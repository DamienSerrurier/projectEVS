<?php

namespace ProjectEvs;

require_once '../../utility/exceptions/ExceptionPerso.php';

class Document implements RegexTester {

    //Propriétés
    private int $id;
    private string $name;
    private string $link;
    private Structure $structure;

    //Constructeur

    //Getters et Setters
    public function getId() : int {
        return $this->id;
    }

    public function setId(int $id) {

        if($id > 0) {

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

    public function getName() : string {
        return $this->name;
    }

    public function setName(string $name) {

         if (!empty($name)) {
            $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';

            if ($this->testInput($pattern, $name)) {
                $this->name = $name;
            } else {
                throw new ExceptionPerso("Le nom du document n'est pas valide");
            }
        } else {
            throw new ExceptionPerso("Veuillez renseigner ce champ");
        }
    }

    public function getLink() : string {
        return $this->link;
    }

    public function setLink(string $link) {
        $error = $_FILES['userfile']['error'];
        
        if ($error == 0) {
            $path = '../../assets/test/';
            $expectedType = ['text/plain', 'application/pdf'];
            $mineType = mime_content_type($path . $link);
    
            if (in_array($mineType, $expectedType)) {
                $pathUpload = '../../assets/img/uploadPicture/';
                $fileName = pathinfo($_FILES['userfile']['name']);
                $fileExtension = $fileName['extension'];
                $newUploadFileName = uniqid($fileName['filename'], true);
                $fileNameWithTargetDirectory = $pathUpload . $newUploadFileName . '.' . $fileExtension;
                
                if (move_uploaded_file($path, $fileNameWithTargetDirectory)) {
                    $this->link = $link;
                }
            }
            else {
                throw new ExceptionPerso("Veuillez choisir un fichier text (txt, pdf)");
            }
        }
        else {
            throw new ExceptionPerso("Votre fichier n'a pu être envoyé, veuillez réessayer");
        }
    }

    public function getStructure() : Structure {
        return $this->structure;
    }

    public function setStructure(Structure $structure) {

        if ($structure instanceof Structure) {
            $this->structure = $structure;
        }
        else {
            throw new ExceptionPerso("Ceci n'est pas une instance de la classe Structure");
        }
    }

    public function testInput($pattern, $input) {
        return preg_match($pattern, $input);
    }
}