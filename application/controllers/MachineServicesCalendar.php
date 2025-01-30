<?php

class MachineServicesCalendar extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Machine Services Calendar';
        $this->load->model('model_machine_services_calendar');

    }

    public function index()
    {
        if(!in_array('viewMachineService', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        //sp for today jobs
        $date = date('Y-m-d');

        $sql = "
                SELECT sp.*, SUM(msei.qty) as total_rec
                FROM spare_parts sp
                LEFT JOIN machine_service_estimated_items msei on sp.id = msei.spare_part_id
                LEFT JOIN machine_services ms ON msei.machine_service_id = ms.id
                WHERE ms.service_date_from <= '$date' OR ms.service_date_to >= '$date'
                AND ms.is_deleted = 0
                GROUP BY msei.spare_part_id
        ";

        $query = $this->db->query($sql);
        $this->data['sp'] = $query->result_array();

        $this->data['js'] = 'application/views/MachineServices/MachineServicesCalendar/index-js.php';
        $this->render_template('MachineServices/MachineServicesCalendar/index', $this->data);
    }

    //getServiceEvents
    public function getServiceEvents()
    {
        $data = $this->model_machine_services_calendar->getServiceEvents();

        $result = array();
        foreach ($data as $value) {

            $color = '#00b7eb';

            if($value['is_postponed'] == 1){
                $color = '#ff6347';
            }

            if($value['service_date_from'] < date('Y-m-d') ){
                $color = '#ff0000';
            }

            if( ($value['service_date_from'] < date('Y-m-d')) && ($value['service_date_to'] > date('Y-m-d'))  ){
                $color = '#33ffbd';
            }

            if($value['service_date_from'] < date('Y-m-d') && $value['is_postponed'] == 1){
                $color = '#560319';
            }

            $this->db->select('*');
            $this->db->from('machine_service_details');
            $this->db->where('service_id ', $value['id']);
            $this->db->where('is_deleted ', 0);
            $query = $this->db->get();
            $service_detail = $query->row_array();

            if(!empty($service_detail)){
                $color = '#77dd77';
            }

            $result[] = array(
                'id' => $value['id'],
                'service_no' => $value['service_no'],
                'service_date_from' => $value['service_date_from'],
                'service_date_to' => $value['service_date_to'],
                'color' => $color,
            );
        }

        echo json_encode($result);
    }

    //getServiceRes
    public function getServiceRes()
    {
        $service_id = $this->input->post('service_id');
        $data = $this->model_machine_services_calendar->getServiceRes($service_id);

        $html = '';
        $html .= '<div class="table-responsive">';
        $html .= '<table class="table table-bordered table-sm">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th>Service No</th>';
        $html .= '<th>Machine Type</th>';
        $html .= '<th>Machine</th>';
        $html .= '<th>Service Date From</th>';
        $html .= '<th>Service Date To</th>';
        $html .= '<th>Estimated Service Hours</th>';
        $html .= '<th>Action</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';

            $html .= '<tr>';
            $html .= '<td>' . $data['service_no'] . '</td>';
            $html .= '<td>' . $data['machine_type_name'] . '</td>';
            $html .= '<td>' . $data['s_no'] . '</td>';
            $html .= '<td>' . $data['service_date_from'] . '</td>';
            $html .= '<td>' . $data['service_date_to'] . '</td>';
            $html .= '<td>' . $data['estimated_service_hours'] . '</td>';

//            $html .= '<td>';
//
//                $id = $data['id'];
//                $sql = "SELECT sp.*, msei.qty
//                            FROM machine_service_issued_items msei
//                            LEFT JOIN spare_parts sp ON sp.id = msei.spare_part_id
//                            WHERE msei.machine_service_id = '$id'
//                            ";
//                $query = $this->db->query($sql);
//                $sc = $query->result_array();
//
//                foreach ($sc as $s){
//                    $html .= ' <badge class="badge badge-default"> '.$s['name'].' <badge class="badge badge-info"> '.$s['qty'].' </badge> </badge>';
//                }
//
//            $html .= '</td>';

            $html .= '<td>';

            $this->db->select('*');
            $this->db->from('machine_service_details');
            $this->db->where('service_id =', $data['id']);
            $this->db->where('is_deleted =', 0);
            $query = $this->db->get();
            $service_detail = $query->row_array();

            if(empty($service_detail)){

                $html .= '<button type="button" style="margin:1px;" class="btn btn-success btn-sm" onclick="viewFunc(' . $data['id'] . ')" data-toggle="modal" data-target="#viewModal"><i class="fas fa-eye text-white"></i></button>';

                if(in_array('createMachineService', $this->permission)) {
                    $html .= '<button type="button" style="margin:1px;" class="btn btn-primary btn-sm btn_create" data-service_no="'.$data['service_no'].'" data-machine_type_name="'.$data['machine_type_name'].'" data-id="'.$data['id'].'" title="Create Service" > <i class="fa fa-wrench"></i> </button>';
                }

                if(in_array('createMachineServicePostpone', $this->permission)) {
                    $html .= '<button type="button" style="margin:1px;" class="btn btn-warning btn-sm btn_postpone" data-service_no="'.$data['service_no'].'" data-machine_type_name="'.$data['machine_type_name'].'" data-id="'.$data['id'].'" title="Postpone"> <i class="fa fa-stop-circle"></i> </button>';
                }

                if(in_array('deleteMachineService', $this->permission)) {
                    $html .= '<button type="button" style="margin:1px;" class="btn btn-danger btn-sm btn_delete" data-service_no="'.$data['service_no'].'" data-machine_type_name="'.$data['machine_type_name'].'" data-id="'.$data['id'].'" title="Delete"> <i class="fa fa-trash"></i> </button>';
                }

            }

            $html .= '</td>';
            $html .= '</tr>';

        $html .= '</tbody>';
        $html .= '</table>';
        $html .= '</div>';

        echo json_encode($html);
    }

    public function createService()
    {
        if(!in_array('createMachineService', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $data = array(
            'service_id' => $this->input->post('service_id'),
            'sub_total' => $this->input->post('sub_total'),
            'service_done_by' => $this->input->post('service_done_by'),
            'service_charge' => $this->input->post('service_charge'),
            'transport_charge' => $this->input->post('transport_charge'),
            'service_type' => $this->input->post('service_type'),
            'remarks' => $this->input->post('remarks'),
            'created_by' => $this->session->userdata('id'),
            'created_at' => date('Y-m-d H:i:s')
        );

        $create = $this->model_machine_services_calendar->create($data);
        //get last inserted id
        $service_details_id = $this->db->insert_id();

        $service_details = $this->input->post('service_details');
        foreach ($service_details as $value) {

            $service_item_name = $value['service_item_name'];
            $service_item_id = $value['service_item_id'];

            $data = array(
                'machine_service_details_id' => $service_details_id,
                'spare_part_id' => $service_item_id,
                'quantity' => $value['quantity'],
                'price' => $value['price'],
                'total' => $value['total'],
                'created_by' => $this->session->userdata('id'),
                'created_at' => date('Y-m-d H:i:s')
            );

            $this->model_machine_services_calendar->createServiceDetailItems($data);
        }

        if($create == true) {
            $response['success'] = true;
            $response['messages'] = 'Successfully created. The Page will be refreshed';
        }
        else {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while creating the information';
        }

        echo json_encode($response);
    }

    //postponeService
    public function postponeService()
    {
        if(!in_array('createMachineService', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();
        $service_id = $this->input->post('id');

        $service = $this->model_machine_services_calendar->getServiceRes($service_id);
        $original_date = $service['service_date'];

        $data = array(
            'service_date' => $this->input->post('service_date'),
            'postpone_reason' => $this->input->post('reason'),
            'is_postponed' => 1,
            'original_date' => $original_date,
            'updated_by' => $this->session->userdata('id'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        $postpone = $this->model_machine_services_calendar->update($service_id, $data);
        if($postpone == true) {
            $response['success'] = true;
            $response['messages'] = 'Successfully Postponed. The Page will be refreshed.';
        }
        else {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while creating the information';
        }
        echo json_encode($response);
    }

    //deleteService
    public function deleteService()
    {
        if(!in_array('createMachineService', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $data = array(
            'is_deleted' => 1,
            'deleted_by' => $this->session->userdata('id'),
            'deleted_at' => date('Y-m-d H:i:s')
        );

        $response = array();
        $service_id = $this->input->post('id');
        $delete = $this->model_machine_services_calendar->update($service_id, $data);
        if($delete == true) {
            $response['success'] = true;
            $response['messages'] = 'Successfully deleted. The page will be refreshed.';
        }
        else {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while creating the information';
        }
        echo json_encode($response);
    }

    //get_employees_select
    public function get_employees_select()
    {
        $term = $this->input->get('term');
        $page = $this->input->get('page');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $current_user = $this->session->userdata('id');

        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('id', $current_user);
        $query = $this->db->get();
        $result = $query->row_array();

        $user_factory = $result['factory_id'];

        $this->db->select('*');
        $this->db->from('employees');
        $this->db->where('factory_id', $user_factory);
        $this->db->like('name_with_initial', $term, 'both');
        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $departments = $query->result_array();

        $this->db->select('*');
        $this->db->from('employees');
        $this->db->where('factory_id', $user_factory);
        $this->db->like('name_with_initial', $term, 'both');
        $count = $this->db->count_all_results();

        $data = array();
        foreach ($departments as $v) {
            $data[] = array(
                'id' => $v['id'],
                'text' => $v['name_with_initial']
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

    public function get_sp_for_service_id_select()
    {
        $term = $this->input->get('term');
        $page = $this->input->get('page');
        $service_id = $this->input->get('service_id');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $this->db->select('spare_parts.*');
        $this->db->from('spare_parts');
        $this->db->join('machine_service_issued_items', 'machine_service_issued_items.spare_part_id = spare_parts.id', 'left');
        $this->db->like('spare_parts.name', $term, 'both');
        $this->db->where('machine_service_issued_items.machine_service_id', $service_id);
        $this->db->group_by('spare_parts.id');
        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $sections = $query->result_array();

        $this->db->select('spare_parts.*');
        $this->db->from('spare_parts');
        $this->db->join('machine_service_issued_items', 'machine_service_issued_items.spare_part_id = spare_parts.id', 'left');
        $this->db->like('spare_parts.name', $term, 'both');
        $this->db->where('machine_service_issued_items.machine_service_id', $service_id);
        $this->db->group_by('spare_parts.id');
        $count = $this->db->count_all_results();

        $data = array();
        foreach ($sections as $v) {
            $data[] = array(
                'id' => $v['id'],
                'text' => $v['name']. ' - ' . $v['part_no'],
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