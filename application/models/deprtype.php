<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DeprType extends CI_Model{
	
	public function deprType_all(){
		$this->db->order_by('type');
		$query = $this->db->get('ast_depr_type');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function deprType_insert($newdept){
		$sql = $this->db->insert_string('ast_depr_type', $newdept);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}

	public function deprType_edit($updatedept, $fldid){
		$this->db->where('fldid', $fldid);
		$query = $this->db->update('ast_depr_type', $updatedept); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function deprType_id($id){
		$query = $this->db->get_where('ast_depr_type', array('fldid'=>$id), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function deprType_save($fldid, $data){
		$this->db->where('fldid', $fldid);
		$query = $this->db->update('ast_depr_type', $data); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	public function deprType_delete($fldid){
		$this->db->where('fldid', $fldid);
		$query = $this->db->delete('ast_depr_type'); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
}