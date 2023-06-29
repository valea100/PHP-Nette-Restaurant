<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use App\Model\Ukazovator;
use Nette\Database\ResultSet;
use Nette\Application\UI\Form;
use Nette\Utils\Html;


use TableFactory;
use GroupFormFactory;
use Nette\Database\Table\ActiveRow;

final class ViewerPresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private Ukazovator $ukazovator,
        private Nette\Database\Explorer $db,
        private GroupFormFactory $groupFormFactory,
        private TableFactory $tableFactory,
    ){}
    
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


    


}
