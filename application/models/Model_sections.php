<?php

class Model_sections extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getSectionsData($id = null)
    {
        if($id) {
            $sql = "SELECT sections.*,
                    departments.name AS department_name,
                    departments.id AS department_id,
                    f.br_name AS factory_name,
                    f.id AS factory_id
                    FROM sections 
                    LEFT JOIN departments ON sections.department = departments.id  
                    LEFT JOIN mbranchlist f on departments.factory_id = f.id
                    WHERE sections.id = ?";
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }

        $sql = "SELECT sections.*,
                departments.name AS department_name,
                departments.id AS department_id ,
                f.br_name AS factory_name,
                f.id AS factory_id
                FROM sections 
                LEFT JOIN departments ON sections.department = departments.id 
                LEFT JOIN mbranchlist f on departments.factory_id = f.id ";

        $sql .=" ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function create($data = array())
    {
        if($data) {
            $create = $this->db->insert('sections', $data);
            return ($create == true) ? true : false;
        }
    }

    public function update($id = null, $data = array())
    {
        if($id && $data) {
            $this->db->where('id', $id);
            $update = $this->db->update('sections', $data);
            return ($update == true) ? true : false;
        }
    }

    public function remove($id = null)
    {
        if($id) {
            $this->db->where('id', $id);
            $delete = $this->db->delete('sections');
            return ($delete == true) ? true : false;
        }

        return false;
    }

    public function getActiveStyle()
    {
        $sql = "SELECT * FROM sections WHERE active = ?";
        $query = $this->db->query($sql, array(1));
        return $query->result_array();
    }

    public function countTotalSections()
    {
        $sql = "SELECT * FROM sections WHERE active = ?";
        $query = $this->db->query($sql, array(1));
        return $query->num_rows();
    }
}