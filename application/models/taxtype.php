<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Taxtype extends CI_Model{
	
	public function taxtype_all(){
		$query = $this->db->get('tax_type');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function taxtype_insert($newdept){
		$sql = $this->db->insert_string('tax_type', $newdept);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}

	public function taxtype_edit($updatedept, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('tax_type', $updatedept); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function taxtype_id($id){
		$query = $this->db->get_where('tax_type', array('ID'=>$id), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function taxtype_delete($ID){
		$this->db->where('ID', $ID);
		$query = $this->db->delete('tax_type'); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function taxtype_byTaxGroup($taxGroupID){
		$this->db->where('taxGroupID', $taxGroupID);
		$query = $this->db->get('tax_type');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
}