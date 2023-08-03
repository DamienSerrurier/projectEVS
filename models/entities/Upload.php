<?php

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
        $this->person = $person;
    }
    
    public function getDocument() : Document {
        return $this->document;
    }

    public function setDocument(document $document) {
        $this->document = $document;
    }
    public function getUpload_date() : string {
        return $this->upload_date;
    }

    public function setUpload_date(string $upload_date) {
        $this->upload_date = $upload_date;
    }
}