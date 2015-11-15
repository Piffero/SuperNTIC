<?php
require_once ("secure_area.php");

class Test extends Secure_area
{

    function __construct()
    {
        parent::__construct('test');
    }

    function index()
    {
        date_default_timezone_set('Brazil/East');
        $data['date_of_issue'] = date('d/m/Y');
        $this->load->view('sales/test', $data);
    }
}

?>