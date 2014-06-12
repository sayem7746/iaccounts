<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gltransaction extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Useraccess');
		$query = $this->Useraccess->useraccess_id_module2('9', 'transaction');
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
	
	public function journal(){
	  if($this->input->post('mysubmit')){
	  }else{
		$data = '';
		$this->load->library('table');
		$this->lang->load("journal",$this->session->userdata('language'));
		$this->load->model('Chartofaccount');
		$data['chartAccounts'] = $this->Chartofaccount->chartofaccount_all();
		$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
			 ->add_includes('js/validationengine/jquery.validationEngine.js')
		  	 ->add_includes('js/datatables/jquery.dataTables.min.js');
		$data['datatbls'] = NULL;
		$this->layouts->view('gl/transactions/journal_new', array('latest' => 'sidebar/latest'), $data);
	  }
	}

// Journal Copy ( Duplicate) **** Start	
	public function journalCopy(){
		$add_year = $this->uri->segment(3);
		$add_period = $this->uri->segment(4);
		if(!$add_year){
			$add_year = date("Y");
		}
		if(!$add_period){
			$add_period = date("m");
		}
		$this->lang->load("journalcopy",$this->session->userdata('language'));
		$this->load->model('Journal');
		$this->load->model('Compfinancialyear');
		$data['yrs'] = range(date('Y'), 1900);
		$data['selyear'] = $add_year;
		$data['selper'] = $add_period;
		$data['period'] = $this->Compfinancialyear->financialYear_year($add_year);
		$data['datatbls'] = $this->Journal->journal_all_yearperiod($add_year, $add_period);
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('gl/transactions/journalList', array('latest' => 'sidebar/latest'), $data);
	}
	
	public function jlCopy(){
		$journalID = $this->uri->segment(3);
		$this->load->model('Journal');
		$query = $this->Journal->journal_ID($journalID);
		$data['orijournal'] = $query[0];
		$this->lang->load("journalcopy",$this->session->userdata('language'));
		$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
			 ->add_includes('js/validationengine/jquery.validationEngine.js');
		$this->layouts->view('gl/transactions/jlcopy', array('latest' => 'sidebar/latest'), $data);
	}
	
	public function journal_copy_save(){
		$this->load->model('Journal');
		$this->load->model('Glseq');
		$query1 = $this->Glseq->glSequence_jl();
		$newData = array(
			'companyID' => element('compID', $this->session->userdata('logged_in')),
			'journalID' => $query1['seqNumber'],
			'description' => $this->input->post('description'),
			'module' => '1',
			'effective_date' => date("Y-m-d", strtotime($this->input->post('effdate'))),
			'year' => $query1['financialYear'],
			'period' => $query1['period'],
			'createdBy' => element('userid', $this->session->userdata('logged_in'))
		);
		$query2 = $this->Journal->journal_insert($newData);
		$query3 = $this->Journal->journaldetails_copy($query1['seqNumber']);
    	print json_encode(array("status"=>"success", "message"=>$query2, "journalID"=>$query1['seqNumber']));

	}
// Journal Copy ( Duplicate) **** end

// Journal Copy ( Reverse) **** Start
	public function reverse(){
		$add_year = $this->uri->segment(3);
		$add_period = $this->uri->segment(4);
		if(!$add_year){
			$add_year = date("Y");
		}
		if(!$add_period){
			$add_period = date("m");
		}
		$this->lang->load("journalreverse",$this->session->userdata('language'));
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
		$data['datatbls'] = $this->Journal->journal_all_yearperiod($add_year, $add_period);
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('gl/transactions/journalLists', array('latest' => 'sidebar/latest'), $data);
	}
	public function jlReverse(){
		$journalID = $this->uri->segment(3);
		$this->load->model('Journal');
		$query = $this->Journal->journal_ID($journalID);
		$data['orijournal'] = $query[0];
		$this->lang->load("journalreverse",$this->session->userdata('language'));
		$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
			 ->add_includes('js/validationengine/jquery.validationEngine.js');
		$this->layouts->view('gl/transactions/jlreverse', array('latest' => 'sidebar/latest'), $data);
	}
	
	public function journal_reverse_save(){
		$this->load->model('Journal');
		$this->load->model('Glseq');
		$query1 = $this->Glseq->glSequence_rv();
		$newData = array(
			'companyID' => element('compID', $this->session->userdata('logged_in')),
			'journalID' => $query1['seqNumber'],
			'description' => $this->input->post('description'),
			'module' => '1',
			'effective_date' => date("Y-m-d", strtotime($this->input->post('effdate'))),
			'year' => $query1['financialYear'],
			'period' => $query1['period'],
			'createdBy' => element('userid', $this->session->userdata('logged_in'))
		);
		$query2 = $this->Journal->journal_insert($newData);
		$query3 = $this->Journal->journaldetails_reverse($query1['seqNumber']);
    	print json_encode(array("status"=>"success", "message"=>$query2, "journalID"=>$query1['seqNumber']));

	}
