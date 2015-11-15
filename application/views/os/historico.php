<?php $this->load->view("partial/header"); ?>
<div class="cl-mcont">
	<div class="row">
		<div class="col-md-12 col-lg-12 col-sm-12">
			<div class="block-flat">
				<div class="header">
					<h3>
						<font style="color: dodgerblue;">Busca de Ordens de Serviço</font>
					</h3>
				</div>
				<div class="content">
					<div class="col-sm-6 col-md-6 col-lg-6">
								Buscar por situação:
							<?php echo form_open('oshistory/situacao', 'class="form-horizontal"');?>
								<div class="input-group">
							<select class="form-control" name="situacao">
								<option value="Aberta">Abertas</option>
								<option value="Em analise">Em Análise</option>
								<option value="Contactando">Contactando</option>
								<option value="Aprovada">Aprovadas</option>
								<option value="Recusada">Recusadas</option>
								<option value="Em andamento">Em Andamento</option>
								<option value="Concluida">Concluídas</option>
								<option value="Cancelada">Canceladas</option>
								<option value="Finalizada">Finalizadas</option>
								<option value="Fabrica">Fábrica</option>
							</select> <span class="input-group-btn">
								<button type="submit" class="btn btn-primary">Carregar</button>
							</span>
						</div>
							<?php echo form_close();?>
						</div>
					<div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">
							Buscar por Cliente:
							<?php echo form_open('oshistory/client', 'class="form-horizontal"');?>
								<div class="input-group">
									<?php echo form_dropdown('clients', $clients, array(), 'class="form-control"');?>
									<span class="input-group-btn">
								<button type="submit" class="btn btn-primary">Buscar</button>
							</span>
						</div>
							<?php echo form_close();?>
		              	</div>
					<div class="col-sm-12 col-md-12 col-lg-12"
						style="display: inline-block;">
						<table class="hover">
							<thead>
								<tr class="color-primary">
									<th>Cliente</th>
									<th>Equipamento</th>
									<th class="text-center">Abertura</th>
									<th class="text-center">Situação</th>
									<th class="text-center">N&#186; da OS</th>
								</tr>
							</thead>
							<tbody>
			              			<?php if(!empty($lista)){echo $lista;} ?>
			              		</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view("partial/footer"); ?>