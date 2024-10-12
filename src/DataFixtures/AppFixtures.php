<?php

namespace App\DataFixtures;

use App\Entity\{Question, Area, User};
use App\Enums\{UserLevel, AnswerTypes};
use App\Enums\Area as AreaEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $production = (new Area())
            ->setName('Gyártás')
            ->setType(AreaEnum::AREA_PRODUCTION)
            ->setExternalId('')
            ->setActive(true)
        ;
        $manager->persist($production);
        
        $warehouse = (new Area())
            ->setName('Raktár')
            ->setType(AreaEnum::AREA_WAREHOUSE)
            ->setExternalId('3110')
            ->setActive(true)
        ;
        $manager->persist($warehouse);
        
        $maintenance = (new Area())
            ->setName('Karbantartás')
            ->setType(AreaEnum::AREA_MAINTENANCE)
            ->setExternalId('5300')
            ->setActive(true)
        ;
        $manager->persist($maintenance);
        
        $mechanic = (new Area())
            ->setName('Mechanika')
            ->setType(AreaEnum::AREA_MECHANIC)
            ->setExternalId('8000')
            ->setActive(true)
        ;
        $manager->persist($mechanic);
        
        $electronic = (new Area())
            ->setName('Elektronika')
            ->setType(AreaEnum::AREA_ELECTRONIC)
            ->setExternalId('6000')
            ->setActive(true)
        ;
        $manager->persist($electronic);
        
        $manager->flush();
        $manager->refresh($production);
        $manager->refresh($warehouse);
        $manager->refresh($maintenance);
        
        
        $this->productionQuestions($manager, $production);
        $this->maintenanceQuestions($manager, $maintenance);
        $this->warehouseQuestions($manager, $warehouse);
        
        $this->initUsers($manager);
    }
    
    private function initUsers(ObjectManager $manager): void
    {
        
        $area = $manager->getRepository(Area::class)->findOneBy(['name' => 'Mechanika']);
        
        $user1 = new User();
        $user1->setEmail('onakane.durko.edina@lpa-audit.local');
        $user1->setUsername('o.d.e.2960');
        $user1->setName('Onákáné Durkó Edina');
        $user1->setPlainPassword('2960');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('sonkoly.kitti@lpa-audit.local');
        $user1->setUsername('s.k.2068');
        $user1->setName('Sonkoly Kitti');
        $user1->setPlainPassword('2068');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $area = $manager->getRepository(Area::class)->findOneBy(['name' => 'Elektronika']);
        
        $user1 = new User();
        $user1->setEmail('salamon.erzsebet@lpa-audit.local');
        $user1->setUsername('s.e.1759');
        $user1->setName('Salamon Erzsébet');
        $user1->setPlainPassword('1759');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('varga.julianna@lpa-audit.local');
        $user1->setUsername('v.j.1792');
        $user1->setName('Varga Julianna');
        $user1->setPlainPassword('1792');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $area = $manager->getRepository(Area::class)->findOneBy(['name' => 'MKT']);
        
        $user1 = new User();
        $user1->setEmail('bozo.gergo@lpa-audit.local');
        $user1->setUsername('b.g.2631');
        $user1->setName('Bozó Gergő');
        $user1->setPlainPassword('2631');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('balogh.sandor@lpa-audit.local');
        $user1->setUsername('b.s.3187');
        $user1->setName('Balogh Sándor');
        $user1->setPlainPassword('3187');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('czovekne.belog.judit@lpa-audit.local');
        $user1->setUsername('c.b.j.834');
        $user1->setName('Czövekné Balog Judit');
        $user1->setPlainPassword('834');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('gulacsi.eva@lpa-audit.local');
        $user1->setUsername('g.e.2401');
        $user1->setName('Gulácsi Éva');
        $user1->setPlainPassword('2401');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('kulcsar.katalin@lpa-audit.local');
        $user1->setUsername('k.k.268');
        $user1->setName('Kulcsár Katalin');
        $user1->setPlainPassword('268');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('farkas.tibor@lpa-audit.local');
        $user1->setUsername('f.t.3166');
        $user1->setName('Farkas Tibor');
        $user1->setPlainPassword('3166');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('szoke.eszter@lpa-audit.local');
        $user1->setUsername('sz.e.1503');
        $user1->setName('Szőke Eszter');
        $user1->setPlainPassword('1503');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('molnar.nikolett@lpa-audit.local');
        $user1->setUsername('m.n.2446');
        $user1->setName('Molnár Nikolett');
        $user1->setPlainPassword('2446');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('purecse.vivien.fanni@lpa-audit.local');
        $user1->setUsername('p.v.f.3345');
        $user1->setName('Purecse Vivien Fanni');
        $user1->setPlainPassword('3345');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('harangozo.balazs@lpa-audit.local');
        $user1->setUsername('h.b.1003');
        $user1->setName('Harangozó Balázs');
        $user1->setPlainPassword('1003');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('broda.istvan@lpa-audit.local');
        $user1->setUsername('b.i.2785');
        $user1->setName('Bróda István');
        $user1->setPlainPassword('2785');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('szuhanyik.maria@lpa-audit.local');
        $user1->setUsername('sz.m.707');
        $user1->setName('Szuhanyik Mária');
        $user1->setPlainPassword('707');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('hanczarne.kozma.roza@lpa-audit.local');
        $user1->setUsername('h.k.r.2104');
        $user1->setName('Hanczárné Kozma Róza');
        $user1->setPlainPassword('2104');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('kisko.annamaria@lpa-audit.local');
        $user1->setUsername('k.a.875');
        $user1->setName('Kiskó Annamária');
        $user1->setPlainPassword('875');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('hidvegi.attila@lpa-audit.local');
        $user1->setUsername('h.a.813');
        $user1->setName('Hidvégi Attila');
        $user1->setPlainPassword('813');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('bus.klara@lpa-audit.local');
        $user1->setUsername('b.k.650');
        $user1->setName('Bús Klára');
        $user1->setPlainPassword('650');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('dome.ferencne@lpa-audit.local');
        $user1->setUsername('d.f.1454');
        $user1->setName('Döme Ferencné');
        $user1->setPlainPassword('1454');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('varga.ildiko@lpa-audit.local');
        $user1->setUsername('v.i.1402');
        $user1->setName('Varga Ildikó');
        $user1->setPlainPassword('1402');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('gyucha.zsolt@lpa-audit.local');
        $user1->setUsername('gy.zs.1557');
        $user1->setName('Gyucha Zsolt');
        $user1->setPlainPassword('1557');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_2);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('kadar.balazs@lpa-audit.local');
        $user1->setUsername('k.b.3096');
        $user1->setName('Kádár Balázs');
        $user1->setPlainPassword('3096');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_2);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('szentpeterine.nagy.eszter@lpa-audit.local');
        $user1->setUsername('sz.n.e.944');
        $user1->setName('Szentpéteriné Nagy Eszter');
        $user1->setPlainPassword('944');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_2);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('mocz.gyorgy@lpa-audit.local');
        $user1->setUsername('m.gy.3076');
        $user1->setName('Mócz György');
        $user1->setPlainPassword('3076');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_2);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('kokavecz.peter.3359@lpa-audit.local');
        $user1->setUsername('k.p.3359');
        $user1->setName('Kokavecz Péter');
        $user1->setPlainPassword('3359');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_3);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        
        
        $area = $manager->getRepository(Area::class)->findOneBy(['name' => 'Pálca']);
        
        $user1 = new User();
        $user1->setEmail('toma.zsolt@lpa-audit.local');
        $user1->setUsername('t.zs.3044');
        $user1->setName('Toma Zsolt');
        $user1->setPlainPassword('3044');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('kecskemetine.rusznak.andrea@lpa-audit.local');
        $user1->setUsername('k.r.a..1584');
        $user1->setName('Kecskemétiné Rusznák Andrea');
        $user1->setPlainPassword('1584');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('nan-orszaczky.krisztina@lpa-audit.local');
        $user1->setUsername('n.k.1708');
        $user1->setName('Nán-Orszáczky Krisztina');
        $user1->setPlainPassword('1708');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('kelemenne.kocziszky.noemi@lpa-audit.local');
        $user1->setUsername('k.k.n.1989');
        $user1->setName('Kelemenné Kocziszky Noémi');
        $user1->setPlainPassword('1989');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('kellene.marik.eva@lpa-audit.local');
        $user1->setUsername('k.m.e.1985');
        $user1->setName('Kelléné MArik Éva');
        $user1->setPlainPassword('1985');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('andrejkovics.jozsef@lpa-audit.local');
        $user1->setUsername('a.j.2158');
        $user1->setName('Andrejkovics József');
        $user1->setPlainPassword('2158');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('zsibrita.david@lpa-audit.local');
        $user1->setUsername('zs.d.1874');
        $user1->setName('Zsibrita David');
        $user1->setPlainPassword('1874');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('kovacs.akos@lpa-audit.local');
        $user1->setUsername('k.a.1042');
        $user1->setName('Kovács Ákos');
        $user1->setPlainPassword('1042');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('farkas-juhasz.erzsebet@lpa-audit.local');
        $user1->setUsername('f.e.1084');
        $user1->setName('Farkas-Juhász Erzsébet');
        $user1->setPlainPassword('1084');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('hajdu.reka@lpa-audit.local');
        $user1->setUsername('h.r.2963');
        $user1->setName('Hajdu Réka');
        $user1->setPlainPassword('2963');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('gercsi.kitti@lpa-audit.local');
        $user1->setUsername('g.k.1765');
        $user1->setName('Gercsi Kitti');
        $user1->setPlainPassword('1765');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('sipos.judit@lpa-audit.local');
        $user1->setUsername('s.j.2424');
        $user1->setName('Sipos Judit');
        $user1->setPlainPassword('2424');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('alexej.sandor@lpa-audit.local');
        $user1->setUsername('a.s.2407');
        $user1->setName('Alexej Sándor');
        $user1->setPlainPassword('2407');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('sovari.jozsef@lpa-audit.local');
        $user1->setUsername('s.j.1881');
        $user1->setName('Sóvári József');
        $user1->setPlainPassword('1881');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('kokavecz.peter.628@lpa-audit.local');
        $user1->setUsername('k.p.628');
        $user1->setName('Kokavecz Péter');
        $user1->setPlainPassword('628');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_3);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        
        $area = $manager->getRepository(Area::class)->findOneBy(['name' => 'Szonda']);
        
        
        $user1 = new User();
        $user1->setEmail('ujszigeti.imrene@lpa-audit.local');
        $user1->setUsername('u.i.1547');
        $user1->setName('Ujszigeti Imréné');
        $user1->setPlainPassword('1547');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('balogne.gergely.erzsebet@lpa-audit.local');
        $user1->setUsername('b.g.e.2427');
        $user1->setName('Balogné Gergely Erzsébet');
        $user1->setPlainPassword('2427');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $area = $manager->getRepository(Area::class)->findOneBy(['name' => 'Audi LTE']);
        
        $user1 = new User();
        $user1->setEmail('galos.lionel@lpa-audit.local');
        $user1->setUsername('g.l.3331');
        $user1->setName('Gálos Lionel');
        $user1->setPlainPassword('3331');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('kohut.david@lpa-audit.local');
        $user1->setUsername('k.d.3007');
        $user1->setName('Kohut Dávid');
        $user1->setPlainPassword('3007');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('lunkan.nikolett@lpa-audit.local');
        $user1->setUsername('l.n.3147');
        $user1->setName('Lunkán Nikolett');
        $user1->setPlainPassword('3147');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('nagy.norbert@lpa-audit.local');
        $user1->setUsername('n.n.3046');
        $user1->setName('Nagy Norbert');
        $user1->setPlainPassword('3046');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);

        
        
        $user1 = new User();
        $user1->setEmail('szeles.janos@lpa-audit.local');
        $user1->setUsername('sz.j.1998');
        $user1->setName('Szeles János');
        $user1->setPlainPassword('1998');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('mucha.istvan@lpa-audit.local');
        $user1->setUsername('m.i.3335');
        $user1->setName('Mucha István');
        $user1->setPlainPassword('3335');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('zsiga.bence@lpa-audit.local');
        $user1->setUsername('zs.b.3242');
        $user1->setName('Zsiga Bence');
        $user1->setPlainPassword('3242');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('nagyne.sener.maria@lpa-audit.local');
        $user1->setUsername('n.s.m.2330');
        $user1->setName('Nagyné Séner Mária');
        $user1->setPlainPassword('2330');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('boros.istvan@lpa-audit.local');
        $user1->setUsername('b.i.2952');
        $user1->setName('Boros Istvan');
        $user1->setPlainPassword('2952');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('szabo.norbert@lpa-audit.local');
        $user1->setUsername('sz.n.2810');
        $user1->setName('Szabó Norbert');
        $user1->setPlainPassword('2810');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('toth.imre@lpa-audit.local');
        $user1->setUsername('t.i.2482');
        $user1->setName('Tóth Imre');
        $user1->setPlainPassword('2482');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('dienes.jozsef@lpa-audit.local');
        $user1->setUsername('d.j.3353');
        $user1->setName('Dienes József');
        $user1->setPlainPassword('3353');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_2);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('csaki.krisztian@lpa-audit.local');
        $user1->setUsername('cs.k.2381');
        $user1->setName('Csáki Krisztián');
        $user1->setPlainPassword('2381');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_2);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        
        $area = $manager->getRepository(Area::class)->findOneBy(['name' => 'Babaház']);
        
        $user1 = new User();
        $user1->setEmail('nagyne.deak.eszter@lpa-audit.local');
        $user1->setUsername('n.d.e.1848');
        $user1->setName('Nagyné Deák Eszter');
        $user1->setPlainPassword('1848');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('nagy.attila@lpa-audit.local');
        $user1->setUsername('n.a.775');
        $user1->setName('Nagy Attila');
        $user1->setPlainPassword('775');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('krizsánne.babinyecz.beata@lpa-audit.local');
        $user1->setUsername('k.b.b.1007');
        $user1->setName('Krizsánné Babinyecz Beáta');
        $user1->setPlainPassword('1007');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('somodi.gyorgy@lpa-audit.local');
        $user1->setUsername('s.gy.1417');
        $user1->setName('Somodi György');
        $user1->setPlainPassword('1417');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $area = $manager->getRepository(Area::class)->findOneBy(['name' => 'Sperrkreis']);
        
        $user1 = new User();
        $user1->setEmail('kelemen.peter@lpa-audit.local');
        $user1->setUsername('k.p.1720');
        $user1->setName('Kelemen Péter');
        $user1->setPlainPassword('1720');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('hegedus.tamas@lpa-audit.local');
        $user1->setUsername('h.t.2388');
        $user1->setName('Hegedűs Tamás');
        $user1->setPlainPassword('2388');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('santa.mark@lpa-audit.local');
        $user1->setUsername('s.m.3200');
        $user1->setName('Sánta Márk');
        $user1->setPlainPassword('3200');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('darvasine.meszaros.krisztina@lpa-audit.local');
        $user1->setUsername('d.m.k.1396');
        $user1->setName('Darvasiné Mészáros Krisztina');
        $user1->setPlainPassword('1396');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('bozo.edina@lpa-audit.local');
        $user1->setUsername('b.e.2257');
        $user1->setName('Nozó Edina');
        $user1->setPlainPassword('2257');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('ledzenyi.anett@lpa-audit.local');
        $user1->setUsername('l.a.2054');
        $user1->setName('Ledzényi Anett');
        $user1->setPlainPassword('2054');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('brezovszky.roland@lpa-audit.local');
        $user1->setUsername('b.r.2454');
        $user1->setName('Brezovszky Roland');
        $user1->setPlainPassword('2454');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('urbanne.kadar.erika@lpa-audit.local');
        $user1->setUsername('u.k.e.2370');
        $user1->setName('Urbánné Kádár Erika');
        $user1->setPlainPassword('2370');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('szatmari.zoltan@lpa-audit.local');
        $user1->setUsername('sz.z.1770');
        $user1->setName('Szatmári Zoltán');
        $user1->setPlainPassword('1770');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_2);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('kasa.sandor@lpa-audit.local');
        $user1->setUsername('k.s.2522');
        $user1->setName('Kása Sándor');
        $user1->setPlainPassword('2522');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_2);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('szabo.sandor@lpa-audit.local');
        $user1->setUsername('sz.s.3036');
        $user1->setName('Szabó Sándor');
        $user1->setPlainPassword('3036');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_2);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('agoston.gergely@lpa-audit.local');
        $user1->setUsername('a.g.2611');
        $user1->setName('Ágoston Gergely');
        $user1->setPlainPassword('2611');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_2);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('sellei.laszlo@lpa-audit.local');
        $user1->setUsername('s.l.1741');
        $user1->setName('Séllei László');
        $user1->setPlainPassword('1741');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        
        $area = $manager->getRepository(Area::class)->findOneBy(['name' => 'Hullám']);
        
        $user1 = new User();
        $user1->setEmail('farkas.david@lpa-audit.local');
        $user1->setUsername('f.d.2885');
        $user1->setName('Farkas Dávid');
        $user1->setPlainPassword('2885');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('medovarszki.tibor@lpa-audit.local');
        $user1->setUsername('m.t.1829');
        $user1->setName('Medovarszki Tibor');
        $user1->setPlainPassword('1829');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('cser.imre@lpa-audit.local');
        $user1->setUsername('cs.i.2647');
        $user1->setName('Cser Imre');
        $user1->setPlainPassword('2647');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('sodar.zoltan@lpa-audit.local');
        $user1->setUsername('s.z.2752');
        $user1->setName('Sódar Zoltán');
        $user1->setPlainPassword('2752');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('kocsis.mark@lpa-audit.local');
        $user1->setUsername('k.m.3079');
        $user1->setName('Kocsis Márk');
        $user1->setPlainPassword('3079');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('misota.szabolcs@lpa-audit.local');
        $user1->setUsername('m.sz.2573');
        $user1->setName('Misota Szabolcs');
        $user1->setPlainPassword('2573');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('jenei.ilona@lpa-audit.local');
        $user1->setUsername('j.i.648');
        $user1->setName('Jenei Ilona');
        $user1->setPlainPassword('648');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('asos.jozsef@lpa-audit.local');
        $user1->setUsername('a.j.2502');
        $user1->setName('Ásós József');
        $user1->setPlainPassword('2502');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('nagyvaradi.attila@lpa-audit.local');
        $user1->setUsername('n.a.2582');
        $user1->setName('Nagyváradi Attila');
        $user1->setPlainPassword('2582');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('gschwindt.mihaly@lpa-audit.local');
        $user1->setUsername('g.m.2399');
        $user1->setName('Gschwindt Mihály');
        $user1->setPlainPassword('2399');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('borbelyne.zsoter.eva@lpa-audit.local');
        $user1->setUsername('b.zs.e.2065');
        $user1->setName('Borbélyné Zsótér Éva');
        $user1->setPlainPassword('2056');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('szilagyi.beata.mariann@lpa-audit.local');
        $user1->setUsername('sz.b.m.1956');
        $user1->setName('Szilágyi Beáta Mariann');
        $user1->setPlainPassword('');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('laurinyecz.david@lpa-audit.local');
        $user1->setUsername('l.d.3190');
        $user1->setName('Laurinyecz Dávid');
        $user1->setPlainPassword('3190');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('piros.csaba@lpa-audit.local');
        $user1->setUsername('p.cs.2770');
        $user1->setName('Piros Csaba');
        $user1->setPlainPassword('2770');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('kis.monika@lpa-audit.local');
        $user1->setUsername('k.m.1605');
        $user1->setName('Kis Mónika');
        $user1->setPlainPassword('1605');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('szentesine.forras.katalin@lpa-audit.local');
        $user1->setUsername('sz.f.k.1608');
        $user1->setName('Szentesiné Forrás Katalin');
        $user1->setPlainPassword('1608');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        
        $area = $manager->getRepository(Area::class)->findOneBy(['name' => 'EPA/ABM']);
        
        $user1 = new User();
        $user1->setEmail('imre.mate@lpa-audit.local');
        $user1->setUsername('i.m.2684');
        $user1->setName('Imre Máté');
        $user1->setPlainPassword('2684');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('balogh.david@lpa-audit.local');
        $user1->setUsername('b.d.3111');
        $user1->setName('Balogh Dávid');
        $user1->setPlainPassword('3111');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('paller.krisztina@lpa-audit.local');
        $user1->setUsername('p.k.1610');
        $user1->setName('Pallér Krisztina');
        $user1->setPlainPassword('1610');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('litauszki.mihaly@lpa-audit.local');
        $user1->setUsername('l.m.2122');
        $user1->setName('Litauszki Mihály');
        $user1->setPlainPassword('2122');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('taub.csaba@lpa-audit.local');
        $user1->setUsername('t.cs.2193');
        $user1->setName('Taub Csaba');
        $user1->setPlainPassword('2193');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('kantor.tunde@lpa-audit.local');
        $user1->setUsername('k.t.1886');
        $user1->setName('Kántor Tünde');
        $user1->setPlainPassword('1886');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('toth.erika@lpa-audit.local');
        $user1->setUsername('t.e.1933');
        $user1->setName('Tóth Erika');
        $user1->setPlainPassword('1933');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('torok.zsolt@lpa-audit.local');
        $user1->setUsername('t.zs.1878');
        $user1->setName('Török Zsolt');
        $user1->setPlainPassword('1878');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('kovacs.zoltan@lpa-audit.local');
        $user1->setUsername('k.z.2017');
        $user1->setName('Kovács Zoltán');
        $user1->setPlainPassword('2017');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('szabo.hajnalka@lpa-audit.local');
        $user1->setUsername('sz.h.332');
        $user1->setName('Szabó Hajnalka');
        $user1->setPlainPassword('332');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('vitalis.istvanne@lpa-audit.local');
        $user1->setUsername('v.i.1790');
        $user1->setName('Vitális Istvánné');
        $user1->setPlainPassword('1790');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('zdolik.viktor@lpa-audit.local');
        $user1->setUsername('z.v.3110');
        $user1->setName('Zdolik Viktor');
        $user1->setPlainPassword('3110');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('lovas.mate@lpa-audit.local');
        $user1->setUsername('l.m.2523');
        $user1->setName('Lovas Máté');
        $user1->setPlainPassword('2523');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('csernus.mihalyne@lpa-audit.local');
        $user1->setUsername('cs.m.2018');
        $user1->setName('Csernus Mihályné');
        $user1->setPlainPassword('2018');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('havran.zsuzsanna@lpa-audit.local');
        $user1->setUsername('h.zs.2329');
        $user1->setName('Havrán Zsuzsanna');
        $user1->setPlainPassword('2329');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('onaka.attila@lpa-audit.local');
        $user1->setUsername('o.a.1407');
        $user1->setName('Onáka Attila');
        $user1->setPlainPassword('1407');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_2);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('toth.ferenc@lpa-audit.local');
        $user1->setUsername('t.f.612');
        $user1->setName('Tóth Ferenc');
        $user1->setPlainPassword('612');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_2);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('kesjar.andras@lpa-audit.local');
        $user1->setUsername('k.a.1775');
        $user1->setName('Kesjár András');
        $user1->setPlainPassword('1775');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_2);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('fabian.mihaly@lpa-audit.local');
        $user1->setUsername('f.m.1626');
        $user1->setName('Fábián Mihály');
        $user1->setPlainPassword('1626');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_2);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('boszormenyi.istvan@lpa-audit.local');
        $user1->setUsername('b.i.3359');
        $user1->setName('Böszörményi István');
        $user1->setPlainPassword('3359');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_3);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $area = $manager->getRepository(Area::class)->findOneBy(['name' => 'GIGA']);
        
        $user1 = new User();
        $user1->setEmail('hejjas.laszlo@lpa-audit.local');
        $user1->setUsername('h.l.747');
        $user1->setName('Héjjas László');
        $user1->setPlainPassword('747');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('bereczki.agnes@lpa-audit.local');
        $user1->setUsername('b.a.635');
        $user1->setName('Bereczki Ágnes');
        $user1->setPlainPassword('635');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('kelemen.miklos@lpa-audit.local');
        $user1->setUsername('k.m.304');
        $user1->setName('Kelemen Miklós');
        $user1->setPlainPassword('304');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('nemeth.beatrix@lpa-audit.local');
        $user1->setUsername('n.b.623');
        $user1->setName('Németh Beatrix');
        $user1->setPlainPassword('623');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('szalacsi.zoltanne@lpa-audit.local');
        $user1->setUsername('sz.z.931');
        $user1->setName('Szalacsi Zoltánné');
        $user1->setPlainPassword('931');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('bajczer.balazs@lpa-audit.local');
        $user1->setUsername('b.b.3101');
        $user1->setName('Bajczer Balazs');
        $user1->setPlainPassword('3101');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('zahoranne.bus.szilvia@lpa-audit.local');
        $user1->setUsername('z.b.sz.1614');
        $user1->setName('Zahoránné Bús Szilvia');
        $user1->setPlainPassword('1614');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('bauko.palne@lpa-audit.local');
        $user1->setUsername('b.p.1598');
        $user1->setName('Baukó Pálné');
        $user1->setPlainPassword('1598');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('egeresi.mihaly@lpa-audit.local');
        $user1->setUsername('e.m.2022');
        $user1->setName('Egeresi Mihály');
        $user1->setPlainPassword('2022');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('felekne.vozar.ilona@lpa-audit.local');
        $user1->setUsername('f.v.i.1017');
        $user1->setName('Felekné Vozár Ilona');
        $user1->setPlainPassword('1017');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('daranyi.istvanne@lpa-audit.local');
        $user1->setUsername('d.i.1415');
        $user1->setName('Darányi Istvánné');
        $user1->setPlainPassword('1415');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $area = $manager->getRepository(Area::class)->findOneBy(['name' => 'Raktár']);
        
        $user1 = new User();
        $user1->setEmail('abonyi.attila@lpa-audit.local');
        $user1->setUsername('a.a.1971');
        $user1->setName('Abonyi Attila');
        $user1->setPlainPassword('1971');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('ralik.robert@lpa-audit.local');
        $user1->setUsername('r.r.1470');
        $user1->setName('Rálik Róbert');
        $user1->setPlainPassword('1470');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('sovari.ferenc@lpa-audit.local');
        $user1->setUsername('s.f.1421');
        $user1->setName('Sóvári Ferenc');
        $user1->setPlainPassword('1421');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('bus.szabolcs@lpa-audit.local');
        $user1->setUsername('b.sz.657');
        $user1->setName('Bús Szabolcs');
        $user1->setPlainPassword('657');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('murzsicz.tunde@lpa-audit.local');
        $user1->setUsername('m.t.1055');
        $user1->setName('Murzsicz Tünde');
        $user1->setPlainPassword('1055');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_2);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('fejes.gabor@lpa-audit.local');
        $user1->setUsername('f.g.2092');
        $user1->setName('Fejes Gábor');
        $user1->setPlainPassword('2092');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_2);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('jarabin.monika@lpa-audit.local');
        $user1->setUsername('j.m.2973');
        $user1->setName('Jarabin Mónika');
        $user1->setPlainPassword('2973');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_3);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        
        $area = $manager->getRepository(Area::class)->findOneBy(['name' => 'Karbantartás']);
        
        $user1 = new User();
        $user1->setEmail('pilinszky.attila@lpa-audit.local');
        $user1->setUsername('p.a.3197');
        $user1->setName('Pilinszky Attila');
        $user1->setPlainPassword('3197');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('laurinyecz.zoltan@lpa-audit.local');
        $user1->setUsername('l.z.1062');
        $user1->setName('Laurinyecz Zoltán');
        $user1->setPlainPassword('1062');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('fabian.attila@lpa-audit.local');
        $user1->setUsername('f.a.29');
        $user1->setName('Fábián Attila');
        $user1->setPlainPassword('29');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('laurinyecz.laszlo@lpa-audit.local');
        $user1->setUsername('l.l.1248');
        $user1->setName('Laurinyecz László');
        $user1->setPlainPassword('1248');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_1);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        
        $user1 = new User();
        $user1->setEmail('varga.laszlo@lpa-audit.local');
        $user1->setUsername('v.l.3091');
        $user1->setName('Varga László');
        $user1->setPlainPassword('3091');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_2);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $user1 = new User();
        $user1->setEmail('janesz.csaba@lpa-audit.local');
        $user1->setUsername('j.cs.3088');
        $user1->setName('Janesz Csaba');
        $user1->setPlainPassword('3088');
        $user1->setEnabled(true);
        $user1->setLevel(UserLevel::LEVEL_3);
        $user1->setArea($area);
        
        $manager->persist($user1);
        
        $manager->flush();
    }
    
    private function warehouseQuestions(ObjectManager $manager, Area $area): void
    {
        $question1 = (new Question)
            ->setText('Mondd el mi volt az utolsó kieső idővel járó baleset a gyárban?')
            ->setComment('2024.07.03. Bokaszalag szakadás<br>
Részletek: Az operátor a szünetéről tért vissza a dohányzóból, szegélykőre lépett innen bal lába befordult, bokája megsérült, elszakadt a bokaszalagja.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('E1')
            ->setActive(true)
            ->setAvailableAnswers([AnswerTypes::ANSWER_OK => AnswerTypes::ANSWER_OK, AnswerTypes::ANSWER_CORR => AnswerTypes::ANSWER_CORR])
        ;
        $manager->persist($question1);
        
        $question2 = (new Question)
            ->setText('A munkaterület biztonságos és tiszta. A munkaterület jó 5S-t mutat? Az eszközök megfelelő helyen vannak, nincsenek személyes tárgyak a területen.')
            ->setComment('A munkaterület tiszta és biztonságos, mindennek megvan a helye és nincsenek felesleges dolgok, személyes tárgyak, étel / ital a munkaállomáson.
Amennyiben nem, azonnal lépjen kapcsolatba a műszakvezetővel.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('S1')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question2);
        
        $question3 = (new Question)
            ->setText('Tároló dobozok és állványok állapota megfelelő? Minden a megfelelő/előírt helyen van tárolva?')
            ->setComment('Ellenőrizze a tároló dobozok és állványok sérülésmentességét, használhatóságát, jelölését, szekrények layoutot ellenőrizni. Minden a kijelölt tárolóban/helyen.
Amennyiben nem-megfelelő, azonnal értesítse a műszakvezetőt')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('S2')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question3);
        
        $question4 = (new Question)
            ->setText('Ha van folyamatfejlesztési ötleted, azt hol kell leadnod, mi ennek a neve?')
            ->setComment('Fő folyosón lévő számítógép, eFTP, vagyis elektronikus Folyamatos Tökéletesítési Program')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('I1')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question4);
        
        $question5 = (new Question)
            ->setText('A raktárban a termékek, anyagok megfelelően azonosítottak?')
            ->setComment('Ellenőrizze a ládák/dobozokon lévő azonosítók megfelelősségét
Amennyiben nem-megfelelő, azonnal értesítse a műszakvezetőt. Ládákat/Dobozokat elkülöníteni.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('R1')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question5);
        
        $question6 = (new Question)
            ->setText('A nem-megfelelő beeérkező áruk megfelelően felcímkézve elkülönítve vannak tárolva?')
            ->setComment('Amennyiben nem, azonnal értesítse a műszakvezetőt. 
Darabokat elkülöníteni / Földön talált alkatrész esetén selejtezni. Nézzen körül a munkaterületen azonosítatlan / nem-megfelelő helyen lévő alkatrészeket (amennyiben talál, azonos reakció).')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('R2')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question6);
        
        $question7 = (new Question)
            ->setText('A raktári kolléga a munkautasítás szerint dolgozik?')
            ->setComment('Ellenőrizze, hogy a kolléga az érvényes munkautasítások alapján dolgozik. 
Amennyiben nem, azonnal értesítse a műszakvezetőt')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('R3')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question7);
        
        $question8 = (new Question)
            ->setText('A nyákokat megfelelően kezelik tárolják (alapanyag raktár esetében)?')
            ->setComment('Vizsgáld meg az alapanyag raktárban a NYÁKos ládák tárolását, hogy nincs a ládán kívül tárolva nyomtatott áramkör. Eltérés esetén jelezd a műszakvezetőnek.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('C1')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question8);
        
        $question9 = (new Question)
            ->setText('A termék az ellenőrző készülékbe /EOL tesztberendezés helyezve megfelelőséget mutat?')
            ->setComment('Érvényesítse egy darab méreteit a gyártási az EOL teszt alapján. Amennyiben nem-megfelelő, azonnal értesítse a műszakvezetőt. Darabokat elkülöníteni.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('C2')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question9);
        
        $question10 = (new Question)
            ->setText('Az előírt csomagolást használjuk-e és megfelelő a címkézést? A címkézés megfelelősége kiemelt ellenőrzési pont! (Készáru zóna, vagy kiszállítás előkészítés)')
            ->setComment('Ellenőrizze, hogy az előírt csomagolást használjuk, és megfelelően címkézzük a terméket! 
Amennyiben nem, azonnal értesítse a műszakvezetőt. Ládákat elkülöníteni.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('C3')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question10);
        
        $question11 = (new Question)
            ->setText('A Minőségügyi Riasztás/Qalert aktuális , és azokat ismerik?')
            ->setComment('Ellenőrizze, hogy a Minőségügyi Riasztás elérhető és a dolgozó tud az eltérésről, intézkedésről. 
Amennyiben nem, operátort kioktatni.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('Q1')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question11);
        
        $question12 = (new Question)
            ->setText('A mérőeszközök kalibráltak? Ellenőrizze az eszközöket!')
            ->setComment('Ellenőrizze a címkéket, hogy érvényesítse, hogy azok az újraminősítési időtartamon belül vannak. Ellenőrizze az összes eszközt. Lejárat esetén azonnal értesítse a QA osztályt/line inspectort!')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('Q2')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question12);
        
        $question13 = (new Question)
            ->setText('Elérhető autonóm karbantartási utasítás a megadott géphez?')
            ->setComment('Ellenőrizze, hogy az autonóm karbantartási utasítás (TPM) elérhető-e a kijelölt helyén?
Amennyiben nem, azonnal lépjen kapcsolatba a műszakvezetővel.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('T1')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question13);
        
        $question14 = (new Question)
            ->setText('A kijelölt felelős elvégezte az autonóm karbantartási utasítás szerint az feladatokat?')
            ->setComment('Ellenőrizze, hogy az autonóm karbantartási utasítás (TPM) alapján elvégezték-e a napi/heti karbantartásokat.
Amennyiben nem, azonnal lépjen kapcsolatba a műszakvezetővel.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('T2')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question14);
        
        $question15 = (new Question)
            ->setText('Az 1. szintű audit rendszeresen és megfelelően van végrehajtva?')
            ->setComment('Ha van a táblán üres hely, akkor nincs megfelelően töltve.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_2)
            ->setExternalId('A1')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question15);
        
        $question16 = (new Question)
            ->setText('Az információkat a műszakok egymás között hiánytalanul átadják?')
            ->setComment('Meg kell kérni a műszakvezetőt, hogy mutassa meg a műszakátadó naplót.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_2)
            ->setExternalId('I2')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question16);
        
        $question17 = (new Question)
            ->setText('Kérdezd a raktáros kollégát: Milyen hibák szoktak előfordulni az adott műveletnél, amit végez?')
            ->setComment('Területtől függően eltérő lehet.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_2)
            ->setExternalId('Q3')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question17);
        
        $question18 = (new Question)
            ->setText('A kérdezett operátor dolgozhat az állomáson a képességmátrix szerint? Ellenőrizd a mátrixot is!')
            ->setComment('A Qualimátrix a területen található, ezen lehet megnézni, hogy a dolgozó milyen szinten áll az adott folyamat elvégzésével.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_2)
            ->setExternalId('W1')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question18);
        
        $question19 = (new Question)
            ->setText('Az 1. és 2. szintű audit rendszeresen és megfelelően van végrehajtva?')
            ->setComment('Ha nincs a táblán kitöltve megfelelő dátummal a 2. szint, akkor nem megfelelő. ')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_3)
            ->setExternalId('A2')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question19);
        
        $question20 = (new Question)
            ->setText('Kérdezd az operátort: Tudod, hogy melyek a legfontosabb gyári célok? (TRIR, OTD, Productivity, PPM)')
            ->setComment('OTD – On time delivery – Időben való szállítás; Inventory turns - Készletforgás értéke; TRIR – Total Recordable Incident Rate – Jelentésköteles balesetek száma; PPM - Parts Per Million –  Minőségirányítási mutatószám, hibaarány. A hibarátát, amely azt fejezi ki, hogy egymillió legyártott termék (alkatrész) esetében hányszor fordul elő az adott hiba.; Productivity - Hatékonyság')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_3)
            ->setExternalId('I2')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question20);
        
        $manager->flush();
    }
    
    private function maintenanceQuestions(ObjectManager $manager, Area $area): void
    {
        $question1 = (new Question)
            ->setText('Mondd el mi volt az utolsó kieső idővel járó baleset a gyárban?')
            ->setComment('2024.07.03. Bokaszalag szakadás
Részletek: Az operátor a szünetéről tért vissza a dohányzóból, szegélykőre lépett innen bal lába befordult, bokája megsérült, elszakadt a bokaszalagja.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('E1')
            ->setActive(true)
            ->setAvailableAnswers([AnswerTypes::ANSWER_OK => AnswerTypes::ANSWER_OK, AnswerTypes::ANSWER_CORR => AnswerTypes::ANSWER_CORR])
        ;
        $manager->persist($question1);
        
        $question2 = (new Question)
            ->setText('A munkaterület biztonságos és tiszta. A munkaterület jó 5S-t mutat? Az eszközök megfelelő helyen vannak, nincsenek személyes tárgyak a területen.')
            ->setComment('A munkaterület tiszta és biztonságos, mindennek megvan a helye és nincsenek felesleges dolgok, személyes tárgyak, étel / ital a munkaállomáson.
Amennyiben nem, azonnal lépjen kapcsolatba a műszakvezetővel.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('S1')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question2);
        
        $question3 = (new Question)
            ->setText('Tárolószekrények állapota megfelelő? Minden a megfelelő/előírt helyen van tárolva?')
            ->setComment('Ellenőrizze a tárolószekrények sérülésmentességét, használhatóságát, jelölését, szekrények layoutot ellenőrizni. Minden a kijelölt tárolóban/helyen.
Amennyiben nem-megfelelő, azonnal értesítse a műszakvezetőt')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('S2')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question3);
        
        $question4 = (new Question)
            ->setText('Ha van folyamatfejlesztési ötleted, azt hol kell leadnod, mi ennek a neve?')
            ->setComment('Fő folyosón lévő számítógép, eFTP, vagyis elektronikus Folyamatos Tökéletesítési Program')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('I1')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question4);
        
        $question5 = (new Question)
            ->setText('A mérőeszközök kalibráltak? Ellenőrizze az eszközöket!')
            ->setComment('Ellenőrizze a címkéket, hogy érvényesítse, hogy azok az újraminősítési időtartamon belül vannak. Ellenőrizze az összes eszközt. Lejárat esetén azonnal értesítse a QA osztályt/line inspectort!')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('Q1')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question5);
        
        $question6 = (new Question)
            ->setText('Elérhető autonóm karbantartási utasítás a megadott géphez?')
            ->setComment('Ellenőrizze, hogy az autonóm karbantartási utasítás (TPM) elérhető-e a kijelölt helyén?
Amennyiben nem, azonnal lépjen kapcsolatba a műszakvezetővel.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('T1')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question6);
        
        $question7 = (new Question)
            ->setText('A kijelölt felelős elvégezte az autonóm karbantartási utasítás szerint az feladatokat?')
            ->setComment('Ellenőrizze, hogy az autonóm karbantartási utasítás (TPM) alapján elvégezték-e a napi/heti karbantartásokat.
Amennyiben nem, azonnal lépjen kapcsolatba a műszakvezetővel.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('T2')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question7);
        
        $question8 = (new Question)
            ->setText('Az 1. szintű audit rendszeresen és megfelelően van végrehajtva?')
            ->setComment('Ha van a táblán üres hely, akkor nincs megfelelően töltve.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_2)
            ->setExternalId('A1')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question8);
        
        $question9 = (new Question)
            ->setText('Kérdezd a karbantartó kollégát: Honnan kapja meg a napi munkáját és hova kell feljegyezni annak elvégzését? Mikor ér véget a folyamat?')
            ->setComment('Karbantartási programba kell feljegyezni a munka elvégzését, innen kapja meg a napi munkáját. Véget akkor ér a folyamat, amikor a programban lezárják a hibajegyet és a javítás után értesítették a terület Műszakvezetőjét és/vagy Gépbeállítóját.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_2)
            ->setExternalId('Q5')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question9);
        
        $question10 = (new Question)
            ->setText('Az 1. és 2. szintű audit rendszeresen és megfelelően van végrehajtva?')
            ->setComment('Ha nincs a táblán kitöltve megfelelő dátummal a 2. szint, akkor nem megfelelő. ')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_3)
            ->setExternalId('A2')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question10);
        
        $question11 = (new Question)
            ->setText('Kérdezd az operátort: Tudod, hogy melyek a legfontosabb gyári célok? (TRIR, OTD, Productivity, PPM)')
            ->setComment('OTD – On time delivery – Időben való szállítás; Inventory turns - Készletforgás értéke; TRIR – Total Recordable Incident Rate – Jelentésköteles balesetek száma; PPM - Parts Per Million –  Minőségirányítási mutatószám, hibaarány. A hibarátát, amely azt fejezi ki, hogy egymillió legyártott termék (alkatrész) esetében hányszor fordul elő az adott hiba.; Productivity - Hatékonyság')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_3)
            ->setExternalId('I3')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question11);
        
        $manager->flush();
    }
    
    private function productionQuestions(ObjectManager $manager, Area $parentArea): void
    {
        $area1 = (new Area())
            ->setName('Hullám')
            ->setType(AreaEnum::AREA_PRODUCTION)
            ->setExternalId('6200')
            ->setActive(true)
            ->setParent($parentArea)
        ;
        $manager->persist($area1);
        
        $area2 = (new Area())
            ->setName('Sperrkreis')
            ->setType(AreaEnum::AREA_PRODUCTION)
            ->setExternalId('6600')
            ->setActive(true)
            ->setParent($parentArea)
        ;
        $manager->persist($area2);
        
        $area3 = (new Area())
            ->setName('EPA/ABM')
            ->setType(AreaEnum::AREA_PRODUCTION)
            ->setExternalId('7400')
            ->setActive(true)
            ->setParent($parentArea)
        ;
        $manager->persist($area3);
        
        $area4 = (new Area())
            ->setName('GIGA')
            ->setType(AreaEnum::AREA_PRODUCTION)
            ->setExternalId('7300')
            ->setActive(true)
            ->setParent($parentArea)
        ;
        $manager->persist($area4);
        
        $area5 = (new Area())
            ->setName('Babaház')
            ->setType(AreaEnum::AREA_PRODUCTION)
            ->setExternalId('7100')
            ->setActive(true)
            ->setParent($parentArea)
        ;
        $manager->persist($area5);
        
        $area6 = (new Area())
            ->setName('Audi LTE')
            ->setType(AreaEnum::AREA_PRODUCTION)
            ->setExternalId('6300')
            ->setActive(true)
            ->setParent($parentArea)
        ;
        $manager->persist($area6);
        
        $area7 = (new Area())
            ->setName('Pálca')
            ->setType(AreaEnum::AREA_PRODUCTION)
            ->setExternalId('6900')
            ->setActive(true)
            ->setParent($parentArea)
        ;
        $manager->persist($area7);
        
        $area8 = (new Area())
            ->setName('MKT')
            ->setType(AreaEnum::AREA_PRODUCTION)
            ->setExternalId('6800')
            ->setActive(true)
            ->setParent($parentArea)
        ;
        $manager->persist($area8);

        $area9 = (new Area())
            ->setName('Szonda')
            ->setType(AreaEnum::AREA_PRODUCTION)
            ->setExternalId('6800')
            ->setActive(true)
            ->setParent($parentArea)
        ;
        $manager->persist($area9);
        
        $manager->flush();
        
        $manager->refresh($area1);
        $manager->refresh($area2);
        $manager->refresh($area3);
        $manager->refresh($area4);
        $manager->refresh($area5);
        $manager->refresh($area6);
        $manager->refresh($area7);
        $manager->refresh($area8);
        $manager->refresh($area9);
        
        $this->production1Questions($manager, $area1);
        $this->production1Questions($manager, $area2);
        $this->production1Questions($manager, $area3);
        $this->production1Questions($manager, $area4);
        $this->production1Questions($manager, $area5);
        $this->production1Questions($manager, $area6);
        $this->production1Questions($manager, $area7);
        $this->production1Questions($manager, $area8);
        $this->production2Questions($manager, $area9);
    }
    
    private function production1Questions(ObjectManager $manager, Area $area): void
    {
        $question1 = (new Question)
            ->setText('Mondd el mi volt az utolsó kieső idővel járó baleset a gyárban?')
            ->setComment('2024.07.03. Bokaszalag szakadás <br/>Részletek: Az operátor a szünetéről tért vissza a dohányzóból, szegélykőre lépett innen bal lába befordult, bokája megsérült, elszakadt a bokaszalagja.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('E1')
            ->setActive(true)
            ->setAvailableAnswers([AnswerTypes::ANSWER_OK => AnswerTypes::ANSWER_OK, AnswerTypes::ANSWER_CORR => AnswerTypes::ANSWER_CORR])
        ;
        $manager->persist($question1);
        
        $question2 = (new Question)
            ->setText('A munkaterület biztonságos és tiszta. A munkaterület jó 5S-t mutat? Az eszközök megfelelő helyen vannak, nincsenek személyes tárgyak a területen. A kanban polcok megfelelően jelöltek?')
            ->setComment('A munkaterület tiszta és biztonságos, mindennek megvan a helye és nincsenek felesleges dolgok, személyes tárgyak, étel / ital a munkaállomáson. Amennyiben nem, azonnal lépjen kapcsolatba a műszakvezetővel.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('S1')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question2);
        
        $question3 = (new Question)
            ->setText('Tároló dobozok és állványok állapota megfelelő? Minden a megfelelő/előírt helyen van tárolva?')
            ->setComment('Sárga (75mm) – Közlekedő utak jelölése párhuzamos, folyamatos sárga 75mm-es padlójelölővel<br>
Kék – félkész termék jelölése kék sarok 50mm-es padlójelölőve<br>
Zöld – késztermék jelölése zöld sarok 50mm-es padlójelölővel<br>
Fehér – Alapanyag jelölése fehér sarok 50mm-es padlójelölővel<br>
Piros – Selejt, zárolt és piros cédulás terület jelölése piros sarok 50mm-es padlójelölővel<br>
Sárga – Minden mozgatható berendezés, eszköz körül szagatott vagy sarok sárga 50mm-es padlójelölő. Ajtók nyílási irányának megfelelően sárga 50mm-es négyzet jelölés.<br>
Narancssárga – olyan gyártáson belüli terület, ahol nem kell viselni a munkavédelmi szemüveget<br>
Fekete – Hulladékok, forgó (KLT), vagy kartonos csomagolóanyagok jelölése fekete sarok 50mm-es padlójelölővel')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('S2')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question3);
        
        $question4 = (new Question)
            ->setText('Ha van folyamatfejlesztési ötleted, azt hol kell leadnod, mi ennek a neve?')
            ->setComment('Az intraneten az új FTP javaslatok menüpontra kattintva lehet leadni. Neve: Folyamatos Tökéletesítési Program (FTP)')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('I1')
            ->setActive(true)
            ->setAvailableAnswers([AnswerTypes::ANSWER_OK => AnswerTypes::ANSWER_OK, AnswerTypes::ANSWER_CORR => AnswerTypes::ANSWER_CORR])
        ;
        $manager->persist($question4);
        
        $question5 = (new Question)
            ->setText('A gyártásban a termékek, anyagok megfelelően azonosítottak?')
            ->setComment('Ellenőrizze a tételazonosító, checkista, műveleti lapok kitöltöttségének megfelelősségét.<br>
Amennyiben nem-megfelelő, azonnal értesítse a műszakvezetőt. Darabokat elkülöníteni.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('L1')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question5);
        
        $question6 = (new Question)
            ->setText('A kanban polcon a rajta lévő azonosító szerinti anyag van kint, megfelelő mennyiségben?')
            ->setComment('Ha kevesebb van kint, az nem gond. Ha több van a kanbanos esetén, azt jelezni kell a Műszakvezetőnek és a Készletkoordinátornak.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('L2')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question6);
        
        $question7 = (new Question)
            ->setText('Az Első darab jóváhagyása megtörtént?')
            ->setComment('Az aláírt/v. zöld bélyegzővel jelölt checklistának kell lennie.<br>
Amennyiben nem, azonnal értesítse a műszakvezetőt. Az eddig legyártott Darabokat elkülöníteni.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('P1')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question7);
        
        $question8 = (new Question)
            ->setText('A nem-megfelelő darabok azonosítva / megfelelően felcímkézve a piros tárolóban vannak?')
            ->setComment('Amennyiben nem, azonnal értesítse a műszakvezetőt.<br>
Darabokat elkülöníteni / Földön talált alkatrész esetén selejtezni. Nézzen körül a munkaterületen azonosítatlan / nem-megfelelő helyen lévő alkatrészeket (amennyiben talál, azonos reakció).')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('P2')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question8);
        
        $question9 = (new Question)
            ->setText('Sok nem-megfelelő darab van a piros ládában?')
            ->setComment('Értesítse a műszakvezetőt, amennyiben 6 óra alatt 10 darabnál több termék kerül a piros ládába')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('P3')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question9);
        
        $question10 = (new Question)
            ->setText('Az operátor a munkautasítás szerint dolgozik? A dolgozó a műveleti utasításban előírt folyamatot betartja?')
            ->setComment('Ellenőrizze, hogy az operátor az érvényes munkautasítások alapján dolgozik.<br>
Amennyiben nem, azonnal értesítse a műszakvezetőt.<br>
Ellenőrizze, hogy a munkautasítás szerint dolgozik az operátor! Amennyiben nem, jelezni kell a másik oldalon, hogy melyik volt vizsgált műveleti utasítás, és mi volt benne az eltérés. Ha az eltérés problémát okoz, vagy okozhat, akkor jelezni kell a z operátornak, hogy az előírt munkautasítástól nem térhet el.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('P4')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question10);
        
        $question11 = (new Question)
            ->setText('Ellenőrzik/használják-e az operátorok/gépbeállítók a Hibamegelőző berendezéseket/eszközöket műszakonként?')
            ->setComment('Ellenőrizze, hogy az operátor/gépbeállító használják-e! Amennyiben nincs Hibabiztosításra alkalmas eszköz a folyamatban, jelölje N/A-val.<br>
Amennyiben nem, darabokat el kell különíteni.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('P5')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question11);
        
        $question12 = (new Question)
            ->setText('A nyákokat megfelelően kezelik (tálca)?')
            ->setComment('Vizsgáljon meg darabokat a készáruból és/vagy a munkaterületen és igazolja, hogy azok megfelelnek a vevői igényeknek.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('C1')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question12);
        
        $question13 = (new Question)
            ->setText('A termék az ellenőrző készülékbe /EOL tesztberendezés helyezve megfelelőséget mutat?')
            ->setComment('Érvényesítse egy darab méreteit a gyártási az EOL teszt alapján. Amennyiben nem-megfelelő, azonnal értesítse a műszakvezetőt. Darabokat elkülöníteni.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('C2')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question13);
        
        $question14 = (new Question)
            ->setText('Az előírt csomagolást használjuk-e és megfelelő a címkézés? A címkézés megfelelősége kiemelt ellenőrzési pont!')
            ->setComment('Ellenőrizze, hogy az előírt csomagolást használjuk, és megfelelően címkézzük a terméket!<br>
Amennyiben nem, azonnal értesítse a műszakvezetőt. Darabokat elkülöníteni.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('C3')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question14);
        
        $question15 = (new Question)
            ->setText('A Minőségügyi Riasztás/Qalert aktuális , és azokat ismerik?')
            ->setComment('Ellenőrizze, hogy a Minőségügyi Riasztás elérhető és a dolgozó tud az eltérésről, intézkedésről.<br>
Amennyiben nem, operátort kioktatni.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('Q1')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question15);
        
        $question16 = (new Question)
            ->setText('A mérőeszközök kalibráltak? Ellenőrizze az eszközöket!')
            ->setComment('Ellenőrizze a címkéket, hogy érvényesítse, hogy azok az újraminősítési időtartamon belül vannak. Ellenőrizze az összes eszközt. Lejárat esetén azonnal értesítse a QA osztályt/line inspectort!')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('Q2')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question16);
        
        $question17 = (new Question)
            ->setText('A dolgozók elvégzik az előírt méréseket?')
            ->setComment('Ellenőrizze megfigyeléssel, jegyzőkönyv vizsgálattal.<br>
Amennyiben nem, azonnal lépjen kapcsolatba a műszakvezetővel.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('Q3')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question17);
        
        $question18 = (new Question)
            ->setText('A mért adatok feljegyzése/rögzítése megtörténik?')
            ->setComment('Vizsgálja meg az adatbázist, hogy megbizonyosodjon, azokat rendeltetésszerűen töltik.<br>
Amennyiben nem, azonnal értesítse a műszakvezetőt. Darabokat elkülöníteni.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('Q4')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question18);
        
        $question19 = (new Question)
            ->setText('Elérhető autonóm karbantartási utasítás a megadott géphez?')
            ->setComment('Ellenőrizze, hogy az autonóm karbantartási utasítás (TPM) elérhető-e a kijelölt helyén?<br>
Amennyiben nem, azonnal lépjen kapcsolatba a műszakvezetővel.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('T1')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question19);

        $question20 = (new Question)
            ->setText('A kijelölt felelős elvégezte az autonóm karbantartási utasítás szerint az feladatokat?')
            ->setComment('Ellenőrizze, hogy az autonóm karbantartási utasítás (TPM) alapján elvégezték-e a napi/heti karbantartásokat.<br>
Amennyiben nem, azonnal lépjen kapcsolatba a műszakvezetővel.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('T2')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question20);
        
        $question21 = (new Question)
            ->setText('Az 1. szintű audit rendszeresen és megfelelően van végrehajtva?')
            ->setComment('Ha van a táblán üres hely, akkor nincs megfelelően töltve.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_2)
            ->setExternalId('A1')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question21);
        
        $question22 = (new Question)
            ->setText('Kérdezd az operátort: Az adott terméknél milyen hibák szoktak előfordulni?')
            ->setComment('Line Inspectornál lehet ellenőrizni a megadott hiba típust.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_2)
            ->setExternalId('Q5')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question22);
        
        $question23 = (new Question)
            ->setText('A kérdezett operátor dolgozhat az állomáson a képességmátrix szerint? <strong>Ellenőrizd a mátrixot is!</strong>')
            ->setComment('A Qualimátrix a területen található, ezen lehet megnézni, hogy a dolgozó milyen szinten áll az adott folyamat elvégzésével.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_2)
            ->setExternalId('W1')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question23);
        
        $question24 = (new Question)
            ->setText('Az 1. és 2. szintű audit rendszeresen és megfelelően van végrehajtva?')
            ->setComment('Ha nincs a táblán kitöltve megfelelő dátummal a 2. szint, akkor nem megfelelő.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_3)
            ->setExternalId('A2')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question24);
        
        $question24 = (new Question)
            ->setText('Mi az adott terméknél az elvárt darabszám?')
            ->setComment('Órás lapot kell mutatni, ami pontosan megadja a kérdésre a választ.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_3)
            ->setExternalId('P6')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question24);
        
        $question24 = (new Question)
            ->setText('Az információkat a műszakok egymás között hiánytalanul átadják?')
            ->setComment('Meg kell kérni a műszakvezetőt, hogy mutassa meg a műszakátadó naplót.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_3)
            ->setExternalId('I1')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question24);
        
        $question24 = (new Question)
            ->setText('Kérdezd az operátort: Tudod, hogy melyek a legfontosabb gyári célok? (TRIR, OTD, Productivity, PPM)')
            ->setComment('<strong>OTD</strong> – On time delivery – Időben való szállítás; Inventory turns - Készletforgás értéke; <strong>TRIR</strong> – Total Recordable Incident Rate – Jelentésköteles balesetek száma; <strong>PPM</strong> - Parts Per Million –  Minőségirányítási mutatószám, hibaarány. A hibarátát, amely azt fejezi ki, hogy egymillió legyártott termék (alkatrész) esetében hányszor fordul elő az adott hiba.; <strong>Productivity</strong> - Hatékonyság')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_3)
            ->setExternalId('I2')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question24);
        
        $manager->flush();
    }
    
    private function production2Questions(ObjectManager $manager, Area $area): void
    {
        $question1 = (new Question)
            ->setText('Mondd el mi volt az utolsó kieső idővel járó baleset a gyárban?')
            ->setComment('2024.07.03. Bokaszalag szakadás <br/>Részletek: Az operátor a szünetéről tért vissza a dohányzóból, szegélykőre lépett innen bal lába befordult, bokája megsérült, elszakadt a bokaszalagja.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('E1')
            ->setActive(true)
            ->setAvailableAnswers([AnswerTypes::ANSWER_OK => AnswerTypes::ANSWER_OK, AnswerTypes::ANSWER_CORR => AnswerTypes::ANSWER_CORR])
        ;
        $manager->persist($question1);
        
        $question2 = (new Question)
            ->setText('A munkaterület biztonságos és tiszta. A munkaterület jó 5S-t mutat? Az eszközök megfelelő helyen vannak, nincsenek személyes tárgyak a területen. A kanban polcok megfelelően jelöltek?')
            ->setComment('A munkaterület tiszta és biztonságos, mindennek megvan a helye és nincsenek felesleges dolgok, személyes tárgyak, étel / ital a munkaállomáson. Amennyiben nem, azonnal lépjen kapcsolatba a műszakvezetővel.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('S1')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question2);
        
        $question3 = (new Question)
            ->setText('Az operátor sorolja fel, hogy mit jelentenek a padlójelölés színei! <br>Fehér, kék, zöld, sárga, fekete és piros.')
            ->setComment('Sárga (75mm) – Közlekedő utak jelölése párhuzamos, folyamatos sárga 75mm-es padlójelölővel<br>
Kék – félkész termék jelölése kék sarok 50mm-es padlójelölőve<br>
Zöld – késztermék jelölése zöld sarok 50mm-es padlójelölővel<br>
Fehér – Alapanyag jelölése fehér sarok 50mm-es padlójelölővel<br>
Piros – Selejt, zárolt és piros cédulás terület jelölése piros sarok 50mm-es padlójelölővel<br>
Sárga – Minden mozgatható berendezés, eszköz körül szagatott vagy sarok sárga 50mm-es padlójelölő. Ajtók nyílási irányának megfelelően sárga 50mm-es négyzet jelölés.<br>
Narancssárga – olyan gyártáson belüli terület, ahol nem kell viselni a munkavédelmi szemüveget<br>
Fekete – Hulladékok, forgó (KLT), vagy kartonos csomagolóanyagok jelölése fekete sarok 50mm-es padlójelölővel')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('S2')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question3);
        
        $question4 = (new Question)
            ->setText('Ha van folyamatfejlesztési ötleted, azt hol kell leadnod, mi ennek a neve?')
            ->setComment('Az intraneten az új FTP javaslatok menüpontra kattintva lehet leadni. Neve: Folyamatos Tökéletesítési Program (FTP)')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('I1')
            ->setActive(true)
            ->setAvailableAnswers([AnswerTypes::ANSWER_OK => AnswerTypes::ANSWER_OK, AnswerTypes::ANSWER_CORR => AnswerTypes::ANSWER_CORR])
        ;
        $manager->persist($question4);
        
        $question5 = (new Question)
            ->setText('A gyártásban a termékek, anyagok megfelelően azonosítottak?')
            ->setComment('Ellenőrizze a tételazonosító, checkista, műveleti lapok kitöltöttségének megfelelősségét.<br>
Amennyiben nem-megfelelő, azonnal értesítse a műszakvezetőt. Darabokat elkülöníteni.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('L1')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question5);
        
        $question6 = (new Question)
            ->setText('A kanban polcon a rajta lévő azonosító szerinti anyag van kint, megfelelő mennyiségben?')
            ->setComment('Ha kevesebb van kint, az nem gond. Ha több van a kanbanos esetén, azt jelezni kell a Műszakvezetőnek és a Készletkoordinátornak.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('L2')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question6);
        
        $question7 = (new Question)
            ->setText('Az Első darab jóváhagyása megtörtént?')
            ->setComment('Az aláírt/v. zöld bélyegzővel jelölt checklistának kell lennie.<br>
Amennyiben nem, azonnal értesítse a műszakvezetőt. Az eddig legyártott Darabokat elkülöníteni.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('P1')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question7);
        
        $question8 = (new Question)
            ->setText('A nem-megfelelő darabok azonosítva / megfelelően felcímkézve a piros tárolóban vannak?')
            ->setComment('Amennyiben nem, azonnal értesítse a műszakvezetőt.<br>
Darabokat elkülöníteni / Földön talált alkatrész esetén selejtezni. Nézzen körül a munkaterületen azonosítatlan / nem-megfelelő helyen lévő alkatrészeket (amennyiben talál, azonos reakció).')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('P2')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question8);
        
        $question9 = (new Question)
            ->setText('Sok nem-megfelelő darab van a piros ládában?')
            ->setComment('Értesítse a műszakvezetőt, amennyiben 6 óra alatt 10 darabnál több termék kerül a piros ládába')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('P3')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question9);
        
        $question10 = (new Question)
            ->setText('Az operátor a munkautasítás szerint dolgozik? A dolgozó a műveleti utasításban előírt folyamatot betartja?')
            ->setComment('Ellenőrizze, hogy az operátor az érvényes munkautasítások alapján dolgozik.<br>
Amennyiben nem, azonnal értesítse a műszakvezetőt.<br>
Ellenőrizze, hogy a munkautasítás szerint dolgozik az operátor! Amennyiben nem, jelezni kell a másik oldalon, hogy melyik volt vizsgált műveleti utasítás, és mi volt benne az eltérés. Ha az eltérés problémát okoz, vagy okozhat, akkor jelezni kell a z operátornak, hogy az előírt munkautasítástól nem térhet el.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('P4')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question10);
        
        $question11 = (new Question)
            ->setText('Ellenőrzik/használják-e az operátorok/gépbeállítók a Hibamegelőző berendezéseket/eszközöket műszakonként?')
            ->setComment('Ellenőrizze, hogy az operátor/gépbeállító használják-e! Amennyiben nincs Hibabiztosításra alkalmas eszköz a folyamatban, jelölje N/A-val.<br>
Amennyiben nem, darabokat el kell különíteni.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('P5')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question11);
        
        $question12 = (new Question)
            ->setText('A nyákokat megfelelően kezelik (tálca)?')
            ->setComment('Vizsgáljon meg darabokat a készáruból és/vagy a munkaterületen és igazolja, hogy azok megfelelnek a vevői igényeknek.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('C1')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question12);
        
        $question13 = (new Question)
            ->setText('A termék az ellenőrző készülékbe /EOL tesztberendezés helyezve megfelelőséget mutat?')
            ->setComment('Érvényesítse egy darab méreteit a gyártási az EOL teszt alapján. Amennyiben nem-megfelelő, azonnal értesítse a műszakvezetőt. Darabokat elkülöníteni.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('C2')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question13);
        
        $question14 = (new Question)
            ->setText('Az előírt csomagolást használjuk-e és megfelelő a címkézés? A címkézés megfelelősége kiemelt ellenőrzési pont!')
            ->setComment('Ellenőrizze, hogy az előírt csomagolást használjuk, és megfelelően címkézzük a terméket!<br>
Amennyiben nem, azonnal értesítse a műszakvezetőt. Darabokat elkülöníteni.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('C3')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question14);
        
        $question15 = (new Question)
            ->setText('A Minőségügyi Riasztás/Qalert aktuális, és azokat ismerik?')
            ->setComment('Ellenőrizze, hogy a Minőségügyi Riasztás elérhető és a dolgozó tud az eltérésről, intézkedésről.<br>
Amennyiben nem, operátort kioktatni.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('Q1')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question15);
        
        $question16 = (new Question)
            ->setText('A mérőeszközök kalibráltak? Ellenőrizze az eszközöket!')
            ->setComment('Ellenőrizze a címkéket, hogy érvényesítse, hogy azok az újraminősítési időtartamon belül vannak. Ellenőrizze az összes eszközt. Lejárat esetén azonnal értesítse a QA osztályt/line inspectort!')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('Q2')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question16);
        
        $question17 = (new Question)
            ->setText('A dolgozók elvégzik az előírt méréseket?')
            ->setComment('Ellenőrizze megfigyeléssel, jegyzőkönyv vizsgálattal.<br>
Amennyiben nem, azonnal lépjen kapcsolatba a műszakvezetővel.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('Q3')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question17);
        
        $question18 = (new Question)
            ->setText('A mért adatok feljegyzése/rögzítése megtörténik?')
            ->setComment('Vizsgálja meg az adatbázist, hogy megbizonyosodjon, azokat rendeltetésszerűen töltik.<br>
Amennyiben nem, azonnal értesítse a műszakvezetőt. Darabokat elkülöníteni.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('Q4')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question18);
        
        $question19 = (new Question)
            ->setText('Elérhető autonóm karbantartási utasítás a megadott géphez?')
            ->setComment('Ellenőrizze, hogy az autonóm karbantartási utasítás (TPM) elérhető-e a kijelölt helyén?<br>
Amennyiben nem, azonnal lépjen kapcsolatba a műszakvezetővel.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('T1')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question19);

        $question20 = (new Question)
            ->setText('A kijelölt felelős elvégezte az autonóm karbantartási utasítás szerint az feladatokat?')
            ->setComment('Ellenőrizze, hogy az autonóm karbantartási utasítás (TPM) alapján elvégezték-e a napi/heti karbantartásokat.<br>
Amennyiben nem, azonnal lépjen kapcsolatba a műszakvezetővel.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setExternalId('T2')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question20);
        
        $question21 = (new Question)
            ->setText('Az 1. szintű audit rendszeresen és megfelelően van végrehajtva?')
            ->setComment('Ha van a táblán üres hely, akkor nincs megfelelően töltve.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_2)
            ->setExternalId('A1')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question21);
        
        $question22 = (new Question)
            ->setText('Kérdezd az operátort: Az adott terméknél milyen hibák szoktak előfordulni?')
            ->setComment('Line Inspectornál lehet ellenőrizni a megadott hiba típust.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_2)
            ->setExternalId('Q5')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question22);
        
        $question23 = (new Question)
            ->setText('A kérdezett operátor dolgozhat az állomáson a képességmátrix szerint? <strong>Ellenőrizd a mátrixot is!</strong>')
            ->setComment('A Qualimátrix a területen található, ezen lehet megnézni, hogy a dolgozó milyen szinten áll az adott folyamat elvégzésével.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_2)
            ->setExternalId('W1')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question23);
        
        $question24 = (new Question)
            ->setText('Az 1. és 2. szintű audit rendszeresen és megfelelően van végrehajtva?')
            ->setComment('Ha nincs a táblán kitöltve megfelelő dátummal a 2. szint, akkor nem megfelelő.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_3)
            ->setExternalId('A2')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question24);
        
        $question24 = (new Question)
            ->setText('Mi az adott terméknél az elvárt darabszám?')
            ->setComment('Órás lapot kell mutatni, ami pontosan megadja a kérdésre a választ.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_3)
            ->setExternalId('P6')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question24);
        
        $question24 = (new Question)
            ->setText('Az információkat a műszakok egymás között hiánytalanul átadják?')
            ->setComment('Meg kell kérni a műszakvezetőt, hogy mutassa meg a műszakátadó naplót.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_3)
            ->setExternalId('I1')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question24);
        
        $question24 = (new Question)
            ->setText('Kérdezd az operátort: Tudod, hogy melyek a legfontosabb gyári célok? (TRIR, OTD, Productivity, PPM)')
            ->setComment('<strong>OTD</strong> – On time delivery – Időben való szállítás; Inventory turns - Készletforgás értéke; <strong>TRIR</strong> – Total Recordable Incident Rate – Jelentésköteles balesetek száma; <strong>PPM</strong> - Parts Per Million –  Minőségirányítási mutatószám, hibaarány. A hibarátát, amely azt fejezi ki, hogy egymillió legyártott termék (alkatrész) esetében hányszor fordul elő az adott hiba.; <strong>Productivity</strong> - Hatékonyság')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_3)
            ->setExternalId('I2')
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question24);
        
        $manager->flush();
    }
}
