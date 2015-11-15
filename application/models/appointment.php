<?php

class Appointment extends CI_Model
{
    /*
     * Determina se um determinado appointment_id existe
     */
    function exists($appointment, $hour, $doctor_id)
    {
        $this->db->from('appointment');
        $this->db->where('appointment', $appointment);
        $this->db->where('hour', $hour);
        $this->db->where('doctor_id', $doctor_id);
        $this->db->where('deleted', 0);
        $query = $this->db->get();
        
        return ($query->num_rows() ? $query->num_rows() : 0);
    }

    function exist($appointment_id)
    {
        $this->db->from('appointment');
        $this->db->where('appointment_id', $appointment_id);
        $this->db->where('deleted', 0);
        $query = $this->db->get();
        
        return ($query->num_rows() == 1);
    }

    function countDoctor(&$appointment, &$hour, &$doctor)
    {
        $this->db->from('appointment');
        $this->db->where('appointment', $appointment);
        $this->db->where('hour', $hour);
        $this->db->where('doctor_id', $doctor);
        $this->db->where('deleted', 0);
        $query = $this->db->get();
        
        return ($query->num_rows() ? $query->num_rows() : 0);
    }
    
    /*
     * Retorna todos os Apontamentos
     */
    function get_all()
    {
        $this->db->from('appointment');
        $this->db->where('appointment.deleted', 0);
        $this->db->order_by('appointment, hour', 'asc');
        return $this->db->get();
    }

    function get_info_date_hour(&$date, &$hour)
    {
        $this->db->from('appointment');
        $this->db->where('appointment', $date);
        $this->db->where('hour', $hour);
        $this->db->where('deleted', 0);
        return $this->db->get();
    }

    function get_info_date_hour_m(&$date)
    {
        $this->db->from('appointment');
        $this->db->where('appointment', $date);
        $this->db->where('deleted', 0);
        return $this->db->get();
    }

    function get_info_date_hour_fono(&$date, &$hour, &$fono)
    {
        $this->db->from('appointment');
        $this->db->where('appointment', $date);
        $this->db->where('hour like "%' . $hour . '%"');
        $this->db->where('doctor_id', $fono);
        $this->db->where('deleted', 0);
        return $this->db->get();
    }

    /**
     * Retorna o numero de registros contidos na
     * tabela ntic_appointment
     */
    function count_all()
    {
        $this->db->from('appointment');
        $this->db->where('deleted', 0);
        return $this->db->count_all_results();
    }

    /**
     * Retorna o numero de linhas referente a data e hora
     * atribuida pelos parametros $date e $hour
     *
     * @param Date $date            
     * @param Time $hour            
     */
    function count_all_date_hour(&$date, &$hour)
    {
        $this->db->from('appointment');
        $this->db->where('appointment', $date);
        $this->db->where('hour', $hour);
        $this->db->where('deleted', 0);
        return $this->db->count_all_results();
    }

    function count_all_date_hour_m(&$date)
    {
        $this->db->from('appointment');
        $this->db->where('appointment', $date);
        $this->db->where('deleted', 0);
        return $this->db->count_all_results();
    }

    /**
     * Retorna o numero de linhas referente a data e hora
     * atribuida pelos parametros $date e $hour
     *
     * @param Date $date            
     * @param Time $hour            
     * @param String $fono            
     */
    function count_all_date_hour_fono(&$date, &$hour, &$fono)
    {
        $this->db->from('appointment');
        $this->db->where('appointment', $date);
        $this->db->where('hour', $hour);
        $this->db->where('doctor_id', $fono);
        $this->db->where('deleted', 0);
        return $this->db->count_all_results();
    }

    function count_all_date_hour_fono_m(&$date, &$hour, &$fono)
    {
        $this->db->from('appointment');
        $this->db->where('appointment', $date);
        $this->db->where('hour like "%' . $hour . '%"');
        $this->db->where('doctor_id', $fono);
        $this->db->where('deleted', 0);
        return $this->db->count_all_results();
    }

    /**
     * Obt�m informa��es sobre um determinado Apontamento
     * refetente ao ID da tabela ntic_appointment
     *
     * @param integer $appointment_id            
     */
    function get_info($appointment_id)
    {
        $this->db->from('appointment');
        $this->db->where('appointment_id', $appointment_id);
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            // criar o objeto com propriedades vazias
            $fields = $this->db->list_fields('appointment');
            $appointment_obj = new stdClass();
            
            // anexar esses campos ao objeto pai de base, n�s temos um objeto completo e vazio
            foreach ($fields as $field) {
                $appointment_obj->$field = '';
            }
            
            return $appointment_obj;
        }
    }

    /**
     * Obt�m informa��es sobre v�rios Apontamentos
     *
     * @param
     *            $appointment_ids
     * @var Array
     */
    function get_multiple_info($appointment_ids)
    {
        $this->db->from('appointment');
        $this->db->where_in('appointment_id', $appointment_ids);
        $this->db->order_by("last_name", "asc");
        return $this->db->get();
    }
    
    /*
     * Execute essas consultas como uma transa��o, n�s queremos ter certeza de que fazemos tudo ou nada
     */
    function save(&$appointment_data, $appointment_id = false)
    {
        $success = false;
        
        if ($appointment_data && $appointment_id) {
            if (! $appointment_id or ! $this->exist($appointment_id)) {
                $success = $this->db->insert('appointment', $appointment_data);
            } else {
                $this->db->where('appointment_id', $appointment_id);
                $success = $this->db->update('appointment', $appointment_data);
            }
        }
        
        return $success;
    }
    
    /*
     * Deleta um Apontamento
     */
    function delete($appointment_id)
    {
        $this->db->where('appointment_id', $appointment_id);
        return $this->db->update('appointment', array(
            'deleted' => 1
        ));
    }
    
    /*
     * Deleta uma lista de Apontamentos
     */
    function delete_list($appointment_ids)
    {
        $this->db->where_in('appointment_id', $appointment_ids);
        return $this->db->update('appointment', array(
            'deleted' => 1
        ));
    }

    function cleanup()
    {
        $customer_data = array(
            'account_number' => null
        );
        $this->db->where('deleted', 1);
        return $this->db->update('appointment', $customer_data);
    }
    
    /*
     * Busca de Alta Performace para Apontametos
     */
    function search($search)
    {
        $this->db->from('appointment');
        $this->db->where("(appointment_id LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		doctor_id LIKE '%" . $this->db->escape_like_str($search) . "%' or
		patient_id LIKE '%" . $this->db->escape_like_str($search) . "%' or
		CONCAT(`patient_id`,' ',`doctor_id`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0");
        $this->db->order_by("patient_id", "asc");
        
        return $this->db->get();
    }

    function paciente()
    {
        $paciente = $this->db->query('SELECT `first_name`, `last_name` FROM `ntic_patient` WHERE 1');
        
        foreach ($paciente->result() as $value) {
            $rows = $value;
        }
        
        return $rows;
    }
}
?>
