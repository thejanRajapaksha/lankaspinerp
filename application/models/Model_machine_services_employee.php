<?php

class Model_machine_services_employee extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getEmployeeServicesData($id = null, $data = null)
    {
        $employee_id = $data['employee_id'];
        $date_from = $data['date_from'];
        $date_to = $data['date_to'];

            $sql = "SELECT msd.*,  
                e.emp_name_with_initial as employee_name,
                e.id as employee_id,
                COUNT(msd.id) as service_count
                FROM employees e 
                LEFT JOIN machine_service_details msd ON msd.service_done_by = e.id
                LEFT JOIN machine_services ms ON msd.service_id = ms.id
                WHERE msd.is_deleted = 0 ";

            if($employee_id != '') {
                $sql .= " AND msd.service_done_by = '$employee_id' ";
            }

            if($date_from && $date_to != '') {
                $sql .= " AND ms.service_date BETWEEN '$date_from' AND '$date_to' ";
            }

        $sql .= " GROUP BY msd.service_done_by
                ORDER BY msd.service_done_by DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    //getEmployeeServicesDataById($id = null, $date_from = null, $date_to = null)
    public function getEmployeeServicesDataById($id = null, $date_from = null, $date_to = null)
    {
        $sql = "SELECT msd.*,
                m.s_no, m.bar_code, mt.name as machine_type_name,
               ms.service_no, ms.service_date_from, ms.service_date_to 
            FROM machine_service_details msd
            LEFT JOIN machine_services ms ON msd.service_id = ms.id
            LEFT JOIN machine_ins m on ms.machine_in_id = m.id
            LEFT JOIN machine_types mt on m.machine_type_id = mt.id
            WHERE msd.is_deleted = 0 ";

        if($id != '') {
            $sql .= " AND msd.service_done_by = '$id' ";
        }

        if($date_from && $date_to != '') {
           // $sql .= " AND ms.service_date BETWEEN '$date_from' AND '$date_to' ";
           $sql .= " AND ms.service_date_from <= '$date_from' AND ms.service_date_to >= '$date_to";
        }

        $sql .= " ORDER BY msd.service_done_by DESC";

        $query = $this->db->query($sql);
        return $query->result_array();

    }



}