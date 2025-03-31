<?php
class Orderdetailinfo extends CI_Model{
    public function Orderdetailinsertupdate() {
        $this->db->trans_begin();
    
        $userID = $_SESSION['id'];
        $orderID = null; 
    
        // Retrieve data from POST
        $jsonObj = json_decode($this->input->post('tableData'), true);
        $recordID = $this->input->post('recordOption');
        $itemId = $this->input->post('itemId');
        $date = $this->input->post('date');
        $qty = $this->input->post('qty');
        $inquiryid = $this->input->post('inquiryid');
        $quotationid = $this->input->post('quotationid');
    
        $insertdatetime = date('Y-m-d H:i:s');
    
        $this->db->select('o.idtbl_order');
        $this->db->from('tbl_order AS o');
        $this->db->join('tbl_order_detail AS od', 'o.tbl_inquiry_idtbl_inquiry = od.tbl_inquiry_idtbl_inquiry', 'left');
        $this->db->where('o.tbl_inquiry_idtbl_inquiry', $inquiryid);
        $query = $this->db->get('tbl_order');
        $order = $query->row();
    
        if (!$order && $recordID == 1) {
            // Create a new order if it doesn't exist
            $orderData = array(
                'tbl_inquiry_idtbl_inquiry' => $inquiryid,
                'idtbl_order' => $orderID,
                'insertdatetime' => $insertdatetime,
                'tbl_user_idtbl_user' => $userID
            );
    
            $this->db->insert('tbl_order', $orderData);
            $orderID = $this->db->insert_id();
        } else {
            $orderID = $order->idtbl_order;
        }
    
        // Loop through each record and insert into tbl_order_detail
        foreach ($jsonObj as $rowdata) {
            $item = $rowdata['col_2'];
            $orderDate = $rowdata['col_4'];
            $quantity = $rowdata['col_5'];
            // $quantity = $rowdata['col_7'];
    
            $orderDetailData = array(
                'tbl_order_idtbl_order' => $orderID,
                'tbl_inquiry_idtbl_inquiry' => $inquiryid,
                'tbl_products_idtbl_products' => $item,
                // 'tbl_material_idtbl_material' => $materialType,
                'order_date' => $orderDate,
                'quantity' => $quantity,
                'status' => '1',
                'insertdatetime' => $insertdatetime,
                'tbl_user_idtbl_user' => $userID
            );
    
            $this->db->insert('tbl_order_detail', $orderDetailData);
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


    
    
    public function PaymentDetailInsertUpdate() {
        $this->db->trans_begin();
    
        $userID = $_SESSION['userid'];
    
        $bank = $this->input->post('bank');
        $paymenttype = $this->input->post('paymenttype');
        $advance = $this->input->post('advance');
        $pdate = $this->input->post('pdate');
        $tbl_inquiry_idtbl_inquiry = $this->input->post('inquiryid');
    
        $recordOption = $this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))) {
            $recordID = $this->input->post('recordID');
        }
    
        $insertdatetime = date('Y-m-d H:i:s');
        $updatedatetime = date('Y-m-d H:i:s');
    
