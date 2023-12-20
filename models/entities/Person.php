<?php

namespace ProjectEvs;

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR
 . 'utility' . DIRECTORY_SEPARATOR . 'exceptions' . DIRECTORY_SEPARATOR . 'ExceptionPerso.php';
 
use ProjectEvs\ExceptionPerso;

class Person implements RegexTester {

    //Propriétés
    protected int $id;
    protected string $lastname;
    protected string $firstname;
    protected ?string $phone;
    protected Civility $civility;
    private Avatar $avatar;
    protected string $email;
    private string $password;
    protected Address $address;
    private Role $role;

    //Getters et Setters

    /** Méthode permettant de récupérer l'id de la personne
     * @return int L'id de la personne
     */
    public function getId(): int {
        return $this->id;
    }

    /** Méthode permettant de définir l'id de la personne
     * @param int $id L'id de la personne
     * @throws ExceptionPerso Si l'id est négatif ou non valide
     */
    public function setId(int $id) {

        //Vérifie si l'id est positif
        if($id > 0) {

            //Vérifie si l'id est valide
            if (filter_var($id, FILTER_VALIDATE_INT)) {
                $this->id = $id;
            } else {
                throw new ExceptionPerso("Arrêtez de jouer avec mes identifiants");
            }
        }
        else {
            throw new ExceptionPerso('La valeur doit être positif et supérieur à 0');
        }
    }

    /** Méthode permettant de récupérer le nom
     * @return string Le nom
     */
    public function getLastname(): string {
        return $this->lastname;
    }

     /** Méthode permettant de définir le nom
     * @param string $lastname Le nom
     * @throws ExceptionPerso Si le nom est non valide
     */
    public function setLastname(string $lastname) {

        //Vérifie si le champ n'est pas vide
        if (!empty($lastname)) {
            $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';

            //Vérifie si le nom correspond au pattern
            if ($this->testInput($pattern, $lastname)) {
                $this->lastname = $lastname;
            } else {
                throw new ExceptionPerso("Le nom n'est pas valide");
            }
        } else {
            throw new ExceptionPerso("Veuillez renseigner ce champ");
        }
    }

    /** Méthode permettant de récupérer le prénom
     * @return string Le prénom
     */
    public function getFirstname(): string {
        return $this->firstname;
    }

    /** Méthode permettant de définir le prénom
     * @param string $firstname Le prénom
     * @throws ExceptionPerso Si le prénom est non valide
     */
    public function setFirstname(string $firstname) {

        //Vérifie si le champ n'est pas vide
        if (!empty($firstname)) {
            $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';

            //Vérifie si le prénom correspond au pattern
            if ($this->testInput($pattern, $firstname)) {
                $this->firstname = $firstname;
            } else {
                throw new ExceptionPerso("Le prénom n'est pas valide");
            }
        } else {
            throw new ExceptionPerso("Veuillez renseigner ce champ");
        }
    }

    /** Méthode permettant de récupérer le numéro de téléphone
     * @return string Le numéro de téléphone
     */
    public function getPhone(): ?string {
        return $this->phone;
    }

     /** Méthode permettant de définir le numéro de téléphone
     * @param string $phone Le numéro de téléphone
     * @throws ExceptionPerso Si le numéro de téléphone est non valide
     */
    public function setPhone(?string $phone) {
        $pattern = '/^[0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2}$/';
        
        //Vérifie si le numéro de téléphone est vide
        if (empty($phone)) {
            $this->phone = '';
        }
        else {
            
            //Vérifie si le numéro de téléphone est valide
            if ($this->testInput($pattern, $phone)) {
                $this->phone = $phone;
            } else {
                throw new ExceptionPerso("Le numéro de téléphone n'est pas valide");
            }
        }
    }

    /** Méthode permettant de récupérer l'objet Civility
     * @return Civility l'objet Civility
     */
    public function getCivility(): Civility {
        return $this->civility;
    }

