<?php

function get_accomp_manager_table($accomp, $controller)
{
    $CI = & get_instance();
    
    $table = '		<div class="header">' . PHP_EOL;
    $table .= '			<h4>Programa<span class="pull-right">#N° Serial</span></h2>' . PHP_EOL;
    $table .= '			<h5>Quadro de Acompanhamento</h3>' . PHP_EOL;
    $table .= '		</div>' . PHP_EOL;
    $table .= get_accomp_manager_row($accomp, $controller);
    
    return $table;
}

function get_accomp_manager_row($accomp, $controller)
{
    $table_data_rows = '';
    foreach ($accomp->result() as $field) {
        $table_data_rows .= get_accomp_data_row($field, $controller);
    }
    
    if ($accomp->num_rows() == 0) {
        $table_data_rows = '<div class="item">' . PHP_EOL;
        $table_data_rows .= ' <div> </div>' . PHP_EOL;
        $table_data_rows .= ' <div>' . PHP_EOL;
        $table_data_rows .= '	<span class="date pull-right price"></span>' . PHP_EOL;
        $table_data_rows .= '	<h4 class="from">N&#227;o h&#225; linhas para serem mostradas</h4>' . PHP_EOL;
        $table_data_rows .= '	<p class="msg"></p>' . PHP_EOL;
        $table_data_rows .= ' </div>' . PHP_EOL;
        $table_data_rows .= '</div>' . PHP_EOL;
    }
    
    return $table_data_rows;
}

function get_accomp_data_row($accomp, $controller)
{
    $data_row = '';
    
    $CI = & get_instance();
    $data_customer = $CI->Customer->get_info($accomp->patient_id);
    
    $data_row .= '<div class="item" onclick="javascript: create_program(' . $accomp->sales_id . ',\'' . $accomp->number_serie . '\')">' . PHP_EOL;
    $data_row .= '	<div>' . PHP_EOL;
    $data_row .= '		<span class="date pull-right price">' . $accomp->number_serie . '</span>' . PHP_EOL;
    $data_row .= '		<h4 class="from">' . $data_customer->first_name . ' ' . $data_customer->last_name . '</h4>' . PHP_EOL;
    $data_row .= '		<p class="msg">Venda sob número: ' . $accomp->sales_id . '&emsp;&emsp; Agendamento para: ' . convert_timestamp($accomp->appointment) . '</p>' . PHP_EOL;
    $data_row .= '	</div>' . PHP_EOL;
    $data_row .= '</div>' . PHP_EOL;
    
    return $data_row;
}

/**
 * TODO Tabelas responsaveis por trazerem dadas as vendas efetuadas para abertura de quadro de acompanhamento
 */
function get_sales_for_accomp_manager_table($sales, $controller)
{
    $CI = & get_instance();
    $table = '';
    
    foreach ($sales->result() as $sales_item) {
        $customer = $CI->Customer->get_info($sales_item->patient_id);
        $accomp = $CI->Accompaniment->get_info_serie($sales_item->number_serie);
        
        if($accomp->progress != 9)         
        {
            $table .= '<tr>' . PHP_EOL;
            $table .= '	<td style="width:10%;"><input type="checkbox" onclick="c(' . $sales_item->order_id . ',\'' . $sales_item->number_serie . '\');"></td>' . PHP_EOL;
            $table .= '	<td style="width:10%;">' . $sales_item->order_id . '</td>' . PHP_EOL;
            $table .= ' <td style="width:25%;">' . $sales_item->number_serie . '</td>' . PHP_EOL;
            $table .= ' <td style="width:25%;">' . $customer->first_name . ' ' . $customer->last_name . '</td>' . PHP_EOL;
            $table .= '</tr>' . PHP_EOL;;
        }
        else 
        {
            $table .= PHP_EOL;            
        }
        
    }
    
    return $table;
}
	
	