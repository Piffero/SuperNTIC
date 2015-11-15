<?php

function is_sale_integrated_cc_processing()
{
    $CI = & get_instance();
    $payments = $CI->sale_lib->get_payments();
    return $CI->config->item('enable_credit_card_processing') && isset($payments[lang('sales_credit')]);
}

function get_sales_manager_data_rows($sales, $controller, $set)
{
    $CI = & get_instance();
    
    $table = '	<!----TABLE LISTING STARTS--->' . "\n";
    
    $table .= '		<div class="content">' . "\n";
    $table .= '			<div class="table-responsive">' . "\n";
    
    $table .= '				<table class="table no-border hover">' . "\n";
    $table .= '					<thead class="no-border">' . "\n";
    $table .= '					<tr>' . "\n";
    
    $headers = array(
        '						<th><strong>N&#186; Item</strong></th>',
        '						<th><strong>Qtde</strong></th>',
        '						<th><strong>Preco Unid</strong></th>',
        '						<th><strong>A&#231;&#227;o</strong></th>'
    );
    
    foreach ($headers as $header) {
        $table .= $header . "\n";
    }
    
    $table .= '					</tr>' . "\n";
    $table .= '					</thead>' . "\n";
    
    $table .= '					<tbody class="no-border-y">' . "\n";
    $table .= get_sales_table_data_rows($sales, $controller, $set);
    $table .= '					</tbody>' . "\n";
    
    $table .= '				</table>' . "\n";
    $table .= '			</div>' . "\n";
    $table .= '		</div>' . "\n";
    $table .= '	<!----TABLE LISTING END --->' . "\n";
    
    return $table;
}

function get_sales_table_data_rows($sales, $controller, $set)
{
    $CI = & get_instance();
    $table_data_rows = '';
    
    foreach ($sales->result() as $sale) {
        $table_data_rows .= get_sales_data_row($sale, $controller, $set);
    }
    
    if ($sales->num_rows() == 0) {
        $table_data_rows .= '<tr><td colspan="7"><div class="warning_message" style="padding:7px;">N&#227;o h&#225; linhas para serem mostradas</div></tr></tr>';
    }
    
    return $table_data_rows;
}

function get_sales_data_row($sale, $controller, $set)
{
    $CI = & get_instance();
    
    $config['base_url'] = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
    $config['base_url'] .= "://" . $_SERVER['HTTP_HOST'];
    $config['base_url'] .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
    
    $table_data_row = '';
    
    $table_data_row .= '						<tr>';
    $table_data_row .= '							<td>' . $sale->codebar . ' ' . $sale->description . '</td>';
    $table_data_row .= '							<td>' . $sale->quantity . '</td>';
    $table_data_row .= '							<td>' . $sale->item_unit_price . '</td>';
    $table_data_row .= '							<td>' . $sale->item_sum_price . '</td>';
    
    if ($set == 0) {
        $table_data_row .= '							<td>';
        $table_data_row .= '										' . form_open('sales/remover/') . '
															<button class="btn btn-default btn-flat btn-xs" type="submit" name="item_id" value="' . $sale->item_id . ' ' . $sale->sale_id . '"><i class="fa fa-times"></i></button>
															' . form_close();
        $table_data_row .= '							</td>';
    } else {
        $table_data_row .= '							<td>xxxxx</td>';
    }
    
    $table_data_row .= '						</tr>';
    
    return $table_data_row;
}

/**
 * ***********************************************************************************************************************
 */
/**
 * FIM DA TABELA DE VENDAS
 */
function get_method_pay_data_rows($methods, $controller)
{
    $CI = & get_instance();
    $table_data_rows = '';
    
    foreach ($methods->result() as $method) {
        $table_data_rows .= get_method_pay_row($method, $controller);
    }
    
    if ($methods->num_rows() == 0) {
        $table_data_rows .= '<tr><td colspan="2"><div class="warning_message" style="padding:7px;">N&#227;o a linhas para serem mostradas</div><td class="primary-emphasis"></td></tr>';
    }
    
    return $table_data_rows;
}

function get_method_pay_row($method, $controller)
{
    $CI = & get_instance();
    
    $table_data_row = '';
    
    $table_data_row .= '<tr>';
    $table_data_row .= '	<td><b>' . $method->payment_type . '</b></td>';
    $table_data_row .= '	<td class="text-center"><b>' . $method->payment_date . '</b></td>';
    $table_data_row .= '	<td class="text-center primary-emphasis"><b>' . $method->payment_amount . '</b></td>';
    $table_data_row .= '</tr>';
    
    return $table_data_row;
}

/**
 * ***********************************************************************************************************************
 */
