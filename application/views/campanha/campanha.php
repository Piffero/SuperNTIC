<?php $this->load->view("partial/header"); ?>

<div class="container-fluid" id="pcont" style="background-color: white;">
	<div class="main-app">
		<div class="head">
			<h3>Programa de Acompanhamento</h3>
			<input type="text" class="form-control"
				placeholder="Buscar de Programa..." />
			<div class="options">
				<div class="btn-group pull-right">
					<button class="btn btn-sm btn-flat btn-default" type="button">
						<i class="fa fa-angle-left"></i>
					</button>
					<button class="btn btn-sm btn-flat btn-default" type="button">
						<i class="fa fa-angle-right"></i>
					</button>
				</div>

				<div class="btn-group pull-right">
					<button class="btn btn-sm btn-flat btn-default md-trigger"
						type="button" data-modal="form-primary">
						<i class="fa fa-plus"></i>
					</button>
					<!-- 
					<button class="btn btn-sm btn-flat btn-default" type="button">
						<i class="fa fa-times"></i>
					</button>
					 -->
				</div>
			</div>
		</div>

		<div class="filters">				    
		       	<?php echo $manager_result;?>
			</div>

		<div class="filters">
			<div class="items products">
		     		<?php echo $table_items;?>     
		    	</div>
		</div>

	</div>
</div>



<!-- Nifty Modal -->
<div class="md-modal colored-header custom-width md-effect-9"
	id="form-primary">
	<div class="md-content">
		<div class="modal-header">
			<h3>Aparelhos Vendidos Recentemente</h3>
			<button type="button" class="close md-close" data-dismiss="modal"
				aria-hidden="true">&times;</button>
		</div>
		<div class="modal-body form" style="height: 200px; overflow: auto;">

			<table class="table no-border hover">
				<thead class="no-border no-border-y">
					<tr>
						<th style="width: 5%;"><strong>#</strong></th>
						<th style="width: 10%;"><strong>Pedido</strong></th>
						<th style="width: 25%;"><strong>Serie</strong></th>
						<th style="width: 25%;"><strong>Usuário</strong></th>
					</tr>
				</thead>
				<tbody class="no-border-y">
							<?php echo $manager_table; ?>	
						</tbody>
			</table>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default btn-flat md-close"
				data-dismiss="modal">Cancelar</button>
			<button id="create_new" type="button"
				class="btn btn-primary btn-flat md-close" onclick=""
				data-dismiss="modal">Criar Programa</button>
		</div>
	</div>
</div>


<div class="md-overlay"></div>

<!-- POST POR AJAX -->
<script
	src="<?php echo $this->config->base_url();?>web/js/jquery.min.js"></script>




<script type="text/javascript">
		var cl = document.getElementById('cl-wrapper');
	    cl.setAttribute('class', 'fixed-menu sb-collapsed'); 
	    document.getElementById('sidebar-collapse').innerHTML = '<i class="fa fa-angle-right" style="color:#fff;"></i>';

	    
		function create_program(id, serie)
		{
			 var URL = "<?php echo $this->config->site_url('campanha/append'); ?>/"+id+"/"+serie;
			 window.location.href = URL;	
		}
	    
	    function c(id, serie)
	    {			
		    var btn = document.getElementById('create_new');		    
		    btn.setAttribute('onclick', 'create_program('+id+',\''+serie+'\');');			
	    }

	    function rand(){
	    	alert($('div.tooltip-inner').html());
	    }

	    
	</script>



<?php $this->load->view("partial/footer"); ?>