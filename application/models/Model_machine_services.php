<?php

class Model_machine_services extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getMachineServicesData($id = null)
    {
        if($id) {
            $sql = "SELECT machine_services.*,
                m.s_no, mt.name as machine_type_name, e.emp_name_with_initial as emp_name 
            FROM machine_services
            LEFT JOIN machine_ins m on machine_services.machine_in_id = m.id
            LEFT JOIN employees e on machine_services.employee_id = e.id
            LEFT JOIN machine_types mt on m.machine_type_id = mt.id
            WHERE machine_services.id = ? AND machine_services.is_deleted = 0 ";
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }

        $sql = "SELECT machine_services.*,
                m.s_no, mt.name as machine_type_name, e.emp_name_with_initial as emp_name 
            FROM machine_services
            LEFT JOIN machine_ins m on machine_services.machine_in_id = m.id
            LEFT JOIN employees e on machine_services.employee_id = e.id
            LEFT JOIN machine_types mt on m.machine_type_id = mt.id
            WHERE machine_services.is_deleted = 0
            ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function create($data = array())
    {
        if($data) {
            $create = $this->db->insert('machine_services', $data);
            return ($create == true) ? true : false;
        }
    }

    public function update($id = null, $data = array())
    {
        if($id && $data) {
            $this->db->where('id', $id);
            $update = $this->db->update('machine_services', $data);
            return ($update == true) ? true : false;
        }
    }

    public function remove($id = null)
    {
        if($id) {
            $this->db->where('id', $id);
            $delete = $this->db->delete('machine_services');
            return ($delete == true) ? true : false;
        }

        return false;
    }

    public function removeAllocate($id = null)
    {
        if($id) {
            $this->db->where('id', $id);
            $delete = $this->db->delete('machine_services');
            return ($delete == true) ? true : false;
        }

        return false;
    }

    public function getActiveMachineService()
    {
        $sql = "SELECT * FROM machine_services WHERE active = ?";
        $query = $this->db->query($sql, array(1));
        return $query->result_array();
    }

    public function countTotalMachineServices()
    {
        $sql = "SELECT * FROM machine_services WHERE active = ?";
        $query = $this->db->query($sql, array(1));
        return $query->num_rows();
    }

    public function getMachineServicesData_return_to_supplier($id = null)
    {
        if($id) {
            $sql = "SELECT rtsh.*,
                ts.suppliername
            FROM return_to_supplier_header rtsh 
            LEFT JOIN tbl_supplier ts on ts.idtbl_supplier = rtsh.supplier_id 
            WHERE rtsh.id = ? AND rtsh.is_deleted = 0 ";
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }

        $sql = "SELECT rtsh.*,
                ts.suppliername
            FROM return_to_supplier_header rtsh 
            LEFT JOIN tbl_supplier ts on ts.idtbl_supplier = rtsh.supplier_id 
            WHERE rtsh.is_deleted = 0
            ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getMachineServicesData_return_to_supplier_approve($id = null)
    {
        if($id) {
            $sql = "SELECT rtsh.*,
                ts.suppliername
            FROM return_to_supplier_header rtsh 
            LEFT JOIN tbl_supplier ts on ts.idtbl_supplier = rtsh.supplier_id 
            WHERE rtsh.id = ? AND rtsh.is_deleted = 0 ";
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }

        $sql = "SELECT rtsh.*,
                ts.suppliername
            FROM return_to_supplier_header rtsh 
            LEFT JOIN tbl_supplier ts on ts.idtbl_supplier = rtsh.supplier_id 
            WHERE rtsh.is_deleted = 0 AND is_approved = 0
            ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

}