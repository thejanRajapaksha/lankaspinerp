<?php

class Model_operations_for_machines extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getOperationsForMachinesData($id = null)
    {
        if($id) {
            $sql = "SELECT ofm.*,
            ot.name as operation_type_name,
            ot.class_type as operation_type_class_type
            FROM operations_for_machines as ofm 
            LEFT JOIN operation_types as ot ON ot.id = ofm.operation_type_id
            WHERE ofm.id = ?";
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }

        $sql = "SELECT ofm.*,
        ot.name as operation_type_name,
        ot.class_type as operation_type_class_type
        FROM operations_for_machines as ofm 
        LEFT JOIN operation_types as ot ON ot.id = ofm.operation_type_id
        ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function create($data = array())
    {
        if($data) {
            $create = $this->db->insert('operations_for_machines', $data);
            return ($create == true) ? true : false;
        }
    }

    public function update($id = null, $data = array())
    {
        if($id && $data) {
            $this->db->where('id', $id);
            $update = $this->db->update('operations_for_machines', $data);
            return ($update == true) ? true : false;
        }
    }

    public function remove($id = null)
    {
        if($id) {
            $this->db->where('id', $id);
            $delete = $this->db->delete('operations_for_machines');
            return ($delete == true) ? true : false;
        }

        return false;
    }

    public function getActiveOperationsForMachine()
    {
        $sql = "SELECT * FROM operations_for_machines WHERE active = ?";
        $query = $this->db->query($sql, array(1));
        return $query->result_array();
    }

    public function countTotalOperationsForMachines()
    {
        $sql = "SELECT * FROM operations_for_machines WHERE active = ?";
        $query = $this->db->query($sql, array(1));
        return $query->num_rows();
    }

    public function getOperationTypes()
    {
        $sql = "SELECT * FROM operation_types";
        $query = $this->db->query($sql, array(1));
        return $query->result_array();
    }

}