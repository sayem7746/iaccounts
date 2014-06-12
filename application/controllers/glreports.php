<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Glreports extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Useraccess');
		$query = $this->Useraccess->useraccess_id_module2('9', 'reports');
		if(!$query){
			echo '<script>alert("Not authorised..");
				window.location.replace("'.base_url().'Error");
				</script>';
		}
		$this->load->library('layouts');
		$this->load->model('menu');
	}

	public function index()
	{
		
	}
	
// Account Balance Summary
	public function accountBalanceSummary(){
		$add_year = $this->uri->segment(3);
		$add_period = $this->uri->segment(4);
		$acctNo = $this->uri->segment(5);
		if(!$add_year){
			$add_year = date("Y");
		}
		if(!$add_period){
			$add_period = date("m");
		}
		$this->lang->load("accountbalance",$this->session->userdata('language'));
		$this->load->model('Compfinancialyear');
		$this->load->model('CompAcctDet');
		$this->load->model('Journal');
		$this->load->model('Chartofaccount');
		$data['yrs'] = range(date('Y'), 1900);
		$data['selyear'] = $add_year;
		$data['selper'] = $add_period;
		$data['acctNo'] = $acctNo;
		$query = $this->Compfinancialyear->financialYear_year($add_year);
		if($query){
			$data['period'] = $query;
		}else{
			$data['period'] = NULL;
		}
		if($acctNo == ''){
			$query = $this->CompAcctDet->AcctDet_allfy1_period($add_year, $add_period);
		}else{
			$query = $this->CompAcctDet->AcctDet_allfy1_period_acctNo($add_year, $add_period, $acctNo);
		}
		if($query) {
			$data['datatbls'] = $query;
			$data['datatbls1'] = $this->Journal->journalDetails_yearperiodacctNo($add_year, $add_period, $acctNo);
		}else{
			$data['datatbls1'] = '';
			$data['datatbls'] = $query;
		}
		$data['chartAccounts'] = $this->Chartofaccount->chartofaccount_all();
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('gl/reports/accountsummary', array('latest' => 'sidebar/latest'), $data);
	}
	
	public function accountBalanceSummary_print(){
		$add_year = $this->uri->segment(3);
		$add_period = $this->uri->segment(4);
		$acctNo = $this->uri->segment(5);
		$this->load->model('CompAcctDet');
		$this->lang->load("accountbalance",$this->session->userdata('language'));
		$this->load->model('Journal');
		if(!$add_year){
			$add_year = date("Y");
		}
		if(!$add_period){
			$add_period = date("m");
		}
		if($acctNo == ''){
			$query = $this->CompAcctDet->AcctDet_allfy1_period($add_year, $add_period);
		}else{
			$query = $this->CompAcctDet->AcctDet_allfy1_period_acctNo($add_year, $add_period, $acctNo);
		}
		if($query) {
			$data['datatbls'] = $query;
			$data['datatbls1'] = $this->Journal->journalDetails_yearperiodacctNo($add_year, $add_period, $acctNo);
		}else{
			$data['datatbls1'] = '';
			$data['datatbls'] = $query;
		}
		$data['year'] = $add_year;
		$data['period'] = $add_period;
		$data['acctNo'] = $acctNo;
		$this->load->view('gl/reports/accountsummary_print', $data);
	}
	
	public function accountBalanceSummary_excel(){
        //place where the excel file is created
        $this->load->library('parser');
 
        //load required data from database
		$add_year = $this->uri->segment(3);
		$add_period = $this->uri->segment(4);
		$acctNo = $this->uri->segment(5);
		$prn = $this->uri->segment(5);
		$this->load->model('CompAcctDet');
		$this->lang->load("accountbalance",$this->session->userdata('language'));
		$this->load->model('Journal');
		if(!$add_year){
			$add_year = date("Y");
		}
		if(!$add_period){
			$add_period = date("m");
		}
		if($acctNo == ''){
			$query = $this->CompAcctDet->AcctDet_allfy1_period($add_year, $add_period);
		}else{
			$query = $this->CompAcctDet->AcctDet_allfy1_period_acctNo($add_year, $add_period, $acctNo);
		}
		if($query) {
			$data['datatbls'] = $query;
			$data['datatbls1'] = $this->Journal->journalDetails_yearperiodacctNo($add_year, $add_period, $acctNo);
		}else{
			$data['datatbls1'] = '';
			$data['datatbls'] = $query;
		}
		$data['year'] = $add_year;
		$data['period'] = $add_period;
		$data['acctNo'] = $acctNo;
        $myFile = "Account_Balance_Summary(".$add_year."_".$add_period.").xls";
 
        //pass retrieved data into template and return as a string
        $stringData = $this->parser->parse('gl/reports/accountsummary_excel', $data, true);
 
        //open excel and write string into excel
        $fh = fopen($myFile, 'w') or die("can't open file");
        fwrite($fh, $stringData);
 
        fclose($fh);
        //download excel file
        $this->downloadExcel($myFile);
	}

