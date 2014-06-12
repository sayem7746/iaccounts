<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class companyControlAcctSetup_model extends CI_Model{
	
	public function get_all(){
		$companyID = element('compID', $this->session->userdata('logged_in'));
		$this->db->where('companyID', $companyID);
		$query = $this->db->get('comp_control_acct_setup');		
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function get_byID($ID) {
		$this->db->where('ID', $ID);
		$query = $this->db->get('comp_control_acct_setup');		
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}

	
	public function get_byCode($accountCode) {
		$this->db->where('accountCode', $accountCode);
		$query = $this->db->get('comp_control_acct_setup');		
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}		
	}

	public function insert($newData){
		$companyID = element('compID', $this->session->userdata('logged_in'));
		$currentUser = element('role', $this->session->userdata('logged_in'));
		$sql = $this->db->insert_string('item', $newData);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}
	


} //end class
	?>