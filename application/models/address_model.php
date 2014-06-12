<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//created by en.helmi 20140519
//comp_address
//supplier_address
//customer_address

class Address_model extends CI_Model{
	

	public function get_all($tableName){
		switch ($tableName) {
			case 'customer_address':
				$tableName2='customer';
				$field='customer.customerName as name';
				$field2='customerID';
				break;
			case 'supplier_address':
				$tableName2='supplier';
				$field='supplier.supplierName as name';
				$field2='supplierID';
				break;
			default:
				$tableName2='company';
				$field='company.companyName as name';
				$field2='companyID';
				break;
		}
		$this->db->select($field);
		$this->db->select($tableName.'.*');
		$this->db->select('_ref_state.fldname as state');
		$this->db->select('_ref_country.fldcountry as country');
		$this->db->where($tableName.'.companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where($tableName.'.is_delete', '');
		$this->db->order_by('name, addressName', 'desc');
//		$this->db->join('comp_acct_group', 'comp_acct_group.ID = comp_chart_of_acct.acctGroupID');
		$this->db->join('_ref_state', '_ref_state.fldid = '.$tableName.'.stateID','left outer');
		$this->db->join('_ref_country', '_ref_country.fldid = '.$tableName.'.countryID','left outer');
		$this->db->join($tableName2,$tableName2.'.ID='.$tableName.'.'.$field2);

		$query = $this->db->get($tableName);
//		echo $this->db->last_query();		
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function insert($tableName, $dataInsert){
		$sql = $this->db->insert_string($tableName, $dataInsert);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}

   // is used in purchaseInvoice
	public function getCompanyAdresses (){
		$query = $this->db->query("Select * from comp_address");

		if($query->num_rows() >=1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function get_byID($tableName,$id){
		$query = $this->db->get_where($tableName, array('ID'=>$id), 1);		
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function update($tableName, $dataUpdate, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update($tableName, $dataUpdate); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
}