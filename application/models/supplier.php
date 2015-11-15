<?php

class Supplier extends CI_Model
{

    function last_registry()
    {
        $this->db->from('suppliers');
        $this->db->select_max('suppliers_id');
        return $this->db->get();
    }
    
    /*
     * Determina se um determinado suppliers_id � um cliente
     */
    function exists($suppliers_id)
    {
        $this->db->from('suppliers');
        $this->db->where('suppliers.suppliers_id', $suppliers_id);
        $query = $this->db->get();
        
        return ($query->num_rows() == 1);
    }
    
    /*
     * Determina se um determinado item_id possui algum Fornecedor
     */
    function exists_item($suppliers_id)
    {
        $this->db->from('items_taxes');
        $this->db->where('items_taxes.supplier_id', $suppliers_id);
        $query = $this->db->get();
        
        return ($query->num_rows() == 1);
    }
    
    /*
     * Retorna todos os Fornecedor
     */
    function get_all()
    {
        $this->db->from('suppliers');
        $this->db->where('deleted', 0);
        $this->db->order_by("corporate_name", "asc");
        return $this->db->get();
    }

    function count_all()
    {
        $this->db->from('suppliers');
        $this->db->where('deleted', 0);
        return $this->db->count_all_results();
    }
    
    /*
     * Obt�m informa��es sobre um determinado Fornecedor
     */
    function get_info($supplier_id)
    {
        $this->db->from('suppliers');
        $this->db->where('suppliers.suppliers_id', $supplier_id);
        $query = $this->db->get();
        
        if ($query->num_rows() === 1) {
            return $query->row();
        } else {
            // criar o objeto com propriedades vazias
            $fields = $this->db->list_fields('suppliers');
            $custormer_obj = new stdClass();
            
            // anexar esses campos ao objeto pai de base, n�s temos um objeto completo e vazio
            foreach ($fields as $field) {
                $custormer_obj->$field = '';
            }
            
            return $custormer_obj;
        }
    }
    
    /*
     * Obtém informações sobre vários Fornecedores
     */
    function get_multiple_info($supplier_ids)
    {
        $this->db->from('suppliers');
        $this->db->where_in('suppliers.suppliers_id', $supplier_ids);
        $this->db->order_by("corporate_name", "asc");
        return $this->db->get();
    }
    
    /*
     * Obtém informações sobre vários Itens
     * comprados de um Fornecedor
     */
    function get_suppliers_item($supplier_id)
    {
        $this->db->from('suppliers_item');
        $this->db->where('suppliers_id', $supplier_id);
        return $this->db->get();
    }
    
    /*
     * Execute essas consultas como uma transação, nós queremos ter certeza de que fazemos tudo ou nada
     */
    function save(&$customer_data, $supplier_id = false)
    {
        $success = false;
        
        if ($customer_data && $supplier_id) {
            if (! $supplier_id or ! $this->exists($supplier_id)) {
                $success = $this->db->insert('suppliers', $customer_data);
            } else {
                $this->db->where('suppliers_id', $supplier_id);
                $success = $this->db->update('suppliers', $customer_data);
            }
        }
        
        return $success;
    }
    
    /*
     * Delete um Fornecedor
     */
    function delete($supplier_id)
    {
        $this->db->where('suppliers_id', $supplier_id);
        return $this->db->update('suppliers', array(
            'deleted' => 1
        ));
    }
    
    /*
     * Deleta uma lista de Fornecedores
     */
    function delete_list($supplier_ids)
    {
        $this->db->where_in('suppliers_id', $supplier_ids);
        return $this->db->update('suppliers', array(
            'deleted' => 1
        ));
    }

    function cleanup()
    {
        $supplier_data = array(
            'supplier_id' => null
        );
        $this->db->where('deleted', 1);
        return $this->db->update('suppliers', $supplier_data);
    }
    
    /*
     * Busca de Auta Performace para Fornecedores
     */
    function search($search)
    {
        $this->db->from('suppliers');
        $this->db->where("(account_number LIKE '%" . $this->db->escape_like_str($search) . "%' or				
				corporate_name LIKE '%" . $this->db->escape_like_str($search) . "%' or
				fancy_name LIKE '%" . $this->db->escape_like_str($search) . "%' or
				document_cnpj LIKE '%" . $this->db->escape_like_str($search) . "%' or
				phone_number LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0");
        $this->db->order_by("corporate_name", "asc");
        
        return $this->db->get();
    }
}
?>
