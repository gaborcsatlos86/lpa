<?php

declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\EmailSendingService;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use App\Enums\{Area, UserLevel};
use App\Entity\Area as AreaEntity;
use App\Entity\{ QuestionAnswer};
use \DateTimeImmutable;
use \Exception;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'app:alert-level-1-at-night')]
class AlertLevel1AtNightCommand extends Command
{
    private array $adminEamils = [
        'andrea.matusik@hirschmann-car.com' => 'Andrea',
        //'milan.galos@hirschmann-car.com' => 'Milán',
        'hu-shiftleaders@hirschmann-car.com' => 'Shift Leaders',
        'laszlo.sellei@hirschmann-car.com' => 'László',
        'peter.kokavecz@hirschmann-car.com' => 'Péter',
        'csaba.janesz@hirschmann-car.com' => 'Csaba', 
        'gabor.fejes@hirschmann-car.com' => 'Gábor',
        'istvan.boszormenyi@hirschmann-car.com' => 'István',
        'hu-electronics@hirschmann-car.com' => 'Elektronika',
        'hu-mechanics@hirschmann-car.com' => 'Mechanika'
    ];
    
    public function __construct(
        private EntityManagerInterface $em,
        private EmailSendingService $emailSending,
        private ParameterBagInterface $params
    ) {
        parent::__construct(null);
    }
    
    protected function configure(): void
    {
        $this
            ->addArgument('debug', InputArgument::OPTIONAL, 'The debug mode')
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $needsDebug = ($input->hasArgument('debug') && $input->getArgument('debug') == 'debug');
        $areas = $this->initAreas();
        $today = new DateTimeImmutable('today');
        foreach ($areas as $area){
            if ($needsDebug) {
                $output->writeln($area->getName().' area in process...');
            }
            $audits = $this->em->getRepository(QuestionAnswer::class)->createQueryBuilder('qa')
                ->andWhere('qa.area = :area')
                ->andWhere('qa.level = :level')
                ->andWhere('qa.createdAt LIKE :date')
                ->setParameter('area', $area)
                ->setParameter('level', UserLevel::LEVEL_1)
                ->setParameter('date', $today->format('Y-m-d').'%')
                ->getQuery()->getResult();
            if (empty($audits)) {
                if ($needsDebug) {
                    $output->writeln($area->getName().' area has not any audti. Now send alert emails');
                }
                try {
                    foreach ($this->adminEamils as $email => $name){
                        $content = '<h1>Kedves '.$name.'</h1>' . PHP_EOL.
                            '<p>Az alábbi LPA audit nem készült el:</p>'. PHP_EOL.
                            '<p>1. szint <br>' . $area->getName() .'</p>' . PHP_EOL.
                            '<p>Dátum: '. $today->format('Y.m.d.'). '</p>'
                        ;
                        if ($needsDebug) {
                            $output->writeln([
                                'Email to '. $name. ' ['. $email .']',
                                $content]);
                        }
                        $this->emailSending->sendMail($this->params->get('mailer-sender'), $email, 'Értesítés audit hiányosságról', $content, []);
                    }
                } catch (Exception $e) {
                    if ($needsDebug) {
                        $output->writeln(['Error on sending', $e->getMessage(), 'Process Faild']);
                    }
                    return Command::INVALID;
                }    
            } elseif ($needsDebug) {
                $output->writeln($area->getName().' area has audits');
            }
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