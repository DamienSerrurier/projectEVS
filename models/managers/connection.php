<?php

require_once 'utility/exceptions/ExceptionPersoDAO.php';
require_once 'utility/logger/Loggy.php';

/** Fonction permettant d'établire une connexion à la base de données
 * @return PDO
 * @throws ExceptionPersoDao() 
 */
function baseConnection() {
    try {
        $pdo = new PDO('uri:file:///c:\Users\damie\OneDrive\Documents/dbConnect.conf');
        return $pdo;

    } catch (PDOException $e) {
        Loggy::error("Problème d'accès à la base de données " . $e->getMessage());
        throw new ExceptionPersoDAO(" Problème d'accès à la base de données " . $e->getMessage());
    }
}
