<?php

declare(strict_types=1);

namespace App\Command;

use Sonata\UserBundle\Model\UserInterface;
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
use App\Entity\{User, QuestionAnswer};
use \DateTimeImmutable;
use \Exception;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'app:alert-level-2-to-uppers')]
class AlertLevel2ToUppersCommand extends Command
{
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
        $admins = $this->getAdmins();
        $adminsToCC = [];
        foreach ($admins as $admin) {
            $adminsToCC[] = $admin->getEmail();
        }
        foreach ($areas as $area){
            if ($needsDebug) {
                $output->writeln($area->getName().' area in process...');
            }
            $audits = $this->em->getRepository(QuestionAnswer::class)->createQueryBuilder('qa')
                ->andWhere('qa.area = :area')
                ->andWhere('qa.level = :level')
                ->andWhere('qa.createdAt LIKE :date')
                ->setParameter('area', $area)
                ->setParameter('level', UserLevel::LEVEL_2)
                ->setParameter('date', $today->format('Y-m-d').'%')
                ->getQuery()->getResult();
            if (empty($audits)) {
                if ($needsDebug) {
                    $output->writeln($area->getName().' area has not any audti. Now send alert emails');
                }
                $level3Users = $this->em->getRepository(User::class)->findBy(['enabled' => 1, 'level' => UserLevel::LEVEL_3, 'area' => $area]);
                if (empty($level3Users) && ($area->getParent() instanceof Area)) {
                    $level3Users = $this->em->getRepository(User::class)->findBy(['enabled' => 1, 'level' => UserLevel::LEVEL_3, 'area' => $area->getParent()]);
                }
                if (empty($level3Users)) {
                    $level3Users = $admins;
                }
                try {
                    foreach ($level3Users as $level3User){
                        $content = '<h1>Kedves '.$level3User->getName().'</h1>' . PHP_EOL.
                            '<p>Az alábbi LPA audit nem készült el:</p>'. PHP_EOL.
                            '<p>2. szint <br>' . $area->getName() .'</p>' . PHP_EOL.
                            '<p>Dátum: '. $today->format('Y.m.d.'). '</p>'
                        ;
                        if ($needsDebug) {
                            $output->writeln([
                                'Email to '. $level3User->getName(). ' ['. $level3User->getEmail() .']',
                                $content]);
                        }
                        $this->emailSending->sendMail($this->params->get('mailer-sender'), $level3User->getEmail(), 'Értesítés audit hiányosságról', $content, $adminsToCC);
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
    
    protected function getAdmins()
    {
        return $this->em->getRepository(User::class)->createQueryBuilder('u')
            ->andWhere('u.roles LIKE :adminRole')
            ->andWhere('u.enabled = 1')
            ->andWhere('u.email NOT IN (\'gabor.csatlos86@gmail.com\', \'info@csabainformatika.net\')')
            ->setParameter('adminRole', '%'.UserInterface::ROLE_SUPER_ADMIN.'%')
            ->getQuery()->getResult();
    }
}