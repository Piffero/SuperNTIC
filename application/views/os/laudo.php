<?php $this->load->view("partial/header"); ?>

<div class="cl-mcont">
	<div class="row">
		<div class="col-md-12 col-lg-12 col-sm-12">
			<div class="block-flat">
				<div class="header">
					<h3>
						<font style="color: dodgerblue;">Laudo da OS <?php echo $idOS;?></font>
					</h3>
				</div>
				<div class="content">
					<div class="row">
						<div class="col-md-12 col-lg-12 col-sm-12">
							<div class="content">
									<?php if(isset($manage_result)){echo $manage_result;}?>
										<div class="col-md-12 col-sm-12 col-lg-12">
											<?php if(isset($dis)){if($dis != '1'){echo '<a href="'.site_url('tecos/index/'.$idOS).'"> &#8592; Voltar para as ocorrências técnica desta OS.</a>';}}?><br>
								</div>
								<br>
								<p>
								
								
								<div class="col-md-12 col-sm-12 col-lg-12">
									<h5>Descrever operação no aparelho:</h5>
											<?php echo form_open('oslaudo/concluir/'.$idOS);?>
											<textarea class="form-control" name="laudo"
										style="resize: none; width: 50%;"
										<?php if(isset($dis)){if($dis=='1'){echo 'disabled';}}?>
										autofocus="autofocus" rows="11" cols="30" maxlength="1000"
										required="required"
										placeholder="Descrever laudo técnico do aparelho..."
										wrap="hard"><?php if(isset($laudox[0]['laudo'])){echo nl2br($laudox[0]['laudo']);}?></textarea>
								</div>
								<div class="form-group">
									<div class="col-md-12 col-sm-12 col-lg-12">
										<button class="btn btn-success md-trigger pull-center"
											<?php if(isset($dis)){if($dis=='1'){echo 'disabled';}}?>
											data-target="#mod-success" data-toggle="modal">Publicar e
											Concluir OS</button>
										&nbsp;
									</div>
									<!-- Modal -->
									<div class="modal fade" id="mod-success" tabindex="-1"
										role="dialog">
										<div class="modal-dialog">

											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal"
														aria-hidden="true">&times;</button>
												</div>
												<div class="modal-body">
													<div class="text-center">
														<div class="i-circle success">
															<i class="fa fa-check"></i>
														</div>
														<h4>Você deseja concluir esta O.S.?</h4>
														<p>Verifique todas as ocorrências, voltagem e o estado do
															aparelho.</p>
													</div>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default"
														data-dismiss="modal">Cancelar</button>
													<button type="submit" name="situacao" value="Concluida"
														class="btn btn-success">Concluir</button>
												</div>
											</div>
											<!-- /.modal-content -->
										</div>
										<!-- /.modal-dialog -->
									</div>
									<!-- /.modal -->
									<div class="md-overlay"></div>
								</div>
								<!-- <button class="btn btn-success" type="button">Salvar</button>&nbsp;-->
										<?php echo form_close();?>
										<!--  <form action="mailto:who@linuxmail.org">
											<button class="btn btn-default" type="submit" name="enviaros" value="enviar">Enviar por email</button>  
										</form>-->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view("partial/footer"); ?> 
		