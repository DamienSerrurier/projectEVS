<?php

if (isset($_GET['page']) && $_GET['page'] == 'home') {
    require getcwd() . '/controllers/homeController.php';
}
else if (isset($_GET['page']) && $_GET['page'] == 'accountCreation') {
    require getcwd() . '/controllers/accountCreationController.php';
}
else if (isset($_GET['page']) && $_GET['page'] == 'accountConnection') {
    require getcwd() . '/controllers/accountConnectionController.php';
}