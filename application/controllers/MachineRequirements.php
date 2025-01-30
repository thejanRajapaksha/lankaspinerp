<?php

class MachineRequirements extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Machine Requirements';
        $this->load->model('model_machine_requirements');
        $this->load->model('model_machine_types');
        $this->load->model('model_machine_models');
        $this->load->model('model_rent_requests');
        $this->load->model('model_onloan_issue_machines');
        $this->load->model('model_factories');

    }

    public function index()
    {
        if(!in_array('viewMachineRequirement', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        //machine_types
        $this->data['machine_types'] = $this->model_machine_types->getActiveMachineType();
        //machine_models
        $this->data['machine_models'] = $this->model_machine_models->getActiveMachineModel();

        $this->data['js'] = 'application/views/MachineRequirement/MachineRequirement/index-js.php';
        $this->render_template('MachineRequirement/MachineRequirement/index', $this->data);
    }

    public function fetchCategoryData()
    {
        if(!in_array('viewMachineRequirement', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());

        $data = $this->model_machine_requirements->getMachineRequirementsData();

        foreach ($data as $key => $value) {

            // button
            $buttons = '';

            $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="viewFunc('.$value['unique_id'].')" data-toggle="modal" data-target="#viewModal"><i class="fas fa-eye text-info"></i></button>';

//            if(in_array('updateMachineRequirement', $this->permission)) {
//                $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="editFunc('.$value['unique_id'].')" data-toggle="modal" data-target="#editModal"><i class="text-primary fa fa-edit"></i></button>';
//            }
//
//            if(in_array('deleteMachineRequirement', $this->permission)) {
//                $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="removeFunc('.$value['unique_id'].')" data-toggle="modal" data-target="#removeModal"><i class="text-danger fa fa-trash"></i></button>';
//            }

            $result['data'][$key] = array(
                $value['forecast'],
                $value['factory_name'],
                $value['department_name'],
                $value['section_name'],
                $value['line_name'],
                $value['unique_id'],
                $value['request_date'],
                $value['total_requests'],
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }

    public function fetchMachineRequirementsByUniqueId()
    {
        if(!in_array('viewMachineRequirement', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $unique_id = $this->input->post('unique_id');

        $machine_requirements_row = $this->model_machine_requirements->getMachineRequirementsByUniqueId($unique_id);
        $machine_requirement = $this->model_machine_requirements->getMachineRequirementByUniqueId($unique_id);

        $machine_requirements = array();

        foreach ($machine_requirements_row as $item) {

            $this->db->select('*');
            $this->db->from('machine_ins');
            $this->db->where('is_deleted', 0);
            $this->db->where('machine_type_id', $item['machine_type_id']);
            $query = $this->db->get();
            $count_machine_ins = $query->num_rows();

            $sql = "
                SELECT SUM(mrrrm.quantity) as received_quantity
                FROM machine_rent_requests_receive_machines mrrrm 
                LEFT JOIN machine_rent_requests mrr ON mrr.id = mrrrm.rent_request_id
                LEFT JOIN machine_requests mr ON mr.id = mrr.machine_request_id
                WHERE mr.machine_type_id = ?
                AND mrrrm.is_deleted = 0
            ";
            $query = $this->db->query($sql, array($item['machine_type_id']));
            $data = $query->row_array();
            $received_quantity = $data['received_quantity'];

            $sql = "
                SELECT SUM(mrrrmr.quantity) as returned_quantity
                FROM machine_rent_requests_receive_machine_returns mrrrmr 
                LEFT JOIN machine_rent_requests_receive_machines mrrrm ON mrrrm.id = mrrrmr.rent_request_receive_id
                LEFT JOIN machine_rent_requests mrr ON mrr.id = mrrrm.rent_request_id
                LEFT JOIN machine_requests mr ON mr.id = mrr.machine_request_id
                WHERE mr.machine_type_id = ?
                AND mrrrm.is_deleted = 0
            ";
            $query = $this->db->query($sql, array($item['machine_type_id']));
            $data = $query->row_array();
            $returned_quantity = $data['returned_quantity'];

            $available_rented_quantity = $received_quantity - $returned_quantity;

            $sql = "
                SELECT COUNT(mroim.id) as returned_quantity
                FROM machine_request_onloan_issue_machines mroim   
                LEFT JOIN machine_requests mr ON mr.id = mroim.machine_request_id
                WHERE mr.machine_type_id = ?
                AND mroim.is_returned = 0
            ";
            $query = $this->db->query($sql, array($item['machine_type_id']));
            $data = $query->row_array();
            $on_loan_available_quantity = $data['returned_quantity'];

            $total_available_quantity = $count_machine_ins + $available_rented_quantity + $on_loan_available_quantity;

            $balance = $total_available_quantity - $item['quantity'];

            if($balance < 0){
            }else{
                $balance = '(+) '. $balance;
            }

            $data = array(
                'machine_type_name' => $item['machine_type_name'],
                'from_date' => $item['from_date'],
                'to_date' => $item['to_date'],
                'remarks' => $item['remarks'],
                'quantity' => $item['quantity'],
                'factory_available_machines' => $count_machine_ins,
                'available_rented_quantity' => $available_rented_quantity,
                'on_loan_available_quantity' => $on_loan_available_quantity,
                'balance' => $balance,
            );
            array_push($machine_requirements, $data);
        }

        $result = array('machine_requirement' => $machine_requirement, 'machine_requirements' => $machine_requirements);

        echo json_encode($result);
    }

    public function create()
    {
        if(!in_array('createMachineRequirement', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $this->form_validation->set_rules('machine_type_id', 'Machine Type ', 'trim|required');
        $this->form_validation->set_rules('from_date', 'From Date ', 'trim|required');
        $this->form_validation->set_rules('to_date', 'To Date ', 'trim|required');
        $this->form_validation->set_rules('quantity', 'Quantity ', 'trim|required');
        $this->form_validation->set_rules('remarks', 'Remarks ', 'trim|required');

        $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'machine_type_id' => $this->input->post('machine_type_id'),
                'from_date' => $this->input->post('from_date'),
                'to_date' => $this->input->post('to_date'),
                'quantity' => $this->input->post('quantity'),
                'remarks' => $this->input->post('remarks'),
                'created_by' => $this->session->userdata('id'),
                'created_at' => date('Y-m-d H:i:s')
            );

            $create = $this->model_machine_requirements->create($data);
            if($create == true) {
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
        if(!in_array('createMachineRequirement', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $req_data = $this->input->post('req_data');

        //timestamp based batch id
        $unique_id = date("Ymds");

        $data = array();
        foreach ($req_data as $req){
            $data[] = array(
                'forecast' => $req['forecast'],
                'line_id' => $req['line_id'],
                'machine_type_id' => $req['machine_type_id'],
                'from_date' => $req['from_date'],
                'to_date' => $req['to_date'],
                'quantity' => $req['quantity'],
                'remarks' => $req['remarks'],
                'created_by' => $this->session->userdata('id'),
                'created_at' => date('Y-m-d H:i:s'),
                'request_date' => date('Y-m-d'),
                'unique_id' => $unique_id
            );
        }

        //insert batch
        $create = $this->db->insert_batch('machine_requirements', $data);

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


    public function update($id)
    {
        if(!in_array('updateStyleColor', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        if($id) {
            $this->form_validation->set_rules('edit_color_name', 'Color Name', 'trim|required');
            $this->form_validation->set_rules('edit_color_code', 'Color Code', 'trim|required');
            $this->form_validation->set_rules('edit_style_id', 'Style', 'trim|required');

            $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'color_name' => $this->input->post('edit_color_name'),
                    'color_code' => $this->input->post('edit_color_code'),
                    'style_id' => $this->input->post('edit_style_id'),
                    'updated_by' => $this->session->userdata('id'),
                    'updated_at' => date('Y-m-d H:i:s')
                );

                $update = $this->model_style_colors->update($id, $data);
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
        if(!in_array('deleteStyleColor', $this->permission)) {
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

            $delete = $this->model_style_colors->update($style_color_id, $data);

            $style = $this->model_style_colors->getStyleColorsData($style_color_id);

            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully removed";
                $response['style_id'] = $style['style_id'];
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

    public function search()
    {
        if(!in_array('viewMachineRequirement', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        //operations_for_machines
        $sql = "SELECT * FROM operations_for_machines";
        $query = $this->db->query($sql);
        $this->data['operations'] = $query->result_array();

        $this->data['factories'] = $this->model_factories->getActiveFactories();

        $this->data['js'] = 'application/views/MachineRequirement/MachineRequirement/search-js.php';
        $this->render_template('MachineRequirement/MachineRequirement/search', $this->data);

    }

    public function get_forecast_select()
    {
        $term = $this->input->get('term');
        $page = $this->input->get('page');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $this->db->select('*');
        $this->db->from('machine_requirements');
        $this->db->like('forecast', $term, 'both');
        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $sections = $query->result_array();

        $this->db->from('machine_requirements');
        $this->db->like('forecast', $term, 'both');
        $count = $this->db->count_all_results();

        $data = array();
        foreach ($sections as $v) {
            $data[] = array(
                'id' => $v['id'],
                'text' => $v['forecast'],
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

    public function get_machine_requirements(){

        $rad = $this->input->post('rad');
        $factory = $this->input->post('factory');
        $line = $this->input->post('line');
        $id = $this->input->post('forecast');

        $sql = "
        SELECT mr.*,
                mr.line_id,
                l.line_name as line_name,
                l.id as line_id,
                s.name as section_name,
                d.name as department_name,
                f.br_name as factory_name,
                f.id as factory_id,
                mt.name as machine_type_name,
                SUM(mr.quantity) as machine_count_sum 
                FROM machine_requirements mr 
                LEFT JOIN mlinelist l ON l.id = mr.line_id
                LEFT JOIN sections s ON s.id = l.section
                LEFT JOIN departments d ON d.id = l.section
                LEFT JOIN mbranchlist f on d.factory_id = f.id
                LEFT JOIN machine_types mt on mr.machine_type_id = mt.id
                WHERE 1 = 1
              ";

        if($id != ''){
            $sql .= "AND mr.id = '$id' ";
        }

        if($factory != ''){
            $sql .= "AND f.id = '$factory' ";
        }

        if($line != ''){
            $sql .= "AND l.id = '$line' ";
        }

        if($rad == 'factory'){
            $sql .= 'GROUP BY mr.line_id, mr.machine_type_id   ';
        }

        if($rad == 'line'){
            $sql .= 'GROUP BY f.id, mr.machine_type_id';
        }

        $query = $this->db->query($sql);
        $data = $query->result_array();

        $detail_arr = array();

        foreach ($data as $d){

            $sql2 = " 
                SELECT *, mt.name as machine_type_name 
                FROM machine_allocation_current mac 
                LEFT JOIN machine_ins mi ON mi.id = mac.machine_in_id
                LEFT JOIN machine_types mt on mi.machine_type_id = mt.id  
                LEFT JOIN slots sl ON sl.id = mac.slot_id
                LEFT JOIN mlinelist l ON l.id = sl.line
                LEFT JOIN sections s ON s.id = l.section
                LEFT JOIN departments d ON d.id = l.section
                LEFT JOIN mbranchlist f on d.factory_id = f.id 
                WHERE 1 = 1                             
                AND mt.id = ? 
                AND f.id = ?   
                GROUP BY mi.id
                ORDER BY mi.id DESC";
            $query2 = $this->db->query($sql2, array($d['machine_type_id'], $d['factory_id']));
            $data2 = $query2->num_rows();

            $d_arr = array(
                'factory_name' => $d['factory_name'],
                'factory_id' => $d['factory_id'],
                'line_name' => $d['line_name'],
                'line_id' => $d['line_id'],
                'machine_type_name' => $d['machine_type_name'],
                'machine_type_id' => $d['machine_type_id'],
                'required_machines' => $d['machine_count_sum'],
                'total_machines' => $data2
            );
            array_push($detail_arr, $d_arr);

        }

        if(empty($detail_arr)){
            echo json_encode(array(['status' => false, 'message' => 'No Results Found' ]));
        }else{
            echo json_encode(array(['status' => true, 'data' => $detail_arr ]));
        }

    }

    public function get_machines_by_factory_id_machine_type_id($machine_type_id, $factory_id)
    {

        $sql2 = " 
                SELECT *, mt.name as machine_type_name,
                l.name as line_name,
                sl.name as slot_name,
                f.br_name as factory_name
                FROM machine_allocation_current mac 
                LEFT JOIN machine_ins mi ON mi.id = mac.machine_in_id
                LEFT JOIN machine_types mt on mi.machine_type_id = mt.id 
                LEFT JOIN slots sl ON sl.id = mac.slot_id
                LEFT JOIN `lines` l ON l.id = sl.line
                LEFT JOIN sections s ON s.id = l.section
                LEFT JOIN departments d ON d.id = l.section
                LEFT JOIN mbranchlist f on d.factory_id = f.id 
                WHERE 1 = 1                          
                AND mt.id = ? 
                AND f.id = ? 
                GROUP BY mi.id
                ORDER BY mi.id DESC ";
        $query2 = $this->db->query($sql2, array($machine_type_id, $factory_id));

        $data = $query2->result_array();

        echo json_encode($data);

    }

    public function get_machines_by_line_id_machine_type_id($machine_type_id, $line_id)
    {

        $sql2 = " 
                SELECT *, mt.name as machine_type_name,
                l.line_name as line_name,
                sl.name as slot_name,
                f.br_name as factory_name
                FROM machine_allocation_current mac 
                LEFT JOIN machine_ins mi ON mi.id = mac.machine_in_id
                LEFT JOIN machine_types mt on mi.machine_type_id = mt.id 
                LEFT JOIN slots sl ON sl.id = mac.slot_id
                LEFT JOIN mlinelist l ON l.id = sl.line
                LEFT JOIN sections s ON s.id = l.section
                LEFT JOIN departments d ON d.id = l.section
                LEFT JOIN mbranchlist f on d.factory_id = f.id 
                WHERE 1 = 1                          
                AND mt.id = ? 
                AND l.id = ? 
                GROUP BY mi.id
                ORDER BY mi.id DESC ";
        $query2 = $this->db->query($sql2, array($machine_type_id, $line_id));

        $data = $query2->result_array();

        echo json_encode($data);

    }

}