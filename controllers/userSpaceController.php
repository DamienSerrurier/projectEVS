<?php

//Dépendance
require_once 'utility/exceptions/ExceptionPerso.php';
require_once 'utility/function.php';
require_once 'models/entities/RegexTester.php';
require_once 'models/managers/userSpaceManager.php';
require_once 'models/entities/GenericObject.php';
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

//Fonction permettant de créer une session et de créer des jetons (token)
sessionStartWithGenerateToken('token');

try {
    //Retour d'une requête permettant de rechercher toutes les civilités
    $resultCivility = UserSpaceManager::getAllCivility();
} catch (ExceptionPersoDAO $e) {
    //capture et stockage dans une variable session dans le cas d'un retour d'une exception
    $_SESSION['warning'] = $e->getMessage();
}

//Vérification si la valeur supérieure à 0 dans la variable super global get et si elle est déclarée
if (isset($_GET['responsible']) && $_GET['responsible'] >= 0) {
    //On transforme les caractères spéciaux en entités html
    $responsible = htmlspecialchars($_GET['responsible']);
    
    //Filtrage de la valeur get et stockage dans une variable session permettant sa réutilisation
    if (filter_var($responsible, FILTER_VALIDATE_INT)) {
        $_SESSION['responsible'] = $responsible;
    }
}

//Vérification si l'identifiant de l'utilisateur est stocké dans une variable session
if (isset($_SESSION['user']['id'])) {

    //On transforme les caractères spéciaux en entités html
    $id = isset($_SESSION['user']['id']) ? htmlspecialchars($_SESSION['user']['id']) : '';
    //On créé une nouvelle instance de la classe Person et on lui attribut l'identifiant
    $person = new Person();
    $person->setId($id);
    $cleanId = $person->getId();
    //On insert l'identifiant dans une méthode permettant de retourner les informations d'un utilisateur
    $resultQuery = UserSpaceManager::getOneUserById($cleanId);
}

