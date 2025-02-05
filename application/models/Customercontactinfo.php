<?php
class Customercontactinfo extends CI_Model{

	public function GetCustomerid($x){
		// if (empty($x) || !is_numeric($x)) {
        //     return []; 
        // }
        $this->db->where('tbl_customer_idtbl_customer', $x); 
        $query = $this->db->get('tbl_customer_contact_details');
        return $query->result();
  }


  public function Customercontactinsertupdate(){
	  $this->db->trans_begin();

	  $userID=$_SESSION['id'];

	  $name=$this->input->post('name');
	  $postion=$this->input->post('postion');
	  $mobileno=$this->input->post('mobileno');
	  $email=$this->input->post('email');
	  $customerid=$this->input->post('customerid');
	
	  $recordOption=$this->input->post('recordOption');
	  if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

	  $insertdatetime=date('Y-m-d H:i:s');

	  if($recordOption==1){
		  $data = array(
			  'name'=> $name, 
			  'position'=> $postion, 
			  'mobile_no'=> $mobileno, 
			  'email'=> $email, 
			  'tbl_customer_idtbl_customer'=> $customerid, 
			  'status'=> '1', 
			  'updatedatetime'=> $insertdatetime, 
			  'tbl_user_idtbl_user'=> $userID,
		  );

		  $this->db->insert('tbl_customer_contact_details', $data);

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
			  redirect('Customercontact/index/'.$customerid);                
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
			  redirect('Customercontact/index/'.$customerid); 
		  }
	  }
	  else{
		  $data = array(
			  'name'=> $name, 
			  'position'=> $postion, 
			  'mobile_no'=> $mobileno, 
			  'email'=> $email, 
			  'tbl_customer_idtbl_customer'=> $customerid,   
			  'status'=> '1', 
			  'updatedatetime'=> $insertdatetime, 
			  'tbl_user_idtbl_user'=> $userID,
		  );

		  $this->db->where('idtbl_customer_contact_details', $recordID);
		  $this->db->update('tbl_customer_contact_details', $data);

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
			  redirect('Customercontact/index/'.$customerid);              
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
			  redirect('Customercontact/index/'.$customerid); 
		  }
	  }
  }

  public function Customercontactstatus($x,$z,$y){
	  $this->db->trans_begin();

	  $userID=$_SESSION['userid'];
	  $recordID=$x;
	  $customerid=$z;
	  $type=$y;
	  $updatedatetime=date('Y-m-d H:i:s');

	  if($type==1){
		  $data = array(
			  'status' => '1',
			  'tbl_user_idtbl_user'=> $userID, 
			  'updatedatetime'=> $updatedatetime
		  );

		  $this->db->where('idtbl_customer_contact_details', $recordID);
		  $this->db->update('tbl_customer_contact_details', $data);

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
			  redirect('Customercontact/index/'.$customerid);              
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
			  redirect('Customercontact/index/'.$customerid); 
		  }
	  }
	  else if($type==2){
		  $data = array(
			  'status' => '2',
			  'tbl_user_idtbl_user'=> $userID, 
			  'updatedatetime'=> $updatedatetime
		  );

		  $this->db->where('idtbl_customer_contact_details', $recordID);
		  $this->db->update('tbl_customer_contact_details', $data);

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
			  redirect('Customercontact/index/'.$customerid);                 
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
			  redirect('Customercontact/index/'.$customerid); 
		  }
	  }
	  else if($type==3){
		  $data = array(
			  'status' => '3',
			  'tbl_user_idtbl_user'=> $userID, 
			  'updatedatetime'=> $updatedatetime
		  );

		  $this->db->where('idtbl_customer_contact_details', $recordID);
		  $this->db->update('tbl_customer_contact_details', $data);

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
			  redirect('Customercontact/index/'.$customerid);              
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
			  redirect('Customercontact/index/'.$customerid); 
		  }
	  }
  }
  public function Customercontactedit(){
	  $recordID=$this->input->post('recordID');

	  $this->db->select('*');
	  $this->db->from('tbl_customer_contact_details');
	  $this->db->where('idtbl_customer_contact_details', $recordID);
	  $this->db->where('status', 1);

	  $respond=$this->db->get();

	  $obj=new stdClass();
	  $obj->id=$respond->row(0)->idtbl_customer_contact_details;
	  $obj->name=$respond->row(0)->name;
	  $obj->position=$respond->row(0)->position;
	  $obj->mobile=$respond->row(0)->mobile_no;
	  $obj->email=$respond->row(0)->email;
	  echo json_encode($obj);
  }
}
