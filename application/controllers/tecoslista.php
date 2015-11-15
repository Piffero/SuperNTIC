<?php
require_once ("secure_area.php");
date_default_timezone_set('Brazil/East');

class Tecoslista extends Secure_area
{

    function __construct()
    {
        parent::__construct('os');
    }

    function index($manage_result = null, $data = null)
    {
        $data['manage_result'] = $manage_result;
        
        $data['lista'] = '';
        foreach ($this->OrdemServico->get_lista()->result() as $n) {
            
            $data['lista'] .= '<tr class="text-center">
									<td>' . $n->idOS . '</td>
									<td>' . $n->apparatus . ' ' . $n->maker . ' ' . $n->model . ' ' . $n->color . '</td>
									<td>' . $n->first_name . ' ' . $n->last_name . '</td>';
            switch ($n->SITUACAO) {
                case 'Aberta':
                    $data['lista'] .= '<td><center><span class="label label-primary" data-original-title="OS Recêm criada" data-toggle="tooltip" data-placement="right">Aberta</span></center></td>';
                    $data['lista'] .= '<td class="text-center">' . date('d/m/Y h:i', strtotime($n->DTABERTURA)) . '</td>';
                    $data['lista'] .= '<td class="text-center">
											<a href="' . site_url('viewos/index/' . $n->idOS) . '" data-original-title="Visualizar OS" data-toggle="tooltip" data-placement="top" class="label label-primary" name="acao"><i class="fa fa-search"></i></a> 
											<a href="' . site_url('tecos/index/' . $n->idOS) . '" data-toggle="tooltip"  data-original-title="Analisar OS ' . $n->idOS . '" class="label label-success"><i class="fa fa-wrench"></i></a>
										</td> ';
                    break;
                
                case 'Em analise':
                    $data['lista'] .= '<td class="text-center color-success"><span data-original-title="Técnico analisando o produto" data-toggle="tooltip" data-placement="right" class="label label-default">Em Análise</span></td>';
                    $data['lista'] .= '<td class="text-center">' . date('d/m/Y h:i', strtotime($n->DTABERTURA)) . '</td>';
                    $data['lista'] .= '<td class="text-center">
											<a href="' . site_url('viewos/index/' . $n->idOS) . '" data-original-title="Visualizar OS" data-toggle="tooltip" data-placement="top" class="label label-primary" name="acao"><i class="fa fa-search"></i></a> 
									   		<a href="' . site_url('tecos/index/' . $n->idOS) . '" data-toggle="tooltip" data-original-title="Analisar OS ' . $n->idOS . '" class="label label-success"><i class="fa fa-wrench"></i></a>
										</td>';
                    break;
                
                case 'Contactando':
                    $data['lista'] .= '<td class="text-right color-success"><center><span data-original-title="Entrar(ando) em contato com o cliente" data-toggle="tooltip" data-placement="right" class="label label-warning">Contatando</span></center></td>';
                    $data['lista'] .= '<td class="text-center">' . date('d/m/Y h:i', strtotime($n->DTABERTURA)) . '</td>';
                    $data['lista'] .= '<td class="text-center">
									 		<a href="' . site_url('viewos/index/' . $n->idOS) . '" data-original-title="Visualizar OS" data-toggle="tooltip" data-placement="top" class="label label-primary" name="acao"><i class="fa fa-search"></i></a>  
									  		<a href="' . site_url('tecos/index/' . $n->idOS) . '" data-toggle="tooltip" data-original-title="Analisar OS ' . $n->idOS . '" class="label label-success"><i class="fa fa-wrench"></i></a>
									   </td>';
                    
                    break;
                
                case 'Aprovada':
                    $data['lista'] .= '<td class="text-center color-success"><span data-original-title="OS Confirmada pelo cliente para mudanças" data-toggle="tooltip" data-placement="right" class="label label-lucas">Aprovada</span></td>';
                    $data['lista'] .= '<td  class="text-center">' . date('d/m/Y h:i', strtotime($n->DTABERTURA)) . '</td>';
                    $data['lista'] .= '<td class="text-center">
									 		<a href="' . site_url('viewos/index/' . $n->idOS) . '" data-original-title="Visualizar OS" data-toggle="tooltip" data-placement="top" class="label label-primary" name="acao"><i class="fa fa-search"></i></a>  
											<a href="' . site_url('tecos/index/' . $n->idOS) . '" data-toggle="tooltip" data-original-title="Analisar OS ' . $n->idOS . '" class="label label-success"><i class="fa fa-wrench"></i></a>
									   </td>';
                    break;
                
                case 'Recusada':
                    $data['lista'] .= '<td><label data-original-title="OS Recusada pelo cliente para mudanças" data-toggle="tooltip" data-placement="right" class="label label-danger">Recusada</label></td>';
                    $data['lista'] .= '<td class="text-center">' . date('d/m/Y h:i', strtotime($n->DTABERTURA)) . '</td>';
                    $data['lista'] .= '<td class="text-center">
 											<a href="' . site_url('viewos/index/' . $n->idOS) . '" data-original-title="Visualizar OS" data-toggle="tooltip" data-placement="top" class="label label-primary" name="acao"><i class="fa fa-search"></i></a> 
 									  		<a href="' . site_url('tecos/index/' . $n->idOS) . '" data-toggle="tooltip" data-original-title="Analisar OS ' . $n->idOS . '" class="label label-success"><i class="fa fa-wrench"></i></a>
 										</td>';
                    break;
                
                case 'Em andamento':
                    $data['lista'] .= '<td class="text-right color-success"><center><span data-original-title="Técnico executando eventuais mudanças" data-toggle="tooltip" data-placement="right" class="label label-info">Em andamento</span></center></td>';
                    $data['lista'] .= '<td class="text-center">' . date('d/m/Y h:i', strtotime($n->DTABERTURA)) . '</td>';
                    $data['lista'] .= '<td class="text-center">
											<a href="' . site_url('viewos/index/' . $n->idOS) . '" data-original-title="Visualizar OS" data-toggle="tooltip" data-placement="top" class="label label-primary" name="acao"><i class="fa fa-search"></i></a>  
											<a href="' . site_url('tecos/index/' . $n->idOS) . '" data-toggle="tooltip" data-original-title="Analisar OS ' . $n->idOS . '" class="label label-success"><i class="fa fa-wrench"></i></a>
										</td>';
                    break;
                
                case 'Concluida':
                    $data['lista'] .= "<td class=\"text-center\"><span class=\"label label-success\" data-original-title=\"OS Esperando finalização\" data-toggle=\"tooltip\" data-placement=\"right\">Concluída</span></td>";
                    $data['lista'] .= '<td class="text-center">' . date('d/m/Y h:i', strtotime($n->DTABERTURA)) . '</td>';
                    $data['lista'] .= '<td class="text-center">
											<a href="' . site_url('viewos/index/' . $n->idOS) . '" data-original-title="Visualizar OS" data-toggle="tooltip" data-placement="top" class="label label-primary" name="acao"><i class="fa fa-search"></i></a>  
											<a class="label label-default"><i class="fa fa-wrench"></i></a>
										</td>';
                    break;
                
                case 'Fabrica':
                    $data['lista'] .= "<td class=\"text-center\"><span class=\"label label-black\" data-original-title=\"Aparelho enviado para fábrica\" data-toggle=\"tooltip\" data-placement=\"right\">Fábrica</span></td>";
                    $data['lista'] .= '<td class="text-center">' . date('d/m/Y h:i', strtotime($n->DTABERTURA)) . '</td>';
                    $data['lista'] .= '<td class="text-center">
											<a href="' . site_url('viewos/index/' . $n->idOS) . '" data-original-title="Visualizar OS" data-toggle="tooltip" data-placement="top" class="label label-primary" name="acao"><i class="fa fa-search"></i></a> 
											<a href="#" data-original-title="Receber da fábrica" data-toggle="modal" data-placement="top" class="label label-success" data-target="#mod-warning12' . $n->idOS . '" alt="Aprovar OS"><i class="fa fa-sign-in"></i></a>
											<!-- Modal -->
											  <div class="modal fade" id="mod-warning12' . $n->idOS . '" tabindex="-1" role="dialog">
												<div class="modal-dialog">
												  ' . form_open('tecoslista/fabrica/' . $n->idOS) . '
											  	  <div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													</div>
													<div class="modal-body">
														<div class="text-center">
															<div class="i-circle warning"><i class="fa fa-warning"></i></div>
															<h4>Confirmar retorno do Aparelho?</h4>
															<p>Certifique-se de que o aparelho voltou da fábrica.
														</div>
														
													</div>
													<div class="modal-footer">
													
													  <button type="submit" class="btn btn-success" >Confirmar</button>
													  <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
													
													  </div>
												  </div><!-- /.modal-content -->
												  ' . form_close() . '
												</div><!-- /.modal-dialog --> 
											  </div><!-- /.modal -->
									</td>';
                    break;
                
                default:
                    $data['lista'] .= '<td colspan="3"> Houve um erro ao montar a "Situação" dessa tabela</td>.';
                    break;
            }
        }
        
        $this->load->view('os/tecnico', $data);
    }

    function fabrica($idOS)
    {
        if ($this->OrdemServico->change_os_situation($idOS, 'Em andamento')) {
            $this->index('<div class="alert alert-success">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">X</button>
					<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
					Aparelho da OS Nº ' . $idOS . ' Retornou da fábrica.
				</div>');
        } else {
            $this->index('<div class="alert alert-danger">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">X</button>
					<i class="fa fa-check sign"></i><strong>Erro!</strong>
					Houve um problema ao atualizar o registro no banco de dados. OS Nº ' . $idOS . '. Informe o Suporte NTIC sobre esse erro.
				</div>');
        }
    }
}
?>