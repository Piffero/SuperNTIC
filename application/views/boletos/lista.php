<?php
$this->load->view("partial/header");
?>
<div class="page-head">
	<h2>Controle de Boletos</h2>
</div>
<div id="container-fluid" class="pcont">
	<div class="cl-mcont">
			<?php if(isset($manage_result)){echo $manage_result;} ?>
			<div class="row">
			<div class="col-sm-4 col-md-3 col-lg-3">
				<div class="btn-group">
					<button class="btn btn-primary" type="button"
						onclick="location.href='<?php echo site_url("boletos/novo")?>'">
						<i class="fa fa-plus"></i> Novo
					</button>
					<button class="btn btn-default dropdown-toggle"
						data-toggle="dropdown" type="button">
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li><a href="#"><i class="fa fa-file-text"></i> Gerar 2ª via</a></li>
						<li><a href="#"><i class="fa fa-check"></i> Compensar</a></li>
						<li><a href="#" onclick="edit()"><i class="fa fa-pencil"></i>
								Editar</a></li>
						<li class="divider"></li>
						<li><a href="#" onclick="cancel();"><i class="fa fa-times"></i>
								Cancelar Boleto</a></li>
					</ul>
				</div>
        			<?php form_open();?>
        			<select id="situacao"
					style="height: 35px; border: 1px solid lightgrey; width: 50%"
					data-toggle="tooltip" data-original-title="Listar por situação">
					<option value="">Todos</option>
					<option value="pago">Pagos</option>
					<option value="receber">A Receber</option>
					<option value="cancelado">Cancelados</option>
				</select>
			</div>

			<div class="col-md-3 col-sm-3 col-lg-3"
				title="Procurar Boletos por data">
				<div class="input-group date datetime" data-min-view="2"
					data-date="<?php echo date('d/m/Y');?>"
					data-date-format="dd/mm/yyyy" data-link-field="dtp_input1">
					<input id="vencimento" class="form-control" type="text"
						data-toggle="tooltip" data-original-title="Data de vencimento"
						data-mask="##/##/####" placeholder="Ex.: 14/02/1996"> <span
						class="input-group-addon btn btn-primary"><span
						class="glyphicon glyphicon-th"></span></span>
				</div>
			</div>
			<div class="col-sm-3 col-lg-3 col-md-3">
				<select id="patient_id" class="form-control" data-toggle="tooltip"
					data-original-title="Listar por Cliente">
        				<?php
            if (isset($lista_cliente)) {
                echo $lista_cliente;
            } else {
                echo '<option value=""> </option>';
            }
            ?>
        			</select>
			</div>

			<div class="col-md-3 col-lg-3 col-sm-3">
				<select id="bank_id" class="form-control" data-toggle="tooltip"
					data-original-title="Listar por Banco"
					style="width: 60%; display: inline-table;">
    						<?php
        if (isset($lista_banco)) {
            echo $lista_banco;
        } else {
            echo '<option value=""> </option>';
        }
        ?>
    				</select>
				<button class="btn btn-success" onclick="loadrequest()">Buscar</button>
			</div>
    			
    			<?php form_close();?>
    		</div>
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12">
				<div class="tab-container">
					<!-- ----CONTROL TABS START----- -->
					<ul class="nav nav-tabs">
						<li class="active"><a href="#list" data-toggle="tab"><i
								class="fa fa-align-justify"></i> Lista de Boletos</a></li>
					</ul>
					<div class="tab-content">
						<div class="form-group">
							<table class="hover">
								<thead>
									<tr>
										<th style="width: 20px;"><input id="toggle" type="checkbox"
											data-toggle="tooltip"
											data-original-title="Marcar/desmarcar todos os campos"
											onchange="checkall('x')"></th>
										<th><strong>Nº Doc.</strong></th>
										<th><strong>Cliente</strong></th>
										<th class="text-center"><strong>Vencimento</strong></th>
										<th class="text-center"><strong>Banco</strong></th>
										<th class="text-center"><strong>Situação</strong></th>
										<th class="text-right"><strong>Valor</strong></th>

									</tr>
								</thead>
								<tbody id="table">
										<?php
        if (isset($lista_boleto)) {
            echo $lista_boleto;
        }
        ?>
 								 	</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
function checkall(id)
{
	if(document.getElementById("toggle").checked == true)
	{
		for(var i = 0; i < document.getElementsByTagName("input").length; i++)
		{
			var cb = document.getElementsByTagName("input")[i];

			if((cb.type == "checkbox") && (cb.id == id))
			{
				cb.checked = true;
			}
		}
	}
	else if(document.getElementById("toggle").checked == false)
	{
		for(var i = 0; i < document.getElementsByTagName("input").length; i++)
		{
			var cb = document.getElementsByTagName("input")[i];

			if((cb.type == "checkbox") && (cb.id == id))
			{
				cb.checked = false;
			}
		}
	}
	else
	{
		return;
	}
}


function cancel() 
{
	var checados = 0
	
	for(var i = 0; i < document.getElementsByTagName("input").length; i++)
	{
		var cb = document.getElementsByTagName("input")[i];

		if((cb.type == "checkbox") && (cb.checked == true))
		{
			checados += 1;
		}
	}

	if(checados == 0)
	{
		alert("Você deve checar um item da lista para cancelar");
	}
	else if(checados == 1)
	{
		var ctz = confirm("Você deseja realmente excluir esse boleto?");

		if(ctz == true)
		{
			location.href = "<?php echo site_url("boletos/cancel")?>/"+cb.value;
		}
	}
	else if(checados > 1)
	{
		alert("Você deve checar apenas um item da lista para cancelar");
	}
}


  $(function() {
    $('#datetimepicker1').datetimepicker({
    	format: 'dd/MM/yyyy',
      	language: 'pt-BR',
      	pickTime: false
    });
  });


function loadrequest()
{
	var situacao 	= document.getElementById('situacao').value;
	var vencimento 	= document.getElementById('vencimento').value;
	var patient_id 	= document.getElementById('patient').value;
	var bank_id		= document.getElementById('bank').value;
	
	var xmlhttp;
	if (window.XMLHttpRequest)
 	{// code for IE7+, Firefox, Chrome, Opera, Safari
  		xmlhttp = new XMLHttpRequest();
  	}
	else
  	{// code for IE6, IE5
  		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  	}
	
	xmlhttp.open("POST","<?php echo site_url("boletos/search")?>", false); 
	xmlhttp.send("situacao="+situacao+"&vencimento="+vencimento+"&patient_id="+patient_id+"&bank_id="+bank_id);

	xmlhttp.onreadystatechange=function()
  	{
  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
    	{
    		document.getElementById("table").innerHTML = xmlhttp.responseText;
    	}
  	}
}

function edit() 
{
	var checados = 0
	
	for(var i = 0; i < document.getElementsByTagName("input").length; i++)
	{
		var cb = document.getElementsByTagName("input")[i];

		if((cb.type == "checkbox") && (cb.checked == true))
		{
			checados += 1;
		}
	}

	if(checados == 0)
	{
		alert("Você deve checar um item da lista para editar");
	}
	else if(checados == 1)
	{
		location.href = "<?php echo site_url("boletos/novo")?>/"+cb.value;
	}
	else if(checados > 1)
	{
		alert("Você deve checar apenas um item da lista para editar");
	}
}

</script>
<?php $this->load->view("partial/footer"); ?>