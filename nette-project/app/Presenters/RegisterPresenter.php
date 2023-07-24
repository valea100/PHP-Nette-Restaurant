<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;

use App\Model\Registrator;
use RegisterFormFactory;

final class RegisterPresenter extends Nette\Application\UI\Presenter
{
    private Registrator $registrator;
    private RegisterFormFactory $registerFormFactory;

    public function injectRegister(
        Registrator $registrator,
        RegisterFormFactory $registerFormFactory,
    ){
        $this->registrator = $registrator;
        $this->registerFormFactory = $registerFormFactory;
    }
    /*public function __construct(
        private Registrator $registrator,
        private RegisterFormFactory $registerFormFactory,
    ){}*/

    public function startup():void{
        parent::startup();
        $this->setLayout('layout-sign');
        if($this->getUser()->isLoggedIn() === true){
            $this->redirect('Viewer:default');
        }
    }
    
    protected function createComponentRegisterForm(): Form{
        $form = $this->registerFormFactory->create();
        $form->onSuccess[] = [$this, 'formSucceeded'];
        return $form;
    }

    public function formSucceeded(Form $form, $data): void{
        if($data->password !== $data->password2)
        {
            $this->flashMessage('velke spatne');
            $this->redirect('Register:register');
        }
        else{
            $this->registrator->createUser($data->email, $data->password, $data->firstname, $data->lastname, $data->group_id);
            $this->redirect('Sign:in');
        }
    }

}