<?php

function sessionStartWithGenerateToken() {

    if (!session_id()) {
        session_start();
        session_regenerate_id(true);
    }

    if (empty($_SESSION['token'])) {
        $_SESSION['token'] = bin2hex(random_bytes(32));
    }
}