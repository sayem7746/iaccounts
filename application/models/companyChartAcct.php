<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CompanyChartAcct extends CI_Model{
	
	public function chartAcct_all(){
		$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('is_delete', '');
		$this->db->order_by('acctCode', 'desc');
		$this->db->order_by('acctName', 'desc');
		$query = $this->db->get('comp_chart_of_acct');		
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function chartAcct_allexpenses(){
		$this->db->select('a.*');
		$this->db->where('a.companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('is_delete', '');
		$this->db->where('b.acctTypeID', '4');
		$this->db->order_by('acctCode');
		$this->db->order_by('acctName', 'desc');
		$this->db->from('comp_chart_of_acct a');
		$this->db->join('comp_acct_group b', 'a.acctGroupID = b.ID');
		$query = $this->db->get();		
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function chartAcct_all_asc(){
		$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('is_delete', '');
		$this->db->order_by('acctCode');
		$this->db->order_by('acctName');
		$query = $this->db->get('comp_chart_of_acct');		
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function chartAcct_group_all_group(){
		$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('is_delete', '');
		$this->db->order_by('acctGroupID');
		$this->db->order_by('acctCode');
		$query = $this->db->get('comp_chart_of_acct');		
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function chartAcct_group_all_(){
		$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('is_delete', '');
		$this->db->order_by('acctCode');
		$query = $this->db->get('comp_chart_of_acct');		
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function chartAcctInsert($newAcctCode){
		$sql = $this->db->insert_string('comp_chart_of_acct', $newAcctCode);
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
		$query = $this->db->update('comp_chart_of_acct', $update_acctCode); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function chartAcct_id($id){
		$query = $this->db->get_where('comp_chart_of_acct', array('ID'=>$id), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	public function chartAcctDelete($deletuser, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('comp_chart_of_acct', $deletuser); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
}