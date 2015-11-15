<?php
require_once ("secure_area.php");

class Sales extends Secure_area
{

    function __construct()
    {
        parent::__construct('sales');
        $this->load->library('datasale');
    }

    function index($manager_result = null)
    {
        if ($this->check_action_permission('add_update')) {
            
            if ($this->datasale->get_customer() != '-1') {
                $customer_info = $this->Customer->get_info($this->datasale->get_customer());
                $customer_work = $this->Customer->get_work($this->datasale->get_customer());
                $customer_user = $this->Customer->get_info($this->datasale->get_customer_user());
                
                $data['customer_work'] = $customer_work;
                $data['customer_info'] = $customer_info;
                $data['customer_user'] = $customer_user;
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
            
            $this->load->view("sales/budget", $data);
        }
    }
    
    /* ***************************************************************************** */
    /*
     * Funções responsaveis por buscar determinado Cliente/Usuário na tabela patient
     * /* *****************************************************************************
     */
    function search()
    {
        $customer_info = $this->Customer->search($this->input->post('customer'));
        $this->datasale->set_Customer($customer_info->result()[0]->patient_id);
        
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
        
        $this->load->view("sales/budget", $data);
    }

    function search_user()
    {
        $customer_user = $this->Customer->search($this->input->post('customer'));
        $this->datasale->set_Customer_user($customer_user->result()[0]->patient_id);
        
        $customer_info = $this->Customer->get_info($this->datasale->get_customer());
        $customer_work = $this->Customer->get_work($this->datasale->get_customer());
        
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
        
        $data['customer_work'] = $customer_work;
        $data['customer_info'] = $customer_info;
        $data['customer_user'] = $customer_user->result()[0];
        $data['order'] = $this->Sale->next_order();
        
        $this->load->view("sales/budget", $data);
    }
    
    /* ***************************************************************************** */
    
    /* ***************************************************************************** */
    /*
     * Funções responsaveis por buscar Cliente comprador e tornalo usuario
     * /* *****************************************************************************
     */
    function check_customer_user()
    {
        $customer_info = $this->Customer->get_info($this->datasale->get_customer());
        $customer_work = $this->Customer->get_work($this->datasale->get_customer());
        $customer_user = $this->Customer->get_info($this->datasale->get_customer());
        
        $this->datasale->set_Customer_user($customer_user->patient_id);
        
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
        
        $data['customer_work'] = $customer_work;
        $data['customer_info'] = $customer_info;
        $data['customer_user'] = $customer_user;
        $data['order'] = $this->Sale->next_order();
        
        $this->load->view("sales/budget", $data);
    }
    
    /* ***************************************************************************** */
    /*
     * Funções responsaveis por buscar e mostrar os numeros de serie de um determinado
     * /* Aparelho
     * /* *****************************************************************************
     */
    function open_serie($arg)
    {
        $x = explode('.', $arg);
        $local = $x[0];
        $item = $x[1];
        
        $series = $this->Item->get_serie($item);
        if ($series != null) {
            if ($series->num_rows() != 0) {
                $lista = '<div class="list-group todo list-widget">';
                
                foreach ($series->result() as $serie) {
                    $lista .= '<li class="list-group-item"><span class="date"><i class="fa fa-key"></i> ' . $serie->item_serie . '</span>' . $serie->trans_date . '</li>';
                }
                
                $data['list_series'] = $lista;
                $this->load->view('sales/list_serie', $data);
            } else {
                $data['list_series'] = '<p>Este item não possui numeros de Series associados.<p>';
                $this->load->view('sales/list_serie', $data);
            }
        } else {
            $data['list_series'] = '<p>Este item não possui numeros de Series associados.<p>';
            $this->load->view('sales/list_serie', $data);
        }
    }
    
    /* ***************************************************************************** */
    
    /* ***************************************************************************** */
    /*
     * Funções get set dos dados do cliente
     * /* *****************************************************************************
     */
    function open_trade()
    {
        $data['customer_work'] = $this->Customer->get_work($this->datasale->get_customer());
        $this->load->view('sales/data_trade', $data);
    }
    
    /* ***************************************************************************** */
    /*
     * Funções responsavel pelo calculo da proposta de venda
     * /* *****************************************************************************
     */
    function set_value_for_sales()
    {
        if ($this->input->post()) {
            foreach ($this->input->post() as $item_id) {
                $data_item[] = $item_id;
            }
            
            $values_sales = $this->Sale->set_value_for_sales($data_item);
            
            if (count($data_item) > 1) {
                if ($data_item[0] == $data_item[1]) {
                    $totalCompra = $values_sales->result()[0]->selling_price * 2;
                    echo $totalCompra;
                } else {
                    $totalCompra = $values_sales->result()[0]->selling_price + $values_sales->result()[1]->selling_price;
                    echo $totalCompra;
                }
            } else {
                $totalCompra = $values_sales->result()[0]->selling_price;
                echo $totalCompra;
            }
        } else {
            echo '0.00';
        }
    }

    function set_garantia_fabrica()
    {
        // Aqui deve ser fazer o sistema de log
        // para acomanhamento dos registro de produtos
        echo '<script>self.close();</script>';
    }

    function set_garantia_venda()
    {
        $item = $this->datasale->get_items_serie_d();
        $nMeses = $this->input->post('number_meses');
        
        $arr = array(
            'garantia' => $nMeses
        );
        
        if ($this->Item->save($arr, $item)) {
            echo '<script>self.close();</script>';
        } else {
            echo '<p> Não foi possivel salvar as informações referente a garantia </p>';
            echo '<button onclick="self.close();">OK</button>';
        }
    }
    
    /* ***************************************************************************** */
    /*
     * Funções Responsaveis por armazenar os dados no banco
     * /* *****************************************************************************
     */
    function save_trade()
    {
        $data_work = $this->input->post();
        
        // valida casos
        $arg_pro = $this->valida_produto($data_work['set_direito'], $data_work['set_esquerdo']);
        $arg_ald = $this->valida_ald($data_work['set_ald_direito'], $data_work['set_ald_esquerdo']);
        $total = $this->valida_venda($data_work, $arg_pro);
        $desconto = $this->valida_descoto($data_work, $arg_ald);
        
        /*
         * SALVAR AS INFORMAÇÕES REFERENTE A:
         *
         * da venda com seus totais;
         * do aparelho vendido em sequida;
         * do transferência de aparelho no ato da venda;
         */
        
        $save_item = $this->save_item($data_work, $arg_pro);
        $save_desconto = $this->save_desconto($data_work, $arg_ald);
        $save_venda = $this->save_venda($data_work);
        
        /*
         * SALVA AS INFORMAÇÕES DO APARELHO DO CLIENTE
         * EFETUA UM LANÇAMENTO EM CONTAS A RECEBER
         */
        
        $status = $this->set_customer_item($save_item);
        $status = $this->set_account_venda($save_venda);
        
        echo $this->config->site_url('sales_lista');
    }

    function save_item($data_work, $arg_pro)
    {
        $next_order = $this->Sale->next_order();
        date_default_timezone_set('America/Sao_Paulo');
        
        // prepara array referente ao produto
        $success = false;
        
        switch ($arg_pro) {
            case 1:
                $item_info = $this->Item->get_info($data_work['item_direito']);
                $item_serie = $this->Item->get_serie_info($data_work['serie_direito']);
                
                $date_fab = $this->valida_garantia_fabrica($item_info->garantia_fabrica, $item_serie);
                $date_ven = $this->valida_garantia_venda($item_info->garantia, $item_info->item_id);
                
                $pro_data = array(
                    'order_id' => $next_order->order,
                    'patient_id' => $this->datasale->get_customer_user(),
                    'item_id' => $data_work['item_direito'],
                    'color' => 'Direito',
                    'number_serie' => $data_work['serie_direito'],
                    'suppliers_data' => date('Y-m-d', strtotime($date_fab)),
                    'purchase_date' => date('Y-m-d'),
                    'expires_data' => date('Y-m-d', strtotime($date_ven))
                );
                
                $this->Sale->save_item($pro_data);
                
                $success = $pro_data;
                break;
            
            case 2:
                $item_info = $this->Item->get_info($data_work['item_esquerdo']);
                $item_serie = $this->Item->get_serie_info($data_work['serie_esquerdo']);
                
                $date_fab = $this->valida_garantia_fabrica($item_info->garantia_fabrica, $item_serie);
                $date_ven = $this->valida_garantia_venda($item_info->garantia, $item_info->item_id);
                
                $pro_data = array(
                    'order_id' => $next_order->order,
                    'patient_id' => $this->datasale->get_customer_user(),
                    'item_id' => $data_work['item_esquerdo'],
                    'color' => 'Esquerdo',
                    'number_serie' => $data_work['serie_esquerdo'],
                    'suppliers_data' => date('Y-m-d', strtotime($date_fab)),
                    'purchase_date' => date('Y-m-d'),
                    'expires_data' => date('Y-m-d', strtotime($date_ven))
                );
                
                $this->Sale->save_item($pro_data);
                $success = $pro_data;
                break;
            
            case 3:
                $item_info = $this->Item->get_info($data_work['item_direito']);
                $item_serie = $this->Item->get_serie_info($data_work['serie_direito']);
                
                $date_fab = $this->valida_garantia_fabrica($item_info->garantia_fabrica, $item_serie);
                $date_ven = $this->valida_garantia_venda($item_info->garantia, $item_info->item_id);
                
                $pro_data = array(
                    'order_id' => $next_order->order,
                    'patient_id' => $this->datasale->get_customer_user(),
                    'item_id' => $data_work['item_direito'],
                    'color' => 'Direito',
                    'number_serie' => $data_work['serie_direito'],
                    'suppliers_data' => date('Y-m-d', strtotime($date_fab)),
                    'purchase_date' => date('Y-m-d'),
                    'expires_data' => date('Y-m-d', strtotime($date_ven))
                );
                
                $this->Sale->save_item($pro_data);
                $OD = $pro_data;
                
                $item_info = $this->Item->get_info($data_work['item_esquerdo']);
                $item_serie = $this->Item->get_serie_info($data_work['serie_esquerdo']);
                
                $date_fab = $this->valida_garantia_fabrica($item_info->garantia_fabrica, $item_serie);
                $date_ven = $this->valida_garantia_venda($item_info->garantia, $item_info->item_id);
                
                $pro_data = array(
                    'order_id' => $next_order->order,
                    'patient_id' => $this->datasale->get_customer_user(),
                    'item_id' => $data_work['item_esquerdo'],
                    'color' => 'Esquerdo',
                    'number_serie' => $data_work['serie_esquerdo'],
                    'suppliers_data' => date('Y-m-d', strtotime($date_fab)),
                    'purchase_date' => date('Y-m-d'),
                    'expires_data' => date('Y-m-d', strtotime($date_ven))
                );
                
                $this->Sale->save_item($pro_data);
                $OE = $pro_data;
                
                $success[] = $OD;
                $success[] = $OE;
                
                break;
            
            case 4:
                $success = array();
                break;
        }
        
        return $success;
    }

    function save_desconto($data_work, $arg_ald)
    {
        $next_order = $this->Sale->next_order();
        
        // prepara array trasferencia do produto no ato da venda
        $success = false;
        
        switch ($arg_ald) {
            case 1:
                $ald_data = array(
                    'order' => $next_order->order,
                    'set_aer' => 'Direito',
                    'set_name' => $data_work['set_name_direto'],
                    'set_value' => $data_work['set_value_direto']
                );
                
                $success = $this->Sale->save_ald($ald_data);
                
                break;
            
            case 2:
                
                $ald_data = array(
                    'order' => $next_order->order,
                    'set_aer' => 'Esquerdo',
                    'set_name' => $data_work['set_name_esquerdo'],
                    'set_value' => $data_work['set_value_esquerdo']
                );
                $success = $this->Sale->save_ald($ald_data);
                break;
            
            case 3:
                $ald_data = array(
                    'order' => $next_order->order,
                    'set_aer' => 'Direito',
                    'set_name' => $data_work['set_name_direto'],
                    'set_value' => $data_work['set_value_direto']
                );
                $this->Sale->save_ald($ald_data);
                $ald_data = array(
                    'order' => $next_order->order,
                    'set_aer' => 'Esquerdo',
                    'set_name' => $data_work['set_name_esquerdo'],
                    'set_value' => $data_work['set_value_esquerdo']
                );
                $success = $this->Sale->save_ald($ald_data);
                break;
            
            case 4:
                $success = true;
                break;
        }
        
        return $success;
    }

    function salve_info_add()
    {
        $customer_id = $this->datasale->get_customer();
        $Address = $this->input->post();
        $Address['patient_id'] = $customer_id;
        $this->Customer->save_trade($Address, $customer_id);
        
        echo '<script>self.close();</script>';
    }

    function save_venda($data_work)
    {
        $id_customer = $this->datasale->get_customer();
        $id_user = $this->datasale->get_customer_user();
        $next_order = $this->Sale->next_order();
        
        $data_sale = array(
            'order' => $next_order->order,
            'patient_id' => $id_customer,
            'patient_user_id' => $id_user,
            'value_sale' => $data_work['valor_compra'],
            'value_finance' => $data_work['valor_financi'],
            'value_entrada' => $data_work['valor_entrada'],
            'value_desconto' => $data_work['desconto'],
            'value_total' => $data_work['subtotal'],
            'value_apagar' => $data_work['apagar'],
            'parcelas' => $data_work['parcelas'],
            'for_sold' => '1',
            'form_pay' => $data_work['forma_financi']
        );
        
        $this->Sale->save($data_sale, - 1);
        
        return $data_sale;
    }
    
    /* ***************************************************************************** */
    /*
     * Funções Responsaveis por Validar dados da Compra
     * /* *****************************************************************************
     */
    function valida_descoto($work, $arg)
    {
        switch ($arg) {
            case 1:
                
                // Se DIREITO = TRUE e ESQUERDO = FALSE
                // valida se a algum valor que não seja 0.00
                if ($work['set_value_esquerdo'] != '0.00') {
                    // caso o valor do aparelho esquerdo não seja 0.00 mostra mensagem
                    echo 'Opss: você deve marcar (O.E)' . "\n" . 'no processo de transferência de apareho no ato da venda.';
                    exit();
                } else {
                    // caso contrario retorna o valor do aparelho direito
                    return $work['set_value_direto'];
                }
                break;
            
            case 2:
                
                // Se DIREITO = FALSE e ESQUERDO = TRUE
                // valida se a algum valor que não seja 0.00
                if ($work['set_value_direto'] != '0.00') {
                    // caso o valor do aparelho direito não seja 0.00 mostra mensagem
                    echo 'Opss: você deve marcar (O.D)' . "\n" . 'no processo de transferência de apareho no ato da venda.';
                    exit();
                } else {
                    // caso contrario retorna o valor do aparelho esquerdo
                    return $work['set_value_esquerdo'];
                }
                break;
            
            case 3:
                $Soma = $work['set_value_direto'] + $work['set_value_esquerdo'];
                return $Soma;
                break;
            
            case 4:
                if ($work['set_value_direto'] != '0.00') {
                    echo 'Opss: você deve marcar (O.D)' . "\n" . 'no processo de transferência de apareho no ato da venda.';
                    exit();
                } elseif ($work['set_value_esquerdo'] != '0.00') {
                    echo 'Opss: você deve marcar (O.E)' . "\n" . 'no processo de transferência de apareho no ato da venda.';
                    exit();
                } else {
                    return '0.00';
                }
                break;
        }
    }

    function sobre_venda($totalVenda, $entrada)
    {
        if ($entrada == 'NaN')
            $entrada = 0;
        
        if (empty($totalVenda))
            $totalVenda = 0;
        
        $data_venda['entrada'] = $entrada;
        $data_venda['totalVenda'] = $totalVenda;
        
        return $data_venda;
    }
    
    // Valida o valor da venda
    function valida_venda($data_work, $param)
    {
        switch ($param) {
            case 1:
                $data_item[] = $data_work['item_direito'];
                
                // Aqui vamos realizar uma consulta ao resultado (selling_price)
                $data_item_for_sales = $this->Sale->set_value_for_sales($data_item);
                
                // Valida valores entregues
                $valor_compra_entregue = $data_work['valor_compra'];
                $valor_compra_revizado = $data_item_for_sales->result()[0]->selling_price;
                return $valor_compra_revizado;
                break;
            
            case 2:
                $data_item[] = $data_work['item_esquerdo'];
                
                // Aqui vamos realizar uma consulta ao resultado (selling_price)
                $data_item_for_sales = $this->Sale->set_value_for_sales($data_item);
                $valor_compra_revizado = $data_item_for_sales->result()[0]->selling_price;
                return $valor_compra_revizado;
                break;
            
            case 3:
                $data_item[] = $data_work['item_direito'];
                $data_item[] = $data_work['item_esquerdo'];
                
                // Aqui vamos realizar uma consulta e mutiplicar o resultado (selling_price) por 2
                // caso nos items não sejam identicos realiza soma
                if ($data_item[0] == $data_item[1]) {
                    $data_item_for_sales = $this->Sale->set_value_for_sales($data_item);
                    $valor_compra_revizado = $data_item_for_sales->result()[0]->selling_price * 2;
                    return $valor_compra_revizado;
                } else {
                    $data_item_for_sales = $this->Sale->set_value_for_sales($data_item);
                    $valor_compra_revizado = $data_item_for_sales->result()[0]->selling_price + $data_item_for_sales->result()[1]->selling_price;
                    return $valor_compra_revizado;
                }
                break;
            
            case 4:
                echo 'Opss: você deve marcar (O.D  O.E)' . "\n" . 'de acordo com a venda.';
                exit();
                break;
        }
    }
    
    // Determina numero de aparelho e lado
    function valida_produto($od, $oe)
    {
        $Status = 0;
        if ($od == 'true' && $oe == 'false')
            $Status = 1;
        
        if ($od == 'false' && $oe == 'true')
            $Status = 2;
        
        if ($od == 'true' && $oe == 'true')
            $Status = 3;
        
        if ($od == 'false' && $oe == 'false')
            $Status = 4;
        
        return $Status;
    }
    
    // Dertermina aparelho no ato da venda
    function valida_ald($od, $oe)
    {
        $Status = 0;
        if ($od == 'true' && $oe == 'false')
            $Status = 1;
        
        if ($od == 'false' && $oe == 'true')
            $Status = 2;
        
        if ($od == 'true' && $oe == 'true')
            $Status = 3;
        
        if ($od == 'false' && $oe == 'false')
            $Status = 4;
        
        return $Status;
    }
    
    // Determina os dados da garantia fabrica caso não tenha solicita
    // confimação para registro de log
    function valida_garantia_fabrica($arg, $item)
    {
        date_default_timezone_set('America/Sao_Paulo');
        
        if ($arg == 0) {
            echo 'GRNTFBRC';
            $success = date('Y-m-d');
        } else {
            if ($item->date_fabrica == '0000-00-00') {
                $success = date('Y-m-d');
            } else {
                $success = date('Y-m-d', strtotime('+' . $arg . ' month', $item->data_fabrica));
            }
        }
        
        return $success;
    }
    
    // Determina os dados da garantia caso não tenha
    // confirmação para registro da garantia do cliente
    function valida_garantia_venda($arg, $item)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $this->datasale->set_items_serie_d($item);
        
        if ($arg == 0) {
            echo 'VND';
        } else {
            return date('Y-m-d', strtotime('+' . $arg . ' month'));
        }
    }
    
