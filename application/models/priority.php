<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Priority extends CI_Model{
	
	public function priority_all(){
		$query = $this->db->get('tbl_priority');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}

	public function priority_insert($newpriority){
		$sql = $this->db->insert_string('tbl_priority', $newpriority);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}

	public function priority_edit($updatepriority, $fldid){
		$this->db->where('fldid', $fldid);
		$query = $this->db->update('tbl_priority', $updatepriority); 
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}

	public function priority_id($fldid){
		$query = $this->db->get_where('tbl_priority', array('fldid'=>$fldid), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}
	
	public function priority_delete($fldid){
		$this->db->where('fldid', $fldid);
		$query = $this->db->delete('tbl_priority'); 
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}
	
}