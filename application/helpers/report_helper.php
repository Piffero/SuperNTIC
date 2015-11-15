<?php

function get_report_customers_history($patient, $patient_info, $controller)
{
    $CI = & get_instance();
    
    $report = '<!-- REPORT STARTS -->' . "\n";
    $report .= '	<div class="col-md-12" id="print">' . "\n";
    $report .= '		<div class="block-flat">' . "\n";
    $report .= '			<form id="customers_form" class="form-horizontal group-border-dashed">' . "\n";
    
    $report .= get_report_customers_info($patient, $patient_info, $controller);
    
    $report .= '			</form>' . "\n";
    $report .= '		</div>' . "\n";
    $report .= '	</div>' . "\n";
    
    return $report;
}

function get_report_customers_info($patient, $patient_info, $controller)
{
    $CI = & get_instance();
    $report_data = '';
    
    foreach ($patient_info->result() as $customers_info) {
        $customer_info = $customers_info;
    }
    
    foreach ($patient->result() as $customer) {
        $report_data .= get_report_customers_data($customer, $customer_info, $controller);
    }
    
    if ($patient->num_rows() == 0) {
        $report_data .= '<div class="content overflow-hidden">' . "\n";
        $report_data .= '	<blockquote>' . "\n";
        $report_data .= '		<p>N�o Possui registro ou os dados est�o incompleto </p>' . "\n";
        $report_data .= '		<small>Resultado</small>' . "\n";
        $report_data .= '	</blockquote>' . "\n";
    }
    
    return $report_data;
}

