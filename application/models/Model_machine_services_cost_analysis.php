<?php

class Model_machine_services_cost_analysis extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getMachineServicesCostAnalysisData($id = null, $data = null)
    {
        if($id) {
            $sql = "SELECT msd.*,
                m.s_no, m.bar_code, mt.name as machine_type_name,
               ms.service_no, ms.service_date_from, ms.service_date_to, e.name_with_initial 
            FROM machine_service_details msd  
            LEFT JOIN machine_services ms ON msd.service_id = ms.id
            LEFT JOIN machine_ins m on ms.machine_in_id = m.id
            LEFT JOIN machine_types mt on m.machine_type_id = mt.id
            LEFT JOIN employees e on msd.service_done_by = e.id 
            WHERE msd.id = ?";
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }

        $status = $data['status'];
        $service_type = $data['service_type'];
        $machine_type = $data['machine_type'];
        $machine_in_id = $data['machine_in_id'];
        $service_no = $data['service_no'];
        $date_from = $data['date_from'];
        $date_to = $data['date_to'];

        $sql = "SELECT msd.*,
                m.s_no, m.bar_code, mt.name as machine_type_name,
               ms.service_no, ms.service_date_from, ms.service_date_to
            FROM machine_service_details msd
            LEFT JOIN machine_services ms ON msd.service_id = ms.id
            LEFT JOIN machine_ins m on ms.machine_in_id = m.id
            LEFT JOIN machine_types mt on m.machine_type_id = mt.id
            WHERE msd.is_deleted = 0 ";

        if($status != '') {
            $sql .= " AND msd.is_completed = '$status' ";
        }

        if($service_type != '') {
            $sql .= " AND msd.service_type = '$service_type' ";
        }

        if($machine_type != '') {
            $sql .= " AND mt.id = '$machine_type' ";
        }

        if($machine_in_id != '') {
            $sql .= " AND m.id = '$machine_in_id' ";
        }

        if($service_no != '') {
            $sql .= " AND ms.service_no = '$service_no' ";
        }

        if($date_from && $date_to != '') {
           // $sql .= " AND ms.service_date BETWEEN '$date_from' AND '$date_to' ";
           $sql .= " AND ms.service_date_from <= '$date_from' AND ms.service_date_to  >= '$date_to";
        }

        $sql .="ORDER BY id DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getMachineServiceItemsData($id)
    {
        $sql = "SELECT msdi.*, si.name as item_name 
                FROM machine_service_details_items msdi 
                LEFT JOIN service_items si ON msdi.service_item_id = si.id
                WHERE msdi.machine_service_details_id = ? AND si.is_deleted = 0 AND msdi.is_deleted = 0";
        $query = $this->db->query($sql, array($id));
        return $query->result_array();
    }

    //getMonthlyServiceCost
    public function getMonthlyServiceCost($month){

        $date = date('Y-m', strtotime($month));

        $sql = "SELECT SUM(msd.sub_total) as total_cost 
                FROM machine_service_details msd 
                LEFT JOIN machine_services ms ON msd.service_id = ms.id
                WHERE ms.service_date_from LIKE '$date%' 
                AND msd.is_deleted = 0";
        $query = $this->db->query($sql);
        return $query->row_array();

    }

    public function getMachineTypesServiceItemsCount($date)
    {
        $sql = "SELECT mt.name as machine_type_name, COUNT(msd.id) as total_count 
                FROM machine_types mt
                LEFT JOIN machine_ins m on mt.id = m.machine_type_id
                LEFT JOIN machine_services ms ON m.id = ms.machine_in_id
                LEFT JOIN machine_service_details msd ON ms.id = msd.service_id
                WHERE ms.service_date = '$date' AND msd.is_deleted = 0
                GROUP BY mt.id";

        $query = $this->db->query($sql);
        return $query->result_array();
    }


}