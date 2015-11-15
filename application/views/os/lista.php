<?php $this->load->view("partial/header"); ?>
<div class="cl-mcont">
	<div class="row">
		<div class="col-md-12 col-lg-12 col-sm-12">
			<div class="block-flat">
				<div class="header">
					<h3>
						<font style="color: dodgerblue;">Lista de Ordens de Serviços</font>
					</h3>
				</div>
				<div class="content">
					<div class="row">
						<div class="col-md-12 col-lg-12 col-sm-12">
							<div class="content">
									<?php if(isset($manage_result)){echo $manage_result;} ?>
									<?php if (!empty($open)){if(is_numeric($open)){echo '<script>window.open("'.site_url('oscanhoto/index/'.$open).'");</script>';}} ?>
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
												<?php if(!empty($lista)){echo $lista;}else{echo '<td colspan="6">Não há Ordens de Serviços em procedimento</td>';}?>				 	
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

<script type="text/javascript">
	function call(idos)
	{
		window.open("<?php echo site_url("oslista/call/")?>/"+idos,"page","toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=780,height=600");
	}
	function pgto(idos)
	{
		window.open("<?php echo site_url("oslista/pgto/")?>/"+idos,"page","toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=no");
	}
	</script>

<?php $this->load->view("partial/footer"); ?>