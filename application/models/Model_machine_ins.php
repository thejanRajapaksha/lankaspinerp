<?php

class Model_machine_ins extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getMachineInsData($id = null)
    {
        if($id) {
            $sql = "SELECT machine_ins.*,
                mt.name as machine_type_name,
                mm.name as machine_model_name,  
                it.name as in_type_name
                FROM machine_ins 
                LEFT JOIN machine_types mt on machine_ins.machine_type_id = mt.id
                LEFT JOIN machine_models mm on machine_ins.machine_model_id = mm.id 
                LEFT JOIN in_types it on machine_ins.in_type_id = it.id
                WHERE machine_ins.id = $id
                AND machine_ins.is_deleted = 0  
                ";
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }

        $sql = "SELECT machine_ins.*,
               mt.name as machine_type_name,
               mm.name as machine_model_name,  
               it.name as in_type_name
                FROM machine_ins 
                LEFT JOIN machine_types mt on machine_ins.machine_type_id = mt.id
                LEFT JOIN machine_models mm on machine_ins.machine_model_id = mm.id 
                LEFT JOIN in_types it on machine_ins.in_type_id = it.id
                WHERE machine_ins.is_deleted = 0  
                ORDER BY machine_ins.id DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function create($data = array())
    {
        if($data) {
            $create = $this->db->insert('machine_ins', $data);
            return ($create == true) ? true : false;
        }
    }

    public function update($id = null, $data = array())
    {
        if($id && $data) {
            $this->db->where('id', $id);
            $update = $this->db->update('machine_ins', $data);
            return ($update == true) ? true : false;
        }
    }

    public function remove($id = null)
    {
        if($id) {
            $this->db->where('id', $id);
            $delete = $this->db->delete('machine_ins');
            return ($delete == true) ? true : false;
        }

        return false;
    }

    public function getActiveMachineIn()
    {
        $sql = "SELECT * FROM machine_ins WHERE active = ?";
        $query = $this->db->query($sql, array(1));
        return $query->result_array();
    }

    public function countTotalMachineIns()
    {
        $sql = "SELECT * FROM machine_ins WHERE active = ?";
        $query = $this->db->query($sql, array(1));
        return $query->num_rows();
    }

    public function getMachineInDataBySNo(){
        $sql = "SELECT machine_ins.*,
                mt.name as machine_type_name,
                mm.name as machine_model_name,  
                it.name as in_type_name
                FROM machine_ins 
                LEFT JOIN machine_types mt on machine_ins.machine_type_id = mt.id
                LEFT JOIN machine_models mm on machine_ins.machine_model_id = mm.id 
                LEFT JOIN in_types it on machine_ins.in_type_id = it.id
                WHERE machine_ins.s_no = ?";
        $query = $this->db->query($sql, array($this->input->post('s_no')));
        return $query->row_array();
    }

}