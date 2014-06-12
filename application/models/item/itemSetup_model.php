<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ItemSetup_model extends CI_Model{
	
	public function get_all(){
		$this->db->select('a.ID');
		$this->db->select('a.itemCode');
		$this->db->select('a.name');
		$this->db->select('a.description');
		$this->db->select('a.itemStatusID');
		$this->db->select('b.name as status');
		$this->db->select('a.itemCategoryID');
		$this->db->select('c.name as category');
		$this->db->select('a.itemTypeID');
		$this->db->select('d.name as type');
		$this->db->where('a.itemStatusID = b.id');
		$this->db->where('a.itemCategoryID = c.id');
		$this->db->where('a.itemTypeID = d.id');
		$this->db->where ('a.companyID',element('compID', $this->session->userdata('logged_in')));
		$this->db->order_by('a.name');
		$query = $this->db->get('item a, master_code b, master_code c, master_code d');
		//echo $this->db->last_query();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	
	public function insert($newData){
		$sql = $this->db->insert_string('item', $newData);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}
	
	public function itemdelete($id){
		$this->db->where('ID', $id);
		$query = $this->db->delete('item'); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	public function get_byID($id){
		$query = $this->db->get_where('item', array('ID'=>$id), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}

	}
	
	public function get_byCode($code){
		$sql='Select * FROM item WHERE itemCode = "'.$code.'"';
		$query = $this->db->query($sql);

		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}

	}
	
	public function update_byID($id, $data){
		$this->db->where('ID', $id);
		$query = $this->db->update('item', $data); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
}