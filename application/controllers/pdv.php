<?php
require_once ("secure_area.php");

class pdv extends Secure_area
{

    function __construct()
    {
        parent::__construct('sales');
    }

    function index($manage_result = null)
    {
        ECHO '
			<!doctype html>
			<html lang="en">
			<head>
				<meta charset="utf-8">
				<title>jQuery UI Progressbar - Custom Label</title>
				<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
				<script src="//code.jquery.com/jquery-1.10.2.js"></script>
				<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
				
				<style>
				.ui-progressbar {
					background-color: #228B22;
					position: relative;
					height: 35;					
				}
				.progress-label {
					position: absolute;
					left: 50%;
					top: 4px;
					font-weight: bold;
					text-shadow: 1px 1px 0 #fff;					
				}
				</style>
				<script>
					$(function() {
						var progressbar = $( "#progressbar" ),
						progressLabel = $( ".progress-label" );
						progressbar.progressbar({
						value: false,
							change: function() {
								progressLabel.text( progressbar.progressbar( "value" ) + "%" );								
							},
							complete: function() {
								progressLabel.text( "Complete!" );
								self.close();
							}
						});
						function progress() {
							var val = progressbar.progressbar( "value" ) || 0;
							progressbar.progressbar( "value", val + 2 );
							if ( val < 99 ) {
								setTimeout( progress, 80 );
							}
			
							if ( val == 2 )  { var p = document.getElementById("data").innerHTML = "<strong>Gerando Arquivo Integração de Clientes</strong>";}
							if ( val == 16 ) { var p = document.getElementById("data").innerHTML = "<strong>Gerando Arquivo Integração dos Dados Tributarios</strong>"; }
							if ( val == 30 ) { var p = document.getElementById("data").innerHTML = "<strong>Gerando Arquivo Dados Tributarios IPI</strong>"; }
							if ( val == 44 ) { var p = document.getElementById("data").innerHTML = "<strong>Gerando Arquivo Dados Tributarios ICMS</strong>"; }
							if ( val == 58 ) { var p = document.getElementById("data").innerHTML = "<strong>Gerando Arquivo Dados Tributarios PIS</strong>"; }
							if ( val == 72 ) { var p = document.getElementById("data").innerHTML = "<strong>Gerando Arquivo Dados Tributarios COFIS</strong>"; }
							if ( val == 86 ) { var p = document.getElementById("data").innerHTML = "<strong>Gerando Arquivo Integração dos Produtos</strong>"; }														
			
						}
						setTimeout( progress, 3000 );
					});
				</script>
			</head>
			<body>
				<div id="progressbar"><div class="progress-label">Loading...</div></div>
				<p id="data"><strong>Carregando Dados...</strong></p>
			</body>
			</html>
			';
        $this->loadingMonitor();
    }

