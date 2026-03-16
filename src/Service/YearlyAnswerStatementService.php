<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\{Area, Statement};
use App\Repository\{QuestionAnswerRepositoryInterface, QuestionRepositoryInterface};
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class YearlyAnswerStatementService implements YearlyAnswerStatementServiceInterface
{
    private array $yearMonths = [
        'Január', 'Február', 'Március', 'Április', 'Május', 'Június', 'Július', 'Augusztus', 'Szeptember', 'Október', 'November', 'December'
    ];
    
    public function __construct(
        private ExcelExporterServiceInterface $excelExporter,
        private EntityManagerInterface $em,
        private ParameterBagInterface $params,
        private QuestionAnswerRepositoryInterface $questionAnswerRepository,
        private QuestionRepositoryInterface $questionRepository
    ) {}
    
    public function generate(int $year, string $answer, string $name): bool
    {
        $tableData = $this->initEmptyTable();
        $questionAnswers = $this->questionAnswerRepository->findByDateAndAnswer((string)$year, $answer);
        foreach ($questionAnswers as $qa) {
            $monthKey = ((int)$qa->getCreatedAt()->format('m')) - 1;
            if (!isset($tableData[$qa->getQuestion()->getExternalId()])) {
                $this->setDataTableRow($qa->getQuestion()->getExternalId(), $tableData);
            }
            $tableData[$qa->getQuestion()->getExternalId()][$monthKey]++;
            $tableData[$qa->getQuestion()->getExternalId()]['total']++;
        }
        $toExcle = [];
        $toExcle[0] = [0 => ''];
        $areaKeys = [];
        foreach ($this->yearMonths as $key => $month) {
            $toExcle[0][] = $month;
            $areaKeys[$key] = count($toExcle[0])-1;
        }
        $toExcle[0][] = 'Szumma';
        $areaKeys['total'] = count($toExcle[0])-1;
        $row = 1;
        foreach ($tableData as $externalId => $areaData) {
            $toExcle[$row][0] = $externalId;
            foreach ($areaData as $monthKey => $value) {
                $toExcle[$row][$areaKeys[$monthKey]] = $value;
            }
            $row++;
        }
        return $this->createFileAndRecord($toExcle, $name, $answer, (string)$year);
    }
    
    private function initEmptyTable(): array
    {
        $tableData = [];
        $questions = $this->questionRepository->findByDistinctExternal();
        foreach ($questions as $question) {
            $this->setDataTableRow($question['externalId'], $tableData);
        }
        return $tableData;
    }
    
    private function setDataTableRow(string $externalId, array &$tableData): void
    {
        $tableData[$externalId] = [];
        foreach ($this->yearMonths as $key => $month) {
            $tableData[$externalId][$key] = 0;
        }
        $tableData[$externalId]['total'] = 0;
    }
    
    private function createFileAndRecord(array $excelSource, string $name, string $answer, string $year): bool
    {
        $fileName = str_replace(' ', '-', $name).'-yearly-'. $answer . '-'. $year .'.xlsx';
        if ($this->excelExporter->export($excelSource, $fileName)) {
            $filesFolder = $this->params->get('generated-files-folder');
            $newStatement = (new Statement())
                ->setName($name)
                ->setDate($year)
                ->setPath($filesFolder.$fileName);
            $this->em->persist($newStatement);
            $this->em->flush();
            return true;
        }
        return false;
    }
    
}