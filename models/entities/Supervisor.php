<?php

class Supervisor {

    //Propriétés
    private int $id;
    private string $school;
    private Structure $structure;
    private Member $member_responsible;
    private Member $member_not_responsible;

    //Constructeur
    public function __construct() {
        $this->member_not_responsible = [];
    }

    //Getters et Setters
    public function getId() : int {
        return $this->id;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function getSchool() : string {
        return $this->school;
    }

    public function setSchool(string $school) {
        $this->school = $school;
    }

    public function getStructure() : Structure {
        return $this->structure;
    }

    public function setStructure(Structure $structure) {
        $this->structure = $structure;
    }

    public function getMember_responsible() : Member {
        return $this->member_responsible;
    }

    public function setMember_responsible(Member $member_responsible) {
        $this->member_responsible = $member_responsible;
    }
    
    public function getMember_not_responsible() : Member {
        return $this->member_not_responsible;
    }

    public function setMember_not_responsible(Member $member_not_responsible) {
        $this->member_not_responsible = $member_not_responsible;
    }
}