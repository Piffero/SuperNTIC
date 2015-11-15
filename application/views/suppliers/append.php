 <?php $this->load->view("partial/header"); ?>
<div class="container-fluid" id="pcont">
	<div class="page-head">
		<h2>Registro de Fornecedor</h2>
	</div>
	<div class="cl-mcont">
			<?php if(isset($manage_result)){echo $manage_result;}else{echo '';}; ?>

			<div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="tab-container">

					<!------CONTROL TABS START------->
					<ul class="nav nav-tabs">
						<li class="<?php echo $add;?>"><a href="#add" data-toggle="tab"><i
								class="fa fa-plus"></i> Inserir Fornecedor</a></li>
						<li class="<?php echo $address;?>"><a
							<?php echo $active_tab_address; ?>><i class="fa fa-home"></i>
								Endereço</a></li>
						<li class="<?php echo $contact;?>"><a
							<?php echo $active_tab_contact; ?>><i class="fa fa-phone"></i>
								Contato</a></li>
						<li class="<?php echo $comment;?>"><a
							<?php echo $active_tab_comment; ?>><i class="fa fa-quote-left"></i>
								Comentários</a></li>
						<li class="<?php echo $purchase;?>"><a
							<?php echo $active_tab_purchase; ?>><i class="fa fa-gavel"></i>
								Compras realizadas</a></li>
					</ul>
					<!------CONTROL TABS END------->

					<div class="tab-content">

						<div class="tab-pane <?php echo $add;?> cont" id="add">
							<div class="col-md-12">
								<div class="header">
									<h3>Dados do Fornecedor</h3>
								</div>

								<!----BASIC FORM STARTS--->
								<div class="content">
          																	   
										    <?php
														if (isset ( $suppliers_info->suppliers_id )) {
															echo form_open ( 'suppliers/save/' . $suppliers_info->suppliers_id, array (
																	'id' => 'suppliers_form',
																	'class' => 'form-horizontal group-border-dashed',
																	'style' => 'border-radius: 0px;' 
															) );
														} else {
															echo form_open ( 'suppliers/save', array (
																	'id' => 'suppliers_form',
																	'class' => 'form-horizontal group-border-dashed',
																	'style' => 'border-radius: 0px;' 
															) );
														}
														
														?>
										    
             								<div class="form-group">
										<div class="col-sm-1">
											<input type="text" readonly="readonly" class="form-control"
												placeholder="Código"
												data-original-title="Código do Fornecedor"
												data-toggle="tooltip" name="suppliers_id"
												value="<?php if(isset($suppliers_info->suppliers_id)){ echo $suppliers_info->suppliers_id;}?>">
										</div>
										<div class="col-sm-6">
											<input type="text"
												class="form-control parsley-validated parsley-error"
												autofocus="autofocus" placeholder="Razão Social"
												data-original-title="Razão Social do Fornecedor"
												data-toggle="tooltip" name="corporate_name"
												value="<?php if(isset($suppliers_info->corporate_name)){ echo $suppliers_info->corporate_name;}?>">
										</div>
										<div class="col-sm-4">
											<input type="text"
												class="form-control parsley-validated parsley-error"
												placeholder="Fantasia"
												data-original-title="Nome Fantasia do Fornecedor"
												data-toggle="tooltip" name="fancy_name"
												value="<?php if(isset($suppliers_info->fancy_name)){ echo $suppliers_info->fancy_name;}?>">
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-3">
											<input type="text"
												class="form-control parsley-validated parsley-error"
												placeholder="CNPJ" data-original-title="CNPJ do Fornecedor"
												data-toggle="tooltip" name="document_cnpj"
												data-mask="00.000.000/0000-00"
												value="<?php if(isset($suppliers_info->document_cnpj)){ echo $suppliers_info->document_cnpj;}?>">
										</div>
										<div class="col-sm-3">
											<input type="text" class="form-control parsley-validated"
												placeholder="IE"
												data-original-title="Inscrição Estadual do Fornecedor"
												data-toggle="tooltip" name="document_ie"
												data-mask="000.000.000.000"
												value="<?php if(isset($suppliers_info->document_ie)){ echo $suppliers_info->document_ie;}?>">
										</div>
										<div class="col-sm-2"
											data-original-title="Insentos de Inscrição Estadual"
											data-toggle="tooltip">
											<input type="checkbox" name="exempt"
												<?php if(isset($suppliers_info->exempt)){ if($suppliers_info->exempt == 1){echo 'chequed="chequed"';}}?>
												value="1"> Isento
										</div>
									</div>


									<div class="form-group text-right">
										<button class="btn btn-primary btn-flat" type="button"
											onClick="document.getElementById('suppliers_form').submit()">
											<i class="fa fa-check"></i> Salvar
										</button>
										<a class="btn btn-default btn-flat" type="button"
											href="<?php echo $this->config->site_url('suppliers');?>"><i
											class="fa fa-times"></i> Cancelar</a>
									</div>           						
              							<?php echo form_close();?>
          							
          							</div>
								<!----BASIC FORM END--->
							</div>
						</div>




						<div class="tab-pane <?php echo $address;?> cont" id="address">
							<div class="col-md-12">
								<div class="header">
									<h3>Dados de Endereço</h3>
								</div>

								<!----ADDRESS FORM STARTS--->
								<div class="content">
          							         <?php
																										echo form_open ( 'suppliers/save_address/' . $suppliers_info->suppliers_id, array (
																												'id' => 'suppliers_address',
																												'class' => 'form-horizontal group-border-dashed',
																												'style' => 'border-radius: 0px;' 
																										) );
																										?> 								
										             								             						
	              							<div class="form-group">
										<div class="col-sm-1">
											<input type="text" readonly="readonly" class="form-control"
												placeholder="Código"
												data-original-title="Código do Fornecedor"
												data-toggle="tooltip" name="suppliers_id"
												value="<?php if(isset($suppliers_info->suppliers_id)){ echo $suppliers_info->suppliers_id;}?>">
										</div>
										<div class="col-sm-4">
											<input type="text"
												class="form-control parsley-validated parsley-error"
												placeholder="Endereço"
												data-original-title="Endereço Fornecedor"
												data-toggle="tooltip" name="address_1"
												value="<?php if(isset($suppliers_info->address_1)){ echo $suppliers_info->address_1;}?>">
										</div>
										<div class="col-sm-4">
											<input type="text"
												class="form-control parsley-validated parsley-error"
												placeholder="Complemento"
												data-original-title="Complemento Fornecedor"
												name="address_2"
												value="<?php if(isset($suppliers_info->address_2)){ echo $suppliers_info->address_2;}?>">
										</div>
										<div class="col-sm-3">
											<input type="text"
												class="form-control parsley-validated parsley-error"
												placeholder="Bairro" data-original-title="Bairro Fornecedor"
												data-toggle="tooltip" name="country"
												value="<?php if(isset($suppliers_info->country)){ echo $suppliers_info->country;}?>">
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-5">
											<input type="text"
												class="form-control parsley-validated parsley-error"
												placeholder="Cidade" data-original-title="Cidade Fornecedor"
												data-toggle="tooltip" name="city"
												value="<?php if(isset($suppliers_info->city)){ echo $suppliers_info->city;}?>">
										</div>
										<div class="col-sm-1">
											<input type="text"
												class="form-control parsley-validated parsley-error"
												placeholder="UF" data-original-title="UF Fornecedor"
												data-toggle="tooltip" name="state"
												value="<?php if(isset($suppliers_info->state)){ echo $suppliers_info->state;}?>">
										</div>
										<div class="col-sm-2">
											<input type="text"
												class="form-control parsley-validated parsley-error"
												placeholder="Cep" data-original-title="CEP Fornecedor"
												data-toggle="tooltip" name="zip" data-mask="00.000-000"
												value="<?php if(isset($suppliers_info->zip)){ echo $suppliers_info->zip;}?>">
										</div>
										<div class="col-sm-1">
											<a href="http://www.buscacep.correios.com.br/"
												target="_blank"><img width="30px"
												src="<?php echo $this->config->base_url();?>web/images/correios.png"></a>
										</div>
									</div>


									<div class="form-group text-right">
										<button class="btn btn-primary btn-flat" type="button"
											onClick="document.getElementById('suppliers_address').submit()">
											<i class="fa fa-check"></i> Salvar
										</button>
										<a class="btn btn-default btn-flat" type="button"
											href="<?php echo $this->config->site_url('suppliers');?>"><i
											class="fa fa-times"></i> Cancelar</a>
									</div>           						
              							<?php echo form_close();?>
              							
              							
          							</div>
							</div>
						</div>



						<div class="tab-pane <?php echo $contact;?> cont" id="contact">
							<div class="col-md-12">
								<div class="header">
									<h3>Dados para Contato</h3>
								</div>

								<!----ADDRESS FORM STARTS--->
								<div class="content">          							
										  <?php
												echo form_open ( 'suppliers/save_contact/' . $suppliers_info->suppliers_id, array (
														'id' => 'suppliers_contact',
														'class' => 'form-horizontal group-border-dashed',
														'style' => 'border-radius: 0px;' 
												) );
												?>
											            								
              								<div class="form-group">
										<div class="col-sm-3">
											<input type="text"
												class="form-control parsley-validated parsley-error"
												placeholder="Telefone"
												data-original-title="Telefone Fornecedor"
												data-toggle="tooltip" name="phone_number"
												data-mask="(00) 000000000"
												value="<?php if(isset($suppliers_info->phone_number)){ echo $suppliers_info->phone_number;}?>">
										</div>
										<div class="col-sm-6">
											<input type="text" class="form-control" placeholder="Email"
												data-original-title="Email Fornecedor" data-toggle="tooltip"
												name="email"
												value="<?php if(isset($suppliers_info->email)){ echo $suppliers_info->email;}?>">
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-6">
											<input type="text" class="form-control" placeholder="WebSite"
												data-original-title="Site Fornecedor" data-toggle="tooltip"
												name="website"
												value="<?php if(isset($suppliers_info->website)){ echo $suppliers_info->website;}?>">
										</div>
									</div>

									<div class="form-group text-right">
										<button class="btn btn-primary btn-flat" type="button"
											onClick="document.getElementById('suppliers_contact').submit()">
											<i class="fa fa-check"></i> Salvar
										</button>
										<a class="btn btn-default btn-flat" type="button"
											href="<?php echo $this->config->site_url('suppliers');?>"><i
											class="fa fa-times"></i> Cancelar</a>
									</div>           						
              							<?php echo form_close();?>
              							
          							</div>
							</div>
						</div>



						<div class="tab-pane <?php echo $comment;?> cont" id="comment">
							<div class="col-md-12">
								<div class="header">
									<h3>Coment&#225;rios e Avisos</h3>
								</div>

								<!----ADDRESS FORM STARTS--->
								<div class="content">          							
										  <?php
												echo form_open ( 'suppliers/save_comment/' . $suppliers_info->suppliers_id, array (
														'id' => 'suppliers_comment',
														'class' => 'form-horizontal group-border-dashed',
														'style' => 'border-radius: 0px;' 
												) );
												?> 	
          									
             								<div class="form-group">
										<div class="col-sm-12">
											<textarea class="form-control" name="comments"><?php if(isset($suppliers_info->comments)){ echo $suppliers_info->comments;}?></textarea>
										</div>
									</div>

									<div class="form-group text-right">
										<button class="btn btn-primary btn-flat" type="button"
											onClick="document.getElementById('suppliers_comment').submit()">
											<i class="fa fa-check"></i> Salvar
										</button>
										<a class="btn btn-default btn-flat" type="button"
											href="<?php echo $this->config->site_url('suppliers');?>"><i
											class="fa fa-times"></i> Cancelar</a>
									</div>           						
              							<?php echo form_close();?>
              						</div>
							</div>
						</div>



						<div class="tab-pane <?php echo $purchase;?> cont" id="purchase">
							<div class="col-md-12">
								<div class="header">
									<h3>Histórico Pedidos</h3>
								</div>

								<!----ADDRESS FORM STARTS--->
								<div class="content">   
          					
          							
          							<?php echo $suppler_purch;?>
          							
          							
              						</div>
							</div>
						</div>

					</div>

				</div>
			</div>
		</div>

	</div>

</div>
    
    
<?php $this->load->view("partial/footer"); ?>