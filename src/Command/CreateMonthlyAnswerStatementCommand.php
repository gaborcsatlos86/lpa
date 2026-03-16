<?php

declare(strict_types=1);

namespace App\Command;

use App\Enums\AnswerTypes;
use App\Service\MonthlyAnswerStatementServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

#[AsCommand(name: 'app:create-monthly-answer-statement')]
class CreateMonthlyAnswerStatementCommand extends Command
{
    public function __construct(
        private MonthlyAnswerStatementServiceInterface $monthlyAnswerStatmentService
    ) {
        parent::__construct(null);
    }
    
    protected function configure(): void
    {
        $this
            ->addArgument('month', InputArgument::OPTIONAL, '2026-01')
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $month = $input->getArgument('month');
        if ($month == null || empty($month)) {
            $month = (new \DateTimeImmutable())->format('Y-m');
        }
        if (
            !$this->monthlyAnswerStatmentService->generate($month, AnswerTypes::ANSWER_NOK, 'LPA_QCPC') ||
            !$this->monthlyAnswerStatmentService->generate($month, AnswerTypes::ANSWER_CORR, 'LPA_QCPC')
        ) {
            return Command::FAILURE;
        }
        return Command::SUCCESS;
    }
}