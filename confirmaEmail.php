<?php
if ($_SESSION["Emitidos"] == 'S') {
    echo '<div class="register-box-body"><div class="alert alert-success alert-dismissable bg-green-gradient">'
    . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'
    . '<h1><i class="icon fa fa-check-square-o"></i>E-mail confirmado</h1><h3>A sua conta esta pronta, '
    . 'Em breve você receberá um e-mail avisando que os boletos estão disponiveis. '
    . 'Para acessar os boletos entre no sistema TopTech utilizando o certificado correspodente ao CNPJ cadastrado.</h3></div></div>';
    $_SESSION["Emitidos"] = '';
} else {
    include './conecta.php';
    $codigo = trim(filter_input(INPUT_GET, 'link'));

    $sql = mysqli_query($mysqli, "select ID, CNPJ, EMAIL from USUARIO");
    while ($dado = mysqli_fetch_object($sql)) {
        if ($codigo == md5('FrU' . $dado->CNPJ . 'ViS')) {
                $editaEmail = mysqli_query($mysqli, "update USUARIO set STATUS = 1 where ID = '" . $dado->ID . "'");

                $sqlPlano = mysqli_query($mysqli, "select USUARIO.ID, CICLOS, VALOR from USUARIO, DURACAO where DURACAO.ID = REFDURACAO and CNPJ = '" . $dado->CNPJ . "'");

                if ($buscaPlano = mysqli_fetch_object($sqlPlano)) {
                    $dataInicial = date_create('' . date('Y') . '-' . date('m') . '-' . date('d') . '');
                    date_add($dataInicial, date_interval_create_from_date_string('15 days'));
                    $_SESSION["CNPJ"] = $dado->CNPJ;
                    $_SESSION["idUsr"] = $buscaPlano->ID;
                    $_SESSION["Ciclos"] = $buscaPlano->CICLOS;
                    $_SESSION["Valor"] = $buscaPlano->VALOR;
                    $_SESSION["Vencimento"] = $dataInicial;

                    while (strlen($_SESSION["idUsr"].'') < 6) {
                        $_SESSION["idUsr"] = "0" . $_SESSION["idUsr"];
                        }
                    echo '<script type="text/javascript"> location.href="index.php?pag=boletoUsuario"; </script>';  
            }
            break;
        }
    }
}