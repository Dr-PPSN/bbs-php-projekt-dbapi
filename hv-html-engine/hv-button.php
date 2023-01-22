<?php
require_once("hv-html.php");

class HV_Button extends HV_HTML
{
    public function __construct($text, $class, $id, $style)
    {
        parent::__construct($text, "", $class, $id, $style, "", "", "");
    }
    public function getP()
    {
        $p = "<p";
        if($this->class != ""){
            $p .= " class='$this->class'";
        }
        if($this->id != ""){
            $p .= " id='$this->id'";
        }
        if($this->style != ""){
            $p .= " style='$this->style'";
        }
        $p .= ">$this->text</p>";
        return $p;
    }
}