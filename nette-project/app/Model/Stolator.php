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

    public function showTablesByOrder():array{
        $result = array();
        $orders = $this->database->table("orders");
        foreach($orders as $order){
            $orderID = $order->id;
            $result += [$orderID => $order->table_id];
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

    public function delOrderInTable($orderID):void{
        $result = $this->database->table("resttables")->where('ordersid', $orderID)->update([
            'ordersid' => null
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

    public function showFood($id){
        $foodTable = $this->database->table("foods");
        $result = $foodTable->get($id)->name;
        return $result;
    }

    public function showAllTableOrders(){
        $tables = $this->database->table("resttables");
        $result = array();
        foreach($tables as $table) {
            $order = $this->database->table("orders")->where('table_id', $table->id);
            $result += [$table->id => count($order)]; 
        }
        return $result;
    }

    public function addOrderToTable($tableID, $orderID):void{
        $t = $this->database->table("resttables")->where('id', $tableID);
        $t->update([
            'ordersid' => $orderID,
        ]);
    }

    public function showAllTables(){
        $tables = $this->database->table("resttables")->select('id');
        return $tables->fetchAll();
    }
}
