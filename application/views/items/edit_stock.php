<?php $this->load->view("partial/header"); ?>

<div class="container-fluid" id="pcont">
	<div class="cl-mcont">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">
				<div class="block-flat">
					<div class="header">
						<h3>
							<font style="color: dodgerblue;">Estoque - Editar Item</font>
						</h3>
					</div>
					
					<?php if(isset($manage_result)){echo $manage_result;}?>
					<div class="content">
						<?php echo form_open("stock_serie/submit_serie", 'class="form-horizontal"');?>
							<div class="form-group">
							<div class="col-md-12 col-lg-12 col-sm-12">
								<h4 style="text-decoration: underline;"><?php echo $nome;?></h4>
							</div>
							<div class="col-md-4 col-lg-4 col-sm-4">
								<h5>Tipo do Item: 
									<?php
        if (isset($tipo) and ! empty($tipo)) {
            echo $tipo;
        } else {
            echo 'Tipo não cadastrado';
        }
        ?>
									</h5>
								<h5>Cód. de barras:
									<?php
        if (isset($codebar) and ! empty($codebar)) {
            echo $codebar;
        } else {
            echo 'Código de Barras não cadastrado';
        }
        ?>
									</h5>
								<h5>Data de Entrada: <?php echo date('d/m/Y', strtotime($data));?></h5>
							</div>
							<div class="col-md-4 col-lg-4 col-sm-4">
								<h5>Categoria: 
									<?php
        if (isset($categoria) and ! empty($categoria)) {
            echo $categoria;
        } else {
            echo 'Sem categoria';
        }
        ?>
									</h5>
								<h5>Unidade:
									<?php
        if (isset($unit) and ! empty($unit)) {
            echo $unit;
        } else {
            echo 'Sem tipo de unidade';
        }
        ?></h5>
							</div>
							<div class="col-md-4 col-lg-4 col-sm-4">
								<h5>Editar Número de Série</h5>
								<input type="text" class="form-control" name="nserie"
									value="<?php if (isset($serie) and !empty($serie)){echo $serie;}?>">

							</div>
							<div class="col-md-12 col-lg-12 col-sm-12"
								style="display: inline-block;">
								<div class="form-group">
									<div class="col-md-12 col-lg-12 col-sm-12"
										style="display: inline-block;">
										<input type="hidden" name="item_id"
											value="<?php echo $item_id;?>">
										<button type="submit" class="btn btn-primary pull-right"
											name="id" value="<?php echo $id; ?>">Salvar</button>
									</div>
								</div>
							</div>
						</div>
						<?php echo form_close();?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<?php $this->load->view("partial/footer"); ?>