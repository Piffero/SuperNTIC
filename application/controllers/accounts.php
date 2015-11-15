<?php
require_once ("secure_area.php");

class Accounts extends Secure_area
{

    function __construct()
    {
        parent::__construct('accounts');
    }

    function index($manage_result = null)
    {
        if ($this->check_action_permission('add_update')) {
            // pega datas para consulta
            date_default_timezone_set('America/Sao_Paulo');
            $datestart = get_date_converter($this->input->post('datefilterstart'));
            $dateend = get_date_converter($this->input->post('datefilterend'));
            
            // valida se a uma data inicial e final
            // caso não tenha set a data de hoje
            if (empty($datestart))
                $datestart = date('Y-m-d', strtotime('-1 month'));
            
            if (empty($dateend))
                $dateend = date('Y-m-d', strtotime('+1 Year'));
                
                // instancia valores das datas para view
            $data['datestart'] = get_date_view($datestart);
            $data['dateend'] = get_date_view($dateend);
            
            // instancia dados referente a tabela de acordo com as datas
            // instancia mensagem para o sistema
            $data['manage_result'] = $manage_result;
            $data['controller_name'] = 'accounts';
            $data['manage_table'] = get_account_manage_table($this->Account->get_receive($datestart, $dateend), $this, 0);
            
            // calcula o valor da soma das contas a receber
            $sum_accont_rends = $this->Account->get_sum_accont_rend($datestart, $dateend);
            foreach ($sum_accont_rends->result() as $value) {
                $sum_accont_rend = $value->value;
            }
            
            // calcula o valor da soma das contas a pagar
            $sum_accont_pays = $this->Account->get_sum_accont_pay($datestart, $dateend);
            foreach ($sum_accont_pays->result() as $value) {
                $sum_accont_pay = $value->value;
            }
            
            $accont_flow = $sum_accont_rend - $sum_accont_pay;
            
            $sum_rends = $this->Account->get_sum_rend($datestart, $dateend);
            foreach ($sum_rends->result() as $value) {
                $sum_rend = $value->value;
            }
            
            $sum_pays = $this->Account->get_sum_pay($datestart, $dateend);
            foreach ($sum_pays->result() as $value) {
                $sum_pay = $value->value;
            }
            
            $flow = $sum_rend - $sum_pay;
            
            $data['sum_accont_rend'] = $sum_accont_rend;
            $data['sum_accont_pay'] = $sum_accont_pay;
            $data['sum_accont_flow'] = number_format($accont_flow, 2, ',', ' ');
            $data['sum_rend'] = $sum_rend;
            $data['sum_pay'] = $sum_pay;
            $data['sum_flow'] = number_format($flow, 2, ',', ' ');
            
            $this->load->view("accounts/accounts", $data);
        } else {
            $this->config->site_url('home');
        }
    }

