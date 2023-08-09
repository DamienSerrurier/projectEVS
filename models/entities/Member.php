<?php

namespace ProjectEvs;

class Member extends Person {

    //Propriétés
    private string $birthdate;
    private string $place_of_birth;
    private Member $memberPair;
    private string $profession;
    private string $family_situation;
    private string $caf_number;
    private string $registration_date;

    //Constructeur
    
    //Getters et Setters
    public function getBirthdate() : string {
        return $this->birthdate;
    }

    public function setBirthdate(string $birthdate) {
        $this->birthdate = $birthdate;
    }

    public function getPlace_of_birth() : string {
        return $this->place_of_birth;
    }

    public function setPlace_of_birth(string $place_of_birth) {
        $this->place_of_birth = $place_of_birth;
    }

    public function getMemberPair() : Member {
        return $this->memberPair;
    }

    public function setMemberPair(Member $memberPair) {
        $this->memberPair = $memberPair;
    }

    public function getProfession() : string {
        return $this->profession;
    }

    public function setProfession(string $profession) {
        $this->profession = $profession;
    }

    public function getFamily_situation() : string {
        return $this->family_situation;
    }

    public function setFamily_situation(string $family_situation) {
        $this->family_situation = $family_situation;
    }

    public function getCaf_number() : string {
        return $this->caf_number;
    }

    public function setCaf_number(string $caf_number) {
        $this->caf_number = $caf_number;
    }

    public function getRegistration_date() : string {
        return $this->registration_date;
    }

    public function setRegistration_date(string $registration_date) {
        $this->registration_date = $registration_date;
    }
}