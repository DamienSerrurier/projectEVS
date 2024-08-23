<?php

//Dépendance
require_once 'utility/exceptions/ExceptionPerso.php';
require_once 'utility/function.php';
require_once 'models/entities/RegexTester.php';
require_once 'models/managers/userSpaceManager.php';
require_once 'models/entities/Person.php';
require_once 'models/entities/Member.php';
require_once 'models/entities/Civility.php';
require_once 'models/entities/Address.php';
require_once 'models/entities/Supervisor.php';

//Fichiers utilisés dans un namespace
use ProjectEvs\ExceptionPerso;
use ProjectEvs\Person;
use ProjectEvs\Member;
use ProjectEvs\Civility;
use ProjectEvs\Address;
use ProjectEvs\Supervisor;

//Fonction d'initialisation d'une session et d'un token
sessionStartWithGenerateToken('token');

//Fonction d'initialisation de la connexion à la base de données permettant aussi d'éffectuer des commits et rollbBacks
$pdo = baseConnection();

try {
    $resultCivility = UserSpaceManager::getAllCivility();
} catch (ExceptionPersoDAO $e) {
    $_SESSION['warning'] = $e->getMessage();
}

if (isset($_GET['responsible']) && $_GET['responsible'] >= 0) {
    $responsible = htmlspecialchars($_GET['responsible']);
    
    if (filter_var($responsible, FILTER_VALIDATE_INT)) {
        $_SESSION['responsible'] = $responsible;
    }
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
    
    } else {

        if (isset($_POST['updateUser'])) {
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
                $person->setId((int) $id);
                $arrayParametters['id'] = $person->getId();
            } 
            catch (ExceptionPerso $e) {
                $infoMessages['id'] = $e->getMessage();
            }

            try {
                $person->setLastname($lastname);
                $arrayParametters['lastname'] = $person->getLastname();
            } 
            catch (ExceptionPerso $e) {
                $infoMessages['lastname'] = $e->getMessage();
            }

            try {
                $person->setFirstname($firstname);
                $arrayParametters['firstname'] = $person->getFirstname();
            } 
            catch (ExceptionPerso $e) {
                $infoMessages['firstname'] = $e->getMessage();
            }

            try {
                $person->setEmail($mail);
                $arrayParametters['mail'] = $person->getEmail();
            } 
            catch (ExceptionPerso $e) {
                $infoMessages['mail'] = $e->getMessage();
            }

            try {
                $person->setPhone($phone);
                $arrayParametters['phone'] = $person->getPhone();
            } 
            catch (ExceptionPerso $e) {
                $infoMessages['phone'] = $e->getMessage();
            }

            if (($passw == $confPassw)) {
                
                try {
                    $person->setPassword($passw);
                    $arrayParametters['passw'] = $person->getPassword();
                } 
                catch (ExceptionPerso $e) {
                    $infoMessages['passw'] = $e->getMessage();
                }
            } else {
                $infoMessages['confPassw'] = "Le mot de passe et de confirmation doivent être indentique";
            }

            try {
                
                if (empty($infoMessages)) {
                    var_dump($arrayParametters);
                    if (UserSpaceManager::updateUser($arrayParametters)) {
                        $_SESSION['success'] = "Votre profile utilisateur a bien été modifié";
                        session_write_close();
                        header('Location: userSpace?idUser=' . $cleanId);
                    }
                }
            } catch (ExceptionPersoDAO $e) {
                $_SESSION['warning'] = $e->getMessage();
            }
        }

        if (isset($_POST['deleteUser'])) {
            $id = isset($_SESSION['user']['id']) ? htmlspecialchars($_SESSION['user']['id']) : '';
            $person = new Person();
            $person->setId($id);
            $cleanId = $person->getid();

            try {
                if (UserSpaceManager::deleteUser($cleanId)) {
                    session_unset();
                    session_destroy();
                    session_regenerate_id(true);
                    header('Location: home');
                }
            } catch (ExceptionPersoDAO $e) {
                $_SESSION['warning'] = $e->getMessage();
            }
        }
    }
}

sessionStartWithGenerateToken('token1');

