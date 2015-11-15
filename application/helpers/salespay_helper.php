<?php
/*
 * Obtem as linhas de dados de html para o povo.
 */
function get_sales_pay_table($sales, $controller)
{
    $CI = & get_instance();
    
    $table = '	<!----TABLE LISTING STARTS--->' . "\n";
    $table .= '		<div class="content">' . "\n";
    $table .= '			<div class="table-responsive">' . "\n";
    
    $table .= '				<table class="table no-border hover">' . "\n";
    $table .= '					<thead class="no-border">' . "\n";
    $table .= '					<tr>' . "\n";
    
    $headers = array(
        '						<th><strong>Número</strong></th>',
        '						<th><strong>Forma de Pagamento</strong></th>',
        '						<th><strong>Data Vencimento</strong></th>',
        '						<th><strong>Valor</strong></th>'
    );
    
    foreach ($headers as $header) {
        $table .= $header . "\n";
    }
    
    $table .= '					</tr>' . "\n";
    $table .= '					</thead>' . "\n";
    
    $table .= '					<tbody class="no-border-y">' . "\n";
    $table .= get_sales_pay_table_data_rows($sales, $controller);
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
function get_sales_pay_table_data_rows($sales, $controller)
{
    $CI = & get_instance();
    $table_data_rows = '';
    
    foreach ($sales->result() as $sale) {
        $table_data_rows .= get_sales_pay_data_row($sale, $controller);
    }
    
    if ($sales->num_rows() == 0) {
        $table_data_rows .= '<tr><td colspan="5"><div class="warning_message" style="padding:7px;">N&#227;o h&#225; linhas para serem mostradas</div></tr></tr>';
    }
    
    return $table_data_rows;
}

function get_sales_pay_data_row($sale, $controller)
{
    $CI = & get_instance();
    
    $table_data_row = '';
    
    $table_data_row .= '						<tr>';
    $table_data_row .= '							<td>' . $sale->npay . '</td>';
    $table_data_row .= '							<td>' . $sale->tpay . '</td>';
    $table_data_row .= '							<td>' . get_date_view($sale->dpay) . '</td>';
    $table_data_row .= '							<td>' . $sale->vpay . '</td>';
    $table_data_row .= '						</tr>';
    
    return $table_data_row;
}

/** ******************************************************************************* **/
/**  FIM DA TABELA DE PAGAMENTOS VENDA **/
