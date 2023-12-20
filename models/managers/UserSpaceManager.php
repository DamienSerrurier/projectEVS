<?php

require_once 'models/managers/connection.php';
require_once 'models/entities/Civility.php';

use ProjectEvs\Person;

class UserSpaceManager {

    /** Méthode permettant de récurer un utilisateur grâce un identifiant
     * 
     * @param int $id 
     * @return array|boolean
     * @throws ExceptionPersoDAO
     */
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

    /** Méthode permettant de mettre à jour un utilisateur grâce un identifiant
     * 
     * @param array $arrayParametters 
     * @return boolean
     * @throws ExceptionPersoDAO
     */
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

    /** Méthode permettant de supprimer un utilisateur grâce un identifiant
     * 
     * @param int $id 
     * @return boolean
     * @throws ExceptionPersoDAO
     */
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

    /** Méthode permettant de récupéer toutes les civilités
     * 
     * @return array|boolean
     * @throws ExceptionPersoDAO
     */
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

    public static function insertMember(array $arrayParametters, int $number) {
        try {
            $pdo = baseConnection();

            $query = "SELECT insertMemberAdult(
                :id,
                :memberLastname$number,
                :memberFirstname$number,
                :memberPhone$number,
                :memberStreetNumber$number,
                :memberStreetName$number,
                :memberStreetComplement$number,
                :memberZipCode$number,
                :memberCity$number,
                :memberBirthdate$number,
                :memberBirthPlace$number,
                :memberIdPair,
                :memberMail$number,
                :profession$number,
                :familySituation$number,
                :cafNumber$number,
                :memberCivility$number
            );";
                $stmt = $pdo->prepare($query);
                $stmt->bindValue(':id', $arrayParametters['id'], PDO::PARAM_INT);
                $stmt->bindValue(':memberLastname' . $number, $arrayParametters['memberLastname'.$number], PDO::PARAM_STR);
                $stmt->bindValue(':memberFirstname' . $number, $arrayParametters['memberFirstname'.$number], PDO::PARAM_STR);
                $stmt->bindValue(':memberPhone' . $number, $arrayParametters['memberPhone'.$number], PDO::PARAM_STR);
                $stmt->bindValue(':memberStreetNumber' . $number, $arrayParametters['memberStreetNumber'.$number], PDO::PARAM_STR);
                $stmt->bindValue(':memberStreetName' . $number, $arrayParametters['memberStreetName'.$number], PDO::PARAM_STR);
                $stmt->bindValue(':memberStreetComplement' . $number, $arrayParametters['memberStreetComplement'.$number], PDO::PARAM_STR);
                $stmt->bindValue(':memberZipCode' . $number, $arrayParametters['memberZipCode'.$number], PDO::PARAM_STR);
                $stmt->bindValue(':memberCity' . $number, $arrayParametters['memberCity'.$number], PDO::PARAM_STR);
                $stmt->bindValue(':memberBirthdate' . $number, $arrayParametters['memberBirthdate'.$number], PDO::PARAM_STR);
                $stmt->bindValue(':memberBirthPlace' . $number, $arrayParametters['memberBirthPlace'.$number], PDO::PARAM_STR);
                $stmt->bindValue(':memberIdPair', $arrayParametters['memberIdPair'], PDO::PARAM_INT);
                $stmt->bindValue(':memberMail' . $number, $arrayParametters['memberMail'.$number], PDO::PARAM_STR);
                $stmt->bindValue(':profession' . $number, $arrayParametters['profession'.$number], PDO::PARAM_STR);
                $stmt->bindValue(':familySituation' . $number, $arrayParametters['familySituation'.$number], PDO::PARAM_STR);
                $stmt->bindValue(':cafNumber' . $number, $arrayParametters['cafNumber'.$number], PDO::PARAM_STR);
                $stmt->bindValue(':memberCivility' . $number, $arrayParametters['memberCivility'.$number], PDO::PARAM_INT);
                $stmt->execute();
                $idMember = $stmt->fetchColumn();
                return $idMember;
            

        } catch (PDOException $e) {
            Loggy::warning("Un problème serveur est survenu" . $e);
            throw new ExceptionPersoDAO("Un problème serveur est survenu");
        }
    }

    public static function getOneMemberById(int $idPerson) {
        try {
            $pdo = baseConnection();
            $query = "SELECT * FROM  displayOneMember(:idPerson);";
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':idPerson', $idPerson, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

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