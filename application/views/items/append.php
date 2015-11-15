 <?php $this->load->view("partial/header"); ?>
<div class="container-fluid" id="pcont">
	<div class="page-head">
		<h2>Registro de Produtos</h2>
	</div>

	<div class="cl-mcont">
		<?php if(isset($manage_result)){echo $manage_result;}else{echo '';}; ?>
		<div class="row">

			<div class="col-sm-12 col-md-12">

				<div class="tab-container">
					<!------CONTROL TABS START------->
					<ul class="nav nav-tabs">
						<li class="<?php echo $add;?>"><a href="#add" data-toggle="tab"><i
								class="fa fa-plus"></i> Inserir Produto</a></li>
						<li class="<?php echo $value;?>"><a
							<?php if(isset($active_tab_value)){echo $active_tab_value;}else{echo '';}?>><i
								class="fa fa-shopping-cart"></i> Informações Comerciais</a></li>
						<li class="<?php echo $taxes;?>"><a
							<?php if(isset($active_tab_taxes)){echo $active_tab_taxes;}else{echo '';}?>><i
								class="fa fa-key"></i> Dados Tributários</a></li>
					</ul>
					<!------CONTROL TABS END------->
				</div>
				<!---- END TAB-CONTAINER --->


				<div class="tab-content">

					<!----PANEL ADD STARTS--->
					<div class="tab-pane <?php echo $add;?> cont" id="add">
						<div class="col-md-12 col-sm-12 col-lg-12">
							<div class="header ">
								<h3>Informa&#231;&#245;es do Produto</h3>
							</div>
							<hr>
							<!----BASIC FORM STARTS--->
							<div class="content">
									<?php
        echo form_open('items/save/' . $items_info->item_id, array(
            'id' => 'items_form',
            'class' => 'form-horizontal',
            'parsley-validate' => '',
            'style' => 'border-radius: 0px;'
        ));
        ?>
									
									<div class="form-group">
									<div class="col-sm-4 col-md-4">
										<input type="text" readonly="readonly" class="form-control"
											placeholder="Código" data-original-title="Código do Produto"
											data-toggle="tooltip" name="item_id"
											value="<?php if(isset($items_info->item_id)){echo $items_info->item_id;}?>">
									</div>
									<div class="col-sm-3 col-md-3">
										<input type="text"
											class="form-control parsley-validated parsley-error"
											autofocus="autofocus" placeholder="Código NCM"
											data-original-title="Código NCM" data-toggle="tooltip"
											name="item_ncm"
											value="<?php if(isset($items_info->item_ncm)){echo $items_info->item_ncm;}?>">
									</div>
									<div class="col-sm-2 col-md-2">
										<input type="text"
											class="form-control parsley-validated parsley-error"
											placeholder="Código de Barras"
											data-original-title="Código de Barras do Produto"
											data-toggle="tooltip" name="item_codebar"
											value="<?php echo $items_info->item_codebar;?>">
									</div>
								</div>

								<div class="form-group">
									<div class="col-sm-9">
										<input type="text"
											class="form-control parsley-validated parsley-error"
											placeholder="Descrição do Produto"
											data-original-title="Descrição do produto"
											data-toggle="tooltip" name="description"
											value="<?php echo $items_info->description;?>">
									</div>

									<div class="col-sm-1 col-md-1 col-lg-1">
										<input type="text"
											class="form-control parsley-validated parsley-error"
											placeholder="Garantia Fabrica"
											data-original-title="Garantia de Fabrica (Meses)"
											data-toggle="tooltip" name="garantia_fabrica"
											value="<?php echo $items_info->garantia_fabrica;?>">
									</div>

									<div class="col-sm-1 col-md-1 col-lg-1">
										<input type="text"
											class="form-control parsley-validated parsley-error"
											placeholder="Garantia Venda"
											data-original-title="Garantia pós venda (Meses)"
											data-toggle="tooltip" name="garantia"
											value="<?php echo $items_info->garantia;?>">
									</div>
								</div>

								<div class="form-group">
									<div class="col-sm-2 col-md-2 col-lg-2">
		              					<?php if (isset($items_info->unit) and $items_info->unit == ''){$items_info->unit = 'UN';}?>
		            	    				<select class="form-control"
											data-original-title="Unidade de Saída" data-toggle="tooltip"
											name="unit" style="border-color: red;">
											<option value="CX"
												<?php if (isset($items_info->unit) and $items_info->unit == 'CX') {echo 'selected="selected"';}?>>CX</option>
											<option value="EMB"
												<?php if (isset($items_info->unit) and $items_info->unit == 'EMB'){echo 'selected="selected"';}?>>EMB</option>
											<option value="KG"
												<?php if (isset($items_info->unit) and $items_info->unit == 'KG') {echo 'selected="selected"';}?>>KG</option>
											<option value="LT"
												<?php if (isset($items_info->unit) and $items_info->unit == 'LT') {echo 'selected="selected"';}?>>LT</option>
											<option value="PC"
												<?php if (isset($items_info->unit) and $items_info->unit == 'PC') {echo 'selected="selected"';}?>>PC</option>
											<option value="PCT"
												<?php if (isset($items_info->unit) and $items_info->unit == 'PCT'){echo 'selected="selected"';}?>>PCT</option>
											<option value="UN"
												<?php if (isset($items_info->unit) and $items_info->unit == 'UN') {echo 'selected="selected"';}?>>UN</option>
										</select>
									</div>
									<div class="col-sm-1 col-md-1 col-lg-1">
										<input type="text"
											class="form-control parsley-validated parsley-error"
											placeholder="Quantidade de Saída"
											data-original-title="Quantidade de Saída"
											data-toggle="tooltip" name="qunit"
											value="<?php echo $items_info->qunit;?>">
									</div>
									<div class="col-sm-3 col-md-3 col-lg-3">
	        		        				<?php echo form_dropdown('type',$item_type,array($items_info->type),'class="form-control" data-original-title="Tipo de produtos" data-toggle="tooltip"') ?>    	    	          								
		            	    			</div>
									<div class="col-sm-3 col-md-3 col-lg-3">
	        		        				<?php echo form_dropdown('category',$item_category,array($items_info->category),'class="form-control" data-original-title="categoria de produtos" data-toggle="tooltip" ') ?>   	    	          								
		            	    			</div>

									<div class="col-sm-3 col-md-3 col-lg-3"
										style="margin-top: 10px">
		            	    			
		            	    				<?php if($items_info->is_serialized == 1){ ?>
	    	    	          					<input type="checkbox" name="is_serialized"
											checked="checked" value="1"> É Serializado:    	    	          					
	    	    	          				&nbsp;&nbsp;&nbsp;&nbsp;
	    	    	          				<?php } else { ?>
	    	    	          				<input type="checkbox" name="is_serialized"
											value="1"> É Serializado:    	    	          					
	    	    	          				&nbsp;&nbsp;&nbsp;&nbsp;
	    	    	          				<?php } ?>
	    	    	          				
	    	    	          				<?php if($items_info->is_service == 1){ ?>
	    	    	          					<input type="checkbox" name="is_service"
											checked="checked" value="1"> É um Serviço:
	    	    	          				<?php } else { ?>
	    	    	          					<input type="checkbox" name="is_service"
											value="1"> É um Serviço:
	    	    	          				<?php }?>
		            	    			</div>

								</div>

								<div class="form-group">
									<hr>
								</div>

								<div class="form-group text-right">
									<button class="btn btn-primary btn-flat" type="button"
										onClick="document.getElementById('items_form').submit()"
										value="save">
										<i class="fa fa-check"></i> Salvar
									</button>
									<a class="btn btn-default btn-flat" type="button"
										href="<?php echo $this->config->site_url('items');?>"><i
										class="fa fa-times"></i> Cancelar</a>
								</div>
	          						
									<?php echo form_close();?>
									
								</div>
							<!----BASIC FORM END--->
						</div>
					</div>
					<!----PANEL ADD END--->


					<!----PANEL VALUE STARTS--->
					<div class="tab-pane <?php echo $value;?> cont" id="value">
						<div class="col-md-12 col-sm-12 col-lg-12">
							<div class="header ">
								<h3>Informa&#231;&#245;es Fornecedor</h3>
							</div>
							<hr>
							<!----BASIC FORM STARTS--->
							<div class="content">
									<?php
        echo form_open('items/save_business/' . $items_info->item_id, array(
            'id' => 'values_form',
            'class' => 'form-horizontal',
            'style' => 'border-radius: 0px;'
        ));
        ?>
									
									<div class="form-group">
									<div class="col-sm-1 col-md-1">
										<input type="text" class="form-control" readonly="readonly"
											name="item_id"
											value="<?php if(isset($items_info->item_id)){echo $items_info->item_id;}?>">
									</div>
									<div class="col-sm-4 col-md-4">
											<?php echo form_dropdown('supplier_id',$supplier,array($items_business->supplier_id),'class="form-control"') ?>    	    	          								
										</div>
								</div>

								<hr>
								<div class="header">
									<h4>Comercial</h4>
								</div>

								<div class="form-group">
									<div class="col-sm-1 col-md-1">&nbsp;</div>
									<div class="col-sm-2 col-md-2">
										<input type="text" class="form-control"
											placeholder="Custo última compra"
											data-original-title="Custo da última compra"
											data-toggle="tooltip" data-mask="#####00.00"
											data-mask-reverse="true" name="cost_of_last_purchase"
											value="<?php if(isset($items_business->cost_of_last_purchase)){echo get_float_view($items_business->cost_of_last_purchase);}?>">
									</div>
									<div class="col-sm-2 col-md-2">
										<input type="text" class="form-control" id="custo"
											placeholder="Preço de Custo"
											data-original-title="Preço de Custo" data-toggle="tooltip"
											data-mask="#####00.00" data-mask-reverse="true"
											name="cost_purchese"
											value="<?php if(isset($items_business->cost_purchese)){echo get_float_view($items_business->cost_purchese);}?>">
									</div>
									<div class="col-sm-5 col-md-5">&nbsp;</div>
									<div class="col-sm-2 col-md-2">
										<input type="text" class="form-control" id="margem"
											placeholder="Margem de Lucro"
											onchange="calcula_preco_real();"
											data-original-title="Margem de Lucro" data-toggle="tooltip"
											name="markup"
											value="<?php if(isset($items_business->markup)){echo $items_business->markup;}?>">
									</div>
								</div>

								<hr>
								<div class="header">
									<h4>Dados de Venda</h4>
								</div>

								<div class="form-group">
									<div class="col-sm-1 col-md-1">&nbsp;</div>
									<div class="col-sm-2 col-md-2">
										<input type="text" class="form-control" name="selling_price"
											placeholder="Preço de venda"
											onchange="calcula_margem_prat();"
											data-original-title="Preço de venda" id="venda"
											data-toggle="tooltip" data-mask="#####00.00"
											data-mask-reverse="true"
											value="<?php if(isset($items_business->selling_price)){echo get_float_view($items_business->selling_price);}?>">
									</div>
									<div class="col-sm-7 col-md-7">&nbsp;</div>
									<div class="col-sm-2 col-md-2">
										<input type="text" readonly="readonly" class="form-control"
											placeholder="Margem Praticada"
											data-original-title="Margem Praticada"
											onload="calcula_margem_prat();" id="margempraticada"
											data-toggle="tooltip" name="markup_practiced"
											value="<?php if(isset($items_business->markup_practiced)){echo $items_business->markup_practiced;}?>">
									</div>
								</div>

								<hr>
								<div class="form-group text-right">
									<button class="btn btn-primary btn-flat" type="button"
										onClick="document.getElementById('values_form').submit()"
										value="save">
										<i class="fa fa-check"></i> Salvar
									</button>
									<a class="btn btn-default btn-flat" type="button"
										href="<?php echo $this->config->site_url('items');?>"><i
										class="fa fa-times"></i> Cancelar</a>
								</div>
          							
             						<?php echo form_close();?>	
								</div>
							<!----BASIC FORM END--->
						</div>
					</div>
					<!----PANEL VALUE END--->


					<!----PANEL TAXES STARTS--->
					<div class="tab-pane <?php echo $taxes;?> cont" id="taxes">
						<div class="col-md-12 col-sm-12 col-lg-12">
							<div class="header ">
								<h3>Tributação</h3>
							</div>
							<hr>
							<!----BASIC FORM STARTS--->
							<div class="content">

								<div class="header ">
									<h4>CST</h4>
								</div>
									<?php
        echo form_open('items/save_nfe/' . $items_info->item_id, array(
            'id' => 'taxes_form',
            'class' => 'form-horizontal',
            'style' => 'border-radius: 0px;'
        ));
        ?>
									 
									<div class="form-group">
									<div class="col-sm-6 col-md-6 col-lg-6"
										style="display: inline-block;">
										<strong>Origem</strong>
											<?php
        
        if ($items_nfe->origem != '') {
            echo form_dropdown('origem', $data_origem, array(
                $items_nfe->origem
            ), 'class="form-control"');
        } else {
            $items_nfe->origem = 2;
            echo form_dropdown('origem', $data_origem, array(
                $items_nfe->origem
            ), 'class="form-control"');
        }
        ?>
										</div>
									<div class="col-sm-6 col-md-6 col-lg-6"
										style="display: inline-block;">
										<strong>Situação Tributária / CSOSN</strong>
											<?php
        if ($items_nfe->situacao_tributaria != '') {
            echo form_dropdown('stributaria', $situacao_tributaria, array(
                $items_nfe->situacao_tributaria
            ), 'class="form-control" id="stributaria2" onchange="habilita_bynum2(this);"');
        } else {
            $items_nfe->situacao_tributaria = 500;
            echo form_dropdown('stributaria', $situacao_tributaria, $items_nfe->situacao_tributaria, 'class="form-control" id="stributaria2" onchange="habilita_bynum2(this);"');
        }
        ?>
										</div>
								</div>
								<hr>

								<div class="header">
									<h4>ICMS</h4>
								</div>

								<div class="form-group">
									<div class="col-sm-12 col-md-12 col-lg-12"
										style="display: inline-block;">

										<div id="aliq_icms" class="col-sm-4 col-md-4 col-lg-4"
											style="display: none;">
											<h5>
												<strong>Alíquota ICMS:</strong>
											</h5>
											<input type="text" id="aliq_icms" data-mask="###.##"
												data-mask-reverse="true" dir="rtl" class="form-control"
												name="aliq_icms"
												value="<?php if (isset($items_nfe->aliq_icms)){echo $items_nfe->aliq_icms;}?>">
										</div>

										<div id="md_bc_icms" style="display: none;"
											class="col-sm-4 col-md-4 col-lg-4">
											<h5>
												<strong>Modalid. de determ. da BC ICMS:</strong>
											</h5>
											<select name="md_bc_icms" id="md_bc_icms"
												class="form-control">
												<option value="NULL"
													<?php if (isset($items_nfe->md_bc_icms) and $items_nfe->md_bc_icms == 'NULL')		{echo 'selected="selected"';}?>>
												</option>
												<option value="mva"
													<?php if (isset($items_nfe->md_bc_icms) and $items_nfe->md_bc_icms == 'mda')		{echo 'selected="selected"';}?>>Margem
													Valor Agregado</option>
												<option value="pauta"
													<?php if (isset($items_nfe->md_bc_icms) and $items_nfe->md_bc_icms == 'pauta')		{echo 'selected="selected"';}?>>Pauta
													(valor)</option>
												<option value="precotabmax"
													<?php if (isset($items_nfe->md_bc_icms) and $items_nfe->md_bc_icms == 'precotabmax'){echo 'selected="selected"';}?>>Preço
													Tabelado Max.</option>
												<option value="valorp"
													<?php if (isset($items_nfe->md_bc_icms) and $items_nfe->md_bc_icms == 'valorp')		{echo 'selected="selected"';}?>>Valor
													da Operação</option>
											</select>
										</div>

										<div id="red_bc_icms" style="display: none;"
											class="col-sm-4 col-md-4 col-lg-4">
											<h5>
												<strong>% Redução BC ICMS:</strong>
											</h5>
											<input type="text" data-mask="###.##"
												data-mask-reverse="true" dir="rtl" class="form-control"
												id="red_bc_icms" name="red_bc_icms"
												value="<?php if (isset($items_nfe->red_bc_icms)){echo $items_nfe->red_bc_icms;}?>">
										</div>

										<div id="bc_op_propria" class="col-sm-4 col-md-4 col-lg-4"
											style="display: none;">
											<h5>
												<strong>% BC da Op. Própria:</strong>
											</h5>
											<input type="text" data-mask="###.##"
												data-mask-reverse="true" dir="rtl" class="form-control"
												id="bc_op_propria" name="bc_op_propria"
												value="<?php if (isset($items_nfe->bc_op_propria)){echo $items_nfe->bc_op_propria;}?>">
										</div>

										<div id="md_bc_icms_st" style="display: none;"
											class="col-sm-4 col-md-4 col-lg-4">
											<h5>
												<strong>Modalid. de determ. da BC ICMS ST:</strong>
											</h5>
											<select name="md_bc_icms_st" id="md_bc_icms_st"
												class="form-control">
												<option value="NULL"
													<?php if (isset($items_nfe->md_bc_icms_st) and $items_nfe->md_bc_icms_st == 'NULL')		  {echo 'selected="selected"';}?>>
												</option>
												<option value="precotabelado"
													<?php if (isset($items_nfe->md_bc_icms_st) and $items_nfe->md_bc_icms_st == 'precotabelado'){echo 'selected="selected"';}?>>Preço
													Tabelado ou Máximo Sugerido</option>
												<option value="lpositiva"
													<?php if (isset($items_nfe->md_bc_icms_st) and $items_nfe->md_bc_icms_st == 'lpositiva')	  {echo 'selected="selected"';}?>>Lista
													Positiva (valor)</option>
												<option value="lnegativa"
													<?php if (isset($items_nfe->md_bc_icms_st) and $items_nfe->md_bc_icms_st == 'lnegativa')	  {echo 'selected="selected"';}?>>Lista
													Negativa (valor)</option>
												<option value="lneutra"
													<?php if (isset($items_nfe->md_bc_icms_st) and $items_nfe->md_bc_icms_st == 'lneutra')	  {echo 'selected="selected"';}?>>Lista
													neutra (valor)</option>
												<option value="margemva"
													<?php if (isset($items_nfe->md_bc_icms_st) and $items_nfe->md_bc_icms_st == 'margemva')	  {echo 'selected="selected"';}?>>Margem
													Valor Agregado (%)</option>
												<option value="pauta"
													<?php if (isset($items_nfe->md_bc_icms_st) and $items_nfe->md_bc_icms_st == 'pauta')		  {echo 'selected="selected"';}?>>Pauta
													(valor)</option>
											</select>
										</div>

										<div id="aliq_icms_st" class="col-sm-4 col-md-4 col-lg-4"
											style="display: none;">
											<h5>
												<strong>Alíquota ICMS ST:</strong>
											</h5>
											<input type="text" id="aliq_icms_st" data-mask="###.##"
												data-mask-reverse="true" dir="rtl" class="form-control"
												name="aliq_icms_st"
												value="<?php if (isset($items_nfe->aliq_icms_st)){echo $items_nfe->aliq_icms_st;}?>">
										</div>

										<div id="red_bc_icms_st" class="col-sm-4 col-md-4 col-lg-4"
											style="display: none;">
											<h5>
												<strong>% Redução BC ICMS ST:</strong>
											</h5>
											<input type="text" id="red_bc_icms_st" data-mask="###.##"
												data-mask-reverse="true" dir="rtl" class="form-control"
												name="red_bc_icms_st"
												value="<?php if (isset($items_nfe->red_bc_icms_st)){echo $items_nfe->red_bc_icms_st;}?>">
										</div>

										<div id="uf_icms_st" class="col-sm-4 col-md-4 col-lg-4"
											style="display: none;">
											<h5>
												<strong>UF ICMS ST:</strong>
											</h5><?php echo $uf;?>
			            	    					</div>

										<div id="margem_val_adc_icms_st"
											class="col-sm-4 col-md-4 col-lg-4" style="display: none;">
											<h5>
												<strong>% Margem Valor Adic. ICMS ST:</strong>
											</h5>
											<input type="text" id="margem_val_adc_icms_st"
												data-mask="###.##" data-mask-reverse="true" dir="rtl"
												class="form-control" name="margem_val_adc_icms_st"
												value="<?php if (isset($items_nfe->margem_val_adc_icms_st)){echo $items_nfe->margem_val_adc_icms_st;}?>">
										</div>

										<div id="motivo_desoneracao"
											class="col-sm-4 col-md-4 col-lg-4" style="display: none;">
											<h5>
												<strong>Motivo Desoneração ICMS:</strong>
											</h5>
											<select name="motivo_desoneracao" id="motivo_desoneracao"
												class="form-control">
												<option value="NULL"
													<?php if (isset($items_nfe->motivo_desoneracao) and $items_nfe->motivo_desoneracao == 'NULL'){echo 'selected="selected"';}?>>
												</option>
												<option value="taxi"
													<?php if (isset($items_nfe->motivo_desoneracao) and $items_nfe->motivo_desoneracao == 'taxi'){echo 'selected="selected"';}?>>Taxi</option>
												<option value="defisico"
													<?php if (isset($items_nfe->motivo_desoneracao) and $items_nfe->motivo_desoneracao == 'defisico'){echo 'selected="selected"';}?>>Deficiente
													Físico</option>
												<option value="frotista"
													<?php if (isset($items_nfe->motivo_desoneracao) and $items_nfe->motivo_desoneracao == 'frotista'){echo 'selected="selected"';}?>>Frotista/Locadora</option>
												<option value="dipconsular"
													<?php if (isset($items_nfe->motivo_desoneracao) and $items_nfe->motivo_desoneracao == 'dipconsular'){echo 'selected="selected"';}?>>Diplomático/Consular</option>
												<option value="umamazonia"
													<?php if (isset($items_nfe->motivo_desoneracao) and $items_nfe->motivo_desoneracao == 'umamazonia'){echo 'selected="selected"';}?>>Utilitários
													e Motocicletas da Amazônia Ocidental e Áreas de Livre
													Comércio (Resolução 714/88 e 790/94 – CONTRAN e suas
													alterações);</option>
												<option value="suframa"
													<?php if (isset($items_nfe->motivo_desoneracao) and $items_nfe->motivo_desoneracao == 'suframa'){echo 'selected="selected"';}?>>SUFRAMA</option>
												<option value="vendaop"
													<?php if (isset($items_nfe->motivo_desoneracao) and $items_nfe->motivo_desoneracao == 'vendaop'){echo 'selected="selected"';}?>>Venda
													à Órgãos Públicos</option>
												<option value="outros"
													<?php if (isset($items_nfe->motivo_desoneracao) and $items_nfe->motivo_desoneracao == 'outros'){echo 'selected="selected"';}?>>Outros</option>
											</select>
										</div>

										<div id="aliq_aplic_calc_cred"
											class="col-sm-4 col-md-4 col-lg-4" style="display: none;">
											<h5>
												<strong>Alíq. Aplicável Calc. Crédito:</strong>
											</h5>
											<input type="text" id="aliq_aplic_calc_cred"
												data-mask="###.##" data-mask-reverse="true" dir="rtl"
												class="form-control"
												value="<?php if (isset($items_nfe->aliq_aplic_calc_cred)){echo $items_nfe->aliq_aplic_calc_cred;}?>"
												name="aliq_aplic_calc_cred">
										</div>
									</div>
								</div>

								<hr>
								<div class="header">
									<h4>PIS / CONFINS</h4>
								</div>

								<div class="form-group">

									<div class="col-sm-4 col-md-4 col-lg-4">
										<h5>
											<strong>CST-PIS:</strong>
										</h5>
												<?php if ($items_nfe->cst_pis == ''){$items_nfe->cst_pis = '99';}?>
    	    	          						<select class="form-control" name="cstpis">
											<option value="NULL"></option>
											<option value="01"
												<?php if (isset($items_nfe->cst_pis) and $items_nfe->cst_pis == '01'){echo 'selected="selected"';}?>>01
												- Operação Tributável com Alíquota Básica</option>
											<option value="02"
												<?php if (isset($items_nfe->cst_pis) and $items_nfe->cst_pis == '02'){echo 'selected="selected"';}?>>02
												- Operação Tributável com Alíquota Diferenciada</option>
											<option value="03"
												<?php if (isset($items_nfe->cst_pis) and $items_nfe->cst_pis == '03'){echo 'selected="selected"';}?>>03
												- Operação Tributável com Alíquota por Unidade de Medida de
												Produto</option>
											<option value="04"
												<?php if (isset($items_nfe->cst_pis) and $items_nfe->cst_pis == '04'){echo 'selected="selected"';}?>>04
												- Operação Tributável Monofásica - Revenda a Alíquota Zero</option>
											<option value="05"
												<?php if (isset($items_nfe->cst_pis) and $items_nfe->cst_pis == '05'){echo 'selected="selected"';}?>>05
												- Operação Tributável por Substituição Tributária</option>
											<option value="06"
												<?php if (isset($items_nfe->cst_pis) and $items_nfe->cst_pis == '06'){echo 'selected="selected"';}?>>06
												- Operação Tributável a Alíquota Zero</option>
											<option value="07"
												<?php if (isset($items_nfe->cst_pis) and $items_nfe->cst_pis == '07'){echo 'selected="selected"';}?>>07
												- Operação Isenta da Contribuição</option>
											<option value="08"
												<?php if (isset($items_nfe->cst_pis) and $items_nfe->cst_pis == '08'){echo 'selected="selected"';}?>>08
												- Operação sem Incidência da Contribuição</option>
											<option value="09"
												<?php if (isset($items_nfe->cst_pis) and $items_nfe->cst_pis == '09'){echo 'selected="selected"';}?>>09
												- Operação com Suspensão da Contribuição</option>
											<option value="49"
												<?php if (isset($items_nfe->cst_pis) and $items_nfe->cst_pis == '49'){echo 'selected="selected"';}?>>49
												- Outras Operações de Saída</option>
											<option value="50"
												<?php if (isset($items_nfe->cst_pis) and $items_nfe->cst_pis == '50'){echo 'selected="selected"';}?>>50
												- Operação com Direito a Crédito - Vinculada Exclusivamente
												a Receita Tributada no Mercado Interno</option>
											<option value="51"
												<?php if (isset($items_nfe->cst_pis) and $items_nfe->cst_pis == '51'){echo 'selected="selected"';}?>>51
												- Operação com Direito a Crédito – Vinculada Exclusivamente
												a Receita Não Tributada no Mercado Interno</option>
											<option value="52"
												<?php if (isset($items_nfe->cst_pis) and $items_nfe->cst_pis == '52'){echo 'selected="selected"';}?>>52
												- Operação com Direito a Crédito - Vinculada Exclusivamente
												a Receita de Exportação</option>
											<option value="53"
												<?php if (isset($items_nfe->cst_pis) and $items_nfe->cst_pis == '53'){echo 'selected="selected"';}?>>53
												- Operação com Direito a Crédito - Vinculada a Receitas
												Tributadas e Não-Tributadas no Mercado Interno</option>
											<option value="54"
												<?php if (isset($items_nfe->cst_pis) and $items_nfe->cst_pis == '54'){echo 'selected="selected"';}?>>54
												- Operação com Direito a Crédito - Vinculada a Receitas
												Tributadas no Mercado Interno e de Exportação</option>
											<option value="55"
												<?php if (isset($items_nfe->cst_pis) and $items_nfe->cst_pis == '55'){echo 'selected="selected"';}?>>55
												- Operação com Direito a Crédito - Vinculada a Receitas
												Não-Tributadas no Mercado Interno e de Exportação</option>
											<option value="56"
												<?php if (isset($items_nfe->cst_pis) and $items_nfe->cst_pis == '56'){echo 'selected="selected"';}?>>56
												- Operação com Direito a Crédito - Vinculada a Receitas
												Tributadas e Não-Tributadas no Mercado Interno, e de
												Exportação</option>
											<option value="60"
												<?php if (isset($items_nfe->cst_pis) and $items_nfe->cst_pis == '60'){echo 'selected="selected"';}?>>60
												- Crédito Presumido - Operação de Aquisição Vinculada
												Exclusivamente a Receita Tributada no Mercado Interno</option>
											<option value="61"
												<?php if (isset($items_nfe->cst_pis) and $items_nfe->cst_pis == '61'){echo 'selected="selected"';}?>>61
												- Crédito Presumido - Operação de Aquisição Vinculada
												Exclusivamente a Receita Não-Tributada no Mercado Interno</option>
											<option value="62"
												<?php if (isset($items_nfe->cst_pis) and $items_nfe->cst_pis == '62'){echo 'selected="selected"';}?>>62
												- Crédito Presumido - Operação de Aquisição Vinculada
												Exclusivamente a Receita de Exportação</option>
											<option value="63"
												<?php if (isset($items_nfe->cst_pis) and $items_nfe->cst_pis == '63'){echo 'selected="selected"';}?>>63
												- Crédito Presumido - Operação de Aquisição Vinculada a
												Receitas Tributadas e Não-Tributadas no Mercado Interno</option>
											<option value="64"
												<?php if (isset($items_nfe->cst_pis) and $items_nfe->cst_pis == '64'){echo 'selected="selected"';}?>>64
												- Crédito Presumido - Operação de Aquisição Vinculada a
												Receitas Tributadas no Mercado Interno e de Exportação</option>
											<option value="65"
												<?php if (isset($items_nfe->cst_pis) and $items_nfe->cst_pis == '65'){echo 'selected="selected"';}?>>65
												- Crédito Presumido - Operação de Aquisição Vinculada a
												Receitas Não-Tributadas no Mercado Interno e de Exportação</option>
											<option value="66"
												<?php if (isset($items_nfe->cst_pis) and $items_nfe->cst_pis == '66'){echo 'selected="selected"';}?>>66
												- Crédito Presumido - Operação de Aquisição Vinculada a
												Receitas Tributadas e Não-Tributadas no Mercado Interno, e
												de Exportação</option>
											<option value="67"
												<?php if (isset($items_nfe->cst_pis) and $items_nfe->cst_pis == '67'){echo 'selected="selected"';}?>>67
												- Crédito Presumido - Outras Operações</option>
											<option value="70"
												<?php if (isset($items_nfe->cst_pis) and $items_nfe->cst_pis == '70'){echo 'selected="selected"';}?>>70
												- Operação de Aquisição sem Direito a Crédito</option>
											<option value="71"
												<?php if (isset($items_nfe->cst_pis) and $items_nfe->cst_pis == '71'){echo 'selected="selected"';}?>>71
												- Operação de Aquisição com Isenção</option>
											<option value="72"
												<?php if (isset($items_nfe->cst_pis) and $items_nfe->cst_pis == '72'){echo 'selected="selected"';}?>>72
												- Operação de Aquisição com Suspensão</option>
											<option value="73"
												<?php if (isset($items_nfe->cst_pis) and $items_nfe->cst_pis == '73'){echo 'selected="selected"';}?>>73
												- Operação de Aquisição a Alíquota Zero</option>
											<option value="74"
												<?php if (isset($items_nfe->cst_pis) and $items_nfe->cst_pis == '74'){echo 'selected="selected"';}?>>74
												- Operação de Aquisição sem Incidência da Contribuição</option>
											<option value="75"
												<?php if (isset($items_nfe->cst_pis) and $items_nfe->cst_pis == '75'){echo 'selected="selected"';}?>>75
												- Operação de Aquisição por Substituição Tributária</option>
											<option value="98"
												<?php if (isset($items_nfe->cst_pis) and $items_nfe->cst_pis == '98'){echo 'selected="selected"';}?>>98
												- Outras Operações de Entrada</option>
											<option value="99"
												<?php if (isset($items_nfe->cst_pis) and $items_nfe->cst_pis == '99'){echo 'selected="selected"';}?>>99
												- Outras Operações</option>
										</select>
									</div>
									<div class="col-sm-4 col-md-4 col-lg-4">
										<h5>
											<strong>CST-COFINS:</strong>
										</h5>
												<?php if ($items_nfe->cst_confins == ''){$items_nfe->cst_confins = '99';}?>
    	    	          						<select class="form-control" name="cstconfins">
											<option value="NULL"
												<?php if (isset($items_nfe->cst_confins) and $items_nfe->cst_confins == 'NULL'){echo 'selected="selected"';}?>>
											</option>
											<option value="01"
												<?php if (isset($items_nfe->cst_confins) and $items_nfe->cst_confins == '01'){echo 'selected="selected"';}?>>01
												- Operação Tributável com Alíquota Básica</option>
											<option value="02"
												<?php if (isset($items_nfe->cst_confins) and $items_nfe->cst_confins == '02'){echo 'selected="selected"';}?>>02
												- Operação Tributável com Alíquota Diferenciada</option>
											<option value="03"
												<?php if (isset($items_nfe->cst_confins) and $items_nfe->cst_confins == '03'){echo 'selected="selected"';}?>>03
												- Operação Tributável com Alíquota por Unidade de Medida de
												Produto</option>
											<option value="04"
												<?php if (isset($items_nfe->cst_confins) and $items_nfe->cst_confins == '04'){echo 'selected="selected"';}?>>04
												- Operação Tributável Monofásica - Revenda a Alíquota Zero</option>
											<option value="05"
												<?php if (isset($items_nfe->cst_confins) and $items_nfe->cst_confins == '05'){echo 'selected="selected"';}?>>05
												- Operação Tributável por Substituição Tributária</option>
											<option value="06"
												<?php if (isset($items_nfe->cst_confins) and $items_nfe->cst_confins == '06'){echo 'selected="selected"';}?>>06
												- Operação Tributável a Alíquota Zero</option>
											<option value="07"
												<?php if (isset($items_nfe->cst_confins) and $items_nfe->cst_confins == '07'){echo 'selected="selected"';}?>>07
												- Operação Isenta da Contribuição</option>
											<option value="08"
												<?php if (isset($items_nfe->cst_confins) and $items_nfe->cst_confins == '08'){echo 'selected="selected"';}?>>08
												- Operação sem Incidência da Contribuição</option>
											<option value="09"
												<?php if (isset($items_nfe->cst_confins) and $items_nfe->cst_confins == '09'){echo 'selected="selected"';}?>>09
												- Operação com Suspensão da Contribuição</option>
											<option value="49"
												<?php if (isset($items_nfe->cst_confins) and $items_nfe->cst_confins == '49'){echo 'selected="selected"';}?>>49
												- Outras Operações de Saída</option>
											<option value="50"
												<?php if (isset($items_nfe->cst_confins) and $items_nfe->cst_confins == '50'){echo 'selected="selected"';}?>>50
												- Operação com Direito a Crédito - Vinculada Exclusivamente
												a Receita Tributada no Mercado Interno</option>
											<option value="51"
												<?php if (isset($items_nfe->cst_confins) and $items_nfe->cst_confins == '51'){echo 'selected="selected"';}?>>51
												- Operação com Direito a Crédito – Vinculada Exclusivamente
												a Receita Não Tributada no Mercado Interno</option>
											<option value="52"
												<?php if (isset($items_nfe->cst_confins) and $items_nfe->cst_confins == '52'){echo 'selected="selected"';}?>>52
												- Operação com Direito a Crédito - Vinculada Exclusivamente
												a Receita de Exportação</option>
											<option value="53"
												<?php if (isset($items_nfe->cst_confins) and $items_nfe->cst_confins == '53'){echo 'selected="selected"';}?>>53
												- Operação com Direito a Crédito - Vinculada a Receitas
												Tributadas e Não-Tributadas no Mercado Interno</option>
											<option value="54"
												<?php if (isset($items_nfe->cst_confins) and $items_nfe->cst_confins == '54'){echo 'selected="selected"';}?>>54
												- Operação com Direito a Crédito - Vinculada a Receitas
												Tributadas no Mercado Interno e de Exportação</option>
											<option value="55"
												<?php if (isset($items_nfe->cst_confins) and $items_nfe->cst_confins == '55'){echo 'selected="selected"';}?>>55
												- Operação com Direito a Crédito - Vinculada a Receitas
												Não-Tributadas no Mercado Interno e de Exportação</option>
											<option value="56"
												<?php if (isset($items_nfe->cst_confins) and $items_nfe->cst_confins == '56'){echo 'selected="selected"';}?>>56
												- Operação com Direito a Crédito - Vinculada a Receitas
												Tributadas e Não-Tributadas no Mercado Interno, e de
												Exportação</option>
											<option value="60"
												<?php if (isset($items_nfe->cst_confins) and $items_nfe->cst_confins == '60'){echo 'selected="selected"';}?>>60
												- Crédito Presumido - Operação de Aquisição Vinculada
												Exclusivamente a Receita Tributada no Mercado Interno</option>
											<option value="61"
												<?php if (isset($items_nfe->cst_confins) and $items_nfe->cst_confins == '61'){echo 'selected="selected"';}?>>61
												- Crédito Presumido - Operação de Aquisição Vinculada
												Exclusivamente a Receita Não-Tributada no Mercado Interno</option>
											<option value="62"
												<?php if (isset($items_nfe->cst_confins) and $items_nfe->cst_confins == '62'){echo 'selected="selected"';}?>>62
												- Crédito Presumido - Operação de Aquisição Vinculada
												Exclusivamente a Receita de Exportação</option>
											<option value="63"
												<?php if (isset($items_nfe->cst_confins) and $items_nfe->cst_confins == '63'){echo 'selected="selected"';}?>>63
												- Crédito Presumido - Operação de Aquisição Vinculada a
												Receitas Tributadas e Não-Tributadas no Mercado Interno</option>
											<option value="64"
												<?php if (isset($items_nfe->cst_confins) and $items_nfe->cst_confins == '64'){echo 'selected="selected"';}?>>64
												- Crédito Presumido - Operação de Aquisição Vinculada a
												Receitas Tributadas no Mercado Interno e de Exportação</option>
											<option value="65"
												<?php if (isset($items_nfe->cst_confins) and $items_nfe->cst_confins == '65'){echo 'selected="selected"';}?>>65
												- Crédito Presumido - Operação de Aquisição Vinculada a
												Receitas Não-Tributadas no Mercado Interno e de Exportação</option>
											<option value="66"
												<?php if (isset($items_nfe->cst_confins) and $items_nfe->cst_confins == '66'){echo 'selected="selected"';}?>>66
												- Crédito Presumido - Operação de Aquisição Vinculada a
												Receitas Tributadas e Não-Tributadas no Mercado Interno, e
												de Exportação</option>
											<option value="67"
												<?php if (isset($items_nfe->cst_confins) and $items_nfe->cst_confins == '67'){echo 'selected="selected"';}?>>67
												- Crédito Presumido - Outras Operações</option>
											<option value="70"
												<?php if (isset($items_nfe->cst_confins) and $items_nfe->cst_confins == '70'){echo 'selected="selected"';}?>>70
												- Operação de Aquisição sem Direito a Crédito</option>
											<option value="71"
												<?php if (isset($items_nfe->cst_confins) and $items_nfe->cst_confins == '71'){echo 'selected="selected"';}?>>71
												- Operação de Aquisição com Isenção</option>
											<option value="72"
												<?php if (isset($items_nfe->cst_confins) and $items_nfe->cst_confins == '72'){echo 'selected="selected"';}?>>72
												- Operação de Aquisição com Suspensão</option>
											<option value="73"
												<?php if (isset($items_nfe->cst_confins) and $items_nfe->cst_confins == '73'){echo 'selected="selected"';}?>>73
												- Operação de Aquisição a Alíquota Zero</option>
											<option value="74"
												<?php if (isset($items_nfe->cst_confins) and $items_nfe->cst_confins == '74'){echo 'selected="selected"';}?>>74
												- Operação de Aquisição sem Incidência da Contribuição</option>
											<option value="75"
												<?php if (isset($items_nfe->cst_confins) and $items_nfe->cst_confins == '75'){echo 'selected="selected"';}?>>75
												- Operação de Aquisição por Substituição Tributária</option>
											<option value="98"
												<?php if (isset($items_nfe->cst_confins) and $items_nfe->cst_confins == '98'){echo 'selected="selected"';}?>>98
												- Outras Operações de Entrada</option>
											<option value="99"
												<?php if (isset($items_nfe->cst_confins) and $items_nfe->cst_confins == '99'){echo 'selected="selected"';}?>>99
												- Outras Operações</option>
										</select>
									</div>

									<div class="col-sm-4 col-md-4 col-lg-4">
										<h5>
											<strong>CST-IPI:</strong>
										</h5>
	            	    						<?php if ($items_nfe->cst_ipi == ''){$items_nfe->cst_ipi = '99';}?>
    	    	          						<select class="form-control" name="cstipi">
											<option value="NULL"></option>
											<option value="00"
												<?php if (isset($items_nfe->cst_ipi) and $items_nfe->cst_ipi == '00'){echo 'selected="selected"';}?>>00
												- Entrada com Recuperação de Crédito</option>
											<option value="01"
												<?php if (isset($items_nfe->cst_ipi) and $items_nfe->cst_ipi == '01'){echo 'selected="selected"';}?>>01
												- Entrada Tributável com Alíquota Zero</option>
											<option value="02"
												<?php if (isset($items_nfe->cst_ipi) and $items_nfe->cst_ipi == '02'){echo 'selected="selected"';}?>>02
												- Entrada Isenta</option>
											<option value="03"
												<?php if (isset($items_nfe->cst_ipi) and $items_nfe->cst_ipi == '03'){echo 'selected="selected"';}?>>03
												- Entrada Não-Tributada</option>
											<option value="04"
												<?php if (isset($items_nfe->cst_ipi) and $items_nfe->cst_ipi == '04'){echo 'selected="selected"';}?>>04
												- Entrada Imune</option>
											<option value="05"
												<?php if (isset($items_nfe->cst_ipi) and $items_nfe->cst_ipi == '05'){echo 'selected="selected"';}?>>05
												- Entrada com Suspensão</option>
											<option value="49"
												<?php if (isset($items_nfe->cst_ipi) and $items_nfe->cst_ipi == '49'){echo 'selected="selected"';}?>>49
												- Outras Entradas</option>
											<option value="50"
												<?php if (isset($items_nfe->cst_ipi) and $items_nfe->cst_ipi == '50'){echo 'selected="selected"';}?>>50
												- Saída Tributada</option>
											<option value="51"
												<?php if (isset($items_nfe->cst_ipi) and $items_nfe->cst_ipi == '51'){echo 'selected="selected"';}?>>51
												- Saída Tributável com Alíquota Zero</option>
											<option value="52"
												<?php if (isset($items_nfe->cst_ipi) and $items_nfe->cst_ipi == '52'){echo 'selected="selected"';}?>>52
												- Saída Isenta</option>
											<option value="53"
												<?php if (isset($items_nfe->cst_ipi) and $items_nfe->cst_ipi == '53'){echo 'selected="selected"';}?>>53
												- Saída Não-Tributada</option>
											<option value="54"
												<?php if (isset($items_nfe->cst_ipi) and $items_nfe->cst_ipi == '54'){echo 'selected="selected"';}?>>54
												- Saída Imune</option>
											<option value="55"
												<?php if (isset($items_nfe->cst_ipi) and $items_nfe->cst_ipi == '55'){echo 'selected="selected"';}?>>55
												- Saída com Suspensão</option>
											<option value="99"
												<?php if (isset($items_nfe->cst_ipi) and $items_nfe->cst_ipi == '99'){echo 'selected="selected"';}?>>99
												- Outras Saídas</option>
										</select>
									</div>

								</div>

								<hr>

								<div class="form-group text-right">
									<button class="btn btn-primary btn-flat" type="button"
										onClick="document.getElementById('taxes_form').submit();"
										value="save">
										<i class="fa fa-check"></i> Salvar
									</button>
									<a class="btn btn-default btn-flat" type="button"
										href="<?php echo $this->config->site_url('items');?>"><i
										class="fa fa-times"></i> Cancelar</a>
								</div>
          								 
									<?php echo form_close();?>
								</div>
							<!----BASIC FORM END--->
						</div>
					</div>
					<!----PANEL TAXES END--->

				</div>


			</div>


		</div>
		<!---- END ROW --->
	</div>

