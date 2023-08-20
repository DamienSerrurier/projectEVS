<?php

namespace ProjectEvs;

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR
 . 'utility' . DIRECTORY_SEPARATOR . 'exceptions' . DIRECTORY_SEPARATOR . 'ExceptionPerso.php';

use DateTime;
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
    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(?string $email) {

        if ($email == '') {
            $this->email = '';
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;
        } else {
            throw new ExceptionPerso("L'adresse mail n'est pas valide");
        }
    }

    public function getBirthdate() : string {
        return $this->birthdate;
    }

    public function setBirthdate(string $birthdate) {
        $format = 'Y-m-d';

        if (date_create_from_format($format, $birthdate)) {
           list($year, $month, $day) = explode('-', $birthdate);
            $birthdate = $year . '/' . $month . '/' . $day;
            $format = 'Y/m/d';
            $dateFormat = DateTime::createFromFormat($format, $birthdate);

            if ($dateFormat && $dateFormat->format($format) == $birthdate) {
                list($year, $month, $day) = explode('/', $birthdate);
                
                if (checkdate($month, $day, $year)) {
                    $today = new DateTime();
                  
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

    public function getPlaceOfBirth() : string {
        return $this->placeOfBirth;
    }

    public function setPlaceOfBirth(string $placeOfBirth) {

        if (!empty($placeOfBirth)) {
            $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';

            if ($this->testInput($pattern, $placeOfBirth)) {
                $this->placeOfBirth = $placeOfBirth;
            } else {
                throw new ExceptionPerso("Le nom de la ville n'est pas valide");
            }
        } else {
            throw new ExceptionPerso("Veuillez renseigner ce champ");
        }
    }

    public function getMemberPair() : Member {
        return $this->memberPair;
    }

    public function setMemberPair(Member $memberPair) {

        if ($memberPair instanceof Member) {
            $this->memberPair = $memberPair;
        }
        else {
            throw new ExceptionPerso("Ceci n'est pas une instance de la classe Member");
        }
    }

    public function getProfession() : string {
        return $this->profession;
    }

    public function setProfession(string $profession) {
        $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';

        if ($this->testInput($pattern, $profession)) {
            $this->profession = $profession;
        } else {
            throw new ExceptionPerso("Le nom de la profession n'est pas valide");
        }
    }

    public function getFamilySituation() : string {
        return $this->familySituation;
    }

    public function setFamilySituation(string $familySituation) {
        $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';

        if ($this->testInput($pattern, $familySituation)) {
            $this->familySituation = $familySituation;
        } else {
            throw new ExceptionPerso("Le nom de la situation de famille n'est pas valide");
        }
    }

    public function getCafNumber() : string {
        return $this->cafNumber;
    }

    public function setCafNumber(string $cafNumber) {

        if (!empty($cafNumber)) {
            $pattern = '/^\d{7}\s\d{2}$/';

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