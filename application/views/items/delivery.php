<?php
$this->load->view("partial/header");

date_default_timezone_set('America/Sao_Paulo');
header('Content-Type: text/html; charset=iso-8859-1');
?>
<script type="text/javascript" src="instant/search.js"></script>

<script> 

    //arrow key navigation 
    $(document).keydown(function(e){ 

        //jump from search field to search results on keydown 
        if (e.keyCode == 40) {  
            $("#s").blur(); 
              return false; 
        } 

        //hide search results on ESC 
        if (e.keyCode == 27) {  
            $("#results").hide(); 
            $("#s").blur(); 
              return false; 
        } 

        //focus on search field on back arrow or backspace press 
        if (e.keyCode == 37 || e.keyCode == 8) {  
            $("#s").focus(); 
        } 

    }); 
    // 


 $(document).ready(function() { 

    //clear search field & change search text color 
    $("#s").focus(function() { 
        $("#s").css('color','#333333'); 
        var sv = $("#s").val(); //get current value of search field 
        if (sv == 'Search') { 
            $("#s").val(''); 
        } 
    }); 
    // 

    //post form on keydown or onclick, get results 
    $("#s").bind('keyup click', function() { 
        $.post("results.php", //post 
            $("#search").serialize(),  
                function(data){ 
                    //hide results if no more than 2 characters 
                    if (data == 'hide') { 
                        $('#results').hide(); 
                    } 

                    //show results if more than 2 characters 
                    if (data != 'hide') { 
                        $("#results").html(data); 
                        if (data) { 
                            $("#results").show(); 
                        } 
                    } 
            }); 
    }); 
    // 

    //hide results when clicked outside of search field 
    $("body").click(function() { 
        $("#results").hide(); 
    }); 
    // 

}); 


</script>

<link href="instant/style.css" rel="stylesheet" type="text/css" />



<div class="container-fluid" id="pcont">
	<div class="page-head">
		<h2>Pedido de Entrega</h2>
	</div>
	<div class="cl-mcont">
		<?php if (isset($manage_result)){echo $manage_result;}else{echo '';}?>
	<?php
error_reporting(E_ALL);
?>
	
			<div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="tab-container">

					<!------CONTROL TABS START------->
					<ul class="nav nav-tabs">
						<li class="active"><a href="#reg" data-toggle="tab"><i
								class="fa fa-plus"></i> Registrar Entrega</a></li>
						<li class=""><a href="#add" data-toggle="tab"><i class="fa fa-key"></i>
								Inserir Produtos</a></li>
					</ul>
					<!------CONTROL TABS END------->

					<div class="tab-content">

						<div class="tab-pane active cont" id="reg">
							<div class="col-md-12">
								<div class="header">
									<h3>Registro de Entrega</h3>
									<br />
									<?php
        echo form_open('items/save_entrada')?>
										<div class="form-group">
										<label class="col-sm-6">
												Produto/�tem entregue para:
												<?php
            echo form_dropdown('destiny', $funcionario, array(), 'class="select2" style="width:50%;"');
            ?>
											</label> <label class="col-sm-12"> Produto/�tem referente
											para: <textarea name="service" maxlength="500"
												placeholder="Servi�o/ordem referente..." rows="10" cols="55"
												style="width: 49%; resize: none;" class="form-control"
												required></textarea>
										</label>
										<div class="col-sm-12" style="inline: block;">
											<input type="submit" class="btn btn-primary"
												value="Cadastrar" />

										</div>
									</div>
									<?php echo form_close();?>
									</div>
							</div>
						</div>
						<div class="tab-pane cont" id="add">
							<div class="col-md-12">
								<div class="header">
									<h3>Inserir Produto</h3>
									<br />

									<div class="form-group" style="inline: block; width: 50%;">
											<?php echo form_open();?>
											<div class="input-group">
											<?php
        echo form_dropdown('produto', $item_produto, array(), 'class="select2"');
        ?>
							                  <span class="input-group-btn">
												<button class="btn btn-primary" type="submit">Inserir ></button>
											</span>
										</div>
							                  
										<?php echo form_close();?>
										</div>
									<label class="col-sm-12">
												<?php echo $manage_table;?>
											</label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<?php $this->load->view("partial/footer"); ?>
