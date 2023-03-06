<?php

require_once 'Autoloader.php';

function getStationData(int $stationID): array|string {
  $cw = new Curl\CurlWrapper("https://apis.deutschebahn.com/db-api-marketplace/apis/station-data/v2/stations/" . $stationID);
  $cw->setHeaders(
      array(
          'Accept: application/json',
          'DB-Client-Id: a2da2da1b33dca433b0eaf0e122dac7e',
          'DB-Api-Key: 7347b817504c2125ebc7a5713bd96158'
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
          'DB-Client-Id: a2da2da1b33dca433b0eaf0e122dac7e',
          'DB-Api-Key: 7347b817504c2125ebc7a5713bd96158'
      ));
  $response = $cw->request(new Curl\Requests\GetRequest(array()))->decode();
  $cw->dispose();
  
  return $response;
}


function getFahrplan(int $evaNr, string $date, string $hour): array|string {
  echo "https://apis.deutschebahn.com/db-api-marketplace/apis/timetables/v1/plan/" . $evaNr . "/" . $date . "/" . $hour;
  $cw = new Curl\CurlWrapper("https://apis.deutschebahn.com/db-api-marketplace/apis/timetables/v1/plan/" . $evaNr . "/" . $date . "/" . $hour);
  $cw->setHeaders(
      array(
          'Accept: application/json',
          'DB-Client-Id: a2da2da1b33dca433b0eaf0e122dac7e',
          'DB-Api-Key: 7347b817504c2125ebc7a5713bd96158'
      ));
  $response = $cw->request(new Curl\Requests\GetRequest(array()));
  $cw->dispose();
  // var_dump($response);
  if (200 !== $response->getStatusCode()) {
    return "Error: " . $response->getStatusCode();
  } else {
    return $response;
  }
}


var_dump(getStationData(3881));
echo "<br><br>";
var_dump(getStationPictureURL(3881));
echo "<br><br>";
var_dump(getFahrplan(8010224, 230306, 12));

?>