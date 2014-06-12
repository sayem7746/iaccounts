<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item_count_adjust extends CI_Model{
	
	//Gather form data
	public function getData(){
		$query = $this->db
			->select('i.ID,i.itemCode,i.name,i.quantity,i.quantity,i.supplierPrice,(i.quantity*i.supplierPrice) as costQty')
			->from('item as i')
			->where(array('companyID'=>element('compID', $this->session->userdata('logged_in'))))
			->get();
		
		$data['datatbls'] = $query->result();
		return $data;
	}
	
	//Update balance item in comp_receive_item_detail
	public function updateBlnc($itemID,$counted){
		//Item information
		$query = $this->db
			->select('quantity,supplierPrice,')
			->from('item')
			->where('ID',$itemID)
			->get();
		$prevItem = $query->result();
		if(($required = $prevItem[0]->quantity - $counted) > 0){
			//Get Item received information
			$query = $this->db
				->select('ID,quantityReceived,balanceItem,createdTS')
				->from('comp_receive_item_detail')
				->order_by('createdTS','ASC')
				->where(array('itemID'=>$itemID,'balanceItem !=' => 0))
				->get();
			$prevItemRcv = $query->result();
			print_r($prevItemRcv);
			foreach($prevItemRcv as $row){
				if(($required - $row->balanceItem) > 0 ){
					$required = $required - $row->balanceItem;
					$query = $this->db->where('ID',$row->ID)->update('comp_receive_item_detail',array('balanceItem'=>0));
				}elseif(($required - $row->balanceItem) < 0 ){
					$query = $this->db->where('ID',$row->ID)->update('comp_receive_item_detail',array('balanceItem'=>($row->balanceItem - $required)));
					$required = 0;
					break;
				}
			}
		}elseif($required < 0 && false){
			//Get Item received information
			$query = $this->db
				->select('ID,quantityReceived,balanceItem,createdTS')
				->from('comp_receive_item_detail')
				->order_by('createdTS','ASC')
				->where(array('itemID'=>$itemID,'balanceItem !=' => 0))
				->get();
			
			$prevItemRcv = $query->result();
			print_r($prevItemRcv);
			
			
			exit();
		}else{
			return;
		}
	}	
	
	//Update counted item quantity
	public function updateQty($id,$data){
		
		
		//Keep record for adjustment.
		$query = $this->db
			->select('quantity,supplierPrice,')
			->from('item')
			->where('ID',$id)
			->get();
		$prevItem = $query->result();
		
		if($prevItem[0]->quantity != $data['quantity']){
			$newData = array(
					'itemID'		=> $id,
					'qtyOnHand' 	=> $prevItem[0]->quantity,
					'counted'		=> $data['quantity'],
					'onDatePrice' 	=> $prevItem[0]->supplierPrice,
					'createdBy'		=> element('role',$this->session->userdata('logged_in')),
				);
			$query = $this->db->insert('item_adjustment', $newData);
			$rows1 = $this->db->affected_rows();
			
			$this->db
				->where('ID', $id)
				->update('item', $data);
			$rows2 = $this->db->affected_rows();
		}
		
		
		
		if(isset($rows1) && isset($rows2)){
			return 1;
		} else {
			return 0;
		}
	}
	
	//Insert item purchase price
	public function insert($data){	
	}
	
	//Get individual price
	public function getPrice($id){
	}
	
	//Delete Sales prices
	public function delete($id){
	}
}