<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SupplierPayment_model extends CI_Model{
	
	 
	 public function supppayment_all(){
	     $this->db->where('is_delete', 0);
	    $this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$query = $this->db->get('comp_payment');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	
	public function supplierPayment_all(){
		$this->db->where('comp_payment.companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->select('comp_payment.*');
		$this->db->select('supplier.supplierName as supplierName');
		$this->db->from('comp_payment');
		$this->db->join('supplier', 'supplier.ID = comp_payment.supplierID');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}

	 public function supppayment_byID($ID){
		$this->db->where('ID', $ID);
	    $this->db->where('is_delete', 0);
	    $this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$query = $this->db->get('comp_payment');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function updatePosting($ID){
		$this->db->where('ID', $ID);
		$updatepayment = array('updateAble'=>1);
		$query = $this->db->update('comp_payment', $updatepayment); 
		if($query){
			return TRUE;
		}else{
			return FALSE;
		}
		
	}
	public function paymentDetail_insert($paymentdetails){
		$currentUser = element('role', $this->session->userdata('logged_in'));

		$paymentID = $paymentdetails["paymentID"];
		for ($i=0; $i< sizeof ($paymentdetails["amountApplied"]); $i++) {
			$amountApplied = ($paymentdetails["amountApplied"][$i]==''?0:$paymentdetails["amountApplied"][$i]);
			$suppInvoiceID = ($paymentdetails["suppInvoiceID"][$i]==''?0:$paymentdetails["suppInvoiceID"][$i]);
			$discount = ($paymentdetails["discount"][$i]==''?0:$paymentdetails["discount"][$i]);
//			echo '<br>amt:'.$amountApplied.' inv:'.$suppInvoiceID.' disc:'.$discount; 
			if ($discount > 0 || $amountApplied > 0) {
//				echo '<br>'.$col[$i].'/'.$paymentdetailsl->amountApplied[$i].'/'.$paymentdetailsl->discount[$i];
				$sql1 = 'insert into comp_payment_detail (paymentID, purchaseInvoiceID,totalAmount,APBalance,discount,amountApplied,createdBy) ';
				$sql1 .= 'select '.$paymentID.',ID,totalAmount, totalPayable  ,'. $discount.','.$amountApplied.','.$currentUser ;
				$sql1 .= ' from comp_supplier_invoice where ID=' . $suppInvoiceID;
				$sql2 = 'update comp_supplier_invoice set ';
				$sql2 .= 'amountPaid = amountPaid + '.$amountApplied.'+'.$discount.', ';
//				$sql2 .= 'totalPayable = totalAmount - amountPaid - '.$amountApplied.' - '.$discount;
				$sql2 .= 'totalPayable = totalAmount - amountPaid ';
				$sql2 .= ' where ID = '.$suppInvoiceID;
				$query = $this->db->query($sql1);
//				echo '<br>'.$this->db->last_query();
				$query = $this->db->query($sql2);
//				echo '<br>'.$this->db->last_query();
			}
		}
				echo '<script>alert("save controller");</script>';

		if($query === TRUE){
			return TRUE;
		} else {
			$last_query = $this->db->last_query();
			return $last_query;
		}
//insert into comp_payment_detail (paymentID, purchaseInvoiceID,totalAmount,APBalance,discount,amountApplied,createdBy) 
//select $paymentID,ID,totalAmount, totalAmount - amountPaid + $amountApplied[$i], $discount[$i],$amountApplied[$i],$currentUser
//from comp_supplier_invoice 
//where ID = $suppInvoiceID[$i]
/* example insert into comp_payment_detail (paymentID, purchaseInvoiceID,totalAmount,APBalance,discount,amountApplied,createdBy) 
select 1,ID,totalAmount, totalAmount - amountPaid + 100, 1,100,1
from comp_supplier_invoice 
where ID = 71
update comp_supplier_invoice set amountPaid = amountPaid + $amountApplied[$i], totalPayable = totalAmount - amountPaid where ID = $suppInvoiceID[$i]

*/
	}

	
	public function suppPayment_insert($newsupppayment){
		$sql=$this->db->insert_string('comp_payment', $newsupppayment);
		$query = $this->db->query($sql);
//		echo '<br>'.$this->db->last_query();
		if($query === TRUE){
			return $this->db->insert_id();//TRUE;
		} else {
			$last_query = $this->db->last_query();
			return 0;
		}
	}
		public function suppPayment_edit($updatepayment,$ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('comp_payment', $updatepayment); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
        public function supppayment_delete($deletpayment, $ID){
		$this->db->where('ID', $ID);
		$query = $this->db->update('comp_payment', $deletepayment); 
		if($query === TRUE){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	public function supplierPaymentDate($dateFrom, $dateTo){
		$this->db->where('comp_payment.companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('paymentDate between  "'.$dateFrom.'" and "'.$dateTo.'"');
//		$this->db->where('updateAble', 0);
		$this->db->select('comp_payment.*');
		$this->db->from('comp_payment');
		$this->db->select('supplier.supplierName as supplierName');
		$this->db->join('supplier', 'supplier.ID = comp_payment.supplierID');
		$this->db->order_by('paymentDate desc');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}

}