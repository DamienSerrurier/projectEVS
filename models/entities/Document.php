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

     /** Méthode permettant de récupérer l'id du document
     * @return int L'id du document
     */
    public function getId() : int {
        return $this->id;
    }

    /** Méthode permettant de définir l'id du document
     * @param int L'id du document
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

     /** Méthode permettant de récupérer le nom du document
     * @return string Le nom du document
     */
    public function getName() : string {
        return $this->name;
    }

    /** Méthode permettant de définir le nom du document
     * @param string Le nom du document
     * @throws ExceptionPerso Si le nom du document est non valide
     */
    public function setName(string $name) {

        //Vérifie si le champ n'est pas vide
         if (!empty($name)) {
            $pattern = '/^[a-zA-Z- éèêôâàîïùûç]+$/';

            //Vérifie si le nom de document correspond au pattern
            if ($this->testInput($pattern, $name)) {
                $this->name = $name;
            } else {
                throw new ExceptionPerso("Le nom du document n'est pas valide");
            }
        } else {
            throw new ExceptionPerso("Veuillez renseigner ce champ");
        }
    }

    /** Méthode permettant de récupérer le lien du document
     * @return string Le lien du document
     */
    public function getLink() : string {
        return $this->link;
    }

    /** Méthode permettant de définir le lien du document
     * @param string Le lien du document
     * @throws ExceptionPerso Si le lien du document est non valide
     */
    public function setLink(string $link) {
        $error = $_FILES['userfile']['error'];
        
        //Vérifie s'il n'y a pas d'erreur
        if ($error == 0) {
            $path = '../../assets/test/';
            $expectedType = ['text/plain', 'application/pdf'];
            $mineType = mime_content_type($path . $link);
    
            //Vérifie si le type mime du document correspond aux types mime définis dans le tableau
            if (in_array($mineType, $expectedType)) {
                $pathUpload = '../../assets/uploadDocument/';
                $fileName = pathinfo($_FILES['userfile']['name']);
                $fileExtension = $fileName['extension'];
                $newUploadFileName = uniqid($fileName['filename'], true);
                $fileNameWithTargetDirectory = $pathUpload . $newUploadFileName . '.' . $fileExtension;
                
                //Vérifie si le document peut être déplacée du fichier temporaire à la nouvelle destination
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

    /** Méthode permettant de récupérer l'objet Structure
     * @return Structure l'objet Structure
     */
    public function getStructure() : Structure {
        return $this->structure;
    }

    /** Méthode permettant de définir l'objet Structure
     * @param Structure l'objet Structure
     */
    public function setStructure(Structure $structure) {
        $this->structure = $structure;
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