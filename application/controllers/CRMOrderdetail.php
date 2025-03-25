<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class CRMOrderdetail extends Admin_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Orderdetailinfo');
		$this->load->model('Productinfo');
		$this->load->model('Customerinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['Quotationid']=$this->Orderdetailinfo->GetQuotationid();
		$result['product']= $this->Productinfo->getProduct();
		$result['customername']= $this->Customerinfo->GetCustomerList();
        // $result['Clothtype'] = $this->Orderdetailinfo->Getclothtype($z,$y);
		// $result['Customername'] = $this->Orderdetailinfo->Getcustomer($z,$y);	
		// $result['getid'] = $this->Orderdetailinfo->Getid($z,$y);
		$this->data['result']  = $result;
		$this->data['js'] = 'application/views/CRMOrder/CRMOrder/index-js.php';
		$this->render_template('CRMOrder/CRMOrder/index', $this->data);
	}
    public function Orderdetailinsertupdate(){
		$this->load->model('Orderdetailinfo');
        $result=$this->Orderdetailinfo->Orderdetailinsertupdate();
	}
	public function PaymentDetailInsertUpdate(){
		$this->load->model('Orderdetailinfo');
        $result=$this->Orderdetailinfo->PaymentDetailInsertUpdate();
	}
    public function Orderdetailupload(){
		$this->load->model('Orderdetailinfo');
        $result=$this->Orderdetailinfo->Orderdetailupload();
	}
    public function Orderdetailcheck(){
		$this->load->model('Orderdetailinfo');
        $result=$this->Orderdetailinfo->Orderdetailcheck();
	}
    public function Getinquirydetails(){
		$this->load->model('Orderdetailinfo');
        $result=$this->Orderdetailinfo->Getinquirydetails();
	}
    public function Getcustomer(){		
		$this->load->model('Orderdetailinfo');
		$result=$this->Orderdetailinfo->Getcustomer();		
	}
	public function Getclothtype(){		
		$this->load->model('Orderdetailinfo');
		$result=$this->Orderdetailinfo->Getclothtype();		
	}
	public function Getsizetype(){		
		$this->load->model('Orderdetailinfo');
		$result=$this->Orderdetailinfo->Getsizetype();		
	}
	public function Getbankname(){		
		$this->load->model('Orderdetailinfo');
		$result=$this->Orderdetailinfo->Getbankname();		
	}
	public function Getpaymenttype(){		
		$this->load->model('Orderdetailinfo');
		$result=$this->Orderdetailinfo->Getpaymenttype();		
	}
	public function GetQuantity(){		
		$this->load->model('Orderdetailinfo');
		$result=$this->Orderdetailinfo->GetQuantity();		
	}
	public function Getmaterialtype(){		
		$this->load->model('Orderdetailinfo');
		$result=$this->Orderdetailinfo->Getmaterialtype();
		echo $result;		
	}
    public function Orderformunitprice(){		
		$this->load->model('Orderdetailinfo');
		$result=$this->Orderdetailinfo->Orderformunitprice();		
	}
	public function Getorderdetails() {
		$inquiryid = $this->input->post('inquiryid');	
		$this->load->model('Orderdetailinfo');
		$order_details = $this->Orderdetailinfo->Getorderdetails($inquiryid);	
		echo json_encode($order_details);
	}
	public function SaveCuttingDetails() {
		$updatedData = $this->input->post('updatedData');
		$updatedData = json_decode($updatedData, true);
	
		if ($updatedData) {
			$this->load->model('Orderdetailinfo');	
			foreach ($updatedData as $item) {
				$this->Orderdetailinfo->updateCuttingQty($item['id'], $item['cuttingQty']);
			}
	
			echo json_encode(['success' => true]);
		} else {
			echo json_encode(['success' => false]);
		}
	}

	public function getItemsByCustomer(){
		$customer_id = $this->input->post('customer_id'); 

		if ($customer_id) {
			$this->load->model('Orderdetailinfo'); 
			$result = $this->Orderdetailinfo->getItemsByCustomer($customer_id);

			echo json_encode($result); 
		} else {
			echo json_encode([]); 
		}
	}

}