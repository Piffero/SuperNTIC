<?php
require_once ("secure_area.php");
date_default_timezone_set("Brazil/East");

class Pcentrada extends Secure_area
{

    function __construct()
    {
        parent::__construct('purchases');
        $this->load->library('Purch_lib');
    }

    function index($numero, $manage_result = null, $data = null)
    {
        $info = $this->Purchase->get_basic_purch_info($numero);
        $arq = 'http://' . $_SERVER['SERVER_ADDR'] . '/nfe/producao/importadas/' . $info->nfe_chave . '-nfe.xml';
        // echo file_exists('http://'.$_SERVER['SERVER_ADDR'].'/nfe/producao/importadas/'.$info->nfe_chave.'-nfe.xml') or file_exists('http://'.$_SERVER['SERVER_ADDR'].'/nfe/producao/importadas/NFe'.$info->nfe_chave.'-procNFe.xml');
        
        if (file_exists('http://' . $_SERVER['SERVER_ADDR'] . '/nfe/producao/importadas/' . $info->nfe_chave . '-nfe.xml') or file_exists('http://' . $_SERVER['SERVER_ADDR'] . '/nfe/producao/importadas/NFe' . $info->nfe_chave . '-procNFe.xml')) {
            $docxml = file_get_contents($arq);
            $doc = new DOMDocument();
            $doc->preservWhiteSpace = FALSE; // elimina espaços em branco
            $doc->formatOutput = FALSE;
            
            $doc->loadXML($docxml, LIBXML_NOBLANKS | LIBXML_NOEMPTYTAG);
            
            $node = $doc->getElementsByTagName('infNFe')->item(0);
            
            $emi = $doc->getElementsByTagName('ICMSTot')->item(0);
            $data['totalnota'] = $this->tagValue($emi, "vNF");
            
            $data['pedido'] = $numero;
        } else {
            $conteudo = $this->Purchase->get_contents_nfe($numero);
            $data['totalnota'] = $conteudo->row()->val_total_nota;
            $data['pedido'] = $numero;
        }
        
        $data['info'] = array(
            $info->data,
            $info->fornecedor,
            $info->departamento,
            $info->nfe_num_nota,
            $info->nfe_chave
        );
        
        $data['manage_table_row'] = '';
        
        $resultado = $this->Purchase->db_list_itens($numero);
        $n = $resultado->result_array();
        
        for ($i = 0; $i < $resultado->num_rows(); $i ++) {
            $data['manage_table_row'] .= '<tr>
					<td>' . $this->Purchase->retorna_name($n[$i]["produto"]) . '
					</td>
					<td>' . $n[$i]["unidade"] . '
						<input type="hidden" name="un" value="' . $n[$i]["unidade"] . '">
					</td>
					<td>' . $n[$i]["quantidade"] . '
						
					</td>';
            
            if ($this->Purchase->is_serial($n[$i]["produto"])->row()->is_serialized == 1) {
                $data['manage_table_row'] .= '<td> Possui Nº de série 
					<!-- <a href="#"  data-toggle="modal" data-target="#mod-info-' . $n[$i]["id"] . '" title="Confirme UN e quantidade." class="label label-success"><i class="fa fa-check"></i></a> -->
				
	    				<!-- Modal -->
							  <div class="modal fade" id="mod-info-' . $n[$i]["id"] . '" tabindex="-1" role="dialog">
								<div class="modal-dialog">
								  <div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									</div>
									<div class="modal-body">
										<div class="text-center">
											<div class="i-circle primary"><i class="fa fa-check"></i></div>
											<h4>Awesome!</h4>
											<p>Changes has been saved successfully!</p>
										</div>
									</div>
									<div class="modal-footer">
									  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									  <button type="button" class="btn btn-primary">Proceed</button>
									</div>
								  </div><!-- /.modal-content -->
								</div><!-- /.modal-dialog -->
							  </div><!-- /.modal -->
	    				
	    		</td>';
            } else {
                $qtde1 = $this->Purchase->verifica_zerou_quant($n[$i]["produto"], $numero)->QTD;
                $qtde2 = $this->Purchase->verifica_zerou_quant($n[$i]["produto"], $numero)->QTD2;
                
                $data['manage_table_row'] .= '<td>';
                
                if ($qtde1 - $qtde2 == 0) {
                    $data['manage_table_row'] .= '<button type="button"  class="btn btn-default btn-flat btn-xs"><i class="fa fa-check"></i></button>';
                } else {
                    $data['manage_table_row'] .= form_open('pcentrada/confirma_quantidade/') . '<button type="submit"  class="btn btn-success btn-flat btn-xs" name="qtdid" value="' . $n[$i]["quantidade"] . '-' . $n[$i]["produto"] . '-' . $numero . '"><i class="fa fa-check"></i></button>' . form_close();
                }
                
                $data['manage_table_row'] .= '
					<!-- <a href="#" data-toggle="modal" data-target="#mod-info-' . $n[$i]["id"] . '"  data-original-title="Fracionar tipo da unidade e quantidade" data-placement="top" class="label label-info"><i class="fa fa-sitemap"></i></a> -->	
					<!-- <a href="#"  title="Confirme UN e quantidade." class="label label-success"><i class="fa fa-check"></i></a>	-->

							<!-- Modal -->
							  <div class="modal fade" id="mod-info-' . $n[$i]["id"] . '" tabindex="-1" role="dialog">
								<div class="modal-dialog">
								  <div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									</div>
									<div class="modal-body">
										<div class="text-center">
											<div class="i-circle primary"><i class="fa fa-sitemap"></i></div>
											<h4>Fracionar item</h4>
											<p>Informe o tipo do item e a quantidade (para 1 UN) para qual deseja fracionar:</p>
							  				Nova quantidade: <input type="text" data-mask="########0.00##" data-mask-reverse="true" placehol> 
										</div>
									</div>
									<div class="modal-footer">
									  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									  <button type="button" class="btn btn-primary">Proceed</button>
									</div>
								  </div><!-- /.modal-content -->
								</div><!-- /.modal-dialog -->
							  </div><!-- /.modal -->
				</td>';
            }
            $data['manage_table_row'] .= '</tr>';
        }
        
        /**
         * ********************************************************************************************
         */
        // total da soma dos produtos pedidos - produtos recebidos
        $qtd = $this->Purchase->soma_subtrai_quantidades($numero)->row()->QTD;
        $qtd2 = $this->Purchase->soma_subtrai_quantidades($numero)->row()->QTD2;
        
        // ----------------------------------------------------------------------------------------------
        // total da soma dos produtos SERIALIZADOS pedidos - produtos SERIALIZADOS recebidos
        $ProdSerialPedidos = $this->Purchase->soma_quant_pserial($numero)->QTD1;
        $ProdSerialRecebidos = $this->Purchase->soma_quant_pserial($numero)->QTD2;
        
        // -----------------------------------------------------------------------------------------------
        // total da soma dos produtos "NÃO" SERIALIZADOS pedidos - produtos "NÃO" SERIALIZADOS recebidos
        $ProdNSerialPedidos = $this->Purchase->soma_quant_pNserial($numero)->QTD1;
        $ProdNSerialRecebidos = $this->Purchase->soma_quant_pNserial($numero)->QTD2;
        // -----------------------------------------------------------------------------------------------
        
        if (($ProdNSerialPedidos - $ProdNSerialRecebidos == 0) and ($ProdSerialPedidos - $ProdSerialRecebidos == 0)) {
            $data['decisao'] = form_open('pcentrada/concluir/' . $numero) . '<button type="button" data-toggle="tooltip" data-placement="top" data-original-title="Não há produtos para serem serializados" class="btn btn-default" readonly="readonly">Serializar</button>
									  <button type="submit" class="btn btn-success">Concluir</button>
								   ' . form_close();
        } elseif (($ProdNSerialPedidos - $ProdNSerialRecebidos != 0) and ($ProdSerialPedidos - $ProdSerialRecebidos == 0)) {
            $data['decisao'] = '<button type="button" data-toggle="tooltip" data-placement="top" data-original-title="Não há produtos para serem serializados" class="btn btn-default" readonly="readonly">Serializar</button>
									<button type="button" data-toggle="tooltip" data-placement="top" data-original-title="Aguardando confirmação dos produtos na lista acima" class="btn btn-default" readonly="readonly">Concluir</button>';
        } elseif (($ProdNSerialPedidos - $ProdNSerialRecebidos == 0) and ($ProdSerialPedidos - $ProdSerialRecebidos != 0)) {
            $data['decisao'] = '<button type="button" onclick="return window.open(\'' . site_url('pcentrada/series/' . $numero) . '\',\'Informação do Pedido\',\'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=50, LEFT=70,width=680,height=500\');" class="btn btn-success">Serializar</button>
									<button type="button" data-toggle="tooltip" data-placement="top" data-original-title="Há produtos que necessitam ser serializados" class="btn btn-default" readonly="readonly">Concluir</button>';
        } elseif (($ProdNSerialPedidos - $ProdNSerialRecebidos != 0) and ($ProdSerialPedidos - $ProdSerialRecebidos != 0)) {
            $data['decisao'] = '<button type="button" onclick="return window.open(\'' . site_url('pcentrada/series/' . $numero) . '\',\'Informação do Pedido\',\'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=50, LEFT=70,width=680,height=500\');" class="btn btn-success">Serializar</button>
									<button type="button" data-toggle="tooltip" data-placement="top" data-original-title="Aguardando confirmação dos produtos na lista acima" class="btn btn-default" readonly="readonly">Concluir</button>';
        }
        
        /**
         * ********************************************************************************************
         */
        
        $data['manage_result'] = $manage_result;
        $this->load->view('purchases/entrada', $data);
    }

