<?php

class Purchase extends CI_Model
{

    function addcompra(&$item_data, $id_pedido)
    {
        $success = false;
        
        if ($item_data && $id_pedido) {
            if ($id_pedido == - 1) {
                $success = $this->db->insert('purch_request', $item_data);
            } else {
                $this->db->where('id', $id_pedido);
                $success = $this->db->update('purch_request', $item_data);
            }
            
            return $success;
        } else {
            return $success;
        }
    }
    
    // ----------------------------------------------------------------------
    function num_compra()
    {
        $this->db->from('purch_request');
        $this->db->select_max('id');
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            foreach ($query->result() as $suggest_id) {
                $rows['id'] = $suggest_id->id;
            }
            
            return $rows['id'];
        } else {
            return true;
        }
    }
    
    // --------------------------------------------------------------------------
    function destiny()
    
    {
        $this->db->from('items');
        $query = $this->db->query('SELECT DISTINCT `unit` FROM `ntic_items`');
        
        if ($query->num_rows() != 0) {
            foreach ($query->result() as $unit) {
                $rows[$unit->unit] = $unit->unit;
            }
            
            return $rows;
        } else {
            return 'Não há registro de tipos unitários';
        }
    }

    function last()
    {
        $this->db->from('purch_request');
        $this->db->select_max('num_pedido');
        $ultimo = $this->db->get();
        if ($ultimo->num_rows() == 1) {
            return $ultimo->row();
        } else {
            $fields = $this->db->list_fields('purch_request');
            $purch_obj = new stdClass();
            
            foreach ($fields as $field) {
                $purch_obj->$field = '';
            }
            return $purch_obj;
        }
    }

    function save_itens_all($itens_data)
    {
        $success = false;
        
        if ($itens_data) {
            $success = $this->db->insert('purch_items', $itens_data);
            // $success .= $this->db->query("UPDATE `ntic_purch_request` SET `situacao` = 'Aberto' WHERE `num_pedido` = '$itens_data[0]'");
        } else {
            $success = false;
        }
        
        return $success;
    }

    function db_list_itens($pedido)
    {
        $this->db->from("purch_items");
        $this->db->where("pedido", $pedido);
        return $this->db->get();
    }

    function del_item($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('purch_items');
        return true;
    }

    function insertpedido($pedido_data)
    {
        $success = false;
        
        if ($pedido_data) {
            $this->db->insert('purch_request', $pedido_data);
        } else {
            $success = false;
        }
        
        return $success;
    }

    function total($pedido)
    {
        $this->db->from('purch_items');
        $this->db->select_sum('vtotal');
        $this->db->where('pedido', $pedido);
        $result = $this->db->get();
        return $result;
    }

    function gerarpc($pedido, $num)
    {
        $this->db->where('num_pedido', $num);
        $this->db->update('purch_request', $pedido);
    }

    function table_lista_pc()
    {
        $query = $this->db->query("SELECT `num_pedido`, `fornecedor`, `departamento`, `data`, `situacao` FROM `ntic_purch_request` WHERE `deleted` = '0' AND `situacao` IN ('Processando', 'Aberto', 'Aprovado', 'Pedido') ORDER BY `ntic_purch_request`.`num_pedido` ASC");
        return $query;
    }

    function max_pedido()
    {
        $this->db->select_max("num_pedido");
        $this->db->from("purch_request");
        $this->db->where("deleted", "0");
        
        $resultado = $this->db->get();
        return $resultado->result();
    }

    function list_order_pc()
    {
        $this->db->select_sum("quantidade");
        $this->db->from("purch_items");
        $this->db->join("purch_request", "purch_request.num_pedido = purch_items.pedido");
        $this->db->where("purch_items.pedido", "5");
        
        $query = $this->db->get();
        return $query->result();
    }

    function request_order()
    {
        $this->db->select("num_pedido");
        $this->db->select("fornecedor");
        $this->db->select("departamento");
        $this->db->from("purch_request");
        $this->db->where("deleted", "0");
        $this->db->order_by("num_pedido", "ASC");
        
        $query = $this->db->get();
        return $query->result();
    }

    function Supreme()
    {
        return $this->db->query("SELECT `ntic_purch_request`.`num_pedido`, `ntic_purch_request`.`fornecedor`, `ntic_purch_request`.`departamento`, 
			SUM(`ntic_purch_items`.`vtotal`) AS `ptotal`, 
			SUM(`ntic_purch_items`.`quantidade`) AS `qtotal` 
			FROM `ntic_purch_items`, `ntic_purch_request` 
			WHERE `ntic_purch_request`.`situacao` = 'Aberto'
			AND `ntic_purch_request`.`deleted` = '0'
			AND `ntic_purch_items`.`pedido` 
			LIKE `ntic_purch_request`.`num_pedido` 
			GROUP BY `ntic_purch_request`.`num_pedido`");
    }

    function get_total_Supreme()
    {
        return $this->db->query("SELECT 
			SUM(`ntic_purch_items`.`vtotal`) AS `ptotal`, 
			SUM(`ntic_purch_items`.`quantidade`) AS `qtotal` 
			FROM `ntic_purch_items`, `ntic_purch_request` 
			WHERE `ntic_purch_request`.`situacao` = 'Aberto' 
			AND `ntic_purch_items`.`pedido` 
			LIKE `ntic_purch_request`.`num_pedido`");
    }

    /**
     * Aprova o pedido setado pelo parâmentro $pedido
     *
     * @param integer $pedido            
     */
    function approve($pedido)
    {
        $this->db->where("num_pedido", $pedido);
        return $this->db->update("purch_request", array(
            'situacao' => 'Aprovado'
        ));
    }

    /**
     * Reprova o pedido setado pelo parâmentro $pedido
     *
     * @param integer $pedido            
     */
    function disapprove($pedido)
    {
        $this->db->where("num_pedido", $pedido);
        return $this->db->update("purch_request", array(
            'situacao' => 'Reprovado'
        ));
    }

    /**
     * Retorna n�mero do telefone e email do fornecedor
     * atrav�s do par�metro passado.
     *
     * @param integer $supplier_name            
     */
    function get_supplier_info($supplier_name)
    {
        $this->db->select("phone_number");
        $this->db->select("email");
        $this->db->from("suppliers");
        $this->db->where("fancy_name", $supplier_name);
        return $this->db->get();
    }

    /**
     * 1� - Troca a situa��o de "Aprovado" para "Pedido"
     * 2� - Insere se o pedido foi realizado via email e/ou telefone
     *
     * @param integer $pedido            
     */
    function send($pedido, $datas)
    {
        $this->db->where("num_pedido", $pedido);
        $this->db->update("purch_request", $datas);
        return $this->db->update("purch_request", array(
            'situacao' => 'Pedido'
        ));
    }

    /**
     * Deleta pedido inteiro, na purch_items e purch_request.
     *
     * @param integer $pedido            
     */
    function delete_purch_all($pedido)
    {
        if ($this->db->query("UPDATE `ntic_purch_request` SET `deleted` = '1' WHERE `num_pedido` = '$pedido'")) {
            if ($this->db->query("UPDATE `ntic_purch_items` SET `deleted` = '1' WHERE `pedido` = '$pedido'")) {
                return true;
            } else {
                return false;
            }
        } 

        else {
            return false;
        }
    }

    /**
     * Checa no banco de dados o item verificado pelo estoquista na
     * entrada do produto do Pedido de Compra e insere os valores unitários
     * e total da nota confirmados por ele.;
     *
     * @param
     *            $item_pedido
     */
    function checkin($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('purch_items', $data);
    }

    /**
     * Função que busca todos os campos da tabela 'ntic_purch_request'
     * atrav�s do parâmetro $pedido e retorna.
     *
     * @param integer $pedido            
     */
    function listpedido($pedido)
    {
        $this->db->select("*");
        $this->db->from("purch_request");
        $this->db->where("num_pedido", $pedido);
        return $this->db->get();
    }

    /**
     * Busca todos as colunas e campos do banco de dados relacionadas ao pedido,
     * passado pelo parametro "$id_pedido" (id do pedido).
     *
     * @param integer $id_pedido            
     */
    function get_campos_pedido($id_pedido)
    {
        $this->db->from("purch_items");
        $this->db->where("id", $id_pedido);
        return $this->db->get();
    }

    /**
     * Função que confirma a chegada do produto na empresa
     * setando o valor "Pedido" para "Recebido" no Banco de Dados.
     *
     * @param integer $pedido            
     */
    function confirma($pedido)
    {
        $data = array(
            'situacao' => 'Recebido'
        );
        $this->db->where('num_pedido', $pedido);
        return $this->db->update('purch_request', $data);
    }

    /**
     * Busca o Fornecedor, departamento e data do pedido
     * de compra passado pelo par�metro "$pedido".
     *
     * @param integer $pedido            
     */
    function busca_Forn_Date_Dept($pedido)
    {
        $this->db->select("fornecedor");
        $this->db->select("departamento");
        $this->db->select("data");
        $this->db->from("purch_request");
        $this->db->where("num_pedido", $pedido);
        $infos = $this->db->get();
        return $infos->result_array();
    }

    /**
     * Lista de pedidos de compras na tabela de acordo com
     * departamento e permissão
     *
     * @param string $dept            
     */
    function list_by_dept(&$dept, $view = false) // $dept
    {
        $this->db->select("num_pedido");
        $this->db->select("fornecedor");
        $this->db->select("departamento");
        $this->db->select("data");
        $this->db->select("situacao");
        $this->db->select("nfe_chave");
        $this->db->select("nfe_num_nota");
        $this->db->from("purch_request");
        $this->db->where("deleted", "0");
        if ($view == false) {
            $this->db->where("departamento", $dept);
        }
        $this->db->where_in("situacao", array(
            "Processando",
            "Aberto",
            "Aprovado",
            "Pedido"
        ));
        $this->db->order_by("num_pedido", "ASC");
        return $this->db->get();
    }

    /**
     *
     * @param unknown $id_forn            
     */
    function get_seted_forn($id_forn)
    {
        $this->db->select("fancy_name");
        $this->db->from("suppliers");
        $this->db->where("suppliers_id", $id_forn);
        $result = $this->db->get();
        return $result->row();
    }

    function get_tel($id)
    {
        $this->db->select("phone_number");
        $this->db->from("suppliers");
        $this->db->where("suppliers_id", $id);
        return $this->db->get()->row()->phone_number;
    }

    function get_email($id)
    {
        $this->db->select("email");
        $this->db->from("suppliers");
        $this->db->where("suppliers_id", $id);
        return $this->db->get()->row()->email;
    }

    function associate_nfe($data, $id)
    {
        return $this->db->update("purch_request", $data, array(
            'num_pedido' => $id
        ));
    }

    function get_basic_purch_info($id)
    {
        $this->db->select("fornecedor, departamento, data, nfe_chave, nfe_num_nota");
        $this->db->from("purch_request");
        $this->db->where("num_pedido", $id);
        return $this->db->get()->row();
    }

    function retorna_name($id)
    {
        $this->db->select("description");
        $this->db->from("items");
        $this->db->where("item_id", $id);
        return $this->db->get()->row()->description;
    }
    // han ???
    function retorna_quant($id)
    {
        $this->db->select("description");
        $this->db->from("items");
        $this->db->where("item_id", $id);
        return $this->db->get()->row()->description;
    }

    function get_lista_produtos($pedido)
    {
        return $this->db->query("select `ntic_purch_items`.`produto`, `ntic_purch_items`.`unidade`, `ntic_purch_items`.`quantidade`, `ntic_items`.`item_codebar` from `ntic_items`, `ntic_purch_items` where `ntic_purch_items`.`pedido` = '$pedido' and `ntic_items`.`item_id` = `ntic_purch_items`.`produto`");
    }

    function get_entrada($pedido)
    {
        $this->db->select("produto, quantidade, quant_inserida");
        $this->db->from("purch_items");
        $this->db->where("deleted", 0);
        $this->db->where("pedido", $pedido);
        return $this->db->get();
    }

    function is_serial($item_id)
    {
        $this->db->select("is_serialized");
        $this->db->from("items");
        $this->db->where("item_id", $item_id);
        return $this->db->get();
    }

    /**
     * Recebe item serializado no estoque
     *
     * @param array $data            
     * @return boolean
     */
    function insert_serie($data)
    {
        return $this->db->insert("items_serie", $data);
    }

    /**
     *
     * @param unknown $produto            
     * @param unknown $pedido            
     */
    function esta_na_lista($produto, $pedido)
    {
        $this->db->select("produto");
        $this->db->from("purch_items");
        $this->db->where("produto", $produto);
        $this->db->where("pedido", $pedido);
        return $this->db->get()->num_rows();
    }

    /**
     * Pega a quantidade de itens no estoque a adiciona com a $qtde do parâmetro
     *
     * @param float $qtde            
     * @param int $produto            
     * @param int $pedido            
     * @return boolean
     */
    function soma_no_pedido($qtde, $produto, $pedido, $uvalor = 0, $tvalor = 0)
    {
        $soma = $this->get_quantidade_itens($qtde, $produto, $pedido, $uvalor, $tvalor);
        return $this->db->update("purch_items", array(
            'quantidade' => $soma->QTD,
            'valorunit' => $soma->UNIT,
            'vtotal' => $soma->TOTAL
        ), array(
            'pedido' => $pedido,
            'produto' => $produto,
            'deleted' => 0
        ));
    }

    function get_quantidade_itens($qtde, $produto, $pedido, $uvalor = 0, $tvalor = 0)
    {
        settype($qtde, 'integer');
        return $this->db->query("SELECT SUM(`quantidade`+$qtde) AS `QTD`, SUM(`valorunit`+$uvalor) AS `UNIT`, SUM(`vtotal`+$tvalor) AS `TOTAL` FROM `ntic_purch_items` WHERE `pedido` = '$pedido' AND `produto` = '$produto' AND `deleted` = 0")->row();
    }

    function get_quant_inserida($pedido, $produto)
    {
        $this->db->select("quant_inserida");
        $this->db->from("purch_items");
        $this->db->where(array(
            "pedido" => $pedido,
            "produto" => $produto,
            "deleted" => 0
        ));
        return $this->db->get()->row()->quant_inserida;
    }

    function set_quant_inserida($pedido, $produto, $qtd)
    {
        settype($qtd, 'integer');
        $soma = ($this->get_quant_inserida($pedido, $produto) + $qtd);
        return $this->db->update("purch_items", array(
            'quant_inserida' => $soma
        ), array(
            "pedido" => $pedido,
            "produto" => $produto,
            "deleted" => 0
        ));
    }

    /**
     * Verifica se o nº de série existe, retornando uma ou nenhuma linha
     *
     * @param unknown $nserie            
     */
    function verifica_nserie_existe($nserie)
    {
        $this->db->select("id");
        $this->db->from("items_serie");
        $this->db->where(array(
            "item_serie" => $nserie,
            "deleted" => 0
        ));
        return $this->db->get()->num_rows();
    }

    /**
     * Verifica se o item é serializado
     *
     * @param int $pedido            
     */
    function verifica_todos_serializados($pedido)
    {
        return $this->db->query("SELECT SUM(`ntic_items`.`is_serialized`) AS `soma` FROM `ntic_items`, `ntic_purch_items` WHERE `ntic_purch_items`.`produto`= `ntic_items`.`item_id` AND `ntic_purch_items`.`pedido` = '$pedido'")->row()->soma;
        
        /*
         * $this->db->select_sum("is_serialized", "serializado");
         * $this->db->from("purch_items");
         * $this->db->where(array("pedido"=>$pedido, "deleted"=>0));
         * return $this->db->get()->row()->serializado;
         */
    }

    /**
     * Retorna o valor das somas de quantidade pedida e quantidade já entrada no estoque
     *
     * @param integer $pedido            
     * @return mixed
     */
    function soma_subtrai_quantidades($pedido)
    {
        return $this->db->query("SELECT SUM(`quantidade`) AS `QTD`, SUM(`quant_inserida`) AS `QTD2` FROM `ntic_purch_items` WHERE `pedido` = '82' AND `deleted` = '0' ");
    }

    /**
     * Ajusta a quantidade dos itens
     *
     * @param array $data            
     * @param string $id            
     * @return boolean
     */
    function update_quant($data, $id)
    {
        return $this->db->update("purch_items", $data, array(
            "id" => $id
        ));
    }

    /**
     * Retorna a quantidade de itens do pedido e a quantidade que foi inserida no estoque de APENAS UM item na lista
     *
     * @param integer $id_produto            
     */
    function verif_quant($id_produto)
    {
        $this->db->select("quantidade, quant_inserida");
        $this->db->from("purch_items");
        $this->db->where(array(
            "deleted" => 0,
            "produto" => $id_produto
        ));
        return $this->db->get()->row();
    }

    function confirma_no_pedido($qtde, $produto, $pedido)
    {
        $soma = $this->get_quant_pedido($produto, $pedido);
        return $this->db->update("purch_items", array(
            'quant_inserida' => $soma
        ), array(
            'pedido' => $pedido,
            'produto' => $produto,
            'deleted' => 0
        ));
    }

    function get_quant_pedido($produto, $pedido)
    {
        return $this->db->query("SELECT SUM(`quantidade`) AS `QTD` FROM `ntic_purch_items` WHERE `pedido` = '$pedido' AND `produto` = '$produto' AND `deleted` = 0")->row()->QTD;
    }

    function verifica_zerou_quant($produto, $pedido)
    {
        return $this->db->query("SELECT SUM(`quantidade`) AS `QTD`, SUM(`quant_inserida`) AS `QTD2` FROM `ntic_purch_items` WHERE `pedido` = '$pedido' AND `produto` = '$produto' AND `deleted` = 0")->row();
    }

    /**
     *
     * @param unknown $pedido            
     */
    function soma_quant_pserial($pedido)
    {
        return $this->db->query("SELECT SUM(`ntic_purch_items`.`quantidade`) AS `QTD1`, SUM(`ntic_purch_items`.`quant_inserida`) AS `QTD2`
			FROM `ntic_purch_items`, `ntic_items`
			WHERE `ntic_purch_items`.`produto` = `ntic_items`.`item_id`
			AND `ntic_purch_items`.`pedido` = '$pedido'
			AND `ntic_items`.`is_serialized` = '1'")->row();
    }

    /**
     *
     * @param unknown $pedido            
     */
    function soma_quant_pNserial($pedido)
    {
        return $this->db->query("SELECT SUM(`ntic_purch_items`.`quantidade`) AS `QTD1`, SUM(`ntic_purch_items`.`quant_inserida`) AS `QTD2`
				FROM `ntic_purch_items`, `ntic_items`
				WHERE `ntic_purch_items`.`produto` = `ntic_items`.`item_id`
				AND `ntic_purch_items`.`pedido` = '$pedido'
				AND `ntic_items`.`is_serialized` = '0'")->row();
    }

    function conclui_pedido($data, $pedido)
    {
        return $this->db->update("purch_request", $data, array(
            'num_pedido' => $pedido
        ));
    }

    function list_search($search)
    {
        $this->db->from('purch_request');
        $this->db->where("(
		num_pedido LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		fornecedor LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		departamento LIKE '%" . $this->db->escape_like_str($search) . "%' or
		data LIKE '%" . $this->db->escape_like_str($search) . "%' or 
		situacao LIKE '%" . $this->db->escape_like_str($search) . "%' or
		nfe_chave LIKE '%" . $this->db->escape_like_str($search) . "%' or
		nfe_num_nota LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0");
        $this->db->order_by("num_pedido", "asc");
        
        return $this->db->get();
    }

    function exist_item_value($key)
    {
        $this->db->select("id");
        $this->db->from("items_value");
        $this->db->where("item_id", $key);
        return $this->db->get();
    }

    function get_item_quant($id)
    {
        $this->db->select("quantity");
        $this->db->from("items_value");
        $this->db->where("id", $id);
        return $this->db->get()->row()->quantity;
    }

    function update_item_value($quantidade, $id)
    {
        $quant = $this->get_item_quant($id);
        return $this->db->update("items_value", array(
            'quantity' => ($quant + $quantidade)
        ), array(
            'id' => $id
        ));
    }

    function insert_item_value($key, $a, $logado, $location_id)
    {
        return $this->db->insert("items_value", array(
            'item_id' => $key,
            'quantity' => $a,
            'trans_user' => $logado,
            'location_id' => $location_id
        ));
    }

    function insert_nfe($data)
    {
        return $this->db->insert("purch_nfe", $data);
    }

    function insert_nfe_itens($data)
    {
        return $this->db->insert("purch_nfe_itens", $data);
    }

    function exist_nfe_chave($chave)
    {
        $this->db->select("id");
        $this->db->from("purch_nfe");
        $this->db->where("chave", $chave);
        return $this->db->get()->num_rows();
    }

    function verifica_preco($id_produto)
    {
        $this->db->select("cost_of_last_purchase", "cost_purchese");
        $this->db->from("items_business");
        $this->db->where("item_id", $id_produto);
        return $this->db->get();
    }

    function create_preco($data)
    {
        return $this->db->insert('items_business', $data);
    }

    function seta_preco($data, $id_produto)
    {
        return $this->db->update("items_business", $data, array(
            'item_id' => $id_produto
        ));
    }

    function update_purch_nfe($data, $pedido)
    {
        return $this->db->update("purch_request", $data, array(
            'num_pedido' => $pedido
        ));
    }

    function get_contents_nfe($pedido)
    {
        $this->db->from('purch_nfe');
        $this->db->where('pedido', $pedido);
        return $this->db->get();
    }

    function fornecedor_getnumero($nome)
    {
        $this->db->select("suppliers_id");
        $this->db->from("suppliers");
        $this->db->where("fancy_name", $nome);
        return $this->db->get()->row()->suppliers_id;
    }
}

?>