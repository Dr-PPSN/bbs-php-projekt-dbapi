<?php

require_once("hv-html.php");

class HV_List extends HV_HTML
{
  protected $items = array();

  public function __construct($items, $class, $id, $style)
  {
    $this->items = $items;
    parent::__construct("", "", $class, $id, $style, "", "", "");
  }
  public function getList()
  {
    $button = "<ol";
    if ($this->class != "") {
      $button .= " class='" . $this->class . "'";
    }
    if ($this->id != "") {
      $button .= " id='" . $this->id . "'";
    }
    if ($this->style != "") {
      $button .= " style='" . $this->style . "'";
    }
    $button .= ">" . $this->text . "</ol>";
    return $button;
  }
}