<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CompAcctGroup_model extends CI_Model{
	
	public function companyacctgroup_all( ){
		$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->order_by('acctTypeID');
		$this->db->order_by('acctGroupName');
		$query = $this->db->get('comp_acct_group');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function companyacctgroup_parentID( ){
		$where = "(acctTypeID = 1 OR acctTypeID = 2)";
		$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('parentID', 0);
		$this->db->where($where);
		$this->db->order_by('acctTypeID');
		$this->db->order_by('parentID');
		$this->db->order_by('orderNo');
		$query = $this->db->get('comp_acct_group');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	public function companyacctgroup_parentID_PNL( ){
		$where = "(acctTypeID = 3 OR acctTypeID = 4)";
		$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('parentID', 0);
		$this->db->where($where);
		$this->db->order_by('acctTypeID');
		$this->db->order_by('parentID');
		$this->db->order_by('orderNo');
		$query = $this->db->get('comp_acct_group');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	public function companyacctgroup_subID( ){
		$where = "(acctTypeID = 1 OR acctTypeID = 2)";
		$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('parentID !=', 0);
		$this->db->where($where);
		$this->db->order_by('acctTypeID');
		$this->db->order_by('parentID');
		$this->db->order_by('orderNo');
		$query = $this->db->get('comp_acct_group');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	public function companyacctgroup_subID_PNL( ){
		$where = "(acctTypeID = 3 OR acctTypeID = 4)";
		$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('parentID !=', 0);
		$this->db->where($where);
		$this->db->order_by('acctTypeID');
		$this->db->order_by('parentID');
		$this->db->order_by('orderNo');
		$query = $this->db->get('comp_acct_group');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function balancesheet_all(){
		$this->db->select('comp_chart_of_acct.*');
		$this->db->select('comp_acct_group.acctGroupName as acctGroupName');
		$this->db->select('comp_acct_group.parentID as parentID');
		$this->db->select('comp_acct_group.orderNo as orderNo');
		$this->db->where('comp_chart_of_acct.companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->order_by('orderNo');
		$this->db->order_by('parentID');
		$this->db->order_by('acctTypeID');
		$this->db->from('comp_chart_of_acct');
		$this->db->join('comp_acct_group', 'comp_acct_group.ID = comp_chart_of_acct.acctGroupID');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
}
/* End of file compAcctGroup_model.php */
/* Location: ./application/model/compAcctGroup_model.php */
/* Created : Yahaya Abdollah */
