<?php

declare(strict_types=1);

namespace App\Controller\Portal;


use App\Entity\{User, TableGroup, Question, QuestionAnswer, Area, AnswerSummary};
use App\Enums\{UserLevel, AnswerTypes, Area as AreaEnum};
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Response, Request, JsonResponse};
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use \DateTimeImmutable;
use App\Service\EmailSendingService;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class QuestionController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private EmailSendingService $emailSending,
        private ParameterBagInterface $params
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
        if (!$request->getSession()->has('questions')) {
            $request->getSession()->set('questions', []);
        }
        if (!$request->query->has('product')) {
            return $this->redirectToRoute('app_home');
        }
        $product = $request->query->get('product');
        $questionsInSession = $request->getSession()->get('questions');
        
        if ($request->getMethod() == Request::METHOD_POST) {
            $postData = $request->request->all();
            if (isset($postData['answer']) && isset($postData['comment']) ) {
                $answers = $postData['answer'];
                $comments = $postData['comment'];
                $actualAudit = $request->getSession()->get('actual-audit');
                
                foreach ($answers as $key => $answer) {
                    $questionId = (int)str_replace('question', '', $key);
                    if (!in_array($questionId, $questionsInSession)) {
                        $questionsInSession[] = $questionId;
                        $request->getSession()->set('questions', $questionsInSession);
                    }
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
                    $this->entityManager->flush();
                    $this->entityManager->refresh($newAnswer);
                    
                    if(!$this->handlingSummary($newAnswer, $request)) {
                        //
                    }
                }
                
            }
        }
        
        if ($this->hasTodayAnswer($user, $area, $tableGroup, $product) && empty($questionsInSession) && !$request->query->has('force')) {
            return $this->render('portal/question/today_has_answers.html.twig', [
                'last_username' => $user->getName(),
                'user_level' => $user->getLevel(),
                'table_groups' => [],
                'default_area' => $user->getArea(),
                'area' => $area,
                'tableGroup' => $tableGroup,
                'product' => $product,
            ]);
        }
        
        $auditFinaleResult = null;
        $questions = $this->handlingLevel($user, $area, $tableGroup, $product, $questionsInSession);
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
            
            if ($auditFinaleResult == AnswerTypes::ANSWER_NOK) {
                $this->sendingALertEamil($area, $tableGroup, $product, $user, $request->getSession()->get('today-summary'));
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
    
    #[Route('/area-check/{area}', name: 'app_area_check')]
    public function areaCheck(Area $area, Request $request): JsonResponse
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            return $this->json(['status' => false]);
        }
        $userAnswers = $this->entityManager->getRepository(QuestionAnswer::class)->createQueryBuilder('qa')
            ->andWhere('qa.area = :area')
            ->andWhere('qa.createdAt LIKE :today')
            ->andWhere('qa.level = :level')
            ->setParameter('area', $area)
            ->setParameter('today', (new \DateTimeImmutable())->format('Y-m-d').'%')
            ->setParameter('level', $user->getLevel())
            ->getQuery()->getResult();
        
        return $this->json(['status' => !empty($userAnswers)]);
    }
    
    protected function hasTodayAnswer(User $user, Area $area, TableGroup $tableGroup, string $product): bool
    {
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
        
        return !empty($userAnswers);
    }
    
    private function handlingLevel(User $user, Area $area, TableGroup $tableGroup, string $product, array $questionInSession): array
    {
        $questions = $this->entityManager->getRepository(Question::class)->findBy(['area' => $area, 'level' => $user->getLevel(), 'active' => true]);
        if (empty($questionInSession)) {
            return $questions;
        }
        foreach ($questions as $key => $question) {
            if (in_array($question->getId(), $questionInSession)) {
                unset($questions[$key]);
            }
        }
        
        return array_values($questions);
    }
    
    protected function calulateFirstAndLastDayOfWeek(AnswerSummary $answerSummary, DateTimeImmutable $createdAt): AnswerSummary
    {
        $periodStart = $periodEnd = $createdAt;
        $periodStart = $periodStart
            ->setISODate((int)$createdAt->format('Y'), (int)$createdAt->format('W'))
            ->setTime(0, 0, 0)
            ;
        $periodEnd = $periodEnd
            ->setISODate((int)$createdAt->format('Y'), (int)$createdAt->format('W'), 7)
            ->setTime(23, 59, 59)
        ;
        return $answerSummary
            ->setPeriodStart($periodStart)
            ->setPeriodEnd($periodEnd)
        ;
    }
    
    protected function findByAnswer(QuestionAnswer $answer): array|AnswerSummary
    {
        $qb = $this->entityManager->getRepository(AnswerSummary::class)->createQueryBuilder('ansu')
            ->andWhere('ansu.area = :area')
            ->andWhere('ansu.level = :level')
            ->andWhere('ansu.tableGroup = :tableGroup')
            ->andWhere('ansu.product = :product')
            ->setParameter('area', $answer->getArea())
            ->setParameter('level', $answer->getLevel())
            ->setParameter('tableGroup', $answer->getTableGroup())
            ->setParameter('product', $answer->getProduct());
        
        $qb = $qb->andWhere('ansu.periodStart LIKE :date');
        $qb = $qb->setParameter('date', $answer->getCreatedAt()->format('Y-m-d').'%');
        return $qb->getQuery()->getResult();
    }
    
    protected function handlingSummary(QuestionAnswer $questionAnswer, Request $request): bool
    {
        $answerSummaryRes = $this->findByAnswer($questionAnswer);
        if (empty($answerSummaryRes)) {
            $answerSummary = (new AnswerSummary)
                ->setLevel($questionAnswer->getLevel())
                ->setArea($questionAnswer->getArea())
                ->setTableGroup($questionAnswer->getTableGroup())
                ->setProduct($questionAnswer->getProduct())
                ->setAnswer($questionAnswer->getAnswer())
            ;
            if ($questionAnswer->getAnswer() == AnswerTypes::ANSWER_CORR) {
                $answerSummary->increaseCorrNum();
            }
            $answerSummary->setPeriodStart($questionAnswer->getCreatedAt());
            $this->entityManager->persist($answerSummary);
            if ($questionAnswer->getAnswerSummary() == null) {
                $questionAnswer->setAnswerSummary($answerSummary);
                $this->entityManager->persist($questionAnswer);
            }
            $this->entityManager->flush();
            $this->entityManager->refresh($answerSummary);
            $request->getSession()->set('today-summary', $answerSummary->getId());
            return true;
        }
        if (is_array($answerSummaryRes) && count($answerSummaryRes) > 2) {
            return false;
        }
        $answerSummary = $answerSummaryRes[0];
        if ($answerSummary instanceof AnswerSummary) {
            $request->getSession()->set('today-summary', $answerSummary->getId());
            if ($questionAnswer->getAnswer() == AnswerTypes::ANSWER_CORR) {
                $answerSummary->increaseCorrNum();
                switch ($questionAnswer->getLevel()) {
                    case UserLevel::LEVEL_1:
                        if ($answerSummary->getCorrNum() >= 3 ) {
                            $answerSummary->setAnswer(AnswerTypes::ANSWER_NOK);
                        }
                        break;
                        
                    case UserLevel::LEVEL_2:
                        if ($answerSummary->getCorrNum() >= 2 ) {
                            $answerSummary->setAnswer(AnswerTypes::ANSWER_NOK);
                        }
                        break;
                        
                    case UserLevel::LEVEL_3:
                        if ($answerSummary->getCorrNum() >= 1 ) {
                            $answerSummary->setAnswer(AnswerTypes::ANSWER_NOK);
                        }
                        break;
                }
                $this->entityManager->persist($answerSummary);
            }
            if ($questionAnswer->getAnswerSummary() == null) {
                $questionAnswer->setAnswerSummary($answerSummary);
                $this->entityManager->persist($questionAnswer);
            }
            
            if (($answerSummary->getAnswer() != $questionAnswer->getAnswer()) && ($questionAnswer->getAnswer() == AnswerTypes::ANSWER_NOK)) {
                $answerSummary->setAnswer($questionAnswer->getAnswer());
                $this->entityManager->persist($answerSummary);
            }
            $this->entityManager->flush();
        }
        return true;
    }
    
    protected function sendingALertEamil(Area $area, TableGroup $tableGroup, string $product, User $user, int $answerSummaryId) 
    {
        $answerSummary = $this->entityManager->getRepository(AnswerSummary::class)->find($answerSummaryId);
        $answers = $this->entityManager->getRepository(QuestionAnswer::class)->findBy(['answerSummary' => $answerSummary]);
        
        $content = $this->renderView('admin/email/alert.html.twig', [
            'answers' => $answers,
            'area' => $area,
            'tableGroup' => $tableGroup,
            'product' => $product,
            'user' => $user
        ]);
        $mainArea = $area;
        if ($area->getParent() instanceof Area) {
            $mainArea = $area->getParent();
        }
        
        $level3users = $this->entityManager->getRepository(User::class)->findBy(['area' => $mainArea, 'level' => UserLevel::LEVEL_3, 'enabled' => true]);
        
        foreach ($level3users as $l3user){
            $this->emailSending->sendMail($this->params->get('mailer-sender'), $l3user->getEmail(), 'Értesítés audit hibáról', $content);
        }
        
        if ($area->getType() != AreaEnum::AREA_PRODUCTION) {
            $level2Users = $this->entityManager->getRepository(User::class)->findBy(['area' => $mainArea, 'level' => UserLevel::LEVEL_2, 'enabled' => true]);
            foreach ($level2Users as $l2user){
                $this->emailSending->sendMail($this->params->get('mailer-sender'), $l2user->getEmail(), 'Értesítés audit hibáról', $content);
            }
        }
        
    }
    
}