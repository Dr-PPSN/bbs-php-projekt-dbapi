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
    $suchergebnisse = searchStopPlace($this->searchInput);
    if ($suchergebnisse !== false) {
      $this->items = $suchergebnisse["stopPlaces"];
    } else {
      $this->items = array();
    }
  }

  public function getList(): string
  {
    $items = $this->getItems();
    if ($items === "") {
      return "<div class='keineErgebnisse'>Keine Ergebnisse gefunden!</div>";
    } else {
      $list = "<ul" . $this->getMainTagAttributes() . ">";
      $list .= $items;
      $list .= "</ul>";
      return $list;
    }
  }

  private function getItems(): string
  {
    $items = "";
    foreach ($this->items as $item) {
      $name = $item["names"]["DE"]["nameLong"];

      if (isset($item["stationID"])) {
        $stationID = $item["stationID"];
        $icon = getIcon('bahnhof.png', 'Bahnhof');
        $link = "station-details.php?stationID=" . $stationID;
      } else {
        $evaNumber = $item["evaNumber"];
        $icon = getIcon('bench.png', 'Haltestelle');
        $link = "haltestelle-details.php?evaNumber=" . $evaNumber;
      }
      $listObject = "<a class='searchResultLink' href='" . $link . "'>";
      $listObject .= "<div class='suchergebnisItem mt-2 p-3'><center>";
      $listObject .= $icon. $name;
      $listObject .= "</center></div></a>";

      $items .= "<li>" . $listObject . "</li>";
    }
    return $items;
  }
}
?>