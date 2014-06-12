<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer_model extends CI_Model{
	
  	public function customermaster_all(){
		$this->db->where('is_delete', 0);
		$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$query = $this->db->get('customer');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function customermaster_all_state(){
		$this->db->select('customer.*');
		$this->db->select('_ref_state.fldname');
	    $this->db->where('is_delete', 0);
	    $this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->from('customer');
		$this->db->join('_ref_state', '_ref_state.fldid = customer.customerStateID');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
public function customermaster_id($ID){
	    $this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
	    $this->db->where('ID', $ID);
		$query = $this->db->get('customer', 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	
	public function customermaster_insert($newuser){
		$sql = $this->db->insert_string('customer', $newuser);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}
	public function customermaster_edit($updateuser, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('customer', $updateuser); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function customermaster_delete($deletuser, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('customer', $ID); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	
		public function customermaster_allopt(){
		$this->db->select('ID');
		$this->db->select('customerName');
	    $this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('is_delete', 0);
		$query = $this->db->get('customer');
    	if($query->result()){
       		$result = $query->result();
        	return $result;
    	} 	
	}
}