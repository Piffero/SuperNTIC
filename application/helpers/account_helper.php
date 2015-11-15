<?php
/*
 * Obtem as linhas de dados de html para o povo.
 */
function get_account_os_manage_table($account, $controller, $op)
{
    $CI = & get_instance();
    
    $table = '					<thead class="no-border">' . "\n";
    $table .= '					<tr>' . "\n";
    
    if ($op == 0) {
        $operation = 'Cliente';
    } elseif ($op == 1) {
        $operation = 'Fornecedor';
    }
    
    $headers = array(
        '						<th style="width:20%;"><strong>' . $operation . '</strong></th>',
        '						<th style="width:20%;"><strong>Plano de Contas</strong></th>',
        '						<th style="width:15%;"><strong>Hist&#243;rico</strong></th>',
        '						<th style="width:15%;"><strong>Vencimento</strong></th>',
        '						<th style="width:15%;"><strong>N&#250;mero</strong></th>',
        '						<th style="width:15%;"><strong>Pre&#231;o</strong></th>'
    );
    
    foreach ($headers as $header) {
        $table .= $header . "\n";
    }
    
    $table .= '					</tr>' . "\n";
    $table .= '					</thead>' . "\n";
    
    $table .= '					<tbody class="no-border-y">' . "\n";
    $table .= get_account_os_manage_table_data_rows($account, $controller, $op);
    $table .= '					</tbody>' . "\n";
    
    return $table;
}

/*
 * Obtem as linhas de dados de html para o povo.
 */
function get_account_os_manage_table_data_rows($account, $controller, $op)
{
    $CI = & get_instance();
    $table_data_rows = '';
    
    foreach ($account->result() as $accounts) {
        $table_data_rows .= get_account_os_data_row($accounts, $controller, $op);
    }
    
    if ($account->num_rows() == 0) {
        $table_data_rows .= '<tr><td colspan="6"><div class="warning_message" style="padding:7px;">N&#227;o h&#225; linhas para serem mostradas</div></tr></tr>';
    }
    
    return $table_data_rows;
}

function get_account_os_data_row($account, $controller, $op)
{
    $CI = & get_instance();
    
    if ($op == 0) {
        $operation = 'class="text-success"><label>';
    } elseif ($op == 1) {
        $operation = 'class="text-danger"><label>';
    }
    
    $table_data_row = '';
    
    $table_data_row .= '						<tr>';
    $table_data_row .= '							<td>' . $account->favored . '</td>';
    $table_data_row .= '							<td ' . $operation . $account->plan_accounts . '</label></td>';
    $table_data_row .= '							<td>' . $account->historic . '</td>';
    $table_data_row .= '							<td>' . get_date_view($account->date) . '</td>';
    $table_data_row .= '							<td ' . $operation . $account->number . '</label></td>';
    $table_data_row .= '							<td ' . $operation . get_float_view($account->value) . '</label></td>';
    $table_data_row .= '						</tr>';
    
    return $table_data_row;
}

/**
 * ******************************************************************************* *
 */
/**
 * FIM DA TABELA DE CONTAS OS *
 */

/*
 * Obtem as linhas de dados de html para o povo.
 */
function get_consolidated_manage_table($account, $controller, $op)
{
    $CI = & get_instance();
    
    $table = '					<thead class="no-border">' . "\n";
    $table .= '					<tr>' . "\n";
    
    if ($op == 0) {
        $operation = 'Cliente';
    } elseif ($op == 1) {
        $operation = 'Fornecedor';
    }
    
    $headers = array(
        '						<th style="width:20%;"><strong>' . $operation . '</strong></th>',
        '						<th style="width:20%;"><strong>Plano de Contas</strong></th>',
        '						<th style="width:15%;"><strong>Hist&#243;rico</strong></th>',
        '						<th style="width:15%;"><strong>Vencimento</strong></th>',
        '						<th style="width:15%;"><strong>N&#250;mero</strong></th>',
        '						<th style="width:15%;"><strong>Pre&#231;o</strong></th>'
    );
    
    foreach ($headers as $header) {
        $table .= $header . "\n";
    }
    
    $table .= '					</tr>' . "\n";
    $table .= '					</thead>' . "\n";
    
    $table .= '					<tbody class="no-border-y">' . "\n";
    $table .= get_consolidated_manage_table_data_rows($account, $controller, $op);
    $table .= '					</tbody>' . "\n";
    
    return $table;
}

/*
 * Obtem as linhas de dados de html para o povo.
 */
function get_consolidated_manage_table_data_rows($account, $controller, $op)
{
    $CI = & get_instance();
    $table_data_rows = '';
    
    foreach ($account->result() as $accounts) {
        $table_data_rows .= get_account_os_data_row($accounts, $controller, $op);
    }
    
    if ($account->num_rows() == 0) {
        $table_data_rows .= '<tr><td colspan="6"><div class="warning_message" style="padding:7px;">N&#227;o h&#225; linhas para serem mostradas</div></tr></tr>';
    }
    
    return $table_data_rows;
}

function get_consolidated_data_row($account, $controller, $op)
{
    $CI = & get_instance();
    
    if ($op == 0) {
        $operation = 'class="text-success"><label>';
    } elseif ($op == 1) {
        $operation = 'class="text-danger"><label>';
    }
    
    $table_data_row = '';
    
    $table_data_row .= '						<tr ondblclick="D(' . $account->id . ');" id="' . $account->id . '">';
    $table_data_row .= '							<td>' . $account->favored . '</td>';
    $table_data_row .= '							<td ' . $operation . $account->plan_accounts . '</label></td>';
    $table_data_row .= '							<td>' . $account->historic . '</td>';
    $table_data_row .= '							<td>' . get_date_view($account->date) . '</td>';
    $table_data_row .= '							<td ' . $operation . $account->number . '</label></td>';
    $table_data_row .= '							<td ' . $operation . get_float_view($account->value) . '</label></td>';
    $table_data_row .= '						</tr>';
    
    return $table_data_row;
}

/** ******************************************************************************* **/
/**  FIM DA TABELA DE CONTAS CONSOLIDADAS **/	