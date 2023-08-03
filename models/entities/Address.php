<?php

class Address {

    //Propriétés
    private int $id;
    private string $street_number;
    private string $street_name;
    private string $street_complement;
    private string $code;
    private string $name;

    //Constructeur
    
    //Getters et Setters
    public function getId() : int {
        return $this->id;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function getStreet_number() : string {
        return $this->street_number;
    }

    public function setStreet_number(string $street_number) {
        $this->street_number = $street_number;
    }

    public function getStreet_name() : string {
        return $this->street_name;
    }

    public function setStreet_name(string $street_name) {
        $this->street_name = $street_name;
    }

    public function getstreet_complement() : string {
        return $this->street_complement;
    }

    public function setStreet_complement(string $street_complement) {
        $this->street_complement = $street_complement;
    }

    public function getCode() : string {
        return $this->code;
    }

    public function setCode(string $code) {
        $this->code = $code;
    }

    public function getName() : string {
        return $this->name;
    }

    public function setName(string $name) {
        $this->name = $name;
    }
}