<?php class Supplierinfo extends CI_Model {

	public function GetSuppliercategory() {
		$this->db->select('idtbl_supplier_type, type');
		$this->db->from('tbl_supplier_type');
		$this->db->where('status', 1);

		return $respond=$this->db->get();
	}


	public function Supplierinsertupdate() {
		$this->db->trans_begin();

		$userID=$_SESSION['id'];

		$supplier_name=$this->input->post('supplier_name');
		$suppliertype=$this->input->post('suppliertype');
		$business_regno=$this->input->post('business_regno');
		$nbtno=$this->input->post('nbtno');
		$svatno=$this->input->post('svatno');
		$telephoneno=$this->input->post('telephoneno');
		$faxno=$this->input->post('faxno');
		$vatno=$this->input->post('vatno');
		$line1=$this->input->post('line1');
		$line2=$this->input->post('line2');
		$city=$this->input->post('city');
		$state=$this->input->post('state');
		$dline1=$this->input->post('dline1');
		$dline2=$this->input->post('dline2');
		$dcity=$this->input->post('dcity');
		$dstate=$this->input->post('dstate');
		$business_status=$this->input->post('bstatus');
		$payementmethod=$this->input->post('payementmethod');
		$credit_days=$this->input->post('credit_days');
		$company_id=$this->input->post('f_company_id');
		$branch_id=$this->input->post('f_branch_id');
		// $potalcode=$this->input->post('potalcode');
		// $country=$this->input->post('country');

		$recordOption=$this->input->post('recordOption');

		if( !empty($this->input->post('recordID'))) {
			$recordID=$this->input->post('recordID');
		}

		$insertdatetime=date('Y-m-d H:i:s');

		if($recordOption==1) {
			$data=array('name'=> $supplier_name,
				'bus_reg_no'=> $business_regno,
				'nbt_no'=> $nbtno,
				'svat_no'=> $svatno,
				'telephone_no'=> $telephoneno,
				'fax_no'=> $faxno,
				'address_line1'=> $line1,
				'delivery_address_line1'=> $dline1,
				'address_line2'=> $line2,
				'delivery_address_line2'=> $dline2,
				'city'=> $city,
				'delivery_city'=> $dcity,
				'state'=> $state,
				'delivery_state'=> $dstate,
				// 'postal_code'=> $potalcode,
				// 'country'=> $country,
				'vat_no'=> $vatno,
				'business_status'=> $business_status,
				'payment_method'=> $payementmethod,
				'credit_days'=> $credit_days,
				'tbl_supplier_type_idtbl_supplier_type'=> $suppliertype,
				'company_id'=> $company_id, 
				'company_branch_id'=> $branch_id, 
				'status'=> '1',
				'insertdatetime'=> $insertdatetime,
				'tbl_user_idtbl_user'=> $userID,
			);

			$this->db->insert('tbl_supplier', $data);

			$insertId=$this->db->insert_id();

			// Check if images are uploaded
			if ( !empty($_FILES['image']['name'])) {
				// Configure upload settings for image1
				$config1['upload_path']='./images/supplier_br_cetificate'; // Set the upload path for image1
				$config1['allowed_types']='gif|jpg|png|jpeg';
				$config1['max_size']=10000;
				$this->load->library('upload', $config1);

				// Upload image1
				$this->upload->initialize($config1);

				if (!$this->upload->do_upload('image')) {
					$error = $this->upload->display_errors(); // Fetch the upload error
					return false;
				}else {
					$image1_data=$this->upload->data();
					$filedata=array('imagepath'=> $image1_data['file_name'],
					);
					$this->db->where('idtbl_supplier', $insertId);
					$this->db->update('tbl_supplier', $filedata);
				}
			}


			$this->db->trans_complete();

			if ($this->db->trans_status()===TRUE) {
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
				redirect('Supplier');
			}

			else {
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
				redirect('Supplier');
			}
		}

		else {
			$data=array('name'=> $supplier_name,
				'bus_reg_no'=> $business_regno,
				'nbt_no'=> $nbtno,
				'svat_no'=> $svatno,
				'telephone_no'=> $telephoneno,
				'fax_no'=> $faxno,
				'address_line1'=> $line1,
				'delivery_address_line1'=> $dline1,
				'address_line2'=> $line2,
				'delivery_address_line2'=> $dline2,
				'city'=> $city,
				'delivery_city'=> $dcity,
				'state'=> $state,
				'delivery_state'=> $dstate,
				'vat_no'=> $vatno,
				'business_status'=> $business_status,
				'payment_method'=> $payementmethod,
				'credit_days'=> $credit_days,
				'tbl_supplier_type_idtbl_supplier_type'=> $suppliertype,
				'company_id'=> $company_id, 
				'company_branch_id'=> $branch_id, 
				'status'=> '1',
				'updatedatetime'=> $insertdatetime,
				'tbl_user_idtbl_user'=> $userID,
			);

			$this->db->where('idtbl_supplier', $recordID);
			$this->db->update('tbl_supplier', $data);

			// $config['upload_path']='./images/supplier_bills';
			// $config['allowed_types']='gif|jpg|png|jpeg';
			// $config['max_size']=10000;

			// $this->load->library('upload', $config);

			// if ( ! $this->upload->do_upload('cretificates')) {
			// 	$this->db->trans_rollback();

			// 	$actionObj=new stdClass();
			// 	$actionObj->icon='fas fa-warning';
			// 	$actionObj->title='';
			// 	$actionObj->message='File Upload Error';
			// 	$actionObj->url='';
			// 	$actionObj->target='_blank';
			// 	$actionObj->type='danger';

			// 	$actionJSON=json_encode($actionObj);

			// 	$this->session->set_flashdata('msg', $actionJSON);
			// 	redirect('Supplier');
			// }

			// else {

			// 	//file is uploaded successfully
			// 	//now get the file uploaded data 
			// 	$upload_data=$this->upload->data();
			// 	//get the uploaded file name
			// 	$data['cretificates']=$upload_data['file_name'];

			// 	$filedata=array('imagename'=> $data['cretificates'],
			// 		'size'=> 0,
			// 		'extention'=> "Jpeg",
			// 		'status'=> '1',
			// 		'tbl_user_idtbl_user'=> $userID,
			// 		'updatedatetime'=> $insertdatetime,
			// 	);
			// 	$this->db->where('tbl_supplier_idtbl_supplier', $recordID);
			// 	$this->db->update('tbl_supplier_cetificate_bill', $filedata);
			// }

			$this->db->trans_complete();

			if ($this->db->trans_status()===TRUE) {
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
				redirect('Supplier');
			}

			else {
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
				redirect('Supplier');
			}
		}
	}

	public function Supplierstatus($x, $y) {
		$this->db->trans_begin();

		$userID=$_SESSION['id'];
		$recordID=$x;
		$type=$y;
		$updatedatetime=date('Y-m-d H:i:s');

		if($type==1) {
			$data=array('status'=> '1',
				'tbl_user_idtbl_user'=> $userID,
				'updatedatetime'=> $updatedatetime);

			$this->db->where('idtbl_supplier', $recordID);
			$this->db->update('tbl_supplier', $data);

			$this->db->trans_complete();

			if ($this->db->trans_status()===TRUE) {
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
				redirect('Supplier');
			}

			else {
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
				redirect('Supplier');
			}
		}

		else if($type==2) {
			$data=array('status'=> '2',
				'tbl_user_idtbl_user'=> $userID,
				'updatedatetime'=> $updatedatetime);

			$this->db->where('idtbl_supplier', $recordID);
			$this->db->update('tbl_supplier', $data);

			$this->db->trans_complete();

			if ($this->db->trans_status()===TRUE) {
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
				redirect('Supplier');
			}

			else {
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
				redirect('Supplier');
			}
		}

		else if($type==3) {
			$data=array('status'=> '3',
				'tbl_user_idtbl_user'=> $userID,
				'updatedatetime'=> $updatedatetime);

			$this->db->where('idtbl_supplier', $recordID);
			$this->db->update('tbl_supplier', $data);

			$this->db->trans_complete();

			if ($this->db->trans_status()===TRUE) {
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
				redirect('Supplier');
			}

			else {
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
				redirect('Supplier');
			}
		}
	}

	public function Supplieredit() {
		$recordID=$this->input->post('recordID');

		$this->db->select('*');
		$this->db->from('tbl_supplier');
		$this->db->where('idtbl_supplier', $recordID);
		$this->db->where('status', 1);

		$respond=$this->db->get();

		$obj=new stdClass();
		$obj->id=$respond->row(0)->idtbl_supplier;
		$obj->name=$respond->row(0)->name;
		$obj->business_regno=$respond->row(0)->bus_reg_no;
		$obj->nbtno=$respond->row(0)->nbt_no;
		$obj->svatno=$respond->row(0)->svat_no;
		$obj->telephoneno=$respond->row(0)->telephone_no;
		$obj->faxno=$respond->row(0)->fax_no;
		// $obj->nic=$respond->row(0)->nic;
		$obj->line1=$respond->row(0)->address_line1;
		$obj->line2=$respond->row(0)->address_line2;
		$obj->city=$respond->row(0)->city;
		$obj->state=$respond->row(0)->state;
		$obj->dline1=$respond->row(0)->delivery_address_line1;
		$obj->dline2=$respond->row(0)->delivery_address_line2;
		$obj->dcity=$respond->row(0)->delivery_city;
		$obj->dstate=$respond->row(0)->delivery_state;

		$obj->business_status=$respond->row(0)->business_status;
		$obj->payementmethod=$respond->row(0)->payment_method;
		$obj->credit_days=$respond->row(0)->credit_days;
		// $obj->postal_code=$respond->row(0)->postal_code;
		// $obj->country=$respond->row(0)->country;
		$obj->vat_no=$respond->row(0)->vat_no;
		$obj->type=$respond->row(0)->tbl_supplier_type_idtbl_supplier_type;
		echo json_encode($obj);
	}


	public function GetSupplierList() {
		$this->db->select('idtbl_supplier, name');
		$this->db->from('tbl_supplier');
		$this->db->where('status', 1);

		return $respond=$this->db->get();
	}
}