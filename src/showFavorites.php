<?php
require_once "./hv-html-engine/hv-html-engine.php";
require_once './db/sql.php';

//variables
$hv_html_engine = new HV_HTML_Engine();
function showFavorites(){
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