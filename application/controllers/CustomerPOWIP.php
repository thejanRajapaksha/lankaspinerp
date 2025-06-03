<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class CustomerPOWIP extends Admin_Controller {
    public function index(){
       // $this->load->model('Commeninfo');
        $this->load->model('CustomerPOWIPinfo');
        $result['customername'] = $this->CustomerPOWIPinfo->Getcustomername();
        $this->data['result'] = $result;
		$this->data['js'] = 'application/views/Reports/CustomerPOReport/index-js.php';
		$this->render_template('Reports/CustomerPOReport/index', $this->data);
	}

    public function getPOForCustomer() {
        $this->load->model('CustomerPOWIPinfo');
        $customerId = $this->input->post('customerId');
        $result = $this->CustomerPOWIPinfo->getPOForCustomer($customerId);
        echo json_encode($result);
    }

    
}