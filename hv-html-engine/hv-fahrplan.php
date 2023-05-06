<?php

require_once("hv-html.php");
require_once '../api/helper.php';
require_once '../src/helper.php';

class HV_Fahrplan extends HV_HTML
{
  protected bool $keineDatenGefunden = false;
  protected int | null $evaNumber = null;
  protected array $dateTime = array();
  protected bool $istAktuelleZeit = false;
  protected $fahrplan = array();
  protected $stationName = "";
  // protected $fahrplanAenderungen = array();

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
    $_fahrplan = getFahrplan($this->evaNumber, $datum, $stunde);

    if ($_fahrplan === false || count($_fahrplan) == 0) {
      $this->fahrplan = array();
      $this->keineDatenGefunden = true;
    } else {
      $this->fahrplan = $_fahrplan["s"];
      $this->sortiereFahrplanNachAnkunft();
      // $this->fahrplanAenderungen = getFahrplanAenderungen($this->evaNumber);
    }
  }

  protected function sortiereFahrplanNachAnkunft() {
    $fahrplan = $this->fahrplan;
    usort($fahrplan, function($a, $b) {
      if (isset($a["ar"])) {
        $aZeit = $a["ar"]["@attributes"]["pt"];
      } else if (isset($a["dp"])) {
        $aZeit = $a["dp"]["@attributes"]["pt"];
      } else {
        $aZeit = INF;
      }

      if (isset($b["ar"])) {
        $bZeit = $b["ar"]["@attributes"]["pt"];
      } else if (isset($b["dp"])) {
        $bZeit = $b["dp"]["@attributes"]["pt"];
      } else {
        $bZeit = INF;
      }
      return $aZeit <=> $bZeit;
    });
    $this->fahrplan = $fahrplan;
  }

  public function getFahrplanHeader(): string {
    [$datum, $stunde] = $this->dateTime;
    if ($this->istAktuelleZeit) {
      return "<h1>Aktueller Fahrplan " . formatTimeSlice($stunde) . "</h1>";
    }
    return "<h1>Fahrplan</h1>";
  }

  public function getFahrplan()
  {
    $fahrplan = "<div" . $this->getMainTagAttributes() . ">";

    
    $fahrplan .= "
      <div class='row mt-3'>
        <div class='col-2 fahrplan-header' style='padding-left: 50px'>Ankunft</div>
        <div class='col-3 fahrplan-header'><center>aus</center></div>
        <div class='col-2 fahrplan-header'><center>Zug</center></div>
        <div class='col-3 fahrplan-header'><center>nach</center></div>
        <div class='col-2 fahrplan-header abfahrt' style='padding-right: 50px'>Abfahrt</div>
      </div>
    ";
    $fahrplan .= $this->_getFahrplan();
    $fahrplan .= "</div>";
    return $fahrplan;
  }
  
  protected function _getFahrplan(): string {
    $result = "<ul class='fahrplan mb-5'>";
    if ($this->fahrplanVorhanden()) {
      foreach ($this->fahrplan as $zug) {
        $result .= $this->getZugDaten($zug);
      }
    } else {
      $result .= "
        <div class='keinFahrplanVorhanden mt-5'>
          <center>Hier ist nichts los.<center>
        </div>";
    }
    $result .= "</ul>";
    return $result;
  }

  protected function fahrplanVorhanden(): bool {
    if (count($this->fahrplan) > 0) {
      foreach ($this->fahrplan as $zug) {
        if (isset($zug["tl"])) {
          return true;
        }
      }
    }
    return false;
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
      <div class='row' style='margin-top: -4px;''>
        <div class='col-2 zugZeiten'>" . formatFahrplanZeit($ankunftZeit) . "</div>";
    
    if (isset($ankunftRoute)) {
      $result .= "
        <span class='col-3 von-nach'>" . getAnkunftAus($ankunftRoute) . "</span>";
    } else {
      $result .= "
        <span class='col-3 von-nach'></span>";
    }

    $result .= "
        <span class='col-2 zugBezeichnung'>
          <b>" . $zugBezeichnung . "</b>
        </span>";

    if (isset($abfahrtRoute)) {
      $result .= "
        <span class='col-3 von-nach'>" . getAbfahrtNach($abfahrtRoute) . "</span>";
    } else {
      $result .= "
        <span class='col-3 von-nach'></span>";
    }
    $result .= "
        <div class='col-2 zugZeiten abfahrt'>" . formatFahrplanZeit($abfahrtZeit) . "</div>
      </div>";
    
    $result .= "<div class='row gleis-row'>";
    if (isset($ankunftRoute)) {
      $result .= "
        <div class='col-6'>
          <div class='gleis'>Gleis " . $ankunftGleis . "
          </div>
        </div>";
    } else {
      $result .= "
        <div class='col-6'></div>";
    }
    if (isset($abfahrtRoute)) {
      $result .= "
        <div class='col-6 abfahrt'>
          <div class='gleis'>Gleis " . $abfahrtGleis . "
          </div>
        </div>";
    } else {
      $result .= "
        <div class='col-6'></div>";
    }
    $result .= "</div>";

    $result .= "</li>";
    return $result;
  }

}


?>