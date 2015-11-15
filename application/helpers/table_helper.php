<?php

/*
 * Obtém uma tabela html para gerenciar paciente.
 */
function get_patient_manage_table($patient, $controller)
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
        '						<th style="width:20%;"><strong>Nome e Sobrenome</strong></th>',
        '						<th class="text-right"><strong>Fone Principal</strong></th>',
        '						<th style="width:15%;"><strong>Email</strong></th>',
        '						<th style="width:15%;"><strong>CPF</strong></th>'
    );
    
    foreach ($headers as $header) {
        $table .= $header . "\n";
    }
    
    $table .= '					</tr>' . "\n";
    $table .= '					</thead>' . "\n";
    
    $table .= '					<tbody class="no-border-y">' . "\n";
    $table .= get_patient_manage_table_data_rows($patient, $controller);
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
function get_patient_manage_table_data_rows($patient, $controller)
{
    $CI = & get_instance();
    $table_data_rows = '';
    
    $i = 0;
    foreach ($patient->result() as $customers) {
        $table_data_rows .= get_patient_data_row($patient, $controller, $i);
        $i ++;
    }
    
    if ($patient->num_rows() == 0) {
        $table_data_rows .= '<tr><td colspan="6"><div class="warning_message" style="padding:7px;">N&#227;o h&#225; linhas para serem mostradas</div></tr></tr>';
    }
    
    return $table_data_rows;
}

function get_patient_data_row($patient, $controller, $i)
{
    $CI = & get_instance();
    
    $table_data_row = '';
    
    $table_data_row .= '						<tr ondblclick="D(' . $patient->result_object[$i]->patient_id . ');" "id="' . $patient->result_object[$i]->patient_id . '">';
    $table_data_row .= '							<td><input type="checkbox" id="check" name="customer_id[]" onclick="mudaCor(' . $patient->result_object[$i]->patient_id . ')" value="' . $patient->result_object[$i]->patient_id . '"/></td>';
    $table_data_row .= '							<td>' . $patient->result_object[$i]->first_name . ' ' . $patient->result_object[$i]->last_name . '</td>';
    
    switch ($patient->result_object[$i]->phone_number) {
        case 1:
            $table_data_row .= '							<td class="text-right">' . $patient->result_object[$i]->phone_home . '</td>';
            ;
            break;
        
        case 2:
            $table_data_row .= '							<td class="text-right">' . $patient->result_object[$i]->phone_work . '</td>';
            ;
            break;
        
        case 3:
            $table_data_row .= '							<td class="text-right">' . $patient->result_object[$i]->phone_cell . '</td>';
            ;
            break;
        
        case 4:
            $table_data_row .= '							<td class="text-right">' . $patient->result_object[$i]->phone_other . '</td>';
            ;
            break;
        
        default:
            $table_data_row .= '							<td class="text-right">' . $patient->result_object[$i]->phone_home . '</td>';
            ;
            ;
            break;
    }
    
    $table_data_row .= '							<td class="text-right">' . mailto($patient->result_object[$i]->email, $patient->result_object[$i]->email) . '</td>';
    $table_data_row .= '							<td>' . $patient->result_object[$i]->document_cpf . '</td>';
    $table_data_row .= '						</tr>';
    
    return $table_data_row;
}

/**
 * ******************************************************************************* *
 */
/**
 * FIM DA TABELA DE PACIENTES *
 */
function get_delivery_table($item, $controller, $qtde = 0)
{
    $CI = & get_instance();
    
    $table_data_row = '	<table class="hover">';
    $table_data_row .= '	<thead>';
    $table_data_row .= '		<tr>';
    $table_data_row .= '			<th>C�d. Barras</th><th>Nome do Produto</th><th>Quantidade</th><th>A��o</th>';
    $table_data_row .= '		</tr>';
    $table_data_row .= '		</thead>';
    $table_data_row .= '		<tbody>';
    
    return $table_data_row;
}

