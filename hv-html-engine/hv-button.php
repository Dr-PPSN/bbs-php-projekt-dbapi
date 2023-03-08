<?php
require_once("hv-html.php");

class HV_Button extends HV_HTML
{
    public function __construct($text, $class, $id, $style)
    {
        parent::__construct($text, "", $class, $id, $style, "", "", "");
    }
    public function getButton()
    {
        $button = "<button";
        if ($this->class != "") {
            $button .= " class='" . $this->class . "'";
        }
        if ($this->id != "") {
            $button .= " id='" . $this->id . "'";
        }
        if ($this->style != "") {
            $button .= " style='" . $this->style . "'";
        }
        $button .= ">" . $this->text . "</button>";
        return $button;
    }
}