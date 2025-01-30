<?php

class Model_spare_parts extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getSparePartsData($id = null)
    {
        if($id) {
            $sql = "SELECT sp.*,
            mm.name as machine_model,
            mt.name as machine_type_name, 
            GROUP_CONCAT(ts.suppliername, ', ') as sup_name
            FROM spare_parts sp
            LEFT JOIN machine_models mm ON mm.id = sp.model
            LEFT JOIN machine_types mt ON mt.id = sp.type
            LEFT JOIN tbl_supplier ts ON ts.idtbl_supplier = sp.supplier_id
            WHERE sp.is_deleted = 0 
            AND sp.id = '$id'
            ORDER BY sp.id DESC";
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }

        $sql = "SELECT sp.*,
            mm.name as machine_model,
            mt.name as machine_type_name, 
            GROUP_CONCAT(ts.suppliername, ', ') as sup_name
        FROM spare_parts sp
        LEFT JOIN machine_models mm ON mm.id = sp.model
        LEFT JOIN machine_types mt ON mt.id = sp.type
        LEFT JOIN tbl_supplier ts ON ts.idtbl_supplier = sp.supplier_id
        WHERE sp.is_deleted = 0
        GROUP BY sp.id
        ORDER BY sp.id DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function create($data = array())
    {
        if($data) {
            $create = $this->db->insert('spare_parts', $data);
            return ($create == true) ? true : false;
        }
    }

    public function update($id = null, $data = array())
    {
        if($id && $data) {
            $this->db->where('id', $id);
            $update = $this->db->update('spare_parts', $data);
            return ($update == true) ? true : false;
        }
    }

    public function remove($id = null)
    {
        if($id) {
            $this->db->where('id', $id);
            $delete = $this->db->delete('spare_parts');
            return ($delete == true) ? true : false;
        }

        return false;
    }

    public function getActiveSparePart()
    {
        $sql = "SELECT * FROM spare_parts WHERE active = ?";
        $query = $this->db->query($sql, array(1));
        return $query->result_array();
    }

    public function countTotalSpareParts()
    {
        $sql = "SELECT * FROM spare_parts WHERE active = ?";
        $query = $this->db->query($sql, array(1));
        return $query->num_rows();
    }
}