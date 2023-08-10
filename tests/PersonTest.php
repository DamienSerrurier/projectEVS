<?php

require_once '../../models/entities/RegexTester.php';
require_once '../../models/entities/Person.php';
require_once '../../models/entities/Civility.php';
require_once '../../models/entities/Avatar.php';
require_once '../../models/entities/Address.php';
require_once '../../models/entities/Role.php';

use ProjectEvs\Address;
use ProjectEvs\Avatar;
use ProjectEvs\ExceptionPerso;
use ProjectEvs\Person;
use ProjectEvs\Civility;
use ProjectEvs\Role;

//Tests unitaires pour la classe Person
class PersonTest extends PHPUnit\Framework\TestCase {

    //Test unitaire sur setId
    public function testSetIdWithFilter() {
        $person = new Person();
        $id = 1;
        $person->setId($id);
        if ($id > 0) {
            $this->assertSame(filter_var($person->getid(), FILTER_VALIDATE_INT), $person->getid());
        }
    }

    public function testSetIdNotMatchingWithFilter() {
        $this->expectException(ExceptionPerso::class);
        $person = new Person();
        $id = -356;
        $person->setId($id);
    }

    //Test unitaire sur setLastname
    public function testSetLastnameWithRegex() {
        $person = new Person();
        $lastname = 'djsjd-ejjdéèUY';
        $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';
        $this->assertMatchesRegularExpression($pattern, $person->setLastname($lastname));
    }

    public function testSetLastnameWithNumber() {
        $this->expectException(ExceptionPerso::class);
        $person = new Person();
        $lastname = 426;
        $person->setLastname($lastname);
    }

    public function testSetLastnameWithSpecialCharacter() {
        $this->expectException(ExceptionPerso::class);
        $person = new Person();
        $lastname = '?"/!';
        $person->setLastname($lastname);
    }

    public function testNotMatchLastnameRegex() {
        $this->expectException(ExceptionPerso::class);
        $person = new Person();
        $lastname = 'hdjjj-Gl56Msjjs';
        $person->setLastname($lastname);
    }

    public function testSetLastnameIsNotEmpty() {
        $person = new Person();
        $lastname = 'sjsèéêdY';
        $this->assertNotEmpty($person->setLastname($lastname, ''));
    }

    //Test unitaire sur setFirstname
    public function testSetFirstnameWithRegex() {
        $person = new Person();
        $firstname = 'djsjd-ej-éèUY';
        $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';
        $this->assertMatchesRegularExpression($pattern, $person->setFirstname($firstname));
    }

    public function testSetFirstnameWithNumber() {
        $this->expectException(ExceptionPerso::class);
        $person = new Person();
        $firstname = 426;
        $person->setFirstname($firstname);
    }

    public function testSetFirstnameWithSpecialCharacter() {
        $this->expectException(ExceptionPerso::class);
        $person = new Person();
        $firstname = '?"/!';
        $person->setFirstname($firstname);
    }

    public function testNotMatchFirstnameRegex() {
        $this->expectException(ExceptionPerso::class);
        $person = new Person();
        $firstname = 'hdjjj-Gl56Msjjs';
        $person->setFirstname($firstname);
    }

    public function testSetFirstnameIsNotEmpty() {
        $person = new Person();
        $firstname = 'sjsèéêdY';
        $this->assertNotEmpty($person->setFirstname($firstname, ''));
    }

    //Test unitaire sur setPhone
    public function testSetPhoneWithRegex() {
        $person = new Person();
        $phone = '05 56 23 07 51';
        $pattern = '/^[0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2}$/';
        $this->assertMatchesRegularExpression($pattern, $person->setPhone($phone));
    }

    public function testSetPhoneWithNumber() {
        $this->expectException(ExceptionPerso::class);
        $person = new Person();
        $phone = 426;
        $person->setPhone($phone);
    }

    public function testSetPhoneWithSpecialCharacter() {
        $this->expectException(ExceptionPerso::class);
        $person = new Person();
        $phone = '?"/!';
        $person->setPhone($phone);
    }

    public function testNotMatchPhoneRegex() {
        $this->expectException(ExceptionPerso::class);
        $person = new Person();
        $phone = 'hdjjj-Gl56Msjjs';
        $person->setPhone($phone);
    }
    
    //Test unitaire sur setCivility
    public function testSetCivilityInstanceOf() {
        $person = new Person();
        $civility = new Civility();
        $person->setCivility($civility);
        $this->assertInstanceOf(Civility::class, $person->getCivility());
    }

    public function testSetCivilityNotIntanceOf() {
        $person = new Person();
        $civility = new Civility();
        $person->setCivility($civility);
        $this->assertNotInstanceOf(Person::class, $person->getCivility());
    }

    //Test unitaire sur setAvatar
    public function testSetAvatarInstanceOf() {
        $person = new Person();
        $avatar = new Avatar();
        $person->setAvatar($avatar);
        $this->assertInstanceOf(Avatar::class, $person->getAvatar());
    }

    public function testSetAvatarNotIntanceOf() {
        $person = new Person();
        $avatar = new Avatar();
        $person->setAvatar($avatar);
        $this->assertNotInstanceOf(Person::class, $person->getAvatar());
    }

    //Test unitaire sur setEmail
    public function testSetEmailWithFilter() {
        $person = new Person();
        $email = 'dom@dom.fr';
        $person->setEmail($email);
        $this->assertSame(filter_var($person->getEmail(), FILTER_VALIDATE_EMAIL), $person->getEmail());
    }

    public function testSetEmailWithNumber() {
        $this->expectException(ExceptionPerso::class);
        $person = new Person();
        $email = 426;
        $person->setEmail($email);
    }

    public function testSetEmailWithSpecialCharacter() {
        $this->expectException(ExceptionPerso::class);
        $person = new Person();
        $email = '?"/!';
        $person->setEmail($email);
    }

    public function testSetEmailIsNotEmpty() {
        $person = new Person();
        $email = 'din@din.com';
        $this->assertNotEmpty($person->setEmail($email, ''));
    }

    //Test unitaire sur setPassword
    public function testSetPasswordWithRegex() {
        $person = new Person();
        $password = 'hd1e2ZR?';
        $pattern = '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/';
        $this->assertMatchesRegularExpression($pattern, $person->setPassword($password));
        $this->assertTrue(password_verify($password, $person->getPassword()), $person->getPassword());
    }

    public function testSetPasswordIsNotEmpty() {
        $person = new Person();
        $password = 'hda2ZR#f';
        $this->assertNotEmpty($person->setPassword($password, ''));
    }

    public function testNotMatchPasswordRegex() {
        $this->expectException(ExceptionPerso::class);
        $person = new Person();
        $password = 'gdej5';
        $person->setPassword($password);
    }

    //Test unitaire sur setAddress
    public function testSetAddressInstanceOf() {
        $person = new Person();
        $address = new Address();
        $person->setAddress($address);
        $this->assertInstanceOf(Address::class, $person->getAddress());
    }

    public function testSetAddressNotIntanceOf() {
        $person = new Person();
        $address = new Address();
        $person->setAddress($address);
        $this->assertNotInstanceOf(Person::class, $person->getAddress());
    }

    //Test unitaire sur setRole
    public function testSetRoleInstanceOf() {
        $person = new Person();
        $role = new Role();
        $person->setRole($role);
        $this->assertInstanceOf(Role::class, $person->getRole());
    }

    public function testSetRoleNotIntanceOf() {
        $person = new Person();
        $role = new Role();
        $person->setRole($role);
        $this->assertNotInstanceOf(Person::class, $person->getRole());
    }
}