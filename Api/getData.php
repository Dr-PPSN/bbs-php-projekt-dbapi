<?php

require_once '../autoloader.php';
require_once 'api-config.php';

function getResponseType(string $responseType): string {
    switch ($responseType) {
      case 'json':
        return 'application/json';
      case 'ris+json':
        return 'application/vnd.de.db.ris+json';
      case 'xml':
        return 'application/xml';
      default:
        return 'application/json';
    }
}

function getData(string $url, string $responseType = 'json'): bool|string|array {
  $cw = new Curl\CurlWrapper($url);
  $cw->setHeaders(
    array(
      'Accept: ' . getResponseType($responseType),
      'DB-Client-Id: ' . CLIENT_ID,
      'DB-Api-Key: ' . API_KEY
    ));

  $response = $cw->request(new Curl\Requests\GetRequest(array()));
  $cw->dispose();

  if (200 !== $response->getStatusCode()) {
    return false;
  } else {
    return $response->decode();
  }
}


?>