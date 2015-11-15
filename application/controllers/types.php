<?php
require_once ("secure_area.php");

class Types extends Secure_area
{

    function __construct()
    {
        parent::__construct('types');
    }

    function index($manager_result = null)
    {
        $data['manage_result'] = $manager_result;
        $data['controller_name'] = 'types';
        $data['num_row'] = 'TIPOS REGISTRADOS <strong><font color="green">' . $this->Type->count_all() . '</font></strong>';
        $data['manage_table'] = get_type_manage_table($this->Type->get_all(), $this);
        $this->load->view('types/types', $data);
    }

    function append($types_id = -1)
    {
        if ($this->check_action_permission('add_update')) {
            $data['types_info'] = $this->Type->get_info($types_id);
            $this->load->view('types/append', $data);
        } else {
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
        if ($this->check_action_permission('search')) {
            $search = $this->input->post('search');
            $data_rows = get_type_manage_table($this->Type->search($search), $this);
            
            $data['num_row'] = 'TIPOS REGISTRADOS <strong><font color="green">' . $this->Type->count_all() . '</font></strong>';
            $data['controller_name'] = 'types';
            $data['manage_table'] = $data_rows;
            $this->load->view('types/types', $data);
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
        $suggestions = $this->Type->get_search_suggestions($this->input->post('q'), $this->input->post('limit'));
        echo implode("\n", $suggestions);
    }
    
    /*
     * Loads the Type edit form
     */
    function view($types_id = -1)
    {
        if ($this->check_action_permission('add_update')) {
            $data['id'] = $types_id;
            $data['types_info'] = $this->Type->get_info($types_id);
            $this->load->view('types/append', $data);
        } else {
            $this->index('<div class="alert alert-danger">
					<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Voc&#234; n&#227;o possui permi&#231;&#227;o para esta a&#231;&#227;o!...
					</div>');
        }
    }
    
    /*
     * Inserts/updates a Type
     */
    function save($types_id = -1)
    {
        $type_data = array(
            'name' => ucwords(strtolower($this->input->post('name'))),
            'description' => $this->input->post('description'),
            'issale' => $this->input->post('issale')
        );
        
        if ($types_id) {
            
            // New type
            if ($types_id == - 1) {
                $this->Type->save($type_data, $types_id);
                $this->index('
						<div class="alert alert-success">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
						<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
						Registro inserido com sucesso ' . ($type_data['name']) . ' ' . ($type_data['description']) . ' ' . ($types_id) . '
						</div>');
            } else // previous type
{
                $this->Type->save($type_data, $types_id);
                $this->index('
						<div class="alert alert-success">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
						<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
						Registro atualizado com sucesso ' . ($type_data['name']) . ' ' . ($type_data['description']) . '
						</div>');
            }
        } else // failure
{
            $this->index('
					<div class="alert alert-danger">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Ocorreu um erro ao inserir ou atualizar o resgistro ' . ($type_data['name']) . ' ' . ($type_data['description']) . '
					</div>
					');
        }
    }
    
    /*
     * Isso exclui os clientes da tabela de clientes
     */
    function delete($types_id = -1)
    {
        if ($this->check_action_permission('Delete')) {
            $type_to_delete = $types_id;
            
            if ($this->Type->delete_list($type_to_delete)) {
                
                $this->index('
					<div class="alert alert-info">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
					<i class="fa fa-info-circle sign"></i><strong>Erro!</strong>
					Foi Deletado ' . count($type_to_delete) . ' Registro(s).
					</div>
					');
            } else {
                $this->index('
						<div class="alert alert-danger">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
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