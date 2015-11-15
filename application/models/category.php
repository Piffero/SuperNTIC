<?php

class Category extends CI_Model
{
    /*
     * Determina se um determinado category_id existe
     */
    function exists($category_id)
    {
        $this->db->from('category');
        $this->db->where('category_id', $category_id);
        $query = $this->db->get();
        
        return ($query->num_rows() == 1);
    }
    
    /*
     * Retorna todos os Apontamentos
     */
    function get_all()
    {
        $this->db->from('category');
        $this->db->where('category.deleted', 0);
        $this->db->order_by("name", "asc");
        return $this->db->get();
    }

    function count_all()
    {
        $this->db->from('category');
        $this->db->where('deleted', 0);
        return $this->db->count_all_results();
    }
    
    /*
     * Obt�m informa��es sobre um determinado Apontamento
     */
    function get_info($category_id)
    {
        $this->db->from('category');
        $this->db->where('category_id', $category_id);
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            // criar o objeto com propriedades vazias
            $fields = $this->db->list_fields('category');
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
    function get_multiple_info($category_ids)
    {
        $this->db->from('category');
        $this->db->where_in('category_id', $category_ids);
        $this->db->order_by("name", "asc");
        return $this->db->get();
    }
    
    /*
     * Execute essas consultas como uma transa��o, n�s queremos ter certeza de que fazemos tudo ou nada
     */
    function save(&$category_data, $category_id = false)
    {
        $success = false;
        
        if ($category_data && $category_id) {
            if (! $category_id or ! $this->exists($category_id)) {
                $success = $this->db->insert('category', $category_data);
            } else {
                $this->db->where('category_id', $category_id);
                $success = $this->db->update('category', $category_data);
            }
        }
        
        return $success;
    }
    
    /*
     * Deleta um Apontamento
     */
    function delete($category_id)
    {
        $this->db->where('category_id', $category_id);
        return $this->db->update('category', array(
            'deleted' => 1
        ));
    }
    
    /*
     * Deleta uma lista de Apontamentos
     */
    function delete_list($category_ids)
    {
        $this->db->where_in('category_id', $category_ids);
        return $this->db->update('category', array(
            'deleted' => 1
        ));
    }

    function cleanup()
    {
        $customer_data = array(
            'category_number' => null
        );
        $this->db->where('deleted', 1);
        return $this->db->update('category', $customer_data);
    }
    
    /*
     * Busca de Auta Performace para Apontametos
     */
    function search($search)
    {
        $this->db->from('category');
        $this->db->where("(category_id LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		name LIKE '%" . $this->db->escape_like_str($search) . "%' or
		description LIKE '%" . $this->db->escape_like_str($search) . "%' or
		CONCAT(`name`,' ',`description`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0");
        $this->db->order_by("category_id", "asc");
        
        return $this->db->get();
    }
}
?>
