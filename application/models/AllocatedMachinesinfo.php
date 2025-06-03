<?php
class AllocatedMachinesinfo extends CI_Model{
    public function getAllocationByMachineAndDate($machineId, $date){
        $this->db->select('
            ma.allocatedate,
            ma.allocatedqty,
            ma.idtbl_machine_allocation,
            de.deliveryId,
            de.delivery_date,
            p.product,
            o.idtbl_order,
            mt.name,
            m.s_no
        ');
        $this->db->from('tbl_machine_allocation as ma');
        $this->db->join('machine_ins as m', 'm.id = ma.tbl_machine_idtbl_machine');
        $this->db->join('machine_types as mt', 'mt.id = m.machine_type_id');
        $this->db->join('tbl_order as o', 'o.idtbl_order = ma.tbl_order_idtbl_order');
        $this->db->join('tbl_order_detail as od', 'od.tbl_order_idtbl_order = o.idtbl_order');
        $this->db->join('tbl_products as p', 'p.idtbl_product = od.tbl_products_idtbl_products');
        $this->db->join('tbl_delivery_detail as de', 'de.idtbl_delivery_detail = ma.tbl_delivery_plan_details_idtbl_delivery_plan_details');
        $this->db->where('m.id', $machineId);
        $this->db->where('DATE(ma.startdatetime)', $date);

        $query = $this->db->get();
        return $query->result();
    }

    public function getAllocationDataById($id){
        $this->db->select('
            mt.name,
            m.s_no,
            ma.startdatetime,
            ma.enddatetime,
            ma.allocatedqty,
            ma.idtbl_machine_allocation,
            SUM(md.completedqty) AS completedqty,
            SUM(md.wastageqty) AS wastageqty
        ');
        $this->db->from('tbl_machine_allocation as ma');
        $this->db->join('machine_ins as m', 'm.id = ma.tbl_machine_idtbl_machine','left');
        $this->db->join('machine_types as mt', 'mt.id = m.machine_type_id','left');
        $this->db->join('tbl_machine_allocation_details as md', 'md.tbl_machine_allocation_idtbl_machine_allocation = ma.idtbl_machine_allocation','left');
        $this->db->where('ma.idtbl_machine_allocation', $id);
        $this->db->group_by('ma.idtbl_machine_allocation');
        $query = $this->db->get();
        return $query->result();
    }

    public function getRejectReason(){
        $this->db->select('reason_type , id_rejected_item_reason as id');
        $this->db->from('rejected_item_reason');
        $query = $this->db->get();
        return $query->result();

    }

    public function checkAllocationExists($allocationId){
        $this->db->where('tbl_machine_allocation_idtbl_machine_allocation', $allocationId);
        $query = $this->db->get('tbl_machine_allocation_details');
        return $query->num_rows() > 0;
    }

    public function updateAllocationDetailsData($allocationId, $data){
        $this->db->where('tbl_machine_allocation_idtbl_machine_allocation', $allocationId);
        return $this->db->update('tbl_machine_allocation_details', $data);
    }

    public function InsertCompletedAmmount($data){
        return $this->db->insert('tbl_machine_allocation_details', $data);
    }

    public function InsertRejectedAmmount($data){
        return $this->db->insert('tbl_machine_allocation_details', $data);
    }

    public function getTimeslots(){
        $this->db->select('*');
        $this->db->from('tbl_timeslots');
        $this->db->where('status', 1);
        $query = $this->db->get();
        return $query->result();
    }

}