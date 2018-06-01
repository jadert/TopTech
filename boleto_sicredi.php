<html>
<body onload="carregaPagina()">
<?php
$dias_de_prazo_para_pagamento = 15;
$taxa_boleto = 0;
$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
$valor_cobrado = $_GET["valor_cobrado"];; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

$dadosboleto["inicio_nosso_numero"] = date("y");	// Ano da geração do título ex: 07 para 2007 
$dadosboleto["nosso_numero"] = $_GET['nossoNumero'];  			// Nosso numero (máx. 5 digitos) - Numero sequencial de controle.
$dadosboleto["numero_documento"] = $_GET['seuNumero'];	//UECA16173 Num do pedido ou do documento
$dadosboleto["data_vencimento"] = date("d/m/Y", strtotime($_GET['data_venc']));   // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y");     // Data de emissão do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto;    	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula
// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = $_GET["nomeUsuario"];;
$dadosboleto["endereco1"] = $_GET['endereco1'];
$dadosboleto["endereco2"] = $_GET['endereco2'];
// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "Pagamento do Sistema NF TopTech";
$dadosboleto["demonstrativo2"] = "Em caso de dúvidas entre em contato: suporte@toptech.solutions";
$dadosboleto["demonstrativo3"] = "";
// INSTRUÇÕES PARA O CAIXA
$dadosboleto["instrucoes1"] = "";
$dadosboleto["instrucoes2"] = "";
$dadosboleto["instrucoes3"] = "";
$dadosboleto["instrucoes4"] = "";
// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "";
$dadosboleto["valor_unitario"] = "";
$dadosboleto["aceite"] = "S";	    // N - remeter cobrança sem aceite do sacado  (cobranças não-registradas)
                                    // S - remeter cobrança apos aceite do sacado (cobranças registradas)
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "A"; // OS - Outros segundo manual para cedentes de cobrança SICREDI
// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //
// DADOS DA SUA CONTA - SICREDI
$dadosboleto["agencia"] = "0361"; 	// Num da agencia (4 digitos), sem Digito Verificador
$dadosboleto["conta"] = "60656"; 	// Num da conta (5 digitos), sem Digito Verificador
$dadosboleto["conta_dv"] = "6"; 	// Digito Verificador do Num da conta

// DADOS PERSONALIZADOS - SICREDI
$dadosboleto["posto"]= "09";      // Código do posto da cooperativa de crédito
$dadosboleto["byte_idt"]= "2";	  // Byte de identificação do cedente do bloqueto utilizado para compor o nosso número.
                                  // 1 - Idtf emitente: Cooperativa | 2 a 9 - Idtf emitente: Cedente
$dadosboleto["carteira"] = "A";   // Código da Carteira: A (Simples) 
// SEUS DADOS
$dadosboleto["identificacao"] = "TopTech - Condor Sistemas e Solucoes em TI";
$dadosboleto["cpf_cnpj"] = "19.766.798/0001-05";
$dadosboleto["endereco"] = "Rua Marechal Floriano n30, 2 Andar, Sala 01";
$dadosboleto["cidade_uf"] = "Condor / RS";
$dadosboleto["cedente"] = "TopTech Solutions";

ob_start();

// NÃO ALTERAR!
include("include/funcoes_sicredi.php");
include("include/layout_sicredi.php");

$content = ob_get_clean();

// converte
require_once(dirname(__FILE__).'/html2pdf/vendor/autoload.php');
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

try {
    $html2pdf = new HTML2PDF('P', 'A4', 'pt', true, 'UTF-8', array(15, 5, 15, 5));
    $html2pdf->pdf->SetDisplayMode('real');
	
    // Parametro vuehtml = true desabilita o pdf para desenvolvimento do layout
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

    // Salva o PDF no servidor 
    $html2pdf->Output("boletos/".$_GET['nomeBoleto'].".pdf",'F');
    }
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
    } 
?>      
<script type="text/javascript">
    function carregaPagina(){
        location.href='statusBoleto.php?BoletoID=<?php echo $_GET['BoletoID']; ?>';
        }
</script>
</body>
</html>