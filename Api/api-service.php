<?php

require_once 'getData.php';

function getStationData(int $stationID): array|string {
  return getData("https://apis.deutschebahn.com/db-api-marketplace/apis/station-data/v2/stations/" . $stationID);
}


function getStationPictureURL(int $stationID): array|string {
  return getData("https://apis.deutschebahn.com/db-api-marketplace/apis/api.railway-stations.org/photoStationById/de/" . $stationID);
}


function getFahrplan(int $evaNr, string $date, string $hour): array|string {
  return getData("https://apis.deutschebahn.com/db-api-marketplace/apis/timetables/v1/plan/" . $evaNr . "/" . $date . "/" . $hour, 'xml');
}


var_dump(getStationData(3881));
echo "<br><br>";
var_dump(getStationPictureURL(3881));
echo "<br><br>";
var_dump(getFahrplan(8010224, 230308, 14));

?>