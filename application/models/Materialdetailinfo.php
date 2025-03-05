<?php
class Materialdetailinfo extends CI_Model{
    public function Getmaterialcategory() {
        $inquiryid = $this->input->post('inquiryid');
    
        $this->db->select('tbl_material.idtbl_material, tbl_material.type');
        $this->db->from('tbl_material');
        $this->db->join('tbl_inquiry_detail', 'tbl_material.idtbl_material = tbl_inquiry_detail.tbl_material_idtbl_material');
        $this->db->where('tbl_inquiry_detail.tbl_inquiry_idtbl_inquiry', $inquiryid);
        $this->db->where('tbl_material.status', 1);
    
        $respond = $this->db->get();
        $data = array();
        foreach ($respond->result() as $row) {
            $data[] = array("id" => $row->idtbl_material, "text" => $row->type);
        }
        echo json_encode($data);
    }
    

    public function Materialdetailinsertupdate() {
        $this->db->trans_begin();
    
        $userID = $_SESSION['userid'];
    
        $jsonObj = json_decode($this->input->post('tableData'), true);
        $inquiryid = $this->input->post('inquiryid');
    
        $insertdatetime = date('Y-m-d H:i:s');
    
        $this->db->select('o.idtbl_order');
        $this->db->from('tbl_order AS o');
        $this->db->where('o.tbl_inquiry_idtbl_inquiry', $inquiryid);
        $query = $this->db->get('tbl_order');
        $order = $query->row();
        $orderID = $order->idtbl_order;
    
        // Loop through each record and insert into tbl_material_detail
        foreach ($jsonObj as $rowdata) {
            $mtype = $rowdata['col_1'];
            $oquantity = $rowdata['col_3'];
            $morderdate = $rowdata['col_4'];
            $remarks = $rowdata['col_5'];
    
            $MaterialDetailData = array(
                'tbl_order_idtbl_order' => $orderID,
                'tbl_inquiry_idtbl_inquiry' => $inquiryid,
                'tbl_material_idtbl_material ' => $mtype,
                'mat_quantity' => $oquantity,
                'mat_odate' => $morderdate,
                'mat_remarks' => $remarks,
                'status' => '1',
                'insertdatetime' => $insertdatetime,
                'tbl_user_idtbl_user' => $userID
            );
    
            $this->db->insert('tbl_material_detail', $MaterialDetailData);
        }
    
        $this->db->trans_complete();
    
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
    
            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-save';
            $actionObj->title = '';
            $actionObj->message = 'Material Details Added Successfully';
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'success';
    
            $actionJSON = json_encode($actionObj);
            
        } else {
            $this->db->trans_rollback();
    
            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-warning';
            $actionObj->title = '';
            $actionObj->message = 'Material Details Addition Failed';
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'danger';
    
            $actionJSON = json_encode($actionObj);
        }

        echo $actionJSON;
    }    

    public function Getmaterialdetails() {
        $inquiryid = $this->input->post('inquiryid');

        $this->db->select('md.mat_quantity, md.mat_odate, md.mat_remarks, m.type, md.tbl_material_idtbl_material, md.tbl_order_idtbl_order, md.mat_balance');
        $this->db->from('tbl_material_detail md');
        $this->db->join('tbl_material m', 'md.tbl_material_idtbl_material = m.idtbl_material', 'left');
        $this->db->where('md.tbl_inquiry_idtbl_inquiry ', $inquiryid);
        $result = $this->db->get();

        return $result->result_array();
        
    }

    public function Savematerialbalances() {
        $materialBalances = $this->input->post('materialBalances');
    
        foreach ($materialBalances as $materialBalance) {
            $data = array(
                'mat_balance' => $materialBalance['mat_balance']
            );
    
            $this->db->where('tbl_order_idtbl_order', $materialBalance['tbl_order_idtbl_order']);
            $this->db->where('tbl_material_idtbl_material', $materialBalance['tbl_material_idtbl_material']);
            $this->db->update('tbl_material_detail', $data); 
        }
    
        echo json_encode(array('success' => true));
    }
    

}