<?php

class Model_machine_repair_requests extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getMachineRepairRequestsData($id = null)
    {
        if($id) {
            $sql = "SELECT mcr.*,
                m.s_no, m.bar_code, mt.name as machine_type_name 
            FROM machine_repairs mcr
            LEFT JOIN machine_ins m on mcr.machine_in_id = m.id
            LEFT JOIN machine_types mt on m.machine_type_id = mt.id 
            WHERE mcr.id = ? AND mcr.is_deleted = 0";
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }

        $sql = "SELECT mcr.*,
                m.s_no, m.bar_code, mt.name as machine_type_name 
            FROM machine_repairs mcr
            LEFT JOIN machine_ins m on mcr.machine_in_id = m.id
            LEFT JOIN machine_types mt on m.machine_type_id = mt.id 
            WHERE mcr.is_deleted = 0 
            ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function create($data = array())
    {
        if($data) {
            $create = $this->db->insert('machine_repairs', $data);
            return ($create == true) ? true : false;
        }
    }

    public function update($id = null, $data = array())
    {
        if($id && $data) {
            $this->db->where('id', $id);
            $update = $this->db->update('machine_repairs', $data);
            return ($update == true) ? true : false;
        }
    }

    public function remove($id = null)
    {
        if($id) {
            $this->db->where('id', $id);
            $delete = $this->db->delete('machine_repairs');
            return ($delete == true) ? true : false;
        }

        return false;
    }
}