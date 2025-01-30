<?php

class Model_machine_repairs extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    public function create($data = array())
    {
        if($data) {
            $create = $this->db->insert('machine_repair_details', $data);
            return ($create == true) ? true : false;
        }
    }

    public function createRepairDetailItems($data = array())
    {
        if($data) {
            $create = $this->db->insert('machine_repair_details_items', $data);
            return ($create == true) ? true : false;
        }
    }

    public function getMachineRepairDetails($id = null)
    {
        if($id) {
            $sql = "SELECT * FROM machine_repairs WHERE id = ?";
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }
        return false;
    }

    //update
    public function update( $id = null, $data = array())
    {
        if($data && $id) {
            $this->db->where('id', $id);
            $update = $this->db->update('machine_repairs', $data);
            return ($update == true) ? true : false;
        }
    }



}