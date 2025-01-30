<?php

class Machines extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Machine';
        $this->load->model('model_machines');

    }

    public function index()
    {
        if(!in_array('viewMachine', $this->permission)) {
            redirect('dashboard', 'refresh');
        }


        $sql = "SELECT * FROM sections WHERE active = 1";
        $query = $this->db->query($sql);
        $this->data['sections'] = $query->result();


        $this->data['js'] = 'application/views/machines/index-js.php';
        $this->render_template('machines/index', $this->data);
    }

    public function fetchCategoryData()
    {
        if(!in_array('viewMachine', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());

        $data = $this->model_machines->getMachinesData();

        foreach ($data as $key => $value) {
            // button
            $buttons = '';

            if(in_array('updateMachine', $this->permission)) {
                $buttons = '<button type="button" class="btn btn-default" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal"><i class="text-primary fa fa-edit"></i></button>';
            }

            if(in_array('deleteMachine', $this->permission)) {
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="text-danger fa fa-trash"></i></button>';
            }

            $status = ($value['active'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';

            $result['data'][$key] = array(
                $value['name'],
                $status,
                $value['section_name'],
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }

    public function create()
    {
        if(!in_array('createMachine', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $this->form_validation->set_rules('machine_name', 'Machine name', 'trim|required');
        $this->form_validation->set_rules('active', 'Active', 'trim|required');
        $this->form_validation->set_rules('section', 'Section', 'trim|required');

        $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'name' => $this->input->post('machine_name'),
                'active' => $this->input->post('active'),
                'section' => $this->input->post('section')
            );

            $create = $this->model_machines->create($data);
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

    public function fetchMachinesDataById($id = null)
    {
        if($id) {
            $data = $this->model_machines->getMachinesData($id);
            echo json_encode($data);
        }

    }

    public function update($id)
    {
        if(!in_array('updateMachine', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        if($id) {
            $this->form_validation->set_rules('edit_machine_name', 'Machine name', 'trim|required');
            $this->form_validation->set_rules('edit_active', 'Active', 'trim|required');
            $this->form_validation->set_rules('edit_section', 'Section', 'trim|required');

            $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'name' => $this->input->post('edit_machine_name'),
                    'active' => $this->input->post('edit_active'),
                    'section' => $this->input->post('edit_section')
                );

                $update = $this->model_machines->update($id, $data);
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
        if(!in_array('deleteMachine', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $machine_id = $this->input->post('machine_id');

        $response = array();
        if($machine_id) {
            $delete = $this->model_machines->remove($machine_id);
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

}