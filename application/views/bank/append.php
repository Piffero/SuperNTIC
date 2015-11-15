<?php $this->load->view("partial/header"); ?>
<div class="cl-mcont">
	<div class="block-flat">
		<div class="header">
			<h3>
				<span style="color: dodgerblue;">Registro de Bancos: <?php if(isset($banks_info->name))echo $banks_info->name;?></span>
			</h3>
		</div>
   			<?php if(isset($manage_result)){echo $manage_result;} ?>
			<div class="row">
			<span style="margin-left: 18px;"><small>Obs.: Todos os campos com *
					obrigatórios</small></span><br> <br>
          		<?php echo form_open('banks/save/'.$banks_info->bank_id, array('id'=>'banks_form','class'=>'form-horizontal group-border-dashed', 'style'=>'border-radius: 0px;')); ?>
          			<div class="col-sm-3 col-lg-2 col-md-3">
				<h5>
					<strong>Agencia - Dígito:</strong>
				</h5>
				<div class="form-group" style="padding: 0px 0px !important;">
					<input type="hidden" name="cod_bank" value="<?php if(isset($banks_info->cod_bank))echo $banks_info->cod_bank;?>">
					<input type="hidden" name="name" value="<?php if(isset($banks_info->name))echo $banks_info->name;?>">
					<input style="display: inline-block; width: 65%;" type="text" placeholder="Ex.: 1821" data-mask="####" class="form-control" name="agency" value="<?php if(isset($banks_info->agency))echo $banks_info->agency;?>">
					- <input style="display: inline-block; width: 25%;" type="text" placeholder="Ex.: 2" data-mask="A" class="form-control" name="digito_agency" value="<?php if(isset($banks_info->digito_agency))echo $banks_info->digito_agency;?>">
				</div>
			</div>
			<div class="col-sm-3 col-lg-3 col-md-3">
				<h5><strong>Conta Cedente - Dígito:</strong></h5>
				<div class="form-group" style="padding: 0px 0px !important;">
					<input style="display: inline-block; width: 70%;" type="text" data-mask="########" class="form-control" placeholder="Ex.: 12345" name="account"	value="<?php if(isset($banks_info->account))echo $banks_info->account;?>">
					- <input style="display: inline-block; width: 20%;" type="text" class="form-control" placeholder="Ex.: 3" data-mask="AAA" name="digito_account" value="<?php if(isset($banks_info->digito_account))echo $banks_info->digito_account;?>">
				</div>
			</div>
			<div class="col-sm-2 col-lg-2 col-md-2">
				<h5><strong>* Carteira:</strong></h5>
				<input type="text" class="form-control" data-mask="AAA" required="required" placeholder="Ex.: RG" name="carteira" value="<?php if(isset($banks_info->carteira)) echo $banks_info->carteira;?>">
			</div>

			<div class="col-sm-3 col-lg-2 col-md-3">
				<h5><strong>Convenio:</strong></h5>
				<input type="text" data-mask="########" placeholder="Ex.: 25000012345678923" class="form-control" name="convenio" value="<?php if(isset($banks_info->convenio))echo $banks_info->convenio;?>">
			</div>
			<div class="col-sm-3 col-lg-2 col-md-3">
				<h5><strong>Contrato:</strong></h5>
				<input type="text" data-mask="######" placeholder="Ex.: 091231" class="form-control" name="contrato" value="<?php if(isset($banks_info->contrato))echo $banks_info->contrato;?>">
			</div>
			<!-- <div class="col-sm-2 col-lg-2 col-md-2">
						<h5><strong>Seq. Remessa:</strong></h5>
						<input type="text" name="remessa" class="form-control" data-mask="###########" placeholder="Ex.: 100000000" name="remessa" value="<?php if(isset($banks_info->remessa))echo $banks_info->remessa;?>">
					</div>
					<div class="col-sm-2 col-lg-2 col-md-2">
						<h5><strong>Seq. Deb. Conta:</strong></h5>
						<input type="text" name="debito" class="form-control" data-mask="###########" placeholder="Ex.: 100000000" value="<?php if(isset($banks_info->debito)) echo $banks_info->debito;?>">
					</div>  -->
			<div class="col-sm-6 col-lg-5 col-md-6">
				<h5><strong>* Cedente da conta para Boletos e Carnês:</strong></h5>
				<select name="cedente" class="form-control">
					<?php if (isset($lista_empresas)){echo $lista_empresas;}?>
				</select>
			</div>
			<div class="col-sm-6 col-lg-6 col-md-6">
				<h5><strong>* Local de Pagamento para Boletos e Carnês:</strong></h5>
				<input type="text" maxlength="255" class="form-control" required="required" placeholder="Ex.: Casas lotéricas até o valor limite" name="local" value="<?php if(isset($banks_info->local))echo strtoupper($banks_info->local);?>">
			</div>
			<div class="col-sm-6 col-lg-6 col-md-6">
				<h5><strong>Instruções para Boletos e Carnês:</strong></h5>
				<textarea rows="5" maxlength="2550" name="instrucoes" placeholder="Ex.: NÃO RECEBER APÓS 30 DIAS DE VENCIMENTO, COBRAR JUROS..." style="resize: none" class="form-control"><?php if(isset($banks_info->instrucoes))echo $banks_info->instrucoes;?></textarea>
			</div>
			<div class="col-sm-6 col-lg-6 col-md-6">
				<h5><strong>Mensagem Remessa para Boletos e Carnês:</strong></h5>
				<textarea rows="5" maxlength="2550" name="message" style="resize: none;" class="form-control" placeholder="Ex.: O não pagamento implica na suspensão automática dos serviços"><?php if(isset($banks_info->message))echo $banks_info->message;?></textarea>
			</div>
			<div class="form-group" style="display: inline-block;">
				<div class="col-md-12 col-lg-12 col-sm-12">
					<button class="btn btn-primary btn-flat" type="button" onClick="validador('banks_form', 'required')"><i class="fa fa-check"></i> Salvar </button>
					<a class="btn btn-default btn-flat" type="button" href="<?php echo $this->config->site_url('banks');?>"><i class="fa fa-times"></i> Cancelar</a>
				</div>
			</div>
              	<?php form_close(); ?>
          	</div>
	</div>
</div>
<?php $this->load->view("partial/footer"); ?>