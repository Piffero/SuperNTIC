<?php

class Sale extends CI_Model
{

    function next_order()
    {
        $query = $this->db->query('SELECT MAX(`order`) AS `order` FROM (`ntic_sales`) WHERE `deleted` = 0 ');
        
        if ($query->num_rows() == 1) {
            
            foreach ($query->result() as $value) {
                $sales_obj = $value;
            }
            $sales_obj->order = $sales_obj->order + 1;
            return $sales_obj;
        } else {
            // criar o objeto com propriedades vazias
            $fields = $this->db->list_fields('sales');
            $sales_obj = new stdClass();
            
            // anexar esses campos ao objeto pai de base, nos temos um objeto completo e vazio
            foreach ($fields as $field) {
                $sales_obj->$field = '';
            }
            
            $sales_obj->order = 1;
            
            return $sales_obj;
        }
    }

    function count_sales_item($order)
    {
        $this->db->from('sales_items');
        $this->db->where('order_id', $order);
        $query = $this->db->get();
        
        return $query->num_rows();
    }

    function checked_sales_item($order)
    {
        $this->db->from('sales_items');
        $this->db->distinct('item_id');
        $this->db->where('order_id', $order);
        $query = $this->db->get();
        
        return $query->num_rows();
    }

    function get_all()
    {
        $this->db->from('sales');
        $this->db->where('deleted', 0);
        return $this->db->get();
    }

    function get_item_all()
    {
        $this->db->from('sales_items');
        return $this->db->get();
    }

    public function get_info($order)
    {
        $this->db->from('sales');
        $this->db->where('order', $order);
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            // criar o objeto com propriedades vazias
            $fields = $this->db->list_fields('sales');
            $custormer_obj = new stdClass();
            
            // anexar esses campos ao objeto pai de base, nãs temos um objeto completo e vazio
            foreach ($fields as $field) {
                $custormer_obj->$field = '';
            }
            
            return $custormer_obj;
        }
    }
    
    
    public function get_info_item_serie($order, $serie)
    {
        $this->db->from('sales_items');
        $this->db->where('order_id', $order);
        $this->db->where('number_serie', $serie);
        $query = $this->db->get();
    
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            // criar o objeto com propriedades vazias
            $fields = $this->db->list_fields('sales_items');
            $custormer_obj = new stdClass();
    
            // anexar esses campos ao objeto pai de base, nãs temos um objeto completo e vazio
            foreach ($fields as $field) {
                $custormer_obj->$field = '';
            }
    
            return $custormer_obj;
        }
    }

    public function get_item_info($order)
    {
        $this->db->from('sales_items');
        $this->db->where('order_id', $order);
        return $this->db->get();
    }

    public function get_item_ald($order)
    {
        $this->db->from('sales_ald');
        $this->db->where('order', $order);
        
        return $this->db->get();
    }

    function exists($sale_id)
    {
        $this->db->from('sales');
        $this->db->where('order', $sale_id);
        $query = $this->db->get();
        
        return ($query->num_rows() == 1);
    }

    function exists_serie($item_serie)
    {
        $this->db->from('items_serie');
        $this->db->where('item_serie', $item_serie);
        $query = $this->db->get();
        
        return ($query->num_rows() == 1);
    }

    function exists_items($sale_id)
    {
        $this->db->from('sales_items');
        $this->db->where('sales_items.sale_id', $sale_id);
        return $this->db->get();
    }

    function exists_payments($sale_id)
    {
        $this->db->from('sales_payments');
        $this->db->where('sales_payments.sale_id', $sale_id);
        return $this->db->get();
    }

    function save(&$sales_data, $sale_id = false)
    {
        $success = false;
        
        if ($sales_data && $sale_id) {
            
            if (! $sale_id || ! $this->exists($sale_id)) {
                $success = $this->db->insert('sales', $sales_data);
            } else {
                $this->db->where('order', $sale_id);
                $success = $this->db->update('sales', $sales_data);
            }
        }
        
        return $success;
    }

    function save_item(&$sales_data)
    {
        $success = false;
        
        if ($sales_data) {
            $success = $this->db->insert('sales_items', $sales_data);
        }
        
        return $success;
    }

    function save_ald(&$sales_data)
    {
        $success = false;
        
        if ($sales_data) {
            $success = $this->db->insert('sales_ald', $sales_data);
        }
        
        return $success;
    }
    
    /*
     * Funções por calcular os dados da venda
     */
    function set_value_for_sales(&$data_sales)
    {
        $this->db->from('items_business');
        $this->db->where_in('item_id', $data_sales);
        return $this->db->get();
    }
    
    /*
     * Funções responsaveis para retonar informações sobre o | Produto | Compra | Outras
     */
    function get_data_compra(&$item_id, &$serie)
    {
        $this->db->from('items_serie');
        $this->db->where('item_id', $item_id);
        $this->db->where('item_serie', $serie);
        return $this->db->get();
    }
    
    // **********************************************************************
    // PRE VENDA
}
?>
