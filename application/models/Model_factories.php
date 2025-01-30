<?php

class Model_factories extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getFactoriesData($id = null)
    {
        if($id) {
            $sql = "SELECT * FROM mbranchlist WHERE id = ?";
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }

        $sql = "SELECT * FROM mbranchlist ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function create($data = array())
    {
        if($data) {
            $create = $this->db->insert('mbranchlist', $data);
            return ($create == true) ? true : false;
        }
    }

    public function update($id = null, $data = array())
    {
        if($id && $data) {
            $this->db->where('id', $id);
            $update = $this->db->update('mbranchlist', $data);
            return ($update == true) ? true : false;
        }
    }

    public function remove($id = null)
    {
        if($id) {
            $this->db->where('id', $id);
            $delete = $this->db->delete('mbranchlist');
            return ($delete == true) ? true : false;
        }

        return false;
    }

    public function getActiveFactories()
    {
        $sql = "SELECT * FROM mbranchlist WHERE isoffline = ?";
        $query = $this->db->query($sql, array(0));
        return $query->result_array();
    }

    public function countTotalFactories()
    {
        $sql = "SELECT * FROM mbranchlist WHERE isoffline = ?";
        $query = $this->db->query($sql, array(0));
        return $query->num_rows();
    }
}