<?php

class Customer extends CI_Model
{

    function last_registry()
    {
        $this->db->from('patient');
        $this->db->select_max('patient_id');
        return $this->db->get();
    }
    
    /*
     * Determina se um determinado patient_id é um cliente
     */
    function exists($patient_id)
    {
        $this->db->from('patient');
        $this->db->where('patient.patient_id', $patient_id);
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            return $query;
        }
    }
    
    /*
     * Determina se um determinado patient_id é um cliente
     */
    function exists_trade($patient_id)
    {
        $this->db->from('patient_trade');
        $this->db->where('patient_trade.patient_id', $patient_id);
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            return $query;
        }
    }
    
    /*
     * Determina se um determinado patient_id possui algum aparelho
     */
    function exists_item($patient_id)
    {
        $this->db->from('patient_itens');
        $this->db->where('patient_itens.patient_id', $patient_id);
        $this->db->where('deleted', 0);
        return $this->db->get();
    }
    
    /*
     * Determina se um determinado patient_id possui algum aparelho
     */
    function exists_serie($serie)
    {
        $this->db->from('patient_itens');
        $this->db->where('patient_itens.number_serie', $serie);
        $this->db->where('deleted', 0);
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            return true;
        }
    }
    
    /*
     * Determina se um determinado patient_id possui algum informacao adicional
     */
    function exists_info($patient_id)
    {
        $this->db->from('patient_info');
        $this->db->where('patient_info.patient_id', $patient_id);
        $this->db->where('patient_info.deleted', 0);
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            // criar o objeto com propriedades vazias
            $fields = $this->db->list_fields('patient_info');
            $custormer_obj = new stdClass();
            
            // anexar esses campos ao objeto pai de base, nãs temos um objeto completo e vazio
            foreach ($fields as $field) {
                $custormer_obj->$field = '';
            }
            
            return $custormer_obj;
        }
    }

    function last_data()
    {
        $query = $this->db->query('SELECT MAX(`patient_id`) as patient_id FROM ntic_patient ');
        foreach ($query->result() as $value) {
            $row = $value;
        }
        ;
        return $row->patient_id;
    }
    
    /*
     * Retorna todos os clientes
     */
    function get_all()
    {
        $this->db->from('patient');
        $this->db->where('deleted', 0);
        $this->db->order_by("first_name", "asc");
        return $this->db->get();
    }

    function count_all()
    {
        $this->db->from('patient');
        $this->db->where('deleted', 0);
        return $this->db->count_all_results();
    }

    function count_all_aparatus($patient_id)
    {
        $this->db->from('patient_itens');
        $this->db->where('patient_itens.patient_id', $patient_id);
        $this->db->where('deleted', 0);
        return $this->db->count_all_results();
    }

    function get_appointment($appointment_id)
    {
        $this->db->select("atendimento");
        $this->db->select("appointment");
        $this->db->select("hour");
        $this->db->select("doctor_id");
        $this->db->from("appointment");
        $this->db->where("patient_id", $appointment_id);
        $this->db->where("deleted", "1");
        return $this->db->get();
    }
    
    /*
     * Obtem informaes sobre um determinado cliente
     */
    function get_info($customer_id)
    {
        $this->db->from('patient');
        $this->db->where('patient.patient_id', $customer_id);
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            // criar o objeto com propriedades vazias
            $fields = $this->db->list_fields('patient');
            $custormer_obj = new stdClass();
            
            // anexar esses campos ao objeto pai de base, nos temos um objeto completo e vazio
            foreach ($fields as $field) {
                $custormer_obj->$field = '';
            }
            
            return $custormer_obj;
        }
    }

    function get_work($customer_id)
    {
        $this->db->from('patient_trade');
        $this->db->where('patient_trade.patient_id', $customer_id);
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            // criar o objeto com propriedades vazias
            $fields = $this->db->list_fields('patient_trade');
            $custormer_obj = new stdClass();
            
            // anexar esses campos ao objeto pai de base, nos temos um objeto completo e vazio
            foreach ($fields as $field) {
                $custormer_obj->$field = '';
            }
            
            return $custormer_obj;
        }
    }
    
    /*
     * Obt�m informa��es sobre v�rios clientes
     */
    function get_multiple_info($customer_ids)
    {
        $this->db->from('patient');
        $this->db->where_in('patient.patient_id', $customer_ids);
        $this->db->order_by("last_name", "asc");
        return $this->db->get();
    }
    
    /*
     * Execute essas consultas como uma transa��o, n�s queremos ter certeza de que fazemos tudo ou nada
     */
    function save(&$customer_data, $customer_id = false)
    {
        $success = false;
        
        if ($customer_data && $customer_id) {
            if (! $customer_id or ! $this->exists($customer_id)) {
                $success = $this->db->insert('patient', $customer_data);
            } else {
                $this->db->where('patient_id', $customer_id);
                $success = $this->db->update('patient', $customer_data);
            }
        }
        
        return $success;
    }
    
    /*
     * Execute essas consultas como uma transa��o, n�s queremos ter certeza de que fazemos tudo ou nada
     */
    function save_info(&$customer_data, $customer_id = false)
    {
        $success = false;
        
        if ($customer_data && $customer_id) {
            $quary = $this->exists_info($customer_id);
            
            if ($quary->patient_id) {
                $this->db->where('patient_id', $customer_id);
                $success = $this->db->update('patient_info', $customer_data);
            } else {
                $success = $this->db->insert('patient_info', $customer_data);
            }
        }
        
        return $success;
    }
    
    /*
     * Execute essas consultas como uma transa��o, n�s queremos ter certeza de que fazemos tudo ou nada
     */
    function save_apparatus(&$customer_data, $serie = false)
    {
        $success = false;
        
        if ($customer_data && $serie) {
            if (! $this->exists_serie($serie)) {
                $success = $this->db->insert('patient_itens', $customer_data);
            } else {
                $this->db->where('number_serie', $serie);
                $success = $this->db->insert('patient_itens', $customer_data);
            }
        }
        
        return $success;
    }
    
    /*
     * Executa consulta inserido ou alterando a tabela patient_trade
     */
    function save_trade(&$trade_data, $customer_id = false)
    {
        $success = false;
        
        if ($trade_data && $customer_id) {
            if (! $customer_id or ! $this->exists_trade($customer_id)) {
                $success = $this->db->insert('patient_trade', $trade_data);
            } else {
                $this->db->where('patient_id', $customer_id);
                $success = $this->db->update('patient_trade', $trade_data);
            }
        }
        
        return $success;
    }
    
    /*
     * Delete um Cliente
     */
    function delete($customer_id)
    {
        $this->db->where('patient_id', $customer_id);
        return $this->db->update('patient', array(
            'deleted' => 1
        ));
    }
    
    /*
     * Delete um Aparelho do Cliente
     */
    function delete_item($serie)
    {
        $this->db->from('patient_itens');
        $this->db->where('patient_itens.number_serie', $serie);
        return $this->db->update('ntic_patient_itens', array(
            'deleted' => 1
        ));
    }
    
    /*
     * Deletes a list of patient
     */
    function delete_list($customer_ids)
    {
        $this->db->where_in('patient_id', $customer_ids);
        return $this->db->update('patient', array(
            'deleted' => 1
        ));
    }

    function cleanup()
    {
        $customer_data = array(
            'account_number' => null
        );
        $this->db->where('deleted', 1);
        return $this->db->update('patient', $customer_data);
    }
    
    /*
     * Busca de Auta Performace para Clientes
     */
    function search($search, $order = 3)
    {
        $this->db->from('patient');
        
        if ($order == 0) {
            $this->db->where("first_name LIKE '%" . $this->db->escape_like_str($search) . "%'");
        } elseif ($order == 1) {
            $this->db->where("last_name LIKE '%" . $this->db->escape_like_str($search) . "%'");
        } elseif ($order == 2) {
            $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or email LIKE '%" . $this->db->escape_like_str($search) . "%' or phone_home LIKE '%" . $this->db->escape_like_str($search) . "%' or
			phone_work LIKE '%" . $this->db->escape_like_str($search) . "%' or
			phone_cell LIKE '%" . $this->db->escape_like_str($search) . "%' or
			phone_other LIKE '%" . $this->db->escape_like_str($search) . "%' or		
			patient_id LIKE '%" . $this->db->escape_like_str($search) . "%' or
			document_cpf LIKE '%" . $this->db->escape_like_str($search) . "%' or   
			document_rg LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%')");
        } else {
            $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or email LIKE '%" . $this->db->escape_like_str($search) . "%' or phone_home LIKE '%" . $this->db->escape_like_str($search) . "%' or
			phone_work LIKE '%" . $this->db->escape_like_str($search) . "%' or
			phone_cell LIKE '%" . $this->db->escape_like_str($search) . "%' or
			phone_other LIKE '%" . $this->db->escape_like_str($search) . "%' or
			patient_id LIKE '%" . $this->db->escape_like_str($search) . "%' or
			document_cpf LIKE '%" . $this->db->escape_like_str($search) . "%' or
			document_rg LIKE '%" . $this->db->escape_like_str($search) . "%' or
			CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%')");
        }
        
        $this->db->where(array(
            "deleted" => 0
        ));
        $this->db->order_by("first_name", "asc");
        return $this->db->get();
    }
}
?>
