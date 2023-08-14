<?php

require_once '../../models/entities/RegexTester.php';
require_once '../../models/entities/Category.php';

use ProjectEvs\ExceptionPerso;
use ProjectEvs\Category;

class CategoryTest extends PHPUnit\Framework\TestCase {

    //Test unitaire sur setId
    public function testSetIdWithFilter() {
        $category = new Category();
        $id = 1;
        $badNumber = 0;
        $this->assertGreaterThan($badNumber, $id);
        $category->setId($id);
        $this->assertSame(filter_var($category->getid(), FILTER_VALIDATE_INT), $category->getid());
    }

    public function testSetIdNotMatchingWithFilter() {
        $this->expectException(ExceptionPerso::class);
        $category = new Category();
        $minNuber = 1;
        $id = -356;
        $this->assertLessThan($minNuber, $id);
        $category->setId($id);
    }

    //Test unitaire sur setName
    public function testSetNameWithRegex() {
        $category = new Category();
        $name = 'djsjd-ejjdéèUY';
        $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';
        $this->assertMatchesRegularExpression($pattern, $category->setName($name));
    }

    public function testSetNameWithNumber() {
        $this->expectException(ExceptionPerso::class);
        $category = new Category();
        $name = 426;
        $category->setName($name);
    }

    public function testSetNameWithSpecialCharacter() {
        $this->expectException(ExceptionPerso::class);
        $category = new Category();
        $name = '?"/!';
        $category->setName($name);
    }

    public function testNotMatchNameRegex() {
        $this->expectException(ExceptionPerso::class);
        $category = new Category();
        $name = 'hdjjj-Gl56Msjjs';
        $category->setName($name);
    }

    public function testSetNameIsNotEmpty() {
        $category = new Category();
        $name = 'sjsèéêdY';
        $this->assertNotEmpty($category->setName($name, ''));
    }
}