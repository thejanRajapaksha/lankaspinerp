<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Supplier extends Admin_Controller {
    public function index(){
		$this->load->model('Supplierinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['Suppliercategory']=$this->Supplierinfo->GetSuppliercategory();
		// $this->data['result'] = $result;
		$this->data['js'] = 'application/views/suppliers/supplier/index-js.php';
		$this->render_template('suppliers/supplier/index', $this->data);
	}
   
	public function Supplierinsertupdate(){
		$this->load->model('Supplierinfo');
        $result=$this->Supplierinfo->Supplierinsertupdate();
	}
	public function Supplieredit(){
		$this->load->model('Supplierinfo');
        $result=$this->Supplierinfo->Supplieredit();
	}
	public function Supplierstatus($x, $y){
		$this->load->model('Supplierinfo');
        $result=$this->Supplierinfo->Supplierstatus($x, $y);
	}
	
	public function GetSupplierList(){
		$this->load->model('Supplierinfo');
        $result=$this->Supplierinfo->GetSupplierList();
	}
	
}
