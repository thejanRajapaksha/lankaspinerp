<?php

class MachineServices extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Machine Services';
        $this->load->model('model_machine_services');
        $this->load->model('model_spare_parts');

    }

    public function index()
    {
        if (!in_array('viewMachineService', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $this->data['js'] = 'application/views/MachineServices/MachineServices/index-js.php';
        $this->render_template('MachineServices/MachineServices/index', $this->data);
    }

    public function fetchCategoryData()
    {
        if (!in_array('viewMachineService', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());

        $data = $this->model_machine_services->getMachineServicesData();

        foreach ($data as $key => $value) {
            // button
            $buttons = '';

            $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="viewFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#viewModal"><i class="fas fa-eye text-info"></i></button>';

            if (in_array('updateMachineService', $this->permission)) {
                $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="editFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#editModal"><i class="text-primary fa fa-edit"></i></button>';
            }

            if (in_array('deleteMachineService', $this->permission)) {
                $buttons .= ' <button type="button" class="btn btn-default btn-sm" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal"><i class="text-danger fa fa-trash"></i></button>';
            }

            //$status = ($value['active'] == 1) ? '<span class="badge badge-success btn-sm">Active</span>' : '<span class="badge badge-warning">Inactive</span>';

            $id = $value['id'];

            $sql = "SELECT sp.name, msei.qty
                    FROM machine_service_estimated_items msei 
                    LEFT JOIN spare_parts sp ON sp.id = msei.spare_part_id 
                    WHERE msei.machine_service_id = '$id' 
                    ";
            $query = $this->db->query($sql);
            $sc = $query->result_array();

            $sc_label = '';
            foreach ($sc as $s) {
                $sc_label .= ' <badge class="badge badge-default"> ' . $s['name'] . ' <badge class="badge badge-success"> ' . $s['qty'] . ' </badge> </badge>';
            }

            $type = $value['is_repair'] == 0 ? 'Service':'Repair';

            $result['data'][$key] = array(
                $value['service_no'],
                $type,
                $value['machine_type_name'],
                $value['s_no'],
                $value['service_date_from'],
                $value['service_date_to'],
                $value['estimated_service_hours'],
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }

    public function create()
    {
        if (!in_array('createMachineService', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $this->form_validation->set_rules('service_no', 'Service No', 'trim|required');
        $this->form_validation->set_rules('machine_in_id', 'Machine', 'trim|required');
        $this->form_validation->set_rules('employee_id', 'Employee', 'trim|required');
        $this->form_validation->set_rules('service_date_from', 'Service Date', 'trim|required');
        $this->form_validation->set_rules('service_date_to', 'Service Date', 'trim|required');

        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run() == TRUE) {

            $estimated_service_items = $this->input->post('sp_id[]');
            $qty = $this->input->post('qty[]');

            if ($estimated_service_items == null) {
                $response['success'] = false;
                $response['messages']['estimated_service_items'] = '<p class="text-danger"> Please select at least one Item </p>';
                echo json_encode($response);
                die();
            }

            $this->db->trans_start();

            $data = array(
                'service_no' => $this->input->post('service_no'),
                'machine_in_id' => $this->input->post('machine_in_id'),
                'employee_id' => $this->input->post('employee_id'),
                'service_date_from' => $this->input->post('service_date_from'),
                'service_date_to' => $this->input->post('service_date_to'),
                'estimated_service_hours' => $this->input->post('estimated_service_hours'),
                'is_repair' => $this->input->post('is_repair'),
                'created_by' => $this->session->userdata('id'),
                'created_at' => date('Y-m-d H:i:s')
            );

            $create = $this->model_machine_services->create($data);

            $sp_id = $this->db->insert_id();

            $data = array();
            for ($i = 0; $i < count($estimated_service_items); $i++) {

                $data[] = array(
                    'machine_service_id' => $sp_id,
                    'spare_part_id' => $estimated_service_items[$i],
                    'qty' => $qty[$i],
                );
            }

            $sps_create = $this->db->insert_batch('machine_service_estimated_items', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() == true) {
                $response['success'] = true;
                $response['messages'] = 'Successfully created';
            } else {
                $response['success'] = false;
                $response['messages'] = 'Error in the database while creating the operation';
            }
        } else {
            $response['success'] = false;
            foreach ($_POST as $key => $value) {
                $response['messages'][$key] = form_error($key);
            }
        }

        echo json_encode($response);
    }

    public function update($id)
    {
        if (!in_array('updateMachineService', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        if ($id) {
            $this->form_validation->set_rules('edit_service_no', 'Service No', 'trim|required');
            $this->form_validation->set_rules('edit_machine_in_id', 'Machine', 'trim|required');
            $this->form_validation->set_rules('edit_employee_id', 'Employee', 'trim|required');
            $this->form_validation->set_rules('edit_service_date_from', 'Service Date From', 'trim|required');
            $this->form_validation->set_rules('edit_service_date_to', 'Service Date To', 'trim|required');

            $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

            if ($this->form_validation->run() == TRUE) {

                $estimated_service_items = $this->input->post('sp_id[]');
                $qty = $this->input->post('qty[]');

                if ($estimated_service_items == null) {
                    $response['success'] = false;
                    $response['messages']['edit_estimated_service_items'] = '<p class="text-danger"> Please select at least one Item </p>';
                    echo json_encode($response);
                    die();
                }

                $data = array(
                    'service_no' => $this->input->post('edit_service_no'),
                    'machine_in_id' => $this->input->post('edit_machine_in_id'),
                    'employee_id' => $this->input->post('edit_employee_id'),
                    'service_date_from' => $this->input->post('edit_service_date_from'),
                    'service_date_to' => $this->input->post('edit_service_date_to'),
                    'estimated_service_hours' => $this->input->post('edit_estimated_service_hours'),
                    'is_repair' => $this->input->post('is_repair'),
                    'updated_by' => $this->session->userdata('id'),
                    'updated_at' => date('Y-m-d H:i:s')
                );

                $update = $this->model_machine_services->update($id, $data);
                if ($update == true) {

                    $this->db->where('machine_service_id', $id);
                    $delete = $this->db->delete('machine_service_estimated_items');

                    $sub_data = array();
                    for ($i = 0; $i < sizeof($estimated_service_items); $i++) {
                        $sub_data[] = array(
                            'spare_part_id' => $estimated_service_items[$i],
                            'machine_service_id' => $id,
                            'qty' => $qty[$i],
                        );
                    }
                    $sps_create = $this->db->insert_batch('machine_service_estimated_items', $sub_data);

                    $response['success'] = true;
                    $response['messages'] = 'Successfully updated';
                } else {
                    $response['success'] = false;
                    $response['messages'] = 'Error in the database while updated the information';
                }

            } else {
                $response['success'] = false;
                foreach ($_POST as $key => $value) {
                    $response['messages'][$key] = form_error($key);
                }
            }
        } else {
            $response['success'] = false;
            $response['messages'] = 'Error please refresh the page again!!';
        }

        echo json_encode($response);
    }

    public function remove()
    {
        if (!in_array('deleteMachineService', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $machine_service_id = $this->input->post('machine_service_id');

        $response = array();
        if ($machine_service_id) {
            // $delete = $this->model_machine_ins->remove($machine_in_id);
            $data = array(
                'is_deleted' => 1,
                'deleted_by' => $this->session->userdata('id'),
                'deleted_at' => date('Y-m-d H:i:s')
            );

            $delete = $this->model_machine_services->update($machine_service_id, $data);

            if ($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully removed";
            } else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the information";
            }

        } else {
            $response['success'] = false;
            $response['messages'] = "Refresh the page again!!";
        }

        echo json_encode($response);
    }


    public function fetchAllocatedServiceItems($service_id)
    {
        $sql = "SELECT sp.*, msei.qty, msei.id as estimate_id, sp.unit_price
                    FROM machine_service_estimated_items msei 
                    LEFT JOIN spare_parts sp ON sp.id = msei.spare_part_id 
                    WHERE msei.machine_service_id = '$service_id' 
                    AND msei.is_deleted = 0
                    ";
        $query = $this->db->query($sql);
        $data['sc'] = $query->result_array();

        $sql1 = "SELECT sp.*, msei.qty, msei.id as allocate_id, msei.created_at, msei2.qty as estimated_qty, sp.unit_price
                    FROM machine_service_allocated_items msei 
                    LEFT JOIN machine_service_estimated_items msei2 ON msei2.id = msei.estimate_id
                    LEFT JOIN spare_parts sp ON sp.id = msei.spare_part_id 
                    WHERE msei.machine_service_id = '$service_id' 
                    AND msei.is_deleted = 0
                    ";
        $query1 = $this->db->query($sql1);
        $data['ac'] = $query1->result_array();

        $data_main = array();

        foreach ($data['sc'] as $d) {
            //get allocated count
            $estimate_id = $d['estimate_id'];
            $sql2 = "SELECT SUM(msai.qty) as allo_qty
                FROM machine_service_allocated_items msai 
                WHERE msai.estimate_id = '$estimate_id'
                AND msai.is_deleted = 0
                GROUP BY msai.estimate_id
                ";
            $query2 = $this->db->query($sql2);
            $data2 = $query2->row_array();
            $allo_qty = $data2['allo_qty'] ?? 0;

            $sub_arr = array(
                'sp_name' => $d['name'] . ' - ' . $d['part_no'],
                'sp_id' => $d['id'],
                'estimate_id' => $d['estimate_id'],
                'estimate_qty' => $d['qty'],
                'unit_price' => $d['unit_price'],
                'allocated_qty' => $allo_qty,
            );
            array_push($data_main, $sub_arr);

        }
        $data['sc_det'] = $data_main;

        $data['main_data'] = $this->model_machine_services->getMachineServicesData($service_id);

        echo json_encode($data);
    }

    public function fetchMachineServicesDataById($id = null)
    {
        if ($id) {
            $data['main_data'] = $this->model_machine_services->getMachineServicesData($id);

            $sql = "SELECT sp.*, msei.qty, msei.id as estimate_id
                    FROM machine_service_estimated_items msei 
                    LEFT JOIN spare_parts sp ON sp.id = msei.spare_part_id 
                    WHERE msei.machine_service_id = '$id' 
                    AND msei.is_deleted = 0
                    ";
            $query = $this->db->query($sql);
            $data['sc'] = $query->result_array();

            $data_main = array();

            foreach ($data['sc'] as $d) {
                //get allocated count
                $estimate_id = $d['estimate_id'];
                $sql2 = "SELECT SUM(msai.qty) as allo_qty
                FROM machine_service_allocated_items msai 
                WHERE msai.estimate_id = '$estimate_id'
                AND msai.is_deleted = 0
                GROUP BY msai.estimate_id
                ";
                $query2 = $this->db->query($sql2);
                $data2 = $query2->row_array();
                $allo_qty = $data2['allo_qty'] ?? 0;

                $sub_arr = array(
                    'sp_name' => $d['name'] . ' - ' . $d['part_no'],
                    'sp_id' => $d['id'],
                    'estimate_id' => $d['estimate_id'],
                    'estimate_qty' => $d['qty'],
                    'allocated_qty' => $allo_qty,
                );
                array_push($data_main, $sub_arr);

            }
            $data['sc_det'] = $data_main;

            $sql = "SELECT sp.*, msei.qty, msei.id as allocate_id
                    FROM machine_service_allocated_items msei 
                    LEFT JOIN spare_parts sp ON sp.id = msei.spare_part_id 
                    WHERE msei.machine_service_id = '$id' 
                    AND msei.is_deleted = 0
                    ";
            $query = $this->db->query($sql);
            $data['ic'] = $query->result_array();

            $data_ic = array();

            foreach ($data['ic'] as $d) {
                //get issued count
                $allocate_id = $d['allocate_id'];
                $sql2 = "SELECT SUM(msai.qty) as issued_qty
                FROM machine_service_issued_items msai 
                WHERE msai.a_id = '$allocate_id'
                AND msai.is_deleted = 0
                GROUP BY msai.a_id
                ";
                $query2 = $this->db->query($sql2);
                $data2 = $query2->row_array();
                $issued_qty = $data2['issued_qty'] ?? 0;

                $sub_arr = array(
                    'sp_name' => $d['name'] . ' - ' . $d['part_no'],
                    'sp_id' => $d['id'],
                    'a_id' => $d['allocate_id'],
                    'allocated_qty' => $d['qty'],
                    'issued_qty' => $issued_qty,
                );
                array_push($data_ic, $sub_arr);

            }
            $data['ic_det'] = $data_ic;


            $sql = "SELECT sp.*, msei.qty, msei.id as issue_id
                    FROM machine_service_issued_items msei 
                    LEFT JOIN spare_parts sp ON sp.id = msei.spare_part_id 
                    WHERE msei.machine_service_id = '$id' 
                    AND msei.is_deleted = 0
                    ";
            $query = $this->db->query($sql);
            $data['rc'] = $query->result_array();

            $data_rc = array();

            foreach ($data['rc'] as $d) {
                //get received count
                $issue_id = $d['issue_id'];
                $sql2 = "SELECT SUM(msai.qty) as received_qty
                FROM machine_service_received_items msai 
                WHERE msai.issue_id = '$issue_id'
                AND msai.is_deleted = 0
                GROUP BY msai.issue_id
                ";
                $query2 = $this->db->query($sql2);
                $data2 = $query2->row_array();
                $received_qty = $data2['received_qty'] ?? 0;

                $sub_arr = array(
                    'sp_name' => $d['name'] . ' - ' . $d['part_no'],
                    'sp_id' => $d['id'],
                    'issue_id' => $d['issue_id'],
                    'issued_qty' => $d['qty'],
                    'received_qty' => $received_qty,
                );
                array_push($data_rc, $sub_arr);

            }
            $data['rc_det'] = $data_rc;

            $data_re = array();

            foreach ($data['rc'] as $d) {
                //get received count
                $issue_id = $d['issue_id'];
                $sql2 = "SELECT SUM(msai.qty) as returned_qty
                FROM machine_service_returned_items msai 
                WHERE msai.issue_id = '$issue_id'
                AND msai.is_deleted = 0
                GROUP BY msai.issue_id
                ";
                $query2 = $this->db->query($sql2);
                $data2 = $query2->row_array();
                $received_qty = $data2['returned_qty'] ?? 0;

                $sub_arr = array(
                    'sp_name' => $d['name'] . ' - ' . $d['part_no'],
                    'sp_id' => $d['id'],
                    'issue_id' => $d['issue_id'],
                    'issued_qty' => $d['qty'],
                    'returned_qty' => $received_qty,
                );
                array_push($data_re, $sub_arr);

            }
            $data['re_det'] = $data_re;



            $sql = "SELECT sp.*, msei.qty, msei.id as return_id
                    FROM machine_service_returned_items msei 
                    LEFT JOIN spare_parts sp ON sp.id = msei.spare_part_id 
                    WHERE msei.machine_service_id = '$id' 
                    AND msei.is_deleted = 0
                    ";
            $query = $this->db->query($sql);
            $data['returned'] = $query->result_array();

            $data_ac = array();

            foreach ($data['returned'] as $d) {
                //get accepted count
                $return_id = $d['return_id'];
                $sql2 = "SELECT SUM(msai.qty) as accepted_qty
                FROM machine_service_returned_accepted_items msai 
                WHERE msai.return_id = '$return_id'
                AND msai.is_deleted = 0
                GROUP BY msai.return_id
                ";
                $query2 = $this->db->query($sql2);
                $data2 = $query2->row_array();
                $accepted_qty = $data2['accepted_qty'] ?? 0;

                $sub_arr = array(
                    'sp_name' => $d['name'] . ' - ' . $d['part_no'],
                    'sp_id' => $d['id'],
                    'return_id' => $d['return_id'],
                    'returned_qty' => $d['qty'],
                    'accepted_qty' => $accepted_qty,
                );
                array_push($data_ac, $sub_arr);

            }
            $data['ac_det'] = $data_ac;

            echo json_encode($data);

        }

    }

    public function fetchMachineServicesDataByIdAllocated($id = null)
    {
        if ($id) {
            $data['main_data'] = $this->model_machine_services->getMachineServicesData($id);

            $sql = "SELECT sp.*, msei.qty, msei.id as a_id
                    FROM machine_service_allocated_items msei 
                    LEFT JOIN spare_parts sp ON sp.id = msei.spare_part_id 
                    WHERE msei.machine_service_id = '$id' 
                    ";
            $query = $this->db->query($sql);
            $data['sc'] = $query->result_array();

            echo json_encode($data);

        }

    }

    public function removeAllocate()
    {
        if (!in_array('deleteMachineServiceItemAllocate', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $machine_service_id = $this->input->post('machine_service_id');

        $response = array();
        if ($machine_service_id) {
            $this->db->where('machine_service_id', $machine_service_id);
            $delete = $this->db->delete('machine_service_allocated_items');

            if ($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully removed";
            } else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the information";
            }

        } else {
            $response['success'] = false;
            $response['messages'] = "Refresh the page again!!";
        }

        echo json_encode($response);
    }

    public function removeIssue()
    {
        if (!in_array('deleteMachineServiceItemIssue', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $machine_service_id = $this->input->post('machine_service_id');

        $response = array();
        if ($machine_service_id) {
            $this->db->where('machine_service_id', $machine_service_id);
            $delete = $this->db->delete('machine_service_issued_items');

            if ($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully removed";
            } else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the information";
            }

        } else {
            $response['success'] = false;
            $response['messages'] = "Refresh the page again!!";
        }

        echo json_encode($response);
    }

    public function getServiceNo()
    {
        if (!in_array('createMachineService', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->db->select('*');
        $this->db->from('machine_services');
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        $machine_service = $query->row_array();

        if (empty($machine_service)) {
            $service_id = 1;
        } else {
            $service_id = $machine_service['id'] + 1;
        }

        //check if job no string is less than 4 digits
        if (strlen($service_id) < 4) {
            //add leading zeroes and trim to last 4 digits
            $service_id = str_pad($service_id, 4, '0', STR_PAD_LEFT);
        }

        $service_no = 'SRV' . $service_id;

        echo json_encode($service_no);
    }

    public function get_employee_id_select_id()
    {
        $term = $this->input->get('term');
        $page = $this->input->get('page');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $this->db->select('employees.* ');
        $this->db->from('employees');
        $this->db->like('emp_name_with_initial', $term, 'both');
        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $machine_ins = $query->result_array();

        $this->db->select('employees.* ');
        $this->db->from('employees');
        $this->db->like('emp_name_with_initial', $term, 'both');
        $count = $this->db->count_all_results();

        $data = array();
        foreach ($machine_ins as $v) {
            $data[] = array(
                'id' => $v['id'],
                'text' => $v['emp_name_with_initial']
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

    public function allocate()
    {
        if (!in_array('viewMachineServiceItemAllocate', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $this->data['js'] = 'application/views/MachineServices/MachineServices/allocate-js.php';
        $this->render_template('MachineServices/MachineServices/allocate', $this->data);
    }

    public function fetchCategoryDataAllocate()
    {
        if (!in_array('viewMachineServiceItemAllocate', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());

        $data = $this->model_machine_services->getMachineServicesData();

        foreach ($data as $key => $value) {
            // button
            $buttons = '';

            $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="viewFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#viewModal"><i class="fas fa-eye text-info"></i></button>';

            if (in_array('updateMachineServiceItemAllocate', $this->permission)) {
                $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="editFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#editModal"><i class="text-primary fa fa-edit"></i></button>';
            }

            //$status = ($value['active'] == 1) ? '<span class="badge badge-success btn-sm">Active</span>' : '<span class="badge badge-warning">Inactive</span>';

            $id = $value['id'];

            $sql = "SELECT sp.name, msei.qty
                    FROM machine_service_estimated_items msei 
                    LEFT JOIN spare_parts sp ON sp.id = msei.spare_part_id 
                    WHERE msei.machine_service_id = '$id' 
                    ";
            $query = $this->db->query($sql);
            $sc = $query->result_array();

            $sc_label = '';
            foreach ($sc as $s) {
                $sc_label .= ' <badge class="badge badge-default"> ' . $s['name'] . ' <badge class="badge badge-info"> ' . $s['qty'] . ' </badge> </badge>';
            }

            $sql = "SELECT sp.name, msei.qty
                    FROM machine_service_allocated_items msei 
                    LEFT JOIN spare_parts sp ON sp.id = msei.spare_part_id 
                    WHERE msei.machine_service_id = '$id' 
                    ";
            $query = $this->db->query($sql);
            $sc = $query->result_array();

            $al_label = '';
            foreach ($sc as $s) {
                $al_label .= ' <badge class="badge badge-default"> ' . $s['name'] . ' <badge class="badge badge-success"> ' . $s['qty'] . ' </badge> </badge>';
            }

            $sql1 = "
            SELECT * 
            FROM machine_service_allocated_items 
            WHERE machine_service_id = '$id' 
            ";
            $query1 = $this->db->query($sql1);
            $sc = $query1->result_array();

            if(!empty($sc)) {
                $result['data'][] = array(
                    $value['service_no'],
                    $value['machine_type_name'],
                    $value['s_no'],
                    $value['service_date_from'],
                    $value['service_date_to'],
                    $value['estimated_service_hours'],
                    $buttons
                );
            }
        } // /foreach

        echo json_encode($result);
    }

    public function allocate_new()
    {
        if (!in_array('createMachineServiceItemAllocate', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();
        $this->form_validation->set_rules('service_no', 'Service No', 'trim|required');
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        $service_no = $this->input->post('service_no');

        $estimated_service_items = $this->input->post('sp_id[]');
        $estimate_id = $this->input->post('estimate_id[]');
        $qty = $this->input->post('qty[]');
        $remarks = $this->input->post('remarks');

        if ($estimated_service_items == null) {
            $response['success'] = false;
            $response['messages']['service_no'] = '<p class="text-danger"> Please select at least one Item </p>';
            echo json_encode($response);
            die();
        }

        $sub_data = array();
        for ($i = 0; $i < sizeof($estimated_service_items); $i++) {
            if ($qty[$i] > 0) {
                $sub_data[] = array(
                    'spare_part_id' => $estimated_service_items[$i],
                    'machine_service_id' => $service_no,
                    'qty' => $qty[$i],
                    'estimate_id' => $estimate_id[$i],
                    'created_by' => $this->session->userdata('id'),
                    'created_at' => date('Y-m-d H:i:s')
                );
            }
        }
        $sps_create = $this->db->insert_batch('machine_service_allocated_items', $sub_data);

        $response['success'] = true;
        $response['messages'] = 'Successfully updated';


        echo json_encode($response);
    }

    public function update_allocations()
    {
        if (!in_array('updateMachineServiceItemAllocate', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        $estimated_service_items = $this->input->post('sp_id[]');
        $allocate_id = $this->input->post('allocate_id[]');
        $qty = $this->input->post('qty[]');

        if ($allocate_id == null) {
            $response['success'] = false;
            $response['messages']['edit_service_no'] = '<p class="text-danger"> Please select at least one Item </p>';
            echo json_encode($response);
            die();
        }

        for ($i = 0; $i < sizeof($allocate_id); $i++) {
            if ($qty[$i] > 0) {
                $sub_data = array(
                    'qty' => $qty[$i],
                    'updated_by' => $this->session->userdata('id'),
                    'updated_at' => date('Y-m-d H:i:s')
                );

                $this->db->where('id', $allocate_id[$i]);
                $this->db->update('machine_service_allocated_items', $sub_data);
            }
        }

        $response['success'] = true;
        $response['messages'] = 'Successfully updated';


        echo json_encode($response);
    }

    public function remove_allocation()
    {
        if (!in_array('deleteMachineServiceItemAllocate', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $this->form_validation->set_rules('id', 'ID', 'trim|required');

        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run() == TRUE) {

            $id = $this->input->post('id');

            $data = array(
                'is_deleted' => 1,
                'deleted_by' => $this->session->userdata('id'),
                'deleted_at' => date('Y-m-d H:i:s')
            );

            $this->db->where('id', $id);
            $this->db->update('machine_service_allocated_items', $data);

            $sql = "SELECT machine_service_id FROM
                        machine_service_allocated_items msai 
                        WHERE id = '$id'
                ";
            $query = $this->db->query($sql);
            $sc = $query->row_array();

            $response['service_id'] = $sc['machine_service_id'];
            $response['success'] = true;
            $response['messages'] = 'Successfully updated';

        } else {
            $response['success'] = false;
            foreach ($_POST as $key => $value) {
                $response['messages'][$key] = form_error($key);
            }
        }

        echo json_encode($response);
    }


    public function issue()
    {
        if (!in_array('viewMachineServiceItemIssue', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $this->data['js'] = 'application/views/MachineServices/MachineServices/issue-js.php';
        $this->render_template('MachineServices/MachineServices/issue', $this->data);
    }

    public function fetchCategoryDataIssue()
{
    if (!in_array('viewMachineServiceItemIssue', $this->permission)) {
        redirect('dashboard', 'refresh');
    }

    $result = array('data' => array());

    $data = $this->model_machine_services->getMachineServicesData();

    foreach ($data as $key => $value) {
        // button actions
        $buttons = '<button type="button" class="btn btn-default btn-sm" onclick="viewFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#viewModal"><i class="fas fa-eye text-info"></i></button>';

        if (in_array('updateMachineServiceItemIssue', $this->permission)) {
            $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="editFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#editModal"><i class="text-primary fa fa-edit"></i></button>';
        }

        $id = $value['id'];

        // Fetch Allocated Items
        $sql = "
        SELECT sp.name, msei.qty, e.emp_name_with_initial
        FROM machine_service_allocated_items msei 
        LEFT JOIN spare_parts sp ON sp.id = msei.spare_part_id 
        LEFT JOIN machine_services ms ON ms.id = msei.machine_service_id
        LEFT JOIN employees e ON e.id = ms.employee_id
        WHERE msei.machine_service_id = '$id' 
        ";
        $query = $this->db->query($sql);
        $allocatedItems = $query->result_array();

        $sc_label = '';
        foreach ($allocatedItems as $s) {
            $sc_label .= '<span class="badge badge-default"> ' . $s['name'] . ' <span class="badge badge-info"> ' . $s['qty'] . ' </span></span>';
        }

        // Fetch Issued Items
        $sql = "
        SELECT sp.name, msii.qty, e.emp_name_with_initial
        FROM machine_service_issued_items msii 
        LEFT JOIN spare_parts sp ON sp.id = msii.spare_part_id 
        LEFT JOIN machine_services ms ON ms.id = msii.machine_service_id
        LEFT JOIN employees e ON e.id = ms.employee_id
        WHERE msii.machine_service_id = '$id' 
        ";
        $query = $this->db->query($sql);
        $issuedItems = $query->result_array();

        $al_label = '';
        foreach ($issuedItems as $s) {
            $al_label .= '<span class="badge badge-default"> ' . $s['name'] . ' <span class="badge badge-success"> ' . $s['qty'] . ' </span></span>';
        }

        // Check if this service_no has records in issued table
        $sql1 = "
        SELECT msii.*, e.emp_name_with_initial 
        FROM machine_service_issued_items msii
        LEFT JOIN machine_services ms ON ms.id = msii.machine_service_id
        LEFT JOIN employees e ON e.id = ms.employee_id
        WHERE msii.machine_service_id = '$id' AND msii.is_deleted = 0
        ";
        $query1 = $this->db->query($sql1);
        $sc = $query1->result_array();

        // Safely access employee name
        $emp_name_with_initial = isset($sc[0]['emp_name_with_initial']) ? $sc[0]['emp_name_with_initial'] : 'N/A';

        if (!empty($sc)) {
            $result['data'][] = array(
                $value['service_no'],
                $emp_name_with_initial,
                $value['machine_type_name'],
                $value['s_no'],
                $value['service_date_from'],
                $value['service_date_to'],
                $value['estimated_service_hours'],
                $buttons
            );
        }
    } // /foreach

    echo json_encode($result);
}



    public function fetchIssuedServiceItems($service_id)
    {

        $sql = "SELECT sp.*, msei.qty, msei.id as issue_id, msai.qty as allocated_qty, sp.unit_price, msei.created_at as issued_at
                    FROM machine_service_issued_items msei 
                    LEFT JOIN machine_service_allocated_items msai ON msai.id = msei.a_id
                    LEFT JOIN spare_parts sp ON sp.id = msei.spare_part_id 
                    WHERE msei.machine_service_id = '$service_id' 
                    AND msei.is_deleted = 0
                    ";
        $query = $this->db->query($sql);
        $data['sc'] = $query->result_array();

        $sql1 = "SELECT sp.*, msei.qty, msei.id as allocate_id, msei2.qty as estimated_qty, sp.unit_price
                    FROM machine_service_allocated_items msei 
                    LEFT JOIN machine_service_estimated_items msei2 ON msei2.id = msei.estimate_id
                    LEFT JOIN spare_parts sp ON sp.id = msei.spare_part_id 
                    WHERE msei.machine_service_id = '$service_id' 
                    AND msei.is_deleted = 0
                    ";
        $query1 = $this->db->query($sql1);
        $data['ac'] = $query1->result_array();

        $data_main = array();

        foreach ($data['ac'] as $d) {
            //get allocated count
            $allocate_id = $d['allocate_id'];
            $sql2 = "SELECT SUM(msai.qty) as issue_qty
                FROM machine_service_issued_items msai 
                WHERE msai.a_id = '$allocate_id'
                AND msai.is_deleted = 0
                GROUP BY msai.a_id
                ";
            $query2 = $this->db->query($sql2);
            $data2 = $query2->row_array();
            $issue_qty = $data2['issue_qty'] ?? 0;

            $sub_arr = array(
                'sp_name' => $d['name'] . ' - ' . $d['part_no'],
                'sp_id' => $d['id'],
                'a_id' => $d['allocate_id'],
                'allocated_qty' => $d['qty'],
                'unit_price' => $d['unit_price'],
                'issued_qty' => $issue_qty,
            );
            array_push($data_main, $sub_arr);

        }
        $data['sc_det'] = $data_main;

        $data['main_data'] = $this->model_machine_services->getMachineServicesData($service_id);

        echo json_encode($data);
    }

    public function issue_new()
    {
        if (!in_array('createMachineServiceItemIssue', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();
        $this->form_validation->set_rules('service_no', 'Service No', 'trim|required');
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        $service_no = $this->input->post('service_no');

        $estimated_service_items = $this->input->post('sp_id[]');
        $a_id = $this->input->post('a_id[]');
        $qty = $this->input->post('qty[]');

        if ($estimated_service_items == null) {
            $response['success'] = false;
            $response['messages']['service_no'] = '<p class="text-danger"> Please select at least one Item </p>';
            echo json_encode($response);
            die();
        }

        //$sub_data = array();
        for ($i = 0; $i < sizeof($estimated_service_items); $i++) {
            $sub_data = array(
                'spare_part_id' => $estimated_service_items[$i],
                'machine_service_id' => $service_no,
                'qty' => $qty[$i],
                'a_id' => $a_id[$i],
                'created_by' => $this->session->userdata('id'),
                'created_at' => date('Y-m-d H:i:s')
            );

            $this->db->insert('machine_service_issued_items', $sub_data);
            $issue_id = $this->db->insert_id();
            //mark allocated items as finished
            $data1 = array(
                'is_finished' => 1
            );
            $this->db->where('id', $a_id[$i]);
            $this->db->update('machine_service_allocated_items', $data1);

            //insert to stock
            $qty_s = '-' . $qty[$i];
            $data2 = array(
                'qty' => $qty_s,
                'service_id' => $service_no,
                'allocated_id' => $a_id[$i],
                'issue_id' => $issue_id,
                'spare_part_id' => $estimated_service_items[$i],
                'created_by' => $this->session->userdata('id'),
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->db->insert('tbl_stock', $data2);

        }


        $response['success'] = true;
        $response['messages'] = 'Successfully updated';


        echo json_encode($response);
    }

    public function update_issue()
    {
        if (!in_array('updateMachineServiceItemIssue', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        $estimated_service_items = $this->input->post('sp_id[]');
        $issue_id = $this->input->post('issue_id[]');
        $qty = $this->input->post('qty[]');

        if ($issue_id == null) {
            $response['success'] = false;
            $response['messages']['edit_service_no'] = '<p class="text-danger"> Please select at least one Item </p>';
            echo json_encode($response);
            die();
        }

        for ($i = 0; $i < sizeof($issue_id); $i++) {
            if ($qty[$i] > 0) {
                $sub_data = array(
                    'qty' => $qty[$i],
                    'updated_by' => $this->session->userdata('id'),
                    'updated_at' => date('Y-m-d H:i:s')
                );

                $this->db->where('id', $issue_id[$i]);
                $this->db->update('machine_service_issued_items', $sub_data);
            }

            //update stock
            $sub_data1 = array(
                'qty' => '-'.$qty[$i]
            );
            $this->db->where('issue_id', $issue_id[$i]);
            $this->db->update('tbl_stock', $sub_data1);

        }

        $response['success'] = true;
        $response['messages'] = 'Successfully updated';


        echo json_encode($response);
    }

    public function remove_issue()
    {
        if (!in_array('deleteMachineServiceItemIssue', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $this->form_validation->set_rules('id', 'ID', 'trim|required');

        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run() == TRUE) {

            $id = $this->input->post('id');

            $data = array(
                'is_deleted' => 1,
                'deleted_by' => $this->session->userdata('id'),
                'deleted_at' => date('Y-m-d H:i:s')
            );

            $this->db->where('id', $id);
            $this->db->update('machine_service_issued_items', $data);

            $sql = "SELECT * FROM
                        machine_service_issued_items msai 
                        WHERE id = '$id'
                ";
            $query = $this->db->query($sql);
            $sc = $query->row_array();

            //update stock
            $sub_data1 = array(
                'qty' => 0
            );
            $this->db->where('issue_id', $sc['id']);
            $this->db->update('tbl_stock', $sub_data1);

            $response['service_id'] = $sc['machine_service_id'];
            $response['success'] = true;
            $response['messages'] = 'Successfully updated';

        } else {
            $response['success'] = false;
            foreach ($_POST as $key => $value) {
                $response['messages'][$key] = form_error($key);
            }
        }

        echo json_encode($response);
    }

    public function fetchMachineServicesDataByIdIssued($id = null)
    {
        if ($id) {
            $data['main_data'] = $this->model_machine_services->getMachineServicesData($id);

            $sql = "SELECT sp.*, msei.qty, msei.id as issue_id
                    FROM machine_service_issued_items msei 
                    LEFT JOIN spare_parts sp ON sp.id = msei.spare_part_id 
                    WHERE msei.machine_service_id = '$id' 
                    ";
            $query = $this->db->query($sql);
            $data['sc'] = $query->result_array();

            echo json_encode($data);

        }

    }

    public function get_service_no_select_id()
    {
        $term = $this->input->get('term');
        $page = $this->input->get('page');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $this->db->select('machine_services.* ');
        $this->db->from('machine_services');
        $this->db->like('service_no', $term, 'both');
        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $machine_ins = $query->result_array();

        $this->db->select('machine_services.* ');
        $this->db->from('machine_services');
        $this->db->like('service_no', $term, 'both');
        $count = $this->db->count_all_results();

        $data = array();
        foreach ($machine_ins as $v) {
            $data[] = array(
                'id' => $v['id'],
                'text' => $v['service_no']
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



    public function receive()
    {
        if (!in_array('viewMachineServiceItemReceive', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $this->data['js'] = 'application/views/MachineServices/MachineServices/receive-js.php';
        $this->render_template('MachineServices/MachineServices/receive', $this->data);
    }

    public function fetchCategoryDataReceive()
    {
        if (!in_array('viewMachineServiceItemReceive', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());

        $data = $this->model_machine_services->getMachineServicesData();

        foreach ($data as $key => $value) {
            // button
            $buttons = '';

            $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="viewFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#viewModal"><i class="fas fa-eye text-info"></i></button>';

            if (in_array('updateMachineServiceItemReceive', $this->permission)) {
                $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="editFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#editModal"><i class="text-primary fa fa-edit"></i></button>';
            }

            $id = $value['id'];

            $sql = "SELECT sp.name, msei.qty
                    FROM machine_service_issued_items msei 
                    LEFT JOIN spare_parts sp ON sp.id = msei.spare_part_id 
                    WHERE msei.machine_service_id = '$id' 
                    ";
            $query = $this->db->query($sql);
            $sc = $query->result_array();

            $sc_label = '';
            foreach ($sc as $s) {
                $sc_label .= ' <badge class="badge badge-default"> ' . $s['name'] . ' <badge class="badge badge-info"> ' . $s['qty'] . ' </badge> </badge>';
            }

            $sql = "SELECT sp.name, msei.qty
                    FROM machine_service_received_items msei 
                    LEFT JOIN spare_parts sp ON sp.id = msei.spare_part_id 
                    WHERE msei.machine_service_id = '$id' 
                    ";
            $query = $this->db->query($sql);
            $sc = $query->result_array();

            $al_label = '';
            foreach ($sc as $s) {
                $al_label .= ' <badge class="badge badge-default"> ' . $s['name'] . ' <badge class="badge badge-success"> ' . $s['qty'] . ' </badge> </badge>';
            }

            //check if this service_no has records in received table
            $sql1 = "
            SELECT * 
            FROM machine_service_received_items 
            WHERE machine_service_id = '$id' 
            ";

            $query1 = $this->db->query($sql1);
            $sc = $query1->result_array();

            if(!empty($sc)) {
                $result['data'][] = array(
                    $value['service_no'],
                    $value['machine_type_name'],
                    $value['s_no'],
                    $value['service_date_from'],
                    $value['service_date_to'],
                    $value['estimated_service_hours'],
                    $buttons
                );
            }
        } // /foreach

        echo json_encode($result);
    }

    public function receive_new()
    {
        if (!in_array('createMachineServiceItemReceive', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

            $this->form_validation->set_rules('service_no', 'Service No', 'trim|required');
            $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

            $service_no = $this->input->post('service_no');

            $estimated_service_items = $this->input->post('sp_id[]');
            $issue_id = $this->input->post('issue_id[]');
            $qty = $this->input->post('qty[]');

            if ($estimated_service_items == null) {
                $response['success'] = false;
                $response['messages']['service_no'] = '<p class="text-danger"> Please select at least one Item </p>';
                echo json_encode($response);
                die();
            }

            $sub_data = array();
            for ($i = 0; $i < sizeof($estimated_service_items); $i++) {
                $sub_data[] = array(
                    'spare_part_id' => $estimated_service_items[$i],
                    'machine_service_id' => $service_no,
                    'qty' => $qty[$i],
                    'issue_id' => $issue_id[$i],
                    'created_by' => $this->session->userdata('id'),
                    'created_at' => date('Y-m-d H:i:s')
                );
                //mark allocated items as finished
                $data = array(
                    'is_received' => 1
                );
                $this->db->where('id', $issue_id[$i]);
                $this->db->update('machine_service_issued_items', $data);

            }
            $sps_create = $this->db->insert_batch('machine_service_received_items', $sub_data);

            $response['success'] = true;
            $response['messages'] = 'Successfully updated';

        echo json_encode($response);
    }

    public function fetchReceivedServiceItems($service_id)
    {

        $sql = "SELECT sp.*, msei.qty, msei.id as receive_id, msai.qty as issued_qty, msei.created_at as received_at
                    FROM machine_service_received_items msei 
                    LEFT JOIN machine_service_issued_items msai ON msai.id = msei.issue_id
                    LEFT JOIN spare_parts sp ON sp.id = msei.spare_part_id 
                    WHERE msei.machine_service_id = '$service_id' 
                    AND msei.is_deleted = 0
                    ";
        $query = $this->db->query($sql);
        $data['sc'] = $query->result_array();

        $sql1 = "SELECT sp.*, msei.qty, msei.id as issue_id, msei.created_at 
                    FROM machine_service_issued_items msei  
                    LEFT JOIN spare_parts sp ON sp.id = msei.spare_part_id 
                    WHERE msei.machine_service_id = '$service_id' 
                    AND msei.is_deleted = 0
                    ";
        $query1 = $this->db->query($sql1);
        $data['ic'] = $query1->result_array();

        $data_main = array();

        foreach ($data['ic'] as $d) {
            //get received count
            $issue_id = $d['issue_id'];
            $sql2 = "SELECT SUM(msai.qty) as receive_qty
                FROM machine_service_received_items msai 
                WHERE msai.issue_id = '$issue_id'
                AND msai.is_deleted = 0
                GROUP BY msai.issue_id
                ";
            $query2 = $this->db->query($sql2);
            $data2 = $query2->row_array();
            $received_qty = $data2['receive_qty'] ?? 0;

            $sub_arr = array(
                'sp_name' => $d['name'] . ' - ' . $d['part_no'],
                'sp_id' => $d['id'],
                'issue_id' => $d['issue_id'],
                'issued_qty' => $d['qty'],
                'unit_price' => $d['unit_price'],
                'received_qty' => $received_qty,
            );
            array_push($data_main, $sub_arr);

        }
        $data['rc_det'] = $data_main;

        $data['main_data'] = $this->model_machine_services->getMachineServicesData($service_id);

        echo json_encode($data);
    }

    public function update_receive()
    {
        if (!in_array('updateMachineServiceItemReceive', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        $estimated_service_items = $this->input->post('sp_id[]');
        $receive_id = $this->input->post('receive_id[]');
        $qty = $this->input->post('qty[]');

        if ($receive_id == null) {
            $response['success'] = false;
            $response['messages']['edit_service_no'] = '<p class="text-danger"> Please select at least one Item </p>';
            echo json_encode($response);
            die();
        }

        for ($i = 0; $i < sizeof($receive_id); $i++) {
            if ($qty[$i] > 0) {
                $sub_data = array(
                    'qty' => $qty[$i],
                    'updated_by' => $this->session->userdata('id'),
                    'updated_at' => date('Y-m-d H:i:s')
                );

                $this->db->where('id', $receive_id[$i]);
                $this->db->update('machine_service_received_items', $sub_data);
            }
        }

        $response['success'] = true;
        $response['messages'] = 'Successfully updated';


        echo json_encode($response);
    }

    public function remove_receive()
    {
        if (!in_array('deleteMachineServiceItemReceive', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $this->form_validation->set_rules('id', 'ID', 'trim|required');

        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run() == TRUE) {

            $id = $this->input->post('id');

            $data = array(
                'is_deleted' => 1,
                'deleted_by' => $this->session->userdata('id'),
                'deleted_at' => date('Y-m-d H:i:s')
            );

            $this->db->where('id', $id);
            $this->db->update('machine_service_received_items', $data);

            $sql = "SELECT machine_service_id FROM
                        machine_service_received_items msai 
                        WHERE id = '$id'
                ";
            $query = $this->db->query($sql);
            $sc = $query->row_array();

            $response['service_id'] = $sc['machine_service_id'];
            $response['success'] = true;
            $response['messages'] = 'Successfully updated';

        } else {
            $response['success'] = false;
            foreach ($_POST as $key => $value) {
                $response['messages'][$key] = form_error($key);
            }
        }

        echo json_encode($response);
    }



    public function return_to_stock()
    {
        if (!in_array('viewMachineServiceItemReturn', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $this->data['js'] = 'application/views/MachineServices/MachineServices/return_to_stock-js.php';
        $this->render_template('MachineServices/MachineServices/return_to_stock', $this->data);
    }

    public function fetchCategoryDataReturnToStock()
    {
        if (!in_array('viewMachineServiceItemReturn', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());

        $data = $this->model_machine_services->getMachineServicesData();

        foreach ($data as $key => $value) {
            // button
            $buttons = '';

            $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="viewFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#viewModal"><i class="fas fa-eye text-info"></i></button>';

            if (in_array('updateMachineServiceItemReturn', $this->permission)) {
                $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="editFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#editModal"><i class="text-primary fa fa-edit"></i></button>';
            }

            $id = $value['id'];

            if (in_array('createMachineServiceItemReturnAccept', $this->permission)) {
                $buttons .= '<button type="button" class="btn btn-default btn-sm btn_accept" data-service_id ="'.$id.'" data-toggle="modal" data-target="#acceptModal"><i class="text-success fa fa-check"></i></button>';
            }

            //check if this service_no has records in returned table
            $sql1 = "
            SELECT * 
            FROM machine_service_returned_items_header 
            WHERE machine_service_id = '$id' 
            ";

            $query1 = $this->db->query($sql1);
            $sc = $query1->result_array();

            if(!empty($sc)){
                $result['data'][] = array(
                    $value['service_no'],
                    $value['machine_type_name'],
                    $value['s_no'],
                    $value['service_date_from'],
                    $value['service_date_to'],
                    $value['estimated_service_hours'],
                    $buttons
                );
            }

        } // /foreach

        echo json_encode($result);
    }

    public function return_to_stock_new()
    {
        if (!in_array('createMachineServiceItemReturn', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $this->form_validation->set_rules('service_no', 'Service No', 'trim|required');
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        $service_no = $this->input->post('service_no');

        $estimated_service_items = $this->input->post('sp_id[]');
        $issue_id = $this->input->post('issue_id[]');
        $qty = $this->input->post('qty[]');
        $remarks = $this->input->post('remarks');

        if ($estimated_service_items == null) {
            $response['success'] = false;
            $response['messages']['service_no'] = '<p class="text-danger"> Please select at least one Item </p>';
            echo json_encode($response);
            die();
        }

        $head_data = array(
            'machine_service_id' => $service_no,
            'remarks' => $remarks
        );
        $this->db->insert('machine_service_returned_items_header', $head_data);
        $header_id = $this->db->insert_id();

        $sub_data = array();
        for ($i = 0; $i < sizeof($estimated_service_items); $i++) {
            $sub_data[] = array(
                'spare_part_id' => $estimated_service_items[$i],
                'machine_service_id' => $service_no,
                'header_id' => $header_id,
                'qty' => $qty[$i],
                'issue_id' => $issue_id[$i],
                'created_by' => $this->session->userdata('id'),
                'created_at' => date('Y-m-d H:i:s')
            );
        }
        $sps_create = $this->db->insert_batch('machine_service_returned_items', $sub_data);

        $response['success'] = true;
        $response['messages'] = 'Successfully updated';

        echo json_encode($response);
    }

    public function fetchReturnedServiceItems($service_id)
    {

        $sql = "SELECT sp.*, msei.qty, msei.id as return_id, msai.qty as returned_qty, msei.created_at as received_at
                    FROM machine_service_returned_items msei 
                    LEFT JOIN machine_service_issued_items msai ON msai.id = msei.issue_id
                    LEFT JOIN spare_parts sp ON sp.id = msei.spare_part_id 
                    WHERE msei.machine_service_id = '$service_id' 
                    AND msei.is_deleted = 0
                    ";
        $query = $this->db->query($sql);
        $data['sc'] = $query->result_array();

        $sql3 = "
            SELECT * 
            FROM machine_service_returned_items_header 
            WHERE machine_service_id = '$service_id' 
                AND is_deleted = 0
        ";
        $query3 = $this->db->query($sql3);
        $data['head'] = $query3->result_array();

        $data_head = array();

        foreach ($data['head'] as $s) {

            //get records for header_id
            $head_id = $s['id'];

            $sql4 = "SELECT sp.*, msei.qty, msei.id as return_id, msai.qty as issued_qty, msei.created_at as returned_at
                    FROM machine_service_returned_items msei 
                    LEFT JOIN machine_service_issued_items msai ON msai.id = msei.issue_id
                    LEFT JOIN spare_parts sp ON sp.id = msei.spare_part_id 
                    WHERE msei.header_id = '$head_id' 
                    AND msei.is_deleted = 0
                    ";
            $query4 = $this->db->query($sql4);
            $sc = $query4->result_array();

            $h_arr = array(
                'header_id' => $s['id'],
                'remarks' => $s['remarks'],
                'sc' => $sc
            );
            array_push($data_head, $h_arr);
        }

        $data['head_det'] = $data_head;


        $sql1 = "SELECT sp.*, msei.qty, msei.id as issue_id, msei.created_at 
                    FROM machine_service_issued_items msei  
                    LEFT JOIN spare_parts sp ON sp.id = msei.spare_part_id 
                    WHERE msei.machine_service_id = '$service_id' 
                    AND msei.is_deleted = 0
                    ";
        $query1 = $this->db->query($sql1);
        $data['ic'] = $query1->result_array();

        $data_main = array();

        foreach ($data['ic'] as $d) {
            //get received count
            $issue_id = $d['issue_id'];
            $sql2 = "SELECT SUM(msai.qty) as receive_qty
                FROM machine_service_returned_items msai 
                WHERE msai.issue_id = '$issue_id'
                AND msai.is_deleted = 0
                GROUP BY msai.issue_id
                ";
            $query2 = $this->db->query($sql2);
            $data2 = $query2->row_array();
            $received_qty = $data2['receive_qty'] ?? 0;

            $sub_arr = array(
                'sp_name' => $d['name'] . ' - ' . $d['part_no'],
                'sp_id' => $d['id'],
                'issue_id' => $d['issue_id'],
                'issued_qty' => $d['qty'],
                'unit_price' => $d['unit_price'],
                'received_qty' => $received_qty,
            );
            array_push($data_main, $sub_arr);

        }
        $data['rc_det'] = $data_main;

        $data['main_data'] = $this->model_machine_services->getMachineServicesData($service_id);

        echo json_encode($data);
    }

    public function update_return_to_stock()
    {
        if (!in_array('updateMachineServiceItemReturn', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        $estimated_service_items = $this->input->post('sp_id[]');
        $return_id = $this->input->post('return_id[]');
        $qty = $this->input->post('qty[]');

        $header_id = $this->input->post('header_id[]');
        $remarks = $this->input->post('remarks[]');

        if ($return_id == null) {
            $response['success'] = false;
            $response['messages']['edit_service_no'] = '<p class="text-danger"> Please select at least one Item </p>';
            echo json_encode($response);
            die();
        }

        for ($i = 0; $i < sizeof($header_id); $i++) {
                $sub_data = array(
                    'remarks' => $remarks[$i],
                    'updated_by' => $this->session->userdata('id'),
                    'updated_at' => date('Y-m-d H:i:s')
                );

                $this->db->where('id', $header_id[$i]);
                $this->db->update('machine_service_returned_items_header', $sub_data);
        }

        for ($j = 0; $j < sizeof($return_id); $j++) {
            if ($qty[$j] > 0) {
                $sub_dataj = array(
                    'qty' => $qty[$j],
                    'updated_by' => $this->session->userdata('id'),
                    'updated_at' => date('Y-m-d H:i:s')
                );

                $this->db->where('id', $return_id[$j]);
                $this->db->update('machine_service_returned_items', $sub_dataj);
            }
        }

        $response['success'] = true;
        $response['messages'] = 'Successfully updated';


        echo json_encode($response);
    }

    public function remove_return_to_stock()
    {
        if (!in_array('deleteMachineServiceItemReceive', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $this->form_validation->set_rules('id', 'ID', 'trim|required');

        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run() == TRUE) {

            $id = $this->input->post('id');

            $data = array(
                'is_deleted' => 1,
                'deleted_by' => $this->session->userdata('id'),
                'deleted_at' => date('Y-m-d H:i:s')
            );

            $this->db->where('id', $id);
            $this->db->update('machine_service_returned_items', $data);

            $sql = "SELECT machine_service_id FROM
                        machine_service_returned_items msai 
                        WHERE id = '$id'
                ";
            $query = $this->db->query($sql);
            $sc = $query->row_array();

            $response['service_id'] = $sc['machine_service_id'];
            $response['success'] = true;
            $response['messages'] = 'Successfully updated';

        } else {
            $response['success'] = false;
            foreach ($_POST as $key => $value) {
                $response['messages'][$key] = form_error($key);
            }
        }

        echo json_encode($response);
    }



    public function return_accept()
    {
        if (!in_array('viewMachineServiceItemReturnAccept', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $this->data['js'] = 'application/views/MachineServices/MachineServices/return_to_stock_accept-js.php';
        $this->render_template('MachineServices/MachineServices/return_to_stock_accept', $this->data);
    }

    public function fetchCategoryDataReturnToStockAccept()
    {
        if (!in_array('viewMachineServiceItemReturnAccept', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());

        $data = $this->model_machine_services->getMachineServicesData();

        foreach ($data as $key => $value) {
            // button
            $buttons = '';

            $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="viewFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#viewModal"><i class="fas fa-eye text-info"></i></button>';

            if (in_array('updateMachineServiceItemReturnAccept', $this->permission)) {
                $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="editFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#editModal"><i class="text-primary fa fa-edit"></i></button>';
            }

            $id = $value['id'];

            //check if this service_no has records in accepted table
            $sql1 = "
            SELECT * 
            FROM machine_service_returned_accepted_items_header
            WHERE machine_service_id = '$id' 
            ";

            $query1 = $this->db->query($sql1);
            $sc = $query1->result_array();

            if(!empty($sc)){
                $result['data'][] = array(
                    $value['service_no'],
                    $value['machine_type_name'],
                    $value['s_no'],
                    $value['service_date_from'],
                    $value['service_date_to'],
                    $value['estimated_service_hours'],
                    $buttons
                );
            }

        } // /foreach

        echo json_encode($result);
    }

    public function return_to_stock_new_accept()
    {
        if (!in_array('createMachineServiceItemReturnAccept', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $this->form_validation->set_rules('service_no', 'Service No', 'trim|required');
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        $service_no = $this->input->post('service_no');

        $estimated_service_items = $this->input->post('sp_id[]');
        $issue_id = $this->input->post('return_id[]');
        $qty = $this->input->post('qty[]');
        $remarks = $this->input->post('remarks');

        if ($estimated_service_items == null) {
            $response['success'] = false;
            $response['messages']['service_no'] = '<p class="text-danger"> Please select at least one Item </p>';
            echo json_encode($response);
            die();
        }

        $head_data = array(
            'machine_service_id' => $service_no,
            'remarks' => $remarks
        );
        $this->db->insert('machine_service_returned_accepted_items_header', $head_data);
        $header_id = $this->db->insert_id();

        $sub_data = array();
        for ($i = 0; $i < sizeof($estimated_service_items); $i++) {
            $sub_data[] = array(
                'spare_part_id' => $estimated_service_items[$i],
                'machine_service_id' => $service_no,
                'header_id' => $header_id,
                'qty' => $qty[$i],
                'return_id' => $issue_id[$i],
                'created_by' => $this->session->userdata('id'),
                'created_at' => date('Y-m-d H:i:s')
            );
        }
        $sps_create = $this->db->insert_batch('machine_service_returned_accepted_items', $sub_data);

        $response['success'] = true;
        $response['messages'] = 'Successfully updated';

        echo json_encode($response);
    }

    public function fetchReturnedServiceItemsAccept($service_id)
    {

        $sql = "SELECT sp.*, msei.qty, msei.id as accept_id, msai.qty as accepted_qty, msei.created_at as accepted_at
                    FROM machine_service_returned_accepted_items msei 
                    LEFT JOIN machine_service_returned_items msai ON msai.id = msei.return_id
                    LEFT JOIN spare_parts sp ON sp.id = msei.spare_part_id 
                    WHERE msei.machine_service_id = '$service_id' 
                    AND msei.is_deleted = 0
                    ";
        $query = $this->db->query($sql);
        $data['sc'] = $query->result_array();

        $sql3 = "
            SELECT * 
            FROM machine_service_returned_accepted_items_header 
            WHERE machine_service_id = '$service_id' 
                AND is_deleted = 0
        ";
        $query3 = $this->db->query($sql3);
        $data['head'] = $query3->result_array();

        $data_head = array();

        foreach ($data['head'] as $s) {

            $head_id = $s['id'];

            $sql4 = "SELECT sp.*, msei.qty, msei.id as accept_id, msai.qty as returned_qty, msei.created_at as accepted_at
                    FROM machine_service_returned_accepted_items msei 
                    LEFT JOIN machine_service_returned_items msai ON msai.id = msei.return_id
                    LEFT JOIN spare_parts sp ON sp.id = msei.spare_part_id 
                    WHERE msei.header_id = '$head_id' 
                    AND msei.is_deleted = 0
                    ";
            $query4 = $this->db->query($sql4);
            $sc = $query4->result_array();

            $h_arr = array(
                'header_id' => $s['id'],
                'remarks' => $s['remarks'],
                'sc' => $sc
            );
            array_push($data_head, $h_arr);
        }

        $data['head_det'] = $data_head;


        $sql1 = "SELECT sp.*, msei.qty, msei.id as return_id, msei.created_at 
                    FROM machine_service_returned_items msei  
                    LEFT JOIN spare_parts sp ON sp.id = msei.spare_part_id 
                    WHERE msei.machine_service_id = '$service_id' 
                    AND msei.is_deleted = 0
                    ";
        $query1 = $this->db->query($sql1);
        $data['ic'] = $query1->result_array();

        $data_main = array();

        foreach ($data['ic'] as $d) {
            //get accepted count
            $return_id = $d['return_id'];
            $sql2 = "SELECT SUM(msai.qty) as accept_qty
                FROM machine_service_returned_accepted_items msai 
                WHERE msai.return_id = '$return_id'
                AND msai.is_deleted = 0
                GROUP BY msai.return_id
                ";
            $query2 = $this->db->query($sql2);
            $data2 = $query2->row_array();
            $accept_qty = $data2['accept_qty'] ?? 0;

            $sub_arr = array(
                'sp_name' => $d['name'] . ' - ' . $d['part_no'],
                'sp_id' => $d['id'],
                'return_id' => $d['return_id'],
                'returned_qty' => $d['qty'],
                'unit_price' => $d['unit_price'],
                'accepted_qty' => $accept_qty,
            );
            array_push($data_main, $sub_arr);

        }
        $data['rc_det'] = $data_main;

        $data['main_data'] = $this->model_machine_services->getMachineServicesData($service_id);

        echo json_encode($data);
    }

    public function update_return_to_stock_accept()
    {
        if (!in_array('updateMachineServiceItemReturnAccept', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        $estimated_service_items = $this->input->post('sp_id[]');
        $accept_id = $this->input->post('accept_id[]');
        $qty = $this->input->post('qty[]');

        $header_id = $this->input->post('header_id[]');
        $remarks = $this->input->post('remarks[]');

        if ($accept_id == null) {
            $response['success'] = false;
            $response['messages']['edit_service_no'] = '<p class="text-danger"> Please select at least one Item </p>';
            echo json_encode($response);
            die();
        }

        for ($i = 0; $i < sizeof($header_id); $i++) {
            $sub_data = array(
                'remarks' => $remarks[$i],
                'updated_by' => $this->session->userdata('id'),
                'updated_at' => date('Y-m-d H:i:s')
            );

            $this->db->where('id', $header_id[$i]);
            $this->db->update('machine_service_returned_accepted_items_header', $sub_data);
        }

        for ($i = 0; $i < sizeof($accept_id); $i++) {
            if ($qty[$i] > 0) {
                $sub_data = array(
                    'qty' => $qty[$i],
                    'updated_by' => $this->session->userdata('id'),
                    'updated_at' => date('Y-m-d H:i:s')
                );

                $this->db->where('id', $accept_id[$i]);
                $this->db->update('machine_service_returned_accepted_items', $sub_data);
            }
        }

        $response['success'] = true;
        $response['messages'] = 'Successfully updated';


        echo json_encode($response);
    }

    public function remove_return_to_stock_accept()
    {
        if (!in_array('deleteMachineServiceItemReturnAccept', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $this->form_validation->set_rules('id', 'ID', 'trim|required');

        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run() == TRUE) {

            $id = $this->input->post('id');

            $data = array(
                'is_deleted' => 1,
                'deleted_by' => $this->session->userdata('id'),
                'deleted_at' => date('Y-m-d H:i:s')
            );

            $this->db->where('id', $id);
            $this->db->update('machine_service_returned_accepted_items', $data);

            $sql = "SELECT machine_service_id FROM
                        machine_service_returned_items msai 
                        WHERE id = '$id'
                ";
            $query = $this->db->query($sql);
            $sc = $query->row_array();

            $response['service_id'] = $sc['machine_service_id'];
            $response['success'] = true;
            $response['messages'] = 'Successfully updated';

        } else {
            $response['success'] = false;
            foreach ($_POST as $key => $value) {
                $response['messages'][$key] = form_error($key);
            }
        }

        echo json_encode($response);
    }

    public function return_to_supplier()
    {
        if (!in_array('viewSparePartReturnToSupplier', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $this->data['js'] = 'application/views/MachineServices/MachineServices/return_to_supplier-js.php';
        $this->render_template('MachineServices/MachineServices/return_to_supplier', $this->data);
    }

    public function fetchCategoryData_return_to_supplier()
    {
        if (!in_array('viewSparePartReturnToSupplier', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());

        $data = $this->model_machine_services->getMachineServicesData_return_to_supplier();

        foreach ($data as $key => $value) {
            // button
            $buttons = '';

            $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="viewFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#viewModal"><i class="fas fa-eye text-info"></i></button>';

            if (in_array('updateSparePartReturnToSupplier', $this->permission)) {
                $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="editFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#editModal"><i class="text-primary fa fa-edit"></i></button>';
            }

            if (in_array('deleteSparePartReturnToSupplier', $this->permission)) {
                $buttons .= ' <button type="button" class="btn btn-default btn-sm" onclick="removeFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#removeModal"><i class="text-danger fa fa-trash"></i></button>';
            }

            $status = ($value['is_approved'] == 1) ? '<span class="badge badge-success btn-sm">Yes</span>' : '<span class="badge badge-danger">No</span>';

            $id = $value['id'];


            $result['data'][$key] = array(
                $value['suppliername'],
                $value['date'],
                $status,
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }

    public function fetchReturnToSupplierServiceItems($id)
    {
        $sql = "SELECT sp.*, rts.qty, rts.id as return_id, sp.unit_price
                    FROM return_to_supplier rts 
                    LEFT JOIN spare_parts sp ON sp.id = rts.spare_part_id 
                    WHERE rts.header_id = '$id' 
                    AND rts.is_deleted = 0
                    ";
        $query = $this->db->query($sql);
        $data['sc'] = $query->result_array();

        $data['main_data'] = $this->model_machine_services->getMachineServicesData_return_to_supplier($id);

        echo json_encode($data);
    }

    public function create_return_to_supplier()
    {
        if (!in_array('createSparePartReturnToSupplier', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $this->form_validation->set_rules('supplier_id', 'Supplier', 'trim|required');
        $this->form_validation->set_rules('date', 'Date', 'trim|required');

        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if ($this->form_validation->run() == TRUE) {

            $sp = $this->input->post('sp_id[]');
            $qty = $this->input->post('qty[]');

            if ($sp == null) {
                $response['success'] = false;
                $response['messages']['spare_part_id'] = '<p class="text-danger"> Please select at least one Item </p>';
                echo json_encode($response);
                die();
            }

            $this->db->trans_start();

            $data = array(
                'supplier_id' => $this->input->post('supplier_id'),
                'date' => $this->input->post('date'),
                'remarks' => $this->input->post('remarks'),
                'created_by' => $this->session->userdata('id'),
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->db->insert('return_to_supplier_header', $data);

            $sp_id = $this->db->insert_id();

            $data = array();
            for ($i = 0; $i < count($sp); $i++) {

                $data[] = array(
                    'header_id' => $sp_id,
                    'spare_part_id' => $sp[$i],
                    'qty' => $qty[$i],
                );
            }

            $sps_create = $this->db->insert_batch('return_to_supplier', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() == true) {
                $response['success'] = true;
                $response['messages'] = 'Successfully created';
            } else {
                $response['success'] = false;
                $response['messages'] = 'Error in the database while creating the operation';
            }
        } else {
            $response['success'] = false;
            foreach ($_POST as $key => $value) {
                $response['messages'][$key] = form_error($key);
            }
        }

        echo json_encode($response);
    }

    public function update_return_to_supplier($id)
    {
        if (!in_array('updateSparePartReturnToSupplier', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        if ($id) {
            $this->form_validation->set_rules('edit_supplier_id', 'Supplier', 'trim|required');
            $this->form_validation->set_rules('edit_date', 'Date', 'trim|required');

            $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

            if ($this->form_validation->run() == TRUE) {

                $estimated_service_items = $this->input->post('sp_id[]');
                $qty = $this->input->post('qty[]');

                if ($estimated_service_items == null) {
                    $response['success'] = false;
                    $response['messages']['edit_spare_part_id'] = '<p class="text-danger"> Please select at least one Item </p>';
                    echo json_encode($response);
                    die();
                }

                $data = array(
                    'supplier_id' => $this->input->post('edit_supplier_id'),
                    'date' => $this->input->post('edit_date'),
                    'remarks' => $this->input->post('edit_remarks'),
                    'updated_by' => $this->session->userdata('id'),
                    'updated_at' => date('Y-m-d H:i:s')
                );

                $this->db->where('id', $id);
                $this->db->update('return_to_supplier_header', $data);

                    $this->db->where('header_id', $id);
                    $delete = $this->db->delete('return_to_supplier');

                    $sub_data = array();
                    for ($i = 0; $i < sizeof($estimated_service_items); $i++) {
                        $sub_data[] = array(
                            'spare_part_id' => $estimated_service_items[$i],
                            'header_id' => $id,
                            'qty' => $qty[$i],
                        );
                    }
                    $sps_create = $this->db->insert_batch('return_to_supplier', $sub_data);

                    $response['success'] = true;
                    $response['messages'] = 'Successfully updated';

            } else {
                $response['success'] = false;
                foreach ($_POST as $key => $value) {
                    $response['messages'][$key] = form_error($key);
                }
            }
        } else {
            $response['success'] = false;
            $response['messages'] = 'Error please refresh the page again!!';
        }

        echo json_encode($response);
    }

    public function remove_return_to_supplier()
    {
        if (!in_array('deleteSparePartReturnToSupplier', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $machine_service_id = $this->input->post('machine_service_id');

        $response = array();
        if ($machine_service_id) {
            $data = array(
                'is_deleted' => 1,
                'deleted_by' => $this->session->userdata('id'),
                'deleted_at' => date('Y-m-d H:i:s')
            );

            $this->db->where('id', $machine_service_id);
            $this->db->update('return_to_supplier_header', $data);

            $response['success'] = true;
            $response['messages'] = "Successfully removed";

        } else {
            $response['success'] = false;
            $response['messages'] = "Refresh the page again!!";
        }

        echo json_encode($response);
    }


    public function return_to_supplier_approve_front()
    {
        if (!in_array('createSparePartReturnToSupplierApprove', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $this->data['js'] = 'application/views/MachineServices/MachineServices/return_to_supplier_approve-js.php';
        $this->render_template('MachineServices/MachineServices/return_to_supplier_approve', $this->data);
    }

    public function return_to_supplier_fetchDataApprove(){
        if (!in_array('createSparePartReturnToSupplierApprove', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());
        $data = $this->model_machine_services->getMachineServicesData_return_to_supplier_approve();

        foreach ($data as $key => $value) {

            // button
            $buttons = ''; 
            $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="viewFunc(' . $value['id'] . ')" data-toggle="modal" data-target="#viewModal"><i class="fas fa-eye text-info"></i></button>';

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
                $value['suppliername'],
                $value['date'],
                $approved_label,
                $value['remarks'],
                $buttons
            );
        } // /foreach

        echo json_encode($result);

    }

    public function return_to_supplier_approve()
    {

        $id = $this->input->post('id');

        if (empty($id)) {
            $response['status'] = false;
            $response['msg'] = '<p class="text-danger"> Please select at least one record </p>';
            echo json_encode($response);
            die();
        }

        $data =  array(
            'is_approved' => 1,
            'approved_by' => $this->session->userdata('id'),
            'approved_at' => date('Y-m-d H:i:s')
        );

        $this->db->where('id', $id);
        $this->db->update('return_to_supplier_header', $data);

        $response['status'] = true;
        $response['msg'] = 'Successfully Updated';

        echo json_encode($response);

    }

    public function fetchViewStock($sp_id){

        $sql1 = "SELECT sp.*, msei.qty, msei.id as allocate_id, msei.created_at, msei2.qty as estimated_qty, sp.unit_price, ms.service_no, msei.qty as allocated_qty
                    FROM machine_service_allocated_items msei 
                    LEFT JOIN machine_services ms ON ms.id = msei.machine_service_id
                    LEFT JOIN machine_service_estimated_items msei2 ON msei2.id = msei.estimate_id
                    LEFT JOIN spare_parts sp ON sp.id = msei.spare_part_id 
                    WHERE msei.spare_part_id = '$sp_id' 
                    AND msei.is_deleted = 0
                    AND msei.is_finished = 0
                    ";
        $query1 = $this->db->query($sql1);
        $data['ac'] = $query1->result_array();

        $data['main_data'] = $this->model_spare_parts->getSparePartsData($sp_id);

        echo json_encode($data);
    }


}