<?php

require_once '../../models/entities/RegexTester.php';
require_once '../../models/entities/Civility.php';

use ProjectEvs\ExceptionPerso;
use ProjectEvs\Civility;

class CivilityTest extends PHPUnit\Framework\TestCase {

    //Test unitaire sur setId
    public function testSetIdWithFilter() {
        $civility = new Civility();
        $id = 1;
        $badNumber = 0;
        $this->assertGreaterThan($badNumber, $id);
        $civility->setId($id);
        $this->assertSame(filter_var($civility->getid(), FILTER_VALIDATE_INT), $civility->getid());
    }

    public function testSetIdNotMatchingWithFilter() {
        $this->expectException(ExceptionPerso::class);
        $civility = new Civility();
        $minNuber = 1;
        $id = -356;
        $this->assertLessThan($minNuber, $id);
        $civility->setId($id);
    }

    //Test unitaire sur setName
    public function testSetNameWithRegex() {
        $civility = new Civility();
        $name = 'djsjd-ejjdéèUY';
        $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';
        $civility->setName($name);
        $this->assertMatchesRegularExpression($pattern, $civility->getName());
    }

    public function testSetNameWithNumber() {
        $this->expectException(ExceptionPerso::class);
        $civility = new Civility();
        $name = 426;
        $civility->setName($name);
    }

    public function testSetNameWithSpecialCharacter() {
        $this->expectException(ExceptionPerso::class);
        $civility = new Civility();
        $name = '?"/!';
        $civility->setName($name);
    }

    public function testNotMatchNameRegex() {
        $this->expectException(ExceptionPerso::class);
        $civility = new Civility();
        $name = 'hdjjj-Gl56Msjjs';
        $civility->setName($name);
    }

    public function testSetNameIsNotEmpty() {
        $civility = new Civility();
        $name = 'sjsèéêdY';
        $civility->setName($name);
        $this->assertNotEmpty($civility->getName(), '');
    }
}