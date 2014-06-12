<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accmaster extends CI_Model{
	
	public function accmaster_all(){
		$this->db->order_by('fldac_code');
		$query = $this->db->get('fin_acmaster');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function accmaster_save($fldid, $data){
		$this->db->where('fldid', $fldid);
		$query = $this->db->update('fin_acmaster', $data); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function accmaster_delete($fldid){
		$this->db->where('fldid', $fldid);
		$query = $this->db->delete('fin_acmaster'); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
}