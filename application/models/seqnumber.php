<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Seqnumber extends CI_Model{
	
	public function seqnumber_insert($newrtg){
		$sql = $this->db->insert_string('_sys_sequence', $newrtg);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}

	public function seqnumber_update($updatertg, $fldid){
		$this->db->where('fldid', $fldid);
		$query = $this->db->update('_sys_sequence', $updatertg); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function seqnumber_module($module){
		$query = $this->db->get_where('_sys_sequence', array('module'=>$module), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function seqnumber_modyrmth($module, $year, $month){
		$query = $this->db->get_where('_sys_sequence', array('module'=>$module, 'seqyear'=>$year, 'seqmonth'=>$month), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
}