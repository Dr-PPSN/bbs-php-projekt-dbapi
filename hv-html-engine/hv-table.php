<?php
require_once("hv-html.php");

class HV_Table extends HV_HTML{
    public function __construct($array2D, $class, $id, $style, $orderBy, $orderDirection)
    {
        parent::__construct("", $array2D, $class, $id, $style, "", $orderBy, $orderDirection);
    }
    public function getTable()
    {
        return "returned table";
    }
}
?>