    function payables($manage_result = null)
    {
        if ($this->check_action_permission('add_update')) {
            
            date_default_timezone_set('America/Sao_Paulo');
            $datestart = get_date_converter($this->input->post('datefilterstart'));
            $dateend = get_date_converter($this->input->post('datefilterend'));
            
            if (empty($datestart))
                $datestart = date('Y-m-d', strtotime('-1 month'));
            ;
            
            if (empty($dateend))
                $dateend = date('Y-m-d', strtotime('+1 Year'));
            
            $data['datestart'] = get_date_view($datestart);
            $data['dateend'] = get_date_view($dateend);
            
            $data['manage_result'] = $manage_result;
            $data['controller_name'] = 'accounts';
            $data['manage_table'] = get_account_manage_table($this->Account->get_pay($datestart, $dateend), $this, 1);
            
            $sum_accont_rends = $this->Account->get_sum_accont_rend($datestart, $dateend);
            foreach ($sum_accont_rends->result() as $value) {
                $sum_accont_rend = $value->value;
            }
            
            $sum_accont_pays = $this->Account->get_sum_accont_pay($datestart, $dateend);
            foreach ($sum_accont_pays->result() as $value) {
                $sum_accont_pay = $value->value;
            }
            
            $accont_flow = $sum_accont_rend - $sum_accont_pay;
            
            $sum_rends = $this->Account->get_sum_rend($datestart, $dateend);
            foreach ($sum_rends->result() as $value) {
                $sum_rend = $value->value;
            }
            
            $sum_pays = $this->Account->get_sum_pay($datestart, $dateend);
            foreach ($sum_pays->result() as $value) {
                $sum_pay = $value->value;
            }
            
            $flow = $sum_rend - $sum_pay;
            
            $data['sum_accont_rend'] = $sum_accont_rend;
            $data['sum_accont_pay'] = $sum_accont_pay;
            $data['sum_accont_flow'] = number_format($accont_flow, 2, ',', ' ');
            $data['sum_rend'] = $sum_rend;
            $data['sum_pay'] = $sum_pay;
            $data['sum_flow'] = number_format($flow, 2, ',', ' ');
            
            $this->load->view("accounts/payables", $data);
        } else {
            $this->config->site_url('home');
        }
    }

    function donw_receit($manage_result = null)
    {
        if ($this->check_action_permission('add_update')) {
            
            date_default_timezone_set('America/Sao_Paulo');
            $datestart = get_date_converter($this->input->post('datefilterstart'));
            $dateend = get_date_converter($this->input->post('datefilterend'));
            
            if (empty($datestart))
                $datestart = date('Y-m-d', strtotime('-1 month'));
            ;
            
            if (empty($dateend))
                $dateend = date('Y-m-d', strtotime('+1 Year'));
            
            $data['datestart'] = get_date_view($datestart);
            $data['dateend'] = get_date_view($dateend);
            
            $data['manage_result'] = $manage_result;
            $data['controller_name'] = 'accounts';
            $data['manage_table'] = get_consolidated_manage_table($this->Account->get_donw_receive($datestart, $dateend), $this, 0);
            
            // calcula o valor da soma das contas a receber
            $sum_accont_rends = $this->Account->get_sum_accont_rend($datestart, $dateend);
            foreach ($sum_accont_rends->result() as $value) {
                $sum_accont_rend = $value->value;
            }
            
            // calcula o valor da soma das contas a pagar
            $sum_accont_pays = $this->Account->get_sum_accont_pay($datestart, $dateend);
            foreach ($sum_accont_pays->result() as $value) {
                $sum_accont_pay = $value->value;
            }
            
            $accont_flow = $sum_accont_rend - $sum_accont_pay;
            
            $sum_rends = $this->Account->get_sum_rend($datestart, $dateend);
            foreach ($sum_rends->result() as $value) {
                $sum_rend = $value->value;
            }
            
            $sum_pays = $this->Account->get_sum_pay($datestart, $dateend);
            foreach ($sum_pays->result() as $value) {
                $sum_pay = $value->value;
            }
            
            $flow = $sum_rend - $sum_pay;
            
            $data['sum_accont_rend'] = $sum_accont_rend;
            $data['sum_accont_pay'] = $sum_accont_pay;
            $data['sum_accont_flow'] = number_format($accont_flow, 2, ',', ' ');
            $data['sum_rend'] = $sum_rend;
            $data['sum_pay'] = $sum_pay;
            $data['sum_flow'] = number_format($flow, 2, ',', ' ');
            
            $this->load->view("accounts/down_receit", $data);
        } else {
            $this->config->site_url('home');
        }
    }

