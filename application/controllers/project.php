<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('menu');
	}

	public function index()
	{   		
		echo 'default index project controller';		
	}

	//New Project Setup
	//Created:Farhana
	
	public function ProjectSetup() 
	{
	  if($this->input->post('mysubmit')){
		  if($this->input->post('ID')==NULL){
			  $newproject = array(
			  	'ID'		=> $this->input->post('ID'), 
			  	'companyID'		=> element('compID', $this->session->userdata('logged_in')), 
			  	'project_name'		=> $this->input->post('project_name'), 
			  	'projectManagerID'		=> $this->input->post('projectManagerID'),
				'totalBudget'		=> $this->input->post('totalBudget'),
				'remarks'		=> $this->input->post('remarks'),
				'updatedBy'		=> $this->input->post('updatedBy'),
		  	);
			$this->load->model('project/project_model');
		  	$insert_project = $this->project_model->project_insert($newproject);
			if($insert_project){
				echo '<script>alert("Insert Data Success..");
				window.location.replace("projectlist");
				</script>';
			}else{
				echo '<script>alert("Insert Data Failed.");
				history.go(-1);</script>';
			}
		  }
		  else{
			  
			$ID = $this->input->post('ID');
		  	$newproject = array(
			   	'ID'		=> $this->input->post('ID'), 
			  	'companyID'		=> element('compID', $this->session->userdata('logged_in')), 
			  	'project_name'		=> $this->input->post('project_name'), 
			  	'projectManagerID'		=> $this->input->post('projectManagerID'),
				'totalBudget'		=> $this->input->post('totalBudget'),
				'remarks'		=> $this->input->post('remarks'),
				'updatedBy'		=> $this->input->post('updatedBy'),
		  	);
			$this->load->model('project/project_model');
			$insert_project = $this->project_model->project_edit($newproject, $ID);
			if($insert_project){
				echo '<script>alert("Update Success..");
					window.location.replace("projectlist");
					</script>';
			}else{
				echo '<script>alert("Update Failed.");
				history.go(-1);</script>';
			}
		  }
	} else {     
		$ID = isset($_REQUEST['ID'])?$_REQUEST['ID']:"";
		$this->lang->load("project",$this->session->userdata('language'));
		$this->load->library('layouts');
		$this->load->helper('form');
		$this->layouts->set_title('Change Management');
	   	$data['module'] = 'Administration';
	  	$data['title'] = 'New Project Setup';
		$this->load->model('project/project_model');	
		
		$this->layouts->add_includes('js/validationengine/languages/jquery.validationEngine-'.$this->session->userdata('language').'.js')
			->add_includes('js/validationengine/jquery.validationEngine.js');
			
		if($ID >= '0'){
			$dataum = $this->project_model->project_id($ID);
			$data['project'] = $dataum[0];
			$this->layouts->view('project/add_new', array('latest' => 'sidebar/latest'), $data);
		
		}else{
			
			$data['project'] = '';
			$this->layouts->view('project/add_new', array('latest' => 'sidebar/latest'), $data);
		}
						
			}
		
	}
		public function project_delete(){
		$this->load->model('project/project_model');
		  	$deleteproject = array('is_delete' => '1');
			$ID = isset($_REQUEST['ID'])?$_REQUEST['ID']:"";
		  	$deleteproject = $this->project_model->project_delete($deleteproject, $ID);
			if($deleteproject){
				return TRUE;
			}else{
				return FALSE;
			}
	}
	
	    public function project_edit()
	    {
		$this->load->model('project/project_model');
		$updateproject = array('is_delete' => '1');
		$ID = $this->input->post('ID');
		 $updateproject = $this->project_model->project_edit($updateproject,$ID);
			if($updateproject){
				return TRUE;
			}else{
				return FALSE;
			}
	}
	  public function projectlist(){
		$this->lang->load("project",$this->session->userdata('language'));
		$this->load->library('layouts');
		$this->load->helper('form');
		$this->load->helper('menu');
		$this->load->model('project/project_model');
		$data['datatbls'] = $this->project_model->project_all();
		$data['headertbl'] = $this->session->userdata('menuactive');
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('project/list', array('latest' => 'sidebar/latest'), $data);
	}
		
		
		//IS used in po transaction, debit note
		public function refreshProject(){
		//for ajax call 
		$this->load->model('project/project_model');
		$project = $this->project_model->project_all();
		
		//json_encode ($this->project_model->project_all());
		
		$JsonRecords = '{"records":[';
		$n = sizeof($project);
		$i= 0;
		 foreach($project as $row){
			$JsonRecords .= '{';
			$JsonRecords .= '"id":"'.$row->ID.'","projectName":"' . $row->project_name.'"';
			$JsonRecords .= '}';
			if ($i < $n - 1)
				$JsonRecords .= ',';
			$i++;
		}
		$JsonRecords .= ']}';

		//$resul= '{"supplier":['. json_encode($this->supplier_model->suppliermaster_all()).']}';
		 echo $JsonRecords;
	}
		
	}
    
	  
    
	
?>