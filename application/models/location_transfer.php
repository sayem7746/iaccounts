<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Location_transfer extends CI_Model{

	//Gether all location transfer information
	public function get_loc_transfer_all($id){
		$this->db
			->select('lt.ID,loc.code as fromLoc,locTo.code as toLoc,mc.name as movetype,memo,dateTransfer')
			->from('comp_location_transfer as lt')
			->join('tbl_location as loc','loc.fldid=lt.fromLocationID','left')
			->join('tbl_location as locTo','locTo.fldid=lt.toLocationID','left')
			->join('master_code as mc','mc.ID=movementTypeID','left')
			->where(array('lt.companyID'=>$id));
		
		$query = $this->db->get();
		
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	//Gether Location information
	public function location_byCompany($id){
		$this->db
			->select('fldid,code')
			->from('tbl_location')
			->where(array('companyID'=>$id));
			
		$query = $this->db->get();
		
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	//Insert Location information
	public function insert($data){
		$query = $this->db->insert('comp_location_transfer', $data);
		
		if($query){
			return $this->db->insert_id();
		}else{
			return FALSE;
		}	
	}
	
	//Insert Location Detail information
	public function insertDetail($data){
		$query = $this->db->insert('comp_location_transfer_detail', $data);
		
		if($query){
			return TRUE;
		}else{
			return FALSE;
		}	
	}
	
	
	/**********************
	-----------Edit--------
	**********************/
	
	public function get_loc_trans_by_id($id){
		//Transfer information
		$this->db
			->select('*')
			->from('comp_location_transfer');
		
		$query1 = $this->db->get();
		$data['transInfo'] = $query1->result();
		
		//Transfer item detail
		$this->db
			->select('ld.*,item.itemCode,item.description')
			->from('comp_location_transfer_detail as ld')
			->join('item','item.ID=ld.itemID','left')
			->where(array('locationTransferID'=>$data['transInfo'][0]->ID));
		
		$query2 = $this->db->get();
		$data['itemList'] = $query2->result();
		if($query1->num_rows() >= 1){
			return $data;
		}else{
			return false;
		}
	}
	
	/**********************
	-----------Update--------
	**********************/
	
	public function update($id,$data){
		$this->db
			->where('ID', $id)
			->update('comp_location_transfer', $data);
		$rows = $this->db->affected_rows();
		
		
		if($rows >= 1){
			return $rows;
		} else {
			$last_query = $this->db->last_query();
			return false;
		}
	}
	
	public function updateDetail($id,$data){
		$rows = 0;
		$query = $this->db->select('ID')->from('comp_location_transfer_detail')->where('itemID',$id)->get();
		if(empty($query->result())){
			$query = $this->db->insert('comp_location_transfer_detail', $data);
			$rows = $this->db->affected_rows();
			
		}else{
			$this->db
				->where('ID', $id)
				->update('comp_location_transfer_detail', $data);
			$rows = $this->db->affected_rows();
		}
		
		
		
		if($rows >= 1){
			return $rows;
		} else {
			$last_query = $this->db->last_query();
			return false;
		}
	}
	
	
	/**********************
	---------Remove--------
	**********************/
	public function remove($id){
		$this->db->where('ID', $id)
				->delete('comp_location_transfer');
				
		$this->db->where('locationTransferID', $id)
				->delete('comp_location_transfer_detail');
	}
	
	
	public function removeItem($id){
		$this->db->where('ID', $id)
				->delete('comp_location_transfer_detail');
	}

}