    function checkin($item_pedido)
    {
        $id = $this->input->post('id');
        // $resultado = $this->Purchase->get_campos_pedido($id);
        // $n = $resultado->result_array();
        
        $data = array(
            'checked' => '1',
            'vunitnota' => $this->input->post('vuc'),
            'vtotalnota' => $this->input->post('vtc')
        );
        
        $this->Purchase->checkin($id, $data);
    }

    /**
     * Função que atualiza o status do Pedido de Compra para "Recebido"
     *
     * @param integer $pedido            
     */
    function confirma($pedido)
    {
        if ($this->Purchase->confirma($pedido)) {
            $manage_result = 1;
            
            echo '<script> window.location = "' . site_url('pclista/index/' . $manage_result) . '"</script>';
        } else {
            $manage_result = '<div class="alert alert-danger">
						<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
						<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
						Ocorreu um erro ao realizar esta entrada de Pedido de Compra (pedido ' . $pedido . '). Por favor informe este problema ao Suporte do NTIC.
					</div>';
            
            $this->index($pedido, $manage_result, NULL);
        }
    }

    function tagValue($node, $tag)
    {
        return $node->getElementsByTagName("$tag")->item(0)->nodeValue;
    }

    function series($pedido, $manage_result = NULL)
    {
        $data['pedido'] = $pedido;
        $data['manage_result'] = $manage_result;
        
        $b = $this->Purchase->get_entrada($pedido);
        $rows = $b->num_rows();
        $c = $b->result_array();
        // print_r($c);
        $data['lista'] = '';
        
        for ($i = 0; $i < $rows; $i ++) {
            // verifica se o produto é serializado
            if ($this->Purchase->is_serial($c[$i]['produto'])->row()->is_serialized == 1) {
                for ($j = 0; $j < ($c[$i]['quantidade'] - $c[$i]['quant_inserida']); $j ++) {
                    $data['lista'] .= '<tr>';
                    $data['lista'] .= '<td>' . $this->Purchase->retorna_name($c[$i]['produto']) . '</td>
									   		<td><input type="text" name="' . $c[$i]['produto'] . '[' . $j . '][nserie]" class="form-control"></td>';
                    $data['lista'] .= '</tr>';
                }
            } // Então, se o produto não é serializado não aparece na lista
        }
        
        $this->load->view('purchases/series', $data);
    }

