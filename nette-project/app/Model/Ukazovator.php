<?php

namespace App\Model;

use Nette;


final class Ukazovator
{
    public function __construct(
        private Nette\Database\Explorer $database,
    ) {
    }

    /**
     * @param int $count    Pocet vypsanych radku
     * @param array $params   Nazvy columns ktere chces vykreslit napr. ['id', 'email']
     */
    public function showUsers($count = -1, $params = [])
    {
        $result = false;
        $queryRequest = '';
        $cnt_par = count($params);
        
        if ($cnt_par === 0) {
            //show all
            $queryRequest = 'SELECT * FROM users';
        } else {
            $queryRequest = 'SELECT';
            for ($i = 0; $i < $cnt_par; $i++) {
                $queryRequest = $queryRequest . $params[$i] . ', ';
            }
            $queryRequest = substr($queryRequest, 0, -2); //odstranit carku
            $queryRequest = $queryRequest . ' FROM users';
        }

        if($count !== -1){
            $queryRequest = $queryRequest . ' limit ' . strval($count);
        }
        $queryRequest = $queryRequest . ';';
        $result = $this->database->query($queryRequest);
        return $result;
    }

    public function showGroups($count = -1, $params = []){
        $result = false;
        $queryRequest = '';
        $cnt_par = count($params);

        if ($cnt_par === 0) {
            //show all
            $queryRequest = 'SELECT * FROM groups';
        } else {
            $queryRequest = 'SELECT';
            for ($i = 0; $i < $cnt_par; $i++) {
                $queryRequest = $queryRequest . $params[$i] . ', ';
            }
            $queryRequest = substr($queryRequest, 0, -2); //odstranit carku
            $queryRequest = $queryRequest . ' FROM groups';
        }

        if($count !== -1){
            $queryRequest = $queryRequest . ' limit ' . strval($count);
        }
        $queryRequest = $queryRequest . ';';
        $result = $this->database->query($queryRequest);
        return $result;
    }

    public function createGroup($name){
        $result = $this->database->table('groups')->insert([
            'name' => $name,
        ]);
        
        return $result;
    }
}
