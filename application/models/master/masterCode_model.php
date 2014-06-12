<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MasterCode_model extends CI_Model{
	
	public function get_all($filter){
		$this->db->where('a.masterID',$filter['masterID']);
		if (isset($filter['parentFilterID'])) {
			$this->db->where('a.parentFilterID',$filter['parentFilterID']);
			$this->db->where('a.parentFilterID = b.ID');
			$this->db->select('a.ID');
			$this->db->select('a.code');
			$this->db->select('a.name');
			$this->db->select('a.shortName');
			$this->db->select('a.orderNo');
			$this->db->select('b.name as description');
			$this->db->order_by('a.orderNo');
			$query = $this->db->get('master_code a, master_code b');
		}else {
			$this->db->select('ID');
			$this->db->select('code');
			$this->db->select('name');
			$this->db->select('shortName');
			$this->db->select('orderNo');
			$this->db->select('description');
			$this->db->order_by('orderNo');
			$query = $this->db->get('master_code a');
		}
		//echo $this->db->last_query(); 
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
// master	
	public function master_all(){
		$this->db->order_by('name', 'desc');
		$query = $this->db->get('master');		
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
// master_code	
	public function mastercode_all(){
		$this->db->where('is_delete', 0);
		$this->db->order_by('parentFilterID', 'desc');
		$this->db->order_by('name', 'desc');
		$query = $this->db->get('master_code');		
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function mastercode_all_id($id){
		$this->db->where('masterID', $id);
		$this->db->order_by('parentFilterID', 'desc');
		$this->db->order_by('name');
		$query = $this->db->get('master_code');		
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
//javascript changeList	
	public function masterCodeSetup_masterid($id){
		$this->db->where('masterID',$id);
		$this->db->order_by('name');
		$query = $this->db->get('master_code');		
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function masterCodeSetupInsert($newMasterCodeSetup){
		$sql = $this->db->insert_string('master_code', $newMasterCodeSetup);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}

	public function masterCodeSetup_edit($update_masterCodeSetup, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('master_code', $update_masterCodeSetup); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function masterCodeSetup_id($id){
		$query = $this->db->get_where('master_code', array('ID'=>$id), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	public function masterCodeSetupDelete($delete_masterCodeSetup, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('master_code', $delete_masterCodeSetup); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}	

}
?>