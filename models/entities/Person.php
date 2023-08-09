<?php

namespace ProjectEvs;

class Person {

    //Propriétés
    protected int $id;
    protected string $lastname;
    protected string $firstname;
    protected string $phone;
    protected Civility $civility;
    private Avatar $avatar;
    protected string $email;
    private string $password;
    protected Address $address;
    private Role $role;

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
        
        if (!empty($lastname)) {

            $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';
            if (preg_match($pattern, $lastname)) {
                $this->lastname = $lastname;
                return $this->lastname;
            }
            else {
                return $errorMessage = "La valeur attendue n'est pas la bonne";
            }
        }
        else {
            return $errorMessage = "Veuillez renseigner ce champ";
        }
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

    public function getCivility() : Civility {
        return $this->civility;
    }

    public function setCivility(Civility $civility) {
        $this->civility = $civility;
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

    public function getRole() : Role {
        return $this->role;
    }

    public function setRole(Role $role) {
        $this->role = $role;
    }
}