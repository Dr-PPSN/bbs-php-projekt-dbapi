<?php

require_once("hv-html.php");
require_once '../api/helper.php';
require_once '../src/helper.php';

class HV_Fahrplan extends HV_HTML
{
  protected int | null $evaNumber = null;
  protected array $dateTime = array();
  protected bool $istAktuelleZeit = false;
  protected $fahrplan = array();
  protected $stationName = "";
  protected $fahrplanAenderungen = array();

  public function __construct(int $evaNumber, array | null $dateTime, $class, $id, $style)
  {
    $this->evaNumber = $evaNumber;
    if ($dateTime == null) {
      $this->dateTime = getAktuellesDatumUndStunde();
      $this->istAktuelleZeit = true;
    } else {
      $this->dateTime = $dateTime;
    }
    $this->init();
    parent::__construct("", "", $class, $id, $style, "", "", "");
  }

  protected function init() {
    [$datum, $stunde] = $this->dateTime;
    $this->fahrplan = getFahrplan($this->evaNumber, $datum, $stunde);
    $this->stationName = $this->fahrplan["@attributes"]["station"];
    $this->fahrplanAenderungen = getFahrplanAenderungen($this->evaNumber);
  }

  public function getFahrplan()
  {
    $fahrplan = "<div" . $this->getMainTagAttributes() . ">";

    if ($this->istAktuelleZeit) {
      $fahrplan .= "<h1>Aktueller Fahrplan</h1>";
    } else {
      $fahrplan .= "<h1>Fahrplan</h1>";
    }
    $fahrplan .= $this->_getFahrplan();
    $fahrplan .= "</div>";
    return $fahrplan;
  }
  
  protected function _getFahrplan(): string {
    $result = "<div" . $this->getMainTagAttributes() . ">";
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