    function donw_pay($manage_result = null)
    {
        if ($this->check_action_permission('add_update')) {
            
            date_default_timezone_set('America/Sao_Paulo');
            $datestart = get_date_converter($this->input->post('datefilterstart'));
            $dateend = get_date_converter($this->input->post('datefilterend'));
            
            if (empty($datestart))
                $datestart = date('Y-m-d', strtotime('-1 month'));
            ;
            
            if (empty($dateend))
                $dateend = date('Y-m-d', strtotime('+1 Year'));
            
            $data['datestart'] = get_date_view($datestart);
            $data['dateend'] = get_date_view($dateend);
            
            $data['manage_result'] = $manage_result;
            $data['controller_name'] = 'accounts';
            $data['manage_table'] = get_consolidated_manage_table($this->Account->get_down_pay($datestart, $dateend), $this, 1);
            
            $sum_accont_rends = $this->Account->get_sum_accont_rend($datestart, $dateend);
            foreach ($sum_accont_rends->result() as $value) {
                $sum_accont_rend = $value->value;
            }
            
            $sum_accont_pays = $this->Account->get_sum_accont_pay($datestart, $dateend);
            foreach ($sum_accont_pays->result() as $value) {
                $sum_accont_pay = $value->value;
            }
            
            $accont_flow = $sum_accont_rend - $sum_accont_pay;
            
            $sum_rends = $this->Account->get_sum_rend($datestart, $dateend);
            foreach ($sum_rends->result() as $value) {
                $sum_rend = $value->value;
            }
            
            $sum_pays = $this->Account->get_sum_pay($datestart, $dateend);
            foreach ($sum_pays->result() as $value) {
                $sum_pay = $value->value;
            }
            
            $flow = $sum_rend - $sum_pay;
            
            $data['sum_accont_rend'] = $sum_accont_rend;
            $data['sum_accont_pay'] = $sum_accont_pay;
            $data['sum_accont_flow'] = number_format($accont_flow, 2, ',', ' ');
            $data['sum_rend'] = $sum_rend;
            $data['sum_pay'] = $sum_pay;
            $data['sum_flow'] = number_format($flow, 2, ',', ' ');
            
            $this->load->view("accounts/down_pay", $data);
        } else {
            $this->config->site_url('home');
        }
    }

    function append($op, $accounts_id = -1, $manage_result = null)
    {
        if ($this->check_action_permission('add_update')) {
            if ($op == 0) {
                $data['manage_result'] = $manage_result;
                $data['accounts_info'] = $this->Account->get_info($accounts_id, $op);
                
                // Inicia Lista de Clientes
                $custormes_list = $this->Customer->get_all();
                
                if ($custormes_list->num_rows() != 0) {
                    foreach ($custormes_list->result() as $custormer) {
                        $cust[$custormer->first_name . ' ' . $custormer->last_name] = $custormer->first_name . ' ' . $custormer->last_name;
                    }
                    
                    $data['custormes_info'] = $cust;
                } else {
                    $data['custormes_info'] = array(
                        'N&#227; o h&#225; Clientes Registrados '
                    );
                }
                // Acabou a Lista de Clientes
                
                // Inicia Lista de Planos de Conta
                $plan_account_list = $this->PlanAccount->get_notcategory();
                
                if ($plan_account_list->num_rows() != 0) {
                    foreach ($plan_account_list->result() as $plan_account) {
                        $plan[$plan_account->codigo] = $plan_account->descricao;
                    }
                    $data['plan_account_info'] = $plan;
                } else {
                    $data['plan_account_info'] = array(
                        'N&#227; o h&#225; Planos de Contas '
                    );
                }
                // Acabou a Lista de Plano de Contas
                
                // Incia Lista de Forma de Pagamento
                $payment_form = $this->Method->get_all();
                
                if ($payment_form->num_rows() != 0) {
                    foreach ($payment_form->result() as $pay_form) {
                        $form[$pay_form->payment_type] = $pay_form->payment_type;
                    }
                    
                    $data['playment_form'] = $form;
                } else {
                    $data['playment_form'] = array(
                        'N&#227; o h&#225; Planos de Contas '
                    );
                }
                // Fim Lista de Forma de Pagamento
                
                $this->load->view('accounts/receit', $data);
            } else {
                $data['manager_result'] = $manage_result;
                $data['accounts_info'] = $this->Account->get_info($accounts_id, $op);
                
                // Inicia Lista de Fornecedores
                $supplier_list = $this->Supplier->get_all();
                
                if ($supplier_list->num_rows() != 0) {
                    foreach ($supplier_list->result() as $supplier) {
                        $rows[$supplier->corporate_name] = $supplier->corporate_name;
                    }
                    
                    $data['supplier_info'] = $rows;
                } else {
                    $data['supplier_info'] = array(
                        'N&#227;o h&#225; Fornecedores Registrados '
                    );
                }
                // Acabou Linha de Fornecedores
                
               // Inicia Lista de Planos de Conta
                $plan_account_list = $this->PlanAccount->get_notcategory();
                
                if ($plan_account_list->num_rows() != 0) {
                    foreach ($plan_account_list->result() as $plan_account) {
                        $plan[$plan_account->codigo] = $plan_account->descricao;
                    }
                    $data['plan_account_info'] = $plan;
                } else {
                    $data['plan_account_info'] = array(
                        'N&#227; o h&#225; Planos de Contas '
                    );
                }
                // Acabou a Lista de Plano de Contas
                
                $payment_form = $this->Method->get_all();
                
                if ($payment_form->num_rows() != 0) {
                    foreach ($payment_form->result() as $payment) {
                        $form[$payment->payment_type] = $payment->payment_type;
                    }
                    
                    $date['playment_form'] = $form;
                } else {
                    $data['playment_form'] = array(
                        'N&#227; o h&#225; Planos de Contas '
                    );
                }
                
                $this->load->view('accounts/pay', $data);
            }
        } else {
            $this->config->site_url('home');
        }
    }

