 <?php date_default_timezone_set("Brazil/East");?>
 <?php $this->load->view("partial/header"); ?>
<div class="container-fluid" id="pcont">
	<div class="page-head">
		<h2>
			Registro do Cliente <font color="green"><b> <?php echo $customers_info->first_name.' '.$customers_info->last_name;?> </b></font>
		</h2>
	</div>
	<div class="cl-mcont">
			<?php if(isset($manage_result)){echo $manage_result;}else{echo '';}; ?>

			<div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="tab-container">

					<!------CONTROL TABS START------->
					<ul class="nav nav-tabs">
						<li class="<?php echo $add;?>"><a href="#add" data-toggle="tab"><i
								class="fa fa-plus"></i> Inserir Cliente</a></li>
						<li class="<?php echo $addr;?>"><a
							<?php if(isset($active_address)){echo $active_address;}else{echo '';}?>><i
								class="fa fa-envelope"></i> Endereço</a></li>
						<li class="<?php echo $cont;?>"><a
							<?php if(isset($active_contato)){echo $active_contato;}else{echo '';}?>><i
								class="fa fa-phone"></i> Contato</a></li>
						<li class="<?php echo $item;?>"><a
							<?php if(isset($active_item)){echo $active_item;}else{echo '';}?>><i
								class="fa fa-headphones"></i> Produtos do Cliente</a></li>
						<li class="<?php echo $info;?>"><a
							<?php if(isset($active_info)){echo $active_info;}else{echo '';}?>><i
								class="fa fa-star"></i> Informa&#231;&#245;es Adicionais</a></li>
						<li class="<?php if(isset($ficha)){echo $ficha;}?>"><a
							<?php if(isset($active_ficha)){echo $active_ficha;}else{echo '';}?>><i
								class="fa fa-stethoscope"></i> Ficha Técnica</a></li>
					</ul>
					<!------CONTROL TABS END------->

					<div class="tab-content">

						<div class="tab-pane <?php echo $add;?> cont" id="add">
							<div class="col-md-12">
								<div class="header">
									<h3>Dados do Cliente</h3>
								</div>

								<!----BASIC FORM STARTS--->
								<div class="content">
          																	   
										    <?php
            echo form_open('customers/save/' . $customers_info->patient_id, array(
                'id' => 'customers_form',
                'class' => 'form-horizontal',
                'style' => 'border-radius: 0px;'
            ));
            ?>
										    
             								<div class="form-group">
										<div class="col-sm-1 col-md-1 col-lg-1">
											<input type="text" readonly="readonly" class="form-control"
												placeholder="Código" data-original-title="Código"
												data-toggle="tooltip" name="patient_id"
												value="<?php echo $customers_info->patient_id;?>">
										</div>
										<div class="col-sm-3 col-md-3 col-lg-3">
											<input type="text"
												class="form-control parsley-validated parsley-error"
												autofocus="autofocus" placeholder="Nome"
												data-original-title="Nome" data-toggle="tooltip"
												name="first_name"
												value="<?php echo $customers_info->first_name;?>">
										</div>
										<div class="col-sm-3 col-md-3 col-lg-3">
											<input type="text"
												class="form-control parsley-validated parsley-error"
												placeholder="Sobrenome" data-original-title="Sobrenome"
												data-toggle="tooltip" name="last_name"
												value="<?php echo $customers_info->last_name;?>">
										</div>
										<div class="col-sm-2 col-md-2 col-lg-2">    											
    													<?php echo form_dropdown('sex', array('Masculino' => 'Masculino', 'Feminino' => 'Feminino'), array($customers_info->sex), 'class="form-control"' );?>
    											</div>
										<div class="input-group col-sm-3 col-md-3 col-lg-3">
											<input type="text"
												class="form-control parsley-validated parsley-error"
												placeholder="Cliente Desde"
												data-original-title="Cliente Desde" data-toggle="tooltip"
												name="account_opening" data-mask="00/00/0000"
												value="<?php if(!empty($customers_info->account_opening) or ($customers_info->account_opening != '')){echo $customers_info->account_opening;} else {echo date('d/m/Y');};?>"></input>
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-4 col-md-4 col-lg-4"></div>
										<div class="col-sm-3 col-md-3 col-lg-3">
											<input class="form-control parsley-validated parsley-error"
												placeholder="CPF ou CNPJ" data-original-title="CPF ou CNPJ"
												data-toggle="tooltip" type="text" name="document_cpf"
												value="<?php echo $customers_info->document_cpf;?>">
										</div>
										<div class="col-sm-2 col-md-2 col-lg-2">
											<input type="text"
												class="form-control parsley-validated parsley-error"
												placeholder="RG ou IE" data-original-title="RG ou IE"
												data-toggle="tooltip" name="document_rg"
												value="<?php echo$customers_info->document_rg;?>">
										</div>
										<div class="input-group col-sm-3 col-md-3 col-lg-3">
											<input class="form-control parsley-validated parsley-error"
												type="text" name="birth_date"
												placeholder="Data de Nascimento"
												data-original-title="Data de Nascimento"
												data-toggle="tooltip" data-mask="00/00/0000"
												value="<?php echo $customers_info->birth_date;?>"></input>
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-3 col-md-3 col-lg-3">
											<input type="checkbox" name="waives_terms" value="1"
												<?php if(isset($customers_info->waives_terms)){if($customers_info->waives_terms == 1){echo "checked";}}?>>
											Protecao de Dados
										</div>
										<div class="col-sm-3 col-md-3 col-lg-3">
											<input type="checkbox" name="sending_letter" value="1"
												<?php if(isset($customers_info->sending_letter)){if($customers_info->sending_letter == 1){echo "checked";}}?>>
											OK para Envio de Corespondencia
										</div>
										<div class="col-sm-3 col-md-3 col-lg-3">
											<input type="checkbox" name="sending_email" value="1"
												<?php if(isset($customers_info->sending_email)){if($customers_info->sending_email == 1){echo "checked";}}?>>
											OK para Envio de Email
										</div>
										<div class="col-sm-3 col-md-3 col-lg-3">
											<input type="checkbox" name="sending_sms" value="1"
												<?php if(isset($customers_info->sending_sms)){if($customers_info->sending_sms == 1){echo "checked";}}?>>
											OK para Envio de SMS
										</div>
									</div>

									<input id="action1" type="hidden" name="save" />

									<div class="form-group text-right">
										<button class="btn btn-danger btn-flat" type="button"
											onClick="document.getElementById('action1').setAttribute('value','1'); document.getElementById('customers_form').submit();">
											<i class="fa fa-file"></i> Salvar e Adicionar Novo
										</button>
										<button class="btn btn-primary btn-flat" type="button"
											onClick="document.getElementById('action1').setAttribute('value','0'); document.getElementById('customers_form').submit();">
											<i class="fa fa-check"></i> Salvar e Continuar
										</button>
										<a class="btn btn-default btn-flat" type="button"
											href="<?php echo $this->config->site_url('customers');?>"><i
											class="fa fa-times"></i> Cancelar</a>
									</div>
          							                    						
              							<?php echo form_close();?>
          							
          							</div>
								<!----BASIC FORMos END--->
							</div>
						</div>





						<div class="tab-pane <?php echo $addr;?> cont" id="addr">
							<div class="col-md-12">
								<div class="header">
									<h3>Dados de Endere&#231;o</h3>
								</div>

								<!----ADDRESS FORM STARTS--->
								<div class="content">
          																	   
										    <?php
            echo form_open('customers/save_address/' . $customers_info->patient_id, array(
                'id' => 'address_form',
                'class' => 'form-horizontal',
                'style' => 'border-radius: 0px;'
            ));
            ?>
										    
             								<div class="form-group">
										<div class="col-sm-1 col-md-1 col-lg-1">
											<input type="text" readonly="readonly" class="form-control"
												placeholder="Código" data-original-title="Código"
												data-toggle="tooltip" name="patient_id"
												value="<?php if(isset($customers_info->patient_id)){echo $customers_info->patient_id;}?>">
										</div>
										<div class="col-sm-5">
											<input type="text"
												class="form-control parsley-validated parsley-error"
												placeholder="Logradouro" data-original-title="Logradouro"
												data-toggle="tooltip" name="address_1"
												value="<?php if(isset($customers_info->address_1)){echo$customers_info->address_1;}?>">
										</div>
										<div class="col-sm-5">
											<input type="text" class="form-control"
												placeholder="Complemento" data-original-title="Complemento"
												data-toggle="tooltip" name="address_2"
												value="<?php if(isset($customers_info->address_2)){ echo$customers_info->address_2;}?>">
										</div>
										<div class="col-sm-1">
	            	    							<?php echo form_dropdown('state',$Ibge_uf,$customers_info->state,'id="state" class="form-control parsley-validated parsley-error" placeholder="UF"  data-original-title="UF" data-toggle="tooltip" onchange="ibge_mun();"')?>    	    	          							
	            	    						</div>
									</div>

									<div class="form-group">
										<div class="col-sm-3">              									
              										<?php echo form_dropdown('city',$Ibge_Mun,$customers_info->city,'id="city" class="form-control parsley-validated parsley-error" placeholder="Município"  data-original-title="Município" data-toggle="tooltip"')?>    	    	          							
	            	    						</div>
										<div class="col-sm-6">
											<input type="text" class="form-control" name="country"
												value="<?php if(isset($customers_info->country)){echo$customers_info->country;}?>">
										</div>
										<div class="col-sm-2">
											<input type="text" class="form-control" name="zip"
												data-mask="00.000-000"
												value="<?php if(isset($customers_info->zip)){echo $customers_info->zip;}?>">
										</div>
										<div class="col-sm-1">
											<a href="http://www.buscacep.correios.com.br/"
												target="_blank"><img width="30px"
												src="<?php echo $this->config->base_url();?>web/images/correios.png"></a>
										</div>
									</div>

									<input id="action1" type="hidden" name="save" />

									<div class="form-group text-right">
										<button class="btn btn-danger btn-flat" type="button"
											onClick="document.getElementById('action1').setAttribute('value','1'); document.getElementById('address_form').submit();">
											<i class="fa fa-file"></i> Salvar e Adicionar Novo
										</button>
										<button class="btn btn-primary btn-flat" type="button"
											onClick="document.getElementById('action1').setAttribute('value','0'); document.getElementById('address_form').submit();">
											<i class="fa fa-check"></i> Salvar e Continuar
										</button>
										<a class="btn btn-default btn-flat" type="button"
											href="<?php echo $this->config->site_url('customers');?>"><i
											class="fa fa-times"></i> Cancelar</a>
									</div>
          							                    						
              							<?php echo form_close();?>
          							
          							</div>
								<!----ADDRESS FORM END--->
							</div>
						</div>



						<div class="tab-pane <?php echo $cont;?> cont" id="cont">
							<div class="col-md-12">
								<div class="header">
									<h3>Dados para Contato</h3>
								</div>

								<!----CONTATO FORM STARTS--->
								<div class="content">
          																	   
										    <?php
            echo form_open('customers/save_contato/' . $customers_info->patient_id, array(
                'id' => 'contato_form',
                'class' => 'form-horizontal group-border-dashed',
                'style' => 'border-radius: 0px;'
            ));
            ?>
        					
											
											<div class="form-group">
										<div class="col-sm-1 col-md-1 col-lg-1">
											<input type="text" readonly="readonly" class="form-control"
												placeholder="Código" data-original-title="Código"
												data-toggle="tooltip" name="patient_id"
												value="<?php echo $customers_info->patient_id;?>">
										</div>
										<div class="col-sm-9">
											<input type="text" class="form-control"
												placeholder="Endereço de email"
												data-original-title="Endereço de email"
												data-toggle="tooltip" name="email"
												value="<?php echo$customers_info->email;?>">
										</div>
										<div class="col-sm-2">
											<select class="form-control"												
												data-original-title="Telefone Principal"
												data-toggle="tooltip" name="phone_number">
												<option value="1">Residencial</option>
												<option value="2">Trabalho</option>
												<option value="3">Celular</option>
												<option value="4">Outro Telefone</option>
											</select>
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-3">
											<input type="text" class="form-control"
												placeholder="Telefone Recidencial"
												data-original-title="Telefone Recidencial"
												data-toggle="tooltip" name="phone_home"
												data-mask="(00) #00000000"
												value="<?php echo $customers_info->phone_home;?>">
										</div>
										<div class="col-sm-3">
											<input type="text" class="form-control"
												placeholder="Telefone do Trabalho"
												data-original-title="Telefone do Trabalho"
												data-toggle="tooltip" name="phone_work"
												data-mask="(00) #00000000"
												value="<?php echo $customers_info->phone_work;?>">
										</div>
										<div class="col-sm-3">
											<input type="text" class="form-control"
												placeholder="Telefone Celular"
												data-original-title="Telefone Celular" data-toggle="tooltip"
												name="phone_cell" data-mask="(00) #00000000"
												value="<?php echo $customers_info->phone_cell; ?>">
										</div>
										<div class="col-sm-3">
											<input type="text" class="form-control"
												placeholder="Outro Telefone"
												data-original-title="Outro Telefone" data-toggle="tooltip"
												name="phone_other" data-mask="(00) #00000000"
												value="<?php echo $customers_info->phone_other?>">
										</div>
									</div>


									<input id="action1" type="hidden" name="save" />

									<div class="form-group text-right">
										<button class="btn btn-danger btn-flat" type="button"
											onClick="document.getElementById('action1').setAttribute('value','1'); document.getElementById('contato_form').submit();">
											<i class="fa fa-file"></i> Salvar e Adicionar Novo
										</button>
										<button class="btn btn-primary btn-flat" type="button"
											onClick="document.getElementById('action1').setAttribute('value','0'); document.getElementById('contato_form').submit();">
											<i class="fa fa-check"></i> Salvar e Continuar
										</button>
										<a class="btn btn-default btn-flat" type="button"
											href="<?php echo $this->config->site_url('customers');?>"><i
											class="fa fa-times"></i> Cancelar</a>
									</div>
        					                						
              							<?php echo form_close();?>
          							
          							</div>
								<!----CONTATO FORM END--->
							</div>
						</div>



						<div class="tab-pane <?php echo $info;?> cont" id="info">
							<div class="col-md-12">
								<div class="header">
									<h3>Atendimento e Outros Dados</h3>
								</div>

								<!----BASIC FORM STARTS--->
								<div class="content">
          							
										 	<?php
            echo form_open('customers/save_info/' . $id, array(
                'id' => 'info_info',
                'class' => 'form-horizontal group-border-dashed',
                'style' => 'border-radius: 0px;'
            ));
            ?>
											
              								
              								<div class="form-group">
										<div class="col-sm-3">
											<input type="text" class="form-control"
												placeholder="Atendimento Anterior"
												data-original-title="Atendimento Anterior"
												data-toggle="tooltip" name="previous_doctor"
												value="<?php if(isset($customers_addinfo->previous_doctor)){echo $customers_addinfo->previous_doctor;}?>">
										</div>
										<div class="col-sm-3">
											<input type="text" class="form-control"
												placeholder="Indicação Medica"
												data-original-title="Indicação Medica" data-toggle="tooltip"
												name="pointer_doctor"
												value="<?php if(isset($customers_addinfo->pointer_doctor)){echo $customers_addinfo->pointer_doctor;}?>">
										</div>

										<div class="col-sm-3"></div>

										<div class="col-sm-3">
											<input class="form-control" type="text"
												placeholder="Data do último teste"
												data-original-title="Data do último teste"
												data-toggle="tooltip" name="last_test_date"
												data-mask="00/00/0000"
												value="<?php if(isset($customers_addinfo->last_test_date)){echo get_date_view($customers_addinfo->last_test_date);}?>"></input>
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-6">
											<textarea class="form-control"
												placeholder="Comentaríos e Obs.:"
												data-original-title="Comentaríos e Obs.:"
												data-toggle="tooltip" name="comments"><?php if(isset($customers_addinfo->comments)){echo $customers_addinfo->comments;}?></textarea>
										</div>
										<div class="col-sm-6">
											<textarea class="form-control"
												placeholder="Informações Sobre Cliente"
												data-original-title="Informações Sobre Cliente"
												data-toggle="tooltip" name="historic"><?php if(isset($customers_addinfo->historic)){echo $customers_addinfo->historic;}?></textarea>
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-6">
											<input type="text" class="form-control"
												placeholder="Perda Auditiva Lado Esquerdo"
												data-original-title="Perda Auditiva Lado Esquerdo"
												data-toggle="tooltip" name="left_loss"
												value="<?php if(isset($customers_addinfo->left_loss)){echo $customers_addinfo->left_loss;}?>">
										</div>
										<div class="col-sm-6">
											<input type="text" class="form-control"
												placeholder="Perda Auditiva Lado Direito"
												data-original-title="Perda Auditiva Lado Direito"
												data-toggle="tooltip" name="right_loss"
												value="<?php if(isset($customers_addinfo->right_loss)){echo $customers_addinfo->right_loss;}?>">
										</div>
									</div>


									<input id="action2" type="hidden" name="save" />

									<div class="form-group text-right">
										<button class="btn btn-danger btn-flat" type="button"
											onClick="document.getElementById('action2').setAttribute('value','1'); document.getElementById('info_info').submit();">
											<i class="fa fa-file"></i> Salvar e Adicionar Novo
										</button>
										<button class="btn btn-primary btn-flat" type="button"
											onClick="document.getElementById('action2').setAttribute('value','0'); document.getElementById('info_info').submit();">
											<i class="fa fa-check"></i> Salvar
										</button>
										<a class="btn btn-default btn-flat" type="button"
											href="<?php echo $this->config->site_url('customers');?>"><i
											class="fa fa-times"></i> Cancelar</a>
									</div>
          							                    						
              							<?php echo form_close();?>									
          								</div>
							</div>
						</div>


						<div class="tab-pane <?php echo $item; ?> cont" id="item">
							<div class="col-md-12">
								<div class="header">
									<h3>Lista de Aparelhos</h3>
								</div>
								<!----ADD TABLE ITEN STARTS--->
								<div class="content">
									<div class="table-responsive">

										<table class="table no-border hover">
											<thead class="no-border">
												<tr>
													<th style="width: 10%;"><strong>Produto</strong></th>
													<th style="width: 10%;"><strong>Marca</strong></th>
													<th style="width: 7%;"><strong>Modelo</strong></th>
													<th style="width: 12%;"><strong>Lado</strong></th>
													<th style="width: 10%;"><strong>Serie</strong></th>
													<th style="width: 15%;"><strong>Data Compra</strong></th>
													<th style="width: 15%;"><strong>Validade Garantia</strong></th>
													<th style="width: 15%;"><strong>Garantia Fabrica</strong></th>
													<th style="width: 20%;" class="text-center"><strong>A&#231;&#227;o</strong></th>
												</tr>
											</thead>
											<tbody class="no-border-y">
												<tr>
												<?php echo form_open('customers/save_apparatus/'.$id, 'id="form2"')?>													
													<td><input type="text" class="form-control"
														name="apparatus"></td>
													<td class="text-right"><input type="text"
														class="form-control" name="maker"></td>
													<td class="color-primary"><input type="text"
														class="form-control" name="model"></td>
													<td><select class="form-control" name="color">
															<option value="Não Especificado">Não Especificado</option>
															<option value="Esquerdo">Esquerdo</option>
															<option value="Direito">Direito</option>
													</select></td>
													<td><input type="text" class="form-control"
														name="number_serie"
														value="<?php echo $generating_series;?>"></td>
													<td>
														<div class="input-group date datetime"
															data-date-format="dd/mm/yyyy" data-min-view="2">
															<input class="form-control" type="text"
																name="purchase_date" data-mask="00/00/0000"></input> <span
																class="input-group-addon btn btn-primary"> <span
																class="glyphicon glyphicon-th"></span>
															</span>
														</div>
													</td>
													<td>
														<div class="input-group date datetime"
															data-date-format="dd/mm/yyyy" data-min-view="2">
															<input class="form-control" type="text"
																name="expires_data" data-mask="00/00/0000"></input> <span
																class="input-group-addon btn btn-primary"> <span
																class="glyphicon glyphicon-th"></span>
															</span>
														</div>
													</td>
													<td>
														<div class="input-group date datetime"
															data-date-format="dd/mm/yyyy" data-min-view="2">
															<input class="form-control" type="text"
																name="suppliers_data" data-mask="00/00/0000"></input> <span
																class="input-group-addon btn btn-primary"> <span
																class="glyphicon glyphicon-th"></span>
															</span>
														</div>
													</td>
													<td class="text-center" colspan="2">
														<button class="btn btn-default" type="button"
															onclick="document.getElementById('form2').submit();">Inserir</button>
													</td>
												<?php echo form_close();?>	
												</tr>
												<?php echo $row_item; ?>																		
											</tbody>
											<tfoot>
												<tr>
													<td align="left" colspan="8">								
														<?php echo $num_row; ?>
													</td>
													<td align="right" colspan="2"><a
														class="btn btn-default btn-flat" type="button"
														href="<?php echo $this->config->site_url('customers');?>"><i
															class="fa fa-times"></i> Fechar</a></td>
												</tr>
										
										</table>

									</div>
								</div>
							</div>
						</div>


						<div
							class="tab-pane <?php
    
    if (isset($ficha)) {
        echo $ficha;
        ;
    }
    ?> cont"
							id="ficha">
							<div class="col-md-12">
								<div class="header">
									<h3>Ficha Técnica de Atendimento</h3>
								</div>
								<!----ADD TABLE ITEN STARTS--->
								<div class="content">
									<div class="table-responsive">
										<table class="hover">
											<thead class="">
												<tr>
													<th style="width: 55%;"><strong>Atendimento</strong></th>
													<th style="width: 25%;" class="text-center"><strong>Fonoaudiólogo(a)</strong></th>
													<th style="width: 20%;" class="text-center"><strong>Data e
															Hora</strong></th>
												</tr>
											</thead>
											<tbody class="hover">
													<?php
            if (isset($table_app)) {
                echo $table_app;
            }
            ?>
												</tbody>
											<tfoot class="no-border-x">
													<?php
            if (isset($linhas)) {
                echo $linhas;
            }
            ?>
											
										
										
										
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script
	src="<?php echo $this->config->base_url();?>web/js/jquery.min.js"></script>

<script type="text/javascript">
<!--  function onchage municipio //-->
function ibge_mun()
{
	var URL = "<?php echo $this->config->site_url('customers/onchangeUF');?>";
	var UF = document.getElementById('state').value;

	$.post(URL,
		    {
				setUF:UF
		    },
		    function(data,status){

		    	   	
		    	var x = document.getElementById("city");
		    	x.options.length = 0;
		    	
		    	
			    eval(data);

				for (var int = 0; int < opt.length; int++) {
							 
					
					var x = document.getElementById("city");
			    	var option = document.createElement("option");

			    	option.text = opt[int];
			    	x.add(option);
				}
			    	
		    }
	);
}
</script>

<?php $this->load->view("partial/footer"); ?>