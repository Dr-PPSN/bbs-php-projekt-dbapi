<?php
require_once "sql.php";

if (isset($_POST['btnCreateUser'])) {
    createUser($_POST['userName'], $_POST['password']);
}
else if (isset($_POST['btnLogin'])) {
    if(checkLogin($_POST['userName'], $_POST['password'])){
        $notification = "Erfolgreich eingeloggt";
        $_SESSION['userName'] = $_POST['userName'];
    }
    else{
        $notification = "Fehler beim einloggen";
    }
}

function createUser($userName, $password){
    global $notification;
    $x = checkUserName($userName);
    if(isset($x[0]["userName"]) && $x[0]["userName"] == $userName || !checkPassword($password)) {
        $notification = "Benutzername ungültig oder Passwort zu kurz";
        return;
    }
    else{
        $pepper = "P1H2P3e4t5r6i7e8";
        $salt = random_string(12);
        $password = hash("sha256",$salt . $password . $pepper); // Damit das  Passwort schön Gewürzt ist und gut schmeckt
        $sql = "INSERT INTO user (userName, password, salt, favorite_stations) VALUES ('$userName', '$password', '$salt', null)";
        executeSQL($sql);
        $notification = "Benutzer erfolgreich erstellt";
    }
}
function checkLogin($userName, $password){
    $x = checkUserName($userName);
    if(isset($x[0]["userName"]) && $x[0]["userName"] == $userName){
        $result = executeSQL("SELECT * FROM user WHERE userName = '$userName'");
        $pepper = "P1H2P3e4t5r6i7e8";
        $salt = $result[0]["salt"];
        $hashedPassword = $result[0]["password"];
        if($hashedPassword == hash("sha256",$salt . $password . $pepper)){
            return true;
        }
        else{
            return false;
        }
    }
    else{
        return false;
    }
}
function checkUserName($userName){
    if(strlen($userName) < 25 && strlen($userName) > 2){
        $sql = "SELECT userName FROM user WHERE userName = '$userName'";
        $result = executeSQL($sql);
        return $result;
    }   
    return false;
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