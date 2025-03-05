<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class CRMCompletedorder extends Admin_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Completedorderinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->data['result']  = $result;
		$this->data['js'] = 'application/views/CRMOrder/CRMCompletedOrder/index-js.php';
		$this->render_template('CRMOrder/CRMCompletedOrder/index', $this->data);
	}
    public function Completedorderinsertupdate(){
		$this->load->model('Completedorderinfo');
        $result=$this->Completedorderinfo->Completedorderinsertupdate();
	}
    public function Completedorderstatus($x, $y){
		$this->load->model('Completedorderinfo');
        $result=$this->Completedorderinfo->Completedorderstatus($x, $y);
	}
    public function Getcompletedorders() {	
		$this->load->model('Completedorderinfo');
		$material_details = $this->Completedorderinfo->Getcompletedorders();	
		echo json_encode($material_details);
	}
    public function Completedorderupload(){
		$this->load->model('Completedorderinfo');
        $result=$this->Completedorderinfo->Completedorderupload();
	}
    public function Completedordercheck(){
		$this->load->model('Completedorderinfo');
        $result=$this->Completedorderinfo->Completedordercheck();
	}
	public function Savematerialbalances(){
		$this->load->model('Completedorderinfo');
        $this->Completedorderinfo->Savematerialbalances();
	}
    public function Getmaterialcategory(){		
		$this->load->model('Completedorderinfo');
		$result=$this->Completedorderinfo->Getmaterialcategory();		
	}
	public function GetPaymentDetails(){		
		$this->load->model('Completedorderinfo');
		$result=$this->Completedorderinfo->GetPaymentDetails();	
		echo json_encode($result);
	}

	public function loadSummaryDetails(){
		$this->load->model('Completedorderinfo');
		$result=$this->Completedorderinfo->loadSummaryDetails();
		echo json_encode($result);		
	}
}