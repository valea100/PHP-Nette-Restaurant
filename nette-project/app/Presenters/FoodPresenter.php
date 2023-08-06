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
use Nette\Utils\Image;
use Nette\Utils\FileUpload;
use TableDeleteFormFactory;
use OrderFormFactory;
use FoodFormFactory;

final class FoodPresenter extends HomePresenter
{
    private Ukazovator $ukazovator;
    private Stolator $stolator;
    private Orderator $orderator;
    private Jidlator $jidlator;
    private Imaginator $imaginator;
    private Cenator $cenator;
    private OrderFormFactory $orderFormFactory;
    private TableDeleteFormFactory $tableDeleteFormFactory;
    private FoodFormFactory $foodFormFactory;
    public function injectTable(
        TableDeleteFormFactory $tableDeleteFormFactory,
        OrderFormFactory $orderFormFactory,
        Stolator $stolator,
        Ukazovator $ukazovator,
        Orderator $orderator,
        Jidlator $jidlator,
        Imaginator $imaginator,
        Cenator $cenator,
        FoodFormFactory $foodFormFactory,
    ){
        $this->stolator = $stolator;
        $this->orderFormFactory = $orderFormFactory;
        $this->tableDeleteFormFactory = $tableDeleteFormFactory;
        $this->foodFormFactory = $foodFormFactory;
        $this->ukazovator = $ukazovator;
        $this->orderator = $orderator;
        $this->jidlator = $jidlator;
        $this->imaginator = $imaginator;
        $this->cenator = $cenator;
    }

    public function renderDefault():void{
        $foods = $this->jidlator->showAllfoods();
        $images = $this->imaginator->showAllFoodImages($foods);
        $prices = $this->cenator->showAllPrices($foods);
        $this->template->images = $images;
        $this->template->foods = $foods;
        $this->template->prices = $prices;

    }

    public function createComponentFoodForm(): Form{
        $form = $this->foodFormFactory->create();
        $form->onSuccess[] = [$this, 'foodSuccess'];
        return $form;
    }

    public function createComponentDeleteFoodForm(): Form{
        $form = $this->foodFormFactory->create();
        $form->onSuccess[] = [$this, 'foodDelete'];
        return $form;
    }

    public function foodSuccess(Form $form, $data){
        $images = $data->image;
        if(!($this->saveImage($images, $data))){
            $this->redirect('Viewer:default');
        } else $this->redirect('Food:default');
    }

    private function saveImage($images, $data):bool{
        if($images->isOk() && $images->isImage()){
            $image = $images->toImage();
            $hashName = random_int(1, 12345678);    //random name
            while($this->imaginator->checkImage(strval($hashName))){
                $hashName = random_int(1, 12345678);
            }
            $hashName = strval($hashName);
            $myPath = 'img/'.$hashName.'.png';
             
            $image->save($myPath);
            $this->jidlator->insertFood($data->name, $data->quantity);
            $foodID = $this->jidlator->getFoodId($data->name);
            $this->cenator->addPrice($foodID, $data->price);
            $this->imaginator->insertImage($myPath, $image->getHeight(), $image->getWidth(), $this->jidlator->getFoodId($data->name), $hashName);
            return true;
        }else return false; //exception sem
    }

    public function handleDeleteFood($food): void
    {
        if($this->orderator->isFoodInOrder($food)){
            //pridat do renderu nejake info
        }
        else{
            $this->cenator->deletePrice($food);
            $this->imaginator->deleteImage($food);
            $this->jidlator->deleteFood($food);
        }
    }

}