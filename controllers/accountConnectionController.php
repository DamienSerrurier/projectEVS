<?php

require_once 'utility/exceptions/ExceptionPerso.php';
require_once 'models/entities/RegexTester.php';
require_once 'models/managers/AccountConnecionManager.php';
require_once 'models/entities/Person.php';
require_once 'models/entities/Role.php';
require_once 'app/function.php';

use ProjectEvs\ExceptionPerso;
use ProjectEvs\Person;
use ProjectEvs\Role;

sessionStartWithGenerateToken();

if (isset($_POST['token'])) {

    if ($_POST['token'] != $_SESSION['token']) {
        die("Jeton CSRF invalide");
    }
    else {
        if (isset($_POST['userConnection'])) {
        
            $mail = isset($_POST['mail']) && !empty($_POST['mail']) ? htmlspecialchars(trim($_POST['mail'])) : '';
            $passw = isset($_POST['passw']) && !empty($_POST['passw']) ? htmlspecialchars(trim($_POST['passw'])) : '';
        
            $person = new Person();
            $infoMessages = [];
        
            try {
                $cleanEmail =  $person->setEmail($mail);
                $resultQuery = AccountConnectionManager::verifyInfoUserConnection($cleanEmail);
            }
            catch (ExceptionPerso $e){
                $infoMessages['mail'] = $e->getMessage();
            }
            
            if(!empty($resultQuery)) {
        
                $person->setId($resultQuery['id']);
                $person->setEmail($resultQuery['email']);
                $person->setHachedPassword($resultQuery['password']);
                
                $role = new Role();
                $role->setId($resultQuery['id']);
                $role->setName($resultQuery['name']);
        
                if (password_verify($passw, $person->getPassword())) {
        
                    $userRole = [];
                    $userRole['id'] = $person->getid();
                    $userRole['email'] = $person->getEmail();
                    $userRole['password'] = $person->getPassword();
                    $userRole['id'] = $role->getId();
                    $userRole['name'] = $role->getName();
                    $_SESSION['user'] = $userRole;
        
                    header('Location: userSpace');
                }
                else {
                    $infoMessages['passw'] = "Vérifier vos identifiants";
                }
            }
            else {
                $infoMessages['passw'] = "Vérifier vos identifiants";
            }
        }
    }
}

require_once 'views/accountConnection.php';