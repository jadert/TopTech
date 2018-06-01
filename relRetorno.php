<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Relatório de retorno</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="index.php?p=retorno">Importar retorno</a></li>
            <li class="active">Relatório de retorno</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="col-md-push-12" >
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-angle-double-right"></i> Relatório de retorno</h3>
                    <h2 class="box box-warning text-center text-black">Relatório de retorno</h2>
                    <?php
                    // definir o numero de itens por pagina
                    $itens_por_pagina = 10;

                    // pegar a pagina atual
                    $pagina = intval($_GET['pg']);
                    $limit = $pagina * 10;

                    $maxarq = mysqli_query($mysqli, "SELECT MAX(RETORNOARQUVO) AS MAX FROM RETORNO");
                    $idarq = mysqli_fetch_object($maxarq);
                    $soma1 = mysqli_query($mysqli, "SELECT SUM(VALORPAGO) AS PAGO, SUM(DESPCOBRANCA) AS COBRANCA, SUM(DESPPROTESTO) AS PROTESTO FROM RETORNO WHERE RETORNOARQUVO = {$idarq->MAX}");
                    $soma = mysqli_fetch_object($soma1);
                    $vlpg = mysqli_query($mysqli, "SELECT SUM(VALORPAGO) AS PAGO FROM RETORNO WHERE RETORNOARQUVO = {$idarq->MAX} AND OCORRENCIA <> 28");
                    $vlrpago = mysqli_fetch_object($vlpg);

                    // puxar produtos do banco
                    $sql_code = "SELECT USUARIO.NOME, RETORNO.ID, RETORNO.DATA, RETORNO.HORA, RETORNO.RESPONSAVEL, RETORNO.USUARIO, RETORNO.BOLETO, RETORNO.OCORRENCIA, RETORNO.DATAOCORRENCIA, RETORNO.DESPCOBRANCA, RETORNO.DESPPROTESTO, RETORNO.ABATIMENTO, RETORNO.DESCONTO, RETORNO.VALORPAGO, RETORNO.JUROSMORA, RETORNO.MULTA, RETORNO.NOSSONUMERO, RETORNO.RETORNOARQUVO FROM RETORNO INNER JOIN MOTIVOOCORENCIA ON RETORNO.ID = MOTIVOOCORENCIA.RETORNO INNER JOIN USUARIO ON USUARIO.ID = RETORNO.USUARIO INNER JOIN OCORRENCIA ON OCORRENCIA.COD = RETORNO.OCORRENCIA "
                            . "WHERE RETORNO.RETORNOARQUVO = {$idarq->MAX} ORDER BY USUARIO.NOME LIMIT $limit, $itens_por_pagina";
                    $execute = $mysqli->query($sql_code) or die($mysqli->error);
                    $produto = $execute->fetch_assoc();
                    $num = $execute->num_rows;

                    // pega a quantidade total de objetos no banco de dados
                    $num_total = $mysqli->query("SELECT RETORNO.ID FROM RETORNO WHERE RETORNO.RETORNOARQUVO = {$idarq->MAX}")->num_rows;

                    // definir numero de pÃ¡ginas
                    $num_paginas = ceil($num_total / $itens_por_pagina);
                    ?>
                    <div class="box-body">
                        <table class="table table-condensed table-responsive" style="width: 80%; margin-left: auto;margin-right: auto;" >
                            <tr>
                                <th>ID</th>
                                <th>Usuário</th>
                                <th>Data Retorno</th>
                                <th>Hora</th>
                                <th>Boleto</th>
                                <th>Despesas protesto</th>
                                <th>Despesas cobrança</th>
                                <th>Desconto</th>
                                <th>Juros mora</th>
                                <th>Multa</th>
                                <th>Valor pago</th>
                                <th>Nosso número</th>
                            </tr>
                            <?php
                            do { ?>
                                <tr>                                           
                                    <td><?php echo $produto['ID']; ?></td>
                                    <td><?php echo $produto['NOME']; ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($produto['DATA']));; ?></td>                                     
                                    <td><?php echo $produto['HORA']; ?></td>                                     
                                    <td><?php echo $produto['BOLETO']; ?></td>                                     
                                    <td><?php echo $produto['DESPPROTESTO']; ?></td>                                     
                                    <td><?php echo $produto['DESPCOBRANCA']; ?></td>                                     
                                    <td><?php echo $produto['DESCONTO']; ?></td>                                     
                                    <td><?php echo $produto['JUROSMORA']; ?></td>                                     
                                    <td><?php echo $produto['MULTA']; ?></td>                                     
                                    <td> <strong> <?php echo $produto['VALORPAGO']; ?> </strong> </td>                                     
                                    <td><?php echo $produto['NOSSONUMERO']; ?></td>                                     
                                </tr>
                                <tr>
                                    <td colspan="12"> 
                                        <div class="col-md-12">
                                            <div class="box box-default collapsed-box box-solid">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Ocorrência/motivos</h3>
                                                    <div class="box-tools pull-right">
                                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                    <!-- /.box-tools -->
                                                </div>
                                                <!-- /.box-header -->
                                                <div class="box-body">
                                                    <?php
                                                    $ocr = mysqli_query($mysqli, "SELECT OCORRENCIA.DESCRICAO FROM RETORNO INNER JOIN OCORRENCIA ON OCORRENCIA.COD = RETORNO.OCORRENCIA WHERE RETORNO.ID = {$produto['ID']}");
                                                    $ocorrencia = mysqli_fetch_object($ocr);
                                                    ?>
                                                    <h4>Ocorrência: <strong class="text text-orange"> <?php echo $ocorrencia->DESCRICAO; ?></strong> </h4>

                                                    <table class="table table-condensed table-responsive"> 
                                                        <tr>
                                                            <th>Descrição Motivo</th>
                                                        </tr>
                                                        <?php
                                                        $mtv = mysqli_query($mysqli, "SELECT MOTIVO.DESCRICAO FROM MOTIVOOCORENCIA INNER JOIN MOTIVO ON MOTIVO.COD = MOTIVOOCORENCIA.MOTIVO WHERE MOTIVOOCORENCIA.RETORNO = {$produto['ID']}");

                                                        while ($motivo = mysqli_fetch_object($mtv)) {
                                                            ?>                                                   
                                                            <tr>
                                                                <td><?php echo $motivo->DESCRICAO; ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </table>
                                                </div>
                                                <!-- /.box-body -->
                                            </div>
                                            <!-- /.box -->
                                        </div>
                                    </td>
                                </tr>
                            <?php } while ($produto = $execute->fetch_assoc()); ?>         
                        </table>
                        <div id="bottom" class="row" style="width: 80%; margin-left: auto;margin-right: auto;">
                            <div class="col-md-12">
                                <ul class="pagination">
                                    <?php
                                    if ($pagina == 0) {
                                        ?>
                                        <li class="disabled"><a href="">&lt; Anterior</a></li>
                                        <?php
                                    } else if ($pagina != 0) {
                                        ?>
                                        <li><a href="index.php?p=RelRetorno&pg=<?= $pagina - 1 ?>">&lt; Anterior</a></li>
                                        <?php
                                    }
                                    for ($i = 0; $i < $num_paginas; $i++) {
                                        $estilo = "";
                                        if ($pagina === $i) {
                                            $estilo = "class=\"active\"";
                                        }
                                        ?>
                                        <li>
                                        <li <?php echo $estilo; ?>  ><a href="index.php?p=RelRetorno&pg=<?php echo $i; ?>"><?php echo $i + 1; ?></a></li>
                                    <?php } ?>
                                    <li>
                                        <?php
                                        if ($num_paginas == $pagina + 1) {
                                            ?>                                        
                                        <li class="next disabled"><a href="" rel="next">Próximo &gt;</a></li>
                                        <?php
                                    } else if ($num_paginas != $pagina + 1) {
                                        ?>                                        
                                        <li class="next"><a href="index.php?p=RelRetorno&pg=<?= $pagina + 1 ?>" rel="next">Próximo &gt;</a></li>
                                        <?php
                                    } ?>
                                </ul><!-- /.pagination -->
                            </div>
                        </div>
                    </div>
                    <div class="box box-info" style="width: 30%; margin-left: auto; margin-right: auto;">
                        <div class="box-header with-border">
                            <h3 class="box-title">Resultado</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <!-- /.box-tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <?php
                            echo '<h3>Valor pago<strong> R$ ', $vlrpago->PAGO, '</strong></h3>';
                            echo '<h3>Despesas com cobrança<strong> R$ ', $soma->COBRANCA, '</strong></h3>';
                            echo '<h3>Despesas com protesto<strong> R$ ', $soma->PROTESTO, '</strong></h3>';
                            ?>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div><!-- /.box -->
            </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->