<?php

require_once '../../models/entities/Role.php';

use ProjectEvs\ExceptionPerso;
use ProjectEvs\Role;

class RoleTest extends PHPUnit\Framework\TestCase {

    //Test unitaire sur setId
    public function testSetIdWithFilter() {
        $role = new Role();
        $id = 1;
        $badNumber = 0;
        $this->assertGreaterThan($badNumber, $id);
        $role->setId($id);
        $this->assertSame(filter_var($role->getid(), FILTER_VALIDATE_INT), $role->getid());
    }

    public function testSetIdNotMatchingWithFilter() {
        $this->expectException(ExceptionPerso::class);
        $role = new Role();
        $minNuber = 1;
        $id = -356;
        $this->assertLessThan($minNuber, $id);
        $role->setId($id);
    }

    //Test unitaire sur setName
    public function testSetNameWithRegex() {
        $role = new Role();
        $name = 'djsjd-ejjdéèUY';
        $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';
        $this->assertMatchesRegularExpression($pattern, $role->setName($name));
    }

    public function testSetNameWithNumber() {
        $this->expectException(ExceptionPerso::class);
        $role = new Role();
        $name = 426;
        $role->setName($name);
    }

    public function testSetNameWithSpecialCharacter() {
        $this->expectException(ExceptionPerso::class);
        $role = new Role();
        $name = '?"/!';
        $role->setName($name);
    }

    public function testNotMatchNameRegex() {
        $this->expectException(ExceptionPerso::class);
        $role = new Role();
        $name = 'hdjjj-Gl56Msjjs';
        $role->setName($name);
    }

    public function testSetNameIsNotEmpty() {
        $role = new Role();
        $name = 'sjsèéêdY';
        $this->assertNotEmpty($role->setName($name, ''));
    }
}
