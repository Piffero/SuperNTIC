<?php

class Purch_lib
{

    var $CI;

    function __construct()
    {
        $this->CI = & get_instance();
    }
    
    // Retorna cliente instanciado em sessao
    function get_order()
    {
        if (! $this->CI->session->userdata('order'))
            $this->set_order(- 1);
        
        return $this->CI->session->userdata('order');
    }
    
    // Set cliente em uma sessao
    function set_order($order_id)
    {
        $this->CI->session->set_userdata('order', $order_id);
    }
    
    // -----------------------------------------------------------------------------------------------
    function get_dept()
    {
        if (! $this->CI->session->userdata('dept'))
            $this->set_dept(- 1);
        
        return $this->CI->session->userdata('dept');
    }

    function set_dept($department_info)
    {
        $this->CI->session->set_userdata('dept', $department_info);
    }
    
    // -----------------------------------------------------------------------------------------------
    function get_forn()
    {
        if (! $this->CI->session->userdata('forn'))
            $this->set_forn(1);
        
        return $this->CI->session->userdata('forn');
    }

    function set_forn($forn_info)
    {
        $this->CI->session->set_userdata('forn', $forn_info);
    }
    
    // -----------------------------------------------------------------------------------------------
}

?>