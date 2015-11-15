<?php
require_once ("secure_area.php");

class Suppliers extends Secure_area
{

    function __construct()
    {
        parent::__construct('suppliers');
    }

    function index($manage_result = null)
    {
        $data['manage_result'] = $manage_result;
        $data['controller_name'] = 'suppliers';
        $data['num_row'] = 'FORNECEDORES REGISTRADOS <strong><font color="green">' . $this->Supplier->count_all() . '</font></strong>';
        $data['manage_table'] = get_supplier_manage_table($this->Supplier->get_all(), $this);
        $this->load->view('suppliers/suppliers', $data);
    }

    function append($supplier_id = -1)
    {
        if ($this->check_action_permission('add_update')) {
            $data['add'] = 'active';
            $data['address'] = '';
            $data['contact'] = '';
            $data['comment'] = '';
            $data['purchase'] = '';
            
            $data['active_tab_address'] = '';
            $data['active_tab_contact'] = '';
            $data['active_tab_comment'] = '';
            $data['active_tab_purchase'] = '';
            
            $this->load->view('suppliers/append', $data);
        } else {
            $this->index('<div class="alert alert-danger">
					<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Voc&#234; n&#227;o possui permi&#231;&#227;o para esta a&#231;&#227;o!...
					</div>');
        }
    }
    
    /*
     * Retorna linhas de dados da tabela cliente. Este ser� chamado com AJAX.
     */
    function search()
    {
        if ($this->check_action_permission('search')) {
            $search = $this->input->post('search');
            $data_rows = get_supplier_manage_table($this->Supplier->search($search), $this);
            
            $data['num_row'] = 'FORNECEDORES REGISTRADOS <strong><font color="green">' . $this->Supplier->count_all() . '</font></strong>';
            $data['controller_name'] = 'suppliers';
            $data['manage_table'] = $data_rows;
            $this->load->view('suppliers/suppliers', $data);
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
        $suggestions = $this->Supplier->get_search_suggestions($this->input->post('q'), $this->input->post('limit'));
        echo implode("\n", $suggestions);
    }
    
    /*
     * Loads the Supplier edit form
     */
    function view($supplier_id = -1, $manage_result = null, $i = 0)
    {
        if ($this->check_action_permission('add_update')) {
            $data['id'] = $supplier_id;
            $data['suppliers_info'] = $this->Supplier->get_info($supplier_id);
            $data['suppler_purch'] = get_supplier_item_table($this->Supplier->get_suppliers_item($supplier_id), $this);
            
            if ($i == 0) {
                $data['add'] = 'active';
                $data['address'] = '';
                $data['contact'] = '';
                $data['comment'] = '';
                $data['purchase'] = '';
            } elseif ($i == 1) {
                $data['add'] = '';
                $data['address'] = 'active';
                $data['contact'] = '';
                $data['comment'] = '';
                $data['purchase'] = '';
            } elseif ($i == 2) {
                $data['add'] = '';
                $data['address'] = '';
                $data['contact'] = 'active';
                $data['comment'] = '';
                $data['purchase'] = '';
            } elseif ($i == 3) {
                $data['add'] = '';
                $data['address'] = '';
                $data['contact'] = '';
                $data['comment'] = 'active';
                $data['purchase'] = '';
            } elseif ($i == 4) {
                $data['add'] = '';
                $data['address'] = '';
                $data['contact'] = '';
                $data['comment'] = '';
                $data['purchase'] = 'active';
            }
            
            $data['active_tab_taxes'] = 'href="#taxes" data-toggle="tab"';
            $data['active_tab_value'] = 'href="#value" data-toggle="tab"';
            
            $data['active_tab_address'] = 'href="#address" data-toggle="tab"';
            $data['active_tab_contact'] = 'href="#contact" data-toggle="tab"';
            $data['active_tab_comment'] = 'href="#comment" data-toggle="tab"';
            $data['active_tab_purchase'] = 'href="#purchase" data-toggle="tab"';
            
            $this->load->view('suppliers/append', $data);
        } else {
            $this->index('<div class="alert alert-danger">
					<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Voc&#234; n&#227;o possui permi&#231;&#227;o para esta a&#231;&#227;o!...
					</div>');
        }
    }
    
    /*
     * Inserts/updates a Supplier
     */
    function save($supplier_id = -1)
    {
        $supplier_data = array(
            'corporate_name' => ucwords(strtolower($this->input->post('corporate_name'))),
            'fancy_name' => ucwords(strtolower($this->input->post('fancy_name'))),
            'document_cnpj' => $this->input->post('document_cnpj'),
            'document_ie' => $this->input->post('document_ie'),
            'exempt' => $this->input->post('exempt')
        );
        
        if ($this->Supplier->save($supplier_data, $supplier_id)) {
            $registry = $this->Supplier->last_registry();
            
            foreach ($registry->result() as $supplier) {
                $id = $supplier->suppliers_id;
            }
            
            // New Supplier
            if ($supplier_id == - 1) {
                $this->view($id, '
						<div class="alert alert-success">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-check sign"></i><strong>Sucesso!</strong> 
							Registro inserido com sucesso ' . $supplier_data['corporate_name'] . ' ' . $supplier_data['fancy_name'] . '
						</div>', 1);
            } else // previous Supplier
{
                $this->view($supplier_id, '
						<div class="alert alert-success">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-check sign"></i><strong>Sucesso!</strong> 
							Registro atualizado com sucesso ' . $supplier_data['corporate_name'] . ' ' . $supplier_data['fancy_name'] . '
						</div>', 1);
            }
        } else // failure
{
            $this->view($id, '
						<div class="alert alert-danger">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-plus sign"></i><strong>Erro!</strong> 
							Opss.. Ocorreu um erro ao inserir ou atualizar o registro. ' . corrigeAcentuacao($supplier_data['corporate_name']) . ' ' . corrigeAcentuacao($supplier_data['fancy_name']) . '
						</div>
					', 0);
        }
    }

    function save_address($supplier_id)
    {
        $supplier_data = array(
            
            'address_1' => ucwords(strtolower($this->input->post('address_1'))),
            'address_2' => ucwords(strtolower($this->input->post('address_2'))),
            'city' => ucwords(strtolower($this->input->post('city'))),
            'state' => mb_strtoupper($this->input->post('state')),
            'zip' => $this->input->post('zip'),
            'country' => ucwords(strtolower($this->input->post('country')))
        );
        
        if ($this->Supplier->save($supplier_data, $supplier_id)) {
            $this->view($supplier_id, '
					<div class="alert alert-success">
						<button class="close" aria-hidden="true" data-dismiss="alert" type"button">x</button>
						<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
						Registro atualizado com sucesso
					</div>
					', 2);
        } else // failure
{
            $this->view($supplier_id, '
						<div class="alert alert-danger">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-plus sign"></i><strong>Erro!</strong>
							Opss.. Ocorreu um erro ao inserir ou atualizar o registro.
						</div>
					', 1);
        }
    }

    function save_contact($supplier_id)
    {
        $supplier_data = array(
            
            'phone_number' => $this->input->post('phone_number'),
            'email' => $this->input->post('email'),
            'website' => $this->input->post('website')
        );
        
        if ($this->Supplier->save($supplier_data, $supplier_id)) {
            
            $this->view($supplier_id, '
					<div class="alert alert-success">
						<button class="close" aria-hidden="true" data-dismiss="alert" type"button">x</button>
						<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
						Registro atualizado com sucesso
					</div>
					', 3);
        } else // failure
{
            $this->view($supplier_id, '
						<div class="alert alert-danger">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-plus sign"></i><strong>Erro!</strong>
							Opss.. Ocorreu um erro ao inserir ou atualizar o registro.
						</div>
					', 2);
        }
    }

    function save_comment($supplier_id)
    {
        $supplier_data = array(
            
            'comments' => $this->input->post('comments')
        );
        
        if ($this->Supplier->save($supplier_data, $supplier_id)) {
            
            $this->index('
					<div class="alert alert-success">
						<button class="close" aria-hidden="true" data-dismiss="alert" type"button">x</button>
						<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
						Registro atualizado com sucesso
					</div>
					');
        } else // failure
{
            $this->view($supplier_id, '
						<div class="alert alert-danger">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-plus sign"></i><strong>Erro!</strong>
							Opss.. Ocorreu um erro ao inserir ou atualizar o registro.
						</div>
					', 3);
        }
    }
    
    /*
     * Isso exclui os clientes da tabela de clientes
     */
    function delete($supplier_id = -1)
    {
        if ($this->check_action_permission('Delete')) {
            
            $suppliers_to_delete = $supplier_id;
            
            if ($this->Supplier->delete_list($suppliers_to_delete)) {
                $this->index('
					<div class="alert alert-info">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-info-circle sign"></i><strong>Info!</strong>
					Foi Deletado ' . count($suppliers_to_delete) . ' Registro(s).
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
					<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Voc&#234; n&#227;o possui permi&#231;&#227;o para esta a&#231;&#227;o!...
					</div>');
        }
    }
}
?>