<?php $this->load->view("partial/header"); ?>
<div class="container-fluid" id="pcont">
	<div class="cl-mcont">
		<div class="row">
			<div class="col-sm-12 col-md-12 col-xs-12">
				<div class="tab-container">

					<!------CONTROL TABS START------->
					<ul class="nav nav-tabs">
						<li class="active"><a href="#list" data-toggle="tab"><i
								class="fa fa-align-justify"></i> Entradas</a></li>
					</ul>
					<!------CONTROL TABS END------->

					<div class="tab-content">
						<div class="tab-pane active cont">
								  	<?php date_default_timezone_set('America/Sao_Paulo'); ?>
									<div class="content">
										<?php echo form_open('os/filter',array('id'=>'filter_form'));?>
										<div class="col-sm-2 col-md-2 col-xs-2">
									<input class="form-control" placeholder="Data"
										data-mask="00/00/0000" name="datefilterstart" type="text"
										onkeypress="javascript:return displayKeyCode(event)"
										value="<?php echo $datestart; ?>"></input>
								</div>
								<div class="col-sm-2 col-md-2 col-xs-2">
									<input class="form-control" placeholder="Data"
										data-mask="00/00/0000" name="datefilterend" type="text"
										onkeypress="javascript:return displayKeyCode(event)"
										value="<?php echo $dateend;?>"></input>
								</div>
										<?php echo form_close();?>
										<button id="down" class="btn btn-default btn-flat"
									onclick="javascript:printDiv('table')" data-placement="bottom">
									<i class="fa fa-print"></i>
								</button>
								<div id="table" class="table-responsive">
									<h5><?php if(isset($manage_result)){echo $manage_result;}else{echo '';}; ?></h5>
									<table class="table no-border hover">
											<?php echo $manage_table; ?>
											<tfoot class="no-border-y">
											<tr>
												<td colspan="2" class="text-right big-text no-margin">Sub
													Total</td>
												<td colspan="5"
													class="text-center color-success  big-text no-margin">R$ <?php if(isset($sum_accont_rend->value)){echo get_float_view($sum_accont_rend->value);}else{echo '0,00';}?></td>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>

						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
 	function displayKeyCode(e) {
		if(e.keyCode == 13){
			document.getElementById("filter_form").submit();
		}		
 	}
 
 	</script>


<script type="text/javascript">
        function printDiv(divID) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
            document.body.innerHTML = 
              "<html><head><title></title></head><body>" + 
              divElements + "</body>";

              
            //Print Page
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = oldPage;

          
        }
    </script>
<?php $this->load->view("partial/footer"); ?>	