<?php

require_once 'utility/exceptions/ExceptionPerso.php';
require_once 'models/entities/RegexTester.php';
require_once 'models/managers/AccountCreationManager.php';
require_once 'models/entities/Person.php';

use ProjectEvs\ExceptionPerso;
use ProjectEvs\Person;

session_start();

if (isset($_POST['userCreate'])) {

    $lastname = isset($_POST['lastname']) && !empty($_POST['lastname']) ? htmlspecialchars(trim($_POST['lastname'])) : '';
    $firstname = isset($_POST['firstname']) && !empty($_POST['firstname']) ? htmlspecialchars(trim($_POST['firstname'])) : '';
    $mail = isset($_POST['mail']) && !empty($_POST['mail']) ? htmlspecialchars(trim($_POST['mail'])) : '';
    $passw = isset($_POST['passw']) && !empty($_POST['passw']) ? htmlspecialchars(trim($_POST['passw'])) : '';
    $confPassw = isset($_POST['confPassw']) && !empty($_POST['confPassw']) ? htmlspecialchars(trim($_POST['confPassw'])) : '';

    $person = new Person();
    $infoMessages = [];
    $arrayParametters = [];

    try {
        $arrayParametters['lastname'] =  $person->setLastname($lastname);

    } 
    catch (ExceptionPerso $e) {
        $infoMessages['lastname'] = $e->getMessage();
    }

    try {
        $arrayParametters['firstname'] =  $person->setFirstname($firstname);

    } 
    catch (ExceptionPerso $e) {
        $infoMessages['firstname'] = $e->getMessage();
    }

    try {
        $arrayParametters['mail'] =  $person->setEmail($mail);

    } 
    catch (ExceptionPerso $e) {
        $infoMessages['mail'] = $e->getMessage();
    }

    if (($passw == $confPassw)) {

        try {
            $arrayParametters['passw'] =  $person->setPassword($passw);

        }
        catch (ExceptionPerso $e) {
            $infoMessages['passw'] = $e->getMessage();
        }
    }
    else {
        $infoMessages['confPassw'] = "Le mot de passe et de confirmation doivent être indentique";
    }

    try {
        if (empty($infoMessages)) {
            AccountCreationManager::insertUser($arrayParametters);
            header('Location: home');
        }
    }
    catch (ExceptionPersoDAO $e) {
        $warningMessage = $e->getMessage();
    }
}

require_once 'views/accountCreation.php';
