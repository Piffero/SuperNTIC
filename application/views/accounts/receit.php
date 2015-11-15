<!DOCTYPE html>
<html lang="en">

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="" />
<meta name="author" content="" />

<link rel="shortcut icon"
	href="<?php echo $this->config->base_url();?>web/images/favicon.png" />

<title><?php echo $this->config->item('company').' -- ' ?>NTIC Nucleo de Tecnologia da Informacao e Comunicacao</title>
<link
	href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800"
	rel="stylesheet" type="text/css" />
<link href="http://fonts.googleapis.com/css?family=Raleway:300,200,100"
	rel="stylesheet" type="text/css" />
<link
	href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700'
	rel='stylesheet' type='text/css'>
<link
	href="<?php echo $this->config->base_url();?>web/js/bootstrap/dist/css/bootstrap.css"
	rel="stylesheet" />

<link rel="stylesheet"
	href="<?php echo $this->config->base_url();?>web/fonts/font-awesome-4/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css"
	href="<?php echo $this->config->base_url();?>web/js/jquery.nanoscroller/nanoscroller.css" />
<link rel="stylesheet" type="text/css"
	href="<?php echo $this->config->base_url();?>web/js/bootstrap.switch/bootstrap-switch.css" />
<link rel="stylesheet" type="text/css"
	href="<?php echo $this->config->base_url();?>web/js/bootstrap.datetimepicker/css/bootstrap-datetimepicker.min.css" />
<link rel="stylesheet" type="text/css"
	href="<?php echo $this->config->base_url();?>web/js/jquery.select2/select2.css" />
<link rel="stylesheet" type="text/css"
	href="<?php echo $this->config->base_url();?>web/js/bootstrap.slider/css/slider.css" />
<link rel="stylesheet" type="text/css"
	href="<?php echo $this->config->base_url();?>web/js/jquery.niftymodals/css/component.css" />
<link href="<?php echo $this->config->base_url();?>web/css/style.css"
	rel="stylesheet" />


</head>
<body>
	<div class="colored-header success" id="form-primary"
		style="z-index: 9999999">
		<div class="md-content">
			<div class="modal-header">
				<h3>Lan&#231;amento Conta a Receber</h3>

			</div>

			<div class="modal-body form">
                       <?php if(isset($manage_result)){echo $manage_result;}else{echo '';}; ?>
                      		<?php
                        
                        echo form_open('accounts/save/0', array(
                            'id' => 'accounts_form',
                            'class' => 'form-horizontal',
                            'style' => 'border-radius: 0px;'
                        ));
                        ?>

						    <div class="form-group col-sm-12">
					<div class="col-sm-4">
						<label class="control-label">N&#250;mero Documento</label> <input
							type="text" class="form-control" data-mask="#######00"
							name="number" value="<?php echo $accounts_info->number;?>" />
					</div>
					<div class="col-sm-8">
						<label class="control-label">Hist&#243;rico</label> <input
							type="text" class="form-control" name="historic"
							value="<?php echo $accounts_info->historic;?>" />
					</div>
				</div>

				<div class="form-group col-sm-12">
					<div class="col-sm-6">
						<label class="control-label">Cliente</label>
						        	<?php echo form_dropdown('favored',$custormes_info, array($accounts_info->favored), 'class="select2"');?>
						       </div>
					<div class="col-sm-6">
						<label class="control-label">Plano de Contas</label>
						        	<?php echo form_dropdown('plan_accounts',$plan_account_info, array($accounts_info->plan_accounts), 'class="select2"');?>
				            	</div>
				</div>

				<div class="form-group col-sm-12">
					<div class="col-sm-6">
						<label class="control-label">Data de Emiss&#227;o</label> <input
							type="text" class="form-control" data-mask="00/00/0000"
							name="date"
							value="<?php echo get_date_view($accounts_info->date);?>" />
					</div>
					<div class="col-sm-6">
						<label class="control-label">Data de Vencimento</label> <input
							type="text" class="form-control" data-mask="00/00/0000"
							name="date"
							value="<?php echo get_date_view($accounts_info->date);?>" />
					</div>
				</div>

				<div class="form-group col-sm-12">
					<div class="col-sm-4">
						<label class="control-label">Valor</label> <input type="text"
							class="form-control" data-mask="######0,00"
							data-mask-reverse="true" name="value"
							value="<?php echo $accounts_info->value;?>" />
					</div>
					<div class="col-sm-8">
						<label class="control-label">Forma de Pagamento</label>
					             	<?php echo form_dropdown('payment_form',$playment_form, array($accounts_info->payment_form), 'class="select2"');?>					             	
								<br />
						<br /> <input name="account_id"
							value="<?php echo $accounts_info->id;?>"
							style="visibility: hidden;" />

						<p align="right">
							<button type="button"
								onClick="document.getElementById('accounts_form').submit(); opener.location.reload();"
								class="btn btn-success btn-flat">Salvar</button>
							<button type="reset" class="btn btn-default btn-flat"
								onClick="opener.location.reload(); self.close()">Fechar</button>
						</p>
					</div>
	                    
                      		<?php echo form_close();?>
                    	</div>

			</div>
		</div>
	</div> 
<?php $this->load->view("partial/footer"); ?>