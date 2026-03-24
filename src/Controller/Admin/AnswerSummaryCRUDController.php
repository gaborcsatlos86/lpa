<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\{AnswerSummary, Area};
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\{JsonResponse, Request};
use Doctrine\ORM\EntityManagerInterface;
use App\Service\Admin\CalendarServiceInterface;

class AnswerSummaryCRUDController extends CRUDController
{
    
    public function __construct(
        private CalendarServiceInterface $calendarService
    ) { }
    
    public function dataListAction(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $responseData = [];
        $areas = $entityManager->getRepository(Area::class)->findBy(['hidden' => false, 'deletedAt' => null]);
        $fromDate = new \DateTimeImmutable();
        if ($request->query->has('month')) {
            $fromDate = new \DateTimeImmutable($request->query->get('month').'-01');
        }
        foreach ($areas as $area) {
            $responseData[$area->getId()] = $this->calendarService->calculateCalendarData($area, $fromDate);
        }
        $days = $this->calendarService->getDays($fromDate);
        return $this->json(['view' => $this->renderView('admin/block/calendar_table.html.twig', [
            'tableData' => $responseData,
            'days' => $days
        ])]);
    }
    
}