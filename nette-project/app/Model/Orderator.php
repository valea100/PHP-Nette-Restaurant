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
        $orders = $this->database->table("orders")->fetchAll();
        return $orders;
    }

    public function createOrder($food, $status, $about, $stul, $userId):int{
        $row = $this->table->insert([
            'food_id' => $food,
            'status' => $status,
            'about' => $about,
            'user_id' => $userId,
            'table_id' => intval($stul),
        ]);
        $foodData = $this->database->table("foods")->where('id', $food)->update([
            'quantity-=' => 1,
        ]);

        return $row->id;
    }

    public function delOrder($id){
        $result = $this->database->table("orders")->where('id', $id)->delete();
        return $result;
    }

    public function changeStatus(int $id, string $status):void{
        $result = $this->database->table("orders")->where('id', $id)->update([
            'status' => $status,
        ]);
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

    public function showAllTableOrders($tableID):array{
        $table = $this->database->table('orders')->where('table_id', $tableID);
        $result = array();
        foreach($table as $item) {
            $result += [$item->id => $item];
        }
        return $result;
    }

    public function isFoodInOrder($foodID):bool{
        $result = $this->database->table('orders')->where('food_id', $foodID)->fetch();
        return isset($result);
    }
}
