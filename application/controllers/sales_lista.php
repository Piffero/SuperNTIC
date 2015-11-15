<?php
require_once ("secure_area.php");

class Sales_lista extends Secure_area
{

    function __construct()
    {
        parent::__construct('sales_lista');
    }

    function index()
    {
        // Aqui montamos a tabela lista de venda atravez da função get_saleslist_table_data_rows
        // e a enviamos para view, budget_list.
        $data['manager_table'] = get_saleslist_table_data_rows($this->Sale->get_all(), $this);
        $this->load->view('sales/budget_list', $data);
    }

    function view($order)
    {
        // Aqui coletamos os dados da venda e montamos o registro do mesmo para visulaização
        // no popup budget_info
        $Sales_info = $this->Sale->get_info($order);
        $Sales_item = $this->Sale->get_item_info($order);
        $Sales_ald = $this->Sale->get_item_ald($order);
        
        // print_r($Sales_item->result());
        
        $data_view = $this->show_data_sales($Sales_info, $Sales_item, $Sales_ald);
        
        $data['data_view'] = $data_view;
        $data['caption'] = 'Dados Sobre Venda';
        
        if ($Sales_info->for_sold == 2) {
            $data['form_success'] = '<button class="btn btn-success btn-flat" type="submit">Validar Venda</button>';
        }
        
        $this->load->view('sales/budget_info', $data);
    }

    function show_data_sales($sale, $item, $ald)
    {
        $customer_data = $this->Customer->get_info($sale->patient_id); // dados do comprador
        $patient_data = $this->Customer->get_info($sale->patient_user_id); // dodos do usuário
        
        $table = '';
        
        $table .= '<div id="home" class="tab-pane cont active">';
        $table .= '	<table class="no-border no-strip information">';
        $table .= '		<tbody class="no-border-x no-border-y">';
        $table .= '			<tr>';
        $table .= '				<td class="category" style="width:30%;">';
        $table .= '					<strong>N° Pedido ' . $sale->order . '</strong>';
        $table .= '				</td>';
        $table .= '				<td>';
        $table .= '					<table class="no-border no-strip skills">';
        $table .= '						<tbody class="no-border-x no-border-y">';
        $table .= '							<tr>';
        $table .= '								<td style="width:40%;"><label>Realizado às:</label></td>';
        $table .= '								<td>' . convert_timestamp($sale->sale_time) . '</td>';
        $table .= '							</tr>';
        $table .= '							<tr>';
        $table .= '								<td style="width:40%;"><label>Comprado por:</label></td>';
        $table .= '								<td>' . $customer_data->first_name . ' ' . $customer_data->last_name . '</td>';
        $table .= '							</tr>';
        $table .= '							<tr>';
        $table .= '								<td style="width:40%;"><label>Utilizado por:</label></td>';
        $table .= '								<td>' . $patient_data->first_name . ' ' . $patient_data->last_name . '</td>';
        $table .= '							</tr>';
        $table .= '							</tbody>';
        $table .= '					</table>';
        $table .= '				</td>';
        $table .= '			</tr>';
        $table .= '			<tr>';
        $table .= '				<td class="category" style="width:30%;">';
        $table .= '					<strong>Sobre a Venda</strong>';
        $table .= '				</td>';
        $table .= '				<td>';
        $table .= '					<table class="no-border no-strip skills">';
        $table .= '						<tbody class="no-border-x no-border-y">';
        $table .= '							<tr>';
        $table .= '								<td style="width:40%;"><label>Valor Venda:</label></td>';
        $table .= '								<td> R$ ' . $sale->value_sale . '</td>';
        $table .= '							</tr>';
        $table .= '							<tr>';
        $table .= '								<td style="width:40%;"><label>Valor Entrada:</label></td>';
        $table .= '								<td> R$ ' . $sale->value_entrada . ' &emsp;<font color="red">(Pagar junto ao Caixa)</font></td>';
        $table .= '							</tr>';
        $table .= '							<tr>';
        $table .= '								<td style="width:40%;"><label>Valor Desconto:</label></td>';
        $table .= '								<td> R$ ' . $sale->value_desconto . '</td>';
        $table .= '							</tr>';
        $table .= '							<tr>';
        $table .= '								<td style="width:40%;"><label>Financiado:</label></td>';
        $table .= '								<td> R$ ' . $sale->value_finance . '</td>';
        $table .= '							</tr>';
        $table .= '							<tr>';
        $table .= '								<td style="width:40%;"><label>Valor a Pagar:</label></td>';
        $table .= '								<td> R$ ' . $sale->value_apagar . ' &emsp;<font color="red">(Saldo Financiado)</font></td>';
        $table .= '							</tr>';
        $table .= '						</tbody>';
        $table .= '					</table>';
        $table .= '				</td>';
        $table .= '			</tr>';
        $table .= '			<tr>';
        $table .= '				<td class="category" style="width:30%;">';
        $table .= '					<strong>Sobre o Parelho</strong>';
        $table .= '				</td>';
        $table .= '				<td>';
        $table .= '					<table class="no-border no-strip skills">';
        $table .= '						<tbody class="no-border-x no-border-y">';
        
        foreach ($item->result() as $item_sale) {
            
            $item_result = $this->Item->get_info($item_sale->item_id);
            
            $table .= '							<tr>';
            $table .= '								<td style="width:40%;"><label>Aparelho ' . $item_sale->color . ':</label></td>';
            $table .= '								<td>' . $item_result->description . ' &emsp; <label>Série:</label> ' . $item_sale->number_serie . '</td>';
            $table .= '							</tr>';
        }
        
        $table .= '						</tbody>';
        $table .= '					</table>';
        $table .= '				</td>';
        $table .= '			</tr>';
        $table .= '			<tr>';
        $table .= '				<td class="category" style="width:30%;">';
        $table .= '					<strong>Transferência<br>no ato da venda</strong>';
        $table .= '				</td>';
        $table .= '				<td>';
        $table .= '					<table class="no-border no-strip skills">';
        $table .= '						<tbody class="no-border-x no-border-y">';
        
        foreach ($ald->result() as $ald_sale) {
            
            $table .= '							<tr>';
            $table .= '								<td style="width:40%;"><label>Aparelho ' . $ald_sale->set_aer . ':</label></td>';
            $table .= '								<td>' . $ald_sale->set_name . '</td>';
            $table .= '							</tr>';
            $table .= '							<tr>';
            $table .= '								<td style="width:40%;"><label>Valor Avaliado:</label></td>';
            $table .= '								<td>R$ ' . $ald_sale->set_value . '</td>';
            $table .= '							</tr>';
        }
        
        $table .= '						</tbody>';
        $table .= '					</table>';
        $table .= '				</td>';
        $table .= '			</tr>';
        $table .= '		</tbody>';
        $table .= '	</table>';
        $table .= '</div>';
        
        return $table;
    }

