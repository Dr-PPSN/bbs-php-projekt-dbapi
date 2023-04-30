<?php

require_once("hv-html.php");
require_once '../api/helper.php';
require_once '../src/helper.php';

class HV_Fahrplan extends HV_HTML
{
  protected $stationName = "";
  protected $fahrplan = array();
  protected $fahrplanAenderungen;

  public function __construct($fahrplanData, $fahrplanAenderungen, $class, $id, $style)
  {
    $this->stationName = $fahrplanData["@attributes"]["station"];
    $this->fahrplan = $fahrplanData;
    $this->fahrplanAenderungen = $fahrplanAenderungen;
    parent::__construct("", "", $class, $id, $style, "", "", "");
  }
  public function getFahrplan()
  {
    $fahrplan = "<div" . $this->getMainTagAttributes() . ">";
    $fahrplan .= "<h1>Fahrplan</h1>";
    $fahrplan .= $this->_getFahrplan();
    $fahrplan .= "</div>";
    return $fahrplan;
  }
  
  protected function _getFahrplan(): string {
    $result = "<div>";
    foreach ($this->fahrplan["s"] as $zug) {
      $result .= $this->getZugDaten($zug);
    }
    $result .= "</div>";
    return $result;
  }

  protected function getZugDaten($zug): string {
    $zugBezeichnung = $zug["tl"]["@attributes"]["c"] . " " . $zug["tl"]["@attributes"]["n"];
    
    if (isset($zug["ar"])) {
      $ankunft = $zug["ar"]["@attributes"];
    } else {
      $ankunft = null;
    }

    if (isset($zug["dp"])) {
      $abfahrt = $zug["dp"]["@attributes"];
    } else {
      $abfahrt = null;
    }
    // printPretty($zug);

    return "";
  }

}


?>