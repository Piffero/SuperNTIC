<?php

class Method extends CI_Model
{
    /*
     * Determina se um determinado payment_id existe
     */
    function exists($payment_id)
    {
        $this->db->from('payment');
        $this->db->where('payment_id', $payment_id);
        $query = $this->db->get();
        
        return ($query->num_rows() == 1);
    }
    
    /*
     * Retorna todos os Apontamentos
     */
    function get_all()
    {
        $this->db->from('payment');
        $this->db->where('payment.deleted', 0);
        $this->db->order_by("payment_type", "asc");
        return $this->db->get();
    }

    function count_all()
    {
        $this->db->from('payment');
        $this->db->where('deleted', 0);
        return $this->db->count_all_results();
    }
    
    /*
     * Obt�m informa��es sobre um determinado Apontamento
     */
    function get_info($payment_id)
    {
        $this->db->from('payment');
        $this->db->where('payment_id', $payment_id);
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            // criar o objeto com propriedades vazias
            $fields = $this->db->list_fields('payment');
            $payment_obj = new stdClass();
            
            // anexar esses campos ao objeto pai de base, n�s temos um objeto completo e vazio
            foreach ($fields as $field) {
                $payment_obj->$field = '';
            }
            
            return $payment_obj;
        }
    }
    
    /*
     * Obt�m informa��es sobre v�rios Apontamentos
     */
    function get_multiple_info($payment_ids)
    {
        $this->db->from('payment');
        $this->db->where_in('payment_id', $payment_ids);
        $this->db->order_by("last_name", "asc");
        return $this->db->get();
    }
    
    /*
     * Execute essas consultas como uma transa��o, n�s queremos ter certeza de que fazemos tudo ou nada
     */
    function save(&$payment_data, $payment_id = false)
    {
        $success = false;
        
        if ($payment_data && $payment_id) {
            if (! $payment_id or ! $this->exists($payment_id)) {
                $success = $this->db->insert('payment', $payment_data);
            } else {
                $this->db->where('payment_id', $payment_id);
                $success = $this->db->update('payment', $payment_data);
            }
        }
        
        return $success;
    }
    
    /*
     * Deleta um Apontamento
     */
    function delete($payment_id)
    {
        $this->db->where('payment_id', $payment_id);
        return $this->db->update('payment', array(
            'deleted' => 1
        ));
    }
    
    /*
     * Deleta uma lista de Apontamentos
     */
    function delete_list($payment_ids)
    {
        $this->db->where_in('payment_id', $payment_ids);
        return $this->db->update('payment', array(
            'deleted' => 1
        ));
    }

    function cleanup()
    {
        $customer_data = array(
            'account_number' => null
        );
        $this->db->where('deleted', 1);
        return $this->db->update('payment', $customer_data);
    }
    
    /*
     * Busca de Auta Performace para Apontametos
     */
    function search($search)
    {
        $this->db->from('payment');
        $this->db->where("(payment_id LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		doctor_id LIKE '%" . $this->db->escape_like_str($search) . "%' or
		patient_id LIKE '%" . $this->db->escape_like_str($search) . "%' or
		CONCAT(`patient_id`,' ',`doctor_id`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0");
        $this->db->order_by("patient_id", "asc");
        
        return $this->db->get();
    }
}
?>
