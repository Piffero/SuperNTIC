<?php
date_default_timezone_set('America/Sao_Paulo');

$this->load->view("partial/header");

?>

<div class="container-fluid" id="pcont">
	<div class="cl-mcont">
			<?php

if (isset($manage_result)) {
    echo $manage_result;
} else {
    echo '';
}
?>
				<div class="row">
			<div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
				<div class="block-flat">
					<div class="header">
						<h3>
							<b><font style="color: dodgerblue;">Ordem de Pedidos Compra</font></b>
						</h3>
					</div>
					<div class="content">
						<div class="form-group">
							<table class="hover">
								<thead>
									<tr>
										<th><strong>Departamento</strong></th>
										<th><strong>Fornecedor</strong></th>
										<th class="text-center"><strong>Qtde.</strong></th>
										<th><strong>Total</strong></th>
										<th class="text-center"><strong>Ação</strong></th>
									</tr>
								</thead>
								<tbody>
										<?php
        if ($table_order) {
            echo $table_order;
        } else {
            echo '<tr><td colspan="5">Não há pedidos de compra abertos com produtos para serem mostrados</td></tr>';
        }
        ?>	
										</tbody>
								<tfoot class="no-border-y">
										<?php
        if ($table_order) {
            echo $table_total;
        } else {
            echo '';
        }
        ?>	
										</tfoot>
							</table>
							<div class="md-overlay"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<?php $this->load->view("partial/footer"); ?>