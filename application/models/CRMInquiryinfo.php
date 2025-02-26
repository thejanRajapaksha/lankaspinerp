<?php
class CRMInquiryinfo extends CI_Model {
    public function Inquiryinsertupdate() {
        $this->db->trans_begin();
        
        $userID = $_SESSION['id'];
        $tableData = $this->input->post('data');//json_decode($this->input->post('tableData'), true); 
        $insertdatetime=date('Y-m-d H:i:s');
        $updatedatetime=date('Y-m-d H:i:s');
        
        $tbl_customer_idtbl_customer = $tableData[0]['tbl_customer_idtbl_customer']; 
        $date = $tableData[0]['date']; 

        // Insert into tbl_inquiry
        $inquiryData = [
            'tbl_customer_idtbl_customer' => $tbl_customer_idtbl_customer,
            'date' => $date,
            'status' => '1',
            'insertdatetime' => $insertdatetime,
            'tbl_user_idtbl_user' => $userID
        ];
        $this->db->insert('tbl_inquiry', $inquiryData);
        $inquiryID = $this->db->insert_id();

        // Insert into tbl_inquiry_detail
        foreach ($tableData as $rowdata) {
            $tbl_salesrep_idtbl_salesrep = $rowdata['tbl_salesrep_idtbl_salesrep'];
            $tbl_material_idtbl_material = $rowdata['tbl_material_idtbl_material'];
            $tbl_cloth_idtbl_cloth = $rowdata['tbl_cloth_idtbl_cloth'];
            $quantity = $rowdata['quantity'];

            $detailData = [
                'tbl_inquiry_idtbl_inquiry' => $inquiryID,
                'tbl_salesrep_idtbl_salesrep' => $tbl_salesrep_idtbl_salesrep,
                'tbl_cloth_idtbl_cloth' => $tbl_cloth_idtbl_cloth,
                'tbl_material_idtbl_material' => $tbl_material_idtbl_material,                
                'quantity' => $quantity,
                'status' => '1',
                'insertdatetime' => $insertdatetime,
                'tbl_user_idtbl_user' => $userID
            ];
            $this->db->insert('tbl_inquiry_detail', $detailData);
        }

        //$this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            
            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-save';
            $actionObj->title = '';
            $actionObj->message = 'Record Added Successfully';
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'success';

            $actionJSON = json_encode($actionObj);
            
            $this->session->set_flashdata('msg', $actionJSON);
            //redirect('CRMInquiry');                
            return true;
        } else {
            $this->db->trans_rollback();

            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-warning';
            $actionObj->title = '';
            $actionObj->message = 'Record Error';
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'danger';

            $actionJSON = json_encode($actionObj);
            
            $this->session->set_flashdata('msg', $actionJSON);
            //redirect('CRMInquiry');
            return false;
        }
    }
    
    public function Inquirystatus($x, $y){
        $this->db->trans_begin();

        $userID=$_SESSION['id'];
        $recordID=$x;
        $type=$y;
        $updatedatetime=date('Y-m-d H:i:s');

        if($type==1){
            $data = array( 
                'status'=> '1', 
                'updatedatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

			$this->db->where('idtbl_inquiry', $recordID);
            $this->db->update('tbl_inquiry', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-check';
                $actionObj->title='';
                $actionObj->message='Record Activate Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='success';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('CRMInquiry');                
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
                redirect('CRMInquiry');
            }
        }
        else if($type==2){
            $data = array(
                'status'=> '2', 
                'updatedatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

			$this->db->where('idtbl_inquiry', $recordID);
            $this->db->update('tbl_inquiry', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-times';
                $actionObj->title='';
                $actionObj->message='Record Deactivate Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='warning';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('CRMInquiry');                
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
                redirect('CRMInquiry');
            }
        }
        else if($type==3){
			$data = array( 
                'status'=> '3', 
                'updatedatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

			$this->db->where('idtbl_inquiry', $recordID);
            $this->db->update('tbl_inquiry', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-trash-alt';
                $actionObj->title='';
                $actionObj->message='Record Remove Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='danger';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('CRMInquiry');                
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
                redirect('CRMInquiry');
            }
        }
    }

    public function Inquirydetailstatus($x, $y){
        $this->db->trans_begin();

        $userID=$_SESSION['id'];
        $recordID=$x;
        $type=$y;
        $updatedatetime=date('Y-m-d H:i:s');

        if($type==1){
            $data = array( 
                'status'=> '1', 
                'updatedatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

			$this->db->where('idtbl_inquiry_detail', $recordID);
            $this->db->update('tbl_inquiry_detail', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-check';
                $actionObj->title='';
                $actionObj->message='Record Activate Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='success';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('CRMInquiry');                
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
                redirect('CRMInquiry');
            }
        }
        else if($type==2){
            $data = array(
                'status'=> '2', 
                'updatedatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

			$this->db->where('idtbl_inquiry_detail', $recordID);
            $this->db->update('tbl_inquiry_detail', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-times';
                $actionObj->title='';
                $actionObj->message='Record Deactivate Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='warning';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('CRMInquiry');                
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
                redirect('CRMInquiry');
            }
        }
        else if($type==3){
			$data = array( 
                'status'=> '3', 
                'updatedatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

			$this->db->where('idtbl_inquiry_detail', $recordID);
            $this->db->update('tbl_inquiry_detail', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-trash-alt';
                $actionObj->title='';
                $actionObj->message='Record Remove Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='danger';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('CRMInquiry');                
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
                redirect('CRMInquiry');
            }
        }
    }

    public function Inquiryedit(){
        $recordID = $this->input->post('recordID');
    
        $this->db->select('*');
        $this->db->from('tbl_inquiry');
        $this->db->where('idtbl_inquiry', $recordID);
        $this->db->where('status', 1);
    
        $respond = $this->db->get();
    
        if ($respond->num_rows() > 0) {
            $obj = new stdClass();
            $obj->idtbl_inquiry = $respond->row(0)->idtbl_inquiry;
            $obj->tbl_customer_idtbl_customer = $respond->row(0)->tbl_customer_idtbl_customer;
            // Add other fields as needed
            echo json_encode($obj);
        } else {
            echo json_encode(null); // Return null if no record found
        }
    }

    public function Getcustomername(){
        $this->db->select('idtbl_customer, name');
        $this->db->from('tbl_customer');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getsalesrepname(){
        $this->db->select('idtbl_salesrep, name');
        $this->db->from('tbl_salesrep');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getclothtype(){
        $this->db->select('idtbl_cloth, type');
        $this->db->from('tbl_cloth');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getmaterialtype(){
        $this->db->select('idtbl_material, type');
        $this->db->from('tbl_material');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
}
