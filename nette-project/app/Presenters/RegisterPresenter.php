<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;

use App\Model\Registrator;

final class RegisterPresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private Registrator $registrator,
    ){}
    protected function createComponentRegisterForm(): Form{
        $form = new Form;
        $form->addText('firstname', 'Jméno')->setRequired();
        $form->addText('lastname', 'Příjmení')->setRequired();
        $form->addText('email', 'email')->setRequired();
        $form->addPassword('password', 'password')->setRequired();
        $form->addPassword('password2', 'password again')->setRequired();
        $form->addInteger('group_id', 'grupa');
        $form->addSubmit('send', 'send');
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
            $this->redirect('Viewer:default');
        }
    }

}