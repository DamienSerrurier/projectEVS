<?php

require_once 'models/managers/connection.php';

class AdministratorSpaceManager {

    public static function insertCategoryName(string $categoryName) {

        try {
            $pdo = baseConnection();
            $query = "CALL insertCategory(:categoryName);";
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':categoryName', $categoryName, PDO::PARAM_STR);
            return $stmt->execute();
        }
        catch (PDOException $e) {
            Loggy::warning("Un problème serveur est survenu" . $e->getMessage());
            throw new ExceptionPersoDAO("Un problème serveur est survenu" . $e->getMessage());
        }
    }

    
}