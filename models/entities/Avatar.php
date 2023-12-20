<?php

namespace ProjectEvs;

require_once '../../utility/exceptions/ExceptionPerso.php';

class Avatar {

    //Propriétés
    private int $id;
    private string $picture;

    //Constructeur
    
    //Getters et Setters

    /** Méthode permettant de récupérer l'id de l'avatar
     * @return int L'id de l'avatar
     */
    public function getId() : int {
        return $this->id;
    }

    /** Méthode permettant de définir l'id de l'avatar
     * @param int L'id de l'avatar
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
    
    /** Méthode permettant de récupérer le lien de l'image de l'avatar
     * @return string Le lien de l'image de l'avatar
     */
    public function getPicture() : string {
        return $this->picture;
    }

    /** Méthode permettant de définir le lien de l'image de l'avatar
     * @param string Le lien de l'image de l'avatar
     * @throws ExceptionPerso Si le lien de l'image est non valide
     */
    public function setPicture(string $picture) {
        $error = $_FILES['userfile']['error'];

        //Vérifie si error est égale à zéro
        if ($error == 0) {
            $path = '../../assets/test/';
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
                throw new ExceptionPerso("Veuillez choisir un fichier image (png ou jpeg)");
            }
        }
        else {
            throw new ExceptionPerso("Votre fichier n'a pu être envoyé, veuillez réessayer");
        }
    }
}