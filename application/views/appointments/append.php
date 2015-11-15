 <?php
$this->load->view("partial/header");

header('Content-type: text/html; charset=UTF-8');
?>
<div class="container-fluid" id="pcont">
	<div class="page-head">
		<h2>Registro de Atendimento</h2>
	</div>
	<div class="cl-mcont">
			<?php if(isset($manage_result)){echo $manage_result;}else{echo '';}; ?>
			<div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="tab-container">
					<!------CONTROL TABS START------->
					<ul class="nav nav-tabs">
						<li class="active"><a href="#add" data-toggle="tab"><i
								class="fa fa-plus"></i> Inserir Consulta</a></li>
					</ul>
					<!------CONTROL TABS END------->

					<div class="tab-content">
						<div class="tab-pane active cont" id="add">
							<div class="col-md-12 col-md-12 col-lg-12">
								<!----BASIC FORM STARTS--->
								<div class="content">
                    <?php
                    echo form_open('appointments/save/' . $appointments_info->appointment_id, array(
                        'id' => 'appointments_form',
                        'class' => 'form-horizontal group-border-dashed',
                        'style' => 'border-radius: 0px;'
                    ));
                    ?>
											<div class="form-group">
										<div class="col-sm-4 col-md-4 col-lg-4">
    	    	          								<?php echo form_dropdown('fono', $employeer_fono, array($appointments_info->doctor_id), 'class="select2"');?>
	            	    							</div>
										<div class="col-sm-4 col-md-4 col-lg-4">
        	          								<?php echo form_dropdown('paciente', $customer, array($appointments_info->patient_id), 'class="select2"');?>
            	    							</div>
										<div class="col-sm-2 col-md-2 col-lg-2 ">
											<input type="text" class="form-control"
												data-original-title="Data da Consulta" data-toggle="tooltip"
												placeholder="00/00/0000" data-mask="00/00/0000" name="date"
												required
												value="<?php if(isset($appointments_info->appointment)){echo get_date_view($appointments_info->appointment);} ?>">
										</div>
										<div class="col-sm-2 col-md-2 col-lg-2">
											<input type="text" class="form-control"
												data-original-title="Hora da Consulta" data-toggle="tooltip"
												placeholder="00:00" data-mask="00:00" name="hour" required
												value="<?php if(isset($appointments_info->hour)){echo $appointments_info->hour;} ?>">
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-12 col-md-12 col-lg-12">
											<textarea style="resize: none;" autofocus="autofocus"
												name="atendimento" class="form-control"
												data-original-title="Descrição" data-toggle="tooltip"
												maxlength="700" rows="9"
												placeholder="Descreva a consulta..."><?php if(isset($appointments_info->atendimento)){echo $appointments_info->atendimento;} ?></textarea>
										</div>
									</div>
									<div class="form-group text-right">
										<button class="btn btn-primary" type="submit">
											<i class="fa fa-check"></i> Salvar
										</button>        										
        										<?php if (isset($btn_close)){echo $btn_close;}?>		    				 
          							         </div>
              							<?php echo form_close(); ?>
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