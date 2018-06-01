<?php
include 'conecta.php';
echo "PRONTO<br>";
$atualizaBoleto = $mysqli->query("update BOLETO set STATUS = 3 where ID = ".$_GET['BoletoID']."");