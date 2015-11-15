<?php $this->load->view('partial/header'); ?>

<link rel="stylesheet" type="text/css"
	href="<?php echo $this->config->base_url();?>web/js/chosen.min.css">

<div class="page-aside app filters">
	<div>
		<div class="content">
			<button class="navbar-toggle" data-target=".app-nav"
				data-toggle="collapse" type="button">
				<span class="fa fa-chevron-down"></span>
			</button>
			<h2 class="page-title">Próxima Visita</h2>
			<p class="description">Quadro de Acompanhamento</p>
		</div>
		<div class="app-nav collapse">
			<div class="content">
          	<?php
        echo form_open('campanha/save_appointment/' . $sale_id.'/'.$serie_item, array(
            'id' => 'appointments_form',
            'class' => 'form-horizontal',
            'style' => 'border-radius: 5px;'
        ));
        ?>
                 <div class="form-group">
        			  <label class="control-label">Data:</label> 
        			  <input id="next_date" class="form-control" name="next_date" placeholder="DD/MM/AAAA" data-mask="00/00/0000" value="<?php if(isset($next_date)){echo $next_date;}?>"> 
        			  <label class="control-label">Hora:</label> 
        			  <input id="next_time" class="form-control" name="next_time" placeholder="HH:MM" data-mask="00:00" value="<?php if(isset($next_time)){echo $next_time;}?>"> 
        			  <label class="control-label">Marcar com Fonoaudiólogo:</label>  
                      <?php echo form_dropdown('fono',$fono_profile, array($fono_id), 'class="form-control"');?>
                      <input id="atendimento" type="text" name="atendimento" value="1º visita de acompanhamento - 15 dias" style="visibility: hidden;"> 
        			  <input id="program" type="text"name="program" value="1" style="visibility: hidden;">
        		</div>

				<div class="form-group text-right">
					<a class="btn btn-primary btn-flat" href="javascript: document.getElementById('appointments_form').submit();">Marcar Visita</a>
				</div>
            <?php echo form_close();?>
          </div>

		</div>
	</div>
</div>

