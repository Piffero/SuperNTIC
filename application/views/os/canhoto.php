<?php
date_default_timezone_set("Brazil/East");

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>NTIC - :: IMPRESSÃO DE COMPROVANTE</title>
<script>window.print();</script>

</head>

<body>

	<div
		style="width: 100%%; height: 110%; border: 0px solid; margin: 0 auto;">
		<!-- DIV - Inicia layout da p�gina -->
		<div style="width: 100%; border: 0px solid; float: left;">
			<!-- DIV - Inicia imagem -->
			<div style="width: 120px; height: 100%; float: left;">
				<img src="<?php echo $logo;?>" width="100%" />
			</div>

			<!-- Cabe�alho principal -->
			<div style="margin-left: 150px;">

				<h3>
					<i> 	<?php echo $array[0]['razaosocial']; //razao?></i>
				</h3>
				<br />
			CNPJ: 		<?php echo substr($array[0]['cnpj'],0,2).'.'.substr($array[0]['cnpj'], 2,3).'.'. substr($array[0]['cnpj'], 5,3).'/'. substr($array[0]['cnpj'], 8,4).'-'. substr($array[0]['cnpj'], 12);?><br />			
			Telefone: 	<?php echo substr($array[0]['fone'],0,4).'.'.substr($array[0]['fone'],4);?><br />
			Endereço: 	<?php echo $array[0]['logradouro'].', Nº '.$array[0]['numero'].' - Bairro: '.$array[0]['bairro'];?><span></span><br>
					  	<?php echo $array[0]['municipio'].' - ' .substr($array[0]['cep'],0,2).'.'.substr($array[0]['cep'], 2,3).'-'.substr($array[0]['cep'], 5);?>
			
		</div>
			<p></p>
			<!-- Fim do cabeçalho principal-->

		</div>
		<!-- DIV - Finaliza cabeçalho da esquerda -->

		<hr color="lightgray" />
		<div style="width: 99.8%; border: 0px solid; float: left;">
			<!-- DIV - Inicia corpo 1 do layout		   -->
			<br />
			<p></p>
			<div style="margin: 10px;">
				<strong>O.S. Nº: <?php echo $idOS; ?></strong> <span
					style="padding-left: 30%;">
					Equipamento: <?php echo $arrayCL[0]['apparatus'].'&nbsp;';  echo  $arrayCL[0]['maker'].'&nbsp;'; echo $arrayCL[0]['model'].'&nbsp; ['.$arrayCL[0]['color'].']&nbsp';?>
				</span> <br />
					Cliente: <?php echo $arrayCL[0]['first_name'].'&nbsp;'; echo $arrayCL[0]['last_name'];?>
				<span style="padding-left: 30%;"> <strong>Nº de Série: <?php echo $arrayCL[0]['nserie'];?></strong><br>
				</span>
				Telefone(s): <?php
    if (! empty($arrayCL[0]['phone_home'])) {
        echo $arrayCL[0]['phone_home'] . '; &nbsp;';
    }
    if (! empty($arrayCL[0]['phone_cell'])) {
        echo $arrayCL[0]['phone_cell'] . '; &nbsp;';
    }
    if (! empty($arrayCL[0]['phone_work'])) {
        echo $arrayCL[0]['phone_work'] . '; &nbsp;';
    }
    if (! empty($arrayCL[0]['phone_other'])) {
        echo $arrayCL[0]['phone_other'] . '; ';
    }
    
    ?>
			</div>

		</div>
		<!-- DIV - Finaliza corpo 1 do layout	   -->


		<hr color="lightgray">
		<br />
		<p></p>
		<b>&#187; Defeitos Informados pelo cliente:</b>
		<p></p>
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
						
					<br />
		<p></p>
		<hr color="lightgray" />
		<div style="margin: 10px;">
			<strong style="text-decoration: underline;">Informações</strong>
			<p></p>
			<br /> <small> Autorizo(amos) o conserto do equipamento acima
				especificado. Estou(amos) ciente(s) de que reparos até R$ 150,00
				(cento e cinquenta reais) terão aprovação imediata para conserto, e
				também de que caso o valor total para o conserto ultrapasse o valor
				constante nesse item, terei que autorizá-lo previamente junto a essa
				empresa.<br> 1. A manutenção do produto junto ao seu estabelecimento
				não configura nenhuma forma de depósito;<br> 2. O consumidor
				autoriza p´revia e expressamente a doação para uma entidade de
				caridade do produto caso ele não seja retirado em 90 dias;<br> 3. O
				Consumidor autoriza prévia e expressamente a venda do produto para o
				pagamento dos serviços efetuados tendo direito ao recebimento de
				eventual saldo positivo ou tendo o dever de efetuar o pagamento da
				diferença restante, conforme o valor apurado com a venda do produto
				e o seu débito.
			</small>
		</div>

		<br>
		<p></p>

		<div style="text-align: center;">

			__________________________<br style="text-align: center;">
				<?php echo $arrayCL[0]['first_name'].'&nbsp;'; echo $arrayCL[0]['last_name'];?><br>

		</div>

	</div>
	<!-- DIV - Finaliza layout da página  -->
	<div>
		<br>
		<hr style="border: dashed black; border-width: 1px; height: 0;" />
		<br> <i><?php echo $array[0]['razaosocial'];?></i>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo substr($array[0]['cnpj'],0,2).'.'.substr($array[0]['cnpj'], 2,3).'.'. substr($array[0]['cnpj'], 5,3).'/'. substr($array[0]['cnpj'], 8,4).'-'. substr($array[0]['cnpj'], 12);?>
	<p style="text-decoration: underline;">Estou ciente de que, para
			retirar o equipamento, deverei apresentar este comprovante.</p>
		<p>
			<strong>Ordem de Serviço Nº: <?php echo $idOS;?></strong> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Nome: <?php echo $arrayCL[0]['first_name'].'&nbsp;'; echo $arrayCL[0]['last_name'];?><br />
	Data de entrada: <?php echo date('d/m/Y h:i', strtotime($arrayCL[0]['DTABERTURA']));?>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Fone: <?php echo substr($array[0]['fone'],0,4).'.'.substr($array[0]['fone'],4);?>
	
	
	
	
	</div>



</body>
</html>
