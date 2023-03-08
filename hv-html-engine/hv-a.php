<?php
require_once("hv-html.php");

class HV_A extends HV_HTML
{
    public function __construct($text, $class, $id, $style, $href)
    {
        parent::__construct($text, "", $class, $id, $style, $href, "", "");
    }
    public function getA()
    {
        $a = "<a";
        if($this->class != ""){
            $a .= " class='" . $this->class . "'";
        }
        if($this->id != ""){
            $a .= " id='" . $this->id . "'";
        }
        if($this->style != ""){
            $a .= " style='" . $this->style . "'";
        }
        if($this->href != ""){
            $a .= " href='" . $this->href . "'";
        }
        $a .= ">" . $this->text . "</a>";
        
        return $a;
    }
}
?>