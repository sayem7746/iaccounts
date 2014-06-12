<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Taxclass extends CI_Model{
	
	public function taxclass_all(){
		$query = $this->db->get('tax_class');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function taxclass_insert($newdept){
		$sql = $this->db->insert_string('tax_class', $newdept);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}

	public function taxclass_edit($updatedept, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('tax_class', $updatedept); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function taxclass_id($id){
		$query = $this->db->get_where('tax_class', array('ID'=>$id), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function taxclass_delete($ID){
		$this->db->where('ID', $ID);
		$query = $this->db->delete('tax_class'); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function taxclass_save($id, $data){
		$this->db->where('ID', $id);
		$query = $this->db->update('tax_class', $data); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
}