<?php

declare(strict_types=1);

namespace App\Service\Admin;

use App\Entity\{Area, AnswerSummary};
use Doctrine\ORM\EntityManagerInterface;
use App\Enums\{AnswerTypes, UserLevel};
use App\Repository\AnswerSummaryRepositoryInterface;

class CalendarService implements CalendarServiceInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private AnswerSummaryRepositoryInterface $answerSummaryRepository
    ) {}
    
    public function calculateCalendarData(Area $area, \DateTimeImmutable $fromDate): array
    {
        $results = [
            'name' => $area->getName(),
            'items' => []
        ];
        $this->setDates($results['items'], $fromDate);
        $items = $this->answerSummaryRepository->getItemsByAreaFromDate($area, $fromDate);
        foreach ($items as $answerSummary) {
            /** @var AnswerSummary $answerSummary */
            if (isset($results['items'][$answerSummary->getPeriodStart()->format('Y-m-d')][$answerSummary->getLevel()])) {
                $results['items'][$answerSummary->getPeriodStart()->format('Y-m-d')][$answerSummary->getLevel()] = [
                    'answer' => $answerSummary->getAnswer(),
                    'id' => $answerSummary->getId(),
                    'color' => $this->getAnswerColor($answerSummary->getAnswer())
                ];
            }
            
        }
        
        return $results;
    }
    
    public function getDays(\DateTimeImmutable $fromDate): array
    {
        $result = [];
        $interval = new \DateInterval('P1D');
        $period = new \DatePeriod($fromDate, $interval, new \DateTimeImmutable(), \DatePeriod::INCLUDE_END_DATE);
        foreach ($period as $date) {
            $result[] = $date->format('Y-m-d');
        }
        return $result;
    }
    
    private function setDates(array &$result, \DateTimeImmutable $fromDate): void
    {
        $interval = new \DateInterval('P1D');
        $period = new \DatePeriod($fromDate, $interval, new \DateTimeImmutable());
        foreach ($period as $date) {
            $result[$date->format('Y-m-d')] = [
                UserLevel::LEVEL_1 => [],
                UserLevel::LEVEL_2 => [],
                UserLevel::LEVEL_3 => [],
            ];
        }
    }
    
    private function getAnswerColor(string $answer): string
    {
        $color = 'red';
        switch ($answer) {
            case AnswerTypes::ANSWER_NOK:
                $color = 'red';
                break;
                
            case AnswerTypes::ANSWER_OK:
                $color = 'green';
                break;
                
            case AnswerTypes::ANSWER_NOT_WORKING_DAY:
                $color = 'orange';
                break;
        }
        
        return $color;
    }
}