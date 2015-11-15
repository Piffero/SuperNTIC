<?php $this->load->view("partial/popup"); ?>

<div id="content" class="ontainer-fluid">
	<div class="col-lg-12 col-sm-12 col-md-12">
		<div class="cl-mcont">

			<div class="block-transparent">
				<div class="header">
					<h3>
						<span style="color: blue;">Números de Serie</span>
					</h3>
				</div>
	    			
    				<?php echo $list_series;?>    						    				
	    		</div>
			<button class="btn btn-default btn-flat"
				onclick="self.close(); opener.set_valor();">fechar</button>
		</div>
	</div>
</div>

<?php $this->load->view("partial/footer"); ?>	