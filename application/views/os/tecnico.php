<?php $this->load->view("partial/header"); ?>
<div class="cl-mcont">
	<div class="row">
		<div class="col-md-12 col-lg-12 col-sm-12">
			<div class="block-flat">
				<div class="header">
					<h3>
						<font style="color: dodgerblue;">Lista Técnica de Ordens de
							Serviços</font>
					</h3>
				</div>
				<div class="content">
					<div class="row">
						<div class="col-md-12 col-lg-12 col-sm-12">
							<div class="content">
								<?php if (isset($manage_result)){echo $manage_result;}?>
									<div class="table-responsive">
									<table class="table no-border hover">
										<thead class="no-border">
											<tr>
												<th class="text-center"><strong>Nº da OS</strong></th>
												<th class="text-center"><strong>Produto</strong></th>
												<th class="text-center"><strong>Cliente</strong></th>
												<th class="text-center"><strong>Situação</strong></th>
												<th class="text-center"><strong>Abertura</strong></th>
												<th class="text-center"><strong>Ação</strong></th>
											</tr>
										</thead>
										<tbody class="no-border-y">
												<?php echo $lista; ?>					
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
<?php $this->load->view("partial/footer"); ?>