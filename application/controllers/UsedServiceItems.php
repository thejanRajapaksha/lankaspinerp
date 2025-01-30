<?php

class UsedServiceItems extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Used Service Items';
        $this->load->model('model_used_service_items');

    }

    public function index()
    {
        if(!in_array('viewUsedServiceItems', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->data['js'] = 'application/views/MachineServices/UsedServiceItems/index-js.php';
        $this->render_template('MachineServices/UsedServiceItems/index', $this->data);
    }

    public function fetchCategoryData()
    {
        if(!in_array('viewUsedServiceItems', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $service_item_id = $this->input->get('service_item_id');
        $date_from = $this->input->get('date_from');
        $date_to = $this->input->get('date_to');

        $data = array(
            'service_item_id' => $service_item_id,
            'date_from' => $date_from,
            'date_to' => $date_to
        );

        $result = array('data' => array());

        $data = $this->model_used_service_items->getUsedServiceItemsData(null,$data);

        foreach ($data as $key => $value) {
            // button
            $buttons = '';

            //$buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="viewFunc('.$value['employee_id'].', \''.$date_from.'\', \''.$date_to.'\')" data-toggle="modal" data-target="#viewModal"><i class="fas fa-eye text-info"></i></button>';
            //viewFunc add employee_name too
            $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="viewFunc('.$value['id'].', \''.$date_from.'\', \''.$date_to.'\', \''.$value['name'].'\')" data-toggle="modal" data-target="#viewModal"><i class="fas fa-eye text-info"></i></button>';

            $result['data'][$key] = array(
                $value['name'],
                $value['item_count'],
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }



    public function fetchServiceDataById()
    {

        $id = $this->input->post('id');
        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');

        if($id) {
            $data = $this->model_used_service_items->getUsedServiceItemsDataById($id, $date_from, $date_to);
            echo json_encode($data);
        }

    }

    public function get_service_item_select()
    {
        $term = $this->input->get('term');
        $page = $this->input->get('page');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $this->db->select('service_items.name, service_items.id');
        $this->db->from('service_items');
        $this->db->join('machine_service_details_items', 'machine_service_details_items.service_item_id = service_items.id', 'left');
        $this->db->join('machine_service_details', 'machine_service_details.id = machine_service_details_items.machine_service_details_id', 'left');
        $this->db->where('machine_service_details_items.is_deleted', 0 );
        $this->db->like('service_items.name', $term, 'both');
        $this->db->group_by('service_items.id');
        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $departments = $query->result_array();

        $this->db->select('service_items.name, service_items.id');
        $this->db->from('service_items');
        $this->db->join('machine_service_details_items', 'machine_service_details_items.service_item_id = service_items.id', 'left');
        $this->db->join('machine_service_details', 'machine_service_details.id = machine_service_details_items.machine_service_details_id', 'left');
        $this->db->where('machine_service_details_items.is_deleted', 0 );
        $this->db->like('service_items.name', $term, 'both');
        $this->db->group_by('service_items.id');
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