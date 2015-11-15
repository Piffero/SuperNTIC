<?php
date_default_timezone_set('America/Sao_Paulo');
$this->load->view("partial/header");

?>

<div id="main-content" class="main-content container-fluid">
	<?php
if (isset($manage_result)) {
    echo $manage_result;
} else {
    echo '';
}
?>
	 	<div class="col-lg-12 pull-left">
		<div class="cl-mcont">
			<div class="block-flat">
				<div class="header">
					<h3>
						<i class="fontello-icon-chart-bar-3"></i>Pedido de Compra de
						Insumos e Despesas
					</h3>
				</div>	
					<?php echo form_open('purchases/save', 'class="form-horizontal" id="form1"', array());?>
						<div class="form-group">
					<div class="col-sm-4 col-md-4">
						N&#176; do pedido: <input id="pedido" type="text" name="numero"
							value="<?php echo $numero;?>" class="form-control" readonly />
					</div>
					<div class="col-sm-4">
								Fornecedor:
								<?php echo form_dropdown('fornecedor', $supplier_info, array($fornecedor_get), 'id="fornecedor" onchange="post_forn();" name="fornecedor" class="select2"')?>
							</div>
					<div class="col-sm-4">
								Departamento:
								<?php echo form_dropdown('departamento', $department_info, array($departamento_get), 'id="departamento" onchange="post_dept();" name="departamento" class="select2"')?>
							</div>
				</div>
					<?php echo form_close();?>
					<div class="content">
					<?php echo form_open('purchases/save_itens');?>
						<table class="no-border hover">
						<thead class="no-border">
							<tr>
								<th style="width: 230px;">Produto</th>
								<th style="width: 50px;">UN.</th>
								<th style="width: 90px;">Valor Unit.</th>
								<th style="width: 50px;">Qtde</th>
								<th style="width: 90px;">Total</th>
								<th style="width: 50px;">Acao</th>
							</tr>
						</thead>
						<tbody class="no-border-x no-border-y hover">
							<tr>
								<td><?php echo form_dropdown('produto', $items_info, array(), 'class="select2"')?><input
									type="hidden" name="pedido" value="<?php echo $next;?>"></td>
								<td><?php echo form_dropdown('un', $unidade, array(), 'class="select2"')?></td>
								<td class="text-right"><input type="text" name="valorunit"
									id="b" value="0" onchange="mult();" class="form-control"></td>
								<td><input type="number"
									onchange="mult();document.getElementById('kkk').value = document.getElementById('c').value;"
									min="1" max="1000" id="c" value="1" class="form-control"> <input
									type="hidden" id="kkk" name="quant" value="1"></td>
								<td class="text-right"><input type="text" name="vtotal" value=""
									id="a" class="form-control" readonly /></td>
								<td><button class="btn btn-primary" type="submit">Inserir</button></td>
							</tr>
						</tbody>
					</table>
					<?php echo form_close();?>
				 	<table class="no-border hover">
						<tbody class="no-border-y">
							 <?php echo $manage_table_row; ?>
				    	</tbody>
					</table>
					<hr class="mm">
					<form class="form-horizontal" style="border-radius: 0px;"
						action="#">
						<div class="form-group">
							<label class="col-sm-9 control-label">Total:</label>
							<div class="col-sm-3">
								<div class="input-group">
									<input class="form-control" readonly="readonly"
										value="<?php echo $valortotal;?>" type="text">
								</div>
							</div>
						</div>
						<button class="btn btn-primary" type="button"
							onclick="javascript:post();">Gerar Pedido</button>
						<button class="btn btn-default"
							onclick="window.location='<?php echo site_url('pclista');?>'">Cancelar</button>
					</form>
				</div>
				<!--  // column -->
			</div>
			<!-- // Example row -->
		</div>
	</div>
	<!-- // block-flat -->
</div>

<!-- // main-content -->

<script
	src="<?php echo $this->config->base_url();?>web/js/jquery.min.js"></script>

<script type="text/javascript">

		function post()
		{

			
			var pedido = document.getElementById("pedido").value;
			
			var e = document.getElementById("fornecedor");
			var fornecedor1 = e.options[e.selectedIndex].innerHTML;

			var f = document.getElementById("departamento");
			var departamento1 = f.options[f.selectedIndex].innerHTML;

									
			var URL = "<?php echo $this->config->site_url('purchases/gerapedido');?>";

			
			$.post
			(
				URL,
				    {
				      numero:pedido,
				      fornecedor:fornecedor1,
				      departamento:departamento1
				     		      
				    },
				    function(data,status)
				    {
						window.location="<?php echo $this->config->site_url('pclista');?>";
				    }
			);
		};

		function post_dept()
		{
			var f = document.getElementById("departamento");
			var departamento1 = f.options[f.selectedIndex].value;

			var URL = "<?php echo $this->config->site_url('purchases/seta_departamento');?>";

			
			$.post
			(
				URL,
				    {
				      departamento:departamento1
				    },
				    function(data,status)
				    {
						//window.location="<?php echo $this->config->site_url('pclista');?>";
				    }
			);
		}

		function post_forn()
		{
			var e = document.getElementById("fornecedor");
			var fornecedor1 = e.options[e.selectedIndex].value;

			var URL = "<?php echo $this->config->site_url('purchases/seta_fornecedor');?>";

			
			$.post
			(
				URL,
				    {
					fornecedor:fornecedor1
				    },
				    function(data,status)
				    {
						//window.location="<?php echo $this->config->site_url('pclista');?>";
				    }
			);
		}
	
	
	</script>


<script type="text/javascript">
	function mult()
	{
		document.getElementById('a').value = (document.getElementById('b').value * document.getElementById('c').value).toFixed(2);
	}
	
	</script>
<?php $this->load->view("partial/footer"); ?>