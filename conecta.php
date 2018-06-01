<?php
$caminho = 'localhost';
$usuario = 'root';
$senha = 'root';
$banco = 'boletostt';
$mysqli = mysqli_connect($caminho, $usuario, $senha, $banco);   
if (!$mysqli) {
    die('Não foi possível conectar: ' . mysql_error());
    }