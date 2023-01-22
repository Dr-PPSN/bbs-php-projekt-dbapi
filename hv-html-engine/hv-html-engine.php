<?php
require_once("hv-table.php");
require_once("hv-a.php");

class HV_HTML_Engine{
    public function __construct(){
        echo "HV-HTML-Engine Start<br>";
    }
    public function getTable($array2D, $class, $id, $style, $orderBy, $orderDirection){
        $table = new HV_Table($array2D, $class, $id, $style, $orderBy, $orderDirection);
        return $table->getTable();
    }
    public function getA($text, $class, $id, $style, $href){
        $a = new HV_A($text, $class, $id, $style, $href);
        return $a->getA();
    }
}

?>