<?php


if(isset($_POST['submit_add'])&&isset($_POST['stationID'])&&isset($_POST['stationName'])&&isset($_POST['type'])){
    session_start();
    require_once '../db/sql.php';
    $stationID = $_POST['stationID'];
    $stationName = $_POST['stationName'];
    $userName = $_SESSION['userName'];
    $type = $_POST['type'];
    $userID = getUserID($userName);
    $favoritesArray = getFavorites($userName);
    if(!checkIfFavorite($stationID)){
        $sql = "INSERT INTO favourite_stations (id_user, idStation, typ, stationName) VALUES ('$userID', '$stationID', '$type', '$stationName')";
        executeSQL($sql);
    }
    header("Location: station-details.php?stationID=$stationID");
}
else if(isset($_POST['submit_delete'])&&isset($_POST['stationID'])){
    session_start();
    require_once '../db/sql.php';
    $stationID = $_POST['stationID'];
    $userName = $_SESSION['userName'];
    $userID = getUserID($userName);
    $sql = "DELETE FROM favourite_stations WHERE id_user = '$userID' AND idStation = '$stationID'";
    executeSQL($sql);
    header("Location: station-details.php?stationID=$stationID");
}
else if(isset($_POST['submit_add_2'])&&isset($_POST['stationID'])&&isset($_POST['stationName'])&&isset($_POST['type'])){
    session_start();
    require_once '../db/sql.php';
    $stationID = $_POST['stationID'];
    $stationName = $_POST['stationName'];
    $userName = $_SESSION['userName'];
    $type = $_POST['type'];
    $userID = getUserID($userName);
    $favoritesArray = getFavorites($userName);
    if(!checkIfFavorite($stationID)){
        $sql = "INSERT INTO favourite_stations (id_user, idStation, typ, stationName) VALUES ('$userID', '$stationID', '$type', '$stationName')";
        executeSQL($sql);
    }
    header("Location: haltestelle-details.php?evaNumber=$stationID");
}
else if(isset($_POST['submit_delete_2'])&&isset($_POST['stationID'])){
    session_start();
    require_once '../db/sql.php';
    $stationID = $_POST['stationID'];
    $userName = $_SESSION['userName'];
    $userID = getUserID($userName);
    $sql = "DELETE FROM favourite_stations WHERE id_user = '$userID' AND idStation = '$stationID'";
    executeSQL($sql);
    header("Location: haltestelle-details.php?evaNumber=$stationID");
}
function checkIfFavorite($stationID){
    require_once '../db/sql.php';
    $userName = $_SESSION['userName'];
    $favoritesArray = getFavorites($userName);
    if($favoritesArray != null){
        foreach($favoritesArray as $favorite){
            if($favorite['idStation'] === $stationID){
                return true;
            }
        }
    }
    return false;
}
function showFavorites(){
    require_once './db/sql.php';
    $html = "";
    $favoritesArray = getFavorites($_SESSION['userName']);
    if($favoritesArray != null){
        foreach($favoritesArray as $favorite){
            if($favorite['typ'] === 'isStation'){
                $link = "src/haltestelle-details.php?evaNumber=" . $favorite['idStation'];
            }
            elseif($favorite['typ'] === 'isBahnhof'){
                $link = "src/station-details.php?stationID=" . $favorite['idStation'];
            }
            $html .= "<div class='m-3 w-100'><center><a class='btn btn-outline-dark p-3 text-white DbahnBackground' href='" . $link . "'>" . $favorite['stationName'] . "</a></center></div>";
        }
        return $html;
    }
    else{
        return "<div class='m-3 w-100'><center><h3>Keine Favoriten vorhanden</h3></center></div>";
    }
}
function getFavorites($userName){
    $idUser = getUserID($userName);
    $sql = "SELECT * FROM favourite_stations WHERE id_user = '$idUser'";
    $result = executeSQL($sql);
    return $result;
}
function getUserID($userName){
    $sql = "SELECT idUser FROM user WHERE name = '$userName'";
    $result = executeSQL($sql);
    return $result[0]['idUser'];
}
?>