<!DOCTYPE HTML>
<!--
    Arcana 2.1 by HTML5 UP
    html5up.net | @n33co
    Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<?php session_start(); ?>
<html lang="pt-br">
    <head>
        <link rel="icon" type="image/png" href="images/TT.png" />
        <title>TopTech Solutions</title>
        <meta name="description" content="Quer dar mais visibilidade ao seu negócio? Então você precisa de um website, 
                                          acesse e entre em contato conosco, trabalhamos com os mais novos padrões web.
                                          Também desenvolvemos software para suprir as necessidades de sua empresa,
                                          com compatibilidade para Android e iOS " />
        <meta name="keywords" content="TopTech, Toptech Solutions, Desenvolvimento de software, Desenvolvimento de website,
                                       loja de informatica, loja de informática, roteador, web designer, web design,
                                       criação de websites, criação de sites" />
        <title>TopTech Solutions</title>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" >
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300italic,700" rel="stylesheet" />
        <script src="js/jquery.min.js"></script>
        <script src="js/config.js"></script>
        <script src="js/skel.min.js"></script>
        <script src="js/skel-panels.min.js"></script>
        <script src="js/jquery-1.6.3.min.js"></script>
        <script src="js/script.js"></script>
        <script src="js/jquery-1.6.3.min.js"></script>
        <script src="js/script.js"></script>
        <!-- Google Analytics -->
        <script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-52964543-1', 'auto');
            ga('send', 'pageview');
        </script>
        <!-- End Google Analytics -->
        <noscript>
        <link rel="stylesheet" href="css/skel-noscript.css" />
        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="css/style-desktop.css" />
        </noscript>
        <!-[if lte IE]><link rel="stylesheet" href="css/style-ie9.css" /><![endif]->
        <!-[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]->
        <link rel="stylesheet" href="font-awesome-4.2.0/css/font-awesome.min.css"/>
    </head>
    <!-- Google Tag Manager -->
    <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-MPQKQ8"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <script>(function (w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({'gtm.start':
                            new Date().getTime(), event: 'gtm.js'});
                var f = d.getElementsByTagName(s)[0],
                        j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src =
                        '//www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', 'GTM-MPQKQ8');</script>
    <!-- End Google Tag Manager -->
    <body>
        <!-- Header -->
        <div id="header-wrapper">
            <header class="container" id="site-header">
                <div class="row">
                    <div class="12u">
                        <div id="logo">
                            <div id="logo-mobile">
                            </div>			
                        </div>
                        <div class="nav-total">
                            <nav id="nav">
                                <ul>
                                    <?php
                                    if (isset($_REQUEST["pag"])){
                                        if (($_REQUEST["pag"] == "home"))
                                            echo '<li class="current_page_item"><a href="#" accesskey="H">Home</a></li>';
                                        else
                                            echo '<li><a href="home" accesskey="H">Home</a></li>';
                                        if ($_REQUEST["pag"] == "noticias")
                                            echo '<li class="current_page_item"><a href="#" accesskey="N">Noticias</a></li>';
                                        else
                                            echo '<li><a href="noticias" accesskey="N">Noticias</a></li>';
                                        if ($_REQUEST["pag"] == "servicos")
                                            echo '<li class="current_page_item"><a href="#" accesskey="S">Serviços</a></li>';
                                        else 
                                            echo '<li><a href="servicos" accesskey="S">Serviços</a></li>';
                                        if (($_REQUEST["pag"] == "planos") || ($_REQUEST["pag"] == "confirmaEmail") || 
                                            ($_REQUEST["pag"] == "boletoUsuario") || ($_REQUEST["pag"] == "cadastro"))
                                            echo '<li class="current_page_item"><a href="#" accesskey="P">Sistema NF-e</a></li>';
                                        else
                                            echo '<li><a href="planos" accesskey="P">Sistema NF-e</a></li>';
                                        if ($_REQUEST["pag"] == "sobre")
                                            echo '<li class="current_page_item"><a href="#">Sobre</a></li>';
                                        else
                                            echo '<li><a href="sobre">Sobre</a></li>';
                                        if ($_REQUEST["pag"] == "contatos")
                                            echo '<li class="current_page_item"><a href="#" accesskey="C">Contatos</a></li>';
                                        else
                                            echo '<li><a href="contatos" accesskey="C">Contatos</a></li>';
                                        } else { 
                                            echo '<li class="current_page_item"><a href="#" accesskey="H">Home</a></li>';
                                            echo '<li><a href="noticias" accesskey="N">Noticias</a></li>';
                                            echo '<li><a href="servicos" accesskey="P">Serviços</a></li>';
                                            echo '<li><a href="planos" accesskey="P">Sistema NF-e</a></li>';
                                            echo '<li><a href="sobre" accesskey="S">Sobre</a></li>';
                                            echo '<li><a href="contatos" accesskey="C">Contatos</a></li>';
                                            }
                                        ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </header>
        </div>
        <!-- Main -->
        <div id="main-wrapper">
            <div id="conteudo" class="container">           
                <?php
		  if (isset($_REQUEST["pag"])){
                    if ($_REQUEST["pag"] == "noticias")
                      include 'noticias.php';
                    else if ($_REQUEST["pag"] == "servicos")
                      include 'servicos.php';
                    else if ($_REQUEST["pag"] == "planos")
                      include 'planos.php';
                    else if ($_REQUEST["pag"] == "sobre")
                      include 'sobre.php';
                    else if ($_REQUEST["pag"] == "contatos")
                      include 'contatos.php';
                    else if ($_REQUEST["pag"] == "cadastro")
                      include 'cadastro.php';
                    else if ($_REQUEST["pag"] == "confirmaEmail")
                      include 'confirmaEmail.php';
                    else if ($_REQUEST["pag"] == "boletoUsuario")
                      include 'boletoUsuario.php';
                    else
                      include 'home.php';
                  } else
                      include 'home.php';
                ?>
            </div>
        </div>               
        <!-- Footer -->
        <div id="footer-wrapper">
            <footer class="container" id="site-footer">
<div style="width:100%;">
<div style="float:left;width:60%;margin-top:2.5%">
                            <div id="copyright"> <i class="fa fa-copyright"></i>
                                TopTech Solutions. All rights reserved. | Design: <a href="http://html5up.net">HTML5 UP</a>
                            </div>
</div>
<div style="margin-left:60%;padding: 0 20px;">
<h3>Acompanhe também a TopTech, nas redes sociais.</h3></td>
</div>
<div style="margin-left:60%;padding: 0 20px;">
                    <nav id="rodape">
                        <ul>
                            <li>
                                <a href="https://www.facebook.com/solucoestoptech/" target="_blank"/><img src="images/social03.png" width="32" height="32" alt="Facebook"/></a>
                            </li>
                            <li>
                                <a href="#"><img src="images/social01.png" width="32" height="32" alt="Twitter"/></a>
                            </li>
                            <li>
                                <a href="https://plus.google.com/107334042158321991624" target="_blank"/><img src="images/social04.png" width="32" height="32" alt="Google+"/></a>
                            </li>
                            <li>
                                <a href="#"><img src="images/social02.png" width="32" height="32" alt="RSS"/></a>
                            </li>
                        </ul>
                    </nav>
</div>
</div>
        </div>
        <script type="text/javascript">
            (function () {
                var po = document.createElement("script");
                po.type = "text/javascript";
                po.async = true;
                po.src = "https://apis.google.com/js/plusone.js?publisherid=107334042158321991624";
                var s = document.getElementsByTagName("script")[0];
                s.parentNode.insertBefore(po, s);
            })();
        </script>
    </body>
</html>