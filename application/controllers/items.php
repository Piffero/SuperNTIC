<?php
require_once ("secure_area.php");

class Items extends Secure_area
{

    function __construct()
    {
        parent::__construct('items');
    }

    function index($manage_result = null)
    {
        $data['manage_result'] = $manage_result;
        $data['controller_name'] = 'items';
        $data['num_row'] = 'ITEMS REGISTRADOS <strong><font color="green">' . $this->Item->get_all()->num_rows() . '</font></strong>';
        $data['manage_table'] = get_item_manage_table($this->Item->get_all(), $this);
        $this->load->view('items/items', $data);
    }

    function delivery($manage_result = null)
    {
        $data['manage_result'] = $manage_result;
        $data['controller_name'] = 'items';
        $data['manage_table'] = get_delivery_table($this->Item->get_delivery_all(), $this);
        
        $item_produto = $this->Item->get_all();
        
        if ($item_produto->num_rows() != 0) {
            foreach ($item_produto->result() as $produtos) {
                $row[$produtos->description] = $produtos->description;
            }
            
            $data['item_produto'] = $row;
        } else {
            $data['item_produto'] = array(
                'Não há Registro de Produtos!'
            );
        }
        
        $funcionario = $this->Employeer->get_all();
        
        if ($funcionario->num_rows() != 0) {
            foreach ($funcionario->result() as $funcionarios) {
                $rows[$funcionarios->first_name] = $funcionarios->first_name;
            }
            
            $data['funcionario'] = $rows;
        } else {
            $data['funcionario'] = array(
                'N&#234;o h&#227; Registro de Funcion&#225;rios!'
            );
        }
        
        $this->load->view('items/delivery', $data);
    }

