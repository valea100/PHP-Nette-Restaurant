<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use App\Model\Ukazovator;
use App\Model\Stolator;
use App\Model\Orderator;
use App\Model\Jidlator;
use Nette\Application\UI\Form;
use Nette\ComponentModel\IComponent;
use GroupDeleteFormFactory;
use GroupFormFactory;
use TableDeleteFormFactory;
use OrderFormFactory;

final class OrderPresenter extends HomePresenter
{
    private Ukazovator $ukazovator;
    private Stolator $stolator;
    private Orderator $orderator;
    private Jidlator $jidlator;
    private OrderFormFactory $orderFormFactory;
    private TableDeleteFormFactory $tableDeleteFormFactory;
    public function injectTable(
        TableDeleteFormFactory $tableDeleteFormFactory,
        OrderFormFactory $orderFormFactory,
        Stolator $stolator,
        Ukazovator $ukazovator,
        Orderator $orderator,
        Jidlator $jidlator,
    ){
        $this->stolator = $stolator;
        $this->orderFormFactory = $orderFormFactory;
        $this->tableDeleteFormFactory = $tableDeleteFormFactory;
        $this->ukazovator = $ukazovator;
        $this->orderator = $orderator;
        $this->jidlator = $jidlator;
    }

    public function renderDefault():void{
        $this->template->tableTables = $this->stolator->showAllTables();
        $this->template->orderFood = $this->stolator->showAllTableOrders();
    }
    protected function createComponentOrderForm(): Form{
        $foodss = $this->ukazovator->showTable('foods');
        $tabless = $this->ukazovator->showTable('resttables');
        $form = $this->orderFormFactory->create($foodss, $tabless);
        $form->onSuccess[] = [$this, 'orderFormSucceeded'];
        return $form;
    }

    protected function createComponentDeleteForm(): Form{
        $idk = $this->ukazovator->showTable('resttables');
        $form = $this->tableDeleteFormFactory->create($idk);
        $form->onSuccess[] = [$this, 'deleteSuccess'];
        return $form;
    }
    public function orderFormSucceeded(Form $form, $data): void{
        $userId = $this->getUser()->getId();
        $foodId = $this->jidlator->getFoodId($form['selectedFood']->getSelectedItem());
        $this->orderator->createOrder($foodId, 'pending', 'idk',
         $form['selectedTable']->getSelectedItem(), $userId);
        $this->redirect('Table:default');
    }

    public function deleteSuccess(Form $form, $data): void{
        $sel = $form['selected'];
        $this->stolator->delTable($sel->getSelectedItem());
        $this->redirect('Table:default');        
    }
}