<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;

use App\Model\Ukazovator;
use Nette\Database\ResultSet;
use Nette\Application\UI\Form;
use Nette\Utils\Html;

final class ViewerPresenter extends Nette\Application\UI\Presenter
{
    public function __construct(
        private Ukazovator $ukazovator,
        private Nette\Database\Explorer $db,
    ){}
    
    public function renderDefault():void{
        $idk = $this->ukazovator->showUsers();
        $this->template->tableUser = $this->createTable($idk, ['ID', 'EMAIL', 'PASSWORD', 'FIRST NAME', 'LAST NAME', 'GROUP ID']);

        $idk = $this->ukazovator->showGroups();
        $this->template->tableGroup = $this->createTable($idk, ['ID', 'NAME']);
    }

    public function renderGroups():void{
        $idk = $this->ukazovator->showGroups();
        $this->template->tableGroup = $this->createTable($idk, ['ID', 'NAME']);
    }

    private function createTable(ResultSet $data, array $description): Html{
        $colCount = $data->getColumnCount();
        $rowCount = $data->getRowCount();
        $desc = '<tr class="viewNadpis">';

        foreach ($description as $d) {
            $desc = $desc . '<th> ' . $d . ' </th> ';
        }

        $desc = $desc . '</trc>';
        $t = Html::el('table');
        $t[] = $desc;

        $rowD = $data->fetchAll();
        
        $desc = '';
        for ($i=0; $i < $rowCount; $i++) {
            $desc = $desc . '<tr>';
            for ($z=0; $z < $colCount; $z++) { 
                $desc = $desc . '<th>' . $rowD[$i][$z] . '</th>';
            }
            $desc = $desc . '</tr>'; 
        }
        $t[] = $desc;

        return $t;
    }

    protected function createComponentGroupForm(): Form{
        $form = new Form;
        $form->addText('name', 'Jméno skupiny')->setRequired();
        $form->addSubmit('send', 'Create');
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
