<?php

class Model_machine_requests extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getMachineRequestsData($id = null)
    {
        if($id) {
            $sql = "SELECT machine_req.unique_id, request_date 
            FROM machine_requests as machine_req
            LEFT JOIN machine_models as m on m.id = machine_req.machine_model_id
            LEFT JOIN machine_types mt on machine_req.machine_type_id = mt.id 
            WHERE machine_req.id = ?";
             
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }

        $sql = "SELECT machine_req.unique_id, request_date,
                COUNT(machine_req.id) as total_requests
            FROM machine_requests as machine_req
            LEFT JOIN machine_models as m on m.id = machine_req.machine_model_id
            LEFT JOIN machine_types mt on machine_req.machine_type_id = mt.id
            GROUP BY machine_req.unique_id
            ORDER BY machine_req.unique_id 
            DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getMachineRequestsByUniqueId($unique_id)
    {
        $sql = "SELECT machine_req.*, m.name as machine_model_name, mt.name as machine_type_name
            FROM machine_requests as machine_req
            LEFT JOIN machine_models as m on m.id = machine_req.machine_model_id
            LEFT JOIN machine_types mt on machine_req.machine_type_id = mt.id 
            WHERE machine_req.unique_id = ? ";

        $query = $this->db->query($sql, array($unique_id));
        return $query->result_array();
    }

    public function getMachineRequestByUniqueId($unique_id)
    {
        $sql = "SELECT machine_req.*, m.name as machine_model_name, mt.name as machine_type_name
            FROM machine_requests as machine_req
            LEFT JOIN machine_models as m on m.id = machine_req.machine_model_id
            LEFT JOIN machine_types mt on machine_req.machine_type_id = mt.id 
            WHERE machine_req.unique_id = ?
            LIMIT 1";

        $query = $this->db->query($sql, array($unique_id));
        return $query->row_array();
    }

    public function create($data = array())
    {
        if($data) {
            $create = $this->db->insert('machine_requests', $data);
            return ($create == true) ? true : false;
        }
    }

    public function update($id = null, $data = array())
    {
        if($id && $data) {
            $this->db->where('id', $id);
            $update = $this->db->update('machine_requests', $data);
            return ($update == true) ? true : false;
        }
    }

    public function update_on_loan_request($id = null, $data = array())
    {
        if($id && $data) {
            $this->db->where('id', $id);
            $update = $this->db->update('machine_request_onloan_issue_machines', $data);
            return ($update == true) ? true : false;
        }
    }

    //checkIfApproved
    public function checkIfApproved($id)
    {
        $sql = "SELECT * FROM machine_requests WHERE id = ? AND is_approved = 1";
        $query = $this->db->query($sql, array($id));
        return $query->row_array();
    }

    public function remove($id = null)
    {
        if($id) {
            $this->db->where('id', $id);
            $delete = $this->db->delete('style_colors');
            return ($delete == true) ? true : false;
        }

        return false;
    }

    public function getActiveMachineRequests()
    {
        $sql = "SELECT * FROM style_colors WHERE active = ?";
        $query = $this->db->query($sql, array(1));
        return $query->result_array();
    }

    public function countTotalMachineRequests()
    {
        $sql = "SELECT * FROM style_colors WHERE active = ?";
        $query = $this->db->query($sql, array(1));
        return $query->num_rows();
    }
}