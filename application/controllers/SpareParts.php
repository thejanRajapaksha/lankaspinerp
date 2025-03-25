<?php

class SpareParts extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Spare Parts';
        $this->load->model('model_spare_parts');

    }

    public function index()
    {
        if(!in_array('viewSparePart', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->data['js'] = 'application/views/SpareParts/index-js.php';
        $this->render_template('SpareParts/index', $this->data);
    }

    // public function fetchCategoryData()
    // {
    //     if(!in_array('viewSparePart', $this->permission)) {
    //         redirect('dashboard', 'refresh');
    //     }

    //     $result = array('data' => array());

    //     $data = $this->model_spare_parts->getSparePartsData();

    //     foreach ($data as $key => $value) {
    //         // button
    //         $buttons = '';

    //         if(in_array('updateSparePart', $this->permission)) {
    //             $buttons = '<button type="button" class="btn btn-default btn-sm" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal"><i class="text-primary fa fa-edit"></i></button>';
    //         }

    //         if(in_array('deleteSparePart', $this->permission)) {
    //             $buttons .= ' <button type="button" class="btn btn-default btn-sm" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="text-danger fa fa-trash"></i></button>';
    //         }

    //         $status = ($value['active'] == 1) ? '<span class="badge badge-success ">Active</span>' : '<span class="badge badge-warning">Inactive</span>';

    //         $id = $value['id'];

    //         $sql = "SELECT ts.suppliername as sup_name 
    //                 FROM spare_parts sp
    //                 LEFT JOIN spare_part_suppliers sps ON sps.sp_id = sp.id 
    //                 LEFT JOIN tbl_supplier ts ON ts.idtbl_supplier = sps.supplier_id 
    //                 WHERE sps.sp_id = '$id' 
    //                 ";
    //         $query = $this->db->query($sql);
    //         $sc = $query->result_array();

    //         $sc_label = '';
    //         foreach ($sc as $s){
    //             $sc_label .= ' <badge class="badge badge-info"> '.$s['sup_name'].' </badge>';
    //         }

    //         $result['data'][$key] = array(
    //             $value['name'],
    //             $value['machine_model'],
    //             $value['machine_type_name'],
    //             $sc_label,
    //             $value['part_no'],
    //             $value['rack_no'],
    //             $value['unit_price'],
    //             $status,
    //             $buttons
    //         );
    //     } // /foreach

    //     echo json_encode($result);
    // }

    public function create()
    {
        if(!in_array('createSparePart', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $this->form_validation->set_rules('name', 'Spare Part Name', 'trim|required');
        $this->form_validation->set_rules('machine_type_id', 'Machine Type', 'trim|required');
        $this->form_validation->set_rules('machine_model_id', 'Machine Model', 'trim|required');
        $this->form_validation->set_rules('part_no', 'Part No', 'trim|required');
        $this->form_validation->set_rules('unit_price', 'Unit Price', 'trim|required');
        $this->form_validation->set_rules('active', 'Active', 'trim|required');

        $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {

            $supplier_id = $this->input->post('supplier_id[]');

            if($supplier_id == null){
                $response['success'] = false;
                $response['messages']['supplier_id'] = '<p class="text-danger"> Please select at least one Supplier </p>';
                echo json_encode($response);
                die();
            }

            $this->db->trans_start();

            $data = array(
                'name' => $this->input->post('name'),
                'type' => $this->input->post('machine_type_id'),
                'model' => $this->input->post('machine_model_id'),
                'part_no' => $this->input->post('part_no'),
                'unit_price' => $this->input->post('unit_price'),
                'rack_no' => $this->input->post('rack_no'),
                'active' => $this->input->post('active'),
            );
            $create = $this->model_spare_parts->create($data);

            $sp_id = $this->db->insert_id();

            $data = array();
            for ($i=0; $i < count($supplier_id); $i++) {

                $data[] = array(
                    'sp_id' => $sp_id,
                    'supplier_id' => $supplier_id[$i]
                );
            }

            $sps_create = $this->db->insert_batch('spare_part_suppliers', $data);

            $this->db->trans_complete();

            if($this->db->trans_status() == true) {
                $response['success'] = true;
                $response['messages'] = 'Successfully created';
            }
            else {
                $response['success'] = false;
                $response['messages'] = 'Error in the database while creating the operation breakdown information';
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

    public function fetchSparePartsDataById($id = null)
    {
        if($id) {
            $data['main_data'] = $this->model_spare_parts->getSparePartsData($id);

            $sql = "SELECT ts.suppliername as sup_name, ts.idtbl_supplier as id 
                    FROM spare_parts sp
                    LEFT JOIN spare_part_suppliers sps ON sps.sp_id = sp.id 
                    LEFT JOIN tbl_supplier ts ON ts.idtbl_supplier = sps.supplier_id 
                    WHERE sps.sp_id = '$id' 
                    ";
            $query = $this->db->query($sql);
            $data['sc'] = $query->result_array();

            echo json_encode($data);
        }

    }

    public function update($id)
    {
        if(!in_array('updateSparePart', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        if($id) {
            $this->form_validation->set_rules('edit_name', 'Spare Part Name', 'trim|required');
            $this->form_validation->set_rules('edit_machine_type_id', 'Machine Type', 'trim|required');
            $this->form_validation->set_rules('edit_machine_model_id', 'Machine Model', 'trim|required');
            $this->form_validation->set_rules('edit_part_no', 'Part No', 'trim|required');
            $this->form_validation->set_rules('edit_unit_price', 'Unit Price', 'trim|required');
            $this->form_validation->set_rules('edit_active', 'Active', 'trim|required');

            $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

            if ($this->form_validation->run() == TRUE) {

                $supplier_id = $this->input->post('edit_supplier_id[]');
                if($supplier_id == null){
                    $response['success'] = false;
                    $response['messages']['edit_supplier_id'] = '<p class="text-danger"> Please select at least one Supplier </p>';
                    echo json_encode($response);
                    die();
                }

                $data = array(
                    'name' => $this->input->post('edit_name'),
                    'type' => $this->input->post('edit_machine_type_id'),
                    'model' => $this->input->post('edit_machine_model_id'),
                    'part_no' => $this->input->post('edit_part_no'),
                    'unit_price' => $this->input->post('edit_unit_price'),
                    'rack_no' => $this->input->post('edit_rack_no'),
                    'active' => $this->input->post('edit_active'),
                );

                $update = $this->model_spare_parts->update($id, $data);
                if($update == true) {

                    $this->db->where('sp_id', $id);
                    $delete = $this->db->delete('spare_part_suppliers');

                    $sub_data = array();
                    for($i = 0; $i < sizeof($supplier_id); $i++  ){
                        $sub_data[] = array(
                            'supplier_id' => $supplier_id[$i],
                            'sp_id' => $id
                        );
                    }
                    $sps_create = $this->db->insert_batch('spare_part_suppliers', $sub_data);

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
        if (!in_array('deleteSparePart', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
    
        $machine_type_id = $this->input->post('machine_type_id');
    
        $response = array();
    
        if ($machine_type_id) {
            $data = array(
                'is_deleted' => 1,
                'deleted_by' => $this->session->userdata('id'),
                'deleted_at' => date('Y-m-d H:i:s')
            );
    
            $delete = $this->model_spare_parts->update($machine_type_id, $data);
    
            if ($delete) {
                $response['success'] = true;
                $response['messages'] = "Successfully removed";
            } else {
                $response['success'] = false;
                $response['messages'] = "Database error while removing the record";
            }
        } else {
            $response['success'] = false;
            $response['messages'] = "Refresh the page and try again!";
        }
    
        echo json_encode($response);
        exit;
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
            $data = $this->model_spare_parts->getSparePartsData($id);
            echo json_encode($data);
        }

    }



}