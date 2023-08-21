<?php

//Définition de l'espace de noms "ProjectEvs"
namespace ProjectEvs;

//Définition de l'interface "RegexTester"
interface RegexTester {

    //Déclaration de la méthode "testInput"
    //Cette méthode est destinée à être implémentée par toute classe qui utilise cette interface
    //Elle prend deux paramètres : 
    //$pattern une expression régulière
    //$input la chaîne de caractères à tester avec cette expression régulière
    public function testInput($pattern, $input);
}