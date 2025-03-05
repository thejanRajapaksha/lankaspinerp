<?php
class Deliverydetailinfo extends CI_Model{
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
    
    public function GetDeliveryAndPackagingDetails() {
        $inquiryid = $this->input->post('inquiryid');
    
        $this->db->select('dd.deliver_quantity, dd.delivery_date, c.type as cloth_type, s.type as size');
        $this->db->from('tbl_delivery_detail dd');
        $this->db->join('tbl_cloth c', 'dd.tbl_cloth_idtbl_cloth = c.idtbl_cloth', 'left');
        $this->db->join('tbl_size s', 'dd.tbl_size_idtbl_size = s.idtbl_size', 'left');
        $this->db->where('dd.tbl_inquiry_idtbl_inquiry', $inquiryid);
        $deliveryResult = $this->db->get();
        $deliveryDetails = $deliveryResult->result_array();
    
        $this->db->select('pd.packed_quantity, pd.packaging_date, c.type as cloth_type, s.type as size');
        $this->db->from('tbl_packaging_detail pd');
        $this->db->join('tbl_cloth c', 'pd.tbl_cloth_idtbl_cloth = c.idtbl_cloth', 'left');
        $this->db->join('tbl_size s', 'pd.tbl_size_idtbl_size = s.idtbl_size', 'left');
        $this->db->where('pd.tbl_inquiry_idtbl_inquiry', $inquiryid);
        $packagingResult = $this->db->get();
        $packagingDetails = $packagingResult->result_array();
    
        $data = array(
            'delivery' => $deliveryDetails,
            'packaging' => $packagingDetails
        );
    
        return $data;
    }
    

    public function Packagingdetailinsertupdate() {
        $this->db->trans_begin();
    
        $userID = $_SESSION['userid'];
        $jsonObj = json_decode($this->input->post('tableData'), true);
        $inquiryid = $this->input->post('inquiryid'); 
        $insertdatetime = date('Y-m-d H:i:s');

        foreach ($jsonObj as $rowdata) {
            $clothTypeID = $rowdata['clothTypeID'];
            $sizeID = $rowdata['sizeID'];
            $quantity = $rowdata['quantity'];
            $packagingDate = $rowdata['date'];
            
            $PackagingDetailData = array(
                'packed_quantity' => $quantity,
                'packaging_date' => $packagingDate,
                'tbl_cloth_idtbl_cloth' => $clothTypeID,
                'tbl_size_idtbl_size' => $sizeID,
                'tbl_inquiry_idtbl_inquiry' => $inquiryid,
                'status' => '1',
                'insertdatetime' => $insertdatetime,
                'tbl_user_idtbl_user' => $userID
            );
            
            $this->db->insert('tbl_packaging_detail', $PackagingDetailData);
        }
    
        $this->db->trans_complete();
    
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
    
            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-save';
            $actionObj->title = '';
            $actionObj->message = 'Packaging Details Added Successfully';
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'success';
    
            $actionJSON = json_encode($actionObj);
            
        } else {
            $this->db->trans_rollback();
    
            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-warning';
            $actionObj->title = '';
            $actionObj->message = 'Packaging Details Addition Failed';
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'danger';
    
            $actionJSON = json_encode($actionObj);
        }

