<?php

require "db.php";

$themeList = ["light", "dark"];

$query = $con->prepare("SELECT theme FROM accounts WHERE username=:username");
$query->bindParam(":username", $_SESSION["username"]);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);

if ($result) {
    $theme = $result[0]['theme'];
    
    if (in_array($theme, $themeList)) {
        $_SESSION["theme"] = $theme;
    } else {
        $_SESSION["theme"] = "light"; 
    }
} else {
    $_SESSION["theme"] = "light";
}