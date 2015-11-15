<?php $this->load->view("partial/header"); ?>
<link rel="stylesheet" type="text/css"
	href="<?php echo $this->config->base_url();?>web/js/chosen.min.css">

<style type="text/css" media="all">
/* fix rtl for demo */
.chosen-rtl .chosen-drop 
{
	left: -9000px;
}
</style>

<link
	href="<?php echo $this->config->base_url();?>web/js/jquery.icheck/skins/square/blue.css"
	rel="stylesheet">
<div class="cl-mcont">
	<?php if(isset($manage_result)){echo $manage_result;} ?>
	<div class="block-flat">
		<div class="header">
			<h3>
				<font style="color: dodgerblue;">Relatórios</font>
			</h3>
		</div>
		<div class="row">
			<div class="col-sm-3 col-md-3 col-lg-3 col-xs-12">
				<label>Tipo: </label> 
				<select class="form-control" id="tipo" onchange="refere();">
					<optgroup label="Contas">
						<option value="contas:receber">Contas a Receber</option>
						<option value="contas:pagar">Contas a Pagar</option>
						<option value="contas:canceladas">Contas Canceladas</option>
					</optgroup>
					<optgroup label="Vendas">
						<option value="vendas:efetuadas">Vendas Efetuadas</option>
						<option value="vendas:canceladas">Vendas Canceladas</option>
					</optgroup>
					<optgroup label="Itens Não Serializados">
						<option value="itens:estoque">Itens Estocados</option>
					</optgroup>
					<optgroup label="Itens Serializados">
						<option value="itens:vendidos">Aparelhos Vendidos</option>
						<!-- <option value="itens:teste">Aparelhos em Teste</option> -->
						<!-- <option value="itens:Sestoque">Aparelhos Estocados</option> -->
					</optgroup>
					<optgroup label="Compras da Empresa">
						<option value="compras:efetuadas">Compras Efetuadas</option>
						<option value="compras:canceladas">Compras Canceladas</option>
					</optgroup>
					<optgroup label="Ordens de Serviço">
						<option value="os:finalizadas">OSs Finalizadas</option>
						<option value="os:canceladas">OSs Canceladas</option>
						<option value="os:andamento">OSs em Andamento</option>
					</optgroup>
					<optgroup label="Consultas">
						<option value="consultas:abertas">Consultas Abertas</option>
						<option value="consultas:fechadas">Consultas Fechadas</option>
						<option value="consultas:acompab">Progs. de Acompanhamento abertos</option>
						<option value="consultas:acompfec">Progs. de Acompanhamento fechados</option>
					</optgroup>
				</select>
			</div>
			<div class="col-md-3 col-sm-3 col-lg-3">
				<label>Empresas:</label> 
				<select id="enterprise" class="form-control">
					<option value="all">Todas</option>
					<?php
					if (isset($empresas))
					{
						echo $empresas;
					}
					?>
				</select>
			</div>
			<div class="col-md-4 col-sm-3 col-lg-4">
				<label>Referência:</label> 
				<select id="refer" class="form-control">
					<?php
					if (isset($lista))
					{
						echo $lista;
					}
					else
					{
						echo '<option value="all">Tudo</option>';
					}
					?>
				</select>
			</div>
			<div class="col-md-1 col-sm-3 col-lg-2">
				<label>&nbsp;</label>
				<h5>&nbsp;</h5>
			</div>
			<div class="col-md-3 col-sm-3 col-lg-2" style="display: inline-block;">
				<label>Início:</label> 
				<input id="DInic" class="form-control" type="date" value="<?php echo date("d/m/Y");?>" data-mask="##/##/####" placeholder="Ex.: 14/02/2016">
			</div>
			<div class="col-md-3 col-sm-3 col-lg-2" style="display: inline-block;">
				<label>Fim:</label> <input id="DFim" class="form-control" type="date" value="<?php echo date("d/m/Y");?>" data-mask="##/##/####" placeholder="Ex.: 14/02/2016">
			</div>
			<div style="display: none;" class="col-md-4 col-sm-4 col-lg-4" style="display: inline-block;">
				<label>Gerar em:</label><br> 
				<label class="radio-inline pull-left">
					Sumário:
					<input type="radio" id="mode1" class="icheck" name="modo" value="sumario" checked="checked">
				</label> 
				 <label style="display: none;" class="radio-inline pull-right">
					Gráfico: 
					<input type="radio" id="mode2" class="icheck" name="modo" value="grafico">
				</label>
			</div>
			<div class="col-md-2 col-sm-2 col-lg-2" style="display: inline-block;">
				<br>
				<button class="btn btn-primary pull-right" onclick="request();">Gerar Relatório</button>
			</div>
			<div class="col-md-2 col-sm-2 col-lg-2" style="display: inline-block;">
				<label>&nbsp;</label>
				<h5>&nbsp;</h5>
			</div><br><br>
			<div class="col-md-12 col-sm-12 col-lg-12" style="display: inline-block;" id="tabler">
			</div>
		</div>
	</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $this->config->base_url();?>web/js/chosen.jquery.min.js"></script>