    function loadingMonitor()
    {
        $txt = '';
        // pega registro de clientes;
        $customers = $this->Customer->get_all();
        
        foreach ($customers->result() as $customer) {
            if (strlen($customer->document_cpf) == 14) {
                $tipo = 'F';
            } elseif (strlen($customer->document_cpf) == 18) {
                $tipo = 'J';
            } else {
                $tipo = 'F';
            }
            ;
            
            $cep = explode('.', $customer->zip);
            
            if (isset($cep[1])) {
                $strzip = $cep[0] . $cep[1];
            } else {
                $strzip = ' ';
            }
            
            $txt .= str_pad($customer->patient_id, 20, '0', STR_PAD_LEFT); // Codigo exter do Cliente
            $txt .= $tipo; // Tipo de Documento
            $txt .= substr(str_pad(removeAcento($customer->first_name . ' ' . $customer->last_name), 50, ' ', STR_PAD_RIGHT), 0, 50); // Nome do Cliente
            $txt .= substr(str_pad(removeAcento($customer->first_name), 30, ' ', STR_PAD_RIGHT), 0, 30); // Apelido se for Pessoa Fisica ou Fantasia Pessoa Juridica
            $txt .= str_pad(' ', 8, ' ', STR_PAD_RIGHT); // Data de Cadastro
            $txt .= str_pad(' ', 8, ' ', STR_PAD_RIGHT); // Data de Nacimento
            $txt .= str_pad(' ', 12, ' ', STR_PAD_RIGHT); // Ult Compra
            $txt .= str_pad(' ', 12, ' ', STR_PAD_RIGHT); // Data de Alteração
            $txt .= str_pad($customer->phone_home, 14, ' ', STR_PAD_RIGHT); // Telefone Rezidencial ou Comercial
            $txt .= str_pad($customer->phone_cell, 14, ' ', STR_PAD_RIGHT); // Celular ou Fax
            $txt .= str_pad($customer->email, 50, ' ', STR_PAD_RIGHT); // E-mail
            $txt .= str_pad(removeAcento($customer->address_1), 50, ' ', STR_PAD_RIGHT); // Endereço ou Logradouro
            $txt .= str_pad(' ', 6, ' ', STR_PAD_RIGHT); // Numero do Endereço
            $txt .= str_pad(removeAcento($customer->address_2), 30, ' ', STR_PAD_RIGHT); // Complemento do Endereço
            $txt .= str_pad(removeAcento($customer->country), 30, ' ', STR_PAD_RIGHT); // Bairro
            $txt .= str_pad(removeAcento($customer->city), 30, ' ', STR_PAD_RIGHT); // Cidade NOME ou Codigo IBGE
            $txt .= str_pad($customer->state, 2, ' ', STR_PAD_RIGHT); // Estado UF
            $txt .= str_pad($strzip, 9, ' ', STR_PAD_RIGHT); // CEP com o - seprador
            $txt .= str_pad(' ', 80, ' ', STR_PAD_RIGHT); // Observações para facilitar a localização
            $txt .= str_pad($customer->document_rg, 20, ' ', STR_PAD_RIGHT); // RG se Pessoa Fisica ou Insc. Estadual se pessoa Juridica
            $txt .= str_pad($customer->document_cpf, 20, ' ', STR_PAD_RIGHT); // CPF se Pessoa Fisica ou CNPJ se pessoa Juridica
            $txt .= str_pad(' ', 65, ' ', STR_PAD_RIGHT); // Observações referente a este cliente para ser exibida no momento da Venda
            $txt .= str_pad(' ', 80, ' ', STR_PAD_RIGHT); // MEMO Observações diversas sobre o Cliente
            $txt .= str_pad('9', 1, '9', STR_PAD_RIGHT); // Nivel de Crédito de 0 a 9 sendo 0 = Cliente Bloqueado e 9 Cliente VIP
            $txt .= str_pad('0', 10, ' ', STR_PAD_RIGHT); // Valor Máximo permitido para Compras A PRAZO para este cliente, 2 Decimais
            $txt .= str_pad(' ', 16, ' ', STR_PAD_RIGHT); // Senha para liberação do Cliente. Deve ser informada em Hexadecimal.
            $txt .= str_pad(' ', 6, ' ', STR_PAD_RIGHT); // Chave estrangeira para a tabela CLASSE
            $txt .= str_pad(' ', 30, ' ', STR_PAD_RIGHT); // Descricção da Classe Deve ser informado
            $txt .= str_pad(' ', 6, ' ', STR_PAD_RIGHT); // Chave estrangeira para a tabela Convenio
            $txt .= str_pad(' ', 30, ' ', STR_PAD_RIGHT); // Descricao do Convenio Deve ser informado
            $txt .= str_pad('0', 6, ' ', STR_PAD_RIGHT); // Codigo da Animação 0 = sem animação
            $txt .= str_pad(' ', 6, ' ', STR_PAD_RIGHT); // Campo numerico para uso libre
            $txt .= chr(13);
        }
        
        // Cria arquivo CLIENTE.TXT
        $fp = fopen('pre/producao//CLIENTE.txt', 'w');
        fwrite($fp, $txt);
        fclose($fp);
        
        // ***********************************************************************************
        // Codigo de IPI
        
        $Data_IPI = array(
            0 => array(
                'ID_IPI' => '100',
                'CST' => '00',
                'DESCRICAO' => 'Entrada com Recuperacao de Credito'
            ),
            1 => array(
                'ID_IPI' => '101',
                'CST' => '01',
                'DESCRICAO' => 'Entrada Tributavel com Aliquota Zero'
            ),
            2 => array(
                'ID_IPI' => '102',
                'CST' => '02',
                'DESCRICAO' => 'Entrada Isenta'
            ),
            3 => array(
                'ID_IPI' => '103',
                'CST' => '03',
                'DESCRICAO' => 'Entrada Nao-Tributada'
            ),
            4 => array(
                'ID_IPI' => '104',
                'CST' => '04',
                'DESCRICAO' => 'Entrada Imune'
            ),
            5 => array(
                'ID_IPI' => '105',
                'CST' => '05',
                'DESCRICAO' => 'Entrada com Suspensao'
            ),
            6 => array(
                'ID_IPI' => '149',
                'CST' => '49',
                'DESCRICAO' => 'Outras Entradas'
            ),
            7 => array(
                'ID_IPI' => '150',
                'CST' => '50',
                'DESCRICAO' => 'Saida Tributada'
            ),
            8 => array(
                'ID_IPI' => '151',
                'CST' => '51',
                'DESCRICAO' => 'Saida Tributável com Aliquota Zero'
            ),
            9 => array(
                'ID_IPI' => '152',
                'CST' => '52',
                'DESCRICAO' => 'Saida Isenta'
            ),
            10 => array(
                'ID_IPI' => '153',
                'CST' => '53',
                'DESCRICAO' => 'Saida Não-Tributada'
            ),
            11 => array(
                'ID_IPI' => '154',
                'CST' => '54',
                'DESCRICAO' => 'Saida Imune'
            ),
            12 => array(
                'ID_IPI' => '155',
                'CST' => '55',
                'DESCRICAO' => 'Saida com Suspensao'
            ),
            13 => array(
                'ID_IPI' => '199',
                'CST' => '99',
                'DESCRICAO' => 'Outras Saidas'
            )
        );
        
        $txt = '';
        foreach ($Data_IPI as $ipi) {
            $txt .= str_pad($ipi['ID_IPI'], 6, ' ', STR_PAD_LEFT); // Codigo do IPI
            $txt .= str_pad($ipi['DESCRICAO'], 60, ' ', STR_PAD_LEFT); // Descrição do IPI
            $txt .= str_pad(' ', 5, ' ', STR_PAD_LEFT); // Classe Enquadramento
            $txt .= str_pad(' ', 14, ' ', STR_PAD_LEFT); // CNPJ do Produtor
            $txt .= str_pad(' ', 60, ' ', STR_PAD_LEFT); // Selo de Controle
            $txt .= str_pad(' ', 3, ' ', STR_PAD_LEFT); // Codigo Enquadramento
            $txt .= str_pad($ipi['CST'], 2, ' ', STR_PAD_LEFT); // Codigo CST
            $txt .= str_pad('P', 1, ' ', STR_PAD_LEFT); //
            $txt .= str_pad('0', 5, ' ', STR_PAD_RIGHT); //
            $txt .= str_pad('0', 4, ' ', STR_PAD_RIGHT); //
            $txt .= str_pad('0', 10, ' ', STR_PAD_RIGHT); // Tipo de IPI igual
            $txt .= str_pad('S', 1, ' ', STR_PAD_RIGHT); // Soma a base de cálculo do ICMS
            $txt .= str_pad('S', 1, ' ', STR_PAD_RIGHT); // Soma a base de cálculo do ICMS ST
            
            $txt .= chr(13);
        }
        
        // Cria arquivo IPI.TXT
        $fp = fopen('pre/producao//IPI.txt', 'w');
        fwrite($fp, $txt);
        fclose($fp);
        
        // ***********************************************************************************
        // LISTA DE ICMS
        
        $Data_ICMS = array(
            0 => array(
                'ID_ICMS' => '0101',
                'CST' => '101',
                'DESCRICAO' => 'Tributada com Permissao de Credito'
            ),
            1 => array(
                'ID_ICMS' => '0102',
                'CST' => '102',
                'DESCRICAO' => 'Tributada sem permissão de Credito'
            ),
            2 => array(
                'ID_ICMS' => '0103',
                'CST' => '103',
                'DESCRICAO' => 'Isencao de ICMS para faixa de receita bruta'
            ),
            3 => array(
                'ID_ICMS' => '0201',
                'CST' => '201',
                'DESCRICAO' => 'Tributada com permissao de credito e com combranca do ICMS por ST'
            ),
            4 => array(
                'ID_ICMS' => '0202',
                'CST' => '202',
                'DESCRICAO' => 'Tributada sem permissao de credito e com combranca do ICMS por ST'
            ),
            5 => array(
                'ID_ICMS' => '0203',
                'CST' => '203',
                'DESCRICAO' => 'Isenção do ICMS para faixa de recita bruta e com cobranca de ICMS por ST'
            ),
            6 => array(
                'ID_ICMS' => '0300',
                'CST' => '300',
                'DESCRICAO' => 'Imune'
            ),
            7 => array(
                'ID_ICMS' => '0400',
                'CST' => '400',
                'DESCRICAO' => 'Nao Tributada'
            ),
            8 => array(
                'ID_ICMS' => '0500',
                'CST' => '500',
                'DESCRICAO' => 'ICMS cobrado anteriormente por ST ou por antecipacao'
            ),
            9 => array(
                'ID_ICMS' => '0900',
                'CST' => '900',
                'DESCRICAO' => 'Outros'
            ),
            
            10 => array(
                'ID_ICMS' => '1101',
                'CST' => '101',
                'DESCRICAO' => 'Tributada com Permissao de Credito'
            ),
            11 => array(
                'ID_ICMS' => '1102',
                'CST' => '102',
                'DESCRICAO' => 'Tributada sem permissão de Credito'
            ),
            12 => array(
                'ID_ICMS' => '1103',
                'CST' => '103',
                'DESCRICAO' => 'Isencao de ICMS para faixa de receita bruta'
            ),
            13 => array(
                'ID_ICMS' => '1201',
                'CST' => '201',
                'DESCRICAO' => 'Tributada com permissao de credito e com combranca do ICMS por ST'
            ),
            14 => array(
                'ID_ICMS' => '1202',
                'CST' => '202',
                'DESCRICAO' => 'Tributada sem permissao de credito e com combranca do ICMS por ST'
            ),
            15 => array(
                'ID_ICMS' => '1203',
                'CST' => '203',
                'DESCRICAO' => 'Isenção do ICMS para faixa de recita bruta e com cobranca de ICMS por ST'
            ),
            16 => array(
                'ID_ICMS' => '1300',
                'CST' => '300',
                'DESCRICAO' => 'Imune'
            ),
            17 => array(
                'ID_ICMS' => '1400',
                'CST' => '400',
                'DESCRICAO' => 'Nao Tributada'
            ),
            18 => array(
                'ID_ICMS' => '1500',
                'CST' => '500',
                'DESCRICAO' => 'ICMS cobrado anteriormente por ST ou por antecipacao'
            ),
            19 => array(
                'ID_ICMS' => '1900',
                'CST' => '900',
                'DESCRICAO' => 'Outros'
            ),
            
            20 => array(
                'ID_ICMS' => '2101',
                'CST' => '101',
                'DESCRICAO' => 'Tributada com Permissao de Credito'
            ),
            21 => array(
                'ID_ICMS' => '2102',
                'CST' => '102',
                'DESCRICAO' => 'Tributada sem permissão de Credito'
            ),
            22 => array(
                'ID_ICMS' => '2103',
                'CST' => '103',
                'DESCRICAO' => 'Isencao de ICMS para faixa de receita bruta'
            ),
            23 => array(
                'ID_ICMS' => '2201',
                'CST' => '201',
                'DESCRICAO' => 'Tributada com permissao de credito e com combranca do ICMS por ST'
            ),
            24 => array(
                'ID_ICMS' => '2202',
                'CST' => '202',
                'DESCRICAO' => 'Tributada sem permissao de credito e com combranca do ICMS por ST'
            ),
            25 => array(
                'ID_ICMS' => '2203',
                'CST' => '203',
                'DESCRICAO' => 'Isenção do ICMS para faixa de recita bruta e com cobranca de ICMS por ST'
            ),
            26 => array(
                'ID_ICMS' => '2300',
                'CST' => '300',
                'DESCRICAO' => 'Imune'
            ),
            27 => array(
                'ID_ICMS' => '2400',
                'CST' => '400',
                'DESCRICAO' => 'Nao Tributada'
            ),
            28 => array(
                'ID_ICMS' => '2500',
                'CST' => '500',
                'DESCRICAO' => 'ICMS cobrado anteriormente por ST ou por antecipacao'
            ),
            29 => array(
                'ID_ICMS' => '2900',
                'CST' => '900',
                'DESCRICAO' => 'Outros'
            ),
            
            30 => array(
                'ID_ICMS' => '3101',
                'CST' => '101',
                'DESCRICAO' => 'Tributada com Permissao de Credito'
            ),
            31 => array(
                'ID_ICMS' => '3102',
                'CST' => '102',
                'DESCRICAO' => 'Tributada sem permissão de Credito'
            ),
            32 => array(
                'ID_ICMS' => '3103',
                'CST' => '103',
                'DESCRICAO' => 'Isencao de ICMS para faixa de receita bruta'
            ),
            33 => array(
                'ID_ICMS' => '3201',
                'CST' => '201',
                'DESCRICAO' => 'Tributada com permissao de credito e com combranca do ICMS por ST'
            ),
            34 => array(
                'ID_ICMS' => '3202',
                'CST' => '202',
                'DESCRICAO' => 'Tributada sem permissao de credito e com combranca do ICMS por ST'
            ),
            35 => array(
                'ID_ICMS' => '3203',
                'CST' => '203',
                'DESCRICAO' => 'Isenção do ICMS para faixa de recita bruta e com cobranca de ICMS por ST'
            ),
            36 => array(
                'ID_ICMS' => '3300',
                'CST' => '300',
                'DESCRICAO' => 'Imune'
            ),
            37 => array(
                'ID_ICMS' => '3400',
                'CST' => '400',
                'DESCRICAO' => 'Nao Tributada'
            ),
            38 => array(
                'ID_ICMS' => '3500',
                'CST' => '500',
                'DESCRICAO' => 'ICMS cobrado anteriormente por ST ou por antecipacao'
            ),
            39 => array(
                'ID_ICMS' => '3900',
                'CST' => '900',
                'DESCRICAO' => 'Outros'
            ),
            
            40 => array(
                'ID_ICMS' => '4101',
                'CST' => '101',
                'DESCRICAO' => 'Tributada com Permissao de Credito'
            ),
            41 => array(
                'ID_ICMS' => '4102',
                'CST' => '102',
                'DESCRICAO' => 'Tributada sem permissão de Credito'
            ),
            42 => array(
                'ID_ICMS' => '4103',
                'CST' => '103',
                'DESCRICAO' => 'Isencao de ICMS para faixa de receita bruta'
            ),
            43 => array(
                'ID_ICMS' => '4201',
                'CST' => '201',
                'DESCRICAO' => 'Tributada com permissao de credito e com combranca do ICMS por ST'
            ),
            44 => array(
                'ID_ICMS' => '4202',
                'CST' => '202',
                'DESCRICAO' => 'Tributada sem permissao de credito e com combranca do ICMS por ST'
            ),
            45 => array(
                'ID_ICMS' => '4203',
                'CST' => '203',
                'DESCRICAO' => 'Isenção do ICMS para faixa de recita bruta e com cobranca de ICMS por ST'
            ),
            46 => array(
                'ID_ICMS' => '4300',
                'CST' => '300',
                'DESCRICAO' => 'Imune'
            ),
            47 => array(
                'ID_ICMS' => '4400',
                'CST' => '400',
                'DESCRICAO' => 'Nao Tributada'
            ),
            48 => array(
                'ID_ICMS' => '4500',
                'CST' => '500',
                'DESCRICAO' => 'ICMS cobrado anteriormente por ST ou por antecipacao'
            ),
            49 => array(
                'ID_ICMS' => '4900',
                'CST' => '900',
                'DESCRICAO' => 'Outros'
            ),
            
            50 => array(
                'ID_ICMS' => '5101',
                'CST' => '101',
                'DESCRICAO' => 'Tributada com Permissao de Credito'
            ),
            51 => array(
                'ID_ICMS' => '5102',
                'CST' => '102',
                'DESCRICAO' => 'Tributada sem permissão de Credito'
            ),
            52 => array(
                'ID_ICMS' => '5103',
                'CST' => '103',
                'DESCRICAO' => 'Isencao de ICMS para faixa de receita bruta'
            ),
            53 => array(
                'ID_ICMS' => '5201',
                'CST' => '201',
                'DESCRICAO' => 'Tributada com permissao de credito e com combranca do ICMS por ST'
            ),
            54 => array(
                'ID_ICMS' => '5202',
                'CST' => '202',
                'DESCRICAO' => 'Tributada sem permissao de credito e com combranca do ICMS por ST'
            ),
            55 => array(
                'ID_ICMS' => '5203',
                'CST' => '203',
                'DESCRICAO' => 'Isenção do ICMS para faixa de recita bruta e com cobranca de ICMS por ST'
            ),
            56 => array(
                'ID_ICMS' => '5300',
                'CST' => '300',
                'DESCRICAO' => 'Imune'
            ),
            57 => array(
                'ID_ICMS' => '5400',
                'CST' => '400',
                'DESCRICAO' => 'Nao Tributada'
            ),
            58 => array(
                'ID_ICMS' => '5500',
                'CST' => '500',
                'DESCRICAO' => 'ICMS cobrado anteriormente por ST ou por antecipacao'
            ),
            59 => array(
                'ID_ICMS' => '5900',
                'CST' => '900',
                'DESCRICAO' => 'Outros'
            ),
            
            60 => array(
                'ID_ICMS' => '6101',
                'CST' => '101',
                'DESCRICAO' => 'Tributada com Permissao de Credito'
            ),
            61 => array(
                'ID_ICMS' => '6102',
                'CST' => '102',
                'DESCRICAO' => 'Tributada sem permissão de Credito'
            ),
            62 => array(
                'ID_ICMS' => '6103',
                'CST' => '103',
                'DESCRICAO' => 'Isencao de ICMS para faixa de receita bruta'
            ),
            63 => array(
                'ID_ICMS' => '6201',
                'CST' => '201',
                'DESCRICAO' => 'Tributada com permissao de credito e com combranca do ICMS por ST'
            ),
            64 => array(
                'ID_ICMS' => '6202',
                'CST' => '202',
                'DESCRICAO' => 'Tributada sem permissao de credito e com combranca do ICMS por ST'
            ),
            65 => array(
                'ID_ICMS' => '6203',
                'CST' => '203',
                'DESCRICAO' => 'Isenção do ICMS para faixa de recita bruta e com cobranca de ICMS por ST'
            ),
            66 => array(
                'ID_ICMS' => '6300',
                'CST' => '300',
                'DESCRICAO' => 'Imune'
            ),
            67 => array(
                'ID_ICMS' => '6400',
                'CST' => '400',
                'DESCRICAO' => 'Nao Tributada'
            ),
            68 => array(
                'ID_ICMS' => '6500',
                'CST' => '500',
                'DESCRICAO' => 'ICMS cobrado anteriormente por ST ou por antecipacao'
            ),
            69 => array(
                'ID_ICMS' => '6900',
                'CST' => '900',
                'DESCRICAO' => 'Outros'
            ),
            
            70 => array(
                'ID_ICMS' => '7101',
                'CST' => '101',
                'DESCRICAO' => 'Tributada com Permissao de Credito'
            ),
            71 => array(
                'ID_ICMS' => '7102',
                'CST' => '102',
                'DESCRICAO' => 'Tributada sem permissão de Credito'
            ),
            72 => array(
                'ID_ICMS' => '7103',
                'CST' => '103',
                'DESCRICAO' => 'Isencao de ICMS para faixa de receita bruta'
            ),
            73 => array(
                'ID_ICMS' => '7201',
                'CST' => '201',
                'DESCRICAO' => 'Tributada com permissao de credito e com combranca do ICMS por ST'
            ),
            74 => array(
                'ID_ICMS' => '7202',
                'CST' => '202',
                'DESCRICAO' => 'Tributada sem permissao de credito e com combranca do ICMS por ST'
            ),
            75 => array(
                'ID_ICMS' => '7203',
                'CST' => '203',
                'DESCRICAO' => 'Isenção do ICMS para faixa de recita bruta e com cobranca de ICMS por ST'
            ),
            76 => array(
                'ID_ICMS' => '7300',
                'CST' => '300',
                'DESCRICAO' => 'Imune'
            ),
            77 => array(
                'ID_ICMS' => '7400',
                'CST' => '400',
                'DESCRICAO' => 'Nao Tributada'
            ),
            78 => array(
                'ID_ICMS' => '7500',
                'CST' => '500',
                'DESCRICAO' => 'ICMS cobrado anteriormente por ST ou por antecipacao'
            ),
            79 => array(
                'ID_ICMS' => '7900',
                'CST' => '900',
                'DESCRICAO' => 'Outros'
            ),
            
            80 => array(
                'ID_ICMS' => '8101',
                'CST' => '101',
                'DESCRICAO' => 'Tributada com Permissao de Credito'
            ),
            81 => array(
                'ID_ICMS' => '8102',
                'CST' => '102',
                'DESCRICAO' => 'Tributada sem permissão de Credito'
            ),
            82 => array(
                'ID_ICMS' => '8103',
                'CST' => '103',
                'DESCRICAO' => 'Isencao de ICMS para faixa de receita bruta'
            ),
            83 => array(
                'ID_ICMS' => '8201',
                'CST' => '201',
                'DESCRICAO' => 'Tributada com permissao de credito e com combranca do ICMS por ST'
            ),
            84 => array(
                'ID_ICMS' => '8202',
                'CST' => '202',
                'DESCRICAO' => 'Tributada sem permissao de credito e com combranca do ICMS por ST'
            ),
            85 => array(
                'ID_ICMS' => '8203',
                'CST' => '203',
                'DESCRICAO' => 'Isenção do ICMS para faixa de recita bruta e com cobranca de ICMS por ST'
            ),
            86 => array(
                'ID_ICMS' => '8300',
                'CST' => '300',
                'DESCRICAO' => 'Imune'
            ),
            87 => array(
                'ID_ICMS' => '8400',
                'CST' => '400',
                'DESCRICAO' => 'Nao Tributada'
            ),
            88 => array(
                'ID_ICMS' => '8500',
                'CST' => '500',
                'DESCRICAO' => 'ICMS cobrado anteriormente por ST ou por antecipacao'
            ),
            89 => array(
                'ID_ICMS' => '8900',
                'CST' => '900',
                'DESCRICAO' => 'Outros'
            )
        );
        
        $txt = '';
        foreach ($Data_ICMS as $icms) {
            $txt .= str_pad($icms['ID_ICMS'], 6, ' ', STR_PAD_LEFT); // Codigo do ICMS
            $txt .= substr(str_pad(utf8_decode($icms['DESCRICAO']), 60, ' ', STR_PAD_RIGHT), 0, 60); // Descrição do ICMS
            $txt .= str_pad($icms['CST'], 2, ' ', STR_PAD_RIGHT); // CST
            $txt .= str_pad('0', 31, '0', STR_PAD_RIGHT); // ESPAÇO
            $txt .= str_pad($icms['ID_ICMS'], 6, ' ', STR_PAD_RIGHT); // CALCULO TIPO DE CSOSN
            $txt .= str_pad('0', 22, '0', STR_PAD_RIGHT); // ESPAÇO
            
            $txt .= chr(13);
        }
        
        // Cria arquivo PIS.TXT
        $fp = fopen('pre/producao//ICMS.txt', 'w');
        fwrite($fp, $txt);
        fclose($fp);
        
        // ***********************************************************************************
        // LISTA DE PIS / Confis
        
        $Data_PIS = array(
            
            0 => array(
                'ID_PIS' => '01',
                'CST' => '01',
                'DESCRICAO' => '01 - Operação Tributável com Alíquota Básica',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            1 => array(
                'ID_PIS' => '02',
                'CST' => '02',
                'DESCRICAO' => '02 - Operação Tributável com Alíquota Diferenciada',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            2 => array(
                'ID_PIS' => '03',
                'CST' => '03',
                'DESCRICAO' => '03 - Operação Tributável com Alíquota por Unidade de Medida de Produto',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            3 => array(
                'ID_PIS' => '04',
                'CST' => '04',
                'DESCRICAO' => '04 - Operação Tributável Monofásica - Revenda a Alíquota Zero',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            4 => array(
                'ID_PIS' => '05',
                'CST' => '05',
                'DESCRICAO' => '05 - Operação Tributável por Substituição Tributária',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            5 => array(
                'ID_PIS' => '06',
                'CST' => '06',
                'DESCRICAO' => '06 - Operação Tributável a Alíquota Zero',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            6 => array(
                'ID_PIS' => '07',
                'CST' => '07',
                'DESCRICAO' => '07 - Operação Isenta da Contribuição',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            7 => array(
                'ID_PIS' => '08',
                'CST' => '08',
                'DESCRICAO' => '08 - Operação sem Incidência da Contribuição',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            8 => array(
                'ID_PIS' => '09',
                'CST' => '09',
                'DESCRICAO' => '09 - Operação com Suspensão da Contribuição',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            9 => array(
                'ID_PIS' => '49',
                'CST' => '49',
                'DESCRICAO' => '49 - Outras Operações de Saída',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            10 => array(
                'ID_PIS' => '50',
                'CST' => '50',
                'DESCRICAO' => '50 - Operação com Direito a Crédito - Vinculada Exclusivamente a Receita Tributada no Mercado Interno',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            11 => array(
                'ID_PIS' => '51',
                'CST' => '51',
                'DESCRICAO' => '51 - Operação com Direito a Crédito – Vinculada Exclusivamente a Receita Não Tributada no Mercado Interno',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            12 => array(
                'ID_PIS' => '52',
                'CST' => '52',
                'DESCRICAO' => '52 - Operação com Direito a Crédito - Vinculada Exclusivamente a Receita de Exportação',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            13 => array(
                'ID_PIS' => '53',
                'CST' => '53',
                'DESCRICAO' => '53 - Operação com Direito a Crédito - Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            14 => array(
                'ID_PIS' => '54',
                'CST' => '54',
                'DESCRICAO' => '54 - Operação com Direito a Crédito - Vinculada a Receitas Tributadas no Mercado Interno e de Exportação',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            15 => array(
                'ID_PIS' => '55',
                'CST' => '55',
                'DESCRICAO' => '55 - Operação com Direito a Crédito - Vinculada a Receitas Não-Tributadas no Mercado Interno e de Exportação',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            16 => array(
                'ID_PIS' => '56',
                'CST' => '56',
                'DESCRICAO' => '56 - Operação com Direito a Crédito - Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno, e de Exportação',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            17 => array(
                'ID_PIS' => '60',
                'CST' => '60',
                'DESCRICAO' => '60 - Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita Tributada no Mercado Interno',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            18 => array(
                'ID_PIS' => '61',
                'CST' => '61',
                'DESCRICAO' => '61 - Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita Não-Tributada no Mercado Interno',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            19 => array(
                'ID_PIS' => '62',
                'CST' => '62',
                'DESCRICAO' => '62 - Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita de Exportação',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            20 => array(
                'ID_PIS' => '63',
                'CST' => '63',
                'DESCRICAO' => '63 - Crédito Presumido - Operação de Aquisição Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            21 => array(
                'ID_PIS' => '64',
                'CST' => '64',
                'DESCRICAO' => '64 - Crédito Presumido - Operação de Aquisição Vinculada a Receitas Tributadas no Mercado Interno e de Exportação',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            22 => array(
                'ID_PIS' => '65',
                'CST' => '65',
                'DESCRICAO' => '65 - Crédito Presumido - Operação de Aquisição Vinculada a Receitas Não-Tributadas no Mercado Interno e de Exportação',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            23 => array(
                'ID_PIS' => '66',
                'CST' => '66',
                'DESCRICAO' => '66 - Crédito Presumido - Operação de Aquisição Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno, e de Exportação',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            24 => array(
                'ID_PIS' => '67',
                'CST' => '67',
                'DESCRICAO' => '67 - Crédito Presumido - Outras Operações',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            25 => array(
                'ID_PIS' => '70',
                'CST' => '70',
                'DESCRICAO' => '70 - Operação de Aquisição sem Direito a Crédito',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            26 => array(
                'ID_PIS' => '71',
                'CST' => '71',
                'DESCRICAO' => '71 - Operação de Aquisição com Isenção',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            27 => array(
                'ID_PIS' => '72',
                'CST' => '72',
                'DESCRICAO' => '72 - Operação de Aquisição com Suspensão',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            28 => array(
                'ID_PIS' => '73',
                'CST' => '73',
                'DESCRICAO' => '73 - Operação de Aquisição a Alíquota Zero',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            29 => array(
                'ID_PIS' => '74',
                'CST' => '74',
                'DESCRICAO' => '74 - Operação de Aquisição sem Incidência da Contribuição',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            30 => array(
                'ID_PIS' => '75',
                'CST' => '75',
                'DESCRICAO' => '75 - Operação de Aquisição por Substituição Tributária',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            31 => array(
                'ID_PIS' => '98',
                'CST' => '98',
                'DESCRICAO' => '98 - Outras Operações de Entrada',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            32 => array(
                'ID_PIS' => '99',
                'CST' => '99',
                'DESCRICAO' => '99 - Outras Operações',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            )
        );
        
        $txt = '';
        foreach ($Data_PIS as $pis) {
            $txt .= str_pad($pis['ID_PIS'], 6, ' ', STR_PAD_LEFT); // Codigo do PIS
            $txt .= substr(str_pad(utf8_decode($pis['DESCRICAO']), 60, ' ', STR_PAD_RIGHT), 0, 60); // Descrição do PIS
            $txt .= str_pad($pis['CST'], 2, ' ', STR_PAD_RIGHT); // CST
            $txt .= str_pad($pis['CALCULO'], 1, ' ', STR_PAD_RIGHT); // CALCULO TIPO DE PIS
            $txt .= str_pad($pis['BC'], 5, ' ', STR_PAD_RIGHT); // BASE DE CALCULO
            $txt .= str_pad($pis['Aliquota'], 4, ' ', STR_PAD_RIGHT); // Codigo Enquadramento
            $txt .= str_pad($pis['ValorUnidade'], 10, '0', STR_PAD_LEFT); // Valor do PIS
            
            $txt .= chr(13);
        }
        
        // Cria arquivo PIS.TXT
        $fp = fopen('pre/producao//PIS.txt', 'w');
        fwrite($fp, $txt);
        fclose($fp);
        
        $Data_PISST = array(
            
            0 => array(
                'ID_PIS' => '01',
                'CST' => '01',
                'DESCRICAO' => '01 - Operação Tributável com Alíquota Básica',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            1 => array(
                'ID_PIS' => '02',
                'CST' => '02',
                'DESCRICAO' => '02 - Operação Tributável com Alíquota Diferenciada',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            2 => array(
                'ID_PIS' => '03',
                'CST' => '03',
                'DESCRICAO' => '03 - Operação Tributável com Alíquota por Unidade de Medida de Produto',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            3 => array(
                'ID_PIS' => '04',
                'CST' => '04',
                'DESCRICAO' => '04 - Operação Tributável Monofásica - Revenda a Alíquota Zero',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            4 => array(
                'ID_PIS' => '05',
                'CST' => '05',
                'DESCRICAO' => '05 - Operação Tributável por Substituição Tributária',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            5 => array(
                'ID_PIS' => '06',
                'CST' => '06',
                'DESCRICAO' => '06 - Operação Tributável a Alíquota Zero',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            6 => array(
                'ID_PIS' => '07',
                'CST' => '07',
                'DESCRICAO' => '07 - Operação Isenta da Contribuição',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            7 => array(
                'ID_PIS' => '08',
                'CST' => '08',
                'DESCRICAO' => '08 - Operação sem Incidência da Contribuição',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            8 => array(
                'ID_PIS' => '09',
                'CST' => '09',
                'DESCRICAO' => '09 - Operação com Suspensão da Contribuição',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            9 => array(
                'ID_PIS' => '49',
                'CST' => '49',
                'DESCRICAO' => '49 - Outras Operações de Saída',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            10 => array(
                'ID_PIS' => '50',
                'CST' => '50',
                'DESCRICAO' => '50 - Operação com Direito a Crédito - Vinculada Exclusivamente a Receita Tributada no Mercado Interno',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            11 => array(
                'ID_PIS' => '51',
                'CST' => '51',
                'DESCRICAO' => '51 - Operação com Direito a Crédito – Vinculada Exclusivamente a Receita Não Tributada no Mercado Interno',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            12 => array(
                'ID_PIS' => '52',
                'CST' => '52',
                'DESCRICAO' => '52 - Operação com Direito a Crédito - Vinculada Exclusivamente a Receita de Exportação',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            13 => array(
                'ID_PIS' => '53',
                'CST' => '53',
                'DESCRICAO' => '53 - Operação com Direito a Crédito - Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            14 => array(
                'ID_PIS' => '54',
                'CST' => '54',
                'DESCRICAO' => '54 - Operação com Direito a Crédito - Vinculada a Receitas Tributadas no Mercado Interno e de Exportação',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            15 => array(
                'ID_PIS' => '55',
                'CST' => '55',
                'DESCRICAO' => '55 - Operação com Direito a Crédito - Vinculada a Receitas Não-Tributadas no Mercado Interno e de Exportação',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            16 => array(
                'ID_PIS' => '56',
                'CST' => '56',
                'DESCRICAO' => '56 - Operação com Direito a Crédito - Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno, e de Exportação',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            17 => array(
                'ID_PIS' => '60',
                'CST' => '60',
                'DESCRICAO' => '60 - Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita Tributada no Mercado Interno',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            18 => array(
                'ID_PIS' => '61',
                'CST' => '61',
                'DESCRICAO' => '61 - Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita Não-Tributada no Mercado Interno',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            19 => array(
                'ID_PIS' => '62',
                'CST' => '62',
                'DESCRICAO' => '62 - Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita de Exportação',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            20 => array(
                'ID_PIS' => '63',
                'CST' => '63',
                'DESCRICAO' => '63 - Crédito Presumido - Operação de Aquisição Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            21 => array(
                'ID_PIS' => '64',
                'CST' => '64',
                'DESCRICAO' => '64 - Crédito Presumido - Operação de Aquisição Vinculada a Receitas Tributadas no Mercado Interno e de Exportação',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            22 => array(
                'ID_PIS' => '65',
                'CST' => '65',
                'DESCRICAO' => '65 - Crédito Presumido - Operação de Aquisição Vinculada a Receitas Não-Tributadas no Mercado Interno e de Exportação',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            23 => array(
                'ID_PIS' => '66',
                'CST' => '66',
                'DESCRICAO' => '66 - Crédito Presumido - Operação de Aquisição Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno, e de Exportação',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            24 => array(
                'ID_PIS' => '67',
                'CST' => '67',
                'DESCRICAO' => '67 - Crédito Presumido - Outras Operações',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            25 => array(
                'ID_PIS' => '70',
                'CST' => '70',
                'DESCRICAO' => '70 - Operação de Aquisição sem Direito a Crédito',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            26 => array(
                'ID_PIS' => '71',
                'CST' => '71',
                'DESCRICAO' => '71 - Operação de Aquisição com Isenção',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            27 => array(
                'ID_PIS' => '72',
                'CST' => '72',
                'DESCRICAO' => '72 - Operação de Aquisição com Suspensão',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            28 => array(
                'ID_PIS' => '73',
                'CST' => '73',
                'DESCRICAO' => '73 - Operação de Aquisição a Alíquota Zero',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            29 => array(
                'ID_PIS' => '74',
                'CST' => '74',
                'DESCRICAO' => '74 - Operação de Aquisição sem Incidência da Contribuição',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            30 => array(
                'ID_PIS' => '75',
                'CST' => '75',
                'DESCRICAO' => '75 - Operação de Aquisição por Substituição Tributária',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            31 => array(
                'ID_PIS' => '98',
                'CST' => '98',
                'DESCRICAO' => '98 - Outras Operações de Entrada',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            32 => array(
                'ID_PIS' => '99',
                'CST' => '99',
                'DESCRICAO' => '99 - Outras Operações',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            )
        );
        
        $txt = '';
        foreach ($Data_PISST as $pis) {
            $txt .= str_pad($pis['ID_PIS'], 6, ' ', STR_PAD_LEFT); // Codigo do PIS
            $txt .= substr(str_pad(utf8_decode($pis['DESCRICAO']), 60, ' ', STR_PAD_RIGHT), 0, 60); // Descrição do PIS
            $txt .= str_pad($pis['CALCULO'], 1, ' ', STR_PAD_RIGHT); // CALCULO TIPO DE PIS
            $txt .= str_pad($pis['BC'], 5, ' ', STR_PAD_RIGHT); // BASE DE CALCULO
            $txt .= str_pad($pis['Aliquota'], 4, ' ', STR_PAD_RIGHT); // Codigo Enquadramento
            $txt .= str_pad($pis['ValorUnidade'], 10, '0', STR_PAD_LEFT); // Valor do PIS
            
            $txt .= chr(13);
        }
        
        // Cria arquivo PISST.TXT
        $fp = fopen('pre/producao//PISST.txt', 'w');
        fwrite($fp, $txt);
        fclose($fp);
        
        $Data_Confis = array(
            
            0 => array(
                'ID_CONFIS' => '01',
                'CST' => '01',
                'DESCRICAO' => '01 - Operação Tributável com Alíquota Básica',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            1 => array(
                'ID_CONFIS' => '02',
                'CST' => '02',
                'DESCRICAO' => '02 - Operação Tributável com Alíquota Diferenciada',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            2 => array(
                'ID_CONFIS' => '03',
                'CST' => '03',
                'DESCRICAO' => '03 - Operação Tributável com Alíquota por Unidade de Medida de Produto',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            3 => array(
                'ID_CONFIS' => '04',
                'CST' => '04',
                'DESCRICAO' => '04 - Operação Tributável Monofásica - Revenda a Alíquota Zero',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            4 => array(
                'ID_CONFIS' => '05',
                'CST' => '05',
                'DESCRICAO' => '05 - Operação Tributável por Substituição Tributária',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            5 => array(
                'ID_CONFIS' => '06',
                'CST' => '06',
                'DESCRICAO' => '06 - Operação Tributável a Alíquota Zero',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            6 => array(
                'ID_CONFIS' => '07',
                'CST' => '07',
                'DESCRICAO' => '07 - Operação Isenta da Contribuição',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            7 => array(
                'ID_CONFIS' => '08',
                'CST' => '08',
                'DESCRICAO' => '08 - Operação sem Incidência da Contribuição',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            8 => array(
                'ID_CONFIS' => '09',
                'CST' => '09',
                'DESCRICAO' => '09 - Operação com Suspensão da Contribuição',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            9 => array(
                'ID_CONFIS' => '49',
                'CST' => '49',
                'DESCRICAO' => '49 - Outras Operações de Saída',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            10 => array(
                'ID_CONFIS' => '50',
                'CST' => '50',
                'DESCRICAO' => '50 - Operação com Direito a Crédito - Vinculada Exclusivamente a Receita Tributada no Mercado Interno',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            11 => array(
                'ID_CONFIS' => '51',
                'CST' => '51',
                'DESCRICAO' => '51 - Operação com Direito a Crédito – Vinculada Exclusivamente a Receita Não Tributada no Mercado Interno',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            12 => array(
                'ID_CONFIS' => '52',
                'CST' => '52',
                'DESCRICAO' => '52 - Operação com Direito a Crédito - Vinculada Exclusivamente a Receita de Exportação',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            13 => array(
                'ID_CONFIS' => '53',
                'CST' => '53',
                'DESCRICAO' => '53 - Operação com Direito a Crédito - Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            14 => array(
                'ID_CONFIS' => '54',
                'CST' => '54',
                'DESCRICAO' => '54 - Operação com Direito a Crédito - Vinculada a Receitas Tributadas no Mercado Interno e de Exportação',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            15 => array(
                'ID_CONFIS' => '55',
                'CST' => '55',
                'DESCRICAO' => '55 - Operação com Direito a Crédito - Vinculada a Receitas Não-Tributadas no Mercado Interno e de Exportação',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            16 => array(
                'ID_CONFIS' => '56',
                'CST' => '56',
                'DESCRICAO' => '56 - Operação com Direito a Crédito - Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno, e de Exportação',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            17 => array(
                'ID_CONFIS' => '60',
                'CST' => '60',
                'DESCRICAO' => '60 - Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita Tributada no Mercado Interno',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            18 => array(
                'ID_CONFIS' => '61',
                'CST' => '61',
                'DESCRICAO' => '61 - Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita Não-Tributada no Mercado Interno',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            19 => array(
                'ID_CONFIS' => '62',
                'CST' => '62',
                'DESCRICAO' => '62 - Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita de Exportação',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            20 => array(
                'ID_CONFIS' => '63',
                'CST' => '63',
                'DESCRICAO' => '63 - Crédito Presumido - Operação de Aquisição Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            21 => array(
                'ID_CONFIS' => '64',
                'CST' => '64',
                'DESCRICAO' => '64 - Crédito Presumido - Operação de Aquisição Vinculada a Receitas Tributadas no Mercado Interno e de Exportação',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            22 => array(
                'ID_CONFIS' => '65',
                'CST' => '65',
                'DESCRICAO' => '65 - Crédito Presumido - Operação de Aquisição Vinculada a Receitas Não-Tributadas no Mercado Interno e de Exportação',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            23 => array(
                'ID_CONFIS' => '66',
                'CST' => '66',
                'DESCRICAO' => '66 - Crédito Presumido - Operação de Aquisição Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno, e de Exportação',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            24 => array(
                'ID_CONFIS' => '67',
                'CST' => '67',
                'DESCRICAO' => '67 - Crédito Presumido - Outras Operações',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            25 => array(
                'ID_CONFIS' => '70',
                'CST' => '70',
                'DESCRICAO' => '70 - Operação de Aquisição sem Direito a Crédito',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            26 => array(
                'ID_CONFIS' => '71',
                'CST' => '71',
                'DESCRICAO' => '71 - Operação de Aquisição com Isenção',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            27 => array(
                'ID_CONFIS' => '72',
                'CST' => '72',
                'DESCRICAO' => '72 - Operação de Aquisição com Suspensão',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            28 => array(
                'ID_CONFIS' => '73',
                'CST' => '73',
                'DESCRICAO' => '73 - Operação de Aquisição a Alíquota Zero',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            29 => array(
                'ID_CONFIS' => '74',
                'CST' => '74',
                'DESCRICAO' => '74 - Operação de Aquisição sem Incidência da Contribuição',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            30 => array(
                'ID_CONFIS' => '75',
                'CST' => '75',
                'DESCRICAO' => '75 - Operação de Aquisição por Substituição Tributária',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            31 => array(
                'ID_CONFIS' => '98',
                'CST' => '98',
                'DESCRICAO' => '98 - Outras Operações de Entrada',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            ),
            32 => array(
                'ID_CONFIS' => '99',
                'CST' => '99',
                'DESCRICAO' => '99 - Outras Operações',
                'CALCULO' => 'P',
                'BC' => '0',
                'Aliquota' => '000',
                'ValorUnidade' => '0,00'
            )
        );
        
        $txt = '';
        foreach ($Data_Confis as $confis) {
            $txt .= str_pad($confis['ID_CONFIS'], 6, ' ', STR_PAD_LEFT); // Codigo do PIS
            $txt .= substr(str_pad(utf8_decode($confis['DESCRICAO']), 60, ' ', STR_PAD_RIGHT), 0, 60); // Descrição do PIS
            $txt .= str_pad($confis['CST'], 2, ' ', STR_PAD_RIGHT); // CST
            $txt .= str_pad($confis['CALCULO'], 1, ' ', STR_PAD_RIGHT); // CALCULO TIPO DE PIS
            $txt .= str_pad($confis['BC'], 5, ' ', STR_PAD_RIGHT); // BASE DE CALCULO
            $txt .= str_pad($confis['Aliquota'], 4, ' ', STR_PAD_RIGHT); // Codigo Enquadramento
            $txt .= str_pad($confis['ValorUnidade'], 10, '0', STR_PAD_LEFT); // Valor do PIS
            
            $txt .= chr(13);
        }
        
        // Cria arquivo CONFINS.TXT
        $fp = fopen('pre/producao//COFINS.txt', 'w');
        fwrite($fp, $txt);
        fclose($fp);
        
        $Data_Confis = array(
            
            0 => array(
                'ID_CONFIS' => '01',
                'CST' => '01',
                'DESCRICAO' => '01 - Operação Tributável com Alíquota Básica',
                'CALCULO' => 'P',
                'BC' => '1700',
                'Aliquota' => '165',
                'ValorUnidade' => '0,00'
            ),
            1 => array(
                'ID_CONFIS' => '02',
                'CST' => '02',
                'DESCRICAO' => '02 - Operação Tributável com Alíquota Diferenciada',
                'CALCULO' => 'P',
                'BC' => '1700',
                'Aliquota' => '165',
                'ValorUnidade' => '0,00'
            ),
            2 => array(
                'ID_CONFIS' => '03',
                'CST' => '03',
                'DESCRICAO' => '03 - Operação Tributável com Alíquota por Unidade de Medida de Produto',
                'CALCULO' => 'P',
                'BC' => '1700',
                'Aliquota' => '165',
                'ValorUnidade' => '0,00'
            ),
            3 => array(
                'ID_CONFIS' => '04',
                'CST' => '04',
                'DESCRICAO' => '04 - Operação Tributável Monofásica - Revenda a Alíquota Zero',
                'CALCULO' => 'P',
                'BC' => '1700',
                'Aliquota' => '165',
                'ValorUnidade' => '0,00'
            ),
            4 => array(
                'ID_CONFIS' => '05',
                'CST' => '05',
                'DESCRICAO' => '05 - Operação Tributável por Substituição Tributária',
                'CALCULO' => 'P',
                'BC' => '1700',
                'Aliquota' => '165',
                'ValorUnidade' => '0,00'
            ),
            5 => array(
                'ID_CONFIS' => '06',
                'CST' => '06',
                'DESCRICAO' => '06 - Operação Tributável a Alíquota Zero',
                'CALCULO' => 'P',
                'BC' => '1700',
                'Aliquota' => '165',
                'ValorUnidade' => '0,00'
            ),
            6 => array(
                'ID_CONFIS' => '07',
                'CST' => '07',
                'DESCRICAO' => '07 - Operação Isenta da Contribuição',
                'CALCULO' => 'P',
                'BC' => '1700',
                'Aliquota' => '165',
                'ValorUnidade' => '0,00'
            ),
            7 => array(
                'ID_CONFIS' => '08',
                'CST' => '08',
                'DESCRICAO' => '08 - Operação sem Incidência da Contribuição',
                'CALCULO' => 'P',
                'BC' => '1700',
                'Aliquota' => '165',
                'ValorUnidade' => '0,00'
            ),
            8 => array(
                'ID_CONFIS' => '09',
                'CST' => '09',
                'DESCRICAO' => '09 - Operação com Suspensão da Contribuição',
                'CALCULO' => 'P',
                'BC' => '1700',
                'Aliquota' => '165',
                'ValorUnidade' => '0,00'
            ),
            9 => array(
                'ID_CONFIS' => '49',
                'CST' => '49',
                'DESCRICAO' => '49 - Outras Operações de Saída',
                'CALCULO' => 'P',
                'BC' => '1700',
                'Aliquota' => '165',
                'ValorUnidade' => '0,00'
            ),
            10 => array(
                'ID_CONFIS' => '50',
                'CST' => '50',
                'DESCRICAO' => '50 - Operação com Direito a Crédito - Vinculada Exclusivamente a Receita Tributada no Mercado Interno',
                'CALCULO' => 'P',
                'BC' => '1700',
                'Aliquota' => '165',
                'ValorUnidade' => '0,00'
            ),
            11 => array(
                'ID_CONFIS' => '51',
                'CST' => '51',
                'DESCRICAO' => '51 - Operação com Direito a Crédito – Vinculada Exclusivamente a Receita Não Tributada no Mercado Interno',
                'CALCULO' => 'P',
                'BC' => '1700',
                'Aliquota' => '165',
                'ValorUnidade' => '0,00'
            ),
            12 => array(
                'ID_CONFIS' => '52',
                'CST' => '52',
                'DESCRICAO' => '52 - Operação com Direito a Crédito - Vinculada Exclusivamente a Receita de Exportação',
                'CALCULO' => 'P',
                'BC' => '1700',
                'Aliquota' => '165',
                'ValorUnidade' => '0,00'
            ),
            13 => array(
                'ID_CONFIS' => '53',
                'CST' => '53',
                'DESCRICAO' => '53 - Operação com Direito a Crédito - Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno',
                'CALCULO' => 'P',
                'BC' => '1700',
                'Aliquota' => '165',
                'ValorUnidade' => '0,00'
            ),
            14 => array(
                'ID_CONFIS' => '54',
                'CST' => '54',
                'DESCRICAO' => '54 - Operação com Direito a Crédito - Vinculada a Receitas Tributadas no Mercado Interno e de Exportação',
                'CALCULO' => 'P',
                'BC' => '1700',
                'Aliquota' => '165',
                'ValorUnidade' => '0,00'
            ),
            15 => array(
                'ID_CONFIS' => '55',
                'CST' => '55',
                'DESCRICAO' => '55 - Operação com Direito a Crédito - Vinculada a Receitas Não-Tributadas no Mercado Interno e de Exportação',
                'CALCULO' => 'P',
                'BC' => '1700',
                'Aliquota' => '165',
                'ValorUnidade' => '0,00'
            ),
            16 => array(
                'ID_CONFIS' => '56',
                'CST' => '56',
                'DESCRICAO' => '56 - Operação com Direito a Crédito - Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno, e de Exportação',
                'CALCULO' => 'P',
                'BC' => '1700',
                'Aliquota' => '165',
                'ValorUnidade' => '0,00'
            ),
            17 => array(
                'ID_CONFIS' => '60',
                'CST' => '60',
                'DESCRICAO' => '60 - Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita Tributada no Mercado Interno',
                'CALCULO' => 'P',
                'BC' => '1700',
                'Aliquota' => '165',
                'ValorUnidade' => '0,00'
            ),
            18 => array(
                'ID_CONFIS' => '61',
                'CST' => '61',
                'DESCRICAO' => '61 - Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita Não-Tributada no Mercado Interno',
                'CALCULO' => 'P',
                'BC' => '1700',
                'Aliquota' => '165',
                'ValorUnidade' => '0,00'
            ),
            19 => array(
                'ID_CONFIS' => '62',
                'CST' => '62',
                'DESCRICAO' => '62 - Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita de Exportação',
                'CALCULO' => 'P',
                'BC' => '1700',
                'Aliquota' => '165',
                'ValorUnidade' => '0,00'
            ),
            20 => array(
                'ID_CONFIS' => '63',
                'CST' => '63',
                'DESCRICAO' => '63 - Crédito Presumido - Operação de Aquisição Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno',
                'CALCULO' => 'P',
                'BC' => '1700',
                'Aliquota' => '165',
                'ValorUnidade' => '0,00'
            ),
            21 => array(
                'ID_CONFIS' => '64',
                'CST' => '64',
                'DESCRICAO' => '64 - Crédito Presumido - Operação de Aquisição Vinculada a Receitas Tributadas no Mercado Interno e de Exportação',
                'CALCULO' => 'P',
                'BC' => '1700',
                'Aliquota' => '165',
                'ValorUnidade' => '0,00'
            ),
            22 => array(
                'ID_CONFIS' => '65',
                'CST' => '65',
                'DESCRICAO' => '65 - Crédito Presumido - Operação de Aquisição Vinculada a Receitas Não-Tributadas no Mercado Interno e de Exportação',
                'CALCULO' => 'P',
                'BC' => '1700',
                'Aliquota' => '165',
                'ValorUnidade' => '0,00'
            ),
            23 => array(
                'ID_CONFIS' => '66',
                'CST' => '66',
                'DESCRICAO' => '66 - Crédito Presumido - Operação de Aquisição Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno, e de Exportação',
                'CALCULO' => 'P',
                'BC' => '1700',
                'Aliquota' => '165',
                'ValorUnidade' => '0,00'
            ),
            24 => array(
                'ID_CONFIS' => '67',
                'CST' => '67',
                'DESCRICAO' => '67 - Crédito Presumido - Outras Operações',
                'CALCULO' => 'P',
                'BC' => '1700',
                'Aliquota' => '165',
                'ValorUnidade' => '0,00'
            ),
            25 => array(
                'ID_CONFIS' => '70',
                'CST' => '70',
                'DESCRICAO' => '70 - Operação de Aquisição sem Direito a Crédito',
                'CALCULO' => 'P',
                'BC' => '1700',
                'Aliquota' => '165',
                'ValorUnidade' => '0,00'
            ),
            26 => array(
                'ID_CONFIS' => '71',
                'CST' => '71',
                'DESCRICAO' => '71 - Operação de Aquisição com Isenção',
                'CALCULO' => 'P',
                'BC' => '1700',
                'Aliquota' => '165',
                'ValorUnidade' => '0,00'
            ),
            27 => array(
                'ID_CONFIS' => '72',
                'CST' => '72',
                'DESCRICAO' => '72 - Operação de Aquisição com Suspensão',
                'CALCULO' => 'P',
                'BC' => '1700',
                'Aliquota' => '165',
                'ValorUnidade' => '0,00'
            ),
            28 => array(
                'ID_CONFIS' => '73',
                'CST' => '73',
                'DESCRICAO' => '73 - Operação de Aquisição a Alíquota Zero',
                'CALCULO' => 'P',
                'BC' => '1700',
                'Aliquota' => '165',
                'ValorUnidade' => '0,00'
            ),
            29 => array(
                'ID_CONFIS' => '74',
                'CST' => '74',
                'DESCRICAO' => '74 - Operação de Aquisição sem Incidência da Contribuição',
                'CALCULO' => 'P',
                'BC' => '1700',
                'Aliquota' => '165',
                'ValorUnidade' => '0,00'
            ),
            30 => array(
                'ID_CONFIS' => '75',
                'CST' => '75',
                'DESCRICAO' => '75 - Operação de Aquisição por Substituição Tributária',
                'CALCULO' => 'P',
                'BC' => '1700',
                'Aliquota' => '165',
                'ValorUnidade' => '0,00'
            ),
            31 => array(
                'ID_CONFIS' => '98',
                'CST' => '98',
                'DESCRICAO' => '98 - Outras Operações de Entrada',
                'CALCULO' => 'P',
                'BC' => '1700',
                'Aliquota' => '165',
                'ValorUnidade' => '0,00'
            ),
            32 => array(
                'ID_CONFIS' => '99',
                'CST' => '99',
                'DESCRICAO' => '99 - Outras Operações',
                'CALCULO' => 'P',
                'BC' => '1700',
                'Aliquota' => '165',
                'ValorUnidade' => '0,00'
            )
        );
        
        $txt = '';
        foreach ($Data_Confis as $Confis) {
            $txt .= str_pad($Confis['ID_CONFIS'], 6, ' ', STR_PAD_LEFT); // Codigo do PIS
            $txt .= substr(str_pad(utf8_decode($Confis['DESCRICAO']), 60, ' ', STR_PAD_RIGHT), 0, 60); // Descrição do PIS
                                                                                                                 // $txt .= str_pad($confis['CST'], 2, ' ', STR_PAD_RIGHT); // CST
            $txt .= str_pad($Confis['CALCULO'], 1, ' ', STR_PAD_RIGHT); // CALCULO TIPO DE PIS
            $txt .= str_pad($Confis['BC'], 5, ' ', STR_PAD_LEFT); // BASE DE CALCULO
            $txt .= str_pad($Confis['Aliquota'], 4, ' ', STR_PAD_RIGHT); // Codigo Enquadramento
            $txt .= str_pad($Confis['ValorUnidade'], 10, '0', STR_PAD_LEFT); // Valor do PIS
            
            $txt .= chr(13);
        }
        
        // Cria arquivo COFINSST.TXT
        $fp = fopen('pre/producao//COFINSST.txt', 'w');
        fwrite($fp, $txt);
        fclose($fp);
        
        // ***********************************************************************************
        // LISTA DE PRODUTOS
        
        // pega registro de produtos
        $items = $this->Item->get_all();
        
        $txt = '';
        
        foreach ($items->result() as $item) {
            
            $item_cst = $this->Item->get_info_nfe($item->item_id);
            $items_business = $this->Item->get_info_business($item->item_id);
            
            $price = explode('.', $items_business->selling_price);
            if ($price[0]) {
                $SetPrice = $price[0] . $price[1] . '0';
            } else {
                $SetPrice = '0';
            }
            
            if ($item_cst->cst_ipi) {
                $ipi = '1' . $item_cst->cst_ipi;
            } else {
                $ipi = 0;
            }
            
            $txt .= str_pad($item->item_id, 20, ' ', STR_PAD_RIGHT); // Codigo do produto
            $txt .= str_pad($item->item_codebar, 20, ' ', STR_PAD_LEFT); // Codigo de barras do produto
            $txt .= substr(str_pad(removeAcento($item->description), 40, ' ', STR_PAD_RIGHT), 0, 40); // Descrição do produto
            $txt .= str_pad(removeAcento($item->category), 20, ' ', STR_PAD_RIGHT); // Complemento do produto
            $txt .= str_pad($item->unit, 4, ' ', STR_PAD_RIGHT); // Medida de Unidade UN
            $txt .= str_pad($SetPrice, 12, '0', STR_PAD_LEFT); // preço do produto
            $txt .= str_pad('0', 6, '0', STR_PAD_LEFT); // Desconto
            
            if($item->is_serialized == 1)
            { 
                $txt .= str_pad('I', 1, ' ', STR_PAD_RIGHT); // Situação Tributaria          
            }
            else 
            {
                $txt .= str_pad('F', 1, ' ', STR_PAD_RIGHT); // Situação Tributaria
            }
            
            $txt .= str_pad('0', 4, '0', STR_PAD_RIGHT); // ICMS
            $txt .= str_pad(' ', 65, ' ', STR_PAD_RIGHT); // Observações grupo seriais referente a este produto
            $txt .= str_pad('N', 1, ' ', STR_PAD_RIGHT); // Produto Pesáveis
            $txt .= str_pad('N', 1, ' ', STR_PAD_RIGHT); // Bloqueio de digitação de decimal
            $txt .= str_pad('N', 1, ' ', STR_PAD_RIGHT); // Bloqueio de informar quantidade
            $txt .= str_pad('S', 1, ' ', STR_PAD_RIGHT); // Utiliza Arrendondamento no Produto
            $txt .= str_pad('N', 1, ' ', STR_PAD_RIGHT); // Produto de produção propria
            $txt .= str_pad(' ', 6, ' ', STR_PAD_RIGHT); // Codigo do grupo
            $txt .= str_pad(' ', 30, ' ', STR_PAD_RIGHT); // Descricao_grupo
            $txt .= str_pad(' ', 6, ' ', STR_PAD_RIGHT); // Codigo do departamento
            $txt .= str_pad(' ', 30, ' ', STR_PAD_RIGHT); // Descricao departamento
            $txt .= str_pad(' ', 6, ' ', STR_PAD_RIGHT); // Codigo do marca
            $txt .= str_pad(' ', 30, ' ', STR_PAD_RIGHT); // Descricao marca
            $txt .= str_pad(' ', 6, ' ', STR_PAD_RIGHT); // Codigo do vasilhame
            $txt .= str_pad(' ', 30, ' ', STR_PAD_RIGHT); // Descricao vasilhame
            $txt .= str_pad(0, 6, ' ', STR_PAD_RIGHT); // Codigo da Animacao
            $txt .= str_pad(' ', 6, ' ', STR_PAD_RIGHT); // Flag Animação
            $txt .= str_pad($item->item_ncm, 20, ' ', STR_PAD_RIGHT); // Numero Comum do Mercosul
            $txt .= str_pad(' ', 6, ' ', STR_PAD_RIGHT); // Código do tipo de descrição
            $txt .= str_pad(' ', 20, ' ', STR_PAD_RIGHT); // Gtin_Contabil
            $txt .= str_pad(' ', 20, ' ', STR_PAD_RIGHT); // Ext IPI
            $txt .= str_pad(' ', 20, ' ', STR_PAD_RIGHT); // Gtin_Tributavel
            $txt .= str_pad($item_cst->origem . $item_cst->situacao_tributaria, 6, ' ', STR_PAD_RIGHT); // ID ICMS
            $txt .= str_pad($ipi, 6, ' ', STR_PAD_RIGHT); // ID IPI
            $txt .= str_pad(' ', 6, ' ', STR_PAD_RIGHT); // ID ISSQN
            $txt .= str_pad(' ', 6, ' ', STR_PAD_RIGHT); // Impostos de Importação
            $txt .= str_pad($item_cst->cst_pis, 6, ' ', STR_PAD_RIGHT); // CST PIS
            $txt .= str_pad($item_cst->cst_pis, 6, ' ', STR_PAD_RIGHT); // CST PIS ST
            $txt .= str_pad($item_cst->cst_confins, 6, ' ', STR_PAD_RIGHT); // CST COFINS
            $txt .= str_pad($item_cst->cst_confins, 6, ' ', STR_PAD_RIGHT); // CST COFINS ST
            $txt .= str_pad('N', 1, ' ', STR_PAD_RIGHT); // CST Produto seja um KIT
            $txt .= str_pad(' ', 12, ' ', STR_PAD_RIGHT); // Qtde Estoque
            
            $txt .= chr(13);
        }
        
        // Cria arquivo CLIENTE.TXT
        $fp = fopen('pre/producao//PRODUTO.txt', 'w');
        fwrite($fp, $txt);
        fclose($fp);
    }
}