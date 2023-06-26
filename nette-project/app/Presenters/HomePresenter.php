<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;


final class HomePresenter extends Nette\Application\UI\Presenter
{
    public function __construct(){
    }


    public function renderDefault()
    {
        $text = 'jakub1';
        $hashp = password_hash($text, PASSWORD_BCRYPT);
        if('$1$gjplngkD$.0nQluBdLOczxSuwfbbW41' === $hashp)
        {
            echo "je tomu tak";
        }
        else{
            echo $hashp;
        }
        
    }
}
