<?php

namespace ProjectEvs;

require_once '../../utility/exceptions/ExceptionPerso.php';

class Upload {

    //Propriétés
    private Person $person;
    private Document $document;
    private string $uploadDate;

    //Constructeur

    //Getters et Setters
    public function getPerson() : Person {
        return $this->person;
    }

    public function setPerson(Person $person) {

        if ($person instanceof Person) {
            return $this->person = $person;
        }
        else {
            throw new ExceptionPerso("Ceci n'est pas une instance de la classe Person");
        }
    }
    
    public function getDocument() : Document {
        return $this->document;
    }

    public function setDocument(Document $document) {

        if ($document instanceof Document) {
            return $this->document = $document;
        }
        else {
            throw new ExceptionPerso("Ceci n'est pas une instance de la classe Document");
        }
    }
    public function getUploadDate() : string {
        return $this->uploadDate;
    }

    public function setUploadDate(string $uploadDate) {
        $this->uploadDate = $uploadDate;
    }
}