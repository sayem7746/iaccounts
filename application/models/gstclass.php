<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gstclass extends CI_Model{
	
	public function gstclass_all(){
		$query = $this->db->get('gst_class');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function gstclass_insert($newdept){
		$sql = $this->db->insert_string('gst_class', $newdept);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}

	public function gstclass_edit($updatedept, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('gst_class', $updatedept); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function gstclass_id($id){
		$query = $this->db->get_where('gst_class', array('ID'=>$id), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function gstclass_delete($ID){
		$this->db->where('ID', $ID);
		$query = $this->db->delete('gst_class'); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
}