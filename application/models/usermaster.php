<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usermaster extends CI_Model{
	
	public function usermaster_all(){
		$this->db->where('is_delete', 0);
		$query = $this->db->get('tbl_usermaster');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	public function usermaster_allopt(){
		$this->db->select('userid');
		$this->db->select('username');
		$this->db->where('is_delete', 0);
		$query = $this->db->get('tbl_usermaster');
    	if($query->result()){
       		$result = $query->result();
        	return $result;
    	} 	
	}

	public function usermaster_id($id){
		$query = $this->db->get_where('tbl_usermaster', array('fldid'=>$id), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}

	public function usermaster_userid($id){
		$query = $this->db->get_where('tbl_usermaster', array('userid'=>$id), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function usermaster_insert($newuser){
		$sql = $this->db->insert_string('tbl_usermaster', $newuser);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}

	public function usermaster_edit($updateuser, $fldid){
		$this->db->where('fldid', $fldid);
		$query = $this->db->update('tbl_usermaster', $updateuser); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function usermaster_delete($deletuser, $fldid){
		$this->db->where('fldid', $fldid);
		$query = $this->db->update('tbl_usermaster', $deletuser); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function getLogin($userid,$password){
		
//		$this->db->select('userid','password','username');
//		$this->db->from('tbl_usermaster');
//		$this->db->where('userid', $userid);
//		$this->db->where('password', $password);
//		$this->db->limit(1);

		$query = $this->db->get_where('tbl_usermaster', array('userid'=>$userid, 'password'=>$password), 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}

	}
	
}