    function insert_series($pedido)
    {
        $logado = $this->Employeer->get_logged_in_employee_info()->employees_id;
        
        foreach ($this->input->post() as $key => $value) {
            /*
             * POST
             * exemplo: (Ambra)
             * id: (54 =>
             * ([0]['nserie']=>'xxx'),
             * ([1]['nserie']=>'yyy'),
             * ([2]['nserie']=>'aaa')
             * )
             */
            
            $a = count($value); // Quantidade de chaves no array : quantidade de proutos pedidos
            for ($i = 0; $i < $a; $i ++) {
                // if do notepad++
                if ($this->Purchase->verifica_nserie_existe($value[$i]["nserie"]) == 0) {
                    // Se o valor for nulo ou não estiver setado, passa para o próximo item
                    if (! ($value[$i] == '' or $value[$i] == ' ' or $value[$i] == null or empty($value[$i]) or ! isset($value[$i]))) {
                        $data = array(
                            'item_id' => $key,
                            'item_serie' => $value[$i]['nserie'],
                            'trans_user' => $logado,
                            'location_id' => 1
                        );
                        
                        $this->Purchase->insert_serie($data);
                        $this->Purchase->set_quant_inserida($pedido, $key, 1);
                    }
                } else {
                    redirect('pcentrada/series/' . $pedido . '/' . $value[$i]['nserie']);
                }
            }
            
            if ($this->Purchase->exist_item_value($key)->num_rows() != 0) {
                $id = $this->Purchase->exist_item_value($key)->row()->id;
                $this->Purchase->update_item_value($a, $id);
            } else {
                $this->Purchase->insert_item_value($key, $a, $logado, 1);
            }
        }
        
        echo '<script>opener.location.reload(); self.close();</script>';
    }

