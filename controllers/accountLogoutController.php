<?php

require_once 'app/function.php';

sessionStartWithGenerateToken('token');

if (isset($_POST['token'])) {

    if ($_POST['token'] != $_SESSION['token']) {
        die("Jeton CSRF invalide");
    }
    else {
        if (isset($_POST['logout'])) {
            session_unset();
            session_destroy();
            session_regenerate_id(true);
            header('Location: home');
        }
    }
}

require_once 'views/accountLogout.php';