<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use App\Model\Ukazovator;
use App\Model\Stolator;
use Nette\Application\UI\Form;
use Nette\ComponentModel\IComponent;
use TableFormFactory;
use GroupDeleteFormFactory;
use GroupFormFactory;
use TableDeleteFormFactory;

final class TablePresenter extends HomePresenter
{
    private Ukazovator $ukazovator;
    private Stolator $stolator;
    private TableFormFactory $tableFormFactory;
    private TableDeleteFormFactory $tableDeleteFormFactory;
    public function injectTable(
        TableDeleteFormFactory $tableDeleteFormFactory,
        TableFormFactory $tableFormFactory,
        Stolator $stolator,
        Ukazovator $ukazovator,
    ){
        $this->stolator = $stolator;
        $this->tableFormFactory = $tableFormFactory;
        $this->tableDeleteFormFactory = $tableDeleteFormFactory;
        $this->ukazovator = $ukazovator;
    }

    public function renderDefault():void{
        //$this->template->tableTables = $this->stolator->showAllTables();
        $this->template->orderFood = $this->stolator->showAllTableOrders();
    }
    protected function createComponentTableForm(): Form{
        $form = $this->tableFormFactory->create();
        $form->onSuccess[] = [$this, 'tableFormSucceeded'];
        return $form;
    }

    protected function createComponentDeleteForm(): Form{
        $idk = $this->ukazovator->showTable('resttables');
        $form = $this->tableDeleteFormFactory->create($idk);
        $form->onSuccess[] = [$this, 'deleteSuccess'];
        return $form;
    }
    public function tableFormSucceeded(Form $form, $data): void{
        $this->stolator->addTable();
        $this->redirect('Table:default');
    }

    public function deleteSuccess(Form $form, $data): void{
        $sel = $form['selected'];
        $this->stolator->delTable($sel->getSelectedItem());
        $this->redirect('Table:default');        
    }
}
