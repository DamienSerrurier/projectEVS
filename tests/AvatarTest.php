<?php

require_once '../../models/entities/Avatar.php';

use ProjectEvs\ExceptionPerso;
use ProjectEvs\Avatar;

class AvatarTest extends PHPUnit\Framework\TestCase {

    //Test unitaire sur setId
    public function testSetIdWithFilter() {
        $avatar = new Avatar();
        $id = 1;
        $badNumber = 0;
        $this->assertGreaterThan($badNumber, $id);
        $avatar->setId($id);
        $this->assertSame(filter_var($avatar->getid(), FILTER_VALIDATE_INT), $avatar->getid());
    }

    public function testSetIdNotMatchingWithFilter() {
        $this->expectException(ExceptionPerso::class);
        $avatar = new Avatar();
        $minNuber = 1;
        $id = -356;
        $this->assertLessThan($minNuber, $id);
        $avatar->setId($id);
    }

    //Test unitaire sur setPicture
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

    public function testSetPictureErrorAuther() {
        $this->expectException(ExceptionPerso::class);
        $this->simulateFileUpload('invalidFile.txt', '../../assets/test/', UPLOAD_ERR_FORM_SIZE);
        $avatar = new Avatar();
        $error = 0;
        $fileError = $_FILES['userfile']['error'];
        $file = $_FILES['userfile']['name'];
        $this->assertNotEquals($error, $fileError);
        $avatar->setPicture($file);
    }

    public function testSetPictureErrorEqualZero() {
        $this->simulateFileUpload('logoCaf.png', '../../assets/test/', UPLOAD_ERR_OK);
        $avatar = new Avatar();
        $error = 0;
        $fileError = $_FILES['userfile']['error'];
        $file = $_FILES['userfile']['name'];
        $this->assertEquals($error, $fileError);
        $avatar->setPicture($file);
    }

    public function testSetPictureMimeType() {
        $avatar = new Avatar();
        $path = '../../assets/test/';
        $file = 'logoCaf.png';
        $expectedMimeContentType = ['image/png', 'image/jpeg'];
        $mimeType = mime_content_type($path . $file);
        $avatar->setPicture($file);
        $this->assertEquals(in_array($mimeType, $expectedMimeContentType), $mimeType);
    }

    public function testSetPictureBadMimeType() {
        $this->expectException(ExceptionPerso::class);
        $avatar = new Avatar();
        $file = 'invalidFile.txt';
        $avatar->setPicture($file);
    }

    public function testSetPictureDimensions() {
        $avatar = new Avatar();
        $maxWidth = 1000;
        $maxHeight = 1000;
        $path = '../../assets/test/';
        $file = 'logoCaf.png';
        list($width, $height) = getimagesize($path . $file);
        $this->assertLessThanOrEqual($maxWidth, $width);
        $this->assertLessThanOrEqual($maxHeight, $height);
        $avatar->setPicture($file);
    }

    public function testSetPictureBadDimension() {
        $this->expectException(ExceptionPerso::class);
        $avatar = new Avatar();
        $maxWidth = 1000;
        $maxHeight = 1000;
        $path = '../../assets/test/';
        $file = 'iconCoffee.jpg';
        list($width, $height) = getimagesize($path . $file);
        $this->assertGreaterThan($maxWidth, $width);
        $this->assertGreaterThan($maxHeight, $height);
        $avatar->setPicture($file);
    }

    public function testSetPictureSize() {
        $avatar = new Avatar();
        $maxSize = 10000;
        $path = '../../assets/test/';
        $file = 'logoCaf.png';
        $fileSize = filesize($path . $file);
        $this->assertLessThanOrEqual($maxSize, $fileSize);
        $avatar->setPicture($file);
    }

    public function testSetPictureBadSize() {
        $this->expectException(ExceptionPerso::class);
        $avatar = new Avatar();
        $maxSize = 10000;
        $path = '../../assets/test/';
        $file = 'iconCoffee.jpg';
        $fileSize = filesize($path . $file);
        $this->assertGreaterThan($maxSize, $fileSize);
        $avatar->setPicture($file);
    }
}