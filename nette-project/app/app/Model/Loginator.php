<?php
namespace App\Model;

use Nette\Database\Explorer;
use Nette\Security\Passwords;
use Nette\Security\IIdentity;

final class Loginator implements \Nette\Security\Authenticator
{
    public function __construct(
        private Explorer $database,
        private Passwords $passwords,
    ){}

    public function authenticate($email, $password): IIdentity {
        //BLOWFISH 2A
        $table = $this->database->table('users');
        $table->where('email', $email);
        $line = $table->fetch();
        if ($line !== null) {
            $hashP = $line->offsetGet('password'); 
        } else throw new \Nette\Security\AuthenticationException("Wrong mail or password");

        if($this->passwords->verify($password, $hashP))
        {
            return new \Nette\Security\SimpleIdentity($line->id, $line->group_id, ['firstname' => $line->firstname]);
        } else throw new \Nette\Security\AuthenticationException("Wrong mail or password");
        
    }
}