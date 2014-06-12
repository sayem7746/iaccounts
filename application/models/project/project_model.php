<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project_model extends CI_Model{
	
	public function project_all(){
	    $this->db->where('is_delete', 0);
	    $this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$query = $this->db->get('comp_project');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	public function project_id($ID){
		$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('ID', $ID);
		$query = $this->db->get('comp_project', 1);		
		if($query->num_rows() == 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function project_edit($updateproject, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('comp_project', $updateproject); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function project_insert($newproject){
		$sql = $this->db->insert_string('comp_project', $newproject);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}
	
	
	public function project_delete($deleteproject, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('comp_project', $deleteproject); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}

}

