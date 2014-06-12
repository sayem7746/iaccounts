<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact_model extends CI_Model{
	
    public function contact_all(){
	     $this->db->where('is_delete', 0);
		$query = $this->db->get('supplier_contact');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
    public function contact_supplier_all($supplierid){
	     $this->db->where('supplierID', $supplierid);
	     $this->db->where('is_delete', 0);
		$query = $this->db->get('supplier_contact');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function contact_id($ID){
		$this->db->where('ID', $ID);
	    $query = $this->db->get_where('supplier_contact', array('ID'=>$ID), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function contact_edit($updatecontact, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('supplier_contact', $updatecontact); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function contact_insert($newcontact){
		$sql = $this->db->insert_string('supplier_contact', $newcontact);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}
	public function contact_delete($deletecontact, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('supplier_contact', $deletecontact); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}

}