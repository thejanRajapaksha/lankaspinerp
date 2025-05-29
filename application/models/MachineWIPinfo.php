<?php
class MachineWIPinfo extends CI_Model{
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
        $this->db->where('DATE(ma.allocatedate)', $date);

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
            md.completedqty
        ');
        $this->db->from('tbl_machine_allocation as ma');
        $this->db->join('machine_ins as m', 'm.id = ma.tbl_machine_idtbl_machine','left');
        $this->db->join('machine_types as mt', 'mt.id = m.machine_type_id','left');
        $this->db->join('tbl_machine_allocation_details as md', 'md.tbl_machine_allocation_idtbl_machine_allocation = ma.idtbl_machine_allocation','left');
        $this->db->where('idtbl_machine_allocation', $id);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function InsertCompletedAmmount($data)
        {
            return $this->db->insert('tbl_machine_allocation_details', $data);
        }

}