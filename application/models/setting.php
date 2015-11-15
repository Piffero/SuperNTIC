<?php

class Setting extends CI_Model
{
    
    /*
     * Obtem informacoes sobre o modulo que o Empregado tem acesso
     */
    function get_permissions_modulo($employees_id)
    {
        $this->db->from('permissions');
        $this->db->where('permissions.employees_id', $employees_id);
        $query = $this->db->get();
        
        if ($query->num_rows() != 0) {
            return $query;
        } else {
            return array();
        }
    }
    
    /*
     * Obtem informacoes sobre as acoes que o Empregado tem acesso
     */
    function get_permissions_action($employees_id)
    {
        $this->db->from('permissions_actions');
        $this->db->where('permissions_actions.person_id', $employees_id);
        $query = $this->db->get();
        
        if ($query->num_rows() != 0) {
            return $query;
        } else {
            return array();
        }
    }
    
    /*
     * Execute essas consultas como uma transação, nãs queremos ter certeza de que fazemos tudo ou nada
     */
    function save(&$permission_data, &$permission_action_data, $employee_id = null)
    {
        $success = false;
        
        // Temos quer ter inserido ou atualizado um novo funcionário, agora vamos definir permiss�es.
        if ($employee_id) {
            // Primeiro vamos limpar as permissões do empregado tem atualmente.
            $success = $this->db->delete('permissions', array(
                'employees_id' => $employee_id
            ));
            
            // Agora insira as novas permissões
            if ($success) {
                foreach ($permission_data as $allowed_module) {
                    $success = $this->db->insert('permissions', array(
                        'module_id' => $allowed_module,
                        'employees_id' => $employee_id
                    ));
                }
            }
            
            // Primeiro vamos limpar ações quaisquer permissões do empregado tem atualmente.
            $success = $this->db->delete('permissions_actions', array(
                'person_id' => $employee_id
            ));
            
            // Agora insira as novas ações de permissões
            if ($success) {
                foreach ($permission_action_data as $permission_action) {
                    list ($module, $action) = explode('|', $permission_action);
                    $success = $this->db->insert('permissions_actions', array(
                        'module_id' => $module,
                        'action_id' => $action,
                        'person_id' => $employee_id
                    ));
                }
            }
        }
        
        return $success;
    }
}
?>