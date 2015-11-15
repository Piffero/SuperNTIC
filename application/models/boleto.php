<?php

class Boleto extends CI_Model
{

	public function get_banks()
	{
		return $this->db->query("SELECT `id`, `bank_id`, `cod_bank`, `name` 
			FROM `ntic_banco_sis` 
			WHERE `account` != '' 
			AND `agency` != ''");
	}

	function search($situacao = '', $vencimento = '', $patient_id = '', $bank_id = '')
	{
		$this->db->from("boletos");
		
		if (! empty($situacao))
		{
			$this->db->where(array(
				
				"situacao" => $situacao
			));
		}
		if (! empty($vencimento)) // converter no controllers para "Y-m-d"
		{
			$this->db->where(array(
				
				"vencimento" => $vencimento
			));
		}
		if (! empty($patient_id))
		{
			$this->db->where(array(
				
				"patient_id" => $patient_id
			));
		}
		if (! empty($bank_id))
		{
			$this->db->where(array(
				
				"bank_id" => $bank_id
			)); // convereter com o $bank_id com str_pad
		}
		
		return $this->db->get();
	}

	private function searchBank($bank_name)
	{
		return $this->db->query("SELECT `code_bank` FROM `ntic_banco_sis` WHERE `name` LIKE '%$bank_name%'");
	}

	public function get_patients()
	{
		$this->db->select("patient_id");
		$this->db->distinct();
		$this->db->from("boletos");
		return $this->db->get();
	}

	public function get_boleto_banks()
	{
		$this->db->select("bank_id");
		$this->db->distinct();
		$this->db->from("boletos");
		return $this->db->get();
	}
}