// **********************************************************************
function get_row_itens_manage_data_rows($patient, $controller)
{
    $CI = & get_instance();
    $table_data_rows = '';
    
    $i = 0;
    foreach ($patient->result() as $customers) {
        $table_data_rows .= get_row_itens_data($customers, $controller, $i);
        $i ++;
    }
    
    if ($patient->num_rows() == 0) {
        $table_data_rows .= '<tr><td colspan="10"><div class="warning_message" style="padding:7px;">N&#227;o h&#225; linhas para serem mostradas</div></tr></tr>';
    }
    
    return $table_data_rows;
}

function get_row_itens_data($patient, $controller)
{
    $CI = & get_instance();
    
    $config['base_url'] = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
    $config['base_url'] .= "://" . $_SERVER['HTTP_HOST'];
    $config['base_url'] .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
    
    $table_data_row = '';
    
    $table_data_row .= '						  <tr>';
    $table_data_row .= '							    <td class="color-primary"><strong>' . $patient->apparatus . '</strong></td>';
    $table_data_row .= '							    <td class="color-primary"><strong>' . $patient->maker . '</strong></td>';
    $table_data_row .= '								<td>' . $patient->model . '</td>';
    $table_data_row .= '								<td>' . $patient->color . '</td>';
    $table_data_row .= '								<td class="color-primary"><strong>' . $patient->number_serie . '</strong></td>';
    $table_data_row .= '								<td>' . get_date_view($patient->purchase_date) . '</td>';
    $table_data_row .= '								<td>' . get_date_view($patient->expires_data) . '</td>';
    $table_data_row .= '								<td>' . get_date_view($patient->suppliers_data) . '</td>';
    $table_data_row .= '								<td class="text-center">';
    // $table_data_row.= ' <a class="label label-info" data-original-title="Trocar Aparelho" data-toggle="tooltip" data-placement="bottom" href="#"><i class="fa fa-refresh"></i></a>';
    
    $table_data_row .= ' 									<form action="' . $config['base_url'] . 'index.php/os/check" method="post"><button class="btn btn-primary btn-flat btn-xs" type="submit" name="NSERIE" value="' . $patient->number_serie . '"><i class="fa fa-ticket"></i></button></form>';
    // $table_data_row.= ' <a class="label label-success" data-original-title="Editar Aparelho" data-toggle="tooltip" data-placement="bottom" href="#"><i class="fa fa-pencil"></i></a>';
    $table_data_row .= '								</td>';
    $table_data_row .= '								<td class="text-center">';
    
    $table_data_row .= ' 									' . form_open('customers/delete_item/' . $patient->patient_id) . '
															<button class="btn btn-default btn-flat btn-xs" type="submit" name="serie" value="' . $patient->number_serie . '"><i class="fa fa-times"></i></button>
															' . form_close();
    $table_data_row .= '								</td>';
    $table_data_row .= '							</tr>';
    
    return $table_data_row;
}

/**
 * ******************************************************************************* *
 */
/**
 * FIM DA TABELA DE ITEMS CLIENTE *
 */

/*
 * Obtem uma tabela html para gerenciar Consultas.
 */
function get_appointment_manage_table($appointment, $controller)
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
        '						<th><strong>Data e Hora da Consulta</strong></th>',
        '						<th style="width:20%;"><strong>Fonoaudiologo</strong></th>',
        '						<th style="width:15%;"><strong>Paciente</strong></th>'
    );
    
    foreach ($headers as $header) {
        $table .= $header . "\n";
    }
    
    $table .= '					</tr>' . "\n";
    $table .= '					</thead>' . "\n";
    
    $table .= '					<tbody class="no-border-y">' . "\n";
    $table .= get_appointment_manage_table_data_rows($appointment, $controller);
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
function get_appointment_manage_table_data_rows($appointment, $controller)
{
    $CI = & get_instance();
    $table_data_rows = '';
    
    $i = 0;
    foreach ($appointment->result() as $customers) {
        $table_data_rows .= get_appointment_data_row($appointment, $controller, $i);
        $i ++;
    }
    
    if ($appointment->num_rows() == 0) {
        $table_data_rows .= '<tr><td colspan="6"><div class="warning_message" style="padding:7px;">N&#227;o h&#225; linhas para serem mostradas</div></tr></tr>';
    }
    
    return $table_data_rows;
}

