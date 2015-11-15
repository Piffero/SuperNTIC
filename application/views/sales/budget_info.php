<?php $this->load->view("partial/popup"); ?>

<div id="content" class="ontainer-fluid">
	<div class="col-lg-12 col-sm-12 col-md-12">
		<div class="cl-mcont">

			<div class="block-flat">
				<div class="header">
					<h3>
						<span style="color: blue;"><?php echo $caption; ?></span>
					</h3>
				</div>

				<div class="content">
    					<?php echo $data_view;?>
    				</div>

				<div class="spacer2 text-right">
    					<?php
        echo form_open('sales_lista/success_sales');
        if (isset($form_success)) {
            echo $form_success;
        }
        ?>
    					<button class="btn btn-default btn-flat" type="reset"
						onclick="self.close();">fechar</button>
    					
    					<?php echo form_close();?>
    				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view("partial/footer"); ?>	