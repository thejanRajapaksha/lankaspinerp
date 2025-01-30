<?php

class Model_onloan_issue_machines extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create($data = array())
    {
        if($data) {
            $create = $this->db->insert('machine_request_onloan_issue_machines', $data);
            return ($create == true) ? true : false;
        }
    }

    //getMachineOnLoanRequestsData
    public function getMachineOnLoanRequestsData($id = null)
    {
        if($id) {
            $sql = "SELECT machine_req.unique_id, request_date 
            FROM machine_request_onloan_issue_machines as mroim 
            LEFT JOIN machine_requests as machine_req ON mroim.machine_request_id = machine_req.id
            LEFT JOIN machine_models as m on m.id = machine_req.machine_model_id
            LEFT JOIN machine_types mt on machine_req.machine_type_id = mt.id 
            WHERE machine_req.unique_id = ?";

            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }

        $sql = "SELECT machine_req.unique_id, machine_req.request_date,
                machine_request_id, machine_req.approved_quantity,
                COUNT(mroim.id) as total_requests
            FROM machine_request_onloan_issue_machines as mroim 
            LEFT JOIN machine_requests as machine_req ON mroim.machine_request_id = machine_req.id
            LEFT JOIN machine_models as m on m.id = machine_req.machine_model_id
            LEFT JOIN machine_types mt on machine_req.machine_type_id = mt.id
            GROUP BY mroim.machine_request_id
            ORDER BY mroim.machine_request_id
            DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    //getMachineOnLoanRequestsByUniqueId
    public function getMachineOnLoanRequestsByMachineRequestId($machine_request_id)
    {
        $sql = "SELECT mroim.*, m.name as machine_model_name, mt.name as machine_type_name,
            mi.s_no
            FROM machine_request_onloan_issue_machines as mroim 
            LEFT JOIN machine_requests AS machine_req ON mroim.machine_request_id = machine_req.id
            LEFT JOIN machine_models as m on m.id = machine_req.machine_model_id
            LEFT JOIN machine_types mt on machine_req.machine_type_id = mt.id 
            LEFT JOIN machine_ins as mi ON mroim.machine_in_id = mi.id
            WHERE machine_req.id = ? ";

        $query = $this->db->query($sql, array($machine_request_id));
        return $query->result_array();
    }

}


