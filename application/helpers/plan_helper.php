<?php

/*
 * Obtem uma tabela html para gerenciar paciente.
 */
function get_plan_account_manage_table($plan, $controller)
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
        '						<th style="width:20%;"><strong>C&#243;digo Plano</strong></th>',
        '						<th style="width:15%;"><strong>Categoria</strong></th>',
        '						<th style="width:15%;"><strong>Decri&#231;&#227;o</strong></th>',
        '						<th style="width:15%;"><strong>&#201; uma Categoria</strong></th>'
    );
    
    foreach ($headers as $header) {
        $table .= $header . "\n";
    }
    
    $table .= '					</tr>' . "\n";
    $table .= '					</thead>' . "\n";
    
    $table .= '					<tbody class="no-border-y">' . "\n";
    $table .= get_plan_account_manage_table_data_rows($plan, $controller);
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
function get_plan_account_manage_table_data_rows($plan, $controller)
{
    $CI = & get_instance();
    $table_data_rows = '';
    
    foreach ($plan->result() as $plans) {
        $table_data_rows .= get_plan_account_data_row($plans, $controller);
    }
    
    if ($plan->num_rows() == 0) {
        $table_data_rows .= '<tr><td colspan="6"><div class="warning_message" style="padding:7px;">N&#227;o h&#225; linhas para serem mostradas</div></tr></tr>';
    }
    
    return $table_data_rows;
}

function get_plan_account_data_row($plans, $controller)
{
    $CI = & get_instance();
    
    $table_data_row = '';
    
    $table_data_row .= '						<tr ondblclick="D(\'' . $plans->plan_id . '\');" "id="' . $plans->plan_id . '">';
    $table_data_row .= '							<td><input type="checkbox" id="check" onclick="mudaCor(' . $plans->plan_id . ')" value="' . $plans->plan_id . '"/></td>';
    $table_data_row .= '							<td>' . $plans->plan_id . '</td>';
    $table_data_row .= '							<td>' . $plans->plan_group . '</td>';
    $table_data_row .= '							<td>' . $plans->descrition . '</td>';
    
    if ($plans->iscategory == 1) {
        $table_data_row .= '							<td>SIM</td>';
    } else {
        $table_data_row .= '							<td>N&#195;O</td>';
    }
    
    $table_data_row .= '						</tr>';
    
    return $table_data_row;
}

/** ******************************************************************************* **/
/**  FIM DA TABELA DE PACIENTES **/	