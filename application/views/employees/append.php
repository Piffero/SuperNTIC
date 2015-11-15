 <?php $this->load->view("partial/header"); ?>
<div class="container-fluid" id="pcont">
	<div class="page-head">
		<h2>Registro de Funcion&#225;rios</h2>
	</div>
	<div class="cl-mcont">
			<?php if(isset($manage_result)){echo $manage_result;}else{echo '';}; ?>

			<div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="tab-container">

					<!------CONTROL TABS START------->
					<ul class="nav nav-tabs">
						<li class="active"><a href="#add" data-toggle="tab"><i
								class="fa fa-plus"></i> Inserir Funcion&#225;rios</a></li>
						<li><a
							<?php if(isset($active_tab)){echo $active_tab;}else{echo '';}?>><i
								class="fa fa-user"></i> Usuário ao Sistema</a></li>
					</ul>
					<!------CONTROL TABS END------->

					<div class="tab-content">

						<div class="tab-pane active cont" id="add">
							<div class="col-md-12">

								<!----BASIC FORM STARTS--->
								<div class="content">
          							
          									 <?php
                    echo form_open('employees/save/' . $employees_info->employees_id, array(
                        'id' => 'employees_form',
                        'class' => 'form-horizontal group-border-dashed',
                        'style' => 'border-radius: 0px;'
                    ));
                    ?>
											<!----EMPLOYEER FORM STARTS--->
									<div class="col-sm-12">
										<strong>Dados</strong>
									</div>

									<div class="form-group">
										<div class="col-sm-1">
											<input type="text" readonly="readonly" class="form-control"
												placeholder="Cód." data-original-title="Código"
												data-toggle="tooltip" autofocus="autofocus"
												name="employees_id"
												value="<?php echo ($employees_info->employees_id);?>">
										</div>
										<div class="col-sm-3">
											<input type="text"
												class="form-control parsley-validated parsley-error"
												placeholder="Nome" data-original-title="Nome"
												data-toggle="tooltip" name="first_name"
												value="<?php echo ($employees_info->first_name);?>">
										</div>
										<div class="col-sm-3">
											<input type="text"
												class="form-control parsley-validated parsley-error"
												placeholder="Sobrenome" data-original-title="Sobrenome"
												data-toggle="tooltip" name="last_name"
												value="<?php echo $employees_info->last_name;?>">
										</div>
										<div class="col-sm-3">
											<input type="text"
												class="form-control parsley-validated parsley-error"
												placeholder="CPF" data-original-title="CPF"
												data-toggle="tooltip" name="document_cpf"
												data-mask="000.000.000-00"
												value="<?php echo $employees_info->document_cpf;?>">
										</div>
										<div class="col-sm-2">
											<input type="text"
												class="form-control parsley-validated parsley-error"
												placeholder="RG" data-original-title="RG"
												data-toggle="tooltip" name="document_rg"
												data-mask="0.000.000-0000"
												value="<?php echo $employees_info->document_rg;?>">
										</div>
									</div>


									<div class="form-group">
										<div class="col-sm-2">
        		        							<?php echo form_dropdown('department_id',$employees_department,array(($employees_info->department_id)),'class="form-control parsley-validated parsley-error" placeholder="Departamento" data-original-title="Departamento" data-toggle="tooltip"') ?>    	        	    								
	            	    						</div>
										<div class="col-sm-3">
											<input type="text"
												class="form-control parsley-validated parsley-error"
												placeholder="Função" data-original-title="Cargo ou Função"
												data-toggle="tooltip" name="profile"
												value="<?php echo ($employees_info->profile);?>">
										</div>
										<div class="col-sm-4"></div>
										<div class="col-sm-3">
											<input type="text"
												class="form-control parsley-validated parsley-error"
												placeholder="Data Nasc."
												data-original-title="Data de Nascimento"
												data-toggle="tooltip" name="birth_date"
												data-mask="00/00/0000"
												value="<?php echo $employees_info->birth_date;?>">
										</div>
									</div>
									<!----EMPLOYEER FORM END--->




									<!----ADDRESS FORM STARTS--->
									<div class="col-sm-12">
										<strong>Endereço</strong>
									</div>

									<div class="form-group">
										<div class="col-sm-5">
											<input type="text"
												class="form-control parsley-validated parsley-error"
												placeholder="Endereço" data-original-title="Endereço"
												data-toggle="tooltip" name="address_1"
												value="<?php echo ($employees_info->address_1);?>">
										</div>
										<div class="col-sm-4">
											<input type="text" class="form-control"
												placeholder="Complemento." data-original-title="Complemento"
												data-toggle="tooltip" name="address_2"
												value="<?php echo ($employees_info->address_2);?>">
										</div>
										<div class="col-sm-3">
											<input type="text"
												class="form-control parsley-validated parsley-error"
												placeholder="Bairro" data-original-title="Bairro"
												data-toggle="tooltip" name="country"
												value="<?php echo ($employees_info->country);?>">
										</div>
									</div>


									<div class="form-group">
										<div class="col-sm-3">
											<input type="text"
												class="form-control parsley-validated parsley-error"
												placeholder="Cidade" data-original-title="Cidade"
												data-toggle="tooltip" name="city"
												value="<?php echo ($employees_info->city);?>">
										</div>
										<div class="col-sm-1">
											<input type="text"
												class="form-control parsley-validated parsley-error"
												placeholder="UF" data-original-title="UF"
												data-toggle="tooltip" name="state"
												value="<?php echo ($employees_info->state);?>">
										</div>
										<div class="col-sm-2">
											<input type="text"
												class="form-control parsley-validated parsley-error"
												placeholder="CEP" data-original-title="CEP"
												data-toggle="tooltip" name="zip" data-mask="00.000-000"
												value="<?php echo $employees_info->zip;?>">
										</div>
										<div class="col-sm-1">
											<a href="http://www.buscacep.correios.com.br/"
												target="_blank"><img width="30px"
												src="<?php echo $this->config->base_url();?>web/images/correios.png"></a>
										</div>
									</div>
									<!----ADDRESS FORM END--->

									<!----CONCTAC FORM START--->
									<div class="col-sm-12">
										<strong>Contato</strong>
									</div>

									<div class="form-group">
										<div class="col-sm-4">
											<input type="text" class="form-control"
												placeholder="Telefone"
												data-original-title="Telefone de Contato"
												data-toggle="tooltip" name="phone_number"
												data-mask="(00) 000000000"
												value="<?php echo $employees_info->phone_number;?>">
										</div>
										<div class="col-sm-6">
											<input type="text" class="form-control" placeholder="Email"
												data-original-title="Email" data-toggle="tooltip"
												name="email" value="<?php echo $employees_info->email;?>">
										</div>
										<div class="col-sm-2" align="center">
	            	    						<?php if($employees_info->isfono == 1) {$check = 'checked';} ?>
	            	    							<input type="checkbox" name="isfono"
												<?php if(isset($check)){echo $check;}?> value="1"> <font
												size="3">É Fonoaudiologo</font>
										</div>
									</div>


									<div class="form-group text-right">
										<button class="btn btn-primary btn-flat" type="button"
											onClick="document.getElementById('employees_form').submit()">
											<i class="fa fa-check"></i> Salvar
										</button>
										<a class="btn btn-default btn-flat" type="button"
											href="<?php echo $this->config->site_url('employees');?>"><i
											class="fa fa-times"></i> Cancelar</a>
									</div>
          							         
          							       		
              							<?php echo form_close();?>
          							
          							</div>
								<!----BASIC FORM END--->
							</div>
						</div>

						<div class="tab-pane cont" id="user">
							<div class="col-md-12">
								<div class="header">
									<h3>Conta do Usuario</h3>
								</div>

								<!----BASIC FORM USER--->
								<div class="content">
          							
          									 <?php
                    echo form_open('employees/save_pass/' . $employees_info->employees_id, array(
                        'id' => 'employees_user',
                        'class' => 'form-horizontal group-border-dashed',
                        'style' => 'border-radius: 0px;'
                    ));
                    ?>
											
											 <div class="form-group">
										<div class="col-sm-1">
											<input type="text" class="form-control" placeholder="Código"
												data-original-title="Código" data-toggle="tooltip"
												name="employees_id" readonly="readonly"
												value="<?php echo $employees_info->employees_id;?>">
										</div>
										<div class="col-sm-4">
											<input type="text"
												class="form-control parsley-validated parsley-error"
												placeholder="Nome de Usuário"
												data-original-title="Nome de Usuaário" data-toggle="tooltip"
												name="username"
												value="<?php if(isset($employees_user->username)){echo $employees_user->username;}?>">
										</div>
										<div class="col-sm-1"></div>
										<div class="col-sm-5">
											<input type="password"
												class="form-control parsley-validated parsley-error"
												placeholder="Senha de Acesso"
												data-original-title="Senha de Acesso" data-toggle="tooltip"
												name="valid_password">
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-6"></div>
										<div class="col-sm-5">
											<input type="password"
												class="form-control parsley-validated parsley-error"
												placeholder="Confirmação de Senha"
												data-original-title="Confirmar Senha" data-toggle="tooltip"
												name="password">
										</div>
									</div>

									<div class="form-group text-right">
										<button class="btn btn-primary btn-flat" type="button"
											onClick="document.getElementById('employees_user').submit()">
											<i class="fa fa-check"></i> Salvar
										</button>
										<a class="btn btn-default btn-flat" type="button"
											href="<?php echo $this->config->site_url('employees');?>"><i
											class="fa fa-times"></i> Cancelar</a>
									</div>
											
											<?php echo form_close(); ?>
									</div>
								<!-- END BASIC FORM USER -->


							</div>
						</div>


					</div>
				</div>

			</div>
		</div>
	</div>

</div>

<?php $this->load->view("partial/footer"); ?>