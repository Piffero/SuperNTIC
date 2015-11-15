<?php

class Enterprise extends CI_Model
{
    
    /*
     * Determina se a empresa existe
     */
    function exists($enterprise_id)
    {
        $this->db->from('enterprise');
        $this->db->where('enterprise_id', $enterprise_id);
        $query = $this->db->get();
        
        return ($query->num_rows() == 1);
    }
    
    /*
     * Traz todas as empresas cadastradas
     */
    function get_all()
    {
        $this->db->from('enterprise');
        return $this->db->get();
    }

    function get_info(&$enterprise_id)
    {
        $this->db->from('enterprise');
        $this->db->where('enterprise_id', $enterprise_id);
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            // criar o objeto com propriedades vazias
            $fields = $this->db->list_fields('enterprise');
            $employees_obj = new stdClass();
            
            // append those fields to base parent object, we we have a complete empty object
            foreach ($fields as $field) {
                $employees_obj->$field = '';
            }
            
            return $employees_obj;
        }
    }

    function save(&$enterprise_data, $enterprise_id = false)
    {
        $success = false;
        
        if ($enterprise_data && $enterprise_id) {
            if (! $enterprise_id or ! $this->exists($enterprise_id)) {
                $success = $this->db->insert('enterprise', $enterprise_data);
            } else {
                $this->db->where('enterprise_id', $enterprise_id);
                $success = $this->db->update('enterprise', $enterprise_data);
            }
        }
        return $success;
    }
}