<?php $this->load->view("partial/header"); ?>

<div id="main-content" class="main-content container-fluid">

	<div class="page-head">
		<h2>
			<i class="fontello-icon-chart-bar-3"></i>Aparelhos em Teste
		</h2>
	</div>
		
	<?php if(isset($manager_result)){echo $manager_result;}?>
		
	<div class="cl-mcont">
		<div class="row">
			<div class="col-sm-4 col-md-4 col-lg-4">
				<div class="block-flat">
					<div class="header">
						<h3 class="visible-sm visible-md">Dados do Comprador</h3>
						<h3 class="visible-lg">Dados Comprador</h3>
						<h3 class="visible-xs">Comprador</h3>
					</div>

					<div class="content">
						<div class="col-sm-12 col-md-12 col-lg-12"
							style="display: inline-block;">
	        				<?php echo form_open('sales_teste/search');?>
		                  		<input type="text"
								class="form-control col-sm-4 col-md-4 col-lx-4 parsley-validated parsley-error"
								placeholder="Buscar por CPF/CNPJ ou Telefone"
								data-original-title="Informe CPF/CNPJ ou Telefone"
								data-toggle="tooltip" name="customer" autofocus="autofocus"
								value="">
		                  	<?php echo form_close();?>
		                </div>

						<div class="col-sm-12 col-md-12 col-lg-12">
							<strong>Nome:</strong> <?php if(isset($customer_info->first_name)) { echo $customer_info->first_name . ' ' . $customer_info ->last_name;} else { echo 'Não Informado';}?><br>
							<strong>Fone:</strong> 
		                  		<?php
                    
                    if (isset($customer_info->phone_number)) {
                        
                        switch ($customer_info->phone_number) {
                            case 1:
                                echo $customer_info->phone_home;
                                break;
                            
                            case 2:
                                echo $customer_info->phone_work;
                                break;
                            
                            case 3:
                                echo $customer_info->phone_cell;
                                break;
                            
                            case 4:
                                echo $customer_info->phone_other;
                                break;
                            
                            default:
                                echo '(xx)xxxx-xxxx';
                                break;
                        }
                    } else {
                        echo '(xx) xxxx-xxxx';
                    }
                    ?> 
								<br> <strong>Endereço:</strong> 
								<?php if(isset($customer_info->address_1)) { echo $customer_info->address_1 . ' ' . $customer_info->address_2;} else { echo 'para confirmação da Rua,';}?> 
								<?php if(isset($customer_info->country)) { echo $customer_info->country;} else {echo 'Bairro,';} ?>
								<?php if(isset($customer_info->city)) { echo $customer_info->city;} else { echo 'Cidade,';}?> 
								<?php if(isset($customer_info->state)) { echo $customer_info->state;} else {echo 'Etc.';}?>								 
		                  	</div>

						<div class="col-sm-12 col-md-12 col-lg-12">&nbsp;</div>
					</div>
					<!-- end content -->
				</div>
				<!-- end block-flat -->
			</div>

			<div class="col-sm-8 col-md-8 col-lg-8">

				<div class="col-sm-12 col-md-12 col-lg-12">
					<div class="block-flat">

						<div class="header">
							<h3 class="visible-sm visible-md">Informações Aparelho</h3>
							<h3 class="visible-lg">Informações sobre Aparelho</h3>
							<h3 class="visible-xs">Aparelho</h3>
						</div>
						<div class="content">
							<?php
                   				echo form_open('sales_teste/save', array(
                        		'id' => 'teste_form',
                        		'class' => 'form-horizontal group-border-dashed',
                        		'style' => 'border-radius: 0px;'
                    			));
                    		?>
								<div class="form-group">
									<div class="col-sm-2 col-md-2 col-lg-2">
										<input name="od" id="odCheck" type="checkbox"
											<?php if(isset($customer_user_item->OD)){if($customer_user_item->OD == 1){echo 'chequed';}} ?>>
										O.D
									</div>
									<div class="col-sm-6  col-md-6 col-lg-6">
				                  		<?php echo form_dropdown('item_d',$item_list,array($item_selected_d),'id="item_d" class="select2"');?>
				                	</div>
									<div class="col-sm-4  col-md-4 col-lg-4">
										<input type="text" class="form-control" id="number_serie_d"
											name="number_serie_d" ondblclick="javascript:open_serie(1);"
											data-trigger="hover" data-placement="top"
											data-content="Com clique duplo você abre a lista de Nº Séries Disponiveis!"
											data-original-title="Dica" data-popover="popover">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-2  col-md-2 col-lg-2">
										<input name="oe" id="oeCheck" type="checkbox"
											<?php if(isset($customer_user_item->OD)){if($customer_user_item->OD == 1){echo 'chequed';}} ?>>
										O.E
									</div>
									<div class="col-sm-6  col-md-6 col-lg-6">
				                  		<?php echo form_dropdown('item_e',$item_list,array($item_selected_d),'id="item_e" class="select2"');?>
				                	</div>
									<div class="col-sm-4  col-md-4 col-lg-4">
										<input type="text" class="form-control" id="number_serie_e"
											name="number_serie_e" ondblclick="javascript:open_serie(2);"
											onchange="set_valor();" data-trigger="hover"
											data-placement="top"
											data-content="Com clique duplo você abre a lista de Nº Séries Disponiveis!"
											data-original-title="Dica" data-popover="popover">
									</div>
								</div>
								<div class="col-sm-12 col-md-12 col-lg-12" align="right">
									<button class="btn btn-default btn-flat" type="button"
										onclick="">Cancelar</button>
									<button class="btn btn-primary btn-flat" type="submit"
										onclick="">Colocar aparelho em teste</button>
								</div>
							<?php echo form_close(); ?>
						</div>

					</div>
				</div>
			</div>

		</div>



	</div>
	<!-- end row -->
