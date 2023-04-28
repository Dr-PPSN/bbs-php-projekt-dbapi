<?php

class HV_HTML
{
    protected $text = "";
    protected $tableData = "";
    protected $class = "";
    protected $id = "";
    protected $style = "";
    protected $href = "";
    protected $orderBy = "";
    protected $orderDirection = "";

    public function __construct($text, $array2D, $class, $id, $style, $href, $orderBy, $orderDirection)
    {
        $this->text = $text;
        $this->tableData = $array2D;
        $this->class = $class;
        $this->id = $id;
        $this->style = $style;
        $this->href = $href;
        $this->orderBy = $orderBy;
        $this->orderDirection = $orderDirection;
    }

    protected function getMainTagAttributes()
    {
        $mainAttributes = "";
        if ($this->class != "") {
            $mainAttributes .= " class='" . $this->class . "'";
        }
        if ($this->id != "") {
            $mainAttributes .= " id='" . $this->id . "'";
        }
        if ($this->style != "") {
            $mainAttributes .= " style='" . $this->style . "'";
        }
        if ($this->href != "") {
            $mainAttributes .= " href='" . $this->href . "'";
        }
        return $mainAttributes;
    }
}

?>