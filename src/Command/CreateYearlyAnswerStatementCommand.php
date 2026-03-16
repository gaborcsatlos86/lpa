<?php

declare(strict_types=1);

namespace App\Command;

use App\Enums\AnswerTypes;
use App\Service\YearlyAnswerStatementServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

#[AsCommand(name: 'app:create-yearly-answer-statement')]
class CreateYearlyAnswerStatementCommand extends Command
{
    public function __construct(
        private YearlyAnswerStatementServiceInterface $yearlyAnswerStatmentService
    ) {
        parent::__construct(null);
    }
    
    protected function configure(): void
    {
        $this
            ->addArgument('year', InputArgument::OPTIONAL, '2026')
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $year = $input->getArgument('year');
        if ($year == null || empty($year)) {
            $year = (new \DateTimeImmutable())->format('Y');
        }
        if (
            !$this->yearlyAnswerStatmentService->generate((int)$year, AnswerTypes::ANSWER_NOK, 'LPA_QCPC_FY'.$year) ||
            !$this->yearlyAnswerStatmentService->generate((int)$year, AnswerTypes::ANSWER_CORR, 'LPA_QCPC_FY'.$year)
        ) {
            return Command::FAILURE;
        }
        return Command::SUCCESS;
    }
}