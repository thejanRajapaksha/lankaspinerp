<?php

class MachineBrands extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Machine Brand';
        $this->load->model('model_machine_brands');

    }

    public function index()
    {
        if(!in_array('viewMachineBrand', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $this->data['js'] = 'application/views/machines/MachineBrands/index-js.php';
        $this->render_template('machines/MachineBrands/index', $this->data);
    }

    public function fetchCategoryData()
    {
        if(!in_array('viewMachineBrand', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());

        $data = $this->model_machine_brands->getMachineBrandsData();

        foreach ($data as $key => $value) {
            // button
            $buttons = '';

            if(in_array('updateMachineBrand', $this->permission)) {
                $buttons = '<button type="button" class="btn btn-default btn-sm" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal"><i class="text-primary fa fa-edit"></i></button>';
            }

            if(in_array('deleteMachineBrand', $this->permission)) {
                $buttons .= ' <button type="button" class="btn btn-default btn-sm" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="text-danger fa fa-trash"></i></button>';
            }

            $status = ($value['active'] == 1) ? '<span class="badge badge-success ">Active</span>' : '<span class="badge badge-warning">Inactive</span>';

            $result['data'][$key] = array(
                $value['name'],
                $status,
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }

    public function create()
    {
        if(!in_array('createMachineBrand', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $this->form_validation->set_rules('machine_brand_name', 'MachineBrand name', 'trim|required');
        $this->form_validation->set_rules('active', 'Active', 'trim|required');

        $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'name' => $this->input->post('machine_brand_name'),
                'active' => $this->input->post('active'),
            );

            $create = $this->model_machine_brands->create($data);
            if($create == true) {
                $response['success'] = true;
                $response['messages'] = 'Successfully created';
            }
            else {
                $response['success'] = false;
                $response['messages'] = 'Error in the database while creating the machine type information';
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

    public function fetchMachineBrandsDataById($id = null)
    {
        if($id) {
            $data = $this->model_machine_brands->getMachineBrandsData($id);
            echo json_encode($data);
        }

    }

    public function update($id)
    {
        if(!in_array('updateMachineBrand', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        if($id) {
            $this->form_validation->set_rules('edit_machine_brand_name', 'MachineBrand name', 'trim|required');
            $this->form_validation->set_rules('edit_active', 'Active', 'trim|required');

            $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'name' => $this->input->post('edit_machine_brand_name'),
                    'active' => $this->input->post('edit_active'),
                );

                $update = $this->model_machine_brands->update($id, $data);
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
        if(!in_array('deleteMachineBrand', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $machine_brand_id = $this->input->post('machine_brand_id');

        $response = array();
        if($machine_brand_id) {
            $delete = $this->model_machine_brands->remove($machine_brand_id);
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