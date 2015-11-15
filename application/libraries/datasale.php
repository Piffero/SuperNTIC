<?php

class datasale
{

    var $CI;

    function __construct()
    {
        $this->CI = & get_instance();
    }
    
    /* ************************************************************ */
    /*
     * Get Set Cliente Comprador
     * /* ************************************************************
     */
    
    // Retorna cliente instanciado em sessao
    function get_customer()
    {
        if (! $this->CI->session->userdata('customer'))
            $this->set_customer(- 1);
        
        return $this->CI->session->userdata('customer');
    }
    
    // Set cliente em uma sessao
    function set_customer($customer_id)
    {
        $this->CI->session->set_userdata('customer', $customer_id);
    }
    
    /* ************************************************************ */
    
    /* ************************************************************ */
    /*
     * Get Set Cliente Usuário
     * /* ************************************************************
     */
    
    // Retorna cliente usuário instanciado em sessao
    function get_customer_user()
    {
        if (! $this->CI->session->userdata('customer_user'))
            $this->set_Customer_user(- 1);
        
        return $this->CI->session->userdata('customer_user');
    }
    
    // Set cliente usuario em uma sessao
    function set_Customer_user($customer_id)
    {
        $this->CI->session->set_userdata('customer_user', $customer_id);
    }
    
    /* ************************************************************ */
    
    /* ************************************************************ */
    /*
     * Get Set Items Sales
     * /* ************************************************************
     */
    
    // Retorna item a ser vendido instanciado em sessao
    function get_items_sale_d()
    {
        if (! $this->CI->session->userdata('items_sale_d'))
            $this->set_items_sale_d(- 1);
        
        return $this->CI->session->userdata('items_sale_d');
    }
    
    // Set Retorna item a ser vendido instanciado em sessao
    function set_items_sale_d($item_id)
    {
        $this->CI->session->set_userdata('items_sale_d', $item_id);
    }
    
    // Retorna item a ser vendido instanciado em sessao
    function get_items_sale_e()
    {
        if (! $this->CI->session->userdata('items_sale_e'))
            $this->set_items_sale_e(- 1);
        
        return $this->CI->session->userdata('items_sale_e');
    }
    
    // Set Retorna item a ser vendido instanciado em sessao
    function set_items_sale_e($item_id)
    {
        $this->CI->session->set_userdata('items_sale_e', $item_id);
    }
    /* ************************************************************ */
    function get_items_serie_d()
    {
        if (! $this->CI->session->userdata('items_serie_d'))
            $this->set_items_sale_d(- 1);
        
        return $this->CI->session->userdata('items_serie_d');
    }

    function set_items_serie_d($serie)
    {
        $this->CI->session->set_userdata('items_serie_d', $serie);
    }
    
    /* ************************************************************ */
    /*
     * Get Set Sales
     * /* ************************************************************
     */
    
    // Retorna venda em questão
    function get_sales()
    {
        if (! $this->CI->session->userdata('sales'))
            $this->set_sales(- 1);
        
        return $this->CI->session->userdata('sales');
    }
    
    // Set devine id da venda em sessão
    function set_sales($order)
    {
        $this->CI->session->set_userdata('sales', $order);
    }
}
?>