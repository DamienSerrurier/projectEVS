<?php

namespace ProjectEvs;

require_once '../../utility/exceptions/ExceptionPerso.php';

class TypeStructure implements RegexTester {

    //Propriétés
    private int $id;
    private string $wording;

    //Constructeur

    //Getters et Setters
    public function getId() : int {
        return $this->id;
    }

    public function setId(int $id) {

        if($id > 0) {

            if (filter_var($id, FILTER_VALIDATE_INT)) {
                return $this->id = $id;
            } else {
                throw new ExceptionPerso("Arrêtez de jouer avec mes post");
            }
        }
        else {
            throw new ExceptionPerso('La valeur doit être positif et supérieur à 0');
        }
    }

    public function getWording() : string {
        return $this->wording;
    }

    public function setWording(string $wording) {

        if (!empty($wording)) {
            $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';

            if ($this->testInput($pattern, $wording)) {
                return $this->wording = $wording;
            } else {
                throw new ExceptionPerso("Le nom de la type de structure n'est pas valide");
            }
        } else {
            throw new ExceptionPerso("Veuillez renseigner ce champ");
        }
    }

    public function testInput($pattern, $input) {
        return preg_match($pattern, $input);
    }
}