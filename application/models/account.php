<?php

class Account extends CI_Model
{
    /*
     * Determina se um determinado account_id existe
     */
    function exists($number)
    {
        $this->db->from('accounts');
        $this->db->where('number', $number);
        $query = $this->db->get();
        
        return ($query->num_rows() == 1);
    }
    
    /*
     * Retorna todas contas
     */
    function get_all()
    {
        $this->db->from('accounts');
        $this->db->where('accounts.deleted', 0);
        $this->db->order_by("favored", "asc");
        return $this->db->get();
    }

    function count_all()
    {
        $this->db->from('accounts');
        $this->db->where('accounts.deleted', 0);
        return $this->db->count_all_results();
    }

    function get_receive($datestart, $dateend)
    {
        if ($datestart && $dateend) {
            $this->db->from('accounts');
            $this->db->where('ntic_accounts.date >= "' . $datestart . '"');
            $this->db->where('ntic_accounts.date <= "' . $dateend . '"');
            $this->db->where('accounts.operation', 0);
            $this->db->where('accounts.deleted', 0);
            return $this->db->get();
        } else {
            $this->db->from('accounts');
            $this->db->where('accounts.operation', 0);
            $this->db->where('accounts.deleted', 0);
            return $this->db->get();
        }
    }

    function get_pay($datestart, $dateend)
    {
        if ($datestart && $dateend) {
            $this->db->from('accounts');
            $this->db->where('accounts.operation', 1);
            $this->db->where('ntic_accounts.date >= "' . $datestart . '"');
            $this->db->where('ntic_accounts.date <= "' . $dateend . '"');
            $this->db->where('accounts.deleted', 0);
            return $this->db->get();
        } else {
            $this->db->from('accounts');
            $this->db->where('accounts.operation', 1);
            $this->db->where('accounts.deleted', 0);
            return $this->db->get();
        }
    }

    function get_donw_receive($datestart, $dateend)
    {
        if ($datestart && $dateend) {
            $this->db->from('consolidated');
            $this->db->where('consolidated.operation', 0);
            $this->db->where('ntic_consolidated.date >= "' . $datestart . '"');
            $this->db->where('ntic_consolidated.date <= "' . $dateend . '"');
            $this->db->where('consolidated.deleted', 0);
            return $this->db->get();
        } else {
            $this->db->from('consolidated');
            $this->db->where('consolidated.operation', 0);
            $this->db->where('consolidated.deleted', 0);
            return $this->db->get();
        }
    }

    function get_down_pay($datestart, $dateend)
    {
        if ($datestart && $dateend) {
            $this->db->from('consolidated');
            $this->db->where('consolidated.operation', 1);
            $this->db->where('ntic_consolidated.date >= "' . $datestart . '"');
            $this->db->where('ntic_consolidated.date <= "' . $dateend . '"');
            $this->db->where('consolidated.deleted', 0);
            return $this->db->get();
        } else {
            $this->db->from('consolidated');
            $this->db->where('consolidated.operation', 1);
            $this->db->where('consolidated.deleted', 0);
            return $this->db->get();
        }
    }

    function get_sum_accont_rend($datestart, $dateend)
    {
        $this->db->from('accounts');
        $this->db->select_sum('value');
        $this->db->where('ntic_accounts.date >= "' . $datestart . '"');
        $this->db->where('ntic_accounts.date <= "' . $dateend . '"');
        $this->db->where('accounts.operation', 0);
        $this->db->where('accounts.deleted', 0);
        $sum = $this->db->get();
        
        if ($sum->num_rows() == 1) {
            return $sum;
        } else {
            // criar o objeto com propriedades vazias
            $fields = $this->db->list_fields('accounts');
            $account_obj = new stdClass();
            
            // anexar esses campos ao objeto pai de base, n�s temos um objeto completo e vazio
            foreach ($fields as $field) {
                $account_obj->$field = '';
            }
            
            return $account_obj;
        }
    }

