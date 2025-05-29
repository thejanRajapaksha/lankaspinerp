<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class CustomerPOWIP extends Admin_Controller {
    public function index(){
       // $this->load->model('Commeninfo');
        $this->load->model('CustomerPOWIPinfo');
        $this->load->model('Machineallocationinfo');
        $result['machine']=$this->Machineallocationinfo->Getmachinelist();
        $this->data['result'] = $result;
		$this->data['js'] = 'application/views/Reports/CustomerPOReport/index-js.php';
		$this->render_template('Reports/CustomerPOReport/index', $this->data);
	}

    public function fetch(){
        $machineId = $this->input->post('machine_id');
        $date = $this->input->post('date');

        $this->load->model('CustomerPOWIPinfo');
        $data = $this->CustomerPOWIPinfo->getAllocationByMachineAndDate($machineId, $date);

        echo json_encode($data);
    }

    public function getAllocationDataById(){
        $id = $this->input->post('id');

        $this->load->model('CustomerPOWIPinfo');
        $result= $this->CustomerPOWIPinfo->getAllocationDataById($id); 

        echo json_encode($result);

    }
    
    public function InsertCompletedAmmount() {
        $this->load->model('CustomerPOWIPinfo');
        $user = $_SESSION['id'];
        $data = [
            'tbl_machine_allocation_idtbl_machine_allocation' => $this->input->post('allocation_id'),
            'wastageqty'=> '0',
            'completedqty' => $this->input->post('amount'),
            'insertuser'=> $user,
            'status'=> '1',

            //'created_at' => date('Y-m-d H:i:s')
        ];
        
        $result = $this->CustomerPOWIPinfo->InsertCompletedAmmount($data);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Amount saved successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to save amount']);
        }
    }

}