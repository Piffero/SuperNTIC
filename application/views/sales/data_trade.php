<?php $this->load->view("partial/popup"); ?>

<div id="content" class="ontainer-fluid">
	<div class="col-lg-12 col-sm-12 col-md-12">
		<div class="cl-mcont">

			<div class="block-flat">
				<div class="content">
						<?php
    
    echo form_open('sales/salve_info_add', array(
        'id' => 'customers_form',
        'class' => 'form-horizontal'
    ));
    ?>
						<table class="no-border">
						<thead class="no-border">
							<tr>
								<th colspan="8"><h3>
										Dados Comerciais <small>do Comprador</small>
									</h3></th>
							</tr>
						</thead>
						<tbody class="no-border-y">
							<tr>
								<td align="left">Local de Trabaho:</td>
								<td colspan="7" align="left"><input type="text"
									id="loacation_work" class="form-control parsley-validated"
									placeholder="Local de Trabalho" name="location_work"
									value="<?php if(isset($customer_work->location_work)){echo $customer_work->location_work;}?>">
								</td>
							</tr>
							<tr>
								<td>End. do Trabalho:</td>
								<td colspan="3" align="left"><input id="address_work"
									type="text" class="form-control parsley-validated"
									placeholder="End. do Trabalho" name="address_work"
									value="<?php if(isset($customer_work->address_work)){echo $customer_work->address_work;}?>"></td>
								<td align="right">Telenone Trabalho:</td>
								<td align="left" colspan="2"><input id="PhoneWork" type="text"
									class="form-control" placeholder="Telenone Trabalho"
									name="phone_work"
									value="<?php if(isset($customer_work->phone_work)){echo $customer_work->phone_work;}?>"></td>
							</tr>
							<tr>
								<td>Bairro:</td>
								<td align="left"><input id="district" type="text"
									class="form-control parsley-validated" placeholder="Bairro"
									name="district_work"
									value="<?php if(isset($customer_work->district_work)){echo $customer_work->district_work;}?>"></td>
								<td align="right">Cidade:</td>
								<td align="left"><input id="city" type="text"
									class="form-control parsley-validated" placeholder="Cidade"
									name="city_work"
									value="<?php if(isset($customer_work->city_work)){echo $customer_work->city_work;}?>"></td>
								<td align="right">UF:</td>
								<td align="left"><input id="UF" type="text"
									class="form-control parsley-validated" placeholder="UF"
									name="UF_work"
									value="<?php if(isset($customer_work->UF_work)){echo $customer_work->UF_work;}?>"></td>
							</tr>
							<tr>
								<td>Tempo de Serviço:</td>
								<td align="left"><input id="time_service" type="text"
									class="form-control parsley-validated"
									placeholder="Tempo de Serviço" name="time_service"
									value="<?php if(isset($customer_work->time_service)){echo $customer_work->time_service;}?>"></td>
								<td align="right">Salário:</td>
								<td align="left"><input id="rend" type="text"
									class="form-control parsley-validated" placeholder="Salário"
									name="salary"
									value="<?php if(isset($customer_work->salary)){echo $customer_work->salary;}?>"></td>
								<td align="right">Outras Rendas:</td>
								<td align="left"><input id="OutherRend" type="text"
									class="form-control" placeholder="Outras Rendas"
									name="other_income"
									value="<?php if(isset($customer_work->other_income)){echo $customer_work->other_income;}?>"></td>
							</tr>
						</tbody>
					</table>
					<br> <br>
					<button class="btn btn-primary btn-flat"
						onclick="document.getElementById('customers_form').submit();">Salvar</button>
					<button class="btn btn-default btn-flat" onclick="self.close();">Fechar</button>
						<?php echo form_close();?>
					</div>
				<!------CONTENT END------->
			</div>
			<!------block-flat END------->

		</div>
	</div>
</div>

<?php $this->load->view("partial/footer"); ?>	    