<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Customerbank extends Admin_Controller {
    public function index($x){
		$this->load->model('Customerbankinfo');
		$this->load->model('Customercontactinfo');
		$this->data['customer_id'] = $x;
		$this->load->model('Commeninfo');
		// $result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['Customerbankdetails']=$this->Customerbankinfo->GetCustomerbankid($x);
		$result['Customercontactdetails']=$this->Customercontactinfo->GetCustomerid($x);
		$this->data['result'] = $result;
		$this->data['js'] = 'application/views/customers/customerBank/index-js.php';
		$this->render_template('customers/customerBank/index', $this->data);
	}
   
	public function Customerbankinsertupdate(){
		$this->load->model('Customerbankinfo');
        $result=$this->Customerbankinfo->Customerbankinsertupdate();
	}
	public function Customerbankedit(){
		$this->load->model('Customerbankinfo');
        $result=$this->Customerbankinfo->Customerbankedit();
	}
	public function Customerbankstatus($x,$z,$y){
		$this->load->model('Customerbankinfo');
        $result=$this->Customerbankinfo->Customerbankstatus($x,$z,$y);
	}
	
}