</div>





<script type="text/javascript">

function calcula_preco_real()
{
	var a = document.getElementById('margem').value; 
	var margem = document.getElementById('margem').value;
	var custo = parseFloat(document.getElementById('custo').value);
	
	document.getElementById('venda').value = (custo+(custo*(margem/100))).toFixed(2);

}

function calcula_margem_prat()
{
	var custo = parseFloat(document.getElementById('custo').value);
	var venda = parseFloat(document.getElementById('venda').value);

	document.getElementById('margempraticada').value = ((100*(venda-custo))/custo).toFixed(2);
	
}




									 
function change_situacao(e)
{
	if(e.selectedIndex == 0)
	{
		document.getElementById('divstr2').style.display='none';
		document.getElementById('stributaria2').disabled = true

		document.getElementById('divstr1').style.display='inline-block';
		document.getElementById('stributaria1').disabled = false;
	}
	else if (e.selectedIndex == 1) 
	{
		document.getElementById('divstr1').style.display='none';
		document.getElementById('stributaria1').disabled = true;

		document.getElementById('divstr2').style.display='inline-block';
		document.getElementById('stributaria2').disabled = false
	}
	
	
}

/****** Lista de IDs *******|
 * -------------------------|
 * - md_bc_icms				|
 * - md_bc_icms_st			|
 * - aliq_icms				|
 * - aliq_icms_st			|
 * - red_bc_icms			|
 * - red_bc_icms_st			|
 * - margem_val_adc_icms_st	|
 * - bc_op_propria			|
 * - uf_icms_st				|
 * - motivo_desoneracao		|
 ***************************/