    function get_sum_acconts_rend($datestart, $dateend)
    {
        $this->db->from('accounts');
        $this->db->select_sum('value');
        $this->db->where('accounts.operation', 0);
        $this->db->where('ntic_accounts.date >= "' . $datestart . '"');
        $this->db->where('ntic_accounts.date <= "' . $dateend . '"');
        $this->db->where('accounts.date', $datestart);
        $this->db->where('accounts.deleted', 0);
        $sum = $this->db->get();
        
        if ($sum->num_rows() == 1) {
            return $sum;
        } else {
            // criar o objeto com propriedades vazias
            $fields = $this->db->list_fields('accounts');
            $account_obj = new stdClass();
            
            // anexar esses campos ao objeto pai de base, nos temos um objeto completo e vazio
            foreach ($fields as $field) {
                $account_obj->$field = '';
            }
            
            return $account_obj;
        }
    }

    function get_sum_accont_pay($datestart, $dateend)
    {
        $this->db->from('accounts');
        $this->db->select_sum('value');
        $this->db->where('ntic_accounts.date >= "' . $datestart . '"');
        $this->db->where('ntic_accounts.date <= "' . $dateend . '"');
        $this->db->where('accounts.operation', 1);
        $this->db->where('accounts.deleted', 0);
        $sum = $this->db->get();
        if ($sum->num_rows() == 1) {
            return $sum;
        } else {
            // criar o objeto com propriedades vazias
            $fields = $this->db->list_fields('accounts');
            $account_obj = new stdClass();
            
            // anexar esses campos ao objeto pai de base, n�s temos um objeto completo e vazio
            foreach ($fields as $field) {
                $account_obj->$field = '';
            }
            
            return $account_obj;
        }
    }
    
    // retirar depois de checar se esta em uso
    function get_sum_acconts_pay($datestart, $dateend)
    {
        $this->db->from('accounts');
        $this->db->select_sum('value');
        $this->db->where('ntic_accounts.date >= "' . $datestart . '"');
        $this->db->where('ntic_accounts.date <= "' . $dateend . '"');
        $this->db->where('accounts.operation', 1);
        $this->db->where('accounts.deleted', 0);
        $sum = $this->db->get();
        if ($sum->num_rows() == 1) {
            return $sum;
        } else {
            // criar o objeto com propriedades vazias
            $fields = $this->db->list_fields('accounts');
            $account_obj = new stdClass();
            
            // anexar esses campos ao objeto pai de base, n�s temos um objeto completo e vazio
            foreach ($fields as $field) {
                $account_obj->$field = '';
            }
            
            return $account_obj;
        }
    }

    function get_sum_rend($datestart, $dateend)
    {
        $this->db->from('consolidated');
        $this->db->select_sum('value');
        $this->db->where('ntic_consolidated.date >= "' . $datestart . '"');
        $this->db->where('ntic_consolidated.date <= "' . $dateend . '"');
        $this->db->where('consolidated.operation', 0);
        $this->db->where('consolidated.deleted', 0);
        $sum = $this->db->get();
        if ($sum->num_rows() != 0) {
            return $sum;
        } else {
            // criar o objeto com propriedades vazias
            $fields = $this->db->list_fields('consolidated');
            $account_obj = new stdClass();
            
            // anexar esses campos ao objeto pai de base, nos temos um objeto completo e vazio
            foreach ($fields as $field) {
                $account_obj->$field = '';
            }
            
            return $account_obj;
        }
    }

    function get_sum_pay($datestart, $dateend)
    {
        $this->db->from('consolidated');
        $this->db->select_sum('value');
        $this->db->where('ntic_consolidated.date >= "' . $datestart . '"');
        $this->db->where('ntic_consolidated.date <= "' . $dateend . '"');
        $this->db->where('consolidated.operation', 1);
        $this->db->where('consolidated.deleted', 0);
        $sum = $this->db->get();
        if ($sum->num_rows() == 1) {
            return $sum;
        } else {
            // criar o objeto com propriedades vazias
            $fields = $this->db->list_fields('consolidated');
            $account_obj = new stdClass();
            
            // anexar esses campos ao objeto pai de base, n�s temos um objeto completo e vazio
            foreach ($fields as $field) {
                $account_obj->$field = '';
            }
            
            return $account_obj;
        }
    }

