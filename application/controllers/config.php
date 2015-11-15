<?php
require_once ("secure_area.php");

class Config extends Secure_area
{

    function __construct()
    {
        parent::__construct('config');
    }

    function index()
    {
        $this->load->view("config");
    }

    function site_url($uri = '')
    {
        $CI = & get_instance();
        return $CI->config->site_url($uri);
    }
}
?>