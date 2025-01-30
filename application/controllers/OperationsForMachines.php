<?php

class OperationsForMachines extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Operations for Machines';
        $this->load->model('model_operations_for_machines');

    }

    public function index()
    {
        if(!in_array('viewOperationsForMachine', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->data['operation_types'] = $this->model_operations_for_machines->getOperationTypes();
        $this->data['js'] = 'application/views/machines/operations_for_machines/index-js.php';
        $this->render_template('machines/operations_for_machines/index', $this->data);
    }

    public function fetchCategoryData()
    {
        if(!in_array('viewOperationsForMachine', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());

        $data = $this->model_operations_for_machines->getOperationsForMachinesData();

        foreach ($data as $key => $value) {
            // button
            $buttons = '';

            if(in_array('updateOperationsForMachine', $this->permission)) {
                $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal"><i class="text-primary fa fa-edit"></i></button>';
            }

            if(in_array('deleteOperationsForMachine', $this->permission)) {
                $buttons .= ' <button type="button" class="btn btn-default btn-sm" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="text-danger fa fa-trash"></i></button>';
            }

            $status = ($value['active'] == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-warning">Inactive</span>';
            $type = '<span class="badge badge-'.$value['operation_type_class_type'].'"> '.$value['operation_type_name'].' </span>';

            $result['data'][$key] = array(
                $value['name'],
                $type,
                $status,
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }

    public function create()
    {
        if(!in_array('createOperationsForMachine', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $this->form_validation->set_rules('operation_name', 'Operation name', 'trim|required');
        $this->form_validation->set_rules('active', 'Active', 'trim|required');
        $this->form_validation->set_rules('operation_type_id', 'Operation Type', 'trim|required');

        $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'name' => $this->input->post('operation_name'),
                'active' => $this->input->post('active'),
                'operation_type_id' => $this->input->post('operation_type_id'),
            );

            $create = $this->model_operations_for_machines->create($data);
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

    public function fetchOperationsForMachinesDataById($id = null)
    {
        if($id) {
            $data = $this->model_operations_for_machines->getOperationsForMachinesData($id);
            echo json_encode($data);
        }

    }

    public function update($id)
    {
        if(!in_array('updateOperationsForMachine', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        if($id) {
            $this->form_validation->set_rules('edit_operation_name', 'Operation name', 'trim|required');
            $this->form_validation->set_rules('edit_active', 'Active', 'trim|required');
            $this->form_validation->set_rules('edit_operation_type_id', 'Operation Type', 'trim|required');

            $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'name' => $this->input->post('edit_operation_name'),
                    'active' => $this->input->post('edit_active'),
                    'operation_type_id' => $this->input->post('edit_operation_type_id')
                );

                $update = $this->model_operations_for_machines->update($id, $data);
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
        if(!in_array('deleteOperationsForMachine', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $operation_id = $this->input->post('operation_id');

        $response = array();
        if($operation_id) {
            $delete = $this->model_operations_for_machines->remove($operation_id);
            if($delete == true) {
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

    public function get_operations_for_machines_select()
    {
        $term = $this->input->get('term');
        $page = $this->input->get('page');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $this->db->select('*');
        $this->db->from('operations_for_machines');
        $this->db->where('active', 1 );
        $this->db->like('name', $term, 'both');
        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $departments = $query->result_array();

        $this->db->from('operations_for_machines');
        $this->db->where('active', 1 );
        $this->db->like('name', $term, 'both');
        $count = $this->db->count_all_results();

        $data = array();
        foreach ($departments as $v) {
            $data[] = array(
                'id' => $v['id'],
                'text' => $v['name'],
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