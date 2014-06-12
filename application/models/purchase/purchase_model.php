<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Purchase_model extends CI_Model{
	
	
	
	public function insert($tname, $newData){
		$sql = $this->db->insert_string($tname, $newData);
		$query = $this->db->query($sql);
		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
	}
	
	
	// is used in items received
	public function getPoList ($supID,$companyID){
		if ($supID!="null")
		 $this->db->where('supplierID',$supID); 
		if ($companyID > 0)
		    $this->db->where('companyID',$companyID); 
		$this->db->select('formNo');
		$this->db->select('ID');
		$query = $this->db->get('comp_purchase_order');
		if($query->num_rows() >0 ){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function getPoItemList($idPo){
		$sql='SELECT comp_purchase_order_detail.*,  comp_purchase_order_detail.ID AS poDetailID, item.ID as itemID, item.itemCode as itemCodee 
			FROM comp_purchase_order_detail
			LEFT JOIN item
			ON comp_purchase_order_detail.itemID=item.ID
			WHERE comp_purchase_order_detail.quantityReceivedTotal<comp_purchase_order_detail.quantityOrder 
				AND comp_purchase_order_detail.purchaseOrderID ='.$idPo;
			$query = $this->db->query($sql);
			
		if($query->num_rows() >=1){
			$res = $query->result();
				//for ajax call 
			$JsonRecords = '{"records":[';
			
			$n = sizeof($res);
			$i= 0;
			 foreach($res as $row){
				$JsonRecords .= '{';
				$JsonRecords .= '"itemId":"' . $row->itemID . '","poDetailId":"'.$row->poDetailID.
				'", "itemCode":"'. $row->itemCodee.'","itemName":"'. $row->itemName.'","description":"'. $row->description
				.'", "unitPrice":"'.$row->unitPrice.'","quantityReceivedTotal":"'.$row->quantityReceivedTotal.'","quantityOrder":"'
				.$row->quantityOrder.'"';
				$JsonRecords .= '}';
				if ($i < $n - 1)
					$JsonRecords .= ',';
				$i++;
			}
			$JsonRecords .= ']}';
			
			//$resul= '{"supplier":['. json_encode($this->supplier_model->suppliermaster_all()).']}';
			 return $JsonRecords;
		}else{
			return FALSE;
		}
	}
	
	
	public function get_Detail_byID($id){
		$sql='SELECT comp_purchase_order_detail.*, comp_purchase_order_detail.unitPrice*quantityOrder as total
			FROM comp_purchase_order_detail
			LEFT JOIN item
			ON comp_purchase_order_detail.itemID=item.ID
			where purchaseOrderID ='.$id;
			$query = $this->db->query($sql);

		if($query->num_rows() >=1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function get_byID($tname, $id){
		$sql ="";
		switch ($tname) {
    		case "comp_purchase_order":
       			 $sql='SELECT comp_purchase_order.*, comp_purchase_order.ID as poID, supplier.supplierName, terms.termName, terms.termDescription, currency.currencyWord FROM (comp_purchase_order left outer join terms on comp_purchase_order.termAndConditionID = terms.ID), currency , supplier where comp_purchase_order.updateAble = 1 AND supplier.ID=comp_purchase_order.supplierID AND currency.ID=supplier.currencyID AND comp_purchase_order.ID =  '.$id;
      		 	 break;
  	 		
		   }
		
		$query = $this->db->query($sql);

		if($query->num_rows() >0){
			return $query->result();
		}else{
			return FALSE;
		}

	}
	
		
	public function delete($id){
		$this->db->where('ID', $id);
		$query = $this->db->delete("comp_purchase_order_detail"); 
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
	
	public function updatePoDetail($id, $data){
		$this->db->where('ID', $id);
		$query = $this->db->update('comp_purchase_order_detail', $data); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function update($id, $data){
		$this->db->where('ID', $id);
		$query = $this->db->update('comp_purchase_order_detail', $data); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
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

	/*public function purchaseOrder_all(){
		$this->db->where('comp_purchase_order.companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->select('comp_purchase_order.*');
		$this->db->select('supplier.supplierName as supplierName');
		$this->db->from('comp_purchase_order');
		$this->db->join('supplier', 'supplier.ID = comp_purchase_order.supplierID');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}*/
	
	public function updatePosting($ID){
		$this->db->where('ID', $ID);
		$updatepayment = array('updateAble'=>0);
		$query = $this->db->update('comp_purchase_order', $updatepayment); 
		if($query){
			return TRUE;
		}else{
			return FALSE;
		}
		
	}
	
	public function getPoItemTotal($id){
		$sql='SELECT quantityReceivedTotal
			From comp_purchase_order_detail where  ID='.$id;
      		 
		$query = $this->db->query($sql);

		if($query->num_rows() >0){
			$r = $query->result();
			$val ="null";
			 foreach ($r as $row)
				$val= $row->quantityReceivedTotal;
			return $val;
		}else{
			return FALSE;
		}
	} 
	
	public function getReceiveDetail ($id){
			$sql='SELECT comp_receive_item_detail.*
			From comp_receive_item_detail where  receiveID='.$id;
      		 
		$query = $this->db->query($sql);

		if($query->num_rows() >0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function getReceiveByID($id) {
		$sql='SELECT comp_receive_item.memo, comp_employee.employeeName , supplier.supplierName, comp_receive_item.formNo, deliveryDate, supplierDoNo, CONCAT(comp_receive_item.formNo, comp_receive_item.ID) AS reFormNo, CONCAT(comp_purchase_order.formNo, comp_purchase_order.ID) AS poFormNo, tbl_location.state, tbl_location.address, currency.currencyWord, currency.exchangeRate, master_code.code as shipping
		FROM ((comp_receive_item left outer join comp_employee on comp_receive_item.employeeID=comp_employee.ID) left outer join master_code on master_code.ID = comp_receive_item.shippingMethodID) LEFT OUTER JOIN tbl_location on comp_receive_item.locationID=tbl_location.fldid, currency , supplier, comp_purchase_order
		 WHERE master_code.masterID=2 AND supplier.ID=comp_receive_item.supplierID AND currency.ID=supplier.currencyID AND comp_purchase_order.ID= comp_receive_item.purchaseOrderID AND comp_receive_item.ID =  '.$id;
      		 
		
		$query = $this->db->query($sql);

		if($query->num_rows() >0){
			return $query->result();
		}else{
			return FALSE;
		}

	}
	
	public function purchaseOrderDate($dateFrom, $dateTo){
		$this->db->where('comp_purchase_order.companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('poDate between  "'.$dateFrom.'" and "'.$dateTo.'"');
		$this->db->where('updateAble', 1);
		$this->db->select('comp_purchase_order.*');
		$this->db->from('comp_purchase_order');
		$this->db->select('supplier.supplierName as supplierName');
		$this->db->join('supplier', 'supplier.ID = comp_purchase_order.supplierID');
		$this->db->order_by('poDate desc');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function rptGetPaymentAdviceDetail($id){
		$sql='SELECT comp_payment_detail.amountApplied, comp_supplier_invoice.supplierInvoiceNo,
					comp_supplier_invoice.invoiceDate
			  FROM comp_payment_detail,comp_supplier_invoice
			  WHERE comp_payment_detail.purchaseInvoiceID = comp_supplier_invoice.ID AND
					  comp_payment_detail.paymentID ='.$id;
      		 
		$query = $this->db->query($sql);

		if($query->num_rows() >0){
			return $query->result();
		}else{
			return FALSE;
		}

	}
	
	
 	public function rptGetPaymentAdvice($id){
		$sql='SELECT supplier.supplierName, supplier.line1, supplier.line2, supplier.line3, supplier.supplierPostCode, comp_payment.ID,
		              supplier.city,_ref_state.fldname, _ref_country.fldcountry, comp_payment.amountPaid, master.name AS pMethod, 
					  comp_payment.paymentDate, comp_payment.referenceNo, currency.currencyCode, currency.exchangeRate , comp_payment.formNo
			  FROM comp_payment LEFT OUTER JOIN master ON comp_payment.paymentMethodID=master.ID, (((Supplier LEFT OUTER JOIN _ref_state ON         
			  		Supplier.supplierStateID=_ref_state.fldid) 
			        LEFT OUTER JOIN _ref_country ON Supplier.supplierCountryID=_ref_country.fldid) 
					LEFT OUTER JOIN currency ON currency.ID = Supplier.currencyID) 
			  WHERE Supplier.ID=comp_payment.supplierID
			  		AND comp_payment.ID ='.$id.' LIMIT 1';
      		 
		$query = $this->db->query($sql);

		if($query->num_rows() >0){
			return $query->result();
		}else{
			return FALSE;
		}

	}
	
} // end