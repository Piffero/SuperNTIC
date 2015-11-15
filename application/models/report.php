<?php
class Report extends CI_Model 
{
	function contas($ini, $fim, $favored="all", $operation=NULL, $historic='all', $del=NULL, $location='all')
	{
		$this->db->select("*");
		$this->db->from("accounts");
		$this->db->where("date >=", $ini);
		$this->db->where("date <=", $fim);
		
		if ($del != NULL) 
		{
			$this->db->where(array("deleted"=>$del));
		}
		
		if ($operation != NULL) 
		{
			$this->db->where(array("operation"=>$operation));
		}
		
		if ($favored != "all")
		{
			$this->db->where(array("favored"=>$favored));
		}
		
		if ($historic != 'all') 
		{
			$this->db->where(array("historic"=>$historic));
		}
		
		if ($location != 'all') 
		{
			$this->db->where(array('location_id'=>$location));
		}
		
		$this->db->order_by("date", "asc");
		return $this->db->get()->result_array();
	}
	
	function itens($ini, $fim, $favored="all", $location="all") 
	{
		//$this->db->query("select * from `sales_items` where `purchase_date` >= $ini and `purchase_dete` <= $fim");
		$this->db->select("*");
		$this->db->from("sales_items");
		$this->db->join("sales", "sales.order = sales_items.order_id");
		$this->db->where("purchase_date >=", $ini);
		$this->db->where("purchase_date <=", $fim);

		if ($location != 'all') 
		{
			$this->db->where(array('location_id'=>$location));
		}
		
		if ($favored != "all")
		{
			$this->db->where(array("patient_id"=>$favored));
		}
		
		$this->db->order_by("purchase_date", "asc");
		return $this->db->get()->result_array();
	}
	
	function compras($DI, $DF, $del=0, $local='all', $fornecedor='all') 
	{
		$this->db->select("*");
		$this->db->from("purch_request");
		$this->db->where("data >=", $DI.' 00:00:00');
		$this->db->where("data <=", $DF.' 00:00:00');
		$this->db->where("deleted", $del);
		
		if ($fornecedor != 'all') 
		{
			$this->db->where("fornecedor", $fornecedor);
		}
		
		if ($local != 'all') 
		{
			$this->db->where("location_id", $local);
		}
		
		$this->db->order_by("data", "asc");
		return $this->db->get()->result_array();
	}
	
	function os($DI, $DF, $situacao, $local='all') 
	{
		$this->db->select("*");
		$this->db->from("os");
		$this->db->where("DTABERTURA >=", $DI.' 00:00:00');
		
		if ($situacao == "Finalizada") 
		{
			$this->db->where("SITUACAO", "Finalizada");
			$this->db->where("DTFECHAMENTO >", "0000-00-00 00:00:00");
		}
		elseif ($situacao == "Cancelada")
		{
			$this->db->where("SITUACAO", "Finalizada");
			$this->db->where("DTFECHAMENTO", "0000-00-00 00:00:00");
		}
		else
		{
			$this->db->where("SITUACAO !=", "Finalizada");
			$this->db->where("DTFECHAMENTO", "0000-00-00 00:00:00");
		}
		
		if ($local != "all")
		{
			$this->db->where("location_id", $local);
		}
		
		$this->db->order_by("DTABERTURA", "asc");
		return $this->db->get()->result_array();
	}
	
	function consultas($DI, $DF, $tipo, $del=0, $enterprise="all")
	{
		$this->db->select("*");
		$this->db->from("appointment");
		$this->db->where("appointment >=", $DI);
		$this->db->where("appointment <=", $DF);
		
		if ($tipo == "consulta") 
		{
			$this->db->where("point_type", 0);
		}
		elseif ($tipo == "acompanhamento")
		{
			$this->db->where("point_type", 1);
		}
		
		if ($enterprise != "all")
		{
			$this->db->where("location_id", $enterprise);
		}
		
		$this->db->where("deleted", $del);
		$this->db->order_by("appointment", "asc");
		
		return $this->db->get()->result_array();
	}
	
	function teste($DI, $DF, $refer, $enterprise="all", $local="all")
	{
		$this->db->select("*");
		$this->db->from("items_serie");
		$this->db->where("trans_date >=", $DI);
		$this->db->where("trans_date <=", $DF);
		
		if ($enterprise != "all")
		{
			$this->db->where("location_id", $enterprise);
		}

		if ($local != 'all')
		{
			$this->db->where("stock_local", $local);
		}

		$this->db->order_by("id", "asc");
		return $this->db->get()->result_array();
	}
	
	/**
	 * Não Serializados
	 * @param string $DI
	 * @param string $DF
	 * @param string $refer
	 * @param string $enterprise
	 */
	function itens_estoque($DI, $DF, $refer="all", $enterprise="all")
	{
		$this->db->from("items_value");
		$this->db->where("trans_date >=", $DI.' 00:00:00');
		$this->db->where("trans_date <=", $DF.' 00:00:00');
		
		if ($enterprise != "all") 
		{
			$this->db->where("location_id", $enterprise);
		}
		
		$this->db->order_by("trans_date", "asc");
		return $this->db->get()->result_array();
	}
	
	/**
	 * Serializados
	 * @param unknown $DI
	 * @param unknown $DF
	 * @param string $refer
	 * @param string $enterprise
	 */
	function itens_Sestoque($DI, $DF, $refer="all", $enterprise="all")
	{
		$this->db->from("items_serie");
		$this->db->where("trans_date >=", $DI.' 00:00:00');
		$this->db->where("trans_date <=", $DF.' 00:00:00');
	
		if ($enterprise != "all")
		{
			$this->db->where("location_id", $enterprise);
		}
	
		$this->db->order_by("trans_date", "asc");
		return $this->db->get()->result_array();
	}
	
}