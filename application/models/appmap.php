<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Appmap extends CI_Model{
	
	public function appmap_all(){
		$query = $this->db->get('tbl_appmap');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function appmap_insert($newsla){
		$sql = $this->db->insert_string('tbl_appmap', $newsla);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}

	public function appmap_edit($updatesla, $fldid){
		$this->db->where('fldid', $fldid);
		$query = $this->db->update('tbl_appmap', $updatesla); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function appmap_id($id){
		$query = $this->db->get_where('tbl_appmap', array('fldid'=>$id), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function appmap_reqno($req_no){
		$this->db->order_by('req_no','seq_no');
		$query = $this->db->get_where('tbl_appmap', array('req_no'=>$req_no));		
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}

	public function appmap_next($req_no, $seq_no ){
		$this->db->order_by('req_no','seq_no');
		$query = $this->db->get_where('tbl_appmap', array('req_no'=>$req_no, 'seq_no >'=>$seq_no), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}

	public function appmap_approver($approver){
		$this->db->order_by('approver','req_no');
		$query = $this->db->get_where('tbl_appmap', array('approver'=>$approver, 'approve_date'=>NULL));		
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function appmap_delete($fldid){
		$this->db->where('fldid', $fldid);
		$query = $this->db->delete('tbl_appmap'); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
}