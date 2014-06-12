<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Address_model extends CI_Model{
	
    public function address_all(){
	     $this->db->where('is_delete', 0);
		$query = $this->db->get('comp_address');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
    public function address_company_all($companyid){
		$this->db->select('comp_address.*');
		$this->db->select('_ref_state.fldname');
		$this->db->select('_ref_country.fldcountry');
	    $this->db->where('companyID', $companyid);
	    $this->db->where('is_delete', 0);
		$this->db->from('comp_address');
		$this->db->join('_ref_state', '_ref_state.fldid = comp_address.stateID');
		$this->db->join('_ref_country', '_ref_country.fldid = comp_address.countryID');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function address_id($ID){
		$query = $this->db->get_where('comp_address', array('ID'=>$ID), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	public function address_companyID($ID){
		$query = $this->db->get_where('comp_address', array('companyID'=>$ID), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function address_edit($editaddress, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('comp_address', $editaddress); 
		//echo $this->db->last_query();
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function address_insert($newaddress){
		$sql = $this->db->insert_string('comp_address', $newaddress);
		$query = $this->db->query($sql);
		//echo $this->db->last_query();
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}
	public function addressShipToList_delete($delete, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('comp_address', $delete); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}

}