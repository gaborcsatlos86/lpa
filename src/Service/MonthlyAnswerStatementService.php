<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\{Area, Statement};
use App\Repository\{QuestionAnswerRepositoryInterface, QuestionRepositoryInterface};
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MonthlyAnswerStatementService implements MonthlyAnswerStatementServiceInterface
{
    public function __construct(
        private ExcelExporterServiceInterface $excelExporter,
        private EntityManagerInterface $em,
        private ParameterBagInterface $params,
        private QuestionAnswerRepositoryInterface $questionAnswerRepository,
        private QuestionRepositoryInterface $questionRepository
    ) {}
    
    public function generate(string $month, string $answer, string $name): bool
    {
        $tableData = $this->initEmptyTable();
        $questionAnswers = $this->questionAnswerRepository->findByDateAndAnswer($month, $answer);
        foreach ($questionAnswers as $qa) {
            $tableData[$qa->getQuestion()->getExternalId()][$qa->getArea()->getId()]++;
            $tableData[$qa->getQuestion()->getExternalId()]['total']++;
        }
        $toExcle = [];
        $areas = $this->getAreas();
        $toExcle[0] = [0 => ''];
        $areaKeys = [];
        foreach ($areas as $area) {
            $toExcle[0][] = $area->getName();
            $areaKeys[$area->getId()] = count($toExcle[0])-1;
        }
        $toExcle[0][] = 'Szumma';
        $areaKeys['total'] = count($toExcle[0])-1;
        $row = 1;
        foreach ($tableData as $externalId => $areaData) {
            $toExcle[$row][0] = $externalId;
            foreach ($areaData as $areaId => $value) {
                $toExcle[$row][$areaKeys[$areaId]] = $value;
            }
            
            $row++;
        }
        return $this->createFileAndRecord($toExcle, $name, $answer, $month);
    }
    
    private function initEmptyTable(): array
    {
        $tableData = [];
        $areas = $this->getAreas();
        $questions = $this->questionRepository->findByDistinctExternal();
        foreach ($questions as $question) {
            $tableData[$question['externalId']] = [];
            foreach ($areas as $area) {
                $tableData[$question['externalId']][$area->getId()] = 0;
            }
            $tableData[$question['externalId']]['total'] = 0;
        }
        return $tableData;
    }
    
    private function getAreas(): array
    {
        return $this->em->getRepository(Area::class)->findBy(['hidden' => false, 'deletedAt' => null]);
    }
    
    private function createFileAndRecord(array $excelSource, string $name, string $answer, string $month): bool
    {
        $fileName = str_replace(' ', '-', $name).'-monthly-'. $answer . '-'. $month .'.xlsx';
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