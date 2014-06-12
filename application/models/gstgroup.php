<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gstgroup extends CI_Model{
	
	public function gstgroup_all(){
		$query = $this->db->get('gst_group');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function gstgroup_insert($newdept){
		$sql = $this->db->insert_string('gst_group', $newdept);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}

	public function gstgroup_edit($updatedept, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('gst_group', $updatedept); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function gstgroup_id($id){
		$query = $this->db->get_where('gst_group', array('ID'=>$id), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function gstgroup_delete($ID){
		$this->db->where('ID', $ID);
		$query = $this->db->delete('gst_group'); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
}