<?php 
function tirarAcentos($string){
    $troca = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/",
                                "/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/",
                                "/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/","/(ç)/","/(Ç)/"),
                                explode(" ","a A e E i I o O u U n N c C"),$string);
    $troca = str_replace('º', '', $troca);
    return str_replace('°', '', $troca);
    }

include 'conecta.php';
$sql = $mysqli->query("select BOLETO.ID, VALOR, USUARIO.NOME, CNPJ, CEP,
                       RUA, NUMERO, BAIRRO, VENCIMENTO, SEQUENCIAL, SEUNUMERO, CIDADE.NOME as CNOME, CAMINHO
     		       from BOLETO, USUARIO, CIDADE
                       where BOLETO.STATUS = 1
                       and USUARIO.ID = BOLETO.REFUSUARIO
                       and CIDADE.ID = USUARIO.REFCIDADE");

set_time_limit(0);

while ($boleto = mysqli_fetch_object($sql)) {	
    $dataVencimento = date('dmy', strtotime($boleto->VENCIMENTO)); 
    $uNome = tirarAcentos($boleto->NOME);
    $endereco = tirarAcentos($boleto->RUA . ", " . $boleto->NUMERO);
    echo ("<iframe src='boleto_sicredi.php?data_venc=".$boleto->VENCIMENTO."&valor_cobrado=".$boleto->VALOR.
          "&nossoNumero=".$boleto->SEQUENCIAL."&seuNumero=".$boleto->SEUNUMERO."&nomeUsuario=".$uNome." - CNPJ: ".$boleto->CNPJ.
          "&endereco1=".($boleto->RUA . " Numero " . $boleto->NUMERO . ", Bairro - " . $boleto->BAIRRO).
          "&endereco2=".($boleto->CNOME." - RS - CEP: ".$boleto->CEP)."&nomeBoleto=".$boleto->CAMINHO."&BoletoID=".$boleto->ID."'></iframe>"."\n");
    }
echo "<meta HTTP-EQUIV='refresh' CONTENT='60;URL=criaPDF.php'>";