function get_appointment_data_row($appointment, $controller, $i)
{
    $CI = & get_instance();
    
    $table_data_row = '';
    
    $table_data_row .= '						<tr ondblclick="D(' . $appointment->result_object[$i]->appointment_id . ');"  id="' . $appointment->result_object[$i]->appointment_id . '">';
    $table_data_row .= '							<td><input type="checkbox" id="check" onclick="mudaCor(' . $appointment->result_object[$i]->appointment_id . ')" value="' . $appointment->result_object[$i]->appointment_id . '"/></td>';
    $table_data_row .= '							<td>' . get_date_view($appointment->result_object[$i]->appointment) . ' ' . $appointment->result_object[$i]->hour . '</td>';
    $table_data_row .= '							<td>' . $appointment->result_object[$i]->doctor_id . '</td>';
    
    $table_data_row .= '							<td>' . ($appointment->result_object[$i]->patient_name) . '</td>';
    $table_data_row .= '						</tr>';
    
    return $table_data_row;
}

/**
 * ******************************************************************************* *
 */
/**
 * FIM DA TABELA DE CONSULTAS *
 */

/*
 * Obt�m uma tabela html para gerenciar Funcionarios.
 */
function get_employeer_manage_table($employeer, $controller)
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
        '						<th style="width:40%;"><strong>Nome e Sobrenome</strong></th>',
        '						<th style="width:15%;"><strong>Departamento</strong></th>',
        '						<th class="text-right"><strong>Fone Principal</strong></th>',
        '						<th style="width:15%;"><strong>Cargo ou Fun&#231;&#227;o</strong></th>',
        '						<th style="width:15%;"><strong>Email</strong></th>'
    );
    
    foreach ($headers as $header) {
        $table .= $header . "\n";
    }
    
    $table .= '					</tr>' . "\n";
    $table .= '					</thead>' . "\n";
    
    $table .= '					<tbody class="no-border-y">' . "\n";
    $table .= get_employeer_manage_table_data_rows($employeer, $controller);
    $table .= '					</tbody>' . "\n";
    
    $table .= '				</table>' . "\n";
    $table .= '			</div>' . "\n";
    $table .= '		</div>' . "\n";
    $table .= '	<!----TABLE LISTING ENDS--->' . "\n";
    
    return $table;
}

/*
 * Obt�m as linhas de dados de html para o povo.
 */
function get_employeer_manage_table_data_rows($employeer, $controller)
{
    $CI = & get_instance();
    $table_data_rows = '';
    
    $i = 0;
    foreach ($employeer->result() as $employeers) {
        $table_data_rows .= get_employeer_data_row($employeer, $controller, $i);
        $i ++;
    }
    
    if ($employeer->num_rows() == 0) {
        $table_data_rows .= '<tr><td colspan="6"><div class="warning_message" style="padding:7px;">N&#227;o h&#225; linhas para serem mostradas</div></tr></tr>';
    }
    
    return $table_data_rows;
}

function get_employeer_data_row($employeer, $controller, $i)
{
    $CI = & get_instance();
    
    $table_data_row = '';
    
    $table_data_row .= '						<tr ondblclick="D(' . $employeer->result_object[$i]->employees_id . ');" id="' . $employeer->result_object[$i]->employees_id . '">';
    $table_data_row .= '							<td><input type="checkbox" id="check" onclick="mudaCor(' . $employeer->result_object[$i]->employees_id . ')" value="' . $employeer->result_object[$i]->employees_id . '"/></td>';
    $table_data_row .= '							<td>' . ($employeer->result_object[$i]->first_name . ' ' . $employeer->result_object[$i]->last_name) . '</td>';
    $table_data_row .= '							<td>' . ($employeer->result_object[$i]->department_id) . '</td>';
    $table_data_row .= '							<td class="text-right">' . $employeer->result_object[$i]->phone_number . '</td>';
    $table_data_row .= '							<td>' . ($employeer->result_object[$i]->profile) . '</td>';
    $table_data_row .= '							<td class="text-right">' . mailto($employeer->result_object[$i]->email, $employeer->result_object[$i]->email) . '</td>';
    $table_data_row .= '						</tr>';
    
    return $table_data_row;
}

