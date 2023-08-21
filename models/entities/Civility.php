<?php

namespace ProjectEvs;

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR
 . 'utility' . DIRECTORY_SEPARATOR . 'exceptions' . DIRECTORY_SEPARATOR . 'ExceptionPerso.php';

use ProjectEvs\ExceptionPerso;

class Civility implements RegexTester {

    //Propriétés
    private int $id;
    private string $name;

    //Constructeur

    //Getters et Setters

     /** Méthode permettant de récupérer l'id de la civilité
     * @return int L'id de la civilité
     */
    public function getId() : int {
        return $this->id;
    }

    /** Méthode permettant de définir l'id de la civilité
     * @param int L'id de la civilité
     * @throws ExceptionPerso Si l'id est négatif, égale à zéro ou non valide
     */
    public function setId(int $id) {
        //Vérifie si l'id est égale à zéro
        if ($id == 0) {
            throw new ExceptionPerso("Veuillez faire un choix de civilité");
        }
        else {

            //Vérifie si l'id est positif
            if($id > 0) {
    
                //Vérifie si l'id est valide
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

    }

    /** Méthode permettant de récupérer le nom de la civilité
     * @return string Le nom de la civilité
     */
    public function getName() : string {
        return $this->name;
    }

    /** Méthode permettant de définir le nom de la civilité
     * @param string Le nom de la civilité
     * @throws ExceptionPerso Si le nom de la civilité est non valide
     */
    public function setName(string $name) {

        //Vérifie si le champ n'est pas vide
        if (!empty($name)) {
            $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';

            //Vérifie si le nom de la civilité correspond au pattern
            if ($this->testInput($pattern, $name)) {
                $this->name = $name;
            } else {
                throw new ExceptionPerso("Le nom de la civilité n'est pas valide");
            }
        } else {
            throw new ExceptionPerso("Veuillez renseigner ce champ");
        }
    }

    /** Méthode permettant de vérifier si une valeur correspond à un pattern donné
     * @param string $pattern Le pattern à vérifier
     * @param string $input La valeur à vérifier
     * @return boolean Renvoie true si la valeur correspond au pattern, false sinon
     */
    public function testInput($pattern, $input) {
        return preg_match($pattern, $input);
    }
}