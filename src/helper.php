<?php

function phpVersionZuAlt(): bool
{
  if (version_compare(phpversion(), '8.1.0', '<')) {
    echo 'PHP Version is too old. Please update to 8.1.0 or higher.';
    return true;
  } else {
    return false;
  }
}

function routeZurIndex() {
  header('Location: ../index.php');
  exit();
}

function routeZurFehlerSeite() {
  header('Location: ./not-found.php');
  exit();
}

function bauePictureUrlZusammen($stationPictureURLObj): string {
  $photoBaseUrl = $stationPictureURLObj['photoBaseUrl'];
  $path = $stationPictureURLObj['stations'][0]['photos'][0]['path'];
  return $photoBaseUrl . $path;
}

function dayToDeutsch($day): string {
  switch ($day) {
    case 'monday':
      return 'Montag';
    case 'tuesday':
      return 'Dienstag';
    case 'wednesday':
      return 'Mittwoch';
    case 'thursday':
      return 'Donnerstag';
    case 'friday':
      return 'Freitag';
    case 'saturday':
      return 'Samstag';
    case 'sunday':
      return 'Sonntag';
    case 'holiday':
      return 'Feiertag';
    default:
      return '';
  }
}

function getIcon(string $iconFilename, string $title = ''): string {
  return '<img class="icon" src="../assets/pics/' . $iconFilename . '" title="'. $title . '">';
}

function getAktuellesDatumUndStunde(): array {
  $timestamp = time();
  return array(
    date("ymd", $timestamp),
    date("H", $timestamp)
  );
}

function wandleDateStringInArrayUm(string $dateString): array {
  $dateTime = new DateTime($dateString);
  return array(
    $dateTime->format('ymd'),
    $dateTime->format('H')
  );
}

function getMainEvaNumber($evaNumbers) {
  foreach ($evaNumbers as $evaNumber) {
    if (isset($evaNumber["isMain"]) && $evaNumber["isMain"] == true) {
      return $evaNumber["number"];
    }
  }
  return null;
}

function formatFahrplanZeit(string $datumZeit): string {
  if ($datumZeit !== "") {
    $date = DateTime::createFromFormat('ymdHi', $datumZeit);
    $formatiertesDatumZeit = $date->format('H:i');
    return $formatiertesDatumZeit;
  } else {
    return "";
  }
}

function getAnkunftAus(string $fromPath): string {
  $array = explode("|", $fromPath);
  $first_element = $array[0];
  return $first_element;
}

function getAbfahrtNach(string $toPath): string {
  $array = explode("|", $toPath);
  $last_element = end($array);
  return $last_element;
}

function getParkingFacilityName($parkingFacilityNameObj): string {
  $result = '';
  if (isset($parkingFacilityNameObj)) {
    foreach ($parkingFacilityNameObj as $name) {
      if ($name["context"] == "DISPLAY") {
        return $name["name"];
      }
      if ($name["context"] == "NAME") {
        $result = $name["name"];
      }
    }
  }
  return $result;
}

function getParkingFacilityCapacity(array $parkingFacilityCapacityObj): array { 
  foreach ($parkingFacilityCapacityObj as $facility) {
    if (isset($facility["type"]) && $facility["type"] == "PARKING") {
      $isAvailable = $facility["available"];
      $totalCapacity = $facility["total"];
      $availableCapacity = $facility["free"]["text"];
      if ($facility["free"]["category"] == "MORE_THAN_FIFTY") {
        $capacityColor = "parking-capacity-green";
      } else {
        $capacityColor = "parking-capacity-orange";
      }
      return array($isAvailable, $totalCapacity, $availableCapacity, $capacityColor);
    }
  }
  return array(false, 0, 0);
}

function formatTimeSlice(string | int $sliceStart): string {
  $sliceStart = (int)$sliceStart;
  if ($sliceStart < 23) {
    $sliceEnd = $sliceStart + 1;
  } else {
    $sliceEnd = 0;
  }
  return $sliceStart . ':00 - ' . $sliceEnd . ':00';
}

?>