<?php

class MachineRentRequests extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Machine Rent Requests';
        $this->load->model('model_rent_requests');


    }

    public function index()
    {
        if (!in_array('viewMachineRentRequest', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->data['js'] = 'application/views/machines/machineRentRequests/index-js.php';
        $this->render_template('machines/machineRentRequests/index', $this->data);
    }

    public function fetchCategoryData()
    {
        if(!in_array('viewMachineRentRequest', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());

        $data = $this->model_rent_requests->getMachineRentRequestsData();

        foreach ($data as $key => $value) {

            // button
            $buttons = '';

            $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="viewFunc('.$value['unique_id'].')" data-toggle="modal" data-target="#viewModal"><i class="fas fa-eye text-info"></i></button>';

//            if(in_array('updateMachineRequest', $this->permission)) {
//                $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="editFunc('.$value['unique_id'].')" data-toggle="modal" data-target="#editModal"><i class="text-primary fa fa-edit"></i></button>';
//            }
//
//            if(in_array('deleteMachineRequest', $this->permission)) {
//                $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="removeFunc('.$value['unique_id'].')" data-toggle="modal" data-target="#removeModal"><i class="text-danger fa fa-trash"></i></button>';
//            }

            $result['data'][$key] = array(
                $value['unique_id'],
                $value['request_date'],
                $value['total_requests'],
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }

    public function fetchMachineRentRequestsByUniqueId()
    {
        if(!in_array('viewMachineRentRequest', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $unique_id = $this->input->post('unique_id');

        $machine_rent_requests = $this->model_rent_requests->getMachineRentRequestsByUniqueId($unique_id);
        $machine_rent_request = $this->model_rent_requests->getMachineRentRequestByUniqueId($unique_id);

        $result = array('machine_rent_requests' => $machine_rent_requests, 'machine_rent_request' => $machine_rent_request);

        echo json_encode($result);
    }

}

