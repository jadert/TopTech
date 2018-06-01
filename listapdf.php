<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Lista de passageiros</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Lista de passageiros</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="col-md-push-12" >
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-angle-double-right"></i> Lista de passageiros</h3>
                    <h2 class="box box-warning text-center text-black">Lista de passageiros</h2>
                    <div class="box-body">
<?php
$cidade = isset($_GET['id']) ? (int) $_GET['id'] : false;

date_default_timezone_set('America/Sao_Paulo');

$pesquisa = mysqli_query($mysqli, "SELECT USUARIO.NOME as USUARIO,USUARIO.RG, USUARIO.CPF, "
                                . "SEGUNDAIDA, SEGUNDAVOLTA, TERCAIDA, TERCAVOLTA, QUARTAIDA, "
                                . "QUARTAVOLTA, QUINTAIDA, QUINTAVOLTA, SEXTAIDA, SEXTAVOLTA, "
                                . "INSTITUICAO.NOME AS INSTITUICAO, CIDADE.NOME AS CIDADE FROM CADASTRO "
                                . "INNER JOIN USUARIO ON USUARIO.ID = CADASTRO.REFUSUARIO "
                                . "INNER JOIN INSTITUICAO ON CADASTRO.REFINSTITUICAO = INSTITUICAO.ID "
                                . "INNER JOIN CIDADE ON CIDADE.ID = INSTITUICAO.REFCIDADE "
                                . "WHERE INSTITUICAO.REFCIDADE = {$cidade} AND "
                                . "USUARIO.ID <> 33 AND CADASTRO.ATIVO = 1 ORDER BY USUARIO.NOME");

$html = '<table class="table table-bordered table-responsive">
                            <tr class="bg-teal-active">
                                <th class="text-center">#</th>
                                <th class="text-center">Usuário</th>
                                <th class="text-center">RG</th>
                                <th class="text-center">Instituição</th>
                                <th class="text-center">Cidade</th>
                                <th class="text-center" colspan="2">Segunda-Feira</th>
                                <th class="text-center" colspan="2">Terça-Feira</th>
                                <th class="text-center" colspan="2">Quarta-Feira</th>
                                <th class="text-center" colspan="2">Quinta-Feira</th>
                                <th class="text-center" colspan="2">Sexta-Feira</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th class="text-center bg-olive-active">Ida</th>
                                <th class="text-center bg-olive-active">Volta</th>
                                <th class="text-center bg-olive-active">Ida</th>
                                <th class="text-center bg-olive-active">Volta</th>
                                <th class="text-center bg-olive-active">Ida</th>
                                <th class="text-center bg-olive-active">Volta</th>
                                <th class="text-center bg-olive-active">Ida</th>
                                <th class="text-center bg-olive-active">Volta</th>
                                <th class="text-center bg-olive-active">Ida</th>
                                <th class="text-center bg-olive-active">Volta</th>
                            </tr>
                            <?php
                            $i = 0;
                            while ($dap = mysqli_fetch_object($pesquisa)) {
                                $i = $i +1;
                                ?>
                                <tr style="border-style: solid; border-color: #cfcfcf;">
                                    <td class="text-left"><?php echo $i; ?></td>
                                    <td class="text-left"><?php echo $dap->USUARIO; ?></td>
                                    <td class="text-center"><?php echo $dap->RG; ?></td>
                                    <td class="text-center"><?php echo $dap->INSTITUICAO; ?></td>
                                    <td class="text-center"><?php echo $dap->CIDADE; ?></td>                            
                                    <td class="text-center"><?php if ($dap->SEGUNDAIDA == 1) echo "<i class="fa fa-check text-red"></i>"; ?></td>
                                    <td class="text-center"><?php if ($dap->SEGUNDAVOLTA == 1) echo "<i class="fa fa-check text-red"></i>"; ?></td>
                                    <td class="text-center"><?php if ($dap->TERCAIDA == 1) echo "<i class="fa fa-check text-red"></i>"; ?></td>
                                    <td class="text-center"><?php if ($dap->TERCAVOLTA == 1) echo "<i class="fa fa-check text-red"></i>"; ?></td>
                                    <td class="text-center"><?php if ($dap->QUARTAIDA == 1) echo "<i class="fa fa-check text-red"></i>"; ?></td>
                                    <td class="text-center"><?php if ($dap->QUARTAVOLTA == 1) echo "<i class="fa fa-check text-red"></i>"; ?></td>
                                    <td class="text-center"><?php if ($dap->QUINTAIDA == 1) echo "<i class="fa fa-check text-red"></i>"; ?></td>
                                    <td class="text-center"><?php if ($dap->QUINTAVOLTA == 1) echo "<i class="fa fa-check text-red"></i>"; ?></td>
                                    <td class="text-center"><?php if ($dap->SEXTAIDA == 1) echo "<i class="fa fa-check text-red"></i>"; ?></td>
                                    <td class="text-center"><?php if ($dap->SEXTAVOLTA == 1) echo "<i class="fa fa-check text-red"></i>"; ?></td>
                                </tr>

                                <?php
                            }
                        }
                        ?> 
                    </table>';

mysql_free_result($pesquisa);

//Aqui nós chamamos a class do dompdf
require_once 'dompdf/autoload.inc.php';

//É fundamental definir o TIMEZONE de nossa região para que não tenhamos problemas com a geração.
date_default_timezone_set('America/Sao_Paulo');

//Aqui eu estou decodificando o tipo de charset do documento, para evitar erros nos acentos das letras e etc.
$html = utf8_decode($html);

//Instanciamos a class do dompdf para o processo
$dompdf = new DOMPDF();

//Aqui nós damos um LOAD (carregamos) todos os nossos dados e formatações para geração do PDF
$dompdf->load_html($html);

//Aqui nós damos início ao processo de exportação (renderizar)
$dompdf->render();

//por final forçamos o download do documento, coloquei a nomenclatura com a data e mais um string no final.
$dompdf->stream(date('d/m/Y').'_ListaPassageiros.pdf');
?>
          </div>
                    </div>
                </div>
            </div>
    </section>
    </div>