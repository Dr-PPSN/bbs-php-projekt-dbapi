<?php

require_once("hv-html.php");

class HV_Suchergebnisse extends HV_HTML
{
  protected $items = array();

  public function __construct($items, $class, $id, $style)
  {
    $this->items = $items;
    parent::__construct("", "", $class, $id, $style, "", "", "");
  }
  public function getList()
  {
    $list = "<div";
    if ($this->class != "") {
      $list .= " class='" . $this->class . "'";
    }
    if ($this->id != "") {
      $list .= " id='" . $this->id . "'";
    }
    if ($this->style != "") {
      $list .= " style='" . $this->style . "'";
    }
    $list .= ">" . $this->getItems() . "</div>";
    return $list;
  }

  private function getItems(): string
  {
    $items = "";
    foreach ($this->items as $item) {
      echo $item;
      // $items .= "<div>" . $item . "</div>";
    }
    return $items;
  }
}


?>