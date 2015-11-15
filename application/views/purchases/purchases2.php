<?php
date_default_timezone_set('America/Sao_Paulo');
$this->load->view("partial/header");

?>

<div id="main-content" class="main-content container-fluid">
	<?php
if (isset($manage_result)) {
    echo $manage_result;
} else {
    echo '';
}
?>
	 	<div class="col-lg-12 pull-left">
		<div class="cl-mcont">
			<div class="block-flat">
				<div class="header">
					<h3>
						<i class="fontello-icon-chart-bar-3"></i>Pedido de Compra de
						Produtos
					</h3>
				</div>	
					<?php echo form_open('purchases/save', 'class="form-horizontal" id="form1"', array());?>
						<div class="form-group">
					<div class="col-sm-2 col-md-2 col-lg-2">
						N&#176; do pedido: <input id="pedido" type="text" name="numero"
							value="<?php echo $numero;?>" class="form-control" readonly />
					</div>
					<div class="col-sm-5 col-md-5 col-lg-5">
								Fornecedor:
								<?php echo form_dropdown('fornecedor', $supplier_info, array($fornecedor_get), 'id="fornecedor" autofocus="autofocus" onchange="post_forn();get_info();" name="fornecedor" class="select2"')?>
							</div>
					<div class="col-sm-5 col-md-5 col-lg-5">
								Departamento:
								<?php echo form_dropdown('departamento', $department_info, array($departamento_get), 'id="departamento" onchange="post_dept();get_info();" name="departamento" class="select2"')?>
							</div>
				</div>
					<?php echo form_close();?>
					<div class="content">

					<table class="no-border hover">
						<thead class="no-border text-primary">
							<tr>
								<th>Produto</th>
								<th class="text-center">UN.</th>
								<th class="text-right">Valor Unit.</th>
								<th class="text-right">Qtde</th>
								<th class="text-right">Total</th>
								<th class="text-center">Ação</th>
							</tr>
						</thead>
						<tbody class="no-border-y">
							<tr>
						    	<?php echo form_open('purchases/save_itens');?>
						    		<td><?php echo form_dropdown('produto', $items_info, array(), 'class="select2"')?><input
									type="hidden" name="pedido" value="<?php echo $next;?>"></td>
								<td><?php echo form_dropdown('un', $unidade, array(), 'class="select2"')?></td>
								<td class="text-right"><input type="text" name="valorunit"
									id="b" dir="rtl" data-mask="#######.##"
									data-mask-reverse="true" data-toggle="tooltip"
									placeholder="Ex.: 1200.00"
									data-original-title="Insira corretamente no formato: 0.00"
									value="0.00" onchange="mult();" class="form-control"></td>
								<td><input name="quant" id="c" type="text" onchange="mult();"
									dir="rtl" data-mask="#####" data-mask-reverse="true"
									data-toggle="tooltip" placeholder="Ex.: 1.00"
									data-original-title="Insira corretamente no formato: 0.00"
									value="1.00" class="form-control"></td>
								<td class="text-right"><input type="text" name="vtotal"
									dir="rtl" id="a" class="form-control" readonly="readonly"></td>
								<td class="text-center"><button class="btn btn-primary"
										type="submit">Inserir</button></td>
						    	<?php echo form_close();?>
						    	</tr>
							 <?php echo $manage_table_row; ?>
				    	</tbody>
					</table>
					<hr class="mm">
					<div class="form-horizontal" style="border-radius: 0px;">
						<div class="form-group">
							<div class="col-sm-6 col-md-6 col-lg-6">&nbsp;</div>
							<label class="col-sm-3 col-lg-3 col-md-3 control-label">Total:</label>
							<div class="col-sm-3 col-lg-3 col-md-3">
								<div class="input-group">
									<input class="form-control" dir="rtl" readonly="readonly"
										value="<?php echo $valortotal;?>" type="text" id="valortotal">
								</div>
							</div>
						<?php echo form_open("purchases/gera_contas_pagar/".$numero, 'id="form2"');?>
						<div class="col-md-12 col-lg-12 col-sm-12"
								style="display: inline-block;">
								<h4>
									<strong>Pagamento:</strong>
								</h4>
							</div>
							<div class="col-md-4 col-lg-4 col-sm-4"
								style="display: inline-block;">
								<strong>Parcelas:</strong> <input style="width: 70px;"
									id="numparcelas"
									onchange="gera_parcelas(this.value);calcula_valor();"
									class="form-control" type="number" value="1" name="parcelas"
									min="1" max="60">

							</div>
							<div class="col-md-4 col-lg-4 col-sm-4"
								style="display: inline-block;">
								<strong>Colocar todas formas de pgto. em:</strong> <select
									class="form-control" id="formapgto"
									onchange="all_by_method(this);">
									<option>Em dinheiro</option>
									<option>Boleto</option>
									<option>Cheque</option>
									<option>Cartão: Crédito</option>
									<option>Cartão: Débito</option>
									<option>Transferência Bancária</option>
								</select>
							</div>
							<div class="col-md-4 col-lg-4 col-sm-4"
								style="display: inline-block;">
								<label><strong>Datas de Vencimento:</strong></label><br> <label>Com
									entrada: <input type="radio" name="dias30"
									onclick="gera_parcelas(document.getElementById('numparcelas').value);"
									id="diaspgto" value="0" checked="checked">
								</label> <label style="margin-left: 21px;">Sem entrada: <input
									type="radio" name="dias30"
									onclick="gera_parcelas(document.getElementById('numparcelas').value);"
									id="diaspgto" value="1"></label>

							</div>

							<div class="col-md-12 col-lg-12 col-sm-12"
								style="display: inline-block;">
								<hr style="color: lightgrey;">
							</div>



							<div class="col-md-4 col-lg-4 col-sm-4" id="parcelapgto"
								style="display: inline-block;">
								<input class="form-control" type="text"
									onchange="calcula_valor()" data-mask="#####0.00"
									style="width: 220px;" data-mask-reverse="true"
									placeholder="0.0000" id="valorparcela0"
									value="<?php echo $valortotal;?>" dir="rtl"
									name="parcelaval[0]"><br>
							</div>
							<div class="col-md-4 col-lg-4 col-sm-4" id="metodopgto"
								style="display: inline-block;">
								<select class="form-control" id="formapgto20"
									name="formapgto[0]">
									<option value="0">Em dinheiro</option>
									<option value="1">Boleto</option>
									<option value="2">Cheque</option>
									<option value="3">Cartão: Crédito</option>
									<option value="4">Cartão: Débito</option>
									<option value="5">Transferência Bancária</option>
								</select> <br>
							</div>
							<div class="col-md-4 col-lg-4 col-sm-4" id="datapgto"
								style="display: inline-block;">
								<input class="form-control" id="datapgto2"
									placeholder="Ex.: <?php echo date('d/m/Y');?>"
									pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}"
									title="Padrão: dia/mês/ano" value="<?php echo date('d/m/Y');?>"
									name="datavencimento[0]"><br>
							</div>
							<div class="col-md-12 col-lg-12 col-sm-12"
								style="display: inline-block;">
								<input class="form-control" readonly="readonly" id="excesso"
									value="Status: OK" style="width: 220px; border-color: darkgrey">
							</div>

							<div class="col-sm-12 col-md-12 col-lg-12"
								style="display: inline-block;">
								<br> <input type="hidden" id="fornecedorY" name="fornecedor"
									value=""> <input type="hidden" id="departamentoY"
									name="departamento" value="">
								<button class="btn btn-primary"
									onclick="change_dept_forn();document.getElementById('form2').submit();"
									name="pedido" value="<?php echo $numero;?>" type="button">Gerar
									Pedido</button>
								<button class="btn btn-default" type="button"
									onclick="window.location='<?php echo site_url('pclista');?>'">Voltar</button>
							</div>
						
						
						<?php echo form_close();?>
						</div>
					</div>
					<div class="md-overlay"></div>
				</div>
				<!--  // column -->
			</div>
			<!--  Example row -->
		</div>
	</div>
	<!-- // block-flat -->
