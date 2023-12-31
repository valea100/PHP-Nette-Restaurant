<?php

namespace App\Model;

use Nette;

use Nette\Database\Table\Selection;

final class Jidlator
{
    public function __construct(
        private Nette\Database\Explorer $database,
    ) {
        $this->table = $this->database->table("foods");
        $this->prices = $this->database->table("price_list");
    }

    /**
     * @return array all table id
     */
    /*public function showAllfoods():array
    {
        $result = [];
        foreach ($this->table as $item) {
            array_push($result, $item->id);
        }
        return $result;
    }**/

    public function getFoodId($foodName){
        $result = $this->table->where('name', $foodName)->fetch();
        return $result->id;
    }
    /**
     * @param $id Id of table to show order
     * @return table order
     */ 
    public function showTableOrder($id){
        $orderId = $this->table->get($id)->ordersid;
        $orderTable = $this->database->table("orders");
        $result = $orderTable->get($orderId);
        return $result;
    }

    public function showFood($id){
        $foodTable = $this->database->table("foods");
        $result = $foodTable->get($id)->name;
        return $result;
    }

    public function showAllfoods(){
        $result = $this->table->fetchAll();
        return $result;
    }

    public function showAllTableOrders(){
        $tableArray = $this->showAllTables();
        $result = [];
        foreach($this->table as $item) {
            $order = $this->showTableOrder($item->id);
            array_push($result, $this->showFood($order->food_id));   
        }
        return $result;
    }

    public function insertFood($name, $quantity):void{
        if(is_string($name) && is_int($quantity)){
            $this->table->insert([
                'name' => $name,
                'quantity' => $quantity,
            ]);
        }
    }

    public function addPrice($foodID, $price):void{
        if(is_int($price) && is_int($foodID)){
            $this->prices->insert([
                'food_id' => $foodID,
                'price' => $price,
            ]);
        }
    }

    public function deleteFood($foodID):void{
        $result = $this->database->table("foods")->where('id', $foodID)->delete();
    }





}
