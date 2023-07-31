<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use App\Model\Ukazovator;
use App\Model\Jidlator;
use App\Model\Cenator;
use Nette\Application\UI\Form;
use PriceFormFactory;

final class PricePresenter extends HomePresenter
{
    private Ukazovator $ukazovator;
    private Jidlator $jidlator;
    private Cenator $cenator;
    private PriceFormFactory $priceFormFactory;
    public function injectTable(
        Ukazovator $ukazovator,
        Jidlator $jidlator,
        Cenator $cenator,
        PriceFormFactory $priceFormFactory,
    ){
        $this->ukazovator = $ukazovator;
        $this->jidlator = $jidlator;
        $this->cenator = $cenator;
        $this->priceFormFactory = $priceFormFactory;
    }

    public function renderDefault():void{
        $foods = $this->jidlator->showAllfoods();
        $prices = $this->cenator->showAllPrices($foods);
        $this->template->foods = $foods;
        $this->template->prices = $prices;

    }

    public function createComponentPriceForm(): Form{
        $foodss = $this->ukazovator->showTable('foods');
        $form = $this->priceFormFactory->create($foodss);
        $form->onSuccess[] = [$this, 'priceSuccess'];
        return $form;
    }

    public function priceSuccess($form, $data){
        $foodID = $this->jidlator->getFoodId($form['selectedFood']->getSelectedItem());
        $this->cenator->changePrice($foodID, $data->price);
        $this->redirect("Price:default");
    }


}