    /**
     * Filtro de Contas Receber Lançametos por DATE, HISTORIC, DELETED
     */
    function date_filter($datestart, $dateend)
    {
        $this->db->from('accounts');
        $this->db->where('ntic_accounts.date >= "' . $datestart . '"');
        $this->db->where('ntic_accounts.date <= "' . $dateend . '"');
        $this->db->where('plan_accounts', '1');
        $this->db->where('plan_accounts', '01.01.01');
        $this->db->where('deleted', 0);
        return $this->db->get();
    }

    function date_filter_sum($datestart, $dateend)
    {
        $this->db->from('accounts');
        $this->db->select_sum('value');
        $this->db->where('ntic_accounts.date >= "' . $datestart . '"');
        $this->db->where('ntic_accounts.date <= "' . $dateend . '"');
        $this->db->where('accounts.operation', 0);
        $this->db->where('deleted', 0);
        $sum = $this->db->get();
        
        if ($sum->num_rows() == 1) {
            return $sum->row();
        } else {
            // criar o objeto com propriedades vazias
            $fields = $this->db->list_fields('accounts');
            $account_obj = new stdClass();
            
            // anexar esses campos ao objeto pai de base, nos temos um objeto completo e vazio
            foreach ($fields as $field) {
                $account_obj->$field = '';
            }
            
            return $account_obj;
        }
    }

    function get_info($account_id)
    {
        $this->db->from('accounts');
        $this->db->where('id', $account_id);
        $this->db->where('accounts.deleted', 0);
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            // criar o objeto com propriedades vazias
            $fields = $this->db->list_fields('accounts');
            $account_obj = new stdClass();
            
            // anexar esses campos ao objeto pai de base, n�s temos um objeto completo e vazio
            foreach ($fields as $field) {
                $account_obj->$field = '';
            }
            
            return $account_obj;
        }
    }
    
    /*
     * Execute essas consultas como uma para inser��o
     */
    function down(&$account_data, $account_id = false)
    {
        $success = false;
        
        if ($account_data && $account_id) {
            $this->db->where('id', $account_id);
            $this->db->delete('accounts');
            
            $success = $this->db->insert('consolidated', $account_data);
        }
        
        return $success;
    }
    
    /*
     * Execute essas consultas como uma transa��o, n�s queremos ter certeza de que fazemos tudo ou nada
     */
    function save(&$account_data, $number = false)
    {
        $success = false;
        
        if ($account_data && $number) {
            if (! $number or ! $this->exists($number)) {
                $success = $this->db->insert('accounts', $account_data);
            } else {
                $this->db->where('number', $number);
                $success = $this->db->update('accounts', $account_data);
            }
        }
        
        return $success;
    }
    
    /*
     * Deleta uma Conta
     */
    function delete($account_id)
    {
        $this->db->where('id', $account_id);
        return $this->db->update('accounts', array(
            'deleted' => 1
        ));
    }

    function cleanup()
    {
        $customer_data = array(
            'account_number' => null
        );
        $this->db->where('deleted', 1);
        return $this->db->update('account', $customer_data);
    }
    
    /*
     * Busca de Auta Performace para Contas por datas
     */
    function search_date($start_date, $end_date)
    {
        $this->db->from('account');
        $this->db->where("BETWEEN '" . $this->db->escape_like_str($start_date) . "' AND '" . $this->db->escape_like_str($end_date) . "'  and deleted=0");
        $this->db->order_by("date", "asc");
        
        return $this->db->get();
    }
    
    /*
     * Busca de Auta Performace para Contas
     */
    function search($search)
    {
        $this->db->from('account');
        $this->db->where("(account_id LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		favored LIKE '%" . $this->db->escape_like_str($search) . "%' and deleted=0");
        $this->db->order_by("favored", "asc");
        
        return $this->db->get();
    }
    
    
    function lista($codigo, $valor, $data_ini, $data_fim)
    {
        $query = $this->db->query("SELECT * FROM `ntic_accounts` WHERE `number` = '$codigo' AND `date` >= '$data_ini' AND `date` <= '$data_fim' AND `value` >= '$valor' ORDER BY `date` DESC");
        return $query->result_array();
    }
    
    function lista2($valor, $data_ini, $data_fim)
    {
        $query = $this->db->query("SELECT * FROM `ntic_accounts` WHERE `date` >= '$data_ini' AND `date` <= '$data_fim' AND `value` >= '$valor' ORDER BY `date` DESC");
        return $query->result_array();
    }
}
?>
