<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Suppliercontact extends Admin_Controller {
    public function index($x){
		$this->load->model('Suppliercontactinfo');
	//	$this->load->model('Commeninfo');
	//	$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['Suppliercontactdetails']=$this->Suppliercontactinfo->GetSupplierid($x);
		$this->data['result'] = $result;
		$this->data['js'] = 'application/views/suppliers/supplierContact/index-js.php';
		$this->render_template('suppliers/supplierContact/index', $this->data);
	}
   
	public function Suppliercontactinsertupdate(){
		$this->load->model('Suppliercontactinfo');
        $result=$this->Suppliercontactinfo->Suppliercontactinsertupdate();
	}
	public function Suppliercontactedit(){
		$this->load->model('Suppliercontactinfo');
        $result=$this->Suppliercontactinfo->Suppliercontactedit();
	}
	public function Suppliercontactstatus($x,$z,$y){
		$this->load->model('Suppliercontactinfo');
        $result=$this->Suppliercontactinfo->Suppliercontactstatus($x,$z,$y);
	}
	
}
