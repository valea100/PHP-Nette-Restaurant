<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;

use App\Model\Loginator;
use SignInFormFactory;

final class SignPresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private Loginator $loginator,
        private SignInFormFactory $signInFormFactory,
    ){}
    
    protected function createComponentSignInForm(): Form{
        $form = $this->signInFormFactory->create();
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