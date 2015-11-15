<?php
require_once ('secure_area.php');

class Boletos extends Secure_area
{

	public function __construct()
	{
		parent::__construct('accounts');
	}

	function index()
	{
		setlocale(LC_ALL, "pt_BR");
		date_default_timezone_set("Brazil/East");
		
		$lista_cliente = $this->Boleto->get_patients()->result_array();
		
		$data['lista_cliente'] = '<option value=""> </option>';
		
		foreach ($lista_cliente as $cliente)
		{
			$x = $this->General->select2("first_name, last_name", "patient", array(
				
				"patient_id" => $cliente['patient_id']
			))->row();
			$data['lista_cliente'] .= '<option value="' . $cliente['patient_id'] . '">' . $x->first_name . ' ' . $x->last_name . '</option>' . PHP_EOL;
		}
		
		$lista_banco = $this->Boleto->get_boleto_banks()->result_array();
		
		$data['lista_banco'] = '<option value=""> </option>';
		
		foreach ($lista_banco as $bancos)
		{
			$banco_cod = str_pad($bancos['bank_id'], 3, "0", STR_PAD_LEFT);
			
			$y = $this->General->select2("name", "banco_sis", array("cod_bank" => $banco_cod))->row();
			$data['lista_banco'] .= '<option value="' . $banco_cod . '">' . $y->name . '</option>' . PHP_EOL;
		}
		
		$get_boletos = $this->General->select2("*", "boletos", array("deleted"=>0));
		
		$data['lista_boleto'] = '';
		
		if ($get_boletos->num_rows() > 0)
		{
			foreach ($get_boletos->result_array() as $boleto)
			{
				$idboleto = str_pad($boleto["bank_id"], 3, "0", STR_PAD_LEFT);
				$data['lista_boleto'] .= '<tr>
											<td><input type="checkbox" id="x" value="' . $boleto['id'] . '"></td>
											<td>' . $boleto['numdocum'] . '</td>	
											<td>' . $this->get_patient($boleto["patient_id"])->first_name . ' ' . $this->get_patient($boleto["patient_id"])->last_name . '</td>
											<td class="text-center">' . date('d/m/Y', strtotime($boleto["vencimento"])) . '</td>
											<td class="text-center">' . $this->get_bank($idboleto) . '</td>';
				if ($boleto['situacao'] == "pago")
				{
					$data['lista_boleto'] .= '<td class="text-center"><label class="label label-success">Pago</label></td>';
				}
				elseif ($boleto['situacao'] == "Cancelado")
				{
					$data['lista_boleto'] .= '<td class="text-center"><label class="label label-warning">Cancelado</label></td>';
				}
				else
				{
					if (strtotime($boleto["vencimento"]) >= strtotime(date('Y-m-d')))
					{
						$data['lista_boleto'] .= '<td class="text-center"><label class="label label-primary">A Receber</label></td>';
					}
					elseif (strtotime($boleto["vencimento"]) < strtotime(date('Y-m-d')))
					{
						$data['lista_boleto'] .= '<td class="text-center"><label class="label label-danger">Atrasado</label></td>';
					}
					else
					{
						$data['lista_boleto'] .= '<td class="text-center"><label class="label label-default">*ERRO*</label></td>';
					}
				}
				
				$data['lista_boleto'] .= '<td class="text-right">' . money_format("%n", $boleto["docvalue"]) . '</td>
										</tr>';
			}
		}
		else
		{
			$data['lista_boleto'] .= '<td colspan="7">Não há Boletos para serem mostrados.</td>';
		}
		
		$this->load->view('boletos/lista', $data);
	}

