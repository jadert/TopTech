<?php
if ($_REQUEST["acao"] == "importar") {
    session_start();

    date_default_timezone_set('America/Sao_Paulo');

    $arquivo = $_FILES['arquivo'];
    $nomes = $_FILES['arquivo']['name'];
    $nomes = explode('.', $nomes);

    $ponteiro = fopen($arquivo['tmp_name'], 'r');

    $vetor = array();
    while (!feof($ponteiro)) {
        $log = 0;
        $linha = fgets($ponteiro, 4096);
        $vetor["registro"] = substr($linha, 0, 1);
        $vetor["identificacao"] = substr($linha, 1, 1);

        if (($vetor["registro"] == 0) and ( $vetor["identificacao"] == 2)) {
            $vetor["literal"] = substr($linha, 2, 7);
            $vetor["cod_servico"] = substr($linha, 9, 2);
            $vetor["tipo_servico"] = substr($linha, 11, 15);
            $vetor["complemento1"] = substr($linha, 19, 7);
            $vetor["cod_benef"] = substr($linha, 26, 5);
            $vetor["cgc"] = substr($linha, 31, 14);
            $vetor["sicredi"] = substr($linha, 76, 3);
            $vetor["dv_conta _cedente"] = substr($linha, 79, 15);
            $vetor["data_grav"] = substr($linha, 94, 8);
            $vetor["nmr_retorno"] = substr($linha, 110, 7);
            $vetor["versao_sis"] = substr($linha, 389, 5);
            $vetor["sequencial_reg"] = substr($linha, 394, 6);

            $vetor["data_grav"] = substr($vetor["data_grav"], 0, 4) . '-' . substr($vetor["data_grav"], 4, 2) . '-' . substr($vetor["data_grav"], 6, 2);
            $rtno = mysqli_query($mysqli, "SELECT ID, DATA, NOME FROM RETORNOARQUVO");

            $nomes[0] = trim($nomes[0]);
            while ($retor = mysqli_fetch_object($rtno)) {
                if (($retor->NOME == $nomes[0]) and ( $retor->DATA == $vetor["data_grav"])) {
                    $log = 1;
                    //echo $nomes[0], ' == ', $retor->NOME;                    
                    //echo ' Data ',$retor->DATA ,' == ', $vetor["data_grav"];
                    break;
                    break;
                }
            }
            if ($log == 0) {
                $retarq = mysqli_query($mysqli, "INSERT INTO RETORNOARQUVO(DATA, NOME) VALUES ('{$vetor["data_grav"]}', '{$nomes[0]}')");
            } else {
                break;
            }
            //echo '<br> Log: ', $log;
        } else if ($vetor["registro"] == 1) {
            $vetor["cod_pagador"] = substr($linha, 14, 5);
            $vetor["nossonumero"] = substr($linha, 47, 15);
            $vetor["ocorrencia"] = substr($linha, 108, 2);
            $vetor["dataocor"] = substr($linha, 110, 6);
            $vetor["seunumero"] = substr($linha, 116, 10);
            $vetor["datavencimento"] = substr($linha, 146, 6);
            $vetor["valortitulo"] = substr($linha, 152, 13);
            $vetor["especiedoc"] = substr($linha, 174, 1);
            $vetor["despcobranca"] = substr($linha, 175, 13);
            $vetor["despprotesto"] = substr($linha, 188, 13);
            $vetor["abatimento"] = substr($linha, 227, 13);
            $vetor["desconto"] = substr($linha, 240, 13);
            $vetor["valorpago"] = substr($linha, 253, 13);
            $vetor["jurosmora"] = substr($linha, 266, 13);
            $vetor["multa"] = substr($linha, 279, 13);
            $vetor["ocorrencia19"] = substr($linha, 294, 1);
            $vetor["motivoocor"] = substr($linha, 318, 10);
            $vetor["datalancconta"] = substr($linha, 328, 8);
            $vetor["sequencial"] = substr($linha, 394, 6);

            /* echo 'cod_pagador -> ', $vetor["cod_pagador"], '<br>' ;
              echo 'nossonumero -> ', $vetor["nossonumero"], '<br>' ;
              echo 'ocorrencia -> ', $vetor["ocorrencia"], '<br>' ;
              echo 'dataocor -> ', $vetor["dataocor"], '<br>' ;
              echo 'seunumero -> ', $vetor["seunumero"], '<br>' ;
              echo 'datavencimento -> ', $vetor["datavencimento"], '<br>' ;
              echo 'valortitulo -> ', $vetor["valortitulo"], '<br>' ;
              echo 'especiedoc -> ', $vetor["especiedoc"], '<br>' ;
              echo 'despcobranca -> ', $vetor["despcobranca"], '<br>' ;
              echo 'despprotesto -> ', $vetor["despprotesto"], '<br>' ;
              echo 'abatimento -> ', $vetor["abatimento"], '<br>' ;
              echo 'desconto -> ', $vetor["desconto"], '<br>' ;
              echo 'valorpago -> ', $vetor["valorpago"], '<br>' ;
              echo 'jurosmora -> ', $vetor["jurosmora"], '<br>' ;
              echo 'multa -> ', $vetor["multa"], '<br>' ;
              echo 'ocorrencia19 -> ', $vetor["ocorrencia19"], '<br>' ;
              echo 'motivoocor -> ', $vetor["motivoocor"], '<br>' ;
              echo 'datalancconta -> ', $vetor["datalancconta"], '<br>' ;
              echo 'sequencial -> ', $vetor["sequencial"], '<br>' ;
             */
            $data = date("Y-m-d");
            $hora = date("H:i:s");
            $dtocr1 = substr($vetor["dataocor"], 0, 2);
            $dtocr2 = substr($vetor["dataocor"], 2, 2);
            $dtocr3 = substr($vetor["dataocor"], 4, 2);
            $vetor["dataocor"] = '20' . $dtocr3 . '-' . $dtocr2 . '-' . $dtocr1;
            $vetor["valortitulo"] = substr($vetor["valortitulo"], 0, 11) . '.' . substr($vetor["valortitulo"], 10, 2);
            $vetor["despcobranca"] = substr($vetor["despcobranca"], 0, 11) . '.' . substr($vetor["despcobranca"], 10, 2);
            $vetor["despprotesto"] = substr($vetor["despprotesto"], 0, 11) . '.' . substr($vetor["despprotesto"], 10, 2);
            $vetor["abatimento"] = substr($vetor["abatimento"], 0, 11) . '.' . substr($vetor["abatimento"], 10, 2);
            $vetor["desconto"] = substr($vetor["desconto"], 0, 11) . '.' . substr($vetor["desconto"], 10, 2);
            $vetor["valorpago"] = substr($vetor["valorpago"], 0, 11) . '.' . substr($vetor["valorpago"], 11, 2);
            $vetor["jurosmora"] = substr($vetor["jurosmora"], 0, 11) . '.' . substr($vetor["jurosmora"], 10, 2);
            $vetor["multa"] = substr($vetor["multa"], 0, 11) . '.' . substr($vetor["multa"], 10, 2);
            $motivos = array();
            $motivos["1"] = substr($vetor["motivoocor"], 0, 2);
            $motivos["2"] = substr($vetor["motivoocor"], 2, 2);
            $motivos["3"] = substr($vetor["motivoocor"], 4, 2);
            $motivos["4"] = substr($vetor["motivoocor"], 6, 2);
            $motivos["5"] = substr($vetor["motivoocor"], 8, 2);

            $vetor["nossonumero"] = trim($vetor["nossonumero"]);
            $dados = mysqli_query($mysqli, "SELECT BOLETO.ID, VALOR, EMISSAO, VENCIMENTO, STATUS, SEQUENCIAL, SEUNUMERO, REFUSUARIO, REFREMESSA, NOSSONUMERO FROM BOLETO WHERE NOSSONUMERO = '{$vetor["nossonumero"]}'");
            $daBol = mysqli_fetch_object($dados);

            $maxarq = mysqli_query($mysqli, "SELECT MAX(ID) as MAX FROM RETORNOARQUVO");
            $idarq = mysqli_fetch_object($maxarq);

            if ($daBol->REFUSUARIO == NULL) {
                $idusr = 0;
            } else {
                $idusr = $daBol->REFUSUARIO;
                }
            if ($daBol->ID == NULL) {
                $idblt = 0;
            } else {
                $idblt = $daBol->ID;
                }
            $vetor["nossonumero"] = trim($vetor["nossonumero"]);

            $sqlu = mysqli_query($mysqli, "INSERT INTO RETORNO(DATA, HORA, RESPONSAVEL, USUARIO, BOLETO, OCORRENCIA,  DATAOCORRENCIA, DESPCOBRANCA, DESPPROTESTO, ABATIMENTO, DESCONTO, VALORPAGO, JUROSMORA, MULTA, NOSSONUMERO, RETORNOARQUVO) "
                    . "VALUES ('{$data}','{$hora}',{$_SESSION["idUS"]}, {$idusr},{$idblt},'{$vetor["ocorrencia"]}','{$vetor["dataocor"]}','{$vetor["despcobranca"]}','{$vetor["despprotesto"]}','{$vetor["abatimento"]}','{$vetor["desconto"]}','{$vetor["valorpago"]}','{$vetor["jurosmora"]}','{$vetor["multa"]}', '{$vetor["nossonumero"]}','{$idarq->MAX}')");
            if (!$sqlu) {
                die('Invalid query: ' . mysqli_error());
                }

            $xz = 0;
            for ($i = 1; $i < 6; $i++) {
                $max = mysqli_query($mysqli, "SELECT MAX(ID) as MAX FROM RETORNO");
                $idret = mysqli_fetch_object($max);
                if ($motivos[$i] == '00') {
                    $xz = $xz + 1;
                    if ($xz == 1) {
                        $sqlmot = mysqli_query($mysqli, "INSERT INTO MOTIVOOCORENCIA ( RETORNO, MOTIVO) VALUES ('{$idret->MAX}','{$motivos[$i]}')");
                    }
                } else {
                    $sqlmot = mysqli_query($mysqli, "INSERT INTO MOTIVOOCORENCIA ( RETORNO, MOTIVO) VALUES ('{$idret->MAX}','{$motivos[$i]}')");
                    }
                }

            if ((trim($daBol->NOSSONUMERO)) == (trim($vetor["nossonumero"]))) {
                //echo ' OCR ', $vetor["ocorrencia"], '<br>';
                if (($vetor["ocorrencia"] == '06') or ( $vetor["ocorrencia"] == '15') or ( $vetor["ocorrencia"] == '17')) {
                    if (($vetor["ocorrencia"] == '06') or ( $vetor["ocorrencia"] == '15') or ( $vetor["ocorrencia"] == '17')) {
                        $blt = mysqli_query($mysqli, "UPDATE BOLETO SET STATUS = 3 WHERE NOSSONUMERO = '{$vetor["nossonumero"]}'");

                        $sqlBoleto = mysqli_query($mysqli, "SELECT CAMINHO FROM BOLETO WHERE ID = {$idblt}");
                        if ($buscaBoleto = mysqli_fetch_object($sqlBoleto)) {
                            unlink("boletos/" . $buscaBoleto->CAMINHO . ".pdf");
                            }

                        if ($daBol->ID == NULL) {
                            $idblt = 0;
                        } else {
                            $idblt = $daBol->ID;
                            }
                        $entrsaida = mysqli_query($mysqli, "INSERT INTO ENTRADASAIDA(VALOR, DATA, TIPO, REFBOLETO, REFCATEGORIA, DESCRICAO)"
                                . "VALUES ('{$vetor["valorpago"]}','{$vetor["dataocor"]}','E','{$idblt}','1','Boleto pago')");
                    }
                } else if ($vetor["ocorrencia"] == '14') {
                    $blt = mysqli_query($mysqli, "UPDATE BOLETO SET VENCIMENTO = '{$vetor["datavencimento"]}' WHERE NOSSONUMERO = '{$vetor["nossonumero"]}'");
                } else if ((($vetor["ocorrencia"] == '19') and ( $motivos["1"] == 'A0')) or ( ($vetor["ocorrencia"] == '19') and ( $motivos["1"] == '0A')) or ( ($vetor["ocorrencia"] == '19') and ( $motivos["1"] == '00'))) {
                    $blt = mysqli_query($mysqli, "UPDATE BOLETO SET STATUS = 6 WHERE NOSSONUMERO = '{$vetor["nossonumero"]}'");
                } else if ($vetor["ocorrencia"] == '20') {
                    $blt = mysqli_query($mysqli, "UPDATE BOLETO SET STATUS = 6 WHERE NOSSONUMERO = '{$vetor["nossonumero"]}'");
                } else if ($vetor["ocorrencia"] == '23') {
                    $blt = mysqli_query($mysqli, "UPDATE BOLETO SET STATUS = 6 WHERE NOSSONUMERO = '{$vetor["nossonumero"]}'");
                } else if ($vetor["ocorrencia"] == '28') {
                    if ($daBol->ID == NULL) {
                        $idblt = 0;
                    } else {
                        $idblt = $daBol->ID;
                    }
                    $entrsaida = mysqli_query($mysqli, "INSERT INTO ENTRADASAIDA(VALOR, DATA, TIPO, REFBOLETO, REFCATEGORIA, DESCRICAO) "
                            . "VALUES ('{$vetor["valorpago"]}','{$vetor["dataocor"]}','S','{$idblt}','1','Tarifa de operação com boleto')");
                } else if (($vetor["ocorrencia"] == '09') or ( $vetor["ocorrencia"] == '10')) {
                    $blt = mysqli_query($mysqli, "UPDATE BOLETO SET STATUS = 5 WHERE NOSSONUMERO = '{$vetor["nossonumero"]}'");
                }
            } else {
                if (($vetor["ocorrencia"] == '06') or ( $vetor["ocorrencia"] == '09') or ( $vetor["ocorrencia"] == '10') or ( $vetor["ocorrencia"] == '15') or ( $vetor["ocorrencia"] == '17')) {
                    if (($vetor["ocorrencia"] == '06') or ( $vetor["ocorrencia"] == '15') or ( $vetor["ocorrencia"] == '17')) {
                        if ($daBol->ID == NULL) {
                            $idblt = 0;
                            $entrsaida = mysqli_query($mysqli, "INSERT INTO ENTRADASAIDA(VALOR, DATA, TIPO, REFBOLETO, REFCATEGORIA, DESCRICAO)"
                                    . "VALUES ('{$vetor["valorpago"]}','{$vetor["dataocor"]}','E','{$idblt}','1','Boleto pago')");
                        } else {
                            $idblt = $daBol->ID;
                        }
                    }
                } else if ($vetor["ocorrencia"] == '28') {
                    if ($daBol->ID == NULL) {
                        $idblt = 0;
                        $entrsaida = mysqli_query($mysqli, "INSERT INTO ENTRADASAIDA(VALOR, DATA, TIPO, REFBOLETO, REFCATEGORIA, DESCRICAO) "
                                . "VALUES ('{$vetor["valorpago"]}','{$vetor["dataocor"]}','S','{$idblt}','1','Tarifa de operação com boleto')");
                    } else {
                        $idblt = $daBol->ID;
                    }
                }
            }
        }
    }
    //print_r(array_values($vetor));
    fclose($ponteiro);
    if ($log == 0) { ?>
        <script language=javascript>
            location.href = 'index.php?p=RelRetorno';
        </script>
        <?php
    }
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Importar retorno</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Importar retorno</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="col-md-push-12" >
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-angle-double-right"></i> Importar retorno</h3>
                    <h2 class="box box-warning text-center text-black">Importar arquivo de retorno Sicredi</h2>
                    <div class="box-body">
                        <?php
                        if (!isset($log)) {
                        }
                        else if (@$log == 1) {
                                echo '<div class="alert alert-error alert-dismissable"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <h4><i class="icon fa fa-ban"></i> Importar retorno!</h4><strong>Arquivo retorno já importado</strong></div>';
                            } ?>
                        <form action="index.php?p=retorno" method="post" enctype="multipart/form-data" style="width: 80%; margin-left: auto; margin-right: auto">
                            <div class="form-group has-feedback">
                                <label>Arquivo</label>
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                    <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Selecionar arquivo</span><span class="fileinput-exists">Alterar</span>
                                        <input name="arquivo" accept=".CRT" type="file" required></span>
                                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remover</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-2">
                                    <button type="submit" class="btn btn-primary btn-block btn-flat">Importar</button>
                                    <input type="hidden" name="acao" value="importar" />
                                </div><!-- /.col -->
                            </div>
                        </form>
                    </div>
                </div><!-- /.box -->
            </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->