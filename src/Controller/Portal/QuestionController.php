<?php

declare(strict_types=1);

namespace App\Controller\Portal;


use App\Entity\{User, TableGroup, Question, QuestionAnswer, Area};
use App\Enums\{UserLevel, AnswerTypes};
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Response, Request};
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class QuestionController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ){}
    
    #[Route('/form/{area}/{tableGroup}', name: 'app_question')]
    public function index(Area $area, TableGroup $tableGroup, Request $request): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return $this->redirectToRoute('app_home');
        }
        
        if ($user->getLevel() == null) {
            return $this->render('portal/question/error.html.twig', ['last_username' => $user->getUsername()]);
        }
        if (!$request->getSession()->has('actual-audit')) {
            $request->getSession()->set('actual-audit', []);
        }
        if (!$request->query->has('product')) {
            return $this->redirectToRoute('app_home');
        }
        $product = $request->query->get('product');
        
        if ($request->getMethod() == Request::METHOD_POST) {
            $postData = $request->request->all();
            if (isset($postData['answer']) && isset($postData['comment']) ) {
                $answers = $postData['answer'];
                $comments = $postData['comment'];
                $actualAudit = $request->getSession()->get('actual-audit');
                
                foreach ($answers as $key => $answer) {
                    $questionId = (int)str_replace('question', '', $key);
                    if (!isset($actualAudit[$answer])) {
                        $actualAudit[$answer] = 0;
                    }
                    $actualAudit[$answer]++;
                    $request->getSession()->set('actual-audit', $actualAudit);
                    $newAnswer = (new QuestionAnswer())
                        ->setUser($user)
                        ->setLevel($user->getLevel())
                        ->setArea($area)
                        ->setTableGroup($tableGroup)
                        ->setProduct($product)
                        ->setQuestion($this->entityManager->getRepository(Question::class)->find($questionId))
                        ->setAnswer($answer)
                        ->setAnswerDescription($comments[$key])
                    ;
                    
                    $this->entityManager->persist($newAnswer);
                }
                $this->entityManager->flush();
            }
        }
        
        $auditFinaleResult = null;
        $questions = $this->handlingLevel($user, $area, $tableGroup, $product);
        if (!empty($questions) && isset($questions[0])) {
            $questions = [$questions[0]];
        } else {
            $actualAudit = $request->getSession()->get('actual-audit');
            $auditFinaleResult = AnswerTypes::ANSWER_OK;
            
            switch ($user->getLevel()) {
                case UserLevel::LEVEL_1: 
                    if (isset($actualAudit[AnswerTypes::ANSWER_NOK]) || (isset($actualAudit[AnswerTypes::ANSWER_CORR]) && $actualAudit[AnswerTypes::ANSWER_CORR] >= 3 )) {
                        $auditFinaleResult = AnswerTypes::ANSWER_NOK;
                    }
                    break;
                    
                case UserLevel::LEVEL_2:
                    if (isset($actualAudit[AnswerTypes::ANSWER_NOK]) || (isset($actualAudit[AnswerTypes::ANSWER_CORR]) && $actualAudit[AnswerTypes::ANSWER_CORR] >= 2 )) {
                        $auditFinaleResult = AnswerTypes::ANSWER_NOK;
                    }
                    break;
                    
                case UserLevel::LEVEL_3:
                    if (isset($actualAudit[AnswerTypes::ANSWER_NOK]) || (isset($actualAudit[AnswerTypes::ANSWER_CORR]) && $actualAudit[AnswerTypes::ANSWER_CORR] >= 1 )) {
                        $auditFinaleResult = AnswerTypes::ANSWER_NOK;
                    }
                    break;
            }
            
        }
        
        return $this->render('portal/question/index.html.twig', [
            'last_username' => $user->getName(),
            'user_level' => $user->getLevel(),
            'table_groups' => [],
            'default_area' => $user->getArea(),
            'questions' => $questions,
            'area' => $area,
            'tableGroup' => $tableGroup,
            'product' => $product,
            'auditFinaleResult' => $auditFinaleResult
        ]); 
    }
    
    private function handlingLevel(User $user, Area $area, TableGroup $tableGroup, string $product): array
    {
        $questions = $this->entityManager->getRepository(Question::class)->findBy(['area' => $area, 'level' => $user->getLevel(), 'active' => true]);
        
        $userAnswers = $this->entityManager->getRepository(QuestionAnswer::class)->createQueryBuilder('qa')
            ->andWhere('qa.user = :user')
            ->andWhere('qa.tableGroup = :tableGroup')
            ->andWhere('qa.product = :product')
            ->andWhere('qa.area = :area')
            ->andWhere('qa.createdAt LIKE :today')
            ->setParameter('user', $user)
            ->setParameter('tableGroup', $tableGroup)
            ->setParameter('product', $product)
            ->setParameter('area', $area)
            ->setParameter('today', (new \DateTimeImmutable())->format('Y-m-d').'%')
            ->getQuery()->getResult();
        
        if (empty($userAnswers)) {
            return $questions;
        }
        foreach ($questions as $key => $question) {
            foreach ($userAnswers as $answerQuestion) {
                if ($question->getId() == $answerQuestion->getQuestion()->getId()) {
                    unset($questions[$key]);
                    break;
                }
            }
        }
        
        return array_values($questions);
    }
    
}