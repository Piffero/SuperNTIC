<?php $this->load->view("partial/header"); ?>

        <div class="page-aside email">
			<div class="fixed nano nscroller">
				<div class="content">
					<div class="header">
						<button class="navbar-toggle" data-target=".mail-nav"
							data-toggle="collapse" type="button">
							<span class="fa fa-chevron-down"></span>
						</button>
						<h2 class="page-title">Gestor NFe</h2>
						<p class="description">Controle de Notas</p>
					</div>
					<div class="mail-nav collapse">
						<ul class="nav nav-pills nav-stacked ">
							<li class="active"><a href="#"><span
									class="label label-primary pull-right">6</span><i
									class="fa fa-inbox"></i> Entradas Processadas</a></li>
							<li><a href="#"><i class="fa fa-envelope"></i> Notas Enviadas</a></li>							
							<li><a href="#"><span
									class="label label-default pull-right">3</span><i
									class="fa fa-file-o"></i> Entrada Manual</a></li>
							<li><a href="#"><i class="fa fa-download"></i> Importação XML</a></li>
							<li><a href="#"><i class="fa fa-trash-o"></i> Notas Excluidas</a></li>
						</ul>

						<p class="title">Operações</p>
						
						<div class="compose">
							<a class="btn btn-flat btn-primary"><i class="fa fa-file"></i> Entrada Manual</a>
							<a class="btn btn-flat btn-primary"><i class="fa fa-download"></i> Importar NFE XML</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="container-fluid" id="pcont">
			<div class="message">
				<div class="head">
					<h3>
						John Doe Fornecedor <span><a href="#"><i class="fa fa-inbox"></i></a><a
							href="#"><i class="fa fa-reply"></i></a></span>
					</h3>
					<h4>
						Venda a Prazo<span><a href="#"><i
								class="fa fa-star"></i></a> Jan 9, <b>10:40 AM</b></span>
					</h4>
				</div>
				<div class="mail">
					<p>
					   <div class="GeralXslt">
						  <h1></h1>
						      <fieldset>
						          <legend><small>Dados Gerais</small></legend>
						          <table class="no-border">
						              <tbody class="no-border-x no-border-y">						              
    						              <tr>
    						                  <td>
    						                      <label>Chave de Acesso</label>
    						                      <span>3515 0145 1702 8900 0125 5502 0000 1197 3010 0286 7325</span>
    						                  </td>
    						                  <td class="fixo-nro-serie">
    						                      <label>Número</label>
    						                      <span>119730</span>
    						                  </td>
    						                  <td class="fixo-versao-xml">
    						                      <label>Versão XML</label>
    						                      <span>3.10</span>
    						                  </td>
    						              </tr>
    						              <tr style="background-color: white;"><td>&nbsp;</td></tr>
						              </tbody>
						          </table>
						     </fieldset>
					   </div>					   
					   <div id="NFe" class="GeralXslt">
					       <fieldset>
					           <legend class="titulo-aba"><small>Dados da NF-e</small></legend>
					           <table class="no-border">
					               <tbody class="no-border-x no-border-y">	
    					               <tr>
    					                  <td>
    					                       <label>Modelo</label><br>
    					                       <span>55</span>
    					                  </td>
    					                  <td>
    					                       <label>Série</label><br>
    					                       <span>20</span>
    					                  </td>
    					                  <td>
    					                       <label>Número</label><br>
    					                       <span>119730</span>
    					                  </td>
    					                  <td>
    					                       <label>Data de Emissão</label><br>
    					                       <span>22/01/2015 14:17:00-02:00</span>
    					                  </td>
    					                  <td>
    					                       <label>Data/Hora de Saída ou da Entrada</label><br> 
    					                       <span>22/01/2015 14:17:00-02:00</span>
    					                  </td>
    					                  <td>
    					                       <label>Valor Total da Nota Fiscal</label><br>
    					                       <span>522,00</span>
    					                  </td>
    					             </tr>
    					             <tr style="background-color: white;"><td>&nbsp;</td></tr>
					             </tbody>
					         </table>
					      </fieldset>
					      
					      
					      <fieldset>
					           <legend><small>Emitente</small></legend>
				               <table class="no-border">
				                   <tbody class="no-border-x no-border-y">	
				                       <tr>
				                           <td>
				                               <label>CNPJ</label><br>
				                               <span>45.170.289/0001-25</span>
				                           </td>
				                           <td>
				                               <label>Nome / Razão Social</label><br>
				                               <span>DARUMA TELECOMUNICACOES E INFORM. S. A.</span>
				                           </td>
				                           <td>
				                               <label>Inscrição Estadual</label><br>
				                               <span>688023460111</span>
				                           </td>
				                           <td>
				                               <label>UF</label><br>
				                               <span>SP</span>
				                           </td>
				                       </tr>
				                       <tr style="background-color: white;"><td>&nbsp;</td></tr>
				                   </tbody>
				               </table>
					     </fieldset>
					       
					     <fieldset>
					           <legend><small>Destinatário</small></legend>
					           <table class="no-border">
				                   <tbody class="no-border-x no-border-y">
    				                  <tr>
    				                        <td>
    				                            <label>CNPJ</label><br>
    				                            <span>15.190.802/0001-89</span>
    				                        </td>
    				                        <td>
    				                            <label>Nome / Razão Social</label><br>
    				                            <span>THIAGO PIFFERO RANGEL 06434506457</span>
    				                        </td>
    				                        <td>
    				                            <label>Inscrição Estadual</label><br>
    				                            <span>&nbsp;</span>
    				                        </td>
    				                        <td>
    				                            <label>UF</label><br>
    				                            <span>SC</span>
    				                        </td>
    				                  </tr>
    				                  <tr style="background-color: white;">
    				                        <td>
    				                            <label>Destino da operação</label><br>
    				                            <span>2 - Operação Interestadual</span>
    				                        </td>
    				                        <td>
    				                            <label>Consumidor final</label><br>
    				                            <span>1 - Consumidor final</span>
    				                        </td>
    				                        <td>
    				                            <label>Presença do Comprador</label><br>
    				                            <span>0 - Não se aplica</span>
    				                        </td>
    				                  </tr>
    				                  <tr style="background-color: white;"><td>&nbsp;</td></tr>    				                  
				                  </tbody>
				               </table>
				         </fieldset>
				         
				         <fieldset>
				                <legend><small>Emissão</small></legend>
				                <table class="no-border">
				                   <tbody class="no-border-x no-border-y">
				                        <tr>
				                            <td>
				                                <label>Processo</label><br>
				                                <span>0 - com aplicativo do Contribuinte</span>
				                            </td>
				                            <td>
				                                <label>Versão do Processo</label><br>
				                                <span>2.39</span>
				                            </td>
			                                <td>
			                                    <label>Tipo de Emissão</label><br>
			                                    <span>1 - Normal</span>
			                                </td>
			                                <td>
			                                    <label>Finalidade</label><br>
			                                    <span>1 - Normal</span>
			                                </td>
				                        </tr>
				                        <tr style="background-color: white;">
				                            <td>
				                                <label>Natureza da Operação</label><br>
				                                <span>VENDA PRODUCAO ESTABELECIMENTO DEST. A NAO CONTRIBUINTE</span>
				                            </td>
				                            <td>
				                                <label>Tipo da Operação</label><br>
				                                <span>1 - Saída</span>
				                            </td>
				                            <td>
				                                <label>Forma de Pagamento</label><br>
				                                <span>1 - A prazo</span>
				                            </td>
				                            <td>
				                                <label>valor da chave da NF-e</label><br>
				                                <span>b6EzzqYoq9ssQO5+RNjqFkYlW2E=</span>
				                            </td>
				                        </tr>
				                        <tr style="background-color: white;"><td>&nbsp;</td></tr>
				                   </tbody>
				               </table>
				         </fieldset>				
				</div>
				<div id="Prod">
				        <fieldset>
				            <legend><small>Dados dos Produtos e Serviços</small></legend>				            
				            <table>
				                <thead>
				                    <tr style="border: hidden;">
				                        <th class="text-center" style="border: hidden;"><label>#</label></th>
				                        <th style="border: hidden;"><label>Num</label></th>
				                        <th colspan="3" style="border: hidden;"><label>Descrição</label></th>
				                        <th style="border: hidden;"><label>Qtd.</label></th>
				                        <th style="border: hidden;"><label>Unid.</label></th>
				                        <th style="border: hidden;"><label>Valor(R$)</label></th>
				                    </tr>
				                </thead>
				                <tbody style="border: hidden;">
				                        <tr style="border: hidden;">
				                            <td style="border: hidden;" class="text-center "><a href=""><i class="fa fa-plus"></i></a></td>
				                            <td style="border: hidden;"><span>1</span></td>
				                            <td colspan="3" style="border: hidden;"><span>IMPRESSORA DE NAO IMPACTO, TERMICA MODELO DR700 ETH DG GUILHOTINA</span></td>
				                            <td style="border: hidden;"><span>1,0000</span></td>
				                            <td style="border: hidden;"><span>PC</span></td>
				                            <td style="border: hidden;"><span>518,11</span></td>
				                        </tr>
				                        <tr>
				                            <td class="details" colspan="8">
				                                <table class="table-bordered" style="padding-left:50px;">
				                                    <tr style="background-color: rgba(0, 0, 0, 0.024); border: hidden;"><td colspan="8"><legend>Dados sobre o Produto</legend></td></tr>
				                                    <tr style="background-color: rgba(0, 0, 0, 0.024); border: hidden;">
				                                        <td colspan="2" style="border: hidden;">&nbsp;</td>
				                                        <td style="border: hidden;"><label>Código do Produto</label><br><span>614001148</span></td>
				                                        <td style="border: hidden;"><label>Código NCM</label><br><span>84433239</span></td>
				                                        <td colspan="4" style="border: hidden;"><label>Indicador de Composição do Valor Total da NF-e </label><br><span>1 - O valor do item (vProd) compõe o valor total da NF-e (vProd)</span></td>
				                                    </tr>
				                                    <tr style="background-color: rgba(0, 0, 0, 0.024); border: hidden;">
				                                        <td colspan="2" style="border: hidden;">&nbsp;</td>
				                                        
				                                        <td style="border: hidden;"><label>Código EX da TIPI</label><br><span>&nbsp;</span></td>
				                                        <td style="border: hidden;"><label>CFOP</label><br><span>6107</span></td>
				                                        <td style="border: hidden;"><label>Outras Despesas Acessórias</label><br><span>&nbsp;</span></td>
				                                        <td style="border: hidden;"><label>Valor do Desconto</label><br><span>&nbsp;</span></td>
				                                        <td style="border: hidden;"><label>Valor Total do Frete</label><br><span>&nbsp;</span></td>
				                                        <td style="border: hidden;"><label>Valor do Seguro</label><br><span>&nbsp;</span></td>				                                        
				                                    </tr>
				                                    <tr style="background-color: rgba(0, 0, 0, 0.024); border: hidden;"><td colspan="8">&nbsp;</td></tr>
				                                    <tr style="background-color: rgba(0, 0, 0, 0.024); border: hidden;">
				                                        <td style="border: hidden;" colspan="2" style="border: hidden;">&nbsp;</td>
				                                        <td style="border: hidden;" colspan="1"><label>Código EAN Comercial</label><br><span>&nbsp;</span></td>
				                                        <td style="border: hidden;" colspan="1"><label>Unidade Comercial</label><br><span>PC</span></td>
				                                        <td style="border: hidden;" colspan="2"><label>Quantidade Comercial</label><br><span>1,0000</span></td>
				                                        <td style="border: hidden;" colspan="2"><label>Valor unitário de comercialização</label><br><span>518,1100000000</span></td>
				                                    </tr>
				                                    <tr style="background-color: rgba(0, 0, 0, 0.024); border: hidden;">
				                                        <td style="border: hidden;" colspan="2">&nbsp;</td>
				                                        <td style="border: hidden;" colspan="1"><label>Código EAN Tributável</label><br><span>&nbsp;</span></td>
				                                        <td style="border: hidden;" colspan="1"><label>Unidade Tributável</label><br><span>PC</span></td>
				                                        <td style="border: hidden;" colspan="2"><label>Quantidade Tributável</label><br><span>1,0000</span></td>
				                                        <td style="border: hidden;" colspan="2"><label>Valor unitário de tributação</label><br><span>518,1100000000</span></td>
				                                    </tr>				                                    
				                                    <tr style="background-color: rgba(0, 0, 0, 0.024); border: hidden;">
				                                        <td style="border: hidden;" colspan="2">&nbsp;</td>
				                                        <td style="border: hidden;" colspan="2"><label>Número do pedido de compra</label><br><span>&nbsp;</span></td>
				                                        <td style="border: hidden;" colspan="1"><label>Item do pedido de compra</label><br><span>&nbsp;</span></td>
				                                        <td style="border: hidden;" colspan="1"><label>Valor Aproximado dos Tributos</label><br><span>172,42</span></td>
				                                        <td style="border: hidden;" colspan="2"><label>Número da FCI</label><br><span>&nbsp;</span></td>
				                                    </tr>
				                                    <tr style="background-color: rgba(0, 0, 0, 0.024); border: hidden;"><td colspan="8"><legend>ICMS Normal e ST</legend></td></tr>
				                                    <tr style="background-color: rgba(0, 0, 0, 0.024); border: hidden;">
				                                        <td style="border: hidden;" colspan="2">&nbsp;</td>
				                                        <td style="border: hidden;" colspan="2"><label>Origem da Mercadoria</label><br><span>4 - Nacional, com produção em conformidade com processo produtivo básico previsto na legislação</span></td>
				                                        <td style="border: hidden;" colspan="2"><label>Tributação do ICMS</label><br><span>20 - Com redução de base de cálculo</span></td>
				                                        <td style="border: hidden;" colspan="2"><label>Modalidade Definição da BC do ICMS</label><br><span>3 - Valor da Operação</span></td>				                                        
				                                    </tr>
				                                    <tr style="background-color: rgba(0, 0, 0, 0.024); border: hidden;">
				                                        <td style="border: hidden;" colspan="2">&nbsp;</td>
				                                        <td style="border: hidden;" colspan="2"><label>Base de Cálculo</label><br><span>348,02</span></td>
				                                        <td style="border: hidden;" colspan="2"><label>Alíquota</label><br><span>18,0000</span></td>
				                                        <td style="border: hidden;" colspan="2"><label>Valor</label><br><span>62,64</span></td>
				                                    </tr>				                                    
				                                    <tr style="background-color: rgba(0, 0, 0, 0.024); border: hidden;">
				                                        <td style="border: hidden;" colspan="2">&nbsp;</td>
				                                        <td style="border: hidden;" colspan="2"><label>Percentual Redução de BC do ICMS Normal</label><br><span>33,3300</span></td>
				                                        <td style="border: hidden;" colspan="2"><label>Valor ICMS Desonerado</label><br><span>&nbsp;</span></td>
				                                        <td style="border: hidden;" colspan="2"><label>Motivo Desoneração ICMS</label><br><span>&nbsp;</span></td>
				                                    </tr>
				                                    
				                                    <tr style="background-color: rgba(0, 0, 0, 0.024); border: hidden;"><td colspan="8"><legend>Imposto Sobre Produtos Industrializados</legend></td></tr>
				                                    <tr style="background-color: rgba(0, 0, 0, 0.024); border: hidden;">
				                                        <td style="border: hidden;" colspan="2">&nbsp;</td>
				                                        <td style="border: hidden;" colspan="2"><label>Classe de Enquadramento</label><br><span>&nbsp;</span></td>
				                                        <td style="border: hidden;" colspan="2"><label>Código de Enquadramento</label><br><span>&nbsp;</span></td>
				                                        <td style="border: hidden;" colspan="2"><label>Código do Selo</label><br><span>&nbsp;</span></td>
				                                    </tr>
				                                    <tr style="background-color: rgba(0, 0, 0, 0.024); border: hidden;">
				                                        <td style="border: hidden;" colspan="2">&nbsp;</td>
				                                        <td style="border: hidden;" colspan="2"><label>CNPJ do Produtor</label><br><span>&nbsp;</span></td>
				                                        <td style="border: hidden;" colspan="2"><label>Qtd. Selo</label><br><span>&nbsp;</span></td>
				                                        <td style="border: hidden;" colspan="2"><label>CST</label><br><span>50 - Saída tributada</span></td>
				                                    </tr>
				                                    <tr style="background-color: rgba(0, 0, 0, 0.024); border: hidden;">
				                                        <td style="border: hidden;" colspan="2">&nbsp;</td>
				                                        <td style="border: hidden;" colspan="2"><label>Qtd Total Unidade Padrão</label><br><span>&nbsp;</span></td>
				                                        <td style="border: hidden;" colspan="2"><label>Valor por Unidade</label><br><span>&nbsp;</span></td>
				                                        <td style="border: hidden;" colspan="2"><label>Valor IPI</label><br><span>3,89</span></td>
				                                    </tr>
				                                    <tr style="background-color: rgba(0, 0, 0, 0.024); border: hidden;">
				                                        <td style="border: hidden;" colspan="2">&nbsp;</td>
				                                        <td style="border: hidden;" colspan="2"><label>Base de Cálculo</label><br><span>518,11</span></td>
				                                        <td style="border: hidden;" colspan="2"><label>Alíquota</label><br><span>0,7500</span></td>
				                                        <td style="border: hidden;" colspan="2"><label>&nbsp;</label><br><span>&nbsp;</span></td>
				                                    </tr>
				                                    <tr style="background-color: rgba(0, 0, 0, 0.024); border: hidden;"><td colspan="8"><legend>PIS</legend></td></tr>
				                                    <tr style="background-color: rgba(0, 0, 0, 0.024); border: hidden;">
				                                        <td style="border: hidden;" colspan="2"><label>CST</label><br><span>&nbsp;</span></td>
				                                        <td style="border: hidden;" colspan="2"><label>&nbsp;</label><br><span>&nbsp;</span></td>
				                                        <td style="border: hidden;" colspan="2"><label>&nbsp;</label><br><span>&nbsp;</span></td>
				                                        <td style="border: hidden;" colspan="2"><label>&nbsp;</label><br><span>&nbsp;</span></td>
				                                    </tr>
				                                </table>
				                                
				                            </td>
				                        </tr>	
				                        			                        
				                   </tbody>
				            </table>
				       </fieldset> 
				   </div>
				   
				  <tr><td colspan="12"><fieldset><legend class="toggle">PIS</legend><div class="toggable"><table class="box"><tr class="col-3"><td colspan="3"><label>CST</label><span>01 - Operação Tributável (base de cálculo = valor da operação alíquota normal (cumulativo/não cumulativo))</span></td></tr><tr class="col-3"><td><label>Base de Cálculo</label><span>518,11</span></td><td><label>Alíquota</label><span>1,6500</span></td><td><label>Valor</label><span>8,55</span></td></tr></table></div></fieldset></td></tr><tr></tr><tr><td colspan="12"><fieldset><legend class="toggle">COFINS</legend><div class="toggable"><table class="box"><tr class="col-3"><td colspan="3"><label>CST</label><span>01 - Operação Tributável (base de cálculo = valor da operação alíquota normal (cumulativo/não cumulativo))</span></td></tr><tr class="col-3"><td><label>Base de Cálculo</label><span>518,11</span></td><td><label>Alíquota</label><span>7,6000</span></td><td><label>Valor</label><span>39,38</span></td></tr></table></div></fieldset></td></tr><tr></tr><tr></tr><tr></tr><tr><td colspan="12"></td></tr></table></td></tr></table></div></fieldset></div></div><div id="aba_nft_10" class="nft"></div></div>        
				
			</div>
		</div>
    </div>
    
    
		<script type="text/javascript">
		 var cl = document.getElementById('cl-wrapper');
		 cl.setAttribute('class', 'fixed-menu sb-collapsed'); 
		 document.getElementById('sidebar-collapse').innerHTML = '<i class="fa fa-angle-right" style="color:#fff;"></i>';
	    </script>
		
<?php $this->load->view("partial/footer");?>