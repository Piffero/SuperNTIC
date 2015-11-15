<?php
require_once ("secure_area.php");
date_default_timezone_set('Brazil/East');
setlocale(LC_MONETARY, 'pt_BR');

class Viewos extends Secure_area
{

    function __construct()
    {
        parent::__construct('os');
    }

    function index($idOS, &$manage_result = null, &$data = null)
    {
        $data['laudo'] = $this->OrdemServico->get_laudo($idOS)->result_array();
        $data['manage_result'] = $manage_result;
        
        $data['manage_table_row'] = '';
        
        $resultado = $this->OrdemServico->lista_ocorrencia($idOS);
        $n = $resultado->result_array();
        
        for ($i = 0; $i < $resultado->num_rows(); $i ++) {
            $data['manage_table_row'] .= '<tr>
					<td>' . nl2br($n[$i]["ocorrencia"]) . '</td>
							
					<td class="text-right">' . money_format('%.2n', $n[$i]["valor"]) . '</td>
					<td>' . $n[$i]["funcionario"] . '</td>
					<td class="text-left">' . date('d/m/Y h:i', strtotime($n[$i]["data"])) . '</td>
				</tr>';
        }
        
        $data['info'] = $this->OrdemServico->get_info($idOS)->result_array();
        $data['idOS'] = $idOS;
        $data['def'] = $this->OrdemServico->get_defects($idOS)->result_array();
        
        $lanc = $this->OrdemServico->get_lancamentos_lista($idOS)->result_array();
        $data['lanc'] = '';
        
        for ($g = 0; $g < $this->OrdemServico->get_lancamentos_lista($idOS)->num_rows(); $g ++) {
            $data['lanc'] .= '<tr>
				<td class="text-center">' . date('d/m/Y h:i', strtotime($lanc[$g]["data"])) . '</td> 
				<td class="text-right">' . money_format('%.2n', $lanc[$g]["valor"]) . '</td>
			</tr>';
        }
        
        $cont = $this->OrdemServico->get_contact_lista($idOS)->result_array();
        $data['cont'] = '';
        
        for ($f = 0; $f < $this->OrdemServico->get_contact_lista($idOS)->num_rows(); $f ++) {
            $data['cont'] .= '<tr>
	    		<td>' . $cont[$f]["descricao"] . '</td>
	    		<td class="text-center">' . date('d/m/Y h:i', strtotime($cont[$f]["data"])) . '</td>';
            if ($cont[$f]["contatado"] == 1) {
                $data['cont'] .= '<td class="text-center">Sim</td>';
            } else {
                $data['cont'] .= '<td class="text-center">Não</td>';
            }
            $data['cont'] .= '</tr>';
        }
        
        $this->load->view('os/view', $data);
    }
}		