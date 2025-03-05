<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class CRMPrintingdetail extends Admin_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Printingdetailinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        // $result['materialcategory']=$this->Printingdetailinfo->Getmaterialcategory();
		$this->data['result']  = $result;
		$this->data['js'] = 'application/views/CRMOrder/CRMPrinting/index-js.php';
		$this->render_template('CRMOrder/CRMPrinting/index', $this->data);
	}
    public function Printingdetailupload(){
		$this->load->model('Printingdetailinfo');
        $result=$this->Printingdetailinfo->Printingdetailupload();
	}
    public function Printingdetailcheck(){
		$this->load->model('Printingdetailinfo');
        $result=$this->Printingdetailinfo->Printingdetailcheck();
	}
    public function Getprintingcompany(){		
		$this->load->model('Printingdetailinfo');
		$result=$this->Printingdetailinfo->Getprintingcompany();		
	}
	public function Getcuffcompany(){		
		$this->load->model('Printingdetailinfo');
		$result=$this->Printingdetailinfo->Getcuffcompany();		
	}
	public function Getcolorcode(){		
		$this->load->model('Printingdetailinfo');
		$result=$this->Printingdetailinfo->Getcolorcode();		
	}
    public function Getsewingcompany(){		
		$this->load->model('Printingdetailinfo');
		$result=$this->Printingdetailinfo->Getsewingcompany();		
	}
	public function Getcolorcompany(){		
		$this->load->model('Printingdetailinfo');
		$result=$this->Printingdetailinfo->Getcolorcompany();		
	}
    public function Getclothtype(){		
		$this->load->model('Printingdetailinfo');
		$result=$this->Printingdetailinfo->Getclothtype();		
	}
	public function Getdesigntype(){		
		$this->load->model('Printingdetailinfo');
		$result=$this->Printingdetailinfo->Getdesigntype();		
	}
	public function Orderdetailinsertupdate(){
		$this->load->model('Printingdetailinfo');
        $result=$this->Printingdetailinfo->Orderdetailinsertupdate();
	}
	public function Getorderdetails() {
		$inquiryid = $this->input->post('inquiryid');
		$customerid = $this->input->post('customerid');
		$this->load->model('Printingdetailinfo');
		$customer_name = $this->Printingdetailinfo->GetCustomerName($customerid);
		$data = $this->Printingdetailinfo->Getorderdetails($inquiryid, $customerid);
		if (is_null($data) || !is_array($data)) {
			$data = [
				'order_details' => [],
				'additional_details' => []
			];
		}
		$response = array(
			'customer_name' => $customer_name ? $customer_name : 'Unknown Customer',
			'order_details' => isset($data['order_details']) ? $data['order_details'] : [],
			'additional_details' => isset($data['additional_details']) ? $data['additional_details'] : []
		);
		echo json_encode($response);
	}	
	public function GetReceiveorderInfoDetails() {
		$inquiryid = $this->input->post('inquiryid');
		$customerid = $this->input->post('customerid');
		$this->load->model('Printingdetailinfo');
		$customer_name = $this->Printingdetailinfo->GetCustomerName($customerid);
		$data = $this->Printingdetailinfo->GetReceiveorderInfoDetails($inquiryid, $customerid);
		if (is_null($data) || !is_array($data)) {
			$data = [
				'received_order_details' => [],
				'received_colorcuff_details' => []
			];
		}
		$response = array(
			'customer_name' => $customer_name ? $customer_name : 'Unknown Customer',
			'received_order_details' => isset($data['received_order_details']) ? $data['received_order_details'] : [],
			'received_colorcuff_details' => isset($data['received_colorcuff_details']) ? $data['received_colorcuff_details'] : []
		);
		echo json_encode($response);
	}		
	public function SaveReceiveDetails() {
		$this->load->model('Printingdetailinfo');
		$receiveDetails = $this->input->post('receiveDetails');
		$inquiryid = $this->input->post('inquiryid'); 
		$Rremark = $this->input->post('Rremark'); 
	
		if (is_array($receiveDetails) && !empty($receiveDetails)) {
			$result = $this->Printingdetailinfo->SaveReceiveDetails($receiveDetails, $inquiryid, $Rremark);
			if ($result) {
				echo json_encode(['success' => true]);
			} else {
				echo json_encode(['success' => false, 'message' => 'Failed to save details.']);
			}
		} else {
			echo json_encode(['success' => false, 'message' => 'No details to save.']);
		}
	}
	public function SavecolorcuffDetails() {
		$this->load->model('Printingdetailinfo');
		$colorcuffDetails = $this->input->post('colorcuffDetails');
		$inquiryid = $this->input->post('inquiryid'); 
		$CMremark = $this->input->post('CMremark'); 
	
		if (is_array($colorcuffDetails) && !empty($colorcuffDetails)) {
			$result = $this->Printingdetailinfo->SavecolorcuffDetails($colorcuffDetails, $inquiryid, $CMremark);
			if ($result) {
				echo json_encode(['success' => true]);
			} else {
				echo json_encode(['success' => false, 'message' => 'Failed to save details.']);
			}
		} else {
			echo json_encode(['success' => false, 'message' => 'No details to save.']);
		}
	}
	
	
	
}