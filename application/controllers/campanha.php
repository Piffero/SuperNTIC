<?php
require_once ("secure_area.php");

class Campanha extends Secure_area
{

    function __construct()
    {
        parent::__construct('appointments');
    }

    
    function index($manager_result = null)
    {
        $expression = $this->Accompaniment->get_all();
        
        $data['manager_result'] = $manager_result;
        $data['table_items'] = get_accomp_manager_table($this->Accompaniment->get_all(), 'appointments');
        $data['manager_table'] = get_sales_for_accomp_manager_table($this->Sale->get_item_all(), 'appointments');
        
        $this->load->view('campanha/campanha', $data);
    }
    
    function append($order = null, $serie_item = null)
    {
        if (isset($order) && isset($serie_item)) {
        	
            // Obtem lista do fonoaudiologos registrados            
        	$data_fono = $this->Employeer->get_fono();
            foreach ($data_fono->result() as $fono_field) {
                $fono_profile[$fono_field->employees_id] = $fono_field->first_name . ' ' . $fono_field->last_name;
            }
            
            // Verifica se trata de um quadro de acompanhamento existente
            if($this->Accompaniment->exists_by_sale($order, $serie_item))
            {
                // Caso seja - Formata Button de acordo com processo atual;
                $data_accomp = $this->Accompaniment->get_info_serie($serie_item);
                $customer_user = $this->Customer->get_info($data_accomp->patient_id); // Obtem nome do Usuario                 
                
                // obtem as informações sobre a venda e captura data e hora
                $sales_info = $this->Sale->get_info($order);                
                $date_time = explode(' ', $sales_info->sale_time);
                
                // valida se a um grupo de check lista sobre a vista
                if($this->Accompaniment->exists_visit_group($data_accomp->progress) != 0)
                {
                    // Agora valida se a visita em questao determinada pela
                    // tabela e campo `ntic_accompaniment`.`progress` foi completada.                    
                    if($this->Accompaniment->exists_visit_group($data_accomp->progress) == $this->valida_checking($data_accomp->progress))
                    {                        
                        $data = $this->valida_datetime($date_time, $data_accomp->progress + 1);
                        // valida e calcula a data para a proxima vista                       
                        $data['btn_group'] = $this->set_btn_group($data_accomp->progress+1);
                        $data['customer_user'] = $customer_user->first_name.' '.$customer_user->last_name;
                        
                        // caso haja monta a instancia para retorno dos checkbox
                        $data_group_accomp = $this->Accompaniment->get_all_group($data_accomp->ID);
                        foreach ($data_group_accomp->result() as $accomp_group)
                        {
                            $data['op'.$accomp_group->accomp_op][$accomp_group->accomp_key] = $accomp_group->accomp_value;
                        }
                        
                        $data['panel_active'] = $this->set_panel_group($data_accomp->progress+1);
                        
                    }
                    else 
                    {                        
                        // caso não tenha sido completada. 
                        $data = $this->valida_datetime($date_time, $data_accomp->progress);
                        $data['btn_group'] = $this->set_btn_group($data_accomp->progress);
                        $data['customer_user'] = $customer_user->first_name.' '.$customer_user->last_name;
                        
                        // caso haja monta a instancia para retorno dos checkbox
                        $data_group_accomp = $this->Accompaniment->get_all_group($data_accomp->ID);
                        foreach ($data_group_accomp->result() as $accomp_group)
                        {
                            $data['op'.$accomp_group->accomp_op][$accomp_group->accomp_key] = $accomp_group->accomp_value;
                        } 

                        $data['panel_active'] = $this->set_panel_group($data_accomp->progress);
                    }
                }
                else 
                {
                    $data = $this->valida_datetime($date_time, $data_accomp->progress);
                    $data['$panel_active'] = $this->set_panel_group($data_accomp->progress);
                    $data['btn_group'] = $this->set_btn_group($data_accomp->progress);
                    $data['customer_user'] = $customer_user->first_name.' '.$customer_user->last_name;  
                    $data['panel_active'] = $this->set_panel_group($data_accomp->progress);
                }
                
                
            } else {
                                
                $sales_info = $this->Sale->get_info($order);
                $customer_user = $this->Customer->get_info($sales_info->patient_user_id);
                $date_time = explode(' ', $sales_info->sale_time);
                $data['panel_active'] = $this->set_panel_group(1);
                $data = $this->valida_datetime($date_time, 1);                
                $data['btn_group'] = $this->set_btn_group(-1);
                $data['customer_user'] = $customer_user->first_name.' '.$customer_user->last_name;
                
            }
            
            
            $data['sale_id'] = $order;
            $data['fono_id'] = 0;
            $data['fono_profile'] = $fono_profile;
            $data['serie_item'] = $serie_item;
            
            
            $this->load->view('campanha/program', $data);
            
        } else {
            $this->index('<div class="alert alert-danger">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Opss:</strong> Não Pode associar o programa de acompanhamento a venda. (Tente novamente).
				   </div>');
        }
    }

    /**
     * Esta função é responsavel por organizar o estilo e cores dos
     * botões de paginação contidos na /views/campanha/program.php.
     *
     * @param integer $progress            
     * @return array $btn_group
     */
    function set_btn_group($progress = null)
    {
        switch ($progress) {
            case 1:
            	for ($i = 0; $i < 8; $i++) {
            		if($i == 0){$btn_group[] = 'btn-danger';} else {$btn_group[] = 'btn-primary';}
            	}               
            break;
            
            case 2: 
                for ($i = 0; $i < 8; $i++) {
            		if($i == 0){
            			for ($b = 0; $b < 1; $b++) {$btn_group[] = 'btn-success';}
            			$btn_group[] = 'btn-danger';
            		} else {$btn_group[] = 'btn-primary';}
            	}                
            break;
            
            case 3:
                for ($i = 0; $i < 8; $i++) {
            		if($i == 0){
            			for ($b = 0; $b < 2; $b++) {$btn_group[] = 'btn-success';}
            			$btn_group[] = 'btn-danger';
            		} else {$btn_group[] = 'btn-primary';}
            	}             	
            break;
            
            case 4:
                for ($i = 0; $i < 8; $i++) {
            		if($i == 0){
            			for ($b = 0; $b < 3; $b++) {$btn_group[] = 'btn-success';}
            			$btn_group[] = 'btn-danger';
            		} else {$btn_group[] = 'btn-primary';}
            	}                
            break;
            
            
            case 5:
                for ($i = 0; $i < 8; $i++) {
            		if($i == 0){
            			for ($b = 0; $b < 4; $b++) {$btn_group[] = 'btn-success';}
            			$btn_group[] = 'btn-danger';
            		} else {$btn_group[] = 'btn-primary';}
            	}          	
            break;

            
            case 6:
                for ($i = 0; $i < 8; $i++) {
            		if($i == 0){
            			for ($b = 0; $b < 5; $b++) {$btn_group[] = 'btn-success';}
            			$btn_group[] = 'btn-danger';
            		} else {$btn_group[] = 'btn-primary';}
            	}
            break;
                
            
            case 7:
                for ($i = 0; $i < 8; $i++) {
            		if($i == 0){
            			for ($b = 0; $b < 6; $b++) {$btn_group[] = 'btn-success';}
            			$btn_group[] = 'btn-danger';
            		} else {$btn_group[] = 'btn-primary';}
            	}               
            break;
            
            
            case 8:
                for ($i = 0; $i < 8; $i++) {
            		if($i == 0){
            			for ($b = 0; $b < 7; $b++) {$btn_group[] = 'btn-success';}
            			$btn_group[] = 'btn-danger';
            		} else {$btn_group[] = 'btn-primary';}
            	}            	
            break;
            
            default:
                for ($i = 0; $i < 8; $i++) {
            		if($i == 0){
            			for ($b = 0; $b < 7; $b++) {$btn_group[] = 'btn-success';}
            			$btn_group[] = 'btn-danger';
            		} else {$btn_group[] = 'btn-primary';}
            	}              	
            break;
        }
        
        return $btn_group;
    }
    
    
    
    /**
     * Esta função é responsavel por organizar o estilo e cores dos
     * botões de paginação contidos na /views/campanha/program.php.
     *
     * @param integer $progress
     * @return array $panel_active
     */
    function set_panel_group($progress = null)
    {
        switch ($progress) {
            case 1:
                for ($i = 0; $i < 8; $i++) {
                    if($i == 0){$panel_active[] = 'active';} else {$panel_active[] = '';}
                }
                break;
    
            case 2:
                for ($i = 0; $i < 7; $i++) {
                    if($i == 0){
                        for ($b = 0; $b < 1; $b++) {$panel_active[] = '';}
                        $panel_active[] = 'active';
                    } else {$panel_active[] = '';}
                }
                break;
    
            case 3:
                for ($i = 0; $i < 6; $i++) {
            		if($i == 0){
            			for ($b = 0; $b < 2; $b++) {$panel_active[] = '';}
            			$panel_active[] = 'active';
            		} else {$panel_active[] = '';}
            	}  
    
            case 4:
                for ($i = 0; $i < 8; $i++) {
                    if($i == 0){
                        for ($b = 0; $b < 3; $b++) {$panel_active[] = '';}
                        $panel_active[] = 'active';
                    } else {$panel_active[] = '';}
                }
                break;
    
    
            case 5:
                for ($i = 0; $i < 8; $i++) {
                    if($i == 0){
                        for ($b = 0; $b < 4; $b++) {$panel_active[] = '';}
                        $panel_active[] = 'active';
                    } else {$panel_active[] = '';}
                }
                break;
    
    
            case 6:
                for ($i = 0; $i < 8; $i++) {
                    if($i == 0){
                        for ($b = 0; $b < 5; $b++) {$panel_active[] = '';}
                        $panel_active[] = 'active';
                    } else {$panel_active[] = '';}
                }
                break;
    
    
            case 7:
                for ($i = 0; $i < 8; $i++) {
                    if($i == 0){
                        for ($b = 0; $b < 6; $b++) {$panel_active[] = '';}
                        $panel_active[] = 'active';
                    } else {$panel_active[] = '';}
                }
                break;
    
    
            case 8:
                for ($i = 0; $i < 8; $i++) {
                    if($i == 0){
                        for ($b = 0; $b < 7; $b++) {$panel_active[] = '';}
                        $panel_active[] = 'active';
                    } else {$panel_active[] = '';}
                }
                break;
    
            default:
                for ($i = 0; $i < 8; $i++) {
                    if($i == 0){
                        for ($b = 0; $b < 7; $b++) {$panel_active[] = '';}
                        $panel_active[] = 'active';
                    } else {$panel_active[] = '';}
                }
                break;
        }
    
        return $panel_active;
    }
    
    
    
    
    /**
     * Responsavel por validar e calcular a data da próxima visita de acordo com o
     * processo atual passado pelo parametro $progress, retornando um array com data e hora
     * 
     * @param array $arr_datetime
     * @param integer $progress
     * @return array $datatime
     */
    function valida_datetime($arr_datetime, $progress)
    {
         
        // formata data para arendondar o agendamento para (00) ou (30) minutos
        $date = $arr_datetime[0];
        $arr_time = explode(':', $arr_datetime[1]);
        
        $timer = (int)$arr_time[1];        
        $horas = (int)$arr_time[0];
        
        if($timer > 1 && $timer < 21){ $minutos = '00';}
        if($timer > 20 && $timer < 45){$minutos = '30';}        
        if($timer > 44 && $timer < 60){$horas++; $minutos = '00';}
        
        if($horas < 10){$it = '0';}else{$it = '';}
        $datetime['next_time'] = $it.$horas.':'.$minutos;
        date_default_timezone_set('America/Sao_Paulo');
        
        switch ($progress) {
            case 1: $datetime['next_date'] = date('d/m/Y', strtotime('+15 days',strtotime($date))); break;
            case 2: $datetime['next_date'] = date('d/m/Y', strtotime('+3 months',strtotime($date))); break;
            case 3: $datetime['next_date'] = date('d/m/Y', strtotime('+6 months',strtotime($date))); break;
            case 4: $datetime['next_date'] = date('d/m/Y', strtotime('+12 months',strtotime($date))); break;
            case 5: $datetime['next_date'] = date('d/m/Y', strtotime('+18 months',strtotime($date))); break;
            case 6: $datetime['next_date'] = date('d/m/Y', strtotime('+24 months',strtotime($date))); break;
            case 7: $datetime['next_date'] = date('d/m/Y', strtotime('+30 months',strtotime($date))); break;
            case 8: $datetime['next_date'] = date('d/m/Y', strtotime('+36 months',strtotime($date))); break;
            default: $datetime['next_date'] = date('d/m/Y', strtotime('+36 months',strtotime($date))); break;
        }
        
        return $datetime;
    }
    
    
    
    function valida_checking($progress=null)
    {
        switch ($progress) {
            case 1:
                $number_checking = 5;
                break;
        
            case 2:
                $number_checking = 9;
                break;
        
            case 3:
                $number_checking = 10;
                break;
        
            case 4:
                $number_checking = 9;
                break;
        
        
            case 5:
                $number_checking = 4;
                break;
        
        
            case 6:
                $number_checking = 9;
                break;
        
        
            case 7:
                $number_checking = 4;
                break;
        
        
            case 8:
                $number_checking = 5;
                break;
        
            default:
                $number_checking = 5;
                break;
        }
        
        return $number_checking;
    }
    
    
    
    
    function save_appointment($order, $serie_item)
    {
        $sales_info =   $this->Sale->get_info($order);    
        $sales_item =   $this->Sale->get_info_item_serie($order, $serie_item);
        $patient_user =  $this->Customer->get_info($sales_info->patient_user_id);
        $fono_info = $this->Employeer->get_info($this->input->post('fono'));
        
        $appointment_data = array(
            'doctor_id' => $fono_info->first_name.' '.$fono_info->last_name,
            'patient_id' => $sales_info->patient_user_id,
            'patient_name' => $patient_user->first_name.' '.$patient_user->last_name,
            'appointment' => get_date_converter($this->input->post('next_date')),
            'hour' => $this->input->post('next_time'),
            'atendimento' => $this->input->post('atendimento'),
            'point_type' => 1
        );
        
        
        
        if($this->Appointment->save($appointment_data, -1))
        {
            if($this->Accompaniment->exists_by_sale($order, $serie_item))
            {
                
                $accomp_data = $this->Accompaniment->get_info_serie($serie_item);                
                if($this->Accompaniment->save(array('progress'=>$accomp_data->progress+1), $accomp_data->ID))
                {
                    $this->index('
                         <div class="alert alert-success">
                                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
                                <i class="fa fa-plus sign"></i>
                                <strong>Sucesso!</strong>
                                Programa de Acompanhamento foi salvo com sucesso
                         </div>
                        ');
                }
                else 
                {
                    $this->index('
                         <div class="alert alert-danger">
                                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
                                <i class="fa fa-plus sign"></i>
                                <strong>Opss!</strong>
                                Não pude salvar programa de Acompanhamento verifique se não faltou algun dados
                         </div>
                        ');
                }
                
                
               
            }
            else 
            {
                $accomp_data = array(
                    'patient_id' => $sales_info->patient_user_id,
                    'sales_id' => $order,
                    'item_id' => $sales_item->item_id,
                    'number_serie' => $serie_item,
                    'progress' => 1,
                    'appointment' => get_date_converter($this->input->post('next_date')).' '.$this->input->post('next_time')                    
                );
                
                
               if($this->Accompaniment->save($accomp_data, -1))
               {
                   $this->index('
                       <div class="alert alert-success">
                            <button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
                            <i class="fa fa-check sign"></i>
                            <strong>Sucesso!</strong> Quadro de acompanhamento salvo com sucesso.
                       </div>');
               }
               else 
               {
                   $this->index('
                       <div class="alert alert-danger">
                            <button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
                            <i class="fa fa-check sign"></i>
                            <strong>Opss!</strong> Ocorreu um erro ao inserir algum(s) dado(s) sobre o programa de acompanhamento
                       </div>');
               }
            }            
        }
        else 
        {
            $this->index('
                       <div class="alert alert-danger">
                            <button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
                            <i class="fa fa-check sign"></i>
                            <strong>Opss!</strong> O NTIC não pode efetuar o agendamento para o quadro de acompanhamento
                       </div>');
        }
        
    }
    
    
    
    function save_group($sales_id, $number_serie)
    {
        $accomp_data = $this->Accompaniment->get_info_serie($number_serie);
        
        // Obtem a Operação e monta $accomp_group_data
        $operacao = substr(key($this->input->post()), 2);
        $accomp_group_data = $this->input->post(key($this->input->post()));
        
        // Salva o check list da primeria visita
        if($this->Accompaniment->save_group($accomp_group_data, $accomp_data->ID, $operacao))
        {
            // validar caso seja a ultima visita.
            if($accomp_data->progress == 8)
            {
                // caso seja realiza um up date da tabela `accompaniment`.`progress`
                if($this->Accompaniment->save(array('progress'=>$accomp_data->progress+1), $accomp_data->ID))
                {
                    $this->index('
                         <div class="alert alert-success">
                                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
                                <i class="fa fa-plus sign"></i>
                                <strong>Sucesso!</strong>
                                Programa de Acompanhamento foi salvo e concluido com sucesso
                         </div>
                        ');
                }
                else
                {
                    $this->index('
                         <div class="alert alert-danger">
                                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
                                <i class="fa fa-plus sign"></i>
                                <strong>Opss!</strong>
                                Não pude salvar programa de Acompanhamento verifique se não faltou algun dados
                         </div>
                        ');
                }
            }
            else 
            {
                // caso não seja redirecionar para append
                $this->append($sales_id, $number_serie);
            }
        }
        else 
        {
            $this->index('
                            <div class="alert alert-danger">
                                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
                                <i class="fa fa-times sign"></i>
                                <strong>Opss..</strong> O NTIC não pode salvar a lista de item realizados 
                            </div>
                ');
        }       
    }
}