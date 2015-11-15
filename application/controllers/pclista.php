<?php
require_once ("secure_area.php");
date_default_timezone_set("Brazil/East");

class Pclista extends Secure_area
{

    function __construct()
    {
        parent::__construct('purchases');
        $this->load->library('Purch_lib');
    }

    function index($manage_result = null)
    {
        $func_dept = $this->Employeer->get_logged_in_employee_info();
        $data['func'] = $func_dept;
        $depto = $func_dept->department_id;
        
        $pedido = $this->Purchase->last(); // Pega a linha inteira que contém o número do último ID
        $data['pedido'] = $pedido->num_pedido + 1;
        
        if ($manage_result == 1)
            $manage_result = '<div class="alert alert-success">
								<button class="close" aria-hidden="true" data-dismiss="alert" type="button">X</button>
								<i class="fa fa-check sign"></i><strong>Sucesso!</strong> 
								O pedido foi recebido com sucesso!
							</div>';
        
        $data['manage_result'] = $manage_result;
        
        $resultado = $this->Purchase->list_by_dept($depto, $this->check_action_permission('view_all')); // $this->Purchase->table_lista_pc();
        
        $linhas = $resultado->result();
        
        $data['table_pc'] = '';
        $a = $resultado->result_array();
        $data['linhas'] = $resultado->num_rows();
        
        for ($j = 0; $j < $resultado->num_rows(); $j ++) {
            
            switch (($a[$j]["situacao"])) {
                case "Processando":
                    
                    $data["table_pc"] .= '<tr>
								    		 	<td>' . $a[$j]["num_pedido"] . '</td>
								    		  	<td colspan="4" class="text-center"><i>Processando</i></td>
								    		  	<td>
								    		  	<!-- Modal -->
												 	<div class="modal fade" id="mod-warning' . $a[$j]["num_pedido"] . '" tabindex="-1" role="dialog">
														<div class="modal-dialog">
															' . form_open("pclista/deleteall/" . $a[$j]["num_pedido"]) . '
													 			<div class="modal-content">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																	</div>
																	<div class="modal-body">
																		<div class="text-center">
																			<div class="i-circle warning"><i class="fa fa-warning"></i></div>
																			<h4>Aviso!</h4>
																			<p>Você deseja realmente deletar o pedido ' . $a[$j]["num_pedido"] . ' ?</p>
																		</div>
																	</div>
																	<div class="modal-footer">
														  				<button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
														 				<a href="' . site_url('pclista/deleteall/' . $a[$j]["num_pedido"]) . '" type="submit" class="btn btn-warning">Deletar</a>
																	</div>
													  			</div><!-- /.modal-content -->
													 		' . form_close() . '
														</div><!-- /.modal-dialog -->
												  	</div><!-- /.modal -->
													<center><a href="" class="label label-danger" data-toggle="modal" title="Realizar pedido" data-target="#mod-warning' . $a[$j]["num_pedido"] . '"><i class="fa fa-times"></i></a></center></td>
								    		</tr>';
                    break;
                
                case "Aberto":
                    $data["table_pc"] .= '<tr>
								    		 	<td>' . $a[$j]["num_pedido"] . '</td>
								    		  	<td class="text-center">' . ($a[$j]["departamento"]) . '</td>
								    		  	<td class="text-center">' . ($a[$j]["fornecedor"]) . '</td>
								    		  	<td class="text-center">' . date('d/m/Y h:m', strtotime($a[$j]["data"])) . '</td>
								    		  	<td class="text-center"><labe class="label label-primary">' . ($a[$j]["situacao"]) . '</label></td>
								    		  	<td class="text-center">
								    		  		<a href="#" onclick="return window.open(\'' . $this->config->site_url('pclista/info/' . $a[$j]["num_pedido"]) . '\',\'Informação do Pedido\',\'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=50, LEFT=70,width=770,height=500\');" class="label label-primary"  data-original-title="Visualizar Pedido" data-toggle="tooltip" data-placement="top"><i class="fa fa-search"></i></a>
								    		  		<a class="label label-default"><i class="fa fa-check"></i></a>
							    		  			<!-- Modal -->
											  		<div class="modal fade" id="mod-warning' . $a[$j]["num_pedido"] . '" tabindex="-1" role="dialog">
														<div class="modal-dialog">
															' . form_open("pclista/deleteall/" . $a[$j]["num_pedido"]) . '
												 			 	<div class="modal-content">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																	</div>
																	<div class="modal-body">
																		<div class="text-center">
																			<div class="i-circle warning"><i class="fa fa-warning"></i></div>
																			<h4>Aviso!</h4>
																			<p>Você deseja realmente deletar o pedido ' . $a[$j]["num_pedido"] . ' ?</p>
																		</div>
																	</div>
																	<div class="modal-footer">
													  					<button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
													 	 				<a href="' . site_url('pclista/deleteall/' . $a[$j]["num_pedido"]) . '" type="submit" class="btn btn-warning">Deletar</a>
																	</div>
											  					</div><!-- /.modal-content -->
										  					' . form_close() . '
														</div><!-- /.modal-dialog -->
										  			</div><!-- /.modal -->
											  		<a href="" class="label label-danger" data-toggle="modal" title="Deletar pedido" data-target="#mod-warning' . $a[$j]["num_pedido"] . '"><i class="fa fa-times"></i></a>
											  	</td>
							    		  	</tr>';
                    break;
                
                case "Aprovado":
                    $em = $this->Purchase->get_supplier_info(($a[$j]["fornecedor"]));
                    $ema = $em->result();
                    $email = $ema[0]->email;
                    $tel = $ema[0]->phone_number;
                    $data["table_pc"] .= '<tr>
					    		 	<td>' . $a[$j]["num_pedido"] . '</td>
					    		  	<td class="text-center">' . ($a[$j]["departamento"]) . '</td>
					    		  	<td class="text-center">' . ($a[$j]["fornecedor"]) . '</td>
					    		  	<td class="text-center">' . date('d/m/Y h:m', strtotime($a[$j]["data"])) . '</td>
					    		  	<td class="text-center"><label class="label label-success">' . ($a[$j]["situacao"]) . '</label></td><td>
      								<!-- Modal -->
										<div class="modal fade colored-header" id="mod-info" tabindex="-1" role="dialog">
											<div class="modal-dialog">
												' . form_open('pclista/send/' . $a[$j]["num_pedido"]) . '
										  			<div class="modal-content">
														<div class="modal-header">
															<h3>Realizar pedido ' . $a[$j]["num_pedido"] . ' ?</h3>
															<button type="button" class="close md-close" data-dismiss="modal" aria-hidden="true" style="margin-top: -30px;">&times;</button>																</div>
															<div class="modal-body">
																<div class="form-group">
																	<label><h4>Fornecedor: ' . ($a[$j]["fornecedor"]) . '</h4></label> 
																</div>
																<div class="form-group">
																	<h5><strong>Telefones: ' . $tel . '</strong></h5>
																	<h5><strong>Email: ' . $email . '</strong></h5>
																</div><br>
																<input type="checkbox" name="tel" value="1"> Contatar por telefone.<br>
																<input type="checkbox" name="email" value="1">  Enviar pedido por email.
															</div>
															<div class="modal-footer">
															  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
															  <button type="submit" class="btn btn-primary">Realizar pedido</button>
															</div>
													  	</div><!-- /.modal-content -->
												  	' . form_close() . '
												</div><!-- /.modal-dialog -->
											</div>
										<!-- /.modal -->
      									<center>
      								  		<a href="#" onclick="return window.open(\'' . $this->config->site_url('pclista/info/' . $a[$j]["num_pedido"]) . '\',\'Informa��o do Pedido\',\'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=50, LEFT=70,width=770,height=500\');" class="label label-primary"  data-original-title="Visualizar Pedido" data-toggle="tooltip" data-placement="top"><i class="fa fa-search"></i></a> 
      								  		<a href="" class="label label-info" data-toggle="modal" title="Realizar pedido" data-target="#mod-info"><i class="fa fa-check"></i></a>
      								  		<!-- Modal -->
													<div class="modal fade" id="mod-warning' . $a[$j]["num_pedido"] . '" tabindex="-1" role="dialog">
														<div class="modal-dialog">
													' . form_open("pclista/deleteall/" . $a[$j]["num_pedido"]) . '
													  <div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
														</div>
														<div class="modal-body">
															<div class="text-center">
																<div class="i-circle warning"><i class="fa fa-warning"></i></div>
																<h4>Aviso!</h4>
																<p>Você deseja realmente deletar o pedido ' . $a[$j]["num_pedido"] . ' ?</p>
															</div>
														</div>
														<div class="modal-footer">
														  <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
														  <a href="' . site_url('pclista/deleteall/' . $a[$j]["num_pedido"]) . '" type="submit" class="btn btn-warning">Deletar</a>
														</div>
													  </div><!-- /.modal-content -->
													  ' . form_close() . '
													</div><!-- /.modal-dialog -->
												  </div><!-- /.modal -->
												  <a href="" class="label label-danger" data-toggle="modal" title="Deletar pedido" data-target="#mod-warning' . $a[$j]["num_pedido"] . '"><i class="fa fa-times"></i></a></center></td>
      						</tr>';
                    
                    break;
                
                case "Pedido":
                    $data["table_pc"] .= '<tr>';
                    if ($a[$j]["nfe_num_nota"]) {
                        $data["table_pc"] .= '<td>' . $a[$j]["num_pedido"] . ' - ' . $a[$j]["nfe_num_nota"] . '</td>';
                    } else {
                        $data["table_pc"] .= '<td>' . $a[$j]["num_pedido"] . '</td>';
                    }
                    
                    $data["table_pc"] .= '
					    		<td class="text-center">' . ($a[$j]["departamento"]) . '</td>
					    	  	<td class="text-center">' . ($a[$j]["fornecedor"]) . '</td>
					    	  	<td class="text-center">' . date('d/m/Y h:m', strtotime($a[$j]["data"])) . '</td>
					    	  	<td class="text-center"><label class="label label-info">' . ($a[$j]["situacao"]) . '</label></td>
					    	  	<td><center>
					    	  			<a href="#" onclick="return window.open(\'' . $this->config->site_url('pclista/info/' . $a[$j]["num_pedido"]) . '\',\'Informação do Pedido\',\'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=50, LEFT=70,width=770,height=500\');" class="label label-primary"  data-original-title="Visualizar Pedido" data-toggle="tooltip" data-placement="top"><i class="fa fa-search"></i></a>';
                    
                    if ($a[$j]["nfe_num_nota"]) {
                        $data["table_pc"] .= ' <a href="' . site_url('pcentrada/index/' . $a[$j]["num_pedido"]) . '" class="label label-warning" data-original-title="Realizar entrada do pedido" data-toggle="tooltip" data-placement="top"><i class="fa fa-folder-open"></i></a>';
                    } else {
                        $data["table_pc"] .= ' <a onclick="return window.open(\'' . $this->config->site_url('pclista/import/' . $a[$j]["num_pedido"]) . '\',\'Importação de Nota fiscal Eletônica\',\'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=50, LEFT=70,width=1000,height=500\');" href="" class="label label-info" data-original-title="Associar NF-e ao pedido" data-toggle="tooltip" data-placement="top"><i class="fa fa-download"></i></a>';
                    }
                    
                    $data["table_pc"] .= '
		    	  				<!-- Modal -->
								  <div class="modal fade" id="mod-warning' . $a[$j]["num_pedido"] . '" tabindex="-1" role="dialog">
									<div class="modal-dialog">
									' . form_open("pclista/deleteall/" . $a[$j]["num_pedido"]) . '
									  <div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										</div>
										<div class="modal-body">
											<div class="text-center">
												<div class="i-circle warning"><i class="fa fa-warning"></i></div>
												<h4>Aviso!</h4>
												<p>Você deseja realmente deletar o pedido ' . $a[$j]["num_pedido"] . ' ?</p>
											</div>
										</div>
										<div class="modal-footer">
										  <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
										  <a href="' . site_url('pclista/deleteall/' . $a[$j]["num_pedido"]) . '" type="submit" class="btn btn-warning">Deletar</a>
										</div>
									  </div><!-- /.modal-content -->
									  ' . form_close() . '
									</div><!-- /.modal-dialog -->
								  </div><!-- /.modal -->
								<a href="" class="label label-danger" data-toggle="modal" title="Deletar pedido" data-target="#mod-warning' . $a[$j]["num_pedido"] . '"><i class="fa fa-times"></i></a></center></td>
					    	 </tr>';
                    break;
                
                default:
                    $data["table_pc"] .= '<tr>
    		  					<td>' . $a[$j]["num_pedido"] . '</td>
    		  					<td colspan="5">Erro ao montar Ação</td>
    		  				</tr>';
                    break;
            }
        }
        
        $this->load->view('purchases/situacao', $data);
    }
    