/**
 * ******************************************************************************* *
 */
/**
 * FIM DA TABELA DE FUNCIONARIOS *
 */

/*
 * Obtem uma tabela html para gerenciar Fornecedores.
 */
function get_supplier_manage_table($supplier, $controller)
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
        '						<th style="width:10%;"><strong>Id Empresa/Loja</strong></th>',
        '						<th style="width:15%;"><strong>Raz&#227;o Social</strong></th>',
        '						<th style="width:15%;"><strong>Nome Fantasia</strong></th>',
        '						<th style="width:30%;"><strong>CNJP / IE</strong></th>',
        '						<th style="width:15%;"><strong>Telefone</strong></th>',
        '						<th  class="text-right" style="width:15%;"><strong>email</strong></th>'
    );
    
    foreach ($headers as $header) {
        $table .= $header . "\n";
    }
    
    $table .= '					</tr>' . "\n";
    $table .= '					</thead>' . "\n";
    
    $table .= '					<tbody class="no-border-y">' . "\n";
    $table .= get_supplier_manage_table_data_rows($supplier, $controller);
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
function get_supplier_manage_table_data_rows($supplier, $controller)
{
    $CI = & get_instance();
    $table_data_rows = '';
    
    $i = 0;
    foreach ($supplier->result() as $suppliers) {
        $table_data_rows .= get_supplier_data_row($suppliers, $controller);
        $i ++;
    }
    
    if ($supplier->num_rows() == 0) {
        $table_data_rows .= '<tr><td colspan="7"><div class="warning_message" style="padding:7px;">N&#227;o h&#225; linhas para serem mostradas</div></tr></tr>';
    }
    
    return $table_data_rows;
}

function get_supplier_data_row($supplier, $controller)
{
    $CI = & get_instance();
    
    $table_data_row = '';
    
    $table_data_row .= '						<tr ondblclick="D(' . $supplier->suppliers_id . ');" id="' . $supplier->suppliers_id . '">';
    $table_data_row .= '							<td><input type="checkbox" id="check" onclick="mudaCor(' . $supplier->suppliers_id . ')" value="' . $supplier->suppliers_id . '"/></td>';
    $table_data_row .= '							<td>' . $supplier->suppliers_id . '</td>';
    $table_data_row .= '							<td>' . $supplier->corporate_name . '</td>';
    $table_data_row .= '							<td>' . $supplier->fancy_name . '</td>';
    $table_data_row .= '							<td>' . $supplier->document_cnpj . ' / ' . $supplier->document_ie . '</td>';
    $table_data_row .= '							<td>' . $supplier->phone_number . '</td>';
    $table_data_row .= '							<td class="text-right">' . mailto($supplier->email, $supplier->email) . '</td>';
    $table_data_row .= '						</tr>';
    
    return $table_data_row;
}

/**
 * ******************************************************************************* *
 */
/**
 * FIM DA TABELA DE FORNECEDORES *
 */

/*
 * Obtem uma tabela html para gerenciar Itens.
 */
