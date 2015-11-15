<?php
require_once ("secure_area.php");

class Customers extends Secure_area
{

    function __construct()
    {
        parent::__construct('customers');
    }

    function index($manage_result = null)
    {
        $data['manage_result'] = $manage_result;
        $data['controller_name'] = 'custormes';
        $data['num_row'] = 'CLIENTES REGISTRADOS <strong><font color="green">' . $this->Customer->count_all() . '</font></strong>';
        $data['manage_table'] = get_patient_manage_table($this->Customer->get_all(), $this);
        $this->load->view('customers/customers', $data);
    }

    function append($manage_result = null, $customer_id = -1)
    {
        if ($this->check_action_permission('add_update')) {
            $data['add'] = 'active';
            $data['addr'] = '';
            $data['cont'] = '';
            $data['info'] = '';
            $data['item'] = '';
            $data['ficha'] = '';
            
            $data['customers_info'] = $this->Customer->get_info($customer_id);
            
            // Inicia Lista de Categorias
            $employeer_fono = $this->Employeer->get_fono();
            
            if ($employeer_fono->num_rows() != 0) {
                foreach ($employeer_fono->result() as $fono) {
                    $rows[$fono->first_name] = $fono->first_name;
                }
                
                $data['employeer_fono'] = $rows;
            } else {
                $data['employeer_fono'] = array(
                    'Não há Funcionarios de Fonoaudiologia '
                );
            }
            // Acabou Linha de Categorias
            
            if (isset($customer_info->state)) {
                $ibge_Mun = $this->Ibge->get_ibge_Mun($Customer_info->state);
                
                foreach ($ibge_Mun->result() as $Mun) {
                    // print_r($Mun->municipio);
                    $data['Ibge_Mun'][$Mun->municipio] = $Mun->municipio;
                }
            } else {
                $data['Ibge_Mun']['0'] = 'Escolha uma UF';
            }
            
            $this->load->view('customers/append', $data);
        } else {
            $this->index('<div class="alert alert-danger">
					<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Voc&#234; n&#227;o possui permi&#231;&#227;o para esta a&#231;&#227;o!...
					</div>');
        }
    }

    /**
     * Retorna linhas de dados da tabela cliente.
     * Este ser� chamado com AJAX.
     */
    function search()
    {
        if ($this->check_action_permission('search')) {
            $search = $this->input->post('search');
            $order = $this->input->post('order');
            
            $data_rows = get_patient_manage_table($this->Customer->search($search, $order), $this);
            
            $data['num_row'] = 'CLIENTES REGISTRADOS <strong><font color="green">' . $this->Customer->count_all() . '</font></strong>';
            $data['controller_name'] = 'custormes';
            $data['manage_table'] = $data_rows;
            $this->load->view('customers/customers', $data);
        } else {
            $this->index('<div class="alert alert-danger">
					<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Voc&#234; n&#227;o possui permi&#231;&#227;o para esta a&#231;&#227;o!...
					</div>');
        }
    }
    
    /*
     * Gives search suggestions based on what is being searched for
     */
    function suggest()
    {
        $suggestions = $this->Customer->get_search_suggestions($this->input->post('q'), $this->input->post('limit'));
        echo implode("\n", $suggestions);
    }
    
    /*
     * Loads the customer edit form
     */
    function view($customer_id = -1, $manage_result = null, $i = 0)
    {
        if ($this->check_action_permission('add_update')) {
            
            $Customer_info = $this->Customer->get_info($customer_id);
            
            $data['manage_result'] = $manage_result;
            $data['id'] = $customer_id;
            $data['customers_info'] = $Customer_info;
            $data['customers_addinfo'] = $this->Customer->exists_info($customer_id);
            
            $data['active_address'] = 'href="#addr" data-toggle="tab"';
            $data['active_contato'] = 'href="#cont" data-toggle="tab"';
            $data['active_info'] = 'href="#info" data-toggle="tab"';
            $data['active_item'] = 'href="#item" data-toggle="tab"';
            $data['active_ficha'] = 'href="#ficha" data-toggle="tab"';
            
            $data['num_row'] = 'APARELHOS REGISTRADOS <strong><font color="green">' . $this->Customer->count_all_aparatus($customer_id) . '</font></strong>';
            
            $data['generating_series'] = $this->getSerial();
            $data['row_item'] = get_row_itens_manage_data_rows($this->Customer->exists_item($customer_id), $this);
            
            $data['Ibge_uf'] = array();
            $ibge_uf = $this->Ibge->get_ibge_uf();
            
            foreach ($ibge_uf->result() as $UF) {
                $data['Ibge_uf'][$UF->uf] = $UF->uf;
            }
            
            if ($Customer_info->state) {
                $ibge_Mun = $this->Ibge->get_ibge_Mun($Customer_info->state);
                
                foreach ($ibge_Mun->result() as $Mun) {
                    // print_r($Mun->municipio);
                    $data['Ibge_Mun'][$Mun->municipio] = $Mun->municipio;
                }
            } else {
                $data['Ibge_Mun']['0'] = 'Escolha uma UF';
            }
            
            if ($i == 0) {
                $data['add'] = 'active';
                $data['addr'] = '';
                $data['cont'] = '';
                $data['info'] = '';
                $data['item'] = '';
                $data['ficha'] = '';
            } elseif ($i == 1) {
                $data['add'] = '';
                $data['addr'] = 'active';
                $data['cont'] = '';
                $data['info'] = '';
                $data['item'] = '';
                $data['ficha'] = '';
            } elseif ($i == 2) {
                $data['add'] = '';
                $data['addr'] = '';
                $data['cont'] = 'active';
                $data['info'] = '';
                $data['item'] = '';
                $data['ficha'] = '';
            } elseif ($i == 3) {
                $data['add'] = '';
                $data['addr'] = '';
                $data['cont'] = '';
                $data['info'] = '';
                $data['item'] = 'active';
                $data['ficha'] = '';
            } elseif ($i == 4) {
                $data['add'] = '';
                $data['addr'] = '';
                $data['cont'] = '';
                $data['info'] = 'active';
                $data['item'] = '';
                $data['ficha'] = '';
            } elseif ($i == 5) {
                $data['add'] = '';
                $data['addr'] = '';
                $data['cont'] = '';
                $data['info'] = '';
                $data['item'] = '';
                $data['ficha'] = 'active';
            }
            
            // Inicia Lista de Categorias
            $employeer_fono = $this->Employeer->get_fono();
            
            if ($employeer_fono->num_rows() != 0) {
                foreach ($employeer_fono->result() as $fono) {
                    $rows[$fono->first_name] = $fono->first_name;
                }
                $data['employeer_fono'] = $rows;
            } else {
                $data['employeer_fono'] = array(
                    'Nao existem Funcionarios de Fonoaudiologia '
                );
            }
            // Acabou Linha de Categorias
            
            $data['appointment'] = $this->Customer->get_appointment($customer_id);
            
            $data['table_app'] = '';
            $linhas = $this->Customer->get_appointment($customer_id)->num_rows();
            $n = $this->Customer->get_appointment($customer_id)->result_array();
            
            for ($i = 0; $i < $linhas; $i ++) {
                $data['table_app'] .= '<tr>
							<td>' . $n[$i]['atendimento'] . '</td>
							<td class="text-center">' . $n[$i]['doctor_id'] . '</td>
							<td style="width:50%;" class="text-center">' . get_date_view($n[$i]['appointment']) . ' - ' . $n[$i]['hour'] . '</td>
						</tr>';
            }
            $data['reg_app'] = '';
            $data['linhas'] = '<tr>
									<td class="text-right" colspan="3">Consultas registradas: 
										<span style="color:green;">' . $linhas . '</span>
									</td>
								</tr>';
            
            $this->load->view('customers/append', $data);
        } else {
            $this->index('<div class="alert alert-danger">
					<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Voc&#234; n&#227;o possui permi&#231;&#227;o para esta a&#231;&#227;o!...
					</div>');
        }
    }

    function save_apparatus($customer_id = -1)
    {
        $customer_data = array(
            'patient_id' => $customer_id,
            'apparatus' => $this->input->post('apparatus'),
            'maker' => $this->input->post('maker'),
            'model' => $this->input->post('model'),
            'color' => $this->input->post('color'),
            'number_serie' => $this->input->post('number_serie'),
            'purchase_date' => get_date_converter($this->input->post('purchase_date')),
            'expires_data' => get_date_converter($this->input->post('expires_data')),
            'suppliers_data' => get_date_converter($this->input->post('suppliers_data'))
        );
        
        if ($this->Customer->save_apparatus($customer_data, $customer_id)) {
            
            $this->view($customer_id, '
						<div class="alert alert-success">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-check sign"></i><strong>Sucesso!</strong> 
							Registro inserido com sucesso ' . ($customer_data['apparatus']) . ' ' . ($customer_data['maker']) . ' ' . ($customer_data['model']) . '
						</div>', 2);
        } else // failure
{
            $this->view($customer_id, '
						<div class="alert alert-danger">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-plus sign"></i><strong>Erro!</strong> 
							Opss.. Ocorreu um erro ao inserir ou atualizar o resgistro ' . ($customer_data['apparatus']) . ' ' . ($customer_data['maker']) . ' ' . ($customer_data['model']) . '
						</div>
					', 2);
        }
    }
    
    /*
     * Inserts/updates a customer
     */
    function save($customer_id = -1)
    {
        $gotopage = $this->input->post('save');
        
        $customer_data = array(
            'first_name' => ucwords(strtolower($this->input->post('first_name'))),
            'last_name' => ucwords(strtolower($this->input->post('last_name'))),
            'sex' => $this->input->post('sex'),
            'account_opening' => $this->input->post('account_opening'),
            'birth_date' => $this->input->post('birth_date'),
            'document_cpf' => $this->input->post('document_cpf'),
            'document_rg' => $this->input->post('document_rg'),
            
            'waives_terms' => $this->input->post('waives_terms'),
            'sending_letter' => $this->input->post('sending_letter'),
            'sending_email' => $this->input->post('sending_email'),
            'sending_sms' => $this->input->post('sending_sms')
        );
        
        if ($this->Customer->save($customer_data, $customer_id)) {
            
            if ($gotopage == 0) {
                
                // New customer
                if ($customer_id == - 1) {
                    $registry = $this->Customer->last_registry();
                    
                    foreach ($registry->result() as $custmer) {
                        $customer_id = $custmer;
                    }
                    
                    $this->view($customer_id->patient_id, '
							<div class="alert alert-success">
								<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
								<i class="fa fa-check sign"></i><strong>Sucesso!</strong> 
								Registro inserido com sucesso ' . ($customer_data['first_name']) . ' ' . ($customer_data['last_name']) . '
							</div>', 1);
                } else // previous customer
{
                    
                    $this->view($customer_id, '
							<div class="alert alert-success">
								<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
								<i class="fa fa-check sign"></i><strong>Sucesso!</strong> 
								Registro atualizado com sucesso ' . ($customer_data['first_name']) . ' ' . ($customer_data['last_name']) . '								
							</div>', 1);
                }
            } elseif ($gotopage == 1) {
                // New customer
                if ($customer_id == - 1) {
                    
                    $this->append('
							<div class="alert alert-success">
								<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
								<i class="fa fa-check sign"></i><strong>Sucesso!</strong> 
								Registro inserido com sucesso ' . ($customer_data['first_name']) . ' ' . ($customer_data['last_name']) . '
							</div>');
                } else // previous customer
{
                    
                    $this->append('
							<div class="alert alert-success">
								<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
								<i class="fa fa-check sign"></i><strong>Sucesso!</strong> 
								Registro atualizado com sucesso ' . ($customer_data['first_name']) . ' ' . ($customer_data['last_name']) . '								
							</div>');
                }
            }
        } else // failure
{
            $this->view($customer_id, '
						<div class="alert alert-danger">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-plus sign"></i><strong>Erro!</strong> 
							Opss.. Ocorreu um erro ao inserir ou atualizar o resgistro ' . ($customer_data['first_name']) . ' ' . ($customer_data['last_name']) . '
						</div>
					', 1);
        }
    }
    
    /*
     * Inserts/updates a customer
     */
    function save_address($customer_id = -1)
    {
        $gotopage = $this->input->post('save');
        
        $customer_data = array(
            'address_1' => ucwords(strtolower($this->input->post('address_1'))),
            'address_2' => ucwords(strtolower($this->input->post('address_2'))),
            'city' => $this->input->post('city'),
            'state' => mb_strtoupper($this->input->post('state')),
            'zip' => $this->input->post('zip'),
            'country' => ucwords(strtolower($this->input->post('country')))
        );
        
        if ($this->Customer->save($customer_data, $customer_id)) {
            
            if ($gotopage == 0) {
                $this->view($customer_id, '
						<div class="alert alert-success">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
							Registro atualizado com sucesso
						</div>', 2);
            } elseif ($gotopage == 1) {
                $this->append('
							<div class="alert alert-success">
								<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
								<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
								Registro atualizado com sucesso
							</div>');
            }
        } else // failure
{
            $this->view($customer_id, '
						<div class="alert alert-danger">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-plus sign"></i><strong>Erro!</strong>
							Opss.. Ocorreu um erro ao inserir ou atualizar o resgistro
						</div>
					', 1);
        }
    }
    
    /*
     * Inserts/updates a customer
     */
    function save_contato($customer_id = -1)
    {
        $gotopage = $this->input->post('save');
        
        $customer_data = array(
            'email' => $this->input->post('email'),
            'phone_number' => $this->input->post('phone_number'),
            'phone_home' => $this->input->post('phone_home'),
            'phone_work' => $this->input->post('phone_work'),
            'phone_cell' => $this->input->post('phone_cell'),
            'phone_other' => $this->input->post('phone_other')
        );
        
        if ($this->Customer->save($customer_data, $customer_id)) {
            
            if ($gotopage == 0) {
                $this->view($customer_id, '
						<div class="alert alert-success">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
							Registro atualizado com sucesso
						</div>', 3);
            } elseif ($gotopage == 1) {
                $this->append('
							<div class="alert alert-success">
								<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
								<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
								Registro atualizado com sucesso
							</div>');
            }
        } else // failure
{
            $this->view($customer_id, '
						<div class="alert alert-danger">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-plus sign"></i><strong>Erro!</strong>
							Opss.. Ocorreu um erro ao inserir ou atualizar o resgistro
						</div>
					', 2);
        }
    }
    
    /*
     * Inserts/updates a customer
     */
    function save_info($customer_id = -1)
    {
        $gotopage = $this->input->post('save');
        
        $customer_data = array(
            'patient_id' => $customer_id,
            'previous_doctor' => $this->input->post('previous_doctor'),
            'next_doctor_id' => $this->input->post('next_doctor_id'),
            'pointer_doctor' => $this->input->post('pointer_doctor'),
            'comments' => $this->input->post('comments'),
            'historic' => $this->input->post('historic'),
            'left_loss' => $this->input->post('left_loss'),
            'right_loss' => $this->input->post('right_loss'),
            'last_test_date' => get_date_converter($this->input->post('last_test_date'))
        );
        
        if ($this->Customer->save_info($customer_data, $customer_id)) {
            
            if ($gotopage == 0) {
                $this->view($customer_id, '
							<div class="alert alert-success">
								<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
								<i class="fa fa-check sign"></i><strong>Sucesso!</strong> 
								Registro atualizado com sucesso								
							</div>', 3);
            } elseif ($gotopage == 1) {
                $this->append('
							<div class="alert alert-success">
								<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
								<i class="fa fa-check sign"></i><strong>Sucesso!</strong> 
								Registro atualizado com sucesso 								
							</div>');
            }
        } else // failure
{
            $this->view($customer_id, '
						<div class="alert alert-danger">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-plus sign"></i><strong>Erro!</strong> 
							Opss.. Ocorreu um erro ao inserir ou atualizar o resgistro
						</div>
					', 3);
        }
    }

    function onchangeUF()
    {
        if ($this->input->post("setUF")) {
            
            $ibge_Mun = $this->Ibge->get_ibge_Mun($this->input->post("setUF"));
            
            $array_txt = 'var opt = [';
            
            foreach ($ibge_Mun->result() as $Mun) {
                // print_r($Mun->municipio);
                $array_txt .= '"' . $Mun->municipio . '", ';
            }
            
            $array_txt .= ']';
            
            echo $array_txt;
        } else {
            echo 'var opt[0] = "Escolha uma UF"';
        }
    }
    
    /*
     * Isso exclui os clientes da tabela de clientes
     */
    function delete($customer_id = -1)
    {
        if ($this->check_action_permission('Delete')) {
            $customers_to_delete = $customer_id;
            
            if ($this->Customer->delete_list($customers_to_delete)) {
                $this->index('
						<div class="alert alert-info">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
						<i class="fa fa-info-circle sign"></i><strong>Info!</strong>
						Foi Deletado ' . count($customers_to_delete) . ' Registro(s).
						</div>
						');
            } else {
                $this->index('
						<div class="alert alert-danger">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-times-circle sign"></i><strong>Erro!</strong> 
							Opss.. Ocorreu um erro ao deletar o(s) resgistro(s)							
						</div>
					');
            }
        } else {
            $this->index('<div class="alert alert-danger">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Voc&#234; n&#227;o possui permi&#231;&#227;o para esta a&#231;&#227;o!...
					</div>');
        }
    }

    function delete_item($customer_id = -1)
    {
        if ($this->check_action_permission('Delete')) {
            $item_to_delete = $this->input->post('serie');
            
            if ($this->Customer->delete_item($item_to_delete)) {
                
                $this->view($customer_id, '
					<div class="alert alert-info">
					<button class="close" onclick="opener.location.reload();" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-info-circle sign"></i><strong>Info!</strong>
					Foi Deletado ' . count($item_to_delete) . ' Registro(s).
					</div>
					', 2);
            } else {
                $this->view($customer_id, '
					<div class="alert alert-danger">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Ocorreu um erro ao deletar o(s) resgistro(s)
					</div>
					', 2);
            }
        } else {
            $this->view($customer_id, '<div class="alert alert-danger">
					<button class="close" aria-hidden="true" onclick="javascript:window.history.go(-1);" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Voc&#234; n&#227;o possui permiss&#227;o para deletar informa&#231;&#245;es pertinente ao registro de clientes!...
					</div>', 2);
        }
    }
    
    /*
     * Gera numero Serial do produto do Cliente
     */
    function getSerial()
    {
        return uniqid('TOP');
    }

    function mutiSelect_info()
    {
        $customer_ids = $this->input->post('customer_id');
        
        $zip = new ZipArchive();
        
        if (file_exists("upload/clientes.zip")) {
            unlink('upload/clientes.zip');
        }
        
        if ($customer_ids) {
            
            if ($zip->open('upload/clientes.zip', ZipArchive::CREATE) === true) {
                
                foreach ($customer_ids as $id) {
                    
                    // Receberá todos os dados do banco para o XML
                    $customer = $this->Customer->get_info($id);
                    
                    switch ($customer->phone_number) {
                        case 1:
                            $phone = substr($customer->phone_home, 1, 2) . substr($customer->phone_home, 5);
                            break;
                        
                        case 2:
                            $phone = substr($customer->phone_work, 1, 2) . substr($customer->phone_work, 5);
                            break;
                        
                        case 3:
                            $phone = substr($customer->phone_cell, 1, 2) . substr($customer->phone_cell, 5);
                            break;
                        
                        case 4:
                            $phone = substr($customer->phone_other, 1, 2) . substr($customer->phone_other, 5);
                            break;
                    }
                    
                    $cep = substr($customer->zip, 0, 2) . substr($customer->zip, 3, 3) . substr($customer->zip, 7);
                    
                    $length = strlen($customer->document_cpf);
                    
                    if ($length == 14) {
                        $string = substr($customer->document_cpf, 0, 3) . substr($customer->document_cpf, 4, 3) . substr($customer->document_cpf, 8, 3) . substr($customer->document_cpf, 12);
                        $document = '<CPF>' . $string . '</CPF>';
                    } elseif ($length == 19) {
                        $arra = explode('.', $customer->document_cpf);
                        $arrb = explode('/', $arra[2]);
                        $arrc = explode('-', $arrb[1]);
                        
                        $string = $arra[0] . $arra[1] . $arrb[0] . $arrc[0] . $arrc[1];
                        $document = '<CNPJ>' . $string . '</CNPJ>';
                    }
                    
                    if ($customer->address_2) {
                        $complemento = '<xCpl>' . $customer->address_2 . '</xCpl>';
                    } else {
                        $complemento = '';
                    }
                    
                    $Ibge_cMuc = $this->Ibge->get_cMun($customer->city);
                    
                    foreach ($Ibge_cMuc as $value) {
                        $cMuc = $value->codigo;
                    }
                    
                    // A raiz do meu documento XML
                    $xml = '<sistema versao="1.02" xmlns="http://www.portalfiscal.inf.br/nfe">';
                    
                    $xml .= '<dest>';
                    $xml .= $document;
                    $xml .= '<xNome>' . $customer->first_name . ' ' . $customer->last_name . '</xNome>';
                    $xml .= '<enderDest>';
                    $xml .= '<xLgr>' . $customer->address_1 . '</xLgr>';
                    $xml .= $complemento;
                    $xml .= '<xBairro>' . $customer->country . '</xBairro>';
                    $xml .= '<cMun>' . $cMuc . '</cMun>';
                    $xml .= '<xMun>' . $customer->city . '</xMun>';
                    $xml .= '<UF>' . $customer->state . '</UF>';
                    $xml .= '<CEP>' . $cep . '</CEP>';
                    $xml .= '<cPais>1058</cPais>';
                    $xml .= '<xPais>BRASIL</xPais>';
                    $xml .= '</enderDest>';
                    $xml .= '<IE>ISENTO</IE>';
                    $xml .= '<email>' . $customer->email . '</email>';
                    $xml .= '</dest>';
                    $xml .= '</sistema>';
                    
                    $arquivo = $customer->first_name;
                    
                    // Escreve o arquivo
                    $fp = fopen('upload/' . $arquivo . '.xml', 'w');
                    fwrite($fp, $xml);
                    fclose($fp);
                    
                    $zip->addFile('upload/' . $arquivo . '.xml', $arquivo . '.xml');
                }
            }
            
            $zip->close();
            
            foreach ($customer_ids as $id) {
                $customer = $this->Customer->get_info($id);
                if (file_exists('upload/' . $customer->first_name . '.xml')) {
                    unlink('upload/' . $customer->first_name . '.xml');
                }
            }
            
            if (file_exists("upload/clientes.zip")) {
                redirect(base_url() . "upload/clientes.zip");
            }
        } else {
            $this->index('<div class="alert alert-danger">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Voc&#234; deve marcar um cliente pelo menos!...
					</div>');
        }
    }
}
?>