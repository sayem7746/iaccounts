<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee_model extends CI_Model{
	
	  	public function employeemaster_all(){
		$this->db->where('is_delete', 0);
		$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$query = $this->db->get('comp_employee');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	public function employeemaster_insert($newuser){
		$sql = $this->db->insert_string('comp_employee', $newuser);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}
	public function employeemaster_edit($updateuser, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('comp_employee', $updateuser); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function employeemaster_delete($deletuser, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('comp_employee', $deletuser); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function employeemaster_id($ID){
	    $this->db->where('ID', $ID);
		$query = $this->db->get('comp_employee', 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
		public function employeemaster_allopt(){
		$this->db->select('ID');
		$this->db->select('employeeName');
	    //$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('is_delete', 0);
		$this->db->order_by('employeeName');
		$query = $this->db->get('comp_employee');
    	if($query->result()){
       		$result = $query->result();
        	return $result;
    	} 	
	}
}