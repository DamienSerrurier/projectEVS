<?php

namespace ProjectEvs;

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR
 . 'utility' . DIRECTORY_SEPARATOR . 'exceptions' . DIRECTORY_SEPARATOR . 'ExceptionPerso.php';

use DateTime;
use Exception;
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
    private bool $archived;
    private int $maturity;
    private Category $category;

    //Getters et Setters

    /** Méthode permettant de récupérer l'id de l'activité
     * @return int L'id de l'activité
     */
    public function getId() : int {
        return $this->id;
    }

    /** Méthode permettant de définir l'id de l'activité
     * @param int L'id de l'activité
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

    /** Méthode permettant de récupérer l'information additionelle de l'activité
     * @return string L'information additionelle de l'activité
     */
    public function getAdditionalInformation() : string {
        return $this->additionalInformation;
    }

    /** Méthode permettant de définir l'information additionelle de l'activité
     * @param string L'information additionelle de l'activité
     * @throws ExceptionPerso Si l'information additionelle est non valide
     */
    public function setAdditionalInformation(string $additionalInformation) {
        $pattern = '/^[a-zA-Z- éèêôâàîïùûç\/]+$/';

        //Vérifie si l'information additionelle correspond au pattern
        if ($this->testInput($pattern, $additionalInformation)) {
            $this->additionalInformation = $additionalInformation;
        } else {
            throw new ExceptionPerso("L'information additionnelle n'est pas valide");
        }
    }

    /** Méthode permettant de récupérer la date de début de l'activité
     * @return string La date de début de l'activité
     */
    public function getStartDate() : string {
        return $this->startDate;
    }

    /** Méthode permettant de définir la date de début de l'activité
     * @param string La date de début de l'activité
     * @throws ExceptionPerso Si la date de début est non valide
     */
    public function setStartDate(string $startDate) {

        //Vérifie si la date de début est vide
        if (empty($startDate)) {
            $this->startDate = '';
        }
        else {
            $format = 'Y-m-d';

            //Vérifie si la date de début de l'activité est au bon format
            if (date_create_from_format($format, $startDate)) {
               list($year, $month, $day) = explode('-', $startDate);
                $startDate = $year . '/' . $month . '/' . $day;
                $format = 'Y/m/d';
                $dateFormat = DateTime::createFromFormat($format, $startDate);

                //Vérifie si la date de début de l'activité correspond au nouveau format défini
                if ($dateFormat && $dateFormat->format($format) == $startDate) {
                    list($year, $month, $day) = explode('/', $startDate);

                    //Vérifie si la date de début de l'activité est valide
                    if (checkdate($month, $day, $year)) {
                        $today = new DateTime();

                        //Vérifie si la date de début de l'activité est inférieure à la date aujourd'hui
                        if ($today <= $dateFormat) {
                            $this->startDate = $startDate;
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
            else {
                throw new ExceptionPerso("Veuillez renseigner une date correcte");
            }
        }
    }

    /** Méthode permettant de récupérer la date de fin de l'activité
     * @return string La date de fin de l'activité
     */
    public function getEndDate() : string {
        return $this->endDate;
    }

    /** Méthode permettant de définir la date de fin de l'activité
     * @param string La date de fin de l'activité
     * @throws ExceptionPerso Si la date de fin est non valide
     */
    public function setEndDate(string $endDate) {

        //Vérifie si la date de fin est vide
        if (empty($endDate)) {
            $this->endDate = '';
        }
        else {
            $format = 'Y-m-d';

            //Vérifie si la date de fin de l'activité est au bon format
            if (date_create_from_format($format, $endDate)) {
               list($year, $month, $day) = explode('-', $endDate);
                $endDate = $year . '/' . $month . '/' . $day;
                $format = 'Y/m/d';
                $dateFormat = DateTime::createFromFormat($format, $endDate);

                //Vérifie si la date de fin de l'activité correspond au nouveau format défini
                if ($dateFormat && $dateFormat->format($format) == $endDate) {
                    list($year, $month, $day) = explode('/', $endDate);

                    //Vérifie si la date de fin de l'activité est valide
                    if (checkdate($month, $day, $year)) {                      
                        $this->endDate = $endDate;    
                    }
                    else {
                        throw new ExceptionPerso("Le format de la date n'est pas valide");
                    }
                }
                else {
                    throw new ExceptionPerso("La date doit être au format comme: jour/mois/année");
                }
            }
            else {
                throw new ExceptionPerso("Veuillez renseigner une date correcte");
            }
        }
    }

    /** Méthode permettant de récupérer l'heure de début de l'activité
     * @return string L'heure de début de l'activité
     */
    public function getStartHour() : string {
        return $this->startHour;
    }

    /** Méthode permettant de définir l'heure de début de l'activité
     * @param string L'heure de début de l'activité
     * @throws ExceptionPerso Si l'heure de début est non valide
     */
    public function setStartHour(string $startHour) {
        date_default_timezone_set('Europe/Paris');
        $format = 'H\h\:i';
        $hourFormat = DateTime::createFromFormat($format, $startHour);

        //Vérifie si l'heure de début de l'activité est au bon format
        if ($hourFormat && $hourFormat->format($format) == $startHour) {
            $this->startHour = $startHour;
        }
        else {
            throw new ExceptionPerso("le format de l'heure n'est pas valide comme: 10h:30");
        }
    }

    /** Méthode permettant de récupérer l'heure de fin de l'activité
     * @return string L'heure de fin de l'activité
     */
    public function getEndHour() : string {
        return $this->endHour;
    }

    /** Méthode permettant de définir l'heure de fin de l'activité
     * @param string L'heure de fin de l'activité
     * @throws ExceptionPerso Si l'heure de fin est non valide
     */
    public function setEndHour(string $endHour) {
        date_default_timezone_set('Europe/Paris');
        $format = 'H\h\:i';
        $hourFormat = DateTime::createFromFormat($format, $endHour);

        //Vérifie si l'heure de fin de l'activité est au bon format
        if ($hourFormat && $hourFormat->format($format) == $endHour) {
            $this->endHour = $endHour;
        }
        else {
            throw new ExceptionPerso("le format de l'heure n'est pas valide comme: 10h:30");
        }
    }

     /** Méthode permettant de récupérer la description de l'activité
     * @return string La description de l'activité
     */
    public function getDescription() : string {
        return $this->description;
    }

    /** Méthode permettant de définir la description de l'activité
     * @param string La description de l'activité
     */
    public function setDescription(string $description) {
        $this->description = $description;
    }

    /** Méthode permettant de récupérer le lien de l'image de l'activité
     * @return string Le lien de l'image de l'activité
     */
    public function getPicture() : string {
        return $this->picture;
    }

    /** Méthode permettant de définir le lien de l'image de l'activité
     * @param string Le lien de l'image de l'activité
     * @throws ExceptionPerso Si le lien de l'image est non valide
     */
    public function setPicture(string $picture) {
        $error = $_FILES['userfile']['error'];

        //Vérifie s'il n'y a pas d'erreur
        if ($error == 0) {
            $path = $_FILES['userfile']['tmp_name'];
            $expectedType = ['image/png', 'image/jpeg'];
            $mineType = mime_content_type($path . $picture);

            //Vérifie si le type mime de l'image correspond aux types mime définis dans le tableau
            if (in_array($mineType, $expectedType)) {
                $maxWidth = 1000;
                $maxHeight = 1000;
                list($width, $height) = getimagesize($path . $picture);

                //Vérifie si l'image ne dépasse pas une certaine dimension
                if ($maxWidth >= $width || $maxHeight >= $height) {
                    $maxSize = 10000;
                    $fileSize = filesize($path . $picture);

                    //véririe si le poid de l'image ne dépasse pas une certaine valeur 
                    if ($maxSize >= $fileSize) {
                        $pathUpload = '../../assets/img/uploadPicture/';
                        $fileName = pathinfo($_FILES['userfile']['name']);
                        $fileExtension = $fileName['extension'];
                        $newUploadFileName = uniqid($fileName['filename'], true);
                        $fileNameWithTargetDirectory = $pathUpload . $newUploadFileName . '.' . $fileExtension;
                        
                        //Vérifie si l'image peut être déplacée du fichier temporaire à la nouvelle destination
                        if (move_uploaded_file($path, $fileNameWithTargetDirectory)) {
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

    /** Méthode permettant de récupérer un mode d'archivage de l'activité
     * @return bool Le mode d'archivage
     */
    public function getArchived() {
        return $this->archived;
    }

    /** Méthode permettant de vérifier et de définir un mode d'archivage de l'activité
     * @param bool Le mode d'archivage
     * @throws ExceptionPerso Si le mode d'archivage est non valide
     */
    public function setArchived(bool $archived) {

        if (filter_var($archived, FILTER_VALIDATE_BOOL)) {
            $this->archived = $archived;
        }
        else {
            throw new ExceptionPerso("Arrêter de jouer avec mon input tipe radio");
        }
        
    }

    /** Méthode permettant de récupérer l'identifiant de la maturité
     * @return int L'identifiant de la maturité
     */
    public function getMaturity() {
        return $this->maturity;
    }

    /** Méthode permettant de vérifier et definir un choix de maturité
     * @param int L'identifiant de la maturité
     * @throws ExceptionPerso Si la maturité n'est pas renseigné ou non valide
     */
    public function setMaturity(int $maturity) {

        if (!empty($maturity)) {

            if (filter_var($maturity, FILTER_VALIDATE_INT)) {
                $this->maturity = $maturity;
            }
            else {
                throw new ExceptionPerso("Arrêtez de jouer avec mes input tipe checkbox");
            }
        }
        else {
            throw new ExceptionPerso("Veuillez faire un choix à qui sera destiner l'activité");
        }
    }

    /** Méthode permettant de récupérer l'objet Catégorie de l'activité
     * @return Category L'objet Catégorie de l'activité
     */
    public function getCategory() : Category {
        return $this->category;
    }

    /** Méthode permettant de définir l'objet Catégorie de l'activité
     * @param Category L'objet Catégorie de l'activité
     */
    public function setCategory(Category $category) {
        $this->category = $category; 
    }

    /** Méthode permettant de vérifier si une valeur correspond à un pattern donné
     * @param string $pattern Le pattern à vérifier
     * @param string $input La valeur à vérifier
     * @return boolean Renvoie true si la valeur correspond au pattern, false sinon
     */
    public function testInput($pattern, $input) {
        return preg_match($pattern, $input);
    }

    /** Méthode permettant de comparer deux dates et défini la date de fin si elle 
     * est postérieur à la date de début
     * @param string $startDate La date de début au format 'Y-m-d'
     * @param string $endDate La date de fin au format 'Y-m-d'
     * @throws ExceptionPerso Si la date de fin est antérieure ou égale à la date de début 
     */
    public function compareDates(string $startDate, string $endDate) {
        $timestampStartDate = strtotime($startDate);
        $timestampEndDate = strtotime($endDate);

        //Vérifie si la date de fin est postérieure à la date de début
        if ($timestampStartDate < $timestampEndDate) {
            $this->endDate = $endDate;
        }
        else {
            throw new ExceptionPerso("La date de fin doit être supérieur à la date de départ");
        }
    }
}