function get_item_manage_table($item, $controller, $qtde = 0)
{
    $CI = & get_instance();
    $table = '	<!----TABLE LISTING STARTS--->' . "\n";
    $table .= '		<div class="content">' . "\n";
    $table .= '			<div class="table-responsive">' . "\n";
    
    $table .= '				<table class="table no-border hover" id="tablex">' . "\n";
    $table .= '					<thead class="no-border">' . "\n";
    $table .= '					<tr>' . "\n";
    
    $headers = array(
        '						<th><input type="checkbox" id="check" onclick="CheckAll(event);"/></th>',
        '						<th><strong>C&#243;digo de Barras</strong></th>',
        '						<th><strong>Descri&#231;&#227;o</strong></th>',
        '						<th><strong>Unidade</strong></th>',
        '						<th><strong>Quantidade</strong></th>',
        '						<th><strong>Categoria</strong></th>',
        '						<th><strong>É Serializado</strong></th>'
    );
    setlocale(LC_MONETARY, 'pt_BR');
    
    foreach ($headers as $header) {
        $table .= $header . "\n";
    }
    
    $table .= '					</tr>' . "\n";
    $table .= '					</thead>' . "\n";
    
    $table .= '					<tbody class="no-border-y">' . "\n";
    $table .= get_item_manage_table_data_rows($item, $controller, $qtde);
    
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
function get_item_manage_table_data_rows($item, $controller, $qtde)
{
    $CI = & get_instance();
    $table_data_rows = '';
    
    $i = 0;
    foreach ($item->result() as $items) {
        $table_data_rows .= get_item_data_row($item, $controller, $i, $qtde);
        
        $i ++;
    }
    
    if ($item->num_rows() == 0) {
        $table_data_rows .= '<tr><td colspan="7"><div class="warning_message" style="padding:7px;">N&#227;o h&#225; linhas para serem mostradas</div></tr></tr>';
    }
    
    return $table_data_rows;
}

function get_item_data_row($item, $controller, $i, $qtde)
{
    $CI = & get_instance();
    
    $itemsValue = new Item();
    $itemsQtde = $itemsValue->get_stock($item->result_object[$i]->item_id);
    
    $serial = $item->result_object[$i]->is_serialized;
    
    if ($serial == 1) {
        $MyQtde = $CI->General->select("id", "items_serie", array(
            "item_id" => $item->result_object[$i]->item_id
        ))->num_rows();
        $quis = 'SIM';
    } else {
        if ($itemsQtde == array()) {
            $MyQtde = 0;
        } else {
            $MyQtde = $itemsQtde[0]["quantity"];
        }
        $quis = 'NÃO';
    }
    
    $custoy = settype($custoz, 'float');
    $qtdx = settype($MyQtde, 'float');
    
    $table_data_row = '';
    
    $table_data_row .= '						<tr ondblclick="D(' . $item->result_object[$i]->item_id . ');" "id="' . $item->result_object[$i]->item_id . '">';
    $table_data_row .= '							<td><input type="checkbox" id="check" name="item_id[]" onclick="mudaCor(' . $item->result_object[$i]->item_id . ')" value="' . $item->result_object[$i]->item_id . '"/></td>';
    $table_data_row .= '							<td>' . $item->result_object[$i]->item_codebar . '</td>';
    $table_data_row .= '							<td>' . $item->result_object[$i]->description . '</td>';
    $table_data_row .= '							<td>' . $item->result_object[$i]->unit . '</td>';
    $table_data_row .= '							<td>' . $MyQtde . '</td>';
    $table_data_row .= '							<td>' . $item->result_object[$i]->category . '</td>';
    $table_data_row .= '							<td style="text-align:left">' . $quis . '</td>';
    $table_data_row .= '						</tr>';
    
    return $table_data_row;
}

/**
 * ******************************************************************************* *
 */
/**
 * FIM DA TABELA DE ITENS *
 */

/*
 * Obtem uma tabela html para gerenciar Departamentos.
 */
function get_department_manage_table($department, $controller)
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
        '						<th style="width:15%;"><strong>Codigo</strong></th>',
        '						<th style="width:30%;"><strong>Departamento</strong></th>',
        '						<th style="width:40%;"><strong>Descri&#231;&#227;o</strong></th>'
    );
    
    foreach ($headers as $header) {
        $table .= $header . "\n";
    }
    
    $table .= '					</tr>' . "\n";
    $table .= '					</thead>' . "\n";
    
    $table .= '					<tbody class="no-border-y">' . "\n";
    $table .= get_department_manage_table_data_rows($department, $controller);
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
function get_department_manage_table_data_rows($department, $controller)
{
    $CI = & get_instance();
    $table_data_rows = '';
    
    $i = 0;
    foreach ($department->result() as $departments) {
        $table_data_rows .= get_department_data_row($department, $controller, $i);
        $i ++;
    }
    
    if ($department->num_rows() == 0) {
        $table_data_rows .= '<tr><td colspan="4"><div class="warning_message" style="padding:7px;">N&#227;o h&#225; linhas para serem mostradas</div></tr></tr>';
    }
    
    return $table_data_rows;
}