    function show_progress_sales($order)
    {
        
        // O arquivo deve ser gerado com o nome referente ao numero seguencial de geração
        // do arquivo sendo que deve ser preenchido com zeros a esquerda para que o nome
        // do arquivo posua 8 posições mais a extensão, acompanhado da extensão ".djp"
        
        /**
         * ALGUMAS REGRAS
         * Os campos deverão ser separados entre si pelo caracter "|" (pipe) e apos o ultimo campo
         * tambem deverar ser adicionado um caracter "|" (pipe).
         * Para campos numericos que possuem casas decimais, informar o ponto (.)
         */
        $file = str_pad($order, 8, "0", STR_PAD_LEFT);
        
        // cosultando dados da tabela
        $sale = $this->Sale->get_info($order);
        
        // Monta data e hora de acordo com DJMonitor
        $ar_datetime = explode(' ', $sale->sale_time);
        
        $date = $ar_datetime[0];
        $time = $ar_datetime[1];
        
        $ar_date = explode('-', $date);
        $ar_time = explode(':', $time);
        
        $string_datetime = $ar_date[2] . $ar_date[1] . $ar_date[0] . $ar_time[0] . $ar_time[1] . $ar_time[2];
        $separador = '|';
        
        // Consulta nome do Cliente
        $customer = $this->Customer->get_info($sale->patient_id);
        
        // verifica quanto a quantidade de item
        $qtde_item = $this->Sale->count_sales_item($order);
        
        // Monta conteudo arquivo .djp
        $pre = '';
        
        // Registro PRE - Cabeçalho da Pré-Venda
        $pre .= 'PRE' . $separador;
        $pre .= $order . $separador;
        $pre .= $string_datetime . $separador;
        $pre .= $sale->patient_id . $separador;
        $pre .= $customer->first_name . ' ' . $customer->last_name . $separador;
        $pre .= $customer->document_cpf . $separador;
        $pre .= $sale->for_sold . $separador;
        $pre .= $sale->value_sale . $separador;
        $pre .= $sale->value_desconto . $separador;
        $pre .= '0.00' . $separador;
        $pre .= $qtde_item . $separador;
        $pre .= chr(13);
        
        $pit = '';
        $A = 0;
        $item_sale = $this->Sale->get_item_info($order);
        $qtde_is = $this->Sale->checked_sales_item($order);
        
        // Registro PIT - Itens da Pré-Venda
        foreach ($item_sale->result() as $item) {
            $item_info = $this->Item->get_info($item->item_id);
            $item_nfe = $this->Item->get_info_nfe($item->item_id);
            $item_business = $this->Item->get_info_business($item->item_id);
            
            $A ++;
            $pit .= 'PIT' . $separador; // Sigla Inicial
            $pit .= $A . $separador; // Sequecia
            $pit .= $item->item_id . $separador; // Codigo Externo
            $pit .= $qtde_is . $separador; // Quantidade
            $pit .= $item_business->selling_price . $separador; // preço Unitario
            $pit .= '0.00' . $separador; // Valor do Desconto
            $pit .= '0.00' . $separador; // Valor do Acrescimo
            $pit .= $item_business->selling_price . $separador; // Total Liquido
            $pit .= $item_info->item_codebar . $separador; // Codigo de Barras
            
            $pit .= chr(13);
            
            $item_serie = $this->Item->get_serie_info($item->number_serie);
            $this->Item->update_serie(array(
                'stock_local' => '2'
            ), array(
                'id' => $item_serie->id
            ));
        }
        
        $txt = $pre . $pit;
        
        $fp = fopen('pre/producao/' . $file . '.djp', 'w');
        fwrite($fp, $txt);
        fclose($fp);
        
        $this->progress_return($order);
    }

    function progress_return($order)
    {
        $data_sales['for_sold'] = '2';
        
        if ($this->Sale->save($data_sales, $order)) {
            
            $data_order = $this->Sale->get_info($order);
            $sale_item = $this->Sale->get_item_info($order);
            $sale_item_ald = $this->Sale->get_item_ald($order);
            
            // Pega as informações do Cliente Comprador e Usuário
            $customer = $this->Customer->get_info($data_order->patient_id);
            $patient = $this->Customer->get_info($data_order->patient_user_id);
            $work_data = $this->Customer->get_work($data_order->patient_id);
            
            $data['sale_item'] = $sale_item->result();
            $data['sale_item_ald'] = $sale_item_ald->result();
            $data['order_sales'] = $data_order;
            $data['customer'] = $customer;
            $data['patient'] = $patient;
            $data['work'] = $work_data;
            
            $this->load->view('sales/contract_bud', $data);
        }
    }
}

?>