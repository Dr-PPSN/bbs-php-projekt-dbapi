<?php

class HV_HTML
{
    protected $text = "";
    protected $array2D = "";
    protected $class = "";
    protected $id = "";
    protected $style = "";
    protected $href = "";
    protected $orderBy = "";
    protected $orderDirection = "";

    public function __construct($text, $array2D, $class, $id, $style, $href, $orderBy, $orderDirection)
    {
        $this->text = $text;
        $this->array2D = $array2D;
        $this->class = $class;
        $this->id = $id;
        $this->style = $style;
        $this->href = $href;
        $this->orderBy = $orderBy;
        $this->orderDirection = $orderDirection;
    }
}

?>