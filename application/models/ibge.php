<?php

class Ibge extends CI_Model
{

    function get_ibge_uf()
    {
        $this->db->select('uf');
        $this->db->distinct();
        $this->db->from("ibge_uf");
        return $this->db->get();
    }

    function get_ibge_Mun($uf)
    {
        $this->db->from('ibge_mun');
        $this->db->where('uf', $uf);
        return $this->db->get();
    }

    function get_cMun($String)
    {
        $this->db->from('ibge_mun');
        $this->db->where('municipio', $String);
        $query = $this->db->get();
        return ($query->num_rows === 1) ? $query->result() : 'ERROR';
    }

    function exist_ncm($code)
    {
        $this->db->from('ncm');
        $this->db->where('ncm', $code);
        $query = $this->db->get();
        
        return ($query->num_rows === 1) ? true : false;
    }

    function lista_cfop()
    {
        $this->db->select("id_cfop, descricao");
        $this->db->from("cfop");
        return $this->db->get();
    }
}