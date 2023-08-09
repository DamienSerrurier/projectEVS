<?php

require_once '../../models/entities/Person.php';

use ProjectEvs\Person;

class PersonTest extends PHPUnit\Framework\TestCase {

    public function testSetLastname() {
        $person = new Person();
        $lastname = 'djsjd-ejjdéèUY';
        $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';
        $this->assertMatchesRegularExpression($pattern, $person->setLastname($lastname));
    }

    public function testSetLastnameIsNotEmpty() {
        $person = new Person();
        $lastname = 'sjsèéêdY';
        $this->assertNotEmpty($person->setLastname($lastname, ''));
    }
}