    function down_view($op, $accounts_id = -1, $manage_result = null)
    {
        if ($this->check_action_permission('add_update')) {
            if ($op == 0) {
                $data['manage_result'] = $manage_result;
                $data['accounts_info'] = $this->Account->get_info($accounts_id, $op);
                
                $this->load->view('accounts/receit_down', $data);
            } else {
                $data['manager_result'] = $manage_result;
                $data['accounts_info'] = $this->Account->get_info($accounts_id, $op);
                
                $this->load->view('accounts/pay_down', $data);
            }
        } else {
            $this->config->site_url('home');
        }
    }

    function filter_donw($op)
    {
        if ($this->check_action_permission('add_update')) {
            
            if ($op == 0) {
                $date = get_date_converter($this->input->post('datefilter'));
                $data['manage_table'] = get_consolidated_manage_table($this->Account->date_filter($date), $this, $op);
                
                $sum_accont_rends = $this->Account->date_filter_sum($date);
                
                $data['dateresult'] = get_date_view($date);
                $data['sum_accont_rend'] = $sum_accont_rends;
                $this->load->view("accounts/accounts", $data);
            }
            
            if ($op == 1) {
                $date = get_date_converter($this->input->post('datefilter'));
                $data['manage_table'] = get_account_manage_table($this->Account->date_filter($date), $this, $op);
                
                $sum_accont_rends = $this->Account->date_filter_sum($date);
                
                $data['dateresult'] = get_date_view($date);
                $data['sum_accont_rend'] = $sum_accont_rends;
                $this->load->view("accounts/payables", $data);
            }
        }
    }
    
