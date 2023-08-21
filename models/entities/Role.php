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

    /** Méthode permettant de récupérer l'id du rôle
     * @return int L'id du rôle
     */
    public function getId() : int {
        return $this->id;
    }

    /** Méthode permettant de définir l'id du rôle
     * @param int L'id du rôle
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

    /** Méthode permettant de récupérer le nom du rôle
     * @return string Le nom du rôle
     */
    public function getName() : string {
        return $this->name;
    }

    /** Méthode permettant de définir le nom du rôle
     * @param string Le nom du rôle
     * @throws ExceptionPerso Si le nom du rôle est non valide
     */
    public function setName(string $name) {

        //Vérifie si le champ n'est pas vide
        if (!empty($name)) {
            $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';

            //Vérifie si le nom du rôle correspond au pattern
            if ($this->testInput($pattern, $name)) {
                $this->name = $name;
            } else {
                throw new ExceptionPerso("Le nom du Role n'est pas valide");
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