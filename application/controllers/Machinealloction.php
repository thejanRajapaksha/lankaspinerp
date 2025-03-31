<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Machinealloction extends Admin_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Machineallocationinfo');
        // $this->load->model('Customerinquiryinfo');

        $result['machine']=$this->Machineallocationinfo->Getmachinelist();
        $result['employee']=$this->Machineallocationinfo->Getemployeelist();
        $result['inquiryinfo']=$this->Machineallocationinfo->GetAllCustomerInquiries();
        $this->data['result'] = $result;
		$this->data['js'] = 'application/views/CRMOrder/Machineallocation/index-js.php';
		$this->render_template('CRMOrder/Machineallocation/index.php', $this->data);
	}

    public function Machineinsertupdate(){
		$this->load->model('Machineallocationinfo');
        $result=$this->Machineallocationinfo->Machineinsertupdate();
	}

    public function Checkmachineavailability(){
		$this->load->model('Machineallocationinfo');
        $result=$this->Machineallocationinfo->Checkmachineavailability();
	}

    public function Checkissueqty(){
		$this->load->model('Machineallocationinfo');
        $result=$this->Machineallocationinfo->Checkissueqty();
	}
    public function FetchAllocationData(){
		$this->load->model('Machineallocationinfo');
        $result=$this->Machineallocationinfo->FetchAllocationData();
	}
   
    public function GetInquieryDetails(){
		$this->load->model('Machineallocationinfo');
        $result=$this->Machineallocationinfo->GetInquieryDetails();
        echo json_encode($result);
	}

    public function GetCostItemData(){
		$this->load->model('Machineallocationinfo');
        $result=$this->Machineallocationinfo->GetCostItemData();
        echo json_encode($result);

	}

    public function FetchItemDataForAllocation(){
		$this->load->model('Machineallocationinfo');
        $result=$this->Machineallocationinfo->FetchItemDataForAllocation();
	}

    public function GetDeliveryPlanDetails(){
		$this->load->model('Machineallocationinfo');
        $result=$this->Machineallocationinfo->GetDeliveryPlanDetails();
        echo json_encode($result);
	}

}