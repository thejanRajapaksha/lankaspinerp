<?php

class Slots extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Slot';
        $this->load->model('model_slots');
        $this->load->model('model_sections');
        $this->load->model('model_factories');
        $this->load->model('model_operation_breakdown_allocations');

    }

    public function index()
    {
        if(!in_array('viewSlot', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->data['js'] = 'application/views/locations/slots/index-js.php';
        $this->render_template('locations/slots/index', $this->data);
    }

    public function fetchCategoryData()
    {
        if(!in_array('viewSlot', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());

        $data = $this->model_slots->getSlotsData();

        $this->load->model('IoModule_model');
		$inst_slot_data = $this->IoModule_model->getIoInstallations();
		
		foreach ($data as $key => $value) {
            // button
            $buttons = '';

            if(in_array('updateSlot', $this->permission)) {
                $buttons = '<button type="button" class="btn btn-default btn-sm" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal"><i class="text-primary fa fa-edit"></i></button>';
            }

            if(in_array('deleteSlot', $this->permission)) {
                $buttons .= ' <button type="button" class="btn btn-default btn-sm" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="text-danger fa fa-trash"></i></button>';
            }

            $status = ($value['active'] == 1) ? '<span class="badge badge-success ">Active</span>' : '<span class="badge badge-warning">Inactive</span>';
			
			$inst_str = isset($inst_slot_data[$value['id']])?'Tracked':'Untracked';
			$status .= '<span style="cursor:pointer;" class="badge badge-info revw_inst" data-refslot="'.$value['id'].'">'.$inst_str.'</span>';

            $result['data'][$key] = array(
                $value['name'],
                $value['line_name'],
                $value['section_name'],
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
        if(!in_array('createSlot', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $this->form_validation->set_rules('slot_name', 'Slot name', 'trim|required');
        $this->form_validation->set_rules('active', 'Active', 'trim|required');
        $this->form_validation->set_rules('department_id', 'Department', 'trim|required');
        $this->form_validation->set_rules('factory_id', 'Factory', 'trim|required');
        $this->form_validation->set_rules('section_id', 'Section', 'trim|required');
        $this->form_validation->set_rules('line_id', 'Line', 'trim|required');

        $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'name' => $this->input->post('slot_name'),
                'active' => $this->input->post('active'),
                'line' => $this->input->post('line_id')
            );

            $create = $this->model_slots->create($data);
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

    public function fetchSlotsDataById($id = null)
    {
        if($id) {
            $data = $this->model_slots->getSlotsData($id);
            echo json_encode($data);
        }

    }

    public function update($id)
    {
        if(!in_array('updateSlot', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        if($id) {
            $this->form_validation->set_rules('edit_slot_name', 'Slot name', 'trim|required');
            $this->form_validation->set_rules('edit_active', 'Active', 'trim|required');
            $this->form_validation->set_rules('edit_department_id', 'Department', 'trim|required');
            $this->form_validation->set_rules('edit_factory_id', 'Factory', 'trim|required');
            $this->form_validation->set_rules('edit_section_id', 'Section', 'trim|required');
            $this->form_validation->set_rules('edit_line_id', 'Section', 'trim|required');

            $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'name' => $this->input->post('edit_slot_name'),
                    'active' => $this->input->post('edit_active'),
                    'line' => $this->input->post('edit_line_id')
                );

                $update = $this->model_slots->update($id, $data);
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
        if(!in_array('deleteSlot', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $slot_id = $this->input->post('slot_id');

        $response = array();
        if($slot_id) {
            $delete = $this->model_slots->remove($slot_id);
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

    public function get_slots_select()
    {
        $term = $this->input->get('term');
        $line_id = $this->input->get('line_id') ?? null;
		//$line_id = '';//$this->input->get('line_id') ?? null;
        $page = $this->input->get('page');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $this->db->select('*');
        $this->db->from('slots');
        $this->db->where('active', 1 );
        $this->db->like('name', $term, 'both');
        if($line_id) {
            $this->db->where('line', $line_id);
        }
        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $sections = $query->result_array();

        $this->db->from('slots');
        $this->db->where('active', 1 );
        $this->db->like('name', $term, 'both');
        if($line_id) {
            $this->db->where('line', $line_id);
        }
        $count = $this->db->count_all_results();

        $data = array();
        foreach ($sections as $v) {
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

    public function get_line_slots_with_operation_breakdowns(){

        $line_id = $this->input->post('line_id');
        $style_id = $this->input->post('style_id');
        $slots = $this->model_slots->get_line_slots($line_id);
        $allocated_operation_breakdowns = $this->model_operation_breakdown_allocations->get_allocated_operation_breakdowns($style_id);

        $data = array(
            'slots' => $slots,
            'allocated_operation_breakdowns' => $allocated_operation_breakdowns
        );

        echo json_encode($data);

    }

}