    /* ***************************************************************************** */
    /*
     * Funções Responsaveis por inserir as informações em outros modulos da aplicação
     * /* *****************************************************************************
     */
    
    // Aqui inserimos as informações referente ao aparelho na tabela patient_itens.
    function set_customer_item($item_sales)
    {
        $item_info = $this->Item->get_info($item_sales['item_id']);
        $item_business = $this->Item->get_infoI($item_sales['item_id']);
        $supplier = $this->Supplier->get_info($item_business->supplier_id);
        
        $customer_item = array(
            'patient_id' => $item_sales['patient_id'],
            'apparatus' => 'APARELHO AUDITIVO',
            'maker' => $supplier->fancy_name,
            'color' => $item_sales['color'],
            'model' => $item_info->description,
            'number_serie' => $item_sales['number_serie'],
            'suppliers_data' => $item_sales['suppliers_data'],
            'purchase_date' => date('Y-m-d'),
            'expires_data' => $item_sales['expires_data']
        );
        
        return $this->Customer->save_apparatus($customer_item, $item_sales['number_serie']);
    }
    
    // Aqui inserimos as informaçoes referente as contas a receber
    function set_account_venda($save_venda)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $customer = $this->Customer->get_info($save_venda['patient_id']);
        
        // Calcula o valor da parcela
        $account_value = $save_venda['value_apagar'] / $save_venda['parcelas'];
        $account_data = array();
        
