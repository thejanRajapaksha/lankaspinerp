<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Customercontact extends Admin_Controller {
    public function index($x){
		$this->load->model('Customercontactinfo');
		$this->data['customer_id'] = $x;
		//$this->load->model('Commeninfo');
		//$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['Customercontactdetails']=$this->Customercontactinfo->GetCustomerid($x);
		$this->data['result'] = $result;
		$this->data['js'] = 'application/views/customers/customerContact/index-js.php';
		$this->render_template('customers/customerContact/index', $this->data);
	}
   
	public function Customercontactinsertupdate(){
		$this->load->model('Customercontactinfo');
        $result=$this->Customercontactinfo->Customercontactinsertupdate();
	}
	public function Customercontactedit(){
		$this->load->model('Customercontactinfo');
        $result=$this->Customercontactinfo->Customercontactedit();
	}
	public function Customercontactstatus($x,$z,$y){
		$this->load->model('Customercontactinfo');
        $result=$this->Customercontactinfo->Customercontactstatus($x,$z,$y);
	}

	
}
