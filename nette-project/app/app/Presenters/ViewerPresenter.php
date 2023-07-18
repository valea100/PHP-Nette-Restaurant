<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use App\Model\Ukazovator;
use Nette\Application\UI\Form;


use TableFactory;
use GroupFormFactory;
use GroupDeleteFormFactory;

final class ViewerPresenter extends HomePresenter
{
    private Ukazovator $ukazovator;
    private GroupFormFactory $groupFormFactory;
    private GroupDeleteFormFactory $groupDeleteFormFactory;
    private TableFactory $tableFactory;
    public function injectViewer(
        Ukazovator $ukazovator,
        GroupFormFactory $groupFormFactory,
        GroupDeleteFormFactory $groupDeleteFormFactory,
        TableFactory $tableFactory,        
    ){
        $this->ukazovator = $ukazovator;
        $this->groupFormFactory = $groupFormFactory;
        $this->groupDeleteFormFactory = $groupDeleteFormFactory;
        $this->tableFactory = $tableFactory;
    }
    /*public function __construct(
        private Ukazovator $ukazovator,
        private Nette\Database\Explorer $db,
        private GroupFormFactory $groupFormFactory,
        private GroupDeleteFormFactory $groupDeleteFormFactory,
        private TableFactory $tableFactory,
    ){}*/
    
    public function startup(){
        parent::startup();

        if($this->getUser()->isLoggedIn() === false){
            $this->redirect('Sign:in');
        }
    }

    public function renderDefault():void{
        $idk = $this->ukazovator->showTable('users');
        $this->template->tableUser = $this->tableFactory->create($idk, ['id', 'email', 'firstname', 'lastname', 'group_id']);

        $idk = $this->ukazovator->showTable('groups');
        $this->template->tableGroup = $this->tableFactory->create($idk, ['id', 'name']);
    }

    public function renderGroups():void{
        $idk = $this->ukazovator->showTable('groups');
        $this->template->tableGroup = $this->tableFactory->create($idk, ['id', 'name']);
    }

    protected function createComponentGroupForm(): Form{
        $form = $this->groupFormFactory->create();
        $form->onSuccess[] = [$this, 'groupFormSucceeded'];
        return $form;
    }

    protected function createComponentGroupDelForm(): Form{
        $idk = $this->ukazovator->showTable('groups');
        $form = $this->groupDeleteFormFactory->create($idk);
        $form->onSuccess[] = [$this, 'groupDelSucceeded'];
        return $form;
    }
    public function groupFormSucceeded(Form $form, $data): void{
        if(strlen($data->name) === 0)
        {
            $this->flashMessage('wrong');
            $this->redirect('Viewer:groups');
        }
        else{
            $this->ukazovator->createGroup($data->name);
            $this->redirect('Viewer:groups');
        }
    }

    public function groupDelSucceeded(Form $form, $data): void
    {
        $sel = $form['selected'];
        $this->ukazovator->deleteGroup($sel->getSelectedItem());
        $this->redirect('Viewer:groups');
    }
    
    public function actionSignOut(){
        $this->getUser()->logout();
        $this->redirect('Sign:in');
    }


}
