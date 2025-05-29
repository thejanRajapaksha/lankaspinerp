<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class MachineWIP extends Admin_Controller {
    public function index(){
       // $this->load->model('Commeninfo');
        $this->load->model('MachineWIPinfo');
        $this->load->model('Machineallocationinfo');
        $result['machine']=$this->Machineallocationinfo->Getmachinelist();
        $this->data['result'] = $result;
		$this->data['js'] = 'application/views/Reports/MachinesReport/index-js.php';
		$this->render_template('Reports/MachinesReport/index', $this->data);
	}

    public function fetch(){
        $machineId = $this->input->post('machine_id');
        $date = $this->input->post('date');

        $this->load->model('MachineWIPinfo');
        $data = $this->MachineWIPinfo->getAllocationByMachineAndDate($machineId, $date);

        echo json_encode($data);
    }

    public function getAllocationDataById(){
        $id = $this->input->post('id');

        $this->load->model('MachineWIPinfo');
        $result= $this->MachineWIPinfo->getAllocationDataById($id); 

        echo json_encode($result);

    }
    
    public function InsertCompletedAmmount() {
        $this->load->model('MachineWIPinfo');
        $user = $_SESSION['id'];
        $data = [
            'tbl_machine_allocation_idtbl_machine_allocation' => $this->input->post('allocation_id'),
            'wastageqty'=> '0',
            'completedqty' => $this->input->post('amount'),
            'insertuser'=> $user,
            'status'=> '1',

            //'created_at' => date('Y-m-d H:i:s')
        ];
        
        $result = $this->MachineWIPinfo->InsertCompletedAmmount($data);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Amount saved successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to save amount']);
        }
    }

}