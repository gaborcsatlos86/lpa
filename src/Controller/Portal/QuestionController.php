<?php

declare(strict_types=1);

namespace App\Controller\Portal;


use App\Entity\{User, Product, TableGroup, Question, QuestionAnswer};
use App\Enums\{Area, UserLevel};
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Response, Request};
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class QuestionController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ){}
    
    #[Route('/form/{area}/{tableGroup}/{product}', name: 'app_question')]
    public function index(string $area, TableGroup $tableGroup, Product $product, Request $request): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return $this->redirectToRoute('app_home');
        }
        
        if ($user->getLevel() == null) {
            return $this->render('portal/question/error.html.twig', ['last_username' => $user->getUsername()]);
        }
        if ($request->getMethod() == Request::METHOD_POST) {
            $postData = $request->request->all();
            if (isset($postData['answer']) && isset($postData['comment']) ) {
                $answers = $postData['answer'];
                $comments = $postData['comment'];
                foreach ($answers as $key => $answer) {
                    $questionId = (int)str_replace('question', '', $key);
                    
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
        
        
        $questions = $this->handlingLevel($user, $area, $tableGroup, $product);
        
        return $this->render('portal/question/index.html.twig', [
            'last_username' => $user->getUsername(),
            'questions' => $questions
        ]); 
    }
    
    private function handlingLevel(User $user, string $area, TableGroup $tableGroup, Product $product): array
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