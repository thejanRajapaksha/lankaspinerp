<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class CRMDeliverydetail extends Admin_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Deliverydetailinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->data['result']  = $result;
		$this->data['js'] = 'application/views/CRMOrder/CRMDelivery/index-js.php';
		$this->render_template('CRMOrder/CRMDelivery/index', $this->data);
	}
    public function Packagingdetailinsertupdate(){
		$this->load->model('Deliverydetailinfo');
        $result=$this->Deliverydetailinfo->Packagingdetailinsertupdate();
	}
	public function Deliverydetailinsertupdate(){
		$this->load->model('Deliverydetailinfo');
        $result=$this->Deliverydetailinfo->Deliverydetailinsertupdate();
	}
    public function Deliverydetailstatus($x, $y){
		$this->load->model('Deliverydetailinfo');
        $result=$this->Deliverydetailinfo->Deliverydetailstatus($x, $y);
	}
    public function Getdeliverydetails() {	
		$this->load->model('Deliverydetailinfo');
		$material_details = $this->Deliverydetailinfo->Getdeliverydetails();	
		echo json_encode($material_details);
	}
    public function Deliverydetailcheck(){
		$this->load->model('Deliverydetailinfo');
        $result=$this->Deliverydetailinfo->Deliverydetailcheck();
	}
	public function Getpaymenttype(){		
		$this->load->model('Deliverydetailinfo');
		$result=$this->Deliverydetailinfo->Getpaymenttype();		
	}
	public function Getadvancepayment(){		
		$this->load->model('Deliverydetailinfo');
		$result=$this->Deliverydetailinfo->Getadvancepayment();		
		echo json_encode($result);
	}
	public function AddPayment(){		
		$this->load->model('Deliverydetailinfo');
		$result=$this->Deliverydetailinfo->AddPayment();		
		echo json_encode(['status' => 'success']);
	}
	public function GetPaymentDetails() {
		$this->load->model('Deliverydetailinfo');
		$payments = $this->Deliverydetailinfo->GetPaymentDetails();
		echo json_encode($payments);
	}	
	public function GetMachineType(){		
		$this->load->model('Deliverydetailinfo');
		$result=$this->Deliverydetailinfo->GetMachineType();		
	}
	public function GetMachineModel(){		
		$this->load->model('Deliverydetailinfo');
		$result=$this->Deliverydetailinfo->GetMachineModel();		
	}
	public function GetSerialNumber(){		
		$this->load->model('Deliverydetailinfo');
		$result=$this->Deliverydetailinfo->GetSerialNumber();		
	}
	public function GetDeliveryAndPackagingDetails() {
		$this->load->model('Deliverydetailinfo');
		$result = $this->Deliverydetailinfo->GetDeliveryAndPackagingDetails();
		echo json_encode($result);
	}
	public function GetAllAvailableMachines(){
		$this->load->model('Deliverydetailinfo');
		$result = $this->Deliverydetailinfo->getAllAvailableMachines();
		echo json_encode($result);
	}
	
}