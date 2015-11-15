<?php
require_once ("secure_area.php");

class Calendars extends Secure_area
{

    var $data_fono;

    var $data_customer;

    function __construct()
    {
        parent::__construct('calendars');
    }

    function index()
    {
        date_default_timezone_set('America/Sao_Paulo');
        
        $data['calendar'] = $this->MostreSemanas(date('d'), date('m'), date('Y'));
        
        // Inicia Lista de Clientes
        $customer_info = $this->Customer->get_all();
        
        if ($customer_info->num_rows() != 0) {
            foreach ($customer_info->result() as $patient) {
                $rows[$patient->patient_id] = $patient->first_name . ' ' . $patient->last_name;
            }
            
            $customer = $rows;
        } else {
            $customer = array(
                'N&#227;o h&#225; Clientes Cadastrados '
            );
        }
        // Acabou Linha de lista de clientes
        
        $data['customers'] = form_dropdown('patient', $customer, array(
            $this->data_fono
        ), 'id="patient" class="form-control"');
        
        if (empty($this->data_fono)) {
            $this->data_fono = '';
        }
        
        // Inicia Lista de fonoaudiologo
        $employeer_fono = $this->Employeer->get_fono();
        
        if ($employeer_fono->num_rows() != 0) {
            
            foreach ($employeer_fono->result() as $fono) {
                $rows_Employeer[$fono->first_name . ' ' . $fono->last_name] = $fono->first_name . ' ' . $fono->last_name;
            }
            
            $employeer_fono = $rows_Employeer;
        } else {
            $employeer_fono = array(
                'N&#227;o h&#225; fonoaudiologo '
            );
        }
        // Acabou Lista de fonoaudiologo
        
        $data['fono'] = form_dropdown('fono', $employeer_fono, array(
            $this->data_fono
        ), 'id="fono" class="form-control" onchange="javascript: agendado(event);"');
        
        $this->load->view('calendar/appointment', $data);
    }

    /**
     * Agendamento geral aparece todos so compromisos das fonos no calendario
     *
     * @return string;
     */
    function agenda()
    {
        date_default_timezone_set('America/Sao_Paulo');
        $modal = $this->input->post('modal');
        
        $CI = & get_instance();
        $CI->session->set_userdata('diaatual', date('d'));
        
        switch ($modal) {
            case 1:
                $this->data_fono = '';
                $this->session->set_userdata('calendar', $modal);
                echo $this->MostreCalendario(date('m'), date('Y'));
                break;
            
            case 2:
                $this->data_fono = '';
                $this->session->set_userdata('calendar', $modal);
                echo $this->MostreDia(date('d'), date('m'), date('Y'));
                break;
            
            case 3:
                $this->data_fono = '';
                $this->session->set_userdata('calendar', $modal);
                echo $this->MostreSemanas(date('d'), date('m'), date('Y'));
                break;
            
            default:
                $this->data_fono = '';
                $this->session->set_userdata('calendar', $modal);
                echo $this->MostreSemanas(date('d'), date('m'), date('Y'));
                break;
        }
    }

    /**
     * Agendamento especifico aparece os compromisos de uma fono especificada no calendario
     *
     * @return string;
     */
    function agendaDo()
    {
        date_default_timezone_set('America/Sao_Paulo');
        $fono = $this->input->post('fono');
        
        $modal = $this->session->userdata('calendar');
        
        switch ($modal) {
            case 1:
                $this->data_fono = $fono;
                echo $this->MostreCalendarioDo(date('m'), date('Y'), $fono);
                break;
            
            case 2:
                $this->data_fono = $fono;
                echo $this->MostreDiaDo(date('d'), date('m'), date('Y'), $fono);
                break;
            
            case 3:
                $this->data_fono = $fono;
                echo $this->MostreSemanasDo(date('d'), date('m'), date('Y'), $fono);
                break;
            
            default:
                $this->data_fono = $fono;
                echo $this->MostreSemanasDo(date('d'), date('m'), date('Y'), $fono);
                break;
        }
    }
    
    /* *********************************************************************************************************************************** */
    function new_appointment()
    {
        $id = $this->input->post('id');
        $employeer = $this->input->post('employeer');
        $teste = convert_timestamp($id);
        $new = explode(' ', $teste);
        
        echo 'var info = ["' . $new[0] . '", "' . $new[1] . '", "' . $employeer . '"];';
    }

    function save($appointments_id = -1)
    {
        $doctor_id = $this->input->post('doctor_id');
        $appointments = get_date_converter($this->input->post('appointment'));
        $hour = $this->input->post('hour');
        
        if ($this->input->post("check") == '1') {
            $peganome = $this->Customer->get_info($this->input->post('patient_id'));
            $nome = $peganome->first_name . ' ' . $peganome->last_name;
            $patient_id = $this->input->post("patient_id");
        } elseif ($this->input->post("check") == '0') {
            $peganome = $this->Customer->get_info("1");
            $nome = $this->input->post("cliente");
            $patient_id = "1";
        }
        
        $appointment_data = array(
            'doctor_id' => $doctor_id,
            'patient_id' => $patient_id,
            'patient_name' => $nome,
            'appointment' => $appointments,
            'hour' => $hour,
            'atendimento' => $this->input->post('atendimento')
        );
        
        if ($this->Appointment->exists($appointments, $hour, $doctor_id) == 0) {
            if ($this->Appointment->save($appointment_data, $appointments_id)) {
                echo 'showcalendar(' . $this->session->userdata('calendar') . ')';
            } else {
                echo 'alert("opss! Ocorreu um erro ao inserir o agendamento.");';
            }
        } else {
            echo 'alert("Opss! O fonoaudiologo ' . $doctor_id . ' ja possui compromisso");';
            exit();
        }
    }
    
    /* *********************************************************************************************************************************** */
    function get_numero_dias($mes)
    {
        $numero_dias = array(
            '01' => 31,
            '02' => 28,
            '03' => 31,
            '04' => 30,
            '05' => 31,
            '06' => 30,
            '07' => 31,
            '08' => 31,
            '09' => 30,
            '10' => 31,
            '11' => 30,
            '12' => 31
        );
        
        if (((date('Y') % 4) == 0 and (date('Y') % 100) != 0) or (date('Y') % 400) == 0) {
            $numero_dias['02'] = 29; // altera o numero de dias de fevereiro se o ano for bissexto
        }
        
        return $numero_dias[$mes];
    }

    function get_numero_semana($dia)
    {
        switch ($dia) {
            case "0":
                return "Dom.";
                break;
            case "1":
                return "Seg.";
                break;
            case "2":
                return "Ter.";
                break;
            case "3":
                return "Qua.";
                break;
            case "4":
                return "Qui.";
                break;
            case "5":
                return "Sex.";
                break;
            case "6":
                return "S&#225;b.";
                break;
        }
        ;
    }

    function get_nome_mes($mes)
    {
        $meses = array(
            '01' => "Janeiro",
            '02' => "Fevereiro",
            '03' => "Mar&#231;o",
            '04' => "Abril",
            '05' => "Maio",
            '06' => "Junho",
            '07' => "Julho",
            '08' => "Agosto",
            '09' => "Setembro",
            '10' => "Outubro",
            '11' => "Novembro",
            '12' => "Dezembro"
        );
        
        if ($mes >= 01 && $mes <= 12) {
            return $meses[$mes];
        } elseif ($mes > 12) {
            return $meses['01'];
        } elseif ($mes < 1) {
            return $meses['12'];
        } else {
            return "Mês desconhecido";
        }
    }

    function get_ano($ano = null)
    {
        return date('Y');
    }
    
    /* *********************************************************************************************************************************** */
    
