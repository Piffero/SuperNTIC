<?php
require_once ("secure_area.php");

class Home extends Secure_area
{

    function __construct()
    {
        parent::__construct('home');
    }

    function index()
    {
        $this->load->view("home");
    }

    function logout()
    {
        $this->Employeer->logout();
    }
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */