<?php $this->load->view("partial/header"); ?>
<div class="page-aside tree">
	<div class="fixed nano nscroller">
		<div class="content">
			<div class="title">
				<h2>Defini&#231;&#245;es</h2>
			</div>
			<ul class="nav nav-list treeview">
				<li><?php echo anchor("settings/permissions",'<i class="fa fa-folder-open-o"></i> Permiss&#245;es'); ?></li>
			</ul>
		</div>
	</div>
</div>

<div class="container-fluid" id="pcont">
	<div class="cl-mcont">

		<div class="container"
			style="background: none repeat scroll 0% 0% #FFF;">

			<div class="page-header text-info"> &nbsp; &nbsp; Lista de Usu&#225;rios</div>

			<div class="row">
		
    										
			<?php

echo form_open('settings/search_user', array(
    'id' => 'employees_form',
    'style' => 'border-radius: 0px;'
));
?>	     
		
		
			<label class="col-sm-3">Usu&#225;rios do Sistema</label>
				<div class="col-sm-8 input-group">      			
    			<?php echo form_dropdown('user_id', $employees_user, array(),'class="form-control" autofocus="autofocus"');?>
    			<label class="input-group-btn">
						<button class="btn btn-primary" type="submit">Listar!</button>
					</label>

				</div>
			
			<?php echo form_close();?>
			
			</div>
		</div>
		<br>
    	
    	<?php if(isset($user_id)){ ?>
    	
    	<?php
        
        echo form_open('settings/save_permissions/' . $user_id, array(
            'id' => 'permissions_form',
            'style' => 'border-radius: 0px;'
        ));
        ?>	
    	
    		<div class="container"
			style="background: none repeat scroll 0% 0% #FFF;">
			<div class="form-group">
				<div class="page-header text-info">
					&nbsp; &nbsp; As permiss&#245;es e Acesso do Usu&#225;rio <font
						color="red"><?php echo $user_name[$user_id]?></font>
				</div>
				<p>Marque as caixas abaixo para permitir o acesso aos m&#243;dulos</p>
				<ul id="permission_list" class="list-unstyled">
					<!-- Permiss�o para Logar no Sistema -->
					<li><input type="checkbox" name="permissions[]" value="home"
						class="module_checkboxes "
						<?php if(isset($permition['home'])){if($permition['home'] == $user_id){echo 'checked';}}?> />
						<Label class="text-success">Home:</Label> <label
						class="text-label">Logar no Sistema</label></li>
					<br>
					<!-- Permissão para Cadastro de Clientes e Ações -->
					<li><input type="checkbox" name="permissions[]" value="customers"
						class="module_checkboxes "
						<?php if(isset($permition['customers'])){if($permition['customers'] == $user_id){echo 'checked';}}?> />
						<label class="text-success">Clientes:</label> <label
						class="text-label">Acesso ao Modulo Clientes</label>
						<ul>
							<li><input type="checkbox" name="permissions_actions[]"
								value="customers|add_update"
								<?php if(isset($permiting_action_add_update['customers'])){if($permiting_action_add_update['customers'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Adicionar e Atualizar</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="customers|Delete"
								<?php if(isset($permiting_action_delete['customers'])){if($permiting_action_delete['customers'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Deletar</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="customers|search"
								<?php if(isset($permiting_action_search['customers'])){if($permiting_action_search['customers'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Listar Clientes</label></li>
						</ul></li>
					<br>

					<!-- Permiss�o para Cadastro de Fornecedor e A��es -->
					<li><input type="checkbox" name="permissions[]" value="suppliers"
						class="module_checkboxes "
						<?php if(isset($permition['suppliers'])){if($permition['suppliers'] == $user_id){echo 'checked';}}?> />
						<label class="text-success">Fornecedores:</label> <label
						class="text-label">Acesso ao Modulo Fornecedores</label>
						<ul>
							<li><input type="checkbox" name="permissions_actions[]"
								value="suppliers|add_update"
								<?php if(isset($permiting_action_add_update['suppliers'])){if($permiting_action_add_update['suppliers'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Adicionar e Atualizar</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="suppliers|Delete"
								<?php if(isset($permiting_action_delete['suppliers'])){if($permiting_action_delete['suppliers'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Deletar</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="suppliers|search"
								<?php if(isset($permiting_action_search['suppliers'])){if($permiting_action_search['suppliers'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Listar Fornecedores</label></li>
						</ul></li>
					<br>


					<!-- Permiss�o para Cadastro de Funcionarios e A��es -->
					<li><input type="checkbox" name="permissions[]" value="employees"
						class="module_checkboxes "
						<?php if(isset($permition['employees'])){if($permition['employees'] == $user_id){echo 'checked';}}?> />
						<label class="text-success">Funcionarios:</label> <label
						class="text-label">Acesso ao Modulo Funcionarios</label>
						<ul>
							<li><input type="checkbox" name="permissions_actions[]"
								value="employees|add_update"
								<?php if(isset($permiting_action_add_update['employees'])){if($permiting_action_add_update['employees'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Adicionar e Atualizar</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="employees|Delete"
								<?php if(isset($permiting_action_delete['employees'])){if($permiting_action_delete['employees'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Deletar</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="employees|search"
								<?php if(isset($permiting_action_search['employees'])){if($permiting_action_search['employees'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Listar Funcionarios</label></li>
						</ul></li>
					<br>

					<!-- Permissão para Cadastro de Produtos e A��es -->
					<li><input type="checkbox" name="permissions[]" value="items"
						class="module_checkboxes "
						<?php if(isset($permition['items'])){if($permition['items'] == $user_id){echo 'checked';}}?> />
						<label class="text-success">Produtos:</label> <label
						class="text-label">Acesso ao Modulo Produtos</label>
						<ul>
							<li><input type="checkbox" name="permissions_actions[]"
								value="items|add_update"
								<?php if(isset($permiting_action_add_update['items'])){if($permiting_action_add_update['items'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Adicionar e Atualizar</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="items|Delete"
								<?php if(isset($permiting_action_delete['items'])){if($permiting_action_delete['items'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Deletar</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="items|search"
								<?php if(isset($permiting_action_search['items'])){if($permiting_action_search['items'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Listar Produtos</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="items|see_cost_price"
								<?php if(isset($permition['items'])){if($permition['items'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Ver o pre&#231;o de custo</label></li>
						</ul></li>
					<br>

					<!-- Divisor -->
					<hr>
					<br>


					<!-- Permissão para Cadastro de Departamentos e Ações -->
					<li><input type="checkbox" name="permissions[]" value="departments"
						class="module_checkboxes "
						<?php if(isset($permition['departments'])){if($permition['departments'] == $user_id){echo 'checked';}}?> />
						<label class="text-success">Departamentos:</label> <label
						class="text-label">Acesso ao Modulo Departamentos</label>
						<ul>
							<li><input type="checkbox" name="permissions_actions[]"
								value="departments|add_update"
								<?php if(isset($permiting_action_add_update['departments'])){if($permiting_action_add_update['departments'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Adicionar e Atualizar</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="departments|Delete"
								<?php if(isset($permiting_action_delete['departments'])){if($permiting_action_delete['departments'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Deletar</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="departments|search"
								<?php if(isset($permiting_action_search['departments'])){if($permiting_action_search['departments'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Listar Departamentos</label></li>
						</ul></li>
					<br>


					<!-- Permissão para Cadastro de Categoria de Produtos e Ações -->
					<li><input type="checkbox" name="permissions[]" value="categories"
						class="module_checkboxes "
						<?php if(isset($permition['categories'])){if($permition['categories'] == $user_id){echo 'checked';}}?> />
						<label class="text-success">categorias:</label> <label
						class="text-label">Acesso ao Modulo Categorias</label>
						<ul>
							<li><input type="checkbox" name="permissions_actions[]"
								value="categories|add_update"
								<?php if(isset($permiting_action_add_update['categories'])){if($permiting_action_add_update['categories'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Adicionar e Atualizar</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="categories|Delete"
								<?php if(isset($permiting_action_delete['categories'])){if($permiting_action_delete['categories'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Deletar</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="categories|search"
								<?php if(isset($permiting_action_search['categories'])){if($permiting_action_search['categories'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Listar Categorias</label></li>
						</ul></li>
					<br>


					<!-- Permissão para Cadastro de Categoria de Produtos e Ações -->
					<li><input type="checkbox" name="permissions[]" value="types"
						class="module_checkboxes "
						<?php if(isset($permition['types'])){if($permition['types'] == $user_id){echo 'checked';}}?> />
						<label class="text-success">Tipo de Produto:</label> <label
						class="text-label">Acesso ao Cadastro Tipo de Produtos </label>
						<ul>
							<li><input type="checkbox" name="permissions_actions[]"
								value="types|add_update"
								<?php if(isset($permiting_action_add_update['types'])){if($permiting_action_add_update['types'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Adicionar e Atualizar</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="types|Delete"
								<?php if(isset($permiting_action_delete['types'])){if($permiting_action_delete['types'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Deletar</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="types|search"
								<?php if(isset($permiting_action_search['types'])){if($permiting_action_search['types'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Listar Tipos de Produtos</label></li>
						</ul></li>
					<br>

					<!-- Divisor -->
					<hr>
					<br>


					<!-- Permissão para Modulo de Ordem de Servico e Ações -->
					<li><input type="checkbox" name="permissions[]" value="os"
						class="module_checkboxes "
						<?php if(isset($permition['os'])){if($permition['os'] == $user_id){echo 'checked';}}?> />
						<label class="text-success">Ordem de Servi&#231;o:</label> <label
						class="text-label">Acesso ao Modulo Ordem de Servi&#231;o</label>
						<ul>
							<li><input type="checkbox" name="permissions_actions[]"
								value="os|openos"
								<?php if(isset($permiting_action_openos['os'])){if($permiting_action_openos['os'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Adicionar Ordem de Servi&#231;o</label>
							</li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="os|listos"
								<?php if(isset($permiting_action_listos['os'])){if($permiting_action_listos['os'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Listar Ordem de Servi&#231;o</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="os|tecos"
								<?php if(isset($permiting_action_tecos['os'])){if($permiting_action_tecos['os'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Assistencia Tecnica</label></li>
						</ul></li>
					<br>

					<!-- Divisor -->
					<hr>
					<br>

					<li><input type="checkbox" name="permissions[]" value="settings"
						class="module_checkboxes "
						<?php if(isset($permition['settings'])){if($permition['settings'] == $user_id){echo 'checked';}}?> />
						<label class="text-success">Configurações:</label> <label
						class="text-label">Sistema de Configura&#231;&#245;es,
							Matriz/Filial e Permiss&#245;es</label></li>
					<br>
					<li><input type="checkbox" name="permissions[]"
						value="appointments" class="module_checkboxes "
						<?php if(isset($permition['appointments'])){if($permition['appointments'] == $user_id){echo 'checked';}}?> />
						<label class="text-success">Agendamento:</label> <label
						class="text-label">Acesso ao Modulo Agendamento</label>
						<ul>
							<li><input type="checkbox" name="permissions_actions[]"
								value="appointments|add_update"
								<?php if(isset($permiting_action_add_update['appointments'])){if($permiting_action_add_update['appointments'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Adicionar e Atualizar</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="appointments|Delete"
								<?php if(isset($permiting_action_delete['appointments'])){if($permiting_action_delete['appointments'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Deletar</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="appointments|search"
								<?php if(isset($permiting_action_search['appointments'])){if($permiting_action_search['appointments'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Listar Atendimentos</label></li>
						</ul></li>
					<br>

					<li><input type="checkbox" name="permissions[]" value="calendars"
						class="module_checkboxes "
						<?php if(isset($permition['calendars'])){if($permition['calendars'] == $user_id){echo 'checked';}}?> />
						<label class="text-success">Calendario:</label> <label
						class="text-label">Acesso ao Calendario de Atendimento</label></li>

					<!-- Divisor -->
					<hr>
					<br>
					<li><input type="checkbox" name="permissions[]" value="sales"
						class="module_checkboxes "
						<?php if(isset($permition['sales'])){if($permition['sales'] == $user_id){echo 'checked';}}?> />
						<label class="text-success">Vendas:</label> <label
						class="text-label">Processar vendas e retornos</label>
						<ul>
							<li><input type="checkbox" name="permissions_actions[]"
								value="sales|add_update"
								<?php if(isset($permition['sales'])){if($permition['sales'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Efetuar Venda</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="sales|edit_sale_price"
								<?php if(isset($permition['sales'])){if($permition['sales'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Editar Pre&#231;o de venda</label></li>
							<li><input type="checkbox" name="permissions[]"
								value="sales_lista"
								<?php if(isset($permition['sales_lista'])){if($permition['sales_lista'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Listar Vendas Salvas</label></li>
							<li><input type="checkbox" name="permissions[]" value="nfe"
								<?php if(isset($permition['nfe'])){if($permition['nfe'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">NFe</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="sales|give_discount"
								<?php if(isset($permition['sales'])){if($permition['sales'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Dar Desconto</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="sales|Delete_suspended_sale"
								<?php if(isset($permition['sales'])){if($permition['sales'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Deletar venda suspensa</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="sales|Delete"
								<?php if(isset($permition['sales'])){if($permition['sales'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Deletar Venda</label></li>
						</ul></li>
					<br>

					<!-- Divisor -->
					<hr>
					<br>
					<li><input type="checkbox" name="permissions[]" value="purchases"
						class="module_checkboxes"
						<?php if(isset($permition['purchases'])){if($permition['purchases'] == $user_id){echo 'checked';}}?> />
						<label class="text-success">Compras:</label> <label
						class="text-label">Pedido de Compras</label> <br>
						<ul>
							<li><input type="checkbox" name="permissions_actions[]"
								value="purchases|add_manager"
								<?php if(isset($permition['purchases'])){if($permition['purchases'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Efetuar Pedido de Produtos para Venda</label>
							</li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="purchases|delete_manager"
								<?php if(isset($permition['purchases'])){if($permition['purchases'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Deletar Pedido de Produtos para Venda</label>
							</li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="purchases|add"
								<?php if(isset($permition['purchases'])){if($permition['purchases'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Efetuar Pedido de Insumos e despesas
									operacionais</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="purchases|delete"
								<?php if(isset($permition['purchases'])){if($permition['purchases'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Deletar Pedido de Insumos e despesas
									operacionais</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="purchases|approve"
								<?php if(isset($permition['purchases'])){if($permition['purchases'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Aprovar pedido de insumo/despesa
									operacional</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="purchases|disapprove"
								<?php if(isset($permition['purchases'])){if($permition['purchases'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Reprovar pedido de insumo/despesa
									operacional</label></li>
							<li><input type="checkbox" id="dept" onclick="descheck2();"
								name="permissions_actions[]" value="purchases|view"
								<?php if(isset($permition['purchases'])){if($permition['purchases'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Visualizar Lista de Pedidos apenas do
									departamento deste usuário</label></li>
							<li><input type="checkbox" id="all" onclick="descheck();"
								name="permissions_actions[]" value="purchases|view_all"
								<?php if(isset($permition['purchases'])){if($permition['purchases'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Visualizar lista de Pedidos de todos os
									departamentos</label></li>
						</ul></li>

					<!-- Divisor -->

					<hr>
					<br>

					<!-- Permissão para Cadastro de Categoria de Produtos e Ações -->
					<li><input type="checkbox" name="permissions[]" value="accounts"
						class="module_checkboxes "
						<?php if(isset($permition['accounts'])){if($permition['accounts'] == $user_id){echo 'checked';}}?> />
						<label class="text-success">Financeiro Contas:</label> <label
						class="text-label">Acesso ao Controle Contas </label>
						<ul>
							<li><input type="checkbox" name="permissions_actions[]"
								value="accounts|add_update"
								<?php if(isset($permiting_action_add_update['accounts'])){if($permiting_action_add_update['accounts'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Adicionar e Atualizar</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="accounts|Delete"
								<?php if(isset($permiting_action_delete['accounts'])){if($permiting_action_delete['accounts'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Deletar</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="accounts|search"
								<?php if(isset($permiting_action_search['accounts'])){if($permiting_action_search['accounts'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Listar Tipos de Produtos</label></li>
						</ul></li>
					<br>

					<!-- Permissão para Controle de Boletos -->
					<li><input type="checkbox" name="permissions[]" value="billets"
						class="module_checkboxes "
						<?php if(isset($permition['billets'])){if($permition['billets'] == $user_id){echo 'checked';}}?> />
						<label class="text-success">Financeiro Botelo:</label> <label
						class="text-label">Acesso ao Controle Boletos </label>
						<ul>
							<li><input type="checkbox" name="permissions_actions[]"
								value="billets|add_update"
								<?php if(isset($permiting_action_add_update['billets'])){if($permiting_action_add_update['billets'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Adicionar e Atualizar</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="billets|Delete"
								<?php if(isset($permiting_action_delete['billets'])){if($permiting_action_delete['billets'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Deletar</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="billets|search"
								<?php if(isset($permiting_action_search['billets'])){if($permiting_action_search['billets'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Listar Tipos de Produtos</label></li>
						</ul></li>
					<br>


					<!-- Permiss�o para Cadastro de Plano de Contas -->
					<li><input type="checkbox" name="permissions[]"
						value="planaccounts" class="module_checkboxes "
						<?php if(isset($permition['planaccounts'])){if($permition['planaccounts'] == $user_id){echo 'checked';}}?> />
						<label class="text-success">Financeiro Plano de Contas:</label> <label
						class="text-label">Acesso ao Modulo de Plano de Contas </label>
						<ul>
							<li><input type="checkbox" name="permissions_actions[]"
								value="planaccounts|add_update"
								<?php if(isset($permiting_action_add_update['planaccounts'])){if($permiting_action_add_update['planaccounts'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Adicionar e Atualizar</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="planaccounts|Delete"
								<?php if(isset($permiting_action_delete['planaccounts'])){if($permiting_action_delete['planaccounts'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Deletar</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="planaccounts|search"
								<?php if(isset($permiting_action_search['planaccounts'])){if($permiting_action_search['planaccounts'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Listar Tipos de Produtos</label></li>
						</ul></li>
					<br>

					<!-- Permiss�o para Cadastro de Plano de Contas -->
					<li><input type="checkbox" name="permissions[]" value="methods"
						class="module_checkboxes"
						<?php if(isset($permition['planaccounts'])){if($permition['planaccounts'] == $user_id){echo 'checked';}}?> />
						<label class="text-success">Financeiro Formas de Pagamento:</label>
						<label class="text-label">Acesso ao Modulo de Formas de Pagamento
					</label>
						<ul>
							<li><input type="checkbox" name="permissions_actions[]"
								value="methods|add_update"
								<?php if(isset($permiting_action_add_update['planaccounts'])){if($permiting_action_add_update['planaccounts'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Adicionar e Atualizar</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="methods|Delete"
								<?php if(isset($permiting_action_delete['planaccounts'])){if($permiting_action_delete['planaccounts'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Deletar</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="methods|search"
								<?php if(isset($permiting_action_search['planaccounts'])){if($permiting_action_search['planaccounts'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Listar Tipos de Produtos</label></li>
						</ul></li>
					<br>

					<!-- Divisor -->
					<hr>
					<br>

					<li><input type="checkbox" name="permissions[]" value="reports"
						class="module_checkboxes "
						<?php if(isset($permition['reports'])){if($permition['reports'] == $user_id){echo 'checked';}}?> />
						<label class="text-success">Relat&#243;rio:</label> <label
						class="text-label">Ver e gerar relat&#243;rios</label>
						<ul>
							<li><input type="checkbox" name="permissions_actions[]"
								value="reports|view_categories"
								<?php if(isset($permition['reports'])){if($permition['reports'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Categorias</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="reports|view_sales_generator"
								<?php if(isset($permition['reports'])){if($permition['reports'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Relat&#243;rio personalizado</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="reports|view_customers"
								<?php if(isset($permition['reports'])){if($permition['reports'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Clientes</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="reports|view_Deleted_sales"
								<?php if(isset($permition['reports'])){if($permition['reports'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Vendas Excluidas</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="reports|view_discounts"
								<?php if(isset($permition['reports'])){if($permition['reports'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Descontos</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="reports|view_employees"
								<?php if(isset($permition['reports'])){if($permition['reports'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Funcionarios</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="reports|view_giftcards"
								<?php if(isset($permition['reports'])){if($permition['reports'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Cart&#245;es de Presente</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="reports|view_inventory_reports"
								<?php if(isset($permition['reports'])){if($permition['reports'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Inventario</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="reports|view_item_kits"
								<?php if(isset($permition['reports'])){if($permition['reports'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Kits de Produtos</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="reports|view_items"
								<?php if(isset($permition['reports'])){if($permition['reports'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Produtos</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="reports|view_payments"
								<?php if(isset($permition['reports'])){if($permition['reports'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Pagamentos</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="reports|view_profit_and_loss"
								<?php if(isset($permition['reports'])){if($permition['reports'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Lucros e Perdas</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="reports|view_receivings"
								<?php if(isset($permition['reports'])){if($permition['reports'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Recebimentos</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="reports|view_register_log"
								<?php if(isset($permition['reports'])){if($permition['reports'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Registro de Logs</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="reports|view_sales"
								<?php if(isset($permition['reports'])){if($permition['reports'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Vendas</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="reports|view_store_account"
								<?php if(isset($permition['reports'])){if($permition['reports'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Contas da Loja</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="reports|view_suppliers"
								<?php if(isset($permition['reports'])){if($permition['reports'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Fornecedores</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="reports|view_taxes"
								<?php if(isset($permition['reports'])){if($permition['reports'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Taxas</label></li>
						</ul></li>

					<br>

					<li><input type="checkbox" name="permissions[]" value="locations"
						class="module_checkboxes "
						<?php if(isset($permition['locations'])){if($permition['locations'] == $user_id){echo 'checked';}}?> />
						<label class="text-success">Localiza&#231;&#245;es:</label> <label
						class="text-label">Acesso ao Modulo Localiza&#231;&#245;es</label>
						<ul>
							<li><input type="checkbox" name="permissions_actions[]"
								value="locations|add_update"
								<?php if(isset($permiting_action_add_update['locations'])){if($permiting_action_add_update['locations'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Adicionar e Atualizar</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="locations|Delete"
								<?php if(isset($permiting_action_delete['locations'])){if($permiting_action_delete['locations'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Deletar</label></li>
							<li><input type="checkbox" name="permissions_actions[]"
								value="locations|search"
								<?php if(isset($permiting_action_search['locations'])){if($permiting_action_search['locations'] == $user_id){echo 'checked';}}?> />
								<label class="text-info">Listar Locais</label></li>
						</ul></li>
				</ul>

			</div>
    	
    	<?php echo form_button(array('class'=>'btn btn-primary btn-flat'),'<i class="fa fa-check"></i> Salvar')?>
    	<?php echo form_close();?>
    	<?php } ?>
    	</div>

	</div>
</div>
<script type="text/javascript">
	function descheck()
	{
		document.getElementById("dept").checked = false;
	}
	function descheck2()
	{
		document.getElementById("all").checked = false;
	}


</script>
<?php $this->load->view("partial/footer"); ?>