	function novo($id = null) // se id estiver setado e diferente de null você está editando o boleto, senão está iniciando um novo
	{
		date_default_timezone_set("Brazil/East");
		
		if ($id != NULL)
		{
			$data['id_blt'] = $id;
			$boletox = $this->General->select2("*", "boletos", array('id'=>$id))->row();
			$data['form_edit'] = true;
			$data['blt'] = $boletox;
		}
		
		// Busca lista de bancos no BD
		$bank = $this->Boleto->get_banks()->result_array();
		
		$data['descbank'] = $this->General->select2("instrucoes", "banco_sis", array("deleted"=>0))->result_array()[0]["instrucoes"];
		$lista = '';
		
		foreach ($bank as $banks)
		{
			if ($id != NULL)
			{
				if ($boletox->bank_id == $banks['cod_bank'])
				{
					$lista .= '<option value="' . $banks['cod_bank'] . '" selected="selected">' . $banks["name"] . '</option>';
				}
				else
				{
					$lista .= '<option value="' . $banks['cod_bank'] . '">' . $banks["name"] . '</option>';
				}
			}
			else
			{
				$lista .= '<option value="' . $banks['cod_bank'] . '">' . $banks["name"] . '</option>';
			}
		}
		
		$data['lista'] = $lista;
		
		// Busca lista de pacientes/clientes no BD
		$r = $this->General->select2("patient_id, first_name, last_name", "patient", array(
			
			"deleted" => 0
		), "first_name", "asc")->result_array();
		$lista_cliente = '';
		
		foreach ($r as $cli)
		{
			$lista_cliente .= '<option value="' . $cli["patient_id"] . '">' . $cli["first_name"] . ' ' . $cli["last_name"] . '</option>';
		}
		
		$data['lista_cliente'] = $lista_cliente;
		// echo get_patient('4')->last_name;
		
		$this->load->view('boletos/new', $data);
	}

	public function gerar()
	{
		date_default_timezone_set("Brazil/East");
		$data2 = $this->input->post("vencimento");
		$data3 = explode("/", $data2);
		$data4 = $data3[2] . '-' . $data3[1] . '-' . $data3[0];
		
		$patient_id = $this->input->post("patient");
		$numdocum = $this->input->post("numdocum");
		$nossonum = time();
		
		/* Buscas no BD de Cliente, Banco e Empresa */
		$patient = $this->General->select2("*", "patient", array(
			
			'patient_id' => $patient_id
		))->row();
		$banco = $this->General->select2("*", "banco_sis", array(
			
			"cod_bank" => $this->input->post("bank")
		))
			->row();
		
		$empresa = $this->General->select2("*", "enterprise", array(
			
			"enterprise_id" => $banco->cedente
		))->row(); // ALTERAAAAAR o 1 !!!
		
		/* Montados */
		$cep = explode('.', $patient->zip);
		$cep = $cep[0] . $cep[1];
		$cnpj2 = substr($empresa->cnpj, 0, 2) . '.' . substr($empresa->cnpj, 2, 3) . '.' . substr($empresa->cnpj, 5, 3) . '/' . substr($empresa->cnpj, 8, 4) . '-' . substr($empresa->cnpj, 12, 2);
		
		$dados = array(
			
			'patient_id' => $patient_id,
			'bank_id' => $this->input->post("bank"),
			'quantity' => $this->input->post("quantity"),
			'docvalue' => $this->input->post("docvalue"),
			'vencimento' => $data4,
			'pay_value' => $this->input->post("pay_value"),
			'description' => $this->input->post("description"),
			'prazo' => $data2,
			'nossonum' => (isset($banco->our_number) ? $banco->our_number : $nossonum),
			'nomecli' => $patient->first_name . ' ' . $patient->last_name,
			'cep' => $cep,
			'rua' => $patient->address_1,
			'estado' => $patient->state,
			'cidade' => $patient->city,
			'agencia' => $banco->agency,
			'local' => $banco->local,
			'conta' => $banco->account,
			'cedente' => strtoupper($this->General->select2("razaosocial", "enterprise", array("enterprise_id" => $banco->cedente))->row()->razaosocial),
			'carteira' => $banco->carteira,
			'contrato' => $banco->contrato,
			'convenio' => $banco->convenio,
			'cnpj' => $cnpj2,
			'uf' => $empresa->uf,
			'digito_conta' => $banco->digito_account,
			'digito_agencia' => $banco->digito_agency,
			'local' => $banco->local,
			'mensagem' => $banco->message,
			'ndocum' => $numdocum,
			'nossonum'=>$nossonum
		);
		
		$dadosB = array(
			
			'patient_id' => $patient_id,
			'numdocum' => $numdocum,
			'bank_id' => $this->input->post("bank"),
			'quantity' => $this->input->post("quantity"),
			'docvalue' => $this->input->post("docvalue"),
			'vencimento' => $data4,
			'pay_value' => $this->input->post("pay_value"),
			'description' => $this->input->post("description"),
			'nossonum' => $nossonum
		);
		
		// Insere dados no ntic_boletos
		$this->General->insert("boletos", $dadosB);
		
		$financeiro = array(
			
			'number' => $numdocum,
			'date' => $data4,
			'favored' => $dados['nomecli'],
			'operation' => 1,
			'plan_accounts' => '01.02.01',
			'payment_form' => "Boleto",
			'cost_center' => $dados['docvalue'],
			'value' => $dados['docvalue'],
			'historic' => 'Depósito por Boleto'
		);
		
		// Insere dados no financeiro
		$this->General->insert("accounts", $financeiro);
		
		switch ($dados['bank_id'])
		{
			case "001":
				$this->load->view("boletos/boletos/boleto_bb", $dados); // m ok
				break;
			
			case "104": // "104":
				$this->load->view("boletos/boletos/boleto_cef", $dados); // m ok
				break;
			
			case "237":
				$this->load->view("boletos/boletos/boleto_bradesco", $dados); // m ok
				break;
			
			case "033": // 033":
				$this->load->view("boletos/boletos/boleto_santander_banespa", $dados); // m ok
				break;
			
			case "399":
				$this->load->view("boletos/boletos/boleto_hsbc", $dados); // m ok
				break;
			
			case "344":
				$this->load->view("boletos/boletos/boleto_itau", $dados); // m ok
				break;
			
			default:
				;
				break;
		}
	}

