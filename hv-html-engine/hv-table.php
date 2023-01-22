<?php
require_once("hv-html.php");

class HV_Table extends HV_HTML{
    public $thClass = "";
    public $tdClass = "";
    public function __construct($array2D, $class, $id, $style, $orderBy, $orderDirection)
    {
        parent::__construct("", $array2D, $class, $id, $style, "", $orderBy, $orderDirection);
    }
    public function setThClass($class){
        $this->thClass = $class;
    }
    public function setTdClass($tdClass){
        $this->tdClass = $tdClass;
    }
    public function getTable()
    {
        $table = "<table";
        if($this->class != ""){
            $table .= " class='$this->class'";
        }
        if($this->id != ""){
            $table .= " id='$this->id'";
        }
        if($this->style != ""){
            $table .= " style='$this->style'";
        }
        $table .= ">";
        foreach($this->array2D as $key => $value){
            if($key == 0){
                $table .= "<tr>";
                foreach($value as $key2 => $value2){
                    $table .= "<th";
                    if($this->thClass != ""){
                        $table .= " class='$this->thClass'";
                    }
                    $table .= ">$key2</th>";
                }
                $table .= "</tr>";
            }
            $table .= "<tr>";
            foreach($value as $key2 => $value2){
                $table .= "<td class='$this->tdClass'>$value2</td>";
            }
            $table .= "</tr>";
        }
        $table .= "</table>";
        return $table;
    }
}
?>