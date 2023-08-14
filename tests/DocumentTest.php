<?php

require_once '../../utility/exceptions/ExceptionPerso.php';
require_once '../../models/entities/Document.php';
require_once '../../models/entities/Structure.php';

use ProjectEvs\ExceptionPerso;
use ProjectEvs\Document;
use ProjectEvs\Structure;

class DocumentTest extends PHPUnit\Framework\TestCase {

    //Test unitaire sur setId
    public function testSetIdWithFilter() {
        $document = new Document();
        $id = 1;
        $badNumber = 0;
        $this->assertGreaterThan($badNumber, $id);
        $document->setId($id);
        $this->assertSame(filter_var($document->getid(), FILTER_VALIDATE_INT), $document->getid());
    }

    public function testSetIdNotMatchingWithFilter() {
        $this->expectException(ExceptionPerso::class);
        $document = new Document();
        $id = -356;
        $document->setId($id);
    }

    //Test unitaire sur setName
    public function testSetNameWithRegex() {
        $document = new Document();
        $name = 'djsjd-ejjdéèUY';
        $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';
        $this->assertMatchesRegularExpression($pattern, $document->setName($name));
    }

    public function testSetNameWithNumber() {
        $this->expectException(ExceptionPerso::class);
        $document = new Document();
        $name = 426;
        $document->setName($name);
    }

    public function testSetNameWithSpecialCharacter() {
        $this->expectException(ExceptionPerso::class);
        $document = new Document();
        $name = '?"/!';
        $document->setName($name);
    }

    public function testNotMatchNameRegex() {
        $this->expectException(ExceptionPerso::class);
        $document = new Document();
        $name = 'hdjjj-Gl56Msjjs';
        $document->setName($name);
    }

    public function testSetNameIsNotEmpty() {
        $document = new Document();
        $name = 'sjsèéêdY';
        $this->assertNotEmpty($document->setName($name, ''));
    }

    //Test unitaire sur setLink
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

    public function testSetLinkErrorAuther() {
        $this->expectException(ExceptionPerso::class);
        $this->simulateFileUpload('invalidFile.txt', '../../assets/test/', UPLOAD_ERR_CANT_WRITE);
        $document = new Document();
        $error = 0;
        $fileError = $_FILES['userfile']['error'];
        $file = $_FILES['userfile']['name'];
        $this->assertNotEquals($error, $fileError);
        $document->setLink($file);
    }

    public function testSetLinkErrorEqualZero() {
        $this->simulateFileUpload('invalidFile.txt', '../../assets/test/', UPLOAD_ERR_OK);
        $document = new Document();
        $error = 0;
        $fileError = $_FILES['userfile']['error'];
        $file = $_FILES['userfile']['name'];
        $this->assertEquals($error, $fileError);
        $document->setLink($file);
    }

    public function testSetLinkMimeType() {
        $document = new Document();
        $path = '../../assets/test/';
        $file = 'invalidFile.txt';
        $expectedMimeContentType = ['text/plain', 'application/pdf'];
        $mimeType = mime_content_type($path . $file);
        $document->setLink($file);
        $this->assertEquals(in_array($mimeType, $expectedMimeContentType), $mimeType);
    }

    public function testSetLinkBadMimeType() {
        $this->expectException(ExceptionPerso::class);
        $document = new Document();
        $file = 'iconCoffee.jpg';
        $document->setLink($file);
    }

    //Test unitaire sur setStructure
    public function testSetStructureInstanceOf() {
        $document = new Document();
        $structure = new Structure();
        $document->setStructure($structure);
        $this->assertInstanceOf(Structure::class, $document->getStructure());
    }
}