// Trial Balance
	public function trialBalance(){
		$this->lang->load("tb",$this->session->userdata('language'));
		$this->load->model('Compfinancialyear');
		$this->load->model('CompAcctGroup_model');
		$data['yrs'] = range(date('Y'), 1900);
			$add_year = date("Y");
		$query = $this->Compfinancialyear->financialYear_year($add_year);
		if($query){
			$data['period'] = $query;
		}else{
			$data['period'] = NULL;
		}
		$data['datatbls'] = $this->CompAcctGroup_model->companyacctgroup_all();
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('gl/reports/tb', array('latest' => 'sidebar/latest'), $data);
	}
	
	public function get_TrialBalance_year()
	{
		$year = $this->uri->segment(3);
		$this->load->model('Compfinancialyear');
		$query = $this->Compfinancialyear->financialYear_year($year);
//		var_dump($query);
		if($query){
			print json_encode(array(
				"status"=>"success", 
				"message"=>$query, 
				));
		}
		else{
			print json_encode(array("status"=>"false", "message"=>''));
		}
	}
	
	public function trialBalance_print(){
		$add_year = $this->uri->segment(3);
		$add_period = $this->uri->segment(4);
		$data['selyear'] = $add_year;
		$data['selper'] = $add_period;
		$this->lang->load("tb",$this->session->userdata('language'));
		$this->load->model('CompAcctDet');
		$data['datatbls'] = $this->CompAcctDet->AcctDet_allfy_period($add_year, $add_period);
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('gl/reports/tb_print', array('latest' => 'sidebar/latest'), $data);
	}
	public function trialBalance_print1(){
		$add_year = $this->uri->segment(3);
		$add_period = $this->uri->segment(4);
		$data['selyear'] = $add_year;
		$data['selper'] = $add_period;
		$this->lang->load("tb",$this->session->userdata('language'));
		$this->load->model('CompAcctDet');
		$data['datatbls'] = $this->CompAcctDet->AcctDet_allfy_period($add_year, $add_period);
		$this->load->view('gl/reports/tb_print1', $data);
	}
	
	public function tb_excel(){
        //place where the excel file is created
        $this->load->library('parser');
 
        //load required data from database
		$add_year = $this->uri->segment(3);
		$add_period = $this->uri->segment(4);
		$prn = $this->uri->segment(5);
		$this->lang->load("tb",$this->session->userdata('language'));
		$this->load->model('CompAcctDet');
		$add_year = $this->uri->segment(3);
		$add_period = $this->uri->segment(4);
		$data['datatbls'] = $this->CompAcctDet->AcctDet_allfy_period($add_year, $add_period);
        $myFile = "Trial_balance(".$add_year."_".$add_period.").xls";
 
        //pass retrieved data into template and return as a string
        $stringData = $this->parser->parse('gl/reports/tb_excel', $data, true);
 
        //open excel and write string into excel
        $fh = fopen($myFile, 'w') or die("can't open file");
        fwrite($fh, $stringData);
 
        fclose($fh);
        //download excel file
        $this->downloadExcel($myFile);
	}
	public function trialbalanceFiscalyear(){
		$this->lang->load("tb",$this->session->userdata('language'));
		$this->load->model('Compfinancialyear');
		$this->load->model('CompAcctGroup_model');
		$data['yrs'] = range(date('Y'), 1900);
		$data['period'] = $this->Compfinancialyear->financialCalendar_all();
		$data['datatbls'] = $this->CompAcctGroup_model->companyacctgroup_all();
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('gl/reports/tbfc', array('latest' => 'sidebar/latest'), $data);
	}
	public function trialbalanceFiscalyear_print(){
		$add_year = $this->uri->segment(3);
		$data['selyear'] = $add_year;
		$this->lang->load("tb",$this->session->userdata('language'));
		$this->load->model('CompAcctDet');
		$data['datatbls'] = $this->CompAcctDet->AcctDet_allfy($add_year);
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('gl/reports/tbyear_print', array('latest' => 'sidebar/latest'), $data);
	}
	public function trialbalanceFiscalyear_print1(){
		$add_year = $this->uri->segment(3);
		$data['selyear'] = $add_year;
		$this->lang->load("tb",$this->session->userdata('language'));
		$this->load->model('CompAcctDet');
		$data['datatbls'] = $this->CompAcctDet->AcctDet_allfy($add_year);
		$this->load->view('gl/reports/tbyear_print1', $data);
	}
	public function tbfy_excel(){
        //place where the excel file is created
        $this->load->library('parser');
 
        //load required data from database
		$add_year = $this->uri->segment(3);
		$prn = $this->uri->segment(5);
		$this->lang->load("tb",$this->session->userdata('language'));
		$this->load->model('CompAcctDet');
		$add_year = $this->uri->segment(3);
		$add_period = $this->uri->segment(4);
		$data['datatbls'] = $this->CompAcctDet->AcctDet_allfy($add_year);
        $myFile = "Trial_balance(".$add_year.").xls";
 
        //pass retrieved data into template and return as a string
        $stringData = $this->parser->parse('gl/reports/tbfy_excel', $data, true);
 
        //open excel and write string into excel
        $fh = fopen($myFile, 'w') or die("can't open file");
        fwrite($fh, $stringData);
 
        fclose($fh);
        //download excel file
        $this->downloadExcel($myFile);
	}
