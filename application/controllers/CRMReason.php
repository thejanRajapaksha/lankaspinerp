<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class CRMReason extends Admin_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('CRMReasoninfo');
	    // $result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->data['js'] = 'application/views/CRM/CRMReason/index-js.php';
		$this->render_template('CRM/CRMReason/index', $this->data);
	}
    public function Reasontypeinsertupdate(){
		$this->load->model('CRMReasoninfo');
        $result=$this->CRMReasoninfo->Reasontypeinsertupdate();
	}
    public function Reasontypestatus($x, $y){
		$this->load->model('CRMReasoninfo');
        $result=$this->CRMReasoninfo->Reasontypestatus($x, $y);
	}
    public function Reasontypeedit(){
		$this->load->model('CRMReasoninfo');
        $result=$this->CRMReasoninfo->Reasontypeedit();
	}
}