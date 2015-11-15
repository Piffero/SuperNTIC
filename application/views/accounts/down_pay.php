<?php $this->load->view("partial/header"); ?>
<div class="container-fluid" id="pcont" style="background-color: white;">
	<div class="page-aside email">
		<div class="fixed nano nscroller">
			<div class="content">
				<div class="header">
					<button class="navbar-toggle" data-target=".mail-nav"
						data-toggle="collapse" type="button">
						<span class="fa fa-chevron-down"></span>
					</button>
					<h3 class="page-title">Lan&#231;amento</h3>
				</div>
				<div class="mail-nav collapse">
					<ul class="nav nav-pills nav-stacked">
						<li><a href="<?php echo $this->config->site_url('accounts');?>"><span
								class="label label-success pull-right"><?php if(isset($sum_accont_rend)){echo get_float_view($sum_accont_rend);}else{echo '0,00';}?></span><i
								class="fa fa-arrow-left text-success"></i> Contas a Receber</a></li>
						<li><a
							href="<?php echo $this->config->site_url('accounts/payables');?>"><span
								class="label label-danger pull-right"><?php if(isset($sum_accont_pay)){echo get_float_view($sum_accont_pay);}else{echo '0,00';}?></span><i
								class="fa fa-arrow-right text-danger"></i> Contas a Pagar</a></li>
						<li><a><span class="label label-primary pull-right"><?php if(isset($sum_accont_flow)){echo $sum_accont_flow;}else{echo '0,00';} ?></span><i
								class="fa fa-money text-primary"></i> Saldo Final R$</a></li>
					</ul>

					<div class="header">
						<h3 class="page-title">Consolidado</h3>
					</div>

					<ul class="nav nav-pills nav-stacked">
						<li><a
							href="<?php echo $this->config->site_url('accounts/donw_receit');?>"><span
								class="label label-success pull-right"><?php if(isset($sum_rend)){echo get_float_view($sum_rend);}else{echo '0,00';}?></span><i
								class="fa fa-arrow-left text-success"></i> Receitas</a></li>
						<li class="active"><a
							href="<?php echo $this->config->site_url('accounts/donw_pay');?>"><span
								class="label label-danger pull-right"><?php if(isset($sum_pay)){echo get_float_view($sum_pay);}else{echo '0,00';}?></span><i
								class="fa fa-arrow-right text-danger"></i> Despesas</a></li>
						<li><a><span class="label label-primary pull-right"><?php if(isset($sum_flow)){echo $sum_flow;}else{echo '0,00';}?></span><i
								class="fa fa-money text-primary"></i>Saldo Final R$</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid" id="pcont">
		<div class="message">
			<div class="head">
				<h3 class="page-title">Despesas Consolidadas</h3>
			</div>
			<div class="mail" style="width: 870px; height: 510px;">
      <?php date_default_timezone_set('America/Sao_Paulo'); ?>
       		<div class="col-md-12">
					<div class="content">
							<?php echo form_open('accounts/donw_pay',array('id'=>'filter_form'));?>
								<div class="col-sm-2">
							<input class="form-control" placeholder="Data"
								data-mask="00/00/0000" name="datefilterstart" type="text"
								onkeypress="javascript:return displayKeyCode(event)"
								value="<?php echo $datestart; ?>"></input>
						</div>
						<div class="col-sm-2">
							<input class="form-control" placeholder="Data"
								data-mask="00/00/0000" name="datefilterend" type="text"
								onkeypress="javascript:return displayKeyCode(event)"
								value="<?php echo $dateend;?>"></input>
						</div>
							<?php echo form_close();?>
						<p align="right">
							<button id="print" class="btn btn-default btn-flat"
								onclick="javascript:printDiv('table')"
								data-original-title="Imprimir" data-toggle="tooltip"
								data-placement="bottom">
								<i class="fa fa-print"></i>
							</button>
						</p>
						<div id="table" class="table-responsive">
							<h5><?php if(isset($manage_result)){echo $manage_result;}else{echo '';}; ?></h5>
							<table class="table no-border hover">
								<?php echo $manage_table; ?>
								<tfoot class="no-border-y">
									<tr>
										<td colspan="4" class="text-right">Sub Total</td>
										<td colspan="3" class="text-center color-danger">R$ <?php if(isset($sum_pay)){echo get_float_view($sum_pay);}else{echo '0,00';}?></td>
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


<script type="text/javascript">
<!--
 function displayKeyCode(e) {
		if(e.keyCode == 13){
			document.getElementById("filter_form").submit();
		}		
 }
//-->
</script>

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
		document.getElementById('down').setAttribute("href","<?php echo $this->config->site_url('accounts/donw');?>/"+id_da_linha);
		document.getElementById('delete').setAttribute("href","<?php echo $this->config->site_url('accounts/delete');?>/"+id_da_linha); 		
		}
	
	
	function D(id) {  
		window.open("<?php echo $this->config->site_url('accounts/append/0');?>/"+id,"Lancamento Contas","STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=50, LEFT=70,width=770,height=500");                        
   }

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

	 var cl = document.getElementById('cl-wrapper');
	 cl.setAttribute('class', 'fixed-menu sb-collapsed');
	 document.getElementById('sidebar-collapse').innerHTML = '<i class="fa fa-angle-right" style="color:#fff;"></i>';
</script>

<?php $this->load->view("partial/footer"); ?>