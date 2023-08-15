<?php

require_once '../../models/entities/Structure.php';
require_once '../../models/entities/TypeStructure.php';

use ProjectEvs\ExceptionPerso;
use ProjectEvs\Structure;
use ProjectEvs\TypeStructure;
use ProjectEvs\Address;

class StructureTest extends PHPUnit\Framework\TestCase {

    //Test unitaire sur setId
    public function testSetIdWithFilter() {
        $structure = new Structure();
        $id = 1;
        $badNumber = 0;
        $this->assertGreaterThan($badNumber, $id);
        $structure->setId($id);
        $this->assertSame(filter_var($structure->getid(), FILTER_VALIDATE_INT), $structure->getid());
    }

    public function testSetIdNotMatchingWithFilter() {
        $this->expectException(ExceptionPerso::class);
        $structure = new Structure();
        $id = -356;
        $structure->setId($id);
    }

    //Test unitaire sur setName
    public function testSetNameWithRegex() {
        $structure = new Structure();
        $name = 'djsjd-ejjdéèUY';
        $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';
        $this->assertMatchesRegularExpression($pattern, $structure->setName($name));
    }

    public function testSetNameWithNumber() {
        $this->expectException(ExceptionPerso::class);
        $structure = new Structure();
        $name = 426;
        $structure->setName($name);
    }

    public function testSetNameWithSpecialCharacter() {
        $this->expectException(ExceptionPerso::class);
        $structure = new Structure();
        $name = '?"/!';
        $structure->setName($name);
    }

    public function testNotMatchNameRegex() {
        $this->expectException(ExceptionPerso::class);
        $structure = new Structure();
        $name = 'hdjjj-Gl56Msjjs';
        $structure->setName($name);
    }

    public function testSetNameIsNotEmpty() {
        $structure = new Structure();
        $name = 'sjsèéêdY';
        $this->assertNotEmpty($structure->setName($name, ''));
    }

    //Test unitaire sur setLogo
    private static function simulateFileUpload (
        $name,
        $tmpName,
        $error 
    ) {
        $_FILES['userfile'] = [
            'name'     => $name,
            'tmp_name' => $tmpName,
            'error'    => $error,
        ];
    }

    public function testSetLogoErrorAuther() {
        $this->expectException(ExceptionPerso::class);
        $this->simulateFileUpload('invalidFile.txt', '../../assets/test/', UPLOAD_ERR_FORM_SIZE);
        $structure = new Structure();
        $error = 0;
        $fileError = $_FILES['userfile']['error'];
        $file = $_FILES['userfile']['name'];
        $this->assertNotEquals($error, $fileError);
        $structure->setLogo($file);
    }

    public function testSetLogoErrorEqualZero() {
        $this->simulateFileUpload('logoCaf.png', '../../assets/test/', UPLOAD_ERR_OK);
        $structure = new Structure();
        $error = 0;
        $fileError = $_FILES['userfile']['error'];
        $file = $_FILES['userfile']['name'];
        $this->assertEquals($error, $fileError);
        $structure->setLogo($file);
    }

    public function testSetLogoMimeType() {
        $structure = new Structure();
        $path = '../../assets/test/';
        $file = 'logoCaf.png';
        $expectedMimeContentType = ['image/png', 'image/jpeg'];
        $mimeType = mime_content_type($path . $file);
        $structure->setLogo($file);
        $this->assertTrue(in_array($mimeType, $expectedMimeContentType));
    }

    public function testSetLogoBadMimeType() {
        $this->expectException(ExceptionPerso::class);
        $structure = new Structure();
        $file = 'invalidFile.txt';
        $structure->setLogo($file);
    }

    public function testSetLogoDimensions() {
        $structure = new Structure();
        $maxWidth = 1000;
        $maxHeight = 1000;
        $path = '../../assets/test/';
        $file = 'logoCaf.png';
        list($width, $height) = getimagesize($path . $file);
        $this->assertLessThanOrEqual($maxWidth, $width);
        $this->assertLessThanOrEqual($maxHeight, $height);
        $structure->setLogo($file);
    }

    public function testSetLogoBadDimension() {
        $this->expectException(ExceptionPerso::class);
        $structure = new Structure();
        $maxWidth = 1000;
        $maxHeight = 1000;
        $path = '../../assets/test/';
        $file = 'iconCoffee.jpg';
        list($width, $height) = getimagesize($path . $file);
        $this->assertGreaterThan($maxWidth, $width);
        $this->assertGreaterThan($maxHeight, $height);
        $structure->setLogo($file);
    }

    public function testSetLogoSize() {
        $structure = new Structure();
        $maxSize = 10000;
        $path = '../../assets/test/';
        $file = 'logoCaf.png';
        $fileSize = filesize($path . $file);
        $this->assertLessThanOrEqual($maxSize, $fileSize);
        $structure->setLogo($file);
    }

    public function testSetLogoBadSize() {
        $this->expectException(ExceptionPerso::class);
        $structure = new Structure();
        $maxSize = 10000;
        $path = '../../assets/test/';
        $file = 'iconCoffee.jpg';
        $fileSize = filesize($path . $file);
        $this->assertGreaterThan($maxSize, $fileSize);
        $structure->setLogo($file);
    }

    //Test unitaire sur setPhone
    public function testSetPhoneWithRegex() {
        $structure = new Structure();
        $phone = '05 56 23 07 51';
        $pattern = '/^[0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2}$/';
        $this->assertMatchesRegularExpression($pattern, $structure->setPhone($phone));
    }

    public function testSetPhoneWithNumber() {
        $this->expectException(ExceptionPerso::class);
        $structure = new Structure();
        $phone = 426;
        $structure->setPhone($phone);
    }

    public function testSetPhoneWithSpecialCharacter() {
        $this->expectException(ExceptionPerso::class);
        $structure = new Structure();
        $phone = '?"/!';
        $structure->setPhone($phone);
    }

    public function testNotMatchPhoneRegex() {
        $this->expectException(ExceptionPerso::class);
        $structure = new Structure();
        $phone = 'hdjjj-Gl56Msjjs';
        $structure->setPhone($phone);
    }

    public function testSetPhoneIsNotEmpty() {
        $structure = new Structure();
        $name = '05 56 23 07 51';
        $this->assertNotEmpty($structure->setPhone($name, ''));
    }

    //Test unitaire sur setTypeStructure
    public function testSetTypeStructureInstanceOf() {
        $structure = new Structure();
        $typeStructure = new TypeStructure();
        $structure->setTypeStructure($typeStructure);
        $this->assertInstanceOf(TypeStructure::class, $structure->getTypeStructure());
    }

    //Test unitaire sur setAddress
    public function testSetAddressInstanceOf() {
        $structure = new Structure();
        $address = new Address();
        $structure->setAddress($address);
        $this->assertInstanceOf(Address::class, $structure->getAddress());
    }
}