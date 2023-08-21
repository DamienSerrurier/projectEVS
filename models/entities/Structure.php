<?php

namespace ProjectEvs;

require_once '../../utility/exceptions/ExceptionPerso.php';

class Structure implements RegexTester {

    //Propriétés
    private int $id;
    private string $name;
    private string $logo;
    private string $phone;
    private TypeStructure $typeStructure;
    private Address $address;

    //Constructeur
    
    //Getters et Setters

    /** Méthode permettant de récupérer l'id de la structure
     * @return int L'id de la structure
     */
    public function getId() : int {
        return $this->id;
    }

    /** Méthode permettant de définir l'id de la structure
     * @param int L'id de la structure
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

    /** Méthode permettant de récupérer le nom de la structure
     * @return string Le nom de la structure
     */
    public function getName() : string {
        return $this->name;
    }

    /** Méthode permettant de définir le nom de la structure
     * @param string Le nom de la structure
     * @throws ExceptionPerso Si le nom de la structure est non valide
     */
    public function setName(string $name) {

        //Vérifie si le champ n'est pas vide
        if (!empty($name)) {
            $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';

            //Vérifie si le nom de la structure correspond au pattern
            if ($this->testInput($pattern, $name)) {
                $this->name = $name;
            } else {
                throw new ExceptionPerso("Le nom de la structure n'est pas valide");
            }
        } else {
            throw new ExceptionPerso("Veuillez renseigner ce champ");
        }
    }

    /** Méthode permettant de récupérer le lien de l'image du logo
     * @return string Le lien de l'image du logo
     */
    public function getLogo() : string {
        return $this->logo;
    }

    /** Méthode permettant de définir le lien de l'image du logo
     * @param string Le lien de l'image du logo
     * @throws ExceptionPerso Si le lien de l'image est non valide
     */
    public function setLogo(string $logo) {
        $error = $_FILES['userfile']['error'];
        
        //Vérifie s'il n'y a pas d'erreur
        if ($error == 0) {
            $path = '../../assets/test/';
            $expectedType = ['image/png', 'image/jpeg'];
            $mineType = mime_content_type($path . $logo);
    
            //Vérifie si le type mime de l'image correspond aux types mime définis dans le tableau
            if (in_array($mineType, $expectedType)) {
                $maxWidth = 1000;
                $maxHeight = 1000;
                list($width, $height) = getimagesize($path . $logo);
    
                //Vérifie si l'image ne dépasse pas une certaine dimension
                if ($maxWidth >= $width || $maxHeight >= $height) {
                    $maxSize = 10000;
                    $fileSize = filesize($path . $logo);
    
                    //véririe si le poid de l'image ne dépasse pas une certaine valeur 
                    if ($maxSize >= $fileSize) {
                        $pathUpload = '../../assets/img/uploadPicture/';
                        $fileName = pathinfo($_FILES['userfile']['name']);
                        $fileExtension = $fileName['extension'];
                        $newUploadFileName = uniqid($fileName['filename'], true);
                        $fileNameWithTargetDirectory = $pathUpload . $newUploadFileName . '.' . $fileExtension;
                        
                        //Vérifie si l'image peut être déplacée du fichier temporaire à la nouvelle destination
                        if (move_uploaded_file($path, $fileNameWithTargetDirectory)) {
                            $this->logo = $logo;
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

    /** Méthode permettant de récupérer le numéro de téléphone de la structure
     * @return string Le numéro de téléphone de la structure
     */
    public function getPhone() : string {
        return $this->phone;
    }

    /** Méthode permettant de définir le numéro de téléphone de la structure
     * @param string Le numéro de téléphone de la structure
     * @throws ExceptionPerso Si le numéro de téléphone de la structure est non valide
     */
    public function setPhone(string $phone) {

        //Vérifie si le champ n'est pas vide
        if (!empty($phone)) {
            $pattern = '/^[0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2}$/';

            //Vérifie si le numéro de téléphone de la structure correspond au pattern
            if ($this->testInput($pattern, $phone)) {
                $this->phone = $phone;
            } else {
                throw new ExceptionPerso("Le numéro de téléphone n'est pas valide");
            }
        } else {
            throw new ExceptionPerso("Veuillez renseigner ce champ");
        }
    }

    /** Méthode permettant de récupérer l'objet TypeStructure
     * @return TypeStructure l'objet TypeStructure
     */
    public function getTypeStructure() : TypeStructure {
        return $this->typeStructure;
    }

    /** Méthode permettant de définir l'objet TypeStructure
     * @param TypeStructure l'objet TypeStructure
     */
    public function setTypeStructure(TypeStructure $typeStructure) {
        $this->typeStructure = $typeStructure;
    }

    /** Méthode permettant de récupérer l'objet Address
     * @return Address l'objet Address
     */
    public function getAddress() : Address {
        return $this->address;
    }

    /** Méthode permettant de définir l'objet Address
     * @param Address l'objet Address
     */
    public function setAddress(Address $address) {
        $this->address = $address; 
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