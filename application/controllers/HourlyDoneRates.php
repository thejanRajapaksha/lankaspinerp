<?php

class HourlyDoneRates extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Hourly Done Rate';
        $this->load->model('model_hourly_done_rate');

    }

    public function index()
    {
        if(!in_array('viewHourlyDoneRate', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->data['js'] = 'application/views/HourlyDoneRates/index-js.php';
        $this->render_template('HourlyDoneRates/index', $this->data);
    }

    public function fetchCategoryData()
    {
        if(!in_array('viewHourlyDoneRate', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());

        $data = $this->model_hourly_done_rate->getHourlyDoneRatesData();

        foreach ($data as $key => $value) {
            // button
            $buttons = '';

            if(in_array('updateHourlyDoneRate', $this->permission)) {
                $buttons = '<button type="button" class="btn btn-default btn-sm" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal"><i class="text-primary fa fa-edit"></i></button>';
            }

            if(in_array('deleteHourlyDoneRate', $this->permission)) {
                $buttons .= ' <button type="button" class="btn btn-default btn-sm" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="text-danger fa fa-trash"></i></button>';
            }

            $result['data'][$key] = array(
                $value['name_with_initial'],
                $value['line_name'],
                $value['sabs_style_id'],
                $value['operation_name'],
                $value['s_no'],
                $value['qty'],
                $value['hour'],
                $value['date'],
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }

    public function create()
    {
        if(!in_array('createHourlyDoneRate', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $this->form_validation->set_rules('barcode', 'Barcode', 'trim|required');
        $this->form_validation->set_rules('line_id', 'Line ID', 'trim|required');
        $this->form_validation->set_rules('sabs_style_id', 'SABS Style ID', 'trim|required');
        $this->form_validation->set_rules('operation_id', 'Operation', 'trim|required');
        $this->form_validation->set_rules('machine_in_id', 'Machine', 'trim|required');
        $this->form_validation->set_rules('qty', 'QTY', 'trim|required');
        $this->form_validation->set_rules('hour', 'Hour', 'trim|required');
        $this->form_validation->set_rules('date', 'Date', 'trim|required');

        $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {

            $this->db->trans_start();

            $slotId = !empty($this->input->post('slot_id'))?$this->input->post('slot_id'):0;
			$instId = !empty($this->input->post('inst_id'))?$this->input->post('inst_id'):0;
			
			$data = array(
                'emp_id' => $this->input->post('barcode'),
                'line_id' => $this->input->post('line_id'),
                'sabs_style_id' => $this->input->post('sabs_style_id'),
                'operation_id' => $this->input->post('operation_id'),
                'machine_in_id' => $this->input->post('machine_in_id'),
                'qty' => $this->input->post('qty'),
                'hour' => $this->input->post('hour'),
                'date' => $this->input->post('date'),
				'slot_id' => $slotId,
				'machine_allocation_current_id' => $instId
            );
            $create = $this->model_hourly_done_rate->create($data);

            $this->db->trans_complete();

            if($this->db->trans_status() == true) {
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

    public function fetchHourlyDoneRatesDataById($id = null)
    {
        if($id) {
            $data = $this->model_hourly_done_rate->getHourlyDoneRatesData($id);

            echo json_encode($data);
        }

    }

    public function update($id)
    {
        if(!in_array('updateHourlyDoneRate', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        if($id) {

            $this->form_validation->set_rules('edit_barcode', 'Barcode', 'trim|required');
            $this->form_validation->set_rules('edit_line_id', 'Line ID', 'trim|required');
            $this->form_validation->set_rules('edit_sabs_style_id', 'SABS Style ID', 'trim|required');
            $this->form_validation->set_rules('edit_operation_id', 'Operation', 'trim|required');
            $this->form_validation->set_rules('edit_machine_in_id', 'Machine', 'trim|required');
            $this->form_validation->set_rules('edit_qty', 'QTY', 'trim|required');
            $this->form_validation->set_rules('edit_hour', 'Hour', 'trim|required');
            $this->form_validation->set_rules('edit_date', 'Date', 'trim|required');

            $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

            if ($this->form_validation->run() == TRUE) {

                $data = array(
                    'emp_id' => $this->input->post('edit_barcode'),
                    'line_id' => $this->input->post('edit_line_id'),
                    'sabs_style_id' => $this->input->post('edit_sabs_style_id'),
                    'operation_id' => $this->input->post('edit_operation_id'),
                    'machine_in_id' => $this->input->post('edit_machine_in_id'),
                    'qty' => $this->input->post('edit_qty'),
                    'hour' => $this->input->post('edit_hour'),
                    'date' => $this->input->post('edit_date'),
                );

                $update = $this->model_hourly_done_rate->update($id, $data);
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
        if(!in_array('deleteHourlyDoneRate', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $machine_type_id = $this->input->post('machine_type_id');

        $response = array();
        if($machine_type_id) {
            $data = array(
                'is_deleted' => 1,
                'deleted_by' => $this->session->userdata('id'),
                'deleted_at' => date('Y-m-d H:i:s')
            );

            $delete = $this->model_hourly_done_rate->update($machine_type_id, $data);

            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully removed";
            }
            else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the information";
            }
        }
        else {
            $response['success'] = false;
            $response['messages'] = "Refresh the page again!!";
        }

        echo json_encode($response);
    }

    public function get_parts_select()
    {
        $term = $this->input->get('term');
        $page = $this->input->get('page');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $this->db->select('*');
        $this->db->from('spare_parts');
        $this->db->like('name', $term, 'both');
        $this->db->like('part_no', $term, 'both');
        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $machine_ins = $query->result_array();

        $this->db->select('*');
        $this->db->from('spare_parts');
        $this->db->like('name', $term, 'both');
        $this->db->like('part_no', $term, 'both');
        $count = $this->db->count_all_results();

        $data = array();
        foreach ($machine_ins as $v) {
            $data[] = array(
                'id' => $v['id'],
                'text' => $v['name'] . ' - ' . $v['part_no']
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

    public function fetchUnitPrice()
    {
        $id = $this->input->post('spare_part_id');
        if($id) {
            $data = $this->model_hourly_done_rate->getHourlyDoneRatesData($id);
            echo json_encode($data);
        }

    }

    public function get_sabs_select()
    {
        $term = $this->input->get('term');
        $page = $this->input->get('page');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $this->db->select('*');
        $this->db->from('salesorder_info');
        $this->db->like('sabs_styleid', $term, 'both');
        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $machine_ins = $query->result_array();

        $this->db->select('*');
        $this->db->from('salesorder_info');
        $this->db->like('sabs_styleid', $term, 'both');
        $count = $this->db->count_all_results();

        $data = array();
        foreach ($machine_ins as $v) {
            $data[] = array(
                'id' => $v['sabs_styleid'],
                'text' => $v['sabs_styleid']
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