function habilita_bynum(e)
{
	switch(e.selectedIndex)
	{
		case 0: // VAZIO
			
			document.getElementById('md_bc_icms').style.display='none';
			document.getElementById('md_bc_icms_st').style.display='none';
			document.getElementById('aliq_icms').style.display='none';
			document.getElementById('aliq_icms_st').style.display='none';
			document.getElementById('red_bc_icms').style.display='none';
			document.getElementById('red_bc_icms_st').style.display='none';
			document.getElementById('margem_val_adc_icms_st').style.display='none';
			document.getElementById('bc_op_propria').style.display='none';
			document.getElementById('uf_icms_st').style.display='none';
			document.getElementById('motivo_desoneracao').style.display='none';
			document.getElementById('aliq_aplic_calc_cred').style.display='none';
			break;
			
		case 1: // 00
			
			document.getElementById('md_bc_icms').style.display='block';
			document.getElementById('md_bc_icms_st').style.display='none';
			document.getElementById('aliq_icms').style.display='block';
			document.getElementById('aliq_icms_st').style.display='none';
			document.getElementById('red_bc_icms').style.display='none';
			document.getElementById('red_bc_icms_st').style.display='none';
			document.getElementById('margem_val_adc_icms_st').style.display='none';
			document.getElementById('bc_op_propria').style.display='none';
			document.getElementById('uf_icms_st').style.display='none';
			document.getElementById('motivo_desoneracao').style.display='none';
			document.getElementById('aliq_aplic_calc_cred').style.display='none';
			break;
		
		case 2: // 10a
		
			document.getElementById('md_bc_icms').style.display='block';
			document.getElementById('md_bc_icms_st').style.display='block';
			document.getElementById('aliq_icms').style.display='block';
			document.getElementById('aliq_icms_st').style.display='block';
			document.getElementById('red_bc_icms').style.display='none';
			document.getElementById('red_bc_icms_st').style.display='block';
			document.getElementById('margem_val_adc_icms_st').style.display='block';
			document.getElementById('bc_op_propria').style.display='none';
			document.getElementById('uf_icms_st').style.display='none';
			document.getElementById('motivo_desoneracao').style.display='none';
			document.getElementById('aliq_aplic_calc_cred').style.display='none';
			break;
		
		case 3: // 10b
		
			document.getElementById('md_bc_icms').style.display='block';
			document.getElementById('md_bc_icms_st').style.display='block';
			document.getElementById('aliq_icms').style.display='block';
			document.getElementById('aliq_icms_st').style.display='block';
			document.getElementById('red_bc_icms').style.display='block';
			document.getElementById('red_bc_icms_st').style.display='block';
			document.getElementById('margem_val_adc_icms_st').style.display='block';
			document.getElementById('bc_op_propria').style.display='block';
			document.getElementById('uf_icms_st').style.display='block';
			document.getElementById('motivo_desoneracao').style.display='none';
			document.getElementById('aliq_aplic_calc_cred').style.display='none';
			break;
			
		case 4: // 20
			
			document.getElementById('md_bc_icms').style.display='block';//
			document.getElementById('md_bc_icms_st').style.display='none';
			document.getElementById('aliq_icms').style.display='block';//
			document.getElementById('aliq_icms_st').style.display='none';
			document.getElementById('red_bc_icms').style.display='block';//
			document.getElementById('red_bc_icms_st').style.display='none';
			document.getElementById('margem_val_adc_icms_st').style.display='none';
			document.getElementById('bc_op_propria').style.display='none';
			document.getElementById('uf_icms_st').style.display='none';
			document.getElementById('motivo_desoneracao').style.display='none';
			document.getElementById('aliq_aplic_calc_cred').style.display='none';
			break;

		case 5: // 30
			
			document.getElementById('md_bc_icms').style.display='none';
			document.getElementById('md_bc_icms_st').style.display='block';//
			document.getElementById('aliq_icms').style.display='none';
			document.getElementById('aliq_icms_st').style.display='block';//
			document.getElementById('red_bc_icms').style.display='none';
			document.getElementById('red_bc_icms_st').style.display='block';//
			document.getElementById('margem_val_adc_icms_st').style.display='block';//
			document.getElementById('bc_op_propria').style.display='none';
			document.getElementById('uf_icms_st').style.display='none';
			document.getElementById('motivo_desoneracao').style.display='none';
			document.getElementById('aliq_aplic_calc_cred').style.display='none';
			break;

		case 6: // 40
			
			document.getElementById('md_bc_icms').style.display='none';
			document.getElementById('md_bc_icms_st').style.display='none';
			document.getElementById('aliq_icms').style.display='none';
			document.getElementById('aliq_icms_st').style.display='none';
			document.getElementById('red_bc_icms').style.display='none';
			document.getElementById('red_bc_icms_st').style.display='none';
			document.getElementById('margem_val_adc_icms_st').style.display='none';
			document.getElementById('bc_op_propria').style.display='none';
			document.getElementById('uf_icms_st').style.display='none';
			document.getElementById('motivo_desoneracao').style.display='block';//
			document.getElementById('aliq_aplic_calc_cred').style.display='none';
			break;

		case 7: // 41a
			
			document.getElementById('md_bc_icms').style.display='none';
			document.getElementById('md_bc_icms_st').style.display='none';
			document.getElementById('aliq_icms').style.display='none';
			document.getElementById('aliq_icms_st').style.display='none';
			document.getElementById('red_bc_icms').style.display='none';
			document.getElementById('red_bc_icms_st').style.display='none';
			document.getElementById('margem_val_adc_icms_st').style.display='none';
			document.getElementById('bc_op_propria').style.display='none';
			document.getElementById('uf_icms_st').style.display='none';
			document.getElementById('motivo_desoneracao').style.display='block';//
			document.getElementById('aliq_aplic_calc_cred').style.display='none';
			break;

		case 8: // 41b
			
			document.getElementById('md_bc_icms').style.display='none';
			document.getElementById('md_bc_icms_st').style.display='none';
			document.getElementById('aliq_icms').style.display='none';
			document.getElementById('aliq_icms_st').style.display='none';
			document.getElementById('red_bc_icms').style.display='none';
			document.getElementById('red_bc_icms_st').style.display='none';
			document.getElementById('margem_val_adc_icms_st').style.display='none';
			document.getElementById('bc_op_propria').style.display='none';
			document.getElementById('uf_icms_st').style.display='none';
			document.getElementById('motivo_desoneracao').style.display='none';
			document.getElementById('aliq_aplic_calc_cred').style.display='none';
			break;

		case 9: // 50
			
			document.getElementById('md_bc_icms').style.display='none';
			document.getElementById('md_bc_icms_st').style.display='none';
			document.getElementById('aliq_icms').style.display='none';
			document.getElementById('aliq_icms_st').style.display='none';
			document.getElementById('red_bc_icms').style.display='none';
			document.getElementById('red_bc_icms_st').style.display='none';
			document.getElementById('margem_val_adc_icms_st').style.display='none';
			document.getElementById('bc_op_propria').style.display='none';
			document.getElementById('uf_icms_st').style.display='none';
			document.getElementById('motivo_desoneracao').style.display='block';//
			document.getElementById('aliq_aplic_calc_cred').style.display='none';
			break;

		case 10: // 51
			
			document.getElementById('md_bc_icms').style.display='block';//
			document.getElementById('md_bc_icms_st').style.display='none';
			document.getElementById('aliq_icms').style.display='block';//
			document.getElementById('aliq_icms_st').style.display='none';
			document.getElementById('red_bc_icms').style.display='block';//
			document.getElementById('red_bc_icms_st').style.display='none';
			document.getElementById('margem_val_adc_icms_st').style.display='none';
			document.getElementById('bc_op_propria').style.display='none';
			document.getElementById('uf_icms_st').style.display='none';
			document.getElementById('motivo_desoneracao').style.display='block';//
			document.getElementById('aliq_aplic_calc_cred').style.display='none';
			break;

		case 11: // 60
			
			document.getElementById('md_bc_icms').style.display='none';
			document.getElementById('md_bc_icms_st').style.display='none';
			document.getElementById('aliq_icms').style.display='none';
			document.getElementById('aliq_icms_st').style.display='none';
			document.getElementById('red_bc_icms').style.display='none';
			document.getElementById('red_bc_icms_st').style.display='none';
			document.getElementById('margem_val_adc_icms_st').style.display='none';
			document.getElementById('bc_op_propria').style.display='none';
			document.getElementById('uf_icms_st').style.display='none';
			document.getElementById('motivo_desoneracao').style.display='none';
			document.getElementById('aliq_aplic_calc_cred').style.display='none';
			break;

		case 12: // 70
			
			document.getElementById('md_bc_icms').style.display='block';
			document.getElementById('md_bc_icms_st').style.display='block';
			document.getElementById('aliq_icms').style.display='block';
			document.getElementById('aliq_icms_st').style.display='block';
			document.getElementById('red_bc_icms').style.display='block';
			document.getElementById('red_bc_icms_st').style.display='block';
			document.getElementById('margem_val_adc_icms_st').style.display='block';
			document.getElementById('bc_op_propria').style.display='none';
			document.getElementById('uf_icms_st').style.display='none';
			document.getElementById('motivo_desoneracao').style.display='none';
			document.getElementById('aliq_aplic_calc_cred').style.display='none';
			break;
			
		case 13: // 90a
			
			document.getElementById('md_bc_icms').style.display='block';
			document.getElementById('md_bc_icms_st').style.display='block';
			document.getElementById('aliq_icms').style.display='block';
			document.getElementById('aliq_icms_st').style.display='block';
			document.getElementById('red_bc_icms').style.display='block';
			document.getElementById('red_bc_icms_st').style.display='block';
			document.getElementById('margem_val_adc_icms_st').style.display='block';
			document.getElementById('bc_op_propria').style.display='block';
			document.getElementById('uf_icms_st').style.display='block';
			document.getElementById('motivo_desoneracao').style.display='none';
			document.getElementById('aliq_aplic_calc_cred').style.display='none';
			break;

		case 14: // 90b
			
			document.getElementById('md_bc_icms').style.display='block';
			document.getElementById('md_bc_icms_st').style.display='block';
			document.getElementById('aliq_icms').style.display='block';
			document.getElementById('aliq_icms_st').style.display='block';
			document.getElementById('red_bc_icms').style.display='block';
			document.getElementById('red_bc_icms_st').style.display='block';
			document.getElementById('margem_val_adc_icms_st').style.display='block';
			document.getElementById('bc_op_propria').style.display='none';
			document.getElementById('uf_icms_st').style.display='none';
			document.getElementById('motivo_desoneracao').style.display='none';
			document.getElementById('aliq_aplic_calc_cred').style.display='none';
			break;
						
		
	}

	
}

