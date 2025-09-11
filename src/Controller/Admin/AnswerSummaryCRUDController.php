<?php

declare(strict_types=1);

namespace App\Controller\Admin;


use App\Enums\AnswerTypes;
use App\Entity\{AnswerSummary, Area};
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\{JsonResponse, Request};
use Doctrine\ORM\EntityManagerInterface;

class AnswerSummaryCRUDController extends CRUDController
{
    public function dataListAction(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $responseData = [];
        if (!$request->query->has('area')) {
            return $this->json($responseData);
        }
        $area = $entityManager->getRepository(Area::class)->find($request->query->get('area'));
        
        $answerSummaries = $entityManager->getRepository(AnswerSummary::class)->findBy(['area' => $area], ['level' => 'ASC','periodStart' => 'DESC']);
        foreach ($answerSummaries as $answerSummary) {
            /** @var AnswerSummary $answerSummary */
            $calendarItem = [
                'title' => $answerSummary->getLevel() . ' - ' . $answerSummary->getProduct(),
                'color' => ($answerSummary->getAnswer() == AnswerTypes::ANSWER_NOK) ? 'red' : 'green',
                'start' => $answerSummary->getPeriodStart()->format('Y-m-d'),
                'url'   => '/admin/app/questionanswer/list?filter[answerSummary][value]='.$answerSummary->getId()
            ];
            
            if ($answerSummary->getPeriodEnd() instanceof \DateTimeImmutable) {
                $calendarItem['end'] = $answerSummary->getPeriodEnd()->format('Y-m-d');
            }
            $responseData[] = $calendarItem;
        }
        
        return $this->json($responseData);
    }
}