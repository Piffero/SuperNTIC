<?php
require_once ("secure_area.php");

class Fleets extends Secure_area
{

    function __construct()
    {
        parent::__construct('fleets');
    }

    function index($manage_result = null)
    {
        $data['manage_result'] = $manage_result;
        $data['controller_name'] = 'fleets';
        $data['manage_table'] = get_fleet_manage_table($this->Fleet->get_all(), $this);
        $this->load->view('fleets/fleets', $data);
    }

    function append($fleets_id = -1)
    {
        $data['fleets_info'] = $this->Fleet->get_info($fleet_id);
        $this->load->view('fleets/append', $data);
    }
    
    /*
     * Retorna linhas de dados da tabela frota. Este ser� chamado com AJAX.
     */
    function search()
    {
        $search = $this->input->post('search');
        $data_rows = get_fleet_manage_table($this->Fleet->search($search), $this);
        
        $data['controller_name'] = 'fleets';
        $data['manage_table'] = $data_rows;
        $this->load->view('fleets/fleets', $data);
    }
    
    /*
     * Gives search suggestions based on what is being searched for
     */
    function suggest()
    {
        $suggestions = $this->Fleet->get_search_suggestions($this->input->post('q'), $this->input->post('limit'));
        echo implode("\n", $suggestions);
    }
    
    /*
     * Loads the customer edit form
     */
    function view($fleet_id = -1)
    {
        $data['id'] = $fleet_id;
        $data['fleets_info'] = $this->Fleet->get_info($fleet_id);
        // $data['active_tab_taxes']='href="#taxes" data-toggle="tab"';
        // $data['active_tab_value']='href="#value" data-toggle="tab"';
        $this->load->view('fleets/append', $data);
    }
    
    /*
     * Inserts/updates a customer
     */
    function save($fleet_id = -1)
    {
        $flet_data = array(
            'fleet_number' => $this->input->post('fleet_number'),
            'supplier_id' => $this->input->post('supplier_id'),
            'description' => $this->input->post('description'),
            'category' => $this->input->post('category'),
            'unit' => $this->input->post('unit'),
            'code_EAN' => $this->input->post('code_EAN'),
            'code_NCM' => $this->input->post('code_NCM'),
            'code_TIPI' => $this->input->post('code_TIPI'),
            'code_CFOP' => $this->input->post('code_CFOP'),
            'stok_min' => $this->input->post('stok_min'),
            'stok_max' => $this->input->post('stok_max'),
            'is_serialized' => $this->input->post('is_serialized'),
            'is_service' => $this->input->post('is_service')
        );
        
        if ($fleet_id) {
            
            // New customer
            if ($fleet_id == - 1) {
                $this->Fleet->save($fleet_data, $fleet_id);
                $this->index('
						<div class="alert alert-success">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-check sign"></i><strong>Sucesso!</strong> 
							Registro inserido com sucesso ' . corrigeAcentuacao($fleet_data['fleet_number']) . ' ' . corrigeAcentuacao($fleet_data['description']) . '
						</div>');
            } else // previous customer
{
                $this->Fleet->save($customer_data, $customer_id);
                $this->index('
						<div class="alert alert-success">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-check sign"></i><strong>Sucesso!</strong> 
							Registro atualizado com sucesso ' . corrigeAcentuacao($fleet_data['fleet_number']) . ' ' . corrigeAcentuacao($fleet_data['description']) . '								
						</div>');
            }
        } else // failure
{
            $this->index('
						<div class="alert alert-danger">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-plus sign"></i><strong>Erro!</strong> 
							Opss.. Ocorreu um erro ao inserir ou atualizar o resgistro ' . corrigeAcentuacao($fleet_data['fleets_number']) . ' ' . corrigeAcentuacao($fleet_data['description']) . '
						</div>
					');
        }
    }
    
    /*
     * Isso exclui os clientes da tabela de clientes
     */
    function delete($fleet_id = -1)
    {
        if ($this->check_action_permission('Delete')) {
            
            $fleets_to_delete = $fleet_id;
            
            if ($this->Fleet->delete_list($fleet_to_delete)) {
                $this->index('
						<div class="alert alert-info">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
						<i class="fa fa-info-circle sign"></i><strong>Erro!</strong>
						Foi Deletado ' . count($fleets_to_delete) . ' Registro(s).
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