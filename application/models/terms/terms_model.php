<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Terms_model extends CI_Model{
	
	public function terms_all(){
		$this->db->where('is_delete',0);
		$this->db->order_by('termName');
		$query = $this->db->get('terms');		
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}

	public function terms_id($id){
		$this->db->where('ID',$id);
		$this->db->where('is_delete',0);
		$query = $this->db->get('terms');		
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
			
	}
	
}