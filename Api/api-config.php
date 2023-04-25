<?php

$config = parse_ini_file('../config.ini'); 

define('CLIENT_ID', $config["client_id"]);
define('API_KEY'  , $config["api_key"]);

?>