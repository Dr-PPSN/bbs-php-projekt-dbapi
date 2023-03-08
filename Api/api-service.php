<?php

require_once 'getData.php';

function getStationData(int $stationID): array|string {
  $data = getData("https://apis.deutschebahn.com/db-api-marketplace/apis/station-data/v2/stations/" . $stationID);
  if (false === $data) {
    return false;
  } else {
    // TODO: Pick relevant data from $data
    return $data;
  }
}


function getStationPictureURL(int $stationID): array|string {
  $data = getData("https://apis.deutschebahn.com/db-api-marketplace/apis/api.railway-stations.org/photoStationById/de/" . $stationID);
  if (false === $data) {
    return false;
  } else {
    // TODO: Pick relevant data from $data
    return $data;
  }
}


function getFahrplan(int $evaNr, string $date, string $hour): array|string {
  $data = getData("https://apis.deutschebahn.com/db-api-marketplace/apis/timetables/v1/plan/" . $evaNr . "/" . $date . "/" . $hour, 'xml');
  if (false === $data) {
    return false;
  } else {
    // TODO: Pick relevant data from $data
    return $data;
  }
}


var_dump(getStationData(3881));
echo "<br><br>";  // linebreak go br
var_dump(getStationPictureURL(3881));
echo "<br><br>";
var_dump(getFahrplan(8010224, 230308, 14));

?>