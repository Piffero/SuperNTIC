<?php
header('Content-Type: text/html; charset=UTF-8');
?>
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
<link
	href="<?php echo $this->config->base_url();?>web/js/bootstrap/dist/css/bootstrap.css"
	rel="stylesheet">
<link rel="stylesheet" type="text/css"
	href="<?php echo $this->config->base_url();?>web/js/bootstrap.datetimepicker/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" type="text/css"
	href="<?php echo $this->config->base_url();?>web/js/jquery.select2/select2.css">
<link rel="stylesheet" type="text/css"
	href="<?php echo $this->config->base_url();?>web/js/bootstrap.slider/css/slider.css">

<link rel="stylesheet"
	href="<?php echo $this->config->base_url();?>web/fonts/font-awesome-4/css/font-awesome.min.css">
<link rel="stylesheet"
	href="<?php echo $this->config->base_url();?>web/css/pygments.css">
<link rel="stylesheet" type="text/css"
	href="<?php echo $this->config->base_url();?>web/js/jquery.nanoscroller/nanoscroller.css">
<link rel="stylesheet" type="text/css"
	href="<?php echo $this->config->base_url();?>web/js/bootstrap.switch/bootstrap-switch.css">

<link rel="stylesheet" type="text/css"
	href="<?php echo $this->config->base_url();?>web/js/jquery.niftymodals/css/component.css">
<link rel="stylesheet" type="text/css"
	href="<?php echo $this->config->base_url();?>web/js/jquery.timeline/css/component.css">
<link href="<?php echo $this->config->base_url();?>web/css/style.css"
	rel="stylesheet">


