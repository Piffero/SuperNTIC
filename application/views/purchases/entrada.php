<?php
date_default_timezone_set('America/Sao_Paulo');
$this->load->view("partial/header");

?>

<div class="container-fluid" id="pcont">
	<div class="cl-mcont">

		<div class="row">
			<div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
				<div class="block-flat">
					<div class="header">
						<h3>
							<b><font style="color: dodgerblue;">Entrada de Produtos</font></b>
						</h3>
					</div>
					<div class="content">
								<?php
        if (isset($manage_result)) {
            echo $manage_result;
        } else {
            echo '';
        }
        ?>
								<form class="form-horizontal">
							<div class="form-group">
								<div class="col-sm-3 col-md-3 col-lg-3 col-xs-6">
									<h5>Nº do Pedido:</h5>
									<input type="text" value="<?php echo $pedido;?>"
										class="form-control" readonly="readonly">
								</div>
								<div class="col-sm-3 col-md-3 col-lg-3 col-xs-6">
									<h5>Nº da Nota:</h5>
									<input name="nota" value="<?php echo $info[3];?>" type="text"
										data-mask="###.###.###" data-mask-reverse="true"
										pattern="\d{3}\.\d{3}\.\d{3}" class="form-control"
										readonly="readonly">
								</div>
								<div class="col-sm-6 col-md-6 col-lg-6 col-xs-12">
									<h5>Chave de Acesso da Nota:</h5>
									<input name="proto" value="<?php echo $info[4];?>" type="text"
										data-mask="#### #### #### #### #### #### #### #### #### #### ####"
										placeholder="nnnn nnnn nnnn nnnn nnnn nnnn nnnn nnnn nnnn nnnn"
										class="form-control" readonly="readonly">
								</div>

								<div class="col-sm-2 col-md-2 col-lg-2 col-xs-6">
									<h5>Data do Pedido:</h5>
									<input type="text"
										value="<?php echo date('d/m/Y h:m', strtotime($info[0]));?>"
										class="form-control" readonly="readonly">
								</div>
								<div class="col-sm-4 col-md-4 col-lg-4 col-xs-6">
									<h5>Fornecedor:</h5>
									<input type="text" value="<?php echo $info[1];?>"
										class="form-control" readonly="readonly">
								</div>
								<div class="col-sm-4 col-md-4 col-lg-4 col-xs-6">
									<h5>Departamento:</h5>
									<input type="text" value="<?php echo $info[2];?>"
										class="form-control" readonly="readonly">
								</div>
								<div class="col-sm-2 col-md-2 col-lg-2 col-xs-6">
									<h5>Valor Total da Nota:</h5>
									<input type="text" value="<?php echo $totalnota;?>"
										class="form-control" readonly="readonly">
								</div>
							</div>
						</form>
						<div class="header">
							<h3>
								<span style="color: dodgerblue;">Itens</span>
							</h3>
						</div>
						<table class="no-border hover">
							<thead class="no-border">
								<tr>
									<th><strong>Nome</strong></th>
									<th><strong>UN.</strong></th>
									<th><strong>Qtde.</strong></th>
									<th><strong>Ação</strong></th>
								</tr>
							</thead>
							<tbody class="no-border-y">
										<?php
        if (isset($manage_table_row) or $manage_table_row != '') {
            echo $manage_table_row;
        } else {
            echo '<tr><td colspan="8">Não há ítens para serem checados</td></tr>';
        }
        ?>
									</tbody>
						</table>
						<div class="form-group">
							<div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
										<?php echo $decisao; ?>
									</div>
						</div>
						<div class="md-overlay"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<?php $this->load->view("partial/footer"); ?>