<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Department extends CI_Model{
	
	public function department_all(){
		$query = $this->db->get('tbl_department');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function department_insert($newdept){
		$sql = $this->db->insert_string('tbl_department', $newdept);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}

	public function department_edit($updatedept, $fldid){
		$this->db->where('fldid', $fldid);
		$query = $this->db->update('tbl_department', $updatedept); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function department_id($id){
		$query = $this->db->get_where('tbl_department', array('fldid'=>$id), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function department_delete($fldid){
		$this->db->where('fldid', $fldid);
		$query = $this->db->delete('tbl_department'); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
}