    /**
     * Função responsavel por mostrar o dia atual no calendario com os
     * apontamentos de todos os fonoaudiologos
     *
     * @param date('d') $dia            
     * @param date('m') $mes            
     * @param date('Y') $ano            
     *
     */
    function MostreDia($dia, $mes, $ano)
    {
        $nome_mes = $this->get_nome_mes($mes);
        
        $calendar_data_rows = '';
        
        $calendar_data_rows .= '<div id="calendar" class="fc fc-ltr">' . "\n";
        $calendar_data_rows .= '	<table class="fc-header" style="width:100%">' . "\n";
        
        $calendar_data_rows .= '		<tbody>' . "\n";
        $calendar_data_rows .= '		<tr>' . "\n";
        $calendar_data_rows .= '			<td class="text-left">' . "\n";
        $calendar_data_rows .= '				<span><h2 id="stringMesAno">' . $dia . ' ' . $nome_mes . ' ' . $ano . '</h2></span>' . "\n";
        $calendar_data_rows .= '			</td>' . "\n";
        $calendar_data_rows .= '			<td class="text-center col-sm-12"></td>' . "\n";
        $calendar_data_rows .= '			<td class="text-right">' . "\n";
        
        $calendar_data_rows .= '				<span id="1" onclick="showcalendar(1);" class="fc-button">M&#234;s</span>' . "\n";
        $calendar_data_rows .= '				<span id="3" onclick="showcalendar(3);" class="fc-button">Semana</span>' . "\n";
        $calendar_data_rows .= '				<span id="2" onclick="showcalendar(2);" class="fc-button fc-state-active">Dia</span>' . "\n";
        
        $calendar_data_rows .= '				<span class="fc-header-space"></span>' . "\n";
        $calendar_data_rows .= '				<span class="fc-button fc-state-disabled">Hoje</span>' . "\n";
        $calendar_data_rows .= '				<span class="fc-header-space"></span>' . "\n";
        
        $calendar_data_rows .= '				<span class="fc-button fc-corner-left"><span class="fa fa-angle-left" onclick="javascript: gotoleft();"></span></span>' . "\n";
        $calendar_data_rows .= '				<span class="fc-button fc-corner-right"><span class="fa fa-angle-right" onclick="javascript: gotoright();"></span></span>' . "\n";
        
        $calendar_data_rows .= '				<span class="fc-header-space"></span>' . "\n";
        
        // Inicia Lista de Categorias
        $employeer_fono = $this->Employeer->get_fono();
        
        if ($employeer_fono->num_rows() != 0) {
            $rows['1'] = 'Todos';
            
            foreach ($employeer_fono->result() as $fono) {
                $rows[$fono->first_name . ' ' . $fono->last_name] = $fono->first_name . ' ' . $fono->last_name;
            }
            
            $employeer_fono = $rows;
        } else {
            $employeer_fono = array(
                'N&#227;o h&#225; fonoaudiologo '
            );
        }
        // Acabou Linha de Categorias
        
        $calendar_data_rows .= form_dropdown('fono', $employeer_fono, array(
            ''
        ), 'id="profi" onchange="javascript: agendado(event);"');
        
        $calendar_data_rows .= '			</td>' . "\n";
        $calendar_data_rows .= '		</tr>' . "\n";
        $calendar_data_rows .= '		</tbody>' . "\n";
        $calendar_data_rows .= '	</table>' . "\n";
        
        $calendar_data_rows .= '	<div class="fc-content" style="position: relative;">' . "\n";
        $calendar_data_rows .= '	<div class="fc-view fc-view-agendaWeek fc-agenda" style="position: relative; -moz-user-select: none;">' . "\n";
        $calendar_data_rows .= '		<table class="fc-agenda-days fc-border-separate" cellspacing="0" style="width:100%">' . "\n";
        $calendar_data_rows .= '		<thead>' . "\n";
        $calendar_data_rows .= '			<tr class="fc-first fc-last">' . "\n";
        
        if (date("d") == $dia) {
            if (date("m") == $mes) {
                $calendar_data_rows .= '				<th class="fc-agenda-axis fc-widget-header fc-first" style="width: 50px;"></th>' . "\n";
                $calendar_data_rows .= '				<th class="fc-sun fc-col0 fc-widget-header" style="width: 679px;"><font color=red>' . $dia . ' - ' . $mes . '</font></th>' . "\n";
                $calendar_data_rows .= '				<th class="fc-agenda-gutter fc-widget-header fc-last" style="width: 17px;"></th>' . "\n";
            } else {
                $calendar_data_rows .= '				<th class="fc-agenda-axis fc-widget-header fc-first" style="width: 50px;"></th>' . "\n";
                $calendar_data_rows .= '				<th class="fc-sun fc-col0 fc-widget-header" style="width: 679px;">' . $dia . ' - ' . $mes . '</th>' . "\n";
                $calendar_data_rows .= '				<th class="fc-agenda-gutter fc-widget-header fc-last" style="width: 17px;"></th>' . "\n";
            }
        } else {
            $calendar_data_rows .= '				<th class="fc-agenda-axis fc-widget-header fc-first" style="width: 50px;"></th>' . "\n";
            $calendar_data_rows .= '				<th class="fc-sun fc-col0 fc-widget-header" style="width: 679px;">' . $dia . ' - ' . $mes . '</th>' . "\n";
            $calendar_data_rows .= '				<th class="fc-agenda-gutter fc-widget-header fc-last" style="width: 17px;"></th>' . "\n";
        }
        
        $calendar_data_rows .= '			</tr>' . "\n";
        $calendar_data_rows .= '		</thead>' . "\n";
        $calendar_data_rows .= '		<tbody>' . "\n";
        
        $calendar_data_rows .= '		<div style="position:relative;width:100%;overflow:hidden">' . "\n";
        
        $horas = 7;
        
        for ($linha = 0; $linha < 23; $linha ++) {
            
            if ($linha % 2 == 0) {
                $calendar_data_rows .= '			<tr class="fc-slot0  fc-last">' . "\n";
                $calendar_data_rows .= '				<th class="fc-agenda-axis fc-widget-header" style="width: 50px;">' . $horas . ':00</th>' . "\n";
                
                if (date("d") == $dia) {
                    if (date("m") == $mes) {
                        $calendar_data_rows .= '				<td class="fc-widget-content" style="background-color: #FFFACD;">' . "\n";
                        $calendar_data_rows .= '					<div id="' . $ano . '-' . $mes . '-' . $dia . ' ' . $horas . ':00" ondblclick="javascript: setdatetime(event); document.getElementById(\'button\').click();" ondrop="drop(event)" ondragover="allowDrop(event)" style="position: relative;">&nbsp;
														    												' . $this->coloca_div($ano . '-' . $mes . '-' . $dia, $horas . ":00") . '
														    												</div>' . "\n";
                        $calendar_data_rows .= '				</td>' . "\n";
                    } else {
                        $calendar_data_rows .= '				<td class="fc-widget-content">' . "\n";
                        $calendar_data_rows .= '					<div id="' . $ano . '-' . $mes . '-' . $dia . ' ' . $horas . ':00" ondblclick="javascript: setdatetime(event); document.getElementById(\'button\').click();" ondrop="drop(event)" ondragover="allowDrop(event)" style="position: relative;">&nbsp;
													    												' . $this->coloca_div($ano . '-' . $mes . '-' . $dia, $horas . ":00") . '
													    												</div>' . "\n";
                        $calendar_data_rows .= '				</td>';
                    }
                } else {
                    $calendar_data_rows .= '				<td class="fc-widget-content">' . "\n";
                    $calendar_data_rows .= '					<div id="' . $ano . '-' . $mes . '-' . $dia . ' ' . $horas . ':00" ondblclick="javascript: setdatetime(event); document.getElementById(\'button\').click();" ondrop="drop(event)" ondragover="allowDrop(event)" style="position: relative;">&nbsp;
													    												' . $this->coloca_div($ano . '-' . $mes . '-' . $dia, $horas . ":00") . '
													    												</div>' . "\n";
                    $calendar_data_rows .= '				</td>';
                }
                
                $calendar_data_rows .= '				<th class="fc-agenda-axis fc-widget-header" style="width: 17px;"></th>' . "\n";
                $calendar_data_rows .= '			</tr>' . "\n";
            } else {
                $calendar_data_rows .= '			<tr class="fc-slot0  fc-last">' . "\n";
                $calendar_data_rows .= '				<th class="fc-agenda-axis fc-widget-header" style="width: 50px;">' . $horas . ':30</th>' . "\n";
                
                if (date("d") == $dia) {
                    if (date("m") == $mes) {
                        $calendar_data_rows .= '				<td class="fc-widget-content" style="background-color: #FFFACD;">' . "\n";
                        $calendar_data_rows .= '					<div id="' . $ano . '-' . $mes . '-' . $dia . ' ' . $horas . ':30" ondblclick="javascript: setdatetime(event); document.getElementById(\'button\').click();" ondrop="drop(event)" ondragover="allowDrop(event)" style="position: relative;">&nbsp;
														    												' . $this->coloca_div($ano . '-' . $mes . '-' . $dia, $horas . ":30") . '											
														    												</div>' . "\n";
                        $calendar_data_rows .= '				</td>';
                    } else {
                        $calendar_data_rows .= '				<td class="fc-widget-content">' . "\n";
                        $calendar_data_rows .= '					<div id="' . $ano . '-' . $mes . '-' . $dia . ' ' . $horas . ':30" ondblclick="javascript: setdatetime(event); document.getElementById(\'button\').click();" ondrop="drop(event)" ondragover="allowDrop(event)" style="position: relative;">&nbsp;
														    												' . $this->coloca_div($ano . '-' . $mes . '-' . $dia, $horas . ":30") . '											
														    												</div>' . "\n";
                        $calendar_data_rows .= '				</td>';
                    }
                } else {
                    $calendar_data_rows .= '				<td class="fc-widget-content">' . "\n";
                    $calendar_data_rows .= '					<div id="' . $ano . '-' . $mes . '-' . $dia . ' ' . $horas . ':30" ondblclick="javascript: setdatetime(event); document.getElementById(\'button\').click();" ondrop="drop(event)" ondragover="allowDrop(event)" style="position: relative;">&nbsp;
													    												' . $this->coloca_div($ano . '-' . $mes . '-' . $dia, $horas . ":30") . '											
													    												</div>' . "\n";
                    $calendar_data_rows .= '				</td>';
                }
                
                $calendar_data_rows .= '				<th class="fc-agenda-axis fc-widget-header" style="width: 17px;"></th>' . "\n";
                $calendar_data_rows .= '			</tr>' . "\n";
                
                $horas ++;
            }
        }
        
        $calendar_data_rows .= '		</div>' . "\n";
        
        $calendar_data_rows .= '		</tbody>' . "\n";
        $calendar_data_rows .= '		</table>' . "\n";
        
        return $calendar_data_rows;
    }

