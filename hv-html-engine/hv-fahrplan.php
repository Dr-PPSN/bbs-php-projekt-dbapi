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
    $this->fahrplanAenderungen = getFahrplanAenderungen($this->evaNumber);
    $this->stationName = $this->fahrplan["@attributes"]["station"];
  }

  public function getFahrplan()
  {
    $fahrplan = "<div" . $this->getMainTagAttributes() . ">";

    [$datum, $stunde] = $this->dateTime;
    if ($this->istAktuelleZeit) {
      $fahrplan .= "<h1>Aktueller Fahrplan heute " . $stunde . "</h1>";
    } else {
      $fahrplan .= "<h1>Fahrplan</h1>";
    }
    $fahrplan .= $this->_getFahrplan();
    $fahrplan .= "</div>";
    return $fahrplan;
  }
  
  protected function _getFahrplan(): string {
    $result = "<ul class='fahrplan'>";
    foreach ($this->fahrplan["s"] as $zug) {
      $result .= $this->getZugDaten($zug);
    }
    $result .= "</ul>";
    return $result;
  }

  protected function getZugDaten($zug): string {
    $zugBezeichnung = $zug["tl"]["@attributes"]["c"] . " " . $zug["tl"]["@attributes"]["n"];
    
    if (isset($zug["ar"])) {
      $ankunft = $zug["ar"]["@attributes"];
      $ankunftZeit = $ankunft["pt"];
      $ankunftGleis = $ankunft["pp"];
      $ankunftRoute = $ankunft["ppth"];
    } else {
      $ankunft = null;
      $ankunftZeit = "";
    }

    if (isset($zug["dp"])) {
      $abfahrt = $zug["dp"]["@attributes"];
      $abfahrtZeit = $abfahrt["pt"];
      $abfahrtGleis = $abfahrt["pp"];
      $abfahrtRoute = $abfahrt["ppth"];
    } else {
      $abfahrt = null;
      $abfahrtZeit = "";
    }
    
    $result = "<li class='fahrplanItem'>";
    $result .= "
      <div class='d-flex justify-content-between'>
        <div class='gleis'>Gleis " . $ankunftGleis . "</div>
        <span class='zugBezeichnung'>
          <b>" . $zugBezeichnung . "</b>
        </span>
        <div class='gleis'>Gleis " . $abfahrtGleis . "</div>
      </div>";
    
    $result .= "<div class='zugZeiten d-flex justify-content-between'>";
    $result .= "<span class='zeit'>" . formatFahrplanZeit($ankunftZeit) . "</span>";
    $result .= "<span class='abfahrtZeit'>" . formatFahrplanZeit($abfahrtZeit) . "</span>";
    $result .= "</div>";

    $result .= "</li>";
    return $result;
  }

}


?>