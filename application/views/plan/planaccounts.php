<?php $this->load->view("partial/header");?>

<div class="page-aside tree">
	<div class="fixed nano nscroller">
		<div class="content">
			<div class="title">
				<h3>Plano de Contas</h3>
			</div>
          	<?php echo $treeview;?>
          	<br> <br> <br> <br>
		</div>
	</div>
</div>



<div class="container-fluid" id="pcont">
	<div class="cl-mcont">
	
	   <div class="spacer spacer-bottom text-right">	   
            <div class="btn-group">
                <button id="inputBtn1" class="btn btn-default md-trigger" data-modal="form-primary" type="button" style="display:inherit;"><i class="fa fa-plus"></i> Categoria</button>
                <button id="inputBtn2" class="btn btn-default md-trigger" data-modal="form-secundary" type="button" style="display:none;"><i class="fa fa-bars"></i> Plano Contas</button>
            </div>                 
        </div>
        
        <div id="alert" class="col-md-12 col-sm-12 col-lg-12">
        
        </div>
                                  
		<div class="block-flat">
		      <div class="header"><h3>Registro de Categoria</h3></div>
		      
		      <div class="content">
		          <div class="row">
		             <div class="col-md-4 col-lg-3 col-sm-4">
    		             <label>Código</label>
    		             <input id="inputCode" class="form-control" type="text" placeholder="Código" data-mask="0.00.##.##.##.##" readonly="readonly"></input>
    		         </div>
    		         <div class="col-md-7 col-lg-6 col-sm-7">
    		             <label>Descrição</label>
    		             <input id="inputText" class="form-control" type="text" placeholder="Descrição" readonly="readonly"></input>
    		         </div> 
    		         <div class="col-md-3 col-lg-3 col-sm-3">
    		              <label>Definir como:</label><br>
    		              <label class="checkbox-inline">
    		                  <input id="inputBox" type="checkbox" name="check1" readonly="readonly" value="1" style="position: absolute; opacity: 1;"></input>
    		                  Categoria
    		              </label>  
    		         </div>
    		          
		          </div>		          
		      </div>
		</div>
		
		 
			 <div class="md-modal colored-header custom-width md-effect-9" id="form-primary" style="z-index: 99999999">
				<div class="md-content">
					<div class="modal-header">
						<h3>Adicionar Categoria</h3>
						<button type="button" class="close md-close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body form">
						<div class="form-group">
							<span id="category">Criar como: <i id="insertPlan">Categoria Principal</i></span>    							
						</div>
						<div class="form-group">
						    <label>Nome da Categoria:</label>
							<input id="categoria" placeholder="Ex.: Aluguel de caixas de madeira" type="text" class="form-control">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default md-close" data-dismiss="modal">Cancelar</button>
						<button id="btnCategoria" type="button" class="btn btn-primary btn-flat" onclick="save(1)">Criar Categoria</button>
					</div>
				</div>
			</div>
			
			
			
			<div class="md-modal colored-header custom-width md-effect-9" id="form-secundary" style="z-index: 99999999">
				<div class="md-content">
					<div class="modal-header">
						<h3>Adicionar Plano de Contas</h3>
						<button type="button" class="close md-close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body form">
						<div class="form-group">
							<span id="planocontas">Criar <i>Plano de Contas</i></span>    							
						</div>
						<div class="form-group">
						    <label>Nome do Plano de Conta:</label>
							<input id="plano" placeholder="Ex.: Aluguel de caixas de madeira" type="text" class="form-control">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default md-close" data-dismiss="modal">Cancelar</button>
						<button id="btnPlanoConta" type="button" class="btn btn-primary btn-flat" onclick="save(2)">Criar Categoria</button>
					</div>
				</div>
			</div>
			
			<div class="md-overlay" style="z-index: 999999"></div>
	</div>
</div>




<script src="<?php echo $this->config->base_url();?>web/js/jquery.min.js"></script>

<script type="text/javascript">
var cl = document.getElementById('cl-wrapper');
	cl.setAttribute('class', 'fixed-menu sb-collapsed'); 
	document.getElementById('sidebar-collapse').innerHTML = '<i class="fa fa-angle-right" style="color:#fff;"></i>';


function getCodePlan(codePlan, textPlan, typePlan)
{
	window.document.getElementById('inputCode').value = codePlan;
	window.document.getElementById('inputText').value = textPlan;
	

	if(typePlan == 'S'){
		window.document.getElementById('inputBox').setAttribute('checked', 'checked');
	}else{
		window.document.getElementById('inputBox').removeAttribute('checked');
	};

	window.document.getElementById('insertPlan').innerHTML = 'Subcategoria de '+textPlan;

	var str = codePlan;
	var retorno = str.split('.');

	
    switch (retorno.length) {
    case 1:
        document.getElementById('inputBtn1').setAttribute('style', 'display:inherit'); // Categoria -- open                
        document.getElementById('inputBtn2').setAttribute('style', 'display:none');   // Plano de conta -- close                   
    break;
    case 2:
    	document.getElementById('inputBtn1').setAttribute('style', 'display:inherit'); // Categoria -- open
    	document.getElementById('inputBtn2').setAttribute('style', 'display:none;');   // Plano de conta -- close  
    break;        
	case 3:
		document.getElementById('inputBtn1').setAttribute('style', 'display:inherit'); // Categoria -- open
		document.getElementById('inputBtn2').setAttribute('style', 'display:inherit;');// Plano de conta -- open
	break;
	case 4:
		document.getElementById('inputBtn1').setAttribute('style', 'display:inherit'); // Categoria -- open
		document.getElementById('inputBtn2').setAttribute('style', 'display:inherit;');// Plano de conta -- open		       
	break;
	case 5:
		document.getElementById('inputBtn1').setAttribute('style', 'display:none');    // Categoria -- close
		document.getElementById('inputBtn2').setAttribute('style', 'display:inherit;');// Plano de conta -- open
	break;
	}


	
   
}
	
function save(op)
{
	var url = "<?php echo site_url('planaccounts/save');?>";
	var codefather = document.getElementById('inputCode').value;
	
	if(op == 1){
		category = document.getElementById('categoria').value;		
    	$.post(url,{codigopai:codefather, descricao:category, tipo:op},function(data){
    		document.getElementById('alert').innerHTML = data;
    		window.location.reload(true);
    		
    	});
	}

	if(op == 2){
		planaccount = document.getElementById('plano').value;
		$.post(url, {codigopai:codefather, descricao:planaccount, tipo:op},function(data){
			document.getElementById('alert').innerHTML = data;
			window.location.reload(true);
		});
	}
	
}



</script>

<?php $this->load->view("partial/footer"); ?>
