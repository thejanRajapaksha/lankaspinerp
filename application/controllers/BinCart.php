<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class BinCart extends Admin_Controller {
    public function index(){
		//$this->load->model('Bincart_info');
		//$this->data['Suppliercategory']=$this->Supplierinfo->GetSuppliercategory();
		$this->data['js'] = 'application/views/bincart/index-js.php';
		$this->render_template('bincart/index', $this->data);
	}
   
	
}
