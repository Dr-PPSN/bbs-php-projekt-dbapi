<?php
require_once "sql.php";
function createUser($userName, $password){
    if (!checkUserName($userName) && !checkPassword($password)) {
        global $notification;
        $notification = "Benutzername ungültig oder Passwort zu kurz";
        return;
    }
    $pepper = "P1H2P3e4t5r6i7e8";
    $salt = random_string(12);
    $password = hash("sha256",$salt . $password . $pepper); // Damit das  Passwort schön Gewürzt ist und gut schmeckt
    $sql = "INSERT INTO user (userName, password, salt, favorite_stations) VALUES ('$userName', '$password', '$salt', null)";
    executeSQL($sql);
}
function checkLogin($userName, $password){
    if(checkUserName($userName)){
        $salt = executeSQL("SELECT salt FROM user WHERE userName = '$userName'");
        $password = executeSQL("SELECT password FROM user WHERE userName = '$userName'");
        //TODO: unhash password
        
    }
}
function checkUserName($userName){
    if(strlen($userName) < 25 && strlen($userName) > 3){
        $sql = "SELECT userName FROM user WHERE userName = '$userName'";
        return executeSQL($sql);
    }
    else{
        return false;
    }
}
function checkPassword($password){
    if (strlen($password) < 65 && strlen($password) > 4) {
        return true;
    }
    else{
        return false;
    }
}
function random_string($length) {
    $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str = '';
    $max = 12;
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[random_int(0, $max)];
    }
    return $str;
}
?>