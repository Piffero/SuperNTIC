<?php $this->load->view("partial/header"); ?>

	<div class="page-aside email">
			<div class="fixed nano nscroller">
				<div class="content">
					<div class="header">
						<button class="navbar-toggle" data-target=".mail-nav"
							data-toggle="collapse" type="button">
							<span class="fa fa-chevron-down"></span>
						</button>
						<h2 class="page-title">Gestor NFe</h2>
						<p class="description">Controle de Notas</p>
					</div>
					<div class="mail-nav collapse">
						<ul class="nav nav-pills nav-stacked ">
							<li class="active"><a href="#"><span
									class="label label-primary pull-right">6</span><i
									class="fa fa-inbox"></i> Entradas Processadas</a></li>
							<li><a href="#"><i class="fa fa-envelope"></i> Notas Enviadas</a></li>							
							<li><a href="#"><span
									class="label label-default pull-right">3</span><i
									class="fa fa-file-o"></i> Entrada Manual</a></li>
							<li><a href="#"><i class="fa fa-download"></i> Importação XML</a></li>
							<li><a href="#"><i class="fa fa-trash-o"></i> Notas Excluidas</a></li>
						</ul>

						<p class="title">Operações</p>
						
						<div class="compose">
							<a class="btn btn-flat btn-primary"><i class="fa fa-file"></i> Entrada Manual</a>
							<a class="btn btn-flat btn-primary"><i class="fa fa-download"></i> Importar NFE XML</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container-fluid" id="pcont">
			<div class="mail-inbox">
				<div class="head">
					<h3>
						Chave de Acesso NFe <span>(13 novas entradas)</span>
					</h3>
					<input type="text" class="form-control"
						placeholder="Buscar Nota Fiscal..." />
				</div>
				<div class="filters">
					<input id="check-all" type="checkbox" name="checkall" /> <span>Selecionar Todos</span>
					<div class="btn-group pull-right">
						<button class="btn btn-sm btn-flat btn-default" type="button">
							<i class="fa fa-angle-left"></i>
						</button>
						<button class="btn btn-sm btn-flat btn-default" type="button">
							<i class="fa fa-angle-right"></i>
						</button>
					</div>
					<div class="btn-group pull-right">
						<button data-toggle="dropdown"
							class="btn btn-sm btn-flat btn-default dropdown-toggle"
							type="button">
							Ordenar Por <span class="caret"></span>
						</button>
						<ul role="menu" class="dropdown-menu">
							<li><a href="#">Data</a></li>
							<li><a href="#">Fornecedor</a></li>
							<li><a href="#">Empresa</a></li>
							<li class="divider"></li>
							<li><a href="#">Operação</a></li>
						</ul>
					</div>

				</div>
				<div class="mails">
					<div class="item">
						<div>
							<input type="checkbox" name="c[]" />
						</div>
						<div>
							<span class="date pull-right"><i class="fa fa-paperclip"></i>
								20 Nov</span>
							<h4 class="from">Jeff Hanneman</h4>
							<p class="msg">Urgent - You forgot your keys in the class
								room, please come imediatly!</p>
						</div>
					</div>
					<div class="item">
						<div>
							<input type="checkbox" name="c[]" />
						</div>
						<div>
							<span class="date pull-right"><i class="fa fa-paperclip"></i>
								20 Nov</span>
							<h4 class="from">John Doe</h4>
							<p class="msg">Urgent - You forgot your keys in the class
								room, please come imediatly!</p>
						</div>
					</div>
					<div class="item">
						<div>
							<input type="checkbox" name="c[]" />
						</div>
						<div>
							<span class="date pull-right"><i class="fa fa-paperclip"></i>
								20 Nov</span>
							<h4 class="from">John Doe</h4>
							<p class="msg">Urgent - You forgot your keys in the class
								room, please come imediatly!</p>
						</div>
					</div>
					<div class="item">
						<div>
							<input type="checkbox" name="c[]" />
						</div>
						<div>
							<span class="date pull-right"><i class="fa fa-paperclip"></i>
								20 Nov</span>
							<h4 class="from">John Doe</h4>
							<p class="msg">Urgent - You forgot your keys in the class
								room, please come imediatly!</p>
						</div>
					</div>
					<div class="item">
						<div>
							<input type="checkbox" name="c[]" />
						</div>
						<div>
							<span class="date pull-right"><i class="fa fa-paperclip"></i>
								20 Nov</span>
							<h4 class="from">John Doe</h4>
							<p class="msg">Urgent - You forgot your keys in the class
								room, please come imediatly!</p>
						</div>
					</div>
					<div class="item">
						<div>
							<input type="checkbox" name="c[]" />
						</div>
						<div>
							<span class="date pull-right"><i class="fa fa-paperclip"></i>
								20 Nov</span>
							<h4 class="from">John Doe</h4>
							<p class="msg">Urgent - You forgot your keys in the class
								room, please come imediatly!</p>
						</div>
					</div>

				</div>
			</div>
		</div>
		
		
		<script type="text/javascript">
		 var cl = document.getElementById('cl-wrapper');
		 cl.setAttribute('class', 'fixed-menu sb-collapsed'); 
		 document.getElementById('sidebar-collapse').innerHTML = '<i class="fa fa-angle-right" style="color:#fff;"></i>';
	    </script>
<?php $this->load->view("partial/footer");?>