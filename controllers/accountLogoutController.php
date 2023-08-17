<?php

session_start();

if (isset($_POST['logout'])) {
    var_dump('ok');
    session_unset();
    session_destroy();
    session_regenerate_id(true);
    header('Location: home');
}

require_once 'views/accountLogout.php';