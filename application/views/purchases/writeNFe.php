<?php $this->load->view("partial/popup"); ?>
<div class="cl-mcont">
	<div class="row">
		<div class="block-flat">
			<div class="header">
				<h3>
					<span style="color: dodgerblue;">Digitar Manualmente NF-e - Pedido <?php echo $pedido;?></span>
				</h3>
				<a data-toggle="tooltip" data-placement="top"
					data-original-title="Voltar" class="label label-success" href="#"
					onclick="history.go(-1);" style="float: right; margin-top: -30px;"><i
					class="fa fa-arrow-left fa-3x"></i></a>
			</div>
    			<?php echo form_open('pclista/associa_nfe', 'id="form1"'); ?>
					<div class="row">
				<div class="col-md-6 col-lg-6">
					<h5>
						<strong>Fornecedor: <?php echo ($infos[0]["fornecedor"]);?></strong>
					</h5>
				</div>
				<div class="col-md-6 col-lg-6">
					<h5>
						<strong>Fornecedor: <?php echo ($infos[0]["departamento"]);?></strong>
					</h5>
				</div>
				<div class="col-md-5 col-lg-4">
					<h6>Chave de Acesso</h6>
					<input type="text" name="chave" autofocus="autofocus"
						class="form-control"
						data-mask="0000 0000 0000 0000 0000 0000 0000 0000 0000 0000 0000"
						placeholder="0000 0000 0000 0000 0000 0000 0000 0000 0000 0000 0000">
				</div>
				<div class="col-md-2 col-lg-2">
					<h6>Nº</h6>
					<input type="text" name="number" data-mask="000000000"
						placeholder="#########" value="1" class="form-control"
						required="required">
				</div>
				<div class="col-md-1 col-lg-2">
					<h6>Série:</h6>
					<input type="text" name="serie" placeholder="000" data-mask="000"
						value="001" class="form-control" required="required">
				</div>
				<div class="col-md-2 col-lg-2">
					<h6>Base Cálculo ICMS</h6>
					<input type="text" name="bc_icms" placeholder="0.00"
						data-mask="#####0.00" value="0.00" data-mask-reverse="true"
						class="form-control" required="required">
				</div>
				<div class="col-md-2 col-lg-2">
					<h6>Valor do ICMS</h6>
					<input type="text" name="val_icms" placeholder="0.00"
						data-mask="#####0.00" value="0.00" data-mask-reverse="true"
						class="form-control" required="required">
				</div>
				<div class="col-md-2 col-lg-2">
					<h6>Base Cálculo ICMS ST</h6>
					<input type="text" name="bc_icms_st" placeholder="0.00"
						data-mask="#####0.00" value="0.00" data-mask-reverse="true"
						class="form-control" required="required">
				</div>
				<div class="col-md-2 col-lg-2">
					<h6>Valor do ICMS Subst.</h6>
					<input type="text" name="val_icms_sub" placeholder="0.00"
						data-mask="#####0.00" value="0.00" data-mask-reverse="true"
						class="form-control" required="required">
				</div>


				<div class="col-md-2 col-lg-2">
					<h6>Valor Total Produtos</h6>
					<input type="text" name="val_total" placeholder="0.00"
						data-mask="#####0.00" value="0.00" data-mask-reverse="true"
						class="form-control" required="required">
				</div>
				<div class="col-md-2 col-lg-2">
					<h6>Valor do Frete</h6>
					<input type="text" name="frete" placeholder="0.00"
						data-mask="#####0.00" value="0.00" data-mask-reverse="true"
						class="form-control" required="required">
				</div>
				<div class="col-md-2 col-lg-2">
					<h6>Valor do Seguro</h6>
					<input type="text" name="seguro" placeholder="0.00"
						data-mask="#####0.00" value="0.00" data-mask-reverse="true"
						class="form-control" required="required">
				</div>
				<div class="col-md-2 col-lg-2">
					<h6>Desconto</h6>
					<input type="text" name="desconto" placeholder="0.00"
						data-mask="#####0.00" value="0.00" data-mask-reverse="true"
						class="form-control" required="required">
				</div>
				<div class="col-md-2 col-lg-2">
					<h6>Outras Despesas</h6>
					<input type="text" name="despesas" placeholder="0.00"
						data-mask="#####0.00" value="0.00" data-mask-reverse="true"
						class="form-control" required="required">
				</div>
				<div class="col-md-2 col-lg-2">
					<h6>Valor Total Nota</h6>
					<input type="text" name="val_total_nota" placeholder="0.00"
						data-mask="#####0.00" value="0.00" data-mask-reverse="true"
						class="form-control" required="required">
				</div>
				<!-- Não necessário: -->

				<div class="col-md-2 col-lg-2">
					<h6>Valor IMP. Importação</h6>
					<input type="text" name="val_imp_imp" placeholder="0.00"
						data-mask="#####0.00" value="0.00" data-mask-reverse="true"
						class="form-control" required="required">
				</div>
				<div class="col-md-2 col-lg-2">
					<h6>Valor do PIS</h6>
					<input type="text" name="pis" placeholder="0.00"
						data-mask="#####0.00" value="0.00" data-mask-reverse="true"
						class="form-control" required="required">
				</div>
				<div class="col-md-2 col-lg-2">
					<h6>Valor da COFINS</h6>
					<input type="text" name="val_cofins" placeholder="0.00"
						data-mask="#####0.00" value="0.00" data-mask-reverse="true"
						class="form-control" required="required">
				</div>
				<div class="col-md-2 col-lg-2">
					<h6>Valor Total IPI</h6>
					<input type="text" name="val_ipi" placeholder="0.00"
						data-mask="#####0.00" value="0.00" data-mask-reverse="true"
						class="form-control" required="required">
				</div>
			</div>
			<div class="col-md-12 col-lg-12">
				<div class="row">
					<h5>
						<strong>Produtos da NF-e</strong>
					</h5>
					<table class="hover">
						<thead class="color-primary">
							<tr>
								<th>Código Produto</th>
								<th>Descrição Produto/Serviço</th>
								<th class="text-right">Quantidade</th>
								<th class="text-right">Valor Unit.</th>
							</tr>
						</thead>
						<tbody>
									<?php
        if (isset($table)) {
            echo $table;
        }
        ?>
								</tbody>
					</table>
					<br>
					<button data-toggle="modal" data-target="#mod-warning"
						type="button" class="btn btn-primary">Asesociar NF-e</button>
				</div>
			</div>
			<!-- Modal -->
			<div class="modal fade" id="mod-warning" tabindex="-1" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"
								aria-hidden="true">&times;</button>
						</div>
						<div class="modal-body">
							<div class="text-center">
								<div class="i-circle warning">
									<i class="fa fa-warning"></i>
								</div>
								<h4>Aviso!</h4>
								<p>Você realmente deseja associar esta NF-e ao Pedido <?php echo $pedido;?> ?</p>
							</div>
						</div>
						<div class="modal-footer">
							<input type="hidden" name="pedido" value="<?php echo $pedido;?>">
							<button type="button" class="btn btn-default"
								data-dismiss="modal">Cancelar</button>
							<button type="submit" class="btn btn-warning">Proceder</button>
						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
			<!-- /.modal -->
			<div class="md-overlay"></div>
					<?php echo form_close(); ?>
				</div>
	</div>
</div>
<script type="text/javascript"> 
function submiter()
{
	var a = confirm("Você realmente deseja associar esta NF-e ao Pedido <?php echo $pedido;?> ?");
	if (a == true)
	{
		document.getElementById('form1').submit();
	}
}


</script>
<?php $this->load->view("partial/popfooter"); ?>