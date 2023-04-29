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

function getIcon($iconFilename): string {
  return '<img class="icon" src="../assets/pics/' . $iconFilename . '">';
}

function getAktuellesDatumUndStunde(): array {
  $timestamp = time();
  $datum = date("ymd", $timestamp);
  $stunde = date("H", $timestamp);
  return array($datum, $stunde);
}

function getMainEvaNumber($evaNumbers) {
  foreach ($evaNumbers as $evaNumber) {
    if (isset($evaNumber["isMain"]) && $evaNumber["isMain"] == true) {
      return $evaNumber["number"];
    }
  }
  return null;
}

?>