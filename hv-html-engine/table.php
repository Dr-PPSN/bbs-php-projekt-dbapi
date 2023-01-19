<?php

class Table{
    private $array2D;
    private $useBootstrap;
    private $tableClass;
    private $tableId;
    private $tableIdIncrement;
    private $tableStyle;
    private $sortByCol;
    private $sortOrder;

    public function __construct($array2D, $useBootstrap, $tableClass, $tableId, $tableIdIncrement, $tableStyle, $sortByCol, $sortOrder){
        $this->array2D = $array2D;
        $this->useBootstrap = $useBootstrap;
        $this->tableClass = $tableClass;
        $this->tableId = $tableId;
        $this->tableStyle = $tableStyle;
        $this->sortByCol = $sortByCol;
        $this->sortOrder = $sortOrder;
    }
    public function getTable(){
        $table = "";
        if($this->useBootstrap){
            $table .= '<table id="' . $this->tableId . '" class="table table-striped table-hover table-bordered table-sm" style="' . $this->tableStyle . '">';
        }else{
            $table .= '<table style="' . $this->tableStyle . '">';
        }
        $table .= "<thead>";
        $table .= "<tr>";
        foreach($this->array2D[0] as $key => $value){
            $table .= "<th>" . $key . "</th>";
        }
        $table .= "</tr>";
        $table .= "</thead>";
        $table .= "<tbody>";
        foreach($this->array2D as $row){
            $table .= "<tr>";
            foreach($row as $value){
                $table .= "<td>" . $value . "</td>";
            }
            $table .= "</tr>";
        }
        $table .= "</tbody>";
        $table .= "</table>";
        return $table;
    }
}

?>