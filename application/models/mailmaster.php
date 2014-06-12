<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mailmaster extends CI_Model{
	
	public function mail_all(){
		$query = $this->db->get('mlt_mail');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function mail_insert($newmail){
		$sql = $this->db->insert_string('mlt_mail', $newmail);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}

	public function mail_edit($newmail, $fldid){
		$this->db->where('fldid', $fldid);
		$query = $this->db->update('mlt_mail', $newmail); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function mail_id($id){
		$query = $this->db->get_where('mlt_mail', array('fldid'=>$id), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function mail_delete($fldid){
		$this->db->where('fldid', $fldid);
		$query = $this->db->delete('mlt_mail'); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
}