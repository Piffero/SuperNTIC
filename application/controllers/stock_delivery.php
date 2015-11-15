<?php
require_once ("secure_area.php");

class Stock_delivery extends Secure_area
{

    function __construct()
    {
        parent::__construct('stock_delivery');
    }

    function index()
    {
        date_default_timezone_set('Brazil/East');
        $data['date_of_issue'] = date('d/m/Y');
        $this->load->view('stock/stock_delivery', $data);
    }
}