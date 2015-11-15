<?php
$this->load->view("partial/header");
?>
<div class="page-head">
	<h2>Pedidos de Compras</h2>
</div>
<div id="container-fluid" class="pcont">

	<div class="cl-mcont">
			<?php if(isset($manage_result)){echo $manage_result;}else{echo '';} ?>
						
			<div class="row">
			<div class="col-sm-5 col-md-5 col-lg-5">
					<?php echo form_open('pclista/request/'.$pedido);?>
        				<button class="btn btn-primary" type="submit">
					<i class="fa fa-plus"></i>&nbsp; Novo &nbsp;
				</button>
    				<?php echo form_close();?>
    			</div>
			<div class="col-md-2 col-sm-2 col-lg-2">&nbsp;</div>
			<div class="col-md-5 col-sm-5 col-lg-5 pull-right">
    				<?php echo form_open("pclista/search", 'onsubmit="desabilita()"'); ?>
    					<input type="text" name="var"
					placeholder="Procurar por chave da NF-e" class="form-control"
					onkeypress="return disableCtrlKeyCombination(event);"
					onkeydown="return disableCtrlKeyCombination(event);"> <input
					type="submit" style="display: none;">
    				<?php echo form_close();?>
    			</div>
		</div>

		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12">
				<div class="tab-container">
					<!-- ----CONTROL TABS START----- -->
					<ul class="nav nav-tabs">
						<li class="active"><a href="#list" data-toggle="tab"><i
								class="fa fa-align-justify"></i> Lista de Pedidos de Compras</a></li>
					</ul>
					<!------CONTROL TABS END------->

					<div class="tab-content">
						<div class="form-group">
							<table class="hover">
								<thead>
									<tr>
										<th><strong>Pedido - Nota</strong></th>
										<th class="text-center"><strong>Departamento</strong></th>
										<th class="text-center"><strong>Fornecedor</strong></th>
										<th class="text-center"><strong>Data de Emissão</strong></th>
										<th class="text-center"><strong>Situação</strong></th>
										<th class="text-center"><strong>Ação</strong></th>
									</tr>
								</thead>
								<tbody>
 										 		<?php
            if ($linhas <= 0) {
                echo '<tr><td colspan="6">Não há pedidos de compras para serem mostrados.</td></tr>';
            } else {
                echo $table_pc;
            }
            ?>
 										 	</tbody>
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