<?php

class Model_used_service_items extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getUsedServiceItemsData($id = null, $data = null)
    {
        $service_item_id = $data['service_item_id'];
        $date_from = $data['date_from'];
        $date_to = $data['date_to'];

        $sql = "SELECT msdi.*,  
                si.name, si.id, 
                COUNT(msdi.id) as item_count
                FROM service_items si 
                LEFT JOIN machine_service_details_items msdi ON msdi.spare_part_id = si.id
                LEFT JOIN machine_service_details msd ON msdi.machine_service_details_id = msd.id
                LEFT JOIN machine_services ms ON msd.service_id = ms.id
                WHERE msdi.is_deleted = 0 ";

            if($service_item_id) {
                $sql .= "AND msdi.spare_part_id = $service_item_id ";
            }

            if($date_from && $date_to != '') {
                $sql .= " AND ms.service_date BETWEEN '$date_from' AND '$date_to' ";
            }

        $sql .= " GROUP BY msdi.spare_part_id
                ORDER BY msdi.spare_part_id DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getUsedServiceItemsDataById($id = null, $date_from = null, $date_to = null)
    {
        $sql = "SELECT msdi.*,  
                si.name, si.id, 
                ms.service_no, ms.service_date_from as service_date, ms.service_date_to,
                e.name_with_initial 
                FROM service_items si 
                LEFT JOIN machine_service_details_items msdi ON msdi.spare_part_id = si.id
                LEFT JOIN machine_service_details msd ON msdi.machine_service_details_id = msd.id
                LEFT JOIN machine_services ms ON msd.service_id = ms.id
                LEFT JOIN employees e ON msd.service_done_by = e.id
                WHERE msdi.is_deleted = 0 ";

        if($id != '') {
            $sql .= " AND si.id = '$id' ";
        }

        if($date_from && $date_to != '') {
            $sql .= " AND ms.service_date BETWEEN '$date_from' AND '$date_to' ";
        }

        $sql .= " ORDER BY si.id DESC";

        $query = $this->db->query($sql);
        return $query->result_array();

    }



}