<?php

require_once 'Autoloader.php';
require_once 'config.php';

function getStationData(int $stationID): array|string {
  $cw = new Curl\CurlWrapper("https://apis.deutschebahn.com/db-api-marketplace/apis/station-data/v2/stations/" . $stationID);
  $cw->setHeaders(
      array(
          'Accept: application/json',
          'DB-Client-Id: ' . CLIENT_ID,
          'DB-Api-Key: ' . API_KEY
      ));
  $response = $cw->request(new Curl\Requests\GetRequest(array()))->decode();
  $cw->dispose();

  return $response;
}


function getStationPictureURL(int $stationID): array|string {
  $cw = new Curl\CurlWrapper("https://apis.deutschebahn.com/db-api-marketplace/apis/api.railway-stations.org/photoStationById/de/" . $stationID);
  $cw->setHeaders(
      array(
          'Accept: application/json',
          'DB-Client-Id: ' . CLIENT_ID,
          'DB-Api-Key: ' . API_KEY
      ));
  $response = $cw->request(new Curl\Requests\GetRequest(array()))->decode();
  $cw->dispose();
  
  return $response;
}


function getFahrplan(int $evaNr, string $date, string $hour): array|string {
  $cw = new Curl\CurlWrapper("https://apis.deutschebahn.com/db-api-marketplace/apis/timetables/v1/plan/" . $evaNr . "/" . $date . "/" . $hour);
  $cw->setHeaders(
      array(
          'Accept: application/xml',
          'DB-Client-Id: ' . CLIENT_ID,
          'DB-Api-Key: ' . API_KEY
      ));
  $response = $cw->request(new Curl\Requests\GetRequest(array()));
  $cw->dispose();

  // 404 wenn zu neu; 410 wenn zu alt
  if (200 !== $response->getStatusCode()) {
    return "Error: " . $response->getStatusCode();
  } else {
    return $response->decode();
  }
}


var_dump(getStationData(3881));
echo "<br><br>";
var_dump(getStationPictureURL(3881));
echo "<br><br>";
var_dump(getFahrplan(8010224, 230308, 14));

?>