    /**
     * Funï¿½ï¿½o responsavel por mostrar o dia atual no calendario com os
     * apontamentos de um determinado fonoaudiologo
     *
     * @param date('d') $dia            
     * @param date('m') $mes            
     * @param date('Y') $ano            
     * @param string $fono;            
     *
     */
    function MostreDiaDo($dia, $mes, $ano, $profi)
    {
        $nome_mes = $this->get_nome_mes($mes);
        
        $calendar_data_rows = '';
        
        $calendar_data_rows .= '<div id="calendar" class="fc fc-ltr">' . "\n";
        $calendar_data_rows .= '	<table class="fc-header" style="width:100%">' . "\n";
        
        $calendar_data_rows .= '		<tbody>' . "\n";
        $calendar_data_rows .= '		<tr>' . "\n";
        $calendar_data_rows .= '			<td class="text-left">' . "\n";
        $calendar_data_rows .= '				<span><h2 id="stringMesAno">' . $dia . ' ' . $nome_mes . ' ' . $ano . '</h2></span>' . "\n";
        $calendar_data_rows .= '			</td>' . "\n";
        $calendar_data_rows .= '			<td class="text-center col-sm-12"></td>' . "\n";
        $calendar_data_rows .= '			<td class="text-right">' . "\n";
        
        $calendar_data_rows .= '				<span id="1"  onclick="showcalendar(1);" class="fc-button">M&#234;s</span>' . "\n";
        $calendar_data_rows .= '				<span id="3" onclick="showcalendar(3);" class="fc-button">Semana</span>' . "\n";
        $calendar_data_rows .= '				<span id="2" onclick="showcalendar(2);" class="fc-button fc-state-active">Dia</span>' . "\n";
        
        $calendar_data_rows .= '				<span class="fc-header-space"></span>' . "\n";
        $calendar_data_rows .= '				<span class="fc-button fc-state-disabled">Hoje</span>' . "\n";
        $calendar_data_rows .= '				<span class="fc-header-space"></span>' . "\n";
        
        $calendar_data_rows .= '				<span class="fc-button fc-corner-left"><span class="fa fa-angle-left" onclick="javascript: gotoleft();"></span></span>' . "\n";
        $calendar_data_rows .= '				<span class="fc-button fc-corner-right"><span class="fa fa-angle-right" onclick="javascript: gotoright();"></span></span>' . "\n";
        
        $calendar_data_rows .= '				<span class="fc-header-space"></span>' . "\n";
        
        // Inicia Lista de Categorias
        $employeer_fono = $this->Employeer->get_fono();
        
        if ($employeer_fono->num_rows() != 0) {
            $rows['1'] = 'Todos';
            
            foreach ($employeer_fono->result() as $fono) {
                $rows[$fono->first_name . ' ' . $fono->last_name] = $fono->first_name . ' ' . $fono->last_name;
            }
            
            $employeer_fono = $rows;
        } else {
            $employeer_fono = array(
                'N&#227;o h&#225; Fonoaudiologo '
            );
        }
        // Acabou Linha de Categorias
        
        $calendar_data_rows .= form_dropdown('fono', $employeer_fono, array(
            $profi
        ), 'id="profi" onchange="javascript: agendado(event);"');
        
        $calendar_data_rows .= '			</td>' . "\n";
        $calendar_data_rows .= '		</tr>' . "\n";
        $calendar_data_rows .= '		</tbody>' . "\n";
        $calendar_data_rows .= '	</table>' . "\n";
        
        $calendar_data_rows .= '	<div class="fc-content" style="position: relative;">' . "\n";
        $calendar_data_rows .= '	<div class="fc-view fc-view-agendaWeek fc-agenda" style="position: relative; -moz-user-select: none;">' . "\n";
        $calendar_data_rows .= '		<table class="fc-agenda-days fc-border-separate" cellspacing="0" style="width:100%">' . "\n";
        $calendar_data_rows .= '		<thead>' . "\n";
        $calendar_data_rows .= '			<tr class="fc-first fc-last">' . "\n";
        
        if (date("d") == $dia) {
            $calendar_data_rows .= '				<th class="fc-agenda-axis fc-widget-header fc-first" style="width: 50px;"></th>' . "\n";
            $calendar_data_rows .= '				<th class="fc-sun fc-col0 fc-widget-header" style="width: 679px;"><font color=red>' . $dia . ' - ' . $mes . '</font></th>' . "\n";
            $calendar_data_rows .= '				<th class="fc-agenda-gutter fc-widget-header fc-last" style="width: 17px;"></th>' . "\n";
        } else {
            $calendar_data_rows .= '				<th class="fc-agenda-axis fc-widget-header fc-first" style="width: 50px;"></th>' . "\n";
            $calendar_data_rows .= '				<th class="fc-sun fc-col0 fc-widget-header" style="width: 679px;">' . $dia . ' - ' . $mes . '</th>' . "\n";
            $calendar_data_rows .= '				<th class="fc-agenda-gutter fc-widget-header fc-last" style="width: 17px;"></th>' . "\n";
        }
        
        $calendar_data_rows .= '			</tr>' . "\n";
        $calendar_data_rows .= '		</thead>' . "\n";
        $calendar_data_rows .= '		<tbody>' . "\n";
        
        $calendar_data_rows .= '		<div style="position:relative;width:100%;overflow:hidden">' . "\n";
        
        $horas = 7;
        
        for ($linha = 0; $linha < 23; $linha ++) {
            
            if ($linha % 2 == 0) {
                $calendar_data_rows .= '			<tr class="fc-slot0  fc-last">' . "\n";
                $calendar_data_rows .= '				<th class="fc-agenda-axis fc-widget-header" style="width: 50px;">' . $horas . ':00</th>' . "\n";
                
                if (date("d") == $dia) {
                    $calendar_data_rows .= '				<td class="fc-widget-content" style="background-color: #FFFACD;">' . "\n";
                    $calendar_data_rows .= '					<div id="' . $ano . '-' . $mes . '-' . $dia . ' ' . $horas . ':00" ondblclick="javascript: setdatetime(event); document.getElementById(\'button\').click();" ondrop="drop(event)" ondragover="allowDrop(event)" style="position: relative;">&nbsp;
													    												' . $this->coloca_div_do($ano . '-' . $mes . '-' . $dia, $horas . ":00", $profi) . '
													    												</div>' . "\n";
                    $calendar_data_rows .= '				</td>' . "\n";
                } else {
                    $calendar_data_rows .= '				<td class="fc-widget-content">' . "\n";
                    $calendar_data_rows .= '					<div id="' . $ano . '-' . $mes . '-' . $dia . ' ' . $horas . ':00" ondblclick="javascript: setdatetime(event); document.getElementById(\'button\').click();" ondrop="drop(event)" ondragover="allowDrop(event)" style="position: relative;">&nbsp;
													    												' . $this->coloca_div_do($ano . '-' . $mes . '-' . $dia, $horas . ":00", $profi) . '
													    												</div>' . "\n";
                    $calendar_data_rows .= '				</td>';
                }
                
                $calendar_data_rows .= '				<th class="fc-agenda-axis fc-widget-header" style="width: 17px;"></th>' . "\n";
                $calendar_data_rows .= '			</tr>' . "\n";
            } else {
                $calendar_data_rows .= '			<tr class="fc-slot0  fc-last">' . "\n";
                $calendar_data_rows .= '				<th class="fc-agenda-axis fc-widget-header" style="width: 50px;">' . $horas . ':30</th>' . "\n";
                
                if (date("d") == $dia) {
                    $calendar_data_rows .= '				<td class="fc-widget-content" style="background-color: #FFFACD;">' . "\n";
                    $calendar_data_rows .= '					<div id="' . $ano . '-' . $mes . '-' . $dia . ' ' . $horas . ':30" ondblclick="javascript: setdatetime(event); document.getElementById(\'button\').click();" ondrop="drop(event)" ondragover="allowDrop(event)" style="position: relative;">&nbsp;
													    												' . $this->coloca_div_do($ano . '-' . $mes . '-' . $dia, $horas . ":30", $profi) . '										
													    												</div>' . "\n";
                    $calendar_data_rows .= '				</td>';
                } else {
                    $calendar_data_rows .= '				<td class="fc-widget-content">' . "\n";
                    $calendar_data_rows .= '					<div id="' . $ano . '-' . $mes . '-' . $dia . ' ' . $horas . ':30" ondblclick="javascript: setdatetime(event); document.getElementById(\'button\').click();" ondrop="drop(event)" ondragover="allowDrop(event)" style="position: relative;">&nbsp;
													    												' . $this->coloca_div_do($ano . '-' . $mes . '-' . $dia, $horas . ":30", $profi) . '											
													    												</div>' . "\n";
                    $calendar_data_rows .= '				</td>';
                }
                
                $calendar_data_rows .= '				<th class="fc-agenda-axis fc-widget-header" style="width: 17px;"></th>' . "\n";
                $calendar_data_rows .= '			</tr>' . "\n";
                
                $horas ++;
            }
        }
        
        $calendar_data_rows .= '		</div>' . "\n";
        
        $calendar_data_rows .= '		</tbody>' . "\n";
        $calendar_data_rows .= '		</table>' . "\n";
        
        return $calendar_data_rows;
    }

