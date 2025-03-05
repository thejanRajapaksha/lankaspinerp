<?php
class Printingdetailinfo extends CI_Model{
    public function Getmaterialcategory(){
        $this->db->select('`idtbl_res_material_category`, `category`');
        $this->db->from('tbl_res_material_category');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Orderdetailinsertupdate() {
        $this->db->trans_begin();
    
        $userID = $_SESSION['userid'];

        $jsonObj = json_decode($this->input->post('tableData'), true);
        $inquiryid = $this->input->post('inquiryid');
        $remark = $this->input->post('remark');
    
        $insertdatetime = date('Y-m-d H:i:s');
    
        $this->db->select('o.idtbl_order');
        $this->db->from('tbl_order AS o');
        $this->db->join('tbl_order_detail AS od', 'o.tbl_inquiry_idtbl_inquiry = od.tbl_inquiry_idtbl_inquiry', 'left');
        $this->db->where('o.tbl_inquiry_idtbl_inquiry', $inquiryid);
        $query = $this->db->get('tbl_order');
        $order = $query->row();
        $orderID = $order->idtbl_order;
    
        foreach ($jsonObj as $rowdata) {
            $clothType = $rowdata['col_1'];
            $printingComID = $rowdata['col_4'];
            $sewingComID = $rowdata['col_6'];
            $quantity = $rowdata['col_3'];
            $assigndate = $rowdata['col_8'];
            $designText = $rowdata['col_9'];
    
            $orderDetailData = array(
                'tbl_order_idtbl_order' => $orderID,
                'tbl_inquiry_idtbl_inquiry' => $inquiryid,
                'tbl_cloth_idtbl_cloth' => $clothType,
                'printing_com' => $printingComID,
                'sewing_com' => $sewingComID,
                'printing_qty' => $quantity,
                'assigndate' => $assigndate,
                'design_type' => $designText,
                'remark' => $remark,
                'status' => '1',
                'insertdatetime' => $insertdatetime,
                'tbl_user_idtbl_user' => $userID
            );
    
            $this->db->insert('tbl_printing_detail', $orderDetailData);
        }
    
        $this->db->trans_complete();
    
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
    
            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-save';
            $actionObj->title = '';
            $actionObj->message = 'Order Details Added Successfully';
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'success';
    
            $actionJSON = json_encode($actionObj);
            
        } else {
            $this->db->trans_rollback();
    
            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-warning';
            $actionObj->title = '';
            $actionObj->message = 'Order Details Addition Failed';
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'danger';
    
            $actionJSON = json_encode($actionObj);
        }

        echo $actionJSON;
    }

