<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sysum extends CI_Model{
	
	public function sysum_all(){
		$query = $this->db->get('_sys_um');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function sysum_insert($newdept){
		$sql = $this->db->insert_string('_sys_um', $newdept);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}

	public function sysum_edit($updatedept, $fldid){
		$this->db->where('fldid', $fldid);
		$query = $this->db->update('_sys_um', $updatedept); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function sysum_id($id){
		$query = $this->db->get_where('_sys_um', array('fldid'=>$id), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function sysum_save($fldid, $data){
		$this->db->where('fldid', $fldid);
		$query = $this->db->update('_sys_um', $data); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	public function sysum_delete($fldid){
		$this->db->where('fldid', $fldid);
		$query = $this->db->delete('_sys_um'); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}

}