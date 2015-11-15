<?php

class Department extends CI_Model
{
    /*
     * Determina se um determinado department_id existe
     */
    function exists($department_id)
    {
        $this->db->from('department');
        $this->db->where('department_id', $department_id);
        $query = $this->db->get();
        
        return ($query->num_rows() == 1);
    }
    
    /*
     * Retorna todos os Apontamentos
     */
    function get_all()
    {
        $this->db->from('department');
        $this->db->where('department.deleted', 0);
        $this->db->order_by("name", "asc");
        return $this->db->get();
    }

    function count_all()
    {
        $this->db->from('department');
        $this->db->where('deleted', 0);
        return $this->db->count_all_results();
    }
    
    /*
     * Obt�m informa��es sobre um determinado Apontamento
     */
    function get_info($department_id)
    {
        $this->db->from('department');
        $this->db->where('department_id', $department_id);
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            // criar o objeto com propriedades vazias
            $fields = $this->db->list_fields('department');
            $department_obj = new stdClass();
            
            // anexar esses campos ao objeto pai de base, n�s temos um objeto completo e vazio
            foreach ($fields as $field) {
                $department_obj->$field = '';
            }
            
            return $department_obj;
        }
    }
    
    /*
     * Obt�m informa��es sobre v�rios Apontamentos
     */
    function get_multiple_info($department_ids)
    {
        $this->db->from('department');
        $this->db->where_in('department_id', $department_ids);
        $this->db->order_by("last_name", "asc");
        return $this->db->get();
    }
    
    /*
     * Execute essas consultas como uma transação, nós queremos ter certeza de que fazemos tudo ou nada
     */
    function save(&$department_data, $department_id = false)
    {
        $success = false;
        
        if ($department_data && $department_id) {
            if (! $department_id or ! $this->exists($department_id)) {
                $success = $this->db->insert('department', $department_data);
            } else {
                $this->db->where('department_id', $department_id);
                $success = $this->db->update('department', $department_data);
            }
        }
        
        return $success;
    }
    
    /*
     * Deleta um Apontamento
     */
    function delete($department_id)
    {
        $this->db->where('department_id', $department_id);
        return $this->db->update('department', array(
            'deleted' => 1
        ));
    }
    
    /*
     * Deleta uma lista de Apontamentos
     */
    function delete_list($department_ids)
    {
        $this->db->where_in('department_id', $department_ids);
        return $this->db->update('department', array(
            'deleted' => 1
        ));
    }

    function cleanup()
    {
        $customer_data = array(
            'account_number' => null
        );
        $this->db->where('deleted', 1);
        return $this->db->update('department', $customer_data);
    }
    
    /*
     * Busca de Auta Performace para Apontametos
     */
    function search($search)
    {
        $this->db->from('department');
        $this->db->where("(department_id LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		name LIKE '%" . $this->db->escape_like_str($search) . "%' or
		description LIKE '%" . $this->db->escape_like_str($search) . "%' or
		CONCAT(`name`,' ',`description`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0");
        $this->db->order_by("department_id", "asc");
        
        return $this->db->get();
    }
}
?>
