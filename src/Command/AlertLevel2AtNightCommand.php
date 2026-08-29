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
#[AsCommand(name: 'app:alert-level-2-at-night')]
class AlertLevel2AtNightCommand extends Command
{
    private array $adminEmails = [
        'istvan.boszormenyi@hirschmann-car.com' => 'István',
        'andrea.matusik@hirschmann-car.com' => 'Andrea',
        //'milan.galos@hirschmann-car.com',
        'laszlo.sellei@hirschmann-car.com' => 'László',
        'peter.kokavecz@hirschmann-car.com' => 'Péter',
        'csaba.janesz@hirschmann-car.com' => 'Csaba',
        'gabor.fejes@hirschmann-car.com' => 'Gábor'
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
        $today = new DateTimeImmutable('today');
        $monday = new DateTimeImmutable('-'.((int)$today->format('N')-1).' day');
        $noAudit = [];
        foreach ($areas as $area){
            $audits = $this->em->getRepository(QuestionAnswer::class)->createQueryBuilder('qa')
                ->andWhere('qa.area = :area')
                ->andWhere('qa.level = :level')
                ->andWhere('qa.createdAt BETWEEN :monday AND :today')
                ->setParameter('area', $area)
                ->setParameter('level', UserLevel::LEVEL_2)
                ->setParameter('monday', $monday->format('Y-m-d'). ' 00:00:00')
                ->setParameter('today', $today->format('Y-m-d') . ' 23:59:59')
                ->getQuery()->getResult();
            if (empty($audits)) {
                $noAudit[] = $area->getName();
            }
        }
        
        if (empty($noAudit)) {
            return Command::SUCCESS;
        }
        
        try {
            foreach ($this->adminEmails as $adminEmail => $name){
                $content = '<h1>Kedves '.$name.'</h1>' . PHP_EOL.
                    '<p>Az alábbi LPA audit nem készült el:</p>'. PHP_EOL.
                    '<p>2. szint <br>' . implode(', ', $noAudit) .'</p>' . PHP_EOL.
                    '<p>Dátum: '. $today->format('Y.m.d.'). '</p>'
                    ;
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