    function append($item_id = -1)
    {
        if ($this->check_action_permission('add_update')) {
            $data['id'] = $item_id;
            $data['items_info'] = $this->Item->get_info($item_id);
            $data['items_nfe'] = $this->Item->get_info_nfe($item_id);
            $data['items_nfe']->crt = 'sn';
            
            $data['add'] = 'active';
            $data['taxes'] = '';
            $data['value'] = '';
            
            // Inicia Lista de Categorias
            $item_category = $this->Category->get_all();
            
            if ($item_category->num_rows() != 0) {
                foreach ($item_category->result() as $categories) {
                    $rows[$categories->name] = $categories->name;
                }
                
                $data['item_category'] = $rows;
            } else {
                $data['item_category'] = array(
                    'Não há Registro de Categorias'
                );
            }
            // Acabou Linha de Categorias
            
            // Inicia Lista de Fornecedor
            $supplier = $this->Supplier->get_all();
            
            if ($supplier->num_rows() != 0) {
                foreach ($supplier->result() as $suppliers) {
                    $rows[$suppliers->fancy_name] = $suppliers->fancy_name;
                }
                
                $data['supplier'] = $rows;
            } else {
                $data['supplier'] = array(
                    'N&#234;o h&#227; Registro de Fornecedores'
                );
            }
            // Acabou Linha de Fornecedor
            
            // Inicia Lista de Tipos de Produtos
            $item_type = $this->Type->get_all();
            
            if ($item_type->num_rows() != 0) {
                foreach ($item_type->result() as $types) {
                    $Linha[$types->type_id] = $types->name;
                }
                
                $data['item_type'] = $Linha;
            } else {
                $data['item_type'] = array(
                    'N&#234;o h&#227; Registro de Tipos'
                );
            }
            // Acabou Linha de Tipos de Produtos
            
            $this->load->view('items/append', $data);
        } else {
            $this->index('<div class="alert alert-danger">
					<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Voc&#234; n&#227;o possui permi&#231;&#227;o para esta a&#231;&#227;o!...
					</div>');
        }
    }
    
    /*
     * Loads the customer edit form
     */
    function view($item_id = -1, $manage_result = null, $i = 0)
    {
        if ($this->check_action_permission('add_update')) {
            $data['id'] = $item_id;
            $data['manage_result'] = $manage_result;
            $data['items_info'] = $this->Item->get_info($item_id);
            $data['items_nfe'] = $this->Item->get_info_nfe($item_id);
            $data['items_business'] = $this->Item->get_info_business($item_id);
            
            $data['items_nfe']->crt = 'sn';
            
            if ($i == 0) {
                $data['add'] = 'active';
                $data['taxes'] = '';
                $data['value'] = '';
            } elseif ($i == 1) {
                $data['add'] = '';
                $data['taxes'] = '';
                $data['value'] = 'active';
            } elseif ($i == 2) {
                $data['add'] = '';
                $data['taxes'] = 'active';
                $data['value'] = '';
            }
            
            // Inicia Lista de Categorias
            $item_category = $this->Category->get_all();
            
            if ($item_category->num_rows() != 0) {
                foreach ($item_category->result() as $categories) {
                    $rows[$categories->name] = $categories->name;
                }
                
                $data['item_category'] = $rows;
            } else {
                $data['item_category'] = array(
                    'N&#227;o h&#225; Registro de Categorias'
                );
            }
            // Acabou Linha de Categorias
            
            // Inicia Lista de Fornecedor
            $supplier = $this->Supplier->get_all();
            
            if ($supplier->num_rows() != 0) {
                foreach ($supplier->result() as $suppliers) {
                    $row[$suppliers->suppliers_id] = $suppliers->fancy_name;
                }
                
                $data['supplier'] = $row;
            } else {
                $data['supplier'] = array(
                    'N&#227;o h&#225; Registro de Fornecedores'
                );
            }
            // Acabou Linha de Fornecedor
            
            // Inicia Lista de Tipos de Produtos
            $item_type = $this->Type->get_all();
            
            if ($item_type->num_rows() != 0) {
                foreach ($item_type->result() as $types) {
                    $Linha[$types->type_id] = $types->name;
                }
                $data['item_type'] = $Linha;
            } else {
                $data['item_type'] = array(
                    'N&#227;o h&#225; Registro de Tipos'
                );
            }
            // Acabou Linha de Tipos de Produtos
            
            $origem_data = array(
                0 => '0 - Nacional, exceto as indicadas nos códigos 3 a 5',
                1 => '1 - Estrangeira - Importação direta, exceto a indicada no código 6',
                2 => '2 - Estrangeira - Adquirida no mercado interno, exceto a indicada no código 7',
                3 => '3 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40% (quarenta por cento)',
                4 => '4 - Nacional, cuja produção tenha sido feita em conformidade com os processos produtivos básicos de que tratam o Decreto -Lei nº 288/1967 e as Leis nºs 8.248/1991, 8.387/1991, 10.176/2001 e 11.484/2007',
                5 => '5 - Nacional, mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40% (quarenta por cento)',
                6 => '6 - Estrangeira - Importação direta, sem similar nacional, constante em lista de Resolução CAMEX e Gás Natural.',
                7 => '7 - Estrangeira - Adquirida no mercado interno, sem similar nacional, constante em lista de Resolução CAMEX" e Gás Natural.',
                8 => '8 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 70% (setenta por cento)'
            );
            
            $situacao_tributaria = array(
                101 => '101 - Tributada com permissão de crédito',
                102 => '102 - Tributada com permissão de crédito',
                103 => '103 - Isenção de ICMS para faixa de receita bruta',
                201 => '201 - Tributada com permissão de crédito e com cobrança do ICMS por ST',
                202 => '202 - Tributada sem permissão de crédito e com cobrança do ICMS por ST',
                203 => '203 - Isenção do ICMS para faixa de receita bruta e com cobrança do ICMS por ST',
                300 => '300 - Imune',
                400 => '400 - Não tributada',
                500 => '500 - ICMS cobrado anteriormente por ST ou por antecipação',
                900 => '900 - Outros'
            );
            
            $data['situacao_tributaria'] = $situacao_tributaria;
            $data['data_origem'] = $origem_data;
            
            $a = $this->Ibge->lista_cfop();
            
            $num_rows = $a->num_rows();
            $data['lista_cfop'] = '<select class="form-control" id="cfop" name="cfop">
									<option value="NULL"> </option>';
            for ($i = 0; $i < $num_rows; $i ++) {
                if (isset($data['items_nfe']->cfop) and $data['items_nfe']->cfop == $a->result_array()[$i]["id_cfop"]) {
                    $data['lista_cfop'] .= '<option value="' . $a->result_array()[$i]["id_cfop"] . '" selected="selected">' . $a->result_array()[$i]["id_cfop"] . ' - ' . $a->result_array()[$i]["descricao"] . '</option>';
                } else {
                    $data['lista_cfop'] .= '<option value="' . $a->result_array()[$i]["id_cfop"] . '">' . $a->result_array()[$i]["id_cfop"] . ' - ' . $a->result_array()[$i]["descricao"] . '</option>';
                }
            }
            $data['lista_cfop'] .= '</select>';
            
            // #####################################################################################################
            
            $b = $this->Ibge->get_ibge_uf();
            
            $ba = $b->result_array();
            $num_rows2 = $b->num_rows();
            
            $data['uf'] = '<select class="form-control" id="uf_icms_st" name="uf_icms_st">
								<option value="NULL"> </option>';
            for ($j = 0; $j < $num_rows2; $j ++) {
                if (isset($data['items_nfe']->uf_icms_st) and $data['items_nfe']->uf_icms_st == $ba[$j]["uf"]) {
                    $data['uf'] .= '<option value="' . $ba[$j]["uf"] . '" selected="selected">' . $ba[$j]["uf"] . '</option>';
                } else {
                    $data['uf'] .= '<option value="' . $ba[$j]["uf"] . '">' . $ba[$j]["uf"] . '</option>';
                }
            }
            $data['uf'] .= '</select>';
            
            $data['active_tab_taxes'] = 'href="#taxes" data-toggle="tab"';
            $data['active_tab_value'] = 'href="#value" data-toggle="tab"';
            $this->load->view('items/append', $data);
        } else {
            $this->index('<div class="alert alert-danger">
					<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Voc&#234; n&#227;o possui permiss&#227;o para esta a&#231;&#227;o!...
					</div>');
        }
    }
    
    // Ramel Inventory Tracking
    function inventory($item_id = -1, $location_id = 1, $manage_result = null)
    {
        $this->check_action_permission('add_update');
        $data['manage_result'] = $manage_result;
        $data['id_item'] = $item_id;
        $quant = $this->Item->get_stock($item_id, $location_id);
        
        $enterprise = $this->Enterprise->get_info($location_id);
        $data['enterprise'] = $enterprise->fantasia;
        $data['location'] = $location_id;
        
        if ($quant == array()) {
            
            $data['item_q'] = 0;
        } else {
            $data['item_q'] = $quant[0];
        }
        
        $data['info'] = $this->Item->get_item_base_info($item_id)[0];
        
        $this->load->view("items/inventory", $data);
    }
    
    /*
     * Retorna linhas de dados da tabela item. Este ser� chamado com AJAX.
     */
    function search()
    {
        if ($this->check_action_permission('search')) {
            $search = $this->input->post('search');
            $data_rows = get_item_manage_table($this->Item->search($search), $this);
            
            $data['num_row'] = 'ITEMS REGISTRADOS <strong><font color="green">' . $this->Item->search($search)->num_rows() . '</font></strong>';
            $data['controller_name'] = 'items';
            $data['manage_table'] = $data_rows;
            $this->load->view('items/items', $data);
        } else {
            $this->index('<div class="alert alert-danger">
					<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Voc&#234; n&#227;o possui permi&#231;&#227;o para esta a&#231;&#227;o!...
					</div>');
        }
    }
    
    /*
     * Inserts/updates a customer
     */
    function save($item_id = -1)
    {
        $item_data = array(
            'item_ncm' => $this->input->post('item_ncm'),
            'item_codebar' => $this->input->post('item_codebar'),
            'description' => ucwords(strtolower($this->input->post('description'))),
            'type' => ucwords(strtolower($this->input->post('type'))),
            'category' => ucwords(strtolower($this->input->post('category'))),
            'unit' => mb_strtoupper($this->input->post('unit')),
            'qunit' => mb_strtoupper($this->input->post('qunit')),
            'garantia' => $this->input->post('garantia'),
            'garantia_fabrica' => $this->input->post('garantia_fabrica'),
            'is_serialized' => $this->input->post('is_serialized'),
            'is_service' => $this->input->post('is_service')
        );
        
        if ($this->Item->save($item_data, $item_id)) {
            
            // New Item value
            if ($item_id == - 1) {
                $registry = $this->Item->last_registry();
                
                foreach ($registry->result() as $item) {
                    $item_id = $item;
                }
                
                $this->view($item_id->item_id, '
						<div class="alert alert-success">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-check sign"></i><strong>Sucesso!</strong> 
							Registro inserido com sucesso
						</div>', 1);
            } else // previous Item value
{
                
                $this->view($item_id, '
						<div class="alert alert-success">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-check sign"></i><strong>Sucesso!</strong> 
							Registro atualizado com sucesso							
						</div>', 1);
            }
        } else // failure
{
            $this->view($item_id, '
						<div class="alert alert-danger">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-plus sign"></i><strong>Erro!</strong> 
							Opss.. Ocorreu um erro ao inserir ou atualizar o resgistro
						</div>
					', 0);
        }
    }
    
    /*
     * Inserts/updates a Promocao
     */
    function save_entrada($item_id = -1)
    {
        $item_data = array(
            'destinado' => get_float_converter($this->input->post('destiny')),
            'servico' => get_float_converter($this->input->post('service')),
            'ordenador' => $this->session->userdata('employees_id')
        );
        
        if ($this->Item->save_entrada($item_data, $item_id)) {
            
            // New Item value
            if ($item_id == - 1) {
                
                $this->delivery('
						<div class="alert alert-success">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-check sign"></i><strong>Sucesso!</strong> 
							Registro inserido com sucesso
						</div>');
            } else // previous Item value
{
                
                $this->delivery('
						<div class="alert alert-success">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-check sign"></i><strong>Sucesso!</strong> 
							Registro atualizado com sucesso							
						</div>');
            }
        } else // failure
{
            $this->delivery('
						<div class="alert alert-danger">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-plus sign"></i><strong>Erro!</strong> 
							Opss.. Ocorreu um erro ao inserir ou atualizar o resgistro
						</div>
					');
        }
    }

    function save_nfe($item_id = -1)
    {
        $item_data = array(
            'item_id' => $item_id,
            'crt' => $this->input->post('regime'),
            'situacao_tributaria' => $this->input->post('stributaria'),
            'origem' => $this->input->post('origem'),
            'cst_ipi' => $this->input->post('cstipi'),
            'cst_pis' => $this->input->post('cstpis'),
            'cst_confins' => $this->input->post('cstconfins'),
            'cfop' => $this->input->post('cfop'),
            'md_bc_icms' => $this->input->post('md_bc_icms'),
            'aliq_icms' => $this->input->post('aliq_icms'),
            'red_bc_icms' => $this->input->post('red_bc_icms'),
            'bc_op_propria' => $this->input->post('bc_op_propria'),
            'md_bc_icms_st' => $this->input->post('md_bc_icms_st'),
            'aliq_icms_st' => $this->input->post('aliq_icms_st'),
            'red_bc_icms_st' => $this->input->post('red_bc_icms_st'),
            'uf_icms_st' => $this->input->post('uf_icms_st'),
            'margem_val_adc_icms_st' => $this->input->post('margem_val_adc_icms_st'),
            'motivo_desoneracao' => $this->input->post('motivo_desoneracao'),
            'aliq_aplic_calc_cred' => $this->input->post('aliq_aplic_calc_cred'),
            'cod_anp' => $this->input->post('cod_anp'),
            'iat' => $this->input->post('iat')
        );
        
        if ($this->Item->save_nfe($item_data, $item_id)) {
            
            // New Item NFE
            if ($item_id == - 1) {
                
                $this->index('
						<div class="alert alert-success">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-check sign"></i><strong>Sucesso!</strong> 
							Registro inserido com sucesso 							
						</div>');
            } else // previous Item NFE
{
                
                $this->index('
						<div class="alert alert-success">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-check sign"></i><strong>Sucesso!</strong> 
							Registro atualizado com sucesso								
						</div>');
            }
        } else // failure
{
            
            $this->view($item_id, '
						<div class="alert alert-danger">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-plus sign"></i><strong>Erro!</strong> 
							Opss.. Ocorreu um erro ao inserir ou atualizar o resgistro
						</div>
					', 0);
        }
    }

    function save_business($item_id = -1)
    {
        $item_data = array(
            'item_id' => $this->input->post('item_id'),
            'supplier_id' => $this->input->post('supplier_id'),
            'cost_of_last_purchase' => $this->input->post('cost_of_last_purchase'),
            'cost_purchese' => $this->input->post('cost_purchese'),
            'selling_price' => $this->input->post('selling_price'),
            'markup_practiced' => $this->input->post('markup_practiced'),
            'markup' => $this->input->post('markup')
        );
        
        if ($this->Item->save_business($item_data, $item_id)) {
            
            // New Item NFE
            if ($item_id == - 1) {
                
                $this->view($item_id, '
						<div class="alert alert-success">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
							Registro inserido com sucesso
						</div>', 2);
            } else // previous Item NFE
{
                
                $this->view($item_id, '
						<div class="alert alert-success">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
							Registro atualizado com sucesso
						</div>', 2);
            }
        } else // failure
{
            $this->view($item_id, '
						<div class="alert alert-danger">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-plus sign"></i><strong>Erro!</strong>
							Opss.. Ocorreu um erro ao inserir ou atualizar o resgistro
						</div>
					', 0);
        }
    }

    function save_value($item_id = null, $locatin_id = 1)
    {
        // valida valores de quantidades negativas ou nulas
        if (empty($this->input->post('campo')) || $this->input->post('campo') < 0) {
            $this->inventory($item_id, $locatin_id, '
							<div class="alert alert-danger">
								<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
								<i class="fa fa-times sign"></i><strong>Aviso!</strong>
								O estoque físico não pode ser negativo!
							</div>
						');
        } else {
            $qtd = $this->input->post('campo');
            $user_logged = $this->session->userdata('employees_id');
            
            // Monta array
            $data_value = array(
                
                'item_id' => $item_id,
                'quantity' => $qtd,
                'trans_user' => $user_logged,
                'location_id' => $locatin_id
            );
            
            if ($this->Item->save_value($data_value, $item_id, $locatin_id)) {
                // Novo Item Value
                if ($item_id == - 1) {
                    $this->inventory($item_id, $locatin_id, '
						<div class="alert alert-success">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-times sign"></i><strong>Sucesso!</strong>
							Quantidade inserida com sucesso.
						</div>
						');
                } else {
                    $this->inventory($item_id, $locatin_id, '
						<div class="alert alert-success">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-times sign"></i><strong>Sucesso!</strong>
							Quantidade inserida com sucesso.
						</div>
						');
                }
            } else {
                $this->inventory($item_id, $locatin_id, '
						<div class="alert alert-danger">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-times sign"></i><strong>Erro!</strong>
							Ouve um problema ao inserir a guantidade, tente novamente!
						</div>
						');
            }
        }
    }
    
    /*
     * Isso exclui os clientes da tabela de clientes
     */
    function delete($item_id = -1)
    {
        $items_to_delete = $item_id;
        
        if ($this->Item->delete_list($items_to_delete)) {
            $this->index('
						<div class="alert alert-info">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
						<i class="fa fa-info-circle sign"></i><strong>Sucesso.</strong>
						Foi Deletado ' . count($items_to_delete) . ' Registro(s).
						</div>
						');
        } else {
            $this->index('
						<div class="alert alert-danger">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
							<i class="fa fa-times-circle sign"></i><strong>Erro!</strong> 
							Opss.. Ocorreu um erro ao deletar o(s) resgistro(s)							
						</div>
					');
        }
    }

    function mutiSelect_info()
    {
        // Pega os item_ids que serão exportados
        $item_ids = $this->input->post('item_id');
        
        // Instancia class ZipArchive
        $zip = new ZipArchive();
        
        // Verifica se o arquivo produtos.zip existe
        // caso exista excluia.
        if (file_exists("upload/produtos.zip")) {
            unlink('upload/produtos.zip');
        }
        
        // verifica se a valores no item_ids
        if ($item_ids) {
            if ($zip->open('upload/produtos.zip', ZipArchive::CREATE) === true) {
                foreach ($item_ids as $id) {
                    // Receberá todos os dados do banco para o XML
                    $item = $this->Item->get_infoI($id);
                    
                    if ($item->item_id != '' || $item->item_id != null) {
                        if ($item->item_ncm != 0) {
                            $item_ncm = '<NCM>' . $item->item_ncm . '</NCM>';
                        } else {
                            $item_ncm = '';
                        }
                        
                        number_format($item->selling_price);
                        
                        $xml = '<sistema versao="1.02" xmlns="http://www.portalfiscal.inf.br/nfe">';
                        
                        $xml .= '<det>';
                        $xml .= '<prod>';
                        $xml .= '<cProd>' . $item->item_id . '</cProd>';
                        $xml .= '<cEAN>' . $item->item_codebar . '</cEAN>';
                        $xml .= '<xProd>' . $item->description . '</xProd>';
                        $xml .= $item_ncm;
                        $xml .= '<uCom>' . $item->unit . '</uCom>';
                        $xml .= '<uTrib>' . $item->unit . '</uTrib>';
                        $xml .= '<qTrib>' . $item->qunit . '</qTrib>';
                        $xml .= '<vUnCom>' . $item->selling_price . '</vUnCom>';
                        $xml .= '<vUnTrib>' . $item->selling_price . '</vUnTrib>';
                        $xml .= '</prod>';
                        $xml .= '</det>';
                        $xml .= '</sistema>';
                        
                        // Escreve o arquivo
                        $fp = fopen('upload/' . $item->item_codebar . '.xml', 'w');
                        fwrite($fp, $xml);
                        fclose($fp);
                        
                        $zip->addFile('upload/' . $item->item_codebar . '.xml', $item->item_codebar . '.xml');
                    } else {
                        $info_item = $this->Item->get_info($id);
                        $button_active = 1;
                        echo "O PRODUTO --- $info_item->item_codebar $info_item->description  --- NÃO ESTA COMPLETO <br>";
                    }
                }
            }
            if ($button_active == 1) {
                echo '<button onclick="javascript:history.back()">Voltar</button><br>';
            }
            
            $zip->close();
            
            foreach ($item_ids as $id) {
                $customer = $this->Item->get_infoI($id);
                if (file_exists('upload/' . $item->item_codebar . '.xml')) {
                    unlink('upload/' . $item->item_codebar . '.xml');
                }
            }
            
            if (file_exists("upload/produtos.zip")) {
                redirect(base_url() . "upload/produtos.zip");
            }
        } else {
            $this->index('<div class="alert alert-danger">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Voc&#234; deve marcar um produto pelo menos!...
					</div>');
        }
    }
}
?>