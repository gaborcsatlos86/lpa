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
#[AsCommand(name: 'app:alert-level-3-at-night')]
class AlertLevel3AtNightCommand extends Command
{
    private array $adminEmails = [
        'istvan.boszormenyi@hirschmann-car.com' => 'István',
        'andrea.matusik@hirschmann-car.com' => 'Andrea',
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
        $today = new DateTimeImmutable('today');
        if (!$this->isNowLastWeek($today)) {
            return Command::SUCCESS;
        }
        $areas = $this->initAreas();
        $noAudit = [];
        foreach ($areas as $area){
            $audits = $this->em->getRepository(QuestionAnswer::class)->createQueryBuilder('qa')
                ->andWhere('qa.area = :area')
                ->andWhere('qa.level = :level')
                ->andWhere('qa.createdAt LIKE :today')
                ->setParameter('area', $area)
                ->setParameter('level', UserLevel::LEVEL_3)
                ->setParameter('today', $today->format('Y-m').'%')
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
                    '<p>Az alábbi LPA audit még nem készült el:</p>'. PHP_EOL.
                    '<p>3. szint <br>' . implode(', ', $noAudit) .'</p>' . PHP_EOL.
                    '<p>Dátum: '. $today->format('Y.m.d.'). '</p>'
                    ;
                $this->emailSending->sendMail($this->params->get('mailer-sender'), $adminEmail, 'Értesítés audit hiányosságról', $content);
            }
        } catch (Exception $e) {
            return Command::INVALID;
        }    
        
        return Command::SUCCESS;
    }
    
    protected function isNowLastWeek(DateTimeImmutable $today): bool
    {
        $endOfTheMonth = new \DateTimeImmutable($today->format('Y-m-t'));
        if ((int)$endOfTheMonth->format('N') > 5) {
            $thisMonthLastMonday = new DateTimeImmutable($today->format('Y-m-'). ((int)$endOfTheMonth->format('d')-(int)$endOfTheMonth->format('N')+1));
        } else {
            $thisMonthLastMonday = new DateTimeImmutable($today->format('Y-m-'). ((int)$endOfTheMonth->format('d')-((int)$endOfTheMonth->format('N')+6)));
        }
        return $today >= $thisMonthLastMonday;
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