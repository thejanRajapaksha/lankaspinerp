<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Materialmaincategory extends Admin_Controller {
    public function index(){
		$this->load->model('Materialmaincategoryinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->data['result']  = $result;
		$this->data['js'] = 'application/views/MaterialData/materialmaincategory/index-js.php';
		$this->render_template('MaterialData/materialmaincategory/index', $this->data);
	}
   
	public function Materialmaincategoryinsertupdate(){
		$this->load->model('Materialmaincategoryinfo');
        $result=$this->Materialmaincategoryinfo->Materialmaincategoryinsertupdate();
	}
	public function Materialmaincategoryedit(){
		$this->load->model('Materialmaincategoryinfo');
        $result=$this->Materialmaincategoryinfo->Materialmaincategoryedit();
	}
	public function Materialmaincategorystatus($x, $y){
		$this->load->model('Materialmaincategoryinfo');
        $result=$this->Materialmaincategoryinfo->Materialmaincategorystatus($x, $y);
	}
	public function GetMainCatList(){
		$this->load->model('Materialmaincategoryinfo');
        $result=$this->Materialmaincategoryinfo->GetMainCatList();
	}
	
}
