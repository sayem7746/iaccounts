<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gsttype extends CI_Model{
	
	public function gsttype_all(){
		$query = $this->db->get('gst_type');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function gsttype_insert($newdept){
		$sql = $this->db->insert_string('gst_type', $newdept);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}

	public function gsttype_edit($updatedept, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('gst_type', $updatedept); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function gsttype_id($id){
		$query = $this->db->get_where('gst_type', array('ID'=>$id), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function gsttype_delete($ID){
		$this->db->where('ID', $ID);
		$query = $this->db->delete('gst_type'); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
}