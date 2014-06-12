<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Compjlseq extends CI_Model{
	
	public function compjlseq_yearperiod( $module, $initial, $year, $period ){
		$this->db->where('compID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('moduleID', $module);
		$this->db->where('initial', $initial);
		$this->db->where('year', $year);
		$this->db->where('period', $period);
		$query = $this->db->get('comp_jl_seq');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function compjlseq_insert($newdata){
		$query = $this->db->insert('comp_jl_seq', $newdata);
		if($query){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	public function compjlseq_update($data, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('comp_jl_seq', $data); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

