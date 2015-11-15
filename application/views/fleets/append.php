 <?php $this->load->view("partial/header"); ?>
<div class="container-fluid" id="pcont">
	<div class="page-head">
		<h2>Registro de Ve�culos</h2>
	</div>
	<div class="cl-mcont">
			<?php if(isset($manage_result)){echo $manage_result;}else{echo '';}; ?>
			
			<div class="row">


			<div class="col-sm-8 input-group">&nbsp;</div>

			<div class="col-sm-4 input-group text-right">
				<form action="#" method="post">
					<input class="form-control" type="text" disabled="disabled"
						placeholder="Busca de Ve�culo:" id="search" name="search">
				</form>
			</div>

		</div>

		<div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="tab-container">

					<!------CONTROL TABS START------->
					<ul class="nav nav-tabs">
						<li class="active"><a href="#add" data-toggle="tab"><i
								class="fa fa-plus"></i> Inserir Ve�culo</a></li>
						<li><a href="#info" data-toggle="tab"><i class="fa fa-star"></i>
								Informa&#231;&#245;es Adicionais</a></li>
						<li><a href="#item" data-toggle="tab"><i class="fa fa-headphones"></i>
								Aparelhos do Ve�culo</a></li>
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

									<form class="form-horizontal group-border-dashed"
										action="<?php echo $this->config->base_url().'fleet/save/'.$fleet_info->patient_id;?>"
										style="border-radius: 0px;">

										<div class="form-group text-right">
											<a class="btn btn-primary btn-flat" type="button"
												href="<?php echo $this->config->site_url('fleet/append');?>"><i
												class="fa fa-plus"></i> Novo</a>
											<button class="btn btn-default btn-flat" type="button"
												type="submit">
												<i class="fa fa-floppy-o"></i> Salvar
											</button>
											<a class="btn btn-default btn-flat" type="button"
												href="<?php echo $this->config->site_url('fleet');?>"><i
												class="fa fa-times"></i> Cancelar</a>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label">C&#243;digo:</label>
											<div class="col-sm-6">
												<input type="text" readonly="readonly" class="form-control"
													name="patient_id"
													value="<?php echo $fleet_info->patient_id;?>">
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label text-danger"">Nome:</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="first_name"
													value="<?php echo $fleet_info->first_name;?>">
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label text-danger"">Sobrenome:</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="last_name"
													value="<?php echo $fleet_info->first_name;?>">
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label text-danger"">Atende
												por:</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="prefer_name"
													value="<?php echo $fleet_info->first_name;?>">
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label">Sexo</label>
											<div class="col-sm-6">
												<select class="form-control" name="sex"
													value="<?php echo $fleet_info->sex;?>">
													<option value="Masculino">Masculino</option>
													<option value="Masculino">Feminino</option>
												</select>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label text-danger">Data de
												Nascimento</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="birth_date"
													value="<?php echo $fleet_info->birth_date;?>">
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label text-danger">CPF / CNPJ</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="document_cpf"
													value="<?php echo $fleet_info->document_cpf;?>">
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label text-danger">RG / IE</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="document_rg"
													value="<?php echo $fleet_info->document_rg;?>">
											</div>
										</div>

										<br>

										<h3>Dados de Endere&#231;o</h3>

										<!----ADDRESS FORM STARTS--->

										<div class="form-group">
											<label class="col-sm-3 control-label text-danger">Endere&#231;o:</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="address_1"
													value="<?php echo $fleet_info->address_1;?>">
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label">Complemento:</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="address_2"
													value="<?php echo $fleet_info->address_2;?>">
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label text-danger"">Cidade:</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="city"
													value="<?php echo $fleet_info->city;?>">
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label text-danger">Estado:</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="state"
													value="<?php echo $fleet_info->state;?>">
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label text-danger">CEP:</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="zip"
													value="<?php echo $fleet_info->zip;?>">
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label text-danger">Pais</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="country"
													value="<?php echo $fleet_info->country;?>">
											</div>
										</div>


										<br>

										<h3>Dados de Contato</h3>

										<div class="form-group">
											<label class="col-sm-3 control-label text-danger">Telefone
												Residencial</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="phone_number"
													value="<?php echo $fleet_info->phone_number;?>">
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label">Telefone Trabalho</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="phone_work"
													value="<?php echo $fleet_info->phone_work;?>">
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label">Telefone Celular</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="phone_cell"
													value="<?php echo $fleet_info->phone_cell;?>">
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label">Outro Telefone</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="phone_other"
													value="<?php echo $fleet_info->phone_other;?>">
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label">Telefone Principal</label>
											<div class="col-sm-6">
												<select class="form-control" name="phone_number"
													value="<?php echo $fleet_info->phone_number;?>">
													<option value="1">Residencial</option>
													<option value="2">Trabalho</option>
													<option value="3">Celular</option>
													<option value="4">Outro Telefone</option>
												</select>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label text-danger"">Email:</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="email"
													value="<?php echo $fleet_info->email;?>">
											</div>
										</div>
									</form>

								</div>
								<!----BASIC FORM END--->
							</div>
						</div>





						<div class="tab-pane cont" id="info">
							<div class="col-md-12">
								<div class="header">
									<h3>Dados Adicionais</h3>
								</div>
								<!----ADD FORM STARTS--->
								<div class="content">



									<form class="form-horizontal group-border-dashed"
										action="<?php echo $this->config->base_url().'fleet/save/'.$fleet_info->patient_id;?>"
										style="border-radius: 0px;">


										<div class="form-group text-right">
											<a class="btn btn-primary btn-flat" type="button"
												href="<?php echo $this->config->site_url('fleet/append');?>"><i
												class="fa fa-plus"></i> Novo</a>
											<button class="btn btn-default btn-flat" type="button"
												type="submit">
												<i class="fa fa-floppy-o"></i> Salvar
											</button>
											<a class="btn btn-default btn-flat" type="button"
												href="<?php echo $this->config->site_url('fleet');?>"><i
												class="fa fa-times"></i> Cancelar</a>
										</div>


										<div class="form-group">
											<label class="col-sm-3 control-label">Grupo Sangu&#243;neo:</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="blood_group">
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label">Ve�culo Desde:</label>
											<div class="col-sm-6">
												<input type="text" readonly="readonly" class="form-control"
													name="account_opening_timestamp">
											</div>
										</div>

										<div class="form-group">
											<div class="col-sm-3">
												<div class="control-label">
													Protecao de Dados<br> <br>
												</div>
												<div class="control-label">
													OK para Envio de Corespondencia<br> <br>
												</div>
												<div class="control-label">
													OK para Envio de Email<br> <br>
												</div>
											</div>
											<div class="col-sm-1">
												<div class="radio">
													<input type="checkbox" class="form-control"
														name="waives_terms"
														value="<?php echo $fleet_info->waives_terms;?>">
												</div>
												<div class="radio">
													<input type="checkbox" class="form-control"
														name="sending_letter"
														value="<?php echo $fleet_info->sending_letter;?>">
												</div>
												<div class="radio">
													<input type="checkbox" class="form-control"
														name="sending_email"
														value="<?php echo $fleet_info->sending_email;?>">
												</div>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label">Medico Anterior:</label>
											<div class="col-sm-6">
												<input type="text" class="form-control"
													name="previous_doctor">
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label">Medico Atual:</label>
											<div class="col-sm-6">
												<select class="form-control" name="next_doctor_id">
													<option value="0">Escolha um Medico</option>
												</select>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label">Comentario e Obs.:</label>
											<div class="col-sm-6">
												<textarea class="form-control" name="comments" rows="12"
													cols=""><?php echo $fleet_info->comments;?></textarea>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label">Linguagem:</label>
											<div class="col-sm-6">
												<select class="form-control" name="language"
													value="<?php echo $fleet_info->language;?>">
													<option value="1">Portugues</option>
													<option value="2">Ingles</option>
													<option value="3">Espanhol</option>
												</select>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label">Perda Auditiva Lado
												Esquerdo:</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="left_loss"
													value="<?php echo $fleet_info->left_loss;?>">
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label">Perda Auditiva Lado
												Direito:</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="right_loss"
													value="<?php echo $fleet_info->right_loss;?>">
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label">Data Ultimo Teste:</label>
											<div class="col-sm-6">
												<input type="text" class="form-control"
													name="last_test_date"
													value="<?php echo $fleet_info->last_test_date;?>">
											</div>
										</div>
									</form>

								</div>
								<!----ADD FORM END--->
							</div>
						</div>

						<div class="tab-pane cont" id="item">
							<div class="col-md-12">
								<div class="header">
									<h3>Dados Adicionais</h3>
								</div>
								<!----ADD TABLE ITEN STARTS--->
								<div class="content">
									<div class="table-responsive">
										<table class="table no-border hover">
											<thead class="no-border">
												<tr>
													<th style="width: 2%;">#</th>
													<th style="width: 13%;"><strong>Marca</strong></th>
													<th style="width: 13%;"><strong>Modelo</strong></th>
													<th style="width: 13%;"><strong>Tipo</strong></th>
													<th style="width: 13%;"><strong>Serie</strong></th>
													<th style="width: 13%;"><strong>Lado</strong></th>
													<th style="width: 10%;"><strong>Data Compra</strong></th>
													<th style="width: 10%;"><strong>Validade Garantia</strong></th>
													<th style="width: 15%;" class="text-center"><strong>A&#231;&#227;o</strong></th>
												</tr>
											</thead>
											<tbody class="no-border-y">
												<tr>
													<td>#</td>
													<td><select class="form-control" name="Marker_id">
															<option value="0">Add Marca</option>
													</select></td>
													<td class="text-right"><input type="text"
														class="form-control" name="model"></td>
													<td class="color-primary"><input type="text"
														class="form-control" name="type"></td>
													<td><input type="text" class="form-control"
														name="number_serie"></td>
													<td><select class="form-control" name="side"
														value="<?php echo $fleet_item_info->side;?>">
															<option value="Esquerdo">Esquerdo</option>
															<option value="Direito">Direito</option>
													</select></td>
													<td><input type="text" class="form-control"
														readonly="readonly" name="purchase_date"></td>
													<td><input type="text" class="form-control"
														readonly="readonly" name="expires_data"></td>
													<td class="text-center"><a class="btn btn-default"
														type="button" href="#">Inserir Aparelho</a></td>
												</tr>
												<tr>
													<td>#</td>
													<td class="color-primary"><strong>Xinquilink</strong></td>
													<td class="color-primary"><strong>XFG 8760</strong></td>
													<td>Digital</td>
													<td class="color-primary"><strong>PX9947663E846</strong></td>
													<td>Esquerdo</td>
													<td>10/04/2010</td>
													<td>10/05/2010</td>
													<td class="text-center"><a class="label label-info"
														data-original-title="Trocar Aparelho"
														data-toggle="tooltip" data-placement="bottom" href="#"><i
															class="fa fa-refresh"></i></a> <a
														class="label label-info"
														data-original-title="Abrir Orden Servi&#231;o"
														data-toggle="tooltip" data-placement="bottom" href="#"><i
															class="fa fa-ticket"></i></a> <a
														class="label label-success"
														data-original-title="Editar Aparelho"
														data-toggle="tooltip" data-placement="bottom" href="#"><i
															class="fa fa-pencil"></i></a> <a
														class="label label-danger"
														data-original-title="Excluir Aparelho"
														data-toggle="tooltip" data-placement="bottom" href="#"><i
															class="fa fa-times"></i></a></td>
												</tr>
											</tbody>
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

<?php $this->load->view("partial/footer"); ?>