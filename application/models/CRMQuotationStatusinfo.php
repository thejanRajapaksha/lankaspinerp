<?php
class CRMQuotationStatusinfo extends CI_Model{
    public function Rejectedinquiryinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $tbl_reason_idtbl_reason=$this->input->post('tbl_reason_idtbl_reason');
        $tbl_quotation_idtbl_quotation=$this->input->post('tbl_quotation_idtbl_quotation');
        $remarks=$this->input->post('remarks');
      
        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $insertdatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
                'tbl_reason_idtbl_reason'=> $tbl_reason_idtbl_reason,
                'tbl_quotation_idtbl_quotation'=> $tbl_quotation_idtbl_quotation, 
                'remarks'=> $remarks, 
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime,
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->insert('tbl_quotation', $data);

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
                redirect('Rejectedinquiry');                
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
                redirect('Rejectedinquiry');
            }
        }
        else{
            $data = array(
                'tbl_reason_idtbl_reason'=> $tbl_reason_idtbl_reason,
                'tbl_quotation_idtbl_quotation'=> $tbl_quotation_idtbl_quotation, 
                'remarks'=> $remarks,  
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->where('idtbl_quotation', $recordID);
            $this->db->update('tbl_quotation', $data);

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
                redirect('Rejectedinquiry');                
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
                redirect('Rejectedinquiry');
            }
        }
    }
    public function Rejectedinquirystatus($x, $y){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
        $type=$y;
        $updatedatetime=date('Y-m-d H:i:s');

        if($type==1){
            $data = array( 
                'status'=> '1', 
                'updatedatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

			$this->db->where('idtbl_quotation', $recordID);
            $this->db->update('tbl_quotation', $data);

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
                redirect('Rejectedinquiry');                
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
                redirect('Rejectedinquiry');
            }
        }
        else if($type==2){
            $data = array(
                'status'=> '2', 
                'updatedatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

			$this->db->where('idtbl_quotation', $recordID);
            $this->db->update('tbl_quotation', $data);

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
                redirect('Rejectedinquiry');                
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
                redirect('Rejectedinquiry');
            }
        }
        else if($type==3){
			$data = array( 
                'status'=> '3', 
                'updatedatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

			$this->db->where('idtbl_quotation', $recordID);
            $this->db->update('tbl_quotation', $data);

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
                redirect('Rejectedinquiry');                
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
                redirect('Rejectedinquiry');
            }
        }
    }
    public function Rejectedinquiryedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_quotation');
        $this->db->where('idtbl_quotation', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_quotation;
        $obj->tbl_reason_idtbl_reason=$respond->row(0)->tbl_reason_idtbl_reason;
        $obj->tbl_quotation_idtbl_quotation=$respond->row(0)->tbl_quotation_idtbl_quotation;
        $obj->remarks=$respond->row(0)->remarks;

        echo json_encode($obj);
    }

    public function GetRejectedinquiryList(){
        $this->db->select('idtbl_quotation, tbl_reason_idtbl_reason, tbl_quotation_idtbl_quotation, remarks');
        $this->db->from('tbl_quotation');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getreasontype(){
        $this->db->select('idtbl_reason, type');
        $this->db->from('tbl_reason');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getquotationid(){
        $this->db->select('idtbl_quotation');
        $this->db->from('tbl_quotation');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
}
