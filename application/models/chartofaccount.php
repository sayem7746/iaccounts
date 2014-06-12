<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chartofaccount extends CI_Model{
	
	public function chartofaccount_all( ){
		$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->order_by('acctGroupID');
		$this->db->order_by('acctCode');
		$query = $this->db->get('comp_chart_of_acct');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	//Check wheather show dropdown or not
	public function isShowDropdown($compID){
		$query1 = $this->db
					->select('*')
					->from('comp_chart_of_acct')
					->where(array('companyID'=>$compID))
					->get();
					
		$query2 = $this->db
					->select('*')
					->from('comp_journal_detail')
					->where(array('companyID'=>$compID))
					->get();
					
		return ($query1->num_rows() && $query2->num_rows())?false:true;
	}
	
	//Gather business type information
	public function getInfo($id,$acctClass){
		$query = $this->db->distinct()
			->select('cacc.ID,cacc.acctCode,cacc.acctName,accGrp.acctGroupName,accType.acctTypeName')
			->from('comp_chart_of_acct as cacc')
			->join('comp_acct_group as accGrp','accGrp.ID = cacc.acctGroupID','left')
			->join('comp_acct_type as accType','accType.ID = accGrp.acctTypeID','left')
			->where(array('accType.acctClass'=>$acctClass,'cacc.companyID'=>$id))
			->get();
			
		if($this->db->affected_rows() >=1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	//Gather industry and type of business information
	public function getdata($id){
		$query = $this->db
			->select('i.ID as indusID,i.name as indusName,biz.ID as bizID,biz.name as bizName')
			->from('_ref_industry as i')
			->join('_ref_business_type as biz','biz.industryID = i.ID','left')
			->order_by('biz.ID','ASC')
			->get();
		return $query->result();
	}
	
	//Gather business type information
	public function getTypedata($id,$acctClass){
		$query = $this->db->distinct()
			->select('cacc.ID,cacc.acctCode,cacc.acctName,accGrp.acctGroupName,accType.acctTypeName')
			->from('_ref_chart_of_acct as cacc')
			->join('_ref_acct_group as accGrp','accGrp.ID = cacc.acctGroupID','left')
			->join('_ref_acct_type as accType','accType.ID = accGrp.acctTypeID','left')
			->where(array('accType.acctClass'=>$acctClass,'cacc.businessTypeID'=>$id))
			->get();
			
		if($this->db->affected_rows() >=1){
			return $query->result();
		}else{
			return false;
		}
	}
}

