<?php

class Model_machine_repairs_employee extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getEmployeeRepairsData($id = null, $data = null)
    {
        $employee_id = $data['employee_id'];
        $date_from = $data['date_from'];
        $date_to = $data['date_to'];

            $sql = "SELECT msd.*,  
                e.name_with_initial as employee_name,
                e.id as employee_id,
                COUNT(msd.id) as repair_count
                FROM employees e 
                LEFT JOIN machine_repair_details msd ON msd.repair_done_by = e.id
                LEFT JOIN machine_repairs ms ON msd.repair_id = ms.id
                WHERE msd.is_deleted = 0 ";

            if($employee_id != '') {
                $sql .= " AND msd.repair_done_by = '$employee_id' ";
            }

            if($date_from && $date_to != '') {
                $sql .= " AND ms.repair_in_date BETWEEN '$date_from' AND '$date_to' ";
            }

        $sql .= " GROUP BY msd.repair_done_by
                ORDER BY msd.repair_done_by DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getEmployeeRepairsDataById($id = null, $date_from = null, $date_to = null)
    {
        $sql = "SELECT msd.*,
                m.s_no, m.bar_code, mt.name as machine_type_name,
                ms.repair_in_date
            FROM machine_repair_details msd
            LEFT JOIN machine_repairs ms ON msd.repair_id = ms.id
            LEFT JOIN machine_ins m on ms.machine_in_id = m.id
            LEFT JOIN machine_types mt on m.machine_type_id = mt.id
            WHERE msd.is_deleted = 0 ";

        if($id != '') {
            $sql .= " AND msd.repair_done_by = '$id' ";
        }

        if($date_from && $date_to != '') {
            $sql .= " AND ms.repair_in_date BETWEEN '$date_from' AND '$date_to' ";
        }

        $sql .= " ORDER BY msd.repair_done_by DESC";

        $query = $this->db->query($sql);
        return $query->result_array();

    }



}