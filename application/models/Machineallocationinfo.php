<?php
class Machineallocationinfo extends CI_Model{

    public function GetAllCustomers(){
        $this->db->select('`idtbl_customer`,`name`');
        $this->db->from('tbl_customer');
        $this->db->where('status', 1);

        $query = $this->db->get();
        return $query->result();
    }

    public function GetAllCustomerInquiries(){

        $this->db->select('*');
        $this->db->from('tbl_inquiry');
        $this->db->where('tbl_inquiry.status', 1);

        $query = $this->db->get();
        return $query->result();
    }

    public function Getmachinelist(){
        $this->db->select('ua.id, u.name, ua.s_no');
        $this->db->from('machine_types AS u');
        $this->db->join('machine_ins AS ua', 'ua.machine_type_id = u.id');
        $this->db->where('u.active', 1);

        $query = $this->db->get();
        return $query->result();
    }

    public function Getemployeelist(){
        $this->db->select('`id`, `emp_name_with_initial`, `emp_id`,`emp_fullname`');
        $this->db->from('employees');
        $this->db->where('deleted', 0);

        $query = $this->db->get();
        return $query->result();
    }
   
    public function Machineinsertupdate(){

        $this->db->trans_begin();

        $userID=$_SESSION['id'];

        $tableData = $this->input->post('tableData');
        $costitemid=$this->input->post('costitemid');
        $poId=$this->input->post('poid');
        $jobid=$this->input->post('jobid');
        $deliveryplan=$this->input->post('deliveryplan');
        $employee=$this->input->post('employee');

        $insertdatetime=date('Y-m-d H:i:s');
        $allocatedatetime=date('Y-m-d H:i:s');

        foreach($tableData as $rowtabledata){
            $data = array( 
                'tbl_machine_idtbl_machine'=> $rowtabledata['col_2'],
                'allocatedate'=> $allocatedatetime,
                'startdatetime'=> $rowtabledata['col_3'], 
                'enddatetime'=> $rowtabledata['col_4'], 
                'allocatedqty'=> $rowtabledata['col_5'], 
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
                'tbl_customerinquiry_detail_idtbl_customerinquiry_detail'=> $jobid, 
                'tbl_cost_items_idtbl_cost_items'=> $costitemid,
                'tbl_order_idtbl_order'=> $poId,
                'tbl_delivery_plan_details_idtbl_delivery_plan_details'=> $deliveryplan,
                'tbl_employee_idtbl_employee'=> $employee
            );

            $this->db->insert('tbl_machine_allocation', $data);

        }

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
                redirect('Machinealloction');                
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
                redirect('Machinealloction');
            }        

    }

    public function Checkmachineavailability(){
        $machineid = $_POST['machineid'];
        $startdate = $_POST['startdate'];
        $enddate = $_POST['enddate'];

        $sql="SELECT `tbl_machine_idtbl_machine`, `startdatetime`, `enddatetime` FROM `tbl_machine_allocation`
        WHERE ('$startdate' BETWEEN `startdatetime` AND `enddatetime`) OR ('$enddate' BETWEEN `startdatetime` AND `enddatetime`) AND `tbl_machine_idtbl_machine`= '$machineid'  AND `status`= 1 AND `completed_status` = '0'";
        $respond=$this->db->query($sql, array($machineid));
        //echo $sql;die;//var_dump($respond);
            //     WHERE new_start < existing_end
            //   AND new_end   > existing_start;

        $obj=new stdClass();
        if($respond->num_rows() > 0){    
            $obj->actiontype = 1; 
        }
        else{
            $obj->actiontype = 2;
        }
        echo json_encode($obj);

    }

    // public function Checkissueqty(){
    //     $recordID=$this->input->post('recordID');
    //     $productionmaterialinfoID=$this->input->post('productionmaterialinfoID');

    //     $sql="SELECT SUM(`qty`) AS `issueqty` FROM `tbl_production_material` WHERE `tbl_production_orderdetail_idtbl_production_orderdetail`=? AND `tbl_print_material_info_idtbl_print_material_info`=?";
    //     $respond=$this->db->query($sql, array($productionmaterialinfoID, $recordID));

    //     echo $respond->row(0)->issueqty;
    // }

    public function FetchAllocationData(){
        $recordID=$this->input->post('recordID');

        $html='';

		$sql="SELECT `a`.`idtbl_machine_allocation`,`a`.`startdatetime`, `a`.`enddatetime`, `a`.`allocatedqty` FROM `tbl_machine_allocation` AS `a`
		WHERE `a`.`tbl_machine_idtbl_machine`= '$recordID' AND `a`.`completed_status` = '0'";

        $respond=$this->db->query($sql, array(1, $recordID));

              
        foreach($respond->result() as $rowlist){
            $html.='
            <tr id ="'.$rowlist->idtbl_machine_allocation.'">
                <td>'.$rowlist->startdatetime.'</td>
                <td>'.$rowlist->enddatetime.'</td>
                <td>'.$rowlist->allocatedqty.'</td>
             </tr>
            
            ';
        }

        echo ($html);
    }

    public function GetInquieryDetails(){
        $recordID=$this->input->post('recordId');

        $sql = "
        SELECT i.*, d.* 
        FROM tbl_inquiry i
        LEFT JOIN tbl_inquiry_detail d ON d.tbl_inquiry_idtbl_inquiry = i.idtbl_inquiry
        WHERE i.tbl_customer_idtbl_customer = '$recordID'
        ";
        $respond=$this->db->query($sql);
        return $respond->result_array();
    }
    public function GetOrderDetails(){
        $recordID=$this->input->post('recordId');

        $sql = "
        SELECT o.*, d.* 
        FROM tbl_order o
        LEFT JOIN tbl_order_detail d ON d.tbl_order_idtbl_order = o.idtbl_order
        WHERE o.tbl_inquiry_idtbl_inquiry = '$recordID'
        ";
        $respond=$this->db->query($sql);
        return $respond->result_array();
    }

    public function GetCostItemData(){
        $recordID=$this->input->post('recordId');

        $sql="SELECT * FROM `tbl_cost_items` WHERE `tbl_customerinquiry_detail_idtbl_customerinquiry_detail` = '$recordID' AND `status` = '1'";
        $respond=$this->db->query($sql);
        return $respond->result_array();

    }

    public function GetOrderList()
    {
        $sql = "
            SELECT 
                dd.tbl_order_idtbl_order,
                dd.tbl_inquiry_idtbl_inquiry,
                p.product,
                id.quantity,
                c.name
            FROM tbl_delivery_detail dd
            JOIN tbl_inquiry i ON dd.tbl_inquiry_idtbl_inquiry = i.idtbl_inquiry
            JOIN tbl_inquiry_detail id ON id.tbl_inquiry_idtbl_inquiry = i.idtbl_inquiry
            JOIN tbl_products p ON p.idtbl_product = id.tbl_products_idtbl_product
            JOIN tbl_customer c ON c.idtbl_customer = i.tbl_customer_idtbl_customer
            GROUP BY dd.tbl_order_idtbl_order
        ";

<<<<<<< Updated upstream
        $query = $this->db->query($sql);
        echo json_encode($query->result());
=======
        $html='';

		$sql="SELECT * FROM `tbl_inquiry` AS `u`
        JOIN `tbl_inquiry_detail` AS `ub` ON `u`.`idtbl_inquiry` = `ub`.`tbl_inquiry_idtbl_inquiry`
        JOIN `tbl_customer` AS `uc` ON `u`.`tbl_customer_idtbl_customer` = `uc`.`idtbl_customer`
        JOIN `tbl_order` AS `ua` ON `ua`.`tbl_inquiry_idtbl_inquiry` = `u`.`idtbl_inquiry`
        JOIN `tbl_order_detail` AS `us` ON `us`.`tbl_order_idtbl_order` = `ua`.`idtbl_order`
        JOIN `tbl_products` AS `ps` ON `ps`.`idtbl_product` = `us`.`tbl_products_idtbl_products`
        WHERE `u`.`status` IN (1) AND `ub`.`status` IN (1) AND `uc`.`status` IN (1) AND `ua`.`idtbl_order` = '$recordID'";

        $respond=$this->db->query($sql, array(1, $recordID));

              
        foreach($respond->result() as $rowlist){
            $html .= '
            <tr id ="'.$rowlist->idtbl_inquiry.'">
                <td>'.$rowlist->idtbl_inquiry.'</td>
                <td>'.$rowlist->name.'</td>
                <td>PO'.$rowlist->idtbl_order.'</td>
                <td>'.$rowlist->quantity.'</td>
                <td>'.$rowlist->product.'</td>
                <td class="text-center">
                    <button type="button" id="'.$rowlist->idtbl_order.'" class="btn btn-dark btn-sm btnAdd mr-1">
                        <i class="fas fa-tools"></i>
                    </button>
                </td>
            </tr>
            ';

        }

        echo $html;
>>>>>>> Stashed changes
    }

    public function GetDeliveryIdsForOrder()
{
    $orderId = $this->input->post('orderId');

    $sql = "
        SELECT 
            d.deliveryId,
            d.deliver_quantity,
            d.tbl_order_idtbl_order,
            c.name AS customer_name,
            p.product AS cost_item_name
        FROM tbl_delivery_detail d
        JOIN tbl_inquiry i ON d.tbl_inquiry_idtbl_inquiry = i.idtbl_inquiry
        JOIN tbl_inquiry_detail id ON id.tbl_inquiry_idtbl_inquiry = i.idtbl_inquiry
        JOIN tbl_products p ON p.idtbl_product = id.tbl_products_idtbl_product
        JOIN tbl_customer c ON c.idtbl_customer = i.tbl_customer_idtbl_customer
        WHERE d.tbl_order_idtbl_order = ?

    ";

    $query = $this->db->query($sql, array($orderId));
    echo json_encode($query->result());
}

<<<<<<< Updated upstream
=======
        $this->db->select('*');
        $this->db->from('tbl_delivery_detail');
        // $this->db->join('tbl_delivery_plan_details', 'tbl_delivery_plan_details.tbl_delivery_plan_idtbl_delivery_plan = tbl_delivery_plan.idtbl_delivery_plan');
        $this->db->where('tbl_order_idtbl_order', $recordID);
        $respond=$this->db->get();
        return $respond->result_array();
    }
>>>>>>> Stashed changes

}