    function MostreSemanas($dia, $mes, $ano)
    {
        $nome_mes = $this->get_nome_mes($mes);
        $dia_semana = date("w");
        
        $calendar_data_rows = '';
        
        $calendar_data_rows .= '<div id="calendar" class="fc fc-ltr">' . "\n";
        $calendar_data_rows .= '	<table class="fc-header" style="width:100%">' . "\n";
        
        $calendar_data_rows .= '		<tbody>' . "\n";
        $calendar_data_rows .= '		<tr>' . "\n";
        $calendar_data_rows .= '			<td class="text-left">' . "\n";
        $calendar_data_rows .= '				<span><h2 id="stringMesAno">' . $nome_mes . ' ' . $ano . '</h2></span>' . "\n";
        $calendar_data_rows .= '			</td>' . "\n";
        $calendar_data_rows .= '			<td class="text-center col-sm-12"></td>' . "\n";
        $calendar_data_rows .= '			<td class="text-right">' . "\n";
        
        $calendar_data_rows .= '				<span id="1" onclick="showcalendar(1);" class="fc-button">M&#234;s</span>' . "\n";
        $calendar_data_rows .= '				<span id="3" onclick="showcalendar(3);" class="fc-button fc-state-active">Semana</span>' . "\n";
        $calendar_data_rows .= '				<span id="2" onclick="showcalendar(2);" class="fc-button">Dia</span>' . "\n";
        
        $calendar_data_rows .= '				<span class="fc-header-space"></span>' . "\n";
        $calendar_data_rows .= '				<span class="fc-button fc-state-disabled">Hoje</span>' . "\n";
        $calendar_data_rows .= '				<span class="fc-header-space"></span>' . "\n";
        
        $calendar_data_rows .= '				<span class="fc-button fc-corner-left"><span class="fa fa-angle-left" onclick="javascript: gotoleft();"></span></span>' . "\n";
        $calendar_data_rows .= '				<span class="fc-button fc-corner-right"><span class="fa fa-angle-right" onclick="javascript: gotoright();"></span></span>' . "\n";
        
        $calendar_data_rows .= '				<span class="fc-header-space"></span>' . "\n";
        
        // Inicia Lista de Fonoaudiologas
        $employeer_fono = $this->Employeer->get_fono();
        
        if ($employeer_fono->num_rows() != 0) {
            $rows['1'] = 'Todos';
            foreach ($employeer_fono->result() as $fono) {
                $rows[$fono->first_name . ' ' . $fono->last_name] = $fono->first_name . ' ' . $fono->last_name;
            }
            
            $employeer_fono = $rows;
        } else {
            $employeer_fono = array(
                'N&#227;o h&#225; Fonoaudiologo '
            );
        }
        // Acabou Linha de Fonoaudiologas
        
        $calendar_data_rows .= form_dropdown('fono', $employeer_fono, array(
            ''
        ), 'id="profi" onchange="javascript: agendado(event);"');
        
        $calendar_data_rows .= '			</td>' . "\n";
        $calendar_data_rows .= '		</tr>' . "\n";
        $calendar_data_rows .= '		</tbody>' . "\n";
        $calendar_data_rows .= '	</table>' . "\n";
        
        $calendar_data_rows .= '	<div class="fc-content" style="position: relative;">' . "\n";
        $calendar_data_rows .= '	<div class="fc-view fc-view-agendaWeek fc-agenda" style="position: relative; -moz-user-select: none;">' . "\n";
        $calendar_data_rows .= '		<table class="fc-agenda-days fc-border-separate" cellspacing="0" style="width:100%">' . "\n";
        $calendar_data_rows .= '		<thead>' . "\n";
        $calendar_data_rows .= '			<tr class="fc-first fc-last">' . "\n";
        
        $calendar_data_rows .= '				<th class="fc-agenda-axis fc-widget-header fc-first" style="width: 50px;"></th>' . "\n";
        
        $cont = 0;
        
        While ($cont <= 6) {
            $dia_calendario = date("d/m", mktime(0, 0, 0, $mes, $dia - $dia_semana, $ano));
            $dia_do_calendario[] = date("Y-m-d", mktime(0, 0, 0, $mes, $dia - $dia_semana, $ano));
            $dia_s_calendario = $this->get_numero_semana(date("w", mktime(0, 0, 0, $mes, $dia - $dia_semana, $ano)));
            
            If ($dia_calendario == $dia . "/" . $mes) {
                $calendar_data_rows .= '				<th class="fc-sun fc-col' . $cont . ' fc-widget-header" style="width: 97px;"><font color=red>' . $dia_s_calendario . ' - ' . $dia_calendario . '</font></th>' . "\n";
            } else {
                $calendar_data_rows .= '				<th class="fc-sun fc-col' . $cont . ' fc-widget-header" style="width: 97px;">' . $dia_s_calendario . ' - ' . $dia_calendario . '</th>' . "\n";
            }
            $dia_semana --;
            $cont ++;
        }
        
        $calendar_data_rows .= '				<th class="fc-agenda-gutter fc-widget-header fc-last" style="width: 17px;"></th>' . "\n";
        
        $calendar_data_rows .= '			</tr>' . "\n";
        $calendar_data_rows .= '		</thead>' . "\n";
        $calendar_data_rows .= '		<tbody>' . "\n";
        
        $calendar_data_rows .= '		<div style="position:relative;width:100%;overflow:hidden">' . "\n";
        
        $count = 0;
        $horas = 7;
        $dia_semana = date("w");
        
        while ($count < 23) {
            
            if ($count % 2 == 0) {
                $calendar_data_rows .= '			<tr class="fc-slot0  fc-last">' . "\n";
                $calendar_data_rows .= '				<th class="fc-agenda-axis fc-widget-header" style="width: 50px;">' . $horas . ':00</th>' . "\n";
                
                $col = 0;
                
                while ($col <= 6) {
                    
                    if (date("w") == $col) {
                        if (date("d") == $dia) {
                            $calendar_data_rows .= '				<td class="fc-widget-content" style="background-color: #FFFACD;">' . "\n";
                            $calendar_data_rows .= '					<div id="' . $dia_do_calendario[$col] . ' ' . $horas . ':00" ondblclick="javascript: setdatetime(event); document.getElementById(\'button\').click();"  ondrop="drop(event)" ondragover="allowDrop(event)" align="center" style="position: relative;">&nbsp;
													   													' . $this->coloca_div($dia_do_calendario[$col], $horas . ":00") . '
													   													</div>' . "\n";
                            $calendar_data_rows .= '				</td>';
                        } else {
                            $calendar_data_rows .= '				<td class="fc-widget-content">' . "\n";
                            $calendar_data_rows .= '					<div id="' . $dia_do_calendario[$col] . ' ' . $horas . ':00" ondblclick="javascript: setdatetime(event); document.getElementById(\'button\').click();" ondrop="drop(event)" ondragover="allowDrop(event)" align="center" style="position: relative;">&nbsp;
													    												' . $this->coloca_div($dia_do_calendario[$col], $horas . ":00") . '
													    												</div>' . "\n";
                            $calendar_data_rows .= '				</td>';
                        }
                    } else {
                        $calendar_data_rows .= '				<td class="fc-widget-content">' . "\n";
                        $calendar_data_rows .= '					<div id="' . $dia_do_calendario[$col] . ' ' . $horas . ':00" ondblclick="javascript: setdatetime(event); document.getElementById(\'button\').click();" ondrop="drop(event)" ondragover="allowDrop(event)" align="center" style="position: relative;">&nbsp;
												    												' . $this->coloca_div($dia_do_calendario[$col], $horas . ":00") . '
												    												</div>' . "\n";
                        $calendar_data_rows .= '				</td>';
                    }
                    $dia_semana --;
                    $col ++;
                }
                
                $calendar_data_rows .= '				<th class="fc-agenda-axis fc-widget-header" style="width: 17px;"></th>' . "\n";
                $calendar_data_rows .= '			</tr>' . "\n";
                
                $count ++;
            } else {
                $calendar_data_rows .= '			<tr class="fc-slot0  fc-last">' . "\n";
                $calendar_data_rows .= '				<th class="fc-agenda-axis fc-widget-header" style="width: 50px;">' . $horas . ':30</th>' . "\n";
                
                $col = 0;
                
                while ($col <= 6) {
                    
                    if (date("w") == $col) {
                        if (date("d") == $dia) {
                            $calendar_data_rows .= '				<td class="fc-widget-content" style="background-color: #FFFACD;">' . "\n";
                            $calendar_data_rows .= '					<div id="' . $dia_do_calendario[$col] . ' ' . $horas . ':30" ondblclick="javascript: setdatetime(event); document.getElementById(\'button\').click();" ondrop="drop(event)" ondragover="allowDrop(event)" align="center" style="position: relative;">&nbsp;
												    												' . $this->coloca_div($dia_do_calendario[$col], $horas . ":30") . '
												    												</div>' . "\n";
                            $calendar_data_rows .= '				</td>';
                        }
                    } else {
                        $calendar_data_rows .= '				<td class="fc-widget-content">' . "\n";
                        $calendar_data_rows .= '					<div id="' . $dia_do_calendario[$col] . ' ' . $horas . ':30" ondblclick="javascript: setdatetime(event); document.getElementById(\'button\').click();" ondrop="drop(event)" ondragover="allowDrop(event)" align="center" style="position: relative;">&nbsp;
												    												' . $this->coloca_div($dia_do_calendario[$col], $horas . ":30") . '
												    												</div>' . "\n";
                        $calendar_data_rows .= '				</td>';
                    }
                    $dia_semana --;
                    $col ++;
                }
                
                $calendar_data_rows .= '				<th class="fc-agenda-axis fc-widget-header" style="width: 17px;"></th>' . "\n";
                $calendar_data_rows .= '			</tr>' . "\n";
                
                $count ++;
                $horas ++;
            }
        }
        
        $calendar_data_rows .= '		</div>' . "\n";
        
        $calendar_data_rows .= '		</tbody>' . "\n";
        $calendar_data_rows .= '		</table>' . "\n";
        
        return $calendar_data_rows;
    }

