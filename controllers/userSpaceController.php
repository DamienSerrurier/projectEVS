<?php

require_once 'utility/exceptions/ExceptionPerso.php';
require_once 'models/entities/RegexTester.php';
require_once 'models/managers/userSpaceManager.php';
require_once 'models/entities/Person.php';
require_once 'models/entities/Member.php';
require_once 'models/entities/Civility.php';
require_once 'app/function.php';

use ProjectEvs\ExceptionPerso;
use ProjectEvs\Person;
use ProjectEvs\Member;

sessionStartWithGenerateToken('token');

try {
    $resultCivility = UserSpaceManager::getAllCivility();
}
catch (ExceptionPersoDAO $e) {
    $warningMessage = $e->getMessage();
} 



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

            try {
                if (empty($infoMessages)) {

                    if (UserSpaceManager::updateUser($arrayParametters)) {
                        $_SESSION['success'] = "Votre profile utilisateur a bien été modifié";
                        session_write_close();
                        header('Location: userSpace?idUser=' . $cleanId);
                    }
                }
            }
            catch (ExceptionPersoDAO $e) {
                $warningMessage = $e->getMessage();
            }
        }

        if (isset($_POST['userDelete'])) {

            $id = isset($_SESSION['user']['id']) ? htmlspecialchars($_SESSION['user']['id']) : '';

            $person = new Person();
            $person->setId($id);
            $cleanId = $person->getid();

            try {
                if (UserSpaceManager::deleteUser($cleanId)) {
                    session_unset();
                    session_destroy();
                    session_regenerate_id(true);
                    session_write_close();
                    header('Location: home');
                }
            }
            catch (ExceptionPersoDAO $e) {
                $warningMessage = $e->getMessage();
            }
        }

        
    }
}

sessionStartWithGenerateToken('token1');

if (isset($_POST['token1'])) {
    
    if ($_POST['token1'] != $_SESSION['token1']) {
        die("Jeton CSRF invalide");
    }
    else {
        if (isset($_POST['memberCreate'])) {

            $id = isset($_SESSION['user']['id']) ? htmlspecialchars($_SESSION['user']['id']) : '';
            $memberCivility = isset($_POST['memberCivility']) && !empty($_POST['memberCivility']) ? htmlspecialchars(trim($_POST['memberCivility'])) : '';
            $memberLastname = isset($_POST['memberLastname']) && !empty($_POST['memberLastname']) ? htmlspecialchars(trim($_POST['memberLastname'])) : '';
            $memberFirstname = isset($_POST['memberFirstname']) && !empty($_POST['memberFirstname']) ? htmlspecialchars(trim($_POST['memberFirstname'])) : '';
            $memberMail = isset($_POST['memberMail']) && !empty($_POST['memberMail']) ? htmlspecialchars(trim($_POST['memberMail'])) : null;
            $memberPhone = isset($_POST['memberPhone']) && !empty($_POST['memberPhone']) ? htmlspecialchars(trim($_POST['memberPhone'])) : null;
            $memberBirthdate = isset($_POST['memberBirthdate']) && !empty($_POST['memberBirthdate']) ? htmlspecialchars(trim($_POST['memberBirthdate'])) : '';
            $memberBirthPlace = isset($_POST['memberBirthPlace']) && !empty($_POST['memberBirthPlace']) ? htmlspecialchars(trim($_POST['memberBirthPlace'])) : '';

            $confPassw = isset($_POST['confPassw']) && !empty($_POST['confPassw']) ? htmlspecialchars(trim($_POST['confPassw'])) : '';

            $member = new Member();
            $infoMessages = [];
            $arrayParametters = [];

            try {
                $arrayParametters['id'] =  $member->setId($id);
            } 
            catch (ExceptionPerso $e) {
                $infoMessages['id'] = $e->getMessage();
            }
            
            try {
                $arrayParametters['memberLastname'] =  $member->setLastname($memberLastname);
            } 
            catch (ExceptionPerso $e) {
                $infoMessages['memberLastname'] = $e->getMessage();
            }
            
            try {
                $arrayParametters['memberFirstname'] =  $member->setFirstname($memberFirstname);
            } 
            catch (ExceptionPerso $e) {
                $infoMessages['memberFirstname'] = $e->getMessage();
            }
            
            try {
                $arrayParametters['memberMail'] =  $member->setEmail($memberMail);
            } 
            catch (ExceptionPerso $e) {
                $infoMessages['memberMail'] = $e->getMessage();
            }
            
            try {
                $arrayParametters['memberPhone'] =  $member->setPhone($memberPhone);
            }
            catch (ExceptionPerso $e) {
                $infoMessages['memberPhone'] = $e->getMessage();
            }

            try {
                $arrayParametters['memberBirthdate'] =  $member->setBirthdate($memberBirthdate);
            }
            catch (ExceptionPerso $e) {
                $infoMessages['memberBirthdate'] = $e->getMessage();
            }

            try {
                $arrayParametters['memberBirthPlace'] =  $member->setBirthdate($memberBirthPlace);
            }
            catch (ExceptionPerso $e) {
                $infoMessages['memberBirthPlace'] = $e->getMessage();
            }

            try {
                if (empty($infoMessages)) {

                    var_dump($arrayParametters);
                }
            }
            catch (ExceptionPersoDAO $e) {
                $warningMessage = $e->getMessage();
            }
        }
    }
}

require_once 'views/userSpace.php';