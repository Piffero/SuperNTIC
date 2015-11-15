<?php
require_once ("secure_area.php");
require_once ('osdefects.php');
date_default_timezone_set('Brazil/East');

class OS extends Secure_area
{

    function __construct()
    {
        parent::__construct('os');
    }

    function index($manage_result = null, $data = null)
    {
        if ($this->check_action_permission('openos')) {
            
            $data['manage_result'] = $manage_result;
            $this->load->view('os/index', $data);
        }
    }

    function check()
    {
        $nserie = $this->input->post("NSERIE");
        $situacao = $this->OrdemServico->exist_os($nserie)->result_array();
        // print_r($situacao);
        
        // Primeiro checa se a situação da OS está finalizada para poder abrir
        if ($this->OrdemServico->check_nserie($nserie)) {
            // Busca as as informações do Produto caso consiga pesquisar o número de série
            if (isset($situacao[0]["SITUACAO"]) and $situacao[0]["SITUACAO"] != 'Finalizada') {
                $this->index('<div class="alert alert-danger">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">X</button>
							<i class="fa fa-times-circle sign"></i><strong>Ops!</strong>
							Esse aparelho já encontra-se com uma OS em procedimento!
						</div>');
            } else {
                if ($this->OrdemServico->check_nserie($nserie)) {
                    // Infos do Produto
                    $group = $this->OrdemServico->check_nserie($nserie);
                    $data['produto'] = $group->apparatus;
                    $data['marca'] = $group->maker;
                    $data['modelo'] = $group->model;
                    $data['lado'] = $group->color;
                    $data['fabrica'] = date('d/m/Y', strtotime($group->suppliers_data));
                    $data['compra'] = date('d/m/Y', strtotime($group->purchase_date));
                    $data['serie'] = $nserie;
                    
                    // Infos do Cliente
                    $cliente = $this->OrdemServico->get_cliente($group->patient_id);
                    $data['cliente'] = $cliente->first_name . ' ' . $cliente->last_name;
                    $data['telcasa'] = $cliente->phone_home;
                    $data['teltrab'] = $cliente->phone_work;
                    $data['telcel'] = $cliente->phone_cell;
                    $data['telother'] = $cliente->phone_other;
                    $data['email'] = $cliente->email;
                    $data['telopt'] = $cliente->phone_number;
                    $data['termos'] = $cliente->waives_terms;
                    
                    $this->index($manage_result = null, $data);
                } else {
                    $this->index('<div class="alert alert-danger">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">X</button>
						<i class="fa fa-times-circle sign"></i><strong>Ops!</strong>
						Este produto não está cadastrado ou carece de informações no cadastro!
						</div>');
                }
            }
        } else {
            $this->index('<div class="alert alert-danger">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">X</button>
						<i class="fa fa-times-circle sign"></i><strong>Ops!</strong>
						Este produto não está cadastrado ou carece de informações no cadastro!
						</div>');
        }
    }

    function input()
    {
        if ($this->check_action_permission('listos')) {
            $datestart = get_date_converter($this->input->post('datefilterstart'));
            $dateend = get_date_converter($this->input->post('datefilterend'));
            
            date_default_timezone_set('America/Sao_Paulo');
            if (empty($datestart))
                $datestart = date('Y-m-d');
            
            if (empty($dateend))
                $dateend = date('Y-m-d');
            
            $data['datestart'] = get_date_view($datestart);
            $data['dateend'] = get_date_view($dateend);
            
            $data['manage_table'] = get_account_os_manage_table($this->Account->date_filter($datestart, $dateend), $this, 0);
            
            $sum_accont_rends = $this->Account->date_filter_sum($datestart, $dateend);
            
            $data['sum_accont_rend'] = $sum_accont_rends;
            $this->load->view('os/input', $data);
        }
    }

    function opener($idOS)
    {
        $data['open'] = $idOS;
        $this->load->view('os/index', $data);
    }
}
?>