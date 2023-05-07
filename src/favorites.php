<?php
session_start();

if(isset($_POST['submit'])&&isset($_POST['stationID'])){
    require_once '../db/sql.php';
    $stationID = $_POST['stationID'];
    $userName = $_SESSION['userName'];
    
    header("Location: station-details.php?stationID=$stationID");
}
function showFavorites(){
    require_once './db/sql.php';

    $favoritesArray = getFavorites($_SESSION['userName'])[0]['favorite_stations'];
    if($favoritesArray != null){
        foreach($favoritesArray as $favorite){
            if($favorite['type'] === 'isStation'){
                $link = "src/haltestelle-details.php?evaNumber=" . $favorite['idStation'];
            }
            elseif($favorite['type'] === 'isBahnhof'){
                $link = "src/station-details.php?stationID=" . $favorite['idStation'];
            }
            $html .= "<div class='m-3 w-100'><center><a class='btn btn-outline-dark p-3 text-white DbahnBackground' href='" . $link . "'>" . $favorite['name'] . "</a></center></div>";
        }
        return $html;
    }
    else{
        return "<div class='m-3 w-100'><center><h3>Keine Favoriten vorhanden</h3></center></div>";
    }
}
function getFavorites($userName){
    $sql = "SELECT idUser FROM user WHERE name = '$userName'";
    $idUser = executeSQL($sql);
    $sql = "SELECT * FROM favourite_stations WHERE id_user = '$idUser'";
    $result = executeSQL($sql);
    return $result;
}
?>