</div>
<!-- end cl-mcont -->

</div>


<script
	src="<?php echo $this->config->base_url();?>web/js/jquery.min.js"></script>

<script type="text/javascript">
							
// Função responsavel por abrir um pop com a lista de numeros de serie na ordem crecente por datas. 
function open_serie(o){

	if(o == 1)
	{
		var x = document.getElementById('item_d').value;		
	}
	else
	{
		var x = document.getElementById('item_e').value;
	}	
	var arg = o +'.'+ x;	
	var URL = "<?php echo $this->config->site_url('sales/open_serie'); ?>/" + arg;
	window.open(URL, "Lista de Seriais", "width=500, height=400");
	
}

// Função responsavel por preencher o valor de acordo com aparelho marcado
function set_valor(){

	if(document.getElementById('odCheck').checked == true)
	{
		
		if(document.getElementById("number_serie_d").value > ''){
			var odItem = document.getElementById("item_d").value;	

		}else{		
			alert('Você deve marcar e associar um número série a Orelha Direita (O.D)');
		}
		
	}

	if(document.getElementById('oeCheck').checked == true){
		
		if(document.getElementById("number_serie_e").value > ''){
			var oeItem = document.getElementById("item_e").value;	

		}else{		
			alert('Você deve marcar e associar um número série a Orelha Esquerda (O.E)');
		}
		
	}

	var URL = "<?php echo $this->config->site_url('sales/set_value_for_sales');?>";
	
	if(document.getElementById('odCheck').checked == false && document.getElementById('oeCheck').checked == false){
		alert('Você deve marque uma opção (O.D ou O.E)');
	}else if (document.getElementById('odCheck').checked == true && document.getElementById('oeCheck').checked == false) {
		// post calculo so do produto OD		
		$.post(URL,{od:odItem}, function(data,status){
			var num = parseInt(data);
			document.getElementById('Valor').innerHTML = num.toFixed(2);
			document.getElementById('Total').innerHTML = num.toFixed(2);
			document.getElementById('total_value').value = num.toFixed(2);
			});
	}else if (document.getElementById('odCheck').checked == false && document.getElementById('oeCheck').checked == true) {
		// post calculo so do produto OE
		$.post(URL,{oe:oeItem}, function(data,status){
			var num = parseInt(data);
			document.getElementById('Valor').innerHTML = num.toFixed(2);
			document.getElementById('Total').innerHTML = num.toFixed(2);
			document.getElementById('total_value').value = num.toFixed(2);
			});
	}else if (document.getElementById('odCheck').checked == true && document.getElementById('oeCheck').checked == true) {
		// post soma produtos OD + OE
		$.post(URL,{od:odItem, oe:oeItem}, function(data,status){
			var num = parseInt(data);			
			document.getElementById('Valor').innerHTML = num.toFixed(2);
			document.getElementById('Total').innerHTML = num.toFixed(2);
			document.getElementById('total_value').value = num.toFixed(2);
		});
	}
	
}

function montaProposta(){

	// pegar os valores da proposta
	var total =  parseInt(document.getElementById('total_value').value);
	var start =  parseInt(document.getElementById('partial_value').value);	

	// pega valores do financiamento
	var finance =  parseInt(document.getElementById('total_finance').value);
	var parcela =  parseInt(document.getElementById('provision').value);	

	// pega valores da Transferencia Aparelho		
	var ald_value_d =  parseInt(document.getElementById('ald_value_d').value);	
	var ald_value_e = parseInt(document.getElementById('ald_value_e').value);

	var SomaDesconto = ald_value_d + ald_value_e;
	var TotalFinal   = total - SomaDesconto;	
	var Pay = finance - SomaDesconto;
	
	document.getElementById('Desconto').innerHTML = SomaDesconto.toFixed(2);
	document.getElementById('Total').innerHTML = TotalFinal.toFixed(2);
	document.getElementById('Financiado').innerHTML = finance.toFixed(2);
	document.getElementById('Entrada').innerHTML = start.toFixed(2);
	document.getElementById('Pay').innerHTML = Pay.toFixed(2);
}

// Função responsavel por abrir um pop com a ficha para registro dos dados comerciais do cliente.
// ATENÇÃO este pode vir preenchido caso já esteja contido no banco
function open_date_trade(){
	var URL = "<?php echo $this->config->site_url('sales/open_trade');?>";
	window.open(URL, "Dados Comerciais", "width=800, height=500");
}



