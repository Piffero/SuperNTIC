<?php $this->load->view("partial/popup"); ?>


	<?php if(isset($caller)){echo $caller;}?>
<div class="col-md-12 col-lg-12 col-sm-12">
	<div class="block-flat">
		<div class="header">
			<h3>
				<font style="color: dodgerblue;">Ligação para Cliente</font>
			</h3>
		</div>
		<div class="content">
					<?php echo form_open('oslista/contato','class="form-horizontal group-border-dashed"')?> 
						<div class="form-group">
				<div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">
					<h3>Cliente:</h3>
								Nome: <?php echo $info[0]['first_name'].' '.$info[0]['last_name'];?><br>
								Telefones: <?php
        
        echo '<select>';
        if (! empty($info[0]['phone_home'])) {
            if ($info[0]['phone_number'] == '1') {
                echo '<option selected> &#149; ' . $info[0]['phone_home'] . ' (Casa) </option>';
            } else {
                echo '<option>' . $info[0]['phone_home'] . ' (Casa)  </option>';
            }
        }
        if (! empty($info[0]['phone_work'])) {
            if ($info[0]['phone_number'] == '2') {
                echo '<option selected> &#149;' . $info[0]['phone_work'] . '  (Trab) </option>';
            } else {
                echo '<option>' . $info[0]['phone_work'] . ' (Trab)  </option>';
            }
        }
        if (! empty($info[0]['phone_cell'])) {
            if ($info[0]['phone_number'] == '3') {
                echo '<option selected> &#149;' . $info[0]['phone_cell'] . '  (Cel)  </option>';
            } else {
                echo '<option>' . $info[0]['phone_cell'] . ' (Cel)   </option>';
            }
        }
        if (! empty($info[0]['phone_other'])) {
            if ($info[0]['phone_number'] == '4') {
                echo '<option selected> &#149;' . $info[0]['phone_other'] . ' (outro)</option>';
            } else {
                echo '<option>' . $info[0]['phone_other'] . ' (outro)</option>';
            }
        }
        echo '</select>';
        ?>
							</div>
				<div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">
					<h3>O.S.:</h3>
								Nº: <?php echo $idOS;?><br>
								Produto: <?php echo $info[0]['apparatus'].' '.$info[0]['maker'].' '.$info[0]['model'].' ['.$info[0]['color'].']';?>
							</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
					<h4>Descrição de contato com o cliente:</h4>
					<input type="hidden" name="idOS" value="<?php echo $idOS; ?>">
					<textarea id="desaba" name="descricao" style="resize: none;"
						placeholder="Descrição..." rows="4" maxlength="500"
						class="form-control"></textarea>
					<label><input type="radio" name="contato" value="1"
						onclick="habilita();" checked> Contato realizado</label><br> <label><input
						type="radio" name="contato" value="0" onclick="desabilita();">
						Cliente não atendeu</label>
				</div>
			</div>
			<div class="form-group">
				<button class="btn btn-primary" type="submit">Salvar Ligação</button>
			</div>
					<?php echo form_close();?>
					<div class="col-sm-12 col-md-12 col-lg-12 col-xs-12"
				style="display: inline-block">
				<table class="hover">
					<thead class="text-primary">
						<tr>
							<th>Ocorrencia</th>
							<th>Valor</th>
							<th>Funcionário</th>
							<th>Data</th>
						</tr>
					</thead>
					<tbody>
								<?php if (isset($manage_table_row)){echo $manage_table_row;}?>
							</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
		function desabilita()
		{
			document.getElementById("desaba").disabled=true;
		}
		function habilita()
		{
			document.getElementById("desaba").disabled=false;
		}
		</script>

<?php $this->load->view("partial/popfooter"); ?> 