</div>


<!-- // main-content -->

<script
	src="<?php echo $this->config->base_url();?>web/js/jquery.min.js"></script>

<script type="text/javascript">
		function gera_parcelas(e)
		{ 
			var valorparcela = (document.getElementById('valortotal').value/e); 
			var depois = new Date();
			
			document.getElementById('parcelapgto').innerHTML = '';
			document.getElementById('metodopgto').innerHTML = '';
			document.getElementById('datapgto').innerHTML = '';
			
			for(var i = 0; i < e; i++)
			{
				if(document.getElementById('diaspgto').checked == true)
				{
					if(i == 0)
					{
						depois.setDate(depois.getDate());
					}
					else
					{
						depois.setDate(depois.getDate() + 30);
					}
					
					document.getElementById('parcelapgto').innerHTML += '<input class="form-control" type="text" style="width: 220px;" onchange="calcula_valor()" data-mask="#####0.0000" data-mask-reverse="true" placeholder="0.0000" id="valorparcela'+i+'" value="'+(valorparcela).toFixed(2)+'" dir="rtl" name="parcelaval['+i+']"><br>';
					document.getElementById('metodopgto').innerHTML += '<select class="form-control" id="formapgto2'+i+'" name="formapgto['+i+']"><option value="0">Em dinheiro</option><option value="1">Boleto</option><option value="2">Cheque</option><option value="3">Cartão: Crédito</option><option value="4">Cartão: Débito</option><option value="5">Transferência Bancária</option></select><br>';
					document.getElementById('datapgto').innerHTML += '<input class="form-control" placeholder="Ex.: <?php echo date('d/m/Y');?>" pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}" title="Padrão: dia/mês/ano" id="datapgto2'+i+'" value="'+depois.toLocaleDateString()+'" name="datavencimento['+i+']"><br>';
				}
				else
				{
					depois.setDate(depois.getDate() + 30);
					
					document.getElementById('parcelapgto').innerHTML += '<input class="form-control" type="text" style="width: 220px;" onchange="calcula_valor()" data-mask="#####0.0000" data-mask-reverse="true" placeholder="0.0000" id="valorparcela'+i+'" value="'+(valorparcela).toFixed(2)+'" dir="rtl" name="parcelaval['+i+']"><br>';
					document.getElementById('metodopgto').innerHTML += '<select class="form-control" id="formapgto2'+i+'" name="formapgto['+i+']"><option value="0">Em dinheiro</option><option value="1">Boleto</option><option value="2">Cheque</option><option value="3">Cartão: Crédito</option><option value="4">Cartão: Débito</option><option value="5">Transferência Bancária</option></select><br>';
					document.getElementById('datapgto').innerHTML += '<input class="form-control" placeholder="Ex.: <?php echo date('d/m/Y');?>" pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}" title="Padrão: dia/mês/ano" id="datapgto2" value="'+depois.toLocaleDateString()+'" name="datavencimento['+i+']"><br>';
				
				}
				
			}
		}

		
	
		function calcula_valor()
		{
			var n = document.getElementById('numparcelas').value;
			var b = parseFloat(document.getElementById('valortotal').value)
			
			var a = 0;
			
			for(var i = 0; i < n; i++)
			{
				a += parseFloat(document.getElementById('valorparcela'+i).value); 
			}

			if((b-a).toFixed(2) == 0)
			{
				document.getElementById('excesso').value = "Status: OK"; 
			}
			else if((b-a).toFixed(2) < 0)
			{
				document.getElementById('excesso').value = "Status: Excedendo R$ "+(-(b-a)).toFixed(2);
			}
			else if((b-a).toFixed(2) > 0)
			{
				document.getElementById('excesso').value = "Status: Faltando R$ "+(b-a).toFixed(2);
			}
			
		}
		
		function all_by_method(e)
		{
			var x = e.selectedIndex;
			var n = document.getElementById('numparcelas').value;
			for(var i = 0; i < n; i++)
			{
				document.getElementById('formapgto2'+i).selectedIndex = x; 
			}
			
		}
		
		function change_dept_forn()
		{
			var e = document.getElementById("fornecedor");
			var fornecedor1 = e.options[e.selectedIndex].innerHTML;
			var f = document.getElementById("departamento");
			var departamento1 = f.options[f.selectedIndex].innerHTML;

			document.getElementById('departamentoY').value = departamento1;
			document.getElementById('fornecedorY').value = fornecedor1;
		}
	
	
	</script>
