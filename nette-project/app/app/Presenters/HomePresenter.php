<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;


class HomePresenter extends Nette\Application\UI\Presenter
{

    public function startup(){
        parent::startup();

        if($this->getUser()->isLoggedIn() === false){
            $this->redirect('Sign:in');
        }
    }

}
