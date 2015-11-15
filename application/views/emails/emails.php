<?php $this->load->view("partial/header"); ?>
<div class="container-fluid" id="pcont">
	<div class="cl-mcont">

		<iframe
			src="<?php echo $this->config->base_url();?>application/plug/email/"
			width="100%" height="560"></iframe>

	</div>
</div>
<?php $this->load->view("partial/footer"); ?>