<?php
namespace App\Model;

    use Nette;


final class Registrator
{
    public function __construct(
        private Nette\Database\Explorer $database,
    ){}



    public function createUser($email, $password, $firstname, $lastname, $group_id): bool
    {
        //BLOWFISH 2A
        $result = $this->database->query(
            "INSERT INTO users (email, password, firstname, lastname, group_id) VALUES (
                ?, crypt(?, gen_salt('bf')), ?, ?, ? );", $email, $password, $firstname, $lastname, $group_id);
        
        $cnt = $result->getRowCount();

        if($cnt === 1){
            return true;
        }
        else{
            return false;
        }
    }
}