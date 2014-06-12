<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Section extends CI_Model{
	
	public function section_all(){
		$query = $this->db->get('tbl_section');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function section_insert($newsec){
		$sql = $this->db->insert_string('tbl_section', $newsec);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}

	public function section_edit($updatesec, $fldid){
		$this->db->where('fldid', $fldid);
		$query = $this->db->update('tbl_section', $updatesec); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function section_id($id){
		$query = $this->db->get_where('tbl_section', array('fldid'=>$id), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function section_delete($fldid){
		$this->db->where('fldid', $fldid);
		$query = $this->db->delete('tbl_section'); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
}