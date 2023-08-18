<?php

require_once 'models/managers/connection.php';
require_once 'app/function.php';

sessionStartWithGenerateToken('token');

require_once 'views/home.php';