<?php
class Rowmaterialsinfo extends CI_Model{
    public function Rowmaterialsinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['id'];

        $materialmaincategory=$this->input->post('materialmaincategory');
        $materialname=$this->input->post('materialname');
        $supplier=$this->input->post('supplier');
        $measurment=$this->input->post('measurment');
        $rol=$this->input->post('rol');
        $unitprice=$this->input->post('unitprice');
        $saleprice=$this->input->post('saleprice');
      
        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $insertdatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
                'material_name'=> $materialname, 
                'rol'=> $rol, 
                'saleprice'=> $saleprice, 
                'unitprice'=> $unitprice, 
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
                'tbl_supplier_idtbl_supplier'=> $supplier,
                'tbl_measurements_idtbl_measurements'=> $measurment,
                'tbl_material_main_cat_idtbl_material_main_cat'=> $materialmaincategory,
            );

            $this->db->insert('tbl_row_material', $data);

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
                redirect('Rowmaterials');                
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
                redirect('Rowmaterials');
            }
        }
        else{
            $data = array(
                'material_name'=> $materialname, 
                'rol'=> $rol, 
                'saleprice'=> $saleprice, 
                'unitprice'=> $unitprice, 
                'updatedatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
                'tbl_supplier_idtbl_supplier'=> $supplier,
                'tbl_measurements_idtbl_measurements'=> $measurment,
                'tbl_material_main_cat_idtbl_material_main_cat'=> $materialmaincategory,
            );

            $this->db->where('idtbl_row_material', $recordID);
            $this->db->update('tbl_row_material', $data);

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
                redirect('Rowmaterials');                
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
                redirect('Rowmaterials');
            }
        }
    }
    public function Rowmaterialsstatus($x, $y){
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

			$this->db->where('idtbl_row_material', $recordID);
            $this->db->update('tbl_row_material', $data);

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
                redirect('Rowmaterials');                
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
                redirect('Rowmaterials');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

			$this->db->where('idtbl_row_material', $recordID);
            $this->db->update('tbl_row_material', $data);

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
                redirect('Rowmaterials');                
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
                redirect('Rowmaterials');
            }
        }
        else if($type==3){
			$data = array(
                'status' => '3',
                'tbl_user_idtbl_user'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

			$this->db->where('idtbl_row_material', $recordID);
            $this->db->update('tbl_row_material', $data);

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
                redirect('Rowmaterials');                
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
                redirect('Rowmaterials');
            }
        }
    }
    public function Rowmaterialsedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_row_material');
        $this->db->where('idtbl_row_material', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_row_material;
        $obj->materialname=$respond->row(0)->material_name;
        $obj->rol=$respond->row(0)->rol;
        $obj->saleprice=$respond->row(0)->saleprice;
        $obj->unitprice=$respond->row(0)->unitprice;
        $obj->supplier=$respond->row(0)->tbl_supplier_idtbl_supplier;
        $obj->measurment=$respond->row(0)->tbl_measurements_idtbl_measurements;
        $obj->maincat=$respond->row(0)->tbl_material_main_cat_idtbl_material_main_cat;
        echo json_encode($obj);
    }

    public function GetMaterialList() {
		$this->db->select('idtbl_row_material, material_name');
		$this->db->from('tbl_row_material');
		$this->db->where('status', 1);

		return $respond=$this->db->get();
	}

}
