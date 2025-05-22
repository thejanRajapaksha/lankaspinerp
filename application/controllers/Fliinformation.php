<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Fliinformation extends Admin_Controller {
    public function index(){
		$this->load->model('Fliinformationinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->data['result']  = $result;
		$this->data['js'] = 'application/views/MaterialData/fliinformation/index-js.php';
		$this->render_template('MaterialData/fliinformation/index', $this->data);
	}
   
	public function Fliinformationinsertupdate(){
		$this->load->model('Fliinformationinfo');
        $result=$this->Fliinformationinfo->Fliinformationinsertupdate();
	}
	public function Fliinformationedit(){
		$this->load->model('Fliinformationinfo');
        $result=$this->Fliinformationinfo->Fliinformationedit();
	}
	public function Fliinformationstatus($x, $y){
		$this->load->model('Fliinformationinfo');
        $result=$this->Fliinformationinfo->Fliinformationstatus($x, $y);
	}
	public function GetFliList(){
		$this->load->model('Fliinformationinfo');
        $result=$this->Fliinformationinfo->GetFliList();
	}
	
}
