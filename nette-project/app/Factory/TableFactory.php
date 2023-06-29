<?php
use Nette\Utils\Html;



class TableFactory{
    public function __construct(

        ){}

    public function create($data, array $description): Html{
        $rowCount = count($data);
        $desc = '<tr class="viewNadpis">';

        foreach ($description as $d) {
            $desc = $desc . '<th> ' . $d . ' </th> ';
        }

        $desc = $desc . '</tr>';
        $t = Html::el('table');
        $t[] = $desc;

        
        $desc = '';
        for ($i=0; $i < $rowCount; $i++) {
            $desc = $desc . '<tr>';
            $row = $data->fetch();
            foreach ($description as $d) { 
                $desc = $desc . '<th>' . $row->offsetGet($d) . '</th>';
            }
            $desc = $desc . '</tr>'; 
        }
        $t[] = $desc;

        return $t;
    }
}