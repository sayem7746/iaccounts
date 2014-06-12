<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Location extends CI_Model{
	
	public function location_all(){
		$this->db->select('tbl_location.*');
		$this->db->select('_ref_state.fldname');
		$this->db->select('_ref_country.fldcountry');
		$this->db->from('tbl_location');
		$this->db->join('_ref_state', '_ref_state.fldid = tbl_location.state');
		$this->db->join('_ref_country', '_ref_country.fldid = tbl_location.country');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function location_insert($newrtg){
		$sql = $this->db->insert_string('tbl_location', $newrtg);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}

	public function location_edit($updatertg, $fldid){
		$this->db->where('fldid', $fldid);
		$query = $this->db->update('tbl_location', $updatertg); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function location_byCompany($comp){
		$query = $this->db->get_where('tbl_location', array('companyID'=>$comp), 1);		
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}
	
	
	public function location_id($id){
		$query = $this->db->get_where('tbl_location', array('fldid'=>$id), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function location_save($fldid, $data){
		$this->db->where('fldid', $fldid);
		$query = $this->db->update('tbl_location', $data); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function location_delete($fldid){
		$this->db->where('fldid', $fldid);
		$query = $this->db->delete('tbl_location'); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
}