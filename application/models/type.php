<?php

class Type extends CI_Model
{
    /*
     * Determina se um determinado type_id existe
     */
    function exists($type_id)
    {
        $this->db->from('type');
        $this->db->where('type_id', $type_id);
        $query = $this->db->get();
        
        return ($query->num_rows() == 1);
    }
    
    /*
     * Retorna todos os Tipo
     */
    function get_all()
    {
        $this->db->from('type');
        $this->db->where('type.deleted', 0);
        $this->db->order_by("type_id", "asc");
        return $this->db->get();
    }

    function count_all()
    {
        $this->db->from('type');
        $this->db->where('deleted', 0);
        return $this->db->count_all_results();
    }
    
    /*
     * Obt�m informa��es sobre um determinado Apontamento
     */
    function get_info($type_id)
    {
        $this->db->from('type');
        $this->db->where('type_id', $type_id);
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            // criar o objeto com propriedades vazias
            $fields = $this->db->list_fields('type');
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
    function get_multiple_info($type_ids)
    {
        $this->db->from('type');
        $this->db->where_in('type_id', $type_ids);
        $this->db->order_by("name", "asc");
        return $this->db->get();
    }
    
    /*
     * Execute essas consultas como uma transa��o, n�s queremos ter certeza de que fazemos tudo ou nada
     */
    function save(&$type_data, $type_id = false)
    {
        $success = false;
        
        if ($type_data && $type_id) {
            if (! $type_id or ! $this->exists($type_id)) {
                $success = $this->db->insert('type', $type_data);
            } else {
                $this->db->where('type_id', $type_id);
                $success = $this->db->update('type', $type_data);
            }
        }
        
        return $success;
    }
    
    /*
     * Deleta um Apontamento
     */
    function delete($type_id)
    {
        $this->db->where('type_id', $type_id);
        return $this->db->update('type', array(
            'deleted' => 1
        ));
    }
    
    /*
     * Deleta uma lista de Apontamentos
     */
    function delete_list($type_ids)
    {
        $this->db->where_in('type_id', $type_ids);
        return $this->db->update('type', array(
            'deleted' => 1
        ));
    }

    function cleanup()
    {
        $customer_data = array(
            'type_number' => null
        );
        $this->db->where('deleted', 1);
        return $this->db->update('type', $customer_data);
    }
    
    /*
     * Busca de Auta Performace para Apontametos
     */
    function search($search)
    {
        $this->db->from('type');
        $this->db->where("(type_id LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		name LIKE '%" . $this->db->escape_like_str($search) . "%' or
		description LIKE '%" . $this->db->escape_like_str($search) . "%' or
		CONCAT(`name`,' ',`description`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0");
        $this->db->order_by("type_id", "asc");
        
        return $this->db->get();
    }
}
?>
