<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company_info_model extends CI_Model{
	
	public function companymaster_all_state(){
		$this->db->select('company.*');
		$this->db->select('_ref_state.fldname');
	    $this->db->where('is_delete', 0);
	    $this->db->where('ID', element('compID', $this->session->userdata('logged_in')));
		$this->db->from('company');
		$this->db->join('_ref_state', '_ref_state.fldid = company.companyStateID');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function companymaster_id($ID=0){
		//$ID = element('compID', $this->session->userdata('logged_in'));
	    $this->db->where('ID', $ID);
//		$this->db->select('gstRegisteredNo');
		$query = $this->db->get('company', 1);
		//echo $this->db->last_query();		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function companyInsert($newCompany){
		$sql = $this->db->insert_string('company', $newCompany);
		$query = $this->db->query($sql);
		if($query === TRUE){
			//return new companyid
			return $this->db->insert_id();
		} else {
//			$last_query = $this->db->last_query();
//			return $last_query;
			return false;
		}
	}
	
	
	public function company_all(){
		$this->db->where('is_delete', '');
		$query = $this->db->get('company');		
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	
	public function company_edit($updateuser, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('company', $updateuser); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function company_delete($deletuser, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('company', $deletuser); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function company_id($id){
		$query = $this->db->get_where('company', array('ID'=>$id), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function companyById($id){
		$sql='SELECT company.*, _ref_state.fldname, _ref_country.fldcountry
			  FROM  (company LEFT OUTER JOIN _ref_state ON company.companyStateID=_ref_state.fldid)
			  		 LEFT OUTER JOIN _ref_country ON company.countryID=_ref_country.fldid
					 where company.ID='.$id;
		$query = $this->db->query($sql);
		$return = NULL;
 
		if($query->num_rows() >= 1){
			return $query->result();
		}else
		 return false;
	}
	
	public function updatePosting($ID){
		$this->db->where('ID', $ID);
		$updatepayment = array('updateAble'=>0);
		$query = $this->db->update('comp_receive_payment', $updatepayment); 
		if($query){
			return TRUE;
		}else{
			return FALSE;
		}
		
	}
	
	public function compRecPaymentDate($dateFrom, $dateTo){
		$this->db->where('comp_receive_payment.companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('receivePaymentDate between  "'.$dateFrom.'" and "'.$dateTo.'"');
		$this->db->where('updateAble', 1);
		$this->db->select('comp_receive_payment.*');
		$this->db->from('comp_receive_payment');
		$this->db->select('customer.customerName as customerName');
		$this->db->join('customer', 'customer.ID = comp_receive_payment.customerID');
		$this->db->order_by('receivePaymentDate desc');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	//added by akmal 20140530
	//to add default chart of account on creating new company
	public function company_groupChartOfAccount_byCompanyID($id){
		$this->db->where('companyID',$id);
		$query = $this->db->get('comp_acct_group');
		return $query->num_rows();
	}

	public function company_ref_groupChartOfAccount_all(){
		$query = $this->db->get('_ref_acct_group');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	public function company_ref_groupChartOfAccount_byParentID($id){
		$this->db->where('parentID',$id);
		$query = $this->db->get('_ref_acct_group');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	public function company_new_groupChartOfAccount_insert($data){
//		$sql = $this->db->insert_string('company', $newCompany);
//		$query = $this->db->query($sql);
		$insertString = $this->db->insert_string('comp_acct_group',$data);
//		echo '<br>'.$insertString;
		$query = $this->db->query($insertString);
		//echo $this->db->last_query(); 
		if($query){
			return $this->db->insert_id();
		}else{
			return 0;
		}
	}
	public function company_new_ChartOfAccount_insert($companyID, $bussinessTypeID){
		$insertString = 'insert into comp_chart_of_acct ';
		$insertString .= ' (companyID, acctGroupID, acctCode, acctName, acctDesc,createdBy)';
		$insertString .= ' select '.$companyID;
		$insertString .= ',acctGroupID,acctCode,acctName,acctDescription,';
		$insertString .= element('role', $this->session->userdata('logged_in'));
		$insertString .= ' from _ref_chart_of_acct';
		$insertString .= ' where businessTypeID='.$bussinessTypeID;
//		echo '<br>'.$insertString;
		$query = $this->db->query($insertString);
		//echo $this->db->last_query();
		return; 
	}
	//end added by akmal 20140530

}

/* End of file company_info_model.php */
/* Location: ./application/model/company/company_info_model.php */
/* Created : Fadhirul Hilmi edited 26/5/2014 */
