
<?php $this->load->view("partial/header"); ?>
<div class="cl-mcont">
	<div class="row">
		<div class="col-md-12 col-lg-12 col-sm-12">
			<div class="block-flat">
				<div class="header">
					<h3>
						<font style="color: dodgerblue;">Ocorrências da OS <?php echo $idOS;?></font>
					</h3>
				</div>
				<div class="content">
					<div class="row">
						<div class="col-md-12 col-lg-12 col-sm-12">
							<div class="content">
								<div class="form-group">
									<label class="col-sm-6 col-lg-6 col-md-6">
										<h4>
											<span style="color: orange;">Situação da OS: <?php echo $situacao; ?></span>
										</h4>
									</label>
											<?php echo form_open('tecos/change_os_situation/'.$idOS);?>
												<div class="col-sm-4 col-lg-4 col-md-4">
										<select name="situacao" class="form-control">
											<option value="Em analise">Analisando</option>
											<option value="Contactando">Contactando</option>
											<option value="Em andamento">Em Andamento</option>
											<option value="Fabrica">Enviado p/ Fábrica</option>
										</select>
									</div>
									<div class="col-sm-2 col-lg-2 col-md-2">
										<button type="submit" class="btn btn-success">Alterar Situação</button>
									</div>
											<?php echo form_close();?>
											<div class="col-md-12 col-lg-12 col-sm-12"
										style="display: inline-block;">
										<div class="panel-group accordion accordion-semi"
											id="accordion3">
											<div class="panel panel-default">
												<div class="panel-heading">
													<h4 class="panel-title">
														<a class="collapsed" data-toggle="collapse"
															data-parent="#accordion3" href="#ac3-1"> <i
															class="fa fa-angle-right"></i> Informações da Ordem de
															Serviço
														</a>
													</h4>
												</div>
												<div id="ac3-1" class="panel-collapse  collapse">
													<div class="panel-body">
														<h4>
															<strong> Aparelho</strong>
														</h4>
																<?php $info = $infos->result_array(); ?>
																<table class="hover">
															<thead>
																<tr>
																	<th>Nº OS</th>
																	<th>Aparelho</th>
																	<th>Lado</th>
																	<th>Nº de Série</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																			<?php
                
                echo '<td>' . $idOS . '</td>
																			<td>' . $info[0]['apparatus'] . ' ' . $info[0]['maker'] . ' ' . $info[0]['model'] . '</td>
																			<td>' . $info[0]['color'] . '</td>
																			<td>' . $info[0]['nserie'] . '</td>';
                ?>
																		</tr>
															</tbody>
														</table>

														<h4>
															<strong>Proprietário</strong>
														</h4>
														<table class="hover">
															<thead>
																<tr>
																	<th>Nome</th>
																	<th>Telefones</th>
																	<th>E-mail</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																			<?php
                echo '<td>' . $info[0]['first_name'] . ' ' . $info[0]['last_name'] . '</td>';
                echo '<td><select class="form-control">';
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
                echo '</select></td>
																				<td>';
                if ($info[0]['waives_terms'] == 1) {
                    echo 'Email protegido pelo Cliente';
                } else {
                    if (! empty($info[0]['email'])) {
                        echo $info[0]['email'];
                    } else {
                        echo 'Cliente sem email';
                    }
                }
                echo '</td>';
                ?>
																		</tr>
															</tbody>
														</table>
													</div>
												</div>
											</div>
											<div class="panel panel-default">
												<div class="panel-heading">
													<h4 class="panel-title">
														<a class="collapsed" data-toggle="collapse"
															data-parent="#accordion3" href="#ac3-2"> <i
															class="fa fa-angle-right"></i> Problemas e Defeitos
														</a>
													</h4>
												</div>
												<div id="ac3-2" class="panel-collapse collapse">
													<div class="panel-body">
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
                    echo '<hr><h4><strong> » Descrição adicional:</strong></h4><br>' . $def[0]['descos'];
                }
                ?>
							  								</div>
												</div>
											</div>
										</div>
									</div>
										
											<?php echo form_open('tecos/ocorrencia')?>
												<div class="col-md-6 col-lg-6 col-sm-6">
										<h5>
											<strong>Ocorrência:</strong>
										</h5>
										<textarea name="desc" placeholder="Descreva a Ocorrência..."
											class="form-control" rows="4" style="resize: none;" required></textarea>
									</div>
									<div class="col-md-4 col-lg-4 col-sm-4">
										<h5>
											<strong>Valor da Ocorrência (R$):</strong>
										</h5>
										<input type="text" class="form-control" name="valor"
											data-mask="#####0.00" data-mask-reverse="true"
											placeholder="0.00" required>
									</div>
									<div class="col-md-2 col-lg-2 col-sm-2">
										<input type="hidden" name="idos" value="<?php echo $idOS;?>">
										<button type="submit" class="btn btn-primary"
											style="margin-top: 36px">Adicionar</button>
									</div>
											<?php echo form_close();?>
											<div class="col-sm-12 col-lg-12 col-md-12"
										style="display: inline-block; margin-top: 20px;">
										<a class="btn btn-success"
											href="<?php echo site_url('oslaudo/index/'.$idOS)?>">Escrever
											laudo</a>
									</div>
									<div class="form-group">
										<div class="col-md-12 col-lg-12 col-sm-12">
											<h4>
												<strong>Ocorrências Processadas:</strong>
											</h4>
											<table class="hover">
												<thead>
													<tr class="color-primary">
														<th>Ocorrência</th>
														<th class="text-right">Valor</th>
														<th>Funcionário</th>
														<th class="text-center">Data e hora</th>
														<th class="text-center">Ação</th>
													</tr>
												</thead>
												<tbody>
															<?php echo $manage_table_row; ?>
														</tbody>
											</table>
										</div>
									</div>
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
