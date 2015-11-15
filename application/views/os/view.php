<?php $this->load->view("partial/header"); ?>
<div class="cl-mcont">
	<div class="row">
		<div class="col-md-12 col-lg-12 col-sm-12">
			<div class="block-flat">
				<div class="header">
					<h3>
						<font style="color: dodgerblue;">Ficha da Ordem de Serviço</font>
					</h3>
				</div>
				<div class="content">
					<div class="row">
						<div class="content">
							<div class="col-md-4 col-lg-4 col-sm-4">
								<h4>
									<strong>Ordem de Serviço:</strong>
								</h4>
								<label>Nº: </label> <?php echo $idOS; ?><br> <label>Situação: </label> <?php
        switch ($info[0]['SITUACAO']) {
            case 'Aberta':
                echo '<label class="label label-primary">' . $info[0]['SITUACAO'] . '</label>';
                break;
            
            case 'Em analise':
                echo '<label class="label label-primary">' . $info[0]['SITUACAO'] . '</label>';
                break;
            
            case 'Em andamento':
                echo '<label class="label label-info">' . $info[0]['SITUACAO'] . '</label>';
                break;
            
            case 'Contatando':
                echo '<label class="label label-warning">' . $info[0]['SITUACAO'] . '</label>';
                break;
            
            case 'Aprovada':
                echo '<label class="label label-lucas">' . $info[0]['SITUACAO'] . '</label>';
                break;
            
            case 'Concluida':
                echo '<label class="label label-success">' . $info[0]['SITUACAO'] . '</label>';
                break;
            
            case 'Recusada':
                echo '<label class="label label-danger">' . $info[0]['SITUACAO'] . '</label>';
                break;
            
            case 'Fabrica':
                echo '<label class="label label-black">' . $info[0]['SITUACAO'] . '</label>';
                break;
        }
        ?><br> <label>Data de Abertura:</label> <?php echo date('d/m/Y h:m', strtotime($info[0]['DTABERTURA'])); ?>
								</div>
							<div class="col-md-4 col-lg-4 col-sm-4">
								<h4>
									<strong>Aparelho:</strong>
								</h4>
								<label>Nome:</label> <?php echo $info[0]['apparatus'].' '.$info[0]['maker'].' '.$info[0]['model'].' ['.$info[0]['color'].']';?>
								</div>
							<div class="col-md-4 col-lg-4 col-sm-4">
								<h4>
									<strong>Cliente:</strong>
								</h4>
								<label>Nome: </label> <?php echo $info[0]['first_name'].' '.$info[0]['last_name'];?> <br>
								<label>Tels.:</label>
									<?php
        echo '<select>';
        if (! empty($info[0]['phone_home'])) {
            if ($info[0]['phone_number'] == '1') {
                echo '<option selected> &#149; ' . $info[0]['phone_home'] . ' (Casa) </option>';
            } else {
                echo '<option>' . $info[0]['phone_home'] . ' (Casa)  </option>';
            }
        }
        if (! empty($info[0]['phone_work'])) {
            if ($info[0]['phone_number'] == '2') {
                echo '<option selected> &#149;' . $info[0]['phone_work'] . '  (Trab) </option>';
            } else {
                echo '<option>' . $info[0]['phone_work'] . ' (Trab)  </option>';
            }
        }
        if (! empty($info[0]['phone_cell'])) {
            if ($info[0]['phone_number'] == '3') {
                echo '<option selected> &#149;' . $info[0]['phone_cell'] . '  (Cel)  </option>';
            } else {
                echo '<option>' . $info[0]['phone_cell'] . ' (Cel)   </option>';
            }
        }
        if (! empty($info[0]['phone_other'])) {
            if ($info[0]['phone_number'] == '4') {
                echo '<option selected> &#149;' . $info[0]['phone_other'] . ' (outro)</option>';
            } else {
                echo '<option>' . $info[0]['phone_other'] . ' (outro)</option>';
            }
        }
        echo '</select>';
        ?><br> <label>Email: </label> 
									<?php
        if ($info[0]['waives_terms'] == 0) {
            if (! empty($info[0]['email'])) {
                echo $info[0]['email'];
            } else {
                echo 'Cliente sem email';
            }
        } else {
            echo '<span style="color:red;"> > Dados Protegidos</span>';
        }
        ?>
								</div>
							<br>
							<hr>
							<div class="col-sm-12 col-md-12 col-lg-12"
								style="display: inline-block; margin-top: 13px;">
								<h4>
									<strong>Defeitos Informados:</strong>
								</h4>
									<?php
        
        if ($def[0]['aparelhoapitando'] == 1) {
            echo ' Aparelho apitando; &nbsp;';
        }
        if ($def[0]['aparelhomudo'] == 1) {
            echo ' Aparelho mudo; &nbsp;';
        }
        if ($def[0]['funcionamentointermitente'] == 1) {
            echo ' Funcionamento intermitente; &nbsp;';
        }
        if ($def[0]['revisao'] == 1) {
            echo ' Revisão/Limpeza; &nbsp;';
        }
        if ($def[0]['ruido'] == 1) {
            echo ' Ruído; &nbsp;';
        }
        if ($def[0]['problemacangulo'] == 1) {
            echo ' Problema com o ângulo; &nbsp;';
        }
        if ($def[0]['somabafado'] == 1) {
            echo ' Som abafado; &nbsp;';
        }
        if ($def[0]['somdistorcido'] == 1) {
            echo ' Som distorcido; &nbsp;';
        }
        if ($def[0]['altoconsumopilha'] == 1) {
            echo ' Alto consumo de pilha; &nbsp;';
        }
        if ($def[0]['faltacapabotao'] == 1) {
            echo ' Falta capa do botão; &nbsp;';
        }
        if ($def[0]['faltatampasoquete'] == 1) {
            echo ' Falta tampa do soquete; &nbsp;';
        }
        if ($def[0]['gavetadepilha'] == 1) {
            echo ' Gaveta da pilha; &nbsp;';
        }
        if ($def[0]['problemacontatodepilha'] == 1) {
            echo ' Problema contato de pilha; &nbsp;';
        }
        if ($def[0]['problemacontrolevolume'] == 1) {
            echo ' Problema controle de volume; &nbsp;';
        }
        if ($def[0]['acabamentoruim'] == 1) {
            echo ' Acabamento Ruim; &nbsp;';
        }
        if ($def[0]['apertada'] == 1) {
            echo ' Apertada; &nbsp;';
        }
        if ($def[0]['caixaquebrada'] == 1) {
            echo ' Caixa quebrada; &nbsp;';
        }
        if ($def[0]['canalmuitolongo'] == 1) {
            echo ' Canal muito longo; &nbsp;';
        }
        if ($def[0]['faltapolimento'] == 1) {
            echo ' Falta polimento; &nbsp;';
        }
        if ($def[0]['faltaventilacao'] == 1) {
            echo ' Falta ventilação; &nbsp;';
        }
        if ($def[0]['machucando'] == 1) {
            echo ' Machucando; &nbsp;';
        }
        if ($def[0]['problemanofechamento'] == 1) {
            echo ' Problema no fechamento; &nbsp;';
        }
        if ($def[0]['soltaapito'] == 1) {
            echo ' Solta apito; &nbsp;';
        }
        if ($def[0]['trocacaixaoutropaciente'] == 1) {
            echo ' Troca caixa outro paciente; &nbsp;';
        }
        if ($def[0]['ventilacaoexagerada'] == 1) {
            echo ' Ventilação exagerada; &nbsp;';
        }
        if ($def[0]['ventilacaoinsuficiente'] == 1) {
            echo ' Ventilação insuficiente; &nbsp;';
        }
        if ($def[0]['aparelhofraco'] == 1) {
            echo ' Aparelho fraco; &nbsp;';
        }
        if ($def[0]['faltatampatimpot'] == 1) {
            echo ' Falta tampa do timpot; &nbsp;';
        }
        if ($def[0]['outros'] == 1) {
            echo ' Outros; &nbsp;';
        }
        if ($def[0]['poucoganho'] == 1) {
            echo ' Pouco ganho; &nbsp;';
        }
        if ($def[0]['seguro'] == 1) {
            echo ' Seguro; &nbsp;';
        }
        if ($def[0]['trocadeaparelho'] == 1) {
            echo ' Troca de aparelho; &nbsp;';
        }
        if ($def[0]['trocadolado'] == 1) {
            echo ' Troca do lado; &nbsp;';
        }
        if ($def[0]['trocarcaixaretro'] == 1) {
            echo ' Trocar caixa retro; &nbsp;';
        }
        if ($def[0]['canalmuitocurto'] == 1) {
            echo ' Canal muito curto; &nbsp;';
        }
        if (! empty($def[0]['descos'])) {
            echo '<br> » Descrição adicional:<br>' . $def[0]['descos'];
        }
        ?>
								</div>
							<hr>
							<div class="col-sm-12 col-md-12 col-lg-12"
								style="display: inline-block;">
								<h4>
									<strong>Tentativas de Contato:</strong>
								</h4>
								<table class="hover">
									<thead>
										<tr class="color-primary">
											<th>Descrição</th>
											<th class="text-center">Data e Hora</th>
											<th class="text-center">Cliente Contatado</th>
										</tr>
									</thead>
									<tbody>
										<tr>
												<?php if(!empty($cont)){echo $cont;}else {echo '<td colspan="3">Não foram tentados contato com este cliente.</td>';} ?>
											</tr>
									</tbody>
								</table>
							</div>
							<hr>
							<div class="col-sm-12 col-md-12 col-lg-12"
								style="display: inline-block;">
								<h4>
									<strong>Pagamentos Efetuados</strong>
								</h4>
								<table class="hover">
									<thead>
										<tr class="color-primary">
											<th class="text-center">Data</th>
											<th class="text-right">Valor do Pagamento</th>
										</tr>
									</thead>
									<tbody>
											<?php if(!empty($lanc)){echo $lanc;}else {echo '<td colspan="2">Não há pagamentos efetuados</td>';} ?>
										</tbody>
								</table>
							</div>
							<hr>
							<div class="col-sm-12 col-md-12 col-lg-12"
								style="display: inline-block;">
								<h4>
									<strong>Ocorrências Processadas</strong>
								</h4>
								<table class="hover">
									<thead>
										<tr class="color-primary">
											<th>Ocorrência</th>
											<th class="text-right">Valor</th>
											<th>Funcionário</th>
											<th>Data e Hora</th>
										</tr>
									</thead>
									<tbody>
											<?php if(!empty($manage_table_row)){echo $manage_table_row;}else {echo '<td colspan="3">Não há ocorrências processadas</td>';} ?>
										</tbody>
								</table>
								<hr>
								<div class="form-group">
									<button
										onclick="window.open('<?php echo site_url('oscanhoto/index/'.$idOS)?>');"
										class="btn btn-default">Comprovante/Canhoto</button>
								</div>
									<?php
        if (! empty($laudo[0]["laudo"])) {
            echo '<a href="' . site_url('oslaudo/ver/' . $idOS) . '">Ver laudo desta Ordem de Serviço ></a>';
        }
        ?>
								</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view("partial/footer"); ?> 