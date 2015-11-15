<?php
setlocale(LC_MONETARY, "pt_BR");
date_default_timezone_set("America/Sao_Paulo");

function contas_table_report($arr) 
{
	//print_r($arr);
	$CI = &get_instance();
	
	echo("<br><table class=\"hover\">\n");
		
	# Cabeçalho
	echo '
	<thead class="text-primary">'."\n".'
		<tr>'."\n".'
			<th>Referência</th>'."\n".'
			<th class="text-center">Nº</th>'."\n".'
			<th>Referenciado</th>'."\n".'
			<th class="text-right">Valor</th>'."\n".'
			<th class="text-center">Lançamento</th>'."\n".'
			<th class="text-center">Vencimento</th>'."\n".'
		</tr>'."\n".'
	</thead>'."\n";
	
	# Corpo Principal
	echo("<tbody>\n");
	
	if (empty($arr)) 
	{
		echo '<tr><td colspan="6">Não há resultados para serem mostrados</td></tr>';
	}
	else 
	{
		foreach ($arr as $value)
		{
			echo '
				<tr>'."\n".'
					<td>'.$value["historic"].'</td>'."\n".'
					<td class="text-center">'.$value["number"].'</td>'."\n".'
					<td>'.$value["favored"].'</td>'."\n".'
					<td class="text-right">'.money_format("%n", $value["value"]).'</td>'."\n".'
					<td class="text-center">'.date('d/m/Y H:i', strtotime($value["launch_date"])).'</td>'."\n".'
					<td class="text-center">'.date('d/m/Y', strtotime($value["date"])).'</td>'."\n".'
				</tr>'."\n";
		}
	}
	echo("</tbody>\n");

	echo("</table>\n");
	
}

function itens_table_report($arr)
{
	/*
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
	*/
	$CI = &get_instance();

	echo("<br><table class=\"hover\">\n");

	# Cabeçalho
	echo '
	<thead class="text-primary">'."\n".'
		<tr>'."\n".'
			<th>Aparelho</th>'."\n".'
			<th class="text-center">Nº Venda</th>'."\n".'
			<th class="text-center">Data da Venda</th>'."\n".'
			<th>Cliente</th>'."\n".'
			<th class="text-right">Valor do Aparelho</th>'."\n".'
		</tr>'."\n".'
	</thead>'."\n";

	# Corpo Principal
	echo("<tbody>\n");

	if (empty($arr))
	{
		echo '<tr><td colspan="5">Não há resultados para serem mostrados</td></tr>';
	}
	else
	{
		foreach ($arr as $value)
		{
			$item = $CI->General->select2("description", "items", array("item_id"=>5))->row()->description;
			$pt = $CI->General->select2("first_name, last_name", "patient", array("patient_id"=>$value["patient_id"]))->row();
			$portador = $pt->first_name.' '.$pt->last_name;
			$price = $CI->General->select2("selling_price", "items_business", array("item_id"=>$value["item_id"]))->row()->selling_price;
			//echo $portador;exit();
			echo '
			<tr>'."\n".'
				<td>'.$item.'</td>'."\n".'
				<td class="text-center">'.$value["order"].'</td>'."\n".'
				<td class="text-center">'.date("d/m/Y", strtotime($value["purchase_date"])).'</td>'."\n".'
				<td>'.$portador.'</td>'."\n".'
				<td class="text-right">'.money_format("%n", $price).'</td>'."\n".'
			</tr>'."\n";
		}
	}
	echo("</tbody>\n");

	echo("</table>\n");

}

function compras_table_report($arr)
{
	//print_r($arr);
	$CI = &get_instance();

	echo("<br><table class=\"hover\">\n");

	# Cabeçalho
	echo '
	<thead class="text-primary">'."\n".'
		<tr>'."\n".'
			<th>Nº Pedido</th>'."\n".'
			<th>Fornecedor</th>'."\n".'
			<th>Departamento</th>'."\n".'
			<th class="text-right">Valor</th>'."\n".'
			<th class="text-center">Data</th>'."\n".'
		</tr>'."\n".'
	</thead>'."\n";

	# Corpo Principal
	echo("<tbody>\n");

	if (empty($arr))
	{
		echo '<tr><td colspan="5">Não há resultados para serem mostrados</td></tr>';
	}
	else
	{
		foreach ($arr as $value)
		{
			$valor = $CI->General->sum("vtotal", "value", "purch_items", array("pedido"=>$value["num_pedido"]))->row()->value;
			
			echo '
			<tr>'."\n".'
				<td>'.$value["num_pedido"].'</td>'."\n".'
				<td>'.$value["fornecedor"].'</td>'."\n".'
				<td>'.$value["departamento"].'</td>'."\n".'
				<td class="text-right">'.money_format("%n", $valor).'</td>'."\n".'
				<td class="text-center">'.date("d/m/Y", strtotime($value["data"])).'</td>'."\n".'
			</tr>'."\n";
		}
	}
	
	echo("</tbody>\n");

	echo("</table>\n");

}

