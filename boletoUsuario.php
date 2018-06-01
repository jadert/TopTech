<?php
session_start();
include './conecta.php';

function tirarAcentos($string) {
    $troca = preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/",
        "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/",
        "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/",
        "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/", "/(ç)/", "/(Ç)/"), explode(" ", "a A e E i I o O u U n N c C"), $string);
    return str_replace('/', '-', $troca);
    }

$i = 1;
while ($i < $_SESSION["Ciclos"]) {
    $i++;
    $sqlSequencial = mysqli_query($mysqli, "select MAX(SEQUENCIAL) as SEQUENCIAL from BOLETO");
    $buscaSequencial = mysqli_fetch_object($sqlSequencial);
    $nossoNumero = $buscaSequencial->SEQUENCIAL + 1;
    while (strlen($nossoNumero) < 5) {
        $nossoNumero = "0" . $nossoNumero;
        }

    $NOMEBOLETO = $_SESSION["CNPJ"] . "@" . date("d-m-Y") . "@" . date_format($_SESSION["Vencimento"], 'd-m-Y');

    $NUMERODOCUMENTO = date_format($_SESSION["Vencimento"], 'ym') . $_SESSION["idUsr"];
    
    $insereBoleto = $mysqli->query("insert into BOLETO (VALOR, VENCIMENTO, CAMINHO, SEQUENCIAL, SEUNUMERO, REFUSUARIO)
                                    VALUES (" . $_SESSION["Valor"] . ",
		        	    '" . date_format($_SESSION["Vencimento"], 'Y-m-d') . "',
				    '" . tirarAcentos($NOMEBOLETO) . "',
				    " . $nossoNumero . ",
				    '" . $NUMERODOCUMENTO . "',
				    " . $_SESSION["idUsr"] . ")");
    
    date_add($_SESSION["Vencimento"], date_interval_create_from_date_string('30 days'));
    }
unset($_SESSION["CNPJ"]);
unset($_SESSION["idUsr"]);
unset($_SESSION["Ciclos"]);
unset($_SESSION["Valor"]);
unset($_SESSION["Vencimento"]);
$_SESSION["Emitidos"] = 'S';
//echo '<script type="text/javascript"> location.href="index.php?pag=confirmaEmail"; </script>';
echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=index.php?pag=confirmaEmail'>";