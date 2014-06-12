<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Taxgroup extends CI_Model{
	
	public function taxgroup_all(){
		$query = $this->db->get('tax_group');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function taxgroup_insert($newdept){
		$sql = $this->db->insert_string('tax_group', $newdept);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}

	public function taxgroup_edit($updatedept, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('tax_group', $updatedept); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function taxgroup_id($id){
		$query = $this->db->get_where('tax_group', array('ID'=>$id), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function taxgroup_delete($ID){
		$this->db->where('ID', $ID);
		$query = $this->db->delete('tax_group'); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	public function taxgroup_save($id, $data){
		$this->db->where('ID', $id);
		$query = $this->db->update('tax_group', $data); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
}