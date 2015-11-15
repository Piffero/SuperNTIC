<?php
require_once ("secure_area.php");
date_default_timezone_set('Brazil/East');

class Oslista extends Secure_area
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
                    $data['lista'] .= '<td class="text-center"><span class="label label-primary" data-original-title="OS Recêm criada" data-toggle="tooltip" data-placement="right">Aberta</span></td>';
                    $data['lista'] .= '<td class="text-center">
														  		' . date('d/m/Y h:i', strtotime($n->DTABERTURA)) . '
											  				</td>';
                    $data['lista'] .= '<td class="text-center">
															<!-- Modal -->
																<div class="modal fade" id="mod-warning' . $n->idOS . '" tabindex="-1" role="dialog">
																	<div class="modal-dialog">
																		' . form_open('oslista/cancela_os/' . $n->idOS) . '
																		<div class="modal-content">
																			<div class="modal-header">
																				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																			</div>
																			<div class="modal-body">
																				<div class="text-center">
																					<div class="i-circle warning"><i class="fa fa-warning"></i></div>
																					<h4>Cancelar?</h4>
																					<p>Você tem certeza que deseja cancelar a Ordem de Serviço ' . $n->idOS . '?</p><br />
																					Especificar motivo:
																				</div>
																				<textarea class="form-control" required="required" name="motivo"></textarea>
																			</div>
																			<div class="modal-footer">
																			  <button type="submit" name="del" value=""class="btn btn-warning" >Cancelar!</button>
																			  <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
																		 	</div>
																  	 	</div><!-- /.modal-content -->
																		' . form_close() . '
																	</div><!-- /.modal-dialog --> 
															  	</div><!-- /.modal -->
														 		<!-- Modal -->
																<!-- Modal -->
																	  <div class="modal fade" id="mod-info90' . $n->idOS . '" tabindex="-1" role="dialog">
																		<div class="modal-dialog">
																		  <div class="modal-content">
																			<div class="modal-header">
																				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																			</div>
																			' . form_open('oslista/lancamento') . '
																			<div class="modal-body">
																				<div class="text-center">
																					<div class="i-circle primary"><i class="fa fa-check"></i></div>
																					<h4>O.S. Nº ' . $n->idOS . '</h4>
																					<p>Qual é o valor do lançamento que deseja fazer? (R$)</p>
																					<center><input type="text" placeholder="0.00" name="valor" class="form-control" style="width:300px;" data-mask="####0.00" data-mask-reverse="true"></center>
																				</div>
																			</div>
																			
																			<div class="modal-footer">
																			  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
																			  <button type="submit" name="idOS" value="' . $n->idOS . '" class="btn btn-primary">Lançar</button>
																			</div>
																			' . form_close() . '
																		  </div><!-- /.modal-content -->
																		</div><!-- /.modal-dialog -->
																	  </div><!-- /.modal -->
										
											 					<a class="label label-default"><i class="fa fa-check"></i></a> 
																<a href="' . site_url('viewos/index/' . $n->idOS) . '" data-original-title="Visualizar OS" data-toggle="tooltip" data-placement="top" class="label label-primary" name="acao"><i class="fa fa-search"></i></a> 
															 	<a href="" title="Fazer lançamento parcial de pagamento" data-toggle="modal" data-modal="mod-info90' . $n->idOS . '" data-target="#mod-info90' . $n->idOS . '" class="label label-info md-trigger" alt="Cancelar OS"><i class="fa fa-usd"></i></a>
																<a href="' . site_url('osdefects/edit/' . $n->idOS) . '" data-original-title="Editar OS" data-toggle="tooltip" data-placement="top" class="label label-warning" name="acao" href="#"><i class="fa fa-pencil"></i></a>															 			
																<a href="" title="Cancelar OS" data-toggle="modal" data-target="#mod-warning' . $n->idOS . '" data-placement="top" class="label label-danger" alt="Cancelar OS" class="label label-danger"><i class="fa fa-times"></i></a>
														  </td>';
                    break;
                
                case 'Em analise':
                    
                    $data['lista'] .= '<td class="text-right color-success"><center><span data-original-title="Técnico analisando o produto" data-toggle="tooltip" data-placement="right" class="label label-default">Em Análise</span></center></td>';
                    $data['lista'] .= '<td class="text-center">
																' . date('d/m/Y h:i', strtotime($n->DTABERTURA)) . '
														  </td>';
                    $data['lista'] .= '<td class="text-center">
											 	<a class="label label-default"><i class="fa fa-check"></i></a> 
												<a href="' . site_url('viewos/index/' . $n->idOS) . '" data-original-title="Visualizar OS" data-toggle="tooltip" data-placement="top" class="label label-primary" name="acao"><i class="fa fa-search"></i></a> 
												<a href="" title="Fazer lançamento parcial de pagamento" data-toggle="modal" data-modal="mod-info90' . $n->idOS . '" data-target="#mod-info90' . $n->idOS . '" class="label label-info md-trigger" alt="Cancelar OS"><i class="fa fa-usd"></i></a>
												<a onclick="return call(\'' . $n->idOS . '\');" data-original-title="Ligar para o cliente" data-toggle="tooltip" data-placement="top" class="label label-warning" name="acao" href="#"><i class="fa fa-phone"></i></a>
														
														<!-- Modal -->
																<div class="modal fade" id="mod-warning' . $n->idOS . '" tabindex="-1" role="dialog">
																	<div class="modal-dialog">
																		' . form_open('oslista/cancela_os/' . $n->idOS) . '
																		<div class="modal-content">
																			<div class="modal-header">
																				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																			</div>
																			<div class="modal-body">
																				<div class="text-center">
																					<div class="i-circle warning"><i class="fa fa-warning"></i></div>
																					<h4>Cancelar?</h4>
																					<p>Você tem certeza que deseja cancelar a Ordem de Serviço ' . $n->idOS . '?</p><br />
																					Especificar motivo:
																				</div>
																				<textarea class="form-control" required="required" name="motivo"></textarea>
																			</div>
																			<div class="modal-footer">
																			  <button type="submit" name="del" value=""class="btn btn-warning" >Cancelar!</button>
																			  <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
																		 	</div>
																  	 	</div><!-- /.modal-content -->
																		' . form_close() . '
																	</div><!-- /.modal-dialog --> 
															  	</div><!-- /.modal -->
														 		<!-- Modal -->
													  		
														 <!-- Modal -->
												 	<!-- Modal -->
													  <div class="modal fade" id="mod-info90' . $n->idOS . '" tabindex="-1" role="dialog">
														<div class="modal-dialog">
														  <div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															</div>
															' . form_open('oslista/lancamento') . '
															<div class="modal-body">
																<div class="text-center">
																	<div class="i-circle primary"><i class="fa fa-check"></i></div>
																	<h4>O.S. Nº ' . $n->idOS . '</h4>
																	<p>Qual é o valor do lançamento que deseja fazer? (R$)</p>
																	<center><input type="text" placeholder="0.00" name="valor" class="form-control" style="width:300px;" data-mask="####0.00" data-mask-reverse="true"></center>
																</div>
															</div>
															
															<div class="modal-footer">
															  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
															  <button type="submit" name="idOS" value="' . $n->idOS . '" class="btn btn-primary">Lançar</button>
															</div>
															' . form_close() . '
														  </div><!-- /.modal-content -->
														</div><!-- /.modal-dialog -->
													  </div><!-- /.modal -->
											 	
											 	
											 	<a  href=""  title="Cancelar OS" data-toggle="modal" data-target="#mod-warning' . $n->idOS . '" data-placement="top" class="label label-danger" alt="Cancelar OS" class="label label-danger"><i class="fa fa-times"></i></a>
 										</td>';
                    
                    break;
                
                case 'Contactando':
                    
                    $data['lista'] .= '<td class="text-right color-success"><center><span data-original-title="Entrar(ando) em contato com o cliente" data-toggle="tooltip" data-placement="right" class="label label-warning">Contatando</span></center></td>';
                    $data['lista'] .= '<td class="text-center">
																' . date('d/m/Y h:i', strtotime($n->DTABERTURA)) . '
														  </td>';
                    $data['lista'] .= '<td class="text-center">
											 	<a href="#" title="Aprovar OS" data-toggle="modal" data-placement="top" class="label label-success" data-target="#mod-warning4' . $n->idOS . '" alt="Aprovar OS" class="label label-success"><i class="fa fa-thumbs-up"></i></a>
												<a href="' . site_url('viewos/index/' . $n->idOS) . '" data-original-title="Visualizar OS" data-toggle="tooltip" data-placement="top" class="label label-primary" name="acao" value="ANALISE$OSID" href="view.php?idOS=$OSID"><i class="fa fa-search"></i></a> 
												<a href="" title="Fazer lançamento parcial de pagamento" data-toggle="modal" data-modal="mod-info90' . $n->idOS . '" data-target="#mod-info90' . $n->idOS . '" class="label label-info md-trigger" alt="Cancelar OS"><i class="fa fa-usd"></i></a>											 	
												<a onclick="return call(\'' . $n->idOS . '\');" data-original-title="Ligar para o cliente" data-toggle="tooltip" data-placement="top" class="label label-warning" name="acao" href="#"><i class="fa fa-phone"></i></a>
														<!-- Modal -->
																<div class="modal fade" id="mod-warning' . $n->idOS . '" tabindex="-1" role="dialog">
																	<div class="modal-dialog">
																		' . form_open('oslista/recusar/' . $n->idOS) . '
																		<div class="modal-content">
																			<div class="modal-header">
																				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																			</div>
																			<div class="modal-body">
																				<div class="text-center">
																					<div class="i-circle warning"><i class="fa fa-warning"></i></div>
																					<h4>Recusar alterações?</h4>
																					<p>Você tem certeza que o cliente recusou as alterações nesta Ordem de Serviço (' . $n->idOS . ') ?</p><br />
																				</div>
																			</div>
																			<div class="modal-footer">
																			  <button type="submit" class="btn btn-warning" >Recusada</button>
																			  <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
																		 	</div>
																  	 	</div><!-- /.modal-content -->
																		' . form_close() . '
																	</div><!-- /.modal-dialog --> 
															  	</div><!-- /.modal -->
														 		<!-- Modal -->
											 	
											 	<a  href="" title="Recusar alterações da OS" data-toggle="modal" data-target="#mod-warning' . $n->idOS . '" data-placement="top" class="label label-danger" alt="Cancelar OS" class="label label-danger"><i class="fa fa-thumbs-down"></i></a>
															  														
											 		<!-- Modal -->
													  <div class="modal fade" id="mod-warning4' . $n->idOS . '" tabindex="-1" role="dialog">
														<div class="modal-dialog">
													  		' . form_open('oslista/aprova/' . $n->idOS) . '
														  <div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
															</div>
															<div class="modal-body">
																<div class="text-center">
																	<div class="i-circle warning"><i class="fa fa-warning"></i></div>
																	<h4>OS Aprovada pelo Cliente?</h4>
																	<p>Você tem certeza que deseja Aprovar essa Ordem de Serviço?</p><br />
																	
																</div>
																
															</div>
															<div class="modal-footer">
															
															  <button type="submit" class="btn btn-success" >Aprovar!</button>
															  <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
															</form>
															  </div>
														  </div><!-- /.modal-content -->
													  		' . form_close() . '
														</div><!-- /.modal-dialog --> 
													  </div><!-- /.modal -->
													  
												 <!-- Modal -->
										  		<!-- Modal -->
														  <div class="modal fade" id="mod-info90' . $n->idOS . '" tabindex="-1" role="dialog">
															<div class="modal-dialog">
															  <div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																</div>
																' . form_open('oslista/lancamento') . '
																<div class="modal-body">
																	<div class="text-center">
																		<div class="i-circle primary"><i class="fa fa-check"></i></div>
																		<h4>O.S. Nº ' . $n->idOS . '</h4>
																		<p>Qual é o valor do lançamento que deseja fazer? (R$)</p>
																		<center><input type="text" placeholder="0.00" name="valor" class="form-control" style="width:300px;" data-mask="####0.00" data-mask-reverse="true"></center>
																	</div>
																</div>
																
																<div class="modal-footer">
																  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
																  <button type="submit" name="idOS" value="' . $n->idOS . '" class="btn btn-primary">Lançar</button>
																</div>
																' . form_close() . '
															  </div><!-- /.modal-content -->
															</div><!-- /.modal-dialog -->
														  </div><!-- /.modal -->
											  </td>';
                    
                    break;
                
                case 'Aprovada':
                    $data['lista'] .= '<td class="text-right color-success"><center><span data-original-title="OS Confirmada pelo cliente para mudanças" data-toggle="tooltip" data-placement="right" class="label label-lucas">Aprovada</span></center></td>';
                    $data['lista'] .= '<td  class="text-center">' . date('d/m/Y h:i', strtotime($n->DTABERTURA)) . '</td>';
                    $data['lista'] .= '<td class="text-center">
											 	
											 	<a class="label label-default"><i class="fa fa-check"></i></a> 
												<a href="' . site_url('viewos/index/' . $n->idOS) . '" data-original-title="Visualizar OS" data-toggle="tooltip" data-placement="top" class="label label-primary" name="acao" ><i class="fa fa-search"></i></a> 
												<a href="" title="Fazer lançamento parcial de pagamento" data-toggle="modal" data-modal="mod-info90' . $n->idOS . '" data-target="#mod-info90' . $n->idOS . '" class="label label-info md-trigger" alt="Cancelar OS"><i class="fa fa-usd"></i></a>
												<a onclick="return call(\'' . $n->idOS . '\');" data-original-title="Ligar para o cliente" data-toggle="tooltip" data-placement="top" class="label label-warning" name="acao" href="#"><i class="fa fa-phone"></i></a>
												<!-- Modal -->
													<div class="modal fade" id="mod-warning' . $n->idOS . '" tabindex="-1" role="dialog">
														<div class="modal-dialog">
															' . form_open('oslista/cancela_os/' . $n->idOS) . '
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																</div>
																<div class="modal-body">
																	<div class="text-center">
																		<div class="i-circle warning"><i class="fa fa-warning"></i></div>
																		<h4>Cancelar?</h4>
																		<p>Você tem certeza que deseja cancelar a Ordem de Serviço ' . $n->idOS . '?</p><br />
																		Especificar motivo:
																	</div>
																	<textarea class="form-control" required="required" name="motivo"></textarea>
																</div>
																<div class="modal-footer">
																  <button type="submit" name="del" value="" class="btn btn-warning" >Cancelar!</button>
																  <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
															 	</div>
													  	 	</div><!-- /.modal-content -->
															' . form_close() . '
														</div><!-- /.modal-dialog --> 
												  	</div><!-- /.modal -->
											 	<!-- Modal -->
												<!-- Modal -->
														  <div class="modal fade" id="mod-info90' . $n->idOS . '" tabindex="-1" role="dialog">
															<div class="modal-dialog">
															  <div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																</div>
																' . form_open('oslista/lancamento') . '
																<div class="modal-body">
																	<div class="text-center">
																		<div class="i-circle primary"><i class="fa fa-check"></i></div>
																		<h4>O.S. Nº ' . $n->idOS . '</h4>
																		<p>Qual é o valor do lançamento que deseja fazer? (R$)</p>
																		<center><input type="text" placeholder="0.00" name="valor" class="form-control" style="width:300px;" data-mask="####0.00" data-mask-reverse="true"></center>
																	</div>
																</div>
																
																<div class="modal-footer">
																  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
																  <button type="submit" name="idOS" value="' . $n->idOS . '" class="btn btn-primary">Lançar</button>
																</div>
																' . form_close() . '
															  </div><!-- /.modal-content -->
															</div><!-- /.modal-dialog -->
														  </div><!-- /.modal -->
												 	
											 	<a  href="" title="Cancelar OS" data-toggle="modal" data-target="#mod-warning' . $n->idOS . '" data-placement="top" class="label label-danger" alt="Cancelar OS" class="label label-danger"><i class="fa fa-times"></i></a>
 												
												 	
												 </td>';
                    break;
                
                case 'Recusada': //
                                  //
                                  //
                    $data['lista'] .= '<td><label data-original-title="OS Recusada pelo cliente para mudanças" data-toggle="tooltip" data-placement="right" class="label label-danger">Recusada</label></td>';
                    $data['lista'] .= '<td  class="text-center">' . date('d/m/Y h:i', strtotime($n->DTABERTURA)) . '</td>';
                    $data['lista'] .= '<td class="text-center">
																<a class="label label-default"><i class="fa fa-check"></i></a> 
																<a href="' . site_url('viewos/index/' . $n->idOS) . '" data-original-title="Visualizar OS" data-toggle="tooltip" data-placement="top" class="label label-primary" name="acao" ><i class="fa fa-search"></i></a> 
																<a href="" title="Fazer lançamento parcial de pagamento" data-toggle="modal" data-modal="mod-info90' . $n->idOS . '" data-target="#mod-info90' . $n->idOS . '" class="label label-info md-trigger" alt="Cancelar OS"><i class="fa fa-usd"></i></a>
																<a onclick="return call(\'' . $n->idOS . '\');" data-original-title="Ligar para o cliente" data-toggle="tooltip" data-placement="top" class="label label-warning" name="acao" href="#"><i class="fa fa-phone"></i></a>
																<a  href="" title="Cancelar OS" data-toggle="modal" data-target="#mod-warning' . $n->idOS . '" data-placement="top" class="label label-danger" alt="Cancelar OS" class="label label-danger"><i class="fa fa-times"></i></a>
															
																<!-- Modal -->
																  <div class="modal fade" id="mod-info90' . $n->idOS . '" tabindex="-1" role="dialog">
																	<div class="modal-dialog">
																	  <div class="modal-content">
																		<div class="modal-header">
																			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																		</div>
																		' . form_open('oslista/lancamento') . '
																		<div class="modal-body">
																			<div class="text-center">
																				<div class="i-circle primary"><i class="fa fa-check"></i></div>
																				<h4>O.S. Nº ' . $n->idOS . '</h4>
																				<p>Qual é o valor do lançamento que deseja fazer? (R$)</p>
																				<center><input type="text" placeholder="0.00" name="valor" class="form-control" style="width:300px;" data-mask="####0.00" data-mask-reverse="true"></center>
																			</div>
																		</div>
																		
																		<div class="modal-footer">
																		  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
																		  <button type="submit" name="idOS" value="' . $n->idOS . '" class="btn btn-primary">Lançar</button>
																		</div>
																		' . form_close() . '
																	  </div><!-- /.modal-content -->
																	</div><!-- /.modal-dialog -->
																  </div><!-- /.modal -->
																<!-- Modal -->
																<div class="modal fade" id="mod-warning' . $n->idOS . '" tabindex="-1" role="dialog">
																	<div class="modal-dialog">
																		' . form_open('oslista/cancela_os/' . $n->idOS) . '
																		<div class="modal-content">
																			<div class="modal-header">
																				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																			</div>
																			<div class="modal-body">
																				<div class="text-center">
																					<div class="i-circle warning"><i class="fa fa-warning"></i></div>
																					<h4>Cancelar?</h4>
																					<p>Você tem certeza que deseja cancelar a Ordem de Serviço ' . $n->idOS . '?</p><br />
																					Especificar motivo:
																				</div>
																				<textarea class="form-control" required="required" name="motivo"></textarea>
																			</div>
																			<div class="modal-footer">
																			  <button type="submit" name="del" value=""class="btn btn-warning" >Cancelar!</button>
																			  <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
																		 	</div>
																  	 	</div><!-- /.modal-content -->
																		' . form_close() . '
																	</div><!-- /.modal-dialog --> 
															  	</div><!-- /.modal -->
														 		<!-- Modal -->
																				
															</td>';
                    break;
                
                case 'Em andamento':
                    $data['lista'] .= '<td class="text-right color-success"><center><span data-original-title="Técnico executando eventuais mudanças" data-toggle="tooltip" data-placement="right" class="label label-info">Em andamento</span></center></td>';
                    $data['lista'] .= '<td class="text-center">
												' . date('d/m/Y h:i', strtotime($n->DTABERTURA)) . '
											  </td>';
                    $data['lista'] .= '<td class="text-center">
											 	<a class="label label-default"><i class="fa fa-check"></i></a> 
												<a href="' . site_url('viewos/index/' . $n->idOS) . '" data-original-title="Visualizar OS" data-toggle="tooltip" data-placement="top" class="label label-primary" name="acao"><i class="fa fa-search"></i></a> 
												<a href="" title="Fazer lançamento parcial de pagamento" data-toggle="modal" data-modal="mod-info90' . $n->idOS . '" data-target="#mod-info90' . $n->idOS . '" class="label label-info md-trigger" alt="Cancelar OS"><i class="fa fa-usd"></i></a>
												<a onclick="return call(\'' . $n->idOS . '\');" data-original-title="Ligar para o cliente" data-toggle="tooltip" data-placement="top" class="label label-warning" name="acao" href="#"><i class="fa fa-phone"></i></a>													
													<!-- Modal -->
														<div class="modal fade" id="mod-warning' . $n->idOS . '" tabindex="-1" role="dialog">
															<div class="modal-dialog">
																' . form_open('oslista/cancela_os/' . $n->idOS) . '
																<div class="modal-content">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																	</div>
																	<div class="modal-body">
																		<div class="text-center">
																			<div class="i-circle warning"><i class="fa fa-warning"></i></div>
																			<h4>Cancelar?</h4>
																			<p>Você tem certeza que deseja cancelar a Ordem de Serviço ' . $n->idOS . '?</p><br />
																			Especificar motivo:
																		</div>
																		<textarea class="form-control" required="required" name="motivo"></textarea>
																	</div>
																	<div class="modal-footer">
																	  <button type="submit" name="del" value=""class="btn btn-warning" >Cancelar!</button>
																	  <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
																 	</div>
														  	 	</div><!-- /.modal-content -->
																' . form_close() . '
															</div><!-- /.modal-dialog --> 
													  	</div><!-- /.modal -->
												 		<!-- Modal -->
												  
												<!-- Modal -->
												<!-- Modal -->
												  <div class="modal fade" id="mod-info90' . $n->idOS . '" tabindex="-1" role="dialog">
													<div class="modal-dialog">
													  <div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
														</div>
														' . form_open('oslista/lancamento') . '
														<div class="modal-body">
															<div class="text-center">
																<div class="i-circle primary"><i class="fa fa-check"></i></div>
																<h4>O.S. Nº ' . $n->idOS . '</h4>
																<p>Qual é o valor do lançamento que deseja fazer? (R$)</p>
																<center><input type="text" placeholder="0.00" name="valor" class="form-control" style="width:300px;" data-mask="####0.00" data-mask-reverse="true"></center>
															</div>
														</div>
														
														<div class="modal-footer">
														  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
														  <button type="submit" name="idOS" value="' . $n->idOS . '" class="btn btn-primary">Lançar</button>
														</div>
														' . form_close() . '
													  </div><!-- /.modal-content -->
													</div><!-- /.modal-dialog -->
												  </div><!-- /.modal -->
																
											 	<a href="" title="Cancelar OS" data-toggle="modal" data-target="#mod-warning' . $n->idOS . '" data-placement="top" class="label label-danger" alt="Cancelar OS" class="label label-danger"><i class="fa fa-times"></i></a>
											</td>';
                    break;
                
                case 'Fabrica':
                    $data['lista'] .= '<td class="text-center"><span data-original-title="Aparelho enviado para Fábrica" data-toggle="tooltip" data-placement="right" class="label label-black">Fábrica</span></td>';
                    $data['lista'] .= '<td class="text-center">
												' . date('d/m/Y h:i', strtotime($n->DTABERTURA)) . '
											  </td>';
                    $data['lista'] .= '<td class="text-center">
											 					<a href="#" data-original-title="Receber da fábrica" data-toggle="modal" data-placement="top" class="label label-success" data-target="#mod-warning12' . $n->idOS . '" alt="Aprovar OS"><i class="fa fa-sign-in"></i></a>
																<a href="' . site_url('viewos/index/' . $n->idOS) . '" data-original-title="Visualizar OS" data-toggle="tooltip" data-placement="top" class="label label-primary" name="acao"><i class="fa fa-search"></i></a> 
																<a href="" title="Fazer lançamento parcial de pagamento" data-toggle="modal" data-modal="mod-info90' . $n->idOS . '" data-target="#mod-info90' . $n->idOS . '" class="label label-info md-trigger" alt="Cancelar OS"><i class="fa fa-usd"></i></a>
																<a onclick="return call(\'' . $n->idOS . '\');" data-original-title="Ligar para o cliente" data-toggle="tooltip" data-placement="top" class="label label-warning" name="acao" href="#"><i class="fa fa-phone"></i></a>
																<a href=""  title="Cancelar OS" data-toggle="modal" data-target="#mod-warning' . $n->idOS . '" data-placement="top" class="label label-danger"><i class="fa fa-times"></i></a>
															
																<!-- Modal -->
																  <div class="modal fade" id="mod-warning12' . $n->idOS . '" tabindex="-1" role="dialog">
																	<div class="modal-dialog">
																	  ' . form_open('oslista/fabrica/' . $n->idOS) . '
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

																<!-- Modal -->
																<div class="modal fade" id="mod-warning' . $n->idOS . '" tabindex="-1" role="dialog">
																	<div class="modal-dialog">
																		' . form_open('oslista/cancela_os/' . $n->idOS) . '
																		<div class="modal-content">
																			<div class="modal-header">
																				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																			</div>
																			<div class="modal-body">
																				<div class="text-center">
																					<div class="i-circle warning"><i class="fa fa-warning"></i></div>
																					<h4>Cancelar?</h4>
																					<p>Você tem certeza que deseja cancelar a Ordem de Serviço ' . $n->idOS . '?</p><br />
																					Especificar motivo:
																				</div>
																				<textarea class="form-control" required="required" name="motivo"></textarea>
																			</div>
																			<div class="modal-footer">
																			  <button type="submit" name="del" value=""class="btn btn-warning" >Cancelar!</button>
																			  <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
																		 	</div>
																  	 	</div><!-- /.modal-content -->
																		' . form_close() . '
																	</div><!-- /.modal-dialog --> 
															  	</div><!-- /.modal -->
														 		<!-- Modal -->
																			
															</td>';
                    break;
                
                case 'Concluida':
                    $data['lista'] .= "<td class=\"text-center\"><span class=\"label label-success\" data-original-title=\"OS Esperando finalização\" data-toggle=\"tooltip\" data-placement=\"right\">Concluída</span></td>";
                    $data['lista'] .= '<td class="text-center">
																' . date('d/m/Y h:i', strtotime($n->DTABERTURA)) . '
														  </td>';
                    $data['lista'] .= '<td class="text-center">
										
										
											 	<a href="" onclick="return pgto(\'' . $n->idOS . '\');" data-original-title="Finalizar OS" data-toggle="tooltip" data-placement="top" alt="Finalizar OS" class="label label-success"><i class="fa fa-check"></i></a> 
 												<a href="' . site_url('viewos/index/' . $n->idOS) . '" data-original-title="Visualizar OS" data-toggle="tooltip" data-placement="top" class="label label-primary" name="acao" href="view.php?idOS=IDOSXX"><i class="fa fa-search"></i></a> 
												<a href="" title="Fazer lançamento parcial de pagamento" data-toggle="modal" data-modal="mod-info90' . $n->idOS . '" data-target="#mod-info90' . $n->idOS . '" class="label label-info md-trigger" alt="Cancelar OS"><i class="fa fa-usd"></i></a>
												<a onclick="return call(\'' . $n->idOS . '\');" data-original-title="Ligar para o cliente" data-toggle="tooltip" data-placement="top" class="label label-warning" name="acao" href="#"><i class="fa fa-phone"></i></a>												
														<!-- Modal -->
																<div class="modal fade" id="mod-warning' . $n->idOS . '" tabindex="-1" role="dialog">
																	<div class="modal-dialog">
																		' . form_open('oslista/cancela_os/' . $n->idOS) . '
																		<div class="modal-content">
																			<div class="modal-header">
																				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																			</div>
																			<div class="modal-body">
																				<div class="text-center">
																					<div class="i-circle warning"><i class="fa fa-warning"></i></div>
																					<h4>Cancelar?</h4>
																					<p>Você tem certeza que deseja cancelar a Ordem de Serviço ' . $n->idOS . '?</p><br />
																					Especificar motivo:
																				</div>
																				<textarea class="form-control" required="required" name="motivo"></textarea>
																			</div>
																			<div class="modal-footer">
																			  <button type="submit" name="del" value=""class="btn btn-warning" >Cancelar!</button>
																			  <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
																		 	</div>
																  	 	</div><!-- /.modal-content -->
																		' . form_close() . '
																	</div><!-- /.modal-dialog --> 
															  	</div><!-- /.modal -->
														 		<!-- Modal -->
												<!-- Modal -->
														  <div class="modal fade" id="mod-info90' . $n->idOS . '" tabindex="-1" role="dialog">
															<div class="modal-dialog">
															  <div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
																</div>
																' . form_open('oslista/lancamento') . '
																<div class="modal-body">
																	<div class="text-center">
																		<div class="i-circle primary"><i class="fa fa-check"></i></div>
																		<h4>O.S. Nº ' . $n->idOS . '</h4>
																		<p>Qual é o valor do lançamento que deseja fazer? (R$)</p>
																		<center><input type="text" placeholder="0.00" name="valor" class="form-control" style="width:300px;" data-mask="####0.00" data-mask-reverse="true"></center>
																	</div>
																</div>
																
																<div class="modal-footer">
																  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
																  <button type="submit" name="idOS" value="' . $n->idOS . '" class="btn btn-primary">Lançar</button>
																</div>
																' . form_close() . '
															  </div><!-- /.modal-content -->
															</div><!-- /.modal-dialog -->
														  </div><!-- /.modal -->
 														  														 	
											 	<a  href=""  title="Cancelar OS" data-toggle="modal" data-target="#mod-warning' . $n->idOS . '" data-placement="top" class="label label-danger" alt="Cancelar OS" class="label label-danger"><i class="fa fa-times"></i></a>
 											</td>';
                    
                    break;
                
                default:
                    $data['lista'] .= '<td colspan="3">Erro ao montar a "Situação" dessa tabela.</td>';
                    break;
            }
            
            $data['lista'] .= '</tr>';
        }
        
        $this->load->view('os/lista', $data);
    }

    function lancamento()
    {
        $data = array(
            'idOS' => $this->input->post("idOS"),
            'valor' => $this->input->post("valor")
        );
        
        if ($this->OrdemServico->lancamento($data)) {
            redirect("oslista");
        } else {
            $this->index('<div class="alert alert-danger">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">X</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Houve um problema ao inserir o Lançamento no Banco de Dados, 
					tente novamente. Se o problema persistir informe o <a onclick="window.open(\'http://187.49.235.3:1517/mibew/client.php?locale=pt-pt&style=silver', 'NTIC Suporte', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=400,height=440\'); href="#">suporte NTIC</a>.
				</div>');
        }
    }

    function call($idOS, $caller = null)
    {
        $data['idOS'] = $idOS;
        $data['info'] = $this->OrdemServico->get_info($idOS)->result_array();
        $data['caller'] = $caller;
        
        $data['manage_table_row'] = '';
        
        $resultado = $this->OrdemServico->lista_ocorrencia($idOS);
        $n = $resultado->result_array();
        
        for ($i = 0; $i < $resultado->num_rows(); $i ++) {
            $data['manage_table_row'] .= '<tr>
					<td>' . nl2br($n[$i]["ocorrencia"]) . '</td>
					<td class="text-right">R$ ' . $n[$i]["valor"] . '</td>
					<td>' . $n[$i]["funcionario"] . '</td>
					<td class="text-center">' . date('d/m/Y h:i', strtotime($n[$i]["data"])) . '</td>
	    		</tr>';
        }
        
        $this->load->view('os/call', $data);
    }

    function contato()
    {
        if ($this->input->post("contato") == '0') {
            $data = array(
                'idOS' => $this->input->post("idOS"),
                'descricao' => 'Tentativa de contato sem sucesso.',
                'contatado' => '0'
            );
            
            if ($this->OrdemServico->contato($data)) {
                $this->call($this->input->post("idOS"), "<script>opener.location.reload(); self.close()</script>");
            } else {
                $this->call($this->input->post("idOS"), "<script>alert('Erro ao atualizar o registro de contato, por favor informe o suporte NTIC sobre o erro');</script>");
            }
        } else {
            $data = array(
                'idOS' => $this->input->post("idOS"),
                'descricao' => $this->input->post("descricao"),
                'contatado' => '1'
            );
            
            if ($this->OrdemServico->contato($data)) {
                $this->call($this->input->post("idOS"), $caller['caller'] = "<script>opener.location.reload(); self.close()</script>");
            } else {
                $this->call($this->input->post("idOS"), $caller['caller'] = "<script>alert('Erro ao atualizar o registro de contato, por favor informe o suporte NTIC sobre o erro');</script>");
            }
        }
    }

    function cancela_os($idOS)
    {
        $data = array(
            'SITUACAO' => 'Finalizada',
            'motivo' => $this->input->post("motivo")
        );
        
        if ($this->OrdemServico->cancela_os($data, $idOS)) {
            $this->index('<div class="alert alert-success">
				<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
				<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
				Os ' . $idOS . ' Cancelada com sucesso.
				</div>');
        } else {
            $this->index('<div class="alert alert-danger">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">X</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Houve um problema ao tentar Cancelar a OS ' . $idOS . ' no Banco de Dados,  
					tente novamente. Se o problema persistir informe o <a onclick="window.open(\'http://187.49.235.3:1517/mibew/client.php?locale=pt-pt', 'NTIC Suporte', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=400,height=440\'); href="#">suporte NTIC</a>.
				</div>');
        }
    }

    function pgto($idOS)
    {
        $data['idOS'] = $idOS;
        
        $data['lista'] = '<table class="hover">
							<thead class="text-primary">
								<tr>
									<th>Valor</th><th>Data</th>
								</tr>
							</thead>
							<tbody>';
        
        $l = $this->OrdemServico->get_lancamentos_lista($idOS)->result_array();
        $num = $this->OrdemServico->get_lancamentos_lista($idOS)->num_rows();
        
        for ($i = 0; $i < $num; $i ++) {
            $data['lista'] .= '<tr><td class="text-right">R$ ' . $l[$i]['valor'] . '</td><td class="text-center">' . date('d/m/Y h:i', strtotime($l[$i]['data'])) . '</td></tr>';
        }
        
        $data['lista'] .= '</tbody>
						</table>';
        
        $data['manage_table_row'] = '<table class="hover">
				<thead class="color-primary">
					<tr>
						<th>Ocorrencia</th>
						<th class="text-right">Valor</th>
						<th class="text-center">Data</th>
					</tr>
				</thead>';
        $data['manage_table_row'] .= '<tbody>';
        
        $resultado = $this->OrdemServico->lista_ocorrencia($idOS);
        $n = $resultado->result_array();
        
        for ($g = 0; $g < $resultado->num_rows(); $g ++) {
            $data['manage_table_row'] .= '<tr>
					<td>' . nl2br($n[$g]["ocorrencia"]) . '</td>
					<td class="text-right">R$ ' . $n[$g]["valor"] . '</td>
					<td class="text-center">' . date('d/m/Y h:i', strtotime($n[$g]["data"])) . '</td>
	    		</tr>';
        }
        
        $data['manage_table_row'] .= '</tbody></table>';
        
        $data['soma_oc'] = $this->OrdemServico->soma_ocorrencia($idOS)->result_array();
        $data['soma_lan'] = $this->OrdemServico->soma_lancamentos($idOS)->result_array();
        $data['info'] = $this->OrdemServico->get_client_basic_infos($idOS)->result_array();
        
        $this->load->view('os/pgto', $data);
    }

    function pay()
    {
        $os = $this->input->post("os");
        $total = $this->input->post("total");
        $metodo = $this->input->post('metodo');
        $parcela = $this->input->post('parcela');
        $vparc = $this->input->post('vparc');
        $nome = $this->input->post('nome');
        $data = date('Y-m-d');
        
        echo '1 ';
        switch ($metodo) {
            case "dinheiro":
                $data = array(
                    'number' => $os,
                    'date' => date('Y-m-d'),
                    'favored' => $nome,
                    'operation' => '0',
                    'plan_accounts' => '01.01.01',
                    'payment_form' => 'Dinheiro',
                    'cost_center' => $total,
                    'value' => $total,
                    'historic' => 'Pagamento de Serviço'
                );
                
                if ($this->OrdemServico->pay_os($data)) {
                    $this->OrdemServico->change_os_situation($os, 'Finalizada');
                } else {
                    echo 'Erro ao inserir pagamento no Banco de Dados, contate o suporte NTIC e informe este erro.';
                    exit();
                }
                
                echo '<script>opener.location.reload();</script>';
                echo '<script>window.close();</script>';
                break;
            
            case "boleto":
                
                for ($i = 0; $i < $parcela; $i ++) {
                    $data = array(
                        'number' => $os,
                        'date' => date('Y-m-d', strtotime('+' . (30 * $i) . ' days')),
                        'favored' => $nome,
                        'operation' => '0',
                        'plan_accounts' => '01.01.01',
                        'payment_form' => 'Boleto',
                        'cost_center' => $vparc,
                        'value' => $vparc,
                        'historic' => 'Pagamento de Serviço'
                    );
                    
                    $this->OrdemServico->pay_os($data);
                    
                    $this->OrdemServico->change_os_situation($os, 'Finalizada');
                    echo '<script>opener.location.reload();</script>';
                    echo '<script>window.close();</script>';
                }
                break;
            
            case "cheque":
                for ($i = 0; $i < $parcela; $i ++) {
                    $data = array(
                        'number' => $os,
                        'date' => date('Y-m-d', strtotime('+' . (30 * $i) . ' days')),
                        'favored' => $nome,
                        'operation' => '0',
                        'plan_accounts' => '01.01.01',
                        'payment_form' => 'Cheque',
                        'cost_center' => $vparc,
                        'value' => $vparc,
                        'historic' => 'Pagamento de Serviço'
                    );
                    
                    $this->OrdemServico->pay_os($data);
                    
                    $this->OrdemServico->change_os_situation($os, 'Finalizada');
                    echo '<script>opener.location.reload();</script>';
                    echo '<script>window.close();</script>';
                }
                break;
            
            case "cartaodeb":
                $data = array(
                    'number' => $os,
                    'date' => date('Y-m-d'),
                    'favored' => $nome,
                    'operation' => '0',
                    'plan_accounts' => '01.01.01',
                    'payment_form' => 'Cartão: Débito',
                    'cost_center' => $total,
                    'value' => $total,
                    'historic' => 'Pagamento de Serviço'
                );
                
                if ($this->OrdemServico->pay_os($data)) {
                    $this->OrdemServico->change_os_situation($os, 'Finalizada');
                } else {
                    echo 'Erro ao inserir pagamento no Banco de Dados, contate o suporte NTIC e informe este erro.';
                    exit();
                }
                
                echo '<script>opener.location.reload();</script>';
                
                echo '<script>window.close();</script>';
                break;
            
            case "cartaocred":
                for ($i = 1; $i <= $parcela; $i ++) {
                    
                    if ($i == 1) {
                        
                        if (settype(date('d'), 'integer') < 23) {
                            
                            $data = array(
                                'number' => $os,
                                'date' => date('Y-m', strtotime('+' . ($i) . ' month')) . '-10',
                                'favored' => $nome,
                                'operation' => '0',
                                'plan_accounts' => '01.01.01',
                                'payment_form' => 'Cartão: Crédito',
                                'cost_center' => $vparc,
                                'value' => $vparc,
                                'historic' => 'Pagamento de Serviço'
                            );
                            
                            $this->OrdemServico->pay_os($data);
                        } else {
                            $data = array(
                                'number' => $os,
                                'date' => date('Y-m', strtotime('+' . (1 + $i) . ' months')) . '-10',
                                'favored' => $nome,
                                'operation' => '0',
                                'plan_accounts' => '01.01.01',
                                'payment_form' => 'Cartão: Crédito',
                                'cost_center' => $vparc,
                                'value' => $vparc,
                                'historic' => 'Pagamento de Serviço'
                            );
                            
                            $this->OrdemServico->pay_os($data);
                        }
                    } else {
                        $data = array(
                            'number' => $os,
                            'date' => date('Y-m', strtotime('+' . (1 + $i) . ' months')) . '-10',
                            'favored' => $nome,
                            'operation' => '0',
                            'plan_accounts' => '01.01.01',
                            'payment_form' => 'Cartão: Crédito',
                            'cost_center' => $vparc,
                            'value' => $vparc,
                            'historic' => 'Pagamento de Serviço'
                        );
                        $this->OrdemServico->pay_os($data);
                    }
                    
                    $this->OrdemServico->change_os_situation($os, 'Finalizada');
                    echo '<script>opener.location.reload();</script>';
                    echo '<script>window.close();</script>';
                }
                break;
            
            default:
                echo 'Houve um erro ao inserir a conta na tabela do banco. 
					  O método de pagamento não inseriu ou é inválido. 
					  Por favor contate o suporte NTIC.';
                break;
                exit();
        }
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

    function aprova($idOS)
    {
        if ($this->OrdemServico->change_os_situation($idOS, 'Aprovada')) {
            $this->index('<div class="alert alert-success">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">X</button>
					<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
					A OS Nº ' . $idOS . ' Foi aprovada pelo Cliente!
				</div>');
        } else {
            $this->index('<div class="alert alert-danger">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">X</button>
					<i class="fa fa-check sign"></i><strong>Erro!</strong>
					Houve um problema ao atualizar o registro no banco de dados. OS Nº ' . $idOS . '. Informe o Suporte NTIC sobre esse erro.
				</div>');
        }
    }

    function recusar($idOS)
    {
        if ($this->OrdemServico->change_os_situation($idOS, 'Recusada')) {
            $this->index('<div class="alert alert-info">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">X</button>
					<i class="fa fa-check sign"></i><strong>Operação sucedida.</strong>
					A OS Nº ' . $idOS . ' foi reprovada pelo cliente.
				</div>');
        } else {
            $this->index('<div class="alert alert-danger">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">X</button>
					<i class="fa fa-check sign"></i><strong>Erro!</strong>
					Houve um problema ao atualizar o registro no banco de dados. OS Nº ' . $idOS . '. Informe o Suporte NTIC sobre esse erro.
				</div>');
        }
    }

    function recibo($idOS)
    {
        setlocale(LC_MONETARY, 'pt_BR');
        
        date_default_timezone_set("Brazil/East");
        
        $data['idOS'] = $idOS;
        $data['manage_table_row'] = '';
        
        $data['soma_oc'] = $this->OrdemServico->soma_ocorrencia($idOS)->result_array();
        $data['soma_lan'] = $this->OrdemServico->soma_lancamentos($idOS)->result_array();
        
        $resultado = $this->OrdemServico->lista_ocorrencia($idOS);
        $n = $resultado->result_array();
        
        $data['laudo'] = $this->General->select("laudo", "os", array(
            "idOS" => $idOS
        ))->row()->laudo;
        
        for ($i = 0; $i < $resultado->num_rows(); $i ++) {
            $data['manage_table_row'] .= '<tr>
					<td>' . nl2br($n[$i]["ocorrencia"]) . '</td>
					<td class="text-right">R$ ' . $n[$i]["valor"] . '</td>
					<td class="text-center">R$ ' . date('d/m/Y', strtotime($n[$i]["data"])) . '</td>
	    		</tr>';
        }
        $data['enterprise'] = $this->OrdemServico->enterprise_info()->row();
        
        $nserie = $this->General->select("NSERIE", "os", array(
            "idOS" => $idOS
        ))->row()->NSERIE;
        $aparelho = $this->General->select("apparatus, maker, model, color, patient_id", "patient_itens", array(
            "number_serie" => $nserie
        ))->row();
        $cliente = $this->General->select("first_name, last_name, document_cpf, document_rg", "patient", array(
            "patient_id" => $aparelho->patient_id
        ))->row();
        
        $data['nserie'] = $nserie;
        $data['cliente'] = $cliente;
        $data['aparelho'] = $aparelho;
        $this->load->view('os/recibo', $data);
    }

    function opener($idOSx)
    {
        $data['open'] = $idOSx;
        echo '<script>window.open("' . site_url("oscanhoto/index/" . $idOSx) . '");</script>';
        $this->index('<div class="alert alert-success">
				<button class="close" aria-hidden="true" data-dismiss="alert" type="button">X</button>
				<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
				OS adicionada, Nº ' . $idOSx . '
			</div>');
    }
}