function process_sales(){


	// valida dados sobre aparelho
	var odCheck 	= document.getElementById('odCheck').checked;
	var oeCheck		= document.getElementById('oeCheck').checked;

	var odItem 		= document.getElementById('item_d').value;
	var oeItem		= document.getElementById('item_e').value;

	var odSerie		= document.getElementById('number_serie_d').value;
	var oeSerie 	= document.getElementById('number_serie_e').value;
	
		
	// pegar os valores da proposta
	var total 		= parseInt(document.getElementById('total_value').value);
	var start 		= parseInt(document.getElementById('partial_value').value);
	var form_pay 	= document.getElementById('form_pay').value;
	
	// pega valores do financiamento
	var finance 	=  parseInt(document.getElementById('total_finance').value);
	var parcela 	=  parseInt(document.getElementById('provision').value);
	var finance_pay =  document.getElementById('form_finance').value;	

	// pega dados dos Aparelhos no ato da venda	
	var ald_OD = document.getElementById('ald_OD').checked;
	var ald_name_d = document.getElementById('ald_item_d').value;
	var ald_value_d =  parseInt(document.getElementById('ald_value_d').value);
	
	var ald_OE = document.getElementById('ald_OE').checked;
	var ald_name_e = document.getElementById('ald_item_e').value;	
	var ald_value_e = parseInt(document.getElementById('ald_value_e').value);

	// calculo da venda
	var SomaDesconto = ald_value_d + ald_value_e;
	var TotalFinal   = total - SomaDesconto;	
	var Pay = finance - SomaDesconto;

	var URL = "<?php echo $this->config->site_url('sales/save_trade');?>";
		
	$.post(URL,

			{
				// Sobre o Aparelho	
				set_direito:odCheck,
				item_direito:odItem,
				serie_direito:odSerie,

				set_esquerdo:oeCheck,
				item_esquerdo:oeItem,
				serie_esquerdo:oeSerie,

				
				// sobre a Entrada
				valor_compra:total.toFixed(2),
				valor_entrada:start.toFixed(2),
				forma_entrada:form_pay,
				
				// sobre o Financiamento				
				valor_financi:finance.toFixed(2),
				parcelas:parcela,
				forma_financi:finance_pay,

				// sobre os totais
				desconto:SomaDesconto.toFixed(2),
				subtotal:TotalFinal.toFixed(2),
				apagar:Pay.toFixed(2),
				
				// aparelho no ato da venda
				set_ald_direito:ald_OD,
				set_name_direto:ald_name_d,
				set_value_direto:ald_value_d.toFixed(2),

				set_ald_esquerdo:ald_OE,
				set_name_esquerdo:ald_name_e,
				set_value_esquerdo:ald_value_e.toFixed(2),

			},
			
			function (data, status)
			{
				
				if(data == '\nGRNTFBRC')
				{
					var myWindow = window.open("", "Garantia de Fabrica", "width=390, height=100 ,top=300,left=500");
					myWindow.document.write("<p>Este produto não possui período de garantia.</p>");
					myWindow.document.write("<form action='sales/set_garantia_fabrica' method='post'>");
					myWindow.document.write("&emsp; <button type='submit'>Confirmar</button>");	
					myWindow.document.write("</form>");
				}

				if(data == '\nGRNTFBRCVND')
				{
					var myWindow = window.open("", "Garantia de Fabrica", "width=390, height=100 ,top=300,left=500");
					myWindow.document.write("<p>Este produto não possui período de garantia.</p>");
					myWindow.document.write("<form action='sales/set_garantia_fabrica' method='post'>");
					myWindow.document.write("&emsp; <button type='submit'>Confirmar</button>");	
					myWindow.document.write("</form>");
					
					var myWindow = window.open("", "Garantia do Produto", "width=390, height=100 ,top=300,left=500");
					myWindow.document.write("<p>Este produto não possui período de garantia.<br>Informe a garantia do produto em mês</p>");
					myWindow.document.write("<form action='sales/set_garantia_venda' method='post'>");
					myWindow.document.write("Número em mês <input type=\"text\" name=\"number_meses\"> &emsp; <button type='submit'>Confirmar</button>");	
					myWindow.document.write("</form>");
				}

				if(data == '\nVND')
				{
					var myWindow = window.open("", "Garantia do Produto", "width=390, height=100 ,top=300,left=500");
					myWindow.document.write("<p>Este produto não possui período de garantia.<br>Informe a garantia do produto em mês</p>");
					myWindow.document.write("<form action='sales/set_garantia_venda' method='post'>");
					myWindow.document.write("Número em mês <input type=\"text\" name=\"number_meses\"> &emsp; <button type='submit'>Confirmar</button>");	
					myWindow.document.write("</form>");
				}
				
				if(data != '\nGRNTFBRC' && data != '\nGRNTFBRCVND') 
				{
					window.location.assign('<?php echo site_url('sales_lista');?>');
				}					
				
			});

			
	
}

</script>



<script type="text/javascript">

	$(document).ready(function(){
    	$(this).scrollTop(0);
	});
	

</script>

<?php $this->load->view("partial/footer"); ?>			

