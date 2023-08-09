<?php

namespace ProjectEvs;

class Activity {

    //Propriétés
    private int $id;
    private string $additional_information;
    private string $date_start;
    private string $date_end;
    private string $hour_start;
    private string $hour_end;
    private string $description;
    private string $picture;
    private Category $category;

    //Constructeur

    //Getters et Setters
    public function getId() : int {
        return $this->id;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function getAdditional_information() : string {
        return $this->additional_information;
    }

    public function setAdditional_information(string $additional_information) {
        $this->additional_information = $additional_information;
    }

    public function getDate_start() : string {
        return $this->date_start;
    }

    public function setDate_start(string $date_start) {
        $this->date_start = $date_start;
    }

    public function getDate_end() : string {
        return $this->date_end;
    }

    public function setDate_end(string $date_end) {
        $this->date_end = $date_end;
    }

    public function getHour_start() : string {
        return $this->hour_start;
    }

    public function setHour_start(string $hour_start) {
        $this->hour_start = $hour_start;
    }

    public function getHour_end() : string {
        return $this->hour_end;
    }

    public function setHour_end(string $hour_end) {
        $this->hour_end = $hour_end;
    }

    public function getDescription() : string {
        return $this->description;
    }

    public function setDescription(string $description) {
        $this->description = $description;
    }

    public function getPicture() : string {
        return $this->picture;
    }

    public function setPicture(string $picture) {
        $this->picture = $picture;
    }

    public function getCategory() : Category {
        return $this->category;
    }

    public function setCategory(Category $category) {
        $this->category = $category;
    }
}