function get_department_data_row($department, $controller, $i)
{
    $CI = & get_instance();
    
    $table_data_row = '';
    
    $table_data_row .= '						<tr ondblclick="D(' . $department->result_object[$i]->department_id . ');" id="' . $department->result_object[$i]->department_id . '">';
    $table_data_row .= '							<td><input type="checkbox" id="check" onclick="mudaCor(' . $department->result_object[$i]->department_id . ')" value="' . $department->result_object[$i]->department_id . '"/></td>';
    $table_data_row .= '							<td>' . $department->result_object[$i]->department_id . '</td>';
    $table_data_row .= '							<td>' . ($department->result_object[$i]->name) . '</td>';
    $table_data_row .= '							<td>' . ($department->result_object[$i]->description) . '</td>';
    $table_data_row .= '						</tr>';
    
    return $table_data_row;
}

/**
 * ******************************************************************************* *
 */
/**
 * FIM DA TABELA DE DEPARTAMENTOS *
 */

/*
 * Obtem uma tabela html para gerenciar Departamentos.
 */
function get_type_manage_table($type, $controller)
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
        '						<th style="width:15%;"><strong>Codigo</strong></th>',
        '						<th style="width:30%;"><strong>Tipo de Produto</strong></th>',
        '						<th style="width:40%;"><strong>Descri&#231;&#227;o</strong></th>'
    );
    
    foreach ($headers as $header) {
        $table .= $header . "\n";
    }
    
    $table .= '					</tr>' . "\n";
    $table .= '					</thead>' . "\n";
    
    $table .= '					<tbody class="no-border-y">' . "\n";
    $table .= get_type_manage_table_data_rows($type, $controller);
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
function get_type_manage_table_data_rows($type, $controller)
{
    $CI = & get_instance();
    $table_data_rows = '';
    
    foreach ($type->result() as $types) {
        $table_data_rows .= get_type_data_row($types, $controller);
    }
    
    if ($type->num_rows() == 0) {
        $table_data_rows .= '<tr><td colspan="4"><div class="warning_message" style="padding:7px;">N&#227;o h&#225; linhas para serem mostradas</div></tr></tr>';
    }
    
    return $table_data_rows;
}

function get_type_data_row($type, $controller)
{
    $CI = & get_instance();
    
    $table_data_row = '';
    
    $table_data_row .= '						<tr ondblclick="D(' . $type->type_id . ');" id="' . $type->type_id . '">';
    $table_data_row .= '							<td><input type="checkbox" id="check" onclick="mudaCor(' . $type->type_id . ')" value="' . $type->type_id . '"/></td>';
    $table_data_row .= '							<td>' . $type->type_id . '</td>';
    $table_data_row .= '							<td>' . $type->name . '</td>';
    $table_data_row .= '							<td>' . $type->description . '</td>';
    $table_data_row .= '						</tr>';
    
    return $table_data_row;
}

/**
 * ******************************************************************************* *
 */
/**
 * FIM DA TABELA DE TYPOS *
 */

/*
 * Obtem uma tabela html para gerenciar Departamentos.
 */
function get_category_manage_table($category, $controller)
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
        '						<th style="width:15%;"><strong>Codigo</strong></th>',
        '						<th style="width:30%;"><strong>Categoria</strong></th>',
        '						<th style="width:40%;"><strong>Descri&#231;&#227;o</strong></th>'
    );
    
    foreach ($headers as $header) {
        $table .= $header . "\n";
    }
    
    $table .= '					</tr>' . "\n";
    $table .= '					</thead>' . "\n";
    
    $table .= '					<tbody class="no-border-y">' . "\n";
    $table .= get_category_manage_table_data_rows($category, $controller);
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
function get_category_manage_table_data_rows($category, $controller)
{
    $CI = & get_instance();
    $table_data_rows = '';
    
    $i = 0;
    foreach ($category->result() as $categories) {
        $table_data_rows .= get_category_data_row($categories, $controller, $i);
        $i ++;
    }
    
    if ($category->num_rows() == 0) {
        $table_data_rows .= '<tr><td colspan="4"><div class="warning_message" style="padding:7px;">N&#227;o h&#225; linhas para serem mostradas</div></tr></tr>';
    }
    
    return $table_data_rows;
}

