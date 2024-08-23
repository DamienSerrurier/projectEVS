<?php

/**
 * Méthode qui permet de démarrer une session s'il n'y en a pas déjà une d'ouverte et générer un jeton
 * @param string $tokenName
 */
function sessionStartWithGenerateToken($tokenName) {

    if (!session_id()) {
        session_start();
        session_regenerate_id(true);
    }

    if (empty($_SESSION[$tokenName])) {
        $_SESSION[$tokenName] = bin2hex(random_bytes(32));
    }
}