// Financial Position	
	public function financialposition(){
		$this->lang->load("bs",$this->session->userdata('language'));
		$add_year = $this->uri->segment(3);
		if(!$add_year){
			$add_year = date("Y");
		}
		$this->load->model('Compfinancialyear');
		$this->load->model('CompAcctGroup_model');
		$this->load->model('CompAcctDet');
		$this->load->model('Journal');
		$this->load->model('Retainedearning');
		$data['yrs'] = range(date('Y'), 1900);
		$data['selyear'] = $add_year;
		$data['period'] = $this->Compfinancialyear->financialYear_year($add_year);
		$data['accountGroup'] = $this->CompAcctGroup_model->companyacctgroup_parentID();
		$data['groupdetails'] = $this->CompAcctGroup_model->companyacctgroup_subID();
		$data['accountdetails'] = $this->CompAcctDet->AcctDet_allfy($add_year);
		$accountGroupPNL = $this->CompAcctGroup_model->companyacctgroup_parentID_PNL();
		$groupdetailsPNL = $this->CompAcctGroup_model->companyacctgroup_subID_PNL();
		$data['currentretained'] = $this->Retainedearning->CurrentYear($accountGroupPNL, $groupdetailsPNL, $data['accountdetails']);
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('gl/reports/bs', array('latest' => 'sidebar/latest'), $data);
	}
	
	public function financialposition_print(){
		$this->lang->load("bs",$this->session->userdata('language'));
		$add_year = $this->uri->segment(3);
		if(!$add_year){
			$add_year = date("Y");
		}
		$this->load->model('Compfinancialyear');
		$this->load->model('CompAcctGroup_model');
		$this->load->model('CompAcctDet');
		$this->load->model('Journal');
		$this->load->model('Retainedearning');
		$data['year'] = $add_year;
		$data['period'] = $this->Compfinancialyear->financialYear_year($add_year);
		$data['accountGroup'] = $this->CompAcctGroup_model->companyacctgroup_parentID();
		$data['groupdetails'] = $this->CompAcctGroup_model->companyacctgroup_subID();
		$data['accountdetails'] = $this->CompAcctDet->AcctDet_allfy($add_year);
		$accountGroupPNL = $this->CompAcctGroup_model->companyacctgroup_parentID_PNL();
		$groupdetailsPNL = $this->CompAcctGroup_model->companyacctgroup_subID_PNL();
		$data['currentretained'] = $this->Retainedearning->CurrentYear($accountGroupPNL, $groupdetailsPNL, $data['accountdetails']);
		$this->load->view('gl/reports/bs_print', $data);
	}
	
	public function financialPosition_excel(){
        //place where the excel file is created
        $this->load->library('parser');
 
        //load required data from database
		$this->lang->load("bs",$this->session->userdata('language'));
		$add_year = $this->uri->segment(3);
		if(!$add_year){
			$add_year = date("Y");
		}
		$this->load->model('Compfinancialyear');
		$this->load->model('CompAcctGroup_model');
		$this->load->model('CompAcctDet');
		$this->load->model('Journal');
		$this->load->model('Retainedearning');
		$data['year'] = $add_year;
		$data['period'] = $this->Compfinancialyear->financialYear_year($add_year);
		$data['accountGroup'] = $this->CompAcctGroup_model->companyacctgroup_parentID();
		$data['groupdetails'] = $this->CompAcctGroup_model->companyacctgroup_subID();
		$data['accountdetails'] = $this->CompAcctDet->AcctDet_allfy($add_year);
		$accountGroupPNL = $this->CompAcctGroup_model->companyacctgroup_parentID_PNL();
		$groupdetailsPNL = $this->CompAcctGroup_model->companyacctgroup_subID_PNL();
		$data['currentretained'] = $this->Retainedearning->CurrentYear($accountGroupPNL, $groupdetailsPNL, $data['accountdetails']);
        $myFile = "Finacial_Position_For_(".$add_year.").xls";
 
        //pass retrieved data into template and return as a string
        $stringData = $this->parser->parse('gl/reports/bs_excel', $data, true);
 
        //open excel and write string into excel
        $fh = fopen($myFile, 'w') or die("can't open file");
        fwrite($fh, $stringData);
 
        fclose($fh);
        //download excel file
        $this->downloadExcel($myFile);
	}
