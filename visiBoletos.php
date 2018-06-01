<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Visualizar boletos</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Visualizar boletos</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="col-md-push-12" >
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-angle-double-right"></i> Visualizar boletos</h3>
                    <h2 class="box box-warning text-center text-black">Meus boletos</h2>
                    <?php
                    // definir o numero de itens por pagina
                    $itens_por_pagina = 10;

                    // pegar a pagina atual
                    $pagina = intval($_GET['pg']);
                    $limit = $pagina * 10;

                    // puxar produtos do banco
                    $ID = $_SESSION["idUS"];
                    $sql_code = "SELECT BOLETO.ID, BOLETO.VALOR, BOLETO.VENCIMENTO, BOLETO.STATUS, BOLETO.CAMINHO, BOLETO.REFUSUARIO FROM BOLETO WHERE BOLETO.REFUSUARIO = {$ID} ORDER BY BOLETO.STATUS ASC, VENCIMENTO ASC LIMIT $limit, $itens_por_pagina";
                    $execute = $mysqli->query($sql_code) or die($mysqli->error);
                    $produto = $execute->fetch_assoc();
                    $num = $execute->num_rows;

                    // pega a quantidade total de objetos no banco de dados
                    $num_total = $mysqli->query("SELECT BOLETO.ID FROM BOLETO WHERE BOLETO.REFUSUARIO = {$ID}")->num_rows;

                    // definir numero de paginas
                    $num_paginas = ceil($num_total / $itens_por_pagina);
                    ?>
                    <div class="box-body">
                        <table class="table table-condensed table-responsive" style="width: 80%; margin-left: auto;margin-right: auto;" >
                            <tr>
                                <th>ID</th>
                                <th>Vencimento</th>
                                <th>Status</th>
                                <th>Baixar</th>
                                <th>Visualizar</th>
                            </tr>
                            <?php do { ?>
                                <tr>                                           
                                    <td><?php echo $produto['ID']; ?></td>
                                    <td class="text-bold text-orange"><?php $data = date_create($produto['VENCIMENTO']); echo date_format($data, 'd/m/Y'); ?></td>                                    
                                    <?php
                                    $sts = $produto['STATUS'];
                                    if (($sts == 1) or ($sts == 0)) {
                                        ?>                                    
                                        <td>Não emitido</td>
                                        <?php
                                    } else if ($sts == 2) {
                                        ?>
                                        <td>Emitido</td>
                                        <?php
                                    } else if ($sts == 3) {
                                        ?>
                                        <td class="text-green" >Pago</td>
                                        <?php
                                    } else if ($sts == 5) {
                                        ?>
                                        <td class="text-green" >Baixado</td>
                                        <?php
                                    }else if ($sts == 4) {
                                        ?>
                                        <td class="text-red" >Vencido</td>
                                    <?php }
                                    else if ($sts == 6) {
                                        ?>
                                        <td class="text-red" >Em cartório</td>
                                    <?php } ?>
                                    <td> 
                                        <?php
                                        if (($sts == 1) or ($sts == 0) or ($sts == 5) or ($sts == 3) ) {
                                            echo 'Indisponível';
                                        }else{  
                                        ?>
                                        <a href="boletos/<?php echo $produto['CAMINHO'], '.pdf'; ?>" download target="_blank">
                                            <input type="image" class="btn" src="dist/img/download.png" alt="Download">
                                        </a>
                                        <?php  } ?>
                                    </td> 
                                    <td>
                                        <?php
                                        if (($sts == 1) or ($sts == 0) or ($sts == 5) or ($sts == 3)) {
                                            echo 'Indisponível';
                                        }else{
                                        ?>
                                        <form action="index.php?p=verboleto" method="post"> 
                                            <input type="image" class="btn" src="dist/img/view.png" alt="Visualizar" formaction="index.php?p=verboleto">
                                            <input type="hidden" name="id" value="<?= $produto['ID'] ?>">
                                        </form>
                                        <?php  } ?>                                        
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
                                        <li><a href="index.php?p=boletos&pg=<?= $pagina - 1 ?>">&lt; Anterior</a></li>
                                        <?php
                                    }
                                    for ($i = 0; $i < $num_paginas; $i++) {
                                        $estilo = "";
                                        if ($pagina === $i) {
                                            $estilo = "class=\"active\"";
                                        } ?>
                                        <li>
                                        <li <?php echo $estilo; ?>  ><a href="index.php?p=boletos&pg=<?php echo $i; ?>"><?php echo $i + 1; ?></a></li>
                                    <?php } ?>
                                    <li>
                                        <?php
                                        if ($num_paginas == $pagina + 1) {
                                            ?>                                        
                                        <li class="next disabled"><a href="" rel="next">Próximo &gt;</a></li>
                                        <?php
                                    } else if ($num_paginas != $pagina + 1) {
                                        ?>                                        
                                        <li class="next"><a href="index.php?p=boletos&pg=<?= $pagina + 1 ?>" rel="next">Próximo &gt;</a></li>
                                        <?php } ?>
                                </ul><!-- /.pagination -->
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                    </div>
                </div><!-- /.box -->
            </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->