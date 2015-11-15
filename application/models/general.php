<?php

class General extends CI_Model
{

	/**
	 * Seleciona tudo da tabela especificada no parâmetro
	 *
	 * @param mixed $values        	
	 * @param string $table        	
	 * @param mixed $where        	
	 * @param mixed $min        	
	 * @param mixed $max        	
	 * @return mixed
	 */
	public function select($values='*', $table, $where=NULL, $min=NULL, $max=NULL, $order_by=NULL, $asc_desc=NULL)
	{
		$this->db->select($values);
		$this->db->from($table);
		if ($where != NULL)
		{
			$this->db->where($where);
		}
		if ($order_by != NULL)
		{
			$this->db->order_by($order_by, $asc_desc);
		}
		if ($min != NULL)
		{
			return $this->db->get($table, $min, $max);
		}
		else
		{
			return $this->db->get();
		}
	}

	/**
	 * Seleciona tudo da tabela especificada no parâmetro
	 *
	 * @param mixed $values        	
	 * @param string $table        	
	 * @param mixed $where        	
	 * @param mixed $min        	
	 * @param mixed $max        	
	 * @return object
	 */
	public function select2($values = '*', $table, $where = NULL, $order_by = NULL, $asc_desc = NULL, $min = NULL, $max = NULL)
	{
		$this->db->select($values);
		$this->db->from($table);
		if ($where != NULL)
		{
			$this->db->where($where);
		}
		if ($order_by != NULL)
		{
			$this->db->order_by($order_by, $asc_desc);
		}
		if ($min != NULL)
		{
			return $this->db->get($table, $min, $max);
		}
		else
		{
			return $this->db->get();
		}
	}

	/**
	 * Atualiza a tabela do parâmetro especificado
	 *
	 * @param string $table        	
	 * @param array $values        	
	 * @return boolean
	 */
	public function update($table, $values, $where = "1")
	{
		return $this->db->update($table, $values, $where);
	}

	/**
	 * Insere os valores na tabela especificada no parâmetro
	 *
	 * @param unknown $table        	
	 * @param unknown $values        	
	 * @return mixed
	 */
	public function insert($table, $values)
	{
		return $this->db->insert($table, $values);
	}

	/**
	 * Deleta a linha da tabela especificada
	 *
	 * @param string $table        	
	 * @param mixed $where        	
	 * @return mixed
	 */
	public function delete($table, $where)
	{
		return $this->db->delete($table, $where);
	}

	/**
	 * Seleciona o valor máximo do campo da tabela especificada
	 *
	 * @param string $campo        	
	 * @param string $alias        	
	 * @param string $table        	
	 * @param array $where        	
	 * @return mixed
	 */
	public function max($campo, $alias, $table, $where = 1)
	{
		$this->db->select_max($campo, $alias);
		$this->db->from($table);
		$this->db->where($where);
		return $this->db->get();
	}

	/**
	 * Seleciona o valor mínimo do campo da tabela especificada
	 *
	 * @param string $campo        	
	 * @param string $alias        	
	 * @param string $table        	
	 * @param array $where        	
	 * @return mixed
	 */
	public function min($campo, $alias, $table, $where)
	{
		$this->db->select_min($campo, $alias);
		$this->db->from($table);
		$this->db->where($where);
		return $this->db->get();
	}

	/**
	 * Verifica se os campos $where existem na tabela, se existir atualiza, senão a função cria.
	 *
	 * @param array $values        	
	 * @param string $table        	
	 * @param mixed $where        	
	 * @return boolean
	 */
	public function update_or_insert($values, $table, $where = array(1=>1))
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where);
		
		if ($this->db->get()->num_rows() == 0)
		{
			return $this->db->insert($table, $values);
		}
		else
		{
			return $this->db->update($table, $values, $where);
		}
	}

	/**
	 * Faz a soma dos resultados do campo da tabela do Banco de Dados pelos parâmetros especificados e retorna o "alias"
	 *
	 * @param string $campo        	
	 * @param string $alias        	
	 * @param string $from        	
	 * @param string $where        	
	 */
	public function sum($campo, $alias, $from, $where = NULL)
	{
		$this->db->select_sum($campo, $alias);
		$this->db->from($from);
		if (isset($where))
		{
			$this->db->where($where);
		}
		return $this->db->get();
	}
}