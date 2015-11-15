<?php
require_once ("secure_area.php");
class PlanAccounts extends Secure_area
{

	function __construct()
	{
		parent::__construct('planaccounts');
	}

	function index($manage_result = null)
	{
	    date_default_timezone_set('Brazil/East');
	    setlocale(LC_MONETARY, 'pt_BR');
	    
	    
	    $data['treeview'] = $this->categorias(NULL);
	    $this->load->view('plan/planaccounts', $data);		
	}

	function indexHH($plan_id = NULL)
	{
		date_default_timezone_set('Brazil/East');
		setlocale(LC_MONETARY, 'pt_BR');
		$codigo = $this->General->select2("codigo, descricao", "plan_account_sped", array(
			
			'id' => 4
		))->row();
		$lista = $this->Account->lista2('0.00', date('Y-m') . '-01', date('Y-m') . '-28');
		// echo date('Y-m').'-01'.' x '.date('Y-m').'-28';
		// print_r($lista);
		$table = '';
		
		foreach ($lista as $value)
		{
			$table .= '
				<tr>
					<td class="text-center">' . date('d/m/Y', strtotime($value['date'])) . '</td>
					<td class="text-center">' . date('d/m/Y', strtotime($value['launch_date'])) . '</td>
					<td>' . $value['historic'] . '</td>
					<td class="text-right">' . money_format('%n', $value['value']) . '</td>
				</tr>';
		}
		
		$data['lista'] = $table;
		$data['selectOP'] = '';
		$data['selectSub'] = '';
		$data['selectPLA'] = '';
		
		$data['treeview'] = $this->categorias(NULL);
		
		$this->load->view('plan/planaccounts', $data);
	}

	
	
	
	function html()
	{
		$codePlan = $this->PlanAccount->get_all();
		
		foreach ($codePlan->result() as $code)
		{
			$arr = explode('.', $code->codigo);
			$result = count($arr);
			
			switch ($result)
			{
				case 1:
					$ACode[] = $code->descricao;
					break;
				
				case 2:
					$BCode[][$arr[0]] = $code->descricao;
					break;
				
				case 3:
					$CCode[][$arr[0]][$arr[1]] = $code->descricao;
					break;
				
				case 4:
					$DCode[][$arr[0]][$arr[1]][$arr[2]] = $code->descricao;
					break;
				
				case 5:
					$ECode[][$arr[0]][$arr[1]][$arr[2]][$arr[3]] = $code->descricao;
					break;
				
				case 6:
					$FCode[][$arr[0]][$arr[1]][$arr[2]][$arr[3]][$arr[4]] = $code->descricao;
					break;
				
				case 7:
					$GCode[][$arr[0]][$arr[1]][$arr[2]][$arr[3]][$arr[4]][$arr[5]] = $code->descricao;
					break;
				
				case 8:
					$HCode[][$arr[0]][$arr[1]][$arr[2]][$arr[3]][$arr[4]][$arr[5]][$arr[6]] = $code->descricao;
					break;
			}
		}
		
		$string = '' . PHP_EOL;
		$string .= '<ul class="nav nav-list treeview">' . PHP_EOL;
		$SA = 0;
		
		foreach ($ACode as $A)
		{
			// primeiro nivel
			$string .= '	<li><label class="tree-toggler nav-header"><i class="fa fa-folder-o"></i> ' . $A . '</label>' . PHP_EOL;
			$string .= '		<ul class="nav nav-list tree">' . PHP_EOL;
			
			if ($A == 'ATIVO')
			{
				$string .= '			' . $this->printSubCategoria($BCode, '1', $CCode);
			}
			elseif ($A == 'PASSIVO')
			{
				$string .= '			' . $this->printSubCategoria($BCode, '2', $CCode);
			}
			elseif ($A == 'RESULTADO LÍQUIDO DO PERÍODO')
			{
				$string .= '			' . $this->printSubCategoria($BCode, '3', $CCode);
			}
			elseif ($A == 'SUPERÁVIT/DÉFICIT LÍQUIDO DO PERÍODO')
			{
				$string .= '			' . $this->printSubCategoria($BCode, '4', $CCode);
			}
			elseif ($A == 'CUSTOS DE PRODUÇÃO')
			{
				$string .= '			' . $this->printSubCategoria($BCode, '5', $CCode);
			}
			
			$string .= '		</ul>' . PHP_EOL;
			$string .= '	</li>' . PHP_EOL;
			// Fim do primerio nivel
			
			$SA ++;
		}
		
		$string .= '</ul>' . PHP_EOL;
		
		return $string;
	}

