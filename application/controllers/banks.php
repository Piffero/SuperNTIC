<?php
require_once ("secure_area.php");

class Banks extends Secure_area
{

	function __construct()
	{
		parent::__construct('banks');
	}

	function index($manage_result = null)
	{
		$data['manage_result'] = $manage_result;
		$data['controller_name'] = 'departments';
		$data['num_row'] = 'BANCOS REGISTRADOS <strong><font color="green">' . $this->Bank->count_all() . '</font></strong>';
		$data['manage_table'] = get_bank_manage_table($this->Bank->get_all(), $this);
		$this->load->view('bank/banks', $data);
	}

	function append($bank_id = -1)
	{
		if ($this->check_action_permission('add_update'))
		{
			$data['banks_info'] = $this->Bank->get_info($bank_id);
			$this->load->view('bank/append', $data);
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
			$data_rows = get_bank_manage_table($this->Bank->search($search), $this);
			$data['num_row'] = 'BANCOS REGISTRADOS <strong><font color="green">' . $this->Bank->count_all() . '</font></strong>';
			
			$data['controller_name'] = 'Banks';
			$data['manage_table'] = $data_rows;
			$this->load->view('bank/banks', $data);
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
	 * Gives search suggestions based on what is being searched for
	 */
	function suggest()
	{
		$suggestions = $this->Bank->get_search_suggestions($this->input->post('q'), $this->input->post('limit'));
		echo implode("\n", $suggestions);
	}
	
	/*
	 * Loads the Bank edit form
	 */
	function view($Banks_id = -1, $manage_result = null)
	{
		if ($this->check_action_permission('add_update'))
		{
			
			$a = $this->General->select2("enterprise_id, razaosocial", "enterprise")->result_array();
			
			$data['lista_empresas'] = '<option value=""></option>';
			foreach ($a as $value)
			{
				
				if ($this->General->select2("cedente", "banco_sis", array(
					
					"bank_id" => $Banks_id
				))->row()->cedente == $value["enterprise_id"])
				{
					$data['lista_empresas'] .= '<option value="' . $value["enterprise_id"] . '" selected="selected">' . strtoupper($value["razaosocial"]) . '</option>' . "\n";
				}
				else
				{
					$data['lista_empresas'] .= '<option value="' . $value["enterprise_id"] . '">' . strtoupper($value["razaosocial"]) . '</option>' . "\n";
				}
			}
			
			$data['id'] = $Banks_id;
			$data['manage_result'] = $manage_result;
			$data['banks_info'] = $this->Bank->get_info($Banks_id);
			
			$this->load->view('bank/append', $data);
		}
		else
		{
			$this->index('<div class="alert alert-danger">
					<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Voc&#234; n&#227;o possui permissão para esta ação!...
					</div>');
		}
	}
	
	/*
	 * Inserts/updates a Bank
	 */
	function save($back_id = -1)
	{
		$back_data = array(
			
			'cod_bank' => ucwords(strtolower($this->input->post('cod_bank'))),
			'name' => $this->input->post('name'),
			'agency' => $this->input->post("agency"),
			'account' => $this->input->post("account"),
			'remessa' => $this->input->post("remessa"),
			'debito' => $this->input->post("debito"),
			'cedente' => $this->input->post("cedente"),
			'local' => $this->input->post('local'),
			'instrucoes' => $this->input->post('instrucoes'),
			'message' => $this->input->post('message'),
			'carteira' => $this->input->post("carteira"),
			'digito_account' => $this->input->post('digito_account'),
			'digito_agency' => $this->input->post("digito_agency"),
			'convenio' => $this->input->post("convenio"),
			'contrato' => $this->input->post("contrato")
		);
		
		if ($this->Bank->save($back_data, $back_id))
		{
			
			// New Bank
			if ($back_id == - 1)
			{
				$this->index('
						<div class="alert alert-success">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
						<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
						Registro inserido com sucesso ' . ($back_data['name']) . ' ' . $back_id . '
						</div>');
			}
			else // previous Bank
			{
				$this->index('
						<div class="alert alert-success">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
						<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
						Registro atualizado com sucesso ' . ($back_data['name']) . '</div>');
			}
		}
		else // failure
		{
			$this->view($back_id, '
					<div class="alert alert-danger">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
						<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
						Opss.. Ocorreu um erro ao inserir ou atualizar o resgistro ' . ($back_data['name']) . ' ' . ($back_data['description']) . '
					</div>');
		}
	}
	
	/*
	 * Isso exclui os clientes da tabela de clientes
	 */
	function delete($back_id = -1)
	{
		if ($this->check_action_permission('Delete'))
		{
			
			$bank_to_delete = $back_id;
			
			if ($this->Bank->delete_list($bank_to_delete))
			{
				
				$this->index('	
					<div class="alert alert-info">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
					<i class="fa fa-info-circle sign"></i><strong>Erro!</strong>
					Foi Deletado ' . count($back_to_delete) . ' Registro(s).
					</div>
					');
			}
			else
			{
				$this->index('
						<div class="alert alert-danger">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
						<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
						Opss.. Ocorreu um erro ao deletar o(s) resgistro(s)
						</div>
						');
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
}
?>