    function finaliza($pedido)
    {
        $a = explode("-", $this->input->post("qtdid"));
        
        $data = array(
            'quant_inserida' => $a[0]
        );
        
        if ($this->Purchase->update_quant($data, $a[1])) {
            $this->index($pedido, '<div class="alert alert-success">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
						<i class="fa fa-check sign"></i><strong>Sucesso!</strong> 
						Quantidade confirmada do item ' . $this->Purchase->retorna_name($a[1]) . ' !
					</div>');
        } else {
            $this->index($pedido, '<div class="alert alert-danger">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
						<i class="fa fa-plus sign"></i><strong>Erro!</strong> 
						A quantidade não pode ser inserida corretamente no banco de dados. Por favor informe o Suporte NTIC sobre este problema!
					</div>');
        }
    }

    function confirma_quantidade()
    {
        $a = explode("-", $this->input->post("qtdid"));
        $qtde = $a[0];
        $produto = $a[1];
        $pedido = $a[2];
        
        if ($this->Purchase->confirma_no_pedido($qtde, $produto, $pedido)) {
            if ($this->Purchase->exist_item_value($produto)->num_rows() != 0) {
                $id = $this->Purchase->exist_item_value($produto)->row()->id;
                
                $this->Purchase->update_item_value($qtde, $id);
            } else {
                $this->Purchase->insert_item_value($produto, $qtde, 0, 1);
            }
            
            $this->index($pedido, '<div class="alert alert-success">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
						<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
						Quantidade confirmada do item ' . $this->Purchase->retorna_name($a[1]) . ' !
					</div>');
        } else {
            $this->index($pedido, '<div class="alert alert-danger">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
						<i class="fa fa-plus sign"></i><strong>Erro!</strong> 
						A quantidade não pode ser inserida corretamente no banco de dados. Por favor informe o Suporte NTIC sobre este problema!
					</div>');
        }
    }

    function concluir($pedido)
    {
        if ($this->Purchase->conclui_pedido(array(
            'situacao' => 'Recebido'
        ), $pedido)) {
            redirect("pclista");
        } else {
            $this->index($pedido, '<div class="alert alert-danger">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
						<i class="fa fa-plus sign"></i><strong>Erro!</strong>
						Houve um erro ao tentar atualizar o registro da compra no banco de dados. Por favor informe o Suporte NTIC sobre este problema!
					</div>');
        }
    }
}

