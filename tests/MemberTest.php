<?php

require_once '../../models/entities/RegexTester.php';
require_once '../../models/entities/Member.php';

use ProjectEvs\ExceptionPerso;
use ProjectEvs\Member;

class MemberTest extends PHPUnit\Framework\TestCase {

    //Test unitaire sur setBirthdate
    public function testSetBirthdateWithCheckdate() {
        $member = new Member();
        $date = '1999-03-12';
        $expectedDate = '1999/03/12';
        $member->setBirthdate($date);
        $this->assertEquals($expectedDate, $member->getBirthdate());
    }
    
    public function testSetBirthdateWithExpectedException() {
        $this->expectException(ExceptionPerso::class);
        $member = new Member();
        $date = '2900-02-29';
        $member->setBirthdate($date);
    }
    
    public function testSetBirthdateWithWrongFormat() {
        $this->expectException(ExceptionPerso::class);
        $member = new Member();
        $date = '04-11-2013'; // Format incorrect
        $member->setBirthdate($date);
    }
    
    public function testSetBirthdateNotAfterToday() {
        $member = new Member();
        $today = new DateTime();
        $date = '1999-03-12';
        $member->setBirthdate($date);
        $this->assertLessThan($today, new DateTime($member->getBirthdate()));
    }
    
    public function testSetBirthdateAfterToday() {
        $this->expectException(ExceptionPerso::class);
        $member = new Member();
        $today = new DateTime();
        $date = '2030-07-12';
        $member->setBirthdate($date);
        $this->assertGreaterThan($today, new DateTime($member->getBirthdate()));
    }    

    //Test unitaire sur setplaceOfBirth
    public function testsetPlaceOfBirthWithRegex() {
        $member = new Member();
        $placeOfBirth = 'djsjd-ejjdéèUY';
        $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';
        $member->setPlaceOfBirth($placeOfBirth);
        $this->assertMatchesRegularExpression($pattern, $member->getPlaceOfBirth());
    }

    public function testsetPlaceOfBirthWithNumber() {
        $this->expectException(ExceptionPerso::class);
        $member = new Member();
        $placeOfBirth = 426;
        $member->setPlaceOfBirth($placeOfBirth);
    }

    public function testsetPlaceOfBirthWithSpecialCharacter() {
        $this->expectException(ExceptionPerso::class);
        $member = new Member();
        $placeOfBirth = '?"/!';
        $member->setplaceOfBirth($placeOfBirth);
    }

    public function testNotMatchPlaceOfBirthRegex() {
        $this->expectException(ExceptionPerso::class);
        $member = new Member();
        $placeOfBirth = 'hdjjj-Gl56Msjjs';
        $member->setPlaceOfBirth($placeOfBirth);
    }

    public function testsetPlaceOfBirthIsNotEmpty() {
        $member = new Member();
        $placeOfBirth = 'sjsèéêdY';
        $member->setPlaceOfBirth($placeOfBirth);
        $this->assertNotEmpty($member->getPlaceOfBirth(), '');
    }

    //Test unitaire sur setMemberPair
    public function testSetMemberPairInstanceOf() {
        $member = new Member();
        $member->setMemberPair($member);
        $this->assertInstanceOf(Member::class, $member->getMemberPair());
    }

    //Test unitaire sur setProfession
    public function testsetProfessionWithRegex() {
        $member = new Member();
        $profession = 'djsjd-ejjdéèUY';
        $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';
        $member->setProfession($profession);
        $this->assertMatchesRegularExpression($pattern, $member->getProfession());
    }

    public function testsetProfessionWithNumber() {
        $this->expectException(ExceptionPerso::class);
        $member = new Member();
        $profession = 426;
        $member->setProfession($profession);
    }

    public function testsetProfessionWithSpecialCharacter() {
        $this->expectException(ExceptionPerso::class);
        $member = new Member();
        $profession = '?"/!';
        $member->setProfession($profession);
    }

    public function testNotMatchProfessionRegex() {
        $this->expectException(ExceptionPerso::class);
        $member = new Member();
        $profession = 'hdjjj-Gl56Msjjs';
        $member->setProfession($profession);
    }

    //Test unitaire sur setFamilySituation
    public function testsetFamilySituationWithRegex() {
        $member = new Member();
        $familySituation = 'djsjd-ejjdéèUY';
        $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';
        $member->setFamilySituation($familySituation);
        $this->assertMatchesRegularExpression($pattern, $member->getFamilySituation());
    }

    public function testsetFamilySituationWithNumber() {
        $this->expectException(ExceptionPerso::class);
        $member = new Member();
        $familySituation = 426;
        $member->setFamilySituation($familySituation);
    }

    public function testsetFamilySituationWithSpecialCharacter() {
        $this->expectException(ExceptionPerso::class);
        $member = new Member();
        $familySituation = '?"/!';
        $member->setFamilySituation($familySituation);
    }

    public function testNotMatchFamilySituationRegex() {
        $this->expectException(ExceptionPerso::class);
        $member = new Member();
        $familySituation = 'hdjjj-Gl56Msjjs';
        $member->setFamilySituation($familySituation);
    }

    //Test unitaire sur setCafNumber
    public function testsetCafNumberWithRegex() {
        $member = new Member();
        $cafNumber = '7310438 12';
        $pattern = '/^\d{7}\s\d{2}$/';
        $member->setCafNumber($cafNumber);
        $this->assertMatchesRegularExpression($pattern, $member->getCafNumber());
    }

    public function testsetCafNumberWithNumber() {
        $this->expectException(ExceptionPerso::class);
        $member = new Member();
        $cafNumber = 426;
        $member->setCafNumber($cafNumber);
    }

    public function testsetCafNumberWithSpecialCharacter() {
        $this->expectException(ExceptionPerso::class);
        $member = new Member();
        $cafNumber = '?"/!';
        $member->setCafNumber($cafNumber);
    }

    public function testNotMatchCafNumberRegex() {
        $this->expectException(ExceptionPerso::class);
        $member = new Member();
        $cafNumber = 'hdjjj-Gl56Msjjs';
        $member->setCafNumber($cafNumber);
    }
    
    public function testsetCafNumberIsNotEmpty() {
        $member = new Member();
        $name = '7310438 12';
        $member->setCafNumber($name);
        $this->assertNotEmpty($member->getCafNumber(), '');
    }
}