function get_report_customers_data($patient, $patient_info, $controller)
{
    $CI = & get_instance();
    
    $report_data_info = '<h4>Dados do Cliente</h4>';
    $report_data_info .= '<div class="form-group">' . "\n";
    $report_data_info .= '	<label class="col-sm-2 control-label">Nome do Cliente:</label>' . "\n";
    $report_data_info .= '	<div class="col-sm-3 control-label"><p class="text-left">' . $patient->first_name . ' ' . $patient->last_name . '</p></div>' . "\n";
    $report_data_info .= '	<label class="col-sm-2 control-label">Cliente Desde:</label>' . "\n";
    $report_data_info .= '	<div class="col-sm-1 control-label"><p class="text-left">' . $patient->account_opening . '</p></div>' . "\n";
    $report_data_info .= '	<label class="col-sm-2 control-label">Data de Nascimento:</label>' . "\n";
    $report_data_info .= '	<div class="col-sm-1 control-label"><p class="text-left">' . $patient->birth_date . '</p></div>' . "\n";
    $report_data_info .= '<br><br>' . "\n";
    $report_data_info .= '	<label class="col-sm-2 control-label">Nome Preferencial</label>' . "\n";
    $report_data_info .= '	<div class="col-sm-1 control-label"><p class="text-left">' . $patient->prefer_name . '</p></div>' . "\n";
    $report_data_info .= '	<label class="col-sm-4 control-label">Sexo:</label>' . "\n";
    $report_data_info .= '	<div class="col-sm-1 control-label"><p class="text-left">' . $patient->sex . '</p></div>' . "\n";
    $report_data_info .= '</div>' . "\n";
    
    $report_data_info .= '<div class="form-group">' . "\n";
    $report_data_info .= '	<label class="col-sm-2 control-label">CPF:</label>' . "\n";
    $report_data_info .= '	<div class="col-sm-1 control-label"><p class="text-left">' . $patient->document_cpf . '</p></div>' . "\n";
    $report_data_info .= '	<label class="col-sm-6 control-label">Telefone Residencial:</label>' . "\n";
    $report_data_info .= '	<div class="col-sm-3 control-label"><p class="text-left">' . $patient->phone_home . '</p></div>' . "\n";
    $report_data_info .= '<br><br>' . "\n";
    $report_data_info .= '	<label class="col-sm-2 control-label">RG:</label>' . "\n";
    $report_data_info .= '	<div class="col-sm-1 control-label"><p class="text-left">' . $patient->document_rg . '</p></div>' . "\n";
    $report_data_info .= '	<label class="col-sm-6 control-label">Telefone Trabalho:</label>' . "\n";
    $report_data_info .= '	<div class="col-sm-3 control-label"><p class="text-left">' . $patient->phone_work . '</p></div>' . "\n";
    $report_data_info .= '<br><br>' . "\n";
    $report_data_info .= '	<label class="col-sm-9 control-label">Telefone Celular:</label>' . "\n";
    $report_data_info .= '	<div class="col-sm-3 control-label"><p class="text-left">' . $patient->phone_cell . '</p></div>' . "\n";
    $report_data_info .= '<br><br>' . "\n";
    $report_data_info .= '	<label class="col-sm-9 control-label">Outro Telefone:</label>' . "\n";
    $report_data_info .= '	<div class="col-sm-3 control-label"><p class="text-left">' . $patient->phone_other . '</p></div>' . "\n";
    $report_data_info .= '</div>' . "\n";
    
    $report_data_info .= '<div class="form-group">' . "\n";
    $report_data_info .= '	<label class="col-sm-2 control-label">Endere&#231;o:</label>' . "\n";
    $report_data_info .= '	<div class="col-sm-3 control-label"><p class="text-left">' . $patient->address_1 . '</p></div>' . "\n";
    $report_data_info .= '	<label class="col-sm-2 control-label">Bairro:</label>' . "\n";
    $report_data_info .= '	<div class="col-sm-2 control-label"><p class="text-left">' . $patient->country . '</p></div>' . "\n";
    $report_data_info .= '<br><br>' . "\n";
    $report_data_info .= '	<label class="col-sm-2 control-label">Complemento:</label>' . "\n";
    $report_data_info .= '	<div class="col-sm-3 control-label"><p class="text-left">' . $patient->address_2 . '</p></div>' . "\n";
    $report_data_info .= '	<label class="col-sm-2 control-label">Cidade:</label>' . "\n";
    $report_data_info .= '	<div class="col-sm-1 control-label"><p class="text-left">' . $patient->city . '</p></div>' . "\n";
    $report_data_info .= '	<label class="col-sm-1 control-label">UF:</label>' . "\n";
    $report_data_info .= '	<div class="col-sm-1 control-label"><p class="text-left">' . $patient->state . '</p></div>' . "\n";
    $report_data_info .= '</div>' . "\n";
    
    if ($patient->waives_terms = 1) {
        $waves = "SIM";
    } else {
        $waves = "N&#195;O";
    }
    if ($patient->sending_letter = 1) {
        $sending = "SIM";
    } else {
        $sending = "N&#195;O";
    }
    if ($patient->sending_email = 1) {
        $mail = "SIM";
    } else {
        $waves = "N&#195;O";
    }
    if ($patient->sending_sms = 1) {
        $sms = "SIM";
    } else {
        $sending = "N&#195;O";
    }
    
    $report_data_info .= '<div class="form-group">' . "\n";
    $report_data_info .= '	<label class="col-sm-3 control-label">Prote&#231;&#227;o de Dados:</label>' . "\n";
    $report_data_info .= '	<div class="col-sm-2 control-label"><p class="text-left">' . $waves . '</p></div>' . "\n";
    $report_data_info .= '<br><br>' . "\n";
    $report_data_info .= '	<label class="col-sm-3 control-label">Permite Envio de Corespondencia:</label>' . "\n";
    $report_data_info .= '	<div class="col-sm-2 control-label"><p class="text-left">' . $sending . '</p></div>' . "\n";
    $report_data_info .= '<br><br>' . "\n";
    $report_data_info .= '	<label class="col-sm-3 control-label">Permite Envio de Email:</label>' . "\n";
    $report_data_info .= '	<div class="col-sm-2 control-label"><p class="text-left">' . $mail . '</p></div>' . "\n";
    $report_data_info .= '<br><br>' . "\n";
    $report_data_info .= '	<label class="col-sm-3 control-label">Permite Envio de SMS:</label>' . "\n";
    $report_data_info .= '	<div class="col-sm-2 control-label"><p class="text-left">' . $sms . '</p></div>' . "\n";
    $report_data_info .= '</div>' . "\n";
    
    $report_data_info .= '<h4>Atendimento e Outros Dados</h4>';
    $report_data_info .= '<div class="form-group">' . "\n";
    $report_data_info .= '	<label class="col-sm-2 control-label">Atendimento Anterior:</label>' . "\n";
    $report_data_info .= '	<div class="col-sm-3 control-label"><p class="text-left">' . $patient_info->previous_doctor . '</p></div>' . "\n";
    $report_data_info .= '	<label class="col-sm-2 control-label">Indicado pelo Medico:</label>' . "\n";
    $report_data_info .= '	<div class="col-sm-3 control-label"><p class="text-left">' . $patient_info->next_doctor_id . '</p></div>' . "\n";
    $report_data_info .= '<br><br>' . "\n";
    $report_data_info .= '	<label class="col-sm-2 control-label">Atendimento Atual:</label>' . "\n";
    $report_data_info .= '	<div class="col-sm-2 control-label"><p class="text-left">' . $patient->country . '</p></div>' . "\n";
    $report_data_info .= '	<label class="col-sm-2 control-label">Cidade:</label>' . "\n";
    $report_data_info .= '	<div class="col-sm-1 control-label"><p class="text-left">' . $patient->city . '</p></div>' . "\n";
    $report_data_info .= '	<label class="col-sm-1 control-label">UF:</label>' . "\n";
    $report_data_info .= '	<div class="col-sm-1 control-label"><p class="text-left">' . $patient->state . '</p></div>' . "\n";
    $report_data_info .= '</div>' . "\n";
    return $report_data_info;
}
 
 
 
 