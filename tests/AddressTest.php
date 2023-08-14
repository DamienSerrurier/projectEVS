<?php

require_once '../../models/entities/RegexTester.php';
require_once '../../models/entities/Address.php';

use ProjectEvs\ExceptionPerso;
use ProjectEvs\Address;

class AddressTest extends PHPUnit\Framework\TestCase {

    //Test unitaire sur setId
    public function testSetIdWithFilter() {
        $address = new Address();
        $id = 1;
        $badNumber = 0;
        $this->assertGreaterThan($badNumber, $id);
        $address->setId($id);
        $this->assertSame(filter_var($address->getid(), FILTER_VALIDATE_INT), $address->getid());
    }

    public function testSetIdNotMatchingWithFilter() {
        $this->expectException(ExceptionPerso::class);
        $address = new Address();
        $minNuber = 1;
        $id = -356;
        $this->assertLessThan($minNuber, $id);
        $address->setId($id);
    }

    //Test unitaire sur setStreetNumber
    public function testSetStreetNumberWithRegex() {
        $address = new Address();
        $streetNumber = '22 Ter';
        $pattern = '/^\d+\s?[a-zA-Z\s]*$/';
        $this->assertMatchesRegularExpression($pattern, $address->setStreetNumber($streetNumber));
    }

    public function testSetStreetNumberWithSpecialCharacter() {
        $this->expectException(ExceptionPerso::class);
        $address = new Address();
        $streetNumber = '?"/!';
        $address->setStreetNumber($streetNumber);
    }

    public function testSetStreetNumberNotMatchRegex() {
        $this->expectException(ExceptionPerso::class);
        $address = new Address();
        $streetNumber = 'hdjjj-Gl56Msjjs';
        $address->setStreetNumber($streetNumber);
    }

    //Test unitaire sur setStreetName
    public function testsetStreetNameWithRegex() {
        $address = new Address();
        $streetName = 'djsjd-ejjdéèUY';
        $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';
        $this->assertMatchesRegularExpression($pattern, $address->setStreetName($streetName));
    }

    public function testsetStreetNameWithNumber() {
        $this->expectException(ExceptionPerso::class);
        $address = new Address();
        $streetName = 426;
        $address->setStreetName($streetName);
    }

    public function testsetStreetNameWithSpecialCharacter() {
        $this->expectException(ExceptionPerso::class);
        $address = new Address();
        $streetName = '?"/!';
        $address->setStreetName($streetName);
    }

    public function testNotMatchstreetNameRegex() {
        $this->expectException(ExceptionPerso::class);
        $address = new Address();
        $streetName = 'hdjjj-Gl56Msjjs';
        $address->setStreetName($streetName);
    }

    public function testsetStreetNameIsNotEmpty() {
        $address = new Address();
        $streetName = 'sjsèéêdY';
        $this->assertNotEmpty($address->setStreetName($streetName, ''));
    }

    //Test unitaire sur setStreetComplement
    public function testsetStreetComplementWithRegex() {
        $address = new Address();
        $streetComplement = 'appatement porte 822G';
        $pattern = '/^[\w\s-]*$/';
        $this->assertMatchesRegularExpression($pattern, $address->setStreetComplement($streetComplement));
    }

    public function testsetStreetComplementWithSpecialCharacter() {
        $this->expectException(ExceptionPerso::class);
        $address = new Address();
        $streetComplement = '?"/!';
        $address->setStreetComplement($streetComplement);
    }

    public function testNotMatchStreetComplementRegex() {
        $this->expectException(ExceptionPerso::class);
        $address = new Address();
        $streetComplement = '3hhsj???';
        $address->setStreetComplement($streetComplement);
    }

    //Test unitaire sur setCode
    public function testsetCodeWithRegex() {
        $address = new Address();
        $code = '27643';
        $pattern = '/^\d{5}$/';
        $this->assertMatchesRegularExpression($pattern, $address->setCode($code));
    }

    public function testsetCodeWithSpecialCharacter() {
        $this->expectException(ExceptionPerso::class);
        $address = new Address();
        $code = '?"/!';
        $address->setCode($code);
    }

    public function testNotMatchCodeRegex() {
        $this->expectException(ExceptionPerso::class);
        $address = new Address();
        $code = 'hdjjj-Gl56Msjjs';
        $address->setCode($code);
    }

    public function testsetCodeIsNotEmpty() {
        $address = new Address();
        $code = '22249';
        $this->assertNotEmpty($address->setCode($code, ''));
    }

    //Test unitaire sur setName
    public function testsetNameWithRegex() {
        $address = new Address();
        $name = 'djsjd-ejjdéèUY';
        $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';
        $this->assertMatchesRegularExpression($pattern, $address->setName($name));
    }

    public function testsetNameWithNumber() {
        $this->expectException(ExceptionPerso::class);
        $address = new Address();
        $name = 426;
        $address->setName($name);
    }

    public function testsetNameWithSpecialCharacter() {
        $this->expectException(ExceptionPerso::class);
        $address = new Address();
        $name = '?"/!';
        $address->setName($name);
    }

    public function testNotMatchNameRegex() {
        $this->expectException(ExceptionPerso::class);
        $address = new Address();
        $name = 'hdjjj-Gl56Msjjs';
        $address->setName($name);
    }

    public function testsetNameIsNotEmpty() {
        $address = new Address();
        $name = 'sjsèéêdY';
        $this->assertNotEmpty($address->setName($name, ''));
    }
}