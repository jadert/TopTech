<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Gerenciar retorno</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Gerenciar retorno</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="col-md-push-12" >
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-angle-double-right"></i> Gerenciar retorno</h3>
                    <h2 class="box box-warning text-center text-black">Gerenciar retorno</h2>
                    <div id="main" class="container-fluid">
                        <div id="top" class="row">
                        </div> <!-- /#top -->
                            <?php
                            // definir o numero de itens por pagina
                            $itens_por_pagina = 10;

                            // pegar a pagina atual
                            $pagina = intval($_GET['pg']);
                            $limit = $pagina*10;

                            // puxar produtos do banco
                            $sql_code = "SELECT ID, DATA, NOME FROM RETORNOARQUVO ORDER BY DATA DESC LIMIT $limit, $itens_por_pagina";
                            $execute = $mysqli->query($sql_code) or die($mysqli->error);
                            $produto = $execute->fetch_assoc();
                            $num = $execute->num_rows;

                            // pega a quantidade total de objetos no banco de dados
                            $num_total = $mysqli->query("SELECT RETORNOARQUVO.ID FROM RETORNOARQUVO")->num_rows;

                            // definir numero de pÃ¡ginas
                            $num_paginas = ceil($num_total / $itens_por_pagina);
                            ?>
                            <div class="box-body">
                                <table class="table table-condensed table-responsive" style="width: 80%; margin-left: auto;margin-right: auto;" >
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Data</th>
                                        <th>Visualizar</th>
                                    </tr>
                                        <?php do { ?>
                                        <tr>                                           
                                            <td><?php echo $produto['ID']; ?></td>
                                            <td><?php echo $produto['NOME']; ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($produto['DATA'])); ?></td>
                                            <td> 
                                                <form action="index.php?p=verretorno" method="post"> 
                                                    <input type="image" class="btn" src="dist/img/view.png" alt="Editar" formaction="index.php?p=verretorno">
                                                    <input type="hidden" name="id" value="<?= $produto['ID'] ?>">
                                                </form>
                                            </td>
                                        </tr>
                                        <?php } while ($produto = $execute->fetch_assoc()); ?>                           
                                </table>
                                <div id="bottom" class="row" style="width: 80%; margin-left: auto;margin-right: auto;">
                                    <div class="col-md-12">
                                        <ul class="pagination">
                                            <?php
                                            if ($pagina == 0){
                                                ?>
                                            <li class="disabled"><a href="">&lt; Anterior</a></li>
                                            <?php
                                            } else if($pagina != 0){
                                            ?>
                                            <li><a href="index.php?p=gerretorno&pg=<?= $pagina-1 ?>">&lt; Anterior</a></li>
                                            <?php }
				    for($i=0;$i<$num_paginas;$i++){
                                        $estilo = "";
                                    if($pagina === $i){
                                    $estilo = "class=\"active\"";}
                                        ?>
				    <li>
				    <li <?php echo $estilo; ?>  ><a href="index.php?p=gerretorno&pg=<?php echo $i; ?>"><?php echo $i+1; ?></a></li>
					<?php } ?>
				    <li>
                                        <?php
                                        if ($num_paginas == $pagina+1){
                                            ?>                                        
                                            <li class="next disabled"><a href="" rel="next">Próximo &gt;</a></li>
                                        <?php 
                                        }else if ($num_paginas != $pagina+1){
                                        ?>                                        
                                            <li class="next"><a href="index.php?p=gerretorno&pg=<?= $pagina+1 ?>" rel="next">Próximo &gt;</a></li>
                                        <?php } ?>
                                        </ul><!-- /.pagination -->
                                    </div>
                                </div>
                            </div
                        <div id="bottom" class="row">
                        </div> <!-- /#bottom -->
                    </div>  <!-- /#main -->
                </div><!-- /.box -->
            </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->