//Vérification si un token est déclaré
if (isset($_POST['token'])) {

    /*Vérification si le token envoyé à travers le formulaire n'est pas identique à celui qui a été créé et stocké en session, 
    si c'est le cas, on termine le script courant.*/
    if ($_POST['token'] != $_SESSION['token']) {
        die("Jeton CSRF invalide");
        //Sinon on exécute la suite du script
    } else {

        //Vérification si la variable post de modification d'un utilisateur a été déclarée
        if (isset($_POST['updateUser'])) {
            //On transforme les caractères spéciaux en entités html et on supprime les espaces si les variables sont déclarées et non-vide
            $id = isset($_SESSION['user']['id']) ? htmlspecialchars($_SESSION['user']['id']) : '';
            $lastname = isset($_POST['lastname']) && !empty($_POST['lastname']) ? htmlspecialchars(trim($_POST['lastname'])) : '';
            $firstname = isset($_POST['firstname']) && !empty($_POST['firstname']) ? htmlspecialchars(trim($_POST['firstname'])) : '';
            $mail = isset($_POST['mail']) && !empty($_POST['mail']) ? htmlspecialchars(trim($_POST['mail'])) : '';
            $phone = isset($_POST['phone']) && !empty($_POST['phone']) ? htmlspecialchars(trim($_POST['phone'])) : null;
            $passw = isset($_POST['passw']) && !empty($_POST['passw']) ? htmlspecialchars(trim($_POST['passw'])) : '';
            $confPassw = isset($_POST['confPassw']) && !empty($_POST['confPassw']) ? htmlspecialchars(trim($_POST['confPassw'])) : '';

            //On créé une nouvelle instance de la classe Person et on créé des tableaux vides qui vont stocker différentes informations
            $person = new Person();
            $infoMessages = [];
            $arrayParametters = [];

            try {
                //On vérifie si l'identifiant passe tous les différents tests dans le setter, le cas échéant, on le retourne et stock
                GenericObject::init($person, $person->setId((int) $id), $person->getId(), $arrayParametters[$i], 'id');
                $arrayParametters[$i] = GenericObject::getArrayData();
            } 
            catch (ExceptionPerso $e) {
                //On capture une exception et on la stocke si les tests n'ont pas passé
                $infoMessages['id'] = $e->getMessage();
            }

            try {
                //On vérifie si le nom passe tous les différents tests dans le setter, le cas échéant, on le retourne et stock
                GenericObject::init($person, $person->setLastname($lastname), $person->getLastname(), $arrayParametters[$i], 'lastname');
                $arrayParametters[$i] = GenericObject::getArrayData();
            } 
            catch (ExceptionPerso $e) {
                //On capture une exception et on la stocke si les tests n'ont pas passé
                $infoMessages['lastname'] = $e->getMessage();
            }

            try {
                //On vérifie si le prénom passe tous les différents tests dans le setter, le cas échéant, on le retourne et stock
                GenericObject::init($person, $person->setFirstname($firstname), $person->getFirstname(), $arrayParametters[$i], 'firstname');
                $arrayParametters[$i] = GenericObject::getArrayData();
            } 
            catch (ExceptionPerso $e) {
                //On capture une exception et on la stocke si les tests n'ont pas passé
                $infoMessages['firstname'] = $e->getMessage();
            }

            try {
                //On vérifie si l'adresse électronique passe tous les différents tests dans le setter, le cas échéant, on la retourne et stock
                GenericObject::init($person, $person->setEmail($mail), $person->getEmail(), $arrayParametters[$i], 'mail');
                $arrayParametters[$i] = GenericObject::getArrayData();
            } 
            catch (ExceptionPerso $e) {
                //On capture une exception et on la stocke si les tests n'ont pas passé
                $infoMessages['mail'] = $e->getMessage();
            }

            try {
                //On vérifie si le numéro de téléphone passe tous les différents tests dans le setter, le cas échéant, on le retourne et stock
                GenericObject::init($person, $person->setPhone($phone), $person->getPhone(), $arrayParametters[$i], 'phone');
                $arrayParametters[$i] = GenericObject::getArrayData();
            } 
            catch (ExceptionPerso $e) {
                //On capture une exception et on la stocke si les tests n'ont pas passé
                $infoMessages['phone'] = $e->getMessage();
            }

            //Vérification si le mot de passe correspond avec sa confirmation
            if (($passw == $confPassw)) {

                try {
                    //On vérifie si le mot de passe passe tous les différents tests dans le setter, le cas échéant on le hache, on le retourne et stock
                    GenericObject::init($person, $person->setPassword($passw), $person->getPassword(), $arrayParametters[$i], 'passw');
                    $arrayParametters[$i] = GenericObject::getArrayData();
                } 
                catch (ExceptionPerso $e) {
                    $infoMessages['passw'] = $e->getMessage();
                }
            } else {
                //On stock un message si les mots de passe ne sont pas identiques
                $infoMessages['confPassw'] = "Le mot de passe et de confirmation doivent être indentique";
            }

            try {
                //Vérification s'il n'y a pas de message d'erreur 
                if (empty($infoMessages)) {
                    //On insert toutes les informations dans une méthode permettant de mettre à jour les informations d'un utilisateur
                    if (UserSpaceManager::updateUser($arrayParametters)) {
                        //Retourne un message de succès, écrit les données de session et la ferme
                        $_SESSION['success'] = "Votre profile utilisateur a bien été modifié";
                        session_write_close();
                        //On redirige l'utilisateur sur la même page avec on identifiant
                        header('Location: userSpace?idUser=' . $cleanId);
                    }
                }
            } catch (ExceptionPersoDAO $e) {
                //Retourne une exception et la stock dans une variable session
                $_SESSION['warning'] = $e->getMessage();
            }
        }

        //Vérification si la variable post de suppression d'un utilisateur a été déclarée
        if (isset($_POST['deleteUser'])) {

            //On transforme les caractères spéciaux en entités html et on supprime les espaces
            $id = isset($_SESSION['user']['id']) ? htmlspecialchars($_SESSION['user']['id']) : '';

            //On créé une nouvelle instance de la classe Person et on lui attribut l'identifiant
            $person = new Person();
            $person->setId($id);
            $cleanId = $person->getid();

            try {
                //On insert l'identifiant dans une méthode permettant de supprimer un utilisateur
                if (UserSpaceManager::deleteUser($cleanId)) {
                    //On détruit la session, on régénère l'identifiant de session et on redirige vers la page d'accueil
                    session_unset();
                    session_destroy();
                    session_regenerate_id(true);
                    header('Location: home');
                }
            } catch (ExceptionPersoDAO $e) {
                //Retourne une exception et la stock dans une variable session
                $_SESSION['warning'] = $e->getMessage();
            }
        }
    }
}

//Fonction permettant de créer une session et de créer des jetons (token)
sessionStartWithGenerateToken('token1');

