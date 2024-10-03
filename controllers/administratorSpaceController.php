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
                    $activityCategoryName = htmlspecialchars($_POST['categoryName']);

                    try {
                        $category = new Category();
                        $category->setName($activityCategoryName);
                        $resultCategoryName = $category->getName();
                    }
                    catch (ExceptionPerso $e) {
                        $errorCategoryName = $e->getMessage();
                    }

                    if (empty($errorCategoryName)) {
                        AdministratorSpaceManager::insertCategoryName($resultCategoryName);
                        header('Location: administratorSpace?categoryMenu=' . $categoryMenu);
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
    }
}
require_once 'views/administratorSpace.php';
