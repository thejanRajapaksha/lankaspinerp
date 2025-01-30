<?php

class MachineScans extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Machine Scan';
        $this->load->model('model_machine_scans');
        $this->load->model('model_machine_ins');
        $this->load->model('model_factories');

    }

    public function index()
    {
        if(!in_array('viewMachineScan', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->data['js'] = 'application/views/machines/MachineScans/index-js.php';
        $this->render_template('machines/MachineScans/index', $this->data);
    }

    public function scan(){

        if(!in_array('viewMachineScan', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->form_validation->set_rules('s_no', 'S No', 'trim|required');
        $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {

            $s_no = $this->input->post('s_no');

            $machine_in_data = $this->model_machine_ins->getMachineInDataBySNo($s_no);

            if($machine_in_data){
                $response['success'] = true;
                $response['machine_in_data'] = $machine_in_data;
            }
            else{
                $response['success'] = false;
                $response['messages'] = 'No data found';
            }

            //machine allocation data
            $machine_allocation_data = $this->model_machine_scans->getMachineCurrentAllocationDataByMachineInId($machine_in_data['id']);
            if ($machine_allocation_data) {
                $response['machine_allocation_data'] = $machine_allocation_data;
            }else{
                $response['machine_allocation_data'] = 0;
            }

            //machine repair data
            $machine_repair_data = $this->model_machine_scans->getMachineCurrentRepairDataByMachineInId($machine_in_data['id']);
            if ($machine_repair_data) {
                $response['machine_repair_data'] = $machine_repair_data;
            }else{
                $response['machine_repair_data'] = 0;
            }


        } else {
            $response['success'] = false;
            foreach ($_POST as $key => $value) {
                $response['messages'][$key] = form_error($key);
            }
        }

        echo json_encode($response);


    }

    public function release_machine(){

        if(!in_array('createMachineRelease', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $machine_in_id = $this->input->post('machine_in_id');

        $response = array();
        if($machine_in_id) {

            $machine_allocation_current = $this->model_machine_scans->getMachineCurrentAllocationDataByMachineInId($machine_in_id);

            if($machine_allocation_current){

                $data = array(
                    'machine_in_id' => $machine_in_id,
                    'slot_id' => $machine_allocation_current['slot_id'],
                    'allocated_date' => $machine_allocation_current['allocated_date'],
                    'released_date' => date('Y-m-d'),
                    'created_by' => $this->session->userdata('id'),
                    'created_at' => date('Y-m-d H:i:s')
                );

                $insert = $this->model_machine_scans->create_machine_allocation_history($data);
                if($insert) {

                    //delete current allocation
                    $delete = $this->model_machine_scans->delete_machine_allocation_current($machine_in_id);

                    $response['success'] = true;
                    $response['messages'] = 'Successfully Released';
                }
                else {
                    $response['success'] = false;
                    $response['messages'] = 'Error in the database while creating the brand information';
                }
            }
            else{
                $response['success'] = false;
                $response['messages'] = 'No data found';
            }

        }
        else {
            $response['success'] = false;
            $response['messages'] = "Refresh the page again!!";
        }

        echo json_encode($response);

    }

    public function allocate_machine()
    {
        if(!in_array('createMachineAllocate', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $this->form_validation->set_rules('machine_in_id', 'Machine In ID', 'trim|required');
        $this->form_validation->set_rules('factory_id', 'Factory', 'trim|required');
        $this->form_validation->set_rules('department_id', 'Department', 'trim|required');
        $this->form_validation->set_rules('section_id', 'Section', 'trim|required');
        $this->form_validation->set_rules('line_id', 'Line', 'trim|required');
        $this->form_validation->set_rules('slot_id', 'Slot', 'trim|required');
        $this->form_validation->set_rules('allocated_date', 'Allocation Date', 'trim|required');

        $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {

            $machine_allocation_current = $this->model_machine_scans->getMachineCurrentAllocationDataByMachineInId($this->input->post('machine_in_id'));

            if (!empty($machine_allocation_current) ){

                $data_h = array(
                    'machine_in_id' => $this->input->post('machine_in_id'),
                    'slot_id' => $machine_allocation_current['slot_id'],
                    'allocated_date' => $machine_allocation_current['allocated_date'],
                    'released_date' => date('Y-m-d'),
                    'created_by' => $this->session->userdata('id'),
                    'created_at' => date('Y-m-d H:i:s')
                );

                $insert = $this->model_machine_scans->create_machine_allocation_history($data_h);

                $delete = $this->model_machine_scans->delete_machine_allocation_current($this->input->post('machine_in_id'));

            }

            $data = array(
                'machine_in_id' => $this->input->post('machine_in_id'),
                'slot_id' => $this->input->post('slot_id'),
                'allocated_date' => $this->input->post('allocated_date')
            );

            $create = $this->model_machine_scans->create_allocation($data);
            if($create == true) {
                $response['success'] = true;
                $response['messages'] = 'Successfully created';
            }
            else {
                $response['success'] = false;
                $response['messages'] = 'Error in the database while creating the brand information';
            }
        }
        else {
            $response['success'] = false;
            foreach ($_POST as $key => $value) {
                $response['messages'][$key] = form_error($key);
            }
        }

        echo json_encode($response);

    }

    public function repair_machine(){

        if(!in_array('createMachineRepairRequest', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $machine_in_id = $this->input->post('machine_in_id');

        $response = array();
        if($machine_in_id) {

            $machine_allocation_current = $this->model_machine_scans->getMachineCurrentAllocationDataByMachineInId($machine_in_id);

            if($machine_allocation_current){

                $data = array(
                    'machine_in_id' => $machine_in_id,
                    'slot_id' => $machine_allocation_current['slot_id'],
                    'allocated_date' => $machine_allocation_current['allocated_date'],
                    'released_date' => date('Y-m-d'),
                    'created_by' => $this->session->userdata('id'),
                    'created_at' => date('Y-m-d H:i:s')
                );

                $insert = $this->model_machine_scans->create_machine_allocation_history($data);
                if($insert) {
                    $delete = $this->model_machine_scans->delete_machine_allocation_current($machine_in_id);
                }
            }

            $data = array(
                'machine_in_id' => $machine_in_id,
                'repair_in_date' => date('Y-m-d'),
                'created_by' => $this->session->userdata('id'),
                'created_at' => date('Y-m-d H:i:s')
            );

            $create = $this->model_machine_scans->create_repair($data);
            if($create == true) {
                $response['success'] = true;
                $response['messages'] = 'Successfully created';
            }
            else {
                $response['success'] = false;
                $response['messages'] = 'Error in the database while creating the brand information';
            }

        }
        else {
            $response['success'] = false;
            $response['messages'] = "Refresh the page again!!";
        }

        echo json_encode($response);

    }

    public function release_machine_from_repair(){

        if(!in_array('createMachineRelease', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $machine_in_id = $this->input->post('machine_in_id');
        $repair_id = $this->input->post('repair_id');

        $response = array();
        if($machine_in_id) {

            $data = array(
                'repair_out_date' => date('Y-m-d'),
                'updated_by' => $this->session->userdata('id'),
                'updated_at' => date('Y-m-d H:i:s')
            );

            $update = $this->model_machine_scans->update_repair($repair_id, $data);

            $response['success'] = true;
            $response['messages'] = 'Successfully Released';

        }
        else {
            $response['success'] = false;
            $response['messages'] = "Refresh the page again!!";
        }

        echo json_encode($response);

    }


    public function allocate_machine_from_repair()
    {
        if(!in_array('createMachineAllocate', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $this->form_validation->set_rules('machine_in_id', 'Machine In ID', 'trim|required');
        $this->form_validation->set_rules('factory_id', 'Factory', 'trim|required');
        $this->form_validation->set_rules('department_id', 'Department', 'trim|required');
        $this->form_validation->set_rules('section_id', 'Section', 'trim|required');
        $this->form_validation->set_rules('line_id', 'Line', 'trim|required');
        $this->form_validation->set_rules('slot_id', 'Slot', 'trim|required');
        $this->form_validation->set_rules('allocated_date', 'Allocation Date', 'trim|required');

        $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        $machine_in_id = $this->input->post('machine_in_id');

        if ($this->form_validation->run() == TRUE) {

           $repair_id = $this->input->post('repair_id');

           $data = array(
               'repair_out_date' => date('Y-m-d'),
                'updated_by' => $this->session->userdata('id'),
                'updated_at' => date('Y-m-d H:i:s')
           );

          $update = $this->model_machine_scans->update_repair($repair_id, $data);

            $data = array(
                'machine_in_id' => $machine_in_id,
                'slot_id' => $this->input->post('slot_id'),
                'allocated_date' => $this->input->post('allocated_date')
            );

            $create = $this->model_machine_scans->create_allocation($data);
            if($create == true) {
                $response['success'] = true;
                $response['messages'] = 'Successfully created';
            }
            else {
                $response['success'] = false;
                $response['messages'] = 'Error in the database while creating the brand information';
            }
        }
        else {
            $response['success'] = false;
            foreach ($_POST as $key => $value) {
                $response['messages'][$key] = form_error($key);
            }
        }

        echo json_encode($response);

    }


public function fetchAllocationHistoryData()
{
    $result = array('data' => array());

    $machine_in_id = $this->input->post('machine_in_id');

    $data = $this->model_machine_scans->getAllocationHistory($machine_in_id);

    foreach ($data as $key => $value) {

        $result['data'][$key] = array(
            $value['slot_name'],
            $value['line_name'],
            $value['section_name'],
            $value['department_name'],
            $value['factory_name'],
            $value['allocated_date'],
            $value['released_date'],
        );
    } // /foreach

    echo json_encode($result);
}

   public function fetchRepairHistoryData(){
        $result = array('data' => array());

        $machine_in_id = $this->input->post('machine_in_id');

        $data = $this->model_machine_scans->getRepairHistory($machine_in_id);

        foreach ($data as $key => $value) {

            $result['data'][$key] = array(
                $value['repair_in_date'],
                $value['repair_out_date'],
            );
        } // /foreach

        echo json_encode($result);
    }


}