	function printSubCategoria($BCode, $key, $CCode)
	{
		$string = '';
		$I = 0;
		$Y = 1;
		foreach ($BCode as $B)
		{
			// Segundo nivel
			
			if (is_array($B))
			{
				if (array_key_exists($key, $B))
				{
					if (is_string($B[$key]))
					{
						$string .= '	<li><label class="tree-toggler nav-header"><i class="fa fa-folder-o"></i> ' . $B[$key] . '</label>' . PHP_EOL;
						$string .= '		<ul class="nav nav-list tree">' . PHP_EOL;
						$string .= $this->printCategoria($CCode, $key, $I, $Y);
						$string .= '		</ul>' . PHP_EOL;
						$string .= '	</li>' . PHP_EOL;
						$I ++;
						$Y ++;
					}
				}
			}
			// Fim do Segundo nivel
		}
		
		return $string;
	}

	function printCategoria($CCode, $key, $I, $Y)
	{
		// Terceiro nivel
		$string = '';
		$A = 1;
		if ($I < $Y)
		{
			foreach ($CCode as $C)
			{
				if (array_key_exists($key, $C))
				{
					if (array_key_exists("0$Y", $C[$key]))
					{
						$string .= '<li><a href="' . $key . '.0' . $Y . '.0' . $A . '">&emsp;<i class="fa fa-file-text-o"></i> &nbsp;&nbsp;' . $C[$key]["0$Y"] . '</a></li>';
						$A ++;
					}
				}
			}
		}
		
		return $string;
		// Fim do Segundo nivel
	}

