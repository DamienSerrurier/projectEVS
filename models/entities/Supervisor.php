<?php

namespace ProjectEvs;

require_once '../../utility/exceptions/ExceptionPerso.php';

class Supervisor implements RegexTester {

    //Propriétés
    private int $id;
    private string $school;
    private string $schoolCity;
    private Structure $structure;
    private Member $memberResponsible;
    private Member $memberNotResponsible;

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

    public function getSchool() : string {
        return $this->school;
    }

    public function setSchool(string $school) {

        if (!empty($school)) {
            $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';

            if ($this->testInput($pattern, $school)) {
                return $this->school = $school;
            } else {
                throw new ExceptionPerso("Le nom de l'école n'est pas valide");
            }
        } else {
            throw new ExceptionPerso("Veuillez renseigner ce champ");
        }
    }

    public function getSchoolCity() : string {
        return $this->schoolCity;
    }

    public function setSchoolCity(string $schoolCity) {

        if (!empty($schoolCity)) {
            $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';

            if ($this->testInput($pattern, $schoolCity)) {
                return $this->schoolCity = $schoolCity;
            } else {
                throw new ExceptionPerso("Le nom de la ville de l'école n'est pas valide");
            }
        } else {
            throw new ExceptionPerso("Veuillez renseigner ce champ");
        }
    }

    public function getStructure() : Structure {
        return $this->structure;
    }

    public function setStructure(Structure $structure) {

        if ($structure instanceof Structure) {
            return $this->structure = $structure;
        }
        else {
            throw new ExceptionPerso("Ceci n'est pas une instance de la classe Structure");
        }
    }

    public function getMemberResponsible() : Member {
        return $this->memberResponsible;
    }

    public function setMemberResponsible(Member $memberResponsible) {

        if ($memberResponsible instanceof Member) {
            return $this->memberResponsible = $memberResponsible;
        }
        else {
            throw new ExceptionPerso("Ceci n'est pas une instance de la classe Member");
        }
    }
    
    public function getMemberNotResponsible() : Member {
        return $this->memberNotResponsible;
    }

    public function setMemberNotResponsible(Member $memberNotResponsible) {

        if ($memberNotResponsible instanceof Member) {
            return $this->memberNotResponsible = $memberNotResponsible;
        }
        else {
            throw new ExceptionPerso("Ceci n'est pas une instance de la classe Member");
        }
    }

    public function testInput($pattern, $input) {
        return preg_match($pattern, $input);
    }

    public function addMemberMinor(Member $memberMinor) {
        $this->memberNotResponsible= [$memberMinor];
    }
}