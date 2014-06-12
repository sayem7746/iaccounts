<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sysumconv extends CI_Model{
	
	public function sysumconv_all(){
		$query = $this->db->get('_sys_um_conv');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function sysumconv_insert($newdept){
		$sql = $this->db->insert_string('_sys_um_conv', $newdept);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}

	public function sysumconv_edit($updatedept, $fldid){
		$this->db->where('fldid', $fldid);
		$query = $this->db->update('_sys_um_conv', $updatedept); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function sysumconv_id($id){
		$query = $this->db->get_where('_sys_um_conv', array('fldid'=>$id), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function sysumconv_save($fldid, $data){
		$this->db->where('fldid', $fldid);
		$query = $this->db->update('_sys_um_conv', $data); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	public function sysumconv_delete($fldid){
		$this->db->where('fldid', $fldid);
		$query = $this->db->delete('_sys_um_conv'); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}

}