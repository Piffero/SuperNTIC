<?php
require_once ("secure_area.php");

class Stock_cat extends Secure_area
{

    function __construct()
    {
        parent::__construct('items');
    }

    function index($manage_result = null, $data = null)
    {
        $series = $this->Item->get_serie(1);
        
        // Calcula o total de estoque
        $q = $this->Item->total_itens();
        $s = $series->num_rows();
        
        // $q = $this->General->select("id", "items_serie")->num_rows();
        $data['manage_result'] = $manage_result;
        $data['total'] = $this->Item->total_itens();
        $CatRows = $this->Item->get_list_category()->num_rows();
        $lista = $this->Item->get_list_category()->result_array();
        $quant = $q + $s;
        $data['cat'] = '';
        
        for ($i = 0; $i < $CatRows; $i ++) {
            
            if ($lista[$i]["category"] == '0') {
                $data['cat'] .= '<li><a href="' . site_url('stock_cat/lista/' . $lista[$i]["category"]) . '">';
                if (isset($data['categoria']) and $data['categoria'] == $lista[$i]["category"]) {
                    $data['cat'] .= '<i class="fa fa-folder-open-o"></i> Sem Categoria</a></li>';
                } else {
                    $data['cat'] .= '<i class="fa fa-folder-o"></i> Sem Categoria</a></li>';
                }
            } else {
                $data['cat'] .= '<li><a href="' . site_url('stock_cat/lista/' . $lista[$i]["category"]) . '">';
                if (isset($data['categoria']) and $data['categoria'] == $lista[$i]["category"]) {
                    $data['cat'] .= '<i class="fa fa-folder-open-o"></i> ' . $lista[$i]["category"] . '</a></li>';
                } else {
                    $data['cat'] .= '<i class="fa fa-folder-o"></i> ' . $lista[$i]["category"] . '</a></li>';
                }
            }
        }
        
        $data['LinhasCat'] = $CatRows;
        
        $data['lista'] = '<h3><i class="fa fa-folder-open"></i> &nbsp;Total em Estoque: ' . $quant . ' itens</h3>';
        $data['lista'] .= '<h5><i class="fa fa-hand-o-left"></i> &nbsp;Escolha uma categoria ao lado </h5>';
        $this->load->view('items/listall', $data);
    }

    function lista($categoria = null)
    {
        $html = '';
        if ($categoria == null) {
            redirect('stock_cat');
        } else {
            
            $location_id = 1;
            
            $CatRows = $this->Item->get_list_category()->num_rows();
            $lista = $this->Item->get_list_category()->result_array();
            $data['cat'] = '';
            
            for ($i = 0; $i < $CatRows; $i ++) {
                
                if ($lista[$i]["category"] == '0') {
                    $data['cat'] .= '<li><a href="' . site_url('stock_cat/lista/' . $lista[$i]["category"]) . '">';
                    if (isset($data['categoria']) and $data['categoria'] == $lista[$i]["category"]) {
                        $data['cat'] .= '<i class="fa fa-folder-open-o"></i> Sem Categoria</a></li>';
                    } else {
                        $data['cat'] .= '<i class="fa fa-folder-o"></i> Sem Categoria</a></li>';
                    }
                } else {
                    $data['cat'] .= '<li><a href="' . site_url('stock_cat/lista/' . $lista[$i]["category"]) . '">';
                    if (isset($data['categoria']) and $data['categoria'] == $lista[$i]["category"]) {
                        $data['cat'] .= '<i class="fa fa-folder-open-o"></i> ' . $lista[$i]["category"] . '</a></li>';
                    } else {
                        $data['cat'] .= '<i class="fa fa-folder-o"></i> ' . $lista[$i]["category"] . '</a></li>';
                    }
                }
            }
            
            $data['lista'] = $this->html($categoria, $location_id);
            
            $this->load->view('items/listall', $data);
        }
    }

    function xmlrequest()
    {
        $location_id = $this->input->post('empresa');
        $categoria = $this->input->post('cat');
        
        echo $this->html($categoria, $location_id);
    }

    function html($categoria, $location_id = 1)
    {
        $html = '';
        
        // traz informações da lista de produtos por categoria
        $listaItems = $this->Item->get_item_list(rawurldecode($categoria));
        $enterprises = $this->Enterprise->get_all();
        
        foreach ($enterprises->result() as $results) {
            $enterprise[$results->enterprise_id] = $results->fantasia;
        }
        
        // Monta o Cabeçalho referente a Categoria
        $html .= '<h4>';
        $html .= '<span>';
        $html .= rawurldecode($categoria) . ' - ' . $listaItems->num_rows() . ' itens cadastrados';
        $html .= '<small>';
        $html .= '<span style="float: right; text-decoration: underline !important;">';
        $html .= form_dropdown('empresa', $enterprise, array(), 'id="mySelect" onchange="javascript: relista(\'' . $categoria . '\');"');
        $html .= '</span>';
        $html .= '<small>';
        $html .= '</span>';
        $html .= '<h4>';
        
        // Monta tabela referente a categoria
        $html .= '<table class="hover">';
        $html .= '<thead class="color-primary">';
        $html .= '<th>Código de Barras</th>';
        $html .= '<th>Produto</th>';
        $html .= '<th class="text-right">Quantidade</th>';
        $html .= '<th class="text-center">Unidade</th>';
        $html .= '<th class="text-center">Serializado</th>';
        $html .= '</thead>';
        $html .= '<tbody>';
        // Monta conteudo da tabela referente a categoria
        
        foreach ($listaItems->result() as $items) {
            
            $series = $this->Item->get_info_serie($items->item_id, $location_id);
            
            // valida se o item em questão é serializado e prepara link de acordo
            if ($items->is_serialized == 1) {
                // caso o item seja serializado link com STOCK_SERIE/LISTA/ID
                $html .= '<tr ondblclick="window.location.href=\'' . site_url('stock_serie/lista/' . $items->item_id) . '\'">';
                $html .= '<td>' . $items->item_codebar . '</td>';
                $html .= '<td>' . $items->description . '</td>';
                $html .= '<td>' . $series->num_rows() . '</td>';
                $html .= '<td>' . $items->unit . '</td>';
                $html .= '<td>SIM</td>';
            } else {
                $qtde = $this->Item->get_stock($items->item_id, $location_id);
                if (empty($qtde[0]['quantity'])) {
                    $q = 0;
                } else {
                    $q = $qtde[0]['quantity'];
                }
                
                // caso o item não seja serializado link com ITEMS/INVENTORY/ID
                $html .= '<tr ondblclick="window.location.href=\'' . site_url('items/inventory/' . $items->item_id . '/' . $location_id) . '\'">';
                $html .= '<td>' . $items->item_codebar . '</td>';
                $html .= '<td>' . $items->description . '</td>';
                $html .= '<td>' . $q . '</td>';
                $html .= '<td>' . $items->unit . '</td>';
                $html .= '<td>NÃO</td>';
            }
        }
        
        $html .= '</tbody>';
        $html .= '</table>';
        
        return $html;
    }
}

?>