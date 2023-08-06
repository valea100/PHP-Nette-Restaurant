<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use App\Model\Ukazovator;
use App\Model\Stolator;
use App\Model\Orderator;
use App\Model\Jidlator;
use App\Model\Imaginator;
use App\Model\Cenator;
use Nette\Application\UI\Form;
use OrderDeleteFormFactory;
use OrderFormFactory;
use OrderChangeFormFactory;

final class OrderPresenter extends HomePresenter
{
    private Ukazovator $ukazovator;
    private Stolator $stolator;
    private Orderator $orderator;
    private Jidlator $jidlator;
    private Imaginator $imaginator;
    private Cenator $cenator;
    private OrderFormFactory $orderFormFactory;
    private OrderDeleteFormFactory $orderDeleteFormFactory;
    private OrderChangeFormFactory $orderChangeFormFactory;
    public function injectTable(
        OrderDeleteFormFactory $orderDeleteFormFactory,
        OrderFormFactory $orderFormFactory,
        OrderChangeFormFactory $orderChangeFormFactory,
        Stolator $stolator,
        Ukazovator $ukazovator,
        Orderator $orderator,
        Jidlator $jidlator,
        Imaginator $imaginator,
        Cenator $cenator,
    ){
        $this->stolator = $stolator;
        $this->orderFormFactory = $orderFormFactory;
        $this->orderDeleteFormFactory = $orderDeleteFormFactory;
        $this->orderChangeFormFactory = $orderChangeFormFactory;
        $this->ukazovator = $ukazovator;
        $this->orderator = $orderator;
        $this->jidlator = $jidlator;
        $this->imaginator = $imaginator;
        $this->cenator = $cenator;
    }

    public function renderDefault():void{
        $orderss = $this->orderator->showAllOrders();
        $this->template->myOrders= $orderss;
        $foods = $this->jidlator->showAllfoods();
        $this->template->foods = $foods;
        $this->template->images = $this->imaginator->showAllFoodImages($foods);
        $this->template->prices = $this->cenator->showAllPrices($foods);
        $this->template->tablesID = $this->stolator->showAllTables();
    }
    protected function createComponentOrderForm(): Form{
        $form = $this->orderFormFactory->create();
        $form->onSuccess[] = [$this, 'orderFormSucceeded'];
        return $form;
    }

    protected function createComponentDeleteForm(): Form{
        $form = $this->orderDeleteFormFactory->create();
        $form->onSuccess[] = [$this, 'deleteSuccess'];
        return $form;
    }

    protected function createComponentStatusForm(): Form{
        $form = $this->orderChangeFormFactory->create();
        $form->onSuccess[] = [$this, 'statusSuccess'];
        return $form;
    }

    public function orderFormSucceeded(Form $form, $data): void{
        $userId = $this->getUser()->getId();
        $foodId = intval($form->getHttpData($form::DataText, 'selectedFood'));
        $tableId = intval($form->getHttpData($form::DataText, 'selectedTable'));
        $orderId = $this->orderator->createOrder($foodId, 'pending', 'idk', $tableId, $userId);
        //$this->stolator->addOrderToTable($form['selectedTable']->getSelectedItem(), $orderId);
        $this->redirect('Order:default');
    }

    public function deleteSuccess(Form $form, $data): void{
        $sel = intval($form->getHttpData($form::DataText, 'selectedOrder'));
        //$this->stolator->delOrderInTable($data->selectedOrder);
        $this->orderator->delOrder($sel);
        $this->redirect('Order:default');        
    }

    public function statusSuccess(Form $form, $data): void{
        $status = $form['selectedStatus']->getSelectedItem();
        $orderID = intval($form->getHttpData($form::DataText, 'selectedOrder'));
        $this->orderator->changeStatus($orderID, $status);
        $this->redirect('Order:default');
    }
}


//selectedTable