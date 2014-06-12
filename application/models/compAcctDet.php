<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CompAcctDet extends CI_Model{
	
	public function AcctDet_all_period($year, $period){
		$this->db->select('a.*');
		$this->db->select('b.*');
		$this->db->select('c.total as lasttotal');
		$this->db->where('b.companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->order_by('a.year');
		$this->db->order_by('a.period');
		$this->db->order_by('b.acctCode');
		$this->db->from('comp_chart_of_acct a');
		$this->db->join('comp_acc_det a', 'a.acctID = b.ID and a.year ='.$year .' and a.period ='.$period, 'left outer');
//		$this->db->join('comp_acc_det c', 'a.acctID = c.acctID and c.period = a.period - 1 and c.year = a.year', 'left outer');
		$this->db->join('comp_acc_det c', 'b.ID = c.acctID and c.year + c.period <= '.$year.sprintf('%02d', $period - 1), 'left outer');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function AcctDet_allfy($year){
		$this->db->select('a.amountdr as currentyeardebit');
		$this->db->select('a.amountcr as currentyearcredit');
		$this->db->select('a.total');
		$this->db->select('c.*');
		$this->db->select('b.*');
		$this->db->select('sum(c.amountdr) as lastyeardebit');
		$this->db->select('sum(c.amountcr) as lastyearcredit');
		$this->db->where('b.companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->order_by('b.acctCode');
		$this->db->group_by('a.year');
		$this->db->group_by('a.period');
		$this->db->group_by('b.acctCode');
		$this->db->from('comp_chart_of_acct b');
		$this->db->join('comp_acc_det a', 'a.acctID = b.ID and a.year ='.$year, 'left outer');
		$this->db->join('comp_acc_det c', 'b.ID = c.acctID and c.year < '.$year, 'left outer');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	public function AcctDet_allfypnl($year){
		$this->db->select('a.amountdr as currentyeardebit');
		$this->db->select('a.amountcr as currentyearcredit');
		$this->db->select('a.total');
		$this->db->select('b.*');
		$this->db->where('b.companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->order_by('b.acctCode');
		$this->db->group_by('a.year');
		$this->db->group_by('a.period');
		$this->db->group_by('b.acctCode');
		$this->db->from('comp_chart_of_acct b');
		$this->db->join('comp_acc_det a', 'a.acctID = b.ID and a.year ='.$year, 'left outer');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function AcctDet_allfy_period($year, $period){
		$this->db->select('b.*');
//		$this->db->select('c.*');
		$this->db->select('a.amountdr as thismonthdr');
		$this->db->select('a.amountcr as thismonthcr');
		$this->db->select('sum(c.amountdr) as yeardebit');
		$this->db->select('sum(c.amountcr) as yearcredit');
		$this->db->where('b.companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->order_by('b.acctCode');
		$this->db->group_by('a.year');
		$this->db->group_by('a.period');
		$this->db->group_by('b.acctCode');
		$this->db->from('comp_chart_of_acct b');
		$this->db->join('comp_acc_det a', 'a.acctID = b.ID and a.year ='.$year .' and a.period ='.$period, 'left outer');
		$this->db->join('comp_acc_det c', 'b.ID = c.acctID and CONCAT(c.year,if(c.period<=9, CONCAT("0",c.period),c.period)) <= '.$year.sprintf('%02d', $period), 'left outer');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function AcctDet_allfy1_period($year, $period){
		$this->db->select('a.amountdr as thismonthdr');
		$this->db->select('a.amountcr as thismonthcr');
		$this->db->select('a.total');
		$this->db->select('b.*');
		$this->db->select('sum(c.amountdr) as yeardebit');
		$this->db->select('sum(c.amountcr) as yearcredit');
		$this->db->where('b.companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->order_by('b.acctCode');
		$this->db->group_by('a.year');
		$this->db->group_by('a.period');
		$this->db->group_by('b.acctCode');
		$this->db->from('comp_chart_of_acct b');
		$this->db->join('comp_acc_det a', 'a.acctID = b.ID and a.year ='.$year .' and a.period ='.$period, 'left outer');
		$this->db->join('comp_acc_det c', 'b.ID = c.acctID and CONCAT(c.year,if(c.period<=9, CONCAT("0",c.period),c.period)) < '.$year.sprintf('%02d', $period), 'left outer');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function AcctDet_allfy1_period_acctNo($year, $period, $acctNo){
		$this->db->select('a.amountdr as thismonthdr');
		$this->db->select('a.amountcr as thismonthcr');
		$this->db->select('a.total');
		$this->db->select('b.*');
		$this->db->select('sum(c.amountdr) as yeardebit');
		$this->db->select('sum(c.amountcr) as yearcredit');
		$this->db->where('b.companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('b.ID', $acctNo);
		$this->db->order_by('b.acctCode');
		$this->db->group_by('a.year');
		$this->db->group_by('a.period');
		$this->db->group_by('b.acctCode');
		$this->db->from('comp_chart_of_acct b');
		$this->db->join('comp_acc_det a', 'a.acctID = b.ID and a.year ='.$year .' and a.period ='.$period, 'left outer');
		$this->db->join('comp_acc_det c', 'b.ID = c.acctID and CONCAT(c.year,if(c.period<=9, CONCAT("0",c.period),c.period)) < '.$year.sprintf('%02d', $period), 'left outer');
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return false;
		}
	}
	
	public function accountDet(){
		$where = "(acctTypeID = 1 OR acctTypeID = 2)";
		$this->db->where('companyID', element('compID', $this->session->userdata('logged_in')));
		$this->db->where('parentID', 0);
		$this->db->where($where);
		$this->db->order_by('acctTypeID');
		$this->db->order_by('parentID');
		$this->db->order_by('orderNo');
		$query = $this->db->get('comp_acct_group');
		if($query->num_rows() >= 1){
			return $query->result();
		}else{
			return FALSE;
		}
	}
}
/* End of file compAcctDet.php */
/* Location: ./application/model/compAcctDet.php */
/* Created By : Yahaya Abdollah */