</head>
<body>
	<div id="head-nav" class="navbar navbar-default navbar-fixed-top">
		<div class="container-fluid">

			<div class="navbar-header">
				<button class="navbar-toggle" data-target=".navbar-collapse"
					data-toggle="collapse" type="button">
					<span class="fa fa-gear"> </span>
				</button>
				<a class="navbar-brand" href="#"><span>NTIC</span></a>
			</div>

			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">

					<li class="active"><a
						href="<?php echo $this->config->site_url('home');?>">Home</a></li>

					<li><a href="#"
						onclick="window.open('http://179.107.49.1:1517/mibew/client.php?locale=pt-pt&amp;style=silver','NTIC Suporte','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=400,height=440');"><i
							class="fa fa-headphones"></i> Help Desk</a></li>

					<li class="dropdown"><a href="#" class="dropdown-toggle"
						data-toggle="dropdown"><i class="fa fa-cogs"></i> NTIC</a>
						<ul class="dropdown-menu">
							<li><a href="#">Atualiza&#231;&#227;o NTIC</a></li>
							<li><a href="#">Efetuar Backup do Sistema</a></li>
							<li><a href="#"
								onclick="window.open('<?php echo $this->config->site_url("pdv");?>','NTIC','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,addressbars=no,width=700,height=30,top=130,left=150');">Enviar
									dados para Monitor</a></li>
							<li class="divider"></li>
							<li class="dropdown-submenu"><a href="#">Modulos Adicionais</a>
								<ul class="dropdown-menu">
									<li><a
										href="<?php echo $this->config->site_url('employees');?>">Cadastro
											Funcion&#225;rios</a></li>
									<li><a
										href="<?php echo $this->config->site_url('enterprises');?>">Cadastro
											Empresas</a></li>
											
									<li class="divider"></li>
									<li><a 
									   href="<?php echo $this->config->site_url('nfe');?>">Gestão Notas Fiscais</a></li>
								</ul>
						    </li>
							<li class="divider"></li>
							<li><?php echo anchor("settings",'Defini&#231;&#245;es e Permiss&#245;es'); ?></li>
						</ul></li>
				</ul>

				<ul class="nav navbar-nav navbar-right user-nav">
					<li class="dropdown profile_menu"><a class="dropdown-toggle"
						data-toggle="dropdown" href="#"> <img
							src="<?php echo $this->config->base_url()?>web/images/avatars/avatar1.jpg"
							alt="Avatar"></img><?php echo $user_info->first_name.' '.$user_info->last_name; ?><b
							class="caret"></b>
					</a>
						<ul class="dropdown-menu">
							<li><a href="#">Minha Conta</a></li>
							<li class="divider"></li>
							<li><?php echo anchor("home/logout",'Sair do Sistema'); ?></li>
						</ul></li>
				</ul>

			</div>
			<!-- /.nav-collapse -->
		</div>
	</div>

	<div id="cl-wrapper" class="fixed-menu">
		<div class="cl-sidebar">
			<div class="cl-toggle">
				<i class="fa fa-bars"></i>
			</div>

			<div class="cl-navblock">
				<div class="menu-space">
					<div class="content">
						<div class="side-user">
							<div class="avatar">
								<img alt="Avatar"
									src="<?php echo $this->config->base_url()?>web/images/avatars/avatar1_50.jpg"></img>
							</div>
							<div class="info">
								<a href='#'><?php echo $user_info->first_name; ?></a> <img
									alt="Status"
									src="<?php echo $this->config->base_url();?>web/images/state_online.png"></img>
								<span>Online</span>
							</div>
						</div>

						<ul class="cl-vnavigation">
							<li><a href="<?php echo $this->config->site_url('home');?>"><i
									class="fa fa-home"></i><span>Dashboard</span></a></li>
							<li><a href="#"><i class="fa fa-paperclip"></i><span>Cadastros</span></a>
								<ul class="sub-menu">
									<li><a
										href="<?php echo $this->config->site_url('customers');?>">Clientes</a></li>
									<li><a
										href="<?php echo $this->config->site_url('suppliers');?>">Fornecedores</a></li>

									<li><a href="<?php echo $this->config->site_url('items');?>">Produtos</a></li>
									<br>
									<li><a
										href="<?php echo $this->config->site_url('departments');?>">Departamentos</a></li>
									<li><a
										href="<?php echo $this->config->site_url('categories');?>">Categorias
											de Produtos</a></li>
									<li><a href="<?php echo $this->config->site_url('types');?>">Tipo
											de Produtos</a></li>
									<!-- 
								<br>
								<li><a href="<?php echo $this->config->site_url('reports/view_customers');?>">Relat&#243;rios</a></li>
								-->
								</ul></li>
							<li><a href="#"><i class="fa fa-money"></i><span>Compras</span></a>
								<ul class="sub-menu">
									<li><a href="<?php echo $this->config->site_url('pclista');?>">Pedido
											de Compra</a></li>
									<li><a href="<?php echo $this->config->site_url('order_pc');?>">Ordem
											de Compra</a></li>
									<!-- 
    	    					<br>
    	    					<li><a href="<?php echo $this->config->site_url('#');?>">Relat&#243;rio</a></li>
    	    					-->
								</ul></li>
							<li><a href="#"><i class="fa fa-shopping-cart"></i><span>Vendas</span></a>
								<ul class="sub-menu">
									<li><a href="<?php echo $this->config->site_url('sales');?>">Pedido
											de Venda</a></li>
									<li><a
										href="<?php echo $this->config->site_url('sales_lista');?>">Lista
											de Vendas</a></li>
									<br>
									<li><a href="<?php echo $this->config->site_url('sales_teste');?>">Aparelhos em Teste</a></li>									
									<!-- 
   					  			<br>
	   				  			<li><a href="#">Social Network</a></li>
	   				  			-->
								</ul></li>
							<li><a href="#"><i class="fa fa-bug"></i><span>Ordem de
										Servi&#231;o</span></a>
								<ul class="sub-menu">
									<li><a href="<?php echo $this->config->site_url('os');?>">Nova
											Ordem de Servi&#231;o</a></li>
									<li><a href="<?php echo $this->config->site_url('oslista');?>">Lista
											de Ordens de Servi&#231;os</a></li>
									<br>
									<li><a
										href="<?php echo $this->config->site_url('tecoslista');?>">Assist&#234;ncia
											Tecnica</a></li>
									<br>
									<li><a
										href="<?php echo $this->config->site_url('oshistory');?>">Hist&#243;rico</a></li>
									<li><a href="<?php echo $this->config->site_url('os/input');?>">Entradas</a></li>
								</ul></li>
							<li><a href="#"><i class="fa fa-stethoscope"></i><span>Agendamento</span></a>
								<ul class="sub-menu">
									<li><a
										href="<?php echo $this->config->site_url('appointments/append');?>">Novo
											Atendimento</a></li>
									<li><a
										href="<?php echo $this->config->site_url('appointments');?>">Lista
											de Atendimentos</a></li>
									<li><a
										href="<?php echo $this->config->site_url('calendars');?>">Calendario
											de Atendimento</a></li>
									<br>
									<li><a href="<?php echo $this->config->site_url('campanha');?>">Programa
											Acompanhamento</a></li>
								</ul></li>

							<li><a href="#"><i class="fa fa-usd"></i><span>Financerio</span></a>
								<ul class="sub-menu">
									<li><a href="<?php echo $this->config->site_url('accounts');?>">Controle
											de Contas</a></li>
									<li><a href="<?php echo $this->config->site_url('boletos');?>">Controle
											de Boletos</a></li>
									<!-- <li><a href="#">Planejamento</a></li>  -->
									<br>
									<li><a href="<?php echo $this->config->site_url('banks');?>">Registro
											de Bancos</a></li>
									<li><a href="<?php echo $this->config->site_url('methods');?>">Formas
											de Pagamento</a></li>
									<li><a
										href="<?php echo $this->config->site_url('planaccounts');?>">Plano
											de Contas</a></li>
									<!-- 
    							<br>    							
    							<li><a href="#">Relat&#243;rios</a></li>
    							 -->
								</ul></li>
							<li><a href="#"><i class="fa fa-dropbox"></i><span>Estoque</span></a>
								<ul class="sub-menu">
									<li><a
										href="<?php echo $this->config->site_url('stock_cat');?>">Produtos
											por Categoria</a></li>
									<li><a
										href="<?php echo $this->config->site_url('stock_serie');?>">Produtos
											por Série</a></li>
									<li><a
										href="<?php echo $this->config->site_url('items_invent');?>">Inventário
											de Produtos</a></li>
								</ul></li>
							<li><a href="#"><i class="fa fa-envelope nav-icon"></i><span>Email
										Marketing</span></a>
								<ul class="sub-menu">
									<li><a href="#">Inbox</a></li>
								</ul></li>
						</ul>
						<div class="text-right collapse-button" style="padding: 7px 9px;">
							<button id="sidebar-collapse" class="btn btn-default" style="">
								<i style="color: #fff;" class="fa fa-angle-left"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>