<?php
date_default_timezone_set('America/Sao_Paulo');
$this->load->view("partial/popup");
?>

<div class="cl-mcont">
	<div class="block-flat">
		<div class="header">
			<h3>
				<span style="color: dodgerblue;">Associar Nota Fiscal ao pedido <?php echo $id;?></span>
			</h3>
		</div>
		<div class="content">

			<div class="form-group">
					<?php echo form_open('pclista/import/'.$id, array('enctype'=>'multipart/form-data'));?>
						<?php if(isset($result)){echo $result;} ?>
						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
					<b>Importe uma NF-e (XML)</b> <input type="file" name="nfe"
						accept="text/xml" required="required"
						class="btn btn-info btn-flat" autofocus="autofocus"
						style="border-radius: 10px;">
					<button type="submit" class="btn btn-primary">Importar</button>
					<button type="button"
						onclick="location.href='<?php echo site_url("pclista/writeNFe/".$id)?>';"
						class="btn btn-default">Digitar NFe Manual</button>
				</div>
						<?php echo form_close();?>
											
						<?php
    if (isset($itens)) {
        echo form_open('pclista/associate');
        echo '<div class="form-group">
										<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="display:inline-block">
											<input type="hidden" name="id" value="' . $id . '">
											<input type="hidden" name="valnota" value="' . $valornota . '"> <!--DADOS AQUI -->
									 	 	<input type="hidden" name="num_nota" value="' . $numero . '">
										  	<button type="submit" name="nota" value="' . $chave . '" class="btn btn-success pull-right">Associar NF-e</button>
											<button type="button" onclick="self.close()" class="btn btn-default pull-right">Cancelar</button>
										</div>
									</div>';
        echo form_close();
    }
    ?>
							
						<div class="form-group">
					<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
						
						<?php
    if (isset($itens)) {
        echo '
									<h5><strong>Emitente</strong></h5>
									<table class="hover">
										<thead>
											<tr class="text-primary">
												<th>Razão Social</th>
												<th>CNPJ</th>
												<th>Telefone</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>' . $emitenteRazaoSocial . '</td>
												<td>' . $emitenteCnpjFormatado . '</td>
												<td>' . $emitenteTelefone . '</td>
											</tr>
										</tbody>
									</table>
								';
        
        echo '<h5><strong>Destinatário</strong></h5>
									<table class="hover">
										<thead>
											<tr class="text-primary">
												<th>Razão Social</th>
												<th>CNPJ</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>' . $destinatarioRazaoSocial . '</td>
												<td>' . $destinatarioCnpjFormatado . '</td>
											</tr>
										</tbody>
									</table>';
    }
    ?>		
									
									</div>
				</div>
			</div>
		</div>
	</div>
						<?php
    if (isset($itens)) {
        echo '							
							<div class="tab-container">
								<ul class="nav nav-tabs">
							  		<li class="active"><a href="#home" data-toggle="tab">Produtos do Pedido</a></li>
									<li><a href="#profile" data-toggle="tab">Produtos na NF-e</a></li>
								</ul>
								<div class="tab-content">
			  						<div class="tab-pane active cont" id="home">
										<table class="hover">
											<thead class="color-primary">
												<tr>
												<th style="width:13%">Cod. Barras</th>
												<th>Desc. Produto</th>
												<th class="text-center" style="width:9%">UN</th>
												<th class="text-center" style="width:9%">Quant.</th>
												</tr>
											</thead>
											<tbody>
													' . $lista . '
											</tbody>
											</table>
			  						</div>
			  						<div class="tab-pane cont" id="profile">
										<table class="hover">
										<thead class="color-primary">
												<tr>
												<th style="width:13%">Cod. Barras</th>
												<th>Desc. Produto</th>
												<th class="text-center" style="width:9%">UN</th>
												<th class="text-center" style="width:9%">Quant.</th>
												</tr>
											</thead>
										<tbody>';
        
        for ($i = 0; $i < count($itens); $i ++) {
            echo '<tr>
														<td>' . $itens[$i]['ean'] . '</td>
														<td>' . $itens[$i]['nome'] . '</td>
														<td class="text-center">' . $itens[$i]['unidade'] . '</td>
														<td class="text-center">' . $itens[$i]['quantidade'] . '</td>
													</tr>';
        }
        
        echo '</tbody>		
											</table>
			  						</div>
			  						
								</div>
							';
    }
    ?>
		
		</div>

<?php $this->load->view("partial/popfooter"); ?>