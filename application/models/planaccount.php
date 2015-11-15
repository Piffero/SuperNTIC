<?php
class PlanAccount extends CI_Model
{	
	/*
	Determina se um determinado planaccount_id existe
	*/
	function exists($planaccount_id)
	{
		$this->db->from('plan_account_sped');			
		$this->db->where('id',$planaccount_id);
		$query = $this->db->get();
		
		return ($query->num_rows()==1);
	}
	
	
	/*
	Retorna todos os Apontamentos
	*/
	function get_all()
	{
		$this->db->from('plan_account_sped');
		$this->db->where('deleted',0);
		$this->db->order_by("codigo", "asc");
		return $this->db->get();		
	}
	
	function get_category()
	{
		$this->db->from('plan_account_sped');
		$this->db->where('tipo','S');
		$this->db->where('deleted',0);
		$this->db->order_by("codigo", "asc");
		return $this->db->get();		
	}
	
	function get_notcategory()
	{
		$this->db->from('plan_account_sped');
		$this->db->where('tipo','A');
		$this->db->where('deleted',0);
		$this->db->order_by("codigo", "asc");
		return $this->db->get();		
	}
	
		
	function count_all(&$codigo_pai)
	{
		$this->db->from('plan_account_sped');
		$this->db->where('codigo_pai', $codigo_pai);
		$this->db->where('deleted',0);
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	/*
	Obt�m informa��es sobre um determinado Apontamento
	*/
	function get_info($planaccount_id)
	{
		$this->db->from('plan_account_sped');
		$this->db->where('id',$planaccount_id);
		$query = $this->db->get();
		
		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			//criar o objeto com propriedades vazias
			$fields = $this->db->list_fields('plan_account_sped');
			$planaccount_obj = new stdClass;
			
			//anexar esses campos ao objeto pai de base, n�s temos um objeto completo e vazio
			foreach ($fields as $field)
			{
				$planaccount_obj->$field='';
			}
			
			return $planaccount_obj;
		}
	}
	
	
	/*
	Obtém informações sobre vários Apontamentos
	*/
	function get_multiple_info($planaccount_ids)
	{
		$this->db->from('plan_account_sped');
		$this->db->where_in('id',$planaccount_ids);
		$this->db->order_by("codigo", "asc");
		return $this->db->get();		
	}
	
	
	/*
	Execute essas consultas como uma transação, nas queremos ter certeza de que fazemos tudo ou nada
	*/
	function save(&$planaccount_data,$planaccount_id=false)
	{
		$success=false;
		
		if($planaccount_data && $planaccount_id)
		{		
			if (!$planaccount_id or !$this->exists($planaccount_id))
			{					
				$success = $this->db->insert('plan_account_sped',$planaccount_data);
			}
			else
			{
				$this->db->where('id', $planaccount_id);
				$success = $this->db->update('plan_account_sped',$planaccount_data);
			}
		}
		
		return $success;
	}
	
	/*
	Deleta um Apontamento
	*/
	function delete($planaccount_id)
	{
		$this->db->where('id', $planaccount_id);
		return $this->db->update('plan_account_sped', array('deleted' => 1));
	}
	
	/*
	Deleta uma lista de Apontamentos
	*/
	function delete_list($planaccount_ids)
	{
		$this->db->where_in('id',$planaccount_ids);
		return $this->db->update('plan_account_sped', array('deleted' => 1));
 	}
 	
	
	/*
	Busca de Auta Performace para Apontametos
	*/
	function search($search)
	{
		$this->db->from('plan_account_sped');
		$this->db->where("(codigo LIKE '%".$this->db->escape_like_str($search)."%' or 
		descricao LIKE '%".$this->db->escape_like_str($search)."%'and deleted=0)");			
		$this->db->order_by("codigo", "asc");
		
		return $this->db->get();	
	}
	
}
?>
