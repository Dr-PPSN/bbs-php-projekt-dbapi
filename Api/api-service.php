<?php

require_once 'getData.php';
require_once 'helper.php';


function searchStopPlace(string $searchString): array|string {
  $data = getData("https://apis.deutschebahn.com/db-api-marketplace/apis/ris-stations/v1/stop-places/by-name/" . $searchString, 'ris+json');
  if (false === $data || $data === '') {
    return false;
  } else {
    return $data;
  }
}

function getStationData(int $stationID): array|string {
  $data = getData("https://apis.deutschebahn.com/db-api-marketplace/apis/station-data/v2/stations/" . $stationID);
  if (false === $data || $data === '') {
    return false;
  } else {
    return $data;
  }
}

function getStationPictureURL(int $stationID): array|string {
  $data = getData("https://apis.deutschebahn.com/db-api-marketplace/apis/api.railway-stations.org/photoStationById/de/" . $stationID);
  if (false === $data || $data === '') {
    return false;
  } else {
    return $data;
  }
}


function getFahrplan(int $evaNr, string $date, string $hour): array|string {
  $data = getData("https://apis.deutschebahn.com/db-api-marketplace/apis/timetables/v1/plan/" . $evaNr . "/" . $date . "/" . $hour, 'xml');
  if (false === $data || $data === '') {
    return false;
  } else {
    return $data;
  }
}

printPretty(searchStopPlace("Hamburg"));
echo "<br><br>";  // linebreak go br
printPretty(getStationData(3881));
echo "<br><br>";
printPretty(getStationPictureURL(3881));
echo "<br><br>";
printPretty(getFahrplan(8010224, 230419, 20));

?>