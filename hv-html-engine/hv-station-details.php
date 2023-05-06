<?php

require_once("hv-html.php");
require_once '../api/helper.php';
require_once '../src/helper.php';
require_once '../api/api-service.php';

class HV_StationsDetails extends HV_HTML
{
  protected bool $keineDatenGefunden = false;
  protected int | null $stationID = null;
  protected int $evaNumber = 0;
  protected string $stationName = "";
  protected $stationData = array();
  protected $facilityData = array();
  protected $parkplaetze = array();

  public function __construct(int $stationID, $class, $id, $style)
  {
    $this->stationID = $stationID;
    $this->init();
    parent::__construct("", "", $class, $id, $style, "", "", "");
  }

  public function getKeineDatenGefunden(): bool {
    return $this->keineDatenGefunden;
  }

  public function getStationName(): string {
    return $this->stationName;
  }

  public function getParkplaetzeCoordinates(): array {
    $result = array();
    foreach ($this->parkplaetze as $parkplatz) {
      $result []= $parkplatz["coordinates"];
    }
    return $result;
  }

  protected function init() {
    $this->stationData = getStationData($this->stationID);
    if ($this->stationData !== false && count($this->stationData["result"]) > 0) {
      $this->stationData = $this->stationData["result"][0];
      $this->stationName = $this->stationData["name"];
      $this->evaNumber = getMainEvaNumber($this->stationData["evaNumbers"]);
      $this->facilityData = getFacilityStatus($this->stationID);
      $this->parkplaetze = $this->holeParkmoeglichkeitenMitCapacity();
    } else {
      $this->keineDatenGefunden = true;
    }
  }

  protected function holeParkmoeglichkeitenMitCapacity(): array {
    $result = array();
    $parkMoeglichkeiten = getParkmoeglichkeiten($this->evaNumber);
    
    if ($parkMoeglichkeiten !== false && count($parkMoeglichkeiten) > 0) {
      $parkMoeglichkeiten = $parkMoeglichkeiten["_embedded"];

      foreach ($parkMoeglichkeiten as $parkMoeglichkeit) {
        $name = getParkingFacilityName($parkMoeglichkeit["name"]);
        $facilityID = $parkMoeglichkeit["id"];

        $capacityObj = getParkingCapacities($facilityID);
        if ($capacityObj !== false && isset($capacityObj["_embedded"])) {
          $capacityObj = $capacityObj["_embedded"];
          [$isAvailable, $capacity, $availableCapacity, $capacityColor] = getParkingFacilityCapacity($capacityObj);
          $coordinates = array(
            "latitude" => $parkMoeglichkeit["address"]["location"]["latitude"],
            "longitude" => $parkMoeglichkeit["address"]["location"]["longitude"]
          );
    
          $result []= array(
            "isAvailable" => $isAvailable,
            "name" => $name,
            "capacity" => $capacity,
            "availableCapacity" => $availableCapacity,
            "capacityColor" => $capacityColor,
            "coordinates" => $coordinates
          );
        }
      }
    }
    return $result;
  }

  public function getEvaNumber(): int {
    return $this->evaNumber;
  }

  public function getDetails()
  {
    $details = "<div" . $this->getMainTagAttributes() . ">";
    $details .= $this->_getDetails();
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
      if ((isset($facility["type"]) && isset($facility["description"]) && $facility["type"] == "ELEVATOR") && (isset($facility["state"]) && $facility["state"] == "ACTIVE")) {
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
        $result .= "
          <div class='has-parking'>" .
            getIcon("parkplatz.png") . "<span><a href='https://www.google.de/maps/@" . $parkplatz["coordinates"]["latitude"] . "," . $parkplatz["coordinates"]["longitude"] . ",21z' target='_blank'>" . $parkplatz["name"] . "</a></span>
            <span class='parking-capacity " . $parkplatz["capacityColor"] . "'>" . $parkplatz["availableCapacity"] . " / " . $parkplatz["capacity"] . "</span>
          </div>";
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
    $result []= $this->getHasLockers();
    // TODO: hier noch was ausdenken
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

  protected function getHasLockers(): string {
    if (isset($this->stationData["hasLockerSystem"])) {
      $result = "<div class='has-lockerSystem'>";
      $result .= getIcon("locker.png");
      $result .= "<span>hat Schließfächer</span>";
      $result .= "</div>";
      return $result;
    } else {
      return "";
    }
  }

  public function getCoordinates(): array {
    $evaNumbers = $this->stationData["evaNumbers"];
    foreach ($evaNumbers as $evaNumber) {
      if ($evaNumber["isMain"] == true) {
        $longitude = $evaNumber["geographicCoordinates"]["coordinates"][0];
        $latitude = $evaNumber["geographicCoordinates"]["coordinates"][1];
        $coordinates = array("latitude" => $latitude, "longitude" => $longitude);
        return $coordinates;
      }
    }
    return array();
  }
}


?>