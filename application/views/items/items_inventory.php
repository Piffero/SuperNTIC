 <?php $this->load->view("partial/header"); ?>
<div class="cl-mcont" id="print">
	<div class="block-flat">
		<div class="header">
			<h3><?php date_default_timezone_set("Brazil/East");?>
					<span style="color: dodgerblue;">Inventário de Produtos</span> <small><span
					style="float: right; text-decoration: underline !important;"
					onclick="printDiv('change')"><a href="#">IMPRIMIR</a></span></small>
				<select id="set_enterprise" style="float: right; margin-right: 12px; font-size: 14px;"
					onchange="set_tabela(this.value);">
						<?php
    
    if (isset($enterprise)) {
        echo $enterprise;
    }
    ?>
					</select>
			</h3>

		</div>
		<div class="content">
				<?php if(isset($manage_result)){echo $manage_result;} ?>
				<div class="col-md-12 col-lg-12 col-sm-12" id="change">
				<h5>Razão <?php echo $empresa->razaosocial;?><span
						style="float: right;">CNPJ: 
				<?php
    $y = substr($empresa->ie, 0, 3) . '.' . substr($empresa->ie, 3, 3) . '.' . substr($empresa->ie, 6, 3);
    $x = substr($empresa->cnpj, 0, 2) . "." . substr($empresa->cnpj, 2, 3) . "." . substr($empresa->cnpj, 5, 3) . "/" . substr($empresa->cnpj, 8, 4) . "-" . substr($empresa->cnpj, 12, 2);
    echo $x;
    ?></span>
				</h5>
				<h5>INSC. Estadual:  <?php echo $y;?><span style="float: right;">Estoque existente em <?php echo date('d/m/Y');?></span>
				</h5>
				<table class="table no-border hover">
					<thead class="no-border">
						<tr>
							<th><strong>Descrição</strong></th>
							<th class="text-center"><strong>UN</strong></th>
							<th class="text-right"><strong>Qtde.</strong></th>
							<th class="text-right"><strong>Custo</strong></th>
							<th class="text-right"><strong>Custo Total</strong></th>
						</tr>
					</thead>
					<tbody class="no-border-y" id="size">
						<?php if (isset($table1)){echo $table1;}else{echo '<tr><td colspan="6">Não há produtos para serem mostrados</td></tr>';}?>
					</tbody>
					<tfoot class="no-border-y">
						<?php
    if (isset($TotalC) && ($TotalC != '')) {
        echo '<tr>
									<td colspan="2"><strong>TOTAL:</strong></td>
									<td class="text-right"><strong>' . $QTD . '</strong></td>
									<td class="text-right"><strong>' . money_format('%n', $TotalC) . '</strong></td>
   									<td class="text-right"><strong>' . money_format('%n', $Unitotal) . '</strong></td>
								</tr>';
    }
    // <td class="text-right"><strong>'.money_format('%n', $totaltotal).'</strong></td>
    ?>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo $this->config->base_url();?>web/js/jquery.min.js"></script>

<script type="text/javascript">
function printDiv(divID) {


    var URL = "<?php echo site_url("items_invent/save");?>";
    var pont = document.getElementById('set_enterprise').value;
    
    $.post(URL,{enterprise_id:pont},function(data){
    	//Get the HTML of div
        var divElements = document.getElementById(divID).innerHTML;
        //Get the HTML of whole page
        var oldPage = document.body.innerHTML;

        //Reset the page's HTML with div's HTML only
        document.body.innerHTML = '<html><head><title>NTIC</title><meta charset="utf-8"><style>#size > tr > td {font-size: 10px;}</style></head><body>'+divElements+'</body></html>';

          
        //Print Page
        window.print();

        //Restore orignal HTML
        document.body.innerHTML = oldPage;
        
    	alert(data);   
    });

	
    

  
}
						
function change_enterprise(e)
{
	location.href = '<?php echo site_url("items_invent/index")?>/'+e.value;
}

function set_tabela(enterprise_id)
{
	var xmlhttp;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.open("GET","<?php echo site_url("items_invent/get_tabela");?>/"+enterprise_id, false);
	xmlhttp.send();
	xmlDoc=xmlhttp.responseText;
	document.getElementById('change').innerHTML = xmlDoc.trim(); 
} 
</script>

<?php $this->load->view("partial/footer"); ?>