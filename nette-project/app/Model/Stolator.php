<?php

namespace App\Model;

use Nette;

use Nette\Database\Table\Selection;

final class Stolator
{
    public function __construct(
        private Nette\Database\Explorer $database,
    ) {
        $this->table = $this->database->table("resttables");
    }

    /**
     * @return array all table id
     */
    public function showAllTables():array
    {
        $result = [];
        foreach ($this->table as $item) {
            array_push($result, $item->id);
        }
        return $result;
    }

    public function addTable():bool{
        $this->table->insert([
            'isused' => 0,
        ]);
        return true;
    }
    public function delTable($id){
        $result = $this->table->where('id', $id)->delete();
        return $result;
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

    public function showAllTableOrders(){
        $tableArray = $this->showAllTables();
        $result = [];
        foreach($this->table as $item) {
            $order = $this->showTableOrder($item->id);
            if (!isset($order->food_id)) {
                array_push($result, $this->showFood(-1));
            }else array_push($result, $this->showFood($order->food_id));   
        }
        return $result;
    }
}
