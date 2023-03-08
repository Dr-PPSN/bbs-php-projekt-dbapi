<?php
require_once("hv-html.php");

class HV_Img extends HV_HTML
{
    public function __construct($class, $id, $style, $src)
    {
        parent::__construct("", "", $class, $id, $style, $src, "", "");
    }
    public function getImg()
    {
        $img = "<img";
        if($this->class != ""){
            $img .= " class='$this->class'";
        }
        if($this->id != ""){
            $img .= " id='$this->id'";
        }
        if($this->style != ""){
            $img .= " style='$this->style'";
        }
        if($this->href != ""){
            $img .= " src='$this->href'";
        }
        $img .= ">";
        return $img;
    }
}