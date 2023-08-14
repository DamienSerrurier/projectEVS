<?php

namespace ProjectEvs;

require_once '../../utility/exceptions/ExceptionPerso.php';

class Avatar {

    //Propriétés
    private int $id;
    private string $picture;

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
    
    public function getPicture() : string {
        return $this->picture;
    }

    public function setPicture(string $picture) {
        $error = $_FILES['userfile']['error'];
        
        if ($error == 0) {
            $path = '../../assets/test/';
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
                        $this->picture = $picture;
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
}