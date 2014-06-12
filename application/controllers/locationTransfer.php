<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LocationTransfer extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->library('layouts');
		$this->load->helper('form');
		$this->load->helper('menu');
		$this->layouts->set_title('iAccount');		
		
		$this->load->model('master/masterCode_model');
		$this->load->model('Menu');
		$this->load->model('Location_transfer');
		$this->lang->load("loctransfer",$this->session->userdata('language'));	
	}
	
	public function index(){
		//Retrive location transfer informations
		$this->load->model('Location_transfer');
		$data['datatbls'] = $this->Location_transfer->get_loc_transfer_all(element('compID', $this->session->userdata('logged_in')));
		
		
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('locationtransfer/loctranslist', array('latest' => 'sidebar/latest'), $data);
	}
    
	public function get_items(){
		$this->load->model('item/ItemSetup_model');
		
		// URL structure = locationtransfer/get_items/item_ids/1-2-4-7
		$itemIds = explode('-',$this->uri->segment(4));
		$itemDetails = array();
		foreach($itemIds as $item){
			$temp = $this->ItemSetup_model->get_byID($item);
			$itemDetails[] =(array) $temp[0];
		}
		echo json_encode($itemDetails);
	}
	
	//Add location transfer
	public function add(){
		if($this->input->post('postloctrans')){
			//Insert Location Transfer informations
			$newloctrans = array(
				'companyID'			=> element('compID', $this->session->userdata('logged_in')), 
				'fromLocationID'	   => $this->input->post('fromLocationID'), 
				'toLocationID'		 => $this->input->post('toLocationID'),
				'formNo'			   => $this->input->post('formNo'),
				'movementTypeID'	   => $this->input->post('movementTypeID'),
				'dateTransfer'		 => date('Y-m-d',strtotime($this->input->post('selDateFrom'))),
				'memo'	   			 => $this->input->post('memo'),
				'createdTS'	   		=> date('Y-m-d G:i:s',time()),
			
			);
			
		  	$loctransId = $this->Location_transfer->insert($newloctrans);
			
			
			if($loctransId){
				//Insert items for location transfer
				$i = 0;
				foreach($this->input->post('itemList') as $item){
					$newloctransdetail = array(
						'locationTransferID'	=> $loctransId, 
						'itemID'	  	 	   => $item, 
						'quantity'		     => $_POST['quantity'][$i],
						'fromStock'			=> $_POST['stock'][$i],
						'createdTS'	   		=> date('Y-m-d G:i:s',time())				
					);
				
					$loctransDetailId = $this->Location_transfer->insertDetail($newloctransdetail);
					$i++;
				}
				
				echo '<script>alert("Insert Data Success..");
				window.location.replace("'.base_url().'/locationtransfer");
				</script>';
			}else{
				
				echo '<script>alert("Insert Data Failed.");
					history.go(-1); </script>';
			}
		}else{
			$this->load->library('layouts');
			$this->load->helper('form');
			$this->load->helper('menu');
			$this->load->model('master/masterCode_model');
			$this->lang->load("loctransfer",$this->session->userdata('language'));	
			
			//Form setup
			$this->load->model('company/formSetup_Model');
			$filter['companyID']=element('compID', $this->session->userdata('logged_in'));
			$filter['formID']=46;
			$data['formNo']= $this->formSetup_Model->getFormNo($filter);
			
			// Gather predefined values of form
			$data['itemCategory'] = $this->masterCode_model->get_all(array('masterID'=>20));
			$data['fromLocation'] = $this->Location_transfer->location_byCompany(1);
			
			// Gather Item according to location
			$this->load->model('item/ItemSetup_model');
			
			
			//Gather all items		
			$data['items'] = $this->ItemSetup_model->get_all();
			
			$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
			$this->layouts->view('locationtransfer/addloctrans', array('latest' => 'sidebar/latest'), $data);
		}
	}
	
	//Edit location transfer
	
	public function edit(){
		if($this->input->post('update')){
			$this->output->enable_profiler(TRUE);
			
			//Insert Location Transfer informations
			$newloctrans = array(
				'companyID'			=> element('compID', $this->session->userdata('logged_in')), 
				'fromLocationID'	   => $this->input->post('fromLocationID'), 
				'toLocationID'		 => $this->input->post('toLocationID'),
				'formNo'			   => $this->input->post('formNo'),
				'movementTypeID'	   => $this->input->post('movementTypeID'),
				'dateTransfer'		 => date('Y-m-d',strtotime($this->input->post('selDateFrom'))),
				'memo'	   			 => $this->input->post('memo'),
				'createdTS'	   		=> date('Y-m-d G:i:s',time()),
			
			);
			
		  	$loctransId = $this->Location_transfer->update($this->input->post('formID'),$newloctrans);
			
			if($loctransId){
				//Insert items for location transfer
				$i = 0;
				foreach($this->input->post('ID') as $item){
					$newloctransdetail = array( 
						'quantity'		     => $_POST['quantity'][$i],
						'fromStock'			=> $_POST['stock'][$i],
						'createdTS'	   		=> date('Y-m-d G:i:s',time())				
					);
					
					$loctransDetailId = $this->Location_transfer->updateDetail($item,$newloctransdetail);
					$i++;
				}
				
				echo '<script>alert("Insert Data Success..");
				window.location.replace("'.base_url().'/locationtransfer");
				</script>';
			}else{
				
				echo '<script>alert("Insert Data Failed.");
					history.go(-1); </script>';
			}
		}else{
			$data['datatbls'] = $this->Location_transfer->get_loc_trans_by_id($this->uri->segment(3));
			
			
			$this->load->library('layouts');
			$this->load->helper('form');
			$this->load->helper('menu');
			$this->load->model('master/masterCode_model');
			$this->lang->load("loctransfer",$this->session->userdata('language'));	
			
			//Form setup
			$this->load->model('company/formSetup_Model');
			$filter['companyID']=element('compID', $this->session->userdata('logged_in'));
			$filter['formID']=46;
			$data['formNo']= $this->formSetup_Model->getFormNo($filter);
			
			// Gather predefined values of form
			$data['itemCategory'] = $this->masterCode_model->get_all(array('masterID'=>20));
			$data['fromLocation'] = $this->Location_transfer->location_byCompany(1);
			
			// Gather Item according to location
			$this->load->model('item/ItemSetup_model');
			
			
			//Gather all items		
			$data['items'] = $this->ItemSetup_model->get_all();
			
			
			$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
			$this->layouts->view('locationtransfer/editloctrans', array('latest' => 'sidebar/latest'), $data);
		}
	}
	
	//Location Transfer List
	public function loctrans_list()
	{
		$this->load->library('layouts');
		$this->load->helper('form');
		$this->load->helper('menu');
		$this->lang->load("loctransfer",$this->session->userdata('language'));
	    $this->load->model('Location_transfer');
		$data['datatbls'] = $this->Location_transfer->location_transfer_all();
		$this->layouts->add_includes('js/datatables/jquery.dataTables.min.js');
		$this->layouts->view('locationtransfer/list', array('latest' => 'sidebar/latest'), $data);
	}
	
	//Delete location transfer entry
	public function delete(){
		$this->Location_transfer->remove($this->uri->segment(3));		
		echo '<script>alert("Entry removed Successfully..");
				window.location.replace("'.base_url().'/locationtransfer");
				</script>';
	}
}