<div class="container-fluid" id="pcont" style="background-color: white;">
	<div class="main-app">

		<div class="head">
			<h3>Programa de Acompanhamento</h3>
			<h4>
				Cliente: <font style="color: green;"><b> <?php if(isset($customer_user)){echo $customer_user;}?> </b></font>
			</h4>
		    	<?php if(isset($manager_result)){echo $manager_result;}?>		        
		    </div>

		<div class="btn-group pull-right">
			<a href="#15dias" onclick="javascript: progress(1);"
				class="btn btn-sm btn-flat <?php if(isset($btn_group[0])){echo $btn_group[0];}?>"
				data-toggle="tab" type="button">1º</a> <a href="#3meses"
				onclick="javascript: progress(2);"
				class="btn btn-sm btn-flat <?php if(isset($btn_group[1])){echo $btn_group[1];}?>"
				data-toggle="tab" type="button">2º</a> <a href="#6meses"
				onclick="javascript: progress(3);"
				class="btn btn-sm btn-flat <?php if(isset($btn_group[2])){echo $btn_group[2];}?>"
				data-toggle="tab" type="button">3º</a> <a href="#1ano"
				onclick="javascript: progress(4);"
				class="btn btn-sm btn-flat <?php if(isset($btn_group[3])){echo $btn_group[3];}?>"
				data-toggle="tab" type="button">4º</a> <a href="#1ano_6meses"
				onclick="javascript: progress(5);"
				class="btn btn-sm btn-flat <?php if(isset($btn_group[4])){echo $btn_group[4];}?>"
				data-toggle="tab" type="button">5º</a> <a href="#2anos"
				onclick="javascript: progress(6);"
				class="btn btn-sm btn-flat <?php if(isset($btn_group[5])){echo $btn_group[5];}?>"
				data-toggle="tab" type="button">6º</a> <a href="#2anos_6meses"
				onclick="javascript: progress(7);"
				class="btn btn-sm btn-flat <?php if(isset($btn_group[6])){echo $btn_group[6];}?>"
				data-toggle="tab" type="button">7º</a> <a href="#3anos"
				onclick="javascript: progress(8);"
				class="btn btn-sm btn-flat <?php if(isset($btn_group[7])){echo $btn_group[7];}?>"
				data-toggle="tab" type="button">8º</a>
		</div>

		<!-- PRIMEIRA VISITA -->
		<div class="items products tab-content"
			style="border: hidden; box-shadow: 0px 0px 0px 0px;">
			<div class="tab-pane <?php if(isset($panel_active[0])){echo $panel_active[0];} ?> cont" id="15dias">
				<div class="header">
					<h3>1º visita de acompanhamento - 15 dias</h3>
				</div>
				<div class="content">
				<?php echo form_open('campanha/save_group/' . $sale_id.'/'.$serie_item,  array(
				    'id' => 'group_form_a',
				    'class' => 'form-horizontal',
				    'style' => 'border-radius: 5px;'
				));?>
				
					<table class="table no-border hover">
						<thead class="no-border">
							<tr>
								<th style="width: 80%;">Nesta visita seu fonoaudiólogo:</th>
								<th class="text-right">Realizado</th>
							</tr>
						</thead>
						<tbody class="no-border-y">
							<tr>
								<td><strong>Realizará</strong><br /> Uma meatoscopia (inspeção
									visual do conduto auditivo)</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op1[Meatoscopia]" type="checkbox" value="1"
											<?php if(isset($op1['Meatoscopia'])){echo 'checked';}?>>
									</div></td>
							</tr>
							<tr>
								<td><strong>Realizará</strong><br /> Campo Livre para
									verificação dos limiares auditivos com aparelho</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op1[CampoLivre]" type="checkbox" value="1"
											<?php if(isset($op1['CampoLivre'])){echo 'checked';}?>>
									</div></td>
							</tr>
							<tr>
								<td><strong>Realizará</strong><br /> Revisão da adaptação
									(ajustes e manuseio): uso e colocação dos aparelhos auditivos,
									programação e ajustes de acordo com a sua necessidade</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op1[Revisao]" type="checkbox" value="1"
											<?php if(isset($op1['Revisao'])){echo 'checked';}?>>
									</div></td>
							</tr>
							<tr>
								<td><strong>Entregará</strong><br /> Kit de manutenção</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op1[KitManutencao]" type="checkbox" value="1"
											<?php if(isset($op1['KitManutencao'])){echo 'checked';}?>>
									</div></td>
							</tr>
							<tr>
								<td><strong>Entregará</strong><br /> Pilhas para 3 meses</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op1[Pilhas]" type="checkbox" value="1"
											<?php if(isset($op1['Pilhas'])){echo 'checked';}?>>
									</div></td>
							</tr>
						</tbody>
					</table>
					<div class="form-group text-right">
					   <button class="btn btn-primary btn-flat" type="button" onclick="document.getElementById('group_form_a').submit()" value="save">
					       <i class="fa fa-check"></i> Salvar
					   </button>
				       <a class="btn btn-default btn-flat" href="<?php echo site_url('campanha')?>">Fechar Quadro</a>
			        </div>
			        <?php echo form_close();?>
				</div>
			</div>




			<!-- SEGUNDA VISITA -->
			<div class="tab-pane <?php if(isset($panel_active[1])){echo $panel_active[1];} ?> cont" id="3meses">
				<div class="header">
					<h3>2º visita de acompanhamento - 3 meses</h3>
				</div>
				<div class="content">
				<?php echo form_open('campanha/save_group/' . $sale_id.'/'.$serie_item,  array(
				    'id' => 'group_form_b',
				    'class' => 'form-horizontal',
				    'style' => 'border-radius: 5px;'
				));?>
					<table class="no-border">
						<thead class="no-border">
							<tr>
								<th style="width: 80%;">Nesta visita seu fonoaudiólogo:</th>
								<th class="text-right">Realizado</th>
							</tr>
						</thead>
						<tbody class="no-border-y">
							<tr>
								<td><strong>Realizará</strong><br /> Uma meatoscopia</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op2[Meatoscopia]" type="checkbox" value='1'
										  <?php if(isset($op2['Meatoscopia'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Realizará</strong><br /> Revisão da adaptação
									(ajustes e manuseio): uso e colocação dos aparelhos auditivos,
									programação e ajustes de acordo com a sua necessidade</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op2[Revisao]" type="checkbox" value='1'
										  <?php if(isset($op2['Revisao'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Realizará</strong><br /> Verificação da manutenção,
									uso e limpeza dos aparelhos auditivos</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op2[Limpeza]" type="checkbox" value='1'
										  <?php if(isset($op2['Limpeza'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Realizará</strong><br /> Revisão do funcionamento
									dos aparelhos auditivos (veja os itens revisados na aba
									"Revisão")</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op2[Funcionamento]" type="checkbox" value='1'
										  <?php if(isset($op2['Funcionamento'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Entregará</strong><br /> Folheto de acessórios e de
									FM</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op2[Folheto]" type="checkbox" value='1'
										  <?php if(isset($op2['Folheto'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Entregará</strong><br /> Pilhas para 3 meses</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op2[Pilhas]" type="checkbox" value='1'
										  <?php if(isset($op2['Pilhas'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Entregará</strong><br /> Protetor de cera (para
									aparelhos intra-aurais e micro retroauriculares com receptor no
									canal)</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op2[ProtetorCera]" type="checkbox" value='1'
										  <?php if(isset($op2['ProtetorCera'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Entregará</strong><br /> Pastilhas de limpeza de
									moldes (para aparelhos retroauriculares)</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op2[Limpeza]" type="checkbox" value='1'
										  <?php if(isset($op2['Limpeza'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Entregará</strong><br /> Cápsulas desumidificadoras</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op2[Desumidificadora]" type="checkbox" value='1'
										  <?php if(isset($op2['Desumidificadora'])){echo 'checked';}?>/>
									</div></td>
							</tr>
						</tbody>
					</table>
					<div class="form-group text-right">
					   <button class="btn btn-primary btn-flat" type="button" onclick="document.getElementById('group_form_b').submit()" value="save">
					       <i class="fa fa-check"></i> Salvar
					   </button>
				       <a class="btn btn-default btn-flat" href="<?php echo site_url('campanha')?>">Fechar Quadro</a>
			        </div>
			        <?php echo form_close();?>
				</div>
			</div>



			<!-- TERCEIRA VISITA -->
			<div class="tab-pane <?php if(isset($panel_active[2])){echo $panel_active[2];} ?> cont" id="6meses">
				<div class="header">
					<h3>3º visita de acompanhamento - 6 meses</h3>
				</div>
				<div class="content">
				<?php echo form_open('campanha/save_group/' . $sale_id.'/'.$serie_item,  array(
				    'id' => 'group_form_c',
				    'class' => 'form-horizontal',
				    'style' => 'border-radius: 5px;'
				));?>
					<table class="no-border">
						<thead class="no-border">
							<tr>
								<th style="width: 80%;">Nesta visita seu fonoaudiólogo:</th>
								<th class="text-right">Realizado</th>
							</tr>
						</thead>
						<tbody class="no-border-y">
							<tr>
								<td><strong>Realizará</strong><br /> Uma meatoscopia</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op3[Meatoscopia]" type="checkbox" value='1'
										  <?php if(isset($op3['Meatoscopia'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Realizará</strong><br /> Revisão da adaptação
									(ajustes e manuseio)</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op3[Revisao]" type="checkbox" value='1'
										  <?php if(isset($op3['Revisao'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Realizará</strong><br /> Verificação da manutenção,
									uso e limpeza dos aparelhos auditivos</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op3[Manutencao]" type="checkbox" value='1'
										  <?php if(isset($op3['Manutencao'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Realizará</strong><br /> Revisão do funcionamento
									dos aparelhos auditivos (veja os itens revisados na aba
									"Revisão")</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op3[Funcionamento]" type="checkbox" value='1'
										  <?php if(isset($op3['Funcionamento'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Realizará</strong><br /> Campo Livre</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op3[CampoLivre]" type="checkbox" value='1'
										  <?php if(isset($op3['CampoLivre'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Realizará</strong><br /> Teste do FM</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op3[TesteFM]" type="checkbox" value='1'
										  <?php if(isset($op3['TesteFM'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Entregará</strong><br /> Pilhas para 6 meses</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op3[Pilhas]" type="checkbox" value='1'
										  <?php if(isset($op3['Pilhas'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Entregará</strong><br /> Protetor de cera (para
									aparelhos intra-aurais e micro retroauriculares com receptor no
									canal)</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op3[ProtetorCera]" type="checkbox" value='1'
										  <?php if(isset($op3['ProtetorCera'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Entregará</strong><br /> Pastilhas de limpeza de
									moldes (para aparelhos retroauriculares)</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op3[Limpeza]" type="checkbox" />
									</div></td>
							</tr>
							<tr>
								<td><strong>Entregará</strong><br /> Cápsulas desumidificadoras</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op3[Desumidificadora]" type="checkbox" value='1'
										  <?php if(isset($op3['Desumidificadora'])){echo 'checked';}?>/>
									</div></td>
							</tr>
						</tbody>
					</table>
					<div class="form-group text-right">
					   <button class="btn btn-primary btn-flat" type="button" onclick="document.getElementById('group_form_c').submit()" value="save">
					       <i class="fa fa-check"></i> Salvar
					   </button>
				       <a class="btn btn-default btn-flat" href="<?php echo site_url('campanha')?>">Fechar Quadro</a>
			        </div>
			        <?php echo form_close();?>
				</div>
			</div>





			<!-- QUARTA VISITA -->
			<div class="tab-pane <?php if(isset($panel_active[3])){echo $panel_active[3];} ?> cont" id="1ano">
				<div class="header">
					<h3>4º visita de acompanhamento - 1 ano</h3>
				</div>
				<div class="content">
				<?php echo form_open('campanha/save_group/' . $sale_id.'/'.$serie_item,  array(
				    'id' => 'group_form_d',
				    'class' => 'form-horizontal',
				    'style' => 'border-radius: 5px;'
				));?>
					<table class="no-border">
						<thead class="no-border">
							<tr>
								<th style="width: 80%;">Nesta visita seu fonoaudiólogo:</th>
								<th class="text-right">Realizado</th>
							</tr>
						</thead>
						<tbody class="no-border-y">
							<tr>
								<td><strong>Realizará</strong><br /> Uma meatoscopia</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op4[Meatoscopia]" type="checkbox" value='1'
										  <?php if(isset($op4['Meatoscopia'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Realizará</strong><br /> Revisão da adaptação
									(ajustes e manuseio)</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op4[Revisao]" type="checkbox" value='1'
										  <?php if(isset($op4['Revisao'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Realizará</strong><br /> Verificação da manutenção,
									uso e limpeza dos aparelhos auditivos</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op4[Manutencao]" type="checkbox" value='1'
										  <?php if(isset($op4['Manutencao'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Realizará</strong><br /> Revisão do funcionamento
									dos aparelhos auditivos (veja os itens revisados na aba
									"Revisão")</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op4[Funcionamento]" type="checkbox" value='1'
										  <?php if(isset($op4['Funcionamento'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Realizará</strong><br /> Campo Livre</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op4[CampoLivre]" type="checkbox" value='1'
										  <?php if(isset($op4['CampoLivre'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Entregará</strong><br /> Pilhas para 6 meses</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op4[Pilhas]" type="checkbox" value='1'
										  <?php if(isset($op4['Pilhas'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Entregará</strong><br /> Protetor de cera (para
									aparelhos intra-aurais e micro retroauriculares com receptor no
									canal)</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op4[ProtetorCera]" type="checkbox" value='1'
										  <?php if(isset($op4['ProtetorCera'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Entregará</strong><br /> Pastilhas de limpeza de
									moldes (para aparelhos retroauriculares)</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op4[Limpeza]" type="checkbox" value='1'
										  <?php if(isset($op4['Limpeza'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Entregará</strong><br /> Cápsulas desumidificadoras</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op4[Desumidificadora]" type="checkbox" value='1'
										  <?php if(isset($op4['Desumidificadora'])){echo 'checked';}?>/>
									</div></td>
							</tr>
						</tbody>
					</table>
					<div class="form-group text-right">
					   <button class="btn btn-primary btn-flat" type="button" onclick="document.getElementById('group_form_d').submit()" value="save">
					       <i class="fa fa-check"></i> Salvar
					   </button>
				       <a class="btn btn-default btn-flat" href="<?php echo site_url('campanha')?>">Fechar Quadro</a>
			        </div>
			        <?php echo form_close();?>
				</div>
			</div>





			<!-- QUINTA VISITA -->
			<div class="tab-pane <?php if(isset($panel_active[4])){echo $panel_active[4];} ?> cont" id="1ano_6meses">
				<div class="header">
					<h3>5º visita de acompanhamento - 1 ano e 6 meses</h3>
				</div>
				<div class="content">
				<?php echo form_open('campanha/save_group/' . $sale_id.'/'.$serie_item,  array(
				    'id' => 'group_form_e',
				    'class' => 'form-horizontal',
				    'style' => 'border-radius: 5px;'
				));?>
					<table class="no-border">
						<thead class="no-border">
							<tr>
								<th style="width: 80%;">Nesta visita seu fonoaudiólogo:</th>
								<th class="text-right">Realizado</th>
							</tr>
						</thead>
						<tbody class="no-border-y">
							<tr>
								<td><strong>Entregará</strong><br /> Pilhas para 6 meses</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op5[Pilhas]" type="checkbox" value='1'
										  <?php if(isset($op5['Pilhas'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Entregará</strong><br /> Protetor de cera (para
									aparelhos intra-aurais e micro retroauriculares com receptor no
									canal)</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op5[ProtetorCera]" type="checkbox" value='1'
										  <?php if(isset($op5['ProtetorCera'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Entregará</strong><br /> Pastilhas de limpeza de
									moldes (para aparelhos retroauriculares)</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op5[Limpeza]" type="checkbox" value='1'
										  <?php if(isset($op5['Limpeza'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Entregará</strong><br /> Cápsulas desumidificadoras</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op5[Desumidificadora]" type="checkbox" value='1'
										  <?php if(isset($op5['Desumidificadora'])){echo 'checked';}?>/>
									</div></td>
							</tr>
						</tbody>
					</table>
					<div class="form-group text-right">
					   <button class="btn btn-primary btn-flat" type="button" onclick="document.getElementById('group_form_e').submit()" value="save">
					       <i class="fa fa-check"></i> Salvar
					   </button>
				       <a class="btn btn-default btn-flat" href="<?php echo site_url('campanha')?>">Fechar Quadro</a>
			        </div>
			        <?php echo form_close();?>
				</div>
			</div>




			<!-- SEXTA VISITA -->
			<div class="tab-pane <?php if(isset($panel_active[5])){echo $panel_active[5];} ?> cont" id="2anos">
				<div class="header">
					<h3>6ª visita de acompanhamento - 2 anos</h3>
				</div>
				<div class="content">
				<?php echo form_open('campanha/save_group/' . $sale_id.'/'.$serie_item,  array(
				    'id' => 'group_form_f',
				    'class' => 'form-horizontal',
				    'style' => 'border-radius: 5px;'
				));?>
					<table class="no-border">
						<thead class="no-border">
							<tr>
								<th style="width: 80%;">Nesta visita seu fonoaudiólogo:</th>
								<th class="text-right">Realizado</th>
							</tr>
						</thead>
						<tbody class="no-border-y">
							<tr>
								<td><strong>Realizará</strong><br /> Uma meatoscopia</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op6[Meatoscopia]" type="checkbox" value='1'
										  <?php if(isset($op6['Meatoscopia'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Realizará</strong><br /> Revisão da adaptação
									(ajustes e manuseio)</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op6[Revisao]" type="checkbox" value='1'
										  <?php if(isset($op6['Revisao'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Realizará</strong><br /> Verificação da manutenção,
									uso e limpeza dos aparelhos auditivos</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op6[Manutencao]" type="checkbox" value='1'
										  <?php if(isset($op6['Manutencao'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Realizará</strong><br /> Revisão do funcionamento
									dos aparelhos auditivos (veja os itens revisados na aba
									"Revisão")</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op6[Funcionamento]" type="checkbox" value='1'
										  <?php if(isset($op6['Funcionamento'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Realizará</strong><br /> Campo Livre</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op6[CampoLivre]" type="checkbox" value='1'
										  <?php if(isset($op6['CampoLivre'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Entregará</strong><br /> Pilhas para 6 meses</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op6[Pilhas]" type="checkbox" value='1'
										  <?php if(isset($op6['Pilhas'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Entregará</strong><br /> Protetor de cera (para
									aparelhos intra-aurais e micro retroauriculares com receptor no
									canal)</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op6[ProtetorCera]" type="checkbox" value='1'
										  <?php if(isset($op6['ProtetorCera'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Entregará</strong><br /> Pastilhas de limpeza de
									moldes (para aparelhos retroauriculares)</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op6[Limpeza]" type="checkbox" value='1'
										  <?php if(isset($op6['Limpeza'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Entregará</strong><br /> Cápsulas desumidificadoras</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op6[Desumidificadora]" type="checkbox" value='1'
										  <?php if(isset($op6['Desumidificadora'])){echo 'checked';}?>/>
									</div></td>
							</tr>
						</tbody>
					</table>
					<div class="form-group text-right">
					   <button class="btn btn-primary btn-flat" type="button" onclick="document.getElementById('group_form_f').submit()" value="save">
					       <i class="fa fa-check"></i> Salvar
					   </button>
				       <a class="btn btn-default btn-flat" href="<?php echo site_url('campanha')?>">Fechar Quadro</a>
			        </div>
			        <?php echo form_close();?>
				</div>
			</div>



			<!-- SETIMA VISITA -->
			<div class="tab-pane <?php if(isset($panel_active[6])){echo $panel_active[6];} ?> cont" id="2anos_6meses">
				<div class="header">
					<h3>7ª visita de acompanhamento - 2 ano e 6 meses</h3>
				</div>
				<div class="content">
				<?php echo form_open('campanha/save_group/' . $sale_id.'/'.$serie_item,  array(
				    'id' => 'group_form_g',
				    'class' => 'form-horizontal',
				    'style' => 'border-radius: 5px;'
				));?>
					<table class="no-border">
						<thead class="no-border">
							<tr>
								<th style="width: 80%;">Nesta visita seu fonoaudiólogo:</th>
								<th class="text-right">Realizado</th>
							</tr>
						</thead>
						<tbody class="no-border-y">
							<tr>
								<td><strong>Entregará</strong><br /> Pilhas para 6 meses</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op7[Pilhas]" type="checkbox" value='1'
										  <?php if(isset($op7['Pilhas'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Entregará</strong><br /> Protetor de cera (para
									aparelhos intra-aurais e micro retroauriculares com receptor no
									canal)</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op7[ProtetorCera]" type="checkbox" value='1'
										  <?php if(isset($op7['ProtetorCera'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Entregará</strong><br /> Pastilhas de limpeza de
									moldes (para aparelhos retroauriculares)</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op7[Limpeza]" type="checkbox" value='1'
										  <?php if(isset($op7['Limpeza'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Entregará</strong><br /> Cápsulas desumidificadoras</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op7[Desumidificadora]" type="checkbox" value='1'
										  <?php if(isset($op7['Desumidificadora'])){echo 'checked';}?>/>
									</div></td>
							</tr>
						</tbody>
					</table>
					<div class="form-group text-right">
					   <button class="btn btn-primary btn-flat" type="button" onclick="document.getElementById('group_form_g').submit()" value="save">
					       <i class="fa fa-check"></i> Salvar
					   </button>
				       <a class="btn btn-default btn-flat" href="<?php echo site_url('campanha')?>">Fechar Quadro</a>
			        </div>
			        <?php echo form_close();?>
				</div>
			</div>





			<!-- OITAVA VISITA -->
			<div class="tab-pane <?php if(isset($panel_active[7])){echo $panel_active[7];} ?> cont" id="3anos">
				<div class="header">
					<h3>8ª visita de acompanhamento - 3 anos</h3>
				</div>
				<div class="content">
				<?php echo form_open('campanha/save_group/' . $sale_id.'/'.$serie_item,  array(
				    'id' => 'group_form_h',
				    'class' => 'form-horizontal',
				    'style' => 'border-radius: 5px;'
				));?>
					<table class="no-border">
						<thead class="no-border">
							<tr>
								<th style="width: 80%;">Nesta visita seu fonoaudiólogo:</th>
								<th class="text-right">Realizado</th>
							</tr>
						</thead>
						<tbody class="no-border-y">
							<tr>
								<td><strong>Realizará</strong><br /> Uma meatoscopia</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op8[Meatoscopia]" type="checkbox" value='1'
										<?php if(isset($op8['Meatoscopia'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Realizará</strong><br /> Revisão da adaptação
									(ajustes e manuseio)</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op8[Revisao]" type="checkbox" value='1'
										  <?php if(isset($op8['Revisao'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Realizará</strong><br /> Verificação da manutenção,
									uso e limpeza dos aparelhos auditivos</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op8[Manutencao]" type="checkbox" value='1'
										  <?php if(isset($op8['Manutencao'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Realizará</strong><br /> Revisão do funcionamento
									dos aparelhos auditivos (veja os itens revisados na aba
									"Revisão")</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op8[Funcionamento]" type="checkbox" value='1'
										  <?php if(isset($op8['Funcionamento'])){echo 'checked';}?>/>
									</div></td>
							</tr>
							<tr>
								<td><strong>Realizará</strong><br /> Campo Livre</td>
								<td class="text-right"><div class="switch switch-small">
										<input name="op8[CampoLivre]" type="checkbox" value='1'
										  <?php if(isset($op8['CampoLivre'])){echo 'checked';}?>/>
									</div></td>
							</tr>
						</tbody>
					</table>
					<div class="form-group text-right">
					   <button class="btn btn-primary btn-flat" type="button" onclick="document.getElementById('group_form_h').submit()" value="save">
					       <i class="fa fa-check"></i> Salvar
					   </button>
				       <a class="btn btn-default btn-flat" href="<?php echo site_url('campanha')?>">Fechar Quadro</a>
			        </div>
			        <?php echo form_close();?>
				</div>
			</div>

		</div>
	</div>
</div>

<!-- PARA PLUGIN CHOSEN -->
<script
	src="<?php echo $this->config->base_url();?>web/js/jquery-1.6.4.min.js"
	type="text/javascript"></script>
<script type="text/javascript"
	src="<?php echo $this->config->base_url();?>web/js/chosen.jquery.min.js"></script>


<script type="text/javascript">
		var cl = document.getElementById('cl-wrapper');
	    cl.setAttribute('class', 'fixed-menu sb-collapsed'); 
	    document.getElementById('sidebar-collapse').innerHTML = '<i class="fa fa-angle-right" style="color:#fff;"></i>';


	    var config = {
	    		  '.chosen-select'           : {width:"100%"},
	    		  '.chosen-select-deselect'  : {allow_single_deselect:true},
	    		  '.chosen-select-no-single' : {disable_search_threshold:10},
	    		  '.chosen-select-no-results': {no_results_text:'Não há cadastros deste item!'},
	    		  '.chosen-select-width'     : {width:"90%"}
	    }

	    for (var selector in config) 
	    {
	    	$(selector).chosen(config[selector]);
	    }

	</script>
<?php $this->load->view('partial/footer'); ?>