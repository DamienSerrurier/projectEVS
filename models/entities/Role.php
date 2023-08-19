<?php 

namespace ProjectEvs;

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR
 . 'utility' . DIRECTORY_SEPARATOR . 'exceptions' . DIRECTORY_SEPARATOR . 'ExceptionPerso.php';

class Role implements RegexTester {

    //Propriétés
    private int $id;
    private string $name;

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

    public function getName() : string {
        return $this->name;
    }

    public function setName(string $name) {

        if (!empty($name)) {
            $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';

            if ($this->testInput($pattern, $name)) {
                return $this->name = $name;
            } else {
                throw new ExceptionPerso("Le nom du Role n'est pas valide");
            }
        } else {
            throw new ExceptionPerso("Veuillez renseigner ce champ");
        }
    }

    public function testInput($pattern, $input) {
        return preg_match($pattern, $input);
    }
}