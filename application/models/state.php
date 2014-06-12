<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class State extends CI_Model{
	
	public function state_all(){
		$this->db->order_by('fldregion_id');
		$this->db->order_by('fldname');
		$query = $this->db->get('_ref_state');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function state_id($id){
		$query = $this->db->get_where('_ref_state', array('fldid'=>$id), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}

	public function state_region($id){
		$this->db->order_by('fldregion_id');
		$this->db->order_by('fldname');
		$query = $this->db->get_where('_ref_state', array('fldregion_id'=>$id));		
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return $this->db->last_query();
		}
	}
	
	public function state_save($fldid, $data){
		$this->db->where('fldid', $fldid);
		$query = $this->db->update('_ref_state', $data); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function state_delete($fldid){
		$this->db->where('fldid', $fldid);
		$query = $this->db->delete('_ref_state'); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
}