<?php

class MachineRepairRequests extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Machine Repair Requests';
        $this->load->model('model_machine_repair_requests');

    }

    public function index()
    {
        if(!in_array('viewMachineRepairRequest', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $this->data['js'] = 'application/views/MachineRepairs/MachineRepairRequests/index-js.php';
        $this->render_template('MachineRepairs/MachineRepairRequests/index', $this->data);
    }

    public function fetchCategoryData()
    {
        if(!in_array('viewMachineRepairRequest', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());

        $data = $this->model_machine_repair_requests->getMachineRepairRequestsData();

        foreach ($data as $key => $value) {
            // button
            $buttons = '';

            //check if machine_repair_details exists for repair_id
            $this->db->select('*');
            $this->db->from('machine_repair_details');
            $this->db->where('repair_id', $value['id']);
            $query = $this->db->get();
            $result1 = $query->row_array();

            if(empty($result1)){
                if(in_array('createMachineRepair', $this->permission)) {
                    $buttons .= '<button type="button" class="btn btn-default btn-sm repair_add_btn" data-id="'.$value['id'].'" data-machine_type_name="'.$value['machine_type_name'].'" title="Create Repair" data-toggle="modal" data-target="#repairAddModal"><i class="text-success fa fa-wrench"></i></button>';
                }

                if(in_array('createMachineRepairPostpone', $this->permission)) {
                    $buttons .= '<button type="button" style="margin:1px;" class="btn btn-default btn-sm btn_postpone" data-id="'.$value['id'].'" data-machine_type_name="'.$value['machine_type_name'].'" title="Postpone"> <i class="text-warning fa fa-stop-circle"></i> </button>';
                }

            }

            if(in_array('updateMachineRepairRequest', $this->permission)) {
                $buttons .= '<button type="button" class="btn btn-default btn-sm" title="Edit" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal"><i class="text-primary fa fa-edit"></i></button>';
            }

            if(in_array('deleteMachineRepairRequest', $this->permission)) {
                $buttons .= ' <button type="button" class="btn btn-default btn-sm" title="Delete" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="text-danger fa fa-trash"></i></button>';
            }

            //$status = ($value['active'] == 1) ? '<span class="badge badge-success btn-sm">Active</span>' : '<span class="badge badge-warning">Inactive</span>';

            $result['data'][$key] = array(
                $value['machine_type_name'],
                $value['bar_code'],
                $value['s_no'],
                $value['repair_in_date'],
                //$status,
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }

    public function create()
    {
        if(!in_array('createMachineRepair', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        //$this->form_validation->set_rules('service_no', 'Service No', 'trim|required');
        $this->form_validation->set_rules('machine_in_id', 'Machine', 'trim|required');
        $this->form_validation->set_rules('repair_date', 'Repair In Date', 'trim|required');

        $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'machine_in_id' => $this->input->post('machine_in_id'),
                'repair_in_date' => $this->input->post('repair_date')
            );

            $create = $this->model_machine_repair_requests->create($data);
            if($create == true) {
                $response['success'] = true;
                $response['messages'] = 'Successfully created';
            }
            else {
                $response['success'] = false;
                $response['messages'] = 'Error in the database while creating the information';
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

    public function fetchMachineRepairRequestsDataById($id = null)
    {
        if($id) {
            $data = $this->model_machine_repair_requests->getMachineRepairRequestsData($id);
            echo json_encode($data);
        }

    }

    public function update($id)
    {
        if(!in_array('updateMachineRepairRequest', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        if($id) {
            $this->form_validation->set_rules('edit_machine_in_id', 'Machine', 'trim|required');
            $this->form_validation->set_rules('edit_repair_date', 'Repair Date', 'trim|required');

            $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'machine_in_id' => $this->input->post('edit_machine_in_id'),
                    'repair_in_date' => $this->input->post('edit_repair_date'),
                );

                $update = $this->model_machine_repair_requests->update($id, $data);
                if($update == true) {
                    $response['success'] = true;
                    $response['messages'] = 'Successfully updated';
                }
                else {
                    $response['success'] = false;
                    $response['messages'] = 'Error in the database while updated the information';
                }
            }
            else {
                $response['success'] = false;
                foreach ($_POST as $key => $value) {
                    $response['messages'][$key] = form_error($key);
                }
            }
        }
        else {
            $response['success'] = false;
            $response['messages'] = 'Error please refresh the page again!!';
        }

        echo json_encode($response);
    }

    public function remove()
    {
        if(!in_array('deleteMachineRepairRequest', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $machine_repair_id = $this->input->post('machine_repair_id');

        $response = array();
        if($machine_repair_id) {
             //$delete = $this->model_machine_repair_requests->remove($machine_repair_id);

            $data = array(
                'is_deleted' => 1,
                'deleted_by' => $this->session->userdata('id'),
                'deleted_at' => date('Y-m-d H:i:s')
            );

            $delete = $this->model_machine_repair_requests->update($machine_repair_id, $data);

            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully removed";
            }
            else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the information";
            }

        }
        else {
            $response['success'] = false;
            $response['messages'] = "Refresh the page again!!";
        }

        echo json_encode($response);
    }

    public function getServiceNo()
    {
        if(!in_array('createMachineService', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->db->select('*');
        $this->db->from('machine_services');
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        $machine_service = $query->row_array();

        if (empty($machine_service)) {
            $service_id = 1;
        } else {
            $service_id = $machine_service['id'] + 1;
        }

        //check if job no string is less than 4 digits
        if (strlen($service_id) < 4) {
            //add leading zeroes and trim to last 4 digits
            $service_id = str_pad($service_id, 4, '0', STR_PAD_LEFT);
        }

        $service_no = 'SRV' . $service_id;

        echo json_encode($service_no);
    }



}