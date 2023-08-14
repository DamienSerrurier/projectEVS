<?php

namespace ProjectEvs;

require_once '../../utility/exceptions/ExceptionPerso.php';

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
    public function getBirthdate() : string {
        return $this->birthdate;
    }

    public function setBirthdate(string $birthdate) {
        $format = 'd/m/Y';
        $dateFormat = DateTime::createFromFormat($format, $birthdate);
        
        if ($dateFormat && $dateFormat->format($format) == $birthdate) {
            list($day, $month, $year) = explode('/', $birthdate);
            
            if (checkdate($month, $day, $year)) {
                $today = date('m/d/Y');
                $timestampToday = strtotime($today);
                $timestampbirthdate = strtotime($birthdate);
    
                if ($timestampToday > $timestampbirthdate) {
                    return $this->birthdate = $birthdate;
                }
                else {
                    throw new ExceptionPerso("La date de naissance n'est bonne");
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

    public function getPlaceOfBirth() : string {
        return $this->placeOfBirth;
    }

    public function setPlaceOfBirth(string $placeOfBirth) {

        if (!empty($placeOfBirth)) {
            $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';

            if ($this->testInput($pattern, $placeOfBirth)) {
                return $this->placeOfBirth = $placeOfBirth;
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
            return $this->memberPair = $memberPair;
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
            return $this->profession = $profession;
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
            return $this->familySituation = $familySituation;
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
                return $this->cafNumber = $cafNumber;
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