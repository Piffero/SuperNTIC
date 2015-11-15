<?php $this->load->view("partial/header"); ?>
<link rel="stylesheet" type="text/css"
	href="<?php echo $this->config->base_url();?>web/js/chosen.min.css">

<style type="text/css" media="all">
/* fix rtl for demo */
.chosen-rtl .chosen-drop {
	left: -9000px;
}
</style>

<div class="cl-mcont">
	<div class="row">
		<div class="col-md-12 col-lg-12 col-sm-12">
			<div class="block-flat">
				<div class="header">
					<h3>
						<font style="color: dodgerblue;">Novo Boleto</font>
					</h3>
				</div>
				<div class="content">
   					<?php if(isset($manage_result)){echo $manage_result;} ?>
						<div class="row">
							<?php
							if (isset($id_blt))
							{
								echo form_open("boletos/update");
								echo ("<input name=\"id\" value=\"'.$id_blt.'\" type=\"hidden\">");
							}
							else
							{
								echo form_open("boletos/gerar");
							}
							?>
							<div class="col-md-3 col-lg-3 col-sm-3">
							<label>Cliente:</label>
							<div class="side-by-side clearfix">
								<select name="patient" style="width: 95%; height: 34px;"
									class="chosen-select">
										<?php
										if (isset($lista_cliente) and ! empty($lista_cliente))
										{
											echo $lista_cliente;
										}
										?>
									</select>
							</div>
						</div>
						<div class="col-md-3 col-lg-3 col-sm-3">
							<label>Banco:</label> <select name="bank"
								onchange="get_bank(this.value)" class="form-control">
									<?php
									
									if (isset($lista) and ! empty($lista))
									{
										echo $lista;
									}
									?>
								</select>
						</div>
						<div class="col-md-2 col-lg-2 col-sm-2" style="height: 62px;">
							<label>Vencimento:</label>
							<div class="input-group date datetime" data-min-view="2"
								data-date="<?php echo date('d/m/Y');?>"
								data-date-format="dd/mm/yyyy" data-link-field="dtp_input1">
								<input class="form-control" required="required"
									value="<?php if(isset($blt->vencimento)){echo get_date_view($blt->vencimento);}else{echo date('d/m/Y', strtotime("+30 days"));}?>"
									name="vencimento" type="text" data-mask="##/##/####"
									placeholder="Ex.: 14/02/1996"> <span
									class="input-group-addon btn btn-primary"><span
									class="glyphicon glyphicon-th"></span></span>
							</div>
						</div>
						<div class="col-md-2 col-lg-2 col-sm-2">
							<label>Nº Doc.:</label> <input type="text" required="required"
								class="form-control"
								value="<?php if (isset($blt->numdocum)){echo $blt->numdocum;}?>"
								placeholder="Ex.: 2189212" data-mask="###############"
								name="numdocum">
						</div>

						<div class="col-md-2 col-lg-2 col-sm-2">
							<label>Valor Documento:</label> <input type="text"
								class="form-control"
								value="<?php if (isset($blt->docvalue)){echo $blt->docvalue;}?>"
								placeholder="Ex.: 11350.00" data-mask-reverse="true"
								data-mask="######.##" name="docvalue">
						</div>

						<div class="col-md-6 col-lg-6 col-sm-6"
							style="display: inline-block;">
							<label>Descrição:</label>
							<textarea class="form-control" id="descricao" maxlength="700"
								style="resize: none;" rows="5" name="description"><?php if(isset($blt->description)){echo $blt->description;}elseif(isset($descbank)){echo $descbank;}?></textarea>
						</div>
						<div class="col-md-6 col-lg-6 col-sm-6"
							style="display: inline-block;">
							<h6>&nbsp;</h6>
							<button onclick="validador('form1', 'required');"
								class="btn btn-primary">Gerar Boleto</button>
						</div>
							<?php echo form_close();?>
						</div>
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
		  '.chosen-select-width'     : {width:"90%"}
}

for (var selector in config) 
{
	$(selector).chosen(config[selector]);
}
									

function get_bank(id)
{
	var xmlhttp;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	}
	else
	{
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}


	xmlhttp.open("GET","<?php echo site_url("boletos/bank_desc");?>/"+id, false);
	xmlhttp.send();
	xmlDoc = xmlhttp.responseText;
	document.getElementById('descricao').value = xmlDoc.trim();

}
</script>

<?php $this->load->view("partial/footer"); ?>