 <?php $this->load->view("partial/header"); ?>
<div class="container-fluid" id="pcont">
	<div class="page-head">
		<h2>Registro de Formas de Pagamento</h2>
	</div>
	<div class="cl-mcont">
			<?php if(isset($manage_result)){echo $manage_result;}else{echo '';}; ?>

			<div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="tab-container">

					<!------CONTROL TABS START------->
					<ul class="nav nav-tabs">
						<li class="active"><a href="#add" data-toggle="tab"><i
								class="fa fa-plus"></i> Inserir Forma de Pagamento</a></li>
					</ul>
					<!------CONTROL TABS END------->

					<div class="tab-content">

						<div class="tab-pane active cont" id="add">
							<div class="col-md-12">
								<div class="header">
									<h3>Formul&#225;rio Basico</h3>
								</div>

								<!----BASIC FORM STARTS--->
								<div class="content">
          							
          									 <?php
                    echo form_open('methods/save/' . $methods_info->payment_id, array(
                        'id' => 'methods_form',
                        'class' => 'form-horizontal group-border-dashed',
                        'style' => 'border-radius: 0px;'
                    ));
                    ?>
											
										    

          							       
             								<div class="form-group">
										<div class="col-sm-3">
											<input type="text"
												class="form-control parsley-validated parsley-error"
												placeholder="Forma de Pagamento"
												data-original-title="Forma de Pagamento"
												data-toggle="tooltip" name="payment_type"
												value="<?php echo utf8_decode($methods_info->payment_type);?>">
										</div>
										<div class="col-sm-3">
											<select class="select2 select2-offscreen" tabindex="-1"
												name="transaction_id">
												<option Value="Ambos">Ambos</option>
												<option value="Entrada">Entrada</option>
												<option Value="Sa&#237;da">Sa&#237;da</option>
											</select>
										</div>
									</div>


									<div class="form-group">
										<div class="col-sm-6">
        		       									<?php echo form_dropdown('banco', $bancos, array($methods_info->banco), 'class="select2"');?>
    	            								</div>
										<div class="col-sm-3">
											<input type="text"
												class="form-control parsley-validated parsley-error"
												placeholder="Multa" data-original-title="Multa"
												data-toggle="tooltip" name="multa"
												value="<?php echo $methods_info->multa;?>">
										</div>
										<div class="col-sm-3">
											<input type="text"
												class="form-control parsley-validated parsley-error"
												placeholder="Juros" data-original-title="Juros"
												data-toggle="tooltip" name="juros"
												value="<?php echo $methods_info->juros;?>">
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-3">
											<input type="text"
												class="form-control parsley-validated parsley-error"
												placeholder="Data de vencimento"
												data-original-title="Data de vencimento"
												data-toggle="tooltip" name="date_vencimento"
												data-mask="00/00/0000" value="">
										</div>
										<div class="col-sm-3">
											<input type="text"
												class="form-control parsley-validated parsley-error"
												placeholder="Prazo em dias"
												data-original-title="Prazo em dias" data-toggle="tooltip"
												name="prazo_dias" data-mask="#0" data-mask-reverse="true"
												value="">
										</div>
									</div>

									<div class="form-group text-right">
										<button class="btn btn-primary btn-flat" type="button"
											onClick="document.getElementById('methods_form').submit()">
											<i class="fa fa-check"></i> Salvar
										</button>
										<a class="btn btn-default btn-flat" type="button"
											href="<?php echo $this->config->site_url('methods');?>"><i
											class="fa fa-times"></i> Cancelar</a>
									</div>
          							                   							          
          							         				
              							<?php form_close(); ?>
          							
          							</div>
								<!----BASIC FORM END--->
							</div>
						</div>

					</div>

				</div>

			</div>
		</div>
	</div>

</div>

<?php $this->load->view("partial/footer"); ?>