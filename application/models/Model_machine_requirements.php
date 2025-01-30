<?php

class Model_machine_requirements extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getMachineRequirementsData($id = null)
    {
        if($id) {
            $sql = "SELECT machine_req.unique_id, request_date 
            FROM machine_requirements as machine_req
            LEFT JOIN machine_models as m on m.id = machine_req.machine_model_id
            LEFT JOIN machine_types mt on machine_req.machine_type_id = mt.id 
            WHERE machine_req.id = ?";
             
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }

        $sql = "SELECT machine_req.unique_id, request_date,
                COUNT(machine_req.id) as total_requests,
                machine_req.forecast, 
                l.line_name as line_name,
                s.name as section_name,
                d.name as department_name,
                f.br_name as factory_name
            FROM machine_requirements as machine_req
            LEFT JOIN machine_models as m on m.id = machine_req.machine_model_id
            LEFT JOIN machine_types mt on machine_req.machine_type_id = mt.id
             LEFT JOIN mlinelist l on l.id = machine_req.line_id
            LEFT JOIN sections s ON s.id = l.section
            LEFT JOIN departments d ON d.id = s.department
            LEFT JOIN mbranchlist f on d.factory_id = f.id 
            GROUP BY machine_req.unique_id
            ORDER BY machine_req.unique_id 
            DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getMachineRequirementsByUniqueId($unique_id)
    {
        $sql = "SELECT machine_req.*, m.name as machine_model_name, mt.name as machine_type_name
            FROM machine_requirements as machine_req
            LEFT JOIN machine_models as m on m.id = machine_req.machine_model_id
            LEFT JOIN machine_types mt on machine_req.machine_type_id = mt.id 
            WHERE machine_req.unique_id = ? ";

        $query = $this->db->query($sql, array($unique_id));
        return $query->result_array();
    }

    public function getMachineRequirementByUniqueId($unique_id)
    {
        $sql = "SELECT machine_req.*, m.name as machine_model_name, mt.name as machine_type_name
            FROM machine_requirements as machine_req
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
            $create = $this->db->insert('machine_requirements', $data);
            return ($create == true) ? true : false;
        }
    }

    public function update($id = null, $data = array())
    {
        if($id && $data) {
            $this->db->where('id', $id);
            $update = $this->db->update('machine_requirements', $data);
            return ($update == true) ? true : false;
        }
    }

    //checkIfApproved
    public function checkIfApproved($id)
    {
        $sql = "SELECT * FROM machine_requirements WHERE id = ? AND is_approved = 1";
        $query = $this->db->query($sql, array($id));
        return $query->row_array();
    }

    public function remove($id = null)
    {
        if($id) {
            $this->db->where('id', $id);
            $delete = $this->db->delete('machine_requirements');
            return ($delete == true) ? true : false;
        }

        return false;
    }
}