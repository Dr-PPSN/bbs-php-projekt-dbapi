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

      $listObject = "<div class='suchergebnisItem'>";
      if (isset($item["stationID"])) {
        $stationID = $item["stationID"];
        $icon = getIcon('bahnhof.png', 'Bahnhof');
        $link = "station-details.php?stationID=" . $stationID;
      } else {
        $evaNumber = $item["evaNumber"];
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