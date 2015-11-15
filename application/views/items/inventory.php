
<?php
$this->load->view("partial/header");

?>

<div class="container-fluid" id="pcont">
	<div class="page-head">
		<h2>
			Inventário de Produtos da <font color="#2494F2"><b><?php echo $enterprise; ?></b></font>
		</h2>
	</div>
		  	<?php if(isset($manage_result)){echo $manage_result;}else{echo '';}; ?>
			<div class="cl-mcont">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">
				<div class="block-flat">
					<div class="header">
						<h3>
							<b><font style="color: dodgerblue;">Reajuste de Estoque</font></b>
						</h3>
					</div>
					<div class="content">
								<?php echo form_open('items/save_value/'.$id_item.'/'.$location);?>
									<table class="no-border hover">
							<thead class="no-border">
								<tr>
									<th><strong><span style="font-size: 18px;">Produto</span></strong></th>
									<th style="width: 50%;"><strong><span style="font-size: 15px;">Informação</span></strong></th>
								</tr>
							</thead>
							<tbody class="no-border-y">
								<tr>
									<td><i class="fa fa-barcode"></i> <span
										style="font-size: 15px;">Código de Barra:</span></td>
									<td><span style="font-size: 15px;"><?php echo $info['item_codebar'];?></span></td>
								</tr>
								<tr>
									<td><i class="fa fa-star"></i> <span style="font-size: 15px;">Nome
											do item:</span></td>
									<td><span style="font-size: 15px;"><?php echo $info['description'];?></span></td>
								</tr>
								<tr>
									<td><i class="fa fa-tags"></i> <span style="font-size: 15px;">Categoria</span></td>
									<td><span style="font-size: 15px;"><?php if($info['category'] == '0' or $info['category'] == ''){echo 'Sem categoria';}else{echo $info['category'];}?></span></td>
								</tr>
								<tr>
									<td><i class="fa fa-archive"></i> <span
										style="font-size: 15px;"><span style="font-size: 15px;">Quantidade
												em estoque:</span></span></td>
									<td><span style="font-size: 15px;"><?php if(isset($item_q["quantity"])){echo $item_q["quantity"];}?></span></td>
								</tr>
								<tr>
									<td style="font-size: larger;"><i class="fa fa-unsorted"></i>
										Ajustar estoque atual:</td>
									<td><span style="font-size: 15px;"><input
											placeholder=" Digite a quantidade (un)"
											data-mask="#########0" title="Digite somente números!"
											type="text" name="campo" required="required"></span></td>
								</tr>
							</tbody>
						</table>
						<p></p>
						<br>
						<div style="text-align: center;">
							<button type="submit" class="btn btn-primary">Ajustar</button>
						</div>
								<?php echo form_close();?>
							</div>
				</div>
			</div>
		</div>
	</div>
</div>


<?php $this->load->view("partial/footer"); ?>