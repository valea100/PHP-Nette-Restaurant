<?php
namespace App\Model;

use Nette;
use Nette\Security\Passwords;

final class Loginator
{
    public function __construct(
        private Nette\Database\Explorer $database,
        private Passwords $passwords,
    ){}

    public function signIn($email, $password):bool {
        //BLOWFISH 2A
        $table = $this->database->table('users');
        $table->where('email', $email)->select('password');
        $hashP = $table->fetch();
        $hashP = $hashP->offsetGet('password'); 
        if($this->passwords->verify($password, $hashP))
        {
            return true;
        } else return false;
    }

}