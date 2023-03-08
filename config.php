<?php

error_reporting(E_ALL);

$config = parse_ini_file('config.ini'); 

define('CLIENT_ID', $config["client_id"]);
define('API_KEY'  , $config["api_key"]);

define('MYSQL_HOST'     , $config["host"]);
define('MYSQL_BENUTZER' , $config["user"]);
define('MYSQL_KENNWORT' , $config["password"]);
define('MYSQL_DATENBANK', $config["database"]);

?>