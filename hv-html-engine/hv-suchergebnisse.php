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

  protected function init(): void
  {
    $this->items = searchStopPlace($this->searchInput)["stopPlaces"];
    printPretty($this->items);
  }

  public function getList(): string
  {
    $list = "<ul" . $this->getMainTagAttributes() . ">";
    $list .= $this->getItems();
    $list .= "</ul>";
    return $list;
  }

  private function getItems(): string
  {
    $items = "";
    foreach ($this->items as $item) {
      $name = $item["names"]["DE"]["nameLong"];
      $evaNumber = $item["evaNumber"];
      if (isset($item["stationID"])) {
        $stationID = $item["stationID"];
      }
      $listObject = "<div class='suchergebnisItem'>";
      if (isset($stationID)) {
        $icon = getIcon('bahnhof.png', 'Bahnhof');
        $link = "station-details.php?stationID=" . $stationID;
      } else {
        $icon = getIcon('bench.png', 'Haltestelle');
        $link = "haltestelle-details.php?evaNumber=" . $evaNumber;
      }
      $listObject .= $icon;
      $listObject .= "<a href='" . $link . "'>" . $name . "</a>";
      $listObject .= "</div>";
      $items .= "<li>" . $listObject . "</li>";
    }
    return $items;
  }
}


?>