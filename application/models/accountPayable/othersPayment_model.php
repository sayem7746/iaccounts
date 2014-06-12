<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class othersPayment_model extends CI_Model{
	
	
	public function otherpay_all(){
		$this->db->where('is_delete', 0);
		$query = $this->db->get('comp_payment_others');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	
	public function otherpayWithItem_all(){
		$this->db->where('is_delete', 0);
		$this->db->where('otherPaymentType', 0);
		$query = $this->db->get('comp_payment_others');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function otherpayWithOutItem_all(){
		$this->db->where('is_delete', 0);
		$this->db->where('otherPaymentType', 1);
		$query = $this->db->get('comp_payment_others');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	
	public function otherpay_edit($updatepayment,$ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('comp_payment_others', $updatepayment); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function insert($tname, $newData){
		$sql = $this->db->insert_string($tname, $newData);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return $this->db->insert_id();
		} else {
	//		$last_query = $this->db->last_query();
	//		return $last_query;
			return 0;
		}
	}
	
	public function  getLasIdInsert($tname){
		$sql='SELECT LAST_INSERT_ID() as myId from '.$tname;
		$query = $this->db->query($sql);
		$return = NULL;
 
		if($query->num_rows() >= 1){
			foreach($query->result() as $row)
				$return =  $row->myId;
		}
		return $return;
	}
	
		
	public function deleteByTname($id, $tname){
		$this->db->where('ID', $id);
		$query = $this->db->delete($tname); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function updateByTname ($id, $data, $tname){
		$this->db->where('ID', $id);
		$query = $this->db->update($tname, $data); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	public function getOthersPayment($id){
		
	 $sql='SELECT comp_payment_others.*, comp_payment_others.ID as pID, comp_project.project_name, tbl_location.code,
	  		 tbl_location.address, master_code.name AS methodPay, comp_chart_of_acct.acctName, comp_chart_of_acct.acctCode
		   FROM (((comp_payment_others left outer join comp_project on comp_payment_others.projectID = comp_project.ID) 
				LEFT OUTER JOIN tbl_location ON tbl_location.fldid=comp_payment_others.locationID ) 
				LEFT OUTER JOIN master_code ON master_code.ID =comp_payment_others.paymentMethodID)
				LEFT OUTER JOIN comp_chart_of_acct ON comp_payment_others.accountID = comp_chart_of_acct.ID
			WHERE comp_payment_others.updateAble = 1 AND comp_payment_others.ID =  '.$id;
      		 	
		$query = $this->db->query($sql);

		if($query->num_rows() >0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	
	public function getOthersPaymentDetail($id, $tname){
		$sql ="";
		switch ($tname) {
    		case "comp_payment_others_with_item":
       			$sql='SELECT comp_payment_others_with_item.*,  comp_payment_others_with_item.ID AS pDetailID, item.ID as itemID, item.itemCode,
							tax_master.code as taxCode
					  FROM (comp_payment_others_with_item
					  LEFT JOIN item ON comp_payment_others_with_item.itemID=item.ID)
					  LEFT OUTER JOIN tax_master ON tax_master.ID =  comp_payment_others_with_item.taxID
					  WHERE comp_payment_others_with_item.otherPaymentID ='.$id;
      		 	 break;
  	 		
			case "comp_payment_others_without_item":
			 $sql='SELECT comp_payment_others_without_item.*, comp_chart_of_acct.ID as itemAccID, comp_chart_of_acct.accName, comp_chart_of_acct.code
				   FROM comp_payment_others_without_item left outer join comp_chart_of_acct on comp_payment_others_without_item.accoundID = comp_chart_of_acct.ID) 
					WHERE comp_payment_others_without_item.updateAble = 1 AND comp_payment_others_without_item.otherPaymentID =  '.$id;
      		 	 break;
		   }
		
		$query = $this->db->query($sql);

		if($query->num_rows() >0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	

} // end