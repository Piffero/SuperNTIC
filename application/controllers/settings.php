<?php
require_once ("secure_area.php");

class Settings extends Secure_area
{

    function __construct()
    {
        parent::__construct('settings');
    }

    function index()
    {
        $this->permissions();
    }

    /**
     * QUADRO DE PERMISSOES *
     */
    function permissions()
    {
        $employees_user = $this->Employeer->get_all();
        foreach ($employees_user->result() as $users) {
            if ($users->first_name != 'Administrador')
                $rows[$users->employees_id] = $users->first_name;
        }
        
        $data['employees_user'] = $rows;
        
        $this->load->view("settings/permissions", $data);
    }

    function search_user()
    {
        // Carreaga Permissao de acesso aos modulos
        $search = $this->input->post('user_id');
        
        // Carrega Lista de Usuarios
        $employees_user = $this->Employeer->get_all();
        
        foreach ($employees_user->result() as $users) {
            if ($users->employees_id != '1') {
                $rows[$users->employees_id] = $users->first_name;
                $data['user_name'][$users->employees_id] = $users->first_name . ' ' . $users->last_name;
            }
        }
        
        // Carrega Permissoes ao modulo
        
        $permissions_module = $this->Setting->get_permissions_modulo($search);
        
        if ($permissions_module != array()) {
            
            foreach ($permissions_module->result() as $Permite) {
                $permiting[$Permite->module_id] = $Permite->employees_id;
            }
            $data['permition'] = $permiting;
        }
        
        // Carrega Permissoes as acoes
        $permissions_action = $this->Setting->get_permissions_action($search);
        if ($permissions_action != array()) {
            foreach ($permissions_action->result() as $Permite_Acao) {
                
                if ($Permite_Acao->action_id == 'Delete') {
                    $permiting_action_delete[$Permite_Acao->module_id] = $Permite_Acao->person_id;
                }
                if ($Permite_Acao->action_id == 'search') {
                    $permiting_action_search[$Permite_Acao->module_id] = $Permite_Acao->person_id;
                }
                if ($Permite_Acao->action_id == 'add_update') {
                    $permiting_action_add_update[$Permite_Acao->module_id] = $Permite_Acao->person_id;
                }
                if ($Permite_Acao->action_id == 'listos') {
                    $permiting_action_listos[$Permite_Acao->module_id] = $Permite_Acao->person_id;
                }
                if ($Permite_Acao->action_id == 'openos') {
                    $permiting_action_openos[$Permite_Acao->module_id] = $Permite_Acao->person_id;
                }
                if ($Permite_Acao->action_id == 'tecos') {
                    $permiting_action_tecos[$Permite_Acao->module_id] = $Permite_Acao->person_id;
                }
            }
        }
        
        if (empty($permiting)) {
            $permiting = array();
        }
        
        if (empty($permiting_action_delete)) {
            $permiting_action_delete = array();
        }
        
        if (empty($permiting_action_add_update)) {
            $permiting_action_add_update = array();
        }
        
        if (empty($permiting_action_search)) {
            $permiting_action_search = array();
        }
        
        if (empty($permiting_action_listos)) {
            $permiting_action_listos = array();
        }
        
        if (empty($permiting_action_openos)) {
            $permiting_action_openos = array();
        }
        
        if (empty($permiting_action_tecos)) {
            $permiting_action_tecos = array();
        }
        
        $data['user_id'] = $search;
        $data['permition'] = $permiting;
        $data['permiting_action_add_update'] = $permiting_action_add_update;
        $data['permiting_action_search'] = $permiting_action_search;
        $data['permiting_action_delete'] = $permiting_action_delete;
        $data['permiting_action_listos'] = $permiting_action_listos;
        $data['permiting_action_openos'] = $permiting_action_openos;
        $data['permiting_action_tecos'] = $permiting_action_tecos;
        $data['employees_user'] = $rows;
        
        $this->load->view("settings/permissions", $data);
    }

    function save_permissions($employee_id)
    {
        $permission_data = $this->input->post("permissions") != false ? $this->input->post("permissions") : array();
        $permission_action_data = $this->input->post("permissions_actions") != false ? $this->input->post("permissions_actions") : array();
        
        if ($employee_id) {
            // success
            if ($this->Setting->save($permission_data, $permission_action_data, $employee_id)) {
                
                $this->index('
							<div class="alert alert-success">
								<button class="close" aria-hidden="true" data-dismiss="alert" type="button">X</button>
								<i class="fa fa-check sign"></i><strong>Sucesso!</strong> 
								Permissoes inseridas com sucesso
							</div>');
            }  // failure
else {
                $this->index('<div class="alert alert-danger">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">X</button>
							<i class="fa fa-plus sign"></i><strong>Erro!</strong>
							Opss.. Ocorreu um erro ao inserir ou atualizar o resgistro
						</div>');
            }
        }
    }

    function save_company()
    {
        $batch_save_data = array(
            'RazaoSocial' => $this->input->post('RazaoSocial'),
            'NomeFantasia' => $this->input->post('NomeFantasia'),
            'Responsavel' => $this->input->post('Responsavel'),
            'CNPJ' => $this->input->post('CNPJ'),
            'InscrEstadual' => $this->input->post('InscrEstadual'),
            'Municipal' => $this->input->post('Municipal'),
            'UF' => $this->input->post('UF'),
            'CEP' => $this->input->post('CEP'),
            'Bairro' => $this->input->post('Bairro'),
            'Tipo' => $this->input->post('Tipo'),
            'Logradouro' => $this->input->post('Logradouro'),
            'Complemento' => $this->input->post('Complemento'),
            'Numero' => $this->input->post('Numero'),
            'Email' => $this->input->post('Email'),
            'Telefone' => $this->input->post('Telefone'),
            'Celular' => $this->input->post('Celular'),
            'Fax' => $this->input->post('Fax'),
            'Website' => $this->input->post('Website'),
            'RamoAtividade' => $this->input->post('RamoAtividade'),
            'CNAEFiscal' => $this->input->post('CNAEFiscal'),
            'OSN' => $this->input->post('OSN')
        );
        
        if ($this->Appconfig->batch_save($batch_save_data)) {
            $this->index();
        } else {
            $this->index();
        }
    }
}
/* End of file home.php */
/* Location: ./application/controllers/home.php */