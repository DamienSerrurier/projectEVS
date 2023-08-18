<?php

require_once 'app/function.php';

sessionStartWithGenerateToken('token');

if (isset($_POST['token'])) {

    if ($_POST['token'] != $_SESSION['token']) {


    }
}
require_once 'views/educationalEstablishment.php';