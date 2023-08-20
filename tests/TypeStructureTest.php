<?php

require_once '../../models/entities/TypeStructure.php';

use ProjectEvs\ExceptionPerso;
use ProjectEvs\TypeStructure;

class TypeStructureTest extends PHPUnit\Framework\TestCase {

    //Test unitaire sur setId
    public function testSetIdWithFilter() {
        $typeStructure = new TypeStructure();
        $id = 1;
        $badNumber = 0;
        $this->assertGreaterThan($badNumber, $id);
        $typeStructure->setId($id);
        $this->assertSame(filter_var($typeStructure->getid(), FILTER_VALIDATE_INT), $typeStructure->getid());
    }

    public function testSetIdNotMatchingWithFilter() {
        $this->expectException(ExceptionPerso::class);
        $typeStructure = new TypeStructure();
        $minNuber = 1;
        $id = -356;
        $this->assertLessThan($minNuber, $id);
        $typeStructure->setId($id);
    }

    //Test unitaire sur setWording
    public function testSetWordingWithRegex() {
        $typeStructure = new TypeStructure();
        $Wording = 'djsjd-ejjdéèUY';
        $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';
        $typeStructure->setWording($Wording);
        $this->assertMatchesRegularExpression($pattern, $typeStructure->getWording());
    }

    public function testSetWordingWithNumber() {
        $this->expectException(ExceptionPerso::class);
        $typeStructure = new TypeStructure();
        $Wording = 426;
        $typeStructure->setWording($Wording);
    }

    public function testSetWordingWithSpecialCharacter() {
        $this->expectException(ExceptionPerso::class);
        $typeStructure = new TypeStructure();
        $Wording = '?"/!';
        $typeStructure->setWording($Wording);
    }

    public function testNotMatchWordingRegex() {
        $this->expectException(ExceptionPerso::class);
        $typeStructure = new TypeStructure();
        $Wording = 'hdjjj-Gl56Msjjs';
        $typeStructure->setWording($Wording);
    }

    public function testSetWordingIsNotEmpty() {
        $typeStructure = new TypeStructure();
        $Wording = 'sjsèéêdY';
        $typeStructure->setWording($Wording);
        $this->assertNotEmpty($typeStructure->getWording(), '');
    }
}