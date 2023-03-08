<?php

namespace Curl\Responses;

final class ResponseTypeDecider
{
    public static function decideFromData(string $ps_data, int $pi_statusCode): AResponse {
        libxml_use_internal_errors(true);
        if (false !== simplexml_load_string($ps_data)) {
            return new XmlResponse($ps_data, $pi_statusCode);
        } if (false !== json_decode($ps_data, false)) {
            return new JsonResponse($ps_data, $pi_statusCode);
        } else {
            return new StringResponse($ps_data, $pi_statusCode);
        }
    }
}