// Income Statement	
	public function profitNloss(){
		$this->lang->load("pnl",$this->session->userdata('language'));
		$this->load->model('Compfinancialyear');
		$this->load->model('CompAcctGroup_model');
		$this->load->model('CompAcctDet');
		$this->load->model('Journal');
		$add_year = $this->uri->segment(3);
		$add_period = $this->uri->segment(4);
		if(!$add_year){
			$add_year = date("Y");
		}
		if(!$add_period){
			$add_period = date("m");
		}
		$data['yrs'] = range(date('Y'), 1900);
		$data['selyear'] = $add_year;
		$data['period'] = $this->Compfinancialyear->financialYear_year($add_year);
		$data['accountGroup'] = $this->CompAcctGroup_model->companyacctgroup_parentID_PNL();
		$data['groupdetails'] = $this->CompAcctGroup_model->companyacctgroup_subID_PNL();
		$data['accountdetails'] = $this->CompAcctDet->AcctDet_allfypnl($add_year);
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('gl/reports/pnl', array('latest' => 'sidebar/latest'), $data);
	}

	public function profitNloss_print(){
		$this->lang->load("pnl",$this->session->userdata('language'));
		$add_year = $this->uri->segment(3);
		if(!$add_year){
			$add_year = date("Y");
		}
		$this->load->model('Compfinancialyear');
		$this->load->model('CompAcctGroup_model');
		$this->load->model('CompAcctDet');
		$this->load->model('Journal');
		$data['year'] = $add_year;
		$data['period'] = $this->Compfinancialyear->financialYear_year($add_year);
		$data['accountGroup'] = $this->CompAcctGroup_model->companyacctgroup_parentID_PNL();
		$data['groupdetails'] = $this->CompAcctGroup_model->companyacctgroup_subID_PNL();
		$data['accountdetails'] = $this->CompAcctDet->AcctDet_allfypnl($add_year);
		$this->load->view('gl/reports/pnl_print', $data);
	}
	
	public function profitNloss_excel(){
        //place where the excel file is created
        $this->load->library('parser');
 
        //load required data from database
		$this->lang->load("pnl",$this->session->userdata('language'));
		$add_year = $this->uri->segment(3);
		if(!$add_year){
			$add_year = date("Y");
		}
		$this->load->model('Compfinancialyear');
		$this->load->model('CompAcctGroup_model');
		$this->load->model('CompAcctDet');
		$this->load->model('Journal');
		$data['year'] = $add_year;
		$data['period'] = $this->Compfinancialyear->financialYear_year($add_year);
		$data['accountGroup'] = $this->CompAcctGroup_model->companyacctgroup_parentID_PNL();
		$data['groupdetails'] = $this->CompAcctGroup_model->companyacctgroup_subID_PNL();
		$data['accountdetails'] = $this->CompAcctDet->AcctDet_allfypnl($add_year);
		
        $myFile = $this->lang->line('title1')."(".$add_year.").xls";
 
        //pass retrieved data into template and return as a string
        $stringData = $this->parser->parse('gl/reports/pnl_excel', $data, true);
 
        //open excel and write string into excel
        $fh = fopen($myFile, 'w') or die("can't open file");
        fwrite($fh, $stringData);
 
        fclose($fh);
        //download excel file
        $this->downloadExcel($myFile);
	}

