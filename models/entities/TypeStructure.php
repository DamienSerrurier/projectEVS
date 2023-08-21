<?php

namespace ProjectEvs;

require_once '../../utility/exceptions/ExceptionPerso.php';

class TypeStructure implements RegexTester {

    //Propriétés
    private int $id;
    private string $wording;

    //Constructeur

    //Getters et Setters

    /** Méthode permettant de récupérer l'id du type de structure
     * @return int L'id du type de structure
     */
    public function getId() : int {
        return $this->id;
    }

    /** Méthode permettant de définir l'id du type de structure
     * @param int L'id du type de structure
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

    /** Méthode permettant de récupérer le nom du type de structure
     * @return string Le nom du type de structure
     */
    public function getWording() : string {
        return $this->wording;
    }

    /** Méthode permettant de définir le nom du type de structure
     * @param string Le nom du type de structure
     * @throws ExceptionPerso Si le nom du type de structure est non valide
     */
    public function setWording(string $wording) {

        //Vérifie si le champ n'est pas vide
        if (!empty($wording)) {
            $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';

            //Vérifie si le nom du type de structure correspond au pattern
            if ($this->testInput($pattern, $wording)) {
                $this->wording = $wording;
            } else {
                throw new ExceptionPerso("Le nom de la type de structure n'est pas valide");
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