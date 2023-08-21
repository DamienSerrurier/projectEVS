<?php

namespace ProjectEvs;

require_once '../../utility/exceptions/ExceptionPerso.php';

class Category implements RegexTester {

    //Propriétés
    private int $id;
    private string $name;

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
     * @throws ExceptionPerso Si le nom est non valide
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

     /** Méthode permettant de vérifier si une valeur correspond à un pattern donné
     * @param string $pattern Le pattern à vérifier
     * @param string $input La valeur à vérifier
     * @return boolean Renvoie true si la valeur correspond au pattern, false sinon
     */
    public function testInput($pattern, $input) {
        return preg_match($pattern, $input);
    }
}