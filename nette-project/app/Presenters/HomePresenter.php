<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;

#TRIDA POUZE PRO ZJISTENI, JESTLI JE UZIVATEL PRIHLASEN..... ODSUD DEDI VSECHNY PRESENTERY (KROME SIGN A REGISTER PRESENTERU)

class HomePresenter extends Nette\Application\UI\Presenter
{

    public function startup(){
        parent::startup();

        if($this->getUser()->isLoggedIn() === false){
            $this->redirect('Sign:in');
        }
    }
    public function actionSignOut(){
        $this->getUser()->logout();
        $this->redirect('Sign:in');
    }

}
