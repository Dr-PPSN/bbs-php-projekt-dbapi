<?php

namespace Curl\Responses;

use \InvalidArgumentException;
use Curl\Responses\AResponse;

class XmlResponse extends AResponse {

    /**
     * Konstruktor.
     */
    public function __construct(string $s_responseString, int $i_statusCode) {
        parent::__construct($s_responseString, $i_statusCode);
    }

    /**
     * Dekodiert den Response-String als ein XML-Objekt.
     */
    public function decode(): array|string {
      $xml = simplexml_load_string($this->getResponseString());
      $json = json_encode($xml);
      $_retArr = json_decode($json, true);
      if (false === $_retArr) throw new InvalidArgumentException('String ist kein XML!', 1);
      return $_retArr;
    }
}