<?php
require_once ("secure_area.php");
date_default_timezone_set("Brazil/East");

class Purchases extends Secure_area
{

    function __construct()
    {
        parent::__construct('purchases');
        $this->load->library('Purch_lib');
    }

    function index($manage_result = null, $data = null)
    {
        
        // -------------- busca lista de fornecedores -------------------------
        $fornecedor = $this->Supplier->get_all();
        
        if ($fornecedor->num_rows() != 0) {
            foreach ($fornecedor->result() as $fornecedores) {
                $rows[$fornecedores->suppliers_id] = $fornecedores->fancy_name;
            }
            
            $data['supplier_info'] = $rows;
        } else {
            $data['supplier_info'] = array(
                'Não há registro de fornecedores.'
            );
        }
        
        if (empty($data['fornecedor_get'])) {
            $data['fornecedor_get'] = $this->purch_lib->get_forn();
            
            $value = $this->Purchase->get_seted_forn($this->purch_lib->get_forn());
            $data['seted_forn'] = $value->fancy_name;
        } else {
            $value = $this->Purchase->get_seted_forn($this->purch_lib->get_forn());
            $data['seted_forn'] = $value->fancy_name;
        }
        
        // ------------------- busca lista de departamentos -------------------------
        
        $departamento = $this->Department->get_all();
        
        if ($departamento->num_rows() != 0) {
            foreach ($departamento->result() as $departamentos) {
                $rows2[$departamentos->department_id] = $departamentos->name;
            }
            
            $data['department_info'] = $rows2;
        } else {
            $data['department_info'] = array(
                'Não há registro de fornecedores.'
            );
        }
        if (empty($data['departamento_get']))
            $data['departamento_get'] = $this->purch_lib->get_dept();
            
            // ------------ busca lista de produtos -------------------------
        $item = $this->Item->get_all();
        // $rows3[0] = '&nbsp;&nbsp;';
        
        if ($item->num_rows() != 0) {
            foreach ($item->result() as $items) {
                $rows3[$items->item_id] = $items->description;
            }
            
            $data['items_info'] = $rows3;
        } else {
            $data['items_info'] = array(
                'Não há registro de fornecedores.'
            );
        }
        
        // ------------ busca lista de Tipos unitarios -------------------------
        
        $data['unidade'] = $this->Purchase->destiny();
        
        // ----------------------------------------------------------------------
        $data['manage_result'] = $manage_result;
        
        $pedido = $this->Purchase->last(); // Pega a linha inteira que cont�m o n�mero do �ltimo ID
                                            
        // $next = $pedido->num_pedido+1;
                                            // $this->purch_lib->set_order($next); //Instancia sess�o de ordem e adiciona +1 ao pedido
        setlocale(LC_ALL, "pt_BR");
        $numero = $this->purch_lib->get_order();
        
        $data['manage_table_row'] = '';
        
        $resultado = $this->Purchase->db_list_itens($numero);
        $n = $resultado->result_array();
        
        for ($i = 0; $i < $resultado->num_rows(); $i ++) {
            $data['manage_table_row'] .= '<tr>
	    		 	<td>' . $this->Purchase->retorna_name($n[$i]["produto"]) . '</td>
	    		  	<td class="text-center">' . $n[$i]["unidade"] . '</td>
	    		  	<td class="text-right"><span style="margin-right:5px;">' . money_format('%n', $n[$i]["valorunit"]) . '</span></td>
	    		  	<td class="text-right"><span style="margin-right:5px;">' . $n[$i]["quantidade"] . '</span></td>
	    		  	<td class="text-right"><span style="margin-right:5px;">' . money_format('%n', $n[$i]["vtotal"]) . '</span></td>
	    		  	<td class="text-center">
	    		  		<a href="' . $this->config->site_url('purchases/deleteitem/' . $n[$i]["id"] . '') . '" class="label label-danger"><i class="fa fa-times"></i></a>
	    		  	</td>
	    		</tr>';
        }
        
        $data['numero'] = $this->purch_lib->get_order();
        
        $valortotal = $this->Purchase->total($this->purch_lib->get_order());
        $pegaresultado = $valortotal->result();
        
        $data['valortotal'] = $pegaresultado[0]->vtotal;
        
        // $data['manage_table'] = purch_list_itens_manage_table($this->Purchase->db_list_itens($next), $this);
        
        $data['next'] = $this->purch_lib->get_order(); // Verifica a sessão
        
        $this->load->view('purchases/purchases2', $data);
    }

    function deleteitem($item)
    {
        $this->Purchase->del_item($item);
        redirect('purchases/pedido/' . $this->purch_lib->get_order());
    }

