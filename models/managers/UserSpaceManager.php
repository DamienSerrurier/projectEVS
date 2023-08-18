<?php

require_once 'models/entities/Civility.php'; 

use ProjectEvs\Person;

require_once 'models/managers/connection.php';
class UserSpaceManager {

    public static function getOneUserById(int $id) {
        try {
            $pdo = baseConnection();
            $query = "SELECT * FROM displayOneUserById(:id);";
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $person = new Person();
            $person->setLastname($result['lastname']);
            $person->setFirstname($result['firstname']);
            $person->setPhone($result['phone']);
            $person->setEmail($result['email']);
            $person->setPassword($result['password']);

            if (!empty($person)) {
                return $person;
            }
            else {
                return false;
            }
        }
        catch (PDOException $e) {
            Loggy::warning("Un problème serveur est survenu" . $e);
            throw new ExceptionPersoDAO("Un problème serveur est survenu");
        }
    }

    public static function updateUser(array $arrayParametters) {
        try {
            $pdo = baseConnection();
            $query = "CALL updateUser(
                :id,
                :lastname,
                :firstname,
                :phone,
                :mail,
                :passw
            );";
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':lastname', $arrayParametters['lastname'], PDO::PARAM_STR);
            $stmt->bindValue(':firstname', $arrayParametters['firstname'], PDO::PARAM_STR);
            $stmt->bindValue(':mail', $arrayParametters['mail'], PDO::PARAM_STR);
            $stmt->bindValue(':phone', $arrayParametters['phone'], PDO::PARAM_STR);
            $stmt->bindValue(':passw', $arrayParametters['passw'], PDO::PARAM_STR);
            $stmt->bindValue(':id', $arrayParametters['id'], PDO::PARAM_INT);
            return $stmt->execute();

        } catch (PDOException $e) {
            Loggy::warning("Un problème serveur est survenu" . $e);
            throw new ExceptionPersoDAO("Un problème serveur est survenu");
        }
    }

    public static function deleteUser(int $id) {
        try {
            $pdo = baseConnection();
            $query = "CALL deleteOneUser(:id);";
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();

        } catch (PDOException $e) {
            Loggy::warning("Un problème serveur est survenu" . $e);
            throw new ExceptionPersoDAO("Un problème serveur est survenu");
        }
    }

    public static function getAllCivility() {
        try {
            $pdo = baseConnection();
            $query = "SELECT * FROM displayAllCivility;";
            $stmt = $pdo->query($query);
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'ProjectEvs\Civility');
            $result = $stmt->fetchAll();
         
            if (!empty($result)) {
                return $result;
            }
            else {
                return false;
            }
        }
        catch (PDOException $e) {
            Loggy::warning("Un problème serveur est survenu" . $e);
            throw new ExceptionPersoDAO("Un problème serveur est survenu");
        }
    }
}