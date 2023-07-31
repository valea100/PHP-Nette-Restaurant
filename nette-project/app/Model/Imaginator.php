<?php

namespace App\Model;

use Nette;

use Nette\Database\Table\Selection;
use Nette\Utils\Validators;

final class Imaginator
{
    public function __construct(
        private Nette\Database\Explorer $database,
    ) {
        $this->tableImages = $this->database->table("food_images");
        $this->tableFoods = $this->database->table("foods");
    }

    /**
     * @param $foodID ID of food, that you want image of
     * @return url or path to img
     */
    public function showImage($foodID){
        $tabulka = $this->database->table('food_images');
        $result = $tabulka->where('food_id', $foodID)->fetch();
        if(!isset($result->link)){
            return false;
        }else return $result->link;
    }

    /**
     * @param $foodArray array plnej activeRows z foods tabulky
     * @return associative array, kde klic je id jidla a hodnota  je link na obrazek k jidlu
     */
    public function showAllFoodImages(Array $foodArray){
        $result = array();
        foreach($foodArray as $f){
            $img = $this->showImage($f->id);
            $result += [$f->id => $img];
        }
        return $result;
    }

    public function insertImage($link, $height, $width, $foodID, $fileName){
        $this->tableImages->insert([
            'height' => $height,
            'width' => $width,
            'food_id' => $foodID,
            'link' => $link,
            'filename' => $fileName,
        ]);
    }

    public function insertImage2($link, $height, $width, $about){
        if(Validators::isUrl($link) && is_array($about) && is_int($height) && is_int($width)){
                $this->tableImages->insert([
                'height' => $height,
                'width' => $width,
                'about' => $about,
                'link' => $link,
            ]);
        }
    }

    public function checkImage($name):bool{
        $file = $this->tableImages->where("filename", $name)->fetch();
        if (isset($file)) {
            return true;
        } else return false;
    }

}