function habilita_bynum2(e)
{
	switch(e.selectedIndex)
	{
			
		case 0: // 101
			
			document.getElementById('md_bc_icms').style.display='none';
			document.getElementById('md_bc_icms_st').style.display='none';
			document.getElementById('aliq_icms').style.display='none';
			document.getElementById('aliq_icms_st').style.display='none';
			document.getElementById('red_bc_icms').style.display='none';
			document.getElementById('red_bc_icms_st').style.display='none';
			document.getElementById('margem_val_adc_icms_st').style.display='none';
			document.getElementById('bc_op_propria').style.display='none';
			document.getElementById('uf_icms_st').style.display='none';
			document.getElementById('motivo_desoneracao').style.display='none';
			document.getElementById('aliq_aplic_calc_cred').style.display='block';
			break;
		
		case 1: // 102
		
			document.getElementById('md_bc_icms').style.display='none';
			document.getElementById('md_bc_icms_st').style.display='none';
			document.getElementById('aliq_icms').style.display='none';
			document.getElementById('aliq_icms_st').style.display='none';
			document.getElementById('red_bc_icms').style.display='none';
			document.getElementById('red_bc_icms_st').style.display='none';
			document.getElementById('margem_val_adc_icms_st').style.display='none';
			document.getElementById('bc_op_propria').style.display='none';
			document.getElementById('uf_icms_st').style.display='none';
			document.getElementById('motivo_desoneracao').style.display='none';
			document.getElementById('aliq_aplic_calc_cred').style.display='none';
			break;
		
		case 2: // 103
			
			document.getElementById('md_bc_icms').style.display='none';
			document.getElementById('md_bc_icms_st').style.display='none';
			document.getElementById('aliq_icms').style.display='none';
			document.getElementById('aliq_icms_st').style.display='none';
			document.getElementById('red_bc_icms').style.display='none';
			document.getElementById('red_bc_icms_st').style.display='none';
			document.getElementById('margem_val_adc_icms_st').style.display='none';
			document.getElementById('bc_op_propria').style.display='none';
			document.getElementById('uf_icms_st').style.display='none';
			document.getElementById('motivo_desoneracao').style.display='none';
			document.getElementById('aliq_aplic_calc_cred').style.display='none';
			break;
			
			
		case 3: // 201
			
			document.getElementById('md_bc_icms').style.display='none';//
			document.getElementById('md_bc_icms_st').style.display='block';//
			document.getElementById('aliq_icms').style.display='none';
			document.getElementById('aliq_icms_st').style.display='block';//
			document.getElementById('red_bc_icms').style.display='none';
			document.getElementById('red_bc_icms_st').style.display='block';//
			document.getElementById('margem_val_adc_icms_st').style.display='block';//
			document.getElementById('bc_op_propria').style.display='none';
			document.getElementById('uf_icms_st').style.display='none';
			document.getElementById('motivo_desoneracao').style.display='none';
			document.getElementById('aliq_aplic_calc_cred').style.display='block';//
			break;

		case 4: // 202
			
			document.getElementById('md_bc_icms').style.display='none';
			document.getElementById('md_bc_icms_st').style.display='block';//
			document.getElementById('aliq_icms').style.display='none';
			document.getElementById('aliq_icms_st').style.display='block';//
			document.getElementById('red_bc_icms').style.display='none';
			document.getElementById('red_bc_icms_st').style.display='block';//
			document.getElementById('margem_val_adc_icms_st').style.display='block';//
			document.getElementById('bc_op_propria').style.display='none';
			document.getElementById('uf_icms_st').style.display='none';
			document.getElementById('motivo_desoneracao').style.display='none';
			document.getElementById('aliq_aplic_calc_cred').style.display='none';
			break;

		case 5: // 203
			
			document.getElementById('md_bc_icms').style.display='none';
			document.getElementById('md_bc_icms_st').style.display='block';//
			document.getElementById('aliq_icms').style.display='none';
			document.getElementById('aliq_icms_st').style.display='block';//
			document.getElementById('red_bc_icms').style.display='none';
			document.getElementById('red_bc_icms_st').style.display='block';//
			document.getElementById('margem_val_adc_icms_st').style.display='block';//
			document.getElementById('bc_op_propria').style.display='none';
			document.getElementById('uf_icms_st').style.display='none';
			document.getElementById('motivo_desoneracao').style.display='none';
			document.getElementById('aliq_aplic_calc_cred').style.display='none';
			break;
		
		case 6: // 300
			
			document.getElementById('md_bc_icms').style.display='none';
			document.getElementById('md_bc_icms_st').style.display='none';
			document.getElementById('aliq_icms').style.display='none';
			document.getElementById('aliq_icms_st').style.display='none';
			document.getElementById('red_bc_icms').style.display='none';
			document.getElementById('red_bc_icms_st').style.display='none';
			document.getElementById('margem_val_adc_icms_st').style.display='none';
			document.getElementById('bc_op_propria').style.display='none';
			document.getElementById('uf_icms_st').style.display='none';
			document.getElementById('motivo_desoneracao').style.display='none';
			document.getElementById('aliq_aplic_calc_cred').style.display='none';
			break;
		
		case 7: // 400
			
			document.getElementById('md_bc_icms').style.display='none';
			document.getElementById('md_bc_icms_st').style.display='none';
			document.getElementById('aliq_icms').style.display='none';
			document.getElementById('aliq_icms_st').style.display='none';
			document.getElementById('red_bc_icms').style.display='none';
			document.getElementById('red_bc_icms_st').style.display='none';
			document.getElementById('margem_val_adc_icms_st').style.display='none';
			document.getElementById('bc_op_propria').style.display='none';
			document.getElementById('uf_icms_st').style.display='none';
			document.getElementById('motivo_desoneracao').style.display='none';
			document.getElementById('aliq_aplic_calc_cred').style.display='none';
			break;
		
		case 8: // 500
			
			document.getElementById('md_bc_icms').style.display='none';
			document.getElementById('md_bc_icms_st').style.display='none';
			document.getElementById('aliq_icms').style.display='none';
			document.getElementById('aliq_icms_st').style.display='none';
			document.getElementById('red_bc_icms').style.display='none';
			document.getElementById('red_bc_icms_st').style.display='none';
			document.getElementById('margem_val_adc_icms_st').style.display='none';
			document.getElementById('bc_op_propria').style.display='none';
			document.getElementById('uf_icms_st').style.display='none';
			document.getElementById('motivo_desoneracao').style.display='none';
			document.getElementById('aliq_aplic_calc_cred').style.display='none';
			break;
		
		case 9: // 900
			
			document.getElementById('md_bc_icms').style.display='block';//
			document.getElementById('md_bc_icms_st').style.display='block';//
			document.getElementById('aliq_icms').style.display='block';//
			document.getElementById('aliq_icms_st').style.display='block';//
			document.getElementById('red_bc_icms').style.display='block';//
			document.getElementById('red_bc_icms_st').style.display='block';//
			document.getElementById('margem_val_adc_icms_st').style.display='block';//
			document.getElementById('bc_op_propria').style.display='none';
			document.getElementById('uf_icms_st').style.display='none';
			document.getElementById('motivo_desoneracao').style.display='none';
			document.getElementById('aliq_aplic_calc_cred').style.display='block';//
			break;
						
		
	}

	
}

</script>
<?php $this->load->view("partial/footer"); ?>