function get_category_data_row($categories, $controller, $i)
{
    $CI = & get_instance();
    
    $table_data_row = '';
    
    $table_data_row .= '						<tr ondblclick="D(' . $categories->category_id . ');" id="' . $categories->category_id . '">';
    $table_data_row .= '							<td><input type="checkbox" id="check" onclick="mudaCor(' . $categories->category_id . ')" value="' . $categories->category_id . '"/></td>';
    $table_data_row .= '							<td>' . $categories->category_id . '</td>';
    $table_data_row .= '							<td>' . $categories->name . '</td>';
    $table_data_row .= '							<td>' . $categories->description . '</td>';
    $table_data_row .= '						</tr>';
    
    return $table_data_row;
}

/**
 * ******************************************************************************* *
 */
/**
 * FIM DA TABELA DE CATEGORIA *
 */

/*
 * Obtem uma tabela html para gerenciar Departamentos.
 */
function get_item_supplier_manage_table($item_supplier, $controller)
{
    $CI = & get_instance();
    $table = '	<!----TABLE LISTING STARTS--->' . "\n";
    $table .= '		<div class="content">' . "\n";
    $table .= '			<div class="table-responsive">' . "\n";
    
    $table .= '				<table class="table no-border hover">' . "\n";
    $table .= '					<thead class="no-border">' . "\n";
    $table .= '					<tr>' . "\n";
    
    $headers = array(
        '					<th style="width:2%;">#</th>',
        '					<th style="width:13%;"><strong>Marca</strong></th>',
        '					<th style="width:13%;"><strong>Modelo</strong></th>',
        '					<th style="width:13%;"><strong>Tipo</strong></th>',
        '					<th style="width:13%;"><strong>Serie</strong></th>',
        '					<th style="width:10%;"><strong>Lado</strong></th>',
        '					<th style="width:10%;"><strong>Data Compra</strong></th>',
        '					<th style="width:15%;"><strong>Garantia Fabricante</strong></th>'
    );
    
    foreach ($headers as $header) {
        $table .= $header . "\n";
    }
    
    $table .= '					</tr>' . "\n";
    $table .= '					</thead>' . "\n";
    
    $table .= '					<tbody class="no-border-y">' . "\n";
    $table .= get_item_supplier_manage_table_data_rows($item_supplier, $controller);
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
function get_item_supplier_manage_table_data_rows($item_supplier, $controller)
{
    $CI = & get_instance();
    $table_data_rows = '';
    
    $i = 0;
    foreach ($item_supplier->result() as $items_supplierts) {
        $table_data_rows .= get_item_supplier_data_row($items_supplierts, $controller, $i);
        $i ++;
    }
    
    if ($item_supplier->num_rows() == 0) {
        $table_data_rows .= '<tr><td colspan="7"><div class="warning_message" style="padding:7px;">N&#227;o h&#225; linhas para serem mostradas</div></tr></tr>';
    }
    
    return $table_data_rows;
}

function get_item_supplier_data_row($item_supplier, $controller, $i)
{
    $CI = & get_instance();
    
    $table_data_row = '';
    
    $table_data_row .= '						<tr "id="' . $item_supplier->item_id . '">';
    $table_data_row .= '							<td>' . $item_supplier->supplier_id . '</td>';
    $table_data_row .= '							<td>' . $item_supplier->model . '</td>';
    $table_data_row .= '							<td>' . $item_supplier->type . '</td>';
    $table_data_row .= '							<td>' . $item_supplier->serie . '</td>';
    $table_data_row .= '							<td>' . $item_supplier->side . '</td>';
    $table_data_row .= '							<td> </td>';
    $table_data_row .= '							<td> </td>';
    $table_data_row .= '							<td> </td>';
    $table_data_row .= '						</tr>';
    
    return $table_data_row;
}

/**
 * ******************************************************************************* *
 */
/**
 * FIM DA TABELA DE ITENS POR FORNECEDOR *
 */

/*
 * Obt�m uma tabela html para gerenciar paciente.
 */
function get_fleet_manage_table($patient, $controller)
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
        '						<th style="width:20%;"><strong>Tipo</strong></th>',
        '						<th style="width:15%;"><strong>Marca</strong></th>',
        '						<th class="text-right"><strong>Modelo</strong></th>',
        '						<th style="width:15%;"><strong>Ano</strong></th>',
        '						<th style="width:15%;"><strong>Placa</strong></th>'
    );
    
    foreach ($headers as $header) {
        $table .= $header . "\n";
    }
    
    $table .= '					</tr>' . "\n";
    $table .= '					</thead>' . "\n";
    
    $table .= '					<tbody class="no-border-y">' . "\n";
    $table .= get_fleet_manage_table_data_rows($fleet, $controller);
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
function get_fleet_manage_table_data_rows($fleet, $controller)
{
    $CI = & get_instance();
    $table_data_rows = '';
    
    $i = 0;
    foreach ($fleet->result() as $car) {
        $table_data_rows .= get_fleet_data_row($car, $controller);
        $i ++;
    }
    
    if ($fleet->num_rows() == 0) {
        $table_data_rows .= '<tr><td colspan="6"><div class="warning_message" style="padding:7px;">N&#227;o h&#225; linhas para serem mostradas</div></tr></tr>';
    }
    
    return $table_data_rows;
}

