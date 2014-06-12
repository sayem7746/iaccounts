<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Term extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Useraccess');
		$query = $this->Useraccess->useraccess_id_module2('10', 'setup');
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
		echo 'default index term controller';		
	}

	//TermSetup
	public function TermSetup()
	{
	  if($this->input->post('mysubmit')){
		  $this->load->model('Term_model');
		  if($this->input->post('termID')==NULL){
			  $newterm = array( 
			  	'termName'		=> $this->input->post('termName'), 
			  	'termDescription'		=> $this->input->post('termDescription'),
			  	'dueDays'		=> $this->input->post('dueDays'), 
			  	'termStatusID'		=> $this->input->post('termStatusID'), 
			  	'createdBy'		=> $this->input->post('createdBy'), 
			  	'updatedBy'		=> $this->input->post('updatedBy'),
		  	);
			
		  	$insert_term = $this->Term_model->term_insert($newterm);
			if($insert_term){
				echo '<script>alert("Insert Term and Condition Success..");
				window.location.replace("termlist");
				</script>';
			}else{
				echo '<script>alert("Insert Term and Condition Failed.");
				history.go(-1);</script>';
			}
		  }
		  else{
			  
			$ID = $this->input->post('termID');
		  	$editterm = array(
			  	'termName'		=> $this->input->post('termName'), 
			  	'termDescription'		=> $this->input->post('termDescription'),
			  	'dueDays'		=> $this->input->post('dueDays'), 
			  	'termStatusID'		=> $this->input->post('termStatusID'), 
			  	'createdBy'		=> $this->input->post('createdBy'), 
			  	'updatedBy'		=> $this->input->post('updatedBy'),
		  	);
			$this->load->model('Term_model');
		  	$edit_term = $this->Term_model->term_edit($editterm, $ID);
			if($edit_term){
				echo '<script>alert("Update Term and Condition Success..");
				window.location.replace("termlist");
				</script>';
			}else{
				echo '<script>alert("Insert Term and Condition Failed.");
				history.go(-1);</script>';
			}
		  }
	  } else {     
		$ID = isset($_REQUEST['ID'])?$_REQUEST['ID']:"";
		$this->lang->load("term",$this->session->userdata('language'));
		$this->load->model('Term_model');
		$dataum = $this->Term_model->term_id($ID);
		$this->load->model('master/masterCode_model');
		$filter['masterID']=1;
		$data['termstatus'] = $this->masterCode_model->get_all($filter);;
		$data['tmaster'] = $dataum[0];
		$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
			->add_includes('js/validationengine/jquery.validationEngine.js');

			$this->layouts->view('terms/termmaster', array('latest' => 'sidebar/latest'), $data);
	
	  }
	}
	public function term_newform(){
			$this->load->model('Term_Model');
			
			$this->load->model('master/masterCode_model');
			$filter['masterID']=1;
			$data['termstatus'] = $this->masterCode_model->get_all($filter);
			
		$ID = isset($_REQUEST['ID'])?$_REQUEST['ID']:"";
		//$this->lang->load("terms",$this->session->userdata('language'));
		$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-en.js')
			->add_includes('js/validationengine/jquery.validationEngine.js');
		if($ID >= '0'){
			$this->layouts->view('terms/termmaster_edit', array('latest' => 'sidebar/latest'), $data);				
		}else{
			$this->layouts->view('terms/termmaster', array('latest' => 'sidebar/latest'), $data);
		}
	}

	public function term_delete(){
		$this->load->model('Term_model');
		  	$deleteterm = array('is_delete' => '1');
			$ID = isset($_REQUEST['ID'])?$_REQUEST['ID']:"";
			
		  	$delete_term = $this->Term_model->term_delete($deleteterm, $ID);
			if($delete_term){
						echo '<script>alert("Delete Success..");
						window.location.replace("termlist");
						</script>';
			}else{
				return FALSE;
			}
	}

	public function term_edit(){
			$this->load->model('Term_Model');
		  	$updateterm = array('is_delete' => '1');
			$ID = $this->input->post('ID');
		  	$updateterm = $this->Term->term_edit($updateterm,$ID);
			if($updateterm){
				return TRUE;
			}else{
				return FALSE;
			}
	}
	public function getItemCodes(){
		$JsonRecords = '[';
		$i= 0;
		$this->load->model('item/itemSetup_model');
		//$default = $this->itemSetup_model->get_byCode($this->input->post('itemCode'));
		$default = $this->itemSetup_model->get_all();
		$n = sizeof($default);
		 foreach($default as $row){
			$JsonRecords .= '&quot;'.$row->itemCode.'&quot;';
			if ($i < $n - 1)
				$JsonRecords .= ',';
			$i++;
		}
		 $JsonRecords .= ']';
		 return $JsonRecords;
	}
	
	function getTermDescription(){
		$this->load->model('terms/terms_model');	
		$JsonRecords = '';
		$default = $this->terms_model->terms_id($this->input->post('term'));
		if ($default!=false)
		{
			 foreach($default as $row)
				$JsonRecords =  $row->termDescription;
		     echo $JsonRecords;
		}else
			echo "Term not found";
	}
	
	public function refreshTerms(){
		//for ajax call 
		$this->load->model('Terms/terms_model');
			$terms = $this->terms_model->terms_all();
		
		//json_encode ($this->project_model->project_all());
		
		$JsonRecords = '{"records":[';
		$n = sizeof($terms);
		$i= 0;
		 foreach($terms as $row){
			$JsonRecords .= '{';
			$JsonRecords .= '"termName":"' . $row->termName.'","id":"'.$row->ID.'"';
			$JsonRecords .= '}';
			if ($i < $n - 1)
				$JsonRecords .= ',';
			$i++;
		}
		$JsonRecords .= ']}';

		//$resul= '{"supplier":['. json_encode($this->supplier_model->suppliermaster_all()).']}';
		 echo $JsonRecords;
	}
	
	public function termlist(){
			$this->lang->load("term",$this->session->userdata('language'));
			$this->load->model('Term_model');
			$data['datatbls'] = $this->Term_model->term_all();
			$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
			$this->layouts->view('terms/termlist', array('latest' => 'sidebar/latest'), $data);
	}
	
	
}
    
	
?>