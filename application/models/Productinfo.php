<?php
class Productinfo extends CI_Model{
    public function getProduct(){
        $this->db->select('`idtbl_product`,`product`');
        $this->db->from('tbl_products');
        $query = $this->db->get();
        return $query->result();
    
    }
}
?>