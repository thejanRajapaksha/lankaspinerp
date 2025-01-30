<?php

class MachineOperationProduct extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Product Templates';
        $this->load->model('model_machine_operation_product');
        $this->load->model('model_machine_types');
        $this->load->model('model_machine_models');
        $this->load->model('model_rent_requests');
        $this->load->model('model_onloan_issue_machines');
        $this->load->model('model_factories');

    }

    public function index()
    {
        if(!in_array('viewMachineOperationProduct', $this->permission)) {
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

        //machine_models
        $this->data['machine_models'] = $this->model_machine_models->getActiveMachineModel();

        $this->data['js'] = 'application/views/MachineOperationDesc/MachineOperationProduct/index-js.php';
        $this->render_template('MachineOperationDesc/MachineOperationProduct/index', $this->data);
    }

    public function approve_front()
    {
        if(!in_array('createMachineOperationProductApprove', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->data['js'] = 'application/views/MachineOperationDesc/MachineOperationProduct/approve-js.php';
        $this->render_template('MachineOperationDesc/MachineOperationProduct/approve', $this->data);
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
            $this->db->update('machine_operation_product', $data);

        }

        $response['status'] = true;
        $response['msg'] = 'Successfully Updated';

        echo json_encode($response);

    }

    public function fetchCategoryData()
    {
        if(!in_array('viewMachineOperationProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());

        $data = $this->model_machine_operation_product->getMachineOperationProductData();

        foreach ($data as $key => $value) {

            // button
            $buttons = '';

            $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="viewFunc('.$value['id'].')" data-toggle="modal" data-target="#viewModal"><i class="fas fa-eye text-info"></i></button>';

            if(in_array('updateMachineOperationProduct', $this->permission)) {
                $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal"><i class="text-primary fa fa-edit"></i></button>';
            }

            if(in_array('deleteMachineOperationProduct', $this->permission)) {
                $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="text-danger fa fa-trash"></i></button>';
            }

            $id = $value['id'];

            $sql = "SELECT sc.name FROM style_component sc
                    LEFT JOIN machine_operation_product_components mopo ON mopo.component_id = sc.id 
                    WHERE mop_id = '$id'
                    GROUP BY sc.id
                    ";
            $query = $this->db->query($sql);
            $sc = $query->result_array();

            $sc_label = '';
            foreach ($sc as $s){
                $sc_label .= ' <badge class="badge badge-info"> '.$s['name'].' </badge>';
            }

            $approved_label = '<badge class="badge badge-success bg-success text-white"> Yes </badge> ';
            if($value['is_approved'] == 0){
                $approved_label = '<badge class="badge badge-danger bg-danger text-white"> No </badge> ';
            }

            $result['data'][$key] = array(
                $value['product_name'],
                $value['category_name'],
                $value['process_name'],
                $sc_label,
                $value['total_smv'],
                $approved_label,
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }

    public function fetchCategoryDataApprove()
    {
        if(!in_array('createMachineOperationProductApprove', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());

        $data = $this->model_machine_operation_product->getMachineOperationProductDataApprove();

        foreach ($data as $key => $value) {

            // button
            $buttons = '';

            $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="viewFunc('.$value['id'].')" data-toggle="modal" data-target="#viewModal"><i class="fas fa-eye text-info"></i></button>';

            if(in_array('updateMachineOperationProduct', $this->permission)) {
                $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal"><i class="text-primary fa fa-edit"></i></button>';
            }

            if(in_array('deleteMachineOperationProduct', $this->permission)) {
                $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="text-danger fa fa-trash"></i></button>';
            }

            $id = $value['id'];

            $sql = "SELECT sc.name FROM style_component sc
                    LEFT JOIN machine_operation_product_components mopo ON mopo.component_id = sc.id 
                    WHERE mop_id = '$id'
                    GROUP BY sc.id
                    ";
            $query = $this->db->query($sql);
            $sc = $query->result_array();

            $sc_label = '';
            foreach ($sc as $s){
                $sc_label .= ' <badge class="badge badge-info"> '.$s['name'].' </badge>';
            }

            $approved_label = '<badge class="badge badge-success bg-success text-white"> Yes </badge> ';
            if($value['is_approved'] == 0){
                $approved_label = '<badge class="badge badge-danger bg-danger text-white"> No </badge> ';
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

            $result['data'][$key] = array(
                $cb1,
                $value['product_name'],
                $value['category_name'],
                $value['process_name'],
                $sc_label,
                $value['total_smv'],
                $approved_label,
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }

    public function create()
    {
        if(!in_array('createMachineOperationProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $this->form_validation->set_rules('product_id', 'product ', 'trim|required');
        $this->form_validation->set_rules('category_id', 'Category ', 'trim|required');
        $this->form_validation->set_rules('process_id', 'Process ', 'trim|required');

        $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {

            $sequence = $this->input->post('sequence[]');
            $component_id = $this->input->post('component_id[]');

            if(empty($component_id)){
                $response['success'] = false;
                $response['component_id'] = 'One or more Component Required!';
                echo json_encode($response);
                die();
            }

            $data = array(
                'product_id' => $this->input->post('product_id'),
                'category_id' => $this->input->post('category_id'),
                'process_id' => $this->input->post('process_id'),
                'created_by' => $this->session->userdata('id'),
                'created_at' => date('Y-m-d H:i:s'),
            );

            $this->db->trans_start();

                $create = $this->model_machine_operation_product->create($data);
                if($create == true) {

                    $insert_id = $this->db->insert_id();

                    for($i = 0; $i < sizeof($component_id); $i++  ){
                        $sub_data = array(
                            'sequence' => $sequence[$i],
                            'component_id' => $component_id[$i],
                            'mop_id' => $insert_id
                        );
                        $create = $this->model_machine_operation_product->create_mop_operations($sub_data);
                    }

                    $response['success'] = true;
                    $response['messages'] = 'Successfully created';
                }
                else {
                    $response['success'] = false;
                    $response['messages'] = 'Error in the database while creating the information';
                }

            $this->db->trans_complete();
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
        if(!in_array('createMachineOperationProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $req_data = $this->input->post('req_data');

        //timestamp based batch id
        $unique_id = date("Ymds");

        $data = array();
        foreach ($req_data as $req){
            $data[] = array(
                'product_id' => $req['product_id'],
                'category_id' => $req['category_id'],
                'process_id' => $req['process_id'],
                'component_id' => $req['component_id'],
                'operation_id' => $req['operation_id'],
                'sequence' => $req['sequence'],
                'smv' => $req['smv'],
                'assigned_by_id' => $req['assigned_by_id'],
                'assigned_date' => $req['assigned_date'],
                'created_at' => date('Y-m-d H:i:s'),
                'unique_id' => $unique_id,
                'created_by' => $this->session->userdata('id')
            );
        }

        //insert batch
        $create = $this->db->insert_batch('machine_operation_product', $data);

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
        if(!in_array('updateMachineOperationProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        if($id) {
            $this->form_validation->set_rules('edit_product_id', 'Product', 'trim|required');
            $this->form_validation->set_rules('edit_category_id', 'Category ', 'trim|required');
            $this->form_validation->set_rules('edit_process_id', 'Process ', 'trim|required');

            $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

            if ($this->form_validation->run() == TRUE) {

                $sequence = $this->input->post('sequence[]');
                $component_id = $this->input->post('component_id[]');

                if(empty($component_id)){
                    $response['success'] = false;
                    $response['edit_component_id'] = 'One or more Components Required!';
                    echo json_encode($response);
                    die();
                }

                $data = array(
                    'product_id' => $this->input->post('edit_product_id'),
                    'category_id' => $this->input->post('edit_category_id'),
                    'process_id' => $this->input->post('edit_process_id'),
                    'updated_at' => date('Y-m-d H:i:s')
                );

                $update = $this->model_machine_operation_product->update($id, $data);
                if($update == true) {

                    $this->db->where('mop_id', $id);
                    $delete = $this->db->delete('machine_operation_product_components');

                    for($i = 0; $i < sizeof($component_id); $i++  ){
                        $sub_data = array(
                            'sequence' => $sequence[$i],
                            'component_id' => $component_id[$i],
                            'mop_id' => $id
                        );
                        $create = $this->model_machine_operation_product->create_mop_operations($sub_data);
                    }

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
        if(!in_array('deleteMachineOperationProduct', $this->permission)) {
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

            $delete = $this->model_machine_operation_product->update($style_color_id, $data);

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

    public function fetchMachineOperationProductDataById($id = null)
    {
        if($id) {
            $data['main_data'] = $this->model_machine_operation_product->getMachineOperationProductData($id);

            $sql = "SELECT mopc.component_id, sc.name as component_name ,mopc.sequence 
                    FROM machine_operation_product_components mopc
                    LEFT JOIN machine_operation_product mop ON mop.id = mopc.mop_id
                    LEFT JOIN style_component sc on sc.id = mopc.component_id 
                    WHERE mop_id = '$id'
                    AND mop.is_deleted = 0
                    ORDER BY mopc.sequence
                    ";
            $query = $this->db->query($sql);
            $data['op'] = $query->result_array();

            $sql = "SELECT mod1.*, mt.name as machine_type_name 
                FROM machine_operation_product_components AS mopc 
                LEFT JOIN machine_operation_product mop ON mop.id = mopc.mop_id
                LEFT JOIN style_component sc on sc.id = mopc.component_id 
                LEFT JOIN style_component_operations AS sco ON sco.component_id = sc.id
                LEFT JOIN machine_operation_desc mod1 ON mod1.id = sco.operation_id
                LEFT JOIN machine_types mt on mod1.machine_type_id = mt.id
                WHERE mop.id = ? ";
            $query = $this->db->query($sql, array($id));
            $data['ops'] = $query->result_array();

            echo json_encode($data);
        }
    }

    public function fetchMachineOperationProductDataByProductId($id = null)
    {
        if($id) {
            $data['main_data'] = $this->model_machine_operation_product->getMachineOperationProductDataByProductId($id);
            echo json_encode($data);
        }
    }

    public function get_product_select()
    {
        $term = $this->input->get('term');
        $page = $this->input->get('page');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $this->db->select('products.*');
        $this->db->from('machine_operation_product');
        $this->db->join('products', 'products.id = machine_operation_product.product_id', 'left');
        $this->db->like('products.name', $term, 'both');
        $this->db->group_by('products.id');
        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $sections = $query->result_array();

        $this->db->select('products.*');
        $this->db->from('machine_operation_product');
        $this->db->join('products', 'products.id = machine_operation_product.product_id', 'left');
        $this->db->like('products.name', $term, 'both');
        $this->db->group_by('products.id');
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

    public function fetchProductOperationsByMopId()
    {
        if(!in_array('viewMachineOperationProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $mop_id = $this->input->post('mop_id');

        $sql = "SELECT mopc.sequence , mod1.*, mt.name as machine_type_name, c.name as criticality_name, sc.name as component_name, sc.id as component_id 
                    FROM machine_operation_product_components mopc
                    LEFT JOIN style_component sc ON sc.id = mopc.component_id 
                    LEFT JOIN style_component_operations sco ON sco.component_id = sc.id
                    LEFT JOIN machine_operation_desc mod1 ON mod1.id = sco.operation_id  
                    LEFT JOIN machine_types mt ON mod1.machine_type_id = mt.id 
                    LEFT JOIN criticalities c ON c.id = mod1.criticality_id 
                    WHERE mop_id = '$mop_id'
                    AND mod1.is_deleted = 0
                    ORDER BY sequence
                    ";
        $query = $this->db->query($sql);
        $data['op'] = $query->result_array();

        $data['main_data'] = $this->model_machine_operation_product->getMachineOperationProductData($mop_id);

        echo json_encode($data);
    }

    public function fetchMachineOperationDescDataByProductId($id = null)
    {
        if($id) {
            $data = $this->model_machine_operation_product->getMachineOperationProductDataByProductIdRow($id);
            echo json_encode($data);
        }

    }
















    public function search()
    {
        if(!in_array('viewMachineOperationProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $this->data['js'] = 'application/views/MachineOperationDesc/MachineOperationProduct/search-js.php';
        $this->render_template('MachineOperationDesc/MachineOperationProduct/search', $this->data);

    }

    //todo
    public function get_search_dt(){

        $rad = $this->input->post('rad');
        $operation = $this->input->post('operation');
        $product = $this->input->post('product');
        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');

        if($rad == 'operation'){
            $sql = "
                    SELECT mod1.*, 
                            COUNT(mop.id) as products_count  
                            FROM machine_operation_product mop 
                            LEFT JOIN machine_operation_desc mod1 ON mod1.id = mop.operation_id
                            LEFT JOIN products p ON p.id = mop.product_id
                            LEFT JOIN product_categories pc ON pc.id = mop.category_id
                            LEFT JOIN product_process pp on pp.id = mop.process_id
                            LEFT JOIN product_component pco on pco.id = mop.component_id
                            WHERE 1 = 1
                            AND mod1.is_deleted = 0 
                            AND mop.is_deleted = 0
                          ";

            if($product != ''){
                $sql .= "AND p.id = '$product' ";
            }

            if($operation != ''){
                $sql .= "AND mod1.id = '$operation' ";
            }

            if ($date_from != '' && $date_to != '') {
                $sql .= 'AND mop.created_at BETWEEN "' . $date_from . '" AND "' . $date_to . '" ';
            }

            $sql .= 'GROUP BY mod1.id ';

            $query = $this->db->query($sql);
            $data = $query->result_array();

            $detail_arr = array();

            foreach ($data as $d){

                $d_arr = array(
                    'operation_name' => $d['operation_name'],
                    'products_count' => $d['products_count'],
                    'operation_id' => $d['id'],

                );
                array_push($detail_arr, $d_arr);

            }

            if(empty($detail_arr)){
                echo json_encode(array(['status' => false, 'message' => 'No Results Found' ]));
            }else{
                echo json_encode(array(['status' => true, 'data' => $detail_arr ]));
            }


        }else{

            $sql = "
                    SELECT mop.*, 
                            p.name as product_name,
                            COUNT(mod1.id) as operation_count  
                            FROM machine_operation_product mop 
                            LEFT JOIN machine_operation_desc mod1 ON mod1.id = mop.operation_id
                            LEFT JOIN products p ON p.id = mop.product_id
                            LEFT JOIN product_categories pc ON pc.id = mop.category_id
                            LEFT JOIN product_process pp on pp.id = mop.process_id
                            LEFT JOIN product_component pco on pco.id = mop.component_id
                            WHERE 1 = 1
                            AND mod1.is_deleted = 0 
                            AND mop.is_deleted = 0
                          ";

            if($product != ''){
                $sql .= "AND p.id = '$product' ";
            }

            if($operation != ''){
                $sql .= "AND mod1.id = '$operation' ";
            }

            if ($date_from != '' && $date_to != '') {
                $sql .= 'AND mop.created_at BETWEEN "' . $date_from . '" AND "' . $date_to . '" ';
            }

            $sql .= 'GROUP BY p.id ';

            $query = $this->db->query($sql);
            $data = $query->result_array();

            $detail_arr = array();

            foreach ($data as $d){

                $d_arr = array(
                    'product_name' => $d['product_name'],
                    'operations_count' => $d['operation_count'],
                    'product_id' => $d['product_id']
                );
                array_push($detail_arr, $d_arr);

            }

            if(empty($detail_arr)){
                echo json_encode(array(['status' => false, 'message' => 'No Results Found' ]));
            }else{
                echo json_encode(array(['status' => true, 'data' => $detail_arr ]));
            }

        }

    }

    public function get_operation_products_by_operation_id()
    {
        $operation_id = $this->input->post('operation_id');
        $operation = $this->input->post('operation');
        $product = $this->input->post('product');
        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');

        $sql = "SELECT mop.*, 
                 p.name as product_name,
                pc.name as category_name,
                pp.name as process_name,
                pc1.name as component_name,
                mod1.operation_name,
                u2.name_with_initial as assigned_by_name
            FROM machine_operation_product mop  
            LEFT JOIN products p ON mop.product_id = p.id 
            LEFT JOIN product_categories pc ON pc.id = mop.category_id
            LEFT JOIN product_process pp ON pp.id = mop.process_id
            LEFT JOIN product_component pc1 ON pc1.id = mop.component_id
            LEFT JOIN machine_operation_desc mod1 ON mod1.id = mop.operation_id
            LEFT JOIN employees u2 ON u2.id = mop.assigned_by_id  
            WHERE 1 = 1
            ";

        if($operation_id != ''){
            $sql .= "AND mod1.id = '$operation_id' ";
        }

        if($product != ''){
            $sql .= "AND p.id = '$product' ";
        }

        if ($date_from != '' && $date_to != '') {
            $sql .= 'AND mop.created_at BETWEEN "' . $date_from . '" AND "' . $date_to . '" ';
        }

        $sql .= 'AND mop.is_deleted = 0
            ORDER BY mop.id DESC';

        $query2 = $this->db->query($sql);

        $data = $query2->result_array();

        echo json_encode($data);

    }

    public function get_product_operations_by_operation_id()
    {
        $product_id = $this->input->post('product_id');
        $operation = $this->input->post('operation');
        $product = $this->input->post('product');
        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');

        $sql = "SELECT mod1.*, 
                 mt.name as machine_type_name,
                c.name as criticality_name,
                u1.name_with_initial as created_by_name,
                u2.name_with_initial as approved_by_name,
                mv.name as value_name
            FROM machine_operation_desc mod1 
            LEFT JOIN machine_operation_product mop ON mop.operation_id = mod1.id 
            LEFT JOIN products p ON mop.product_id = p.id 
            LEFT JOIN machine_types mt ON mod1.machine_type_id = mt.id 
            LEFT JOIN criticalities c ON c.id = mod1.criticality_id
            LEFT JOIN employees u1 ON u1.id = mod1.created_by
            LEFT JOIN employees u2 ON u2.id = mod1.approved_by 
            LEFT JOIN mod_values mv ON mv.id = mod1.value_id
            WHERE 1 = 1
            ";

        if($product_id != ''){
            $sql .= "AND p.id = '$product_id' ";
        }

        if ($date_from != '' && $date_to != '') {
            $sql .= 'AND mop.created_at BETWEEN "' . $date_from . '" AND "' . $date_to . '" ';
        }

        $sql .= 'AND mop.is_deleted = 0
            ORDER BY mop.id DESC';

        $query2 = $this->db->query($sql);

        $data = $query2->result_array();

        $f_data = array();

        foreach ($data as $key => $value) {

            // button
            $buttons = '';

            $doc_link = '';
            if($value['documents'] != ''){
                $doc_link = '<a target="_blank" href="'.base_url().'uploads/'.$value['documents'].'"> File </a>';
            }

            $video_link = '';
            if($value['video'] != '') {
                $video_link = '<a target="_blank" href="' . base_url() . 'uploads/' . $value['video'] . '"> Video </a>';
            }

            $approved_label = '<badge class="badge badge-success bg-success text-white"> Yes </badge> ';
            if($value['is_approved'] == 0){
                $approved_label = '<badge class="badge badge-danger bg-danger text-white"> No </badge> ';
            }

//            $data_a = array(
//                'operation_id' => $value['operation_id'],
//                'operation_id' => $value['operation_id']
//            )




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
                $value['value_name'],
                $approved_label,
                $buttons
            );
        } // /foreach

        echo json_encode($result);

    }





}