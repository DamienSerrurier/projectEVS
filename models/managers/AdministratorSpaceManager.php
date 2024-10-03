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

    public static function getAllCategory() {

        try {
            $pdo = baseConnection();
            $query = "SELECT * FROM displayallcategory;";
            $stmt = $pdo->query($query);
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'ProjectEvs\Category');
            $result = $stmt->fetchAll();
            
            if (!empty($result)) {
                return $result;
            }
            else {
                return false;
            }

        }
        catch (PDOException $e) {
            Loggy::warning("Un problème serveur est survenu" . $e->getMessage());
            throw new ExceptionPersoDAO("Un problème serveur est survenu" . $e->getMessage());
        }
    }
}