<?php $this->load->view("partial/header"); ?>

<link rel="stylesheet" type="text/css"
	href="<?php echo $this->config->base_url();?>web/js/chosen.min.css">
<style type="text/css" media="all">
.chosen-rtl .chosen-drop {
	left: -9000px;
}
</style>

<div class="cl-mcont">
	<div>
		<div class="col-sm-6 col-md-6">
			<div class="block">
				<div class="header">
					<h2>Selecione a categoria:</h2>
									<?php
        
        if (isset($categoria)) {
            echo form_dropdown('lista_categoria', $categoria, Array(
                'Aparelhos'
            ), 'onchange="mostra_lista(this.value)" class="chosen-select" style="float: right"');
        }
        ?>
							</div>
				<div class="content no-padding "
					style="height: 504px; overflow: auto">
					<ul class="items" id="exu">
									<?php if(isset($lista)){echo $lista;}?>
								</ul>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="block-flat">
				<div class="header">
					<h3>Itens na lista</h3>
				</div>
				<div class="content">
					<table class="no-border hover">
						<thead class="no-border">
							<tr>
								<th style="width: 50%">Produto</th>
								<th style="width: 20%" class="text-center">Quantidade</th>
								<th style="width: 30%" class="text-center">Preço</th>
							</tr>
						</thead>
					</table>
				</div>
				<div class="content" id="tuts"
					style="height: 158px; overflow: auto;">
					<table class="no-border hover">
						<tbody class="no-border-y" id="table">

						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="block-flat">

				<div class="content">
					<div class="form-horizontal">
						<div class="form-group">
							<label class="col-md-4 col-lg-4 control-label">Subtotal:</label>
							<div class="col-md-8 col-lg-8">
								<input class="form-control" id="subtotal" placeholder="0.00"
									dir="rtl" readonly="readonly">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 col-lg-4 control-label">Desconto:</label>
							<div class="col-md-8 col-lg-8">
								<input class="form-control" id="desconto"
									onchange="dar_desconto(this)" placeholder="0.00" dir="rtl"
									data-mask="#####.##" data-mask-reverse="true">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 col-lg-4 control-label">Total:</label>
							<div class="col-md-8 col-lg-8">
								<input class="form-control" id="total" placeholder="0.00"
									dir="rtl" readonly="readonly">
							</div>
						</div>
					</div>
					<button class="btn btn-primary">Concluir</button>
				</div>
			</div>
		</div>
	</div>
</div>

<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"
	type="text/javascript"></script>
<script type="text/javascript"
	src="<?php echo $this->config->base_url();?>web/js/chosen.jquery.min.js"></script>

<script type="text/javascript">
var config = {
		  '.chosen-select'           : {width:"100%"},
		  '.chosen-select-deselect'  : {allow_single_deselect:true},
		  '.chosen-select-no-single' : {disable_search_threshold:10},
		  '.chosen-select-no-results': {no_results_text:'Não há cadastros deste item!'},
		  '.chosen-select-width'     : {width:"20%"}
		}
		for (var selector in config) {
		  $(selector).chosen(config[selector]);
		}
function mostra_lista(id)
{
	var xmlhttp;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}


	xmlhttp.open("GET","<?php echo $this->config->site_url("sales/get_categorias");?>/"+id, false);
	xmlhttp.send();
	xmlDoc=xmlhttp.responseText;
	document.getElementById('exu').innerHTML = xmlDoc.trim();

}

var subtotal = document.getElementById("subtotal");
subtotal.value = "R$ 0.00";

function move_tabela(el) 
{
	
	var value = prompt("Digite a quantidade de produtos");
	if(isNaN(value))
	{
		move_tabela(el);
	}
	else if(value)
	{
		var sub = 0.00;
		var table = document.getElementById("table");
		var dinheiro = el.id.split("|");
		var url = "<?php $this->config->site_url('sales/insert_item'); ?>";
		
			table.innerHTML += "<tr><td style=\"width:50%\">"+dinheiro[0]+"</td><td style=\"width:20%\" class=\"text-center\">"+value+"</td><td style=\"width:30%\" class=\"text-right\">R$ "+(value * parseFloat(dinheiro[1])).toFixed(2)+"</td></tr>";
			sub = sub + (parseFloat(dinheiro[1])*value);
			document.getElementById("subtotal").value = 'R$ '+(sub).toFixed(2);
				
		
	}

	document.getElementById("tuts").scrollTop=99999999;
}

var total = document.getElementById("total");
total.value = "R$ 0.00";
document.getElementById("desconto").value = "";

function dar_desconto(el)
{
	if(el.value == '')
	{
		total.value = subtotal.value;
	}
	else
	{
		total.value = "R$ 0.00";
		var sub = subtotal.value.split("R$ ");
		var desconto = parseFloat(el.value);
		var dinheiro = total.value.split("R$ ");
		var valor = "R$ "+((parseFloat(dinheiro[1]) + parseFloat(sub[1])) - desconto).toFixed(2);
		dinheiro = valor.split("R$ ");
		if(parseFloat(dinheiro[1]) < 0)
		{
			total.value = "R$ 0.00";
		}
		else
		{
			total.value = valor;
		}
	}
}

</script>

<?php $this->load->view("partial/footer"); ?>	