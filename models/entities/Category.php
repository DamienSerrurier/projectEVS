<?php

namespace ProjectEvs;

require_once __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR
 . "utility" . DIRECTORY_SEPARATOR . "exceptions" . DIRECTORY_SEPARATOR . "ExceptionPerso.php";

use Exception;
use ProjectEvs\ExceptionPerso;

class Category implements RegexTester {

    //Propriétés
    private int $id;
    private string $name;
    private int $event;

    //Constructeur

    //Getters et Setters

    /** Méthode permettant de récupérer l'id de la catégorie
     * @return int L'id de la catégorie
     */
    public function getId() : int {
        return $this->id;
    }

    /** Méthode permettant de définir l'id de la catégorie
     * @param int L'id de la catégorie
     * @throws ExceptionPerso Si l'id est négatif ou non valide
     */
    public function setId(int $id) {

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

    /** Méthode permettant de récupérer le nom de la catégorie
     * @return string Le nom de la catégorie
     */
    public function getName() : string {
        return $this->name;
    }

    /** Méthode permettant de définir le nom de la catégorie
     * @param string Le nom de la catégorie
     * @throws ExceptionPerso Si le nom n'est pas renseigné ou non valide
     */
    public function setName(string $name) {

        //Vérifie si le champ n'est pas vide
        if (!empty($name)) {
            $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';

            //Vérifie si le nom de la catégorie correspond au pattern
            if ($this->testInput($pattern, $name)) {
                $this->name = $name;
            } else {
                throw new ExceptionPerso("Le nom de la catégorie n'est pas valide");
            }
        } else {
            throw new ExceptionPerso("Veuillez renseigner ce champ");
        }
    }

    /** Méthode qui permet de retourner un identifiant lié à un événement
     * @return int L'événement associé à une catégorie
     */
    public function getEvent() {
        return $this->event;
    }

    /** Permet de vérifier et de définir l'identifiant correspondant à un événement 
     * @param int L'identifiant de l'événement
     * @throws ExceptionPerso Si l'événement n'est pas renseigné ou non valide
     */
    public function setEvent(int $event) {

        if (!empty($event)) {

            if (filter_var($event, FILTER_VALIDATE_INT)) {
                $this->event = $event;
            }
            else {
                throw new ExceptionPerso("Arrêtez de jouer avec mes input tipe checkbox");
            }
        }
        else {
            throw new ExceptionPerso("Veuillez faire un choix d'événement");
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