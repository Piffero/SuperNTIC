<?php

class Fleet extends CI_Model
{
    /*
     * Determina se um determinado patient_id � um fleet
     */
    function exists($fleet_id)
    {
        $this->db->from('fleets');
        $this->db->where('fleets.fleet_id', $fleet_id);
        $query = $this->db->get();
        
        return ($query->num_rows() == 1);
    }
    
    /*
     * Determina se um determinado fleet_id possui alguma taxa
     */
    function exists_taxa($fleet_id)
    {
        $this->db->from('fleets_taxes');
        $this->db->where('fleets_taxes.fleet_id', $fleet_id);
        $query = $this->db->get();
        
        return ($query->num_rows() == 1);
    }
    
    /*
     * Determina se um determinado fleet_id possui alguma compra
     */
    function exists_purch($fleet_id)
    {
        $this->db->from('fleets_purch');
        $this->db->where('fleets_purch.fleet_id', $fleet_id);
        $query = $this->db->get();
        
        return ($query->num_rows() == 1);
    }
    
    /*
     * Determina se um determinado fleet_id possui alguma venda
     */
    function exists_sales($fleet_id)
    {
        $this->db->from('fleets_sales');
        $this->db->where('fleets_sales.fleet_id', $fleet_id);
        $query = $this->db->get();
        
        return ($query->num_rows() == 1);
    }
    
    /*
     * Determina se um determinado fleet_id possui algum fornecedor atribuido
     */
    function exists_value($fleet_id)
    {
        $this->db->from('fleets_value');
        $this->db->where('fleets_value.fleet_id', $fleet_id);
        $query = $this->db->get();
        
        return ($query->num_rows() == 1);
    }
    
    /*
     * Obtem informacoes sobre varios itens cujo tenha o mesmo fornecedor
     */
    function exists_supplier($supplier_id = -1)
    {
        $this->db->from('fleets');
        $this->db->where('supplier_id', $supplier_id);
        $this->db->order_by("serie", "asc");
        
        if ($query->num_rows() > 0) {
            return $this->db->get();
        } else {
            // criar o objeto com propriedades vazias
            $fields = $this->db->list_fields('fleets');
            $custormer_obj = new stdClass();
            
            // anexar esses campos ao objeto pai de base, n�s temos um objeto completo e vazio
            foreach ($fields as $field) {
                $custormer_obj->$field = '';
            }
            
            return $custormer_obj;
        }
    }
    
    /*
     * Retorna todos os fleets
     */
    function get_all()
    {
        $this->db->from('fleets');
        $this->db->where('deleted', 0);
        $this->db->order_by("description", "asc");
        return $this->db->get();
    }

    function count_all()
    {
        $this->db->from('fleets');
        $this->db->where('deleted', 0);
        return $this->db->count_all_results();
    }
    
    /*
     * Obtem informacoes sobre um determinado fleet
     */
    function get_info($fleet_id)
    {
        $this->db->from('fleets');
        $this->db->where('fleets.fleet_id', $fleet_id);
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            // criar o objeto com propriedades vazias
            $fields = $this->db->list_fields('fleets');
            $custormer_obj = new stdClass();
            
            // anexar esses campos ao objeto pai de base, n�s temos um objeto completo e vazio
            foreach ($fields as $field) {
                $custormer_obj->$field = '';
            }
            
            return $custormer_obj;
        }
    }
    
    /*
     * Obtem informacoes sobre varios itens
     */
    function get_multiple_info($fleet_ids)
    {
        $this->db->from('fleets');
        $this->db->where_in('patient.fleet_id', $fleet_ids);
        $this->db->order_by("description", "asc");
        return $this->db->get();
    }
    
    /*
     * Execute essas consultas como uma transa��o, n�s queremos ter certeza de que fazemos tudo ou nada
     */
    function save(&$fleet_data, $fleet_id = false)
    {
        $success = false;
        
        if ($fleet_data && $fleet_id) {
            if (! $fleet_id or ! $this->exists($fleet_id)) {
                $success = $this->db->insert('fleets', $fleet_data);
            } else {
                $this->db->where('fleet_id', $fleet_id);
                $success = $this->db->update('fleets', $fleet_data);
            }
        }
        
        return $success;
    }
    
    /*
     * Deleta um fleet
     */
    function delete($fleet_id)
    {
        $this->db->where('fleet_id', $fleet_id);
        return $this->db->update('fleets', array(
            'deleted' => 1
        ));
    }
    
    /*
     * Deleta uma lista de fleets
     */
    function delete_list($fleet_ids)
    {
        $this->db->where_in('fleet_id', $fleet_ids);
        return $this->db->update('fleets', array(
            'deleted' => 1
        ));
    }

    function cleanup()
    {
        $fleet_data = array(
            'fleet_number' => null
        );
        $this->db->where('deleted', 1);
        return $this->db->update('fleets', $fleet_data);
    }
    
    /*
     * Busca de Auta Performace para Clientes
     */
    function search($search)
    {
        $this->db->from('fleets');
        $this->db->where("(fleet_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		description LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		supplier_id LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		category LIKE '%" . $this->db->escape_like_str($search) . "%' and deleted=0)");
        $this->db->order_by("description", "asc");
        
        return $this->db->get();
    }
}
?>

