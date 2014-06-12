<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Glchart_model extends CI_Model{
	
	public function expenses($year){
		$this->db->select('b.acctID');
		$this->db->select('sum(b.amountcr - b.amountdr) as amount');
		$this->db->select('c.acctName');
		$this->db->select('a.*');
		$where = "(acctTypeID = 4)";
		$this->db->where('a.companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where($where);
		$this->db->order_by('acctTypeID');
		$this->db->order_by('parentID');
		$this->db->order_by('orderNo');
		$this->db->group_by('b.acctID');
		$this->db->from('comp_acct_group a');
		$this->db->join('comp_acc_det b', 'b.acctGroupID = a.ID and b.year ='.$year);
		$this->db->join('comp_chart_of_acct c', 'c.ID = b.acctID');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			$total = 0;
			$i = 0;
			$dataexpenses = '';
			foreach($query->result() as $row){
				$total =  $total + $row->amount;
			}
			foreach($query->result() as $row){
				$dataexpenses[$i] = array(
					'label' => $row->acctName,
					'data' => $row->amount / $total,
					'accountID' => $row->acctID
					);
				$i++;
			}
			return $dataexpenses;
		}else{
			$dataexpenses = NULL;
			return $dataexpenses;
		}
	}

	public function assets($year){
		$this->db->select('b.acctID');
		$this->db->select('sum(b.amountdr - b.amountcr) as amount');
		$this->db->select('c.acctName');
		$this->db->select('a.*');
		$where = "(a.ID = 2)";
		$this->db->where('a.companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where($where);
		$this->db->order_by('acctTypeID');
		$this->db->order_by('parentID');
		$this->db->order_by('orderNo');
		$this->db->group_by('b.acctID');
		$this->db->from('comp_acct_group a');
		$this->db->join('comp_acc_det b', 'b.acctGroupID = a.ID and b.year ='.$year);
		$this->db->join('comp_chart_of_acct c', 'c.ID = b.acctID');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			$total = 0;
			$i = 0;
			$dataexpenses = '';
			foreach($query->result() as $row){
				$total =  $total + $row->amount;
			}
			foreach($query->result() as $row){
				$dataexpenses[$i] = array(
					'label' => $row->acctName,
					'data' => $row->amount / $total * 100,
					'accountID' => $row->acctID
					);
				$i++;
			}
			return $dataexpenses;
		}else{
			$dataexpenses = NULL;
			return $dataexpenses;
		}
	}
	public function expensesbudget($year){
		$this->db->select('a.*');
		$this->db->select('c.amountcr - c.amountdr as actamount');
		$this->db->select('d.amountcr as budgetamount');
		$this->db->where('a.companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('is_delete', '');
		$this->db->where('b.acctTypeID', '4');
		$this->db->order_by('acctCode');
		$this->db->order_by('acctName', 'desc');
		$this->db->from('comp_chart_of_acct a');
		$this->db->join('comp_acct_group b', 'a.acctGroupID = b.ID');
		$this->db->join('comp_acc_det c', 'c.acctID = a.ID');
		$this->db->join('comp_budget d', 'd.acctID = a.ID and d.year ='. $year);
		$query = $this->db->get();		
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
//		$this->CompanyChartAcct->chartAcct_allexpenses();
	}
	public function accountbalance_type($year){
		$this->db->select('sum(b.amountdr + b.amountcr) as amount');
		$this->db->select('a.*');
		$this->db->where('b.companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->order_by('a.ID');
		$this->db->group_by('a.ID');
		$this->db->from('comp_acct_type a');
		$this->db->join('comp_acct_group c', 'c.acctTypeID = a.ID');
		$this->db->join('comp_acc_det b', 'b.acctGroupID = c.ID and b.year ='.$year);
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			$total = 0;
			$i = 0;
			$dataexpenses = '';
			foreach($query->result() as $row){
				$total =  $total + $row->amount;
			}
			foreach($query->result() as $row){
				$dataexpenses[$i] = array(
					'label' => $row->acctTypeName,
					'data' => $row->amount / $total * 100,
					'accountID' => $row->ID
					);
				$i++;
			}
			return $dataexpenses;
		}else{
			$dataexpenses = NULL;
			return $dataexpenses;
		}
	}
}
/* End of file glchart.php */
/* Location: ./application/model/compAcctDet.php */
/* Created By : Yahaya Abdollah */