    function MostreSemanasDo($dia, $mes, $ano, $profi)
    {
        $nome_mes = $this->get_nome_mes($mes);
        $dia_semana = date("w");
        
        $calendar_data_rows = '';
        
        $calendar_data_rows .= '<div id="calendar" class="fc fc-ltr">' . "\n";
        $calendar_data_rows .= '	<table class="fc-header" style="width:100%">' . "\n";
        
        $calendar_data_rows .= '		<tbody>' . "\n";
        $calendar_data_rows .= '		<tr>' . "\n";
        $calendar_data_rows .= '			<td class="text-left">' . "\n";
        $calendar_data_rows .= '				<span><h2 id="stringMesAno">' . $nome_mes . ' ' . $ano . '</h2></span>' . "\n";
        $calendar_data_rows .= '			</td>' . "\n";
        $calendar_data_rows .= '			<td class="text-center col-sm-12"></td>' . "\n";
        $calendar_data_rows .= '			<td class="text-right">' . "\n";
        
        $calendar_data_rows .= '				<span id="1" onclick="showcalendar(1);" class="fc-button">M&#234;s</span>' . "\n";
        $calendar_data_rows .= '				<span id="3" onclick="showcalendar(3);" class="fc-button fc-state-active">Semana</span>' . "\n";
        $calendar_data_rows .= '				<span id="2" onclick="showcalendar(2);" class="fc-button">Dia</span>' . "\n";
        
        $calendar_data_rows .= '				<span class="fc-header-space"></span>' . "\n";
        $calendar_data_rows .= '				<span class="fc-button fc-state-disabled">Hoje</span>' . "\n";
        $calendar_data_rows .= '				<span class="fc-header-space"></span>' . "\n";
        
        $calendar_data_rows .= '				<span class="fc-button fc-corner-left"><span class="fa fa-angle-left" onclick="javascript: gotoleft();"></span></span>' . "\n";
        $calendar_data_rows .= '				<span class="fc-button fc-corner-right"><span class="fa fa-angle-right" onclick="javascript: gotoright();"></span></span>' . "\n";
        
        $calendar_data_rows .= '				<span class="fc-header-space"></span>' . "\n";
        
        // Inicia Lista de Fonoaudiologas
        $employeer_fono = $this->Employeer->get_fono();
        
        if ($employeer_fono->num_rows() != 0) {
            $rows['1'] = 'Todos';
            foreach ($employeer_fono->result() as $fono) {
                $rows[$fono->first_name . ' ' . $fono->last_name] = $fono->first_name . ' ' . $fono->last_name;
            }
            
            $employeer_fono = $rows;
        } else {
            $employeer_fono = array(
                'N&#227;o h&#225; Fonoaudiologo '
            );
        }
        // Acabou Linha de Fonoaudiologas
        
        $calendar_data_rows .= form_dropdown('fono', $employeer_fono, array(
            $profi
        ), 'id="profi" onchange="javascript: agendado(event);"');
        
        $calendar_data_rows .= '			</td>' . "\n";
        $calendar_data_rows .= '		</tr>' . "\n";
        $calendar_data_rows .= '		</tbody>' . "\n";
        $calendar_data_rows .= '	</table>' . "\n";
        
        $calendar_data_rows .= '	<div class="fc-content" style="position: relative;">' . "\n";
        $calendar_data_rows .= '	<div class="fc-view fc-view-agendaWeek fc-agenda" style="position: relative; -moz-user-select: none;">' . "\n";
        $calendar_data_rows .= '		<table class="fc-agenda-days fc-border-separate" cellspacing="0" style="width:100%">' . "\n";
        $calendar_data_rows .= '		<thead>' . "\n";
        $calendar_data_rows .= '			<tr class="fc-first fc-last">' . "\n";
        
        $calendar_data_rows .= '				<th class="fc-agenda-axis fc-widget-header fc-first" style="width: 50px;"></th>' . "\n";
        
        $cont = 0;
        
        While ($cont <= 6) {
            $dia_calendario = date("d/m", mktime(0, 0, 0, $mes, $dia - $dia_semana, $ano));
            $dia_do_calendario[] = date("Y-m-d", mktime(0, 0, 0, $mes, $dia - $dia_semana, $ano));
            $dia_s_calendario = $this->get_numero_semana(date("w", mktime(0, 0, 0, $mes, $dia - $dia_semana, $ano)));
            
            If ($dia_calendario == $dia . "/" . $mes) {
                $calendar_data_rows .= '				<th class="fc-sun fc-col' . $cont . ' fc-widget-header" style="width: 97px;"><font color=red>' . $dia_s_calendario . ' - ' . $dia_calendario . '</font></th>' . "\n";
            } else {
                $calendar_data_rows .= '				<th class="fc-sun fc-col' . $cont . ' fc-widget-header" style="width: 97px;">' . $dia_s_calendario . ' - ' . $dia_calendario . '</th>' . "\n";
            }
            $dia_semana --;
            $cont ++;
        }
        
        $calendar_data_rows .= '				<th class="fc-agenda-gutter fc-widget-header fc-last" style="width: 17px;"></th>' . "\n";
        
        $calendar_data_rows .= '			</tr>' . "\n";
        $calendar_data_rows .= '		</thead>' . "\n";
        $calendar_data_rows .= '		<tbody>' . "\n";
        
        $calendar_data_rows .= '		<div style="position:relative;width:100%;overflow:hidden">' . "\n";
        
        $count = 0;
        $horas = 7;
        $dia_semana = date("w");
        
        while ($count < 23) {
            
            if ($count % 2 == 0) {
                $calendar_data_rows .= '			<tr class="fc-slot0  fc-last">' . "\n";
                $calendar_data_rows .= '				<th class="fc-agenda-axis fc-widget-header" style="width: 50px;">' . $horas . ':00</th>' . "\n";
                
                $col = 0;
                
                while ($col <= 6) {
                    if (date("w") == $col) {
                        if (date('d') == $dia) {
                            $calendar_data_rows .= '				<td class="fc-widget-content" style="background-color: #FFFACD;">' . "\n";
                            $calendar_data_rows .= '					<div id="' . $dia_do_calendario[$col] . ' ' . $horas . ':00" ondblclick="javascript: setdatetime(event); document.getElementById(\'button\').click();"  ondrop="drop(event)" ondragover="allowDrop(event)" align="center" style="position: relative;">&nbsp;
												   													' . $this->coloca_div_do($dia_do_calendario[$col], $horas . ":00", $profi) . '
												   													</div>' . "\n";
                            $calendar_data_rows .= '				</td>';
                        } else {
                            $calendar_data_rows .= '				<td class="fc-widget-content">' . "\n";
                            $calendar_data_rows .= '					<div id="' . $dia_do_calendario[$col] . ' ' . $horas . ':00" ondblclick="javascript: setdatetime(event); document.getElementById(\'button\').click();" ondrop="drop(event)" ondragover="allowDrop(event)" align="center" style="position: relative;">&nbsp;
													    												' . $this->coloca_div($dia_do_calendario[$col], $horas . ":00") . '
													    												</div>' . "\n";
                            $calendar_data_rows .= '				</td>';
                        }
                    } else {
                        $calendar_data_rows .= '				<td class="fc-widget-content">' . "\n";
                        $calendar_data_rows .= '					<div id="' . $dia_do_calendario[$col] . ' ' . $horas . ':00" ondblclick="javascript: setdatetime(event); document.getElementById(\'button\').click();" ondrop="drop(event)" ondragover="allowDrop(event)" align="center" style="position: relative;">&nbsp;
												    												' . $this->coloca_div_do($dia_do_calendario[$col], $horas . ":00", $profi) . '
												    												</div>' . "\n";
                        $calendar_data_rows .= '				</td>';
                    }
                    $dia_semana --;
                    $col ++;
                }
                
                $calendar_data_rows .= '				<th class="fc-agenda-axis fc-widget-header" style="width: 17px;"></th>' . "\n";
                $calendar_data_rows .= '			</tr>' . "\n";
                
                $count ++;
            } else {
                $calendar_data_rows .= '			<tr class="fc-slot0  fc-last">' . "\n";
                $calendar_data_rows .= '				<th class="fc-agenda-axis fc-widget-header" style="width: 50px;">' . $horas . ':30</th>' . "\n";
                
                $col = 0;
                
                while ($col <= 6) {
                    
                    if (date("w") == $col) {
                        if (date('d') == $dia) {
                            $calendar_data_rows .= '				<td class="fc-widget-content" style="background-color: #FFFACD;">' . "\n";
                            $calendar_data_rows .= '					<div id="' . $dia_do_calendario[$col] . ' ' . $horas . ':30" ondblclick="javascript: setdatetime(event); document.getElementById(\'button\').click();" ondrop="drop(event)" ondragover="allowDrop(event)" align="center" style="position: relative;">&nbsp;
												    												' . $this->coloca_div_do($dia_do_calendario[$col], $horas . ":30", $profi) . '
												    												</div>' . "\n";
                            $calendar_data_rows .= '				</td>';
                        } else {
                            $calendar_data_rows .= '				<td class="fc-widget-content">' . "\n";
                            $calendar_data_rows .= '					<div id="' . $dia_do_calendario[$col] . ' ' . $horas . ':00" ondblclick="javascript: setdatetime(event); document.getElementById(\'button\').click();" ondrop="drop(event)" ondragover="allowDrop(event)" align="center" style="position: relative;">&nbsp;
													    												' . $this->coloca_div($dia_do_calendario[$col], $horas . ":00") . '
													    												</div>' . "\n";
                            $calendar_data_rows .= '				</td>';
                        }
                    } else {
                        $calendar_data_rows .= '				<td class="fc-widget-content">' . "\n";
                        $calendar_data_rows .= '					<div id="' . $dia_do_calendario[$col] . ' ' . $horas . ':30" ondblclick="javascript: setdatetime(event); document.getElementById(\'button\').click();" ondrop="drop(event)" ondragover="allowDrop(event)" align="center" style="position: relative;">&nbsp;
												    												' . $this->coloca_div_do($dia_do_calendario[$col], $horas . ":30", $profi) . '
												    												</div>' . "\n";
                        $calendar_data_rows .= '				</td>';
                    }
                    $dia_semana --;
                    $col ++;
                }
                
                $calendar_data_rows .= '				<th class="fc-agenda-axis fc-widget-header" style="width: 17px;"></th>' . "\n";
                $calendar_data_rows .= '			</tr>' . "\n";
                
                $count ++;
                $horas ++;
            }
        }
        
        $calendar_data_rows .= '		</div>' . "\n";
        
        $calendar_data_rows .= '		</tbody>' . "\n";
        $calendar_data_rows .= '		</table>' . "\n";
        
        return $calendar_data_rows;
    }

    function MostreCalendario($mes, $ano)
    {
        $numero_dias = $this->get_numero_dias($mes); // retorna o nï¿½mero de dias que tem o mï¿½s desejado
        $nome_mes = $this->get_nome_mes($mes);
        $diacorrente = 0;
        
        $diasemana = jddayofweek(cal_to_jd(CAL_GREGORIAN, $mes, "01", $ano), 0); // funï¿½ï¿½o que descobre o dia da semana
        $calendar_data_rows = '';
        
        $calendar_data_rows .= '<div id="calendar" class="fc fc-ltr">' . "\n";
        $calendar_data_rows .= '	<table class="fc-header" style="width:100%">' . "\n";
        
        $calendar_data_rows .= '		<tbody>' . "\n";
        $calendar_data_rows .= '		<tr>' . "\n";
        $calendar_data_rows .= '			<td class="text-left">' . "\n";
        $calendar_data_rows .= '				<span><h2 id="stringMesAno">' . $nome_mes . ' ' . $ano . '</h2></span>' . "\n";
        $calendar_data_rows .= '			</td>' . "\n";
        $calendar_data_rows .= '			<td class="text-center col-sm-12"></td>' . "\n";
        $calendar_data_rows .= '			<td class="text-right">' . "\n";
        
        $calendar_data_rows .= '				<span id="1" onclick="showcalendar(1);" class="fc-button fc-state-active">M&#234;s</span>' . "\n";
        $calendar_data_rows .= '				<span id="3" onclick="showcalendar(3);" class="fc-button">Semana</span>' . "\n";
        $calendar_data_rows .= '				<span id="2" onclick="showcalendar(2);" class="fc-button">Dia</span>' . "\n";
        
        $calendar_data_rows .= '				<span class="fc-header-space"></span>' . "\n";
        $calendar_data_rows .= '				<span class="fc-button fc-state-disabled">Hoje</span>' . "\n";
        $calendar_data_rows .= '				<span class="fc-header-space"></span>' . "\n";
        
        $calendar_data_rows .= '				<span class="fc-button fc-corner-left"><span class="fa fa-angle-left" onclick="javascript: gotoleft();"></span></span>' . "\n";
        $calendar_data_rows .= '				<span class="fc-button fc-corner-right"><span class="fa fa-angle-right" onclick="javascript: gotoright();"></span></span>' . "\n";
        
        $calendar_data_rows .= '				<span class="fc-header-space"></span>' . "\n";
        
        // Inicia Lista de Fonoaudiologas
        $employeer_fono = $this->Employeer->get_fono();
        
        if ($employeer_fono->num_rows() != 0) {
            $rows['1'] = 'Todos';
            foreach ($employeer_fono->result() as $fono) {
                $rows[$fono->first_name . ' ' . $fono->last_name] = $fono->first_name . ' ' . $fono->last_name;
            }
            
            $employeer_fono = $rows;
        } else {
            $employeer_fono = array(
                'N&#227;o h&#225; Fonoaudiologo '
            );
        }
        // Acabou Linha de Fonoaudiologas
        
        $calendar_data_rows .= form_dropdown('fono', $employeer_fono, array(
            ''
        ), 'id="profi" onchange="javascript: agendado(event);"');
        
        $calendar_data_rows .= '			</td>' . "\n";
        $calendar_data_rows .= '		</tr>' . "\n";
        $calendar_data_rows .= '		</tbody>' . "\n";
        $calendar_data_rows .= '	</table>' . "\n";
        
        $calendar_data_rows .= '	<div class="fc-content" style="position: relative;">' . "\n";
        $calendar_data_rows .= '	<div class="fc-view fc-view-month fc-grid" style="position: relative; -moz-user-select: none;">' . "\n";
        $calendar_data_rows .= '		<table class="fc-border-separate" cellspacing="0" style="width:100%">' . "\n";
        $calendar_data_rows .= '		<thead>' . "\n";
        $calendar_data_rows .= '			<tr class="fc-first fc-last">' . "\n";
        $calendar_data_rows .= '				<th class="fc-day-header fc-sun fc-widget-header fc-first" style="width: 107px;">Dom.</th>' . "\n";
        $calendar_data_rows .= '				<th class="fc-day-header fc-fri fc-widget-header" style="width: 107px;">Seg.</th>' . "\n";
        $calendar_data_rows .= '				<th class="fc-day-header fc-mon fc-widget-header" style="width: 107px;">Ter.</th>' . "\n";
        $calendar_data_rows .= '				<th class="fc-day-header fc-tue fc-widget-header" style="width: 107px;">Qua.</th>' . "\n";
        $calendar_data_rows .= '				<th class="fc-day-header fc-wed fc-widget-header" style="width: 107px;">Qui.</th>' . "\n";
        $calendar_data_rows .= '				<th class="fc-day-header fc-thu fc-widget-header" style="width: 107px;">Sex.</th>' . "\n";
        $calendar_data_rows .= '				<th class="fc-day-header fc-sat fc-widget-header fc-last" style="width: 107px;">S&#225;b.</th>' . "\n";
        $calendar_data_rows .= '			</tr>' . "\n";
        $calendar_data_rows .= '		</thead>' . "\n";
        $calendar_data_rows .= '		<tbody>' . "\n";
        
        for ($linha = 0; $linha < 6; $linha ++) {
            
            $calendar_data_rows .= '			<tr class="fc-week fc-last">' . "\n";
            
            for ($coluna = 0; $coluna < 7; $coluna ++) {
                
                $calendar_data_rows .= '			<td class="fc-day fc-sat fc-widget-content	';
                
                if (($diacorrente == (date('d') - 1) && date('m') == $mes)) {
                    $calendar_data_rows .= 'fc-past fc-last" style="background-color: #FFFACD;">' . "\n";
                    $calendar_data_rows .= '				<div style="position: relative; height:90px;">' . "\n";
                } else {
                    if (($diacorrente + 1) <= $numero_dias) {
                        if ($coluna < $diasemana && $linha == 0) {
                            $calendar_data_rows .= 'fc-other-month fc-past fc-last">' . "\n";
                            $calendar_data_rows .= '				<div style="heposition: relative; height:90px;">' . "\n";
                        } else {
                            $calendar_data_rows .= 'fc-past fc-last">' . "\n";
                            $calendar_data_rows .= '				<div style="position: relative; height:90px;">' . "\n";
                        }
                    } else {
                        $calendar_data_rows .= ' ';
                    }
                }
                
                /* TRECHO IMPORTANTE: A PARTIR DESTE TRECHO ï¿½ MOSTRADO UM DIA DO CALENDï¿½RIO (MUITA ATENï¿½ï¿½O NA HORA DA MANUTENï¿½ï¿½O) */
                
                if ($diacorrente + 1 <= $numero_dias) {
                    if ($coluna < $diasemana && $linha == 0) {
                        $calendar_data_rows .= ' ';
                    } else {
                        // echo "<input type = 'button' id = 'dia_comum' name = 'dia".($diacorrente+1)."' value = '".++$diacorrente."' onclick = "acao(this.value)">";
                        $calendar_data_rows .= '					<div class="fc-day-number">' . ++ $diacorrente . '</div>' . "\n";
                        $calendar_data_rows .= '						<div class="fc-day-content" align="center">' . "\n";
                        $calendar_data_rows .= '							<div id="' . $ano . '-' . $mes . '-' . $diacorrente . ' " ondblclick="javascript: setdatetime(event); document.getElementById(\'button\').click();" ondrop="drop(event)" ondragover="allowDrop(event)" style="position: relative;  height:90px;">&nbsp;
										    															' . $this->coloca_div($ano . '-' . $mes . '-' . $diacorrente, "0", 1) . '
										    															</div>' . "\n";
                        $calendar_data_rows .= '						</div>' . "\n";
                        // echo "<a href = ".$_SERVER["PHP_SELF"]."?mes=$mes&dia=".($diacorrente+1).">".++$diacorrente . "</a>";
                    }
                } else {
                    break;
                }
                
                /* FIM DO TRECHO MUITO IMPORTANTE */
                $calendar_data_rows .= '				</div>' . "\n";
                $calendar_data_rows .= '			</td>' . "\n";
            }
            
            $calendar_data_rows .= '			</tr>' . "\n";
        }
        
        $calendar_data_rows .= '		</tbody>' . "\n";
        $calendar_data_rows .= '		</table>' . "\n";
        
        $calendar_data_rows .= '	</div>' . "\n";
        $calendar_data_rows .= '	</div>' . "\n";
        $calendar_data_rows .= '</div>' . "\n";
        
        return $calendar_data_rows;
    }

