<?php
include './conecta.php';
require 'PHPMailer/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function validar_cnpj($cnpj) {
    $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
    if (strlen($cnpj) != 14)
        return false;
    for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
        $soma += $cnpj{$i} * $j;
        $j = ($j == 2) ? 9 : $j - 1;
        }
    $resto = $soma % 11;
    if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto))
        return false;
    for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
        $soma += $cnpj{$i} * $j;
        $j = ($j == 2) ? 9 : $j - 1;
        }
    $resto = $soma % 11;
    return $cnpj{13} == ($resto < 2 ? 0 : 11 - $resto);
    }

if (isset($_POST['salvaCadastro'])) {
    $cnpj = trim(filter_input(INPUT_POST, 'cnpj'));
    $nome = trim(filter_input(INPUT_POST, 'nomeE'));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $email2 = trim(filter_input(INPUT_POST, 'email2', FILTER_SANITIZE_EMAIL));
    $cep = trim(filter_input(INPUT_POST, 'cep'));
    $rua = trim(filter_input(INPUT_POST, 'rua'));
    $numero = trim(filter_input(INPUT_POST, 'numero'));
    $bairro = trim(filter_input(INPUT_POST, 'bairro'));
    $logradouro = trim(filter_input(INPUT_POST, 'logradouro'));
    $cidade = trim(filter_input(INPUT_POST, 'cidade'));
    $estado = trim(filter_input(INPUT_POST, 'estado'));
    
    if (($cnpj != '') && ($email != '') && ($cep != '') && ($rua != '') && ($numero != '') && ($bairro != '') && ($cidade != '') && ($estado != '') && ($nome != '')){
        if (strlen($rua) <= 40) {
            if (strlen($bairro) <= 40) {
                if (strlen($logradouro) <= 40) {
                    if (strlen($email) <= 60) {
                        if ($email == $email2){
                            if (validar_cnpj($cnpj) == 1){
                                $sqllog = mysqli_query($mysqli, "select CNPJ from USUARIO");
                                while ($dadlog = mysqli_fetch_object($sqllog)) {
                                    if ($cnpj == $dadlog->CNPJ) {
                                        $log = 8;
                                        break;
                                    } else {
                                        $sqlBuscaUF = mysqli_query($mysqli, "select ID from ESTADO where UF = '".$estado."'");
                                        if ($buscaUF = mysqli_fetch_object($sqlBuscaUF))
                                            $idUF = $buscaUF->ID;

                                        $sqlBuscaCidade = mysqli_query($mysqli, "select ID from CIDADE where REFESTADO = ".$idUF." and NOME = '".$cidade."'");
                                        if ($buscaCidade = mysqli_fetch_object($sqlBuscaCidade))
                                            $idCidade = $buscaCidade->ID;
                                        $insereUsuario = mysqli_query($mysqli, "insert into USUARIO (CNPJ, NOME, EMAIL, RUA, BAIRRO, NUMERO, CEP, LOGRADOURO, REFCIDADE, CICLOS, REFDURACAO)"
                                                                              ." values ('".$cnpj."', '".$nome."', '".$email."', '".$rua."', '".$bairro."', ".$numero.", '".$cep."', '".$logradouro."',".$idCidade.""
                                                                              .", ".$_POST['ciclos2'].", ".$_POST['tipoPlano2'].")");

                                        $codigo = md5('FrU'.$cnpj.'ViS');

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'br278.hostgator.com.br';
    $mail->SMTPAuth = true;
    $mail->Username = 'naoresponda@toptech.solutions';
    $mail->Password = 'k.Kp5TPLS!Nv';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->setFrom('naoresponda@toptech.solutions', utf8_decode('TopTech Não Responda'));
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = utf8_decode('Verifique seu endereço de e-mail');
    $mail->Body = utf8_decode('
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title></title>
    </head>
    <body style="color:#333; font-family:Helvetica, Arial, sans-serif; margin:0; padding:0; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; width:100%" width="100%">
        <table cellpadding="0" cellspacing="0" border="0" id="background-table"
        style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;
        background:#eaeff2; line-height:100%; margin:0; padding:0; width:100%" width="100%">
            <tr>
            <td style="border-collapse:collapse">
                <table cellpadding="0" cellspacing="0" border="0" align="center" id="main" style="border-collapse:collapse;
                mso-table-lspace:0pt; mso-table-rspace:0pt; width:500px" width="500">
                    <thead>
                        <tr>
                            <th style="font-size:15px; padding:32px 16px; text-align:left" align="left"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <td style="border-collapse:collapse; background:#fff; padding:30px">
                            <p style="margin:1em 0">Olá,</p>
                            <p style="margin:1em 0">Obrigado pelo seu cadastro! Para completar o registro, você precisa confirmar o e-mail.</p>
                            <p style="margin:1em 0">
                                <a href="https://toptech.solutions/index.php?pag=confirmaEmail&link='.$codigo.'" style="background:#81bc2f; border-radius:6px; -moz-border-radius:6px;
                                -webkit-border-radius:6px; border-bottom:2px solid #548323; color:#fff; display:block; font-size:17px; font-weight:bold;
                                height:42px; line-height:42px; padding:0 30px; text-align:center; text-decoration:none; text-shadow:1px 1px 0 #426319" align="center" height="42">
                                Clique aqui para verificar o seu e-mail</a>
                            </p>
                            <p style="margin:1em 0">
                                Se o link acima não funcionar, clique aqui:<br>
                            <a href="https://toptech.solutions/index.php?pag=confirmaEmail&link='.$codigo.'" style="color:#0095dd; text-decoration:none">
                                https://toptech.solutions/index.php?pag=confirmaEmail&link='.$codigo.'</a>
                            </p>
                            <p style="margin:1em 0">Depois de clicar no link, você pode apagar este e-mail.</p>

                            <p style="margin:1em 0">
                                Obrigado,
                                <br>A equipe TopTech
                            </p>
                        </td>
                        </tr>
                    </tbody>
                <tfoot>
                    <tr>
                    <td style="border-collapse:collapse; font-size:13px; padding:16px 30px 32px 30px"></td>
                    </tr>
                </tfoot>
                </table>
            </td>
            </tr>
        </table>
    </body>
</html>');
    $mail->send(); 
    $log = 9;
} catch (Exception $e) {
    $log = 10;
    echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
                                        }
                                    }
                                } else $log = 7;
                            } else $log = 6;
                        } else $log = 5;  
                    } else $log = 4;
                } else $log = 3;
            } else $log = 2;
        } else $log = 1;
    }
?>
        <div class="register-box">
                <div class="register-box-body">
                    <?php
                    if ($log == 1) {
                        echo '<div class="alert alert-error alert-dismissable">'
                           . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'
                           . '<h4><i class="icon fa fa-ban"></i> Cadastro!</h4>Campos obrigatórios estão em branco</div>';
                    } else if ($log == 2) {
                        echo '<div class="alert alert-error alert-dismissable">'
                           . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'
                           . '<h4><i class="icon fa fa-ban"></i> Cadastro!</h4>A rua não pode ter mais de 100 caracteres</div>';
                    } else if ($log == 3) {
                        echo '<div class="alert alert-error alert-dismissable">'
                           . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'
                           . '<h4><i class="icon fa fa-ban"></i> Cadastro!</h4>O bairro não pode ter mais de 60 caracteres</div>';
                    } else if ($log == 4) {
                        echo '<div class="alert alert-error alert-dismissable">'
                           . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'
                           . '<h4><i class="icon fa fa-ban"></i> Cadastro!</h4>O logradouro não pode ter mais de 100 caracteres</div>';
                    } else if ($log == 5) {
                        echo '<div class="alert alert-error alert-dismissable">'
                           . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'
                           . '<h4><i class="icon fa fa-ban"></i> Cadastro!</h4>O E-Mail não pode ter mais de 60 caracteres</div>';
                    } else if ($log == 6) {
                        echo '<div class="alert alert-error alert-dismissable">'
                           . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'
                           . '<h4><i class="icon fa fa-ban"></i> Cadastro!</h4>Os E-Mails não conferem</div>';
                    } else if ($log == 7) {
                        echo '<div class="alert alert-error alert-dismissable">'
                           . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'
                           . '<h4><i class="icon fa fa-ban"></i> Cadastro!</h4>CNPJ informado não é valido</div>';
                    } else if ($log == 8) {
                        echo '<div class="alert alert-error alert-dismissable">'
                           . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'
                           . '<h4><i class="icon fa fa-ban"></i> Cadastro!</h4>CNPJ já cadastrado</div>';
                    } else if ($log == 9) {
                        echo '<div class="register-box-body"><div class="alert alert-success alert-dismissable bg-green-gradient">'
                           . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'
                           . '<h1><i class="icon fa fa-check-square-o"></i>Cadastro feito com sucesso</h1><h3>Para finalizar o processo acesse '
                           . 'o seu e-mail e clique no link.<BR>Obs:. O e-mail pode estar na caixa de spam.</h3></div></div>';
                    } else if ($log == 10) {
                        echo '<div class="alert alert-error alert-dismissable">'
                           . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'
                           . '<h4><i class="icon fa fa-ban"></i> Cadastro!</h4>Erro ao enviar o e-mail.</div>';
                           }?>
                    <p class="login-box-msg"><h2 class="text-center text-orange" style="margin-bottom: 1.2em; margin-top: -0.8em">Registrar um novo usuário</h2></p>
                    <form id="formCadastro" name="Cadastro" method="post" enctype="multipart/form-data">
                        <div class="form-group has-feedback">
                            <input name="cnpj" type="text" id="cnpj" class="form-control" value="" size="17" maxlength="14" placeholder="CNPJ" data-mask="99.999.999/9999-99" required/>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <input name="nomeE" type="text" id="nomeE" class="form-control" size="50" maxlength="40" placeholder="Nome da empresa" required/>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <input name="email" type="text" id="email" class="form-control" size="70" maxlength="60" placeholder="E-Mail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"/>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <input name="email2" type="text" id="email2" class="form-control" size="70" maxlength="60" placeholder="Confirmar E-Mail"/>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <input name="cep" type="text" id="cep" class="form-control" value="" size="10" maxlength="9" placeholder="CEP" data-mask="99999-999"
                                onblur="pesquisacep(this.value);" required/>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <input name="rua" type="text" id="rua" class="form-control" size="50" maxlength="40" placeholder="Rua" required/>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <input name="numero" type="number" id="numero" class="form-control"  placeholder="Número" required/>
                            <span class="fa fa-map-pin form-control-feedback"></span>
                        </div>  
                        <div class="form-group has-feedback">
                            <input name="bairro" type="text" id="bairro" class="form-control" size="50" maxlength="40" placeholder="Bairro" required/>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <input name="logradouro" type="text" id="logradouro" class="form-control" size="50" maxlength="40" placeholder="Logradouro"/>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <input name="cidade" type="text" id="cidade" class="form-control" size="40" placeholder="Cidade"/>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <input name="estado" type="text" id="estado" class="form-control" size="5" placeholder="Estado"/>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                        <input type="hidden" name="tipoPlano2" value="<?php echo $_REQUEST['plano']; ?>">
                        <input type="hidden" name="ciclos2" value="<?php echo $_REQUEST['ciclos']; ?>">

                        <div class="row">
                            <!-- /.col -->
                            <div class="col-xs-12">
                                <button type="submit" name="salvaCadastro" class="btn btn-primary btn-block btn-flat">Cadastrar</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>
                <!-- /.form-box -->
            </div>

<script>
    function limpa_formulário_cep() {
        //Limpa valores do formulário de cep.
        document.getElementById('cep').value=("");
        document.getElementById('cidade').value=("");
        document.getElementById('estado').value=("");
        }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('cidade').value=(conteudo.localidade);
            document.getElementById('estado').value=(conteudo.uf);
            } //end if.
        else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            alert("CEP não encontrado.");
            }
        }
        
    function pesquisacep(valor) {
        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');
        //Verifica se campo cep possui valor informado.
        if (cep != "") {
            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;
            //Valida o formato do CEP.
            if(validacep.test(cep)) {
                //Preenche os campos com "..." enquanto consulta webservice.
                document.getElementById('cidade').value="...";
                document.getElementById('estado').value="...";
                //Cria um elemento javascript.
                var script = document.createElement('script');
                //Sincroniza com o callback.
                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';
                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);
                } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
                }
            } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
            }
        };
        
    function validaEmail(){ 
        email = document.getElementById('email').value;
        email2 = document.getElementById('email2').value;
        if (email != email2){
            alert("Os E-Mails não conferem");
            return false;
            }
        }
</script>
<!-- Bootstrap 3.3.5 -->
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="dist/css/font-awesome.min.css">
<link rel="stylesheet" href="dist/css/font-awesome.css">
<!-- Ionicons -->
<link rel="stylesheet" href="dist/css/ionicons.min.css">
<link rel="stylesheet" href="dist/css/ionicons.css">
<!-- Theme style -->
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">

<script src="bootstrap/js/jasny-bootstrap.min.js"></script>