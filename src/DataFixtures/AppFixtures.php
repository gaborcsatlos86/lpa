<?php

namespace App\DataFixtures;

use App\Entity\Question;
use App\Enums\{UserLevel, Area, AnswerTypes};
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->productionQuestions($manager);
        $this->maintenanceQuestions($manager);
        $this->warehouseQuestions($manager);
    }
    
    private function warehouseQuestions(ObjectManager $manager): void
    {
        $question1 = (new Question)
            ->setText('Mondd el mi volt az utolsó kieső idővel járó baleset a gyárban?')
            ->setArea(Area::AREA_WAREHOUSE)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question1);
        
        $question2 = (new Question)
            ->setText('A munkaterület biztonságos és tiszta. A munkaterület jó 5S-t mutat? Az eszközök megfelelő helyen vannak, nincsenek személyes tárgyak a területen.')
            ->setArea(Area::AREA_WAREHOUSE)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question2);
        
        $question3 = (new Question)
            ->setText('Tároló dobozok és állványok állapota megfelelő? Minden a megfelelő/előírt helyen van tárolva?')
            ->setArea(Area::AREA_WAREHOUSE)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question3);
        
        $question4 = (new Question)
            ->setText('Ha van folyamatfejlesztési ötleted, azt hol kell leadnod, mi ennek a neve?')
            ->setArea(Area::AREA_WAREHOUSE)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question4);
        
        $question5 = (new Question)
            ->setText('A raktárban a termékek, anyagok megfelelően azonosítottak?')
            ->setArea(Area::AREA_WAREHOUSE)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question5);
        
        $question6 = (new Question)
            ->setText('A nem-megfelelő beeérkező áruk megfelelően felcímkézve elkülönítve vannak tárolva?')
            ->setArea(Area::AREA_WAREHOUSE)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question6);
        
        $question7 = (new Question)
            ->setText('A raktári kolléga a munkautasítás szerint dolgozik?')
            ->setArea(Area::AREA_WAREHOUSE)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question7);
        
        $question8 = (new Question)
            ->setText('A nyákokat megfelelően kezelik tárolják (alapanyag raktár esetében)? ')
            ->setArea(Area::AREA_WAREHOUSE)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question8);
        
        $question9 = (new Question)
            ->setText('A termék az ellenőrző készülékbe /EOL tesztberendezés helyezve megfelelőséget mutat?')
            ->setArea(Area::AREA_WAREHOUSE)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question9);
        
        $question10 = (new Question)
            ->setText('Az előírt csomagolást használjuk-e és megfelelő a címkézést? A címkézés megfelelősége kiemelt ellenőrzési pont! (Készáru zóna, vagy kiszállítás előkészítés)')
            ->setArea(Area::AREA_WAREHOUSE)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question10);
        
        $question11 = (new Question)
            ->setText('A Minőségügyi Riasztás/Qalert aktuális , és azokat ismerik?')
            ->setArea(Area::AREA_WAREHOUSE)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question11);
        
        $question12 = (new Question)
            ->setText('A mérőeszközök kalibráltak? Ellenőrizze az eszközöket!')
            ->setArea(Area::AREA_WAREHOUSE)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question12);
        
        $question13 = (new Question)
            ->setText('Elérhető autonóm karbantartási utasítás a megadott géphez?')
            ->setArea(Area::AREA_WAREHOUSE)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question13);
        
        $question14 = (new Question)
            ->setText('A kijelölt felelős elvégezte az autonóm karbantartási utasítás szerint az feladatokat?')
            ->setArea(Area::AREA_WAREHOUSE)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question14);
        
        $question15 = (new Question)
            ->setText('Az 1. szintű audit rendszeresen és megfelelően van végrehajtva?')
            ->setArea(Area::AREA_WAREHOUSE)
            ->setLevel(UserLevel::LEVEL_2)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question15);
        
        $question16 = (new Question)
            ->setText('Az információkat a műszakok egymás között hiánytalanul átadják?')
            ->setArea(Area::AREA_WAREHOUSE)
            ->setLevel(UserLevel::LEVEL_2)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question16);
        
        $question17 = (new Question)
            ->setText('Kérdezd a raktáros kollégát: Milyen hibák szoktak előfordulni az adott műveletnél, amit végez?')
            ->setArea(Area::AREA_WAREHOUSE)
            ->setLevel(UserLevel::LEVEL_2)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question17);
        
        $question18 = (new Question)
            ->setText('A kérdezett operátor dolgozhat az állomáson a képességmátrix szerint? Ellenőrizd a mátrixot is!')
            ->setArea(Area::AREA_WAREHOUSE)
            ->setLevel(UserLevel::LEVEL_2)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question18);
        
        $question19 = (new Question)
            ->setText('Az 1. és 2. szintű audit rendszeresen és megfelelően van végrehajtva?')
            ->setArea(Area::AREA_WAREHOUSE)
            ->setLevel(UserLevel::LEVEL_3)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question19);
        
        $question20 = (new Question)
            ->setText('Kérdezd az operátort: Tudod, hogy melyek a legfontosabb gyári célok? (TRIR, OTD, Productivity, PPM)')
            ->setArea(Area::AREA_WAREHOUSE)
            ->setLevel(UserLevel::LEVEL_3)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question20);
        
        $manager->flush();
    }
    
    private function maintenanceQuestions(ObjectManager $manager): void
    {
        $question1 = (new Question)
            ->setText('Mondd el mi volt az utolsó kieső idővel járó baleset a gyárban?')
            ->setArea(Area::AREA_MAINTENANCE)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question1);
        
        $question2 = (new Question)
            ->setText('A munkaterület biztonságos és tiszta. A munkaterület jó 5S-t mutat? Az eszközök megfelelő helyen vannak, nincsenek személyes tárgyak a területen.')
            ->setArea(Area::AREA_MAINTENANCE)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question2);
        
        $question3 = (new Question)
            ->setText('Tárolószekrények állapota megfelelő? Minden a megfelelő/előírt helyen van tárolva?')
            ->setArea(Area::AREA_MAINTENANCE)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question3);
        
        $question4 = (new Question)
            ->setText('Ha van folyamatfejlesztési ötleted, azt hol kell leadnod, mi ennek a neve?')
            ->setArea(Area::AREA_MAINTENANCE)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question4);
        
        $question5 = (new Question)
            ->setText('A mérőeszközök kalibráltak? Ellenőrizze az eszközöket!')
            ->setArea(Area::AREA_MAINTENANCE)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question5);
        
        $question6 = (new Question)
            ->setText('Elérhető autonóm karbantartási utasítás a megadott géphez? ')
            ->setArea(Area::AREA_MAINTENANCE)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question6);
        
        $question7 = (new Question)
            ->setText('A kijelölt felelős elvégezte az autonóm karbantartási utasítás szerint az feladatokat?')
            ->setArea(Area::AREA_MAINTENANCE)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question7);
        
        $question8 = (new Question)
            ->setText('Az 1. szintű audit rendszeresen és megfelelően van végrehajtva?')
            ->setArea(Area::AREA_MAINTENANCE)
            ->setLevel(UserLevel::LEVEL_2)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question8);
        
        $question9 = (new Question)
            ->setText('Kérdezd a karbantartó kollégát: Honnan kapja meg a napi munkáját és hov a kell feljegyezni annak elvégzését? Mikor ér véget a folyamat?')
            ->setArea(Area::AREA_MAINTENANCE)
            ->setLevel(UserLevel::LEVEL_2)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question9);
        
        $question10 = (new Question)
            ->setText('Az 1. és 2. szintű audit rendszeresen és megfelelően van végrehajtva?')
            ->setArea(Area::AREA_MAINTENANCE)
            ->setLevel(UserLevel::LEVEL_3)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question10);
        
        $question11 = (new Question)
            ->setText('Kérdezd az operátort: Tudod, hogy melyek a legfontosabb gyári célok? (TRIR, OTD, Productivity, PPM)')
            ->setArea(Area::AREA_MAINTENANCE)
            ->setLevel(UserLevel::LEVEL_3)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question11);
        
        $manager->flush();
    }
    
    private function productionQuestions(ObjectManager $manager): void
    {
        $question1 = (new Question)
            ->setText('Mondd el mi volt az utolsó kieső idővel járó baleset a gyárban?')
            ->setArea(Area::AREA_PRODUCTION)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers([AnswerTypes::ANSWER_OK => AnswerTypes::ANSWER_OK, AnswerTypes::ANSWER_CORR => AnswerTypes::ANSWER_CORR])
        ;
        $manager->persist($question1);
        
        $question2 = (new Question)
            ->setText('A munkaterület biztonságos és tiszta. A munkaterület jó 5S-t mutat? Az eszközök megfelelő helyen vannak, nincsenek személyes tárgyak a területen. A kanban polcok megfelelően jelöltek?')
            ->setArea(Area::AREA_PRODUCTION)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question2);
        
        $question3 = (new Question)
            ->setText('Tároló dobozok és állványok állapota megfelelő? Minden a megfelelő/előírt helyen van tárolva?')
            ->setArea(Area::AREA_PRODUCTION)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question3);
        
        $question4 = (new Question)
            ->setText('Ha van folyamatfejlesztési ötleted, azt hol kell leadnod, mi ennek a neve?')
            ->setArea(Area::AREA_PRODUCTION)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers([AnswerTypes::ANSWER_OK => AnswerTypes::ANSWER_OK, AnswerTypes::ANSWER_CORR => AnswerTypes::ANSWER_CORR])
        ;
        $manager->persist($question4);
        
        $question5 = (new Question)
            ->setText('A gyártásban a termékek, anyagok megfelelően azonosítottak?')
            ->setArea(Area::AREA_PRODUCTION)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question5);
        
        $question6 = (new Question)
            ->setText('A kanban polcon a rajta lévő azonosító szerinti anyag van kint, megfelelő mennyiségben? ')
            ->setArea(Area::AREA_PRODUCTION)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question6);
        
        $question7 = (new Question)
            ->setText('Az Első darab jóváhagyása megtörtént?')
            ->setArea(Area::AREA_PRODUCTION)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question7);
        
        $question8 = (new Question)
            ->setText('A nem-megfelelő darabok azonosítva / megfelelően felcímkézve a piros tárolóban vannak?')
            ->setArea(Area::AREA_PRODUCTION)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question8);
        
        $question9 = (new Question)
            ->setText('Sok nem-megfelelő darab van a piros ládában?')
            ->setArea(Area::AREA_PRODUCTION)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question9);
        
        $question10 = (new Question)
            ->setText('Az operátor a munkautasítás szerint dolgozik? A  dolgozó a műveleti utasításban előírt folyamatot betartja?')
            ->setArea(Area::AREA_PRODUCTION)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question10);
        
        $question11 = (new Question)
            ->setText('Ellenőrzik/használják-e az operátorok/gépbeállítók a Hibamegelőző berendezéseket/eszközöket műszakonként?')
            ->setArea(Area::AREA_PRODUCTION)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question11);
        
        $question12 = (new Question)
            ->setText('A nyákokat megfelelően kezelik (tálca)? ')
            ->setArea(Area::AREA_PRODUCTION)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question12);
        
        $question13 = (new Question)
            ->setText('A termék az ellenőrző készülékbe /EOL tesztberendezés helyezve megfelelőséget mutat?')
            ->setArea(Area::AREA_PRODUCTION)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question13);
        
        $question14 = (new Question)
            ->setText('Az előírt csomagolást használjuk-e és megfelelő a címkézés? A címkézés megfelelősége kiemelt ellenőrzési pont!')
            ->setArea(Area::AREA_PRODUCTION)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question14);
        
        $question15 = (new Question)
            ->setText('A Minőségügyi Riasztás/Qalert aktuális , és azokat ismerik?')
            ->setArea(Area::AREA_PRODUCTION)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question15);
        
        $question16 = (new Question)
            ->setText('A mérőeszközök kalibráltak? Ellenőrizze az eszközöket!')
            ->setArea(Area::AREA_PRODUCTION)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question16);
        
        $question17 = (new Question)
            ->setText('A dolgozók elvégzik az előírt méréseket? ')
            ->setArea(Area::AREA_PRODUCTION)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question17);
        
        $question18 = (new Question)
            ->setText('A mért adatok  feljegyzése/rögzítése megtörténik?')
            ->setArea(Area::AREA_PRODUCTION)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question18);
        
        $question19 = (new Question)
            ->setText('Elérhető autonóm karbantartási utasítás a megadott géphez?')
            ->setArea(Area::AREA_PRODUCTION)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question19);

        $question20 = (new Question)
            ->setText('A kijelölt felelős elvégezte az autonóm karbantartási utasítás szerint az feladatokat?')
            ->setArea(Area::AREA_PRODUCTION)
            ->setLevel(UserLevel::LEVEL_1)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question20);
        
        $question21 = (new Question)
            ->setText('Az 1. szintű audit rendszeresen és megfelelően van végrehajtva?')
            ->setArea(Area::AREA_PRODUCTION)
            ->setLevel(UserLevel::LEVEL_2)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question21);
        
        $question22 = (new Question)
            ->setText('Kérdezd az operátort: Az adott terméknél milyen hibák szoktak előfordulni?')
            ->setArea(Area::AREA_PRODUCTION)
            ->setLevel(UserLevel::LEVEL_2)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question22);
        
        $question23 = (new Question)
            ->setText('A kérdezett operátor dolgozhat az állomáson a képességmátrix szerint? <bold>Ellenőrizd a mátrixot is!</bold>')
            ->setArea(Area::AREA_PRODUCTION)
            ->setLevel(UserLevel::LEVEL_2)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question23);
        
        $question24 = (new Question)
            ->setText('Az 1. és 2. szintű audit rendszeresen és megfelelően van végrehajtva?')
            ->setArea(Area::AREA_PRODUCTION)
            ->setLevel(UserLevel::LEVEL_3)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question24);
        
        $question24 = (new Question)
            ->setText('Mi az adott terméknél az elvárt darabszám?')
            ->setArea(Area::AREA_PRODUCTION)
            ->setLevel(UserLevel::LEVEL_3)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question24);
        
        $question24 = (new Question)
            ->setText('Az információkat a műszakok egymás között hiánytalanul átadják?')
            ->setArea(Area::AREA_PRODUCTION)
            ->setLevel(UserLevel::LEVEL_3)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question24);
        
        $question24 = (new Question)
            ->setText('Kérdezd az operátort: Tudod, hogy melyek a legfontosabb gyári célok? (TRIR, OTD, Productivity, PPM)')
            ->setArea(Area::AREA_PRODUCTION)
            ->setLevel(UserLevel::LEVEL_3)
            ->setActive(true)
            ->setAvailableAnswers(AnswerTypes::getItems())
        ;
        $manager->persist($question24);
        
        $manager->flush();
    }
}
