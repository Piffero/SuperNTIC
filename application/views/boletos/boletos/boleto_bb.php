<?php
// +----------------------------------------------------------------------+
// | BoletoPhp - Versão Beta |
// +----------------------------------------------------------------------+
// | Este arquivo está disponível sob a Licença GPL disponível pela Web |
// | em http://pt.wikipedia.org/wiki/GNU_General_Public_License |
// | Voc� deve ter recebido uma cópia da GNU Public License junto com |
// | esse pacote; se não, escreva para: |
// | |
// | Free Software Foundation, Inc. |
// | 59 Temple Place - Suite 330 |
// | Boston, MA 02111-1307, USA. |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Originado do Projeto BBBoletoFree que tiveram colaborações de Daniel |
// | William Schultz e Leandro Maniezo que por sua vez foi derivado do |
// | PHPBoleto de João Prado Maia e Pablo Martins F. Costa |
// | |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br |
// +----------------------------------------------------------------------+

// +--------------------------------------------------------------------------------------------------------+
// | Equipe Coordenação Projeto BoletoPhp: <boletophp@boletophp.com.br> |
// | Desenvolvimento Boleto Banco do Brasil: Daniel William Schultz / Leandro Maniezo / Rogério Dias Pereira|
// +--------------------------------------------------------------------------------------------------------+

// ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERAçãO DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulário c/ POST, GET ou de BD (MySql,Postgre,etc) //

// DADOS DO BOLETO PARA O SEU CLIENTE
// $dias_de_prazo_para_pagamento = 5;
$taxa_boleto = 0.00; // COLOCAR NO CADASTRO DO BANCO !!!
$data_venc = $prazo; // date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400)); // Prazo de X dias OU informe data: "13/04/2006";
$valor_cobrado = number_format($docvalue, 2, ',', ''); // "2950,00"; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = $docvalue; // str_replace(",", ".",$valor_cobrado);
$valor_boleto = number_format($valor_cobrado + $taxa_boleto, 2, ',', '');

$dadosboleto["nosso_numero"] = $nossonum; // "87654";
$dadosboleto["numero_documento"] = $ndocum; // "27.030195.10"; // Num do pedido ou do documento
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; // Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula
                                               
// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = $nomecli; // "Nome do seu Cliente";
$dadosboleto["endereco1"] = $rua; // "Endereço do seu Cliente";
$dadosboleto["endereco2"] = $cidade . ' - ' . $estado . ' - CEP: ' . $cep; // "Cidade - Estado - CEP: 00000-000";
                                                                            
// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = $mensagem; // "Pagamento de Compra na Loja Nonononono";
$dadosboleto["demonstrativo2"] = ''; // "Mensalidade referente a nonon nonooon nononon<br>Taxa bancária - R$ ".number_format($taxa_boleto, 2, ',', '');
$dadosboleto["demonstrativo3"] = ''; // "BoletoPhp - http://www.boletophp.com.br";
                                      
// INSTRUçãES PARA O CAIXA
$dadosboleto["instrucoes1"] = $description; // "- Sr. Caixa, cobrar multa de 2% após o vencimento";
$dadosboleto["instrucoes2"] = ''; // "- Receber até 10 dias após o vencimento";
$dadosboleto["instrucoes3"] = ''; // "- Em caso de dúvidas entre em contato conosco: xxxx@xxxx.com.br";
$dadosboleto["instrucoes4"] = ''; // "&nbsp; Emitido pelo sistema Projeto BoletoPhp - www.boletophp.com.br";
                                   
// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = $quantity; // "10";
$dadosboleto["valor_unitario"] = ''; // "10";
$dadosboleto["aceite"] = "N"; // O QUE É ISSO ???
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "DM";

// ---------------------- DADOS FIXOS DE CONFIGURAçãO DO SEU BOLETO --------------- //

// DADOS DA SUA CONTA - BANCO DO BRASIL
$dadosboleto["agencia"] = $agencia; // "9999"; // Num da agencia, sem digito
$dadosboleto["conta"] = $conta; // "99999"; // Num da conta, sem digito
                                 
// DADOS PERSONALIZADOS - BANCO DO BRASIL
$dadosboleto["convenio"] = $convenio; // "7777777"; // Num do conv�nio - REGRA: 6 ou 7 ou 8 dígitos
$dadosboleto["contrato"] = $contrato; // "999999"; // Num do seu contrato
$dadosboleto["carteira"] = $carteira; // "18";
$dadosboleto["variacao_carteira"] = ""; // Variação da Carteira, com traço (opcional)
                                         
// TIPO DO BOLETO
$dadosboleto["formatacao_convenio"] = settype(strlen(settype($convenio, 'string')), 'string'); // "7"; // REGRA: 8 p/ Convênio c/ 8 dígitos, 7 p/ Convênio c/ 7 dígitos, ou 6 se Convênio c/ 6 dígitos
$dadosboleto["formatacao_nosso_numero"] = "2"; // REGRA: Usado apenas p/ Convênio c/ 6 dígitos: informe 1 se for Nossonúmero de até 5 dígitos ou 2 para opção de até 17 dígitos

/*
 * #################################################
 * DESENVOLVIDO PARA CARTEIRA 18
 *
 * - Carteira 18 com Convênio de 8 digitos
 * Nosso número: pode ser até 9 dígitos
 *
 * - Carteira 18 com Convenio de 7 digitos
 * Nosso número: pode ser até 10 dígitos
 *
 * - Carteira 18 com Convenio de 6 digitos
 * Nosso número:
 * de 1 a 99999 para opção de até 5 dígitos
 * de 1 a 99999999999999999 para opção de até 17 dígitos
 *
 * #################################################
 */

// SEUS DADOS
$dadosboleto["identificacao"] = "NTIC - Núcleo de Tecnologia da Informação e Comunicação";
$dadosboleto["cpf_cnpj"] = $cnpj; // "";
$dadosboleto["endereco"] = "Coloque o endereço da sua empresa aqui";
$dadosboleto["cidade_uf"] = "Cidade / Estado";
$dadosboleto["cedente"] = strtoupper($cedente); // "Coloque a Razão Social da sua empresa aqui";
                                                    
// NÃO ALTERAR!
include ("include/funcoes_bb.php");
include ("include/layout_bb.php");
?>