        if($recordOption == 1) {
            $data = array(
                'tbl_bank_idtbl_bank' => $bank,
                'tbl_payment_idtbl_payment' => $paymenttype,
                'advance' => $advance,
                'order_sdate' => $pdate,
                'tbl_inquiry_idtbl_inquiry' => $tbl_inquiry_idtbl_inquiry,
                'insertdatetime' => $insertdatetime,
                'tbl_user_idtbl_user' => $userID,
                'status'=> '1',
            );
    
            $this->db->insert('tbl_order', $data);
    
            $this->db->trans_complete();
    
            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
    
                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-save';
                $actionObj->title = '';
                $actionObj->message = 'Payment Details Added Successfully';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'success';
    
                echo $actionJSON = json_encode($actionObj);
    
                // $this->session->set_flashdata('msg', $actionJSON);
            } else {
                $this->db->trans_rollback();
    
                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-warning';
                $actionObj->title = '';
                $actionObj->message = 'Error Adding Payment Details';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'danger';
    
                echo $actionJSON = json_encode($actionObj);
    
                // $this->session->set_flashdata('msg', $actionJSON);
            }
        } else {
            $data = array(
                'tbl_bank_idtbl_bank' => $bank,
                'tbl_payment_idtbl_payment ' => $paymenttype,
                'advance' => $advance,
                'order_sdate' => $pdate,
                'tbl_inquiry_idtbl_inquiry' => $tbl_inquiry_idtbl_inquiry,
                'updatedatetime' => $updatedatetime,
                'tbl_user_idtbl_user' => $userID,
            );
    
            $this->db->where('idtbl_order', $recordID);
            $this->db->update('tbl_order', $data);
    
            $this->db->trans_complete();
    
            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
    
                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-save';
                $actionObj->title = '';
                $actionObj->message = 'Payment Details Updated Successfully';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'primary';
    
                $actionJSON = json_encode($actionObj);
    
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Orderdetail');
            } else {
                $this->db->trans_rollback();
    
                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-warning';
                $actionObj->title = '';
                $actionObj->message = 'Error Updating Payment Details';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'danger';
    
                $actionJSON = json_encode($actionObj);
    
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Orderdetail');
            }
        }
    }

    public function Getinquirydetails(){
        $recordID=$this->input->post('recordID');
        
        $this->db->select('tbl_quotation.idtbl_quotation, tbl_quotation.tbl_inquiry_idtbl_inquiry, tbl_inquiry.tbl_colour_idtbl_colour, tbl_inquiry.tbl_size_idtbl_size');
        $this->db->from('tbl_quotation');
        $this->db->join('tbl_inquiry','tbl_inquiry.idtbl_inquiry = tbl_quotation.tbl_inquiry_idtbl_inquiry','right');
        $this->db->where('tbl_inquiry.status', 1);
        $this->db->where('tbl_quotation.idtbl_quotation', $recordID);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->idtbl_quotation=$respond->row(0)->idtbl_quotation;
        $obj->tbl_inquiry_idtbl_inquiry=$respond->row(0)->tbl_inquiry_idtbl_inquiry;
        $obj->tbl_colour_idtbl_colour=$respond->row(0)->tbl_colour_idtbl_colour;
        $obj->tbl_size_idtbl_size=$respond->row(0)->tbl_size_idtbl_size;

        echo json_encode($obj);
    }
    
    public function GetQuotationid() {
        $this->db->select('idtbl_quotation');
        $this->db->from('tbl_quotation');
        $this->db->where('status', 1);
        $this->db->where('approvestatus', 1);

        return $this->db->get()->result();
    }

    public function Getid($z, $y)
    {
        $qua = $y;

        $quatationid = $z;

        return  $quatationid;
    }

    public function Getclothtype() {
        $inquiryid = $this->input->post('inquiryid');

        $this->db->select('u.idtbl_cloth, u.type');
        $this->db->from('tbl_cloth AS u');
        $this->db->join('tbl_inquiry_detail AS ua', 'ua.tbl_cloth_idtbl_cloth = u.idtbl_cloth', 'left');
        $this->db->where('u.status', 1);
        $this->db->where('ua.tbl_inquiry_idtbl_inquiry', $inquiryid);
        $this->db->group_by('u.idtbl_cloth');

        // return $this->db->get()->result();
        $respond=$this->db->get();

        $data=array();

        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->idtbl_cloth, "text"=>$row->type);
        }

        echo json_encode($data);
    }

    public function Getsizetype() {
        $this->db->select('idtbl_size, type');
        $this->db->from('tbl_size');
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $data=array();

        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->idtbl_size, "text"=>$row->type);
        }

        echo json_encode($data);
    }

    public function Getbankname() {
        $this->db->select('idtbl_bank, bank');
        $this->db->from('tbl_bank');
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $data=array();

        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->idtbl_bank, "text"=>$row->bank);
        }

        echo json_encode($data);
    }

    public function Getpaymenttype() {
        $this->db->select('idtbl_payment, p_type');
        $this->db->from('tbl_payment ');
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $data=array();

        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->idtbl_payment, "text"=>$row->p_type);
        }

        echo json_encode($data);
    }

    public function GetQuantity() {
        $inquiryid = $this->input->post('inquiryid');
        $clothtypeId = $this->input->post('clothtypeId');

        $this->db->select('quantity');
        $this->db->from('tbl_inquiry_detail');
        $this->db->where('status', 1);
        $this->db->where('tbl_inquiry_idtbl_inquiry', $inquiryid);
        $this->db->where('tbl_cloth_idtbl_cloth', $clothtypeId);

        $result = $this->db->get()->row();

        echo json_encode($result);
    }

    public function Getmaterialtype() {
        $inquiryid = $this->input->post('inquiryid');
        $clothtypeId = $this->input->post('clothtypeId');

        $this->db->select('ua.idtbl_material, ua.type');
        $this->db->from('tbl_inquiry_detail AS u');
        $this->db->join('tbl_material AS ua', 'ua.idtbl_material = u.tbl_material_idtbl_material', 'left');
        $this->db->where('u.tbl_inquiry_idtbl_inquiry', $inquiryid);
        $this->db->where('u.tbl_cloth_idtbl_cloth', $clothtypeId);
        $this->db->where('u.status', 1);

        $respond=$this->db->get();

        $data=array();

        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->idtbl_material, "text"=>$row->type);
        }

        echo json_encode($data);
    }

    public function Orderformunitprice() {
        $productid = $this->input->post('productid');
        $getid = $this->input->post('getid');
        $customer = $this->input->post('customer');

        $this->db->select('u.quantity');
        $this->db->from('tbl_inquiry_detail AS u');
        $this->db->join('tbl_inquiry AS ua', 'ua.idtbl_inquiry = u.tbl_inquiry_idtbl_inquiry', 'left');
        $this->db->where('u.tbl_material_idtbl_material', $productid);
        $this->db->where('ua.tbl_customer_idtbl_customer', $customer);
        $this->db->where('u.tbl_inquiry_idtbl_inquiry', $getid);
        $this->db->where('u.status', 1);

        $respond = $this->db->get();

        if ($respond->num_rows() > 0) {
            $obj = new stdClass();
            $obj->quantity = $respond->row(0)->quantity;
            echo json_encode($obj);
        } else {
            echo json_encode(['error' => 'No data found']);
        }
    }

    public function Getcustomer($z, $y){
        $getid = $z;
        $getcusid = $y;

        $this->db->select('`tbl_customer_idtbl_customer`, `name`');
        $this->db->from('tbl_inquiry AS u');
        $this->db->join('tbl_customer AS ua', 'ua.idtbl_customer = u.tbl_customer_idtbl_customer', 'left');
        $this->db->where('u.status', 1);
        $this->db->where('tbl_customer_idtbl_customer', $getcusid);
        $this->db->group_by('tbl_customer_idtbl_customer');
        return $respond = $this->db->get();
    }

    public function Getorderdetails($inquiryid) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $this->db->select('tbl_order_idtbl_order');
        $this->db->from('tbl_order_detail');
        $this->db->where('tbl_inquiry_idtbl_inquiry', $inquiryid);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $order_id = $row->tbl_order_idtbl_order;

            $this->db->select('p.p_type, o.advance, o.order_sdate, b.bank as bname,
                                od.tbl_cloth_idtbl_cloth, od.tbl_size_idtbl_size, od.quantity, od.cutting_qty, od.idtbl_order_detail,
                                c.type as cloth_type, s.type as size, m.type as material_type');
            $this->db->from('tbl_order o');
            $this->db->join('tbl_order_detail od', 'o.idtbl_order = od.tbl_order_idtbl_order', 'left');
            $this->db->join('tbl_payment p', 'o.tbl_payment_idtbl_payment = p.p_type', 'left');
            $this->db->join('tbl_cloth c', 'od.tbl_cloth_idtbl_cloth = c.idtbl_cloth', 'left');
            $this->db->join('tbl_size s', 'od.tbl_size_idtbl_size = s.idtbl_size', 'left');
            $this->db->join('tbl_material m', 'od.tbl_material_idtbl_material = m.idtbl_material', 'left');
            $this->db->join('tbl_bank b', 'o.tbl_bank_idtbl_bank  = b.idtbl_bank', 'left');
            $this->db->where('o.idtbl_order', $order_id);
            $result = $this->db->get();

            return $result->result_array();
        } else {
            return [];
        }
    }
    
    public function updateCuttingQty($id, $cuttingQty) {
        // Update the database
        $this->db->set('cutting_qty', $cuttingQty);
        $this->db->where('idtbl_order_detail ', $id); // Adjust this according to your schema
        $this->db->update('tbl_order_detail');
    }

    public function getItemsByCustomer($customer_id)
    {
        $this->db->select('tbl_inquiry_detail.tbl_products_idtbl_product AS idtbl_product, tbl_products.product');
        $this->db->from('tbl_inquiry_detail');
        $this->db->join('tbl_inquiry', 'tbl_inquiry_detail.idtbl_inquiry_detail = tbl_inquiry.idtbl_inquiry');
        $this->db->join('tbl_products', 'tbl_inquiry_detail.tbl_products_idtbl_product = tbl_products.idtbl_product');
        $this->db->where('tbl_inquiry.tbl_customer_idtbl_customer', $customer_id);
        $this->db->group_by('tbl_inquiry_detail.tbl_products_idtbl_product');
        $query = $this->db->get();

        return $query->result();
    }


}
