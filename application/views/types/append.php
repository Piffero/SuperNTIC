 <?php $this->load->view("partial/header"); ?>
<div class="container-fluid" id="pcont">
	<div class="page-head">
		<h2>Registro de Tipos de Produtos</h2>
	</div>
	<div class="cl-mcont">
			<?php if(isset($manage_result)){echo $manage_result;}else{echo '';}; ?>

			<div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="tab-container">

					<!------CONTROL TABS START------->
					<ul class="nav nav-tabs">
						<li class="active"><a href="#add" data-toggle="tab"><i
								class="fa fa-plus"></i> Inserir Tipo de Produto</a></li>
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
                    echo form_open('types/save/' . $types_info->type_id, array(
                        'id' => 'types_form',
                        'class' => 'form-horizontal group-border-dashed',
                        'style' => 'border-radius: 0px;'
                    ));
                    ?>
											
										    

          							       
             								<div class="form-group">
										<div class="col-sm-1">
											<input type="text" readonly="readonly"
												class="form-control parsley-validated parsley-error"
												placeholder="Código" data-original-title="Código"
												data-toggle="tooltip" name="category_id"
												value="<?php echo $types_info->type_id;?>">
										</div>
										<div class="col-sm-6">
											<input type="text"
												class="form-control parsley-validated parsley-error"
												autofocus="autofocus" placeholder="Nome do tipo"
												data-original-title="Nome do tipo" data-toggle="tooltip"
												name="name" value="<?php echo $types_info->name;?>">
										</div>

										<div class="col-sm-5">
											<input type="radio" name="issale" value="1"
												<?php if(($types_info->issale == "1") or empty($types_info->issale) or ($types_info->issale == '')){echo 'checked';}?>>
											<span style="color: red">Disponível para venda</span><br> <input
												type="radio" name="issale" value="0"
												<?php if($types_info->issale == "0"){echo 'checked';};?>><span
												style="color: red"> Não Disponível para venda</span>
										</div>
									</div>

									<div class="form-group">
										<div class="col-sm-10">
											<textarea
												class="form-control parsley-validated parsley-error"
												placeholder="Descrição" data-original-title="Descrição"
												data-toggle="tooltip" name="description"><?php echo $types_info->description;?></textarea>
										</div>
									</div>

									<div class="form-group text-right">
										<button class="btn btn-primary btn-flat" type="button"
											onClick="document.getElementById('types_form').submit()">
											<i class="fa fa-check"></i> Salvar
										</button>
										<a class="btn btn-default btn-flat" type="button"
											href="<?php echo $this->config->site_url('types');?>"><i
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