<?php
class MachineRentRequestReceiveMachine extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Machine Request Receive Machine';
        $this->load->model('model_machine_request_receive_machines');
        $this->load->model('model_machine_requests');
        $this->load->model('model_rent_requests');

    }

    public function index()
    {
        if(!in_array('viewMachineRentRequestReceiveMachine', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $this->data['js'] = 'application/views/machines/MachineRentRequestReceiveMachines/index-js.php';
        $this->render_template('machines/MachineRentRequestReceiveMachines/index', $this->data);
    }

    public function create()
    {
        //createMachineOnLoanRequest
        if(!in_array('createMachineRentRequestReceiveMachine', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $ids = $this->input->post('checked_id');
        $remarks = $this->input->post('remarks');

        $inserted = true;

        $unique_id = date("Ymds");

        foreach ($ids as $id) {

            $rent_request_id = $id['rent_request_id'];
            $quantity = $id['quantity'];
            $rent = $id['rent'];

            $data = array(
                'rent_request_id' => $rent_request_id,
                'unique_id' => $unique_id,
                'quantity' => $quantity,
                'rent' => $rent,
                'remarks' => $remarks,
                'created_by' => $this->session->userdata('id'),
                'created_at' => date('Y-m-d H:i:s'),
                'received_date' => date('Y-m-d H:i:s')
            );

            $inserted = $this->model_machine_request_receive_machines->create($data);

        }

        if($inserted == true) {
            $response['success'] = true;
            $response['messages'] = 'Successfully created';
        }
        else {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while creating the information';
        }

        echo json_encode($response);

    }

    public function fetchCategoryData()
    {
        if(!in_array('viewMachineRentRequestReceiveMachine', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());

        $data = $this->model_machine_request_receive_machines->getMachineRentRequestReceiveMachinesData();

        foreach ($data as $key => $value) {

            // button
            $buttons = '';

            $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="viewFunc('.$value['unique_id'].', '.$value['machine_type_id'].'  )" data-toggle="modal" data-target="#viewModal"><i class="fas fa-eye text-info"></i></button>';

//            if(in_array('updateMachineRequest', $this->permission)) {
//                $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="editFunc('.$value['unique_id'].')" data-toggle="modal" data-target="#editModal"><i class="text-primary fa fa-edit"></i></button>';
//            }
//
//            if(in_array('deleteMachineRequest', $this->permission)) {
//                $buttons .= '<button type="button" class="btn btn-default btn-sm" onclick="removeFunc('.$value['unique_id'].')" data-toggle="modal" data-target="#removeModal"><i class="text-danger fa fa-trash"></i></button>';
//            }

            $machine_type_id = $value['machine_type_id'];
            $request_id = $value['unique_id'];

            $sql = 'SELECT SUM(mrr.quantity) as total_quantity
            FROM machine_rent_requests as mrr 
            LEFT JOIN machine_requests as mr ON mrr.machine_request_id = mr.id
            WHERE mr.machine_type_id = ?
            AND mrr.unique_id = ?
            ';
            $query = $this->db->query($sql, array($machine_type_id, $request_id));
            $rr_data = $query->row_array();
            $total_requested_machines = $rr_data['total_quantity'];

            $sql = 'SELECT SUM(mrrrm.quantity) as total_quantity
            FROM machine_rent_requests_receive_machines as mrrrm 
            LEFT JOIN machine_rent_requests as mrr ON mrr.id = mrrrm.rent_request_id
            LEFT JOIN machine_requests as mr ON mrr.machine_request_id = mr.id
            WHERE mr.machine_type_id = ?
            AND mrr.unique_id = ?
            ';
            $query = $this->db->query($sql, array($machine_type_id, $request_id));
            $rr_data = $query->row_array();
            $total_received_machines = $rr_data['total_quantity'];

            $sql = 'SELECT SUM(mrrrmr.quantity) as total_quantity
            FROM machine_rent_requests_receive_machine_returns as mrrrmr 
            LEFT JOIN machine_rent_requests_receive_machines as mrrrm ON mrrrm.id = mrrrmr.rent_request_receive_id
            LEFT JOIN machine_rent_requests as mrr ON mrr.id = mrrrm.rent_request_id
            LEFT JOIN machine_requests as mr ON mrr.machine_request_id = mr.id
            WHERE mr.machine_type_id = ?
            AND mrr.unique_id = ?
            ';
            $query = $this->db->query($sql, array($machine_type_id, $request_id));
            $rr_data = $query->row_array();
            $total_returned_machines = $rr_data['total_quantity'];

            $result['data'][$key] = array(
                $value['unique_id'],
                $value['machine_type_name'],
                $total_requested_machines,
                $total_received_machines,
                $total_returned_machines,
                $buttons
            );
        } // /foreach

        echo json_encode($result);
    }

    //fetchMachineRentRequestReceiveMachineByUniqueId
    public function fetchMachineRentRequestReceiveMachineByUniqueId()
    {
        if(!in_array('viewMachineRentRequestReceiveMachine', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $unique_id = $this->input->post('unique_id');
        $machine_type_id = $this->input->post('machine_type_id');

        $received_machines = $this->model_machine_request_receive_machines->getMachineRentRequestReceiveMachinesByUniqueId($unique_id, $machine_type_id);
        $received_machine =  $unique_id;

        $result = array('received_machines' => $received_machines, 'received_machine' => $received_machine);

        echo json_encode($result);

    }

    public function returnMachineRequests()
    {
        if(!in_array('createMachineRentRequestReceiveMachineReturn', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $response = array();

        $ids = $this->input->post('checked_id');

        $unique_id = date("Ymds");

        $inserted = true;

        foreach ($ids as $id) {

            $data = array(
                'rent_request_receive_id' => $id['id'],
                'quantity' => $id['quantity'],
                'unique_id' => $unique_id,
                'return_date' => date('Y-m-d'),
                'created_by' => $this->session->userdata('id'),
                'created_at' => date('Y-m-d H:i:s')
            );

            $inserted = $this->model_machine_request_receive_machines->create_return($data);

        }

        if($inserted == true) {
            $response['success'] = true;
            $response['messages'] = 'Successfully created';
            $response['unique_id'] = $unique_id;

        }
        else {
            $response['success'] = false;
            $response['messages'] = 'Error in the database while creating the information';
        }

        echo json_encode($response);

    }

}