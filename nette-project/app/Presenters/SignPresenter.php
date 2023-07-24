<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\User;
use App\Model\Loginator;
use SignInFormFactory;

final class SignPresenter extends Nette\Application\UI\Presenter
{
    private Loginator $loginator;
    private SignInFormFactory $signInFormFactory;
    private User $user;
    public function injectSign(
        Loginator $loginator,
        SignInFormFactory $signInFormFactory,
        User $user,
    ){
        $this->loginator = $loginator;
        $this->signInFormFactory = $signInFormFactory;
        $this->user = $user;
    }
    /*public function __construct(
        private Loginator $loginator,
        private SignInFormFactory $signInFormFactory,
    ){}*/

    public function startup():void{
        parent::startup();
        $this->setLayout('layout-sign');
        if($this->getUser()->isLoggedIn() === true){
            $this->redirect('Viewer:default');
        }
    }
    
    protected function createComponentSignInForm(): Form{
        $form = $this->signInFormFactory->create();
        $form->onSuccess[] = [$this, 'formSucceeded'];
        return $form;
    }

    public function formSucceeded(Form $form, $data): void{
        
        try{
            $this->getUser()->login($data->email, $data->password);
        } catch (Nette\Security\AuthenticationException $e) {
            $this->flashMessage($e->getMessage(), 'danger');
            $this->redirect('Sign:in');
        }

        $this->redirect('Viewer:default');

        /*$suc = $this->loginator->signIn($data->email, $data->password);
        if($suc === true){
            $this->redirect('Viewer:default');
        }else{
            $this->flashMessage('Spatnej login');
            $this->redirect('Sign:in');
        }*/
    }
}