<script type="text/javascript">
function refere()
{
	var ref = document.getElementById('tipo').selectedIndex;
	var refered;
	
	switch(ref)
	{
		case 1:
		case 2:
		case 7:
		case 9:
		case 10:
			refered = "fornecedor";
			break;

		case 0:
		case 3:
		case 4:
		case 5:
		case 6:
		case 11:
		case 12:
		case 13:
		case 14:
		case 15:
		case 16:
		case 17:
		case 18:
			refered = "cliente";
			break;
		
		case 8:
		default:
			refered = 'tudo';
			break;
			
	}
	
	var xmlhttp;
	if (window.XMLHttpRequest)
 	{// code for IE7+, Firefox, Chrome, Opera, Safari
  		xmlhttp = new XMLHttpRequest();
  	}
	else
  	{// code for IE6, IE5
  		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  	}

  	xmlhttp.open("GET","<?php echo site_url("reports/refer");?>/"+refered, false);
	xmlhttp.send();
	document.getElementById("refer").innerHTML = xmlhttp.responseText;
	
}


var config = {
		  '.chosen-select'           : {width:"100%"},
		  '.chosen-select-deselect'  : {allow_single_deselect:true},
		  '.chosen-select-no-single' : {disable_search_threshold:10},
		  '.chosen-select-no-results': {no_results_text:'Não há cadastros deste item!'},
		  '.chosen-select-width'     : {width:"100%"}
}

for (var selector in config) 
{
	$(selector).chosen(config[selector]);
}

function request()
{
	var tipo = document.getElementById('tipo').value;
	var enterprise = document.getElementById('enterprise').value;
	var refer = document.getElementById('refer').value;
	var DInic = document.getElementById('DInic').value == '' ?  '14/02/1979' : document.getElementById('DInic').value;
	var DFim = document.getElementById('DFim').value == '' ?  '28/12/2100' : document.getElementById('DFim').value;
	var mode = document.getElementById('mode1').value;

	
	if(document.getElementById('mode2').checked == true)
	{
		mode = document.getElementById('mode2').value;
	}

	var xmlhttp;
	if (window.XMLHttpRequest)
 	{// code for IE7+, Firefox, Chrome, Opera, Safari
  		xmlhttp = new XMLHttpRequest();
  	}
	else
  	{// code for IE6, IE5
  		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  	}

  	xmlhttp.open("POST","<?php echo site_url("reports/generate");?>", false);
  	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("tipo="+tipo+"&enterprise="+enterprise+"&refer="+refer+"&DInic="+DInic+"&DFim="+DFim+"&mode="+mode);
	//alert(xmlhttp.responseText);
	document.getElementById('tabler').innerHTML = xmlhttp.responseText;
}

</script>

<?php $this->load->view("partial/footer"); ?> 
