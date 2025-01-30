<?php

class Model_machine_operation_desc extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getMachineOperationDescData($id = null)
    {
        if($id) {
            $sql = "SELECT mod1.*, 
                 mt.name as machine_type_name,
                c.name as criticality_name,
                u1.name_with_initial as created_by_name,
                u2.name_with_initial as approved_by_name,
                mv.name as value_name
            FROM machine_operation_desc mod1 
            LEFT JOIN machine_types mt ON mod1.machine_type_id = mt.id 
            LEFT JOIN criticalities c ON c.id = mod1.criticality_id
            LEFT JOIN employees u1 ON u1.id = mod1.created_by
            LEFT JOIN employees u2 ON u2.id = mod1.approved_by 
            LEFT JOIN mod_values mv ON mv.id = mod1.value_id
            WHERE mod1.id = ?";
             
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }

        $sql = "SELECT mod1.*, 
                 mt.name as machine_type_name,
                c.name as criticality_name,
                u1.name_with_initial as created_by_name,
                u2.name_with_initial as approved_by_name,
                mv.name as value_name
            FROM machine_operation_desc mod1 
            LEFT JOIN machine_types mt ON mod1.machine_type_id = mt.id 
            LEFT JOIN criticalities c ON c.id = mod1.criticality_id
            LEFT JOIN employees u1 ON u1.id = mod1.created_by
            LEFT JOIN employees u2 ON u2.id = mod1.approved_by 
            LEFT JOIN mod_values mv ON mv.id = mod1.value_id
            WHERE mod1.is_deleted = 0
            ORDER BY mod1.id DESC
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getMachineOperationDescDataApprove()
    {
        $sql = "SELECT mod1.*, 
                 mt.name as machine_type_name,
                c.name as criticality_name,
                u1.name_with_initial as created_by_name,
                u2.name_with_initial as approved_by_name,
                mv.name as value_name
            FROM machine_operation_desc mod1 
            LEFT JOIN machine_types mt ON mod1.machine_type_id = mt.id 
            LEFT JOIN criticalities c ON c.id = mod1.criticality_id
            LEFT JOIN employees u1 ON u1.id = mod1.created_by
            LEFT JOIN employees u2 ON u2.id = mod1.approved_by 
            LEFT JOIN mod_values mv ON mv.id = mod1.value_id
            WHERE mod1.is_deleted = 0
            AND is_approved = 0
            ORDER BY mod1.id DESC
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function create($data = array())
    {
        if($data) {
            $create = $this->db->insert('machine_operation_desc', $data);
            return ($create == true) ? true : false;
        }
    }

    public function update($id = null, $data = array())
    {
        if($id && $data) {
            $this->db->where('id', $id);
            $update = $this->db->update('machine_operation_desc', $data);
            return ($update == true) ? true : false;
        }
    }

    //checkIfApproved
    public function checkIfApproved($id)
    {
        $sql = "SELECT * FROM machine_operation_desc WHERE id = ? AND is_approved = 1";
        $query = $this->db->query($sql, array($id));
        return $query->row_array();
    }

    public function remove($id = null)
    {
        if($id) {
            $this->db->where('id', $id);
            $delete = $this->db->delete('machine_operation_desc');
            return ($delete == true) ? true : false;
        }

        return false;
    }

    public function getMachineOperationsDataByMachineTypeId($machine_type_id = null)
    {
        if($machine_type_id) {
            $sql = "SELECT mod1.* 
            FROM machine_operation_desc mod1 
            WHERE machine_type_id = ?       
            AND is_deleted = 0

            ";
            $query = $this->db->query($sql, array($machine_type_id));
            return $query->result_array();
        }
    }

}