    /*
     * Retorna linhas de dados da tabela cliente. Este ser� chamado com AJAX.
     */
    function search()
    {
        if ($this->check_action_permission('search')) {
            
            if ($this->check_action_permission('search')) {
                $search = $this->input->post('search');
                $data_rows = get_account_manage_table($this->Account->search($search), $this);
                
                $data['controller_name'] = 'accounts';
                $data['manage_table'] = $data_rows;
                $this->load->view('accounts/accounts', $data);
            } else {
                $this->index('<div class="alert alert-danger">
						<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
						<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
						Opss.. Voc&#234; n&#227;o possui permi&#231;&#227;o para esta a&#231;&#227;o!...
						</div>');
            }
        } else {
            $this->config->site_url('home');
        }
    }
    
    /*
     * Inserts/updates a account
     */
    function save($operation)
    {
        if ($this->check_action_permission('add_update')) {
            
            $accounts_id = $this->input->post('account_id');
            
            $number = $this->input->post('number');
            if (empty($number))
                $number = - 1;
            
            $account_data = array(
                'number' => $this->input->post('number'),
                'date' => get_date_converter($this->input->post('date')),
                'favored' => ucwords(strtolower($this->input->post('favored'))),
                'operation' => $operation,
                'plan_accounts' => $this->input->post('plan_accounts'),
                'payment_form' => $this->input->post('payment_form'),
                'cost_center' => get_float_converter($this->input->post('value')),
                'value' => get_float_converter($this->input->post('value')),
                'historic' => $this->input->post('historic')
            );
            
            if ($this->Account->save($account_data, $number)) {
                
                // New account
                if ($number == - 1) {
                    
                    $this->append($operation, $accounts_id, '
							<div class="alert alert-success">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
							Registro inserido com sucesso ' . $account_data['number'] . ' ' . corrigeAcentuacao($account_data['favored']) . ' ' . $account_data['historic'] . '
							</div>');
                } else // previous account
{
                    $this->append($operation, $accounts_id, '
							<div class="alert alert-success">
							<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
							<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
							Registro atualizado com sucesso ' . $account_data['number'] . ' ' . corrigeAcentuacao($account_data['favored']) . ' ' . $account_data['historic'] . '
							</div>');
                }
            } else // failure
{
                $this->append($operation, $accounts_id, '
						<div class="alert alert-danger">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
						<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
						Opss.. Ocorreu um erro ao inserir ou atualizar o resgistro ' . $account_data['doctor_id'] . ' ' . $account_data['patient_id'] . '
						</div>
						');
            }
        } else {
            $this->config->site_url('home');
        }
    }

    function set_down()
    {
        $accounts_id = $this->input->post('id');
        $account_data = $this->Account->get_info($accounts_id);
        
        $account_id = 'javascript: postdown(' . $accounts_id . ');';
        echo 'var info = ["' . $account_data->number . '", "' . get_date_view($account_data->date) . '", "' . $account_data->favored . '", "' . $account_data->value . '", "' . $account_id . '"];';
    }

    function down()
    {
        $accounts_id = $this->input->post('id');
        $account_data = $this->Account->get_info($accounts_id);
        $account_data->value = $this->input->post('value');
        
        unset($account_data->id);
        
        if ($this->Account->down($account_data, $accounts_id)) {
            $this->index('
					<div class="alert alert-info">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-info-circle sign"></i><strong>info!</strong>
					Foi Deletado ' . count($account_data) . ' Registro(s).
					</div>
					');
        } else {
            $this->index('<div class="alert alert-danger">
					<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Voc&#234; n&#227;o possui permi&#231;&#227;o para esta a&#231;&#227;o!...
					</div>');
        }
    }
    
    /*
     * Isso exclui os clientes da tabela de clientes
     */
    function delete($accounts_id)
    {
        if ($this->check_action_permission('Delete')) {
            $account_to_delete = $accounts_id;
            
            if ($this->Account->delete($account_to_delete)) {
                
                $this->index('
					<div class="alert alert-info">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-info-circle sign"></i><strong>info!</strong>
					Foi Deletado ' . count($account_to_delete) . ' Registro(s).
					</div>
					');
            } else {
                $this->index('
						<div class="alert alert-danger">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
						<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
						Opss.. Ocorreu um erro ao deletar o(s) resgistro(s)
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