<?php
$this->load->view("partial/popup");

setlocale(LC_MONETARY, 'pt_BR');

?>

<div class="cl-mcont">
	<div class="row">
		<div class="col-md-12 col-lg-12 col-sm-12">
			<div class="block-flat">
				<div class="header">
					<h3>
						<font style="color: dodgerblue;">Pagamento e Fechamento de Serviço</font>
					</h3>
				</div>
				<div class="content">
					<?php echo form_open('oslista/pay', 'id="form1" class="form-horizontal group-border-dashed"')?>
						<div class="form-group">
						<div class="col-sm-12 col-md-12 col-lg-12">
							<h4>
								* Checar e conferir a <i>VOLTAGEM da fonte</i> do equipamento *
							</h4>
						</div>
						<div class="col-sm-12 col-md-12 col-lg-12">
							<h3>Informação</h3>
							<table>
								<tr>
									<td> Nº O.S.: <?php echo $idOS;?></td>
									<td>Nome: <?php echo $info[0]['first_name'].' '.$info[0]['last_name'];?></td>
									<td>CPF: <?php echo $info[0]['document_cpf'];?></td>
									<td>RG: <?php echo $info[0]['document_rg'];?></td>
								</tr>
								<tr>
									<td colspan="4"><strong>Aparelho:</strong> <?php echo $info[0]['apparatus'].' '.$info[0]['maker'].' '.$info[0]['model'].' ['.$info[0]['color'].'] (Nº de Série: '.$info[0]['nserie'].')';?></td>
								</tr>
							</table>
						</div>
						<br> <label class="col-sm-6 col-md-6 col-lg-6">
							<h1><?php echo 'Ocorrências: '.money_format('%n', $soma_oc[0]['valor']);?></h1>
							<h1><?php echo 'Entradas: '.money_format('%n', $soma_lan[0]['valor']);?></h1>
						</label> <label class="col-sm-6 col-md-6 col-lg-6"> &nbsp; </label>
						<label class="col-sm-12 col-md-12 col-lg-12">
							<h1 class="big-text no-margin"><?php echo 'Subtotal: '.money_format('%n', ($soma_oc[0]['valor']-$soma_lan[0]['valor'])).'';?></h1>
						</label>
						<div class="col-md-3 col-lg-3 col-sm-3">
							Método de pagamento: <select class="form-control" name="metodo"
								style="width: 200px;"
								onchange="if (this.selectedIndex == 1 || this.selectedIndex == 2 || this.selectedIndex == 4){ habilita_a(); show();}else{ desabilita_a(); hide();}">
								<option value="dinheiro">Dinheiro</option>
								<option value="boleto">Boleto</option>
								<option value="cheque">Cheque</option>
								<option value="cartaodeb">Cartão: débito</option>
								<option value="cartaocred">Cartão: crédito</option>
							</select>
						</div>
						<div class="col-sm-3 col-md-3 col-lg-3">
							Parcelas: <input style="width: 80%;" onchange="change()"
								class="form-control" id="a" type="number" min="1" max="12"
								name="parcela" value="1" id="a" disabled />
						</div>
						<div id="j" class="col-sm-3 col-md-3 col-lg-3"
							style="visibility: hidden;">
							Valor da parcela: <input type="text" class="form-control"
								name="vparc" id="b"
								value="<?php echo ($soma_oc[0]['valor']-$soma_lan[0]['valor']);?>"
								style="visibility: hidden; width: 70%;" disabled="disabled">
						</div>
						<div class="col-sm-3 col-md-3 col-lg-3">
							<div class="form-group">
								<div class="col-lg-12 col-md-12 col-sm-12">
									<input type="hidden" name="os" value="<?php echo $idOS;?>"> <input
										type="hidden" name="nome"
										value="<?php echo $info[0]['first_name'].' '.$info[0]['last_name'];?>">
									<input type="hidden" name="total"
										value="<?php echo ($soma_oc[0]['valor']-$soma_lan[0]['valor']);?>">
									<button
										onclick="document.getElementById('b').removeAttribute('disabled');window.open('<?php echo site_url("oslista/recibo/".$idOS)?>');document.getElementById('form1').submit();"
										type="button" class="btn btn-primary">Confirmar</button>
									<button onclick="window.close();" class="btn btn-default">Voltar</button>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-8 col-md-8 col-lg-8">
							<h3>Ocorrências Processadas</h3>
								
									<?php
        if (isset($manage_table_row)) {
            echo $manage_table_row;
        } else {
            echo 'Nenhuma';
        }
        ?>
								
							</div>
						<div class="col-sm-4 col-md-4 col-lg-4">
							<h3>Entradas do Cliente</h3>
								<?php echo $lista; ?>
							</div>
					</div>
					<?php echo form_close();?>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	// Esconde elemento com id="b" e "j"
		function habilita_a()  
	    {  
	        document.getElementById("a").disabled = false; //Habilitando  
	    }  
	    function desabilita_a()  
	    {  
	        document.getElementById("a").disabled = true; //Desabilitando  
	    }
		function show()
		{
			document.getElementById('b').setAttribute('style', 'visibility: visible; width:70%');
			document.getElementById('j').setAttribute('style', 'visibility: visible;');r
		}
		function hide()
		{
			document.getElementById('b').setAttribute('style', 'visibility: hidden; width:70%');
			document.getElementById('j').setAttribute('style', 'visibility: hidden;');
		}
		function change()
		{
			document.getElementById('b').value = (((<?php echo ($soma_oc[0]['valor']-$soma_lan[0]['valor']);?>/document.getElementById('a').value).toFixed(2)));
		}	

	</script>

<?php $this->load->view("partial/popfooter"); ?>