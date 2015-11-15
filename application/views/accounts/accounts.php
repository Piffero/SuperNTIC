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
						<li class="active"><a
							href="<?php echo $this->config->site_url('accounts');?>"><span
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
						<li><a
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
				<h3 class="page-title">Contas a Receber</h3>
			</div>
			<div class="mail" style="width: 870px; height: 510px;">
				<div class="col-md-12">
					<div class="content">
						<?php echo form_open('accounts',array('id'=>'filter_form'));?>
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
							<button class="btn btn-default btn-flat"
								onClick="javascript:window.open('<?php echo $this->config->site_url('accounts/append/0');?>','Lancamento Contas','STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=50, LEFT=70,width=770,height=500');"
								data-original-title="Novo Lan&#231;amento" data-toggle="tooltip"
								data-placement="bottom">
								<i class="fa  fa-file-o"></i>
							</button>
							<button id="boleto" class="btn btn-default btn-flat"
								onclick="javascript: fallboleto();"
								data-original-title="Gerar Boleto" data-toggle="tooltip"
								data-placement="bottom">
								<i class="fa  fa-barcode"></i>
							</button>
							<button id="down" class="btn btn-default btn-flat md-trigger"
								onclick="javascript: falldown();" data-modal="form-down"
								data-original-title="Compensar" data-toggle="tooltip"
								data-placement="bottom">
								<i class="fa fa-check-square-o"></i>
							</button>
							<a id="delete" class="btn btn-default btn-flat" href="#"
								data-original-title="Cancelar" data-toggle="tooltip"
								data-placement="bottom"><i class="fa fa-times"></i></a> &nbsp;
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
										<td colspan="5" class="text-right">Sub Total</td>
										<td colspan="2" class="text-center color-success">R$ <?php if(isset($sum_accont_rend)){echo get_float_view($sum_accont_rend);}else{echo '0,00';}?></td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Nifty Modal -->
	<div class="md-modal colored-header success custom-width md-effect-9"
		id="form-down" style="z-index: 99999">
		<div class="md-content">
			<div class="modal-header">
				<h3>Confirmação de Baixa</h3>
				<button type="button" class="close md-close" data-dismiss="modal"
					aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body form">
				<div class="row">
					<div class="form-group col-md-12 no-margin">
						<label>Dados da Conta</label>
					</div>
				</div>
				<div class="row no-margin-y">
					<div class="form-group col-md-4 col-sm-4  col-xs-4 no-margin">
						<input id="plan_account" type="text" class="form-control"
							readonly="readonly" placeholder="Plano de Conta">
					</div>
					<div class="form-group col-md-4 col-sm-4  col-xs-4 no-margin">
						<input id="date" type="text" class="form-control"
							readonly="readonly" placeholder="Vencimento">
					</div>
					<div class="form-group col-md-3 col-sm-3  col-xs-3 no-margin">
						<input id="valor" type="text" class="form-control"
							readonly="readonly" placeholder="Valor">
					</div>
				</div>
				<div class="form-group">
					<label>Cliente</label> <input id="favored" type="text"
						class="form-control" readonly="readonly" placeholder="John Doe">
				</div>
				<div class="row">
					<div class="form-group col-md-12 no-margin">
						<label>Dados do Pagamento</label>
					</div>
				</div>
				<div class="row no-margin-y">
					<div class="form-group col-md-4 col-sm-4  col-xs-4 no-margin">
						<input id="set_data" type="text" data-mask="00/00/0000"
							class="form-control" placeholder="Data Pagamento">
					</div>
					<div class="form-group col-md-3 col-sm-3  col-xs-3 no-margin">
						<input id="set_valor" type="text" data-mask="######0.00"
							data-mask-reverse="true" class="form-control" required
							placeholder="Valor">
					</div>
				</div>
				<br>
				<h4 id="falldown" style="color: red; visibility: hidden;">Para
					efetuar a baixa você deve antes selecionar uma conta.</h4>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-flat md-close"
					data-dismiss="modal">Cancelar</button>
				<button id="btn_down" type="button" class="btn btn-success btn-flat"
					data-dismiss="modal">Baixar</button>
			</div>
		</div>
	</div>
	<div class="md-overlay" style="z-index: 9999"></div>
</div>

<script src="<?php echo $this->config->base_url();?>web/js/jquery.min.js"></script>


<script type="text/javascript">
<!--
 function displayKeyCode(e) {
		if(e.keyCode == 13){
			document.getElementById("filter_form").submit();
		}		
 }
//-->

 function postdown(account_id){
	 var URL = "<?php echo $this->config->site_url('accounts/down'); ?>";
	 var valor = document.getElementById('set_valor').value;
	
	 $.post(URL,{id:account_id, value:valor},function(data,status){alert(status);});
 }

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
		document.getElementById('down').setAttribute("onclick","checkdown("+id_da_linha+")");
		document.getElementById('boleto').setAttribute("onclick", "set_boleto("+id_da_linha+")");
		document.getElementById('delete').setAttribute("href","<?php echo $this->config->site_url('accounts/delete');?>/"+id_da_linha);
		 		
	}
	

	function checkdown(id_da_linha){

		var URL = "<?php echo $this->config->site_url('accounts/set_down'); ?>";
		document.getElementById('falldown').setAttribute("style","color: red; visibility: hidden;");
		
		$.post(URL,{id:id_da_linha},function(data,status){	

		    	eval(data);
		    		
		    	var p = document.getElementById("plan_account");
		    	p.setAttribute("style",'color: red;');		    	
				p.setAttribute("value", info[0]);
				
				var t = document.getElementById("date");
				t.setAttribute("value", info[1]);					   

				var f = document.getElementById("favored");
				f.setAttribute("value", info[2]);	
				
				var v = document.getElementById("valor");
				v.setAttribute("value", info[3]);

				var sd = document.getElementById("set_data");
				sd.setAttribute("value", info[1]);
				
				var button = document.getElementById("btn_down");
				button.setAttribute("onclick", info[4]);
							    	
		    });
	    
	}


	function set_boleto(id_da_linha)
	{
		window.location = "<?php echo $this->config->site_url('boletos/account_create_boletos');?>/"+id_da_linha
	}
	
	function falldown(){
		document.getElementById('falldown').setAttribute("style","color: red;");
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