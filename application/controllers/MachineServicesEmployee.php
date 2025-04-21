<?php

class MachineServicesEmployee extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Machine Services Employee';
        $this->load->model('model_machine_services_employee');

    }

    public function index()
    {
        if(!in_array('viewEmployeeServices', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->data['js'] = 'application/views/MachineServices/EmployeeServices/index-js.php';
        $this->render_template('MachineServices/EmployeeServices/index', $this->data);
    }

    public function fetchCategoryData()
    {
        if(!in_array('viewEmployeeServices', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $employee_id = $this->input->get('employee_id');
        $date_from = $this->input->get('date_from');
        $date_to = $this->input->get('date_to');

        $data = array(
            'employee_id' => $employee_id,
            'date_from' => $date_from,
            'date_to' => $date_to
        );

        $result = array('data' => array());

        $data = $this->model_machine_services_employee->getEmployeeServicesData(null,$data);

        foreach ($data as $key => $value) {
            // button
            $buttons = '';

            //$buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="viewFunc('.$value['employee_id'].', \''.$date_from.'\', \''.$date_to.'\')" data-toggle="modal" data-target="#viewModal"><i class="fas fa-eye text-info"></i></button>';
            //viewFunc add employee_name too
            $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="viewFunc('.$value['employee_id'].', \''.$date_from.'\', \''.$date_to.'\', \''.$value['employee_name'].'\')" data-toggle="modal" data-target="#viewModal"><i class="fas fa-eye text-info"></i></button>';

            $result['data'][$key] = array(
                $value['employee_name'],
                $value['service_count'],
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
            $data = $this->model_machine_services_employee->getEmployeeServicesDataById($id, $date_from, $date_to);
            echo json_encode($data);
        }

    }

    public function get_employees_select()
    {
        $term = $this->input->get('term');
        $page = $this->input->get('page');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $this->db->select('employees.emp_name_with_initial, employees.id');
        $this->db->from('employees');
        $this->db->join('machine_service_details', 'employees.id = machine_service_details.service_done_by', 'left');
        $this->db->where('machine_service_details.is_deleted', 0 );
        $this->db->like('employees.emp_name_with_initial', $term, 'both');
        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $departments = $query->result_array();

        $this->db->select('employees.emp_name_with_initial, employees.id');
        $this->db->from('employees');
        $this->db->join('machine_service_details', 'employees.id = machine_service_details.service_done_by', 'left');
        $this->db->where('machine_service_details.is_deleted', 0 );
        $this->db->like('employees.emp_name_with_initial', $term, 'both');
        $count = $this->db->count_all_results();

        $data = array();
        foreach ($departments as $v) {
            $data[] = array(
                'id' => $v['id'],
                'text' => $v['name_with_initial'],
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