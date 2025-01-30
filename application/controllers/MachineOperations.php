<?php

class MachineOperations extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Machine Operation';
        $this->load->model('model_machine_operations');
        $this->load->model('model_operations_for_machines');

    }

    public function index()
    {
        if(!in_array('viewMachineOperation', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->data['operations'] = $this->model_operations_for_machines->getActiveOperationsForMachine();

        $this->data['js'] = 'application/views/machines/MachineOperations/index-js.php';
        $this->render_template('machines/MachineOperations/index', $this->data);
    }

    public function fetchCategoryData()
    {
        if(!in_array('viewMachineOperation', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());

        $data = $this->model_machine_operations->getMachineOperationsData();

        foreach ($data as $key => $value) {
            // button
            $buttons = '';

            $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="viewFunc('.$value['machine_type_id'].')" data-toggle="modal" data-target="#viewModal"><i class="fas fa-eye text-info"></i></button>';
 
            $result['data'][$key] = array(
                $value['machine_type_name'],
                $value['operation_count'],
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }

    public function create()
    {
        if(!in_array('createMachineOperation', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $this->form_validation->set_rules('machine_type_id', 'Machine', 'trim|required');

        $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {

            $operation_id = $this->input->post('operation_id[]');

            if($operation_id != null) {

                $operations_found = false;
                $operation_string = '';
                foreach ($operation_id as $oid1) {
                    //check if the operation_id is already added for the machine_in_id
                    $check = $this->model_machine_operations->checkMachineOperation($oid1, $this->input->post('machine_type_id'));

                    if(!empty($check)){
                        $operations_found = true;
                        foreach ($check as $c) {
                            $operation_string .= $c['operation_name'].', ';
                        }
                    }
                }

                if($operations_found){
                    $response['success'] = false;
                    //remove the last comma
                    $operation_string = rtrim($operation_string, ', ');
                    $response['messages']['operation_id'] = '<p class="text-danger"> <strong> '.$operation_string.' </strong> Operation already added for this machine </p>';
                    echo json_encode($response);
                    die();
                }

                $data = array();
                foreach ($operation_id as $oid) {
                    $data[] = array(
                        'machine_type_id' => $this->input->post('machine_type_id'),
                        'operation_id' => $oid,
                        'created_by' => $this->session->userdata('id'),
                        'created_at' => date('Y-m-d H:i:s')
                    );
                }

                //batch insert to machine_operations table
                $create = $this->db->insert_batch('machine_operations', $data);
                if($create == true) {
                    $response['success'] = true;
                    $response['messages'] = 'Successfully created';
                }
                else {
                    $response['success'] = false;
                    $response['messages'] = 'Error in the database while creating the machine type information';
                }

            }else{
                $response['success'] = false;
                $response['messages']['operation_id'] = '<p class="text-danger"> Please select at least one operation </p>';
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

    public function fetchMachineOperationsDataById($id = null)
    {
        if($id) {
            $data = $this->model_machine_operations->getMachineOperationsData($id);
            echo json_encode($data);
        }

    }

    public function update($id)
    {
        if(!in_array('updateMachineOperation', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        if($id) {
            $this->form_validation->set_rules('edit_machine_operation_name', 'MachineOperation name', 'trim|required');
            $this->form_validation->set_rules('edit_active', 'Active', 'trim|required');

            $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'name' => $this->input->post('edit_machine_operation_name'),
                    'active' => $this->input->post('edit_active'),
                );

                $update = $this->model_machine_operations->update($id, $data);
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
        if(!in_array('deleteMachineOperation', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $machine_operation_id = $this->input->post('machine_operation_id');

        $response = array();
        if($machine_operation_id) {

            $data = array(
                'is_deleted' => 1,
                'deleted_by' => $this->session->userdata('id'),
                'deleted_at' => date('Y-m-d H:i:s')
            );

            $delete = $this->model_machine_operations->update($machine_operation_id, $data);

            $machine_operations = $this->model_machine_operations->getMachineOperationsData($machine_operation_id);

            if($delete == true) {
                $response['machine_type_id'] = $machine_operations['machine_type_id'];
                $response['success'] = true;
                $response['messages'] = "Successfully removed";
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

    public function fetchMachineOperationsByMachineInId($id = null)
    {
        if($id) {
            $data = $this->model_machine_operations->getMachineOperationsDataByMachineInId($id);
            echo json_encode($data);
        }

    }

    public function get_operations_by_machine_type_id($id = null)
    {
        if($id) {
            $data = $this->model_machine_operations->getMachineOperationsDataByMachineTypeId($id);
            echo json_encode($data);
        }

    }

    public function get_operations_by_machine_type_ids()
    {
        $machine_type_ids = $this->input->post('machine_type_ids');
        $data = array();
        foreach ($machine_type_ids as $machine_type_id) {
            $data = array_merge($data, $this->model_machine_operations->getMachineOperationsDataByMachineTypeIdFull($machine_type_id));
        }

        echo json_encode($data);

    }

    public function get_MachineOperations_select()
    {
        $term = $this->input->get('term');
        $page = $this->input->get('page');
        $machine_type_id = $this->input->get('machine_type_id');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $this->db->select('operations_for_machines.id, operations_for_machines.name, operation_types.name as operation_type_name, operation_types.class_type as operation_type_class_type');
        $this->db->from('machine_operations');
        $this->db->join('machine_types', 'machine_types.id = machine_operations.machine_type_id', 'left');
        $this->db->join('operations_for_machines', 'operations_for_machines.id = machine_operations.operation_id', 'left');
        $this->db->join('operation_types', 'operation_types.id = operations_for_machines.operation_type_id', 'left');
        $this->db->where('machine_operations.is_deleted', 0 );
        $this->db->where('operations_for_machines.active', 1 );
        $this->db->like('operations_for_machines.name', $term, 'both');

        if($machine_type_id) {
            $this->db->where('machine_operations.machine_type_id', $machine_type_id);
        }

        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $departments = $query->result_array();

        $this->db->select('operations_for_machines.id, operations_for_machines.name, operation_types.name as operation_type_name, operation_types.class_type as operation_type_class_type');
        $this->db->from('machine_operations');
        $this->db->join('machine_types', 'machine_types.id = machine_operations.machine_type_id', 'left');
        $this->db->join('operations_for_machines', 'operations_for_machines.id = machine_operations.operation_id', 'left');
        $this->db->join('operation_types', 'operation_types.id = operations_for_machines.operation_type_id', 'left');
        $this->db->where('machine_operations.is_deleted', 0 );
        $this->db->where('operations_for_machines.active', 1 );
        $this->db->like('operations_for_machines.name', $term, 'both');

        if($machine_type_id) {
            $this->db->where('machine_operations.machine_type_id', $machine_type_id);
        }

        $count = $this->db->count_all_results();

        $data = array();
        foreach ($departments as $v) {
            $data[] = array(
                'id' => $v['id'],
                'text' => $v['name']. ' - ' . $v['operation_type_name'],
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