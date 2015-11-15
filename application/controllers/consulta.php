<?php
require_once ("secure_area.php");

class Consulta extends Secure_area
{

    function __construct()
    {
        parent::__construct('consulta');
    }

    function index()
    {
        date_default_timezone_set('Brazil/East');
        $data['date_of_issue'] = date('d/m/Y');
        $this->load->view('sales/consulta', $data);
    }
}

?>