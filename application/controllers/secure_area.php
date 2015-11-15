<?php

class Secure_area extends CI_Controller
{

    var $module_id;
    
    /*
     * Controllers that are considered secure extend Secure_area, optionally a $module_id can
     * be set to also check if a user can access a particular module in the system.
     */
    function __construct($module_id = null)
    {
        parent::__construct();
        $this->module_id = $module_id;
        $this->load->model('Employeer');
        if (! $this->Employeer->is_logged_in()) {
            redirect('login');
        }
        
        if (! $this->Employeer->has_module_permission($this->module_id, $this->Employeer->get_logged_in_employee_info()->employees_id)) {
            redirect('login');
        }
        
        // load up global data
        $logged_in_employee_info = $this->Employeer->get_logged_in_employee_info();
        $data['allowed_modules'] = $this->Module->get_allowed_modules($logged_in_employee_info->employees_id);
        $data['user_info'] = $logged_in_employee_info;
        $this->load->vars($data);
    }

    function check_action_permission($action_id)
    {
        if (! $this->Employeer->has_module_action_permission($this->module_id, $action_id, $this->Employeer->get_logged_in_employee_info()->employees_id)) {
            $this->session->sess_update();
            return false;
        } else {
            $this->session->sess_update();
            return true;
        }
    }
}
?>