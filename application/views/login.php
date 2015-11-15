<?php ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description"
	content="Núcleo de Tecnologia da Informação e Comunicação - NTIC">
<meta name="author"
	content="Thiago Piffero Rangel & Lucas Marques Dutra">

<link rel="shortcut icon"
	href="<?php echo $this->config->base_url();?>web/images/favicon.png">

<title><?php echo $this->config->item('company').' -- ' ?>NTIC Nucleo de Tecnologia da Informação e Comunicação</title>
<link
	href="<?php echo $this->config->base_url();?>application/fonts/opensans.css"
	rel="stylesheet" type="text/css">
<link
	href="<?php echo $this->config->base_url();?>application/fonts/raleway.css"
	rel="stylesheet" type="text/css">
<link
	href='<?php echo $this->config->base_url();?>application/fonts/opensanscondensed.css'
	rel='stylesheet' type='text/css'>

<!-- Bootstrap core CSS -->
<link
	href="<?php echo $this->config->base_url();?>web/js/bootstrap/dist/css/bootstrap.css"
	rel="stylesheet">

<link rel="stylesheet"
	href="<?php echo $this->config->base_url();?>web/fonts/font-awesome-4/css/font-awesome.min.css">

<!-- Custom styles for this template -->
<link href="<?php echo $this->config->base_url();?>web/css/style.css"
	rel="stylesheet" />

</head>

<body class="texture">

	<div id="cl-wrapper" class="login-container">

		<div class="middle-login">
			<div class="block-flat">
				<div class="header">
					<h3 class="text-center">
						<img class="logo-img"
							src="<?php echo $this->config->base_url();?>web/images/logo.png"
							alt="logo" />NTIC
					</h3>
				</div>
				<div>
				<?php echo form_open('login', 'class="form-horizontal" style="margin-bottom: 0px !important;"')?>
					<div class="content">
						<h4 class="title">Login de Acesso</h4>
						<?php if(isset($result_menager)){echo $result_menager;}?>
							<div class="form-group">
							<div class="col-sm-12">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-user"></i></span>
										<?php
        
        echo form_input(array(
            'id' => 'user',
            'name' => 'username',
            'type' => 'name',
            'class' => 'form-control',
            
            // 'autocomplete'=>'off',
            'value' => set_value('username')
        ));
        ?> 
									</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-lock"></i></span>
										<?php
        
        echo form_password(array(
            'name' => 'password',
            'type' => 'name',
            'class' => 'form-control',
            
            // 'autocomplete'=>'off',
            'value' => set_value('password')
        ));
        ?>
									</div>
							</div>
						</div>

					</div>
					<div class="foot">
						<?php
    
    echo form_button(array(
        'name' => 'loginButton',
        'class' => 'btn btn-primary btn-flat md-trigger md-close',
        'data-modal' => 'md-superScaled',
        'data-dismiss' => 'modal'
    ), 'Entrar');
    ?>
					</div>
					
				<?php echo form_close(); ?>	
			</div>
			</div>
			<div class="text-center out-links">
				<a href="http://www.meganet.net.br" target="_blank">&copy; 2014
					MegaNet</a>
			</div>
		</div>

	</div>


	<script type="text/javascript">
	document.getElementById('user').focus();
</script>

	<script src="<?php echo $this->config->base_url();?>web/js/jquery.js"></script>
	<script type="text/javascript"
		src="<?php echo $this->config->base_url();?>web/js/behaviour/general.js"></script>


	<!-- Bootstrap core JavaScript
================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->

	<script
		src="<?php echo $this->config->base_url();?>web/js/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>