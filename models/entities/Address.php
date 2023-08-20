<?php

namespace ProjectEvs;

require_once '../../utility/exceptions/ExceptionPerso.php';

use ProjectEvs\ExceptionPerso;

class Address implements RegexTester {

    //Propriétés
    private int $id;
    private string $streetNumber;
    private string $streetName;
    private string $streetComplement;
    private string $code;
    private string $name;

    //Constructeur
    
    //Getters et Setters
    public function getId() : int {
        return $this->id;
    }

    public function setId(int $id) {

        if($id > 0) {

            if (filter_var($id, FILTER_VALIDATE_INT)) {
                $this->id = $id;
            } else {
                throw new ExceptionPerso("Arrêtez de jouer avec mes post");
            }
        }
        else {
            throw new ExceptionPerso('La valeur doit être positif et supérieur à 0');
        }
    }

    public function getStreetNumber() : string {
        return $this->streetNumber;
    }

    public function setStreetNumber(string $streetNumber) {
        $pattern = '/^\d+\s?[a-zA-Z\s]*$/';

        if ($this->testInput($pattern, $streetNumber)) {
            $this->streetNumber = $streetNumber;
        } else {
            throw new ExceptionPerso("Le numéro de rue n'est pas valide");
        }
    }

    public function getStreetName() : string {
        return $this->streetName;
    }

    public function setStreetName(string $streetName) {

        if (!empty($streetName)) {
            $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';

            if ($this->testInput($pattern, $streetName)) {
                $this->streetName = $streetName;
            } else {
                throw new ExceptionPerso("Le nom de la rue n'est pas valide");
            }
        } else {
            throw new ExceptionPerso("Veuillez renseigner ce champ");
        }
    }

    public function getStreetComplement() : string {
        return $this->streetComplement;
    }

    public function setStreetComplement(string $streetComplement) {
        $pattern = '/^[\w\s-]*$/';

        if ($this->testInput($pattern, $streetComplement)) {
            $this->streetComplement = $streetComplement;
        } else {
            throw new ExceptionPerso("Le nom du complément d'adresse n'est pas valide");
        }
    }

    public function getCode() : string {
        return $this->code;
    }

    public function setCode(string $code) {

        if (!empty($code)) {
            $pattern = '/^\d{5}$/';

            if ($this->testInput($pattern, $code)) {
                $this->code = $code;
            } else {
                throw new ExceptionPerso(
                    "Le code postal n'est pas valide, il doit étre composé de 5 chiffres"
                );
            }
        } else {
            throw new ExceptionPerso("Veuillez renseigner ce champ");
        }
    }

    public function getName() : string {
        return $this->name;
    }

    public function setName(string $name) {

        if (!empty($name)) {
            $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';

            if ($this->testInput($pattern, $name)) {
                $this->name = $name;
            } else {
                throw new ExceptionPerso("Le nom de la ville n'est pas valide");
            }
        } else {
            throw new ExceptionPerso("Veuillez renseigner ce champ");
        }
    }

    public function testInput($pattern, $input) {
        return preg_match($pattern, $input);
    }
}