//Vérification si un token est déclaré
if (isset($_POST['token1'])) {

    /*Vérification si le token envoyé à travers le formulaire n'est pas identique à celui qui a été créé et stocké en session, 
    si c'est le cas, on termine le script courant.*/
    if ($_POST['token1'] != $_SESSION['token1']) {
        die("Jeton CSRF invalide");
        //Sinon on exécute la suite du script
    } else {

        //Vérification si la variable post de création de membre a été déclarée
        if (isset($_POST['createMember'])) {
            
            //Vérification si la variable session a été déclarée et si elle est supérieure à 0
            if (isset($_SESSION['responsible']) && $_SESSION['responsible'] > 0) {
                //Création de tableaux vides permettant de stocker les différentes instances, les tableaux d'erreurs et de paramètres
                
                $idMember = 0;
                
                //On transforme les caractères spéciaux en entités html
                $id = isset($_SESSION['user']['id']) && !empty($_SESSION['user']['id']) ? htmlspecialchars($_SESSION['user']['id']) : null;
                
                //On boucle sur la variable session qui contient le nombre d'adultes à insérer
                for ($i = 1; $i <= $_SESSION['responsible']; $i++) {
                    //On créé des nouvelles instances de la classe Member, Civility, Address, Supervisor et on créé des tableaux vides à chaque tour de boucle qui vont stocker différentes informations
                    
                    $members[$i] = new Member();
                    $civilities[$i] = new Civility();
                    $addresses[$i] = new Address();
                    $supervisors[$i] = new Supervisor();
                    $arrayInfoMessages[$i] = [];
                    $arrayParametters[$i] = [];
                    
                    //On transforme les caractères spéciaux en entités html et on supprime les espaces si les variables sont déclarées et non-vide
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
                            GenericObject::init($person, $person->setId((int) $id), $person->getId(), $arrayParametters[$i], 'id');
                            $arrayParametters[$i] = GenericObject::getArrayData();
                        }
                        catch (ExceptionPerso $e) {
                            $arrayInfoMessages[$i]['id'] = $e->getMessage();
                        }
                    }

                    try {
                        GenericObject::init($civilities[$i], $civilities[$i]->setId((int) $memberCivility), $civilities[$i]->getId(), $arrayParametters[$i], 'memberCivility' . $i);
                        $arrayParametters[$i] = GenericObject::getArrayData();
                    } 
                    catch (ExceptionPerso $e) {
                        $arrayInfoMessages[$i]['memberCivility' . $i] = $e->getMessage();
                    }

                    try {
                        GenericObject::init($members[$i], $members[$i]->setLastname($memberLastname), $members[$i]->getLastname(), $arrayParametters[$i], 'memberLastname' . $i);
                        $arrayParametters[$i] = GenericObject::getArrayData();
                    }
                    catch (ExceptionPerso $e) {
                        $arrayInfoMessages[$i]['memberLastname' . $i] = $e->getMessage();
                    }

                    try {
                        GenericObject::init($members[$i], $members[$i]->setFirstname($memberFirstname), $members[$i]->getFirstname(), $arrayParametters[$i], 'memberFirstname' . $i);
                        $arrayParametters[$i] = GenericObject::getArrayData();
                    } 
                    catch (ExceptionPerso $e) {
                        $arrayInfoMessages[$i]['memberFirstname' . $i] = $e->getMessage();
                    }

                    try {
                        GenericObject::init($members[$i], $members[$i]->setEmail($memberMail), $members[$i]->getEmail(), $arrayParametters[$i], 'memberMail' . $i);
                        $arrayParametters[$i] = GenericObject::getArrayData();
                    } 
                    catch (ExceptionPerso $e) {
                        $arrayInfoMessages[$i]['memberMail' . $i] = $e->getMessage();
                    }

                    try {
                        GenericObject::init($members[$i], $members[$i]->setPhone($memberPhone), $members[$i]->getPhone(), $arrayParametters[$i], 'memberPhone' . $i);
                        $arrayParametters[$i] = GenericObject::getArrayData();
                    } 
                    catch (ExceptionPerso $e) {
                        $arrayInfoMessages[$i]['memberPhone' . $i] = $e->getMessage();
                    }

                    try {
                        GenericObject::init($members[$i], $members[$i]->setBirthdate($memberBirthdate), $members[$i]->getBirthdate(), $arrayParametters[$i], 'memberBirthdate' . $i);
                        $arrayParametters[$i] = GenericObject::getArrayData();
                    } 
                    catch (ExceptionPerso $e) {
                        $arrayInfoMessages[$i]['memberBirthdate' . $i] = $e->getMessage();
                    }

                    try {
                        GenericObject::init($members[$i], $members[$i]->setPlaceOfBirth($memberBirthPlace), $members[$i]->getPlaceOfBirth(), $arrayParametters[$i], 'memberBirthPlace' . $i);
                        $arrayParametters[$i] = GenericObject::getArrayData();
                    }
                    catch (ExceptionPerso $e) {
                        $arrayInfoMessages[$i]['memberBirthPlace' . $i] = $e->getMessage();
                    }

                    try {
                        GenericObject::init($addresses[$i], $addresses[$i]->setStreetNumber($memberStreetNumber), $addresses[$i]->getStreetNumber(), $arrayParametters[$i], 'memberStreetNumber' . $i);
                        $arrayParametters[$i] = GenericObject::getArrayData();
                    } 
                    catch (ExceptionPerso $e) {
                        $arrayInfoMessages[$i]['memberStreetNumber' . $i] = $e->getMessage();
                    }

                    try {
                        GenericObject::init($addresses[$i], $addresses[$i]->setStreetName($memberStreetName), $addresses[$i]->getStreetName(), $arrayParametters[$i], 'memberStreetName' . $i);
                        $arrayParametters[$i] = GenericObject::getArrayData();
                    } 
                    catch (ExceptionPerso $e) {
                        $arrayInfoMessages[$i]['memberStreetName' . $i] = $e->getMessage();
                    }

                    try {
                        GenericObject::init($addresses[$i], $addresses[$i]->setStreetComplement($memberStreetComplement), $addresses[$i]->getStreetComplement(), $arrayParametters[$i], 'memberStreetComplement' . $i);
                        $arrayParametters[$i] = GenericObject::getArrayData();
                    } 
                    catch (ExceptionPerso $e) {
                        $arrayInfoMessages[$i]['memberStreetComplement' . $i] = $e->getMessage();
                    }

                    try {
                        GenericObject::init($addresses[$i], $addresses[$i]->setCode($memberZipCode), $addresses[$i]->getCode(), $arrayParametters[$i], 'memberZipCode' . $i);
                        $arrayParametters[$i] = GenericObject::getArrayData();
                    } 
                    catch (ExceptionPerso $e) {
                        $arrayInfoMessages[$i]['memberZipCode' . $i] = $e->getMessage();
                    }

                    try {
                        GenericObject::init($addresses[$i], $addresses[$i]->setName($memberCity), $addresses[$i]->getName(), $arrayParametters[$i], 'memberCity' . $i);
                        $arrayParametters[$i] = GenericObject::getArrayData();
                    } 
                    catch (ExceptionPerso $e) {
                        $arrayInfoMessages[$i]['memberCity' . $i] = $e->getMessage();
                    }

                    try {
                        GenericObject::init($members[$i], $members[$i]->setProfession($profession), $members[$i]->getProfession(), $arrayParametters[$i], 'profession' . $i);
                        $arrayParametters[$i] = GenericObject::getArrayData();
                    } 
                    catch (ExceptionPerso $e) {
                        $arrayInfoMessages[$i]['profession' . $i] = $e->getMessage();
                    }

                    try {
                        GenericObject::init($members[$i], $members[$i]->setFamilySituation($familySituation), $members[$i]->getFamilySituation(), $arrayParametters[$i], 'familySituation' . $i);
                        $arrayParametters[$i] = GenericObject::getArrayData();
                    } 
                    catch (ExceptionPerso $e) {
                        $arrayInfoMessages[$i]['familySituation' . $i] = $e->getMessage();
                    }

                    try {
                        GenericObject::init($members[$i], $members[$i]->setCafNumber($cafNumber), $members[$i]->getCafNumber(), $arrayParametters[$i], 'cafNumber' . $i);
                        $arrayParametters[$i] = GenericObject::getArrayData();
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

                    var_dump($arrayParametters[$i]);
                    
                    try {
                        if (empty($arrayInfoMessages[$i])) {

                            if ($i === 1) {
                                $idMember = UserSpaceManager::insertMember($arrayParametters[$i], $i);
                            }
                            else {
                                
                                try {
                                    $person->setId($id);
                                    $idPerson = $person->getid();
                                }
                                catch (ExceptionPerso $e) {
                                    $arrayInfoMessages[$i]['id'] = $e->getMessage();
                                }

                                $result = UserSpaceManager::getOneMemberById($idPerson);
                                $memberInfo = explode(', ', $result['member_info']);
                                $memberPair = new Member();
                                $memberPair->setId($result['id']);
                                $memberPair->getid();

                                if ($memberPair instanceof Member) {
                                    $arrayParametters[$i]['id'] = null;
                                    $members[$i]->setMemberPair($memberPair);
                                    $arrayParametters[$i]['memberIdPair'] = $members[$i]->getMemberPair();
                                    UserSpaceManager::insertMember($arrayParametters[$i], $i);
                                }
                                else {
                                    $_SESSION['warning'] = "L'identifiant ne correspond à aucun membre ";
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
