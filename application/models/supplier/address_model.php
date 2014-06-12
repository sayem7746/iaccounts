<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Address_model extends CI_Model{
	
    public function address_all(){
	     $this->db->where('is_delete', 0);
		$query = $this->db->get('supplier_address');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
    public function address_supplier_all($supplierid){
		$this->db->select('supplier_address.*');
		$this->db->select('_ref_state.fldname');
		$this->db->select('_ref_country.fldcountry');
	    $this->db->where('supplierID', $supplierid);
	    $this->db->where('is_delete', 0);
		$this->db->from('supplier_address');
		$this->db->join('_ref_state', '_ref_state.fldid = supplier_address.stateID');
		$this->db->join('_ref_country', '_ref_country.fldid = supplier_address.countryID');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function address_id($ID){
		$query = $this->db->get_where('supplier_address', array('ID'=>$ID), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	public function address_supplierID($ID){
		$query = $this->db->get_where('supplier_address', array('supplierID'=>$ID), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function address_edit($editaddress, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('supplier_address', $editaddress); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function address_insert($newaddress){
		$sql = $this->db->insert_string('supplier_address', $newaddress);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}
	public function address_delete($delete, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('supplier_address', $delete); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}

}