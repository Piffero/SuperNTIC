<?php $this->load->view("partial/header"); ?>

<div id="content" class="ontainer-fluid">
	<div class="col-lg-12 col-sm-12 col-md-12">
		<div class="cl-mcont">
			<div class="block-flat">
				<div class="header">
					<h3>
						<span style="color: dodgerblue;">Lista de Vendas</span>
					</h3>
				</div>
				<div class="content">    					    					    				
    					<?php echo $manager_table;?>    					   						
    				</div>
			</div>
		</div>
	</div>
</div>

<script
	src="<?php echo $this->config->base_url();?>web/js/jquery.min.js"></script>

<script type="text/javascript">
		function progress_sales(id)
		{
			var URL = "<?php echo base_url();?>index.php/sales_lista/show_progress_sales/";
			window.open(URL+id , "_black" );									
		}

		function progress_return(id)
		{
			var URL = "<?php echo $this->config->site_url('sales_lista/progress_return');?>";
			window.open(URL+'/'+id, "Retorno", "width=1200, height=650");
		}

		function reboot()
		{
			
		}
	</script>



<?php $this->load->view("partial/footer"); ?>	