	function cancel($id)
	{
		if ($this->General->update("boletos", array("deleted"=>1), array("id" => $id)))
		{
			if ($this->General->update("accounts", array("deleted"=>1), array("number"=>$id)))
			{
				$this->index('<div class="alert alert-success">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
							Boleto cancelado com sucesso.
						</div>');
			}
			else
			{
				$this->index('<div class="alert alert-danger">
						<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
						<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
						Houve um erro ao tentar cancelar o boleto. Informe este erro ao suporte do NTIC!!!
					</div>');
			}
		}
		else
		{
			$this->index('<div class="alert alert-danger">
						<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
						<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
						Houve um erro ao tentar cancelar o boleto. Informe este erro ao suporte do NTIC!!!
					</div>');
		}
	}

	function search()
	{
		$situacao = $this->input->post("situacao");
		$vencimento = explode("/", $this->input->post("vencimento"));
		$vencimento = $vencimento[2] . '-' . $vencimento[1] . '-' . $vencimento[0];
		
		$patient_id = $this->input->post("patient_id");
		$bank_id = $this->input->post("bank_id");
		
		$lista = $this->Boleto->search($situacao, $vencimento, $patient_id, $bank_id)->result_array();
		
		foreach ($lista as $boleto)
		{
			$idboleto = str_pad($boleto["bank_id"], 3, "0", STR_PAD_LEFT);
			echo '<tr>
					<td><input type="checkbox" id="x" value="' . $boleto['numdocum'] . '"></td>
					<td>' . $boleto['numdocum'] . '</td>	
					<td>' . $this->get_patient($boleto["patient_id"])->first_name . ' ' . $this->get_patient($boleto["patient_id"])->last_name . '</td>
					<td class="text-center">' . date('d/m/Y', strtotime($boleto["vencimento"])) . '</td>
					<td class="text-center">' . $this->get_bank($idboleto) . '</td>';
			
			if ($boleto['situacao'] == "pago")
			{
				echo '<td class="text-center"><label class="label label-success">Pago</label></td>';
			}
			elseif ($boleto['deleted'] == 1)
			{
				echo '<td class="text-center"><label class="label label-warning">Cancelado</label></td>';
			}
			else
			{
				if (strtotime($boleto["vencimento"]) >= strtotime(date('Y-m-d')))
				{
					echo '<td class="text-center"><label class="label label-primary">A Receber</label></td>';
				}
				elseif (strtotime($boleto["vencimento"]) < strtotime(date('Y-m-d')))
				{
					echo '<td class="text-center"><label class="label label-danger">Atrasado</label></td>';
				}
				else
				{
					echo '<td class="text-center"><label class="label label-default">*ERRO*</label></td>';
				}
			}
			
			echo '<td class="text-right">' . money_format("%n", $boleto["docvalue"]) . '</td>
				</tr>';
		}
	}

	public function update()
	{
		date_default_timezone_set("Brazil/East");
		
		$numdocum = $this->input->post("numdocum");
		$id_blt = $this->input->post("id");
		
		$data2 = $this->input->post("vencimento");
		$data3 = explode("/", $data2);
		$data4 = $data3[2] . '-' . $data3[1] . '-' . $data3[0];
		
		$patient_id = $this->input->post("patient");
		$nossonum = time();
		
		/* Buscas no BD de Cliente, Banco e Empresa */
		$patient = $this->General->select2("*", "patient", array('patient_id' => $patient_id))->row();
		$banco = $this->General->select2("*", "banco_sis", array("cod_bank" => $this->input->post("bank")))->row();
		$empresa = $this->General->select2("*", "enterprise", array("enterprise_id" => $banco->cedente))->row(); // 
		
		/* Montados */
		$cep = explode('.', $patient->zip);
		$cep = $cep[0] . $cep[1];
		$cnpj2 = substr($empresa->cnpj, 0, 2) . '.' . substr($empresa->cnpj, 2, 3) . '.' . substr($empresa->cnpj, 5, 3) . '/' . substr($empresa->cnpj, 8, 4) . '-' . substr($empresa->cnpj, 12, 2);
		
		$dados = array(
			
			'patient_id' => $patient_id,
			'bank_id' => $this->input->post("bank"),
			'quantity' => $this->input->post("quantity"),
			'docvalue' => $this->input->post("docvalue"),
			'vencimento' => $data4,
			'pay_value' => $this->input->post("pay_value"),
			'description' => $this->input->post("description"),
			'prazo' => $data2,
			'nossonum' => $nossonum, // (isset($banco->our_number) ? $banco->our_number : ''),
			'nomecli' => $patient->first_name . ' ' . $patient->last_name,
			'cep' => $cep,
			'rua' => $patient->address_1,
			'estado' => $patient->state,
			'cidade' => $patient->city,
			'agencia' => $banco->agency,
			'local' => $banco->local,
			'conta' => $banco->account,
			'cedente' => strtoupper($this->General->select2("razaosocial", "enterprise", array(
				
				"enterprise_id" => $banco->cedente
			))->row()->razaosocial),
			'carteira' => $banco->carteira,
			'contrato' => $banco->contrato,
			'convenio' => $banco->convenio,
			'cnpj' => $cnpj2,
			'uf' => $empresa->uf,
			'digito_conta' => $banco->digito_account,
			'digito_agencia' => $banco->digito_agency,
			'local' => $banco->local,
			'mensagem' => $banco->message,
			'ndocum' => $numdocum
		);
		
		$dadosB = array(
			
			'patient_id' => $patient_id,
			'bank_id' => $this->input->post("bank"),
			'quantity' => $this->input->post("quantity"),
			'docvalue' => $this->input->post("docvalue"),
			'vencimento' => $data4,
			'pay_value' => $this->input->post("pay_value"),
			'description' => $this->input->post("description"),
			'numdocum' => $numdocum
		);
		
		// ATUALIZA dados no ntic_boletos
		$this->General->update("boletos", $dadosB, array(
			
			'id' => $id_blt
		));
		
		$financeiro = array(
			
			'date' => $data4,
			'favored' => $dados['nomecli'],
			'cost_center' => $dados['docvalue'],
			'value' => $dados['docvalue']
		);
		
		// ATUALIZA dados no financeiro
		$this->General->update("accounts", $financeiro, array(
			
			'number' => $numdocum,
			'operation' => 1,
			'payment_form' => 'Boleto',
			'plan_accounts' => '01.02.01',
			'historic' => 'Depósito por Boleto'
		));
		
		switch ($dados['bank_id'])
		{
			case "001":
				$this->load->view("boletos/boletos/boleto_bb", $dados); // m ok
				break;
			
			case "104": // "104":
				$this->load->view("boletos/boletos/boleto_cef", $dados); // m ok
				break;
			
			case "237":
				$this->load->view("boletos/boletos/boleto_bradesco", $dados); // m ok
				break;
			
			case "033": // 033":
				$this->load->view("boletos/boletos/boleto_santander_banespa", $dados); // m ok
				break;
			
			case "399":
				$this->load->view("boletos/boletos/boleto_hsbc", $dados); // m ok
				break;
			
			case "344":
				$this->load->view("boletos/boletos/boleto_itau", $dados); // m ok
				break;
			
			default:
				;
				break;
		}
	}

	function get_patient($patient_id)
	{
		return $this->General->select2("first_name, last_name", "patient", array(
			
			'patient_id' => $patient_id
		))->row();
	}

	function get_bank($bank_id)
	{
		return $this->General->select2("name", "banco_sis", array(
			
			"cod_bank" => $bank_id
		))->row()->name;
	}

	function bank_desc($bank_id)
	{
		echo $this->General->select2("instrucoes", "banco_sis", array(
			
			"cod_bank" => $bank_id
		))->row()->instrucoes;
	}
	
	// **************************************************
	// Criação do Piffero
	// Aqui o sistema receberar as informações referente a cliente, data de vencimeto e valor
	// para poder gerar o boleto.
	function account_create_boletos($account_id)
	{
		$data['numdocum'] = $numdocum = null;
		date_default_timezone_set('America/Sao_Paulo');
		// Busca lista de bancos no BD
		$bank = $this->Boleto->get_banks()->result_array();
		
		$data['descbank'] = $this->General->select2("instrucoes", "banco_sis", array(
			
			"deleted" => 0
		))->result_array()[0]["instrucoes"];
		$lista = '';
		
		foreach ($bank as $banks)
		{
			if ($numdocum != NULL)
			{
				if ($boletox->bank_id == $banks['cod_bank'])
				{
					$lista .= '<option value="' . $banks['cod_bank'] . '" selected="selected">' . $banks["name"] . '</option>';
				}
				else
				{
					$lista .= '<option value="' . $banks['cod_bank'] . '">' . $banks["name"] . '</option>';
				}
			}
			else
			{
				$lista .= '<option value="' . $banks['cod_bank'] . '">' . $banks["name"] . '</option>';
			}
		}
		
		$data['lista'] = $lista;
		
		$account_data = $this->Account->get_info($account_id);
		$customers = $this->Customer->search($account_data->favored);
		$customer = $customers->result();
		$patient_id = $customer[0]->patient_id;
		
		// Busca lista de pacientes/clientes no BD
		$r = $this->General->select2("patient_id, first_name, last_name", "patient", array(
			
			"deleted" => 0
		), "first_name", "asc")->result_array();
		$lista_cliente = '';
		
		foreach ($r as $cli)
		{
			if ($patient_id == $cli['patient_id'])
			{
				$lista_cliente .= '<option value="' . $cli["patient_id"] . '" selected>' . $cli["first_name"] . ' ' . $cli["last_name"] . '</option>';
			}
			else
			{
				$lista_cliente .= '<option value="' . $cli["patient_id"] . '">' . $cli["first_name"] . ' ' . $cli["last_name"] . '</option>';
			}
		}
		
		$data['lista_cliente'] = $lista_cliente;
		// echo get_patient('4')->last_name;
		
		$account_data = $this->Account->get_info($account_id);
		
		$arr_blt = new stdClass();
		$arr_blt->docvalue = $account_data->value;
		$arr_blt->vencimento = $account_data->date;
		
		$data['blt'] = $arr_blt;
		$this->load->view('boletos/new', $data);
	}
}