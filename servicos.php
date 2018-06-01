<script type="text/javascript">
    $(document).ready(function () {
        $("#link1").click(function () {
            $("#caixaTexto").html("Oferecemos um serviço de mais alta qualidade no ramo de desenvolvimento de software. Para atender as necessidades de todos os "
                    + "clientes da melhor forma possível oferecemos softwares prontos e sob encomenda, todos criados com extremo cuidado e dedicação. "
                    + "Nenhum de nossos projetos é engavetado, todos continuam sendo desenvolvidos e aprimorados sempre em constante evolução para "
                    + "poder acompanhar as necessidades dos clientes e o desenvolvimento da tecnologia.");
        });

        $("#link2").click(function () {
            $("#caixaTexto").html("Também possuímos um serviço para a criação e desenvolvimento de sites, os quais são desenvolvidos com altos padrões de qualidade. "
                    + "Todos os nossos websites são baseados em HTML5 e CSS3 tecnologias que permitem a criação de sites mais leves e dinâmicos e claro "
                    + "prontos para funcionar em smartphones que atualmente representam um importante mercado. Além da criação de sites leves e bonitos "
                    + "se o cliente precisar nós cuidamos da parte da compra do domínio e da hospedagem para que você tenha a melhor experiência possível.");
        });

        $("#link3").click(function () {
            $("#caixaTexto").html("Para poder atender os mais variados tipos de clientes oferecemos de desenvolvimento de serviços de robótica simples com o sistema "
                    + "Arduino.<br> <nav> <img  id='img' src='images/arduino.png' /> </nav>");
        });

        $("#link4").click(function () {
            $("#caixaTexto").html("Para atender todas as necessidades dos nossos clientes oferecemos também um serviço completo de manutenção para computadores e notebooks, "
                    + "serviços com qualidade e transparência além de preços acessíveis.<br><img id='img' src='images/gamer-supreme.jpg' />");
        });

        $("#link5").click(function () {
            $("#caixaTexto").html("Também oferecemos um serviço de assistência e consultoria no campo da computação, informações nos mais diversos segmentos, como por exemplo "
                    + "redes, computação na nuvem, computação distribuída, virtualização entre outros ramos da tecnologia de ponta. É oferecido um serviço de "
                    + "suporte dos nossos serviços para que você nunca fique desamparado e para que saiba que a <a href='index.php'>TopTech Solutions</a> é o lugar onde você "
                    + "pode confiar para resolver todos os seus problemas na área computacional.");
        });

    });

</script>
<header>
    <nav class="sobre">Serviços oferedidos pela <a href="index.php">TopTech Solutions</a></nav>
</header>

<article>
    <nav class="servicos">
        <p>
        <div id="caixaTexto">Clique no menu ao lado para navegar entre os vários serviços oferecidos pela <a href="index.php">TopTech Solutions</a></div>
        </p>        
    </nav>
</article>

<section>
    <nav>
        <p>
            <a id="link1">Softwares</a><br>
            <a id="link2">Websites</a><br>
            <a id="link3">Robótica</a><br>
            <a id="link4">Manutenção</a><br> 
            <a id="link5">Assistência</a> 
        </p>
    </nav>
</section>

<style>
    @font-face{
        font-family: fontenova;
        src:url('font/Jorvik_.TTF');    
    }

    .sobre {
        text-align: center;
        font-size: 2.9em;
        width: 100%;
    }

    .sobre{
        border: 2px solid;
        border-radius: 35px 8px 35px 8px;
        border-color: #080;
        padding-top: 20px;
        padding-bottom: 20px;
        width: 95%;
        box-shadow: 3px 3px 10px #2E8B57;
        margin-bottom: 55px;
        margin-top: 20px;
        line-height: normal;
    }

    article{
        font-family: fontenova;
        text-align: justify;
        width:80%;
        position: relative;
        float: right;
        margin-bottom: 40px;
        display: inline;
    }

    section{
        width:19%;
        position: static;
        margin-bottom: 40px;
    }
    section p{
        background: url('css/images/bg2.png');/*se mudar de lugar tem de tirar o css/*/ 
        text-shadow: 0.01em 0.01em 0.05em #333;
        line-height: 35px;
        font-size: 1.4em;
        font-family: fontenova;
        margin-bottom: 10px;
        text-align: justify;
        text-align:center;
        height:500px;
    }

    a{ /*Dever ser mantida a ordem de link -> visited -> hover ->active */
        cursor:pointer;
        text-decoration: none;
        color:#006400;
    }
    a:visited{
        text-decoration: none;
        color: #008000;
    }
    a:hover{
        text-decoration: none;
        color: #32CD32;
        transition: all 1s;

    }

    a:active{
        text-decoration: none;
        color: #fae9c9;
    }

    #img{
        width: 40%;
        display: block; 
        margin-left: auto; 
        margin-right: auto; 
        box-shadow: 10px 10px 5px #888888;
        margin-top: 10px;
    }
    

    @media screen and (max-width: 768px) {
        .sobre{
            font-size: 1.9em;
        }
        section{
            width:24%;
            position: static;
            height: 620px;
            background-image: url('css/images/bg2.png');/*se mudar de lugar tem de tirar o css/*/ 
            margin-bottom: 40px;
        }
        section p{

            text-shadow: 0.01em 0.01em 0.05em #333;
            line-height: 35px;
            font-size: 0.9em;
            font-family: fontenova;
            text-align: justify;
            text-align:center;
            width: 100%;
        }
        article{
            width: 58%;
            position: relative;
            float: right;
            margin-bottom: 40px;
            display: inline;
            height: 500px;
        }
        article nav p{
            font-family: fontenova;
            font-size: 0.9em;
            text-align: justify;        
        }
        #img{
            width: 60%;
            display: block; 
            margin-left: auto; 
            margin-right: auto;        
        }


    }
</style>