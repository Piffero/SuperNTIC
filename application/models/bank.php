<?php

class Bank extends CI_Model
{
    /*
     * Determina se um determinado bank_id existe
     */
    function exists($bank_id)
    {
        $this->db->from('banco_sis');
        $this->db->where('bank_id', $bank_id);
        $query = $this->db->get();
        
        return ($query->num_rows() == 1);
    }
    
    /*
     * Retorna todos os Apontamentos
     */
    function get_all()
    {
        $this->db->from('banco_sis');
        $this->db->where('deleted', 0);
        $this->db->order_by("name", "asc");
        return $this->db->get();
    }

    function count_all()
    {
        $this->db->from('banco_sis');
        $this->db->where('deleted', 0);
        return $this->db->count_all_results();
    }

    /**
     * Obtém informações sobre um determinado Apontamento
     */
    function get_info($bank_id)
    {
        $this->db->from('banco_sis');
        $this->db->where('bank_id', $bank_id);
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            // criar o objeto com propriedades vazias
            $fields = $this->db->list_fields('banco_sis');
            $banco_sis_obj = new stdClass();
            
            // anexar esses campos ao objeto pai de base, n�s temos um objeto completo e vazio
            foreach ($fields as $field) {
                $banco_sis_obj->$field = '';
            }
            
            return $banco_sis_obj;
        }
    }
    
    /*
     * Obt�m informa��es sobre v�rios Apontamentos
     */
    function get_multiple_info($bank_ids)
    {
        $this->db->from('banco_sis');
        $this->db->where_in('bank_id', $bank_ids);
        $this->db->order_by("name", "asc");
        return $this->db->get();
    }
    
    /*
     * Execute essas consultas como uma transa��o, n�s queremos ter certeza de que fazemos tudo ou nada
     */
    function save(&$banco_sis_data, $bank_id = false)
    {
        $success = false;
        
        if ($banco_sis_data && $bank_id) {
            if (! $bank_id or ! $this->exists($bank_id)) {
                $success = $this->db->insert('banco_sis', $banco_sis_data);
            } else {
                $this->db->where('bank_id', $bank_id);
                $success = $this->db->update('banco_sis', $banco_sis_data);
            }
        }
        
        return $success;
    }
    
    /*
     * Deleta um Apontamento
     */
    function delete($bank_id)
    {
        $this->db->where('bank_id', $bank_id);
        return $this->db->update('banco_sis', array(
            'deleted' => 1
        ));
    }
    
    /*
     * Deleta uma lista de Apontamentos
     */
    function delete_list($bank_ids)
    {
        $this->db->where_in('bank_id', $bank_ids);
        return $this->db->update('banco_sis', array(
            'deleted' => 1
        ));
    }
    
    /*
     * Busca de Alta Performace para Apontametos
     */
    function search($search)
    {
        $this->db->from('banco_sis');
        $this->db->where("(bank_id LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		cod_bank LIKE '%" . $this->db->escape_like_str($search) . "%' or
		name LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0");
        $this->db->order_by("bank_id", "asc");
        
        return $this->db->get();
    }
}
?>