    function MostreCalendarioDo($mes, $ano, $profi)
    {
        $numero_dias = $this->get_numero_dias($mes); // retorna o nï¿½mero de dias que tem o mï¿½s desejado
        $nome_mes = $this->get_nome_mes($mes);
        $diacorrente = 0;
        
        $diasemana = jddayofweek(cal_to_jd(CAL_GREGORIAN, $mes, "01", $ano), 0); // funï¿½ï¿½o que descobre o dia da semana
        $calendar_data_rows = '';
        
        $calendar_data_rows .= '<div id="calendar" class="fc fc-ltr">' . "\n";
        $calendar_data_rows .= '	<table class="fc-header" style="width:100%">' . "\n";
        
        $calendar_data_rows .= '		<tbody>' . "\n";
        $calendar_data_rows .= '		<tr>' . "\n";
        $calendar_data_rows .= '			<td class="text-left">' . "\n";
        $calendar_data_rows .= '				<span><h2 id="stringMesAno">' . $nome_mes . ' ' . $ano . '</h2></span>' . "\n";
        $calendar_data_rows .= '			</td>' . "\n";
        $calendar_data_rows .= '			<td class="text-center col-sm-12"></td>' . "\n";
        $calendar_data_rows .= '			<td class="text-right">' . "\n";
        
        $calendar_data_rows .= '				<span id="1" onclick="showcalendar(1);" class="fc-button fc-state-active">M&#234;s</span>' . "\n";
        $calendar_data_rows .= '				<span id="3" onclick="showcalendar(3);" class="fc-button">Semana</span>' . "\n";
        $calendar_data_rows .= '				<span id="2" onclick="showcalendar(2);" class="fc-button">Dia</span>' . "\n";
        
        $calendar_data_rows .= '				<span class="fc-header-space"></span>' . "\n";
        $calendar_data_rows .= '				<span class="fc-button fc-state-disabled">Hoje</span>' . "\n";
        $calendar_data_rows .= '				<span class="fc-header-space"></span>' . "\n";
        
        $calendar_data_rows .= '				<span id="" class="fc-button fc-corner-left"><span class="fa fa-angle-left" onclick="javascript: gotoleft();"></span></span>' . "\n";
        $calendar_data_rows .= '				<span id="" class="fc-button fc-corner-right"><span class="fa fa-angle-right" onclick="javascript: gotoright();"></span></span>' . "\n";
        
        $calendar_data_rows .= '				<span class="fc-header-space"></span>' . "\n";
        
        // Inicia Lista de Fonoaudiologas
        $employeer_fono = $this->Employeer->get_fono();
        
        if ($employeer_fono->num_rows() != 0) {
            $rows['1'] = 'Todos';
            foreach ($employeer_fono->result() as $fono) {
                $rows[$fono->first_name . ' ' . $fono->last_name] = $fono->first_name . ' ' . $fono->last_name;
            }
            
            $employeer_fono = $rows;
        } else {
            $employeer_fono = array(
                'N&#227;o h&#225; Fonoaudiologo'
            );
        }
        // Acabou Linha de Fonoaudiologas
        
        $calendar_data_rows .= form_dropdown('fono', $employeer_fono, array(
            $profi
        ), 'id="profi" onchange="javascript: agendado(event);"');
        
        $calendar_data_rows .= '			</td>' . "\n";
        $calendar_data_rows .= '		</tr>' . "\n";
        $calendar_data_rows .= '		</tbody>' . "\n";
        $calendar_data_rows .= '	</table>' . "\n";
        
        $calendar_data_rows .= '	<div class="fc-content" style="position: relative;">' . "\n";
        $calendar_data_rows .= '	<div class="fc-view fc-view-month fc-grid" style="position: relative; -moz-user-select: none;">' . "\n";
        $calendar_data_rows .= '		<table class="fc-border-separate" cellspacing="0" style="width:100%">' . "\n";
        $calendar_data_rows .= '		<thead>' . "\n";
        $calendar_data_rows .= '			<tr class="fc-first fc-last">' . "\n";
        $calendar_data_rows .= '				<th class="fc-day-header fc-sun fc-widget-header fc-first" style="width: 107px;">Dom.</th>' . "\n";
        $calendar_data_rows .= '				<th class="fc-day-header fc-fri fc-widget-header" style="width: 107px;">Seg.</th>' . "\n";
        $calendar_data_rows .= '				<th class="fc-day-header fc-mon fc-widget-header" style="width: 107px;">Ter.</th>' . "\n";
        $calendar_data_rows .= '				<th class="fc-day-header fc-tue fc-widget-header" style="width: 107px;">Qua.</th>' . "\n";
        $calendar_data_rows .= '				<th class="fc-day-header fc-wed fc-widget-header" style="width: 107px;">Qui.</th>' . "\n";
        $calendar_data_rows .= '				<th class="fc-day-header fc-thu fc-widget-header" style="width: 107px;">Sex.</th>' . "\n";
        $calendar_data_rows .= '				<th class="fc-day-header fc-sat fc-widget-header fc-last" style="width: 107px;">S&#225;b.</th>' . "\n";
        $calendar_data_rows .= '			</tr>' . "\n";
        $calendar_data_rows .= '		</thead>' . "\n";
        $calendar_data_rows .= '		<tbody>' . "\n";
        
        for ($linha = 0; $linha < 6; $linha ++) {
            
            $calendar_data_rows .= '			<tr class="fc-week fc-last">' . "\n";
            
            for ($coluna = 0; $coluna < 7; $coluna ++) {
                
                $calendar_data_rows .= '			<td class="fc-day fc-sat fc-widget-content	';
                
                if (($diacorrente == (date('d') - 1) && date('m') == $mes)) {
                    $calendar_data_rows .= 'fc-past fc-last" style="background-color: #FFFACD;">' . "\n";
                    $calendar_data_rows .= '				<div style="position: relative; height:90px;">' . "\n";
                } else {
                    if (($diacorrente + 1) <= $numero_dias) {
                        if ($coluna < $diasemana && $linha == 0) {
                            $calendar_data_rows .= 'fc-other-month fc-past fc-last">' . "\n";
                            $calendar_data_rows .= '				<div style="heposition: relative; height:90px;">' . "\n";
                        } else {
                            $calendar_data_rows .= 'fc-past fc-last">' . "\n";
                            $calendar_data_rows .= '				<div style="position: relative; height:90px;">' . "\n";
                        }
                    } else {
                        $calendar_data_rows .= ' ';
                    }
                }
                
                /* TRECHO IMPORTANTE: A PARTIR DESTE TRECHO ï¿½ MOSTRADO UM DIA DO CALENDï¿½RIO (MUITA ATENï¿½ï¿½O NA HORA DA MANUTENï¿½ï¿½O) */
                
                if ($diacorrente + 1 <= $numero_dias) {
                    if ($coluna < $diasemana && $linha == 0) {
                        $calendar_data_rows .= ' ';
                    } else {
                        // echo "<input type = 'button' id = 'dia_comum' name = 'dia".($diacorrente+1)."' value = '".++$diacorrente."' onclick = "acao(this.value)">";
                        $calendar_data_rows .= '					<div class="fc-day-number">' . ++ $diacorrente . '</div>' . "\n";
                        $calendar_data_rows .= '						<div class="fc-day-content" align="center">' . "\n";
                        $calendar_data_rows .= '							<div id="' . $ano . '-' . $mes . '-' . $diacorrente . ' " ondblclick="javascript: setdatetime(event); document.getElementById(\'button\').click();" ondrop="drop(event)" ondragover="allowDrop(event)" style="position: relative;  height:90px;">&nbsp;
										    															' . $this->coloca_div_do($ano . '-' . $mes . '-' . $diacorrente, "0", $profi, 1) . '
										    															</div>' . "\n";
                        $calendar_data_rows .= '						</div>' . "\n";
                        
                        // echo "<a href = ".$_SERVER["PHP_SELF"]."?mes=$mes&dia=".($diacorrente+1).">".++$diacorrente . "</a>";
                    }
                } else {
                    break;
                }
                
                /* FIM DO TRECHO MUITO IMPORTANTE */
                $calendar_data_rows .= '				</div>' . "\n";
                $calendar_data_rows .= '			</td>' . "\n";
            }
            
            $calendar_data_rows .= '			</tr>' . "\n";
        }
        
        $calendar_data_rows .= '		</tbody>' . "\n";
        $calendar_data_rows .= '		</table>' . "\n";
        
        $calendar_data_rows .= '	</div>' . "\n";
        $calendar_data_rows .= '	</div>' . "\n";
        $calendar_data_rows .= '</div>' . "\n";
        
        return $calendar_data_rows;
    }
    
