<?php

class MachineRequests extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Machine Requests';
        $this->load->model('model_machine_requests');
        $this->load->model('model_machine_types');
        $this->load->model('model_machine_models');
        $this->load->model('model_rent_requests');
        $this->load->model('model_onloan_issue_machines');


    }

    public function index()
    {
        if(!in_array('viewMachineRequest', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        //machine_types
        $this->data['machine_types'] = $this->model_machine_types->getActiveMachineType();
        //machine_models
        $this->data['machine_models'] = $this->model_machine_models->getActiveMachineModel();

        $this->data['js'] = 'application/views/machines/machineRequests/index-js.php';
        $this->render_template('machines/machineRequests/index', $this->data);
    }

    public function fetchCategoryData()
    {
        if(!in_array('viewMachineRequest', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());

        $data = $this->model_machine_requests->getMachineRequestsData();

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

    public function fetchMachineRequestsByUniqueId()
    {
        if(!in_array('viewMachineRequest', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $unique_id = $this->input->post('unique_id');

        $machine_requests = $this->model_machine_requests->getMachineRequestsByUniqueId($unique_id);
        $machine_request = $this->model_machine_requests->getMachineRequestByUniqueId($unique_id);

        $result = array('machine_requests' => $machine_requests, 'machine_request' => $machine_request);

        echo json_encode($result);
    }

    public function create()
    {
        if(!in_array('createMachineRequest', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $this->form_validation->set_rules('machine_type_id', 'Machine Type ', 'trim|required');
        $this->form_validation->set_rules('machine_model_id', 'Machine Model ', 'trim|required');
        $this->form_validation->set_rules('from_date', 'From Date ', 'trim|required');
        $this->form_validation->set_rules('to_date', 'To Date ', 'trim|required');
        $this->form_validation->set_rules('quantity', 'Quantity ', 'trim|required');
        $this->form_validation->set_rules('remarks', 'Remarks ', 'trim|required');

        $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'machine_type_id' => $this->input->post('machine_type_id'),
                'machine_model_id' => $this->input->post('machine_model_id'),
                'from_date' => $this->input->post('from_date'),
                'to_date' => $this->input->post('to_date'),
                'quantity' => $this->input->post('quantity'),
                'remarks' => $this->input->post('remarks'),
                'created_by' => $this->session->userdata('id'),
                'created_at' => date('Y-m-d H:i:s')
            );

            $create = $this->model_machine_requests->create($data);
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

    public function createBatch()
    {
        if(!in_array('createMachineRequest', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $req_data = $this->input->post('req_data');

        //timestamp based batch id
        $unique_id = date("Ymds");

        $data = array();
        foreach ($req_data as $req){
            $data[] = array(
                'machine_type_id' => $req['machine_type_id'],
                'machine_model_id' => $req['machine_model_id'],
                'from_date' => $req['from_date'],
                'to_date' => $req['to_date'],
                'quantity' => $req['quantity'],
                'remarks' => $req['remarks'],
                'created_by' => $this->session->userdata('id'),
                'created_at' => date('Y-m-d H:i:s'),
                'request_date' => date('Y-m-d'),
                'unique_id' => $unique_id
            );
        }

        //insert batch
        $create = $this->db->insert_batch('machine_requests', $data);

        if($create == true) {
            $response['success'] = true;
            $response['messages'] = 'Successfully created';
        }
        else {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while creating the information';
        }

        echo json_encode($response);
    }

    //approveMachineRequests
    public function approveMachineRequests()
    {
        if(!in_array('createMachineRequestApprove', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $ids = $this->input->post('checked_id');
        $remarks = $this->input->post('remarks');

        foreach ($ids as $id) {
            $data = array(
                'is_approved' => 1,
                'approved_quantity' => $id['quantity'],
                'approve_remarks' => $remarks,
                'approved_by' => $this->session->userdata('id'),
                'approved_at' => date('Y-m-d H:i:s')
            );

            $update = $this->model_machine_requests->update($id['id'], $data);
        }

        //unique_id
        $unique_id = $this->input->post('unique_id');

        if($update == true) {
            $response['success'] = true;
            $response['messages'] = 'Successfully approved';
            $response['unique_id'] = $unique_id;

        }
        else {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while approving the information';
        }

        echo json_encode($response);

    }

    public function rentMachineRequests()
    {
        if(!in_array('createMachineRentRequest', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $ids = $this->input->post('checked_id');

        $unique_id = date("Ymds");

        $inserted = true;

        foreach ($ids as $id) {

            //check if machine_request is approved
            $check_approved = $this->model_machine_requests->checkIfApproved($id['id']);

            if($check_approved == true) {

                $data = array(
                    'machine_request_id' => $id['id'],
                    'quantity' => $id['quantity'],
                    'unique_id' => $unique_id,
                    'request_date' => date('Y-m-d'),
                    'created_by' => $this->session->userdata('id'),
                    'created_at' => date('Y-m-d H:i:s')
                );

                $inserted = $this->model_rent_requests->create($data);
                //var_dump($inserted);
            }


        }

        if($inserted == true) {
            $response['success'] = true;
            $response['messages'] = 'Successfully created';
            $response['unique_id'] = $unique_id;

        }
        else {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while creating the information';
        }

        echo json_encode($response);

    }

    public function createMachineRequests()
    {
        if(!in_array('createMachineRequest', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $ids = $this->input->post('checked_id');

        $unique_id = date("Ymds");

        $inserted = true;

        $unique_id = date("Ymds");

        foreach ($ids as $id) {

            $this->db->select('*');
            $this->db->from('machine_types');
            //$this->db->where('is_deleted', 0);
            $this->db->where('name', $id['machine_type_name']);
            $query = $this->db->get();
            $machine_type = $query->row_array();
            $machine_type_id = $machine_type['id'];

//            $this->db->select('*');
//            $this->db->from('machine_models');
//            //$this->db->where('is_deleted', 0);
//            $this->db->where('name', $id['machine_model_name']);
//            $query = $this->db->get();
//            $machine_model = $query->row_array();
//            $machine_model_id = $machine_model['id'];

            $unique_id = date("Ymds");


                $data = array(
                    'machine_type_id' => $machine_type_id,
                    //'machine_model_id' => $machine_model_id,
                    'from_date' => $id['from_date'],
                    'to_date' => $id['to_date'],
                    'quantity' => $id['request_quantity'],
                    'created_by' => $this->session->userdata('id'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'request_date' => date('Y-m-d'),
                    'unique_id' => $unique_id
                );

                $inserted = $this->model_machine_requests->create($data);

        }

        if($inserted == true) {
            $response['success'] = true;
            $response['messages'] = 'Successfully created';
            $response['unique_id'] = $unique_id;

        }
        else {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while creating the information';
        }

        echo json_encode($response);

    }

    public function editBatch()
    {
        if(!in_array('updateStyleColor', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $color_data = $this->input->post('color_data');

        //$data = array();
        $update = false;
        foreach ($color_data as $color){
            $data = array(
                'color_name' => $color['color_name'],
                'color_code' => $color['color_code'],
                'updated_by' => $this->session->userdata('id'),
                'updated_at' => date('Y-m-d H:i:s')
            );

            $this->db->where('id', $color['color_id']);
            $update = $this->db->update('style_colors', $data);
        }

        if($update == true) {
            $response['success'] = true;
            $response['messages'] = 'Successfully updated';
        }
        else {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while updating the color information';
        }

        echo json_encode($response);
    }

    public function fetchStyleColorsDataById($id = null)
    {
        if($id) {
            $data = $this->model_style_colors->getStyleColorsData($id);
            echo json_encode($data);
        }

    }

    public function update($id)
    {
        if(!in_array('updateStyleColor', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        if($id) {
            $this->form_validation->set_rules('edit_color_name', 'Color Name', 'trim|required');
            $this->form_validation->set_rules('edit_color_code', 'Color Code', 'trim|required');
            $this->form_validation->set_rules('edit_style_id', 'Style', 'trim|required');

            $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'color_name' => $this->input->post('edit_color_name'),
                    'color_code' => $this->input->post('edit_color_code'),
                    'style_id' => $this->input->post('edit_style_id'),
                    'updated_by' => $this->session->userdata('id'),
                    'updated_at' => date('Y-m-d H:i:s')
                );

                $update = $this->model_style_colors->update($id, $data);
                if($update == true) {
                    $response['success'] = true;
                    $response['messages'] = 'Successfully updated';
                }
                else {
                    $response['success'] = false;
                    $response['messages'] = 'Error in the database while updated the brand information';
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
        if(!in_array('deleteStyleColor', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $style_color_id = $this->input->post('id');

        $response = array();
        if($style_color_id) {
            // $delete = $this->model_machine_ins->remove($machine_in_id);
            $data = array(
                'is_deleted' => 1,
                'deleted_by' => $this->session->userdata('id'),
                'deleted_at' => date('Y-m-d H:i:s')
            );

            $delete = $this->model_style_colors->update($style_color_id, $data);

            $style = $this->model_style_colors->getStyleColorsData($style_color_id);

            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully removed";
                $response['style_id'] = $style['style_id'];
            }
            else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the brand information";
            }

        }
        else {
            $response['success'] = false;
            $response['messages'] = "Refresh the page again!!";
        }

        echo json_encode($response);
    }

    public function returnOnLoanIssueReturn()
    {
        if(!in_array('createMachineOnLoanRequestReturn', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $ids = $this->input->post('checked_id');

        foreach ($ids as $id) {
            $data = array(
                'is_returned' => 1,
                'returned_at' => date('Y-m-d H:i:s')
            );

            $update = $this->model_machine_requests->update_on_loan_request($id['id'], $data);
        }

        //unique_id
        $unique_id = $this->input->post('unique_id');

        $sql = 'SELECT *
            FROM machine_requests as mr  
            WHERE mr.unique_id = ? 
            ';
        $query = $this->db->query($sql, array($unique_id));
        $rr_data = $query->row_array();
        $machine_request_id = $rr_data['id'];

        if($update == true) {
            $response['success'] = true;
            $response['messages'] = 'Successfully Returned';
            $response['unique_id'] = $machine_request_id;

        }
        else {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while approving the information';
        }

        echo json_encode($response);

    }

}