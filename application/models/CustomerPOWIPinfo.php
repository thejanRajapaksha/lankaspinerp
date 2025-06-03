<?php
class CustomerPOWIPinfo extends CI_Model{
    public function Getcustomername(){
        $this->db->select('c.idtbl_customer, c.name');
        $this->db->from('tbl_order as o');
        $this->db->join('tbl_inquiry as i', 'i.idtbl_inquiry = o.tbl_inquiry_idtbl_inquiry');
        $this->db->join('tbl_customer as c', 'c.idtbl_customer = i.tbl_customer_idtbl_customer');

        $query=$this->db->get();
        return $query->result();
    }

    public function getPOForCustomer($customerId) {
        $this->db->select('o.idtbl_order');
        $this->db->from('tbl_order as o');
        $this->db->join('tbl_inquiry as i', 'i.idtbl_inquiry = o.tbl_inquiry_idtbl_inquiry');
        $this->db->join('tbl_customer as c', 'c.idtbl_customer = i.tbl_customer_idtbl_customer');
        $this->db->where('i.tbl_customer_idtbl_customer', $customerId);

        $query = $this->db->get();
        return $query->result();
    }


}