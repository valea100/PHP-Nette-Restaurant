<?php
namespace App\Model;

use Nette;
use Nette\Security\Passwords;


final class Registrator
{
    public function __construct(
        private Nette\Database\Explorer $database,
        private Passwords $passwords,
    ){}



    public function createUser($email, $password, $firstname, $lastname, $group_id): bool
    {

        $hashP = $this->passwords->hash($password);
        $result = $this->database->query(
            "INSERT INTO users (email, password, firstname, lastname, group_id) VALUES (
                ?, ?, ?, ?, ? );", $email, $hashP, $firstname, $lastname, $group_id);
        
        $cnt = $result->getRowCount();
        return $cnt===1;
    }
}