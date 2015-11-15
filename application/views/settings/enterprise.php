<?php $this->load->view("partial/header"); ?>
<div class="page-aside tree">
	<div class="fixed nano nscroller">
		<div class="content">
			<div class="title">
				<h2>Empresas</h2>
			</div>
			<ul class="nav nav-list treeview">
				<li>
            <?php echo anchor("enterprises",'<i class="fa fa-folder-open-o"></i> Nova Matriz / Filais'); ?>           
            <?php echo $listaEmpresa;?>	                  
            </li>
			</ul>
		</div>

	</div>
</div>
<div class="container-fluid" id="pcont">
	<div class="cl-mcont">

		<!-- Row Start -->
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="widget no-margin">
					<div class="widget-header">
						<div class="title">
							<h3>
								Matriz e Filiais! <i class="fa fa-building-o"></i>
							</h3>
						</div>
					</div>
					<div class="widget-body">
						<div class="row">
							<div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
								<div class="thumbnail">
									<img alt="300x200"
										<?php
        
        if (isset($enterprise_info->logo_address)) {
            echo 'src="' . ((isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") ? "https://" : "http://") . $_SERVER['SERVER_ADDR'] . '/upload/' . basename($enterprise_info->logo_address) . '"';
        } else {
            echo 'src="' . $this->config->base_url() . 'web/images/default-company.png"';
        }
        ?>>
								</div>
								<br>
                        <?php
                        
                        if (isset($enterprise_info->enterprise_id)) {
                            $id = '/' . $enterprise_info->enterprise_id;
                        } else {
                            $id = '';
                        }
                        echo form_open('enterprises/uploader_file' . $id, array(
                            'enctype' => 'multipart/form-data',
                            'method' => 'post',
                            'name' => 'form'
                        ))?>
                        <a href="javascript:void(0);"
									onclick="upload(document.getElementById('input'))"
									class="btn btn-danger col-md-12 col-sm-12 col-xs-12"><i
									class="fa fa-picture-o"></i> Trocar Logo</a> <input type="file"
									name="foto_logo" id="input" onchange="enviar();"
									style="visibility: hidden;">
                        <?php echo form_close();?>
                        <br>
							</div>
							<div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                        <?php
                        
                        if (isset($enterprise_info->enterprise_id)) {
                            $id = '/' . $enterprise_info->enterprise_id;
                        } else {
                            $id = '';
                        }
                        echo form_open('enterprises/save' . $id, array(
                            'class' => 'form-horizontal'
                        ));
                        ?>
                          <h4>
									<b>Informações Empresa</b>
								</h4>
								<hr>
								<div class="form-group">
									<div class="col-sm-12">
										Nome / Razão Social* <input type="text" class="form-control"
											autofocus="autofocus" name="razaosocial"
											placeholder="Razão Social"
											value="<?php if(isset($enterprise_info->razaosocial)){echo $enterprise_info->razaosocial;}?>">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										Nome Fantasia <input type="text" class="form-control"
											name="fantasia" placeholder="Nome Fantasia"
											value="<?php if(isset($enterprise_info->fantasia)){echo $enterprise_info->fantasia;}?>">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-4">
										CNPJ* <input type="text" class="form-control" name="cnpj"
											placeholder="CNPJ Somente Numeros"
											value="<?php if(isset($enterprise_info->cnpj)){echo $enterprise_info->cnpj;}?>">
									</div>
									<div class="col-sm-4">
										Inscrição Estadual* <input type="text" class="form-control"
											name="ie" placeholder="IE Somente Numeros"
											value="<?php if(isset($enterprise_info->ie)){echo $enterprise_info->ie;}?>">
									</div>
								</div>

								<div class="form-group">
									<div class="col-sm-4">
										CNAE Fiscal <input type="text" class="form-control"
											name="cnae" placeholder="CNAE Fiscal"
											value="<?php if(isset($enterprise_info->cnae)){echo $enterprise_info->cnae;}?>">
									</div>
									<div class="col-sm-4">
										Inscrição Municipal <input type="text" class="form-control"
											name="imunic" placeholder="Inscrição Municipal"
											value="<?php if(isset($enterprise_info->imunic)){echo $enterprise_info->imunic;}?>">
									</div>
								</div>

								<div class="form-group">
									<div class="col-sm-6">
										Inscricao Estadual (Subst. Tributário) <input type="text"
											class="form-control" name="iest"
											placeholder="IEST Somente Numero"
											value="<?php if(isset($enterprise_info->iest)){echo $enterprise_info->iest;}?>">
									</div>
									<div class="col-sm-6">
                            	Regime Tributário*
                            	<?php
                            if (isset($enterprise_info->regimetributario)) {
                                $RT = array(
                                    $enterprise_info->regimetributario
                                );
                            } else {
                                $RT = array();
                            }
                            echo form_dropdown('regimetributario', array(
                                1 => 'Simples Nacional',
                                2 => 'Simples Nacional - Excesso de receita bruta',
                                3 => 'Regime Normal'
                            ), $RT, 'class="form-control"');
                            ?>                            	
                            </div>
								</div>
								<br />
								<h4>
									<b>Dados de Endereço</b>
								</h4>
								<hr>
								<div class="form-group">
									<div class="col-sm-10">
										Logradouro* <input type="text" class="form-control"
											name="logradouro" placeholder="Endereço"
											value="<?php if(isset($enterprise_info->logradouro)){echo $enterprise_info->logradouro;}?>">
									</div>
									<div class="col-sm-2">
										Número* <input type="text" class="form-control" name="numero"
											placeholder="Número"
											value="<?php if(isset($enterprise_info->numero)){echo $enterprise_info->numero;}?>">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-6">
										Complemento <input type="text" class="form-control"
											name="complemento" placeholder="Complemento"
											value="<?php if(isset($enterprise_info->complemento)){echo $enterprise_info->complemento;}?>">
									</div>
									<div class="col-sm-4">
										Bairro* <input type="text" class="form-control" name="bairro"
											placeholder="Bairro"
											value="<?php if(isset($enterprise_info->bairro)){echo $enterprise_info->bairro;}?>">
									</div>
									<div class="col-sm-2">
										CEP* <input type="text" class="form-control" name="cep"
											placeholder="CEP"
											value="<?php if(isset($enterprise_info->cep)){echo $enterprise_info->cep;}?>">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-4">
										Pais* <input type="text" class="form-control" name="pais"
											placeholder="Pais"
											value="<?php if(isset($enterprise_info->pais)){echo $enterprise_info->pais;}?>">
									</div>
									<div class="col-sm-2">
										UF* <input type="text" class="form-control" name="uf"
											placeholder="UF"
											value="<?php if(isset($enterprise_info->uf)){echo $enterprise_info->uf;}?>">
									</div>
									<div class="col-sm-6">
										Município* <input type="text" class="form-control"
											name="municipio" placeholder="Município"
											value="<?php if(isset($enterprise_info->municipio)){echo $enterprise_info->municipio;}?>">
									</div>
								</div>
								<br>
								<h4>
									<b>Dados Registro NFe</b>
								</h4>
								<hr>
								<div class="form-group">
									<div class="col-sm-3">
										Codigo Pais* <input type="text" class="form-control"
											name="cPais" placeholder="Codigo Pais IBGE"
											value="<?php if(isset($enterprise_info->cPais)){echo $enterprise_info->cPais;}?>">
									</div>
									<div class="col-sm-4">
										Código Município* <input type="text" class="form-control"
											name="cMun" placeholder="Código Municipal IBGE"
											value="<?php if(isset($enterprise_info->cMun)){echo $enterprise_info->cMun;}?>">
									</div>
									<div class="col-sm-5">
										Telefone <input type="text" class="form-control" name="fone"
											placeholder="Telefone"
											value="<?php if(isset($enterprise_info->fone)){echo $enterprise_info->fone;}?>">
									</div>
								</div>

								<br>
								<div class="form-actions">

									<a
										href="<?php echo site_url('enterprises/export_emitente').$id?>"
										class="btn btn-info pull-right"> <i
										class="fa fa-external-link"></i> Exportar para NFe
									</a>
									<button type="submit" class="btn btn-success pull-right">
										Salvar Alterações</button>
								</div>
                        <?php echo form_close();?>
                      </div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Row End -->
	</div>
</div>

<script type="text/javascript">
function upload(c) {  
    c.click();  
}

function enviar(){      	
    document.form.submit();     
}  
</script>



<?php $this->load->view("partial/footer"); ?>