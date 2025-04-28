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

    public function getDeliveryByOrderId($orderId)
{
    return $this->db->select('d.idtbl_delivery_detail, d.deliver_quantity, d.delivery_date, d.deliveryId')
        ->from('tbl_delivery_detail d')
        ->where('d.tbl_order_idtbl_order', $orderId)
        ->get()
        ->result();
}    

    public function Deliverydetailinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['id'];

		$delivery_date = $this->input->post('delivery_date');
		$delivery_qtys = $this->input->post('delivery_qty');
		$inquiryid     = $this->input->post('inquiryid');
		$orderid       = $this->input->post('orderid');

        $updatedatetime=date('Y-m-d H:i:s');

        $plans = [];
	
		foreach ($delivery_date as $i => $date) {
			$plans[] = [
				'deliveryId' => 'PO-' . $orderid . '-DI-' . ($i + 1),
				'delivery_date' => $date,
				'deliver_quantity' => $delivery_qtys[$i],
				'tbl_inquiry_idtbl_inquiry' => $inquiryid,
				'tbl_order_idtbl_order' => $orderid,
                'insertdatetime' => $updatedatetime,
                'tbl_user_idtbl_user'=> $userID,
                'status' => '1'
			];
		}

            $this->db->insert_batch('tbl_delivery_detail', $plans);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-save';
                $actionObj->title='';
                $actionObj->message='Record Added Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='success';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('CRMDeliverydetail');                
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
                redirect('CRMDeliverydetail');
            }
        }
        public function Deliverydetailupdate(){
            $userID=$_SESSION['id'];

            $deliveryId = $this->input->post('deliveryId');
            $quantity = $this->input->post('deliver_quantity');
            $date = $this->input->post('delivery_date');

            $updatedatetime=date('Y-m-d H:i:s');
            $data = array(
                'deliver_quantity'=> $quantity,
                'delivery_date' => $date, 
                'updatedatetime' => $updatedatetime,
                'updateuser' => $userID
            );

            $this->db->where('deliveryId', $deliveryId);
            $this->db->update('tbl_delivery_detail', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-save';
                $actionObj->title='';
                $actionObj->message='Record Update Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='primary';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('CRMDeliverydetail');                
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
                redirect('CRMDeliverydetail');
            }
        }
    
    public function GetMachineType() {
        $inquiryid = $this->input->post('inquiryid');

        $this->db->distinct(); // Apply DISTINCT correctly
        $this->db->select('u.id, u.name');
        $this->db->from('machine_types AS u');
        $this->db->join('machine_ins AS mi', 'mi.machine_type_id = u.id', 'inner'); 
        $this->db->where('u.active', 1);

        // return $this->db->get()->result();
        $respond=$this->db->get();

        $data=array();

        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->id, "text"=>$row->name);
        }

        echo json_encode($data);
    }

    public function GetMachineModel() {
        $machineType = $this->input->post('machineType');

        $this->db->select('m.id, m.name');
        $this->db->from('machine_models AS m');
        $this->db->join('machine_ins AS mi', 'mi.machine_model_id = m.id', 'left');
        $this->db->where('mi.machine_type_id', $machineType); 
        $this->db->where('m.active', 1);
        $this->db->group_by('m.id'); 

        $respond=$this->db->get();

        $data=array();

        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->id, "text"=>$row->name);
        }

        echo json_encode($data);
    }
    
    public function GetSerialNumber() {
        $machineType = $this->input->post('machineType');
        $machineModel = $this->input->post('machineModel');

        $this->db->select('s_no');
        $this->db->from('machine_ins');
        $this->db->where('machine_type_id', $machineType); 
        $this->db->where('machine_model_id', $machineModel);
        $this->db->where('active', 1);

        $respond=$this->db->get();

        $data=array();

        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->s_no, "text"=>$row->s_no);
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


    public function getAllAvailableMachines() {
        $this->db->select('machine_ins.id, machine_ins.active, machine_ins.s_no,machine_ins.booking_startdate,machine_ins.booking_enddate, mt.name, mm.name as model');
        $this->db->from('machine_ins');
        $this->db->join('machine_types mt', 'machine_ins.machine_type_id = mt.id', 'left');
        $this->db->join('machine_models mm', 'machine_ins.machine_model_id = mm.id', 'left');
        $this->db->where('machine_ins.active', '1'); 
    
        $query = $this->db->get();
        return $query->result();
    }
    public function getInquiryByCustomerId($customer_id) {
        $this->db->select('idtbl_inquiry'); 
        $this->db->from('tbl_inquiry');
        $this->db->where('tbl_customer_idtbl_customer', $customer_id);
        $query = $this->db->get();
        return $query->result(); 
    }
    public function getOrderByInquiryId($inquiry_id) {
        $this->db->select('idtbl_order'); 
        $this->db->from('tbl_order');
        $this->db->where('tbl_inquiry_idtbl_inquiry', $inquiry_id);
        $query = $this->db->get();
        return $query->result(); 
    }

    public function getOrderQuantityById($order_id) {
        $this->db->select('quantity'); 
        $this->db->from('tbl_order_detail');
        $this->db->where('tbl_order_idtbl_order', $order_id);
        $query = $this->db->get();
        return $query->result(); 
    }

    
    
    
}