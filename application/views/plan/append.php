 <?php $this->load->view("partial/header"); ?>
<div class="container-fluid" id="pcont">
	<div class="page-head">
		<h2>Registro de Plano de Contas</h2>
	</div>
	<div class="cl-mcont">
			<?php if(isset($manage_result)){echo $manage_result;}else{echo '';}; ?>

			<div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="tab-container">

					<!------CONTROL TABS START------->
					<ul class="nav nav-tabs">
						<li class="active"><a href="#add" data-toggle="tab"><i
								class="fa fa-plus"></i> Inserir Plano de Contas</a></li>
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
                
                echo form_open('planaccounts/save/' . $plans_info->plan_id, array(
                    'id' => 'plan_form',
                    'class' => 'form-horizontal group-border-dashed',
                    'style' => 'border-radius: 0px;'
                ));
                ?>
											<div class="form-group">
										<div class="col-sm-1">
											<input type="text"
												class="form-control parsley-validated parsley-error"
												placeholder="Código Plano de Contas"
												data-original-title="Código Plano de Contas"
												data-toggle="tooltip" name="plan_id"
												value="<?php echo $plans_info->plan_id;?>">
										</div>
										<div class="col-sm-7">
        		        								<?php echo form_dropdown('plan_group',$plans_group, array($plans_info->plan_group),'class="select2"');?>    	    	          								
	            	    							</div>
									</div>

									<div class="form-group">
										<div class="col-sm-6">
											<input type="text"
												class="form-control parsley-validated parsley-error"
												placeholder="Descrição" data-original-title="Descrição"
												data-toggle="tooltip" name="descrition"
												value="<?php echo utf8_decode($plans_info->descrition);?>">
										</div>
										<div class="col-sm-4">
        		        							<?php if($plans_info->iscategory == 1){?>
    	    	          								<input type="checkbox" readonly="readonly"
												name="iscategory" value="1" checked="checked"> <span
												style="color: red">Marcar como Categoria</span>
    	    	          							<?php } else {?>	
    	    	          								<input type="checkbox" readonly="readonly"
												name="iscategory" value="1"> <span style="color: red">Marcar
												como Categoria</span>
    	    	          							<?php }?>
	            	    							</div>
									</div>

									<div class="form-group text-right">
										<button class="btn btn-primary btn-flat" type="button"
											onClick="document.getElementById('plan_form').submit()">
											<i class="fa fa-check"></i> Salvar
										</button>
										<a class="btn btn-default btn-flat" type="button"
											href="<?php echo $this->config->site_url('planaccounts');?>"><i
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