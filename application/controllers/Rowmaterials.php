<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Rowmaterials extends Admin_Controller {
    public function index(){
		$this->load->model('Rowmaterialsinfo');
		$this->load->model('Supplierinfo');
		$this->load->model('Measurementsinfo');
		$this->load->model('Materialmaincategoryinfo');
		$this->load->model('Commeninfo');
		$result['measurmentlist']=$this->Measurementsinfo->GetMeasurmentList();
		$result['supplierlist']=$this->Supplierinfo->GetSupplierList();
		$result['maincategorylist']=$this->Materialmaincategoryinfo->GetMainCatList();
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->data['result']  = $result;
		$this->data['js'] = 'application/views/MaterialData/rowmaterials/index-js.php';
		$this->render_template('MaterialData/rowmaterials/index', $this->data);
	}
   
	public function Rowmaterialsinsertupdate(){
		$this->load->model('Rowmaterialsinfo');
        $result=$this->Rowmaterialsinfo->Rowmaterialsinsertupdate();
	}
	public function Rowmaterialsedit(){
		$this->load->model('Rowmaterialsinfo');
        $result=$this->Rowmaterialsinfo->Rowmaterialsedit();
	}
	public function GetMaterialList(){
		$this->load->model('Rowmaterialsinfo');
        $result=$this->Rowmaterialsinfo->GetMaterialList();
	}
	public function Rowmaterialsstatus($x, $y){
		$this->load->model('Rowmaterialsinfo');
        $result=$this->Rowmaterialsinfo->Rowmaterialsstatus($x, $y);
	}
	
}
