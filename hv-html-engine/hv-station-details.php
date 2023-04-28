<?php

require_once("hv-html.php");
require_once '../api/helper.php';
require_once '../src/helper.php';

class HV_StationsDetails extends HV_HTML
{
  protected $staionData = array();

  public function __construct($staionData, $class, $id, $style)
  {
    $this->staionData = $staionData["result"][0];
    parent::__construct("", "", $class, $id, $style, "", "", "");
  }
  public function getDetails()
  {
    // printPretty($this->staionData);
    $details = "<div" . $this->getMainTagAttributes() . ">";
    $details .= "<h1>" . $this->staionData["name"] . "</h1>";
    $details .= $this->_getDetails();
    $details .= "</div>";
    return $details;
  }
  
  protected function _getDetails(): string {
    $result = "<div>";
    $result .= $this->getAdress();
    $result .= $this->getOeffnungszeiten();
    $result .= $this->getWeitereInformationen();
    $result .= "</div>";
    return $result;
  }

  protected function getAdress(): string {
    $result = "<div class='adress'>";
    $result .= "<span class='detail-sub-header'>Adresse</span>";
    if (isset($this->staionData["mailingAddress"])) {
      $mailingAdress = $this->staionData["mailingAddress"];
      $result .= "<span>" . $mailingAdress["street"] . "</span>";
      $result .= "<br>";
      $result .= "<span>" . $mailingAdress["city"] . " " . $mailingAdress["zipcode"] . "</span>";
      $result .= "</div>";
    } else {
      $result .= "<span>Keine Adresse vorhanden</span>";
      $result .= "</div>";
    }
    return $result;
  }

  protected function getOeffnungszeiten() {
    $result = "<div class='oeffnungszeiten'>";
    $result .= "<span class='detail-sub-header'>Öffnungszeiten</span>";

    if (isset($this->staionData["DBinformation"])) {
      $oeffnungszeiten = $this->staionData["DBinformation"]["availability"];
      $result .= "<table>";
      foreach ($oeffnungszeiten as $day => $times) {
        $tag = dayToDeutsch($day);
        $fromTime = $times['fromTime'];
        $toTime = $times['toTime'];
        $result .= "<tr><td class='oeffnungszeiten-tage'>" . $tag . "</td><td> &nbsp; </td><td>" . $fromTime . " - " . $toTime . "</td></tr>";
      }
      $result .= "</table>";
    } else {
      $result .= "<span style='display: block'>Keine Öffnungszeiten vorhanden</span>";
    }
    $result .= "</div>";
    return $result;
  }

  protected function getWeitereInformationen(): string {
    $result = "<div class='weitere-informationen'>";
    $result .= "<span class='detail-sub-header'>Weitere Informationen</span>";
    $result .= $this->getHasWifi();
    $result .= $this->hasSteplessAccess();
    $result .= "</div>";
    return $result;
  }

  protected function hasSteplessAccess() {
    if (isset($this->staionData["hasSteplessAccess"])) {
      $result = "<div class='has-stepless-access'>";
      $result .= getIcon("rollstuhl.png");
      $result .= "<span>hat Fahrsuhl</span>";
      $result .= "</div>";
      return $result;
    } else {
      return "";
    }
  }
  
  protected function getHasWifi(): string {
    if (isset($this->staionData["hasWiFi"])) {
      $result = "<div class='has-wifi'>";
      $result .= getIcon("w-lan.png");
      $result .= "<span>hat WLAN</span>";
      $result .= "</div>";
      return $result;
    } else {
      return "";
    }
  }

  public function getCoordinates(): array | null {
    $evaNumbers = $this->staionData["evaNumbers"];
    foreach ($evaNumbers as $evaNumber) {
      if ($evaNumber["isMain"] == true) {
        $coordinate = $evaNumber["geographicCoordinates"]["coordinates"];
        return $coordinate;
      }
    }
    return null;
  }
}


?>