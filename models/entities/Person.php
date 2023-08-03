<?php

class Person {

    //Propriétés
    protected int $id;
    protected string $lastname;
    protected string $firstname;
    protected string $phone;
    protected int $id_civility;
    private Avatar $avatar;
    protected string $email;
    private string $password;
    protected Address $address;
    private int $id_role;

    //Constructeur

    //Getters et Setters
    public function getid() : int {
        return $this->id;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function getLastname() : string {
        return $this->lastname;
    }

    public function setLastname(string $lastname) {
        $this->lastname = $lastname;
    }

    public function getFirstname() : string {
        return $this->firstname;
    }

    public function setFirstname(string $firstname) {
        $this->firstname = $firstname;
    }

    public function getPhone() : string {
        return $this->phone;
    }

    public function setPhone(string $phone) {
        $this->phone = $phone;
    }

    public function getId_civility() : int {
        return $this->id_civility;
    }

    public function setId_civility(int $id_civility) {
        $this->id_civility = $id_civility;
    }

    public function getAvatar() : Avatar {
        return $this->avatar;
    }

    public function setAvatar(Avatar $avatar) {
        $this->avatar = $avatar;
    }

    public function getEmail() : string {
        return $this->email;
    }

    public function setEmail(string $email) {
        $this->email = $email;
    }

    public function getPassword() : string {
        return $this->password;
    }

    public function setPassword(string $password) {
        $this->password = $password;
    }

    public function getAddress() : Address {
        return $this->address;
    }

    public function setAddress(Address $address) {
        $this->address = $address;
    }

    public function getId_role() : int {
        return $this->id_role;
    }

    public function setId_role(int $id_role) {
        $this->id_role = $id_role;
    }
}