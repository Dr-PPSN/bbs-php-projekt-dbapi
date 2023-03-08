<?php
require_once("hv-table.php");
require_once("hv-a.php");
require_once("hv-p.php");
require_once("hv-button.php");
require_once("hv-img.php");

class HV_HTML_Engine{
    public function getTable($tableData, $class, $id, $style, $orderBy, $orderDirection, $thClass, $tdClass){
        $table = new HV_Table($tableData, $class, $id, $style, $orderBy, $orderDirection);
        $table->setThClass($thClass);
        $table->setTdClass($tdClass);
        return $table->getTable();
    }
    public function getA($text, $class, $id, $style, $href){
        $a = new HV_A($text, $class, $id, $style, $href);
        return $a->getA();
    }
    public function getP($text, $class, $id, $style){
        $p = new HV_P($text, $class, $id, $style);
        return $p->getP();
    }
    public function getButton($text, $class, $id, $style){
        $button = new HV_Button($text, $class, $id, $style);
        return $button->getButton();
    }
    public function getImg($class, $id, $style, $src){
        $img = new HV_Img($class, $id, $style, $src);
        return $img->getImg();
    }
}

?>