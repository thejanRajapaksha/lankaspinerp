<?php
class Model_machine_request_receive_machines extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create($data = array())
    {
        if($data) {
            $insert = $this->db->insert('machine_rent_requests_receive_machines', $data);
            return $insert;
        }
    }

    public function getMachineRentRequestReceiveMachinesData($id = null)
    {
        if($id) {
            $sql = "SELECT mrrrm.unique_id, mrrrm.received_date 
            FROM machine_rent_requests_receive_machines as mrrrm 
            LEFT JOIN machine_rent_requests as mrr on mrr.id = mrrrm.rent_request_id
            LEFT JOIN machine_requests as machine_req on machine_req.id = mrr.machine_request_id 
            LEFT JOIN machine_models as m on m.id = machine_req.machine_model_id
            LEFT JOIN machine_types mt on machine_req.machine_type_id = mt.id 
            WHERE mrrrm.id = ?";

            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }

        $sql = "SELECT mrr.unique_id, 
                mt.name as machine_type_name,
                mt.id as machine_type_id,
                mrrrm.unique_id as received_id,
                COUNT(mrrrm.id) as total_receives 
            FROM machine_rent_requests_receive_machines as mrrrm 
            LEFT JOIN machine_rent_requests as mrr on mrr.id = mrrrm.rent_request_id
            LEFT JOIN machine_requests as machine_req on machine_req.id = mrr.machine_request_id 
            LEFT JOIN machine_models as m on m.id = machine_req.machine_model_id
            LEFT JOIN machine_types mt on machine_req.machine_type_id = mt.id 
            GROUP BY mrr.unique_id, machine_req.machine_type_id  
            ORDER BY mrr.unique_id 
            DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    //getMachineRentRequestReceiveMachineByUniqueId
    public function getMachineRentRequestReceiveMachinesByUniqueId($unique_id, $machine_type_id)
    {
        $sql = "SELECT mrrrm.*, m.name as machine_model_name, mt.name as machine_type_name
            FROM machine_rent_requests_receive_machines as mrrrm 
            LEFT JOIN machine_rent_requests as mrr on mrr.id = mrrrm.rent_request_id
            LEFT JOIN machine_requests as machine_req on machine_req.id = mrr.machine_request_id  
            LEFT JOIN machine_models as m on m.id = machine_req.machine_model_id
            LEFT JOIN machine_types mt on machine_req.machine_type_id = mt.id 
            WHERE mrr.unique_id = ? 
            AND mt.id = ?
            ";

        $query = $this->db->query($sql, array($unique_id, $machine_type_id));
        return $query->result_array();
    }

    public function getMachineRentRequestReceiveMachineByUniqueId($unique_id)
    {

    }

    public function create_return($data = array())
    {
        if($data) {
            $insert = $this->db->insert('machine_rent_requests_receive_machine_returns', $data);
            return $insert;
        }
    }

}
