<?php
require_once ("secure_area.php");
class Sales_teste extends Secure_area
{
	
	public function __construct()
	{
		parent::__construct('sales');
		$this->load->library('datasale');
	}
	
	public function index($manager_result=null)
	{
		
		if ($this->check_action_permission('add_update')) {
		
			if ($this->datasale->get_customer() != '-1') {
				$customer_info = $this->Customer->get_info($this->datasale->get_customer());
				$customer_work = $this->Customer->get_work($this->datasale->get_customer());
				//$customer_user = $this->Customer->get_info($this->datasale->get_customer_user());
		
				$data['customer_work'] = $customer_work;
				$data['customer_info'] = $customer_info;
				//$data['customer_user'] = $customer_user;
			}
		
			$item_list = $this->Item->get_item_categoria();
		
			if ($item_list->num_rows() != 0) {
				foreach ($item_list->result() as $items) {
					$items_list[$items->item_id] = $items->description;
				}
				$data['item_list'] = $items_list;
			} else {
				$data['item_list'] = array(
						0 => 'Não foi encontrado produtos na categoria Aparelhos'
				);
			}
		
			$data['item_selected_d'] = '-1';
			$data['item_selected_e'] = '-1';
		
			$data['menager_result'] = $manager_result;
			$data['order'] = $this->Sale->next_order();
		
		$this->load->view('sales/teste', $data);
		}
	
	}
	
	
	
	function search()
	{
		$customer_info = $this->Customer->search($this->input->post('customer'));
		//$this->datasale->set_Customer($customer_info->result()[0]->patient_id);
	
		$data['customer_info'] = $customer_info->result()[0];
		$data['order'] = $this->Sale->next_order();
	
		$item_list = $this->Item->get_item_categoria();
	
		if ($item_list->num_rows() != 0) {
			foreach ($item_list->result() as $items) {
				$items_list[$items->item_id] = $items->description;
			}
			$data['item_list'] = $items_list;
		} else {
			$data['item_list'] = array(
					0 => 'Não foi encontrado produtos na categoria Aparelhos'
			);
		}
	
		$data['item_selected_d'] = '-1';
		$data['item_selected_e'] = '-1';
	
		$this->load->view("sales/teste", $data);
	}
	
	function save()
	{
		$teste = $this->input->post();
		if (isset($teste['od']))
		{
			print_r($teste['od']);
		}
	}
}

?>