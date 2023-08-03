<?php

class Structure {

    //Propriétés
    private int $id;
    private string $name;
    private string $logo;
    private string $phone;
    private int $id_type_structure;
    private Address $address;

    //Constructeur
    
    //Getters et Setters
    public function getId() : int {
        return $this->id;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function getName() : string {
        return $this->name;
    }

    public function setName(string $name) {
        $this->name = $name;
    }

    public function getLogo() : string {
        return $this->logo;
    }

    public function setLogo(string $logo) {
        $this->logo = $logo;
    }

    public function getPhone() : string {
        return $this->phone;
    }

    public function setPhone(string $phone) {
        $this->phone = $phone;
    }

    public function getId_type_structure() : int {
        return $this->id_type_structure;
    }

    public function setId_type_structure(int $id_type_structure) {
        $this->id_type_structure = $id_type_structure;
    }

    public function getAddress() : Address {
        return $this->address;
    }

    public function setAddress(Address $address) {
        $this->address = $address;
    }
}