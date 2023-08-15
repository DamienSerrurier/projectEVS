<?php

namespace ProjectEvs;

require_once '../../utility/exceptions/ExceptionPerso.php';

use DateTime;
use ProjectEvs\ExceptionPerso;

class Activity implements RegexTester {

    //Propriétés
    private int $id;
    private string $additionalInformation;
    private string $startDate;
    private string $endDate;
    private string $startHour;
    private string $endHour;
    private string $description;
    private string $picture;
    private Category $category;

    //Constructeur

    //Getters et Setters
    public function getId() : int {
        return $this->id;
    }

    public function setId(int $id) {

        if($id > 0) {

            if (filter_var($id, FILTER_VALIDATE_INT)) {
                return $this->id = $id;
            } else {
                throw new ExceptionPerso("Arrêtez de jouer avec mes post");
            }
        }
        else {
            throw new ExceptionPerso('La valeur doit être positif et supérieur à 0');
        }
    }

    public function getAdditionalInformation() : string {
        return $this->additionalInformation;
    }

    public function setAdditionalInformation(string $additionalInformation) {
        $pattern = '/^[a-zA-Z- éèêôâàîïùûç\/]+$/';

        if ($this->testInput($pattern, $additionalInformation)) {
            return $this->additionalInformation = $additionalInformation;
        } else {
            throw new ExceptionPerso("L'information additionnelle n'est pas valide");
        }
    }

    public function getStartDate() : string {
        return $this->startDate;
    }

    public function setStartDate(string $startDate) {
        $format = 'd/m/Y';
        $dateFormat = DateTime::createFromFormat($format, $startDate);
        
        if ($dateFormat && $dateFormat->format($format) == $startDate) {
            list($day, $month, $year) = explode('/', $startDate);
            
            if (checkdate($month, $day, $year)) {
                $today = date('m/d/Y');
                $timestampToday = strtotime($today);
                $timestampstartDate = strtotime($startDate);
    
                if ($timestampToday <= $timestampstartDate) {
                    return $this->startDate = $startDate;
                }
                else {
                    throw new ExceptionPerso(
                        "La date du début doit être supérieure ou égale à celle d'aujoud'hui"
                    );
                }
            }
            else {
                throw new ExceptionPerso("Le format de la date n'est pas valide");
            }
        }
        else {
            throw new ExceptionPerso("La date doit être au format comme: jour/mois/année");
        }
    }

    public function getEndDate() : string {
        return $this->endDate;
    }

    public function setEndDate(string $endDate) {
        $format = 'd/m/Y';
        $dateFormat = DateTime::createFromFormat($format, $endDate);

        if ($dateFormat && $dateFormat->format($format) == $endDate) {
        list($day, $month, $year) = explode('/', $endDate);

            if (checkdate($month, $day, $year)) {
                return $this->endDate = $endDate; 
            }
            else {
                throw new ExceptionPerso("Le format de la date n'est pas valide");
            }
        }
        else {
            throw new ExceptionPerso("La date doit être au format comme: jour/mois/année");
        }
    }

    public function getStartHour() : string {
        return $this->startHour;
    }

    public function setStartHour(string $startHour) {
        date_default_timezone_set('Europe/Paris');
        $format = 'H\h\:i';
        $hourFormat = DateTime::createFromFormat($format, $startHour);
        
        if ($hourFormat && $hourFormat->format($format) == $startHour) {
            return $this->startHour = $startHour;
        }
        else {
            throw new ExceptionPerso("le format de l'heure n'est pas valide comme: 10h:30");
        }
    }

    public function getEndHour() : string {
        return $this->endHour;
    }

    public function setEndHour(string $endHour) {
        date_default_timezone_set('Europe/Paris');
        $format = 'H\h\:i';
        $hourFormat = DateTime::createFromFormat($format, $endHour);
        
        if ($hourFormat && $hourFormat->format($format) == $endHour) {
            return $this->endHour = $endHour;
        }
        else {
            throw new ExceptionPerso("le format de l'heure n'est pas valide comme: 10h:30");
        }
    }

    public function getDescription() : string {
        return $this->description;
    }

    public function setDescription(string $description) {
        $this->description = $description;
    }

    public function getPicture() : string {
        return $this->picture;
    }

    public function setPicture(string $picture) {
        $error = $_FILES['userfile']['error'];
        
        if ($error == 0) {
            $path = $_FILES['userfile']['tmp_name'];
            $expectedType = ['image/png', 'image/jpeg'];
            $mineType = mime_content_type($path . $picture);
    
            if (in_array($mineType, $expectedType)) {
                $maxWidth = 1000;
                $maxHeight = 1000;
                list($width, $height) = getimagesize($path . $picture);
    
                if ($maxWidth >= $width || $maxHeight >= $height) {
                    $maxSize = 10000;
                    $fileSize = filesize($path . $picture);
                    
                    if ($maxSize >= $fileSize) {
                        $pathUpload = 'C:\\Logiciels\\laragon\\www\\projectEvs\\assets\\img\\uploadPicture\\';
                        $fileName = pathinfo($_FILES['userfile']['name']);
                        $fileExtension = $fileName['extension'];
                        $newUploadFileName = uniqid($fileName['filename'], true);
                        $fileNameWithTargetDirectory = $pathUpload . $newUploadFileName . '.' . $fileExtension;
                        
                        if (move_uploaded_file($path, $fileNameWithTargetDirectory)) {
                            var_dump('ok');
                            $this->picture = $picture;
                        }
                    }
                    else {
                        throw new ExceptionPerso("Votre fichier est trop lourd, la taille maximale est de 10ko");
                    }
                }
                else {
                    throw new ExceptionPerso("Veuillez réduire la taille de l'image à 1000x1000");
                }
            }
            else {
                throw new ExceptionPerso("Veuillez choisir un fichier image (png, jpeg / jpg ou GIF)");
            }
            
        }
        else {
            throw new ExceptionPerso("Votre fichier n'a pu être envoyé, veuillez réessayer");
        }
    }

    public function getCategory() : Category {
        return $this->category;
    }

    public function setCategory(Category $category) {

        if ($category instanceof Category) {
            return $this->category = $category;
        }
        else {
            throw new ExceptionPerso("Ceci n'est pas une instance de la classe Category");
        }
    }

    public function testInput($pattern, $input) {
        return preg_match($pattern, $input);
    }

    public function compareDates(string $startDate, string $endDate) {
        $startDatePart = explode('/', $startDate);
        $formateStartDate = $startDatePart[1] . '/' . $startDatePart[0] . '/' . $startDatePart[2];
        $timestampStartDate = strtotime($formateStartDate);
        $endDatePart = explode('/', $endDate);
        $formateEndDate = $endDatePart[1] . '/' . $endDatePart[0] . '/' . $endDatePart[2];
        $timestampEndDate = strtotime($formateEndDate);

        if ($timestampStartDate < $timestampEndDate) {
            return $this->endDate = $endDate;
        }
        else {
            throw new ExceptionPerso("La date du début doit être supérieur à la date de départ");
        }
    }

    public function moveUploadedFile() {

    } 
}