<?php
require_once ("secure_area.php");

class Items_invent extends Secure_area
{

    function __construct()
    {
        parent::__construct('items');
    }

    function index($location_id = 1, $manage_result = null, $data = null)
    {
        setlocale(LC_MONETARY, 'pt_BR');
        $a = $this->General->select("item_id, description, unit, is_serialized", "items", NULL, NULL, NULL, "description", "asc");
        $r = $a->result_array();
        
        $data['table1'] = '';
        $totalCost = array();
        // $totalSell = array();
        $qtd = array();
        $Unitotal = array();
        $TotalTotal = array();
        
        $data['empresa'] = $this->General->select2("*", "enterprise", array(
            'enterprise_id' => $location_id
        ))->row();
        $e = $this->General->select2("*", "enterprise")->result_array();
        
        $data['enterprise'] = '';
        
        foreach ($e as $enterprise) {
            $data['enterprise'] .= '<option value="' . $enterprise['enterprise_id'] . '">' . $enterprise['fantasia'] . '</option>';
        }
        
        for ($i = 0; $i < $a->num_rows(); $i ++) {
            $data['table1'] .= '<tr id="' . $r[$i]["item_id"] . '">
				<td>' . $r[$i]["description"] . '</td>
				<td class="text-center">' . $r[$i]["unit"] . '</td>';
            
            // Se o item for serializado: fazer quantidade de acordo com num_rows() daquele item pelo item_id, isso será a quantidade
            
            if ($r[$i]["is_serialized"] == 1) {
                $num_rows_qtd = $this->General->select("id", "items_serie", array(
                    'item_id' => $r[$i]["item_id"],
                    'location_id' => $location_id
                ))->num_rows();
                
                $data['table1'] .= '<td class="text-right">' . $num_rows_qtd . '</td>';
                $qtd[$i] = $num_rows_qtd;
            } else {
                $quantity = $this->General->select("quantity", "items_value", array(
                    "item_id" => $r[$i]["item_id"],
                    'location_id' => $location_id
                ));
                
                if ($quantity->num_rows() != 0) {
                    $data['table1'] .= '<td class="text-right">' . $quantity->row()->quantity . '</td>';
                    $qtd[$i] = $quantity->row()->quantity;
                } else {
                    $data['table1'] .= '<td class="text-right">0</td>';
                    $qtd[$i] = 0;
                }
            }
            
            // Verifica se há item com preço de custo e venda e coloca próxima celula da tabela
            $costs = $this->General->select("cost_purchese", "items_business", array(
                "item_id" => $r[$i]["item_id"]
            ));
            
            if ($costs->num_rows() > 0) {
                $data['table1'] .= '<td class="text-right">' . money_format('%n', $costs->row()->cost_purchese) . '</td>
						 <td class="text-right">' . money_format('%n', ($costs->row()->cost_purchese * $qtd[$i])) . '</td>';
                
                $totalCost[$i] = $costs->row()->cost_purchese;
                // $totalSell[$i] = $costs->row()->selling_price;
                $Unitotal[$i] = $costs->row()->cost_purchese * $qtd[$i];
                // $TotalTotal[$i] = $costs->row()->selling_price * $qtd[$i];
            } else {
                $data['table1'] .= '<td class="text-right">R$ 0,00</td>
						 <td class="text-right">R$ 0,00</td>';
                $totalCost[$i] = 0.00;
                // $totalSell[$i] = 0.00;
                $Unitotal[$i] = 0.00;
                $TotalTotal[$i] = 0.00;
            }
            
            $data['table1'] .= '</tr>';
        }
        
        $data['TotalC'] = array_sum($totalCost);
        // $data['TotalS'] = money_format('%n', array_sum($totalSell));
        $data['QTD'] = array_sum($qtd);
        $data['Unitotal'] = array_sum($Unitotal);
        $data['totaltotal'] = array_sum($TotalTotal);
        
        $this->load->view("items/items_inventory", $data);
    }

