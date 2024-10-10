<?php

namespace App\DataFixtures;

use App\Entity\{Question, Area};
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
            ->setActive(true)
        ;
        $manager->persist($production);
        
        $warehouse = (new Area())
            ->setName('Raktár')
            ->setType(AreaEnum::AREA_WAREHOUSE)
            ->setActive(true)
        ;
        $manager->persist($warehouse);
        
        $maintenance = (new Area())
            ->setName('Karbantartás')
            ->setType(AreaEnum::AREA_MAINTENANCE)
            ->setActive(true)
        ;
        $manager->persist($maintenance);
        
        $manager->flush();
        $manager->refresh($production);
        $manager->refresh($warehouse);
        $manager->refresh($maintenance);
        
        
        $this->productionQuestions($manager, $production);
        $this->maintenanceQuestions($manager, $maintenance);
        $this->warehouseQuestions($manager, $warehouse);
    }
    
    private function warehouseQuestions(ObjectManager $manager, Area $area): void
    {
        $question1 = (new Question)
            ->setText('Mondd el mi volt az utolsó kieső idővel járó baleset a gyárban?')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question1);
        
        $question2 = (new Question)
            ->setText('A munkaterület biztonságos és tiszta. A munkaterület jó 5S-t mutat? Az eszközök megfelelő helyen vannak, nincsenek személyes tárgyak a területen.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question2);
        
        $question3 = (new Question)
            ->setText('Tároló dobozok és állványok állapota megfelelő? Minden a megfelelő/előírt helyen van tárolva?')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question3);
        
        $question4 = (new Question)
            ->setText('Ha van folyamatfejlesztési ötleted, azt hol kell leadnod, mi ennek a neve?')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question4);
        
        $question5 = (new Question)
            ->setText('A raktárban a termékek, anyagok megfelelően azonosítottak?')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question5);
        
        $question6 = (new Question)
            ->setText('A nem-megfelelő beeérkező áruk megfelelően felcímkézve elkülönítve vannak tárolva?')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question6);
        
        $question7 = (new Question)
            ->setText('A raktári kolléga a munkautasítás szerint dolgozik?')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question7);
        
        $question8 = (new Question)
            ->setText('A nyákokat megfelelően kezelik tárolják (alapanyag raktár esetében)? ')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question8);
        
        $question9 = (new Question)
            ->setText('A termék az ellenőrző készülékbe /EOL tesztberendezés helyezve megfelelőséget mutat?')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question9);
        
        $question10 = (new Question)
            ->setText('Az előírt csomagolást használjuk-e és megfelelő a címkézést? A címkézés megfelelősége kiemelt ellenőrzési pont! (Készáru zóna, vagy kiszállítás előkészítés)')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question10);
        
        $question11 = (new Question)
            ->setText('A Minőségügyi Riasztás/Qalert aktuális , és azokat ismerik?')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question11);
        
        $question12 = (new Question)
            ->setText('A mérőeszközök kalibráltak? Ellenőrizze az eszközöket!')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question12);
        
        $question13 = (new Question)
            ->setText('Elérhető autonóm karbantartási utasítás a megadott géphez?')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question13);
        
        $question14 = (new Question)
            ->setText('A kijelölt felelős elvégezte az autonóm karbantartási utasítás szerint az feladatokat?')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question14);
        
        $question15 = (new Question)
            ->setText('Az 1. szintű audit rendszeresen és megfelelően van végrehajtva?')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_2)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question15);
        
        $question16 = (new Question)
            ->setText('Az információkat a műszakok egymás között hiánytalanul átadják?')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_2)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question16);
        
        $question17 = (new Question)
            ->setText('Kérdezd a raktáros kollégát: Milyen hibák szoktak előfordulni az adott műveletnél, amit végez?')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_2)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question17);
        
        $question18 = (new Question)
            ->setText('A kérdezett operátor dolgozhat az állomáson a képességmátrix szerint? Ellenőrizd a mátrixot is!')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_2)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question18);
        
        $question19 = (new Question)
            ->setText('Az 1. és 2. szintű audit rendszeresen és megfelelően van végrehajtva?')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_3)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question19);
        
        $question20 = (new Question)
            ->setText('Kérdezd az operátort: Tudod, hogy melyek a legfontosabb gyári célok? (TRIR, OTD, Productivity, PPM)')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_3)
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
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question1);
        
        $question2 = (new Question)
            ->setText('A munkaterület biztonságos és tiszta. A munkaterület jó 5S-t mutat? Az eszközök megfelelő helyen vannak, nincsenek személyes tárgyak a területen.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question2);
        
        $question3 = (new Question)
            ->setText('Tárolószekrények állapota megfelelő? Minden a megfelelő/előírt helyen van tárolva?')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question3);
        
        $question4 = (new Question)
            ->setText('Ha van folyamatfejlesztési ötleted, azt hol kell leadnod, mi ennek a neve?')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question4);
        
        $question5 = (new Question)
            ->setText('A mérőeszközök kalibráltak? Ellenőrizze az eszközöket!')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question5);
        
        $question6 = (new Question)
            ->setText('Elérhető autonóm karbantartási utasítás a megadott géphez? ')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question6);
        
        $question7 = (new Question)
            ->setText('A kijelölt felelős elvégezte az autonóm karbantartási utasítás szerint az feladatokat?')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question7);
        
        $question8 = (new Question)
            ->setText('Az 1. szintű audit rendszeresen és megfelelően van végrehajtva?')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_2)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question8);
        
        $question9 = (new Question)
            ->setText('Kérdezd a karbantartó kollégát: Honnan kapja meg a napi munkáját és hov a kell feljegyezni annak elvégzését? Mikor ér véget a folyamat?')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_2)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question9);
        
        $question10 = (new Question)
            ->setText('Az 1. és 2. szintű audit rendszeresen és megfelelően van végrehajtva?')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_3)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question10);
        
        $question11 = (new Question)
            ->setText('Kérdezd az operátort: Tudod, hogy melyek a legfontosabb gyári célok? (TRIR, OTD, Productivity, PPM)')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_3)
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
            ->setActive(true)
            ->setParent($parentArea)
        ;
        $manager->persist($area1);
        
        $area2 = (new Area())
            ->setName('Sperrkreis')
            ->setType(AreaEnum::AREA_PRODUCTION)
            ->setActive(true)
            ->setParent($parentArea)
        ;
        $manager->persist($area2);
        
        $area3 = (new Area())
            ->setName('EPA3-ABM')
            ->setType(AreaEnum::AREA_PRODUCTION)
            ->setActive(true)
            ->setParent($parentArea)
        ;
        $manager->persist($area3);
        
        $area4 = (new Area())
            ->setName('GIGA')
            ->setType(AreaEnum::AREA_PRODUCTION)
            ->setActive(true)
            ->setParent($parentArea)
        ;
        $manager->persist($area4);
        
        $area5 = (new Area())
            ->setName('Babaház')
            ->setType(AreaEnum::AREA_PRODUCTION)
            ->setActive(true)
            ->setParent($parentArea)
        ;
        $manager->persist($area5);
        
        $area6 = (new Area())
            ->setName('Audi Lte')
            ->setType(AreaEnum::AREA_PRODUCTION)
            ->setActive(true)
            ->setParent($parentArea)
        ;
        $manager->persist($area6);
        
        $area7 = (new Area())
            ->setName('Pálca')
            ->setType(AreaEnum::AREA_PRODUCTION)
            ->setActive(true)
            ->setParent($parentArea)
        ;
        $manager->persist($area7);
        
        $area8 = (new Area())
            ->setName('MKT')
            ->setType(AreaEnum::AREA_PRODUCTION)
            ->setActive(true)
            ->setParent($parentArea)
        ;
        $manager->persist($area8);

        $area9 = (new Area())
            ->setName('Szonda')
            ->setType(AreaEnum::AREA_PRODUCTION)
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
        $this->production1Questions($manager, $area9);
    }
    
    private function production1Questions(ObjectManager $manager, Area $area): void
    {
        $question1 = (new Question)
            ->setText('Mondd el mi volt az utolsó kieső idővel járó baleset a gyárban?')
            ->setComment('2024.07.03. Bokaszalag szakadás <br/>Részletek: Az operátor a szünetéről tért vissza a dohányzóból, szegélykőre lépett innen bal lába befordult, bokája megsérült, elszakadt a bokaszalagja.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers([AnswerTypes::ANSWER_OK => AnswerTypes::ANSWER_OK, AnswerTypes::ANSWER_CORR => AnswerTypes::ANSWER_CORR])
        ;
        $manager->persist($question1);
        
        $question2 = (new Question)
            ->setText('A munkaterület biztonságos és tiszta. A munkaterület jó 5S-t mutat? Az eszközök megfelelő helyen vannak, nincsenek személyes tárgyak a területen. A kanban polcok megfelelően jelöltek?')
            ->setComment('A munkaterület tiszta és biztonságos, mindennek megvan a helye és nincsenek felesleges dolgok, személyes tárgyak, étel / ital a munkaállomáson. Amennyiben nem, azonnal lépjen kapcsolatba a műszakvezetővel.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
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
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question3);
        
        $question4 = (new Question)
            ->setText('Ha van folyamatfejlesztési ötleted, azt hol kell leadnod, mi ennek a neve?')
            ->setComment('Az intraneten az új FTP javaslatok menüpontra kattintva lehet leadni. Neve: Folyamatos Tökéletesítési Program (FTP)')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
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
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question5);
        
        $question6 = (new Question)
            ->setText('A kanban polcon a rajta lévő azonosító szerinti anyag van kint, megfelelő mennyiségben?')
            ->setComment('Ha kevesebb van kint, az nem gond. Ha több van a kanbanos esetén, azt jelezni kell a Műszakvezetőnek és a Készletkoordinátornak.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
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
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question8);
        
        $question9 = (new Question)
            ->setText('Sok nem-megfelelő darab van a piros ládában?')
            ->setComment('Értesítse a műszakvezetőt, amennyiben 6 óra alatt 10 darabnál több termék kerül a piros ládába')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question9);
        
        $question10 = (new Question)
            ->setText('Az operátor a munkautasítás szerint dolgozik? A  dolgozó a műveleti utasításban előírt folyamatot betartja?')
            ->setComment('Ellenőrizze, hogy az operátor az érvényes munkautasítások alapján dolgozik.<br>
Amennyiben nem, azonnal értesítse a műszakvezetőt.<br>
Ellenőrizze, hogy a munkautasítás szerint dolgozik az operátor! Amennyiben nem, jelezni kell a másik oldalon, hogy melyik volt vizsgált műveleti utasítás, és mi volt benne az eltérés. Ha az eltérés problémát okoz, vagy okozhat, akkor jelezni kell a z operátornak, hogy az előírt munkautasítástól nem térhet el.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
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
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question11);
        
        $question12 = (new Question)
            ->setText('A nyákokat megfelelően kezelik (tálca)? ')
            ->setComment('Vizsgáljon meg darabokat a készáruból és/vagy a munkaterületen és igazolja, hogy azok megfelelnek a vevői igényeknek.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question12);
        
        $question13 = (new Question)
            ->setText('A termék az ellenőrző készülékbe /EOL tesztberendezés helyezve megfelelőséget mutat?')
            ->setComment('Érvényesítse egy darab méreteit a gyártási az EOL teszt alapján. Amennyiben nem-megfelelő, azonnal értesítse a műszakvezetőt. Darabokat elkülöníteni.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
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
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question15);
        
        $question16 = (new Question)
            ->setText('A mérőeszközök kalibráltak? Ellenőrizze az eszközöket!')
            ->setComment('Ellenőrizze a címkéket, hogy érvényesítse, hogy azok az újraminősítési időtartamon belül vannak. Ellenőrizze az összes eszközt. Lejárat esetén azonnal értesítse a QA osztályt/line inspectort!')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
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
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question17);
        
        $question18 = (new Question)
            ->setText('A mért adatok  feljegyzése/rögzítése megtörténik?')
            ->setComment('Vizsgálja meg az adatbázist, hogy megbizonyosodjon, azokat rendeltetésszerűen töltik.<br>
Amennyiben nem, azonnal értesítse a műszakvezetőt. Darabokat elkülöníteni.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_1)
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
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question20);
        
        $question21 = (new Question)
            ->setText('Az 1. szintű audit rendszeresen és megfelelően van végrehajtva?')
            ->setComment('Ha van a táblán üres hely, akkor nincs megfelelően töltve.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_2)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question21);
        
        $question22 = (new Question)
            ->setText('Kérdezd az operátort: Az adott terméknél milyen hibák szoktak előfordulni?')
            ->setComment('Line Inspectornál lehet ellenőrizni a megadott hiba típust.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_2)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question22);
        
        $question23 = (new Question)
            ->setText('A kérdezett operátor dolgozhat az állomáson a képességmátrix szerint? <strong>Ellenőrizd a mátrixot is!</strong>')
            ->setComment('A Qualimátrix a területen található, ezen lehet megnézni, hogy a dolgozó milyen szinten áll az adott folyamat elvégzésével.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_2)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question23);
        
        $question24 = (new Question)
            ->setText('Az 1. és 2. szintű audit rendszeresen és megfelelően van végrehajtva?')
            ->setComment('Ha nincs a táblán kitöltve megfelelő dátummal a 2. szint, akkor nem megfelelő.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_3)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question24);
        
        $question24 = (new Question)
            ->setText('Mi az adott terméknél az elvárt darabszám?')
            ->setComment('Órás lapot kell mutatni, ami pontosan megadja a kérdésre a választ.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_3)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question24);
        
        $question24 = (new Question)
            ->setText('Az információkat a műszakok egymás között hiánytalanul átadják?')
            ->setComment('Meg kell kérni a műszakvezetőt, hogy mutassa meg a műszakátadó naplót.')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_3)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question24);
        
        $question24 = (new Question)
            ->setText('Kérdezd az operátort: Tudod, hogy melyek a legfontosabb gyári célok? (TRIR, OTD, Productivity, PPM)')
            ->setComment('<strong>OTD</strong> – On time delivery – Időben való szállítás; Inventory turns - Készletforgás értéke; <strong>TRIR</strong> – Total Recordable Incident Rate – Jelentésköteles balesetek száma; <strong>PPM</strong> - Parts Per Million –  Minőségirányítási mutatószám, hibaarány. A hibarátát, amely azt fejezi ki, hogy egymillió legyártott termék (alkatrész) esetében hányszor fordul elő az adott hiba.; <strong>Productivity</strong> - Hatékonyság')
            ->setArea($area)
            ->setLevel(UserLevel::LEVEL_3)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question24);
        
        $manager->flush();
    }
}
