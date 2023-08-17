<?php

require_once 'utility/exceptions/ExceptionPerso.php';
require_once 'models/entities/RegexTester.php';
require_once 'models/managers/userSpaceManager.php';
require_once 'models/entities/Person.php';
require_once 'app/function.php';

use ProjectEvs\ExceptionPerso;
use ProjectEvs\Person;

sessionStartWithGenerateToken();

if (isset($_SESSION['user']['id'])) {

    $id = isset($_SESSION['user']['id']) ? htmlspecialchars($_SESSION['user']['id']) : '';

    $person = new Person();
    $person->setId($id);
    $cleanId = $person->getId();
    $resultQuery = UserSpaceManager::getOneUserById($cleanId);
}

if (isset($_POST['token'])) {
    
    if ($_POST['token'] != $_SESSION['token']) {
        die("Jeton CSRF invalide");
    }
    else {
        var_dump('ok');
        if (isset($_POST['userUpdate'])) {

            $id = isset($_SESSION['user']['id']) ? htmlspecialchars($_SESSION['user']['id']) : '';
            $lastname = isset($_POST['lastname']) && !empty($_POST['lastname']) ? htmlspecialchars(trim($_POST['lastname'])) : '';
            $firstname = isset($_POST['firstname']) && !empty($_POST['firstname']) ? htmlspecialchars(trim($_POST['firstname'])) : '';
            $mail = isset($_POST['mail']) && !empty($_POST['mail']) ? htmlspecialchars(trim($_POST['mail'])) : '';
            $phone = isset($_POST['phone']) && !empty($_POST['phone']) ? htmlspecialchars(trim($_POST['phone'])) : null;
            $passw = isset($_POST['passw']) && !empty($_POST['passw']) ? htmlspecialchars(trim($_POST['passw'])) : '';
            $confPassw = isset($_POST['confPassw']) && !empty($_POST['confPassw']) ? htmlspecialchars(trim($_POST['confPassw'])) : '';

            $person = new Person();
            $infoMessages = [];
            $arrayParametters = [];
            try {
                $arrayParametters['id'] =  $person->setId($id);
            } 
            catch (ExceptionPerso $e) {
                $infoMessages['id'] = $e->getMessage();
            }
            
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
            
            try {
                $arrayParametters['phone'] =  $person->setPhone($phone);
                var_dump($arrayParametters['phone']);
            }
            catch (ExceptionPerso $e) {
                $infoMessages['phone'] = $e->getMessage();
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
            var_dump($arrayParametters);
            try {
                if (empty($infoMessages)) {
                    UserSpaceManager::updateUser($arrayParametters);
                    header('Location: userSpace');
                }
            }
            catch (ExceptionPersoDAO $e) {
                $warningMessage = $e->getMessage();
            }
        }
    }
}
require_once 'views/userSpace.php';