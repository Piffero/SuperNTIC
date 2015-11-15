<?php
require_once ("secure_area.php");

class Departments extends Secure_area
{

    function __construct()
    {
        parent::__construct('departments');
    }

    function index($manage_result = null)
    {
        $data['manage_result'] = $manage_result;
        $data['controller_name'] = 'departments';
        $data['num_row'] = 'DEPARTAMENTOS REGISTRADOS <strong><font color="green">' . $this->Department->count_all() . '</font></strong>';
        $data['manage_table'] = get_department_manage_table($this->Department->get_all(), $this);
        $this->load->view('departments/departments', $data);
    }

    function append($departments_id = -1)
    {
        if ($this->check_action_permission('add_update')) {
            $data['departments_info'] = $this->Department->get_info($departments_id);
            $this->load->view('departments/append', $data);
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
            $data_rows = get_department_manage_table($this->Department->search($search), $this);
            
            $data['num_row'] = 'DEPARTAMENTOS REGISTRADOS <strong><font color="green">' . $this->Department->count_all() . '</font></strong>';
            $data['controller_name'] = 'Departments';
            $data['manage_table'] = $data_rows;
            $this->load->view('departments/departments', $data);
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
        $suggestions = $this->Department->get_search_suggestions($this->input->post('q'), $this->input->post('limit'));
        echo implode("\n", $suggestions);
    }
    
    /*
     * Loads the Department edit form
     */
    function view($Departments_id = -1, $manage_result = null)
    {
        if ($this->check_action_permission('add_update')) {
            $data['id'] = $Departments_id;
            $data['manage_result'] = $manage_result;
            $data['departments_info'] = $this->Department->get_info($Departments_id);
            $this->load->view('departments/append', $data);
        } else {
            $this->index('<div class="alert alert-danger">
					<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Voc&#234; n&#227;o possui permi&#231;&#227;o para esta a&#231;&#227;o!...
					</div>');
        }
    }
    
    /*
     * Inserts/updates a Department
     */
    function save($departments_id = -1)
    {
        $department_data = array(
            'name' => ucwords(strtolower($this->input->post('name'))),
            'description' => $this->input->post('description')
        );
        
        if ($departments_id) {
            
            // New Department
            if ($departments_id == - 1) {
                $this->Department->save($department_data, $departments_id);
                $this->view($departments_id, '
						<div class="alert alert-success">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
						<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
						Registro inserido com sucesso ' . ($department_data['name']) . ' ' . ($department_data['description']) . ' ' . ($departments_id) . '
						</div>');
            } else // previous Department
{
                $this->Department->save($department_data, $departments_id);
                $this->view($departments_id, '
						<div class="alert alert-success">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">X</button>
						<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
						Registro atualizado com sucesso ' . ($department_data['name']) . ' ' . ($department_data['description']) . '
						</div>');
            }
        } else // failure
{
            $this->view($departments_id, '
					<div class="alert alert-danger">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">X</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Ocorreu um erro ao inserir ou atualizar o resgistro ' . ($department_data['name']) . ' ' . ($department_data['description']) . '
					</div>
					');
        }
    }
    
    /*
     * Isso exclui os clientes da tabela de clientes
     */
    function delete($departments_id = -1)
    {
        if ($this->check_action_permission('Delete')) {
            
            $department_to_delete = $departments_id;
            
            if ($this->Department->delete_list($department_to_delete)) {
                
                $this->index('
					<div class="alert alert-info">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
					<i class="fa fa-info-circle sign"></i><strong>Erro!</strong>
					Foi Deletado ' . count($department_to_delete) . ' Registro(s).
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