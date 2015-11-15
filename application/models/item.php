<?php

class Item extends CI_Model
{
    /* Retornarndo o ultimo item registrado */
    function last_registry()
    {
        $this->db->from('items');
        $this->db->select_max('item_id');
        return $this->db->get();
    }

    function last_data()
    {
        $query = $this->db->query('SELECT MAX(`item_id`) as `item_id` FROM ntic_items ');
        foreach ($query->result() as $value) {
            $row = $value;
        }
        ;
        return $row->item_id;
    }
    
    /* Determina se um determinado item existe */
    function exists($item_id)
    {
        $this->db->from('items');
        $this->db->where('items.item_id', $item_id);
        $query = $this->db->get();
        
        return ($query->num_rows() == 1);
    }
    
    /* Determina se a item_id possui alguma informação nos dados serie */
    function exists_serie($item_id, $location = 1)
    {
        $this->db->from('items_serie');
        $this->db->where('items_serie.item_id', $item_id);
        $this->db->where('items_serie.location_id', $location);
        $query = $this->db->get();
        
        return ($query->num_rows() == 1);
    }
    
    /* Determina se a item_id possui alguma informação nos dados comerciais */
    function exists_business($item_id)
    {
        $this->db->from('items_business');
        $this->db->where('items_business.item_id', $item_id);
        $query = $this->db->get();
        
        return ($query->num_rows() == 1);
    }
    
    /* Determina se a item_id possui alguma informação nos dados Tributarios */
    function exists_nfe($item_id)
    {
        $this->db->from('items_nfe');
        $this->db->where('items_nfe.item_id', $item_id);
        $query = $this->db->get();
        return ($query->num_rows() == 1);
    }
    
    /* Determina se a item_id possui alguma informação nos dados de valores */
    function exists_value($item_id, $location_id)
    {
        $this->db->from('items_value');
        $this->db->where('item_id', $item_id);
        $this->db->where('location_id', $location_id);
        $query = $this->db->get();
        
        return ($query->num_rows() == 1);
    }
    
    /* Tras todas as informações referente a tabela items */
    function get_all()
    {
        $this->db->from('items');
        $this->db->where('deleted', 0);
        $this->db->order_by("description", "asc");
        return $this->db->get();
        
        // select * from items where deleted = 0;
    }
    
    /* Tras todos os items referente a categoria de aparelhos da tabela */
    function get_item_categoria()
    {
        $this->db->from('items');
        $this->db->where('category', 'Aparelhos');
        $this->db->where('deleted', 0);
        $this->db->order_by("description", "asc");
        return $this->db->get();
    }
    
    /* Tras todos os items referente ao item_id e localização da tabela */
    function get_serie($item_id, $location_id = 1)
    {
        $this->db->from('items_serie');
        $this->db->where('item_id', $item_id);
        $this->db->where('location_id', $location_id);
        $this->db->where('stock_local', 1);
        $this->db->order_by('trans_date', 'asc');
        return $this->db->get();
    }
    
    /* Tras todas as informações por JOIN de todos items das tabelas "ntic_items_..." */
    function get_info_all()
    {
        return $this->db->query('SELECT * FROM `ntic_items`
			LEFT JOIN `ntic_items_value` ON `ntic_items_value`.`item_id` = `ntic_items`.`item_id`
			LEFT JOIN `ntic_items_business` ON `ntic_items_business`.`item_id` = `ntic_items`.`item_id`
			LEFT JOIN `ntic_items_serie` ON `ntic_items_serie`.`item_id` = `ntic_items`.`item_id`
			GROUP BY `ntic_items`.`item_id`;');
    }
    
    /*
     * Tras as informações do item referente ao item_id
     * Caso não possua traz a tabela vasia
     */
    function get_info($item_id)
    {
        $this->db->from('items');
        $this->db->where('items.item_id', $item_id);
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            // criar o objeto com propriedades vazias
            $fields = $this->db->list_fields('items');
            $custormer_obj = new stdClass();
            
            // anexar esses campos ao objeto pai de base, n�s temos um objeto completo e vazio
            foreach ($fields as $field) {
                $custormer_obj->$field = '';
            }
            return $custormer_obj;
        }
    }
    
