<?php $this->load->view("partial/popup"); ?>
<script type="text/javascript">
window.print();
</script>
<div class="row">
	<div class="col-md-12 col-lg-12 col-sm-12">
		<div class="block-flat">
			<div class="header">
				<h3>
					<font style="color: dodgerblue;">Recibo de Serviço</font>
				</h3>
			</div>
			<div class="content">
				<div class="row">
					<div class="col-lg-3 col-md-3 col-sm-3"
						style="display: inline-block;">
						<img alt="logo" style="max-width: 120px; max-height: 120px;"
							src="<?php echo site_url("../../../../upload/".$enterprise->logo_address)?>">
					</div>
					<div class="col-lg-9 col-md-9 col-sm-9"
						style="display: inline-block;">
						<label><h5><?php echo '<u>'.$enterprise->razaosocial.'</u>';?></h5></label>
						<br> <label><?php
    
    $cnpj = substr($enterprise->cnpj, 0, 2) . '.' . substr($enterprise->cnpj, 2, 3) . '.' . substr($enterprise->cnpj, 5, 3) . '/' . substr($enterprise->cnpj, 8, 4) . '-' . substr($enterprise->cnpj, 12, 2);
    echo 'CNPJ: ' . $cnpj;
    ?> | IE: <?php echo $enterprise->ie;?>
								</label> <br> <label>Tel.: <?php echo $enterprise->fone; if ($enterprise->website != NULL){echo ' | '.$enterprise->website;}?></label>
						<br> <label>Endereço: <?php echo $enterprise->logradouro;?>, <?php echo $enterprise->complemento;?>, Nº <?php echo $enterprise->numero;?> - <?php echo $enterprise->municipio;?>/<?php echo $enterprise->uf;?></label>
					</div>
					<hr>
					<div class="col-md-6 col-lg-6 col-sm-6"
						style="display: inline-block;">
								Cliente: <?php echo $cliente->first_name.' '.$cliente->last_name;?> <br> 
								CPF/CNPJ: <?php echo $cliente->document_cpf;?> <br>
								RG: <?php echo $cliente->document_rg;?><br>
					</div>
					<div class="col-md-6 col-lg-6 col-sm-6"
						style="display: inline-block;">
								Item: <?php echo $aparelho->apparatus.' '.$aparelho->maker.' '.$aparelho->model.' [Série: '.$nserie.']'; ?>
							</div>

					<div class="col-md-12 col-lg-12 col-sm-12"
						style="display: inline-block;">
						<hr>
						<p>
						
						
						<h4>OS Nº: <?php echo $idOS;?></h4>
						<table class="hover">
							<thead class="color-primary">
								<tr>
									<th><strong>Ocorrência</strong></th>
									<th class="text-right"><strong>Valor</strong></th>
									<th class="text-center"><strong>Data</strong></th>
								</tr>
							</thead>
							<tbody>
										<?php
        if (isset($manage_table_row)) {
            echo $manage_table_row;
        }
        ?>
									</tbody>
						</table>

						<table class="no-border">
							<tbody class="no-border-y no-border-x">
								<tr>
									<td><h4>Total:</h4></td>
									<td class="text-right"><h4><?php if (isset($soma_oc[0]['valor'])){echo money_format('%n', $soma_oc[0]['valor']);}else {echo 'R$ 0.00';}?></h4></td>
								</tr>
								<tr>
									<td><h4>Entradas:</h4></td>
									<td class="text-right"><h4><?php if (isset($soma_lan[0]['valor'])){echo money_format('%n', $soma_lan[0]['valor']);}else {echo 'R$ 0.00';}?></h4></td>
								</tr>
								<tr>
									<td><h4>Subtotal:</h4></td>
									<td class="text-right"><h4><?php echo money_format('%n', ($soma_oc[0]['valor']-$soma_lan[0]['valor'])).'';?></h4></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="col-md-12 col-lg-12 col-sm-12"
						style="display: inline-block;">
						<h4>
							<b>Laudo Técnico:</b>
						</h4>
						<p>
								<?php
        if (isset($laudo)) {
            echo $laudo;
        } else {
            echo "Não há laudo sobre este item.";
        }
        ?>
								</p>
						<hr>
						<br> * GARANTIA DE 90 DIAS A PARTIR DA DATA DO LAUDO DO CONSERTO.<br>
						INDISPENSÁVEL A PRESENÇA DESTE DOCUMENTO.
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view("partial/popfooter"); ?>