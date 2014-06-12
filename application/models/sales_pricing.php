<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales_pricing extends CI_Model{
	
	//Gather form data
	public function getFormData(){
		//Gethering item list belongs to the company
		$this->db
			->select('ID,itemCode,name')
			->from('item')
			->where(array('companyID'=>element('compID', $this->session->userdata('logged_in'))));
		$query = $this->db->get();
		$data['item'] = $query->result();
		
		//Gethering currency list
		$this->db
			->select('ID,currencyCode, currencyWord')
			->from('currency');
		$query = $this->db->get();
		$data['currency'] = $query->result();
		
		//Gethering item list
		$this->db
			->select('itm.ID,itm.name,itm.itemCode,itm.salesPrice as price,c.companyName, cu.currencyWord, cu.currencyCode')
			->from('item as itm')
			->join('company as c','c.id=itm.companyID','left')
			->join('currency as cu','cu.ID = itm.currencyID','left')
			->where(array('itm.companyID'=>element('compID', $this->session->userdata('logged_in')),'salesPrice !='=> 0));
			
		$query = $this->db->get();
		$data['datatbls'] = $query->result();
		//print_r($data);
		//exit();
		
		return $data;
	}
	
	//Insert item price
	public function insert($id,$newdata){
		$this->db
			->from('item')
			->where(array('ID'=>$id,'companyID'=>$newdata['companyID']));
		$query = $this->db->get();
		if(!$query->num_rows){
			$query = $this->db->insert('comp_sales_price', $newdata);
		}else{
			$entry = $query->result();
			$query = $this->db->where('ID',$entry[0]->ID)
					->update('comp_sales_price', $newdata);
		}
		
		if($query){
			return TRUE;
		}else{
			return FALSE;
		}	
	}
	
	//Update item price
	public function update($id,$data){
		$this->db->where('ID', $id);
		$sql = $this->db->update('item', $data);
		$row = $this->db->affected_rows();
		if($row >= 1){
			return $row;
		} else {
			return false;
		}
	}
	
	//Get all sales prices
	public function allsalesprice(){
		$this->db->select('tbl_location.*');
		$this->db->select('_ref_state.fldname');
		$this->db->select('_ref_country.fldcountry');
		$this->db->from('tbl_location');
		$this->db->join('_ref_state', '_ref_state.fldid = tbl_location.state');
		$this->db->join('_ref_country', '_ref_country.fldid = tbl_location.country');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	//Get individual price
	public function getPrice($id){
		$this->db
			->select('i.ID,i.currencyID,i.salesPrice as price')
			->from('item as i')
			->where(array('ID'=>$id));
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	//Delete Sales prices
	public function delete($id){
		$this->db->where('ID', $id);
		$query = $this->db->delete('comp_sales_price'); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}	
	}
}