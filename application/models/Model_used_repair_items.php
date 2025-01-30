<?php

class Model_used_repair_items extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getUsedRepairItemsData($id = null, $data = null)
    {
        $service_item_id = $data['service_item_id'];
        $date_from = $data['date_from'];
        $date_to = $data['date_to'];

        $sql = "SELECT msdi.*,  
                si.name, si.id, 
                COUNT(msdi.id) as item_count
                FROM service_items si 
                LEFT JOIN machine_repair_details_items msdi ON msdi.service_item_id = si.id
                LEFT JOIN machine_repair_details msd ON msdi.machine_repair_details_id = msd.id
                LEFT JOIN machine_repairs ms ON msd.repair_id = ms.id
                WHERE msdi.is_deleted = 0 AND msd.is_deleted = 0 AND ms.is_deleted = 0  ";

            if($service_item_id) {
                $sql .= "AND msdi.service_item_id = $service_item_id ";
            }

            if($date_from && $date_to != '') {
                $sql .= " AND ms.service_in_date BETWEEN '$date_from' AND '$date_to' ";
            }

        $sql .= " GROUP BY msdi.service_item_id
                ORDER BY msdi.service_item_id DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getUsedRepairItemsDataById($id = null, $date_from = null, $date_to = null)
    {
        $sql = "SELECT msdi.*,  
                si.name, si.id, 
                ms.repair_in_date,
                e.name_with_initial 
                FROM service_items si 
                LEFT JOIN machine_repair_details_items msdi ON msdi.service_item_id = si.id
                LEFT JOIN machine_repair_details msd ON msdi.machine_repair_details_id = msd.id
                LEFT JOIN machine_repairs ms ON msd.repair_id = ms.id
                LEFT JOIN employees e ON msd.repair_done_by = e.id
                WHERE msdi.is_deleted = 0 AND msd.is_deleted = 0 AND ms.is_deleted = 0 ";

        if($id != '') {
            $sql .= " AND si.id = '$id' ";
        }

        if($date_from && $date_to != '') {
            $sql .= " AND ms.repair_in_date BETWEEN '$date_from' AND '$date_to' ";
        }

        $sql .= " ORDER BY si.id DESC";

        $query = $this->db->query($sql);
        return $query->result_array();

    }



}