/**
 * FIM DA TABELA METODOS DE PAGAMENTO
 */
function get_saleslist_table_data_rows($sales, $controller)
{
    $CI = & get_instance();
    
    $table = '	<!----TABLE LISTING STARTS--->' . "\n";
    
    $table .= '		<div class="content">' . "\n";
    $table .= '			<div class="table-responsive">' . "\n";
    
    $table .= '				<table class="table no-border hover">' . "\n";
    $table .= '					<thead class="no-border no-border-y">' . "\n";
    
    $table .= '					<tr>' . "\n";
    
    $headers = array(
        '						<th style="width:10%;"><strong>N&#186; Pedido</strong></th>',
        '						<th style="width:25%;"><strong>Data Emiss&#227;o</strong></th>',
        '						<th style="width:25%;"><strong>Comprador por</strong></th>',
        '						<th style="width:15%;"><strong>Total</strong></th>',
        '						<th style="width:15%;"><strong>Desconto</strong></th>',
        '						<th style="width:15%;"><strong>Subtotal</strong></th>',
        '						<th style="width:20%;" colspan="3"><strong>A&#231;&#227;o</strong></th>'
    );
    
    foreach ($headers as $header) {
        $table .= $header . "\n";
    }
    
    $table .= '					</tr>' . "\n";
    $table .= '					</thead>' . "\n";
    
    $table .= '					<tbody class="no-border-y">' . "\n";
    $table .= get_saleslist_table_data_row($sales, $controller);
    $table .= '					</tbody>' . "\n";
    
    $table .= '					</table>' . "\n";
    
    return $table;
}

function get_saleslist_table_data_row($sales, $controller)
{
    $CI = & get_instance();
    $table_data_rows = '';
    
    foreach ($sales->result() as $sale) {
        $table_data_rows .= get_saleslist_data_row($sale, $controller);
    }
    
    if ($sales->num_rows() == 0) {
        $table_data_rows .= '<tr><td colspan="8"><div class="warning_message" style="padding:7px;">N&#227;o a linhas para serem mostradas</div></tr></tr>';
    }
    
    return $table_data_rows;
}

function get_saleslist_data_row($sale, $controller)
{
    $CI = & get_instance();
    $table_data_row = '';
    
    $Customers = $controller->Customer->get_info($sale->patient_id);
    $config['base_url'] = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
    $config['base_url'] .= "://" . $_SERVER['HTTP_HOST'];
    $config['base_url'] .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
    date_default_timezone_set('America/Sao_Paulo');
    
    $table_data_row .= '						<tr>';
    $table_data_row .= '							<td>' . $sale->order . '</td>';
    $table_data_row .= '							<td>' . date('d/m/Y h:i:s', strtotime($sale->sale_time)) . '</td>';
    $table_data_row .= '							<td>' . $Customers->first_name . ' ' . $Customers->last_name . '</td>';
    $table_data_row .= '							<td>' . $sale->value_sale . '</td>';
    $table_data_row .= '							<td>' . $sale->value_desconto . '</td>';
    $table_data_row .= '							<td>' . $sale->value_total . '</td>';
    
    $table_data_row .= '							<td>' . '<button class="btn btn-primary btn-xs btn-flat" data-placement="bottom" data-toggle="tooltip" data-original-title="Visualizar Dados da Venda" type="button" 
															onclick=" javascript:window.open(\'' . $config["base_url"] . 'index.php/sales_lista/view/' . $sale->order . '\',\'Lancamento Contas\',\'STATUS=0, TOOLBAR=0, LOCATION=0, DIRECTORIES=0, RESISABLE=0, SCROLLBARS=1, TOP=50, LEFT=170,width=740,height=400\');"><i class="fa fa-search"></i></button>' . '</td>';
    
    if ($sale->for_sold == 1) {
        $table_data_row .= '						<td>' . '<button class="btn btn-warning btn-xs btn-flat" data-placement="bottom" data-toggle="tooltip" data-original-title="Processar Pre-Venda" type="button" onclick=" javascript: progress_sales(' . $sale->order . '); reboot();"><i class="fa fa-exchange"></i></button>' . '</td>';
    } elseif ($sale->for_sold == 2) {
        $table_data_row .= '						<td>' . '<button class="btn btn-success btn-xs btn-flat" data-placement="bottom" data-toggle="tooltip" data-original-title="Imprimir Contrato" type="button" onclick=" javascript: progress_return(' . $sale->order . '); reboot();"><i class="fa fa-file"></i></button>' . '</td>';
    }
    
    $table_data_row .= '						<tr>';
    
    return $table_data_row;
}

?>