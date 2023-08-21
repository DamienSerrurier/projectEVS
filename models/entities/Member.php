<?php

namespace ProjectEvs;

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR
 . 'utility' . DIRECTORY_SEPARATOR . 'exceptions' . DIRECTORY_SEPARATOR . 'ExceptionPerso.php';

use DateTime;
use Exception;
use ProjectEvs\ExceptionPerso;

class Member extends Person {

    //Propriétés
    private string $birthdate;
    private string $placeOfBirth;
    private Member $memberPair;
    private string $profession;
    private string $familySituation;
    private string $cafNumber;
    private string $registrationDate;

    //Constructeur
    
    //Getters et Setters

    /** Méthode permettant de récupérer l'adresse mail
     * @return string L'adresse mail
     */
    public function getEmail(): string {
        return $this->email;
    }

    /** Méthode permettant de définir l'adresse mail
     * @param string L'adresse mail
     * @throws ExceptionPerso Si l'adresse mail est non valide
     */
    public function setEmail(?string $email) {
        //Vérifie si l'adresse mail est vide
        if (empty($email)) {
            $this->email = '';
        } 
        else {

            //Vérifie si l'adresse mail est valide
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->email = $email;
            } else {
                throw new ExceptionPerso("L'adresse mail n'est pas valide");
            }
        }
    }

     /** Méthode permettant de récupérer la date de naissance
     * @return string La date de naissance
     */
    public function getBirthdate() : string {
        return $this->birthdate;
    }

    /** Méthode permettant de définir la date de naissance
     * @param string La date de naissance
     * @throws ExceptionPerso Si la date de naissance est non valide
     */
    public function setBirthdate(string $birthdate) {
        $format = 'Y-m-d';
        
        //Vérifie si la date de naissance n'est pas vide
        if (empty($birthdate)) {
            throw new ExceptionPerso("La date de naissance est obligatoire");
        }
        else {

            //Vérifie si la date de naissance est au bon format
            if (date_create_from_format($format, $birthdate)) {
               list($year, $month, $day) = explode('-', $birthdate);
                $birthdate = $year . '/' . $month . '/' . $day;
                $format = 'Y/m/d';
                $dateFormat = DateTime::createFromFormat($format, $birthdate);
    
                //Vérifie si la date de naissance correspond au nouveau format défini
                if ($dateFormat && $dateFormat->format($format) == $birthdate) {
                    list($year, $month, $day) = explode('/', $birthdate);
                    
                    //Vérifie si la date de naissance est valide
                    if (checkdate($month, $day, $year)) {
                        $today = new DateTime();
                      
                        //Vérifie si la date de naissance est inférieure à la date aujourd'hui
                        if ($today > $dateFormat) {
                            $this->birthdate = $birthdate;
                        }
                        else {
                            throw new ExceptionPerso("La date de naissance n'est pas bonne");
                        }
                    }
                    else {
                        throw new ExceptionPerso("Le format de la date de naissance n'est pas valide");
                    }
                }
                else {
                    throw new ExceptionPerso("La date de naissance doit être au format comme: jour/mois/année");
                }
            }
            else {
                throw new ExceptionPerso("Veuillez renseigner votre date de naissance");
            }
        }
    }

    /** Méthode permettant de récupérer le nom du lieu de naissance
     * @return string Le nom du lieu de naissance
     */
    public function getPlaceOfBirth() : string {
        return $this->placeOfBirth;
    }

    /** Méthode permettant de définir le nom du lieu de naissance
     * @param string Le nom du lieu de naissance
     * @throws ExceptionPerso Si le nom du lieu de naissance est non valide
     */
    public function setPlaceOfBirth(string $placeOfBirth) {

        //Vérifie si le champ n'est pas vide
        if (!empty($placeOfBirth)) {
            $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';

            //Vérifie si le nom du lieu de naissance correspond au pattern
            if ($this->testInput($pattern, $placeOfBirth)) {
                $this->placeOfBirth = $placeOfBirth;
            } else {
                throw new ExceptionPerso("Le nom de la ville n'est pas valide");
            }
        } else {
            throw new ExceptionPerso("Veuillez renseigner ce champ");
        }
    }

    /** Méthode permettant de récupérer l'objet Member
     * @return Member L'objet Member
     */
    public function getMemberPair() : Member {
        return $this->memberPair;
    }

    /** Méthode permettant de définir l'objet Member
     * @param Member l'objet Member
     */
    public function setMemberPair(Member $memberPair) {
        $this->memberPair = $memberPair; 
    }

    /** Méthode permettant de récupérer le nom de la profession
     * @return string Le nom de la profession
     */
    public function getProfession() : string {
        return $this->profession;
    }

    /** Méthode permettant de définir le nom de la profession
     * @param string Le nom de la profession
     * @throws ExceptionPerso Si le nom de la profession
     */
    public function setProfession(string $profession) {
        $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';

        //Vérifie si le nom de la profession correspond au pattern
        if ($this->testInput($pattern, $profession)) {
            $this->profession = $profession;
        } else {
            throw new ExceptionPerso("Le nom de la profession n'est pas valide");
        }
    }

    /** Méthode permettant de récupérer le nom de la situation familiale
     * @return string Le nom de la situation familiale
     */
    public function getFamilySituation() : string {
        return $this->familySituation;
    }

    /** Méthode permettant de définir le nom de la situation familiale
     * @param string Le nom de la situation familiale
     * @throws ExceptionPerso Si le nom de la situation familiale
     */
    public function setFamilySituation(string $familySituation) {
        $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';

        //Vérifie si le nom de la situation familiale correspond au pattern
        if ($this->testInput($pattern, $familySituation)) {
            $this->familySituation = $familySituation;
        } else {
            throw new ExceptionPerso("Le nom de la situation de famille n'est pas valide");
        }
    }

    /** Méthode permettant de récupérer le numéro de caf
     * @return string Le numéro de caf
     */
    public function getCafNumber() : string {
        return $this->cafNumber;
    }

     /** Méthode permettant de définir le numéro de caf
     * @param string Le numéro de caf
     * @throws ExceptionPerso Si le numéro de caf est non valide
     */
    public function setCafNumber(string $cafNumber) {

        //Vérifie si le champ n'est pas vide
        if (!empty($cafNumber)) {
            $pattern = '/^\d{7}\s\d{2}$/';

            //Vérifie si le numéro de caf correspond au pattern
            if ($this->testInput($pattern, $cafNumber)) {
                $this->cafNumber = $cafNumber;
            } else {
                throw new ExceptionPerso("Le numéro d'allocation familiale n'est pas valide");
            }
        } else {
            throw new ExceptionPerso("Veuillez renseigner ce champ");
        }
    }

    public function getRegistrationDate() : string {
        return $this->registrationDate;
    }

    public function setRegistrationDate(string $registrationDate) {
        $this->registrationDate = $registrationDate;
    }
}