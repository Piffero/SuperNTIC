	<?php
$this->load->view("partial/header");

?>

<div class="page-aside tree">
	<div class="fixed nano nscroller">
		<div class="content">
			<div class="title">
				<h2>Produtos por Categoria</h2>
			</div>
			<ul class="nav nav-list treeview">
					<?php
    
    if (isset($cat)) {
        echo $cat;
    } else {
        echo '<li> Não há categorias ou produtos cadastrados. </li>';
    }
    ?>
				</ul>
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
								<?php echo $lista;?>	
							</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script
	src="<?php echo $this->config->base_url();?>web/js/jquery.min.js"></script>

<script>
			
		function relista(categoria)
		{			
			 var URL = "<?php echo site_url('stock_cat/xmlrequest/');?>";			 
			 var x = document.getElementById("mySelect").value;
			 		
			 $.post(URL,{empresa:x, cat:categoria},function(data,status){				 
				 document.getElementById('estoque').innerHTML = data;
				 });
		}

		
	</script>

<?php $this->load->view("partial/footer"); ?>