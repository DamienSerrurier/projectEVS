<?php

class TypeStructure {

    //Propriétés
    private int $id;
    private string $wording;

    //Constructeur

    //Getters et Setters
    public function getId() : int {
        return $this->id;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function getWording() : string {
        return $this->wording;
    }

    public function setWording(string $wording) {
        $this->wording = $wording;
    }
}