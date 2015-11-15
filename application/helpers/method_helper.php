<?php

/*
 * Obtem uma tabela html para gerenciar paciente.
 */
function get_method_manage_table($method, $controller)
{
    $CI = & get_instance();
    $table = '	<!----TABLE LISTING STARTS--->' . "\n";
    $table .= '		<div class="content">' . "\n";
    $table .= '			<div class="table-responsive">' . "\n";
    
    $table .= '				<table class="table no-border hover">' . "\n";
    $table .= '					<thead class="no-border">' . "\n";
    $table .= '					<tr>' . "\n";
    
    $headers = array(
        '						<th style="width:2%;"><input type="checkbox" id="check" onclick="CheckAll(event);"/></th>',
        '						<th style="width:20%;"><strong>Forma de Pagamento</strong></th>',
        '						<th style="width:15%;"><strong>Opera&#231;&#227;o</strong></th>',
        '						<th style="width:15%"><strong>Banco</strong></th>',
        '						<th style="width:15%"><strong>Multa</strong></th>',
        '						<th style="width:15%"><strong>Juros</strong></th>'
    );
    
    foreach ($headers as $header) {
        $table .= $header . "\n";
    }
    
    $table .= '					</tr>' . "\n";
    $table .= '					</thead>' . "\n";
    
    $table .= '					<tbody class="no-border-y">' . "\n";
    $table .= get_method_manage_table_data_rows($method, $controller);
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
function get_method_manage_table_data_rows($method, $controller)
{
    $CI = & get_instance();
    $table_data_rows = '';
    
    foreach ($method->result() as $methods) {
        $table_data_rows .= get_method_data_row($methods, $controller);
    }
    
    if ($method->num_rows() == 0) {
        $table_data_rows .= '<tr><td colspan="6"><div class="warning_message" style="padding:7px;">N&#227;o h&#225; linhas para serem mostradas</div></tr></tr>';
    }
    
    return $table_data_rows;
}

function get_method_data_row($methods, $controller)
{
    $CI = & get_instance();
    
    $table_data_row = '';
    
    $table_data_row .= '						<tr ondblclick="D(\'' . $methods->payment_id . '\');" "id="' . $methods->payment_id . '">';
    $table_data_row .= '							<td><input type="checkbox" id="check" onclick="mudaCor(' . $methods->payment_id . ')" value="' . $methods->payment_id . '"/></td>';
    $table_data_row .= '							<td>' . $methods->payment_type . '</td>';
    $table_data_row .= '							<td>' . $methods->transaction_id . '</td>';
    $table_data_row .= '							<td>' . $methods->banco . '</td>';
    $table_data_row .= '							<td>' . $methods->multa . '</td>';
    $table_data_row .= '							<td>' . $methods->juros . '</td>';
    $table_data_row .= '						</tr>';
    
    return $table_data_row;
}

/** ******************************************************************************* **/
/**  FIM DA TABELA DE PACIENTES **/	