    function get_tabela($location_id)
    {
        date_default_timezone_set("Brazil/East");
        setlocale(LC_MONETARY, 'pt_BR');
        $a = $this->General->select("item_id, description, unit, is_serialized", "items", NULL, NULL, NULL, "description", "asc");
        $r = $a->result_array();
        
        $data['table1'] = '';
        $totalCost = array();
        // $totalSell = array();
        $qtd = array();
        $Unitotal = array();
        $TotalTotal = array();
        
        $e = $this->General->select2("*", "enterprise")->result_array();
        $data['enterprise'] = '';
        foreach ($e as $enterprise) {
            $data['enterprise'] .= '<option value="' . $enterprise['enterprise_id'] . '">' . $enterprise['fantasia'] . '</option>';
        }
        
        for ($i = 0; $i < $a->num_rows(); $i ++) {
            $data['table1'] .= '<tr id="' . $r[$i]["item_id"] . '">
				<td>' . $r[$i]["description"] . '</td>
				<td class="text-center">' . $r[$i]["unit"] . '</td>';
            
            // Se o item for serializado: fazer quantidade de acordo com num_rows() daquele item pelo item_id, isso será a quantidade
            
            if ($r[$i]["is_serialized"] == 1) {
                $num_rows_qtd = $this->General->select("id", "items_serie", array(
                    'item_id' => $r[$i]["item_id"],
                    'location_id' => $location_id
                ))->num_rows();
                
                $data['table1'] .= '<td class="text-right">' . $num_rows_qtd . '</td>';
                $qtd[$i] = $num_rows_qtd;
            } else {
                $quantity = $this->General->select("quantity", "items_value", array(
                    "item_id" => $r[$i]["item_id"],
                    'location_id' => $location_id
                ));
                
                if ($quantity->num_rows() != 0) {
                    $data['table1'] .= '<td class="text-right">' . $quantity->row()->quantity . '</td>';
                    $qtd[$i] = $quantity->row()->quantity;
                } else {
                    $data['table1'] .= '<td class="text-right">0</td>';
                    $qtd[$i] = 0;
                }
            }
            
            // Verifica se há item com preço de custo e venda e coloca próxima celula da tabela
            $costs = $this->General->select("cost_purchese", "items_business", array(
                "item_id" => $r[$i]["item_id"]
            ));
            
            if ($costs->num_rows() > 0) {
                $data['table1'] .= '<td class="text-right">' . money_format('%n', $costs->row()->cost_purchese) . '</td>
						 <td class="text-right">' . money_format('%n', ($costs->row()->cost_purchese * $qtd[$i])) . '</td>';
                
                $totalCost[$i] = $costs->row()->cost_purchese;
                // $totalSell[$i] = $costs->row()->selling_price;
                $Unitotal[$i] = $costs->row()->cost_purchese * $qtd[$i];
                // $TotalTotal[$i] = $costs->row()->selling_price * $qtd[$i];
            } else {
                $data['table1'] .= '<td class="text-right">R$ 0,00</td>
						 <td class="text-right">R$ 0,00</td>';
                $totalCost[$i] = 0.00;
                // $totalSell[$i] = 0.00;
                $Unitotal[$i] = 0.00;
                $TotalTotal[$i] = 0.00;
            }
            
            $data['table1'] .= '</tr>';
        }
        
        $data['TotalC'] = array_sum($totalCost);
        // $data['TotalS'] = money_format('%n', array_sum($totalSell));
        $data['QTD'] = array_sum($qtd);
        $data['Unitotal'] = array_sum($Unitotal);
        $data['totaltotal'] = array_sum($TotalTotal);
        $empresa = $this->General->select2("*", "enterprise", array(
            'enterprise_id' => $location_id
        ))->row();
        $x = substr($empresa->cnpj, 0, 2) . "." . substr($empresa->cnpj, 2, 3) . "." . substr($empresa->cnpj, 5, 3) . "/" . substr($empresa->cnpj, 8, 4) . "-" . substr($empresa->cnpj, 12, 2);
        $y = substr($empresa->ie, 0, 3) . '.' . substr($empresa->ie, 3, 3) . '.' . substr($empresa->ie, 6, 3);
        
        echo '<h5>' . $empresa->razaosocial . '<span style="float:right;">CNPJ: ' . $x . '</span></h5>
				<h5>INSC. Estadual: ' . $y . '<span style="float:right;">Estoque existente em ' . date('d/m/Y') . '</span></h5>
				<table class="table no-border hover">		
					<thead class="no-border">
						<tr>
							<th><strong>Descrição</strong></th>
							<th class="text-center"><strong>UN</strong></th>
							<th class="text-right"><strong>Qtde.</strong></th>
							<th class="text-right"><strong>Custo</strong></th>
							<th class="text-right"><strong>Custo Total</stronug></th>
						</tr>			
					</thead>
					<tbody class="no-border-y" id="size">';
        if (isset($data['table1'])) {
            echo $data['table1'];
        } else {
            echo '<tr><td colspan="6">Não há produtos para serem mostrados</td></tr>';
        }
        echo '</tbody>
					<tfoot class="no-border-y">';
        
        if (isset($data['TotalC']) && ($data['TotalC'] != '')) {
            echo '<tr>
									<td colspan="2"><strong>TOTAL:</strong></td>
									<td class="text-right"><strong>' . $data['QTD'] . '</strong></td>
									<td class="text-right"><strong>' . money_format('%n', $data['TotalC']) . '</strong></td>
   									<td class="text-right"><strong>' . money_format('%n', $data['Unitotal']) . '</strong></td>
								</tr>';
        }
        
        echo '</tfoot>
				</table>';
    }
    
    
    function save()
    {
        date_default_timezone_set('America/Sao_Paulo');        
        $enterprise = $this->Enterprise->get_info($this->input->post('enterprise_id'));        
        $items_all = $this->Item->get_all(); 
        
        $report_inventary = array(
            'enterprise_id' => $enterprise->enterprise_id,
            'date_print' => date('Y-m-d')
        );
        
       
        $success = $this->db->insert('report_inventary', $report_inventary);
        
        $this->db->select_max('id');
        $report = $this->db->get('report_inventary');
        
        $get_id = $report->result()[0]->id;
        
        
        if($success == true)
        {
           
            
            foreach ($items_all->result() as $item) 
            {
                
               
                $business = $this->Item->get_info_business($item->item_id);
                
                
                if($item->is_serialized == 0)
                {
                    $qtde = $this->Item->get_info_value($item->item_id);
                    
                    $report_item_inventary = array(
                        'inventary_id' => $get_id,
                        'item_id' => $item->item_id,
                        'item_qtde' => $qtde->quantity,
                        'item_cust' => $business->cost_purchese
                    );
                    
                }
                elseif ($item->is_serialized == 1)
                {
                    
                    $this->db->from('items_serie');
                    $this->db->where('item_id', $item->item_id);
                    $query = $this->db->get();
                    
                    
                    $report_item_inventary = array(
                        'inventary_id' => $get_id,
                        'item_id' => $item->item_id,
                        'item_qtde' => $query->num_rows(),
                        'item_cust' => $business->cost_purchese
                    );
                    
                }
                
                $success = $this->db->insert('report_item_inventary', $report_item_inventary);
                
                    
            }
            
           if($success == true)
           {
               echo 'Inventario '.PHP_EOL
               .$enterprise->razaosocial.PHP_EOL.PHP_EOL.
               'Registrado em '.date('d/m/Y').' pelo sistema'.PHP_EOL.PHP_EOL;
           } 
            
        }
        
        
    }
}