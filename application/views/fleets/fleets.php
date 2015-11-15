 <?php $this->load->view("partial/header"); ?>
<div class="container-fluid" id="pcont">
	<div class="page-head">
		<h2>Registro de Ve�culos</h2>
	</div>
	<div class="cl-mcont">
			<?php if(isset($manage_result)){echo $manage_result;}else{echo '';}; ?>
			<div class="row">


			<div class="col-sm-4">
				<div class="btn-group">
					<a class="btn btn-default btn-flat" type="button"
						href="<?php echo $this->config->site_url('fleets/append');?>"><i
						class="fa fa-plus"></i> Novo</a> <a
						class="btn btn-default btn-flat" type="button"
						href="<?php echo $this->config->site_url('fleets/view');?>"><i
						class="fa fa-pencil"></i> Editar</a> <span></span> <a
						class="btn btn-default btn-flat" type="button"><i
						class="fa fa-times"></i> Deletar</a>
				</div>
			</div>

			<div class="col-sm-4 input-group">&nbsp;</div>

			<div class="col-sm-4 input-group text-right">
				<form action="#" method="post">
					<input class="form-control" type="text"
						placeholder="Busca de Ve�culo:" id="search" name="search">
				</form>
			</div>

		</div>

		<div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="tab-container">

					<!------CONTROL TABS START------->
					<ul class="nav nav-tabs">
						<li class="active"><a href="#list" data-toggle="tab"><i
								class="fa fa-align-justify"></i> Lista de Ve�culos</a></li>
					</ul>
					<!------CONTROL TABS END------->

					<div class="tab-content">
						<div class="tab-pane active cont" id="list">


							<!----TABLE LISTING STARTS--->
							<div class="content">
								<div class="table-responsive">
									<table class="table no-border hover">
										<thead class="no-border">
											<tr>
												<th style="width: 2%;"><input type="checkbox" id="check"
													onclick="CheckAll(event);" /></th>
												<th style="width: 30%;"><strong>Nome e Sobrenome</strong></th>
												<th class="text-right"><strong>Fone Principal</strong></th>
												<th style="width: 15%;"><strong>Email</strong></th>
												<th style="width: 15%;"><strong>CPF</strong></th>
												<th style="width: 15%;"><strong>Situa&#231;&#227;o</strong></th>
											</tr>
										</thead>
										<tbody class="no-border-y">
											<tr>
												<td><input type="checkbox" id="ck1" /></td>
												<td>Fulano da Silva</td>
												<td class="text-right">48 8888-8888</td>
												<td class="color-primary"><strong>fulano@dominio.com.br</strong></td>
												<td>111.111.111-11</td>
												<td>Ativo</td>
											</tr>
										</tbody>
									</table>
									<p style="background-color: #E8E8E8;">Por favor informar Nome,
										Sobrenome, Email ou CPF para iniciar a busca</p>
								</div>
							</div>
							<!----TABLE LISTING ENDS--->
						</div>
					</div>

				</div>
			</div>
		</div>

	</div>
</div>


<script>
	function CheckAll(e){
		try{var element = e.target;		 }catch(er){};
		try{var element = event.srcElement; }catch(er){};
		
		if (element.checked){
			var arrayElements = document.getElementsByTagName('input');
			
			for(var i=0; i<arrayElements.length; i++){
				if (arrayElements[i].type == 'checkbox'){					
					arrayElements[i].checked = true;					
				}
			}
		}
		var mudar = document.getElementById('check');
		mudar.setAttribute('onclick', 'DesChekALL(event)');
	}

	function DesChekALL(e){
		try{var element = e.target;		 }catch(er){};
		try{var element = event.srcElement; }catch(er){};
		
		
			var arrayElements = document.getElementsByTagName('input');
			
			for(var i=0; i<arrayElements.length; i++){
				if (arrayElements[i].type == 'checkbox'){					
					arrayElements[i].checked = false;					
				}
			
		}
		var mudar = document.getElementById('check');
		mudar.setAttribute('onclick', 'CheckAll(event)');	
	}
</script>

<?php $this->load->view("partial/footer"); ?>