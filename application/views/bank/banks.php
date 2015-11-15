 <?php $this->load->view("partial/header"); ?>
<div class="container-fluid" id="pcont">
	<div class="page-head">
		<h2>Registro de Bancos</h2>
	</div>
	<div class="cl-mcont">
			<?php if(isset($manage_result)){echo $manage_result;}else{echo '';}; ?>
			<div class="row">


			<div class="col-sm-5">
				<div class="btn-group">
					<a class="btn btn-primary btn-flat" type="button"
						href="<?php echo $this->config->site_url('banks/append');?>"><i
						class="fa fa-plus"></i> Novo</a> <a id="edit"
						class="btn btn-default btn-flat" type="button" href="#"><i
						class="fa fa-pencil"></i> Editar</a> <span></span> <a id="delete"
						class="btn btn-default btn-flat" type="button" href="#"><i
						class="fa fa-times"></i> Deletar</a>
				</div>
			</div>

			<div class="col-sm-3 input-group">&nbsp;</div>

			<div class="col-sm-4 input-group text-right">
				<form action="<?php echo $this->config->site_url('banks/search')?>"
					method="post">
					<input class="form-control" type="text"
						placeholder="Busca de Contas:" autocomplete="off" id="search"
						name="search">
				</form>
			</div>

		</div>

		<div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="tab-container">

					<!------CONTROL TABS START------->
					<ul class="nav nav-tabs">
						<li class="active"><a href="#list" data-toggle="tab"><i
								class="fa fa-align-justify"></i> Lista de Consultas</a></li>
					</ul>
					<!------CONTROL TABS END------->

					<div class="tab-content">
						<div class="tab-pane active cont" id="list">								
								<?php echo $manage_table; ?>
								<div class="col-sm-12" align="right">
									<?php echo $num_row; ?>
								</div>
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

	function mudaCor(id_da_linha){
		document.getElementById('edit').setAttribute("href","<?php echo $this->config->site_url('banks/view');?>/"+id_da_linha);
		document.getElementById('delete').setAttribute("href","<?php echo $this->config->site_url('banks/delete');?>/"+id_da_linha); 		
		}

	function D(id) {
        window.location.href = "<?php echo $this->config->site_url('banks/view');?>/"+id;                 
   }
</script>

<?php $this->load->view("partial/footer"); ?>