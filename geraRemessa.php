<?php
include './conecta.php';
date_default_timezone_set('America/Sao_Paulo');

function limpaCNPJ($valor){
    $valor = trim($valor);
    $valor = str_replace(".", "", $valor);
    $valor = str_replace("-", "", $valor);
    $valor = str_replace("/", "", $valor);
    return $valor;
    }

function tirarAcentos($string){
    $troca = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/",
                                "/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/",
                                "/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/","/(ç)/","/(Ç)/"),
                                explode(" ","a A e E i I o O u U n N c C"),$string);
    $troca = str_replace('º', '', $troca);
    return str_replace('°', '', $troca);
    }
    
function Cmodulo_11($N) {
    $X = 2;
    $Soma = 0;
    for ($Pn = (strlen($N) - 1); $Pn > 0; $Pn--) {
        $Soma = $Soma + $N[$Pn] * $X;
        $X++;
        if ($X == 10)
            $X = 2;
        }
    $Result = 11 - ($Soma % 11);
    if ($Result > 9) {
        if (strlen($N) == 43)
            $Result = 1;
        else
            $Result = 0;
        }
    return($Result);
    }
    
function remessa($VALOR, $CNPJ, $NOME, $ENDERECO, $CEP, $SEUNUMERO, $SEQUENCIAL, $VENCIMENTO, $BOLETOID, $calculaMes) {
    include './conecta.php';
    while (strlen($NOME) < 40) {
        $NOME = ' ' . $NOME;
    	}
    while (strlen($ENDERECO) < 40) {
        $ENDERECO = ' '.$ENDERECO;
    	}
    while (strlen($SEUNUMERO) < 10) {
        $SEUNUMERO = $SEUNUMERO . '0';
    	}
    while (strlen($SEQUENCIAL) < 5) {
        $SEQUENCIAL = '0' . $SEQUENCIAL;
   	}

    if (!file_exists("remessa/60656" . $calculaMes . date("d") . ".CRM")) {
        $arquivo = fopen("remessa/60656" . $calculaMes . date("d") . ".CRM", "w");
        $buscaRemessa = $mysqli->query("select max(NUMERO) as NUMREMESSA from REMESSA;");
        $busca = mysqli_fetch_object($buscaRemessa);
        $numRemessa = $busca->NUMREMESSA + 1;
        $nomeArquivo = '60656' . $calculaMes . date('d');
        $insereRemessa = $mysqli->query("insert into REMESSA (NOME, NUMERO, NUMLINHAS) values ('" . $nomeArquivo . "', " . $numRemessa . ", 1);");
        fwrite($arquivo, '01REMESSA01COBRANCA       6065619766798000105                               748SICREDI        ');

        while (strlen($numRemessa) < 7) {
            $numRemessa = '0' . $numRemessa;
            }

        fwrite($arquivo, date("Ymd"));
        fwrite($arquivo, '        ');
        fwrite($arquivo, $numRemessa);
        fwrite($arquivo, '                                                                                                  ');
        fwrite($arquivo, '                                                                                      ');
        fwrite($arquivo, '                                                                                         2.00000001');
        fwrite($arquivo, "\r\n");
    } else {
        $arquivo = fopen("remessa/60656" . $calculaMes . date("d") . ".CRM", "a");
        }
    $NOSSONUMERO = date("y") . '2' . $SEQUENCIAL . Cmodulo_11('03610900107' . date('y') . '2' . $SEQUENCIAL);
        
    $atualizaBoleto = $mysqli->query("update BOLETO set EMISSAO = '".date('Y-m-d')."', STATUS = 1, REFREMESSA = (select max(ID) from REMESSA),
                                      NOSSONUMERO = $NOSSONUMERO where ID = ".$BOLETOID.";");

    $buscaLinhaRemssa = $mysqli->query("select max(NUMLINHAS) as REMESSA from REMESSA where ID = (select max(ID) as REMESSA from REMESSA);");
    $bLinha = mysqli_fetch_object($buscaLinhaRemssa);
    $LINHAS = $bLinha->REMESSA + 1;

    $buscaMaxRemessa = $mysqli->query("select max(ID) as REMESSA from REMESSA;");
    $busca2 = mysqli_fetch_object($buscaMaxRemessa);
    $atualizaRemessa = $mysqli->query("update REMESSA set NUMLINHAS = " . $LINHAS . " where ID = " . $busca2->REMESSA . ";");

    while (strlen($LINHAS) < 6)
        $LINHAS = '0' . $LINHAS;
		
    $valorBD = $VALOR;
	$VALOR = str_replace(",", ".", $VALOR);
    if ($VALOR[strlen($VALOR) - 2] == '.') {
        $VALOR = str_replace(".", "", $VALOR);
        $VALOR = $VALOR . '0';
	}
	else if ($VALOR[strlen($VALOR) - 3] == '.')
        $VALOR = str_replace(".", "", $VALOR);
    else
        $VALOR = $VALOR . '00';

    while (strlen($VALOR) < 13) {
        $VALOR = '0' . $VALOR;
        }
	
    $CEP = str_replace("-", "", $CEP);

    fwrite($arquivo, '1AAA            ABB                            ');
    fwrite($arquivo, date("y") . '2' . $SEQUENCIAL . Cmodulo_11('03610900107' . date('y') . '2' . $SEQUENCIAL));
    fwrite($arquivo, '      ');
    fwrite($arquivo, date('Ymd'));
    fwrite($arquivo, ' N B        00000000000200            01');
    fwrite($arquivo, $SEUNUMERO);
    fwrite($arquivo, $VENCIMENTO);
    fwrite($arquivo, $VALOR);
    fwrite($arquivo, '         AS');
    fwrite($arquivo, date('dmy'));
    fwrite($arquivo, '0000000000000001000000000000000000000000000000000000000000000020');
    fwrite($arquivo, $CNPJ);
    fwrite($arquivo, $NOME);
    fwrite($arquivo, $ENDERECO);
    fwrite($arquivo, '00000000000 ');
    fwrite($arquivo, $CEP);
    fwrite($arquivo, '00000                                                       ');
    fwrite($arquivo, $LINHAS);
    fwrite($arquivo, "\r\n");
    fclose($arquivo);
    }
     
if (date("m") <= 9) {
    $calculaMes = date("m");
    $calculaMes = $calculaMes['1'];
} else if (date("m") == 10)
    $calculaMes = 'O';
else if (date("m") == 11)
    $calculaMes = 'N';
else if (date("m") == 12)
    $calculaMes = 'D';

$sql = $mysqli->query("select BOLETO.ID, VALOR, USUARIO.NOME, CNPJ, CEP,
                       RUA, NUMERO, BAIRRO, VENCIMENTO, SEQUENCIAL, SEUNUMERO, CIDADE.NOME as CNOME, CAMINHO
     		       from BOLETO, USUARIO, CIDADE
                       where BOLETO.STATUS = 0
                       and USUARIO.ID = BOLETO.REFUSUARIO
                       and CIDADE.ID = USUARIO.REFCIDADE");

set_time_limit(0);
while ($boleto = mysqli_fetch_object($sql)) {	
    $dataVencimento = date('dmy', strtotime($boleto->VENCIMENTO)); 
    $nome = tirarAcentos($boleto->NOME);
    $endereco = tirarAcentos($boleto->RUA . ", " . $boleto->NUMERO);
    remessa($boleto->VALOR, limpaCNPJ($boleto->CNPJ), $nome, $endereco, $boleto->CEP, $boleto->SEUNUMERO, $boleto->SEQUENCIAL, $dataVencimento, $boleto->ID, $calculaMes);
    $numLinhas = mysqli_num_rows($sql);
    }
    
if ($numLinhas > 0){
    $buscaLinhaRemssa = $mysqli->query("select ID, NUMLINHAS from REMESSA where ID = (select max(ID) from REMESSA);");
    $qLinha = mysqli_fetch_object($buscaLinhaRemssa);
    $linha = $qLinha->NUMLINHAS+1;
    $atualizaLinhas = $mysqli->query("update REMESSA set NUMLINHAS = ".$linha." where ID = ".$qLinha->ID);	
    while (strlen($linha) < 6)
	$linha = '0' . $linha;
    $arquivo = fopen("remessa/60656" . $calculaMes . date("d") . ".CRM", "a");
    fwrite($arquivo, "9174860656                                                                                                  "
            . "                                                                                                                   "
            . "                                                                                                                   "
            . "                                                        ".$linha);
    fwrite($arquivo, "\r\n");
    fclose($arquivo);
    echo "<meta HTTP-EQUIV='refresh' CONTENT='60;URL=criaPDF.php'>";
    }