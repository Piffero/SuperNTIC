<?php
/*
 * Obtem as linhas de dados de html para o povo.
 */
function get_supplier_item_table($supplier, $controller)
{
    $CI = & get_instance();
    
    $table = '	<!----TABLE LISTING STARTS--->' . "\n";
    $table .= '		<div class="content">' . "\n";
    $table .= '			<div class="table-responsive">' . "\n";
    
    $table .= '				<table class="table no-border hover">' . "\n";
    $table .= '					<thead class="no-border">' . "\n";
    $table .= '					<tr>' . "\n";
    
    $headers = array(
        '						<th><strong>Código Item</strong></th>',
        '						<th><strong>Número Pedido</strong></th>',
        '						<th><strong>Quantidade</strong></th>',
        '						<th><strong>Custo Unitario</strong></th>',
        '						<th><strong>Custo Total</strong></th>'
    );
    
    foreach ($headers as $header) {
        $table .= $header . "\n";
    }
    
    $table .= '					</tr>' . "\n";
    $table .= '					</thead>' . "\n";
    
    $table .= '					<tbody class="no-border-y">' . "\n";
    $table .= get_supplier_item_table_data_rows($supplier, $controller);
    $table .= '					</tbody>' . "\n";
    
    $table .= '				</table>' . "\n";
    $table .= '			</div>' . "\n";
    $table .= '		</div>' . "\n";
    $table .= '	<!----TABLE LISTING ENDS--->' . "\n";
    
    return $table;
}

/*
 * Obtem as linhas de dados de html para o povo.
 */
function get_supplier_item_table_data_rows($supplier, $controller)
{
    $CI = & get_instance();
    $table_data_rows = '';
    
    foreach ($supplier->result() as $suppliers) {
        $table_data_rows .= get_supplier_item_data_row($suppliers, $controller);
    }
    
    if ($supplier->num_rows() == 0) {
        $table_data_rows .= '<tr><td colspan="6"><div class="warning_message" style="padding:7px;">N&#227;o h&#225; linhas para serem mostradas</div></tr></tr>';
    }
    
    return $table_data_rows;
}

function get_supplier_item_data_row($suppler, $controller)
{
    $CI = & get_instance();
    
    $total = $suppler->qtde * $suppler->cust_purchase;
    
    $table_data_row = '';
    
    $table_data_row .= '						<tr>';
    $table_data_row .= '							<td>' . $suppler->purch_id . '</td>';
    $table_data_row .= '							<td ' . $suppler->item_id . '</label></td>';
    $table_data_row .= '							<td>' . $suppler->qtde . '</td>';
    $table_data_row .= '							<td>' . $suppler->cust_purchase . '</td>';
    $table_data_row .= '							<td ' . $total . '</label></td>';
    $table_data_row .= '						</tr>';
    
    return $table_data_row;
}

/** ******************************************************************************* **/
/**  FIM DA TABELA DE CONTAS OS **/