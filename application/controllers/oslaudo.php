<?php
require_once ("secure_area.php");
date_default_timezone_set('Brazil/East');

class Oslaudo extends Secure_area
{

    function __construct()
    {
        parent::__construct('os');
    }

    function index($idOS, $manage_result = null, $data = null)
    {
        $data['idOS'] = $idOS;
        $data['manage_result'] = $manage_result;
        $this->load->view('os/laudo', $data);
    }

    function concluir($idOS)
    {
        $data = array(
            'laudo' => $this->input->post("laudo"),
            'SITUACAO' => 'Concluida'
        );
        
        if ($this->OrdemServico->concluir_os($data, $idOS)) {
            redirect("tecoslista");
        } else {
            $this->index($idOS, '<div class="alert alert-danger">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">X</button>
					<i class="fa fa-times-circle sign"></i><strong>Ops!</strong>
					Houve um erro ao tentar atualizar o banco de dados, por favor contateo suporte NTIC.
				</div>');
        }
    }

    function ver($idOS)
    {
        $data['laudox'] = $this->OrdemServico->get_laudo($idOS)->result_array();
        $data['dis'] = 1;
        $this->index($idOS, $manage_result = null, $data);
    }
}

?>