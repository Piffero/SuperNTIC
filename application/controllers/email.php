<?php
require_once ("secure_area.php");

class Emails extends Secure_area
{

    function __construct()
    {
        parent::__construct('emails');
    }

    function index()
    {
        $this->load->view('Emails/Emails');
    }
}
?>