function os_table_report($arr, $tipo)
{
	//print_r($arr);
	$CI = &get_instance();

	echo("<br><table class=\"hover\">\n");

	# Cabeçalho
	echo '
	<thead class="text-primary">'."\n".'
		<tr>'."\n".'
			<th>Nº OS</th>'."\n".'
			<th>Aparelho</th>'."\n".'
			<th>Portador</th>'."\n".'
			<th class="text-center">Abertura</th>'."\n";
	switch ($tipo)
	{
		case "finalizadas":
			echo '
			<th class="text-center">Fechamento</th>'."\n";
			break;
			
		case "canceladas":
			echo '
			<th class="text-center">Fechamento</th>';
			break;
			
		default:
			break;
	}
		echo '
		</tr>'."\n".'
	</thead>'."\n";

	# Corpo Principal
	echo("<tbody>\n");

	if (empty($arr))
	{
		echo '<tr><td colspan="4">Não há resultados para serem mostrados</td></tr>';
	}
	else
	{
		foreach ($arr as $value)
		{
			$ap = $CI->General->select2("*", "patient_itens", array("number_serie"=>$value['NSERIE']))->row();
			$aparelho = $ap->apparatus.' '.$ap->maker.' '.$ap->model;
			$pt = $CI->General->select2("first_name, last_name", "patient", array("patient_id"=>$ap->patient_id))->row();
			$portador = $pt->first_name.' '.$pt->last_name;
			
			echo '
			<tr>'."\n".'
				<td>'.$value["idOS"].'</td>'."\n".'
				<td>'.$aparelho.'</td>'."\n".' 
				<td>'.$portador.'</td>'."\n".'
				<td class="text-center">'.date("d/m/Y H:i", strtotime($value["DTABERTURA"])).'</td>'."\n";
			switch ($tipo)
			{
				case "finalizadas":
					echo '
					<td class="text-center">'.date("d/m/Y H:i", strtotime($value["DTFECHAMENTO"])).'</td>'."\n";
					break;

				case "canceladas":
					echo '
					<td class="text-center">'.date("d/m/Y H:i", strtotime($value["DTFECHAMENTO"])).'</td>'."\n";
					break;

				default:
					break;
			}
			
			echo '	
			</tr>'."\n";
		}
	}

	echo("</tbody>\n");
	echo("</table>\n");

}

function consultas_table_report($arr)
{
	//print_r($arr);
	$CI = &get_instance();
	//print_r($arr);

	echo("<br><table class=\"hover\">\n");

	# Cabeçalho
	echo '
	<thead class="text-primary">'."\n".'
		<tr>'."\n".'
			<th>Paciente</th>'."\n".'
			<th>Fonoaudiólogo(a)</th>'."\n".'
			<th class="text-center">Início Consulta</th>'."\n".'
			<th class="text-center">Fim Consulta</th>'."\n".'
		</tr>'."\n".'
	</thead>'."\n";

	# Corpo Principal
	echo("<tbody>\n");

	if (empty($arr))
	{
		echo '<tr><td colspan="4">Não há resultados para serem mostrados</td></tr>';
	}
	else
	{
		foreach ($arr as $value)
		{
			$pac = $CI->General->select2("first_name, last_name", "patient", array("patient_id"=>$value['patient_id']))->row();
			$paciente = $pac->first_name.' '.$pac->last_name;
			$time  = strtotime($value["appointment"].' '.$value["hour"]);
			$time2 = strtotime("+ 30 minutes", strtotime($value["appointment"].' '.$value["hour"]));
			
			echo '
			<tr>'."\n".'
				<td>'.$paciente.'</td>'."\n".'
				<td>'.$value["doctor_id"].'</td>'."\n".'
				<td class="text-center">'.date("d/m/Y H:i", $time).'</td>'."\n".'
				<td class="text-center">'.date('d/m/Y H:i', $time2).'</td>'."\n".'
			</tr>'."\n";
		}
	}
	
	echo("</tbody>\n");

	echo("</table>\n");

}