// Journal	
	public function postedjournal(){
		$add_year = $this->uri->segment(3);
		$add_period = $this->uri->segment(4);
		if(!$add_year){
			$add_year = date("Y");
		}
		if(!$add_period){
			$add_period = date("m");
		}
		$this->lang->load("journalpost",$this->session->userdata('language'));
		$this->load->model('Journal');
		$this->load->model('Compfinancialyear');
		$data['yrs'] = range(date('Y'), 1900);
		$data['selyear'] = $add_year;
		$data['selper'] = $add_period;
		$query = $this->Compfinancialyear->financialYear_year($add_year);
		if($query){
			$data['period'] = $query;
		}else{
			$data['period'] = NULL;
		}
		$data['datatbls'] = $this->Journal->journal_posted_yearperiod($add_year, $add_period);
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('gl/reports/postedjournal', array('latest' => 'sidebar/latest'), $data);
	}
	
	public function unpostedjournal(){
		$add_year = $this->uri->segment(3);
		$add_period = $this->uri->segment(4);
		if(!$add_year){
			$add_year = date("Y");
		}
		if(!$add_period){
			$add_period = date("m");
		}
		$this->lang->load("journalunpost",$this->session->userdata('language'));
		$this->load->model('Journal');
		$this->load->model('Compfinancialyear');
		$data['yrs'] = range(date('Y'), 1900);
		$data['selyear'] = $add_year;
		$data['selper'] = $add_period;
		$query = $this->Compfinancialyear->financialYear_year($add_year);
		if($query){
			$data['period'] = $query;
		}else{
			$data['period'] = NULL;
		}
		$data['datatbls'] = $this->Journal->journal_unpost_yearperiod($add_year, $add_period);
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('gl/reports/unpostedjournal', array('latest' => 'sidebar/latest'), $data);
	}
	
	public function journalDetails(){
		$ID = $this->uri->segment(3);
		$this->load->model('Journal');
		$query = $this->Journal->journal_ID($ID);
		$data['datatbls'] = $this->Journal->journalDetails_journalno($query[0]->journalID);
		$data['journalHead'] = $query[0];
		$this->lang->load("journaldetails",$this->session->userdata('language'));
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('gl/reports/journal_details', array('latest' => 'sidebar/latest'), $data);
	}
	
	public function journalDetails1(){
		$ID = $this->uri->segment(3);
		$this->load->model('Journal');
		$query = $this->Journal->journal_journalno($ID);
		$data['datatbls'] = $this->Journal->journalDetails_journalno($query[0]->journalID);
		$data['journalHead'] = $query[0];
		$this->lang->load("journaldetails",$this->session->userdata('language'));
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('gl/reports/journal_details', array('latest' => 'sidebar/latest'), $data);
	}
	
