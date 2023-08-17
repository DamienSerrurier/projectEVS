<?php

require_once 'utility/exceptions/ExceptionPersoDAO.php';
require_once 'models/managers/connection.php';
require_once 'models/entities/Person.php';

class AccountCreationManager {

    public static function insertUser(array $arrayParametters) {
        try {
            $pdo = baseConnection();
            $query = "CALL insertUser(
                :lastname,
                :firstname,
                :mail,
                :passw
            );";
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':lastname', $arrayParametters['lastname'], PDO::PARAM_STR);
            $stmt->bindValue(':firstname', $arrayParametters['firstname'], PDO::PARAM_STR);
            $stmt->bindValue(':mail', $arrayParametters['mail'], PDO::PARAM_STR);
            $stmt->bindValue(':passw', $arrayParametters['passw'], PDO::PARAM_STR);
            return $stmt->execute();

        } catch (PDOException $e) {
            Loggy::warning("Un problème serveur est survenu" . $e);
            throw new ExceptionPersoDAO("Un problème serveur est survenu");
        }
    }
}