function teste_table_report($arr)
{
	/*
	 echo '<pre>';
	 print_r($arr);
	 echo '</pre>';
	 */
	$CI = &get_instance();

	echo("<br><table class=\"hover\">\n");

	# Cabeçalho
	echo '
	<thead class="text-primary">'."\n".'
		<tr>'."\n".'
			<th>Aparelho</th>'."\n".'
			<th class="text-center">Nº Venda</th>'."\n".'
			<th>Cliente</th>'."\n".'
			<th class="text-center">Data da Venda</th>'."\n".'
			<th class="text-right">Pedido de Aparelho</th>'."\n".'
		</tr>'."\n".'
	</thead>'."\n";

	# Corpo Principal
	echo("<tbody>\n");

	if (empty($arr))
	{
		echo '<tr><td colspan="6">Não há resultados para serem mostrados</td></tr>';
	}
	else
	{
		foreach ($arr as $value)
		{
			$item = $CI->General->select2("description", "items", array("item_id"=>5))->row()->description;
			$pt = $CI->General->select2("first_name, last_name", "patient", array("patient_id"=>$value["patient_id"]))->row();
			$portador = $pt->first_name.' '.$pt->last_name;
			$price = $CI->General->select2("selling_price", "items_business", array("item_id"=>$value["item_id"]))->row()->selling_price;
			//echo $portador;exit();
			echo '
			<tr>'."\n".'
				<td>'.$item.'</td>'."\n".'
				<td class="text-center">'.date("d/m/Y", strtotime($value["purchase_date"])).'</td>'."\n".'
				<td class="text-center">'.$value["order"].'</td>'."\n".'
				<td>'.$portador.'</td>'."\n".'
				<td class="text-right">'.money_format("%n", $price).'</td>'."\n".'
			</tr>'."\n";
		}
	}
	echo("</tbody>\n");

	echo("</table>\n");

}

function estoque_itens_table_report($arr)
{
	/*
	 echo '<pre>';
	 print_r($arr);
	 echo '</pre>';
	 */
	$CI = &get_instance();

	echo("<br><table class=\"hover\">\n");

	# Cabeçalho
	echo '
	<thead class="text-primary">'."\n".'
		<tr>'."\n".'
			<th>Aparelho</th>'."\n".'
			<th class="text-center">Quantidade</th>'."\n".'
			<th class="text-center">Último Usuário</th>'."\n".'
			<th class="text-center">Última Modificação</th>'."\n".'
		</tr>'."\n".'
	</thead>'."\n";

	# Corpo Principal
	echo("<tbody>\n");

	if (empty($arr))
	{
		echo '<tr><td colspan="4">Não há resultados para serem mostrados</td></tr>';
	}
	else
	{
		foreach ($arr as $value)
		{
			$item = $CI->General->select2("description", "items", array("item_id"=>$value["item_id"]))->row()->description;
			
			if ($value['trans_user'] == '0') 
			{
				$empregado = 'Não Definido';
			}
			else 
			{
				$pt = $CI->General->select2("first_name, last_name", "employees", array("employees_id"=>$value["trans_user"]))->row();
				$empregado = $pt->first_name.' '.$pt->last_name;
			}
			
			
			echo '
			<tr>'."\n".'
				<td>'.$item.'</td>'."\n".'
				<td class="text-center">'.$value['quantity'].'</td>'."\n".'
				<td class="text-center">'.$empregado.'</td>'."\n".'
				<td class="text-center">'.date("d/m/Y H:i:s", strtotime($value["trans_date"])).'</td>'."\n".'
			</tr>'."\n";
		}
	}
	echo("</tbody>\n");

	echo("</table>\n");

}

function Sestoque_itens_table_report($arr)
{
	/*
	 echo '<pre>';
	 print_r($arr);
	 echo '</pre>';
	 */
	$CI = &get_instance();

	echo("<br><table class=\"hover\">\n");

	# Cabeçalho
	echo '
	<thead class="text-primary">'."\n".'
		<tr>'."\n".'
			<th>Aparelho</th>'."\n".'
			<th class="text-center">Quantidade</th>'."\n".'
			<th class="text-center">Último Usuário</th>'."\n".'
			<th class="text-center">Última Modificação</th>'."\n".'
		</tr>'."\n".'
	</thead>'."\n";

	# Corpo Principal
	echo("<tbody>\n");

	if (empty($arr))
	{
		echo '<tr><td colspan="4">Não há resultados para serem mostrados</td></tr>';
	}
	else
	{
		foreach ($arr as $value)
		{
			$item = $CI->General->select2("description", "items", array("item_id"=>$value["item_id"]))->row()->description;
				
			if ($value['trans_user'] == '0')
			{
				$empregado = 'Não Definido';
			}
			else
			{
				$pt = $CI->General->select2("first_name, last_name", "employees", array("employees_id"=>$value["trans_user"]))->row();
				$empregado = $pt->first_name.' '.$pt->last_name;
			}
				
				
			echo '
			<tr>'."\n".'
				<td>'.$item.'</td>'."\n".'
				<td class="text-center">'.$value['quantity'].'</td>'."\n".'
				<td class="text-center">'.$empregado.'</td>'."\n".'
				<td class="text-center">'.date("d/m/Y H:i:s", strtotime($value["trans_date"])).'</td>'."\n".'
			</tr>'."\n";
		}
	}
	echo("</tbody>\n");

	echo("</table>\n");

}