        echo $actionJSON;
    }    

    public function Deliverydetailinsertupdate() {
        $this->db->trans_begin();
    
        $userID = $_SESSION['userid'];
        $jsonObj = json_decode($this->input->post('tableData'), true);
        $inquiryid = $this->input->post('inquiryid');
        $insertdatetime = date('Y-m-d H:i:s');
    
        foreach ($jsonObj as $rowdata) {
            $clothTypeID = $rowdata['clothTypeID'];
            $sizeID = $rowdata['sizeID'];
            $quantity = $rowdata['quantity'];
            $deliveryDate = $rowdata['deliveryDate'];
    
            $DeliveryDetailData = array(
                'deliver_quantity' => $quantity,
                'delivery_date' => $deliveryDate,
                'tbl_cloth_idtbl_cloth' => $clothTypeID,
                'tbl_size_idtbl_size' => $sizeID,
                'tbl_inquiry_idtbl_inquiry' => $inquiryid,
                'status' => '1',
                'insertdatetime' => $insertdatetime,
                'tbl_user_idtbl_user' => $userID
            );
    
            $this->db->insert('tbl_delivery_detail', $DeliveryDetailData);
        }
    
        $this->db->trans_complete();
    
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
    
            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-save';
            $actionObj->title = '';
            $actionObj->message = 'Delivery Details Added Successfully';
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'success';
    
            $actionJSON = json_encode($actionObj);
    
        } else {
            $this->db->trans_rollback();
    
            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-warning';
            $actionObj->title = '';
            $actionObj->message = 'Delivery Details Addition Failed';
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
    
    public function Getclothtype() {
        $inquiryid = $this->input->post('inquiryid');

        $this->db->select('u.idtbl_cloth, u.type');
        $this->db->from('tbl_cloth AS u');
        $this->db->join('tbl_order_detail AS ua', 'ua.tbl_cloth_idtbl_cloth = u.idtbl_cloth', 'left');
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

    public function Getpaymenttype() {
        $inquiryid = $this->input->post('inquiryid');

        $this->db->select('u.idtbl_payment, u.p_type');
        $this->db->from('tbl_payment AS u');
        $this->db->where('u.status', 1);

        $respond=$this->db->get();

        $data=array();

        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->idtbl_payment, "text"=>$row->p_type);
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

    public function Getadvancepayment() {
        $inquiryid = $this->input->post('inquiryid');

        $this->db->select('advance');
        $this->db->from('tbl_order');
        $this->db->where('status', 1);
        $this->db->where('tbl_inquiry_idtbl_inquiry', $inquiryid);

        $row = $this->db->get()->row();
        $advance = isset($row->advance) ? $row->advance : 0;
        return array("advance" => $advance);
    }
    
    public function AddPayment() {
        $userID = $_SESSION['userid'];
        $insertdatetime = date('Y-m-d H:i:s');

        $paymentType = $this->input->post('paymenttype');
        $paymentDate = $this->input->post('paymentDate');
        $paymentAmount = $this->input->post('paymentAmount');
        $inquiryid = $this->input->post('inquiryid');

        $data = array(
            'tbl_inquiry_idtbl_inquiry' => $inquiryid,
            'tbl_payment_idtbl_payment ' => $paymentType,
            'payment_date' => $paymentDate,
            'amount' => $paymentAmount,
            'status' => '1',
            'insertdatetime' => $insertdatetime,
            'tbl_user_idtbl_user' => $userID
        );
    
        return $this->db->insert('tbl_payment_detail', $data);
    }
    
    public function GetPaymentDetails() {
        $inquiryid = $this->input->post('inquiryid');

        $this->db->select('p.p_type, u.payment_date, u.amount');
        $this->db->from('tbl_payment_detail AS u');
        $this->db->join('tbl_payment AS p', 'p.idtbl_payment = u.tbl_payment_idtbl_payment', 'left');
        $this->db->where('tbl_inquiry_idtbl_inquiry', $inquiryid);
        // $this->db->where('status', 1);
    
        $query = $this->db->get();
        return $query->result_array();
    }

    public function Deliverydetailstatus($x, $y){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
        $type=$y;
        $updatedatetime=date('Y-m-d H:i:s');

        if($type==1){
            $data = array(
                'status' => '1',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

			$this->db->where('idtbl_quotation', $recordID);
            $this->db->update('tbl_quotation', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-check';
                $actionObj->title='';
                $actionObj->message='Delivery Completed removed Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='warning';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('deliverydetail');                
            } else {
                $this->db->trans_rollback();

                $actionObj=new stdClass();
                $actionObj->icon='fas fa-warning';
                $actionObj->title='';
                $actionObj->message='Record Error';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='danger';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('deliverydetail');
            }
        }
        else if($type==4){
            $data = array(
                'status' => '4',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

			$this->db->where('idtbl_quotation', $recordID);
            $this->db->update('tbl_quotation', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-times';
                $actionObj->title='';
                $actionObj->message='Record Completed Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='success';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('deliverydetail');                
            } else {
                $this->db->trans_rollback();

                $actionObj=new stdClass();
                $actionObj->icon='fas fa-warning';
                $actionObj->title='';
                $actionObj->message='Record Error';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='danger';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('deliverydetail');
            }
        }
    }
    
}