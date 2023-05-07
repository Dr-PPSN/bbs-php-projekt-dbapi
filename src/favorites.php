<?php
session_start();

if(isset($_POST['submit'])&&isset($_POST['stationID'])){
    require_once '../db/sql.php';
    $stationID = $_POST['stationID'];
    $userName = $_SESSION['userName'];
    $result = getFavorites($userName)[0]['favorite_stations'];
    if($result != null){
        $favoritesEvaNr = explode(",", $result);
        if(!in_array($stationID, $favoritesEvaNr)){
            array_push($favoritesEvaNr, $stationID);
            $favoritesEvaNr = implode(",", $favoritesEvaNr);
            $sql = "UPDATE user SET favorite_stations = '$favoritesEvaNr' WHERE userName = '$userName'";
            executeSQL($sql);
        }
    }
    else{
        $sql = "UPDATE user SET favorite_stations = '$stationID' WHERE userName = '$userName'";
        executeSQL($sql);
    }
    header("Location: station-details.php?stationID=$stationID");
}
function showFavorites(){
    require_once './db/sql.php';
    $favoritesDetailsArray = array();
    $result = getFavorites($_SESSION['userName'])[0]['favorite_stations'];
    if($result != null){
        $favoritesEvaNr = explode(",", $result);
        foreach($favoritesEvaNr as $favoriteEvaNr){
            array_push($favoritesDetailsArray, getStationDetails($favoriteEvaNr));
        }
        // Erstelle die Tabellenkopfzeile
        $html = "";

        // Iteriere durch das Array und füge jede Zeile zur Tabelle hinzu
        foreach ($favoritesDetailsArray as $key => $value) {
            foreach ($value as $innerValue) {
                if ($innerValue['type'] === 'isStation') {
                    $link = "src/haltestelle-details.php?evaNumber=" . $innerValue['eva'];
                } elseif ($innerValue['type'] === 'isBahnhof') {
                    $link = "src/station-details.php?stationID=" . $innerValue['eva'];
                }
                $html .= "<div class='m-3 w-100'><center><a class='btn btn-outline-dark p-3 text-white DbahnBackground' href='" . $link . "'>" . $innerValue['name'] . "</a></center></div>";
            }
        }

        return $html; 
    }
    else{
        return "<div class='m-3 w-100'><center><h3>Keine Favoriten vorhanden</h3></center></div>";
    }
    
}
function getFavorites($userName){
    $sql = "SELECT favorite_stations FROM user WHERE userName = '$userName'";
    $result = executeSQL($sql);
    return $result;
}
function getStationDetails($evaNr){
    $sql = "SELECT * FROM favorite_station WHERE eva = '$evaNr'";
    $result = executeSQL($sql);
    return $result;
}
?>