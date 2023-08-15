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

    public function getName() : string {
        return $this->name;
    }

    public function setName(string $name) {

        if (!empty($name)) {
            $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';

            if ($this->testInput($pattern, $name)) {
                return $this->name = $name;
            } else {
                throw new ExceptionPerso("Le nom de la structure n'est pas valide");
            }
        } else {
            throw new ExceptionPerso("Veuillez renseigner ce champ");
        }
    }

    public function getLogo() : string {
        return $this->logo;
    }

    public function setLogo(string $logo) {
        $error = $_FILES['userfile']['error'];
        
        if ($error == 0) {
            $path = '../../assets/test/';
            $expectedType = ['image/png', 'image/jpeg'];
            $mineType = mime_content_type($path . $logo);
    
            if (in_array($mineType, $expectedType)) {
                $maxWidth = 1000;
                $maxHeight = 1000;
                list($width, $height) = getimagesize($path . $logo);
    
                if ($maxWidth >= $width || $maxHeight >= $height) {
                    $maxSize = 10000;
                    $fileSize = filesize($path . $logo);
    
                    if ($maxSize >= $fileSize) {
                        $pathUpload = '../../assets/img/uploadPicture/';
                        $fileName = pathinfo($_FILES['userfile']['name']);
                        $fileExtension = $fileName['extension'];
                        $newUploadFileName = uniqid($fileName['filename'], true);
                        $fileNameWithTargetDirectory = $pathUpload . $newUploadFileName . '.' . $fileExtension;
                        
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

    public function getPhone() : string {
        return $this->phone;
    }

    public function setPhone(string $phone) {
        if (!empty($phone)) {
            $pattern = '/^[0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2}$/';

            if ($this->testInput($pattern, $phone)) {
                return $this->phone = $phone;
            } else {
                throw new ExceptionPerso("Le numéro de téléphone n'est pas valide");
            }
        } else {
            throw new ExceptionPerso("Veuillez renseigner ce champ");
        }
    }

    public function getTypeStructure() : TypeStructure {
        return $this->typeStructure;
    }

    public function setTypeStructure(TypeStructure $typeStructure) {

        if ($typeStructure instanceof TypeStructure) {
            return $this->typeStructure = $typeStructure;
        }
        else {
            throw new ExceptionPerso("Ceci n'est pas une instance de la classe TypeStructure");
        }
    }

    public function getAddress() : Address {
        return $this->address;
    }

    public function setAddress(Address $address) {

        if ($address instanceof Address) {
            return $this->address = $address;
        }
        else {
            throw new ExceptionPerso("Ceci n'est pas une instance de la classe Address");
        }
    }

    public function testInput($pattern, $input) {
        return preg_match($pattern, $input);
    }
}