<?php

/*
 * Obtem uma tabela html para gerenciar paciente.
 */
function get_bank_manage_table($bank, $controller)
{
    $CI = & get_instance();
    $table = '	<!----TABLE LISTING STARTS--->' . "\n";
    $table .= '		<div class="content">' . "\n";
    
    $table .= '				<table class="table no-border hover">' . "\n";
    $table .= '					<thead class="no-border">' . "\n";
    $table .= '					<tr>' . "\n";
    
    $headers = array(
        '				<th><input type="checkbox" id="check" onclick="CheckAll(event);"/></th>',
        '				<th><strong>Codigo</strong></th>',
        '				<th><strong>Nome Banco</strong></th>',
        '				<th><strong>Agência</strong></th>',
        '				<th><strong>C. Cedente</strong></th>'
    );
    
    foreach ($headers as $header) {
        $table .= $header . "\n";
    }
    
    $table .= '					</tr>' . "\n";
    $table .= '					</thead>' . "\n";
    $table .= '					<tbody class="no-border-y">' . "\n";
    $table .= get_bank_manage_table_data_rows($bank, $controller);
    $table .= '					</tbody>' . "\n";
    $table .= '				</table>' . "\n";
    $table .= '		</div>' . "\n";
    
    return $table;
}

/*
 * Obtem as linhas de dados de html para o povo.
 */
function get_bank_manage_table_data_rows($bank, $controller)
{
    $CI = & get_instance();
    $table_data_rows = '';
    
    foreach ($bank->result() as $banks) {
        $table_data_rows .= get_bank_data_row($banks, $controller);
    }
    
    if ($bank->num_rows() == 0) {
        $table_data_rows .= '<tr><td colspan="6"><div class="warning_message" style="padding:7px;">N&#227;o h&#225; linhas para serem mostradas</div></tr></tr>';
    }
    
    return $table_data_rows;
}

function get_bank_data_row($banks, $controller)
{
    $CI = & get_instance();
    
    $table_data_row = '';
    
    $table_data_row .= '						<tr ondblclick="D(\'' . $banks->bank_id . '\');" "id="' . $banks->bank_id . '">';
    $table_data_row .= '							<td><input type="checkbox" id="check" onclick="mudaCor(' . $banks->bank_id . ')" value="' . $banks->bank_id . '"/></td>';
    $table_data_row .= '							<td>' . $banks->cod_bank . '</td>';
    $table_data_row .= '							<td>' . $banks->name . '</td>';
    $table_data_row .= '							<td>' . $banks->agency . '</td>';
    $table_data_row .= '							<td>' . $banks->account . '</td>';
    
    return $table_data_row;
}

/** ******************************************************************************* **/
/**  FIM DA TABELA DE PACIENTES **/