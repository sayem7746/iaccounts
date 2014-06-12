<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Maildist extends CI_Model{
	
	public function maildist_all(){
		$query = $this->db->get('mlt_dist');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function maildist_insert($newmail){
		$sql = $this->db->insert_string('mlt_dist', $newmail);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}

	public function maildist_edit($newmail, $fldid){
		$this->db->where('fldid', $fldid);
		$query = $this->db->update('mlt_dist', $newmail); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function maildist_id($id){
		$query = $this->db->get_where('mlt_dist', array('fldid'=>$id), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function maildist_delete($fldid){
		$this->db->where('fldid', $fldid);
		$query = $this->db->delete('mlt_dist'); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
}