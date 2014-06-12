<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Term_model extends CI_Model{
	
    public function term_all(){
	    $this->db->where('is_delete', 0);
		$query = $this->db->get('terms');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function term_id($ID){
		$query = $this->db->get_where('terms', array('ID'=>$ID), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function term_edit($updateterm, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('terms', $updateterm); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function term_insert($newterm){
		$sql = $this->db->insert_string('terms', $newterm);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}
	public function term_delete($deleteterm, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('terms', $deleteterm); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}

}