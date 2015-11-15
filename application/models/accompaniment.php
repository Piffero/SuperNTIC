<?php

class Accompaniment extends CI_Model
{

    function exists($accompaniment = -1)
    {
        $this->db->from('accompaniment');
        $this->db->where('ID', $accompaniment);
        $query = $this->db->get();
        return ($query->num_rows() == 1);
    }

    function exists_by_sale($sale_id = -1, $item_serie)
    {
        $this->db->from('accompaniment');
        $this->db->where('sales_id', $sale_id);
        $this->db->where('number_serie', $item_serie);
        $query = $this->db->get();
        return ($query->num_rows() == 1);
    }

    function exists_visit_group($accompaniment = -1)
    {
        $this->db->from('accomp_group');
        $this->db->where('accomp_op', $accompaniment);        
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_all()
    {
        $this->db->from('accompaniment');
        $this->db->where_not_in('progress', array('9'));
        return $this->db->get();
    }

    function get_info($accompaniment_id)
    {
        $this->db->from('accompaniment');
        $this->db->where('ID', $accompaniment_id);
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            // criar o objeto com propriedades vazias
            $fields = $this->db->list_fields('accompaniment');
            $accompaniment_obj = new stdClass();
            
            // append those fields to base parent object, we we have a complete empty object
            foreach ($fields as $field) {
                $accompaniment_obj->$field = '';
            }
            
            return $accompaniment_obj;
        }
    }

    function get_info_serie($item_serie)
    {
        $this->db->from('accompaniment');
        $this->db->where('number_serie', $item_serie);
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            // cria o objeto com propriedades vazias
            $fields = $this->db->list_fields('accompaniment');
            $accompaniment_obj = new stdClass();
            
            // adicionando aos fields para o objeto, isto deve clompletar os objetos vasios
            foreach ($fields as $field) {
                $accompaniment_obj->$field = '';
            }
            
            return $accompaniment_obj;
        }
    }

    
    
    function get_all_group($accomp_id)
    {
        $this->db->from('accomp_group');
        $this->db->where('accomp_id', $accomp_id);
        return $this->db->get();
    }
    
    
    
    function save($accompaniment_data, $accoumpaniment_id = false)
    {
        $success = false;
        
        if ($accompaniment_data && $accoumpaniment_id) {
            if (!$accoumpaniment_id or !$this->exists($accoumpaniment_id)) {
                $success = $this->db->insert('accompaniment', $accompaniment_data);
            } else {
                $this->db->where('ID', $accoumpaniment_id);
                $success = $this->db->update('accompaniment', $accompaniment_data);
            }
        }
        
        return $success;
    }
    
    
    function save_group(&$accomp_group_data, &$accomp_id, &$accomp_op)
    {
        $success = false;
        // valida se a linhas inseridas sob a operação passada pelo parametro $accomp_op         
        if($this->exists_visit_group($accomp_op) != 0)
        {
            // Primeiro vamos limpar o check list do quadro de acompanhamento que tem atualmente.
            $success = $this->db->delete('accomp_group', array('accomp_op' => $accomp_op));
            
            // Agora insira as novas permissões
            if ($success) {
                foreach ($accomp_group_data as $accomp_key => $accomp_value) {
                    $success = $this->db->insert('accomp_group', array(
                        'accomp_id' => $accomp_id,
                        'accomp_op' => $accomp_op,
                        'accomp_key' => $accomp_key,
                        'accomp_value' => $accomp_value
                    ));
                }
            }
        }
        else 
        {
            foreach ($accomp_group_data as $accomp_key => $accomp_value) {
                $success = $this->db->insert('accomp_group', array(
                    'accomp_id' => $accomp_id,
                    'accomp_op' => $accomp_op,
                    'accomp_key' => $accomp_key,
                    'accomp_value' => $accomp_value
                ));
            }
        }
        
        return $success;
    }
}