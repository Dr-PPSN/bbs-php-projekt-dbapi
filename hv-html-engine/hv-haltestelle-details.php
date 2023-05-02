<?php

require_once("hv-html.php");
require_once '../api/helper.php';
require_once '../src/helper.php';
require_once '../api/api-service.php';

class HV_HaltestelleDetails extends HV_HTML
{
  protected int $evaNumber = 0;
  protected $stopPlaceDetails = array();
  protected $facilityData = array();
  protected $parkplaetze = array();

  public function __construct(int $evaNumber, $class, $id, $style)
  {
    $this->evaNumber = $evaNumber;
    $this->init();
    parent::__construct("", "", $class, $id, $style, "", "", "");
  }

  protected function init() {
    $this->stopPlaceDetails = getStopPlacesByEvaNumber($this->evaNumber)["stopPlaces"][0];
    // printPretty($this->stopPlaceDetails);
    // $this->facilityData = getFacilityStatus($this->stationID);
    // $this->parkplaetze = $this->holeParkmoeglichkeitenMitCapacity();
  }

  protected function holeParkmoeglichkeitenMitCapacity(): array {
    $result = array();
    $parkMoeglichkeiten = getParkmoeglichkeiten($this->evaNumber)["_embedded"];

    foreach ($parkMoeglichkeiten as $parkMoeglichkeit) {
      $name = getParkingFacilityName($parkMoeglichkeit["name"]);
      $facilityID = $parkMoeglichkeit["id"];
      $capacityObj = getParkingCapacities($facilityID)["_embedded"];
      [$isAvailable, $capacity, $availableCapacity] = getParkingFacilityCapacity($capacityObj);

      $result []= array(
        "isAvailable" => $isAvailable,
        "name" => $name,
        "capacity" => $capacity,
        "availableCapacity" => $availableCapacity);
    }
    return $result;
  }

  public function getEvaNumber(): int {
    return $this->evaNumber;
  }

  public function getDetails()
  {
    $details = "<div" . $this->getMainTagAttributes() . ">";
    // $details .= "<h1>" . $this->stationData["name"] . "</h1>";
    // $details .= $this->_getDetails();
    $details .= "</div>";
    return $details;
  }
  
  protected function _getDetails(): string {
    $result = "<div>";
    $result .= $this->getAdress();
    $result .= $this->getOeffnungszeiten();
    $result .= $this->getHasElevator();
    $result .= $this->getHasParking();
    $result .= $this->getWeitereInformationen();
    $result .= "</div>";
    return $result;
  }

  protected function getAdress(): string {
    $result = "<div class='detail-section'>";
    $result .= "<span class='detail-sub-header'>Adresse</span>";
    if (isset($this->stationData["mailingAddress"])) {
      $mailingAdress = $this->stationData["mailingAddress"];
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
    $result = "<div class='detail-section'>";
    $result .= "<span class='detail-sub-header'>Öffnungszeiten</span>";

    if (isset($this->stationData["DBinformation"])) {
      $oeffnungszeiten = $this->stationData["DBinformation"]["availability"];
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
  
  protected function getHasElevator() {
    $result = "";
    $hasElevator = $this->_getHasElevator();
    if ($hasElevator !== "") {
      $result = "<div class='detail-section'>";
      $result .= "<span class='detail-sub-header'>Fahrstuhl</span>";
      $result .= $hasElevator;
      $result .= "</div>";
    }
    return $result;
  }

  private function _getHasElevator() {
    $result = "";
    foreach ($this->facilityData["facilities"] as $facility) {
      if ((isset($facility["type"]) && $facility["type"] == "ELEVATOR") && (isset($facility["state"]) && $facility["state"] == "ACTIVE")) {
        $result .= "<div class='has-elevator'>";
        $result .= getIcon("aufzug.png");
        $result .= "<span>" . $facility["description"] . "</span>";
        $result .= "</div>";
      }
    }
    return $result;
  }

  protected function getHasParking(): string {
    $result = "";
    $hasParking = $this->_getHasParking();
    if ($hasParking !== "") {
      $result = "<div class='detail-section'>";
      $result .= "<span class='detail-sub-header'>Parkmöglichkeiten</span>";
      $result .= $hasParking;
      $result .= "</div>";
    }
    return $result;
  }

  protected function _getHasParking() {
    $result = "";
    foreach ($this->parkplaetze as $parkplatz) {
      if ($parkplatz["isAvailable"]) {
        $result .= "<div class='has-parking'>";
        $result .= getIcon("parkplatz.png");
        $result .= "<span>" . $parkplatz["name"] . "</span>";
        $result .= "<span class='parking-capacity'>" . $parkplatz["availableCapacity"] . " / " . $parkplatz["capacity"] . "</span>";
        $result .= "</div>";
      }
    }
    return $result;
  }

  protected function getWeitereInformationen(): string {
    $weitereInformationen = $this->_getWeitereInformationen();
    if (count($weitereInformationen) > 0) {
      $result = "<div class='detail-section'>";
      $result .= "<span class='detail-sub-header'>Weitere Informationen</span>";
      foreach ($weitereInformationen as $weitereInformation) {
        $result .= $weitereInformation;
      }  
      $result .= "</div>";
    }
    return $result;
  }

  private function _getWeitereInformationen(): array {
    $result = [];
    $result []= $this->getHasWifi();
    return $result;
  }
  
  protected function getHasWifi(): string {
    if (isset($this->stationData["hasWiFi"])) {
      $result = "<div class='has-wifi'>";
      $result .= getIcon("w-lan.png");
      $result .= "<span>hat WLAN</span>";
      $result .= "</div>";
      return $result;
    } else {
      return "";
    }
  }

  public function getCoordinates(): array {
    $longitude = $this->stopPlaceDetails["position"]["longitude"];
    $latitude = $this->stopPlaceDetails["position"]["latitude"];
    $coordinates = array("latitude" => $latitude, "longitude" => $longitude);
    return $coordinates;
  }
}


?>