	function append($plan_id = null)
	{
		if ($this->check_action_permission('add_update'))
		{
			$plan = $this->PlanAccount->get_category();
			
			foreach ($plan->result() as $category)
			{
				$rows[$category->plan_group] = $category->plan_group;
			}
			
			$data['plans_group'] = $rows;
			$data['plans_info'] = $this->PlanAccount->get_info($plan_id);
			$this->load->view('plan/append', $data);
		}
		else
		{
			$this->index('<div class="alert alert-danger">
						<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
						<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
						Opss.. Voc&#234; n&#227;o possui permi&#231;&#227;o para esta a&#231;&#227;o!...
					</div>');
		}
	}
	
	/*
	 * Retorna linhas de dados da tabela cliente. Este ser� chamado com AJAX.
	 */
	function search()
	{
		if ($this->check_action_permission('search'))
		{
			$search = $this->input->post('search');
			$data_rows = get_plan_account_manage_table($this->PlanAccount->search($search), $this);
			$data['num_row'] = 'PLANO DE CONTAS REGISTRADAS <strong><font color="green">' . $this->PlanAccount->count_all() . '</font></strong>';
			
			$data['controller_name'] = 'planaccounts';
			$data['manage_table'] = $data_rows;
			$this->load->view('plan/plans', $data);
		}
		else
		{
			$this->index('<div class="alert alert-danger">
					<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Voc&#234; n&#227;o possui permi&#231;&#227;o para esta a&#231;&#227;o!...
					</div>');
		}
	}
	
	/*
	 * Loads the Plano of Contas Edit form
	 */
	function view($plan_id = null)
	{
		if ($this->check_action_permission('add_update'))
		{
			$plan = $this->PlanAccount->get_category();
			
			foreach ($plan->result() as $category)
			{
				$rows[$category->plan_group] = $category->plan_group;
			}
			
			$data['plans_group'] = $rows;
			
			$data['id'] = $plan_id;
			$data['plans_info'] = $this->PlanAccount->get_info($plan_id);
			$this->load->view('plan/append', $data);
		}
		else
		{
			$this->index('<div class="alert alert-danger">
					<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Voc&#234; n&#227;o possui permi&#231;&#227;o para esta a&#231;&#227;o!...
					</div>');
		}
	}
	
	/*
	 * Inserts/updates a Plano de Conta
	 */
	function save()
	{
	    $plan_id = -1;         // fixa valor para inserirmos sempre um dado 
	    $fim_codigo = '00';    // fixa valor para planos de contas
	    
	    // Instancia valores para serem inseridos como:
	    // codigo pai / descrição / tipo / codigo a ser utilizado.
		$codigo_pai = $this->input->post('codigopai');
		$descricao = $this->input->post('descricao');
		$tipo = $this->input->post('tipo');
		$codigo = str_pad($this->PlanAccount->count_all($codigo_pai) + 1, 2, "0", STR_PAD_LEFT);
		
		// valida a foramtação do codigo a ser utilizado e instancia em $nextCode
		if($tipo == 1){$nextCode = $codigo_pai.'.'.$codigo; $op = 'S';}
		elseif ($tipo == 2){$nextCode = $codigo_pai.'.'.$codigo.'.'.$fim_codigo; $op = 'A';}
		
		
		// monta array $data_plan_account_sped
		$data_plan_account_sped = array(
		    'codigo' => $nextCode,
		    'descricao' => $descricao,
		    'inicio_valid' => date('dmY'),
		    'fim_valid' => '0',
		    'tipo' => $op,
		    'codigo_pai' => $codigo_pai
		);
		
		
		
		
		if ($this->PlanAccount->save($data_plan_account_sped, $plan_id))
		{
			
			// New data PlanAccount
			if ($plan_id == - 1)
			{
				
				echo '<div class="alert alert-success">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
							Registro inserido com sucesso.
						</div>';
			}
			else // previous data PlanAccount
			{
				echo '<div class="alert alert-success">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
							Registro atualizado com sucesso.
						</div>';
			}
		}
		else // failure
		{
			echo '<div class="alert alert-danger">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-plus sign"></i><strong>Erro!</strong>
							Opss.. Ocorreu um erro ao inserir ou atualizar o resgistro.
						</div>
					';
		}
		
	}
	
	/*
	 * Isso exclui os clientes da tabela de clientes
	 */
	function delete($plan_id = null)
	{
		if ($this->check_action_permission('Delete'))
		{
			
			$suppliers_to_delete = $supplier_id;
			
			if ($this->PlanAccount->delete_list($suppliers_to_delete))
			{
				$this->index('<div class="alert alert-info">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-info-circle sign"></i><strong>Info!</strong>
					Foi Deletado ' . count($suppliers_to_delete) . ' Registro(s).
					</div>');
			}
			else
			{
				$this->index('<div class="alert alert-danger">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
						<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
						Opss.. Ocorreu um erro ao deletar o(s) resgistro(s)
						</div>');
			}
		}
		else
		{
			$this->index('<div class="alert alert-danger">
					<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Voc&#234; n&#227;o possui permi&#231;&#227;o para esta a&#231;&#227;o!...
					</div>');
		}
	}

	function categorias($x = null)
	{
		// Busca as primeiras principais Categorias do plano de contas:
		$lista = $this->General->select2("id, codigo, descricao, tipo", "plan_account_sped", array('codigo_pai' => ''), "codigo", "asc")->result_array();		
		$string1 = '<ul class="nav nav-list treeview">' . PHP_EOL;
		
		foreach ($lista as $value)
		{
			$string1 .= '<li><label onclick="javascript: getCodePlan(\''.$value['codigo'].'\',\''.$value['descricao'].'\',\''.$value['tipo'].'\');" class="tree-toggler nav-header"><i class="fa fa-folder-o"></i><small> ' . $value['descricao'] . '</small></label>' . PHP_EOL;
			$string1 .= '	<ul class="nav nav-list tree">' . PHP_EOL;
			$string1 .= $this->subCategorias($value['codigo']);
			$string1 .= '	</ul>' . PHP_EOL;
			$string1 .= '</li>' . PHP_EOL;
		}
		
		$string1 .= '	</ul>' . PHP_EOL;		
		return $string1;
	}

	function subCategorias($codigo_pai)
	{
		$string = '';
		$lista = $this->General->select2("id, codigo, descricao, tipo", "plan_account_sped", array(			
			'codigo_pai' => $codigo_pai
		), "codigo", "asc")->result_array();
		
		// print_r($lista[2]);
		foreach ($lista as $value)
		{
			if ($value['tipo'] == "S")
			{
				$string .= '<li title="' . $value['descricao'] . '" ><label onclick="javascript: getCodePlan(\''.$value['codigo'].'\',\''.$value['descricao'].'\',\''.$value['tipo'].'\');" class="tree-toggler nav-header"><i class="fa fa-folder-o"></i><small> ' . mb_substr($value['descricao'], 0, 27, 'UTF-8') . '</small></label>' . PHP_EOL;
				$string .= '	<ul class="nav nav-list tree">' . PHP_EOL;
				$string .= $this->subCategorias($value['codigo']) . PHP_EOL;
				$string .= '	</ul>' . PHP_EOL;
				$string .= '</li>' . PHP_EOL;
			}
			elseif ($value['tipo'] == "A")
			{
				$string .= '<li title="' . $value['descricao'] . '"><a href="javascript:openit(\'' . $value['id'] . '\')">&emsp;<i class="fa fa-file-text-o"></i><small> &nbsp;&nbsp;' . mb_substr($value['descricao'], 0, 27, 'UTF-8') . '</small></a></li>';
			}
		}
		
		return $string;
	}

	function lancamentos()
	{
		date_default_timezone_set('Brazil/East');
		setlocale(LC_MONETARY, 'pt_BR');
		$id_plano = $this->input->post('url');
		$valor = $this->input->post('valor');
		$data_ini = $this->input->post('datai');
		$data_fim = $this->input->post('dataf');
		
		// Queremos o código do plano e não o id, por isso instacia-se o $codigo
		$codigo = $this->General->select2("codigo, descricao", "plan_account_sped", array(
			
			'id' => $id_plano
		))->row();
		// $codigo = $this->General->select2("descrition", "plan_account", array('plan_id'=>$id_plano))->row();
		
		$idata = explode('/', $data_ini);
		
		$idata = $idata[2] . '-' . $idata[1] . '-' . $idata[0];
		
		$fdata = explode('/', $data_fim);
		$fdata = $fdata[2] . '-' . $fdata[1] . '-' . $fdata[0];
		
		$lista = $this->Account->lista($codigo->codigo, $valor, $idata, $fdata);
		// print_r($lista);
		
		$table = '';
		
		foreach ($lista as $value)
		{
			$table .= '
					<tr>
						<td class="text-center">' . date('d/m/Y', strtotime($value['date'])) . '</td>
						<td class="text-center">' . date('d/m/Y', strtotime($value['launch_date'])) . '</td>
						<td>' . $value['historic'] . '</td>
						<td class="text-right">' . money_format('%n', $value['value']) . '</td>
					</tr>';
		}
		
		if (isset($table) and ! empty($table))
		{
			echo $table;
		}
		else
		{
			echo '<tr><td colspan="4">Não há lançamentos neste plano de contas</td></tr>';
		}
	}
}
?>