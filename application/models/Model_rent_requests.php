<?php

class Model_rent_requests extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create($data = array())
    {
        if($data) {
            $create = $this->db->insert('machine_rent_requests', $data);
            return ($create == true) ? true : false;
        }
    }

    //checkIfAlreadyRentedAndApproved
    public function checkIfAlreadyRented($id)
    {
        $this->db->select('*');
        $this->db->from('machine_rent_requests');
        $this->db->where('machine_request_id', $id);
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function getMachineRentRequestsData($id = null)
    {
        if($id) {
            $sql = "SELECT mrr.unique_id, mrr.request_date 
            FROM machine_rent_requests as mrr
            LEFT JOIN machine_requests as mr ON mrr.machine_request_id = mr.id 
            LEFT JOIN machine_models as m on m.id = mr.machine_model_id
            LEFT JOIN machine_types mt on mr.machine_type_id = mt.id 
            WHERE mrr.unique_id = ?
            AND mrr.is_deleted = 0
            ";

            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }

        $sql = "SELECT mrr.unique_id, mrr.request_date,
                COUNT(mrr.id) as total_requests
            FROM machine_rent_requests as mrr
            LEFT JOIN machine_requests as mr ON mrr.machine_request_id = mr.id 
            LEFT JOIN machine_models as m on m.id = mr.machine_model_id
            LEFT JOIN machine_types mt on mr.machine_type_id = mt.id 
            GROUP BY mrr.unique_id
            ORDER BY mrr.unique_id 
            DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getMachineRentRequestsByUniqueId($unique_id)
    {
        $sql = "SELECT mrr.*, m.name as machine_model_name, mt.name as machine_type_name
            FROM machine_rent_requests as mrr
            LEFT JOIN machine_requests as machine_req ON mrr.machine_request_id = machine_req.id 
            LEFT JOIN machine_models as m on m.id = machine_req.machine_model_id
            LEFT JOIN machine_types mt on machine_req.machine_type_id = mt.id 
            WHERE mrr.unique_id = ? ";

        $query = $this->db->query($sql, array($unique_id));
        return $query->result_array();
    }

    public function getMachineRentRequestByUniqueId($unique_id)
    {
        $sql = "SELECT mrr.*, m.name as machine_model_name, mt.name as machine_type_name
            FROM machine_rent_requests as mrr
            LEFT JOIN machine_requests as machine_req ON mrr.machine_request_id = machine_req.id 
            LEFT JOIN machine_models as m on m.id = machine_req.machine_model_id
            LEFT JOIN machine_types mt on machine_req.machine_type_id = mt.id 
            WHERE mrr.unique_id = ?
            LIMIT 1";

        $query = $this->db->query($sql, array($unique_id));
        return $query->row_array();
    }

}


