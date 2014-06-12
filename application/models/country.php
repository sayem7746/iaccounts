<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Country extends CI_Model{
	
	public function country_all(){
		$this->db->order_by('fldcountry');
		$query = $this->db->get('_ref_country');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function country_save($fldid, $data){
		$this->db->where('fldid', $fldid);
		$query = $this->db->update('_ref_country', $data); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function country_delete($fldid){
		$this->db->where('fldid', $fldid);
		$query = $this->db->delete('_ref_country'); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
}