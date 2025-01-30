<?php

class MachineOnLoanRequests extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Machine On Loan Requests';
        $this->load->model('model_onloan_issue_machines');
        $this->load->model('model_machine_requests');


    }

    public function index()
    {
        if (!in_array('viewMachineOnLoanRequest', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->data['js'] = 'application/views/machines/machineOnLoanRequests/index-js.php';
        $this->render_template('machines/machineOnLoanRequests/index', $this->data);
    }

    public function fetchCategoryData()
    {
        if(!in_array('viewMachineOnLoanRequest', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());

        $data = $this->model_onloan_issue_machines->getMachineOnLoanRequestsData();

        foreach ($data as $key => $value) {
            // button
            $buttons = '';

            $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="viewFunc('.$value['machine_request_id'].')" data-toggle="modal" data-target="#viewModal"><i class="fas fa-eye text-info"></i></button>';

            $result['data'][$key] = array(
                $value['unique_id'],
                $value['request_date'],
                $value['approved_quantity'],
                $value['total_requests'],
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }

    public function create()
    {
        //createMachineOnLoanRequest
        if(!in_array('createMachineOnLoanRequest', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $ids = $this->input->post('checked_id');

        $inserted = true;

        foreach ($ids as $id) {

            $machine_request_id = $id['machine_request_id'];

            $machine_in_ids = $id['machine_in_id'];

            foreach ($machine_in_ids as $machine_in_id) {

                $data = array(
                    'machine_request_id' => $machine_request_id,
                    'machine_in_id' => $machine_in_id,
                    'created_by' => $this->session->userdata('id'),
                    'created_at' => date('Y-m-d H:i:s')
                );

                $inserted = $this->model_onloan_issue_machines->create($data);

            }
        }

        if($inserted == true) {
            $response['success'] = true;
            $response['messages'] = 'Successfully created';
        }
        else {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while creating the information';
        }

        echo json_encode($response);

    }

    //fetchMachineOnLoanRequestsByUniqueId
    public function fetchMachineOnLoanRequestsByUniqueId()
    {
        if(!in_array('viewMachineOnLoanRequest', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $machine_request_id = $this->input->post('machine_request_id');

        $issued_machines = $this->model_onloan_issue_machines->getMachineOnLoanRequestsByMachineRequestId($machine_request_id);
        $machine_request = $this->model_machine_requests->getMachineRequestsData($machine_request_id);

        $result = array('issued_machines' => $issued_machines, 'machine_request' => $machine_request);

        echo json_encode($result);
    }



}