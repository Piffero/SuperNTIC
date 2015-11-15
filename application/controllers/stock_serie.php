<?php
date_default_timezone_set("Brazil/East");
require_once ("secure_area.php");

class Stock_serie extends Secure_area
{

    function __construct()
    {
        parent::__construct('items');
    }

    function index($manage_result = null, $data = null)
    {
        $lista = '';
        $itens = $this->Item->get_all();
        $series = $this->Item->get_serie(1);
        
        foreach ($itens->result() as $item) {
            if ($item->is_serialized == 1) {
                $lista .= '<li><a href="' . site_url('stock_serie/lista/' . $item->item_id) . '/1">' . $item->description . '</a></li>';
            }
        }
        
        $data['list_serie'] = '<h3><i class="fa fa-folder-open"></i> &nbsp;Produtos serializados em Estoque: ' . $series->num_rows() . '</h3>
										 	 <h5><i class="fa fa-hand-o-left"></i> &nbsp;Escolha um item ao lado </h5>';
        
        $data['lista'] = $lista;
        $data['rows'] = $series->num_rows();
        $data['manage_result'] = $manage_result;
        $this->load->view('items/listserie', $data);
    }

    function lista($item_id, $location_id = 1)
    {
        $itens = $this->Item->get_all();
        $lista = '';
        foreach ($itens->result() as $item) {
            if ($item->is_serialized == 1) {
                $lista .= '<li><a href="' . site_url('stock_serie/lista/' . $item->item_id . '/1') . '">' . $item->description . '</a></li>';
            }
        }
        
        $data['id'] = $item_id;
        $data['list_serie'] = $this->html($item_id, $location_id);
        $data['lista'] = $lista;
        $this->load->view('items/listserie', $data);
    }

    function xmlrequest()
    {
        $location_id = $this->input->post('empresa');
        $item_id = $this->input->post('serie');
        
        echo $this->html($item_id, $location_id);
    }

    function html($item_id, $loction_id)
    {
        $itens = $this->Item->get_info($item_id);
        $series = $this->Item->get_info_serie($item_id, $loction_id);
        $enterprises = $this->Enterprise->get_all();
        
        foreach ($enterprises->result() as $results) {
            $enterprise[$results->enterprise_id] = $results->fantasia;
        }
        
        // ***************************
        // * Valida Tipo de Produtos *
        // ***************************
        if ($itens->type == 0) {
            $type = 'Não Informado';
        } else {
            $type = $this->Type->get_info($itens->type)->name;
        }
        // **************************
        
        // Monta o cabeçalho junto aos controles
        $html = '';
        $html .= '<h4><u>' . $itens->description . '</u></h4>' . PHP_EOL;
        
        $html .= '<div class="col-md-6 col-lg-6 col-sm-6">' . PHP_EOL;
        $html .= '	<h5>&#149; ' . $series->num_rows() . ' Produtos </h5>' . PHP_EOL;
        $html .= '	<h5>&#149; Tipo do item: ' . $type . ' </h5>' . PHP_EOL;
        $html .= '</div>' . PHP_EOL;
        
        $html .= '<div class="col-md-6 col-lg-6 col-sm-6">' . PHP_EOL;
        $html .= '	<h5>&#149; Categoria: ' . $itens->category . '</h5>' . PHP_EOL;
        $html .= '	<h5>&#149; Unidade: ' . $itens->unit . '</h5>' . PHP_EOL;
        $html .= '</div>' . PHP_EOL;
        
        $html .= '	' . form_open("stock_serie/insert/$loction_id", 'id="formx"') . PHP_EOL;
        $html .= '<div class="col-md-12 col-lg-12 col-sm-12" style="display:inline-block">' . PHP_EOL;
        $html .= '	<hr>' . PHP_EOL;
        $html .= '	<h4>Inserir novo item na: ' . PHP_EOL;
        $html .= '		<small>' . PHP_EOL;
        $html .= '			<span style="float: right; text-decoration: underline !important;">' . PHP_EOL;
        $html .= '				' . form_dropdown('empresa', $enterprise, array(
            $loction_id
        ), 'id="mySelect" onchange="javascript: relista(\'' . $item_id . '\');"') . PHP_EOL;
        $html .= '			</span>' . PHP_EOL;
        $html .= '		<small>' . PHP_EOL;
        $html .= '	</h4>' . PHP_EOL;
        $html .= '</div>' . PHP_EOL;
        
        $html .= '<div class="col-md-6 col-lg-6 col-sm-6" style="display:inline-block">' . PHP_EOL;
        $html .= '	<h5>Nº de Série:</h5>' . PHP_EOL;
        $html .= '	<input type="text" tux="tux" required="required" class="form-control" placeholder="Nº de Série" name="nserie">' . PHP_EOL;
        $html .= '</div>' . PHP_EOL;
        
        $html .= '<div class="col-md-4 col-lg-4 col-sm-4" style="display:inline-block">' . PHP_EOL;
        $html .= '	<h5>Data de Entrada</h5>' . PHP_EOL;
        $html .= '	<input type="text" tux="tux" required="required" class="form-control" name="data" data-mask="00/00/0000" placeholder="Ex.: 01/01/2014" value="' . date('d/m/Y') . '">' . PHP_EOL;
        $html .= '</div>' . PHP_EOL;
        
        $html .= '<div class="col-md-1 col-lg-1 col-sm-1" style="display:inline-block">' . PHP_EOL;
        $html .= '	<h5>&nbsp;</h5><input type="hidden" name="id" value="' . $item_id . '">' . PHP_EOL;
        $html .= '	<button type="button" onclick="validador(\'formx\', \'tux\');" class="btn btn-success">Inserir</button>' . PHP_EOL;
        $html .= '</div>' . PHP_EOL;
        
        $html .= '<div class="col-md-12 col-lg-12 col-sm-12" style="display:inline-block">' . PHP_EOL;
        // Monta a tabela referente os produtos
        $html .= '	<table class="hover">' . PHP_EOL;
        $html .= '		<thead class="color-primary">' . PHP_EOL;
        $html .= '			<th>Nª de Série</th>' . PHP_EOL;
        $html .= '			<th class="text-center">Data de Entrada</th>' . PHP_EOL;
        $html .= '			<th class="text-center">Situação</th>' . PHP_EOL;
        $html .= '			<th class="text-center">Ação</th>' . PHP_EOL;
        $html .= '		</thead>' . PHP_EOL;
        $html .= '		<tbody>' . PHP_EOL;
        
        // lista o conteudo referente ao item e empresa em questão
        
        foreach ($series->result() as $serie) {
            $html .= '			<tr>';
            $html .= '			<td>' . $serie->item_serie . '</td>';
            $html .= '			<td class="text-center">' . date('d/m/Y', strtotime($serie->trans_date)) . '</td>';
            
            // valida situação
            if ($serie->stock_local == 1) {
                $html .= '			<td class="text-center">Em estoque</td>';
            } elseif ($serie->stock_local == 2) {
                $html .= '			<td class="text-center">Em fase de venda</td>';
            } else {
                $html .= '			<td class="text-center">Em fase de teste</td>';
            }
            
            $html .= '			<td class="text-center">';
            $html .= '				<a href="' . site_url('stock_serie/edit/' . $itens->item_id . 'x' . $serie->id) . '" data-toggle="tooltip" data-placement="top" data-original-title="Editar Nª de série" class="label label-primary"><i class="fa fa-pencil"></i></a>';
            $html .= '				<a href="#" onclick="return deletar(\'' . $serie->id . '\');" data-toggle="tooltip" data-placement="top" data-original-title="Excluir produto da lista" class="label label-danger"><i class="fa fa-times"></i></a>';
            $html .= '			</td>';
        }
        
        $html .= '		</tbody>' . PHP_EOL;
        $html .= '	</table>' . PHP_EOL;
        $html .= '</div>' . PHP_EOL;
        
        return $html;
    }

