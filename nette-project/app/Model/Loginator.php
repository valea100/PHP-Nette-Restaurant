<?php
namespace App\Model;

use Nette;


final class Loginator
{
    public function __construct(
        private Nette\Database\Explorer $database,
    ){}

    public function signIn($email, $password):bool {
        //BLOWFISH 2A
        $result = $this->database->query(
            "SELECT * FROM users WHERE email = ? AND password = crypt(?, password)",
            $email, $password
        );

        $cnt = $result->getRowCount();

        if ($cnt === 0){
            return false;
        }
        elseif ($cnt === 1){
            return true;
        }
        else{
            //nejaky error sem
            return false;
        }

    }

}