    function save_itens()
    {
        // verifica se está na lista
        // print_r($this->input->post());
        // echo $this->Purchase->esta_na_lista($this->input->post('produto'), $this->input->post('pedido'));
        // echo gettype($this->Purchase->esta_na_lista($this->input->post('produto'), $this->input->post('pedido')));
        // exit();
        if ($this->Purchase->esta_na_lista($this->input->post('produto'), $this->input->post('pedido')) == 0) {
            $itens_data = array(
                'pedido' => $this->input->post('pedido'),
                'produto' => $this->input->post('produto'),
                'unidade' => ($this->input->post('un')),
                'valorunit' => ($this->input->post('valorunit')),
                'quantidade' => ($this->input->post('quant')),
                'vtotal' => ($this->input->post('vtotal'))
            );
            
            if ($this->Purchase->save_itens_all($itens_data)) {
                $this->index('<div class="alert alert-success">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
						<i class="fa fa-check sign"></i><strong>Sucesso!</strong> 
						Registro atualizado com sucesso.
					</div>');
            } else {
                $this->index('<div class="alert alert-danger">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
						<i class="fa fa-plus sign"></i><strong>Erro!</strong> 
						Opss.. Ocorreu um erro ao inserir ou atualizar o registro.
					</div>');
            }
        } else {
            
            $pedido2 = $this->input->post('pedido');
            $produto2 = $this->input->post('produto');
            $vtotal = $this->input->post('valorunit');
            $quantidade = $this->input->post('quant');
            $unit = $this->input->post('valorunit');
            
            if ($this->Purchase->soma_no_pedido($quantidade, $produto2, $pedido2, $unit, $vtotal)) {
                $this->index('<div class="alert alert-success">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">X</button>
						<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
						Quantidade <u>acrescentada !</u> *.
					</div>');
            } else {
                $this->index('<div class="alert alert-danger">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
						<i class="fa fa-plus sign"></i><strong>Erro!</strong>
						Houve um problema ao inserir a soma na quantidade deste item, por favor contate o suporte NTIC.
					</div>');
            }
        }
    }

    function pedido($numero)
    {
        $this->purch_lib->set_order($numero);
        $data['numero'] = $numero;
        $data['departamento_get'] = $this->purch_lib->get_dept();
        $data['fornecedor_get'] = $this->purch_lib->get_forn();
        
        $this->index($manage_result = null, $data);
        // redirect('purchases');
    }
    
    // -------------------------------------------------------------------------------------------------
    function gera_contas_pagar($pedido)
    {
        for ($i = 0; $i < count($this->input->post('parcelaval')); $i ++) {
            $pagamento = $this->input->post('formapgto')[$i];
            
            switch ($pagamento) {
                case 0:
                    $payment = 'Dinheiro';
                    break;
                
                case 1:
                    $payment = 'Boleto';
                    break;
                
                case 2:
                    $payment = 'Cheque';
                    break;
                
                case 3:
                    $paymepnt = 'Cartão: Crédito';
                    break;
                
                case 4:
                    $payment = 'Cartão: Débito';
                    break;
                
                case 5:
                    $payment = 'Transferência Bancária';
                    break;
                
                default:
                    $payment = 'Dinheiro';
                    break;
            }
            
            $databr = $this->input->post('datavencimento')[$i];
            $a = explode('/', $databr);
            
            $data = $a[2] . '-' . $a[1] . '-' . $a[0];
            
            $array_financeiro = array(
                'number' => $pedido,
                'date' => $data,
                'favored' => $this->input->post('fornecedor'), // fornecedor
                'operation' => 1,
                'plan_accounts' => '02.09.01',
                'payment_form' => $payment,
                'cost_center' => $this->input->post('parcelaval')[$i],
                'value' => $this->input->post('parcelaval')[$i],
                'historic' => 'Pedido de Compra',
                'deleted' => 0
            );
            
            $this->Item->gera_conta_pagar($array_financeiro);
        }
        
        if (! empty($this->input->post('contato1'))) {
            $contato1 = 1;
        } else {
            $contato1 = 0;
        }
        if (! empty($this->input->post('contato2'))) {
            $contato2 = 1;
        } else {
            $contato2 = 0;
        }
        if (! empty($this->input->post('contato3'))) {
            $contato3 = 1;
        } else {
            $contato3 = 0;
        }
        
        $array_post = array(
            'num_pedido' => $pedido,
            'fornecedor' => $this->input->post('fornecedor'),
            'departamento' => $this->input->post('departamento'),
            'situacao' => 'Pedido',
            'telefonado' => $contato1,
            'emailed' => $contato2,
            'website' => $contato3
        );
        
        $this->Purchase->gerarpc($array_post, $pedido);
        
        redirect("pclista");
    }
    // -------------------------------------------------------------------------------------------------
    function lista($manage_result = null)
    {
        $data['manage_result'] = $manage_result;
        $this->load->view('purchases/lista', $data);
    }
    
    // ---------------------------------------------------------------------------------------------------------------
    function purchases($manage_result = null)
    {
        $data['manage_result'] = $manage_result;
        $this->load->view('purchases/purchases', $data);
    }
    // ---------------------------------------------------------------------------------------------------------------
    function entrada($manage_result = null)
    {
        $data['manage_result'] = $manage_result;
        $this->load->view('purchases/entrada', $data);
    }
    
    // ---------------------------------------------------------------------------------------------------------------
    function situacao($manage_result = null)
    {
        $data['manage_result'] = $manage_result;
        $this->load->view('purchases/situacao', $data);
    }
    
    // ---------------------------------------------------------------------------------------------------------------
    function info($manage_result = null)
    {
        $data['manage_result'] = $manage_result;
        $this->load->view('purchases/info', $data);
    }
    
    // ---------------------------------------------------------------------------------------------------------------
    function pedidos($manage_result = null)
    {
        if ($this->purch_lib->get_order() == - 1) {
            $pedido = $this->Purchase->last(); // Pega a linha inteira que contém o número do último ID
            $this->purch_lib->set_order($pedido->id + 1); // Instancia sessão de ordem e adiciona +1 ao pedido
            $data['next'] = $this->purch_lib->get_order(); // Verifica a sessão
            $data['manage_result'] = $manage_result;
            
            $this->load->view('purchases/index', $data);
        } else {
            $this->editar($this->purch_lib->get_order(), 1);
        }
    }

    function seta_departamento()
    {
        $this->purch_lib->set_dept($this->input->post('departamento'));
        echo $this->purch_lib->get_order();
    }

    function seta_fornecedor()
    {
        $this->purch_lib->set_forn($this->input->post('fornecedor'));
        echo $this->purch_lib->get_order();
    }

    function get_forn_info($id)
    {
        echo $this->Purchase->get_tel($id);
    }

    function get_forn_email($id)
    {
        echo $this->Purchase->get_email($id);
    }
}