<?php

declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\EmailSendingService;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use App\Enums\{Area, UserLevel};
use App\Entity\Area as AreaEntity;
use App\Entity\{QuestionAnswer};
use \DateTimeImmutable;
use \Exception;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'app:alert-level-1')]
class AlertLevel1Command extends Command
{
    private array $adminEmails = [
        'hu-shiftleaders@hirschmann-car.com',
        'andrea.matusik@hirschmann-car.com',
        'milan.galos@hirschmann-car.com',
        'laszlo.sellei@hirschmann-car.com',
        'peter.kokavecz@hirschmann-car.com',
        'csaba.janesz@hirschmann-car.com',
        'gabor.fejes@hirschmann-car.com'
    ];
    
    public function __construct(
        private EntityManagerInterface $em,
        private EmailSendingService $emailSending,
        private ParameterBagInterface $params
    ) {
        parent::__construct(null);
    }
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $areas = $this->initAreas();
        $yesterday = new DateTimeImmutable('yesterday');
        $noAudit = [];
        foreach ($areas as $area){
            $audits = $this->em->getRepository(QuestionAnswer::class)->createQueryBuilder('qa')
                ->andWhere('qa.area = :area')
                ->andWhere('qa.level = :level')
                ->andWhere('qa.createdAt LIKE :date')
                ->setParameter('area', $area)
                ->setParameter('level', UserLevel::LEVEL_1)
                ->setParameter('date', $yesterday->format('Y-m-d').'%')
                ->getQuery()->getResult();
            if (empty($audits)) {
                $noAudit[] = $area->getName();
            }
        }
        
        if (empty($noAudit)) {
            return Command::SUCCESS;
        }
        
        $content = '<h1>Kedves Admin</h1>' . PHP_EOL.
        '<p>Az alábbi LPA audit nem készült el:</p>'. PHP_EOL.
        '<p>1. szint <br>' . implode(', ', $noAudit) .'</p>' . PHP_EOL.
        '<p>Dátum: '. $yesterday->format('Y.m.d.'). '</p>'
        ;
        
        try {
            foreach ($this->adminEmails as $adminEmail){
                $this->emailSending->sendMail($this->params->get('mailer-sender'), $adminEmail, 'Értesítés audit hiányosságról', $content);
            }
        } catch (Exception $e) {
            return Command::INVALID;
        }    
        
        return Command::SUCCESS;
    }
    
    protected function initAreas(): array
    {
        $areas = [];
        
        $prods = $this->em->getRepository(AreaEntity::class)->findBy(['type' => Area::AREA_PRODUCTION]);
        foreach ($prods as $item) {
            if ($item->getParent() instanceof AreaEntity) {
                $areas[] = $item;
            }
        }
        
        $warehouses = $this->em->getRepository(AreaEntity::class)->findBy(['type' => Area::AREA_WAREHOUSE]);
        foreach ($warehouses as $item) {
            $areas[] = $item;
        }
        
        $maintens = $this->em->getRepository(AreaEntity::class)->findBy(['type' => Area::AREA_MAINTENANCE]);
        foreach ($maintens as $item) {
            $areas[] = $item;
        }
        
        return $areas;
    }
}