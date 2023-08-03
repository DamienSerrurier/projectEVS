<?php

class Avatar {

    //Propriétés
    private int $id;
    private string $picture;

    //Constructeur
    
    //Getters et Setters
    public function getId() : int {
        return $this->id;
    }

    public function setId(int $id) {
        $this->id = $id;
    }
    
    public function getPicture() : string {
        return $this->picture;
    }

    public function setPicture(string $picture) {
        $this->picture = $picture;
    }
}