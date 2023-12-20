<?php

namespace ProjectEvs;

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR
 . 'utility' . DIRECTORY_SEPARATOR . 'exceptions' . DIRECTORY_SEPARATOR . 'ExceptionPerso.php';

use ProjectEvs\ExceptionPerso;

class Address implements RegexTester {

    //Propriétés
    private int $id;
    private string $streetNumber;
    private string $streetName;
    private string $streetComplement;
    private string $code;
    private string $name;
    
    //Getters et Setters

    /** Méthode permettant de récupérer l'id de l'adresse
     * @return int L'id de l'adresse
     */
    public function getId() : int {
        return $this->id;
    }

    /** Méthode permettant de définir l'id de l'adresse
     * @param int L'id de l'adresse
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

    /** Méthode permettant de récupérer le numéro de rue de l'adresse
     * @return string Le numéro de rue de l'adresse
     */
    public function getStreetNumber() : string {
        return $this->streetNumber;
    }

    /** Méthode permettant de définir le numéro de rue de l'adresse
     * @param string Le numéro de rue de l'adresse
     * @throws ExceptionPerso Si le numéro de rue est non valide
     */
    public function setStreetNumber(string $streetNumber) {

        //Vérifie si le champ est vide
        if (empty($streetNumber)) {
            $this->streetNumber = '';
        }
        else {
            $pattern = '/^\d+\s?[a-zA-Z\s]*$/';
    
            //Vérifie si le numéro de rue correspond au pattern
            if ($this->testInput($pattern, $streetNumber)) {
                $this->streetNumber = $streetNumber;
            } else {
                throw new ExceptionPerso("Le numéro de rue n'est pas valide");
            }
        }
    }

    /** Méthode permettant de récupérer le nom de rue de l'adresse
     * @return string Le nom de rue de l'adresse
     */
    public function getStreetName() : string {
        return $this->streetName;
    }

    /** Méthode permettant de définir le nom de rue de l'adresse
     * @param string Le nom de rue de l'adresse
     * @throws ExceptionPerso Si le nom de rue est non valide
     */
    public function setStreetName(string $streetName) {

        //Vérifie si le champ n'est pas vide
        if (!empty($streetName)) {
            $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';
            
            //Vérifie si le nom de rue correspond au pattern
            if ($this->testInput($pattern, $streetName)) {
                $this->streetName = $streetName;
            } else {
                throw new ExceptionPerso("Le nom de la rue n'est pas valide");
            }
        } else {
            throw new ExceptionPerso("Veuillez renseigner ce champ");
        }
    }

     /** Méthode permettant de récupérer le complément d'adresse
     * @return string Le complément d'adresse
     */
    public function getStreetComplement() : string {
        return $this->streetComplement;
    }

    /** Méthode permettant de définir le complément d'adresse
     * @param string Le complément d'adresse
     * @throws ExceptionPerso Si le complément d'adresse est non valide
     */
    public function setStreetComplement(string $streetComplement) {

        //Vérifie si le champ est vide
        if (empty($streetComplement)) {
            $this->streetComplement = '';
        }
        else {
            $pattern = '/^[\w\s-]*$/';
    
            //Vérifie si le complément d'adresse correspond au pattern
            if ($this->testInput($pattern, $streetComplement)) {
                $this->streetComplement = $streetComplement;
            } else {
                throw new ExceptionPerso("Le nom du complément d'adresse n'est pas valide");
            }
        }
    }

    /** Méthode permettant de récupérer le code postal
     * @return string Le code postal
     */
    public function getCode() : string {
        return $this->code;
    }

    /** Méthode permettant de définir le code postal
     * @param string Le code postal
     * @throws ExceptionPerso Si le code postal est non valide
     */
    public function setCode(string $code) {

        //Vérifie si le champ n'est pas vide
        if (!empty($code)) {
            $pattern = '/^\d{5}$/';

            //Vérifie si le code postal correspond au pattern
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

    /** Méthode permettant de récupérer la ville
     * @return string La ville
     */
    public function getName() : string {
        return $this->name;
    }

    /** Méthode permettant de définir la ville
     * @param string La ville
     * @throws ExceptionPerso Si la ville est non valide
     */
    public function setName(string $name) {

        //Vérifie si le champ n'est pas vide
        if (!empty($name)) {
            $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';
            
            //Vérifie si la ville correspond au pattern
            if ($this->testInput($pattern, $name)) {
                $this->name = $name;
            } else {
                throw new ExceptionPerso("Le nom de la ville n'est pas valide");
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