// Account Details
// created by Yahaya

	public function accountDetails(){
		$ID = $this->uri->segment(3);
		$year = $this->uri->segment(4);
		$period = $this->uri->segment(5);
		$this->load->model('Journal');
		$this->load->model('CompanyChartAcct');
		$query = $this->CompanyChartAcct->chartAcct_id($ID);
		$data['datatbls'] = $this->Journal->journalDetails_accountyearperiod($ID, $year, $period);
		$data['accountHead'] = $query[0];
		$this->lang->load("accountDetails",$this->session->userdata('language'));
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('gl/reports/account_details', array('latest' => 'sidebar/latest'), $data);
	}
	public function accountDetailsfc(){
		$ID = $this->uri->segment(3);
		$year = $this->uri->segment(4);
		if($year == '')  $year = date("Y");;
		$this->load->model('Journal');
		$this->load->model('CompanyChartAcct');
		$query = $this->CompanyChartAcct->chartAcct_id($ID);
		$data['datatbls'] = $this->Journal->journalDetails_accountyear($ID, $year);
		$data['accountHead'] = $query[0];
		$this->lang->load("accountDetails",$this->session->userdata('language'));
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('gl/reports/account_details', array('latest' => 'sidebar/latest'), $data);
	}
	
// Budget
	public function budgetList(){
		$this->lang->load("budget",$this->session->userdata('language'));
		$this->load->model('Budget');
		$add_year = $this->uri->segment(3);
		if(!$add_year){
			$add_year = date("Y");
		}
		$data['selyear'] = $add_year;
		$data['budgetdetails'] = $this->Budget->budget_all_year($add_year);
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('gl/reports/budgetList', array('latest' => 'sidebar/latest'), $data);
	}
	public function BudgetList_print(){
		$this->lang->load("budget",$this->session->userdata('language'));
		$add_year = $this->uri->segment(3);
		if(!$add_year){
			$add_year = date("Y");
		}
		$this->load->model('Budget');
		$data['year'] = $add_year;
		$data['selyear'] = $add_year;
		$data['budgetdetails'] = $this->Budget->budget_all_year($add_year);
		$this->load->view('gl/reports/BudgetList_print', $data);
	}
	
	public function BudgetList_excel(){
        //place where the excel file is created
        $this->load->library('parser');
 
        //load required data from database
		$this->lang->load("budget",$this->session->userdata('language'));
		$add_year = $this->uri->segment(3);
		if(!$add_year){
			$add_year = date("Y");
		}
		$this->load->model('Budget');
		$data['year'] = $add_year;
		$data['budgetdetails'] = $this->Budget->budget_all_year($add_year);
		
        $myFile = $this->lang->line('titleexcel')."(".$add_year.").xls";
 
        //pass retrieved data into template and return as a string
        $stringData = $this->parser->parse('gl/reports/budgetlist_excel', $data, true);
 
        //open excel and write string into excel
        $fh = fopen($myFile, 'w') or die("can't open file");
        fwrite($fh, $stringData);
 
        fclose($fh);
        //download excel file
        $this->downloadExcel($myFile);
	}
// budget end
	
/* download created excel file */
    function downloadExcel($myFile) {
        header("Content-Length: " . filesize($myFile));
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename='.$myFile);
 
        readfile($myFile);
    }
}

	
/* End of file gltransaction.php */
/* Location: ./application/controller/gltransaction.php */
