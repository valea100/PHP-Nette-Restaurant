<?php

namespace App\Model;

use Nette;

use Nette\Database\Table\Selection;

final class Stolator
{
    public function __construct(
        private Nette\Database\Explorer $database,
    ) {
    }

    /**
     * @param int $count    Pocet vypsanych radku
     * @param array $params   Nazvy columns ktere chces vykreslit napr. ['id', 'email']
     * @return array all table id
     */
    public function showAllTables():array
    {
        $table = $this->database->table("resttables");
        $result = [];
        foreach ($table as $item) {
            array_push($result, $item->id);
        }
        return $result;
    }

    public function addTable():bool{
        $table = $this->database->table("resttables");

        $table->insert([
            'isused' => 0,
        ]);
        return true;
    }
    public function delTable($id){
        $result = $this->database->table('resttables')->where('id', $id)->delete();
        return $result;
    }
}
