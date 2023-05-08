<?php
// Funktionen für DB-Operationen
require_once 'config.php';

$conn = getDBConnection();
if($conn != null){
  selectDB();
}

if (isset($_GET['resetDB'])) {
  resetDB();
}

function getDBConnection() {
  global $notification;
  try{
    $conn = new mysqli(MYSQL_HOST, MYSQL_BENUTZER, MYSQL_KENNWORT);
    if ($conn->connect_error) {
      $notification = "Connection failed: " . $conn->connect_error; 
      exit();
    }
    return $conn;
  }
  catch(Exception $e){
    $notification = "Connection failed: " . $e->getMessage(); 
  }
}

function selectDB() {
  global $conn;
  try {
    $conn->select_db('projekt_dbahn');
  } catch (Exception $e) {
    resetDB();
  }
}

function resetDB() {
  global $conn;
  global $notification;
  if (file_exists('projekt_dbahn.sql')) {
    $filename = 'projekt_dbahn.sql';
  } else {
    $notification = 'Error: Keine Datenbankdatei gefundenXXX';
    return;
  }

  $tempLine = '';
  $lines = file($filename);
  foreach ($lines as $line) {
    if (substr($line, 0, 2) == '--' || $line == '')
      continue;
    $tempLine .= $line;
    if (substr(trim($line), -1, 1) == ';') {
      mysqli_query($conn, $tempLine) or print("Error in " . $tempLine . ":" . mysqli_error($conn));
      $tempLine = '';
    }
  }
  $notification = 'Datenbank zurückgesetzt';
}

?>