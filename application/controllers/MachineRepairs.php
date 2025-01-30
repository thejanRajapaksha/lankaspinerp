<?php

class MachineRepairs extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Machine Repairs';
        $this->load->model('model_machine_repairs');

    }

    public function createRepair()
    {
        if(!in_array('createMachineRepair', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $data = array(
            'repair_id' => $this->input->post('repair_request_id'),
            'sub_total' => $this->input->post('sub_total'),
            'repair_done_by' => $this->input->post('repair_done_by'),
            'repair_charge' => $this->input->post('repair_charge'),
            'transport_charge' => $this->input->post('transport_charge'),
            'repair_type' => $this->input->post('repair_type'),
            'remarks' => $this->input->post('remarks'),
            'created_by' => $this->session->userdata('id'),
            'created_at' => date('Y-m-d H:i:s')
        );

        $create = $this->model_machine_repairs->create($data);
        //get last inserted id
        $repair_details_id = $this->db->insert_id();

        $repair_details = $this->input->post('repair_details');
        foreach ($repair_details as $value) {

            $service_item_name = $value['repair_item_name'];

            $this->db->select('*');
            $this->db->from('service_items');
            $this->db->where('name', $service_item_name);
            $query = $this->db->get();
            $result = $query->row_array();
            $service_item_id = $result['id'];

            $data = array(
                'machine_repair_details_id' => $repair_details_id,
                'service_item_id' => $service_item_id,
                'quantity' => $value['quantity'],
                'price' => $value['price'],
                'total' => $value['total'],
                'created_by' => $this->session->userdata('id'),
                'created_at' => date('Y-m-d H:i:s')
            );

            $this->model_machine_repairs->createRepairDetailItems($data);
        }

        if($create == true) {
            $response['success'] = true;
            $response['messages'] = 'Successfully created. The Page will be refreshed';
        }
        else {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while creating the information';
        }

        echo json_encode($response);
    }

    //postponeService
    public function postponeRepair()
    {
        if(!in_array('createMachineRepairPostpone', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();
        $id = $this->input->post('id');

        $repair = $this->model_machine_repairs->getMachineRepairDetails($id);
        $original_date = $repair['repair_in_date'];

        $data = array(
            'repair_in_date' => $this->input->post('repair_in_date'),
            'postpone_reason' => $this->input->post('reason'),
            'is_postponed' => 1,
            'original_date' => $original_date,
            'updated_by' => $this->session->userdata('id'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        $postpone = $this->model_machine_repairs->update($id, $data);
        if($postpone == true) {
            $response['success'] = true;
            $response['messages'] = 'Successfully Postponed. The Page will be refreshed.';
        }
        else {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while creating the information';
        }
        echo json_encode($response);
    }

    //deleteService
    public function deleteService()
    {
        if(!in_array('createMachineService', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $data = array(
            'is_deleted' => 1,
            'deleted_by' => $this->session->userdata('id'),
            'deleted_at' => date('Y-m-d H:i:s')
        );

        $response = array();
        $service_id = $this->input->post('id');
        $delete = $this->model_machine_services_calendar->update($service_id, $data);
        if($delete == true) {
            $response['success'] = true;
            $response['messages'] = 'Successfully deleted. The page will be refreshed.';
        }
        else {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while creating the information';
        }
        echo json_encode($response);
    }

    //get_employees_select
    public function get_employees_select()
    {
        $term = $this->input->get('term');
        $page = $this->input->get('page');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $current_user = $this->session->userdata('id');

        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('id', $current_user);
        $query = $this->db->get();
        $result = $query->row_array();

        $user_factory = $result['factory_id'];

        $this->db->select('*');
        $this->db->from('employees');
        $this->db->where('factory_id', $user_factory);
        $this->db->like('name_with_initial', $term, 'both');
        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $departments = $query->result_array();

        $this->db->select('*');
        $this->db->from('employees');
        $this->db->where('factory_id', $user_factory);
        $this->db->like('name_with_initial', $term, 'both');
        $count = $this->db->count_all_results();

        $data = array();
        foreach ($departments as $v) {
            $data[] = array(
                'id' => $v['id'],
                'text' => $v['name_with_initial']
            );
        }

        $endCount = $offset + $resultCount;
        $morePages = $endCount < $count;

        $results = array(
            "results" => $data,
            "pagination" => array(
                "more" => $morePages
            )
        );

        echo json_encode($results);

    }



}