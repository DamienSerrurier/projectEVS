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

    /** Méthode permettant de récupérer l'objet Person
     * @return Person l'objet Person
     */
    public function getPerson() : Person {
        return $this->person;
    }

    /** Méthode permettant de définir l'objet Person
     * @param Person l'objet Person
     */
    public function setPerson(Person $person) {
        $this->person = $person;
    }
    
    /** Méthode permettant de récupérer l'objet Document
     * @return Document l'objet Document
     */
    public function getDocument() : Document {
        return $this->document;
    }

    /** Méthode permettant de définir l'objet Document
     * @param Document l'objet Document
     */
    public function setDocument(Document $document) {
        $this->document = $document;    
    }

    public function getUploadDate() : string {
        return $this->uploadDate;
    }

    public function setUploadDate(string $uploadDate) {
        $this->uploadDate = $uploadDate;
    }
}