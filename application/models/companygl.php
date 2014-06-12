<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Companygl extends CI_Model{
	
	public function chartAcct_all(){
		$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->order_by('acctID');
		$query = $this->db->get('comp_gl');		
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	public function chartAcct_group_all($add_year, $add_period){
		$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('year', $add_year);
		$this->db->where('period', $add_period);
		$this->db->order_by('acctCode');
		$query = $this->db->get('comp_gl');		
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function chartAcctInsert($newAcctCode){
		$sql = $this->db->insert_string('comp_gl', $newAcctCode);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}

	public function chartAcct_edit($update_acctCode, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('comp_gl', $update_acctCode); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function chartAcct_id($id){
		$query = $this->db->get_where('comp_gl', array('ID'=>$id), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	public function chartAcctDelete($deletuser, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('comp_gl', $deletuser); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
}