<?php
$this->load->view("partial/header");
?>


<div class="col-md-12 col-sm-12 col-lg-12">
	<div class="block-flat">
		<div class="header">
			<h3>
				<font style="color: dodgerblue;">Ordem de Serviço</font>
			</h3>
		</div>
		<div class="content">
			<div class="row">
				<div class="col-md-12 col-lg-12 col-sm-12">
					<div class="content">
									<?php if(!isset($a)){echo form_open('osdefects/insert');}else{echo form_open('osdefects/atualizar/'.$idOS);}?>
										<h4>
							<i class="fa fa-angle-right"></i>Informar defeitos
						</h4>
						<div class="form-group">
							<div class="col-sm-3 col-lg-3 col-md-3">
								<h4>
									<font style="color: #4D90FD">Acústica</font>
								</h4>
								<p>
									<input type="checkbox" name="aparelhoapitando" value="1"
										<?php if(isset($a['aparelhoapitando'])){if ($a["aparelhoapitando"] == 1){echo 'checked';}}?>>
									Aparelho Apitando
								
								
								<p>
									<input type="checkbox" name="aparelhomudo" value="1"
										<?php if(isset($a['aparelhomudo'])){if ($a["aparelhomudo"] == 1){echo 'checked';}}?>>
									Aparelho Mudo
								
								
								<p>
									<input type="checkbox" name="funcionamentointermitente"
										value="1"
										<?php if(isset($a['funcionamentointermitente'])){if ($a["funcionamentointermitente"] == 1){echo 'checked';}}?>>
									Funcionamento Intermitente
								
								
								<p>
									<input type="checkbox" name="revisao" value="1"
										<?php if(isset($a['revisao'])){if ($a["revisao"] == 1){echo 'checked';}}?>>
									Revisão/Limpeza
								
								
								<p>
									<input type="checkbox" name="ruido" value="1"
										<?php if(isset($a['ruido'])){if ($a["ruido"] == 1){echo 'checked';}}?>>
									Ruído
								
								
								<p>
									<input type="checkbox" name="somabafado" value="1"
										<?php if(isset($a['somabafado'])){if ($a["somabafado"] == 1){echo 'checked';}}?>>
									Som Abafado
								
								
								<p>
									<input type="checkbox" name="somdistorcido" value="1"
										<?php if(isset($a['somdistorcido'])){if ($a["somdistorcido"] == 1){echo 'checked';}}?>>
									Som Distorcido
								
								
								<p>
							
							</div>

							<div class="col-sm-3 col-lg-3 col-md-3">
								<h4>
									<font style="color: #4D90FD">Faceplate</font>
								</h4>
								<p>
									<input type="checkbox" name="altoconsumopilha" value="1"
										<?php if(isset($a['altoconsumopilha'])){if ($a["altoconsumopilha"] == 1){echo 'checked';}}?>>
									Alto Consumo de Pilha
								
								
								<p>
									<input type="checkbox" name="faltacapabotao" value="1"
										<?php if(isset($a['faltacapabotao'])){if ($a["faltacapabotao"] == 1){echo 'checked';}}?>>
									Falta Capa Botão
								
								
								<p>
									<input type="checkbox" name="faltatampasoquete" value="1"
										<?php if(isset($a['faltatampasoquete'])){if ($a["faltatampasoquete"] == 1){echo 'checked';}}?>>
									Falta Tampa Soquete
								
								
								<p>
									<input type="checkbox" name="faltatampatimpot" value="1"
										<?php if(isset($a['faltatampatimpot'])){if ($a["faltatampatimpot"] == 1){echo 'checked';}}?>>
									Falta Tampa Timpot
								
								
								<p>
									<input type="checkbox" name="gavetadepilha" value="1"
										<?php if(isset($a['gavetadepilha'])){if ($a["gavetadepilha"] == 1){echo 'checked';}}?>>
									Gaveta de Pilha
								
								
								<p>
									<input type="checkbox" name="problemacontatodepilha" value="1"
										<?php if(isset($a['problemacontatodepilha'])){if ($a["problemacontatodepilha"] == 1){echo 'checked';}}?>>
									Problema Contato de Pilha
								
								
								<p>
									<input type="checkbox" name="problemacontrolevolume" value="1"
										<?php if(isset($a['problemacontrolevolume'])){if ($a["problemacontrolevolume"] == 1){echo 'checked';}}?>>
									Problema Controle Volume
								
								
								<p>
							
							</div>

							<div class="col-sm-3 col-lg-3 col-md-3">
								<h4>
									<font style="color: #4D90FD">Caixa</font>
								</h4>
								<p>
									<input type="checkbox" name="acabamentoruim" value="1"
										<?php if(isset($a['acabamentoruim'])){if ($a["acabamentoruim"] == 1){echo 'checked';}}?>>
									Acabamento Ruim
								
								
								<p>
									<input type="checkbox" name="apertada" value="1"
										<?php if(isset($a['apertada'])){if ($a["apertada"] == 1){echo 'checked';}}?>>
									Apertada
								
								
								<p>
									<input type="checkbox" name="caixaquebrada" value="1"
										<?php if(isset($a['caixaquebrada'])){if ($a["caixaquebrada"] == 1){echo 'checked';}}?>>
									Caixa Quebrada
								
								
								<p>
									<input type="checkbox" name="canalmuitolongo" value="1"
										<?php if(isset($a['canalmuitolongo'])){if ($a["canalmuitolongo"] == 1){echo 'checked';}}?>>
									Canal Muito Longo
								
								
								<p>
									<input type="checkbox" name="faltapolimento" value="1"
										<?php if(isset($a['faltapolimento'])){if ($a["faltapolimento"] == 1){echo 'checked';}}?>>
									Falta Polimento
								
								
								<p>
									<input type="checkbox" name="faltaventilacao" value="1"
										<?php if(isset($a['faltaventilacao'])){if ($a["faltaventilacao"] == 1){echo 'checked';}}?>>
									Falta Ventilação
								
								
								<p>
									<input type="checkbox" name="machucando" value="1"
										<?php if(isset($a['machucando'])){if ($a["machucando"] == 1){echo 'checked';}}?>>
									Machucando
								
								
								<p>
									<input type="checkbox" name="problemanofechamento" value="1"
										<?php if(isset($a['problemanofechamento'])){if ($a["problemanofechamento"] == 1){echo 'checked';}}?>>
									Problema no Fechamento
								
								
								<p>
									<input type="checkbox" name="soltaapito" value="1"
										<?php if(isset($a['soltaapito'])){if ($a["soltaapito"] == 1){echo 'checked';}}?>>
									Solta Apito
								
								
								<p>
									<input type="checkbox" name="trocacaixaoutropaciente" value="1"
										<?php if(isset($a['trocacaixaoutropaciente'])){if ($a["trocacaixaoutropaciente"] == 1){echo 'checked';}}?>>
									Troca Caixa outro Paciente
								
								
								<p>
									<input type="checkbox" name="ventilacaoexagerada" value="1"
										<?php if(isset($a['ventilacaoexagerada'])){if ($a["ventilacaoexagerada"] == 1){echo 'checked';}}?>>
									Ventilação Exagerada
								
								
								<p>
									<input type="checkbox" name="ventilacaoinsuficiente" value="1"
										<?php if(isset($a['ventilacaoinsuficiente'])){if ($a["ventilacaoinsuficiente"] == 1){echo 'checked';}}?>>
									Ventilação Insuficiente
								
								
								<p>
							
							</div>

							<div class="col-sm-3 col-lg-3 col-md-3">
								<h4>
									<font style="color: #4D90FD">Retro / Outros</font>
								</h4>
								<p>
									<input type="checkbox" name="aparelhofraco" value="1"
										<?php if(isset($a['aparelhofraco'])){if ($a["aparelhofraco"] == 1){echo 'checked';}}?>>
									Aparelho Fraco
								
								
								<p>
									<input type="checkbox" name="outros" value="1"
										<?php if(isset($a['outros'])){if ($a["outros"] == 1){echo 'checked';}}?>>
									Outros
								
								
								<p>
									<input type="checkbox" name="poucoganho" value="1"
										<?php if(isset($a['poucoganho'])){if ($a["poucoganho"] == 1){echo 'checked';}}?>>
									Pouco Ganho
								
								
								<p>
									<input type="checkbox" name="problemacangulo" value="1"
										<?php if(isset($a['problemacangulo'])){if ($a["problemacangulo"] == 1){echo 'checked';}}?>>
									Problema c/ ângulo
								
								
								<p>
									<input type="checkbox" name="seguro" value="1"
										<?php if(isset($a['seguro'])){if ($a["seguro"] == 1){echo 'checked';}}?>>
									Seguro
								
								
								<p>
									<input type="checkbox" name="trocadeaparelho" value="1"
										<?php if(isset($a['trocadeaparelho'])){if ($a["trocadeaparelho"] == 1){echo 'checked';}}?>>
									Troca de Aparelho
								
								
								<p>
									<input type="checkbox" name="trocadolado" value="1"
										<?php if(isset($a['trocadolado'])){if ($a["trocadolado"] == 1){echo 'checked';}}?>>
									Troca do Lado
								
								
								<p>
									<input type="checkbox" name="trocarcaixaretro" value="1"
										<?php if(isset($a['trocarcaixaretro'])){if ($a["trocarcaixaretro"] == 1){echo 'checked';}}?>>
									Trocar Caixa Retro
								
								
								<p>
									<input type="checkbox" name="canalmuitocurto" value="1"
										<?php if(isset($a['canalmuitocurto'])){if ($a["canalmuitocurto"] == 1){echo 'checked';}}?>>
									Canal Muito Curto
								
								
								<p>
							
							</div>
						</div>

						<div class="col-sm-6 col-md-6 col-lg-6">
							<h5>Descrição ou problema adicional:</h5>
							<textarea class="form-control" name="descos" rows="4"
								maxlength="400" placeholder="Descreva o problema..."> <?php if (isset($a["descos"])){echo $a["descos"];}?></textarea>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6">
							<br> <br> <input type="hidden" name="tel"
								value="<?php if (isset($tele)) {echo $tele;}?>">
							<button class="btn btn-primary" type="submit" name="nserie"
								value="<?php echo $serie;?>">Abrir OS</button>
							<button class="btn btn-default" type="button"
								onclick="location.href='<?php echo $this->config->site_url('os');?>'">Cancelar</button>
						</div>
										<?php echo form_close();?>
									</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view("partial/footer"); ?>