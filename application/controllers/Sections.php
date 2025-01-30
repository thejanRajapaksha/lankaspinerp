<?php

class Sections extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Section';
        $this->load->model('model_sections');
        $this->load->model('model_departments');
        $this->load->model('model_factories');

    }

    public function index()
    {
        if(!in_array('viewSection', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        //get active factories
        $this->data['factories'] = $this->model_factories->getActiveFactories();

        $this->data['js'] = 'application/views/locations/sections/index-js.php';
        $this->render_template('locations/sections/index', $this->data);
    }

    public function fetchCategoryData()
    {
        if(!in_array('viewSection', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());

        $data = $this->model_sections->getSectionsData();

        foreach ($data as $key => $value) {
            // button
            $buttons = '';

            if(in_array('updateSection', $this->permission)) {
                $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal"><i class="text-primary fa fa-edit"></i></button>';
            }

            if(in_array('deleteSection', $this->permission)) {
                $buttons .= ' <button type="button" class="btn btn-default btn-sm" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="text-danger fa fa-trash"></i></button>';
            }

            $status = ($value['active'] == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-warning">Inactive</span>';

            $result['data'][$key] = array(
                $value['name'],
                $value['department_name'],
                $value['factory_name'],
                $status,
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }

    public function create()
    {
        if(!in_array('createSection', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $this->form_validation->set_rules('section_name', 'Section name', 'trim|required');
        $this->form_validation->set_rules('active', 'Active', 'trim|required');
        $this->form_validation->set_rules('department_id', 'Department', 'trim|required');
        $this->form_validation->set_rules('factory_id', 'Factory', 'trim|required');

        $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'name' => $this->input->post('section_name'),
                'active' => $this->input->post('active'),
                'department' => $this->input->post('department_id')
            );

            $create = $this->model_sections->create($data);
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

    public function fetchSectionsDataById($id = null)
    {
        if($id) {
            $data = $this->model_sections->getSectionsData($id);
            echo json_encode($data);
        }

    }

    public function update($id)
    {
        if(!in_array('updateSection', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        if($id) {
            $this->form_validation->set_rules('edit_section_name', 'Section name', 'trim|required');
            $this->form_validation->set_rules('edit_active', 'Active', 'trim|required');
            $this->form_validation->set_rules('edit_department_id', 'Department', 'trim|required');
            $this->form_validation->set_rules('edit_factory_id', 'Factory', 'trim|required');

            $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'name' => $this->input->post('edit_section_name'),
                    'active' => $this->input->post('edit_active'),
                    'department' => $this->input->post('edit_department_id')
                );

                $update = $this->model_sections->update($id, $data);
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
        if(!in_array('deleteSection', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $section_id = $this->input->post('section_id');

        $response = array();
        if($section_id) {
            $delete = $this->model_sections->remove($section_id);
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

    public function get_sections_select()
    {
        $term = $this->input->get('term');
        $department_id = empty($this->input->get('department_id')) ? null:$this->input->get('department_id');
        $page = $this->input->get('page');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $user_id = $this->session->userdata('id');
        $this->db->select('factory_id');
        $this->db->from('users');
        $this->db->where('id', $user_id );
        $query = $this->db->get();
        $u_data = $query->row_array();
        $factory_id = $u_data['factory_id'];

        $this->db->select('sections.*');
        $this->db->from('sections');
        $this->db->join('departments', 'departments.id = sections.department', 'left');
        $this->db->join('mbranchlist', 'mbranchlist.id = departments.factory_id', 'left');
        $this->db->where('sections.active', 1 );
        $this->db->like('sections.name', $term, 'both');
        if($department_id) {
            $this->db->where('sections.department', $department_id);
        }
        if($factory_id) {
            $this->db->where('mbranchlist.id', $factory_id);
        }

        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $departments = $query->result_array();

        $this->db->select('sections.*');
        $this->db->from('sections');
        $this->db->join('departments', 'departments.id = sections.department', 'left');
        $this->db->join('mbranchlist', 'mbranchlist.id = departments.factory_id', 'left');
        $this->db->where('sections.active', 1 );
        $this->db->like('sections.name', $term, 'both');
        if($department_id) {
            $this->db->where('sections.department', $department_id);
        }
        if($factory_id) {
            $this->db->where('mbranchlist.id', $factory_id);
        }
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