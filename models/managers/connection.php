<?php

require_once 'utility/exceptions/ExceptionPersoDAO.php';
require_once 'utility/logger/Loggy.php';

function baseConnection() {
    try {
        $pdo = new PDO('uri:file:///c:\Logiciels\laragon\www\projectEvs/dbConnect.conf');
        return $pdo;

    } catch (PDOException $e) {
        Loggy::error("Problème d'accès à la base de données " . $e->getMessage());
        throw new ExceptionPersoDAO(" Problème d'accès à la base de données " . $e->getMessage());
    }
}