    /* *********************************************************************************************************************************** */
    function coloca_div($data, $hora, $op = null)
    {
        if ($op == 1) {
            $numDiv = $this->Appointment->count_all_date_hour_m($data);
            $infoDiv = $this->Appointment->get_info_date_hour_m($data, $hora);
            $info = $infoDiv->result();
        } else {
            $numDiv = $this->Appointment->count_all_date_hour($data, $hora);
            $infoDiv = $this->Appointment->get_info_date_hour($data, $hora);
            $info = $infoDiv->result();
        }
        
        $newDiv = '';
        
        if ($numDiv > 2) {
            
            $modal = $this->session->userdata('calendar');
            
            switch ($modal) {
                case 1:
                    $newDiv .= '<button class="btn btn-success btn-xs btn-flat" onclick="showcalendar(3);" type="button">Ha outros ' . $numDiv . '</button>';
                    break;
                
                case 2:
                    for ($i = 0; $i < $numDiv; $i ++) {
                        $newDiv .= '<div id="' . $data . ' ' . $hora . ' ' . $info[$i]->appointment_id . ' ' . $i . '" class="external-event ui-draggable" 
									onclick="show(\'' . $info[$i]->doctor_id . '\',\'' . $info[$i]->patient_name . '\',\'' . $info[$i]->appointment . '\',\'' . $info[$i]->hour . '\',\'' . site_url('appointments/view/' . $info[$i]->appointment_id) . '\');"						
								 	ondragstart="drag(event)" draggable="true" style="position: relative; margin: 4px 4px 4px 4px;">' . $info[$i]->patient_name . '</div> ';
                    }
                    break;
                
                case 3:
                    $newDiv .= '<button class="btn btn-success btn-xs btn-flat" onclick="showcalendar(2);" type="button">Ha outros ' . $numDiv . '</button>';
                    break;
                
                default:
                    for ($i = 0; $i < $numDiv; $i ++) {
                        $newDiv .= '<div id="' . $data . ' ' . $hora . ' ' . $info[$i]->appointment_id . ' ' . $i . '" class="external-event ui-draggable"
									onclick="show(\'' . $info[$i]->doctor_id . '\',\'' . $info[$i]->patient_name . '\',\'' . $info[$i]->appointment . '\',\'' . $info[$i]->hour . '\',\'' . site_url('appointments/view/' . $info[$i]->appointment_id) . '\');"
								 	ondragstart="drag(event)" draggable="true" style="position: relative; margin: 4px 4px 4px 4px;">' . $info[$i]->patient_name . '</div>';
                    }
                    break;
            }
        } else {
            for ($i = 0; $i < $numDiv; $i ++) {
                if ($info[$i]->point_type == 1) {
                    $newDiv .= '<div id="' . $data . ' ' . $hora . ' ' . $info[$i]->appointment_id . ' ' . $i . '" class="external-event ui-draggable"
									onclick="show(\'' . $info[$i]->doctor_id . '\',\'' . $info[$i]->patient_name . '\',\'' . $info[$i]->appointment . '\',\'' . $info[$i]->hour . '\',\'' . site_url('appointments/view/' . $info[$i]->appointment_id) . '\');"
								 	ondragstart="drag(event)" draggable="true" style="position: relative; margin: 4px 4px 4px 4px; background: none repeat scroll 0% 0% #259F18;">' . $info[$i]->patient_name . '</div>';
                } else {
                    $newDiv .= '<div id="' . $data . ' ' . $hora . ' ' . $info[$i]->appointment_id . ' ' . $i . '" class="external-event ui-draggable"
									onclick="show(\'' . $info[$i]->doctor_id . '\',\'' . $info[$i]->patient_name . '\',\'' . $info[$i]->appointment . '\',\'' . $info[$i]->hour . '\',\'' . site_url('appointments/view/' . $info[$i]->appointment_id) . '\');"
								 	ondragstart="drag(event)" draggable="true" style="position: relative; margin: 4px 4px 4px 4px;">' . $info[$i]->patient_name . '</div>';
                }
            }
        }
        
        return $newDiv;
    }

    function coloca_div_do($data, $hora, $fono, $op = null)
    {
        if (isset($op)) {
            $numDiv = $this->Appointment->count_all_date_hour_fono_m($data, $hora, $fono);
            $infoDiv = $this->Appointment->get_info_date_hour_fono($data, $hora, $fono);
            $info = $infoDiv->result();
        } else {
            $numDiv = $this->Appointment->count_all_date_hour_fono($data, $hora, $fono);
            $infoDiv = $this->Appointment->get_info_date_hour_fono($data, $hora, $fono);
            $info = $infoDiv->result();
        }
        
        $newDiv = '';
        
        if ($numDiv > 2) {
            
            $modal = $this->session->userdata('calendar');
            
            switch ($modal) {
                case 1:
                    $newDiv .= '<button class="btn btn-success btn-xs btn-flat" onclick="showcalendar(3);" type="button">Ha outros ' . $numDiv . '</button>';
                    break;
                
                case 2:
                    for ($i = 0; $i < $numDiv; $i ++) {
                        $newDiv .= '<div id="' . $data . ' ' . $hora . ' ' . $info[$i]->appointment_id . ' ' . $i . '" class="external-event ui-draggable" 
									onclick="show(\'' . $info[$i]->doctor_id . '\',\'' . $info[$i]->patient_name . '\',\'' . $info[$i]->appointment . '\',\'' . $info[$i]->hour . '\',\'' . site_url('appointments/view/' . $info[$i]->appointment_id) . '\');"						
								 	ondragstart="drag(event)" draggable="true" style="position: relative; margin: 2px 2px 2px 0px;">' . $info[$i]->patient_name . '</div> ';
                    }
                    break;
                
                case 3:
                    $newDiv .= '<button class="btn btn-success btn-xs btn-flat" onclick="showcalendar(2);" type="button">Ha outros ' . $numDiv . '</button>';
                    break;
                
                default:
                    for ($i = 0; $i < $numDiv; $i ++) {
                        $newDiv .= '<div id="' . $data . ' ' . $hora . ' ' . $info[$i]->appointment_id . ' ' . $i . '" class="external-event ui-draggable" 
									onclick="show(\'' . $info[$i]->doctor_id . '\',\'' . $info[$i]->patient_name . '\',\'' . $info[$i]->appointment . '\',\'' . $info[$i]->hour . '\',\'' . site_url('appointments/view/' . $info[$i]->appointment_id) . '\');"						
								 	ondragstart="drag(event)" draggable="true" style="position: relative; margin: 2px 2px 2px 0px;">' . $info[$i]->patient_name . '</div>';
                    }
                    break;
            }
        } else {
            for ($i = 0; $i < $numDiv; $i ++) {
                if ($info[$i]->point_type == 1) {
                    $newDiv .= '<div id="' . $data . ' ' . $hora . ' ' . $info[$i]->appointment_id . ' ' . $i . '" class="external-event ui-draggable"
									onclick="show(\'' . $info[$i]->doctor_id . '\',\'' . $info[$i]->patient_name . '\',\'' . $info[$i]->appointment . '\',\'' . $info[$i]->hour . '\',\'' . site_url('appointments/view/' . $info[$i]->appointment_id) . '\');"
								 	ondragstart="drag(event)" draggable="true" style="position: relative; margin: 4px 4px 4px 4px; background: none repeat scroll 0% 0% #259F18;">' . $info[$i]->patient_name . '</div>';
                } else {
                    $newDiv .= '<div id="' . $data . ' ' . $hora . ' ' . $info[$i]->appointment_id . ' ' . $i . '" class="external-event ui-draggable"
									onclick="show(\'' . $info[$i]->doctor_id . '\',\'' . $info[$i]->patient_name . '\',\'' . $info[$i]->appointment . '\',\'' . $info[$i]->hour . '\',\'' . site_url('appointments/view/' . $info[$i]->appointment_id) . '\');"
								 	ondragstart="drag(event)" draggable="true" style="position: relative; margin: 4px 4px 4px 4px;">' . $info[$i]->patient_name . '</div>';
                }
            }
        }
        
        return $newDiv;
    }

    function get_appointment()
    {
        $datetime = $this->input->post('datatime');
        $arr = explode(' ', $datetime);
        
        $this->session->set_userdata('appointment_id', $arr[2]);
    }

    function alter_appointment()
    {
        $datetime = $this->input->post('datatime');
        $appointment_id = $this->session->userdata('appointment_id');
        
        $arr = explode(' ', $datetime);
        $appointment = $this->Appointment->get_info($appointment_id);
        
        if ($arr[1] == 0)
            $arr[1] = $appointment->hour;
        
        $appointment_data = array(
            'appointment' => $arr[0],
            'hour' => $arr[1]
        );
        
        if ($this->Appointment->countDoctor($arr[0], $arr[1], $appointment->doctor_id) == 0) {
            if ($this->Appointment->save($appointment_data, $appointment_id)) {
                echo 'showcalendar(' . $this->session->userdata("calendar") . ')';
            } else {
                echo 'alert("opss! Ocorreu um erro ao inserir o agendamento.");';
            }
        } else {
            echo 'alert("Opss! O fonoaudiologo possui ' . $this->Appointment->countDoctor($arr[0], $arr[1], $appointment->doctor_id) . ' compromisso");
				  showcalendar(' . $this->session->userdata("calendar") . ');';
        }
    }