if (isset($_POST['token1'])) {

    if ($_POST['token1'] != $_SESSION['token1']) {
        die("Jeton CSRF invalide");

    } else {

        if (isset($_POST['createMember'])) {
            
            if (isset($_SESSION['responsible']) && $_SESSION['responsible'] > 0) {
                $maxNumberResponsible = (int) $_SESSION['responsible'];
                $idMemberPair;
                
                $id = isset($_SESSION['user']['id']) && !empty($_SESSION['user']['id']) ? htmlspecialchars($_SESSION['user']['id']) : null;
                
                for ($i = 1; $i <= $maxNumberResponsible; $i++) {
                    $members[$i] = new Member();
                    $civilities[$i] = new Civility();
                    $addresses[$i] = new Address();
                    $supervisors[$i] = new Supervisor();
                    $arrayInfoMessages[$i] = [];
                    $arrayParametters[$i] = [];
                    
                    $memberCivility = isset($_POST['memberCivility' . $i]) && !empty($_POST['memberCivility' . $i]) ? htmlspecialchars(trim($_POST['memberCivility' . $i])) : '';
                    $memberLastname = isset($_POST['memberLastname' . $i]) && !empty($_POST['memberLastname' . $i]) ? htmlspecialchars(trim($_POST['memberLastname' . $i])) : '';
                    $memberFirstname = isset($_POST['memberFirstname' . $i]) && !empty($_POST['memberFirstname' . $i]) ? htmlspecialchars(trim($_POST['memberFirstname' . $i])) : '';
                    $memberMail = isset($_POST['memberMail' . $i]) && !empty($_POST['memberMail' . $i]) ? htmlspecialchars(trim($_POST['memberMail' . $i])) : null;
                    $memberPhone = isset($_POST['memberPhone' . $i]) && !empty($_POST['memberPhone' . $i]) ? htmlspecialchars(trim($_POST['memberPhone' . $i])) : null;
                    $memberBirthdate = isset($_POST['memberBirthdate' . $i]) && !empty($_POST['memberBirthdate' . $i]) ? htmlspecialchars(trim($_POST['memberBirthdate' . $i])) : '';
                    $memberBirthPlace = isset($_POST['memberBirthPlace' . $i]) && !empty($_POST['memberBirthPlace' . $i]) ? htmlspecialchars(trim($_POST['memberBirthPlace' . $i])) : '';

                    $memberStreetNumber = isset($_POST['memberStreetNumber' . $i]) && !empty($_POST['memberStreetNumber' . $i]) ? htmlspecialchars(trim($_POST['memberStreetNumber' . $i])) : '';
                    $memberStreetName = isset($_POST['memberStreetName' . $i]) && !empty($_POST['memberStreetName' . $i]) ? htmlspecialchars(trim($_POST['memberStreetName' . $i])) : '';
                    $memberStreetComplement = isset($_POST['memberStreetComplement' . $i]) && !empty($_POST['memberStreetComplement' . $i]) ? htmlspecialchars(trim($_POST['memberStreetComplement' . $i])) : '';
                    $memberZipCode = isset($_POST['memberZipCode' . $i]) && !empty($_POST['memberZipCode' . $i]) ? htmlspecialchars(trim($_POST['memberZipCode' . $i])) : '';
                    $memberCity = isset($_POST['memberCity' . $i]) && !empty($_POST['memberCity' . $i]) ? htmlspecialchars(trim($_POST['memberCity' . $i])) : '';

                    $profession = isset($_POST['profession' . $i]) && !empty($_POST['profession' . $i]) ? htmlspecialchars(trim($_POST['profession' . $i])) : '';
                    $familySituation = isset($_POST['familySituation' . $i]) && !empty($_POST['familySituation' . $i]) ? htmlspecialchars(trim($_POST['familySituation' . $i])) : '';
                    $cafNumber = isset($_POST['cafNumber' . $i]) && !empty($_POST['cafNumber' . $i]) ? htmlspecialchars(trim($_POST['cafNumber' . $i])) : '';

                    $childLastname = isset($_POST['childLastname' . $i]) && !empty($_POST['childLastname' . $i]) ? htmlspecialchars(trim($_POST['childLastname' . $i])) : '';
                    $childFirstname = isset($_POST['childFirstname' . $i]) && !empty($_POST['childFirstname' . $i]) ? htmlspecialchars(trim($_POST['childFirstname' . $i])) : '';
                    $childBirthdate = isset($_POST['childBirthdate' . $i]) && !empty($_POST['childBirthdate' . $i]) ? htmlspecialchars(trim($_POST['childBirthdate' . $i])) : '';
                    $childBirthPlace = isset($_POST['childBirthPlace' . $i]) && !empty($_POST['childBirthPlace' . $i]) ? htmlspecialchars(trim($_POST['childBirthPlace' . $i])) : '';
                    $childPhone = isset($_POST['childPhone' . $i]) && !empty($_POST['childPhone' . $i]) ? htmlspecialchars(trim($_POST['childPhone' . $i])) : '';
                    $childSchool = isset($_POST['childSchool' . $i]) && !empty($_POST['childSchool' . $i]) ? htmlspecialchars(trim($_POST['childSchool' . $i])) : '';
                    $childSchoolCity = isset($_POST['childSchoolCity' . $i]) && !empty($_POST['childSchoolCity' . $i]) ? htmlspecialchars(trim($_POST['childSchoolCity' . $i])) : '';
                    
                    if ($i === 1) {
                        $person = new Person();

                        try {
                            $person->setId((int) $id);
                            $arrayParametters[$i]['id'] = $person->getId();
                        }
                        catch (ExceptionPerso $e) {
                            $arrayInfoMessages[$i]['id'] = $e->getMessage();
                        }
                    }

                    try {
                        $civilities[$i]->setId((int) $memberCivility);
                        $arrayParametters[$i]['memberCivility' . $i] = $civilities[$i]->getId();
                    } 
                    catch (ExceptionPerso $e) {
                        $arrayInfoMessages[$i]['memberCivility' . $i] = $e->getMessage();
                    }

                    try {
                        $members[$i]->setLastname($memberLastname);
                        $arrayParametters[$i]['memberLastname' . $i] = $members[$i]->getLastname();
                    }
                    catch (ExceptionPerso $e) {
                        $arrayInfoMessages[$i]['memberLastname' . $i] = $e->getMessage();
                    }

                    try {
                        $members[$i]->setFirstname($memberFirstname);
                        $arrayParametters[$i]['memberFirstname' . $i] = $members[$i]->getFirstname();
                    } 
                    catch (ExceptionPerso $e) {
                        $arrayInfoMessages[$i]['memberFirstname' . $i] = $e->getMessage();
                    }

                    try {
                        $members[$i]->setEmail($memberMail);
                        $arrayParametters[$i]['memberMail' . $i] = $members[$i]->getEmail();
                    } 
                    catch (ExceptionPerso $e) {
                        $arrayInfoMessages[$i]['memberMail' . $i] = $e->getMessage();
                    }

                    try {
                        $members[$i]->setPhone($memberPhone);
                        $arrayParametters[$i]['memberPhone' . $i] = $members[$i]->getPhone();
                    } 
                    catch (ExceptionPerso $e) {
                        $arrayInfoMessages[$i]['memberPhone' . $i] = $e->getMessage();
                    }

                    try {
                        $members[$i]->setBirthdate($memberBirthdate);
                        $arrayParametters[$i]['memberBirthdate' . $i] = $members[$i]->getBirthdate();
                    } 
                    catch (ExceptionPerso $e) {
                        $arrayInfoMessages[$i]['memberBirthdate' . $i] = $e->getMessage();
                    }

                    try {
                        $members[$i]->setPlaceOfBirth($memberBirthPlace);
                        $arrayParametters[$i]['memberBirthPlace' . $i] = $members[$i]->getPlaceOfBirth();
                    }
                    catch (ExceptionPerso $e) {
                        $arrayInfoMessages[$i]['memberBirthPlace' . $i] = $e->getMessage();
                    }

                    try {
                        $addresses[$i]->setStreetNumber($memberStreetNumber);
                        $arrayParametters[$i]['memberStreetNumber' . $i] = $addresses[$i]->getStreetNumber();
                    } 
                    catch (ExceptionPerso $e) {
                        $arrayInfoMessages[$i]['memberStreetNumber' . $i] = $e->getMessage();
                    }

                    try {
                        $addresses[$i]->setStreetName($memberStreetName);
                        $arrayParametters[$i]['memberStreetName' . $i] = $addresses[$i]->getStreetName();
                    } 
                    catch (ExceptionPerso $e) {
                        $arrayInfoMessages[$i]['memberStreetName' . $i] = $e->getMessage();
                    }

                    try {
                        $addresses[$i]->setStreetComplement($memberStreetComplement);
                        $arrayParametters[$i]['memberStreetComplement' . $i] = $addresses[$i]->getStreetComplement();
                    } 
                    catch (ExceptionPerso $e) {
                        $arrayInfoMessages[$i]['memberStreetComplement' . $i] = $e->getMessage();
                    }

                    try {
                        $addresses[$i]->setCode($memberZipCode);
                        $arrayParametters[$i]['memberZipCode' . $i] = $addresses[$i]->getCode();
                    } 
                    catch (ExceptionPerso $e) {
                        $arrayInfoMessages[$i]['memberZipCode' . $i] = $e->getMessage();
                    }

                    try {
                        $addresses[$i]->setName($memberCity);
                        $arrayParametters[$i]['memberCity' . $i] = $addresses[$i]->getName();
                    } 
                    catch (ExceptionPerso $e) {
                        $arrayInfoMessages[$i]['memberCity' . $i] = $e->getMessage();
                    }

                    try {
                        $members[$i]->setProfession($profession);
                        $arrayParametters[$i]['profession' . $i] = $members[$i]->getProfession();
                    } 
                    catch (ExceptionPerso $e) {
                        $arrayInfoMessages[$i]['profession' . $i] = $e->getMessage();
                    }

                    try {
                        $members[$i]->setFamilySituation($familySituation);
                        $arrayParametters[$i]['familySituation' . $i] = $members[$i]->getFamilySituation();
                    } 
                    catch (ExceptionPerso $e) {
                        $arrayInfoMessages[$i]['familySituation' . $i] = $e->getMessage();
                    }

                    try {
                        $members[$i]->setCafNumber($cafNumber);
                        $arrayParametters[$i]['cafNumber' . $i] = $members[$i]->getCafNumber();
                    } 
                    catch (ExceptionPerso $e) {
                        $arrayInfoMessages[$i]['cafNumber' . $i] = $e->getMessage();
                    }
                    
                    $arrayParametters[$i]['memberIdPair'] = null;

                    // try {
                    //     $member->setLastname($childLastname);
                    //     $arrayParametters['childLastname'.$i] =  $member->getLastname();
                    // }
                    // catch (ExceptionPerso $e) {
                    //     $infoMessages['childLastname'.$i] = $e->getMessage();
                    // }

                    // try {
                    //     $member->setFirstname($childFirstname);
                    //     $arrayParametters['childFirstname'.$i] =  $member->getFirstname();
                    // }
                    // catch (ExceptionPerso $e) {
                    //     $infoMessages['childFirstname'.$i] = $e->getMessage();
                    // }

                    // try {
                    //     $member->setBirthdate($childBirthdate);
                    //     $arrayParametters['childBirthdate'.$i] =  $member->getBirthdate();
                    // }
                    // catch (ExceptionPerso $e) {
                    //     $infoMessages['childBirthdate'.$i] = $e->getMessage();
                    // }

                    // try {
                    //     $member->setPlaceOfBirth($childBirthPlace);
                    //     $arrayParametters['childBirthPlace'.$i] =  $member->getPlaceOfBirth();
                    // }
                    // catch (ExceptionPerso $e) {
                    //     $infoMessages['childBirthPlace'.$i] = $e->getMessage();
                    // }

                    // try {
                    //     $member->setPhone($childPhone);
                    //     $arrayParametters['childPhone'.$i] =  $member->getPhone();
                    // }
                    // catch (ExceptionPerso $e) {
                    //     $infoMessages['childPhone'.$i] = $e->getMessage();
                    // }

                    // try {
                    //     $supervisor->setSchool($childSchool);
                    //     $arrayParametters['childSchool'.$i] =  $supervisor->getSchool();
                    // }
                    // catch (ExceptionPerso $e) {
                    //     $infoMessages['childSchool'.$i] = $e->getMessage();
                    // }

                    // try {
                    //     $supervisor->setSchoolCity($childSchoolCity);
                    //     $arrayParametters['childSchoolCity'.$i] =  $supervisor->getSchoolCity();
                    // }
                    // catch (ExceptionPerso $e) {
                    //     $infoMessages['childSchoolCity'.$i] = $e->getMessage();
                    // }

                    var_dump($maxNumberResponsible);
                    var_dump($arrayParametters[$i]);
                    
                    try {

                        if (empty($arrayInfoMessages[$i])) {
                            $pdo->beginTransaction();

                            if ($i === 1) {

                                try {
                                    $idMemberPair = UserSpaceManager::insertMember($arrayParametters[$i], $i);
                                    $pdo->commit();
                                }
                                catch (ExceptionPersoDAO $e) {
                                    $_SESSION['warning'] = $e->getMessage();
                                    $pdo->rollBack();
                                }
                            }
                            else {

                                try {
                                    $members[$i]->setId($idMemberPair);
                                    $arrayParametters[$i]['id'] = null;
                                    $members[$i]->setMemberPair($members[$i]);
                                    $arrayParametters[$i]['memberIdPair'] = $members[$i]->getMemberPair();
                                    UserSpaceManager::insertMember($arrayParametters[$i], $i);
                                    $pdo->commit();
                                }
                                catch (ExceptionPersoDAO $e) {
                                    $_SESSION['warning'] = $e->getMessage();
                                    $pdo->rollBack();
                                }
                            }

                            $_SESSION['success'] = "Votre demande à devenir un membre de l'association a bien été effectuée";
                            session_write_close();
                            header('Location: userSpace?idMember=' . $arrayParametters['id']);
                        }
                    } catch (ExceptionPersoDAO $e) {
                        $_SESSION['warning'] = $e->getMessage();
                    }
                }
            }  
        }
    }
}

require_once 'views/userSpace.php';
