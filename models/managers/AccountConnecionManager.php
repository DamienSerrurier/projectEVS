<?php

use PhpParser\Node\Stmt;

require_once 'utility/exceptions/ExceptionPersoDAO.php';
require_once 'models/managers/connection.php';
require_once 'models/entities/Person.php';

class AccountConnectionManager {

    public static function verifyInfoUserConnection(string $email) {
        try {
            $pdo = baseConnection();
            $query = "SELECT * FROM displayOneUserByEmail(:email);";
            $stmt = $pdo->prepare($query);
            $stmt->bindValue('email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!empty($result)) {
                return $result;
            }
            else {
                return false;
            }

        } catch (PDOException $e) {
            Loggy::warning("Un problème serveur est survenu" . $e);
            throw new ExceptionPersoDAO("Un problème serveur est survenu");
        }
    }
}
