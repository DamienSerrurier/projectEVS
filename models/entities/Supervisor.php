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
    private array $memberNotResponsible;

    //Constructeur
  
    //Getters et Setters

    /** Méthode permettant de récupérer l'id du superviseur
     * @return int L'id du superviseur
     */
    public function getId() : int {
        return $this->id;
    }

    /** Méthode permettant de définir l'id du superviseur
     * @param int L'id du superviseur
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

    /** Méthode permettant de récupérer le nom du superviseur
     * @return string Le nom du superviseur
     */
    public function getSchool() : string {
        return $this->school;
    }

    /** Méthode permettant de définir le nom du superviseur
     * @param string Le nom du superviseur
     * @throws ExceptionPerso Si le nom du superviseur est non valide
     */
    public function setSchool(string $school) {

        //Vérifie si le champ n'est pas vide
        if (!empty($school)) {
            $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';

            //Vérifie si le nom du superviseur correspond au pattern
            if ($this->testInput($pattern, $school)) {
                $this->school = $school;
            } else {
                throw new ExceptionPerso("Le nom de l'école n'est pas valide");
            }
        } else {
            throw new ExceptionPerso("Veuillez renseigner ce champ");
        }
    }

    /** Méthode permettant de récupérer le nom de la ville où se trouve l'école
     * @return string Le nom de la ville où se trouve l'école
     */
    public function getSchoolCity() : string {
        return $this->schoolCity;
    }

    /** Méthode permettant de définir le nom de la ville où se trouve l'école
     * @param string Le nom de la ville où se trouve l'école
     * @throws ExceptionPerso Si le nom de la ville où se trouve l'école est non valide
     */
    public function setSchoolCity(string $schoolCity) {

        //Vérifie si le champ n'est pas vide
        if (!empty($schoolCity)) {
            $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';

            //Vérifie si le nom de la ville où se trouve l'école correspond au pattern
            if ($this->testInput($pattern, $schoolCity)) {
                $this->schoolCity = $schoolCity;
            } else {
                throw new ExceptionPerso("Le nom de la ville de l'école n'est pas valide");
            }
        } else {
            throw new ExceptionPerso("Veuillez renseigner ce champ");
        }
    }

    /** Méthode permettant de récupérer l'objet Structure
     * @return Structure l'objet Structure
     */
    public function getStructure() : Structure {
        return $this->structure;
    }

    /** Méthode permettant de définir l'objet Structure
     * @param Structure l'objet Structure
     */
    public function setStructure(Structure $structure) {
        $this->structure = $structure; 
    }

    /** Méthode permettant de récupérer l'objet Member
     * @return Member L'objet Member
     */
    public function getMemberResponsible() : Member {
        return $this->memberResponsible;
    }

    /** Méthode permettant de définir l'objet Member
     * @param Member l'objet Member
     */
    public function setMemberResponsible(Member $memberNotResponsible) {
        $this->memberNotResponsible = $memberNotResponsible;   
    }
    
    /** Méthode permettant de récupérer un tableau d'objet Member
     * @return array Le tableau l'objet Member
     */
    public function getMemberNotResponsible() : array {
        return $this->memberNotResponsible;
    }

    /** Méthode permettant de définir l'objet Member
     * @param Member l'objet Member
     */
    public function setMemberNotResponsible(Member $memberNotResponsible) {
        $this->memberNotResponsible = $memberNotResponsible;   
    }

    /** Méthode permettant de vérifier si une valeur correspond à un pattern donné
     * @param string $pattern Le pattern à vérifier
     * @param string $input La valeur à vérifier
     * @return boolean Renvoie true si la valeur correspond au pattern, false sinon
     */
    public function testInput($pattern, $input) {
        return preg_match($pattern, $input);
    }

    public function addMemberMinor(Member $memberMinor) {

        if (!is_array($this->memberNotResponsible)) {
            $this->memberNotResponsible = [];
        }
        
        array_push($this->memberNotResponsible, $memberMinor);
    }
}