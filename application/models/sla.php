<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sla extends CI_Model{
	
	public function sla_all(){
		$query = $this->db->get('tbl_sla');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function sla_insert($newsla){
		$sql = $this->db->insert_string('tbl_sla', $newsla);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}

	public function sla_edit($updatesla, $fldid){
		$this->db->where('fldid', $fldid);
		$query = $this->db->update('tbl_sla', $updatesla); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function sla_id($id){
		$query = $this->db->get_where('tbl_sla', array('fldid'=>$id), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function sla_delete($fldid){
		$this->db->where('fldid', $fldid);
		$query = $this->db->delete('tbl_sla'); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function sla_map($category,$type,$reason,$priority){
		$query = $this->db->get_where('tbl_sla', array('category'=>$category,'type'=>$type,'reason'=>$reason,'priority'=>$priority), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
}