    function edit($id1id2, $manage_result = null)
    {
        $a = explode('x', $id1id2);
        $id = $a[0];
        $id2 = $a[1];
        
        $data['manage_result'] = $manage_result;
        if ($this->Item->get_item_base_info($id)[0]["type"] == 0) {
            $data['tipo'] = 'Nenhum';
        } else {
            $data['tipo'] = '<span data-toggle="tooltip" data-placement="top" data-original-title="' . $this->Item->get_category($this->Item->get_item_base_info($id)[0]["type"])->description . '">' . $this->Item->get_category($this->Item->get_item_base_info($id)[0]["type"])->name . '</span>';
        }
        
        if ($this->Item->get_item_base_info($id)[0]["category"] == 0) {
            $data['categoria'] = 'Sem categoria';
        } else {
            $data['categoria'] = $this->Item->get_item_base_info($id)[0]["category"];
        }
        
        $data['item_id'] = $id;
        $data['id'] = $id2;
        $data['data'] = $this->Item->get_dataeserie($id2)->trans_date;
        $data['serie'] = $this->Item->get_dataeserie($id2)->item_serie;
        $data['unit'] = $this->Item->get_item_base_info($id)[0]["unit"];
        $data['codebar'] = $this->Item->get_item_base_info($id)[0]["item_codebar"];
        $data['nome'] = $this->Item->get_item_base_info($id)[0]["description"];
        
        $this->load->view('items/edit_stock', $data);
    }

    function submit_serie()
    {
        $id = $this->input->post('id');
        $id_array = array(
            'id' => $id
        );
        $item = $this->input->post('item_id');
        
        $array = array(
            'item_serie' => $this->input->post('nserie')
        );
        
        if ($this->Item->update_serie($array, $id_array)) {
            
            redirect('stock_serie/lista/' . $item);
        } else {
            $manage_result = '<div class="alert alert-info">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
									<i class="fa fa-info-circle sign"></i><strong>Erro!</strong>
									Não foi possível inserir os dados no Banco de Dados.
								</div>';
            
            $this->edit($item . 'x' . $id, $manage_result);
        }
    }

    function insert($location_id = 1)
    {
        $data1 = explode('/', $this->input->post('data'));
        $data2 = $data1[2] . '-' . $data1[1] . '-' . $data1[0];
        
        if ($this->Item->insert_newserie(array(
            'item_id' => $this->input->post('id'),
            'item_serie' => $this->input->post('nserie'),
            'trans_date' => $data2,
            'location_id' => $location_id
        ))) {
            $this->lista($this->input->post('id'), $location_id, '<div class="alert alert-success">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
					<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
					Nº de série "' . $this->input->post('nserie') . '" Inserido com sucesso.
					</div>');
        } else {
            $this->lista($this->input->post('id'), $location_id, '<div class="alert alert-danger">
					<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Ops!</strong>
					Ocorreu um erro ao atualizar o registro, por favor informe este erro ao Suporte NTIC.
					</div>');
        }
    }

    function delete($id1id2)
    {
        $a = explode('x', $id1id2);
        $id = $a[0];
        $id2 = $a[1];
        
        if ($this->Item->delete_linha_nserie($id2)) {
            $this->lista($id, '<div class="alert alert-info">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
						<i class="fa fa-info sign"></i><strong>Sucesso.</strong>
						Produto deletado com sucesso.
					</div>');
        } else {
            $this->lista($id, '<div class="alert alert-danger">
					<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Ops!</strong>
					Ocorreu um erro ao atualizar o registro, por favor informe este erro ao Suporte NTIC.
					</div>');
        }
    }
}