<?php $this->load->view('partial/popup'); ?>

<div class="cl-mcont">
	<div class="row">
		<div class="col-md-12 col-lg-12 col-sm-12">
			<div class="block-flat">
				<div class="header">
					<h3>
						<span style="color: dodgerblue;">Inserir nºs de série do Pedido de Compra <?php echo $pedido ?></span>
					</h3>
				</div>
				<div class="content">
					<div class="row">
						<div class="col-md-12 col-lg-12 col-sm-12">
								<?php echo form_open('pcentrada/insert_series/'.$pedido);?>
									<div class="content">
										<?php
        if (isset($manage_result)) {
            echo '<div class="alert alert-info">
													<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
													<i class="fa fa-times sign"></i><strong>Ops!</strong>
													O item com Nº de série ' . $manage_result . ' já está no estoque!
												</div>';
        }
        ?>
										<table class="hover">
									<thead>
										<tr class="color-primary">
											<th>Aparelho</th>
											<th>Nº de Série</th>
										</tr>
									</thead>
									<tbody>
												<?php echo $lista;?>
											</tbody>
								</table>
								<div class="form-group">
									<button type="submit" class="btn btn-primary">Salvar</button>
								</div>
							</div>
								<?php echo form_close();?>
							</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('partial/popfooter'); ?>
