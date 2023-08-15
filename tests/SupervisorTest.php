<?php

require_once '../../models/entities/Supervisor.php';

use ProjectEvs\ExceptionPerso;
use ProjectEvs\Supervisor;
use ProjectEvs\Structure;
use ProjectEvs\Member;

class SupervisorTest extends PHPUnit\Framework\TestCase {

    //Test unitaire sur setId
    public function testSetIdWithFilter() {
        $supervisor = new Supervisor();
        $id = 1;
        $badNumber = 0;
        $this->assertGreaterThan($badNumber, $id);
        $supervisor->setId($id);
        $this->assertSame(filter_var($supervisor->getid(), FILTER_VALIDATE_INT), $supervisor->getid());
    }

    public function testSetIdNotMatchingWithFilter() {
        $this->expectException(ExceptionPerso::class);
        $supervisor = new Supervisor();
        $minNuber = 1;
        $id = -356;
        $this->assertLessThan($minNuber, $id);
        $supervisor->setId($id);
    }

    //Test unitaire sur setSchool
    public function testSetSchoolWithRegex() {
        $supervisor = new Supervisor();
        $school = 'djsjd-ejjdéèUY';
        $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';
        $this->assertMatchesRegularExpression($pattern, $supervisor->setSchool($school));
    }

    public function testSetSchoolWithNumber() {
        $this->expectException(ExceptionPerso::class);
        $supervisor = new Supervisor();
        $school = 426;
        $supervisor->setSchool($school);
    }

    public function testSetSchoolWithSpecialCharacter() {
        $this->expectException(ExceptionPerso::class);
        $supervisor = new Supervisor();
        $school = '?"/!';
        $supervisor->setSchool($school);
    }

    public function testNotMatchSchoolRegex() {
        $this->expectException(ExceptionPerso::class);
        $supervisor = new Supervisor();
        $school = 'hdjjj-Gl56Msjjs';
        $supervisor->setSchool($school);
    }

    public function testSetSchoolIsNotEmpty() {
        $supervisor = new Supervisor();
        $school = 'sjsèéêdY';
        $this->assertNotEmpty($supervisor->setSchool($school, ''));
    }

    //Test unitaire sur setSchoolCity
    public function testSetSchoolCityWithRegex() {
        $supervisor = new Supervisor();
        $schoolCity = 'djsjd-ejjdéèUY';
        $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';
        $this->assertMatchesRegularExpression($pattern, $supervisor->setSchoolCity($schoolCity));
    }

    public function testSetSchoolCityWithNumber() {
        $this->expectException(ExceptionPerso::class);
        $supervisor = new Supervisor();
        $schoolCity = 426;
        $supervisor->setSchoolCity($schoolCity);
    }

    public function testSetSchoolCityWithSpecialCharacter() {
        $this->expectException(ExceptionPerso::class);
        $supervisor = new Supervisor();
        $schoolCity = '?"/!';
        $supervisor->setSchoolCity($schoolCity);
    }

    public function testNotMatchSchoolCityRegex() {
        $this->expectException(ExceptionPerso::class);
        $supervisor = new Supervisor();
        $schoolCity = 'hdjjj-Gl56Msjjs';
        $supervisor->setSchoolCity($schoolCity);
    }

    public function testSetSchoolCityIsNotEmpty() {
        $supervisor = new Supervisor();
        $schoolCity = 'sjsèéêdY';
        $this->assertNotEmpty($supervisor->setSchoolCity($schoolCity, ''));
    }

    //Test unitaire sur setStructure
    public function testSetStructureInstanceOf() {
        $supervisor = new Supervisor();
        $structure = new Structure();
        $supervisor->setStructure($structure);
        $this->assertInstanceOf(Structure::class, $supervisor->getStructure());
    }

    //Test unitaire sur setMemberResponsible
    public function testSetMemberResponsibleInstanceOf() {
        $supervisor = new Supervisor();
        $memberResponsible = new Member();
        $supervisor->setMemberResponsible($memberResponsible);
        $this->assertInstanceOf(Member::class, $supervisor->getMemberResponsible());
    }

    //Test unitaire sur setMemberNotResponsible
    public function testSetMemberNotResponsibleInstanceOf() {
        $supervisor = new Supervisor();
        $memberNotResponsible = new Member();
        $supervisor->setMemberNotResponsible($memberNotResponsible);
        $this->assertInstanceOf(Member::class, $supervisor->getMemberNotResponsible());
    }
}