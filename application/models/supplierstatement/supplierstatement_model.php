<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class supplierstatement_model extends CI_Model{
	
public function supplierstatement_all(){
	    $this->db->where('is_delete', 0);
	    //$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$query = $this->db->get('comp_supplier_statement');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	public function supplier_statement_id($ID){
		$this->db->where('ID', $ID);
	    $this->db->where('is_delete', 0);
	   // $this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$query = $this->db->get('comp_supplier_statement');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
/* //statement should no update/delete -akmal
	public function supplier_statement_edit($updatestat, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('comp_supplier_statement', $updatestat); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function supplier_statement_insert($newstatement){
		$sql = $this->db->insert_string('comp_supplier_statement', $newstatement);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}
	public function suppplier_statement_delete($deletepstat, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('comp_supplier_statement', $deletestat); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	*/
}

