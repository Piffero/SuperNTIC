<?php
require_once ("secure_area.php");
date_default_timezone_set('Brazil/East');

class Tecos extends Secure_area
{

    function __construct()
    {
        parent::__construct('os');
    }

    function index($idOS, &$manage_result = null, &$data = null)
    {
        $data['manage_result'] = $manage_result;
        $data['idOS'] = $idOS;
        $situacao = $this->OrdemServico->last_situation($idOS);
        $data['situacao'] = $situacao->SITUACAO;
        $data['infos'] = $this->OrdemServico->get_info($idOS);
        
        $data['manage_table_row'] = '';
        
        $resultado = $this->OrdemServico->lista_ocorrencia($idOS);
        $n = $resultado->result_array();
        
        for ($i = 0; $i < $resultado->num_rows(); $i ++) {
            $data['manage_table_row'] .= '<tr>
	    		 	<td>' . nl2br($n[$i]["ocorrencia"]) . '</td>
	    		  	<td class="text-right">R$ ' . $n[$i]["valor"] . '</td>
	    		  	<td>' . $n[$i]["funcionario"] . '</td>
	    		  	<td class="text-center">' . date('d/m/Y h:i', strtotime($n[$i]["data"])) . '</td>
	    		  	<td class="text-center"><a href="' . site_url('tecos/delete/' . $idOS . 'x' . $n[$i]["id"]) . '" class="label label-danger"><i class="fa fa-times"></i></td>
	    		</tr>';
        }
        
        $data['def'] = $this->OrdemServico->get_defects($idOS)->result_array();
        
        $this->load->view('os/tec', $data);
    }

    function change_os_situation($idOS)
    {
        if ($this->input->post("situacao") == 'Concluida') {
            if ($this->OrdemServico->change_os_situation($idOS, $this->input->post("situacao"))) {
                redirect("tecoslista");
            } else {
                $this->index($idOS); // tratar erro
            }
        } else {
            if ($this->OrdemServico->change_os_situation($idOS, $this->input->post("situacao"))) {
                $this->index($idOS);
            } else {
                $this->index($idOS); // tratar erro
            }
        }
    }

    function ocorrencia()
    {
        $tecnico = $this->OrdemServico->get_tecnico()->first_name . ' ' . $this->OrdemServico->get_tecnico()->last_name;
        $ocorrencia = array(
            'ocorrencia' => $this->input->post("desc"),
            'valor' => $this->input->post("valor"),
            'idOS' => $this->input->post("idos"),
            'funcionario' => $tecnico
        );
        if ($this->OrdemServico->ocorrencia($ocorrencia)) {
            $this->index($this->input->post("idos"));
        } else {
            return 'erro ao inserir ocorrencia';
        }
    }

    function delete($oseid)
    {
        $arr = explode('x', $oseid);
        $idOS = $arr[0];
        $id = $arr[1];
        
        if ($this->OrdemServico->delete_id($id)) {
            $this->index($idOS);
        } else {
            $this->index($idOS);
        }
    }
}

?>