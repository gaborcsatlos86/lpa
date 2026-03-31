<?php

declare(strict_types=1);

namespace App\Service;

use App\Enums\AnswerTypes;
use App\Entity\{Area, Statement};
use App\Repository\{AnswerSummaryRepositoryInterface};
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MonthlySummLevelOneService implements MonthlySummLevelOneServiceInterface
{
    public function __construct(
        private ExcelExporterServiceInterface $excelExporter,
        private EntityManagerInterface $em,
        private ParameterBagInterface $params,
        private AnswerSummaryRepositoryInterface $answerSummaryRepository,
    ) {}
    
    public function generate(string $month, string $name, int $expectedLpaNum): bool
    {
        $sourceToTable = [];
        $answerSummaries = $this->answerSummaryRepository->getItemsByDate($month);
        foreach ($answerSummaries as $as) {
            if (!isset($sourceToTable[$as->getArea()->getId()])) {
                $sourceToTable[$as->getArea()->getId()] = [
                    AnswerTypes::ANSWER_NOK => 0,
                    AnswerTypes::ANSWER_CORR => 0,
                    AnswerTypes::ANSWER_OK => 0
                ];
            }
            $sourceToTable[$as->getArea()->getId()][$as->getAnswer()]++;
        }
        $areasById = [];
        $areas = $this->getAreas();
        foreach ($areas as $area) {
            $areasById[$area->getId()] = $area->getName();
        }
        $excelSource = [['LPA', '1. szint', $month, 'Elvárt LPA', 'Teljesített LPA', 'Kész LPA aránya']];
        foreach ($sourceToTable as $areaId => $answerData) {
            $excelSource[] = [
                $areasById[$areaId],
                'OK',
                $answerData[AnswerTypes::ANSWER_OK]. ' db',
                '',
                '',
                ''
            ];
            $excelSource[] = [
                $areasById[$areaId],
                'Corr',
                $answerData[AnswerTypes::ANSWER_CORR]. ' db',
                '',
                '',
                ''
            ];
            $excelSource[] = [
                $areasById[$areaId],
                'NOK',
                $answerData[AnswerTypes::ANSWER_NOK]. ' db',
                $expectedLpaNum,
                ($answerData[AnswerTypes::ANSWER_OK] + $answerData[AnswerTypes::ANSWER_NOK] + $answerData[AnswerTypes::ANSWER_CORR]),
                (int)((($answerData[AnswerTypes::ANSWER_OK] + $answerData[AnswerTypes::ANSWER_NOK] + $answerData[AnswerTypes::ANSWER_CORR]) / $expectedLpaNum)*100).'%'
            ];
        }
        return $this->createFileAndRecord($excelSource, $name, $month);
    }
    
    private function getAreas(): array
    {
        return $this->em->getRepository(Area::class)->findBy(['hidden' => false, 'deletedAt' => null]);
    }
    
    private function createFileAndRecord(array $excelSource, string $name, string $month): bool
    {
        $fileName = str_replace(' ', '-', $name).'-monthly-'. $month .'.xlsx';
        if ($this->excelExporter->export($excelSource, $fileName)) {
            $filesFolder = $this->params->get('generated-files-folder');
            $newStatement = (new Statement())
                ->setName($name)
                ->setDate($month)
                ->setPath($filesFolder.$fileName);
            $this->em->persist($newStatement);
            $this->em->flush();
            return true;
        }
        return false;
    }
}