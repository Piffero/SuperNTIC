<?php
require_once ("secure_area.php");

class Appointments extends Secure_area
{

    function __construct()
    {
        parent::__construct('appointments');
    }

    function index($manager_result = null)
    {
        if ($this->check_action_permission('search')) {
            $data['manager_result'] = $manager_result;
            $data['controller_name'] = 'appointments';
            $data['num_row'] = 'CONSULTAS REGISTRADAS <strong><font color="green">' . $this->Appointment->count_all() . '</font></strong>';
            $data['manage_table'] = get_appointment_manage_table($this->Appointment->get_all(), $this);
            $this->load->view('appointments/appointments', $data);
        }
    }

    function append($appointments_id = -1, $manage_result = null)
    {
        if ($this->check_action_permission('add_update')) {
            $data['manage_result'] = $manage_result;
            $data['appointments_info'] = $this->Appointment->get_info($appointments_id);
            
            // Inicia Lista de Empregado
            $employeer_fono = $this->Employeer->get_fono();
            
            if ($employeer_fono->num_rows() != 0) {
                foreach ($employeer_fono->result() as $fono) {
                    $rows[$fono->first_name . ' ' . $fono->last_name] = $fono->first_name . ' ' . $fono->last_name;
                }
                
                $data['employeer_fono'] = $rows;
            } else {
                $data['employeer_fono'] = array(
                    'N&#227;o h&#225; Funcionarios de Fonoaudiologia '
                );
            }
            // Acabou Linha de Empregado
            
            // Inicia Lista de Cliente
            $customer = $this->Customer->get_all();
            
            if ($customer->num_rows() != 0) {
                foreach ($customer->result() as $paciente) {
                    $rows2[$paciente->patient_id] = $paciente->first_name . ' ' . $paciente->last_name;
                }
                
                $data['customer'] = $rows2;
            } else {
                $data['customer'] = array(
                    'N&#227;o h&#225; Clientes cadastrados. '
                );
            }
            // Acabou Linha de Cliente
            
            $this->load->view('appointments/append', $data);
        } else {
            $this->index('<div class="alert alert-danger">
					<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Voc&#234; n&#227;o possui permi&#231;&#227;o para esta a&#231;&#227;o!...
					</div>');
        }
    }
    
    /*
     * Retorna linhas de dados da tabela cliente. Este sera chamado com AJAX.
     */
    function search()
    {
        if ($this->check_action_permission('search')) {
            $search = $this->input->post('search');
            $data_rows = get_appointment_manage_table($this->Appointment->search($search), $this);
            
            $data['num_row'] = 'TOTAL DE REGISTROS: <strong><font color="green">' . $this->Appointment->count_all() . '</font></strong>';
            
            $data['controller_name'] = 'appointments';
            $data['manage_table'] = $data_rows;
            $this->load->view('appointments/appointments', $data);
        } else {
            $this->index('<div class="alert alert-danger">
					<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Voc&#234; n&#227;o possui permiss&#227;o para esta a&#231;&#227;o!...
					</div>');
        }
    }
    
    /*
     * Gives search suggestions based on what is being searched for
     */
    function suggest()
    {
        $suggestions = $this->Appointment->get_search_suggestions($this->input->post('q'), $this->input->post('limit'));
        echo implode("\n", $suggestions);
    }
    
    /*
     * Loads the Appointment edit form
     */
    function view($appointments_id = -1, $manage_result = null)
    {
        if ($this->check_action_permission('add_update')) {
            
            // Inicia Lista de Employeer
            $employeer_fono = $this->Employeer->get_fono();
            
            if ($employeer_fono->num_rows() != 0) {
                foreach ($employeer_fono->result() as $fono) {
                    $rows[$fono->first_name . ' ' . $fono->last_name] = $fono->first_name . ' ' . $fono->last_name;
                }
                
                $data['employeer_fono'] = $rows;
            } else {
                $data['employeer_fono'] = array(
                    'N&#227;o h&#225; Funcionarios de Fonoaudiologia '
                );
            }
            // Acabou Linha de Employeer
            
            // Inicia Lista de Clientes
            $customer = $this->Customer->get_all();
            
            if ($customer->num_rows() != 0) {
                foreach ($customer->result() as $paciente) {
                    $rows2[$paciente->patient_id] = $paciente->first_name . ' ' . $paciente->last_name;
                }
                
                $data['customer'] = $rows2;
            } else {
                $data['customer'] = array(
                    'N&#227;o h&#225; Clientes cadastrados. '
                );
            }
            // Acabou Linha de Clientes
            
            $data['btn_close'] = '<a href="' . site_url("appointments/delete") . '/' . $appointments_id . '" class="btn btn-warning"><i class="fa fa-times"></i> Fechar Consulta</a>';
            $data['manage_result'] = $manage_result;
            $data['id'] = $appointments_id;
            $data['appointments_info'] = $this->Appointment->get_info($appointments_id);
            $this->load->view('appointments/append', $data);
        } else {
            $this->index('<div class="alert alert-danger">
					<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Voc&#234; n&#227;o possui permi&#231;&#227;o para esta a&#231;&#227;o!...
					</div>');
        }
    }
    
    /*
     * Inserts/updates a Appointment
     */
    function save($appointments_id = -1)
    {
        $peganome = $this->Customer->get_info($this->input->post('paciente'));
        $nome = $peganome->first_name . ' ' . $peganome->last_name;
        
        $appointment_data = array(
            'doctor_id' => $this->input->post('fono'),
            'patient_id' => $this->input->post('paciente'),
            'patient_name' => $nome,
            'appointment' => get_date_converter($this->input->post('date')),
            'hour' => $this->input->post('hour'),
            'atendimento' => $this->input->post('atendimento')
        );
        
        if ($this->Appointment->save($appointment_data, $appointments_id)) {
            
            // New Appointment
            if ($appointments_id == - 1) {
                $this->append($appointments_id, '
						<div class="alert alert-success">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
						<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
						Registro inserido com sucesso ' . ($appointment_data['doctor_id']) . ' ' . ($appointment_data['patient_id']) . ' ' . ($appointment_data['appointment']) . '
						</div>');
            } else // previous Appointment
{
                
                $this->view($appointments_id, '
						<div class="alert alert-success">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
						<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
						Registro atualizado com sucesso ' . ($appointment_data['doctor_id']) . ' ' . ($appointment_data['patient_id']) . '
						</div>');
            }
        } else // failure
{
            $this->append($appointments_id, '
					<div class="alert alert-danger">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Ocorreu um erro ao inserir ou atualizar o resgistro ' . ($Appointment_data['doctor_id']) . ' ' . ($appointment_data['patient_id']) . '
					</div>');
        }
    }
    
    /*
     * Isso exclui os clientes da tabela de clientes
     */
    function delete($appointments_id = -1)
    {
        if ($this->check_action_permission('Delete')) {
            $appointment_to_delete = $appointments_id;
            
            if ($this->Appointment->delete_list($appointment_to_delete)) {
                
                $this->index('
					<div class="alert alert-success">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
					Consulta fechada com sucesso.
					</div>
					');
            } else {
                $this->index('
						<div class="alert alert-danger">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
						<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
						Opss.. Ocorreu um erro ao deletar o(s) registro(s)
						</div>
						');
            }
        } else {
            $this->index('<div class="alert alert-danger">
					<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Voc&#234; n&#227;o possui permi&#231;&#227;o para esta a&#231;&#227;o!...
					</div>');
        }
    }
}
?>