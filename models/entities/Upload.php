<?php

namespace ProjectEvs;

class Upload {

    //Propriétés
    private Person $person;
    private Document $document;
    private string $upload_date;

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
    public function getUpload_date() : string {
        return $this->upload_date;
    }

    public function setUpload_date(string $upload_date) {
        $this->upload_date = $upload_date;
    }
}