function get_fleet_data_row($fleet, $controller)
{
    $CI = & get_instance();
    
    $table_data_row = '';
    
    $table_data_row .= '						<tr id="' . $fleet->id . '">';
    $table_data_row .= '							<td><input type="checkbox" id="check" onclick="mudaCor(' . $fleet->patient_id . ')" value="' . $fleet->patient_id . '"/></td>';
    $table_data_row .= '							<td>' . $fleet->tipo_veiculo . '</td>';
    $table_data_row .= '							<td>' . $fleet->marca . '</td>';
    $table_data_row .= '							<td class="text-right">' . $fleet->modelo . '</td>';
    $table_data_row .= '							<td>' . $fleet->ano . '</td>';
    $table_data_row .= '							<td>' . $fleet->placa . '</td>';
    $table_data_row .= '						</tr>';
    
    return $table_data_row;
}

/**
 * ******************************************************************************* *
 */
/**
 * FIM DA TABELA DE PACIENTES *
 */

/*
 * Obt�m uma tabela html para gerenciar paciente.
 */
function get_account_manage_table($account, $controller, $op)
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
        '						<th style="width:2%;"><input type="checkbox" id="check" onclick="CheckAll(event);"/></th>',
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
    $table .= get_account_manage_table_data_rows($account, $controller, $op);
    $table .= '					</tbody>' . "\n";
    
    return $table;
}

/*
 * Obtem as linhas de dados de html para o povo.
 */
function get_account_manage_table_data_rows($account, $controller, $op)
{
    $CI = & get_instance();
    $table_data_rows = '';
    
    foreach ($account->result() as $accounts) {
        $table_data_rows .= get_account_data_row($accounts, $controller, $op);
    }
    
    if ($account->num_rows() == 0) {
        $table_data_rows .= '<tr><td colspan="7"><div class="warning_message" style="padding:7px;">N&#227;o h&#225; linhas para serem mostradas</div></tr></tr>';
    }
    
    return $table_data_rows;
}

function get_account_data_row($account, $controller, $op)
{
    $CI = & get_instance();
    
    if ($op == 0) {
        $operation = 'class="text-success"><label>';
    } elseif ($op == 1) {
        $operation = 'class="text-danger"><label>';
    }
    
    $table_data_row = '';
    
    $table_data_row .= '						<tr ondblclick="D(' . $account->id . ');" id="' . $account->id . '">';
    $table_data_row .= '							<td><input type="checkbox" id="check" onclick="mudaCor(' . $account->id . ')" value="' . $account->id . '"/></td>';
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
 * FIM DA TABELA DE PACIENTES *
 */

?>
