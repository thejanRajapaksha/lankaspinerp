<?php

class Model_machines extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getMachinesData($id = null)
    {
        if($id) {
            $sql = "SELECT machines.*, sections.name AS section_name, sections.id AS section_id 
                    FROM machines 
                    LEFT JOIN sections ON machines.section = sections.id  
                    WHERE machines.id = ?";
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }

        $sql = "SELECT machines.*, sections.name AS section_name, sections.id AS section_id 
                    FROM machines 
                    LEFT JOIN sections ON machines.section = sections.id  
                ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function create($data = array())
    {
        if($data) {
            $create = $this->db->insert('machines', $data);
            return ($create == true) ? true : false;
        }
    }

    public function update($id = null, $data = array())
    {
        if($id && $data) {
            $this->db->where('id', $id);
            $update = $this->db->update('machines', $data);
            return ($update == true) ? true : false;
        }
    }

    public function remove($id = null)
    {
        if($id) {
            $this->db->where('id', $id);
            $delete = $this->db->delete('machines');
            return ($delete == true) ? true : false;
        }

        return false;
    }

    public function getActiveMachines()
    {
        $sql = "SELECT * FROM machines WHERE active = ?";
        $query = $this->db->query($sql, array(1));
        return $query->result_array();
    }

    public function countTotalMachines()
    {
        $sql = "SELECT * FROM machines WHERE active = ?";
        $query = $this->db->query($sql, array(1));
        return $query->num_rows();
    }
}