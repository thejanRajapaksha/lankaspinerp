<?php

class MachineOperationDesc extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Machine Operation Description';
        $this->load->model('model_machine_operation_desc');
        $this->load->model('model_machine_types');
        $this->load->model('model_machine_models');
        $this->load->model('model_rent_requests');
        $this->load->model('model_onloan_issue_machines');
        $this->load->model('model_factories');

    }

    public function index()
    {
        if(!in_array('viewMachineOperationDesc', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        //machine_types
        $this->data['machine_types'] = $this->model_machine_types->getActiveMachineType();

        $this->db->select('*');
        $this->db->from("criticalities");
        $query = $this->db->get();
        $criti = $query->result_array();
        $this->data['criticalities'] = $criti;

        $this->db->select('*');
        $this->db->from("mod_values");
        $query = $this->db->get();
        $criti = $query->result_array();
        $this->data['values'] = $criti;

        $last_row = $this->db->select('*')->order_by('id',"desc")->limit(1)->get('machine_operation_desc')->row();
        $last_id = isset($last_row->operation_id)?$last_row->operation_id:"JSOL0001";
        $id = ((int) substr($last_id, -4)) + 1;

        $number = str_pad($id, 4, "0", STR_PAD_LEFT);

        $this->data['new_op_id'] = 'JSOL'.$number;
        //machine_models
        $this->data['machine_models'] = $this->model_machine_models->getActiveMachineModel();

        $this->data['js'] = 'application/views/MachineOperationDesc/MachineOperationDesc/index-js.php';
        $this->render_template('MachineOperationDesc/MachineOperationDesc/index', $this->data);
    }

    public function approve_front()
    {
        if(!in_array('createMachineOperationDescApprove', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        //machine_types
        $this->data['machine_types'] = $this->model_machine_types->getActiveMachineType();

        $this->db->select('*');
        $this->db->from("criticalities");
        $query = $this->db->get();
        $criti = $query->result_array();
        $this->data['criticalities'] = $criti;

//        $last_row = $this->db->select('*')->order_by('id',"desc")->limit(1)->get('machine_operation_desc')->row();
//        $last_id = $last_row->operation_id ?? "JSOL0001";
//        $id = ((int) substr($last_id, -4)) + 1;
//
//        $number = str_pad($id, 4, "0", STR_PAD_LEFT);
//
//        $this->data['new_op_id'] = 'JSOL'.$number;
        //machine_models
        $this->data['machine_models'] = $this->model_machine_models->getActiveMachineModel();

        $this->data['js'] = 'application/views/MachineOperationDesc/MachineOperationDesc/approve-js.php';
        $this->render_template('MachineOperationDesc/MachineOperationDesc/approve', $this->data);
    }

    public function fetchCategoryData()
    {
        if(!in_array('viewMachineOperationDesc', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());

        $data = $this->model_machine_operation_desc->getMachineOperationDescData();

        foreach ($data as $key => $value) {

            // button
            $buttons = '';

            //$buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="viewFunc('.$value['unique_id'].')" data-toggle="modal" data-target="#viewModal"><i class="fas fa-eye text-info"></i></button>';

            if(in_array('updateMachineOperationDesc', $this->permission)) {
                $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal"><i class="text-primary fa fa-edit"></i></button>';
            }

            if(in_array('deleteMachineOperationDesc', $this->permission)) {
                $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="text-danger fa fa-trash"></i></button>';
            }

            $doc_link = '';
            if($value['documents'] != ''){
                $doc_link = '<a target="_blank" href="'.base_url().'uploads/'.$value['documents'].'"> File </a>';
            }

            $video_link = '';
            if($value['video'] != '') {
                $video_link = '<a target="_blank" href="' . base_url() . 'uploads/' . $value['video'] . '"> Video </a>';
            }

            $cb = '<label>';
            $cb .= '<input type="checkbox" ';
            $cb .= 'data-id = "'.$value['id'].'" ';

            $cb .= 'class = "cb"/> ';
            $cb .= '</label>';

            if($value['is_approved'] == 0){
                $cb1 = $cb;
            }else{
                $cb1 = '';
            }

            $approved_label = '<badge class="badge badge-success bg-success text-white"> Yes </badge> ';
            if($value['is_approved'] == 0){
                $approved_label = '<badge class="badge badge-danger bg-danger text-white"> No </badge> ';
            }


            $result['data'][$key] = array(
                $value['operation_id'],
                $value['operation_name'],
                $value['description'],
                $value['criticality_name'],
                $value['machine_type_name'],
                $value['smv'],
                $value['rate'],
                $doc_link,
                $video_link,
                $value['remarks'],
                $value['value_id'],
                $approved_label,
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }

    public function fetchCategoryDataApprove()
    {
        if(!in_array('createMachineOperationDescApprove', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());

        $data = $this->model_machine_operation_desc->getMachineOperationDescDataApprove();

        foreach ($data as $key => $value) {

            // button
            $buttons = '';

            //$buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="viewFunc('.$value['unique_id'].')" data-toggle="modal" data-target="#viewModal"><i class="fas fa-eye text-info"></i></button>';

            if(in_array('updateMachineOperationDesc', $this->permission)) {
                $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal"><i class="text-primary fa fa-edit"></i></button>';
            }

            if(in_array('deleteMachineOperationDesc', $this->permission)) {
                $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="text-danger fa fa-trash"></i></button>';
            }

            $doc_link = '';
            if($value['documents'] != ''){
                $doc_link = '<a target="_blank" href="'.base_url().'uploads/'.$value['documents'].'"> File </a>';
            }

            $video_link = '';
            if($value['video'] != '') {
                $video_link = '<a target="_blank" href="' . base_url() . 'uploads/' . $value['video'] . '"> Video </a>';
            }

            $cb = '<label>';
            $cb .= '<input type="checkbox" ';
            $cb .= 'data-id = "'.$value['id'].'" ';

            $cb .= 'class = "cb"/> ';
            $cb .= '</label>';

            if($value['is_approved'] == 0){
                $cb1 = $cb;
            }else{
                $cb1 = '';
            }

            $approved_label = '<badge class="badge badge-success bg-success text-white"> Yes </badge> ';
            if($value['is_approved'] == 0){
                $approved_label = '<badge class="badge badge-danger bg-danger text-white"> No </badge> ';
            }


            $result['data'][$key] = array(
                $cb1,
                $value['operation_id'],
                $value['operation_name'],
                $value['description'],
                $value['criticality_name'],
                $value['machine_type_name'],
                $value['smv'],
                $value['rate'],
                $doc_link,
                $video_link,
                $value['remarks'],
                $value['value_id'],
                $approved_label
            );
        } // /foreach

        echo json_encode($result);
    }

    public function approve()
    {

        $selected_cb = $this->input->post('selected_cb');

        if (empty($selected_cb)) {
            $response['status'] = false;
            $response['msg'] = '<p class="text-danger"> Please select at least one record </p>';
            echo json_encode($response);
            die();
        }

        //$data_arr = array();
        foreach ($selected_cb as $cr) {

            $data =  array(
                'is_approved' => 1,
                'approved_by' => $this->session->userdata('id'),
                'approved_at' => date('Y-m-d H:i:s')
            );

            $this->db->where('id', $cr['id']);
            $this->db->update('machine_operation_desc', $data);

        }

        $response['status'] = true;
        $response['msg'] = 'Successfully Updated';

        echo json_encode($response);

    }

    public function create()
    {
        if(!in_array('createMachineOperationDesc', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $this->form_validation->set_rules('operationName', 'Operation Name ', 'trim|required');
        $this->form_validation->set_rules('criticality_id', 'Criticality ', 'trim|required');
        $this->form_validation->set_rules('machine_type_id', 'Machine Type ', 'trim|required');
        $this->form_validation->set_rules('smv', 'SMV ', 'trim|required');

        $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {

            $config['upload_path']="./uploads/";
            $config['allowed_types']='*';
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload',$config);

            $document = '';
            $video = '';
            if($this->upload->do_upload("documents")){
                $data = array('upload_data' => $this->upload->data());
                $document = $data['upload_data']['file_name'];
            }

            if($this->upload->do_upload("video")){
                $data = array('upload_data' => $this->upload->data());
                $video = $data['upload_data']['file_name'];
            }

            $mt_id = $this->input->post('machine_type_id');

            $machine_type_code = $this->db->query("SELECT * FROM machine_types WHERE id='$mt_id'")->row()->code;

            $last_row = $this->db->select('*')->order_by('id',"desc")->limit(1)->get('machine_operation_desc')->row();
            $no = $machine_type_code.'0001';
            $last_id = isset($last_row->operation_id)?$last_row->operation_id:$no;
            $id = ((int) substr($last_id, -4)) + 1;

            $number = str_pad($id, 4, "0", STR_PAD_LEFT);

            $new_op_id = $machine_type_code.$number;

            $data = array(
                'operation_id' => $new_op_id,
                'operation_name' => $this->input->post('operationName'),
                'description' => $this->input->post('description'),
                'criticality_id' => $this->input->post('criticality_id'),
                'machine_type_id' => $this->input->post('machine_type_id'),
                'smv' => $this->input->post('smv'),
                'rate' => $this->input->post('rate'),
                //'date_created' => $this->input->post('date_created'),
                'created_by' => $this->session->userdata('id'),
                //'approved_by' => $this->input->post('approved_by'),
                'documents' => $document,
                'video' => $video,
                'remarks' => $this->input->post('remarks'),
                'value_id' => $this->input->post('value_id'),
                'created_at' => date('Y-m-d H:i:s'),
            );

            $create = $this->model_machine_operation_desc->create($data);
            if($create == true) {
                $response['operation_id'] = $new_op_id;
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
        if(!in_array('createMachineOperationDesc', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $req_data = $this->input->post('req_data');

        //timestamp based batch id
        $unique_id = date("Ymds");

        $data = array();
        foreach ($req_data as $req){
            $data[] = array(
                'operation_id' => $req['operationId'],
                'operation_name' => $req['operationName'],
                'description' => $req['description'],
                'criticality_id' => $req['criticality_id'],
                'machine_type_id' => $req['machine_type_id'],
                'smv' => $req['smv'],
                'rate' => $req['rate'],
                'date_created' => $req['date_created'],
                'created_by' => $req['created_by'],
                'approved_by' => $req['approved_by'],
                'documents' => $req['documents'],
                'video' => $req['video'],
                'remarks' => $req['remarks'],
                'value_id' => $req['value'],
                'created_at' => date('Y-m-d H:i:s'),
                'unique_id' => $unique_id
            );
        }

        //insert batch
        $create = $this->db->insert_batch('machine_operation_desc', $data);

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

    function do_upload(){
        $config['upload_path']="./uploads/";
        $config['allowed_types']='*';
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload',$config);

        $data_upload_data = array('success'=>true);

        if($this->upload->do_upload("documents")){
            $data = array('upload_data' => $this->upload->data());
            $image= $data['upload_data']['file_name'];
            $data_upload_data['doc'] = array('success'=> true, 'file_name'=> $image);
        }else{
            $error = array('error' => $this->upload->display_errors());
            $data_upload_data['doc'] = array('success'=> false, 'file_name'=> '');
        }

        if($this->upload->do_upload("video")){
            $data = array('upload_data' => $this->upload->data());
            $image= $data['upload_data']['file_name'];
            $data_upload_data['video'] = array('success'=> true, 'file_name'=> $image);
        }else{
            $error = array('error' => $this->upload->display_errors());
            $data_upload_data['video'] = array('success'=> false, 'file_name'=> '');
        }

        echo json_encode($data_upload_data);

    }


    public function update($id)
    {
        if(!in_array('updateMachineOperationDesc', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        if($id) {
            $this->form_validation->set_rules('edit_operationId', 'Operation ID ', 'trim|required');
            $this->form_validation->set_rules('edit_operationName', 'Operation Name ', 'trim|required');
            $this->form_validation->set_rules('edit_criticality_id', 'Criticality ', 'trim|required');
            $this->form_validation->set_rules('edit_machine_type_id', 'Machine Type ', 'trim|required');
            $this->form_validation->set_rules('edit_smv', 'SMV ', 'trim|required');
            $this->form_validation->set_rules('edit_rate', 'Rate ', 'trim|required');
            //$this->form_validation->set_rules('edit_date_created', 'Date Created ', 'trim|required');
            //$this->form_validation->set_rules('edit_created_by', 'Created By', 'trim|required');
            $this->form_validation->set_rules('edit_value_id', 'Value', 'trim|required');

            $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

            if ($this->form_validation->run() == TRUE) {

                $data = array(
                    'operation_id' => $this->input->post('edit_operationId'),
                    'operation_name' => $this->input->post('edit_operationName'),
                    'description' => $this->input->post('edit_description'),
                    'criticality_id' => $this->input->post('edit_criticality_id'),
                    'machine_type_id' => $this->input->post('edit_machine_type_id'),
                    'smv' => $this->input->post('edit_smv'),
                    'rate' => $this->input->post('edit_rate'),
                    //'date_created' => $this->input->post('edit_date_created'),
                    //'created_by' => $this->input->post('edit_created_by'),
                    //'approved_by' => $this->input->post('edit_approved_by'),
                    'remarks' => $this->input->post('edit_remarks'),
                    'value_id' => $this->input->post('edit_value_id'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );

                $config['upload_path']="./uploads/";
                $config['allowed_types']='*';
                $config['encrypt_name'] = TRUE;
                $this->load->library('upload',$config);

                $document = '';
                $video = '';
                if($this->upload->do_upload("documents")){
                    $data = array('upload_data' => $this->upload->data());
                    $document = $data['upload_data']['file_name'];
                    $data['documents'] = $document;
                }

                if($this->upload->do_upload("video")){
                    $data = array('upload_data' => $this->upload->data());
                    $video = $data['upload_data']['file_name'];
                    $data['video'] = $video;
                }

                $update = $this->model_machine_operation_desc->update($id, $data);
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
        if(!in_array('deleteMachineOperationDesc', $this->permission)) {
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

            $delete = $this->model_machine_operation_desc->update($style_color_id, $data);

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

    public function fetchMachineOperationDescDataById($id = null)
    {
        if($id) {
            $data = $this->model_machine_operation_desc->getMachineOperationDescData($id);
            echo json_encode($data);
        }

    }

    public function get_products_select()
    {
        $term = $this->input->get('term');
        $page = $this->input->get('page');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $this->db->select('*');
        $this->db->from('products');
        $this->db->like('name', $term, 'both');
        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $sections = $query->result_array();

        $this->db->from('products');
        $this->db->like('name', $term, 'both');
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

    public function get_categories_select()
    {
        $term = $this->input->get('term');
        $page = $this->input->get('page');
        $product_id = $this->input->get('product_id');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $this->db->select('*');
        $this->db->from('product_categories');
        $this->db->like('name', $term, 'both');
        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $sections = $query->result_array();

        $this->db->from('product_categories');
        $this->db->like('name', $term, 'both');
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

    public function get_process_select()
    {
        $term = $this->input->get('term');
        $page = $this->input->get('page');
        $product_id = $this->input->get('product_id');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $this->db->select('*');
        $this->db->from('product_process');
        $this->db->like('name', $term, 'both');
        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $sections = $query->result_array();

        $this->db->from('product_process');
        $this->db->like('name', $term, 'both');
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

    public function get_component_select()
    {
        $term = $this->input->get('term');
        $page = $this->input->get('page');
        $product_id = $this->input->get('product_id');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $this->db->select('*');
        $this->db->from('product_component');
        $this->db->like('name', $term, 'both');
        if($product_id != ''){
            $this->db->like('product_id', $product_id);
        }
        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $sections = $query->result_array();

        $this->db->from('product_component');
        $this->db->like('name', $term, 'both');
        if($product_id != ''){
            $this->db->like('product_id', $product_id);
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

    public function get_operations_select()
    {
        $term = $this->input->get('term');
        $page = $this->input->get('page');
        $machine_type_id = $this->input->get('machine_type_id');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $this->db->select('*');
        $this->db->from('machine_operation_desc');
        $this->db->like('operation_name', $term, 'both');
        $this->db->where('is_deleted', '0');
        $this->db->where('is_approved', '1');
        //$this->db->where('machine_type_id', $machine_type_id);
        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $sections = $query->result_array();

        $this->db->from('machine_operation_desc');
        $this->db->like('operation_name', $term, 'both');
        $this->db->where('is_deleted', '0');
        $this->db->where('is_approved', '1');
       // $this->db->where('machine_type_id', $machine_type_id);
        $count = $this->db->count_all_results();

        $data = array();
        foreach ($sections as $v) {
            $data[] = array(
                'id' => $v['id'],
                'text' => $v['operation_name'],
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

    public function get_operations_by_machine_type_id($id = null)
    {
        if($id) {
            $data = $this->model_machine_operation_desc->getMachineOperationsDataByMachineTypeId($id);
            echo json_encode($data);
        }

    }





}