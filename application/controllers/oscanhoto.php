<?php
require_once ("secure_area.php");

class Oscanhoto extends Secure_area
{

    function __construct()
    {
        parent::__construct('customers');
    }

    function index($idOS, $manage_result = null)
    {
        $data['logo'] = $this->config->base_url() . 'application/views/os/logo.png';
        $data['idOS'] = $idOS;
        $data['array'] = $this->OrdemServico->get_empresa()->result_array();
        $data['arrayCL'] = $this->OrdemServico->get_info($idOS)->result_array();
        $data['def'] = $this->OrdemServico->get_defects($idOS)->result_array();
        $data['manage_result'] = $manage_result;
        $this->load->view('os/canhoto', $data);
    }
}