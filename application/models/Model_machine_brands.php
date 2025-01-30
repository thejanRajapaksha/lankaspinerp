<?php

class Model_machine_brands extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getMachineBrandsData($id = null)
    {
        if($id) {
            $sql = "SELECT * FROM machine_brands WHERE id = ?";
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }

        $sql = "SELECT * FROM machine_brands ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function create($data = array())
    {
        if($data) {
            $create = $this->db->insert('machine_brands', $data);
            return ($create == true) ? true : false;
        }
    }

    public function update($id = null, $data = array())
    {
        if($id && $data) {
            $this->db->where('id', $id);
            $update = $this->db->update('machine_brands', $data);
            return ($update == true) ? true : false;
        }
    }

    public function remove($id = null)
    {
        if($id) {
            $this->db->where('id', $id);
            $delete = $this->db->delete('machine_brands');
            return ($delete == true) ? true : false;
        }

        return false;
    }

    public function getActiveMachineBrand()
    {
        $sql = "SELECT * FROM machine_brands WHERE active = ?";
        $query = $this->db->query($sql, array(1));
        return $query->result_array();
    }

    public function countTotalMachineBrands()
    {
        $sql = "SELECT * FROM machine_brands WHERE active = ?";
        $query = $this->db->query($sql, array(1));
        return $query->num_rows();
    }
}