    /*
     * Tras as informações dos dados tributarios referente ao item_id
     * Caso não possua traz a tabela vasia
     */
    function get_info_nfe($item_id)
    {
        $this->db->from('items_nfe');
        $this->db->where('items_nfe.item_id', $item_id);
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            // criar o objeto com propriedades vazias
            $fields = $this->db->list_fields('items_nfe');
            $items_obj = new stdClass();
            
            // anexar esses campos ao objeto pai de base, nós temos um objeto completo e vazio
            foreach ($fields as $field) {
                $items_obj->$field = '';
            }
            
            return $items_obj;
        }
    }
    
    /*
     * Tras as informações do item e de negocioss referente ao item_id
     * Caso não possua traz a tabela vasia
     */
    function get_infoI($item_id)
    {
        $this->db->from('items');
        $this->db->join('items_business', "items_business.item_id = items.item_id");
        $this->db->where('items.item_id', $item_id);
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            // criar o objeto com propriedades vazias
            $fields = $this->db->list_fields('items');
            $custormer_obj = new stdClass();
            
            // anexar esses campos ao objeto pai de base, n�s temos um objeto completo e vazio
            foreach ($fields as $field) {
                $custormer_obj->$field = '';
            }
            return $custormer_obj;
        }
    }
    
    /*
     * Tras as informações do item_serie referente ao numero de serie
     * Caso não possua traz a tabela vasia
     */
    function get_info_serie(&$item_id = -1, $location_id = 1)
    {
        $this->db->from('items_serie');
        $this->db->where('item_id', $item_id);
        $this->db->where('location_id', $location_id);
        $this->db->order_by('trans_date', 'asc');
        
        return $this->db->get();
    }

    function get_serie_info(&$serie)
    {
        $this->db->from('items_serie');
        $this->db->where('item_serie', $serie);
        $query = $this->db->get();
        
        return $query->row();
    }
    
    /*
     * Tras as informações do item_value referente ao item_id
     * Caso não possua traz a tabela vasia
     */
    function get_info_value($item_id)
    {
        $this->db->from('items_value');
        $this->db->where('items_value.item_id', $item_id);
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            // criar o objeto com propriedades vazias
            $fields = $this->db->list_fields('items_value');
            $custormer_obj = new stdClass();
            
            // anexar esses campos ao objeto pai de base, nós temos um objeto completo e vazio
            foreach ($fields as $field) {
                $custormer_obj->$field = '';
            }
            return $custormer_obj;
        }
    }
    
    /*
     * Tras as informações do item_business referente ao item_id
     * Caso não possua traz a tabela vasia
     */
    function get_info_business($item_id)
    {
        $this->db->from('items_business');
        $this->db->where('items_business.item_id', $item_id);
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            // criar o objeto com propriedades vazias
            $fields = $this->db->list_fields('items_business');
            $custormer_obj = new stdClass();
            
            // anexar esses campos ao objeto pai de base, nos temos um objeto completo e vazio
            foreach ($fields as $field) {
                $custormer_obj->$field = '';
            }
            return $custormer_obj;
        }
    }
    
    /*
     * salvar informações na tabela item / antes valida se o item ja existe
     * caso exista processe um update caso contrario insert
     */
    function save(&$item_data, $item_id = false)
    {
        $success = false;
        
        if ($item_data && $item_id) {
            if (! $item_id or ! $this->exists($item_id)) {
                $success = $this->db->insert('items', $item_data);
            } else {
                $this->db->where('item_id', $item_id);
                $success = $this->db->update('items', $item_data);
            }
        }
        
        return $success;
    }
    
    /*
     * salvar informações na tabela item_business / antes valida se o item ja existe
     * caso exista processe um update caso contrario insert
     */
    function save_business(&$item_data, $item_id = false)
    {
        $sucess = false;
        
        if ($item_data && $item_id) {
            if (! $item_id or ! $this->exists_business($item_id)) {
                $sucess = $this->db->insert('items_business', $item_data);
            } else {
                $this->db->where('item_id', $item_id);
                $sucess = $this->db->update('items_business', $item_data);
            }
        }
        return $sucess;
    }
    
    /*
     * salvar informações na tabela item_nfe / antes valida se o item ja existe
     * caso exista processe um update caso contrario insert
     */
    function save_nfe(&$item_data, $item_id = false)
    {
        $success = false;
        
        if ($item_data && $item_id) {
            
            if ($this->exists_nfe($item_id)) {
                $this->db->where('item_id', $item_id);
                $success = $this->db->update('items_nfe', $item_data);
            } else {
                $success = $this->db->insert('items_nfe', $item_data);
            }
        }
        
        return $success;
    }
    
    /*
     * salvar informações na tabela item_value / antes valida se o item ja existe
     * caso exista processe um update caso contrario insert
     */
    function save_value(&$item_data, $item_id = false, $location_id = 1)
    {
        $success = false;
        
        if ($item_data && $item_id) {
            
            if (! $item_id || ! $this->exists_value($item_id, $location_id)) {
                $success = $this->db->insert('items_value', $item_data);
            } else {
                $this->db->where('item_id', $item_id);
                $success = $this->db->update('items_value', $item_data);
            }
        }
        
        return $success;
    }
    
    /*
     * salvar informações na tabela item_value / antes valida se o item ja existe
     * caso exista processe um update caso contrario insert
     */
    function save_serie(&$item_data, $item_id = false, $location_id = 1)
    {
        $success = false;
        
        if ($item_data && $item_id) {
            
            if (! $item_id || ! $this->exists_serie($item_id, $location_id)) {
                $success = $this->db->insert('items_value', $item_data);
            } else {
                $this->db->where('item_id', $item_id);
                $success = $this->db->update('items_value', $item_data);
            }
        }
        
        return $success;
    }
    
    /* Desabilita informações na tabela item */
    function delete($item_id)
    {
        $this->db->where('item_id', $item_id);
        return $this->db->update('items', array(
            'deleted' => 1
        ));
    }
    
    /* Desabilita informações na tabela item de uma lista */
    function delete_list($item_ids)
    {
        $this->db->where_in('item_id', $item_ids);
        return $this->db->update('items', array(
            'deleted' => 1
        ));
    }
    
    /* Busca de Alta Performace para itens */
    function search($search)
    {
        $this->db->from('items');
        $this->db->where("(item_codebar LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		description LIKE '%" . $this->db->escape_like_str($search) . "%' or 		
		category LIKE '%" . $this->db->escape_like_str($search) . "%' and deleted=0)");
        $this->db->order_by("description", "asc");
        
        return $this->db->get();
    }

    function get_item_base_info($id)
    {
        $this->db->select("item_codebar");
        $this->db->select("description");
        $this->db->select("category");
        $this->db->select("type");
        $this->db->select("unit");
        $this->db->from("items");
        $this->db->where("item_id", $id);
        return $this->db->get()->result_array();
    }

    function get_stock($id, $enterprise = 1)
    {
        $this->db->select("quantity");
        $this->db->select("location_id");
        $this->db->from("items_value");
        $this->db->where("item_id", $id);
        $this->db->where("location_id", $enterprise);
        return $this->db->get()->result_array();
    }

    function get_list_category()
    {
        $this->db->select("category");
        $this->db->distinct();
        $this->db->from("items");
        
        return $this->db->get();
    }

    function get_item_list($categoria)
    {
        $this->db->select("item_id");
        $this->db->select("item_codebar");
        $this->db->select("is_serialized");
        $this->db->select("description");
        $this->db->select("unit");
        $this->db->from("items");
        $this->db->where("deleted", 0);
        $this->db->where("category", $categoria);
        $this->db->order_by("item_id", "asc");
        return $this->db->get();
    }

    function total_itens()
    {
        $this->db->select_sum("quantity");
        $this->db->from("items_value");
        return $this->db->get()->result_array()[0]["quantity"];
    }

    function lista_serial($id)
    {
        return $this->db->query("SELECT `ntic_items`.`item_codebar`, `ntic_items`.`description`, `ntic_items`.`category`, `ntic_items`.`unit`, `ntic_items`.`category`,
				`ntic_items_serie`.`item_serie`, `ntic_items_serie`.`trans_date`, `ntic_items_serie`.`location_id`, `ntic_items_serie`.`id`
				FROM `ntic_items`, `ntic_items_serie`
				WHERE `ntic_items`.`deleted` = 0
				AND `ntic_items`.`item_id` = '$id'
				AND `ntic_items`.`is_serialized` = 1
				AND `ntic_items`.`item_id` = `ntic_items_serie`.`item_id`
				ORDER BY `ntic_items_serie`.`trans_date` ASC");
    }

    function get_category($type_id)
    {
        $this->db->select('name, description');
        $this->db->from("type");
        $this->db->where("type_id", $type_id);
        return $this->db->get()->row();
    }

    function update_serie($data, $id)
    {
        return $this->db->update("items_serie", $data, $id);
    }

    function get_dataeserie($id_itemserie)
    {
        $this->db->select("item_serie, trans_date");
        $this->db->from("items_serie");
        $this->db->where("id", $id_itemserie);
        return $this->db->get()->row();
    }

    function insert_newserie($data)
    {
        return $this->db->insert("items_serie", $data);
    }

    function delete_linha_nserie($id)
    {
        return $this->db->delete("items_serie", array(
            'id' => $id
        ));
    }

    function gera_conta_pagar($data)
    {
        return $this->db->insert("accounts", $data);
    }
}
?>

