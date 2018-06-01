<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/templatemo_style.css" />
<div class="templatemo_lightgrey" id="templatemo_contact">
    <div class="paracenter">
        <h2>Entre em contato conosco</h2></div>
    <div class="clear"></div>
    <div class="container">
        <div class="paracenter">

        </div>
        <div class="clear"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="templatemo_maps">
                        <div class="fluid-wrapper">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1758.0388961379244!2d-53.48224799999956!3d-28.204949005911484!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94fc53f986f8c575%3A0x6ec6125299e76465!2sTopTech+Solutions!5e0!3m2!1spt-BR!2sbr!4v1414077443682" width="1200" height="400" frameborder="0" style="border:0"></iframe>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            <form method="post">
                                <div class="form-group">
                                    <input name="Nome" type="text" class="form-control" id="fullname" placeholder="Seu nome" maxlength="50" required>
                                </div>
                                <div class="form-group">
                                    <input name="Email" type="text" class="form-control" id="email" placeholder="Seu e-mail" maxlength="40" required>
                                </div>
                                <div class="form-group">
                                    <input name="Assunto" type="text" class="form-control" id="subject" placeholder="O seu Assunto" maxlength="40" required>
                                </div>
                                <div><input type="submit" name="bt" class="btn btn-primary" value="Enviar"></div>
                        </div>
                        <div class="col-md-9">
                            <div class="txtarea">
                                <textarea name="Mensagem" type="text" rows="10" class="form-control" id="message" placeholder="Escreva aqui a sua mensagem" required></textarea>
                            </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    /**
    if (isset($_REQUEST["bt"]))
        if ($_REQUEST["bt"]) {
            mail("solucoestoptech@gmail.com", "Contato Site", $_REQUEST['Nome'] . " - " . $_REQUEST['Email'] . " - " . $_REQUEST['Assunto'] . " - " . $_REQUEST['Mensagem']);
            echo "<h2>Dados enviados com sucesso.</h2>";
            }
     * 
     */
    ?>
    
<?php
if (isset($_REQUEST["bt"])) {
    $nome = $_POST['Nome'];
    $email = $_POST['Email'];
    $assunto = $_POST['Assunto'];
    $mensagem = $_POST['Mensagem'];
    
    $email_conteudo = "Nome = $nome \n";
    $email_conteudo .= "Email = $email \n";
    $email_conteudo .= "Mensagem = $mensagem \n";

    if (mail ("jaderfeldmann@hotmail.com", $assunto, nl2br($email_conteudo)))
        echo "</b>E-Mail enviado com sucesso!</b>";
     else
        echo "</b>Falha no envio do E-Mail!</b>";
     } ?>
</div>