<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Purchase_pricing extends CI_Model{
	
	//Gather form data
	public function getFormData(){
		//Gethering item list belongs to the company
		$this->db
			->select('i.ID,i.itemCode,i.name as itemName,i.unitOfMeasureID,mc.name as Unit')
			->from('item as i')
			->join('master_code as mc','mc.ID = i.unitOfMeasureID','left')
			->where(array('companyID'=>element('compID', $this->session->userdata('logged_in'))));
		$query = $this->db->get();
		$data['item'] = $query->result();
				
		//Gethering supplier list
		$this->db
			->select('s.ID,s.supplierName,s.supplierCode,c.currencyCode')
			->from('supplier as s')
			->join('currency as c','c.ID=s.currencyID','left');
		$query = $this->db->get();
		$data['supplier'] = $query->result();
		
		//Gethering item list
		$this->db
			->select('pp.ID,i.name,i.itemCode,s.supplierName,mc.name as UOM,pp.price as supplierPrice')
			->from('comp_purchase_price as pp')
			->join('item as i','i.ID = pp.itemID','left')
			->join('supplier as s','s.ID=pp.supplierID','left')
			->join('master_code as mc','mc.ID = i.unitOfMeasureID','left')
			->where(array('pp.companyID'=>element('compID', $this->session->userdata('logged_in'))));
			
		$query = $this->db->get();
		$data['datatbls'] = $query->result();
		return $data;
	}
	
	//Insert item purchase price
	public function insert($data){
		$query = $this->db->get_where('comp_purchase_price',array('companyID'=>$data['companyID'],'itemID'=>$data['itemID'],'supplierID'=>$data['supplierID']));
		
		//Checking already entry available
		if(!$this->db->affected_rows()){
			$query = $this->db->insert('comp_purchase_price', $data);
			return ($this->db->affected_rows() > 0)?'Inserted ':false;	
		}else{
			$result = $query->result();
			$this->db->where('ID', $result[0]->ID);
			$query = $this->db->update('comp_purchase_price', $data);
			return ($this->db->affected_rows() > 0)?"Updated ":false;
		}
		
		
	}
	
	//Get individual price
	public function getPrice($id){
		$this->db
			->select('itemID,supplierID,price')
			->from('comp_purchase_price')
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
		$query = $this->db->delete('comp_purchase_price'); 
		return $this->db->affected_rows();	
	}
}