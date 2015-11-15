<html>
<head>
<style type="text/css">
@page {
	size: auto;
	margin: 0mm;
}

body {
	font-family: sans-serif;
	margin: 0px;
}
</style>
</head>
<body>
	<table style="width: 100%; height: 100%;">
		<tr>
			<td
				style="width: 25%; height: 15%; border-left: 1px solid black; border-top: 1px solid black; text-align: center;">
				<img src="<?php echo $this->config->base_url();?>/upload/logo.png"
				style="width: 110px; height: 55px; margin-bottom: 2px;"><br> <strong><font
					style="font-size: 9px;">AudioZoom Comércio de Aparelhos Auditivos
						Ltda.</font></strong>
			</td>
			<td
				style="width: 25%; height: 15%; border-top: 1px solid black; text-align: right; font-size: 9px;">
				&nbsp;</td>
			<td
				style="width: 25%; height: 15%; border-top: 1px solid black; text-align: center;">
				&nbsp;</td>
			<td
				style="width: 25%; height: 15%; border-top: 1px solid black; border-right: 1px solid black; text-align: right; font-size: 9px;">
				Rua General Eurico Gaspar Dutra, 822 - Estreito &emsp;<br> 88070-000
				- Florianopólis - Santa Catarina &emsp;<br> CNPJ: 06.330.400/0001-41
				&emsp;<br> Inscrição Estadual: 254.805.914 &emsp;
			</td>
		</tr>
		<tr>
			<td colspan="2" style="border: 1px solid black; height: auto;">
				<table
					style="width: 100%; height: auto; font-size: 10px; padding-right: 10px;">
					<tr style="width: 20%; height: 12px; text-align: right;">
						<td colspan="6" style="text-align: center;"><h2>CONTRATO - Compra e Venda &emsp;&emsp;&emsp;&emsp; Nº <?php echo $order_sales->order;?></h2></td>
					</tr>
					<tr>
						<!-- Nome do Comprador -->
						<td style="width: 21%; height: 12px; text-align: right;"><strong>Comprador(a):</strong></td>
						<td colspan="5" style="width: 80%;"><?php echo $customer->first_name . ' ' . $customer->last_name;?></td>
					</tr>
					<tr>
						<!-- Endereço -->
						<td style="width: 15%; height: 12px; text-align: right;"><strong>Endereço:</strong></td>
						<td colspan="3"> <?php echo $customer->address_1;?></td>
						<!-- Telefone -->
						<td style="text-align: right; height: 12px;"><strong>Tel:</strong></td>
						<td colspan="2"><?php
    
    switch ($customer->phone_number) {
        case 1:
            echo $customer->phone_home;
            break;
        
        case 2:
            echo $customer->phone_work;
            break;
        
        case 3:
            echo $customer->phone_cell;
            break;
        
        case 4:
            echo $customer->phone_other;
            break;
        
        default:
            echo $customer->phone_home;
            break;
    }
    
    ?></td>
					</tr>
					<tr>
						<!-- Bairro -->
						<td style="width: 15%; height: 12px; text-align: right;"><strong>Bairro:</strong></td>
						<td><?php echo $customer->country; ?></td>
						<!-- Cidade -->
						<td style="width: 15%; height: 12px; text-align: right;"><strong>Cidade:</strong></td>
						<td><?php echo $customer->city;?></td>
						<!-- Telefone -->
						<td style="width: 15%; height: 12px; text-align: right;"><strong>Estado:</strong></td>
						<td><?php echo $customer->state; ?></td>
					</tr>
					<tr>
						<!-- Documento CPF -->
						<td style="width: 15%; height: 12px; text-align: right;"><strong>CPF:</strong></td>
						<td><?php echo $customer->document_cpf; ?></td>
						<!-- Documento RG -->
						<td style="width: 15%; height: 12px; text-align: right;"><strong>RG:</strong></td>
						<td><?php echo $customer->document_rg; ?></td>
						<!-- Numero CEP -->
						<td style="width: 15%; height: 12px; text-align: right;"><strong>CEP:</strong></td>
						<td><?php echo $customer->zip; ?></td>
					</tr>
					<tr>
						<!-- Divisor -->
						<td colspan="6"
							style="width: 15%; height: 12px; text-align: right;"></td>
					</tr>
					<tr>
						<!-- Local de Trabalho -->
						<td style="width: 15%; height: 12px; text-align: right;"><strong>Local
								de Trabalho:</strong></td>
						<td colspan="5"><?php if(isset($work->location_work)){echo $work->location_work;}?></td>
					</tr>
					<tr>
						<!-- Endereço de Trabalho -->
						<td style="width: 15%; height: 12px; text-align: right;"><strong>End.
								de Trabalho:</strong></td>
						<td colspan="3"><?php if(isset($work->address_work)){echo $work->address_work;} ?></td>
						<!-- Telefone do Trabalho -->
						<td style="width: 15%; height: 12px; text-align: right;"><strong>Tel:</strong></td>
						<td colspan="2"><?php if(isset($work->phone_work)){echo $work->phone_work;} ?></td>
					</tr>
					<tr>
						<!-- Tempo de Serviço -->
						<td style="width: 15%; height: 12px; text-align: right;"><strong>Tempo
								de Serviço:</strong></td>
						<td><?php if(isset($work->time_service)){echo $work->time_service;}?></td>
						<!-- Salário -->
						<td style="width: 15%; height: 12px; text-align: right;"><strong>Salário:</strong></td>
						<td><?php if(isset($work->salary)){echo $work->salary;}?></td>
						<!-- Outros -->
						<td style="width: 15%; height: 12px; text-align: right;"><strong>Outros:</strong></td>
						<td><?php if(isset($work->other_income)){echo $work->other_income;}?></td>
					</tr>
					<tr>
						<!-- Divisor -->
						<td colspan="6"
							style="width: 15%; height: 12px; text-align: right;"></td>
					</tr>
					<tr>
						<!-- Nome do Usuário -->
						<td style="width: 15%; height: 12px; text-align: right;"><strong>Usuário(a):</strong></td>
						<td colspan="5" style="width: 80%;"><?php echo $patient->first_name. ' ' . $patient->last_name;?></td>
					</tr>
					<tr>
						<!-- Endereço -->
						<td style="width: 15%; height: 12px; text-align: right;"><strong>Endereço:</strong></td>
						<td colspan="3"> <?php echo $patient->address_1;?></td>
						<!-- Telefone -->
						<td style="text-align: right; height: 12px;"><strong>Tel:</strong></td>
						<td colspan="2"><?php
    
    switch ($patient->phone_number) {
        case 1:
            echo $patient->phone_home;
            break;
        
        case 2:
            echo $patient->phone_work;
            break;
        
        case 3:
            echo $patient->phone_cell;
            break;
        
        case 4:
            echo $patient->phone_other;
            break;
        
        default:
            echo $patient->phone_home;
            break;
    }
    
    ?></td>
					</tr>
					<tr>
						<!-- Bairro -->
						<td style="width: 15%; height: 12px; text-align: right;"><strong>Bairro:</strong></td>
						<td><?php echo $patient->country; ?></td>
						<!-- Cidade -->
						<td style="width: 15%; height: 12px; text-align: right;"><strong>Cidade:</strong></td>
						<td><?php echo $patient->city; ?></td>
						<!-- Telefone -->
						<td style="width: 15%; height: 12px; text-align: right;"><strong>Estado:</strong></td>
						<td><?php echo $patient->state; ?></td>
					</tr>

				</table>
			</td>
			<td colspan="2"
				style="width: 100%; height: auto; border: 1px solid black; text-align: justify;">
				<table
					style="width: 100%; height: 100%; font-size: 10px; padding-right: 10px;">
					<tr style="width: 20%; height: 12px; text-align: right;">
						<td colspan="6" style="text-align: center;"><h2>CERTIFICADO DE
								GARANTIA</h2></td>
					</tr>
					<tr>
						<!-- Marca -->
						<td style="width: 21%; height: 12px; text-align: right;"><strong>Aparelho:</strong></td>
						<td colspan="2"><?php
    
    if (isset($sale_item[0])) {
        $item_result = $this->Item->get_info($sale_item[0]->item_id);
        echo $item_result->description;
    }
    ?></td>
						<!-- Número -->
						<td style="text-align: right; height: 12px;"><strong>Nº:</strong></td>
						<td colspan="1"><?php if(isset($sale_item[0])){ echo $sale_item[0]->number_serie;}?></td>
					</tr>
					<tr>
						<!-- Marca -->
						<td style="width: 21%; height: 12px; text-align: right;"><strong>Aparelho:</strong></td>
						<td colspan="2"><?php
    
    if (isset($sale_item[1])) {
        $item_result = $this->Item->get_info($sale_item[1]->item_id);
        echo $item_result->description;
    }
    ?></td>
						<!-- Número -->
						<td style="text-align: right; height: 12px;"><strong>Nº:</strong></td>
						<td colspan="2"><?php if(isset($sale_item[1])){echo $sale_item[1]->number_serie;} ?></td>
					</tr>
					<tr>
						<td colspan="6"></td>
					</tr>
					<tr>
						<!-- Aviso -->
						<td style="width: 100%; height: 12px; text-align: left;"
							colspan="6"><strong>AVISO IMPORTANTE:</strong> Este aparelho foi
							fornecido com garantia de 10 meses Assist. Téc. Gratuita dentro
							do período. O aparelho foi entregue em perfeito estado de
							funcionamento. A empresa não é responsável por qualquer perda ou
							dano causados pelo uso inadequado do mesmo. A garantia não inclui
							cápsulas de intra. A garantia perderá a validade caso o aparelho
							for aberto por empresa não autorizada.</td>
					</tr>
					<tr>
						<td colspan="2"></td>
						<!-- Válidade-->
						<td colspan="2"
							style="width: 15%; height: 12px; text-align: right;"><strong>Válido
								até:</strong> 
			  					<?php
        date_default_timezone_set('America/Sao_Paulo');
        echo date("d/m/Y", $order_sales->sale_time + strtotime("365 days"));
        ?></td>
					</tr>
					<tr>
						<td colspan="6"></td>
					</tr>
					<tr>
						<td colspan=""></td>
						<!-- Visto do representante-->
						<td style="width: 15%; height: 12px; text-align: right;">_________________________________</td>
						<td colspan="">&emsp;&emsp;</td>
						<!-- Visto do cliente-->
						<td style="width: 15%; height: 12px; text-align: right;">_________________________________</td>
					</tr>
					<tr>
						<td colspan=""></td>
						<!-- Visto do representante -->
						<td style="width: 15%; height: 12px; text-align: left;"
							colspan="2"><strong>Empresa</strong></td>
						<!-- Visto do cliente -->
						<td style="width: 15%; height: 12px; text-align: left;" colspan=""><strong>Cliente</strong></td>
					</tr>
					<tr>
						<td colspan="6"></td>
					</tr>
					<tr>
						<!-- Aviso -->
						<td style="width: 100%; height: 12px; text-align: left;"
							colspan="6"><strong>OBS:</strong> Por se tratar de um aparelho de
							origem estrangeira, de auto custo e impostos elevados não
							aceitamos devolução.</td>
					</tr>
					<tr>
						<td colspan="6"></td>
					</tr>
					<tr>
						<!-- Aviso -->
						<td style="width: 100%; height: 12px; text-align: left;"
							colspan="6">Aconselhamos que seja feita uma revisão no aparelho a
							cada 6 meses.<br>
			  						Data prevista para revisão dentro da garantia: <?php
        echo date("d/m/Y", $order_sales->sale_time + strtotime("15 days")) . ' e ' . date("d/m/Y", $order_sales->sale_time + strtotime("90 days"));
        ?> 
			  					</td>
					</tr>
					<tr>
						<td colspan="6"></td>
					</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td colspan="2"
				style="height: auto; border-left: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">
				<table
					style="width: 100%; height: 100%; font-size: 10px; padding-right: 10px;">
					<tr>
						<td colspan="6" style="text-align: center;"><h2>
								APARELHO DE USO PESSOAL<br>NEGÓCIO FIRME E IRREVOGAVEL
							</h2></td>
					</tr>
					<tr>
						<!-- Aparelho auditivo para -->
						<td style="width: 21%; height: 12px; text-align: right;"><strong>Aparelho
								Aud. para:</strong></td>
						<td colspan="4" style="width: 80%;"><?php echo $patient->first_name . ' ' . $patient->last_name; ?></td>
						<td><h3><?php if(isset($sale_item[0])){echo $sale_item[0]->color;}?> <?php if(isset($sale_item[1])){$sale_item[1]->color;}?></h3></td>
					</tr>
					<tr>
						<!-- Marca -->
						<td style="width: 21%; height: 12px; text-align: right;"><strong>Aparelho:</strong></td>
						<td colspan="2"><?php
    
    if (isset($sale_item[0])) {
        $item_result = $this->Item->get_info($sale_item[0]->item_id);
        echo $item_result->description;
    }
    ?></td>
						<!-- Número -->
						<td style="text-align: right; height: 12px;"><strong>Nº:</strong></td>
						<td colspan="2"><?php if(isset($sale_item[0])){echo $sale_item[0]->number_serie;} ?></td>
					</tr>
					<tr>
						<!-- Marca -->
						<td style="width: 21%; height: 12px; text-align: right;"><strong>Aparelho:</strong></td>
						<td colspan="2"><?php
    
    if (isset($sale_item[1])) {
        $item_result = $this->Item->get_info($sale_item[1]->item_id);
        echo $item_result->description;
    }
    ?></td>
						<!-- Número -->
						<td style="text-align: right; height: 12px;"><strong>Nº:</strong></td>
						<td colspan="2"><?php if(isset($sale_item[1])){ echo $sale_item[1]->number_serie;} ?></td>
					</tr>
					<tr>
						<!-- Valor total da compra -->
						<td style="width: 15%; height: 12px; text-align: right;"><strong>Total
								da Compra:</strong></td>
						<td colspan="5" style="width: 80%;"><?php echo $order_sales->value_sale; ?></td>
					</tr>
					<tr>
						<!-- Entrada -->
						<td style="width: 15%; height: 12px; text-align: right;"><strong>Entrada:</strong></td>
						<td><?php echo $order_sales->value_entrada; ?></td>
						<!-- Data -->
						<td style="width: 15%; height: 12px; text-align: right;"><strong>Data:</strong></td>
						<td><?php echo convert_timestamp($order_sales->sale_time); ?></td>
						<!-- Valor financiado -->
						<td style="width: 15%; height: 12px; text-align: right;"><strong>Financiado:</strong></td>
						<td><?php echo $order_sales->value_apagar; ?></td>
					</tr>
					<tr>
						<!-- Número de Parcelas -->
						<td style="width: 15%; height: 12px; text-align: right;"><strong>Nº
								de parcelas:</strong></td>
						<td><?php echo $order_sales->parcelas; ?></td>
						<!-- Valor -->
						<td style="width: 15%; height: 12px; text-align: right;"><strong>Valor:</strong></td>
						<td><?php echo $order_sales->valor_parcela; ?></td>
						<!-- Vencimento -->
						<td style="width: 15%; height: 12px; text-align: right;"><strong>Termino:</strong></td>
						<td><?php echo 	date("d/m/Y", $order_sales->sale_time + strtotime($order_sales->parcelas." months"))?></td>
					</tr>
					<tr>
						<td style="width: 15%; height: 12px; text-align: right;"><strong>Forma
								Pagamento:</strong></td>
						<td colspan="6"><?php echo $order_sales->form_pay; ?></td>
					</tr>
					<tr>
						<td colspan="6"></td>
					</tr>
				</table>
			</td>

			<td colspan="2"
				style="height: 75%; border-left: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;">
				<table
					style="width: 100%; height: 100%; font-size: 10px; padding-right: 10px;">
					<tr>
						<td colspan="6" style="text-align: center;"><h2>DECLARAÇÃO DO
								COMPRADOR</h2></td>
					</tr>
					<tr>
						<!-- Aviso -->
						<td style="width: 100%; height: 12px; text-align: left;"
							colspan="6">Declaro para todos os fins de direito que dei em
							troca por um novo aparelho à<br> Empresa: Audiozoom soluções
							auditivas<br> o aparelho usado de minha propriedade.
						</td>
					</tr>
					<tr>
						<td colspan="6"></td>
					</tr>
					<tr>
						<!-- Marca -->
						<td style="width: 21%; height: 12px; text-align: right;"><strong>Aparelho:</strong></td>
						<td colspan="2"><?php if(isset($sale_item_ald[0])){echo $sale_item_ald[0]->set_name;}?></td>
						<!-- Número -->
						<td style="text-align: right; height: 12px;"><strong>Lado:</strong></td>
						<td colspan="1"><?php if(isset($sale_item_ald[0])){ echo $sale_item_ald[0]->set_aer;}?></td>
					</tr>
					<tr>
						<!-- Marca -->
						<td style="width: 21%; height: 12px; text-align: right;"><strong>Aparelho:</strong></td>
						<td colspan="2"><?php if(isset($sale_item_ald[1])){echo $sale_item_ald[1]->set_name;} ?></td>
						<!-- Número -->
						<td style="text-align: right; height: 12px;"><strong>Lado:</strong></td>
						<td colspan="2"><?php if(isset($sale_item_ald[1])){ echo $sale_item_ald[1]->set_aer;} ?></td>
					</tr>
					<tr>
						<td colspan="6"></td>
					</tr>
					<tr>
						<!-- Aviso -->
						<td style="width: 100%; height: 12px; text-align: left;"
							colspan="6">A empresa poderá dispor como melhor lhe convier deste
							aparelho e firmo que não poderei reclamar o referido em hipótese
							alguma. Para clareza e como sendo a expressão da verdade firmo a
							presente.</td>
					</tr>
					<tr>
						<td colspan="6"></td>
					</tr>

					<!--
			  				<tr>			  					
			  					<td style="width: 100%; height: 12px; text-align: left;" colspan="6">
			  						<strong>Obs: </strong>Bláblá blá Bláblá blá Bláblá blá Bláblá blá 
			  						Bláblá blá Bláblá blá Bláblá blá Bláblá blá Bláblá blá Bláblá blá 
			  						Bláblá blá Bláblá blá Bláblá blá Bláblá blá Bláblá blá Bláblá blá 
			  						Bláblá blá Bláblá blá Bláblá blá Bláblá blá Bláblá blá Bláblá blá.
			  					</td>
			  				</tr>
			  				 -->
					<tr>
						<td colspan="5"></td>
						<!-- Data -->
						<td style="width: 15%; height: 12px; text-align: right;"><strong><?php echo date("d/m/Y");?></strong></td>
					</tr>
					<tr>
						<td colspan="6"></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>