    /* Função que cria a linha na tabela do novo pedido */
    function request($pedido)
    {
        $pedido_data = array(
            'situacao' => 'Processando'
        );
        
        $this->Purchase->insertpedido($pedido_data);
        redirect('purchases/pedido/' . $pedido);
    }

    function send($pedido)
    {
        // $datas = array();
        if ($this->input->post('email')) {
            $datas['emailed'] = $this->input->post('email');
        } else {
            $datas['emailed'] = '0';
        }
        
        if ($this->input->post('tel')) {
            $datas['telefonado'] = $this->input->post('tel');
        } else {
            $datas['telefonado'] = '0';
        }
        
        if ($this->Purchase->send($pedido, $datas)) {
            $this->index('<div class="alert alert-success">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">X</button>
					<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
					Pedido ' . $pedido . ' realizado com sucesso!
				</div>');
        } else {
            $this->index('<div class="alert alert-danger">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">X</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Ocorreu um erro ao atualizar o pedido ' . $pedido . ' ! 
					Informe este erro ao suporte do NTIC.
				</div>');
        }
    }

    function deleteall($pedido)
    {
        if ($this->Purchase->delete_purch_all($pedido)) {
            
            $this->index('<div class="alert alert-success">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">X</button>
					<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
					Pedido ' . $pedido . ' deletado com sucesso!
				</div>');
        } else {
            $this->index('<div class="alert alert-danger">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">X</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Ocorreu um erro ao deletar o pedido ' . $pedido . ' ! 
					Informe este erro ao suporte do NTIC.
				</div>');
        }
    }

    function info($pedido)
    {
        $data['manage_table_row2'] = '';
        $resultado3 = $this->Purchase->db_list_itens($pedido);
        $enc = $resultado3->result_array();
        
        for ($ii = 0; $ii < $resultado3->num_rows(); $ii ++) {
            $data['manage_table_row2'] .= '<tr>
	    		 	<td>' . $this->Purchase->retorna_name($enc[$ii]["produto"]) . '</td>
	    		  	<td class="text-center">' . $enc[$ii]["unidade"] . '</td>
	    		  	<td class="text-center">' . $enc[$ii]["quantidade"] . '</td>
	    		  	<td class="text-center">' . $enc[$ii]["valorunit"] . '</td>
	    		  	<td class="text-center">' . $enc[$ii]["vtotal"] . '</td>
	    		</tr>';
        }
        
        $data['pedido'] = $pedido;
        $data['infos'] = $this->Purchase->busca_Forn_Date_Dept($pedido);
        $this->load->view('purchases/info', $data);
    }

    function import($id, $dados = null)
    {
        $dados['id'] = $id;
        
        if ($_FILES) // se tiver setado o arquivo
{
            if ($_FILES['nfe']['type'] == 'text/xml') // verifica se é XML
{
                if ($_FILES['nfe']['size'] <= 512000) // arquivo da NF-e não pode exceder 500 kb
{
                    if ($_FILES['nfe']['error'] == 0) // verifica se o arquivo não extá corrompido ou inacessível
{
                        $dir = '/var/www/html/nfe/producao/importadas/';
                        
                        $docxml = file_get_contents($_FILES['nfe']['tmp_name']);
                        $dados = $this->importaNFe($docxml);
                        $dados['id'] = $id;
                        
                        $upload_file = $dir . basename($_FILES['nfe']['name']);
                        move_uploaded_file($_FILES['nfe']['tmp_name'], $upload_file);
                    } else {
                        $dados['result'] = '<div class="alert alert-danger">
							<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
							O Arquivo está corrompido, inacessível, ou é muito grande.
						</div>';
                    }
                } else {
                    $dados['result'] = '<div class="alert alert-danger">
							<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
							O tamanho do XML excede o limite de 500 kbytes padrão de NF-e\'s
						</div>';
                }
            } else {
                $dados['result'] = '<div class="alert alert-danger">
							<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
							O arquivo deve ser um XML de uma Nota Fiscal válida.
						</div>';
            }
        } // carrega a tela normal
          
        // print_r($dados);
        $a = $this->Purchase->get_lista_produtos($id);
        $num = $a->num_rows();
        $b = $a->result_array();
        $dados['lista'] = '';
        
        for ($j = 0; $j < $num; $j ++) {
            $dados['lista'] .= '<tr>
									<td>' . $b[$j]['item_codebar'] . '</td>
									<td>' . $this->Purchase->retorna_name($b[$j]['produto']) . '</td>
									<td class="text-center">' . $b[$j]['unidade'] . '</td>
									<td class="text-center">' . $b[$j]['quantidade'] . '</td>
								</tr>';
        }
        
        // print_r($b);
        $this->load->view('purchases/import', $dados);
    }

    function importaNFe($xml)
    {
        $doc = new DOMDocument();
        
        $doc->preservWhiteSpace = FALSE; // elimina espaços em branco
        
        $doc->formatOutput = FALSE;
        $doc->loadXML($xml, LIBXML_NOBLANKS | LIBXML_NOEMPTYTAG);
        $node = $doc->getElementsByTagName('infNFe')->item(0);
        
        $dados['chave'] = substr(trim($node->getAttribute("Id")), 3);
        
        // Reconhecimento dos campos do XML
        $nota = str_pad($this->tagValue($doc, "nNF"), 9, "0", STR_PAD_LEFT);
        /* 000000001 */
        
        $dados['numero'] = substr($nota, 0, 3) . '.' . substr($nota, 3, 3) . '.' . substr($nota, 6);
        $dados['serie'] = $this->tagValue($doc, "serie");
        $emi = $doc->getElementsByTagName('emit')->item(0);
        
        $c1 = $this->tagValue($emi, "CNPJ");
        $c2 = substr($c1, 0, 2) . "." . substr($c1, 2, 3) . "." . substr($c1, 5, 3) . "/" . substr($c1, 8, 4) . "-" . substr($c1, 12, 2);
        
        $dados['emitenteCnpjFormatado'] = $c2;
        $dados['emitenteRazaoSocial'] = $this->tagValue($emi, "xNome");
        $a = $this->tagValue($emi, "fone");
        $dados['emitenteTelefone'] = '(' . substr($a, 0, 2) . ') ' . substr($a, 2);
        
        $dst = $doc->getElementsByTagName('dest')->item(0);
        
        $c1 = $this->tagValue($dst, "CNPJ");
        $c2 = substr($c1, 0, 2) . "." . substr($c1, 2, 3) . "." . substr($c1, 5, 3) . "/" . substr($c1, 8, 4) . "-" . substr($c1, 12, 2);
        
        // valor total da nota fiscal: <vNF>
        $dados['valornota'] = $doc->getElementsByTagName("vNF")->item(0)->nodeValue;
        
        $dados['destinatarioCnpjFormatado'] = $c2;
        $dados['destinatarioRazaoSocial'] = $this->tagValue($dst, "xNome");
        
        $det = $doc->getElementsByTagName('det');
        $itens = "";
        
        for ($i = 0; $i < $det->length; $i ++) {
            $item = $det->item($i);
            $s = "";
            $s['codigo'] = $this->tagValue($item, "cProd");
            $s['ean'] = $this->tagValue($item, "cEAN");
            $s['nome'] = $this->tagValue($item, "xProd");
            $s['ncm'] = $this->tagValue($item, "NCM");
            $s['cfop'] = $this->tagValue($item, "CFOP");
            $s['unidade'] = $this->tagValue($item, "uCom");
            $s['quantidade'] = $this->tagValue($item, "qCom");
            $s['valor'] = $this->tagValue($item, "vUnCom");
            $s['valorTotal'] = $this->tagValue($item, "vProd");
            
            $itens[] = $s;
        }
        
        $dados['itens'] = $itens;
        
        return $dados;
    }

    private function tagValue($node, $tag)
    {
        return $node->getElementsByTagName("$tag")->item(0)->nodeValue;
    }

    function associate()
    {
        $id = $this->input->post("id");
        $data = array(
            'nfe_chave' => $this->input->post("nota"),
            'nfe_num_nota' => $this->input->post("num_nota")
        );
        $data2 = array(
            'pedido' => $this->input->post("id"),
            'chave' => $this->input->post("nota"),
            'number' => $this->input->post('num_nota'),
            'val_total_nota' => $this->input->post("valnota")
        );
        
        if ($this->Purchase->associate_nfe($data, $id)) {
            if ($this->Purchase->insert_nfe($data2)) {
                $dados['result'] = '<script>opener.location.reload(); self.close();</script>';
                $this->import($id, $dados);
            }
        }
    }

    function search($manage_result = null)
    {
        $var = $this->input->post("var");
        
        $func_dept = $this->Employeer->get_logged_in_employee_info();
        $data['func'] = $func_dept;
        $depto = $func_dept->department_id;
        
        $pedido = $this->Purchase->last(); // Pega a linha inteira que contém o número do último ID
        $data['pedido'] = $pedido->num_pedido + 1;
        
        if ($manage_result == 1)
            $manage_result = '<div class="alert alert-success">
								<button class="close" aria-hidden="true" data-dismiss="alert" type="button">X</button>
								<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
								O pedido foi recebido com sucesso!
							</div>';
        
        $data['manage_result'] = $manage_result;
        
        $resultado = $this->Purchase->list_search($var); // $this->Purchase->table_lista_pc();
        
        $linhas = $resultado->result();
        
        $data['table_pc'] = '';
        $a = $resultado->result_array();
        $data['linhas'] = $resultado->num_rows();
        
        for ($j = 0; $j < $resultado->num_rows(); $j ++) {
            
            switch (($a[$j]["situacao"])) {
                case "Processando":
                    
                    $data["table_pc"] .= '<tr>
								<td>' . $a[$j]["num_pedido"] . '</td>
								<td colspan="4" class="text-center"><i>Processando</i></td>
										<td>
												    		  	<!-- Modal -->
																 	<div class="modal fade" id="mod-warning' . $a[$j]["num_pedido"] . '" tabindex="-1" role="dialog">
																		<div class="modal-dialog">
										' . form_open("pclista/deleteall/" . $a[$j]["num_pedido"]) . '
																	 			<div class="modal-content">
												<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																	</div>
																	<div class="modal-body">
																		<div class="text-center">
																			<div class="i-circle warning"><i class="fa fa-warning"></i></div>
																			<h4>Aviso!</h4>
																			<p>Você deseja realmente deletar o pedido ' . $a[$j]["num_pedido"] . ' ?</p>
																		</div>
																	</div>
																	<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
														 				<a href="' . site_url('pclista/deleteall/' . $a[$j]["num_pedido"]) . '" type="submit" class="btn btn-warning">Deletar</a>
																	</div>
														</div><!-- /.modal-content -->
														' . form_close() . '
														</div><!-- /.modal-dialog -->
												  	</div><!-- /.modal -->
													<center><a href="" class="label label-danger" data-toggle="modal" title="Realizar pedido" data-target="#mod-warning' . $a[$j]["num_pedido"] . '"><i class="fa fa-times"></i></a></center></td>
								    		</tr>';
                    break;
                
                case "Aberto":
                    $data["table_pc"] .= '<tr>
								    		 	<td>' . $a[$j]["num_pedido"] . '</td>
		    		  					<td class="text-center">' . ($a[$j]["departamento"]) . '</td>
		    		  					<td class="text-center">' . ($a[$j]["fornecedor"]) . '</td>
		    		  					<td class="text-center">' . date('d/m/Y h:m', strtotime($a[$j]["data"])) . '</td>
		    		  							<td class="text-center"><labe class="label label-primary">' . ($a[$j]["situacao"]) . '</label></td>
								    		  	<td class="text-center">
										    		  	<a href="#" onclick="return window.open(\'' . $this->config->site_url('pclista/info/' . $a[$j]["num_pedido"]) . '\',\'Informação do Pedido\',\'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=50, LEFT=70,width=770,height=500\');" class="label label-primary"  data-original-title="Visualizar Pedido" data-toggle="tooltip" data-placement="top"><i class="fa fa-search"></i></a>
							    		  			<!-- Modal -->
											  		<div class="modal fade" id="mod-warning' . $a[$j]["num_pedido"] . '" tabindex="-1" role="dialog">
														<div class="modal-dialog">
															' . form_open("pclista/deleteall/" . $a[$j]["num_pedido"]) . '
										    		  			<div class="modal-content">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																	</div>
																	<div class="modal-body">
																		<div class="text-center">
																			<div class="i-circle warning"><i class="fa fa-warning"></i></div>
																			<h4>Aviso!</h4>
																			<p>Você deseja realmente deletar o pedido ' . $a[$j]["num_pedido"] . ' ?</p>
																		</div>
																	</div>
																	<div class="modal-footer">
													  					<button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
													 	 				<a href="' . site_url('pclista/deleteall/' . $a[$j]["num_pedido"]) . '" type="submit" class="btn btn-warning">Deletar</a>
																	</div>
											  					</div><!-- /.modal-content -->
		    		  					' . form_close() . '
		    		  					</div><!-- /.modal-dialog -->
										  			</div><!-- /.modal -->
											  		<a href="" class="label label-danger" data-toggle="modal" title="Deletar pedido" data-target="#mod-warning' . $a[$j]["num_pedido"] . '"><i class="fa fa-times"></i></a>
											  	</td>
							    		  	</tr>';
                    break;
                
                case "Aprovado":
                    $em = $this->Purchase->get_supplier_info(($a[$j]["fornecedor"]));
                    $ema = $em->result();
                    $email = $ema[0]->email;
                    $tel = $ema[0]->phone_number;
                    $data["table_pc"] .= '<tr>
		    		  					<td>' . $a[$j]["num_pedido"] . '</td>
		    		  					<td class="text-center">' . ($a[$j]["departamento"]) . '</td>
		    		  					<td class="text-center">' . ($a[$j]["fornecedor"]) . '</td>
					    		  	<td class="text-center">' . date('d/m/Y h:m', strtotime($a[$j]["data"])) . '</td>
							    		  			<td class="text-center"><label class="label label-success">' . ($a[$j]["situacao"]) . '</label></td><td>
      								<!-- Modal -->
		    		  					<div class="modal fade colored-header" id="mod-info" tabindex="-1" role="dialog">
											<div class="modal-dialog">
													' . form_open('pclista/send/' . $a[$j]["num_pedido"]) . '
										  			<div class="modal-content">
														<div class="modal-header">
															<h3>Realizar pedido ' . $a[$j]["num_pedido"] . ' ?</h3>
																			<button type="button" class="close md-close" data-dismiss="modal" aria-hidden="true" style="margin-top: -30px;">&times;</button>																</div>
																					<div class="modal-body">
																<div class="form-group">
																	<label><h4>Fornecedor: ' . ($a[$j]["fornecedor"]) . '</h4></label>
																</div>
																<div class="form-group">
																	<h5><strong>Telefones: ' . $tel . '</strong></h5>
																							<h5><strong>Email: ' . $email . '</strong></h5>
																</div><br>
																<input type="checkbox" name="tel" value="1"> Contatar por telefone.<br>
																<input type="checkbox" name="email" value="1">  Enviar pedido por email.
															</div>
															<div class="modal-footer">
															  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
															  <button type="submit" class="btn btn-primary">Realizar pedido</button>
															</div>
													  	</div><!-- /.modal-content -->
												  	' . form_close() . '
												</div><!-- /.modal-dialog -->
											</div>
										<!-- /.modal -->
      									<center>
      								  		<a href="#" onclick="return window.open(\'' . $this->config->site_url('pclista/info/' . $a[$j]["num_pedido"]) . '\',\'Informa��o do Pedido\',\'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=50, LEFT=70,width=770,height=500\');" class="label label-primary"  data-original-title="Visualizar Pedido" data-toggle="tooltip" data-placement="top"><i class="fa fa-search"></i></a>
      								  		<a href="" class="label label-info" data-toggle="modal" title="Realizar pedido" data-target="#mod-info"><i class="fa fa-check"></i></a>
      								  		<!-- Modal -->
													<div class="modal fade" id="mod-warning' . $a[$j]["num_pedido"] . '" tabindex="-1" role="dialog">
														<div class="modal-dialog">
													' . form_open("pclista/deleteall/" . $a[$j]["num_pedido"]) . '
		      								  				<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
														</div>
														<div class="modal-body">
															<div class="text-center">
																<div class="i-circle warning"><i class="fa fa-warning"></i></div>
																<h4>Aviso!</h4>
																<p>Você deseja realmente deletar o pedido ' . $a[$j]["num_pedido"] . ' ?</p>
															</div>
														</div>
														<div class="modal-footer">
														  <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
														  <a href="' . site_url('pclista/deleteall/' . $a[$j]["num_pedido"]) . '" type="submit" class="btn btn-warning">Deletar</a>
														</div>
													  </div><!-- /.modal-content -->
		      								  				' . form_close() . '
		      								  				</div><!-- /.modal-dialog -->
												  </div><!-- /.modal -->
												  <a href="" class="label label-danger" data-toggle="modal" title="Deletar pedido" data-target="#mod-warning' . $a[$j]["num_pedido"] . '"><i class="fa fa-times"></i></a></center></td>
      						</tr>';
                    
                    break;
                
                case "Pedido":
                    $data["table_pc"] .= '<tr>';
                    if ($a[$j]["nfe_num_nota"]) {
                        $data["table_pc"] .= '<td>' . $a[$j]["num_pedido"] . ' - ' . $a[$j]["nfe_num_nota"] . '</td>';
                    } else {
                        $data["table_pc"] .= '<td>' . $a[$j]["num_pedido"] . '</td>';
                    }
                    
                    $data["table_pc"] .= '
		<td class="text-center">' . ($a[$j]["departamento"]) . '</td>
		<td class="text-center">' . ($a[$j]["fornecedor"]) . '</td>
				<td class="text-center">' . date('d/m/Y h:m', strtotime($a[$j]["data"])) . '</td>
		<td class="text-center"><label class="label label-info">' . ($a[$j]["situacao"]) . '</label></td>
				<td><center>
					    	  			<a href="#" onclick="return window.open(\'' . $this->config->site_url('pclista/info/' . $a[$j]["num_pedido"]) . '\',\'Informação do Pedido\',\'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=50, LEFT=70,width=770,height=500\');" class="label label-primary"  data-original-title="Visualizar Pedido" data-toggle="tooltip" data-placement="top"><i class="fa fa-search"></i></a>';
                    
                    if ($a[$j]["nfe_num_nota"]) {
                        $data["table_pc"] .= ' <a href="' . site_url('pcentrada/index/' . $a[$j]["num_pedido"]) . '" class="label label-warning" data-original-title="Realizar entrada do pedido" data-toggle="tooltip" data-placement="top"><i class="fa fa-folder-open"></i></a>';
                    } else {
                        $data["table_pc"] .= ' <a onclick="return window.open(\'' . $this->config->site_url('pclista/import/' . $a[$j]["num_pedido"]) . '\',\'Importação de Nota fiscal Eletônica\',\'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=50, LEFT=70,width=910,height=500\');" href="" class="label label-info" data-original-title="Associar NF-e ao pedido" data-toggle="tooltip" data-placement="top"><i class="fa fa-download"></i></a>';
                    }
                    
                    $data["table_pc"] .= '
		    	  				<!-- Modal -->
								  <div class="modal fade" id="mod-warning' . $a[$j]["num_pedido"] . '" tabindex="-1" role="dialog">
									<div class="modal-dialog">
									' . form_open("pclista/deleteall/" . $a[$j]["num_pedido"]) . '
									  <div class="modal-content">
											  <div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													</div>
										<div class="modal-body">
											<div class="text-center">
															<div class="i-circle warning"><i class="fa fa-warning"></i></div>
												<h4>Aviso!</h4>
												<p>Você deseja realmente deletar o pedido ' . $a[$j]["num_pedido"] . ' ?</p>
											</div>
										</div>
										<div class="modal-footer">
										  <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
										  <a href="' . site_url('pclista/deleteall/' . $a[$j]["num_pedido"]) . '" type="submit" class="btn btn-warning">Deletar</a>
																	</div>
																	</div><!-- /.modal-content -->
									  ' . form_close() . '
									</div><!-- /.modal-dialog -->
								  </div><!-- /.modal -->
								<a href="" class="label label-danger" data-toggle="modal" title="Deletar pedido" data-target="#mod-warning' . $a[$j]["num_pedido"] . '"><i class="fa fa-times"></i></a></center></td>
					    	 </tr>';
                    break;
                
                default:
                    $data["table_pc"] .= '<tr>
    		  					<td>' . $a[$j]["num_pedido"] . '</td>
    		  					<td colspan="5">Erro ao montar Ação</td>
    		  				</tr>';
                    break;
            }
        }
        
        $this->load->view('purchases/situacao', $data);
    }

    function writeNFe($pedido)
    {
        $data['infos'] = $this->Purchase->busca_Forn_Date_Dept($pedido);
        $data['pedido'] = $pedido;
        $data['table'] = '';
        $resultado3 = $this->Purchase->db_list_itens($pedido);
        $enc = $resultado3->result_array();
        
        for ($ii = 0; $ii < $resultado3->num_rows(); $ii ++) {
            $data['table'] .= '<tr>
					<td><input type="text" class="form-control" name="cprod[' . $ii . ']" required="required"></td>
					<td><input type="hidden" class="form-control" name="idproduto[' . $ii . ']" value="' . $enc[$ii]["produto"] . '" required="required">' . $this->Purchase->retorna_name($enc[$ii]["produto"]) . '</td>
					<td class="text-right">' . $enc[$ii]["quantidade"] . '</td>
					<td title="Preencha corretamente no seguinte formato padrão: 0.0000" class="text-right"><input type="text" data-toggle="tooltip" data-original-title="Preencha corretamente no seguinte formato padrão: 0.0000" class="form-control" dir="rtl" data-mask="#####0.0000" data-mask-reverse="true" value="' . $enc[$ii]["valorunit"] . '" name="vunit[' . $ii . ']" required="required"></td>
				</tr>';
        }
        
        $data['pedido'] = $pedido;
        $data['infos'] = $this->Purchase->busca_Forn_Date_Dept($pedido);
        
        $this->load->view('purchases/writeNFe', $data);
    }

    function associa_nfe()
    {
        $post_chave = $this->input->post("chave");
        
        if ($post_chave == '' or $post_chave == ' ') {
            $chave = '';
        } else {
            $a = explode(' ', $this->input->post("chave"));
            $chave = $a[0] . $a[1] . $a[2] . $a[3] . $a[4] . $a[5] . $a[6] . $a[7] . $a[8] . $a[9] . $a[10];
        }
        
        $data = array(
            'chave' => $chave,
            'number' => $this->input->post('number'),
            'serie' => $this->input->post('serie'),
            'bc_icms' => $this->input->post('bc_icms'),
            'val_icms' => $this->input->post('val_icms'),
            'bc_icms_st' => $this->input->post('bc_icms_st'),
            'val_icms_sub' => $this->input->post('val_icms_sub'),
            'val_imp_imp' => $this->input->post('val_imp_imp'),
            'pis' => $this->input->post('pis'),
            'val_total' => $this->input->post('val_total'),
            'frete' => $this->input->post('frete'),
            'seguro' => $this->input->post('seguro'),
            'desconto' => $this->input->post('desconto'),
            'despesas' => $this->input->post('despesas'),
            'val_ipi' => $this->input->post('val_ipi'),
            'val_cofins' => $this->input->post('val_cofins'),
            'val_total_nota' => $this->input->post('val_total_nota'),
            'pedido' => $this->input->post('pedido')
        );
        
        $this->Purchase->insert_nfe($data);
        
        // Atualizar na ntic_purch_request
        $this->Purchase->update_purch_nfe(array(
            'nfe_chave' => $chave,
            'nfe_num_nota' => $this->input->post('number')
        ), $this->input->post('pedido'));
        
        $c = count($this->input->post("idproduto"));
        
        for ($i = 0; $i < $c; $i ++) {
            $fornecedor = $this->Purchase->busca_Forn_Date_Dept($this->input->post('pedido'))[0]['fornecedor'];
            $id_fornecedor = $this->Purchase->fornecedor_getnumero($fornecedor);
            
            $data2 = array(
                'id_produto' => $this->input->post('idproduto')[$i],
                'cod_prod_forn' => $this->input->post('cprod')[$i],
                'vunit' => $this->input->post('vunit')[$i],
                'pedido' => $this->input->post('pedido')
            );
            
            $this->Purchase->insert_nfe_itens($data2);
            
            // Atualiza preço de custo: #######
            $business = $this->Purchase->verifica_preco($this->input->post('idproduto')[$i]);
            
            if ($business->num_rows() != 0) {
                if ($business->row()->cost_of_last_purchase >= $business->row()->cost_purchese) {
                    $this->Purchase->seta_preco(array(
                        'cost_of_last_purchase' => $this->input->post('vunit')[$i],
                        'cost_purchese' => $this->input->post('vunit')[$i],
                        'supplier_id' => $id_fornecedor
                    ), $this->input->post('idproduto')[$i]);
                } else {
                    $this->Purchase->seta_preco(array(
                        'cost_of_last_purchase' => $this->input->post('vunit')[$i],
                        'supplier_id' => $id_fornecedor
                    ), $this->input->post('idproduto')[$i]);
                }
            } else {
                $this->Purchase->create_preco(array(
                    'item_id' => $this->input->post('idproduto')[$i],
                    'supplier_id' => $id_fornecedor,
                    'cost_of_last_purchase' => $this->input->post('vunit')[$i],
                    'cost_purchese' => $this->input->post('vunit')[$i],
                    'selling_price' => '0.00',
                    'markup' => 0,
                    'markup_practiced' => 0
                ));
            }
            
            // #################################
        }
        
        echo '<script>window.opener.location.reload(true)</script>
			  <script>window.close()</script>';
    }
}

?>