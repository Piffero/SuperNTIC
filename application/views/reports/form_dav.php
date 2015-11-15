<?php $this->load->view("partial/header"); ?>
<div class="container-fluid" id="pcont">
	<div class="cl-mcont">
		<div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="block-flat">
					<div class="content" style="height: 500px;">
						<div class="col-sm-2 col-lg-2 col-md-2" style="height: 128px;">
							<table class="table hover" data-original-title="Tipo de Consulta"
								data-toggle="tooltip">
								<!-- class="no-border"> -->
								<tr>
									<td><input type="radio" name="consulta" checked> Filtros
										Avançados</td>
								</tr>
								<tr>
									<td><input type="radio" name="consulta"> COO</td>
								</tr>
								<tr>
									<td><input type="radio" name="consulta"> CRZ</td>
								</tr>
							</table>
						</div>
						<div class="col-sm-7 col-lg-7 col-md-7">
							<label>Loja:</label> <select class="select2">
								<option value="A">A</option>
								<option value="B">B</option>
								<option value="C">C</option>
							</select>
						</div>
						<div class="col-sm-3 col-lg-3 col-md-3">
							<label>Caixa:</label> <select class="select2">
								<option value="A">A</option>
								<option value="B">B</option>
								<option value="C">C</option>
							</select>
						</div>
						<div class="col-sm-3 col-lg-3 col-md-3">
							<label>Operador:</label> <select class="select2">
								<option value="A">A</option>
								<option value="B">B</option>
								<option value="C">C</option>
							</select>
						</div>
						<div class="col-sm-3 col-lg-3 col-md-3">
							<label>Vendedor:</label> <select class="select2">
								<option value="A">A</option>
								<option value="B">B</option>
								<option value="C">C</option>
							</select>
						</div>
						<div class="col-sm-2 col-lg-2 col-md-2">
							<label>Turno:</label> <input type="number" class="form-control">
						</div>
						<div class="col-sm-2 col-lg-2 col-md-2">
							<br>
							<button style="margin-top: 1px;" class="btn btn-primary">Pesquisar</button>
						</div>
						<div class="col-sm-3 col-lg-3 col-md-3">
							<label>Vendedor:</label> <select class="select2">
								<option value="A">A</option>
								<option value="B">B</option>
								<option value="C">C</option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view("partial/footer"); ?>

<!-- 



-->