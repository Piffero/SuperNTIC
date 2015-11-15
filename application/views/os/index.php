<?php
$this->load->view("partial/header");
?>
<?php if (!empty($open)){if(is_numeric($open)){echo '<script>window.open("'.site_url('oscanhoto/index/'.$open).'");</script>';}} ?>
<div class="cl-mcont">
	<div class="row">
		<div class="col-md-12 col-lg-12 col-sm-12">
			<div class="block-flat">
				<div class="header">
					<h3>
						<font style="color: dodgerblue;"><b>Nova Ordem de Serviço</b></font>
					</h3>
				</div>
				<div class="content">
				<?php
    if (isset($manage_result)) {
        echo $manage_result;
    }
    ?>
				<?php echo form_open('os/check', 'class="form-horizontal"')?>
					<div class="form-group">
						<div class="col-sm-6 col-lg-6 col-md-6">
							<input type="text" name="NSERIE" autofocus="autofocus"
								placeholder="Buscar Nº de Série" class="form-control">
						</div>
						<div class="col-sm-6 col-lg-6 col-md-6">
							<button type="submit" class="btn btn-success">Consultar</button>
						</div>
					</div>
				<?php echo form_close(); ?>
				
				<?php
    
    if (isset($cliente)) {
        echo form_open('osdefects', 'class="form-horizontal"') . '
						<div class="form-group">
							<div class="col-sm-12 col-lg-12 col-md-12">
								<h3><span style="color:dodgerblue;">Cliente</span></h3>
							</div>
							<div class="col-sm-12 col-lg-12 col-md-12">
								<table style="text-align: right;" class="no-border hover">
									<thead class="no-border">
										<tr>
											<th class="text-center"><h5><strong>Nome do Cliente</strong></h5></th>
											<th class="text-center"><h5><strong>Telefones</strong></h5></th>
											<th class="text-center"><h5><strong>E-mail</strong></h5></th>			
										</tr>
									</thead>
									
									<tbody class="no-border-x no-border-y">
										<tr>
											<td class="text-center">' . $cliente . '</td>
											<td class="text-center">
												<center><select class="form-control" name="telefone" style="width:350px;">';
        if (! empty($telcasa)) {
            echo '<option value="1"';
            if ($telopt == 1) {
                echo ' selected="selected"';
            }
            echo '>' . $telcasa . ' (Residencia)</option>';
        }
        if (! empty($teltrab)) {
            echo '<option value="2"';
            if ($telopt == 2) {
                echo ' selected="selected"';
            }
            echo '>' . $teltrab . ' (Trabalho)</option>';
        }
        if (! empty($telcel)) {
            echo '<option value="3"';
            if ($telopt == 3) {
                echo ' selected="selected"';
            }
            echo '>' . $telcel . ' (Celular)</option>';
        }
        if (! empty($telother)) {
            echo '<option value="4"';
            if ($telopt == 4) {
                echo ' selected="selected"';
            }
            echo '>' . $telother . ' (Outro)</option>';
        }
        echo '</select></center>
											</td>
											<td class="text-center">';
        if ($termos == 1) {
            echo '<span style="color:red;">Dados Protegidos</span>';
        } else {
            if (! empty($email)) {
                echo $email;
            } else {
                echo 'Cliente sem email';
            }
        }
        echo '</td>
										</tr>
									</tbody>
								</table>
							</div>';
    }
    
    if (! empty($produto)) {
        echo '
					<div class="col-sm-12 col-lg-12 col-md-12">
						<h3><span style="color:dodgerblue;">Aparelho</span></h3>
					</div>
					<div class="col-sm-12 col-lg-12 col-md-12">
						<table class="no-border hover">
							<thead class="no-border">
								<tr>		
									<th class="text-center"><strong>Nº de série</strong></th>
									<th class="text-center"><strong>Produto</strong></th>
									<th class="text-center"><strong>Marca</strong></th>
									<th class="text-center"><strong>Modelo</strong></th>
									<th class="text-center"><strong>Lado</strong></th>
									<th class="text-center"><strong>Data de Compra</strong></th>
									<th class="text-center"><strong>Garantia da Fábrica</strong></th>
									<th class="text-center"><strong>Última OS</strong></th>
								</tr>			
							</thead>
							<tbody class="no-border-x no-border-y">
								<tr>
									<td class="text-center"><b>' . $serie . '</b></td>
									<td class="text-center"><b>' . $produto . '</b></td>
									<td class="text-center"><b>' . $marca . '</b></td>
									<td class="text-center"><b>' . $modelo . '</b></td>
									<td class="text-center"><b>' . $lado . '</b></td>
									<td class="text-center"><b>' . $compra . '</b></td>
									<td class="text-center"><b>' . $fabrica . '</b></td>
									<td class="text-center"><b>00/00/0000</b></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-12 col-sm-12 col-md-12">
						<button type="submit" value="' . $serie . '" name="aparelho" class="btn btn-primary">Inserir Defeitos</button>
					</div>
				</div>	' . form_close();
    }
    ?>
				</div>
			</div>
		</div>
	</div>
</div>


<?php $this->load->view("partial/footer"); ?>