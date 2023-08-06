<?php

namespace App\Model;

use Nette;

use Nette\Database\Table\Selection;

final class Ukazovator
{
    public function __construct(
        private Nette\Database\Explorer $database,
    ) {
    }

    /**
     * @param int $count    Pocet vypsanych radku
     * @param array $params   Nazvy columns ktere chces vykreslit napr. ['id', 'email']
     * @return Selection    table selection
     */
    public function showTable(string $tableName,$count = -1, $params = []):Selection
    {
        $table = $this->database->table($tableName);
        $cntPar = count($params);
        if($count !== -1){
            $table->limit($count);
        }
        if ($cntPar !== 0){ 
            $table->select(implode(' ', $params));
            echo gey;
        }
        return $table;

    }
    public function createGroup($name){
        $result = $this->database->table('groups')->insert([
            'name' => $name,
        ]);
        
        return $result;
    }

    public function deleteGroup($name){
        $result = $this->database->table('groups')->where('name', $name)->delete();
        return $result;
    }
}
