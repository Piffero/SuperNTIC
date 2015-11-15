 <?php $this->load->view("partial/header"); ?>
<div class="container-fluid" id="pcont">
	<div class="page-head">
		<h2>Registro de Categoria de Produtos</h2>
	</div>
	<div class="cl-mcont">
			<?php if(isset($manage_result)){echo $manage_result;}else{echo '';}; ?>

			<div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="tab-container">

					<!------CONTROL TABS START------->
					<ul class="nav nav-tabs">
						<li class="active"><a href="#add" data-toggle="tab"><i
								class="fa fa-plus"></i> Inserir Categoria</a></li>
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
                    echo form_open('categories/save/' . $categories_info->category_id, array(
                        'id' => 'categories_form',
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
												value="<?php echo $categories_info->category_id;?>">
										</div>
										<div class="col-sm-6">
											<input type="text"
												class="form-control parsley-validated parsley-error"
												placeholder="Nome da categoria" autofocus="autofocus"
												data-original-title="Nome da categoria"
												data-toggle="tooltip" name="name"
												value="<?php echo $categories_info->name;?>">
										</div>
									</div>

									<div class="form-group">

										<div class="col-sm-7">
											<textarea
												class="form-control parsley-validated parsley-error"
												placeholder="Descrição" data-original-title="Descrição"
												data-toggle="tooltip" name="description"><?php echo $categories_info->description;?></textarea>
										</div>
									</div>

									<div class="form-group text-right">
										<button class="btn btn-primary btn-flat" type="button"
											onClick="document.getElementById('categories_form').submit()">
											<i class="fa fa-check"></i> Salvar
										</button>
										<a class="btn btn-default btn-flat" type="button"
											href="<?php echo $this->config->site_url('categories');?>"><i
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