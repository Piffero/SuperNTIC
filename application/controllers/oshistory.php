<?php
require_once ("secure_area.php");
date_default_timezone_set('Brazil/East');

class Oshistory extends Secure_area
{

    function __construct()
    {
        parent::__construct('os');
    }

    function index($data = null)
    {
        $client = $this->OrdemServico->get_clients();
        
        if ($client->num_rows() != 0) {
            foreach ($client->result() as $clients) {
                $rows[$clients->first_name . '|' . $clients->last_name] = $clients->first_name . ' ' . $clients->last_name;
            }
            $data['clients'] = $rows;
        } else {
            $data['clients'] = array(
                'Nao existem clientes cadastrados'
            );
        }
        
        $this->load->view('os/historico', $data);
    }

    function client()
    {
        $cliente = explode("|", $this->input->post("clients"));
        $nome = $cliente[0];
        $sobrenome = $cliente[1];
        
        $lista = $this->OrdemServico->search_by_client($nome, $sobrenome);
        $all = $lista->result_array();
        $data['lista'] = '';
        if ($lista->num_rows() != 0) {
            for ($i = 0; $i < $lista->num_rows(); $i ++) {
                $data['lista'] .= '<tr>
		 			 <td>' . $all[$i]['first_name'] . ' ' . $all[$i]['last_name'] . '</td>
		 			 <td>' . $all[$i]['apparatus'] . ' ' . $all[$i]['maker'] . ' ' . $all[$i]['model'] . ' [' . $all[$i]['color'] . '] </td>
		 			 <td class="text-center">' . date('d/m/Y h:m', strtotime($all[$i]['DTABERTURA'])) . '</td>';
                
                if ($all[$i]['SITUACAO'] == 'Finalizada' and $all[$i]['DTCONCLUSAO'] > 0) {
                    $data['lista'] .= '<td class="text-center">Finalizada</td>';
                } elseif ($all[$i]['SITUACAO'] == 'Finalizada' and $all[$i]['DTCONCLUSAO'] == 0) {
                    $data['lista'] .= '<td class="text-center">Cancelada</td>';
                } else {
                    $data['lista'] .= '<td class="text-center">Em Procedimento</td>';
                }
                
                $data['lista'] .= '<td class="text-center"><a href="' . site_url('viewos/index/' . $all[$i]['idOS']) . '"><u>' . $all[$i]['idOS'] . '</u></a></td>';
                $data['lista'] .= '</tr>';
            }
        } else {
            $data['lista'] .= '<tr><td colspan="5">Não foram encontradas Ordens de Serviço deste Cliente</td></tr>';
        }
        
        $this->index($data);
    }

    function situacao()
    {
        $post = $this->input->post("situacao");
        if ($post != 'Cancelada' and $post != 'Finalizada') {
            $situacao = $this->OrdemServico->search_by_situacao($post);
            $lista2 = $situacao->result_array();
            
            $data['lista'] = '';
            if ($situacao->num_rows() != 0) {
                for ($i = 0; $i < $situacao->num_rows(); $i ++) {
                    $data['lista'] .= '<tr>
						<td>' . $lista2[$i]['first_name'] . ' ' . $lista2[$i]['last_name'] . '</td>
						<td>' . $lista2[$i]['apparatus'] . ' ' . $lista2[$i]['maker'] . ' ' . $lista2[$i]['model'] . ' [' . $lista2[$i]['color'] . '] </td>
						<td class="text-center">' . date('d/m/Y h:m', strtotime($lista2[$i]['DTABERTURA'])) . '</td>';
                    $data['lista'] .= '<td class="text-center">' . $lista2[$i]['SITUACAO'] . '</td>';
                    $data['lista'] .= '<td class="text-center"><a href="' . site_url('viewos/index/' . $lista2[$i]['idOS']) . '"><u>' . $lista2[$i]['idOS'] . '</u></a></td>';
                    $data['lista'] .= '</tr>';
                }
            } else {
                $data['lista'] .= '<tr><td colspan="5">Não foram encontradas Ordens de Serviço nesta Situação</td></tr>';
            }
            
            $this->index($data);
        } elseif ($post == 'Cancelada') {
            $situacao = $this->OrdemServico->search_by_cancelada($post);
            $lista2 = $situacao->result_array();
            
            $data['lista'] = '';
            if ($situacao->num_rows() != 0) {
                for ($i = 0; $i < $situacao->num_rows(); $i ++) {
                    $data['lista'] .= '<tr>
						<td>' . $lista2[$i]['first_name'] . ' ' . $lista2[$i]['last_name'] . '</td>
						<td>' . $lista2[$i]['apparatus'] . ' ' . $lista2[$i]['maker'] . ' ' . $lista2[$i]['model'] . ' [' . $lista2[$i]['color'] . '] </td>
						<td class="text-center">' . date('d/m/Y h:m', strtotime($lista2[$i]['DTABERTURA'])) . '</td>';
                    $data['lista'] .= '<td class="text-center">Cancelada</td>';
                    $data['lista'] .= '<td class="text-center"><a href="' . site_url('viewos/index/' . $lista2[$i]['idOS']) . '"><u>' . $lista2[$i]['idOS'] . '</u></a></td>';
                    $data['lista'] .= '</tr>';
                }
            } else {
                $data['lista'] .= '<tr><td colspan="5">Não foram encontradas Ordens de Serviço nesta Situação</td></tr>';
            }
            
            $this->index($data);
        } elseif ($post == 'Finalizada') {
            $situacao = $this->OrdemServico->search_by_finalizada($post);
            $lista2 = $situacao->result_array();
            
            $data['lista'] = '';
            if ($situacao->num_rows() != 0) {
                for ($i = 0; $i < $situacao->num_rows(); $i ++) {
                    $data['lista'] .= '<tr>
				<td>' . $lista2[$i]['first_name'] . ' ' . $lista2[$i]['last_name'] . '</td>
						<td>' . $lista2[$i]['apparatus'] . ' ' . $lista2[$i]['maker'] . ' ' . $lista2[$i]['model'] . ' [' . $lista2[$i]['color'] . '] </td>
								<td class="text-center">' . date('d/m/Y h:m', strtotime($lista2[$i]['DTABERTURA'])) . '</td>';
                    $data['lista'] .= '<td class="text-center">' . $lista2[$i]['SITUACAO'] . '</td>';
                    $data['lista'] .= '<td class="text-center"><a href="' . site_url('viewos/index/' . $lista2[$i]['idOS']) . '"><u>' . $lista2[$i]['idOS'] . '</u></a></td>';
                    $data['lista'] .= '</tr>';
                }
            } else {
                $data['lista'] .= '<tr><td colspan="5">Não foram encontradas Ordens de Serviço nesta Situação</td></tr>';
            }
            
            $this->index($data);
        }
    }
}

