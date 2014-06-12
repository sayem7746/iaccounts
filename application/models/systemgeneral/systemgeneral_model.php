<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class systemgeneral_model extends CI_Model{
	
    public function sysgetall_bycompanyID(){
		//update record to readonly if transaction exist in journal 
		$sql = 'update comp_control_acct_setup set updateable = 0 where companyID = '. element('compID', $this->session->userdata('logged_in'));
		$sql .= ' and updateable = 1 ';
		$sql .= ' and accountid in (select distinct acctCode from comp_journal_detail where companyid = '.element('compID', $this->session->userdata('logged_in'));
		$sql .= ' )';
		$this->db->query($sql); 
		$this->db->select('ID,accountCode,updateable,accountID');
		$this->db->order_by('ID');
	     $this->db->where('is_delete', 0);
		 $this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		 $query = $this->db->get('comp_control_acct_setup');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			//no data. insert from system default ref. 
			$sql = 'insert into comp_control_acct_setup (companyID, accountCode,createdby)  select '.element('compID', $this->session->userdata('logged_in')).',name,1 from master_code where masterID = 21';
			$this->db->query($sql);
			echo $this->db->last_query(); 
			$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
			$query = $this->db->get('comp_control_acct_setup');
			
			return $query->result();
		}
	}
	
	public function get_byCode($Code){
	  $this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
	    $this->db->where('accountCode', $Code);
		$query = $this->db->get('comp_control_acct_setup', 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	//Function to check if transaction exist.
	public function get_if_transactin_exist($accountID){ 
	  $this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('acctID', $accountID);
		$query = $this->db->get('comp_acc_det', 1);		
		if($query->num_rows() > 0)
		{
			return true;
		}else{
			return false;
		}
	}
	
	//Function to check if record exist.
	public function get_if_record_exist($accountCode){ 
	  $this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('accountCode', $accountCode);
		$query = $this->db->get('comp_control_acct_setup', 1);		
		if($query->num_rows() > 0)
		{
			return true;
		}else{
			return false;
		}
	}
	
	public function sysupdate_byID($ID, $data){
		$this->db->where('ID', $ID);
		$query = $this->db->update('comp_control_acct_setup', $data); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function updateAccountCode($dataUpdate) {
		$this->db->set('accountID',$dataUpdate[0]);
		$this->db->where('ID',$dataUpdate[2]);
		$this->db->update('comp_control_acct_setup');
		return;
	}
	
	public function syssave($dataupdate){
		//check if record exist = update else insert
		$exist = $this->get_if_record_exist($accountCode);
		if ($exist) {
			$this->db->where('ID', $ID);
			$query = $this->db->update('comp_control_acct_setup', $dataupdate); 
		} else{
			$sql = $this->db->insert_string('comp_control_acct_setup', $dataupdate);
			$query = $this->db->query($sql);		
		}		
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
 
}