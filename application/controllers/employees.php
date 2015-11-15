<?php
require_once ("secure_area.php");

class Employees extends Secure_area
{

    function __construct()
    {
        parent::__construct('employees');
    }

    function index($manage_result = null)
    {
        $data['manage_result'] = $manage_result;
        $data['controller_name'] = 'employees';
        $data['num_row'] = 'FUNCIONARIOS REGISTRADOS <strong><font color="green">' . $this->Employeer->count_all() . '</font></strong>';
        $data['manage_table'] = get_employeer_manage_table($this->Employeer->get_all(), $this);
        $this->load->view('employees/employees', $data);
    }

    function append($employees_id = -1)
    {
        if ($this->check_action_permission('add_update')) {
            
            $data['employees_info'] = $this->Employeer->get_info($employees_id);
            
            // Inicia Lista de Departamentos
            $employees_departments = $this->Department->get_all();
            
            if ($employees_departments->num_rows() != 0) {
                foreach ($employees_departments->result() as $departmnets) {
                    $rows[$departmnets->name] = $departmnets->name;
                }
                
                $data['employees_department'] = $rows;
            } else {
                $data['employees_department'] = array(
                    'Não há Registro de Departamentos'
                );
            }
            // Acabou Linha de Departamentos
            
            $this->load->view('employees/append', $data);
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
            $data_rows = get_employeer_manage_table($this->Employeer->search($search), $this);
            
            $data['controller_name'] = 'employees';
            $data['manage_table'] = $data_rows;
            $this->load->view('employees/employees', $data);
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
        $suggestions = $this->Employeer->get_search_suggestions($this->input->post('q'), $this->input->post('limit'));
        echo implode("\n", $suggestions);
    }
    
    /*
     * Loads the employeer edit form
     */
    function view($employees_id = -1, $manage_result = null)
    {
        if ($this->check_action_permission('add_update')) {
            if ($employees_id == 1) {
                $this->index('
						<div class="alert alert-info">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
						<i class="fa fa-info-circle sign"></i><strong>Info!</strong>     Voc&#234; N&#227;o pode Editar o Administrador Meganet!
						</div>
			
						');
            } else {
                
                $data['id'] = $employees_id;
                $data['employees_info'] = $this->Employeer->get_info($employees_id);
                $data['active_tab'] = 'href="#user" data-toggle="tab"';
                $data['manage_result'] = $manage_result;
                
                // Inicia Lista de Departamentos
                $employees_departments = $this->Department->get_all();
                
                if ($employees_departments->num_rows() != 0) {
                    foreach ($employees_departments->result() as $departmnets) {
                        $rows[$departmnets->name] = $departmnets->name;
                    }
                    
                    $data['employees_department'] = $rows;
                } else {
                    $data['employees_department'] = array(
                        'N&#227; h&#225; Registro de Departamentos'
                    );
                }
                // Acabou Linha de Departamentos
                
                $this->load->view('employees/append', $data);
            }
        } else {
            $this->index('<div class="alert alert-danger">
					<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Voc&#234; n&#227;o possui permi&#231;&#227;o para esta a&#231;&#227;o!...
					</div>');
        }
    }
    
    /*
     * Inserts/updates a employeer
     */
    function save($employees_id = -1)
    {
        $employeer_data = array(
            'first_name' => ucwords(strtolower($this->input->post('first_name'))),
            'last_name' => ucwords(strtolower($this->input->post('last_name'))),
            'birth_date' => $this->input->post('birth_date'),
            'department_id' => $this->input->post('department_id'),
            'profile' => ucwords(strtolower($this->input->post('profile'))),
            'document_cpf' => $this->input->post('document_cpf'),
            'document_rg' => $this->input->post('document_rg'),
            'phone_number' => $this->input->post('phone_number'),
            'email' => $this->input->post('email'),
            'address_1' => ucwords(strtolower($this->input->post('address_1'))),
            'address_2' => ucwords(strtolower($this->input->post('address_2'))),
            'city' => ucwords(strtolower($this->input->post('city'))),
            'state' => mb_strtoupper($this->input->post('state')),
            'zip' => $this->input->post('zip'),
            'country' => ucwords(strtolower($this->input->post('country'))),
            'isfono' => $this->input->post('isfono')
        );
        
        if ($employees_id) {
            
            // New employeer
            if ($employees_id == - 1) {
                $this->Employeer->save($employeer_data, $employees_id);
                
                $this->view($employees_id, '
						<div class="alert alert-success">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-check sign"></i><strong>Sucesso!</strong> 
							Registro inserido com sucesso ' . corrigeAcentuacao($employeer_data['first_name']) . ' ' . corrigeAcentuacao($employeer_data['last_name']) . '
						</div>');
            } else // previous employeer
{
                $this->Employeer->save($employeer_data, $employees_id);
                
                $this->view($employees_id, '
						<div class="alert alert-success">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-check sign"></i><strong>Sucesso!</strong> 
							Registro atualizado com sucesso ' . corrigeAcentuacao($employeer_data['first_name']) . ' ' . corrigeAcentuacao($employeer_data['last_name']) . '								
						</div>');
            }
        } else // failure
{
            $this->view($employees_id, '
						<div class="alert alert-danger">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-times-circle sign"></i><strong>Erro!</strong> 
							Opss.. Ocorreu um erro ao inserir ou atualizar o resgistro ' . corrigeAcentuacao($employeer_data['first_name']) . ' ' . corrigeAcentuacao($employeer_data['last_name']) . '
						</div>
					');
        }
    }
    
    /*
     * Inserts/updates a employeer
     */
    function save_pass($employees_id = -1)
    {
        $pass = $this->input->post('password');
        
        $employeer_data = array(
            'username' => $this->input->post('username'),
            'password' => md5($this->input->post('password'))
        );
        
        if ($this->Employeer->save_pass($employeer_data, $employees_id)) {
            
            // New employeer
            if ($employees_id == - 1) {
                
                $this->view($employees_id, '
						<div class="alert alert-success">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-check sign"></i><strong>Sucesso!</strong> 
							Registro inserido com sucesso
						</div>');
            } else // previous employeer
{
                
                $this->view($employees_id, '
						<div class="alert alert-success">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-check sign"></i><strong>Sucesso!</strong> 
							Registro atualizado com sucesso								
						</div>');
            }
        } else // failure
{
            $this->view($employees_id, '
						<div class="alert alert-danger">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-times-circle sign"></i><strong>Erro!</strong> 
							Opss.. Ocorreu um erro ao inserir ou atualizar o resgistro
						</div>
					');
        }
    }
    
    /*
     * Isso exclui um funcioanrio da tabela
     */
    function delete($employees_id = -1)
    {
        if ($this->check_action_permission('Delete')) {
            
            $employeer_to_delete = $employees_id;
            
            if ($employeer_to_delete == 1) {
                $this->index('
					<div class="alert alert-info">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
    					<i class="fa fa-info-circle sign"></i><strong>Info!</strong>     Voc&#234; N&#227;o pode Deletar o Administrador Meganet!
					</div>
					
					');
            } else {
                
                if ($this->Employeer->delete_list($employeer_to_delete)) {
                    
                    $this->index('
						<div class="alert alert-info">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
						<i class="fa fa-info-circle sign"></i><strong>Erro!</strong>
						Foi Deletado ' . count($employeer_to_delete) . ' Registro(s).
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