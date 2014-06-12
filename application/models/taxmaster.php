<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Taxmaster extends CI_Model{
	
	public function taxmaster_all(){
		$query = $this->db->get('tax_master');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function taxmaster_saleOutput(){
		$this->db->where('taxGroup',2); //refer tax group table
		$query = $this->db->get('tax_master');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function taxmaster_purchaseInput(){
		$this->db->where('taxGroup',1);  //refer tax group table
		$query = $this->db->get('tax_master');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function taxmaster_insert($newdept){
		$sql = $this->db->insert_string('tax_master', $newdept);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}

	public function taxmaster_edit($updatedept, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('tax_master', $updatedept); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function taxmaster_id($id){
		$query = $this->db->get_where('tax_master', array('ID'=>$id), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function taxmaster_delete($ID){
		$this->db->where('ID', $ID);
		$query = $this->db->delete('tax_master'); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function taxmaster_save($id, $data){
		$this->db->where('ID', $id);
		$query = $this->db->update('tax_master', $data); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function useraccess_full(){
		$this->db->select('tax_master.*');
		$this->db->select('tax_type.description as desctype');
		$this->db->select('tax_group.description as descgroup');
		$this->db->select('tax_class.code as descclass');
		$this->db->select('comp_chart_of_acct.acctCode as acctcode');
		$this->db->select('comp_chart_of_acct.acctName as acctname');
		$this->db->from('tax_master');
		$this->db->join('tax_type', 'tax_type.ID = tax_master.taxType');
		$this->db->join('tax_group', 'tax_group.ID = tax_master.taxGroup');
		$this->db->join('tax_class', 'tax_class.ID = tax_master.taxClass');
		$this->db->join('comp_chart_of_acct', 'comp_chart_of_acct.ID = tax_master.taxAccount');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
}