// Journal Copy ( Reverse) **** end	
	
	public function journal_copy_edit(){
		$journalID = $this->uri->segment(3);
		$this->load->model('Journal');
		$this->load->library('table');
		$this->lang->load("journaledit",$this->session->userdata('language'));
		$this->load->model('Chartofaccount');
		$data['chartAccounts'] = $this->Chartofaccount->chartofaccount_all();
		$query = $this->Journal->journal_journalno($journalID);
		$data['journalHead'] = $query[0];
		$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
			 ->add_includes('js/validationengine/jquery.validationEngine.js')
		  	 ->add_includes('js/datatables/jquery.dataTables.min.js');
		$data['datatbls'] = NULL;
		$this->layouts->view('gl/transactions/journal_edit', array('latest' => 'sidebar/latest'), $data);
	}
	
	public function journal_head(){
		$this->load->model('Journal');
		$this->lang->load("journal",$this->session->userdata('language'));
		if($this->input->post('journalNo') == ''){
			$this->load->model('Glseq');
			$query = $this->Glseq->glSequence_jl();
			$newData = array(
				'companyID' => element('compID', $this->session->userdata('logged_in')),
				'journalID' => $query['seqNumber'],
				'description' => $this->input->post('description'),
				'module' => '1',
				'effective_date' => date("Y-m-d", strtotime($this->input->post('effdate'))),
				'year' => $query['financialYear'],
				'period' => $query['period'],
				'createdBy' => element('userid', $this->session->userdata('logged_in'))
			);
			$query2 = $this->Journal->journal_insert($newData);
    		print json_encode(array("status"=>"success", "message"=>$query));
		}else{
			$query2 = $this->Journal->journal_journalNo($this->input->post('journalNo'));
			if($query2 and $query2[0]->status == 0){
				$query3 = $this->Journal->journalDetails_journalno($this->input->post('journalNo'));
				if($query3){
					$i = 0;
					foreach($query3 as $row){
						$datatbls[$i] = $row;
						$i++;
					}
				}else{
					$datatbls = '';
				}
				$query['description'] = $query2[0]->description;
				$query['effdate'] = date("d-m-Y", strtotime($query2[0]->effective_date));
    			print json_encode(array(
					"status"=>"success1", 
					"message"=>$query,
					"journalID" => $this->input->post('journalNo'),
					"datatbls"=>$datatbls));
			}else{
    			print json_encode(array(
				"status"=>"failed", 
				"message"=>$this->lang->line('jlnumber') . " : " .  $this->input->post('journalNo') . " " . $this->lang->line('message7')));
			}
		}
	}
	
	public function getAccount(){
		$this->load->model('Chartofaccount');
		$this->load->model('Compfinancialyear');
		$query = $this->Chartofaccount->chartofaccount_all();
		if($query){
    		print json_encode(array("status"=>"success", "message"=>$query));
		}else{
		}
	}
	
	public function journaldetails_insert(){
		$this->load->model('Journal');
		$this->load->model('Compfinancialyear');
		$headdata = array(
			'total_amount_dr' => $this->input->post('amountdebit'),
			'total_amount_cr' => $this->input->post('amountcredit'),
			'total_amount' => $this->input->post('totalamount'),
		);
		$queryhead = $this->Journal->journal_update($this->input->post('journalNo'),$headdata);
		$querycal = $this->Compfinancialyear->compfinancialyear_date($this->input->post('effdate'));
		$datacal = $querycal[0];
		$newdata = array(
			'companyID' => element('compID', $this->session->userdata('logged_in')),
			'journalID' => $this->input->post('journalNo'),
			'sequence' => $this->input->post('sequence'),
			'description' => $this->input->post('description'),
			'acctCode' => $this->input->post('acctCode'),
			'year' => $datacal->financialYear,
			'period' => $datacal->period,
			'amount_cr' => $this->input->post('amountcr'),
			'amount_dr' => $this->input->post('amountdr'),
			'createdBy' => element('userid', $this->session->userdata('logged_in'))
		);
		$query = $this->Journal->journalDetails_insert($newdata);
		if($query){
			$query3 = $this->Journal->journalDetails_journalno($this->input->post('journalNo'));
			if($query3){
				$i = 0;
				foreach($query3 as $row){
					$datatbls[$i] = $row;
					$i++;
				}
			}else{
				$datatbls = '';
			}
   			print json_encode(array(
				"status"=>"success", 
				"message"=>'Journal details saved..',
				"datatbls"=>$datatbls));
		}else{ 
   			print json_encode(array("status"=>"failed", "message"=>'Journal details saved..'));
		}
	}
	
	public function journaldetails_save(){
			$this->load->model('Journal');
			$fldid = $this->input->post('fldid');
			$fieldname = $this->input->post('fieldname');
			$value = $this->input->post('content');
			$data = array($fieldname=>$value);
		  	$query = $this->Journal->journalDetails_save($fldid, $data);
			if($query){
				return TRUE;
			}else{
				return FALSE;
			} 
	}
	public function journaldetails_delete(){
			$this->load->model('Journal');
			$fldid = $this->input->post('fldid');
		  	$delete_menu = $this->Journal->journalDetails_delete($fldid);
			if($delete_menu){
				return TRUE;
			}else{
				return FALSE;
			}
	}
	public function accountSearch(){
		$this->load->model('CompanyChartAcct');
		$query = $this->CompanyChartAcct->chartAcct_all_asc();
		if($query){
   			print json_encode(array("status"=>"success", "message"=>$query));
		}else{
   			print json_encode(array("status"=>"failed", "message"=>'Journal details saved..'));
		}
	}
	
// Posting Journal start

	public function posting(){
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
		$data['datatbls'] = $this->Journal->journal_unpost_yearperiod($add_year, $add_period);
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('gl/transactions/journalPost', array('latest' => 'sidebar/latest'), $data);
	}
	public function journalPosting(){
		$ID = $this->input->post('fldid');
		$journalNo = $this->input->post('journalNo');
		$data = array(
			'status'=>'1'
		);
		$this->load->model('Journal');
		$query = $this->Journal->journal_save($ID, $journalNo, $data);
   		print json_encode(array("status"=>"success", "message"=>$query));
	}
// Posting Journal end
}

	
/* End of file gltransaction.php */
/* Location: ./application/controller/gltransaction.php */
