
<?php $this->load->view("partial/popup"); ?>
<div class="cl-mcont">
	<div class="block-flat">
		<div class="header">
			<h3>
				<b><font style="color: dodgerblue;">Informação do Pedido</font></b>
			</h3>
		</div>
		<div class="content">
			<form class="form-horizontal">
				<div class="form-group">
					<div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">
						<h5>Nº do Pedido: <?php echo $pedido;?></h5>
						<h5>Departamento: <?php echo ($infos[0]["departamento"]);?></h5>


					</div>
					<div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">
						<h5>Abertura do Pedido: <?php echo convert_timestamp($infos[0]["data"]);?></h5>
						<h5>Fornecedor: <?php echo ($infos[0]["fornecedor"]);?></h5>
					</div>
					<div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
						<h5>&nbsp;</h5>
					</div>
					<p />
					<div class="content">
						<table class="hover">
							<thead>
								<tr>
									<th><strong>Produto</strong></th>
									<th class="text-center"><strong>Unidade</strong></th>
									<th class="text-center"><strong>Qtde.</strong></th>
									<th class="text-center"><strong>Valor Unit.</strong></th>
									<th class="text-center"><strong>Total</strong></th>
								</tr>
							</thead>
							<tbody>
												<?php echo $manage_table_row2;?>
											</tbody>
						</table>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<?php 	$this->load->view("partial/popfooter"); ?>