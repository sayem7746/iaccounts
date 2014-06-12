<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Supplier_model extends CI_Model{
	
	public function suppliermaster_all(){ //by current companyid login
	    $this->db->where('is_delete', 0);
	    $this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$query = $this->db->get('supplier');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function suppliermaster_all_state(){
		$this->db->select('supplier.*');
		$this->db->select('_ref_state.fldname');
	    $this->db->where('is_delete', 0);
	    $this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->from('supplier');
		$this->db->join('_ref_state', '_ref_state.fldid = supplier.supplierStateID');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	public function suppliermaster_allopt(){
		$this->db->select('ID');
		$this->db->select('supplierName');
	    $this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('is_delete', 0);
		$query = $this->db->get('supplier');
    	if($query->result()){
       		$result = $query->result();
        	return $result;
    	} 	
	}

	public function suppliermaster_id($ID){
	    $this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
	    $this->db->where('ID', $ID);
		$query = $this->db->get('supplier', 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
		public function suppliermaster_code($ID){ //?? duplicate with suppliermaster_id-akmal
	    $this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
	    $this->db->where('ID', $ID);
		$query = $this->db->get('supplier', 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function suppliermaster_edit($updateData, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('supplier', $updateData); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function suppliermaster_insert($newsupplier){
		$sql = $this->db->insert_string('supplier', $newsupplier);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}
	public function suppliermaster_delete($deleteuser, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('supplier', $deleteuser); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	public function supplierAging_byID($id){
		$this->db->where('supplierID', $id);
		$query = $this->db->get('view_supplier_aging'); 
		if($query === TRUE){
			return $query->result();
		} else {
			return FALSE;
		}
	}
	public function supplierStatement_byID($id){
		$this->db->where('supplierID', $id);
		$this->db->order_by('parent, seq, transDate');
		$query = $this->db->get('view_supplier_statement');
		//echo var_dump($query); 
		//echo '<br>'.var_dump($query->result()); 
		//echo $this->db->last_query(); 
		if($query == TRUE){
			return $query->result();
		} else {
			return FALSE;
		}
	}

}