<?php

class MachineIns extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Machine In';
        $this->load->model('model_machine_ins');
        $this->load->model('model_machine_models');
       // $this->load->model('model_factories');
        $this->load->model('model_machine_types');

    }

    public function index()
    {
        if(!in_array('viewMachineIn', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->data['machine_types'] = $this->model_machine_types->getMachineTypesData();
        $this->data['machine_models'] = $this->model_machine_models->getMachineModelsData();
       // $this->data['factories'] = $this->model_factories->getFactoriesData();

        $this->db->select('*');
        $this->db->from('in_types');
        $this->db->where('active', 1 );
        $query = $this->db->get();
        $this->data['in_types'] = $query->result_array();

        $this->data['js'] = 'application/views/machines/MachineIns/index-js.php';
        $this->render_template('machines/MachineIns/index', $this->data);
    }

    public function fetchCategoryData()
    {
        if(!in_array('viewMachineIn', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());

        $data = $this->model_machine_ins->getMachineInsData();

        foreach ($data as $key => $value) {
            // button
            $buttons = '';

            if(in_array('updateMachineIn', $this->permission)) {
                $buttons = '<button type="button" class="btn btn-default btn-sm" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal"><i class="text-primary fa fa-edit"></i></button>';
            }

            if(in_array('deleteMachineIn', $this->permission)) {
                $buttons .= ' <button type="button" class="btn btn-default btn-sm" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="text-danger fa fa-trash"></i></button>';
            }

            $status = ($value['active'] == 1) ? '<span class="badge badge-success ">Active</span>' : '<span class="badge badge-warning">Inactive</span>';

            $result['data'][$key] = array(
                $value['machine_type_name'],
                $value['machine_model_name'],
                $value['s_no'],
                $value['bar_code'],
                $value['next_service_date'],
                $value['origin_date'],
                $value['reference'],
                $status,
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }

    public function create()
    {
        if(!in_array('createMachineIn', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $this->form_validation->set_rules('active', 'Active', 'trim|required');
        $this->form_validation->set_rules('machine_type_id', 'Machine Type', 'trim|required');
        $this->form_validation->set_rules('machine_model_id', 'Machine Model', 'trim|required');
        $this->form_validation->set_rules('s_no', 'S NO', 'trim|required|max_length[250]');
        $this->form_validation->set_rules('bar_code', 'Bar Code', 'trim|required|max_length[250]');
        $this->form_validation->set_rules('in_type_id', 'In Type', 'trim|required');
        $this->form_validation->set_rules('next_service_date', 'Next Service Date', 'trim|max_length[250]');
        $this->form_validation->set_rules('origin_date', 'Origin Date', 'trim|max_length[250]');
        $this->form_validation->set_rules('reference', 'Reference', 'trim|required|max_length[250]');

        $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'active' => $this->input->post('active'),
                'machine_type_id' => $this->input->post('machine_type_id'),
                'machine_model_id' => $this->input->post('machine_model_id'),
                's_no' => $this->input->post('s_no'),
                'bar_code' => $this->input->post('bar_code'),
                'in_type_id' => $this->input->post('in_type_id'),
                'next_service_date' => $this->input->post('next_service_date'),
                'origin_date' => $this->input->post('origin_date'),
                'reference' => $this->input->post('reference'),
                'created_by' => $this->session->userdata('id'),
                'created_at' => date('Y-m-d H:i:s')
            );

            $create = $this->model_machine_ins->create($data);
            if($create == true) {
                $response['success'] = true;
                $response['messages'] = 'Successfully created';
            }
            else {
                $response['success'] = false;
                $response['messages'] = 'Error in the database while creating the Machine In information';
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

    public function fetchMachineInsDataById($id = null)
    {
        if($id) {
            $data = $this->model_machine_ins->getMachineInsData($id);
            echo json_encode($data);
        }

    }

    public function update($id)
    {
        if(!in_array('updateMachineIn', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        if($id) {
            $this->form_validation->set_rules('active', 'Active', 'trim|required');
            $this->form_validation->set_rules('machine_type_id', 'Machine Type', 'trim|required');
            $this->form_validation->set_rules('machine_model_id', 'Machine Model', 'trim|required');
            $this->form_validation->set_rules('s_no', 'S NO', 'trim|required|max_length[250]');
            $this->form_validation->set_rules('bar_code', 'Bar Code', 'trim|required|max_length[250]');
            $this->form_validation->set_rules('in_type_id', 'In Type', 'trim|required');
            $this->form_validation->set_rules('next_service_date', 'Next Service Date', 'trim|max_length[250]');
            $this->form_validation->set_rules('origin_date', 'Origin Date', 'trim|max_length[250]');
            $this->form_validation->set_rules('reference', 'Reference', 'trim|required|max_length[250]');

            $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'active' => $this->input->post('active'),
                    'machine_type_id' => $this->input->post('machine_type_id'),
                    'machine_model_id' => $this->input->post('machine_model_id'),
                    's_no' => $this->input->post('s_no'),
                    'bar_code' => $this->input->post('bar_code'),
                    'in_type_id' => $this->input->post('in_type_id'),
                    'next_service_date' => $this->input->post('next_service_date'),
                    'origin_date' => $this->input->post('origin_date'),
                    'reference' => $this->input->post('reference'),
                    'updated_by' => $this->session->userdata('id'),
                    'updated_at' => date('Y-m-d H:i:s')
                );

                $update = $this->model_machine_ins->update($id, $data);
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
        if(!in_array('deleteMachineIn', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $machine_in_id = $this->input->post('machine_in_id');

        $response = array();
        if($machine_in_id) {
           // $delete = $this->model_machine_ins->remove($machine_in_id);
            $data = array(
                'is_deleted' => 1,
                'deleted_by' => $this->session->userdata('id'),
                'deleted_at' => date('Y-m-d H:i:s')
            );

            $delete = $this->model_machine_ins->update($machine_in_id, $data);

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

    public function get_machine_ins_select()
    {
        $term = $this->input->get('term');
        $page = $this->input->get('page');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $this->db->select('machine_ins.*, machine_types.name as machine_type_name, machine_models.name as machine_model_name');
        $this->db->from('machine_ins');
        $this->db->join('machine_types', 'machine_types.id = machine_ins.machine_type_id', 'left');
        $this->db->join('machine_models', 'machine_models.id = machine_ins.machine_model_id', 'left');
        $this->db->like('s_no', $term, 'both');
        //$this->db->or_like('machine_types.name', $term, 'both');
        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $machine_ins = $query->result_array();

        $this->db->select('machine_ins.*, machine_types.name as machine_type_name, machine_models.name as machine_model_name');
        $this->db->from('machine_ins');
        $this->db->join('machine_types', 'machine_types.id = machine_ins.machine_type_id', 'left');
        $this->db->join('machine_models', 'machine_models.id = machine_ins.machine_model_id', 'left');
        $this->db->like('s_no', $term, 'both');
        //$this->db->or_like('machine_types.name', $term, 'both');
        $count = $this->db->count_all_results();

        $data = array();
        foreach ($machine_ins as $v) {
            $data[] = array(
                'id' => $v['s_no'],
                'text' => $v['s_no']
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

    public function get_released_machines()
    {
        $term = $this->input->get('term');
        $page = $this->input->get('page');

        $machine_model_name = $this->input->get('machine_model_name');
        $machine_type_name = $this->input->get('machine_type_name');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        //machine_ins where machine_ins.id not in (select machine_id from machine_allocation_current)

        $machine_model_id = $this->db->select('id')->from('machine_models')->where('name', $machine_model_name)->get()->row()->id;
        $machine_type_id = $this->db->select('id')->from('machine_types')->where('name', $machine_type_name)->get()->row()->id;

        $this->db->select('machine_ins.*');
        $this->db->from('machine_ins');
        $this->db->where('machine_ins.id not in (select machine_in_id from machine_allocation_current)');
        $this->db->where('machine_ins.id not in (select machine_in_id from machine_request_onloan_issue_machines where is_returned = 0)');

        $this->db->where('machine_ins.machine_model_id', $machine_model_id);
        $this->db->where('machine_ins.machine_type_id', $machine_type_id);
        $this->db->like('s_no', $term, 'both');
        //left join factory
        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $machine_ins = $query->result_array();

        $this->db->select('machine_ins.*');
        $this->db->from('machine_ins');
        $this->db->where('machine_ins.id not in (select machine_in_id from machine_allocation_current)');
        $this->db->where('machine_ins.id not in (select machine_in_id from machine_request_onloan_issue_machines where is_returned = 0)');
        $this->db->where('machine_ins.machine_model_id', $machine_model_id);
        $this->db->where('machine_ins.machine_type_id', $machine_type_id);
        $this->db->like('s_no', $term, 'both');
        $count = $this->db->count_all_results();

        $data = array();
        foreach ($machine_ins as $v) {
            $data[] = array(
                'id' => $v['id'],
                'text' => $v['s_no']
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

    public function get_machine_ins_select_id()
    {
        $term = $this->input->get('term');
        $page = $this->input->get('page');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $this->db->select('machine_ins.* ');
        $this->db->from('machine_ins');
        $this->db->like('s_no', $term, 'both');
        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $machine_ins = $query->result_array();

        $this->db->select('machine_ins.* ');
        $this->db->from('machine_ins');
        $this->db->like('s_no', $term, 'both');
        $count = $this->db->count_all_results();

        $data = array();
        foreach ($machine_ins as $v) {
            $data[] = array(
                'id' => $v['id'],
                'text' => $v['s_no']
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

    //getFactoryCodeByMachineInId
   /* public function getFactoryCodeByMachineInId()
    {
        $machine_in_id = $this->input->post('machine_in_id');
        $this->db->select('br_code');
        $this->db->from('mbranchlist');
        $this->db->join('machine_ins', 'machine_ins.factory_id = mbranchlist.id');
        $this->db->where('machine_ins.id', $machine_in_id);
        $query = $this->db->get();
        $factory_code = $query->row()->br_code;
        echo json_encode($factory_code);
    }*/

}