<script type="text/javascript">

	function loadXMLDoc(id)
	{
		var xmlhttp;
		if (window.XMLHttpRequest)
	 	{// code for IE7+, Firefox, Chrome, Opera, Safari
	  		xmlhttp=new XMLHttpRequest();
	  	}
		else
	  	{// code for IE6, IE5
	  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  	}
		xmlhttp.onreadystatechange=function()
	  	{
	  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    	{
	    		document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
	    	}
	  	}
		xmlhttp.open("GET","<?php echo site_url("purchases/get_forn_info")?>/"+id,true);
		xmlhttp.send();
	}
	</script>
<script type="text/javascript">

	function loadXMLDoc2(id)
	{
		var xmlhttp;
		if (window.XMLHttpRequest)
	 	{// code for IE7+, Firefox, Chrome, Opera, Safari
	  		xmlhttp=new XMLHttpRequest();
	  	}
		else
	  	{// code for IE6, IE5
	  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  	}
		xmlhttp.onreadystatechange=function()
	  	{
	  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    	{
	    		document.getElementById("myDiv2").innerHTML=xmlhttp.responseText;
	    	}
	  	}
		xmlhttp.open("GET","<?php echo site_url("purchases/get_forn_email")?>/"+id,true); 
		xmlhttp.send();
	}
	</script>


<script type="text/javascript">
	function mult()
	{
		var calculo = document.getElementById('a').value = (document.getElementById('b').value * document.getElementById('c').value).toFixed(4);
	}

	function post_dept()
	{
		var f = document.getElementById("departamento");
		var departamento1 = f.options[f.selectedIndex].value;

		var URL = "<?php echo $this->config->site_url('purchases/seta_departamento');?>";

		
		$.post
		(
			URL,
			    {
			      departamento:departamento1
			    },
			    function(data,status)
			    {
					//window.location="<?php echo $this->config->site_url('pclista');?>";
			    }
		);
	}

	function post_forn()
	{
		var e = document.getElementById("fornecedor");
		var fornecedor1 = e.options[e.selectedIndex].value;

		var URL = "<?php echo $this->config->site_url('purchases/seta_fornecedor');?>";

		
		$.post
		(
			URL,
			    {
				fornecedor:fornecedor1
			    },
			    function(data,status)
			    {
					//window.location="<?php echo $this->config->site_url('pclista');?>";
			    }
		);
	}
	</script>
<?php $this->load->view("partial/footer"); ?>