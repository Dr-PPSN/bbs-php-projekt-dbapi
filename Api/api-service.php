<?php

require_once 'getData.php';
require_once 'helper.php';


function searchStopPlace(string $searchString): array|string|bool {
  $data = getData("https://apis.deutschebahn.com/db-api-marketplace/apis/ris-stations/v1/stop-places/by-name/" . $searchString, 'ris+json');
  if (false === $data || $data === '') {
    return false;
  } else {
    return $data;
  }
}

function getStationData(int $stationID): array|string|bool {
  $data = getData("https://apis.deutschebahn.com/db-api-marketplace/apis/station-data/v2/stations/" . $stationID);
  if (false === $data || $data === '') {
    return false;
  } else {
    return $data;
  }
}

function getFacilityStatus(int $stationID): array|string|bool {
  $data = getData("https://apis.deutschebahn.com/db-api-marketplace/apis/fasta/v2/stations/" . $stationID);
  if (false === $data || $data === '') {
    return false;
  } else {
    return $data;
  }
}

function getStationPictureURL(int $stationID): array|string|bool {
  $data = getData("https://apis.deutschebahn.com/db-api-marketplace/apis/api.railway-stations.org/photoStationById/de/" . $stationID);
  if (false === $data || $data === '') {
    return false;
  } else {
    return $data;
  }
}


function getFahrplan(int $evaNr, string $date, string $hour): array|string|bool {
  $data = getData("https://apis.deutschebahn.com/db-api-marketplace/apis/timetables/v1/plan/" . $evaNr . "/" . $date . "/" . $hour, 'xml');
  if (false === $data || $data === '') {
    return false;
  } else {
    return $data;
  }
}

function getFahrplanAenderungen(int $evaNr): array|string|bool {
  $data = getData("https://apis.deutschebahn.com/db-api-marketplace/apis/timetables/v1/fchg/" . $evaNr, 'xml');
  if (false === $data || $data === '') {
    return false;
  } else {
    return $data;
  }
}

function getParkmoeglichkeiten(int $evaNr): array | string | bool {
  $data = getData("https://apis.deutschebahn.com/db-api-marketplace/apis/parking-information/db-bahnpark/v2/parking-facilities?stopPlaceId=" . $evaNr, 'json');
  if (false === $data || $data === '') {
    return false;
  } else {
    return $data;
  }
}

function getParkingCapacities(int $facilityID): array | string | bool {
  $data = getData("https://apis.deutschebahn.com/db-api-marketplace/apis/parking-information/db-bahnpark/v2/parking-facilities/" . $facilityID . "/capacities", 'json');
  if (false === $data || $data === '') {
    return false;
  } else {
    return $data;
  }
}

?>