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
							<b><font style="color: dodgerblue;">Entrega de Produtos</font></b>
						</h3>
					</div>
					<div class="content">
						<form class="form-horizontal">
							<div class="form-group">
								<div class="col-sm-6 col-md-6 col-lg-6 col-xs-12">
									<h4>Destino:</h4>
									<input type="text"
										placeholder="Ex.: Departamento; Setor; Localidade; etc..."
										class="form-control" maxlength="400" name="destino" required
										autofocus>
								</div>
								<div class="col-sm-6 col-md-6 col-lg-6 col-xs-12">
									<h4>Entregue a:</h4>
									<input type="text" placeholder="Ex.: Jo�o da Silva"
										class="form-control" maxlength="400" name="destinatario"
										required>
								</div>
								<div class="col-sm-4 col-md-4 col-lg-4 col-xs-12"
									style="display: inline-block">
									<h4>Motivo:</h4>
									<input type="text"
										placeholder="Ex.: Servi�o externo no parque;"
										class="form-control" maxlength="400" name="motivo" required>
								</div>
								<div class="col-sm-4 col-md-4 col-lg-4 col-xs-12">
									<h4>Produto:</h4>
									<select class="select2" name="produto">
										<option>Produto #1</option>
										<option>Produto #2</option>
									</select>
								</div>
								<div class="col-sm-2 col-md-2 col-lg-2 col-xs-6">
									<h4>Qtde.</h4>
									<input type="number" min="1" max="10" class="form-control"
										maxlength="400" value="1" name="destinatario" required>
								</div>
								<div class="col-sm-2 col-md-2 col-lg-2 col-xs-6">
									<button type="submit" class="btn btn-primary"
										style="margin-top: 48px;">Inserir Produto</button>
								</div>
							</div>
						</form>
						<h3>Sa�da</h3>
						<table class="hover">
							<thead>
								<tr>
									<th><strong>Produto</strong></th>
									<th><strong>Qtde.</strong></th>
									<th><strong>Entregue a</strong></th>
									<th><strong>Ação</strong></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Robust megapower 2</td>
									<td>5</td>
									<td>Jo�o da Silva</td>
									<td><form>
											<button name="id" value="14" data-toggle="tooltip"
												data-original-title="Excluir Item" data-placement="top"
												type="submit" class="btn btn-danger btn-xs"
												style="width: 25px">
												<i class="fa fa-times"></i>
											</button>
										</form></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view("partial/footer"); ?>