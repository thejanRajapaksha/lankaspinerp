<?php

class Model_slots extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getSlotsData($id = null, $section_id = null)
    {
        if($id) {
            $sql = "SELECT `slots`.*,
                    sections.name AS section_name, 
                   sections.id AS section_id,
                   d.name AS department_name,
                   d.id AS department_id,
                   f.br_name AS factory_name,
                   f.id AS factory_id,
                    mlinelist.line_name AS line_name, 
                    mlinelist.id AS line_id 
                    FROM `slots` 
                    LEFT JOIN mlinelist ON `slots`.line = mlinelist.id
                    LEFT JOIN sections ON mlinelist.section = sections.id  
                    LEFT JOIN departments d ON sections.department = d.id   
                    LEFT JOIN mbranchlist f on d.factory_id = f.id
                    WHERE `slots`.id = ?";
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }

        $sql = "SELECT `slots`.*,
                   sections.name AS section_name, 
                   sections.id AS section_id,
                   d.name AS department_name,
                   d.id AS department_id,
                   f.br_name AS factory_name,
                   f.id AS factory_id,
                   mlinelist.line_name AS line_name, 
                    mlinelist.id AS line_id 
                    FROM `slots` 
                    LEFT JOIN mlinelist ON `slots`.line = mlinelist.id
                    LEFT JOIN sections ON mlinelist.section = sections.id  
                    LEFT JOIN departments d ON sections.department = d.id   
                    LEFT JOIN mbranchlist f on d.factory_id = f.id
                    ";

        if($section_id) {
            $sql .= "WHERE `slots`.section = $section_id ";
        }

        $sql .= "ORDER BY id ASC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_line_slots($line_id)
    {
        $sql = "SELECT `slots`.*, 
                   mlinelist.line_name AS line_name, 
                    mlinelist.id AS line_id 
                    FROM `slots` 
                    LEFT JOIN mlinelist ON `slots`.line = mlinelist.id 
                    WHERE `slots`.line = $line_id
                    ORDER BY slots.id";

        $query = $this->db->query($sql);
        return $query->result_array();

    }

    public function create($data = array())
    {
        if($data) {
            $create = $this->db->insert('slots', $data);
            return ($create == true) ? true : false;
        }
    }

    public function update($id = null, $data = array())
    {
        if($id && $data) {
            $this->db->where('id', $id);
            $update = $this->db->update('slots', $data);
            return ($update == true) ? true : false;
        }
    }

    public function remove($id = null)
    {
        if($id) {
            $this->db->where('id', $id);
            $delete = $this->db->delete('slots');
            return ($delete == true) ? true : false;
        }

        return false;
    }

    public function getActiveSlots()
    {
        $sql = "SELECT * FROM 'slots' WHERE active = ?";
        $query = $this->db->query($sql, array(1));
        return $query->result_array();
    }

    public function countTotalSlots()
    {
        $sql = "SELECT * FROM 'slots' WHERE active = ?";
        $query = $this->db->query($sql, array(1));
        return $query->num_rows();
    }
}