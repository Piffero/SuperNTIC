<?php $this->load->view("partial/header"); ?>

<div class="page-aside tree">
	<div class="fixed nano nscroller">
		<div class="content">
			<div class="title">
				<h2>Produtos por Nº de Série</h2>
			</div>
			<ul class="nav nav-list treeview">
				<?php
    if (isset($lista)) {
        echo $lista;
    } else {
        echo '<li> Não há Produtos serializados cadastrados. </li>';
    }
    ?>
				
			</ul>
			<br> <br> <br> <br> <br>
		</div>
	</div>
</div>
<div class="container-fluid" id="pcont">
	<div class="cl-mcont">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">
				<div class="block-flat">
					<div class="header">
						<h3>
							<font style="color: dodgerblue;">Estoque</font>
						</h3>
					</div>
					<div class="row">
						<div id="estoque" class="col-md-12 col-lg-12 col-sm-12">
						
						<?php
    if (isset($manage_result)) {
        echo $manage_result;
    }
    echo $list_serie;
    ?> 
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
function deletar(e)
{
	var a = confirm("Você realmente deseja excluir este item?");
	if (a == true)
	{
		window.location.href="<?php echo site_url("stock_serie/delete")?>/<?php echo $id;?>x"+e;
	}
	else
	{
		return false;
	}
	
}

function relista(id)
{			
	 var URL = "<?php echo site_url('stock_serie/xmlrequest/');?>";			 
	 var x = document.getElementById("mySelect").value;
	 		
	 $.post(URL,{empresa:x, serie:id},function(data,status){				 
		 document.getElementById('estoque').innerHTML = data;
		 });
}
</script>
<?php $this->load->view("partial/footer"); ?>