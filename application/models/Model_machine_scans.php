<?php

class Model_machine_scans extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

    }

    public function getMachineCurrentAllocationDataByMachineInId($id = null)
    {
        if($id) {
            $sql = "SELECT machine_allocation_current.*, 
                    slots.name as slot_name, 
                    mlinelist.line_name as line_name,
                    s.name as section_name, 
                    d.name as department_name, 
                    f.br_name as factory_name
                    FROM machine_allocation_current
                    LEFT JOIN slots ON machine_allocation_current.slot_id = slots.id 
                    LEFT JOIN mlinelist ON slots.line = mlinelist.id 
                    LEFT JOIN sections s on mlinelist.section = s.id
                    LEFT JOIN departments d on d.id = s.department 
                    LEFT JOIN mbranchlist f on f.id = d.factory_id  
                    WHERE machine_in_id = ?";
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }
    }

    public function create_machine_allocation_history($data = array())
    {
        if($data) {
            $create = $this->db->insert('machine_allocation_history', $data);
            return ($create == true) ? true : false;
        }
    }

   public function delete_machine_allocation_current($machine_in_id)
   {
        if($machine_in_id) {
            $this->db->where('machine_in_id', $machine_in_id);
            $delete = $this->db->delete('machine_allocation_current');
            return ($delete == true) ? true : false;
        }
   }

    public function create_allocation($data = array())
    {
        if($data) {
            $create = $this->db->insert('machine_allocation_current', $data);
            return ($create == true) ? true : false;
        }
    }

    public function create_repair($data = array())
    {
        if($data) {
            $create = $this->db->insert('machine_repairs', $data);
            return ($create == true) ? true : false;
        }
    }

    //update_repair
    public function update_repair($id = null, $data = array())
    {
        if($data && $id) {
            $this->db->where('id', $id);
            $update = $this->db->update('machine_repairs', $data);
            return ($update == true) ? true : false;
        }
    }


    public function getMachineCurrentRepairDataByMachineInId($id = null)
    {
        if($id) {
            $sql = "SELECT machine_repairs.* 
                    FROM machine_repairs     
                    WHERE machine_in_id = ? 
                    AND repair_out_date IS NULL
                    ";
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }
    }

    public function create_machine_repair_history($data = array())
    {
        if($data) {
            $create = $this->db->insert('machine_repair_history', $data);
            return ($create == true) ? true : false;
        }
    }

    public function delete_machine_repair_current($machine_in_id)
    {
        if($machine_in_id) {
            $this->db->where('machine_in_id', $machine_in_id);
            $delete = $this->db->delete('machine_repair_current');
            return ($delete == true) ? true : false;
        }
    }

    public function getAllocationHistory($machine_in_id = null )
    {

        $sql = "SELECT machine_allocation_history.*, 
                slots.name as slot_name, 
                mlinelist.line_name as line_name,
                s.name as section_name, 
                d.name as department_name, 
                f.br_name as factory_name
                FROM machine_allocation_history
                LEFT JOIN slots ON machine_allocation_history.slot_id = slots.id 
                LEFT JOIN mlinelist ON slots.line = mlinelist.id 
                LEFT JOIN sections s on mlinelist.section = s.id
                LEFT JOIN departments d on d.id = s.department 
                LEFT JOIN mbranchlist f on f.id = d.factory_id ";

                if($machine_in_id) {
                    $sql .= " WHERE machine_in_id = ?";
                    $query = $this->db->query($sql, array($machine_in_id));
                } else {
                    $query = $this->db->query($sql);
                }
        return $query->result_array();
    }

    public function getRepairHistory($machine_in_id = null)
    {

        $sql = "SELECT machine_repairs.* 
                FROM machine_repairs 
                WHERE repair_out_date IS NOT NULL ";
                if($machine_in_id) {
                    $sql .= "AND machine_in_id = ?";
                    $query = $this->db->query($sql, array($machine_in_id));
                } else {
                    $query = $this->db->query($sql);
                }
        return $query->result_array();
    }
  


}