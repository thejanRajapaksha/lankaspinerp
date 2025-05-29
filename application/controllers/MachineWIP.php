<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class MachineWIP extends Admin_Controller {
    public function index(){
       // $this->load->model('Commeninfo');
        $this->load->model('Machineallocationinfo');
        $result['machine']=$this->Machineallocationinfo->Getmachinelist();
        $this->data['result'] = $result;
		$this->data['js'] = 'application/views/Reports/MachinesReport/index-js.php';
		$this->render_template('Reports/MachinesReport/index', $this->data);
	}


}