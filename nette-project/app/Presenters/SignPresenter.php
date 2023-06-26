<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;

use App\Model\Loginator;

final class SignPresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private Loginator $loginator,
    ){}
    
    protected function createComponentSignInForm(): Form{
        $form = new Form;
        $form->addText('email', 'email')->setRequired();
        $form->addPassword('password', 'password')->setRequired();
        $form->addSubmit('send', 'send');
        $form->onSuccess[] = [$this, 'formSucceeded'];
        return $form;
    }

    public function formSucceeded(Form $form, $data): void{
        $suc = $this->loginator->signIn($data->email, $data->password);
        if($suc === true){
            $this->redirect('Viewer:default');
        }else{
            $this->flashMessage('Spatnej login');
            $this->redirect('Sign:in');
        }
    }
}