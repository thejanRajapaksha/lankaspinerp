<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Supplierbank extends Admin_Controller {
    public function index($x){
		$this->load->model('Supplierbankinfo');
		$this->load->model('Suppliercontactinfo');
		$this->data['supplier_id'] = $x;
		$result['Suppliercontactdetails']=$this->Suppliercontactinfo->GetSupplierid($x);
		$result['Supplierbankdetails']=$this->Supplierbankinfo->GetSupplierbankid($x);
		$this->data['result'] = $result;
		$this->data['js'] = 'application/views/suppliers/supplierBank/index-js.php';
		$this->render_template('suppliers/supplierBank/index', $this->data);
	}
   
	public function Supplierbankinsertupdate(){
		$this->load->model('Supplierbankinfo');
        $result=$this->Supplierbankinfo->Supplierbankinsertupdate();
	}
	public function Supplierbankedit(){
		$this->load->model('Supplierbankinfo');
        $result=$this->Supplierbankinfo->Supplierbankedit();
	}
	public function Supplierbankstatus($x,$z,$y){
		$this->load->model('Supplierbankinfo');
        $result=$this->Supplierbankinfo->Supplierbankstatus($x,$z,$y);
	}
	
}