    public function Getprintingcompany() {
        $this->db->select('idtbl_supplier, name');
        $this->db->from('tbl_supplier');
        $this->db->where('status', 1);
        $this->db->where('tbl_vender_idtbl_vender ', 1);

        $respond=$this->db->get();

        $data=array();

        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->idtbl_supplier, "text"=>$row->name);
        }

        echo json_encode($data);
    }

    public function Getsewingcompany() {
        $this->db->select('idtbl_supplier, name');
        $this->db->from('tbl_supplier');
        $this->db->where('status', 1);
        $this->db->where('tbl_vender_idtbl_vender ', 2);

        $respond=$this->db->get();

        $data=array();

        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->idtbl_supplier, "text"=>$row->name);
        }

        echo json_encode($data);
    }

    public function Getcolorcompany() {
        $this->db->select('idtbl_supplier, name');
        $this->db->from('tbl_supplier');
        $this->db->where('status', 1);
        $this->db->where('tbl_vender_idtbl_vender ', 3);

        $respond=$this->db->get();

        $data=array();

        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->idtbl_supplier, "text"=>$row->name);
        }

        echo json_encode($data);
    }

    public function Getcuffcompany() {
        $this->db->select('idtbl_supplier, name');
        $this->db->from('tbl_supplier');
        $this->db->where('status', 1);
        $this->db->where('tbl_vender_idtbl_vender ', 3);

        $respond=$this->db->get();

        $data=array();

        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->idtbl_supplier, "text"=>$row->name);
        }

        echo json_encode($data);
    }

    public function Getcolorcode() {
        $this->db->select('idtbl_colour, type');
        $this->db->from('tbl_colour');
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $data=array();

        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->idtbl_colour, "text"=>$row->type);
        }

        echo json_encode($data);
    }

    public function Getclothtype() {
        $inquiryid = $this->input->post('inquiryid');

        $this->db->select('u.idtbl_cloth, u.type');
        $this->db->from('tbl_cloth AS u');
        $this->db->join('tbl_inquiry_detail AS ua', 'ua.tbl_cloth_idtbl_cloth = u.idtbl_cloth', 'left');
        $this->db->where('u.status', 1);
        $this->db->where('ua.tbl_inquiry_idtbl_inquiry', $inquiryid);
        $this->db->group_by('u.idtbl_cloth');

        $respond=$this->db->get();

        $data=array();

        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->idtbl_cloth, "text"=>$row->type);
        }

        echo json_encode($data);
    }

    public function Getdesigntype() {
        $inquiryid = $this->input->post('inquiryid');
        $clothId = $this->input->post('RclothId'); 
    
        $this->db->select('tbl_order_idtbl_order');
        $this->db->from('tbl_order_detail');
        $this->db->where('tbl_inquiry_idtbl_inquiry', $inquiryid);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            $order_id = $query->row()->tbl_order_idtbl_order;
    
            $this->db->select('design_type');
            $this->db->from('tbl_printing_detail u');
            $this->db->where('u.status', 1);
            $this->db->where('u.tbl_inquiry_idtbl_inquiry', $inquiryid);
            $this->db->where('u.tbl_cloth_idtbl_cloth', $clothId);  
            $this->db->where('u.tbl_order_idtbl_order', $order_id);
            $this->db->group_by('u.design_type');
    
            $respond = $this->db->get();
    
            $data = array();
    
            foreach ($respond->result() as $row) {
                $data[] = array(
                    "id" => $row->design_type,  
                    "text" => $row->design_type 
                );
            }
    
            echo json_encode($data);
        } 
    }
    
    public function Getorderdetails($inquiryid, $customerid) {
        $this->db->select('tbl_order_idtbl_order');
        $this->db->from('tbl_order_detail');
        $this->db->where('tbl_inquiry_idtbl_inquiry', $inquiryid);
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $order_id = $row->tbl_order_idtbl_order;
    
            $this->db->select('c.type as cloth_type, pd.printing_qty, sp.name as printing_company, ss.name as sewing_company, pd.assigndate, pd.design_type, pd.remark');
            $this->db->from('tbl_printing_detail pd');
            $this->db->join('tbl_cloth c', 'pd.tbl_cloth_idtbl_cloth = c.idtbl_cloth', 'left');
            $this->db->join('tbl_supplier sp', 'pd.printing_com = sp.idtbl_supplier', 'left');
            $this->db->join('tbl_supplier ss', 'pd.sewing_com = ss.idtbl_supplier', 'left');
            $this->db->where('pd.tbl_order_idtbl_order', $order_id);
            $result = $this->db->get();
            $order_details = $result->result_array();
    
            $this->db->select('CMcategorytypeID, sc.name as colorcuff_company, cc.type as colour, CMOrderQuantity, CMOrderDate, CMremark');
            $this->db->from('tbl_colorcuff');
            $this->db->join('tbl_colour cc', 'CMColorcodeID = cc.idtbl_colour', 'left');
            $this->db->join('tbl_supplier sc', 'CMSupplierID = sc.idtbl_supplier', 'left');
            $this->db->where('tbl_inquiry_idtbl_inquiry', $inquiryid);
            $query2 = $this->db->get();
            $additional_details = $query2->result_array();
    
            return [
                'order_details' => $order_details,
                'additional_details' => $additional_details
            ];
        }
    }
    
    public function GetReceiveorderInfoDetails($inquiryid, $customerid) {
        $this->db->select('tbl_order_idtbl_order');
        $this->db->from('tbl_order_detail');
        $this->db->where('tbl_inquiry_idtbl_inquiry', $inquiryid);
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $order_id = $row->tbl_order_idtbl_order;
 
            $this->db->select('c.type as cloth_type, tpr.received_qty, tpr.received_date, sp.name as printing_company, ss.name as sewing_company, tpr.design_type');
            $this->db->from('tbl_printing_receive tpr');
            $this->db->join('tbl_cloth c', 'tpr.tbl_cloth_idtbl_cloth = c.idtbl_cloth', 'left');
            $this->db->join('tbl_supplier sp', 'tpr.printing_com = sp.idtbl_supplier', 'left');
            $this->db->join('tbl_supplier ss', 'tpr.sewing_com = ss.idtbl_supplier', 'left');
            $this->db->where('tpr.tbl_inquiry_idtbl_inquiry', $inquiryid);
            $result = $this->db->get();
            $received_order_details = $result->result_array();
    
            $this->db->select('tpr.colorcuff, sc.name as colorcuff_com, tpr.received_qty, tpr.received_date');
            $this->db->from('tbl_printing_receive tpr');
            $this->db->join('tbl_supplier sc', 'tpr.colorcuff_com = sc.idtbl_supplier', 'left');
            $this->db->where('tpr.tbl_inquiry_idtbl_inquiry', $inquiryid);
            $query2 = $this->db->get();
            $received_colorcuff_details = $query2->result_array();
    
            return [
                'received_order_details' => $received_order_details,
                'received_colorcuff_details' => $received_colorcuff_details
            ];
        } else {
            return [
                'received_order_details' => [],
                'received_colorcuff_details' => []
            ];
        }
    }    

    public function GetCustomerName($customerid) {
        $this->db->select('name as customer_name');
        $this->db->from('tbl_customer');
        $this->db->where('idtbl_customer', $customerid);
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            return $query->row()->customer_name;
        } else {
            return 'Unknown Customer';
        }
    }
    

    public function SaveReceiveDetails($receiveDetails, $inquiryid, $Rremark) {
        $userID = $_SESSION['userid'];
        $insertdatetime = date('Y-m-d H:i:s');
        $success = false;
    
        $this->db->select('tbl_order_idtbl_order');
        $this->db->from('tbl_order_detail');
        $this->db->where('tbl_inquiry_idtbl_inquiry', $inquiryid);
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            $order_id = $query->row()->tbl_order_idtbl_order;
    
            foreach ($receiveDetails as $detail) {
                $data = array(
                    'tbl_cloth_idtbl_cloth' => $detail['clothTypeID'],
                    'printing_com' => !empty($detail['printingCom']) ? $detail['printingCom'] : null,
                    'sewing_com' => !empty($detail['sewingCom']) ? $detail['sewingCom'] : null, 
                    'colorcuff_com' => !empty($detail['colorcom']) ? $detail['colorcom'] : null, 
                    'design_type' => !empty($detail['designType']) ? $detail['designType'] : null, 
                    'colorcuff' => !empty($detail['colorcuff']) ? $detail['colorcuff'] : null, 
                    'received_qty' => $detail['receivedQuantity'],
                    'received_date' => $detail['receiveDate'],
                    'tbl_order_idtbl_order' => $order_id,
                    'tbl_inquiry_idtbl_inquiry' => $inquiryid,
                    'Rremark' => $Rremark,
                    'status' => '1',
                    'insertdatetime' => $insertdatetime,
                    'tbl_user_idtbl_user' => $userID
                );
    
                $this->db->insert('tbl_printing_receive', $data);
            }
    
            $success = true;
        }
    
        return $success;
    }
    
    public function SavecolorcuffDetails($colorcuffDetails, $inquiryid, $CMremark) {
        $userID = $_SESSION['userid'];
        $insertdatetime = date('Y-m-d H:i:s');
        $success = false;
    
        $this->db->select('tbl_order_idtbl_order');
        $this->db->from('tbl_order_detail');
        $this->db->where('tbl_inquiry_idtbl_inquiry', $inquiryid);
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            $order_id = $query->row()->tbl_order_idtbl_order;
    
            foreach ($colorcuffDetails as $detail) {
                $data = array(                  
                    'CMcategorytypeID' => $detail['CMcategorytypeID'],
                    'CMSupplierID' => $detail['CMSupplierID'],
                    'CMColorcodeID' => $detail['CMColorcodeID'],
                    'CMOrderDate' => $detail['CMOrderDate'],
                    'CMOrderQuantity' => $detail['CMOrderQuantity'], 
                    'tbl_order_idtbl_order' => $order_id,
                    'tbl_inquiry_idtbl_inquiry' => $inquiryid,
                    'CMremark' => $CMremark,
                    'status' => '1',
                    'insertdatetime' => $insertdatetime,
                    'tbl_user_idtbl_user' => $userID
                );
    
                $this->db->insert('tbl_colorcuff', $data);
            }
    
            $success = true;
        }
    
        return $success;
    }
    
}