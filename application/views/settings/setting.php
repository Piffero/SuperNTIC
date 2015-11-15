<?php
$this->load->view("partial/header");

?>
<div class="page-aside tree">
	<div class="fixed nano nscroller">
		<div class="content">
			<div class="title">
				<h2>Defini&#231;&#245;es</h2>
			</div>
			<ul class="nav nav-list treeview">
				<li><?php echo anchor("settings/setting",'<i class="fa fa-folder-open-o"></i> Geral'); ?></li>
				<li><?php echo anchor("settings/enterprise",'<i class="fa fa-folder-o"></i> Matriz / Filais'); ?></li>
				<li><?php echo anchor("settings/permissions",'<i class="fa fa-folder-o"></i> Permiss&#245;es'); ?></li>
			</ul>
		</div>
	</div>
</div>
<div class="container-fluid" id="pcont">
	<div class="cl-mcont">
		<div class="container"
			style="background: none repeat scroll 0% 0% #FFF;">

			<div class="page-header text-info"> &nbsp; &nbsp; Cadastro de Empresa</div>
			<div class="row">
					<?php
    
    echo form_open('settings/save_company/', array(
        'id' => 'permissions_form',
        'style' => 'border-radius: 0px;'
    ));
    ?>	
					
						<div class="form-group">
					<label class="col-sm-12"> * Obrigat&#243;rios. </label> <label
						class="col-sm-6">Raz&#227;o Social *: <input type="text"
						class="form-control" name="RazaoSocial"
						value="<?php if (isset($setting['RazaoSocial'])){ echo $setting['RazaoSocial'];}?>"
						required>
					</label> <label class="col-sm-6">Nome Fantasia *: <input
						type="text" class="form-control" name="NomeFantasia"
						value="<?php if (isset($setting['NomeFantasia'])){ echo $setting['NomeFantasia'];}?>"
						required>
					</label> <label class="col-sm-6">Respons&#225;vel *: <input
						type="text" class="form-control" name="Responsavel"
						value="<?php if (isset($setting['Responsavel'])){ echo $setting['Responsavel'];}?>"
						required>
					</label> <label class="col-sm-6">CNPJ *: <input type="text"
						class="form-control" name="CNPJ" data-mask="00.000.000/0000-00"
						value="<?php if (isset($setting['CNPJ'])){ echo $setting['CNPJ'];}?>"
						required>
					</label> <label class="col-sm-6">Inscr. Estadual/RG: <input
						type="text" class="form-control" name="InscrEstadual"
						data-mask="000.000.000.000"
						value="<?php if (isset($setting['InscrEstadual'])){ echo $setting['InscrEstadual'];}?>">
					</label> <label class="col-sm-6">Inscr. Municipal: <input
						type="text" class="form-control" name="Municipal"
						value="<?php if (isset($setting['Municipal'])){ echo $setting['Municipal'];}?>">
					</label> <label class="col-sm-2">UF *: <input type="text"
						pattern="[A-Za-z]{2}" title="Somente 2 letras!"
						class="form-control" name="UF" data-mask="AA"
						value="<?php if (isset($setting['UF'])){ echo $setting['UF'];}?>"
						required>
					</label> <label class="col-sm-4">CEP: <input type="text"
						class="form-control" name="CEP" data-mask="00.000-000"
						value="<?php if (isset($setting['CEP'])){ echo $setting['CEP'];}?>">
					</label> <label class="col-sm-6">Bairro: <input type="text"
						class="form-control" name="Bairro"
						value="<?php if (isset($setting['Bairro'])){ echo $setting['Bairro'];}?>">
					</label> <label class="col-sm-6">Tipo : <input type="text"
						placeholder="Ex.: Rua, S&#237;tio ..." class="form-control"
						name="Tipo"
						value="<?php if (isset($setting['Tipo'])){ echo $setting['Tipo'];}?>">
					</label> <label class="col-sm-6">Logradouro: <input type="text"
						class="form-control" name="Logradouro"
						value="<?php if (isset($setting['Logradouro'])){ echo $setting['Logradouro'];}?>">
					</label> <label class="col-sm-4">Complemento: <input type="text"
						class="form-control" name="Complemento"
						value="<?php if (isset($setting['Complemento'])){ echo $setting['Complemento'];}?>">
					</label> <label class="col-sm-2">N&#250;mero: <input type="text"
						class="form-control" name="Numero"
						value="<?php if (isset($setting['Numero'])){ echo $setting['Numero'];}?>">
					</label> <label class="col-sm-6">E-mail: <input type="text"
						class="form-control" name="Email"
						value="<?php if (isset($setting['Email'])){ echo $setting['Email'];}?>">
					</label> <label class="col-sm-6">Telefone *: <input type="text"
						class="form-control" name="Telefone" data-mask="(00) 000000000"
						value="<?php if (isset($setting['Telefone'])){ echo $setting['Telefone'];}?>"
						required>
					</label> <label class="col-sm-6">Celular: <input type="text"
						class="form-control" name="Celular" data-mask="(00) 000000000"
						value="<?php if (isset($setting['Celular'])){ echo $setting['Celular'];}?>">
					</label> <label class="col-sm-6">Fax: <input type="text"
						class="form-control" name="Fax" data-mask="(00) 000000000"
						value="<?php if (isset($setting['Fax'])){ echo $setting['Fax'];}?>">
					</label> <label class="col-sm-6">Website: <input type="text"
						placeholder="Ex.: www.meganet.net.br" class="form-control"
						name="Website"
						value="<?php if (isset($setting['Website'])){ echo $setting['Website'];}?>">
					</label> <label class="col-sm-6">Ramo de Atividade *: <input
						type="text" placeholder="Ex.: Com&#233;rcio em Geral"
						class="form-control" name="RamoAtividade"
						value="<?php if (isset($setting['RamoAtividade'])){ echo $setting['RamoAtividade'];}?>">
					</label> <label class="col-sm-6">CNAE Fiscal: <input type="text"
						class="form-control" name="CNAEFiscal"
						value="<?php if (isset($setting['CNAEFiscal'])){ echo $setting['CNAEFiscal'];}?>">
					</label> <label class="col-sm-6">Optante Simples Nacional:<br /> <input
						type="text" class="form-control" name="OSN"
						value="<?php if (isset($setting['OSN'])){ echo $setting['OSN'];}?>">
					</label> <label class="col-sm-12">
						<button type="submit" class="btn btn-primary">Salvar</button>
					</label>
				</div>
					<?php echo form_close();?>
				</div>
		</div>
	</div>
</div>

<?php $this->load->view("partial/footer"); ?>