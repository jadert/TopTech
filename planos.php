<?php include './conecta.php'; ?>
<table>
    <tr>
        <td colspan="3"><center>Selecione um plano:</td>
        </tr>    
        <tr>
            <?php
            $sqlPlano = mysqli_query($mysqli, "select ID, NOME from PLANO where ATIVO = 1");
            while ($buscaPlano = mysqli_fetch_object($sqlPlano)) { ?> 
                <td>
                    <h1><?php echo $buscaPlano->NOME; ?></h1>
                    <?php
                    $sqlDescricao = mysqli_query($mysqli, "select TEXTO from DESCRICAO where REFPLANO = " . $buscaPlano->ID . "");
                    while ($buscaDescricao = mysqli_fetch_object($sqlDescricao))
                        echo "- " . $buscaDescricao->TEXTO . "<br>";
                    ?>
                    <form id="formPlano" name="Plano" method="post" action="index.php?pag=cadastro" enctype="multipart/form-data">
                        <center><h2>Duração</h2>
                            <select name="plano" id="plano">
                                <?php
                                $sqlDuracao = mysqli_query($mysqli, "select ID, DESCRICAO, VALOR from DURACAO where REFPLANO = " . $buscaPlano->ID . "");
                                while ($buscaDuracao = mysqli_fetch_object($sqlDuracao)) {
                                    echo '<option value="' . $buscaDuracao->ID . '">' . $buscaDuracao->DESCRICAO . ' - R$' . $buscaDuracao->VALOR . '</option>';
                                }
                                ?>    
                            </select>
                            <br>
                            <input name="ciclos" type="number" id="ciclos" class="form-control" value="1"  placeholder="Ciclos de Renovação" required/>
                            <br>
                            <button type="submit" name="salvaPlano" class="btn btn-primary btn-block btn-flat">Selecionar</button>
                    </form>  
                </td>
<?php } ?>
        </tr>
</table>    
<BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR>