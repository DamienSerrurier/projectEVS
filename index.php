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
else if (isset($_GET['page']) && $_GET['page'] == 'accountLogout') {
    require getcwd() . '/controllers/accountLogoutController.php';
}
else if (isset($_GET['page']) && $_GET['page'] == 'userSpace') {
    require getcwd() . '/controllers/userSpaceController.php';
}
else if (isset($_GET['page']) && $_GET['page'] == 'educationalEstablishment') {
    require getcwd() . '/controllers/educationalEstablishmentController.php';
}
else if (isset($_GET['page']) && $_GET['page'] == 'administratorSpace') {
    require getcwd() . '/controllers/administratorSpaceController.php';
}