<?php

namespace App\Model;

use Nette;

use Nette\Database\Table\Selection;
use Nette\Security\User;

final class Orderator
{
    public function __construct(
        private Nette\Database\Explorer $database,
        private User $user,
    ) {
        $this->table = $this->database->table("orders");
    }

    /**
     * @return array all table id
     */
    public function showAllOrders():array
    {
        $result = [];
        foreach ($this->table as $item) {
            array_push($result, $item->id);
        }
        return $result;
    }

    public function createOrder($food, $status, $about, $stul, $userId):bool{
        $this->table->insert([
            'food_id' => $food,
            'status' => $status,
            'about' => $about,
            'user_id' => $userId,
        ]);
        return true;
    }

    public function addTable():bool{
        $this->table->insert([
            'ordersid' => -1,   //-1 => no order
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



    public function showAllTableOrders(){
        $tableArray = $this->showAllTables();
        $result = [];
        foreach($this->table as $item) {
            $order = $this->showTableOrder($item->id);
            array_push($result, $this->showFood($order->food_id));   
        }
        return $result;
    }
}
