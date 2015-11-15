<?php

class Employeer extends CI_Model
{
    /*
     * Determines if a given employees_id is an employee
     */
    function exists($employees_id)
    {
        $this->db->from('employees');
        $this->db->where('employees.employees_id', $employees_id);
        $this->db->where('deleted', 0);
        $query = $this->db->get();
        
        return ($query->num_rows() == 1);
    }

    function count_all()
    {
        $this->db->from('employees');
        $this->db->where('deleted', 0);
        return $this->db->count_all_results();
    }
    
    /*
     * Returns all the employees
     */
    function get_all()
    {
        $this->db->from('employees');
        $this->db->where('deleted', 0);
        $this->db->order_by("last_name", "asc");
        return $this->db->get();
    }
    
    /*
     * Gets information about a particular employee
     */
    function get_info($employee_id)
    {
        $this->db->from('employees');
        $this->db->where('employees.employees_id', $employee_id);
        $this->db->where('deleted', 0);
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            // criar o objeto com propriedades vazias
            $fields = $this->db->list_fields('employees');
            $employees_obj = new stdClass();
            
            // append those fields to base parent object, we we have a complete empty object
            foreach ($fields as $field) {
                $employees_obj->$field = '';
            }
            
            return $employees_obj;
        }
    }
    
    /*
     * Gets information about a Fono employee
     */
    function get_fono()
    {
        $this->db->from('employees');
        $this->db->where('employees.isfono', 1);
        $this->db->where('deleted', 0);
        return $this->db->get();
    }
    
    /*
     * Gets information about multiple employees
     */
    function get_multiple_info($employee_ids)
    {
        $this->db->from('employees');
        $this->db->where_in('employees.employees_id', $employee_ids);
        $this->db->where('deleted', 0);
        $this->db->order_by("last_name", "asc");
        return $this->db->get();
    }
    
    /*
     * Inserts or updates an employee
     */
    function save(&$employee_data, $employee_id = false)
    {
        $success = false;
        if ($employee_data && $employee_id) {
            if (! $employee_id or ! $this->exists($employee_id)) {
                $success = $this->db->insert('employees', $employee_data);
                $success = true;
            } else {
                $this->db->where('employees_id', $employee_id);
                $success = $this->db->update('employees', $employee_data);
                $success = true;
            }
        }
        
        return $success;
    }
    
    /*
     * Inserts or updates an employee
     */
    function save_pass(&$employee_data, $employee_id = false)
    {
        $success = false;
        
        if ($employee_data && $employee_id) {
            
            $this->db->where('employees_id', $employee_id);
            $success = $this->db->update('employees', $employee_data);
        }
        
        return $success;
    }
    
    /*
     * Deletes one employee
     */
    function delete($employee_id)
    {
        $success = false;
        
        // Don't let employee delete their self
        if ($employee_id == $this->get_logged_in_employee_info()->employees_id)
            return false;
            
            // Run these queries as a transaction, we want to make sure we do all or nothing
        $this->db->trans_start();
        
        // Delete permissions
        if ($this->db->delete('permissions', array(
            'employees_id' => $employee_id
        ))) {
            $this->db->where('employees_id', $employee_id);
            $success = $this->db->update('employees', array(
                'deleted' => 1
            ));
        }
        $this->db->trans_complete();
        return $success;
    }
    
    /*
     * Deletes a list of employees
     */
    function delete_list($employee_ids)
    {
        $success = false;
        
        // Don't let employee delete their self
        if (in_array($this->get_logged_in_employee_info()->employees_id, $employee_ids))
            return false;
            
            // Run these queries as a transaction, we want to make sure we do all or nothing
        $this->db->trans_start();
        
        $this->db->where_in('employees_id', $employee_ids);
        // Delete permissions
        if ($this->db->delete('permissions')) {
            // delete from employee table
            $this->db->where_in('employees_id', $employee_ids);
            $success = $this->db->update('employees', array(
                'deleted' => 1
            ));
        }
        $this->db->trans_complete();
        return $success;
    }
    
    /*
     * Get search suggestions to find employees
     */
    function get_search_suggestions($search, $limit = 5)
    {
        $suggestions = array();
        
        $this->db->from('employees');
        $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0");
        $this->db->order_by("last_name", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = $row->first_name . ' ' . $row->last_name;
        }
        
        $this->db->from('employees');
        $this->db->where('deleted', 0);
        $this->db->like("email", $search);
        $this->db->order_by("email", "asc");
        $by_email = $this->db->get();
        foreach ($by_email->result() as $row) {
            $suggestions[] = $row->email;
        }
        
        $this->db->from('employees');
        $this->db->where('deleted', 0);
        $this->db->like("username", $search);
        $this->db->order_by("username", "asc");
        $by_username = $this->db->get();
        foreach ($by_username->result() as $row) {
            $suggestions[] = $row->username;
        }
        
        $this->db->from('employees');
        $this->db->where('deleted', 0);
        $this->db->like("phone_cell", $search);
        $this->db->order_by("phone_cell", "asc");
        $by_phone = $this->db->get();
        foreach ($by_phone->result() as $row) {
            $suggestions[] = $row->phone_home;
        }
        
        // only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }
    
    /*
     * Preform a search on employees
     */
    function search($search)
    {
        $this->db->from('employees');
        $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		email LIKE '%" . $this->db->escape_like_str($search) . "%' or		
		username LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0");
        $this->db->order_by("last_name", "asc");
        
        return $this->db->get();
    }
    
    /*
     * Attempts to login employee and set session. Returns boolean based on outcome.
     */
    function login($username, $password)
    {
        $query = $this->db->get_where('employees', array(
            'username' => $username,
            'password' => md5($password),
            'deleted' => 0
        ), 1);
        if ($query->num_rows() == 1) {
            $row = $query->row();
            $this->session->set_userdata('employees_id', $row->employees_id);
            return true;
        }
        return false;
    }
    
    /*
     * Logs out a user by destorying all session data and redirect to login
     */
    function logout()
    {
        $this->session->sess_destroy();
        redirect('home');
    }
    
    /*
     * Determins if a employee is logged in
     */
    function is_logged_in()
    {
        return $this->session->userdata('employees_id') != false;
    }
    
    /*
     * Gets information about the currently logged in employee.
     */
    function get_logged_in_employee_info()
    {
        if ($this->is_logged_in()) {
            return $this->get_info($this->session->userdata('employees_id'));
        }
        
        return false;
    }
    
    /*
     * Determins whether the employee specified employee has access the specific module.
     */
    function has_module_permission($module_id, $employees_id)
    {
        // if no module_id is null, allow access
        if ($module_id == null) {
            return true;
        }
        
        $query = $this->db->get_where('permissions', array(
            'employees_id' => $employees_id,
            'module_id' => $module_id
        ), 1);
        return $query->num_rows() == 1;
    }

    function has_module_action_permission($module_id, $action_id, $employees_id)
    {
        // if no module_id is null, allow access
        if ($module_id == null) {
            return true;
        }
        
        $query = $this->db->get_where('permissions_actions', array(
            'person_id' => $employees_id,
            'module_id' => $module_id,
            'action_id' => $action_id
        ), 1);
        return $query->num_rows() == 1;
    }
}
?>