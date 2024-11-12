<?php

require_once 'utility/exceptions/ExceptionPerso.php';
require_once 'utility/function.php';
require_once 'models/entities/RegexTester.php';
require_once 'models/managers/AdministratorSpaceManager.php';
require_once 'models/entities/Category.php';

use ProjectEvs\ExceptionPerso;
use ProjectEvs\Category;

sessionStartWithGenerateToken('token');

$categoryMenu = 0;
if (isset($_GET['categoryMenu'])) {
    $categoryMenu = (int) htmlspecialchars($_GET['categoryMenu']);
}

if (isset($_GET['selectButtonValue'])) {
    $selectButtonCategory = (int) htmlspecialchars($_GET['selectButtonValue']);
    $categoryClass = AdministratorSpaceManager::getOneCategory($selectButtonCategory);
}

$categories = AdministratorSpaceManager::getAllCategory();

if (isset($_POST['token'])) {

    if ($_POST['token'] != $_SESSION['token']) {
        die("Jeton CSRF invalide");
    } 
    else {
        if (isset($_POST['create'])) {

            switch ($categoryMenu) {
                case 1:
                    var_dump('coucou 1');
                    break;

                case 2:
                    var_dump('coucou 2');

                    break;

                case 3:
                    var_dump('coucou 3');
                    $activityCategoryName = isset($_POST['categoryName']) ? htmlspecialchars($_POST['categoryName']) : '';
                    $id;
                    $category = new Category();

                    try {
                        $category->setName($activityCategoryName);
                        $resultCategoryName = $category->getName();
                    }
                    catch (ExceptionPerso $e) {
                        $errorCategoryName = $e->getMessage();
                    }

                    var_dump($activityCategoryName);
                    if (empty($errorCategoryName)) {
                        try {
                            AdministratorSpaceManager::insertCategoryName($id, $resultCategoryName);
                            $_SESSION['success'] = "La catégorie a bien été crée";
                            session_write_close();
                            header('Location: administratorSpace?categoryMenu=' . $categoryMenu);
                        }
                        catch (ExceptionPersoDAO $e) {
                            $_SESSION['warning'] = $e->getMessage();
                        }
                    }
                    break;

                case 4:
                    var_dump('coucou 4');

                    break;

                case 5:
                    var_dump('coucou 5');

                    break;

                case 6:
                    var_dump('coucou 6');

                    break;

                default:
                    var_dump('coucou 7');

                    break;
            }
        }

        if (isset($_POST['update'])) {

            switch ($categoryMenu) {

                case 1:
                    break;
                
                case 2:
                    break;

                case 3:
                    $activityCategoryName = isset($_POST['categoryName']) ? htmlspecialchars($_POST['categoryName']) : '';
                    $categoryId = isset($_POST['category']) ? htmlspecialchars($_POST['category']) : '';
                    $arrayInfoMessages = [];
                    $arrayParametters = [];
                    $category = new Category();

                    try {
                        $category->setId((int) $categoryId);
                        $arrayParametters['id'] = $category->getId();
                    }
                    catch (ExceptionPerso $e) {
                        $arrayInfoMessages['id'] = $e->getMessage();
                    }

                    try {
                        $category->setName($activityCategoryName);
                        $arrayParametters['name'] = $category->getName();
                    }
                    catch (ExceptionPerso $e) {
                        $arrayInfoMessages['name'] = $e->getMessage();
                    }

                    if (empty($arrayInfoMessages)) {

                        try {
                            AdministratorSpaceManager::updateCategoryName($arrayParametters);
                            $_SESSION['success'] = "La catégorie a bien été modifiée";
                            session_write_close();
                            header('Location: administratorSpace?categoryMenu=' . $categoryMenu);
                        }
                        catch (ExceptionPersoDAO $e) {
                            $_SESSION['warning'] = $e->getMessage();
                        }
                    }
                    break;

                case 4:
                    break;

                case 5:
                    break;

                case 6:
                    break;

                default:
                    break;
            }
        }

        if (isset($_POST['delete'])) {

            switch ($categoryMenu) {

                case 1:
                    break;
                
                case 2:
                    break;

                case 3:
                    $categoryId = isset($_POST['category']) ? htmlspecialchars($_POST['category']) : '';
                    $category = new Category();
                    $categoryIdVerified;
                    $errorCategoryId;

                    try {
                        $category->setId((int) $categoryId);
                        $categoryIdVerified = $category->getid();
                    }
                    catch (ExceptionPersoDAO $e) {
                        $errorCategoryId = $e->getMessage();
                    }

                    if (empty($errorCategoryId)) {

                        try {
                            AdministratorSpaceManager::deleteCategory($categoryIdVerified);
                            $_SESSION['success'] = "La catégorie a bien été supprimée";
                            session_write_close();
                            header("Location: administratorSpace?categoryMenu=" . $categoryMenu);
                        }
                        catch (ExceptionPersoDAO $e) {
                            $_SESSION['warning'] = $e->getMessage();
                        }
                    }

                    break;

                case 4:
                    break;

                case 5:
                    break;

                case 6:
                    break;

                default:
                    break;
            }

        }
    }
}
require_once 'views/administratorSpace.php';
