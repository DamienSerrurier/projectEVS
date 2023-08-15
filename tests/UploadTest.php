<?php

require_once '../../models/entities/Upload.php';

use ProjectEvs\ExceptionPerso;
use ProjectEvs\Upload;
use ProjectEvs\Person;
use ProjectEvs\Document;


class UploadTest extends PHPUnit\Framework\TestCase {

    //Test unitaire sur setPerson
    public function testSetPersonInstanceOf() {
        $upload = new Upload();
        $Person = new Person();
        $upload->setPerson($Person);
        $this->assertInstanceOf(Person::class, $upload->getPerson());
    }

    //Test unitaire sur setAddress
    public function testSetAddressInstanceOf() {
        $upload = new Upload();
        $document = new Document();
        $upload->setDocument($document);
        $this->assertInstanceOf(Document::class, $upload->getDocument());
    }
}