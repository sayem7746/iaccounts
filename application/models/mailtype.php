<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mailtype extends CI_Model{
	
	public function mailtype_all(){
		$query = $this->db->get('mlt_mailtype');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function mailtype_insert($newmail){
		$sql = $this->db->insert_string('mlt_mailtype', $newmail);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}

	public function mailtype_edit($newmail, $code){
		$this->db->where('code', $code);
		$query = $this->db->update('mlt_mailtype', $newmail); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function mailtype_id($code){
		$query = $this->db->get_where('mlt_mailtype', array('code'=>$code), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function mailtype_delete($code){
		$this->db->where('code', $code);
		$query = $this->db->delete('mlt_mailtype'); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
}