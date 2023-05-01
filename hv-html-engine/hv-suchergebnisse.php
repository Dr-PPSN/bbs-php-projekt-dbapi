<?php

require_once("hv-html.php");
require_once '../api/helper.php';

class HV_Suchergebnisse extends HV_HTML
{
  protected string $searchInput = "";
  protected array $items = array();

  public function __construct($searchInput, $class, $id, $style)
  {
    $this->searchInput = $searchInput;
    $this->init();
    parent::__construct("", "", $class, $id, $style, "", "", "");
  }

  protected function init()
  {
    $this->items = searchStopPlace($this->searchInput)["stopPlaces"];
  }

  public function getList()
  {
    $list = "<ul" . $this->getMainTagAttributes() . ">";
    $list .= $this->getItems();
    $list .= "</ul>";
    return $list;
  }

  private function getItems(): string
  {
    $listObjects = "";
    foreach ($this->items as $item) {
      $evaNumber = $item["evaNumber"];
      if (isset($item["stationID"])) {
        $stationID = $item["stationID"];
      }
      $name = $item["names"]["DE"]["nameLong"];
      $listObject = "<div class='suchergebnisItem'>";
      $listObject .= "<a href='station-details.php?stationID=" . $stationID . "&evaNumber=" . $evaNumber . "'>" . $name . "</a>";
      $listObject .= "</div>";
      $listObjects .= "<li>" . $listObject . "</li>";
    }
    return $listObjects;
  }
}


?>