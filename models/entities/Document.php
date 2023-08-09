<?php

namespace ProjectEvs;

class Document {

    //Propriétés
    private int $id;
    private string $name;
    private string $link;
    private int $id_structure;

    //Constructeur

    //Getters et Setters
    public function getId() : int {
        return $this->id;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function getName() : int {
        return $this->name;
    }

    public function setName(int $name) {
        $this->name = $name;
    }

    public function getLink() : int {
        return $this->link;
    }

    public function setLink(int $link) {
        $this->link = $link;
    }

    public function getId_structure() : int {
        return $this->id_structure;
    }

    public function setId_structure(int $id_structure) {
        $this->id_structure = $id_structure;
    }
}