<?php
include 'conecta.php';

set_time_limit(0);
date_default_timezone_set('America/Sao_Paulo');

$diaVencimento = date('d')-1;
$dataVencimento = date('Y-m').'-'.$diaVencimento;
$dataVencimento = date('Y-m-d', strtotime($dataVencimento));
$sqlVENCIDOS = "update BOLETO set STATUS = 4 where VENCIMENTO = '".$dataVencimento."' and STATUS = 2";
$queryVENCIDOS = $mysqli->query($sqlVENCIDOS);    

function tirarAcentos($string){
    return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/",
                              "/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/",
                              "/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/","/(ç)/","/(Ç)/"),
                              explode(" ","a A e E i I o O u U n N c C"),$string);
    }

    
require 'PHPMailer/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$mail = new PHPMailer(true);
   
$mail->IsSMTP();    

$mail->Host = 'in-v3.mailjet.com';
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->Username = '5d203235ef0ebe50a9cbe0adca384a88';
$mail->Password = '3d0584d23f640b1057d08d22058a27a9';
$mail->FromName = "TopTech - Não Responda";
$mail->From = 'naoresponda@toptech.solutions';
$mail->Subject = "Aviso boleto TopTech";

$sql = "select USUARIO.ID, NOME, VENCIMENTO
        from USUARIO, BOLETO
	where STATUS = 2 and (VENCIMENTO = '".date('Y-m-d')."' or VENCIMENTO = '".$dataProtesto."') and REFUSUARIO = USUARIO.ID";

$query = $mysqli->query($sql);
while ($busca = mysqli_fetch_object($query)) {
    if (date('Y-m-d') == $busca->VENCIMENTO){
        $message = "Olá ".$busca->NOME.", a TopTech vem por meio deste informar que você possui "
                 . "um boleto com o vencimento no dia de hoje (".date('d/m/Y', strtotime($busca->VENCIMENTO))."), caso o mesmo não seja pago o "
                 . "fornecimento do serviço sera interrompido automaticamente em 5 dias corridos. No caso do seu boleto já ter sido pago, por "
                 . "favor, desconsidere este e-mail.";
        }
  
    $mail->Body = utf8_decode($message.'<br><br>TopTech Solutions.<br>Para mais informações entre em contato através do e-mail suporte@toptech.solutions');
    $mail->IsHTML(true);

    $mail->AddAddress($busca->EMAIL, tirarAcentos($busca->NOME));
    if(!$mail->Send()){
        $manipular = fopen("emailErro.txt", 'a');
        fwrite("emailErro.txt", $busca->ID." - ".$busca->NOME." - ".$busca->EMAIL);
        fclose($manipular);
        }
    $mail->ClearAllRecipients();
    }

function limpaCNPJ($valor){
    $valor = trim($valor);
    $valor = str_replace(".", "", $valor);
    $valor = str_replace("-", "", $valor);
    $valor = str_replace("/", "", $valor);
    return $valor;
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
   
$sqlVerifica = $mysqli->query("select count(ID) as CONTA from BOLETO where STATUS = 0");
$dadosVerifica = mysqli_fetch_object($sqlVerifica);
if ($dadosVerifica->CONTA != 0){
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
        }

    $mail2 = new PHPMailer(true);

    $mail2->IsSMTP();    

    $mail2->Host = 'toptech.solutions';
    $mail2->SMTPAuth = true;
    $mail2->SMTPSecure = 'tls';
    $mail2->Port = 465;
    $mail2->Username = 'naoresponda@toptech.solutions';
    $mail2->Password = 'k.Kp5TPLS!Nv';
    $mail2->FromName = "TopTech";
    $mail2->From = 'naoresponda@toptech.solutions';
    $mail2->Subject = "Gerar Boletos";

    $mail->Body = utf8_decode("Olá, o remessa foi gerado e os boletos estão prontos para serem emitidos.<br>"
                             ."<a href='https://www.w3schools.com'>Gerar Boletos</a>");
    $mail->IsHTML(true);

    $mail->AddAddress('jaderfeldmann@hotmail.com', "Jader Teixeira");
    $mail->AddAddress('alexssanderdallabrida@gmail.com', "Alexssander Prager");
    if(!$mail->Send()){
        $manipular = fopen("emailErro.txt", 'a');
        fwrite("emailErro.txt", $busca->ID." - ".$busca->NOME." - ".$busca->EMAIL);
        fclose($manipular);
        }
    $mail->ClearAllRecipients();
    }