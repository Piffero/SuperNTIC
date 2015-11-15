<?php
require_once ("secure_area.php");
date_default_timezone_set('Brazil/East');

class Osdefects extends Secure_area
{

    function __construct()
    {
        parent::__construct('os');
    }

    function index($manage_result = null, $data = null)
    {
        if ($this->check_action_permission('openos')) {
            $data['tele'] = $this->input->post("telefone");
            $data['serie'] = $this->input->post("aparelho");
            $data['manage_result'] = $manage_result;
            $this->load->view('os/check', $data);
        } else {
            return 'erro 11'; // tratar
        }
    }

    function insert()
    {
        $lista = $this->input->post();
        
        if ($this->OrdemServico->gera_os(array(
            'NSERIE' => $lista['nserie'],
            'SITUACAO' => 'Aberta',
            'FONECONTATO' => $lista['tel']
        ))) {
            $last_os = $this->OrdemServico->last_os()->idOS;
            
            $lista['idOS'] = zerofiller($last_os);
            
            unset($lista['nserie']);
            unset($lista['tel']);
            
            if ($this->OrdemServico->insert_defects($lista)) {
                redirect('oslista/opener/' . $lista['idOS']);
            } else {
                return 'erro L48: Não foi possível inserir os dados no Banco de Dados'; // tratar
            }
        } else {
            return 'erro 2'; // tratar
        }
    }

    function edit($idOS)
    {
        $data['a'] = $this->OrdemServico->get_defects($idOS)->result_array()[0];
        $data['idOS'] = $idOS;
        
        $data['manage_result'] = null;
        $data['serie'] = $this->OrdemServico->get_nserie($idOS);
        $this->load->view('os/check', $data);
    }

    function atualizar($idOS)
    {
        $lista = array(
            'aparelhoapitando' => '0',
            'aparelhomudo' => '0',
            'funcionamentointermitente' => '0',
            'revisao' => '0',
            'ruido' => '0',
            'somabafado' => '0',
            'somdistorcido' => '0',
            'altoconsumopilha' => '0',
            'faltacapabotao' => '0',
            'faltatampasoquete' => '0',
            'faltatampatimpot' => '0',
            'gavetadepilha' => '0',
            'problemacontatodepilha' => '0',
            'problemacontrolevolume' => '0',
            'acabamentoruim' => '0',
            'apertada' => '0',
            'caixaquebrada' => '0',
            'canalmuitolongo' => '0',
            'faltapolimento' => '0',
            'faltaventilacao' => '0',
            'machucando' => '0',
            'problemanofechamento' => '0',
            'soltaapito' => '0',
            'trocacaixaoutropaciente' => '0',
            'ventilacaoexagerada' => '0',
            'ventilacaoinsuficiente' => '0',
            'aparelhofraco' => '0',
            'outros' => '0',
            'poucoganho' => '0',
            'problemacangulo' => '0',
            'seguro' => '0',
            'trocadeaparelho' => '0',
            'trocadolado' => '0',
            'trocarcaixaretro' => '0',
            'canalmuitocurto' => '0',
            'descos' => ''
        );
        
        $this->OrdemServico->atualizar_defects($lista, $idOS);
        
        $lista = $this->input->post();
        
        unset($lista['nserie']);
        unset($lista['tel']);
        
        if ($this->OrdemServico->atualizar_defects($lista, $idOS)) {
            redirect('oslista');
        } else {
            return 'erro 12'; // tratar
        }
    }
}

?>