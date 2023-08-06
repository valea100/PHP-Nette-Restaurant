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
        /*$foods = $this->jidlator->showAllfoods();
        $prices = $this->cenator->showAllPrices($foods);
        $this->template->foods = $foods;
        $this->template->prices = $prices;*/
        $this->template->dataArr = $this->cenator->showFoodsAndPrices();

    }

    public function createComponentPriceForm(): Form{
        $form = $this->priceFormFactory->create();
        $form->onSuccess[] = [$this, 'priceSuccess'];
        return $form;
    }

    public function priceSuccess($form, $data){
        $foodName = $form->getHttpData($form::DataText, 'selectedFood');
        $foodID = $this->jidlator->getFoodId($foodName);
        $this->cenator->changePrice($foodID, $data->price);
        $this->redirect("Price:default");
    }


}