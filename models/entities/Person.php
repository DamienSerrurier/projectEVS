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

    //Constructeur

    //Getters et Setters
    public function getid(): int {
        return $this->id;
    }

    public function setId(int $id) {

        if($id > 0) {

            if (filter_var($id, FILTER_VALIDATE_INT)) {
                $this->id = $id;
            } else {
                throw new ExceptionPerso("Arrêtez de jouer avec mes posts");
            }
        }
        else {
            throw new ExceptionPerso('La valeur doit être positif et supérieur à 0');
        }
    }

    public function getLastname(): string {
        return $this->lastname;
    }

    public function setLastname(string $lastname) {

        if (!empty($lastname)) {
            $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';

            if ($this->testInput($pattern, $lastname)) {
                $this->lastname = $lastname;
            } else {
                throw new ExceptionPerso("Le nom n'est pas valide");
            }
        } else {
            throw new ExceptionPerso("Veuillez renseigner ce champ");
        }
    }

    public function getFirstname(): string {
        return $this->firstname;
    }

    public function setFirstname(string $firstname) {
        if (!empty($firstname)) {
            $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';

            if ($this->testInput($pattern, $firstname)) {
                $this->firstname = $firstname;
            } else {
                throw new ExceptionPerso("Le prénom n'est pas valide");
            }
        } else {
            throw new ExceptionPerso("Veuillez renseigner ce champ");
        }
    }

    public function getPhone(): ?string {
        return $this->phone;
    }

    public function setPhone(?string $phone) {
        $pattern = '/^[0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2}$/';
        
        if ($phone == '') {
            $this->phone = '';
        }

        if ($this->testInput($pattern, $phone)) {
            $this->phone = $phone;
        } else {
            throw new ExceptionPerso("Le numéro de téléphone n'est pas valide");
        }
    }

    public function getCivility(): Civility {
        return $this->civility;
    }

    public function setCivility(Civility $civility) {

        if ($civility instanceof Civility) {
            $this->civility = $civility;
        }
        else {
            throw new ExceptionPerso("Ceci n'est pas une instance de la classe Civility");
        }
    }

    public function getAvatar(): Avatar {
        return $this->avatar;
    }

    public function setAvatar(Avatar $avatar) {

        if ($avatar instanceof Avatar) {
            $this->avatar = $avatar;
        }
        else {
            throw new ExceptionPerso("Ceci n'est pas une instance de la classe Avatar");
        }
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email) {

        if (!empty($email)) {

            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->email = $email;
            } else {
                throw new ExceptionPerso("L'adresse mail n'est pas valide");
            }
        } else {
            throw new ExceptionPerso("Veuillez renseigner ce champ");
        }
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function setPassword(string $password) {

        if (!empty($password)) {
            $pattern = '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/';

            if ($this->testInput($pattern, $password)) {
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

    public function getAddress(): Address {
        return $this->address;
    }

    public function setAddress(Address $address) {
        
        if ($address instanceof Address) {
            $this->address = $address;
        }
        else {
            throw new ExceptionPerso("Ceci n'est pas une instance de la classe Address");
        }
    }

    public function getRole(): Role {
        return $this->role;
    }

    public function setRole(Role $role) {

        if ($role instanceof Role) {
            $this->role = $role;
        }
        else {
            throw new ExceptionPerso("Ceci n'est pas une instance de la classe Role");
        }
    }

    public function testInput($pattern, $input) {
        return preg_match($pattern, $input);
    }

    public function setHachedPassword(string $hachedPassword) {

        if (!empty($hachedPassword)) {
            $this->password = $hachedPassword;
        }
        else {
            throw new ExceptionPerso("Veuillez renseigner ce champ");
        }
    }
}
