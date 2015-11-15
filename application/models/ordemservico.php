<?php

class OrdemServico extends CI_Model
{

    /**
     * Verifica se existem os campos do número de série chamado
     * pela função check_nserie() da O.S.
     *
     * @param string $nserie            
     */
    function exists($nserie)
    {
        $this->db->from("patient_itens");
        $this->db->where("number_serie", $nserie);
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            $campos = $query->row();
            
            if ($campos->apparatus != NULL || $campos->apparatus != '' || $campos->apparatus != ' ') {
                if ($campos->maker != NULL || $campos->maker != '' || $campos->maker != ' ') {
                    if ($campos->model != NULL || $campos->model != '' || $campos->model != ' ') {
                        if ($campos->color != NULL || $campos->color != '' || $campos->color != ' ') {
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Busca todas as informações do Produto do cliente
     * para confirmar a quem se destinará a O.S.
     *
     * @param string $nserie            
     */
    function check_nserie($nserie)
    {
        if ($this->exists($nserie)) {
            $this->db->select("apparatus");
            $this->db->select("maker");
            $this->db->select("model");
            $this->db->select("color");
            $this->db->select("suppliers_data");
            $this->db->select("purchase_date");
            $this->db->select("patient_id");
            $this->db->from("patient_itens");
            $this->db->where("number_serie", $nserie);
            $result = $this->db->get();
            return $result->row();
        } else {
            return false;
        }
    }

    /**
     * Recolhe as informações do cliente de acordo com a pesquisa feita pelo
     * número de série do Aparelho, ao abrir a OS.
     *
     * @param integer $patient_id            
     */
    function get_cliente($patient_id)
    {
        $this->db->select("first_name");
        $this->db->select("last_name");
        $this->db->select("phone_home");
        $this->db->select("phone_work");
        $this->db->select("phone_cell");
        $this->db->select("phone_other");
        $this->db->select("phone_number");
        $this->db->select("email");
        $this->db->select("waives_terms");
        $this->db->from("patient");
        $this->db->where("patient_id", $patient_id);
        $row = $this->db->get();
        return $row->row();
    }

    /**
     * Insere os defeitos da OS
     *
     * @param array $data            
     */
    function insert_defects($data)
    {
        if ($this->db->insert('os_problems', $data)) {
            return true;
        } else {
            return false;
        }
    }

    function gera_os($data)
    {
        if ($this->db->insert("os", $data)) {
            return true;
        } else {
            return false;
        }
    }

    function last_os()
    {
        $this->db->select_max('idOS');
        $this->db->from("os");
        $row = $this->db->get();
        return $row->row();
    }

    function exist_os($nserie)
    {
        return $this->db->query("SELECT `idOS`, `SITUACAO` FROM (SELECT * FROM `ntic_os` WHERE `NSERIE` = '$nserie') AS `os` ORDER BY `idOS` DESC LIMIT 1");
    }

    function get_lista()
    {
        return $this->db->query("SELECT `ntic_os`.`idOS`, `ntic_os`.`SITUACAO`, `ntic_os`.`DTABERTURA`, 
		    `ntic_patient`.`first_name`, `ntic_patient`.`last_name`, 
		    `ntic_patient_itens`.`apparatus`, `ntic_patient_itens`.`maker`, `ntic_patient_itens`.`model`, `ntic_patient_itens`.`color` 
		    FROM `ntic_os`, `ntic_patient`, `ntic_patient_itens` 
		    WHERE `ntic_os`.`nserie` LIKE `ntic_patient_itens`.`number_serie` 
		    AND `ntic_patient`.`patient_id` LIKE `ntic_patient_itens`.`patient_id`
		    AND `ntic_os`.`SITUACAO` IN('Aberta','Concluida','Contactando','Em analise','Em andamento', 'Aprovada', 'Recusada', 'Fabrica') 
		    ORDER BY `ntic_os`.`idOS` ASC");
    }

    function last_situation($idOS)
    {
        $this->db->select("SITUACAO");
        $this->db->from("os");
        $this->db->where("idOS", $idOS);
        $query = $this->db->get();
        return $query->row();
    }

    function change_os_situation($idOS, $situacao)
    {
        $this->db->where("idOS", $idOS);
        return $this->db->update("os", array(
            'SITUACAO' => $situacao
        ));
    }

    function ocorrencia($ocorrencia)
    {
        $this->db->where("1");
        return $this->db->insert("os_ocorrencia", $ocorrencia);
    }

    function get_info($idOS)
    {
        return $this->db->query("SELECT `ntic_patient`.`first_name`, `ntic_patient`.`last_name`, `ntic_patient`.`phone_number`, `ntic_patient`.`phone_home`, `ntic_patient`.`phone_work`, `ntic_patient`.`phone_cell`, `ntic_patient`.`phone_other`, `ntic_patient`.`waives_terms`, `ntic_patient`.`email`,
		    `ntic_patient_itens`.`apparatus`, `ntic_patient_itens`.`maker`, `ntic_patient_itens`.`model`, `ntic_patient_itens`.`color`, `ntic_os`.`nserie`,
			`ntic_os`.`SITUACAO`, `ntic_os`.`DTABERTURA`
		    FROM `ntic_os`, `ntic_patient`, `ntic_patient_itens` 
		    WHERE `ntic_os`.`idOS` = '$idOS'
		    AND `ntic_os`.`nserie` LIKE `ntic_patient_itens`.`number_serie` 
		    AND `ntic_patient`.`patient_id` LIKE `ntic_patient_itens`.`patient_id`
		    ORDER BY `ntic_os`.`idOS` ASC");
    }

    function lista_ocorrencia($idOS)
    {
        $this->db->select('*');
        $this->db->from("os_ocorrencia");
        $this->db->where("idOS", $idOS);
        $this->db->order_by("data", "desc");
        $query = $this->db->get();
        return $query;
    }

    function delete_id($id)
    {
        return $this->db->delete('os_ocorrencia', array(
            'id' => $id
        ));
    }

    function get_defects($idOS)
    {
        $this->db->select("*");
        $this->db->from("os_problems");
        $this->db->where("idOS", $idOS);
        $query = $this->db->get();
        return $query;
    }

    function lancamento($data)
    {
        return $this->db->insert('os_lancamentos', $data);
    }

    function contato($data)
    {
        return $this->db->insert('os_contato', $data);
    }

    function cancela_os($data, $idOS)
    {
        $this->db->where("idOS", $idOS);
        return $this->db->update("os", $data);
    }

    function get_client_basic_infos($idOS)
    {
        return $this->db->query("SELECT `ntic_patient`.`first_name`, `ntic_patient`.`last_name`, `ntic_patient`.`document_cpf`, `ntic_patient`.`document_rg`,
		    `ntic_patient_itens`.`apparatus`, `ntic_patient_itens`.`maker`, `ntic_patient_itens`.`model`, `ntic_patient_itens`.`color`, `ntic_os`.`nserie`,
			`ntic_os`.`DTCONCLUSAO`
		    FROM `ntic_os`, `ntic_patient`, `ntic_patient_itens` 
		    WHERE `ntic_os`.`idOS` = '$idOS'
		    AND `ntic_os`.`nserie` LIKE `ntic_patient_itens`.`number_serie` 
		    AND `ntic_patient`.`patient_id` LIKE `ntic_patient_itens`.`patient_id`
		    ORDER BY `ntic_os`.`idOS` ASC");
    }

    function get_lancamentos_lista($idOS)
    {
        $this->db->select("valor");
        $this->db->select("data");
        $this->db->from("os_lancamentos");
        $this->db->where("idOS", $idOS);
        return $this->db->get();
    }

    function soma_ocorrencia($idOS)
    {
        $this->db->select_sum("valor");
        $this->db->from("os_ocorrencia");
        $this->db->where("idOS", $idOS);
        return $this->db->get();
    }

    function soma_lancamentos($idOS)
    {
        $this->db->select_sum("valor");
        $this->db->from("os_lancamentos");
        $this->db->where("idOS", $idOS);
        return $this->db->get();
    }

    function pay_os($data)
    {
        return $this->db->insert("accounts", $data);
    }

    function get_contact_lista($idOS)
    {
        $this->db->select("descricao");
        $this->db->select("data");
        $this->db->select("contatado");
        $this->db->from("os_contato");
        $this->db->where("idOS", $idOS);
        return $this->db->get();
    }

    function concluir_os($data, $idOS)
    {
        return $this->db->update("os", $data, array(
            'idOS' => $idOS
        ));
    }

    function get_laudo(&$idOS)
    {
        $this->db->select("laudo");
        $this->db->from("os");
        $this->db->where("idOS", $idOS);
        return $this->db->get();
    }

    function get_clients()
    {
        $this->db->select("first_name");
        $this->db->select("last_name");
        $this->db->from("patient");
        // $this->db->where(1);
        $this->db->order_by("first_name", "asc");
        return $this->db->get();
    }

    function search_by_client($nome, $sobrenome)
    {
        return $this->db->query("SELECT `ntic_patient`.`first_name`, `ntic_patient`.`last_name`, `ntic_os`.`idOS`, `ntic_os`.`DTABERTURA`, 
		    `ntic_patient_itens`.`apparatus`, `ntic_patient_itens`.`maker`, `ntic_patient_itens`.`model`, `ntic_patient_itens`.`color`, `ntic_os`.`nserie`,
			`ntic_os`.`DTFECHAMENTO`, `ntic_os`.`SITUACAO`, `ntic_os`.`DTCONCLUSAO`
		    FROM `ntic_os`, `ntic_patient`, `ntic_patient_itens` 
		    WHERE `ntic_patient`.`first_name` = '$nome' AND `ntic_patient`.`last_name` = '$sobrenome'
		    AND `ntic_os`.`nserie` LIKE `ntic_patient_itens`.`number_serie` 
		    AND `ntic_patient`.`patient_id` LIKE `ntic_patient_itens`.`patient_id`
		    ORDER BY `ntic_os`.`idOS` ASC");
    }

    function search_by_situacao($situacao)
    {
        return $this->db->query("SELECT `ntic_patient`.`first_name`, `ntic_patient`.`last_name`, `ntic_os`.`idOS`, `ntic_os`.`DTABERTURA`, 
		    `ntic_patient_itens`.`apparatus`, `ntic_patient_itens`.`maker`, `ntic_patient_itens`.`model`, `ntic_patient_itens`.`color`, `ntic_os`.`nserie`,
			`ntic_os`.`DTFECHAMENTO`, `ntic_os`.`SITUACAO`, `ntic_os`.`DTCONCLUSAO`
		    FROM `ntic_os`, `ntic_patient`, `ntic_patient_itens` 
		    WHERE `ntic_os`.`SITUACAO` = '$situacao'
		    AND `ntic_os`.`nserie` LIKE `ntic_patient_itens`.`number_serie` 
		    AND `ntic_patient`.`patient_id` LIKE `ntic_patient_itens`.`patient_id`
		    ORDER BY `ntic_os`.`idOS` DESC");
    }

    function search_by_cancelada($situacao)
    {
        return $this->db->query("SELECT `ntic_patient`.`first_name`, `ntic_patient`.`last_name`, `ntic_os`.`idOS`, `ntic_os`.`DTABERTURA`,
				`ntic_patient_itens`.`apparatus`, `ntic_patient_itens`.`maker`, `ntic_patient_itens`.`model`, `ntic_patient_itens`.`color`, `ntic_os`.`nserie`,
				`ntic_os`.`DTFECHAMENTO`, `ntic_os`.`SITUACAO`, `ntic_os`.`DTCONCLUSAO`
				FROM `ntic_os`, `ntic_patient`, `ntic_patient_itens`
				WHERE `ntic_os`.`SITUACAO` = 'Finalizada' AND `ntic_os`.`DTCONCLUSAO` = 0
				AND `ntic_os`.`nserie` LIKE `ntic_patient_itens`.`number_serie`
				AND `ntic_patient`.`patient_id` LIKE `ntic_patient_itens`.`patient_id`
				ORDER BY `ntic_os`.`idOS` DESC");
    }

    function search_by_finalizada($situacao)
    {
        return $this->db->query("SELECT `ntic_patient`.`first_name`, `ntic_patient`.`last_name`, `ntic_os`.`idOS`, `ntic_os`.`DTABERTURA`,
				`ntic_patient_itens`.`apparatus`, `ntic_patient_itens`.`maker`, `ntic_patient_itens`.`model`, `ntic_patient_itens`.`color`, `ntic_os`.`nserie`,
				`ntic_os`.`DTFECHAMENTO`, `ntic_os`.`SITUACAO`, `ntic_os`.`DTCONCLUSAO`
				FROM `ntic_os`, `ntic_patient`, `ntic_patient_itens`
				WHERE `ntic_os`.`SITUACAO` = 'Finalizada' AND `ntic_os`.`DTCONCLUSAO` > 0
				AND `ntic_os`.`nserie` LIKE `ntic_patient_itens`.`number_serie`
				AND `ntic_patient`.`patient_id` LIKE `ntic_patient_itens`.`patient_id`
				ORDER BY `ntic_os`.`idOS` DESC");
    }

    function get_empresa()
    {
        $this->db->from("enterprise");
        $this->db->where("enterprise_id", 1);
        return $this->db->get();
    }

    function get_tecnico()
    {
        $id = $this->Employeer->get_info($this->session->userdata('employees_id'))->employees_id;
        
        $this->db->select("first_name");
        $this->db->select("last_name");
        $this->db->from("employees");
        $this->db->where("employees_id", $id);
        return $this->db->get()->row();
    }

    function get_nserie($idOS)
    {
        $this->db->select("NSERIE");
        $this->db->from("os");
        $this->db->where("idOS", $idOS);
        return $this->db->get()->result_array()[0]["NSERIE"];
    }

    function atualizar_defects($lista, $idOS)
    {
        return $this->db->update("os_problems", $lista, array(
            'idOS' => $idOS
        ));
    }

    function enterprise_info()
    {
        $this->db->from('enterprise');
        $this->db->where("enterprise_id", 1);
        return $this->db->get();
    }
}

?>