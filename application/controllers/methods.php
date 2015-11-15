<?php
require_once ("secure_area.php");

class Methods extends Secure_area
{

    function __construct()
    {
        parent::__construct('methods');
    }

    function index($manage_result = null)
    {
        $data['manage_result'] = $manage_result;
        $data['controller_name'] = 'methods';
        $data['num_row'] = 'FORMAS DE PAGAMENTOS REGISTRADOS <strong><font color="green">' . $this->Method->count_all() . '</font></strong>';
        $data['manage_table'] = get_method_manage_table($this->Method->get_all(), $this);
        $this->load->view('methods/methods', $data);
    }

    function append($method_id = -1)
    {
        if ($this->check_action_permission('add_update')) {
            $data['methods_info'] = $this->Method->get_info($method_id);
            $this->load->view('methods/append', $data);
        } else {
            $this->index('<div class="alert alert-danger">
					<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Voc&#234; n&#227;o possui permi&#231;&#227;o para esta a&#231;&#227;o!...
					</div>');
        }
    }
    
    /*
     * Retorna linhas de dados da tabela cliente. Este serie chamado com AJAX.
     */
    function search()
    {
        if ($this->check_action_permission('search')) {
            $search = $this->input->post('search');
            $data_rows = get_method_manage_table($this->Method->search($search), $this);
            
            $data['controller_name'] = 'methods';
            $data['manage_table'] = $data_rows;
            $this->load->view('methods/methods', $data);
        } else {
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
        $suggestions = $this->Method->get_search_suggestions($this->input->post('q'), $this->input->post('limit'));
        echo implode("\n", $suggestions);
    }
    
    /*
     * Loads the Method edit form
     */
    function view($method_id = -1)
    {
        if ($this->check_action_permission('add_update')) {
            $data['id'] = $method_id;
            $data['methods_info'] = $this->Method->get_info($method_id);
            
            $listaBanco = $this->Bank->get_all();
            $bancos = $listaBanco->result();
            
            foreach ($bancos as $value) {
                $nomesBancos[$value->cod_bank] = utf8_decode($value->name);
            }
            
            $data['bancos'] = $nomesBancos;
            
            $this->load->view('methods/append', $data);
        } else {
            $this->index('<div class="alert alert-danger">
					<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Voc&#234; n&#227;o possui permi&#231;&#227;o para esta a&#231;&#227;o!...
					</div>');
        }
    }
    
    /*
     * Inserts/updates a Method
     */
    function save($method_id = -1)
    {
        $method_data = array(
            'payment_type' => ucwords(strtolower($this->input->post('payment_type'))),
            'transaction_id' => ucwords(strtolower($this->input->post('transaction_id'))),
            'banco' => $this->input->post('banco'),
            'multa' => $this->input->post('multa'),
            'juros' => $this->input->post('juros')
        );
        
        if ($this->Method->save($method_data, $method_id)) {
            
            // New Method
            if ($method_id == - 1) {
                
                $this->index('
						<div class="alert alert-success">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-check sign"></i><strong>Sucesso!</strong> 
							Registro inserido com sucesso ' . corrigeAcentuacao($method_data['payment_type']) . ' ' . corrigeAcentuacao($method_data['transaction_id']) . '
						</div>');
            } else // previous Method
{
                $this->index('
						<div class="alert alert-success">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-check sign"></i><strong>Sucesso!</strong> 
							Registro atualizado com sucesso ' . corrigeAcentuacao($method_data['payment_type']) . ' ' . corrigeAcentuacao($method_data['transaction_id']) . '		
						</div>');
            }
        } else // failure
{
            $this->index('
						<div class="alert alert-danger">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-plus sign"></i><strong>Erro!</strong> 
							Opss.. Ocorreu um erro ao inserir ou atualizar o resgistro ' . corrigeAcentuacao($method_data['payment_type']) . ' ' . corrigeAcentuacao($method_data['transaction_id']) . '
						</div>
					');
        }
    }
    
    /*
     * Isso exclui os clientes da tabela de clientes
     */
    function delete($method_id = -1)
    {
        if ($this->check_action_permission('Delete')) {
            
            $methods_to_delete = $method_id;
            
            if ($this->Method->delete_list($methods_to_delete)) {
                $this->index('
					<div class="alert alert-info">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-info-circle sign"></i><strong>Info!</strong>
					Foi Deletado ' . count($methods_to_delete) . ' Registro(s).
					</div>
					');
            } else {
                $this->index('
						<div class="alert alert-danger">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
						<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
						Opss.. Ocorreu um erro ao deletar o(s) resgistro(s)
						</div>
						');
            }
        } else {
            $this->index('<div class="alert alert-danger">
					<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Voc&#234; n&#227;o possui permi&#231;&#227;o para esta a&#231;&#227;o!...
					</div>');
        }
    }
}
?>