    /** Méthode permettant de définir l'objet Civility
     * @param Civility l'objet Civility
     */
    public function setCivility(Civility $civility) {
        $this->civility = $civility;
    }

    /** Méthode permettant de récupérer l'objet Avatar
     * @return Avatar l'objet Avatar
     */
    public function getAvatar(): Avatar {
        return $this->avatar;
    }

     /** Méthode permettant de définir l'objet Avatar
     * @param Avatar l'objet Avatar
     */
    public function setAvatar(Avatar $avatar) {
            $this->avatar = $avatar;
    }

    /** Méthode permettant de récupérer l'adresse mail de l'utilisateur
     * @return string L'adresse mail de l'utilisateur
     */
    public function getEmail(): string {
        return $this->email;
    }

    /** Méthode permettant de définir l'adresse mail de l'utilisateur
     * @param string $email L'adresse mail de l'utilisateur
     * @throws ExceptionPerso Si l'adresse mail est non valide
     */
    public function setEmail(string $email) {

        //Vérifie si l'adresse mail n'est pas vide
        if (!empty($email)) {

            //Vérifie si l'adresse mail est valide
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->email = $email;
            } else {
                throw new ExceptionPerso("L'adresse mail n'est pas valide");
            }
        } else {
            throw new ExceptionPerso("Veuillez renseigner ce champ");
        }
    }

    /** Méthode permettant de récupérer le mot de passe
     * @return string Le mot de passe
     */
    public function getPassword(): string {
        return $this->password;
    }

    /** Méthode permettant de définir le mot de passe
     * @param string $password Le mot de passe
     * @throws ExceptionPerso Si le mot de passe est non valide
     */
    public function setPassword(string $password) {

        //Vérifie si le mot de passe n'est pas vide
        if (!empty($password)) {
            $pattern = '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/';

            //Vérifie si le mot de passe est valide
            if ($this->testInput($pattern, $password)) {
                //Cryptage du mot de passe 
                $password = password_hash($password, PASSWORD_BCRYPT);
                $this->password = $password;
            } else {
                throw new ExceptionPerso(
                    "Veuillez renseigner un mot de passe de 8 caractères contenant au moins : \n
                    - une lettre majuscule \n
                    - une lettre minuscule \n
                    - un chiffre \n
                    - un caractère spécial"
                );
            }
        } else {
            throw new ExceptionPerso("Veuillez renseigner ce champ");
        }
    }

    /** Méthode permettant de récupérer l'objet Address
     * @return Address l'objet Address
     */
    public function getAddress(): Address {
        return $this->address;
    }

    /** Méthode permettant de définir l'objet Address
     * @param Address l'objet Address
     */
    public function setAddress(Address $address) {
        $this->address = $address;
    }

    /** Méthode permettant de récupérer l'objet Role
     * @return Role l'objet Role
     */
    public function getRole(): Role {
        return $this->role;
    }

    /** Méthode permettant de définir l'objet Role
     * @param Role l'objet Role
     */
    public function setRole(Role $role) {
        $this->role = $role;
    }

    /** Méthode permettant de vérifier si une valeur correspond à un pattern donné
     * @param string $pattern Le pattern à vérifier
     * @param string $input La valeur à vérifier
     * @return boolean Renvoie true si la valeur correspond au pattern, false sinon
     */
    public function testInput(string $pattern, string $input) {
        return preg_match($pattern, $input);
    }

    /** Méthode permettant de définir le mot de passe déjà haché
     * @param string $hachedPassword Le mot de passe déjà haché
     * @throws ExceptionPerso Si le mot de passe déjà haché est vide
     */
    public function setHachedPassword(string $hachedPassword) {

        //Vérifie si le mot de passe déjà haché n'est pas vide
        if (!empty($hachedPassword)) {
            $this->password = $hachedPassword;
        }
        else {
            throw new ExceptionPerso("Veuillez renseigner ce champ");
        }
    }
}
