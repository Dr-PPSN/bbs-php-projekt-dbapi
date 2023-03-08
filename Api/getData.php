<?php

require_once '../Autoloader.php';
require_once '../config.php';

function getResponseType(string $responseType): string {
    switch ($responseType) {
        case 'json':
            return 'application/json';
        case 'xml':
            return 'application/xml';
        default:
            return 'application/json';
    }
}

function getData(string $url, string $responseType = 'json'): string|array {
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
    return "Error: " . $response->getStatusCode();
  } else {
    return $response->decode();
  }
}


?>