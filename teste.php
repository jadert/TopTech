<?php session_start();
$_SESSION["idUsr"] = 13;

while (strlen($_SESSION["idUsr"]) < 6) {
    $_SESSION["idUsr"] = "0" . $_SESSION["idUsr"];
    }
    
echo $_SESSION["idUsr"];  