    function gotoleft()
    {
        date_default_timezone_set('America/Sao_Paulo');
        $stringModal = $this->input->post('modal');
        $nomeProfi = $this->input->post('profi');
        
        if ($stringModal == 1) {
            $stringMesAno = $this->input->post('stringMesAno');
            $arr = explode(' ', $stringMesAno);
            
            $AnoAtual = $arr[1];
            $MesAtual = $arr[0];
            
            $ano = $AnoAtual;
            
            switch ($MesAtual) {
                case 'Janeiro':
                    $ano = $AnoAtual - 1;
                    $mes = '12';
                    break;
                case 'Fevereiro':
                    $mes = '01';
                    break;
                case 'MarÃ§o':
                    $mes = '02';
                    break;
                case 'Abril':
                    $mes = '03';
                    break;
                case 'Maio':
                    $mes = '04';
                    break;
                case 'Junho':
                    $mes = '05';
                    break;
                case 'Julho':
                    $mes = '06';
                    break;
                case 'Agosto':
                    $mes = '07';
                    break;
                case 'Setembro':
                    $mes = '08';
                    break;
                case 'Outubro':
                    $mes = '09';
                    break;
                case 'Novembro':
                    $mes = '10';
                    break;
                case 'Dezembro':
                    $mes = '11';
                    break;
            }
            
            if ($nomeProfi == 1) {
                echo $this->MostreCalendario($mes, $ano);
            } else {
                echo $this->MostreCalendarioDo($mes, $ano, $nomeProfi);
            }
        } elseif ($stringModal == 2) {
            $stringMesDia = $this->input->post('stringMesAno');
            
            $arr = explode(' ', $stringMesDia);
            
            $DiaAtual = $arr[0];
            $MesAtual = $arr[1];
            $AnoAtual = $arr[2];
            
            switch ($MesAtual) {
                case 'Janeiro':
                    $mes = '01';
                    break;
                case 'Fevereiro':
                    $mes = '02';
                    break;
                case 'MarÃ§o':
                    $mes = '03';
                    break;
                case 'Abril':
                    $mes = '04';
                    break;
                case 'Maio':
                    $mes = '05';
                    break;
                case 'Junho':
                    $mes = '06';
                    break;
                case 'Julho':
                    $mes = '07';
                    break;
                case 'Agosto':
                    $mes = '08';
                    break;
                case 'Setembro':
                    $mes = '09';
                    break;
                case 'Outubro':
                    $mes = '10';
                    break;
                case 'Novembro':
                    $mes = '11';
                    break;
                case 'Dezembro':
                    $mes = '12';
                    break;
            }
            
            $DiaDesejado = $DiaAtual - 1;
            
            if ($DiaDesejado == 0) {
                switch ($MesAtual) {
                    case 'Janeiro':
                        $ano = $AnoAtual - 1;
                        $mes = '12';
                        break;
                    case 'Fevereiro':
                        $mes = '01';
                        break;
                    case 'MarÃ§o':
                        $mes = '02';
                        break;
                    case 'Abril':
                        $mes = '03';
                        break;
                    case 'Maio':
                        $mes = '04';
                        break;
                    case 'Junho':
                        $mes = '05';
                        break;
                    case 'Julho':
                        $mes = '06';
                        break;
                    case 'Agosto':
                        $mes = '07';
                        break;
                    case 'Setembro':
                        $mes = '08';
                        break;
                    case 'Outubro':
                        $mes = '09';
                        break;
                    case 'Novembro':
                        $mes = '10';
                        break;
                    case 'Dezembro':
                        $mes = '11';
                        break;
                }
                
                $DiaDesejado = $this->get_numero_dias($mes);
            }
            
            if ($nomeProfi == 1) {
                echo $this->MostreDia($DiaDesejado, $mes, $AnoAtual);
            } else {
                echo $this->MostreDiaDo($DiaDesejado, $mes, $AnoAtual, $nomeProfi);
            }
        } elseif ($stringModal == 3) {
            $stringDiaMesAno = $this->input->post('stringMesAno');
            
            $arr = explode(' ', $stringDiaMesAno);
            
            $MesAtual = $arr[0];
            $AnoAtual = $arr[1];
            
            $CI = & get_instance();
            
            if (! $CI->session->userdata('diaatual')) {
                $CI->session->set_userdata('diaatual', date('d'));
            }
            
            $DiaAtual = $CI->session->userdata('diaatual');
            $dia = $DiaAtual - 7;
            $ano = $AnoAtual;
            
            $CI->session->set_userdata('diaatual', $dia);
            
            switch ($MesAtual) {
                case 'Janeiro':
                    $mes = '01';
                    break;
                case 'Fevereiro':
                    $mes = '02';
                    break;
                case 'MarÃ§o':
                    $mes = '03';
                    break;
                case 'Abril':
                    $mes = '04';
                    break;
                case 'Maio':
                    $mes = '05';
                    break;
                case 'Junho':
                    $mes = '06';
                    break;
                case 'Julho':
                    $mes = '07';
                    break;
                case 'Agosto':
                    $mes = '08';
                    break;
                case 'Setembro':
                    $mes = '09';
                    break;
                case 'Outubro':
                    $mes = '10';
                    break;
                case 'Novembro':
                    $mes = '11';
                    break;
                case 'Dezembro':
                    $mes = '12';
                    break;
            }
            
            if ($nomeProfi == 1) {
                echo $this->MostreSemanas($dia, $mes, $ano);
            } else {
                echo $this->MostreSemanasDo($dia, $mes, $ano, $nomeProfi);
            }
        }
    }

    function gotoright()
    {
        date_default_timezone_set('America/Sao_Paulo');
        $stringMesAno = $this->input->post('stringMesAno');
        $stringModal = $this->input->post('modal');
        $nomeProfi = $this->input->post('profi');
        
        if ($stringModal == 1) {
            $arr = explode(' ', $stringMesAno);
            
            $AnoAtual = $arr[1];
            $MesAtual = $arr[0];
            
            $ano = $AnoAtual;
            
            switch ($MesAtual) {
                case 'Janeiro':
                    $mes = '02';
                    break;
                case 'Fevereiro':
                    $mes = '03';
                    break;
                case 'Março':
                    $mes = '04';
                    break;
                case 'Abril':
                    $mes = '05';
                    break;
                case 'Maio':
                    $mes = '06';
                    break;
                case 'Junho':
                    $mes = '07';
                    break;
                case 'Julho':
                    $mes = '08';
                    break;
                case 'Agosto':
                    $mes = '09';
                    break;
                case 'Setembro':
                    $mes = '10';
                    break;
                case 'Outubro':
                    $mes = '11';
                    break;
                case 'Novembro':
                    $mes = '12';
                    break;
                case 'Dezembro':
                    $ano = $AnoAtual + 1;
                    $mes = '01';
                    break;
            }
            
            if ($nomeProfi == 1) {
                echo $this->MostreCalendario($mes, $ano);
            } else {
                echo $this->MostreCalendarioDo($mes, $ano, $nomeProfi);
            }
        } elseif ($stringModal == 2) {
            $stringMesDia = $this->input->post('stringMesAno');
            
            $arr = explode(' ', $stringMesDia);
            
            $DiaAtual = $arr[0];
            $MesAtual = $arr[1];
            $AnoAtual = $arr[2];
            
            switch ($MesAtual) {
                case 'Janeiro':
                    $mes = '01';
                    break;
                case 'Fevereiro':
                    $mes = '02';
                    break;
                case 'MarÃ§o':
                    $mes = '03';
                    break;
                case 'Abril':
                    $mes = '04';
                    break;
                case 'Maio':
                    $mes = '05';
                    break;
                case 'Junho':
                    $mes = '06';
                    break;
                case 'Julho':
                    $mes = '07';
                    break;
                case 'Agosto':
                    $mes = '08';
                    break;
                case 'Setembro':
                    $mes = '09';
                    break;
                case 'Outubro':
                    $mes = '10';
                    break;
                case 'Novembro':
                    $mes = '11';
                    break;
                case 'Dezembro':
                    $mes = '12';
                    break;
            }
            
            $DiaDesejado = $DiaAtual + 1;
            
            if ($DiaDesejado == $this->get_numero_dias($mes)) {
                switch ($MesAtual) {
                    case 'Janeiro':
                        $mes = '02';
                        break;
                    case 'Fevereiro':
                        $mes = '03';
                        break;
                    case 'MarÃ§o':
                        $mes = '04';
                        break;
                    case 'Abril':
                        $mes = '05';
                        break;
                    case 'Maio':
                        $mes = '06';
                        break;
                    case 'Junho':
                        $mes = '07';
                        break;
                    case 'Julho':
                        $mes = '08';
                        break;
                    case 'Agosto':
                        $mes = '09';
                        break;
                    case 'Setembro':
                        $mes = '10';
                        break;
                    case 'Outubro':
                        $mes = '11';
                        break;
                    case 'Novembro':
                        $mes = '12';
                        break;
                    case 'Dezembro':
                        $mes = '01';
                        break;
                }
                
                $DiaDesejado = 1;
            }
            
            if ($nomeProfi == 1) {
                if ($DiaDesejado == '01' && $mes == '01') {
                    $ano = $AnoAtual + 1;
                } else {
                    $ano = $AnoAtual;
                }
                echo $this->MostreDia($DiaDesejado, $mes, $ano);
            } else {
                if ($DiaDesejado == '01' && $mes == '01') {
                    $ano = $AnoAtual + 1;
                } else {
                    $ano = $AnoAtual;
                }
                echo $this->MostreDiaDo($DiaDesejado, $mes, $ano, $nomeProfi);
            }
        } elseif ($stringModal == 3) {
            $stringDiaMesAno = $this->input->post('stringMesAno');
            
            $arr = explode(' ', $stringDiaMesAno);
            
            $CI = & get_instance();
            
            $MesAtual = $arr[0];
            $AnoAtual = $arr[1];
            
            if (! $CI->session->userdata('diaatual')) {
                $CI->session->set_userdata('diaatual', date('d'));
            }
            
            $DiaAtual = $CI->session->userdata('diaatual');
            
            $dia = $DiaAtual + 7;
            $ano = $AnoAtual;
            
            $CI->session->set_userdata('diaatual', $dia);
            
            switch ($MesAtual) {
                case 'Janeiro':
                    $mes = '01';
                    break;
                case 'Fevereiro':
                    $mes = '02';
                    break;
                case 'MarÃ§o':
                    $mes = '03';
                    break;
                case 'Abril':
                    $mes = '04';
                    break;
                case 'Maio':
                    $mes = '05';
                    break;
                case 'Junho':
                    $mes = '06';
                    break;
                case 'Julho':
                    $mes = '07';
                    break;
                case 'Agosto':
                    $mes = '08';
                    break;
                case 'Setembro':
                    $mes = '09';
                    break;
                case 'Outubro':
                    $mes = '10';
                    break;
                case 'Novembro':
                    $mes = '11';
                    break;
                case 'Dezembro':
                    $mes = '12';
                    break;
            }
            
            if ($nomeProfi == 1) {
                
                echo $this->MostreSemanas($dia, $mes, $ano);
            } else {
                echo $this->MostreSemanasDo($dia, $mes, $ano, $nomeProfi);
            }
        }
    }
}
?>