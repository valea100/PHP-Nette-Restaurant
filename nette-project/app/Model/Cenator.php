<?php

namespace App\Model;

use Nette;

use Nette\Database\Table\Selection;

final class Cenator
{
    public function __construct(
        private Nette\Database\Explorer $database,
    ) {
        $this->prices = $this->database->table("price_list");
    }

    public function addPrice($foodID, $price):void{
        if(is_int($price) && is_int($foodID)){
            $this->prices->insert([
                'food_id' => $foodID,
                'price' => $price,
            ]);
        }
    }

    public function deletePrice($foodID):void{
        $result = $this->database->table('price_list')->where('food_id', $foodID)->delete();
    }

    public function showPrice(int $foodID){
        $table = $this->database->table("price_list");
        $result = $table->where('food_id', $foodID)->fetch();
        return $result;
    }

    
    public function showAllPrices(Array $foodArray){
        $result = array();
        foreach($foodArray as $f){
            $img = $this->showPrice($f->id);
            $result += [$f->id => $img];
        }
        return $result;
    }

    /**
    * @return array, kde klic je jmeno jidla a cena je hodnota
    **/
    public function showFoodsAndPrices(){
        $priceTable = $this->database->table("price_list");
        $result = array();
        foreach($priceTable as $id => $row){
            $foodName = $row->ref('foods', 'food_id')->name;
            $result += [$foodName => $row->price];
        }
        return $result;
    }



    public function changePrice(int $foodID, int $newPrice):void {
        $this->prices->where('food_id', $foodID)->update([
            'price' => $newPrice,
        ]);
    }
}

    
