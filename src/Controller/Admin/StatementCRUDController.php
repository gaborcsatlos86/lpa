<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Enums\AnswerTypes;
use App\Form\{StatementMonthlyType, StatementYearlyType};
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\{Response, Request};
use Doctrine\ORM\EntityManagerInterface;
use App\Service\{MonthlyAnswerStatementServiceInterface, YearlyAnswerStatementServiceInterface};

class StatementCRUDController extends CRUDController
{
    
    public function createMonthlyAction(Request $request, MonthlyAnswerStatementServiceInterface $monthlyAnswerStatementService): Response
    {
        $form = $this->createForm(StatementMonthlyType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $year = (int)$form->get('year')->getData();
            $month = (int)$form->get('month')->getData();
            if ($month < 10) {
                $month = '0'.$month;
            }
            
            if ($monthlyAnswerStatementService->generate($year.'-'.$month, AnswerTypes::ANSWER_NOK, 'LPA_QCPC') &&  $monthlyAnswerStatementService->generate($year.'-'.$month, AnswerTypes::ANSWER_CORR, 'LPA_QCPC')) {
                return $this->redirectToRoute('admin_app_statement_list');
            }
        }
        return $this->render('/admin/statement/monthly.html.twig', ['form' => $form]);
    }
    
    public function createYearlyAction(Request $request, YearlyAnswerStatementServiceInterface $yearlyAnswerStatementService): Response
    {
        $form = $this->createForm(StatementYearlyType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $year = (int)$form->get('year')->getData();
            if ($yearlyAnswerStatementService->generate($year, AnswerTypes::ANSWER_NOK, 'LPA_QCPC_FY') &&  $yearlyAnswerStatementService->generate($year, AnswerTypes::ANSWER_CORR, 'LPA_QCPC_FY')) {
                return $this->redirectToRoute('admin_app_statement_list');
            }
        }
        return $this->render('/admin/statement/yearly.html.twig', ['form' => $form]);
    }
    
}