<?php
require_once ("secure_area.php");

class Order_pc extends Secure_area
{

    function __construct()
    {
        parent::__construct('purchases');
        $this->load->library('Purch_lib');
    }

    function index($manage_result = null, $data = null)
    {
        $data['manage_result'] = $manage_result;
        
        $crazy_table = $this->Purchase->list_order_pc();
        
        foreach ($crazy_table as $value) {
            $data['resultado'] = $value->quantidade;
        }
        // ------------------------------------------------------------------------------------
        $data['table_order'] = '';
        $resultado = $this->Purchase->Supreme();
        $a = $resultado->result_array();
        
        for ($k = 0; $k < $resultado->num_rows(); $k ++) {
            $data['table_order'] .= '<tr>
	    		 	<td>' . ($a[$k]["departamento"]) . '</td>
	    		  	<td>' . ($a[$k]["fornecedor"]) . '</td>
	    		  	<td class="text-center">' . $a[$k]["qtotal"] . '</td>
	    		  	<td>R$ ' . $a[$k]["ptotal"] . '</td>
	    		  	<td class="text-center">
	    		  		<a href="' . site_url('order_pc/approve/' . $a[$k]["num_pedido"] . '') . '" class="label label-success" data-original-title="Aprovar pedido" data-toggle="tooltip" data-placement="top"><i class="fa fa-check"></i></a> 
						
      					<!-- Modal -->
						  <div class="modal fade" id="mod-warning' . $a[$k]["num_pedido"] . '" tabindex="-1" role="dialog">
							<div class="modal-dialog">
							  <div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								</div>
								<div class="modal-body">
									<div class="text-center">
										<div class="i-circle warning"><i class="fa fa-warning"></i></div>
										<h4>Aviso!</h4>
										<p>Você deseja realmente deletar o pedido ' . $a[$k]["num_pedido"] . ' ?</p>
									</div>
								</div>
								<div class="modal-footer">
								  <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
								  <a href="' . site_url('order_pc/disapprove/' . $a[$k]["num_pedido"]) . '" type="submit" class="btn btn-warning">Deletar</a>
								</div>
							  </div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						  </div><!-- /.modal -->
      
	    		  		
	    		  		<a href="" class="label label-danger" data-toggle="modal" title="Reprovar pedido" data-target="#mod-warning' . $a[$k]["num_pedido"] . '"><i class="fa fa-times"></i></a>
						<a href="' . site_url("purchases/pedido/" . $a[$k]["num_pedido"]) . '" class="label label-primary" data-original-title="Visualizar pedido" data-toggle="tooltip" data-placement="top"><i class="fa fa-search"></i></a>
					</td>
				</tr>';
        }
        
        // ------------------------------------------------------------------------------------
        
        $data['table_total'] = '';
        $resultado2 = $this->Purchase->get_total_Supreme();
        $b = $resultado2->result_array();
        
        for ($l = 0; $l < $resultado2->num_rows(); $l ++) {
            $data['table_total'] .= '
				<tr>
					<td colspan="2"><h4><strong>Total:</strong></h4></td>
					<td class="text-center"><h4><strong>' . $b[$l]["qtotal"] . '</strong></h4></td>
					<td colspan="1"><h4><strong>R$ ' . $b[$l]["ptotal"] . '</strong></h4></td>
					<td colspan="1"><strong><center>-</center></strong></td>
					
				</tr>';
        }
        
        $data['rows2'] = $resultado2->num_rows();
        $data['rows'] = $resultado->num_rows();
        
        $this->load->view('purchases/lista', $data);
    }
    
    /* Função que aprova o pedido */
    function approve($pedido)
    {
        $this->Purchase->approve($pedido);
        
        if ($this->Purchase->approve($pedido)) {
            return $this->index('
						<div class="alert alert-success">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">X</button>
						<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
						Pedido ' . $pedido . ' aprovado!
						</div>', null);
        } else {
            return $this->index('<div class="alert alert-danger">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">X</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Houve algum erro ao tentar aprovar o pedido, por-favor contate o suporte e informe este problema.
					</div>', null);
        }
    }
    
    /* Fun��o que reprova o pedido */
    function disapprove($pedido)
    {
        $this->Purchase->disapprove($pedido);
        
        if ($this->Purchase->disapprove($pedido)) {
            return $this->index('
						<div class="alert alert-success">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">X</button>
						<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
						Pedido ' . $pedido . ' Reprovado!
						</div>', null);
        } else {
            return $this->index('<div class="alert alert-danger">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">X</button>
						<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
						Opss.. Houve algum erro ao tentar reprovar o pedido, por-favor contate o suporte e informe este problema.
						</div>', null);
        }
    }
}

?>