        for ($i = 1; $i <= $save_venda['parcelas']; $i ++) {
            
            $account_data['number'] = $save_venda['order'];
            $account_data['date'] = date('Y-m-d', strtotime('+' . $i . ' month')); // calculo de data para o mes seguinte
            $account_data['favored'] = $customer->first_name . ' ' . $customer->last_name; // obtem o nome do cliente a pagar
            $account_data['operation'] = '0'; // Zero como default para operação da contaa a receber
            $account_data['plan_accounts'] = '01.01.02'; // Plano de contas "Receita->Comercial->Vendas"
            $account_data['payment_form'] = $save_venda['form_pay']; // Determina a forma de Pagamento
            $account_data['cost_center'] = $account_value; // valor da parcela,
            $account_data['value'] = $account_value; // valor da parcela,
            $account_data['historic'] = 'Venda de Mercadoria';
            
            $this->Account->save($account_data, - 1);
        }
        
        return true;
    }
    
    // **********************************************************************
    // PRE VENDA
    function pre_sales()
    {
        setlocale(LC_MONETARY, "pt_BR");
        
        // Instanciar todos os valores da tabela category
        // atravez da classe category
        $data_categoria = $this->Category->get_all();
        
        // Atravez do foreach estancie os valores do campo nome da tabela category
        // montando assim uma lista
        foreach ($data_categoria->result() as $categorias) {
            $categoria[$categorias->name] = $categorias->name;
        }
        $data['categoria'] = $categoria;
        
        // Instanciar todos os valores da tabela items e items_business
        // atravez da classe Item
        $data_items = $this->Item->get_all();
        
        // atravez do foreach acesso ao item_business e montagem da lista default
        $lista = '';
        
        foreach ($data_items->result() as $item) {
            $data_business = $this->Item->get_info_business($item->item_id);
            
            if ($item->category == 'Aparelhos') {
                $lista .= '<li name="' . $item->description . '" style="cursor: pointer;" 
							id="' . $item->description . '|' . $data_business->selling_price . '" onclick="move_tabela(this)">
				 			<i class="fa fa-file-text"></i>' . $item->description . '
							<span class="pull-right value">' . money_format("%n", floatval($data_business->selling_price)) . '</span>
							<small id="codebar">' . $item->item_codebar . ' ' . $item->unit . '</small>
							</li>';
            }
        }
        
        $data['lista'] = $lista;
        
        $this->load->view("sales/pre_sales", $data);
    }

    /**
     * Retorna em ajax pelo metodo XMLHttpRequest(); a lista de produtos
     *
     * @param string $cat            
     */
    function get_categorias($cat)
    {
        setlocale(LC_MONETARY, "pt_BR");
        $categorias = $this->General->select2("item_id, description, unit", "items", array(
            "category" => $cat
        ), "description", "asc")->result_array();
        
        foreach ($categorias as $value) {
            if (isset($this->General->select2("selling_price", "items_business", array(
                "item_id" => $value["item_id"]
            ))->row()->selling_price)) {
                $valor = $this->General->select2("selling_price", "items_business", array(
                    "item_id" => $value["item_id"]
                ))->row()->selling_price;
                
                echo '<li name="' . $value["description"] . '" style="cursor: pointer;" id="' . $value["description"] . '|' . $valor . '" onclick="move_tabela(this)">
							<i class="fa fa-file-text"></i>' . $value["description"] . '
							<span class="pull-right value">' . money_format("%n", $valor) . '</span>';
            } else {
                echo '<li name="' . $value["description"] . '" style="cursor: pointer;" id="' . $value["description"] . '|0.00" onclick="move_tabela(this)">
							<i class="fa fa-file-text"></i>' . $value["description"] . '
							<span class="pull-right value">' . money_format("%n", "0.00") . '</span>';
            }
            
            echo '<small>' . $value["unit"] . '</small>
				</li>';
        }
    }

    function insert_item()
    {
        echo $this->load->post('codebar');
        echo $this->load->post('qtd');
        echo $this->load->post('preco');
    }
}
?>