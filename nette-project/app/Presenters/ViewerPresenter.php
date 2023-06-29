<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use App\Model\Ukazovator;
use Nette\Database\ResultSet;
use Nette\Application\UI\Form;
use Nette\Utils\Html;

use GroupFormFactory;
use Nette\Database\Table\ActiveRow;

final class ViewerPresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private Ukazovator $ukazovator,
        private Nette\Database\Explorer $db,
        private GroupFormFactory $groupFormFactory,
    ){}
    
    public function renderDefault():void{
        $idk = $this->ukazovator->showTable('users');
        $this->template->tableUser = $this->createTable($idk, ['id', 'email', 'firstname', 'lastname', 'group_id']);

        $idk = $this->ukazovator->showTable('groups');
        $this->template->tableGroup = $this->createTable($idk, ['id', 'name']);
    }

    public function renderGroups():void{
        $idk = $this->ukazovator->showTable('groups');
        $this->template->tableGroup = $this->createTable($idk, ['id', 'name']);
    }

    private function createTable($data, array $description): Html{
        $rowCount = count($data);
        $desc = '<tr class="viewNadpis">';

        foreach ($description as $d) {
            $desc = $desc . '<th> ' . $d . ' </th> ';
        }

        $desc = $desc . '</tr>';
        $t = Html::el('table');
        $t[] = $desc;

        
        $desc = '';
        for ($i=0; $i < $rowCount; $i++) {
            $desc = $desc . '<tr>';
            $row = $data->fetch();
            foreach ($description as $d) { 
                $desc = $desc . '<th>' . $row->offsetGet($d) . '</th>';
            }
            $desc = $desc . '</tr>'; 
        }
        $t[] = $desc;

        return $t;
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
