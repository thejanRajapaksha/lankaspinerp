<?php

use Dompdf\Dompdf;
use Dompdf\Options;

class CRMQuotationforminfo extends CI_Model
{
    public function Getquotationid($z, $y)
    {
        $qua = $y;

        $quatationid = $z;

        return  $quatationid;
    }

    public function Getproductlistimagesdelete()
    { //Status
        $this->db->trans_begin();


        $recordID = $this->input->post('imageID');

        $data = array(
            'status' => '3'
        );

        $this->db->where('idtbl_product_image', $recordID);
        $this->db->update('tbl_product_image', $data);

        $this->db->trans_complete();

        // if ($this->db->trans_status() === TRUE) {
        //     $this->db->trans_commit();

        //     $actionObj = new stdClass();
        //     $actionObj->icon = 'fas fa-warning';
        //     $actionObj->title = '';
        //     $actionObj->message = ' Delete Successfully';
        //     $actionObj->url = '';
        //     $actionObj->target = '_blank';
        //     $actionObj->type = 'danger';

        //     $actionJSON = json_encode($actionObj);

        //     $obj = new stdClass();
        //     $obj->status = 1;
        //     $obj->action = $actionJSON;

        //     echo json_encode($obj);
        // } else {
        //     $this->db->trans_rollback();

        //     $actionObj = new stdClass();
        //     $actionObj->icon = 'fas fa-warning';
        //     $actionObj->title = '';
        //     $actionObj->message = 'Record Error';
        //     $actionObj->url = '';
        //     $actionObj->target = '_blank';
        //     $actionObj->type = 'danger';

        //     $actionJSON = json_encode($actionObj);

        //     $obj = new stdClass();
        //     $obj->status = 1;
        //     $obj->action = $actionJSON;

        //     echo json_encode($obj);
        // }
    }

    public function Getproductlistimages()
    {
        $productID = $this->input->post('productID');

        $this->db->select('*');
        $this->db->from('tbl_product_image AS u');
        $this->db->where('u.tbl_quotation_idtbl_quotation', $productID);
        $this->db->where_in('u.status', array(1, 2));
        $query = $this->db->get();
        $html = '';
        foreach ($query->result() as $row) {

            $html .= '<table class="table table-striped table-bordered table-sm" id="productimagetable">
    <tbody>
    <tr>
            <td>
                <img src="' . base_url() . '/' . $row->imagepath . '" width="150" height="150">
            </td>
            <td class="text-center">
                <button class="btn btn-outline-danger btn-sm btnremoveimage mt-5" id="' . $row->idtbl_product_image . '"><i class="fas fa-trash-alt"></i></button>
            </td>
        </tr></tbody>
</table>';
        }
        return $html;
    }
    public function Getproduct($z, $y)
    {
        $getinq = $z;
        $get = $y;

        $this->db->select('`quantity`,`date`,`bag_length`,`bag_width`,`bag_type`,`colour_no`,`off_print`,`status`,`tbl_inquiry_idtbl_inquiry`');
        $this->db->from('tbl_inquiry_detail');
        $this->db->where('status', 1);
        $this->db->where('tbl_inquiry_idtbl_inquiry', $getinq);

        $query = $this->db->get();
        return $query-> result();
    }

    public function Quotationformmeterial()
    {
        $productid = $this->input->post('productid');
        $getid = $this->input->post('getid');

        $this->db->select('ua.idtbl_material, ua.type');
        $this->db->from('tbl_inquiry_detail AS u');
        $this->db->join('tbl_material AS ua', 'ua.idtbl_material = u.tbl_material_idtbl_material', 'left');
        $this->db->where('u.tbl_cloth_idtbl_cloth', $productid);
        $this->db->where('u.tbl_inquiry_idtbl_inquiry', $getid);
        $this->db->where('u.status', 1);

        $respond = $this->db->get();
        $result = $respond->result();
        $arraylist = array();
        foreach ($result as $res) {
            $obj = new stdClass();
            $obj->idtbl_material = $res->idtbl_material;
            $obj->type = $res->type;

            array_push($arraylist, $obj);
        }

        return json_encode($arraylist);
    }

    public function Quotationformunitprice()
    {
        $productid = $this->input->post('productid');
        $getid = $this->input->post('getid');
        $customer = $this->input->post('customer');

        $this->db->select('`u.quantity`');
        $this->db->from('tbl_inquiry_detail AS u');
        $this->db->join('tbl_inquiry AS ua', 'ua.idtbl_inquiry = u.tbl_inquiry_idtbl_inquiry', 'left');
        $this->db->where('u.tbl_material_idtbl_material', $productid);
        $this->db->where('ua.tbl_customer_idtbl_customer', $customer);
        $this->db->where('u.tbl_inquiry_idtbl_inquiry', $getid);
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

        return $respond;
    }

    public function Getcustomer($z, $y)
    {

        $getid = $z;
        $getcusid = $y;

        $this->db->select('`tbl_customer_idtbl_customer`, `name`');
        $this->db->from('tbl_inquiry AS u');
        $this->db->join('tbl_customer AS ua', 'ua.idtbl_customer = u.tbl_customer_idtbl_customer', 'left');
        $this->db->where('u.status', 1);
        $this->db->where('tbl_customer_idtbl_customer', $getcusid);
        $this->db->group_by('tbl_customer_idtbl_customer');
         $query = $this->db->get();
         return $query->result();
    }

    public function Quotationformgetinfodata()
    {

        $cusId = $this->input->post('cusId');

        $this->db->select('*');
        $this->db->from('tbl_quotation AS u');
        $this->db->join('tbl_quotation_detail AS ua', 'ua.tbl_quotation_idtbl_quotation = u.idtbl_quotation', 'left');
        $this->db->join('tbl_customer AS ub', 'ub.idtbl_customer = u.tbl_customer_idtbl_customer', 'left');
        $this->db->where('u.idtbl_quotation', $cusId);
        $this->db->where_in('u.status', array(1, 2));

        $query = $this->db->get();

        $html = '';
        $total_amount = 0;
        $count = 0;

        foreach ($query->result() as $row) {

            $html .= '<tr>
            <td scope="row">' . $count . '</td>
            <td scope="row" class="d-none">' . $row->tbl_inquiry_idtbl_inquiry . '</td>
        <td scope="row">' . $row->duedate . '</td>
        <td scope="row">' . $row->comment . '</td>
        <td scope="row">' . $row->qty . '</td>
        <td scope="row">' . $row->unitprice . '</td>
        <td scope="row" class="text-right">' . number_format($row->total, 2) . '</td>
        </tr>';
            $total_amount += $row->total;
        }

        $html .= '<tr>
    <td colspan="5" class="text-right font-weight-bold">Net Total</td>
    <td class="text-right font-weight-bold">' . number_format($total_amount, 2) . '</td>
    </tr>';

        return $html;
    }

    public function Quotationforminsertupdate()
{
    $this->db->trans_begin();
    $userID = $_SESSION['id'];
    $jsonObj = json_decode($this->input->post('tableData'), true);
    $remarks = $this->input->post('remarks');
    $getid = $this->input->post('getid');
    $trimmedValue = $this->input->post('trimmedValue');
    $sumdis = $this->input->post('sumdis');
    $quotdate = $this->input->post('quotdate');
    $duedate = $this->input->post('duedate');
    $customer = $this->input->post('customer');
    $recordOption = $this->input->post('recordOption');
    
    if (!empty($this->input->post('recordID'))) {
        $recordID = $this->input->post('recordID');
    }

    $updatedatetime = date('Y-m-d H:i:s');
    if ($recordOption == 1) { 
        $data = array(
            'quot_date' => $quotdate,
            'duedate' => $duedate,
            'total' => $trimmedValue,
            'discount' => '0',
            'nettotal' => '0',
            'delivery_charge' => '0',
            'approvestatus' => '0',
            'approvedate' => '0',
            'approveuser' => '0',
            'reject_resone' => '',
            'remarks' => $remarks,
            'status' => '1',
            'insertdatetime' => $updatedatetime,
            'tbl_user_idtbl_user' => $userID,
            'tbl_inquiry_idtbl_inquiry' => $getid,
            'tbl_customer_idtbl_customer' => $customer,
        );

        $this->db->insert('tbl_quotation', $data);
        $tbl_quotation_idtbl_quotation = $this->db->insert_id();

        foreach ($jsonObj as $rowdata) {
            $BagType = $rowdata['col_1']; 
            $Comment = $rowdata['col_2']; 
            $Qty = $rowdata['col_3']; 
            $Unitprice = $rowdata['col_4'];
            $Total = $rowdata['col_5'];

            $data2 = array(
                'bag_type' => $BagType, 
                'qty' => $Qty,
                'unitprice' => $Unitprice,
                'total' => $Total,
                'comment' => $Comment,
                'status' => '1',
                'tbl_quotation_idtbl_quotation' => $tbl_quotation_idtbl_quotation
            );

            $this->db->insert('tbl_quotation_detail', $data2);
        }

        $this->db->trans_complete();
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();

            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-save';
            $actionObj->title = '';
            $actionObj->message = 'Record Added Successfully';
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'success';

            echo json_encode(['status' => 1, 'action' => json_encode($actionObj)]);
        } else {
            $this->db->trans_rollback();

            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-warning';
            $actionObj->title = '';
            $actionObj->message = 'Record Error';
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'danger';

            echo json_encode(['status' => 0, 'action' => json_encode($actionObj)]);
        }
    }
}


    public function Quotationformedit()
    {
        $recordID = $this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_quotation');
        $this->db->where('idtbl_quotation', $recordID);
        $this->db->where('status', 1);

        $respond = $this->db->get();

        $obj = new stdClass();
        $obj->id = $respond->row(0)->idtbl_quotation;
        $obj->quot_date = $respond->row(0)->quot_date;
        $obj->duedate = $respond->row(0)->duedate;
        $obj->total = $respond->row(0)->total;
        $obj->discount = $respond->row(0)->discount;
        $obj->nettotal = $respond->row(0)->nettotal;
        $obj->delivery_charge = $respond->row(0)->delivery_charge;
        $obj->remarks = $respond->row(0)->remarks;

        echo json_encode($obj);
    }

    public function Quotationformstatus()
    { //Status
        $this->db->trans_begin();

        $userID = $_SESSION['id'];
        $recordID = $this->input->post('recordID');
        $type = $this->input->post('type');
        $cancelMsg = $this->input->post('cancelMsg');
        $updatedatetime = date('Y-m-d H:i:s');

        if ($type == 1) {
            $data = array(
                'status' => '1',
                'updatedatetime' => $updatedatetime
            );

            $this->db->where('idtbl_quotation', $recordID);
            $this->db->update('tbl_quotation', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();

                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-check';
                $actionObj->title = '';
                $actionObj->message = 'Record Activate Successfully';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'success';

                $actionJSON = json_encode($actionObj);

                $obj = new stdClass();
                $obj->status = 1;
                $obj->action = $actionJSON;

                echo json_encode($obj);
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

                $obj = new stdClass();
                $obj->status = 1;
                $obj->action = $actionJSON;

                echo json_encode($obj);
            }
        } else if ($type == 2) {
            $data2 = array(
                'status' => '2',
                'updatedatetime' => $updatedatetime
            );

            $this->db->where('idtbl_quotation', $recordID);
            $this->db->update('tbl_quotation', $data2);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();

                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-times';
                $actionObj->title = '';
                $actionObj->message = 'Record Deactivate Successfully';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'warning';

                $actionJSON = json_encode($actionObj);

                $obj = new stdClass();
                $obj->status = 1;
                $obj->action = $actionJSON;

                echo json_encode($obj);
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

                $obj = new stdClass();
                $obj->status = 0;
                $obj->action = $actionJSON;

                echo json_encode($obj);
            }
        } else if ($type == 3) {
            $data3 = array(
                'reject_resone' => $cancelMsg,
                'status' => '3',
                'updatedatetime' => $updatedatetime,

            );

            $this->db->where('idtbl_quotation', $recordID);
            $this->db->update('tbl_quotation', $data3);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();

                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-trash-alt';
                $actionObj->title = '';
                $actionObj->message = 'Record Remove Successfully';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'danger';

                $actionJSON = json_encode($actionObj);

                $obj = new stdClass();
                $obj->status = 0;
                $obj->action = $actionJSON;

                echo json_encode($obj);
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

                $obj = new stdClass();
                $obj->status = 0;
                $obj->action = $actionJSON;

                echo json_encode($obj);
            }
        }
    }



    public function Quotationformapprovestatus()
    { //Status
        $this->db->trans_begin();

        $userID = $_SESSION['id'];
        $recordID = $this->input->post('recordID');
        $type = $this->input->post('type');
        $reasonID = $this->input->post('reasonID');
        $reasonAdd = $this->input->post('reasonAdd');
        $updatedatetime = date('Y-m-d H:i:s');

        if ($type == 1) {
            $data = array(
                'approvestatus' => '1',
                'approvedate' => $updatedatetime,
                'approveuser' => $userID,
                'tbl_user_idtbl_user' => $userID,
                'updatedatetime' => $updatedatetime
            );

            $this->db->where('idtbl_quotation', $recordID);
            $this->db->update('tbl_quotation', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();

                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-check';
                $actionObj->title = '';
                $actionObj->message = 'Record Approve Successfully';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'success';

                $actionJSON = json_encode($actionObj);

                $obj = new stdClass();
                $obj->status = 1;
                $obj->action = $actionJSON;

                echo json_encode($obj);
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

                $obj = new stdClass();
                $obj->status = 0;
                $obj->action = $actionJSON;

                echo json_encode($obj);
            }
        } else if ($type == 2) {
            $data2 = array(
                'approvestatus' => '2',
                'approvedate' => $updatedatetime,
                'approveuser' => $userID,
                // 'updateuser' => $userID,
                'updatedatetime' => $updatedatetime,
                'tbl_reason_idtbl_reason' => $reasonID,
                'reject_resone' => $reasonAdd
            );

            $this->db->where('idtbl_quotation', $recordID);
            $this->db->update('tbl_quotation', $data2);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();

                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-times';
                $actionObj->title = '';
                $actionObj->message = 'Record Disapprove Successfully';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'warning';

                $actionJSON = json_encode($actionObj);

                $obj = new stdClass();
                $obj->status = 1;
                $obj->action = $actionJSON;

                echo json_encode($obj);
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

                $obj = new stdClass();
                $obj->status = 0;
                $obj->action = $actionJSON;

                echo json_encode($obj);
            }
        }
    }
    // public function Quotationdetailsinsertupdate()
    // {
    //     $this->db->trans_begin();

    //     $userID = $_SESSION['userid'];
    //     $qty = $this->input->post('qty');
    //     $unitprice = $this->input->post('unitprice');
    //     $discountamount = $this->input->post('discountamount');
    //     $total = $this->input->post('total');
    //     $comment = $this->input->post('comment');
    //     // $id=$this->input->post('id');

    //     $QuotationdetailsrecordOption = $this->input->post('QuotationdetailsrecordOption');
    //     $QuotationdetailsrecordID = $this->input->post('QuotationdetailsrecordID');
    //     $recordID = $this->input->post('recordQdetails');
    //     $updatedatetime = date('Y-m-d H:i:s');

    //     $data = array(
    //         'qty' => $qty,
    //         'unitprice' => $unitprice,
    //         'discountamount' => $discountamount,
    //         'total' => $total,
    //         'comment' => $comment,
    //         'status' => '1',
    //         'tbl_quotation_idtbl_quotation' => $QuotationdetailsrecordOption,
    //         'tbl_product_idtbl_product' => '0'

    //     );

    //     $this->db->insert('tbl_quotation_detail', $data);

    //     $this->db->trans_complete();

    //     if ($this->db->trans_status() === TRUE) {
    //         $this->db->trans_commit();

    //         $actionObj = new stdClass();
    //         $actionObj->icon = 'fas fa-save';
    //         $actionObj->title = '';
    //         $actionObj->message = 'Record Added Successfully';
    //         $actionObj->url = '';
    //         $actionObj->target = '_blank';
    //         $actionObj->type = 'success';

    //         $actionJSON = json_encode($actionObj);

    //         $this->session->set_flashdata('msg', $actionJSON);
    //         redirect('CRMQuotationforminfo');
    //     } else {
    //         $this->db->trans_rollback();

    //         $actionObj = new stdClass();
    //         $actionObj->icon = 'fas fa-warning';
    //         $actionObj->title = '';
    //         $actionObj->message = 'Record Error';
    //         $actionObj->url = '';
    //         $actionObj->target = '_blank';
    //         $actionObj->type = 'danger';

    //         $actionJSON = json_encode($actionObj);

    //         $this->session->set_flashdata('msg', $actionJSON);
    //         redirect('CRMQuotationforminfo');
    //     }
    // }

    public function Quotationdetailsedit()
    {

        $recordID = $this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_quotation_detail');
        $this->db->where('idtbl_quotation_detail', $recordID);
        $this->db->where('tbl_quotation_detail.status', 1);

        $respond = $this->db->get();

        $obj = new stdClass();
        $obj->id = $respond->row(0)->idtbl_quotation_detail;
        $obj->qty = $respond->row(0)->qty;
        $obj->unitprice = $respond->row(0)->unitprice;
        $obj->discountamount = $respond->row(0)->discountamount;
        $obj->total = $respond->row(0)->total;
        $obj->comment = $respond->row(0)->comment;

        echo json_encode($obj);
    }

    public function Getreasontype(){
        $this->db->select('idtbl_reason, type');
        $this->db->from('tbl_reason');
        $this->db->where('status', 1);
    
        $respond=$this->db->get();

        $data=array();

        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->idtbl_reason, "text"=>$row->type);
        }

        echo json_encode($data);
    }

    public function QuotationformDetailsstatus($x, $y)
    {   //Status
        $this->db->trans_begin();

        $userID = $_SESSION['id'];
        $recordID = $x;
        $type = $y;
        $updatedatetime = date('Y-m-d H:i:s');

        if ($type == 1) {
            $data = array(
                'status' => '1',
                'updatedatetime' => $updatedatetime,
                'updateuser' => $userID
            );

            $this->db->where('idtbl_quotation_detail', $recordID);
            $this->db->update('tbl_quotation_detail', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();

                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-check';
                $actionObj->title = '';
                $actionObj->message = 'Record Activate Successfully';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'success';

                $actionJSON = json_encode($actionObj);

                $this->session->set_flashdata('msg', $actionJSON);
                redirect('CRMQuotationforminfo');
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
                redirect('CRMQuotationforminfo');
            }
        } else if ($type == 2) {
            $data = array(
                'status' => '2',
                'updatedatetime' => $updatedatetime,
                'updateuser' => $userID
            );

            $this->db->where('idtbl_quotation_detail', $recordID);
            $this->db->update('tbl_quotation_detail', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();

                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-times';
                $actionObj->title = '';
                $actionObj->message = 'Record Deactivate Successfully';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'warning';

                $actionJSON = json_encode($actionObj);

                $this->session->set_flashdata('msg', $actionJSON);
                redirect('CRMQuotationforminfo');
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
                redirect('CRMQuotationforminfo');
            }
        } else if ($type == 3) {
            $data = array(
                'status' => '3',
                'updatedatetime' => $updatedatetime,
                'updateuser' => $userID
            );

            $this->db->where('idtbl_quotation_detail', $recordID);
            $this->db->update('tbl_quotation_detail', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();

                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-trash-alt';
                $actionObj->title = '';
                $actionObj->message = 'Record Remove Successfully';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'danger';

                $actionJSON = json_encode($actionObj);

                $this->session->set_flashdata('msg', $actionJSON);
                redirect('CRMQuotationforminfo');
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
                redirect('CRMQuotationforminfo');
            }
        }
    }

    public function Quotationformpdf($x)
    {
        $quotaitonid = $x;
        $cusId = $this->input->post('cusId');
        $userID = $_SESSION['id'];
        $this->db->select('*');
        $this->db->from('tbl_quotation AS u');
        $this->db->join('tbl_quotation_detail AS ua', 'ua.tbl_quotation_idtbl_quotation = u.idtbl_quotation', 'left');
        $this->db->join('tbl_customer AS ub', 'ub.idtbl_customer = u.tbl_customer_idtbl_customer', 'left');
        // $this->db->join('tbl_product AS uc', 'uc.idtbl_product = ua.tbl_product_idtbl_product', 'left');
        $this->db->where('u.idtbl_quotation', $quotaitonid);
        $this->db->where_in('u.status', array(1, 2));

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->row();
            $quot_date = $row->quot_date;
            $duedate = $row->duedate;
            $name = $row->name;
            $address1 = $row->address1;
        }

        $this->db->select('`paymentterm`');
        $this->db->from('tbl_payment_terms');
        $this->db->where_in('status', array(1));
        $query2 = $this->db->get();

        $this->db->select('`name`');
        $this->db->from('tbl_user');
        $this->db->where('idtbl_user', $userID);
        $this->db->where_in('status', array(1, 2));
        $query3 = $this->db->get();

        if ($query3->num_rows() > 0) {
            $row3 = $query3->row();
            $name2 = $row3->name;
        }


        $path = 'images/axel2.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $this->load->library('pdf');
        // $options = new Options();
        // $options->set('isPhpEnabled', true);
        // $dompdf = new Dompdf($options);
        $count = 0;
        $sub_total_amount = 0;
        $sub_total_amount2 = 0;
        $total_amount = 0;
        $total_discount = 0;
        $price = 0;
        $html = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>AXEL Projects - By Erav Technology</title>
            <style>
            * {
                margin: 0;
                padding: 0;
                font-size: 12px;
                font-family: "Calibri", sans-serif;
              }
             .table { display: table; width: 100%; border-collapse: collapse; }
             .table-row { display: table-row; }
             .table-cell { display: table-cell; padding: 1em; }
             .h_left {
                width: 25%; text-align: center; }
             .h_md {
                width: 35%; text-align: center;}
             .h_right {
                width: 40%; text-align: left; padding-top:18px; padding-left:20px; }
                .quotation{border: 0px; width: 255px;
                    height: 40px;   border: 1px #5b9bd5;
                    border-radius: 8px;
                    padding: 5px; position: absolute; background-color: #5b9bd5; text-align: center; font-family: "Arial Rounded MT Bold", sans-serif; color: white; font-size: 30px; font-weight: bold;}

                    .specific-tables table, .specific-tables th, .specific-tables td {
                        border: 1px solid #8bbce7;
                        border-collapse: collapse;
                      }
                      
                      .specific-tables tr:nth-child(even) {
                        background-color: #f2f2f2;
                      }

                      .specific-tables2 table, .specific-tables2 th, .specific-tables2 td {
                        border: 1px solid #656262;
                        border-collapse: collapse;
                        height: 25px;
                      }
                      .specific-tables2 th {height:20px}
                      .specific-tables2 tr:nth-child(even) {
                        background-color: #f2f2f2;
                      }
                      .attn{margin-top: 75px;}
                      .hrtext{padding-left: 25px; padding-right: 25px;}
                      .txtalign{padding-right: 5px;}
                      .txtalign2{padding-left: 5px;}
                      .txtalign3{padding-left: 36px;}
                      .mg_b{padding-top:20px; margin-left:-10px;}
                      .mg_c{padding-top:1px; margin-left:-10px;}
                      .page-header {
                        margin-bottom: -90px;
                        position: fixed;
                        background-color: #000080;
                    }

                    li {
                        margin-top: 5px;
                      }
                      .fixed-table {
                        position: fixed;
                        bottom:60px;
                        width: 100%;
                        
                          
                        
                    }

                    .page-brake {
                        page-break-before: always;
                        
                    }
                   
                    .footer-image {
                        width: 800px;
                    }
                    .fixed-table-top {
                        position: fixed;
                        top: 0;
                        width: 100%;
                       padding-left:25px;
                       padding-right:25px;
                       margin-top:15px;
                      
                    }
            
                    
                    .logo img {
                        margin-top: 20px;
                        margin-left: 25px;
                    }
                    .main{
                       border:2px solid black; 
                      
                       margin-left:25px;
                       margin-right:25px;
                    }
                    
                      
     </style>
        </head>
        <body style="padding-top:80px; margin-bottom:60px;">
        
        <table class="fixed-table-top">
        <tr>
            <td style="width: 25%;"><img src="' . $base64 . '" width="150" height="60"></td>
            <td style="width: 35%;"></td>
            <td style="width: 35%;"><b>AXEL INDUSTRIES (PVT) LTD</b><br>#10, VimalaVihara Rd, Nawala, Rajagiriya.<br>T: +94 113 486 570│M: +94 706 868 888<br>w: www.axelsl.com e: sales@axelsl.com</td>
        </tr>
    </table>
        
          
   <table class="fixed-table">
    <tr>
        <td><img src="images/footer image.jpg" alt="" class="footer-image"></td>
    </tr>
</table>

 
 <table style="width:100%;">
    <tr style="">
    <td style=" width:35%; height:100px;"><div style="margin-left: 25px; margin-right: 25px; margin-top: 5px;"><b>TO:</b><br>
    ' . $name . '<br>
    ' . $address1 . '</div></td>
    <td style=" width:35%; height:100px;"></td>
    <td style=" width:43%; height:100px;"><div style="margin-top: -20px; margin-right: 25px; "><div class="quotation">QUOTATION</div></div>
    </div></div></td>
    <tr>
    </table>
  
    <table style="width: 100%;">
    <tr>
    <td style=" width:35%; height:80px;"><div style="margin-left:25px; margin-top:35px; margin-right: 25px;">Attn: Mr/Ms</div></td>
    <td style=" width:30%; height:80px;"></td>
    <td style=" width:40%; height:80px;"><div class="specific-tables" style="margin-right:25px; margin-bottom:8px;">
    <table style="width:100%">
    <tbody class="up_tbody">
      <tr>
        <td class="txtalign2" style="width:50%"><b>QTY NO</b></td>
        <td class="txtalign2">AXL/QT' . $quotaitonid . '</td>
      </tr>
      <tr>
        <td class="txtalign2">DATE</td>
        <td class="txtalign2">' . $quot_date . '</td>
    </tr>
      <tr>
        <td class="txtalign2">DUE DATE</td>
        <td class="txtalign2">' . $duedate . '</td></tr>
      <tr>
        <td class="txtalign2">PREPARED BY</td>
        <td class="txtalign2">' . $name2 . '</td>
      </tr>
      <tr>
        <td class="txtalign2">APPROVED BY</td>
        <td class="txtalign2">' . $name2 . '</td>
      </tr>
    </tbody>
  </table></div></td>
    </tr>
    </table>

  <table style="width: 100%;">
  <tr>
  <td><div class="hrtext"><b>QUOTATION FOR : Industrial [filter category/ Dust collector]</b>
  </div><div class="hrtext"><hr style = "border:0.1px solid color black;"></div></td>
  </tr>
  <tr><td class="hrtext">With refer to your request made, we placed the quote our best price</td></tr>
  </table>
  <div class="specific-tables2 hrtext">
      <table style="width:100%;height:100px">
      <tbody class="up_tbody">
        <tr style="background-color: #0070c0;">
          <th style="color:white; width:4%; text-align: center;">NO</th>
          <th style="color:white; width:40%; text-align: center;">Description</th>
          <th style="color:white; width:15%; text-align: center;">QTY</th>
          <th style="color:white; width:15%; text-align: center;">UNIT/RS</th>
          <th style="color:white; width:20%; text-align: center;">PRICE/LKR</th>
        </tr>';
        foreach ($query->result() as $row) {

            $count = $count + 1;
            $html .= '
        <tr>
        <td class="txtalign2"><b>' . $count . '</b></td>
        <td class="txtalign2">' . $row->productname . '</td>
        <td class="txtalign2">' . $row->qty . '</td>
        <td class="txtalign2" style="text-align:right; padding-right:10px">' . number_format($row->unitprice, 2, '.', ',') . '</td>';

            $price = $row->qty * $row->unitprice;

            $html .= '
        <td class="txtalign2" style="text-align:right; padding-right:10px">' .  number_format($price, 2, '.', ',') . '</td>
        </tr>
        ';

            $sub_total_amount += $price;
            $total_discount += $row->discountamount;
        }

        $html .= '
        <tr>
        <td colspan="4" style="text-align: right;"><div class="txtalign"><b>Sub Total</b></div></td>
        <td class="txtalign2" style="text-align:right; padding-right:10px"> <b>' . number_format($sub_total_amount, 2, '.', ',') . '<b></td>
        </tr>
        <tr>
        <td colspan="4" style="text-align: right;"><div class="txtalign">Total Discount</div></td> 
        <td class="txtalign2" style="text-align:right; padding-right:10px">' . number_format($total_discount, 2, '.', ',') . '</td>
        </tr>
        <tr>
        <td colspan="4" style="text-align: right;"><div class="txtalign">Delivery Charges</div></td>
        <td class="txtalign2" style="text-align:right; padding-right:10px">' . number_format($row->delivery_charge, 2, '.', ',') . '</td>
        </tr>
        <tr>
        <td colspan="4" style="text-align: right; font-size: 14px;"><div class="txtalign"><b>TOTAL</b></div></td>';

        $sub_total_amount2 = $sub_total_amount - $row->discount;
        $total_amount = $sub_total_amount2 + $row->delivery_charge;

        $html .= ' <td class="txtalign2" style="text-align:right; padding-right:10px; font-size: 20px;"><b>' . number_format($total_amount, 2, '.', ',') . '</b></td>
        </tr>
      </tbody>
    </table></div>
    <div style="padding-left: 35px; padding-right: 35px;">
    <table style="width:100%;">
    <tr>
    <td  style="height: 50px; ">
    <h2 class="hrtext mg_b"><b>TERMS AND CONDITIONS </b></h2>
    </td>
    </tr>
    <tr>
    <td  style="height: 10px;">
    <h4 class="hrtext mg_c"><b>Delivery Terms </b></h4>
   
    </td>
    </tr>
    <tr>
    <td class="txtalign3"> 
    <ul style="list-style-type:square;">
    <li>Within 21 working days
    </li>
    
    </ul>
    </td>
    </tr>
    <tr>
    <td  style="height: 10px;">
    <h4 class="hrtext mg_c"><b>Payment Terms  </b></h4>
   
    </td>
    </tr>

    <tr>
    <td class="txtalign3"> 
    
    <ul style="list-style-type:square;">
    ';
        foreach ($query2->result() as $row2) {


            $html .= '
    <li>' . $row2->paymentterm . '
    </li>
    ';
        }

        $html .= '
    </ul>
    
    </td>
    </tr>

    </table>
    <table style="width:100%;">
    <tr>
    <td  style="height: 10px; ">
    <h4 class="hrtext mg_b"></h4>
    </td>
    </tr>
    <tr>
    <td  style="height: 10px;">
    <h4 class="hrtext mg_c"><b>Warranty or Guarantee:</b></h4>
   
    </td>
    </tr>
    <tr>
    <td class="txtalign3"> 
    <ul style="list-style-type:square;">
    <li>One year warranty offered for machineries. Others may vary according to your requirements, terms and conditions may apply.
    </li>
    
    </ul>
    </td>
    </tr>
    <tr>
    <td  style="height: 10px;">
    <h4 class="hrtext mg_c"><b>Other Conditions</b></h4>
   
    </td>
    </tr>
    <tr>
    <td class="txtalign3"> 
    <ul style="list-style-type:square;">
    <li>Quotation rate may be changed after it’s mentioned due date. 
    </li>
    <li>To accept this quotation, please provide written confirmation or sign and return a copy of this quotation before the due date. Failure
    to accept within the specified timeframe may result in the revision or withdrawal of this quotation.</li>
    <li>Any modifications or amendments to this quotation must be made in writing and approved by both parties.</li>
    <li>If there are any modifications or preferable changes needed, the buyer should inform us within 3 working days. It would be charged
    if it was out of the seller-buyer’s agreed design.</li>
    <li>After the seller starts the production according to the sale contract, unless canceled by both parties, the buyer shall not cancel the
    order without agreement by both parties. Otherwise, the buyer shall compensate the seller for not less than 30% of total payments.</li>
    <li>This quotation and any subsequent agreement shall be governed by and construed in accordance with the laws of Sri Lanka. Any
    disputes arising from this quotation or subsequent agreements shall be subject to the exclusive jurisdiction of the courts.</li>
    <li>All information exchanged between the parties during the quotation process and subsequent business interactions shall be kept
    confidential and used solely for the purpose of conducting business.
    </li>
    </ul>
    </td>
    </tr>
    <tr><td style="padding-top: 10px; margin-right: 25px; margin-lest: 25px;">If you have any questions or require further information, please feel free to contact us at +94 113 486 570. We appreciate the opportunity to
    serve you and look forward to the possibility of working together.
    </td></tr>
    </table> 
    </div>
   

    <div style="margin-left:10px; margin-right:10px">
        <table style=" width:100%; height:150px "><tr><td style=" width:30%;"><div style="margin-left:25px; margin-top:100px"> Sincerely,<br>
        Kanchana Rajapaksha<br>
        <b>AXEL Industries (Pvt) Ltd</b><br>
        T: 0113 486 570 | M: 070 686 8888<br>
        <a href="sales@axelsl.com ">sales@axelsl.com </a> | <a href="www.axelsl.com ">www.axelsl.com </a></div></td><td style=" width:70%;"></td></tr></table>
        <div style="margin-left:25px; margin-right:25px; margin-top:10px;"> 
            <h3 style="color: #000080;">BENEFICIARY BANK DETAILS</h3>
                <table style="width:100%;  border-collapse: collapse; border-spacing: 0;">
                    <thead>
                        <tr>
                            <td style="color: #000080; text-align: left; width:15%; border-right: 1px solid; border-top: 1px solid; background-color: #ccc;"
                                scope="col">BENEFICIARY NAME</td>
                            <td style="color: #000080; text-align: left; width:50%; border-top: 1px solid; background-color: #ccc;"
                                scope="col">&nbsp;&nbsp;&nbsp;AXEL Industries (Pvt) Ltd</td>
                        </tr>
                        <tr>
                            <td style="color: #000080; text-align: left; width:15%; border-right: 1px solid;" scope="col">
                                BENEFICIARY BANK</td>
                            <td style="color: #000080; text-align: left; width:50%;" scope="col">&nbsp;&nbsp;&nbsp;Commercial
                                Bank PLC</td>
                        </tr>
                        <tr>
                            <td style="color: #000080; text-align: left; width:15%; border-right: 1px solid; background-color: #ccc;"
                                scope="col">BANK ADDRESS </td>
                            <td style="color: #000080; text-align: left; width:50%; background-color: #ccc;;" scope="col">
                                &nbsp;&nbsp;&nbsp;Commercial Bank PLC, B58, Kadawatha.</td>
                        </tr>
                        <tr>
                            <td style="color: #000080; text-align: left; width:15%; border-right: 1px solid;" scope="col">
                                ACCOUNT NO</td>
                            <td style="color: #000080; text-align: left; width:50%;" scope="col">&nbsp;&nbsp;&nbsp;1000630754
                            </td>
                        </tr>
                        <tr>
                            <td style="color: #000080; text-align: left; width:15%; border-right: 1px solid; background-color: #ccc;"
                                scope="col">BANK CODE</td>
                            <td style="color: #000080; text-align: left; width:50%; background-color: #ccc;;" scope="col">
                                &nbsp;&nbsp;&nbsp;7056</td>
                        </tr>
                        <tr>
                            <td style="color: #000080; text-align: left; width:15%; border-right: 1px solid;" scope="col">BRANCH
                                CODE</td>
                            <td style="color: #000080; text-align: left; width:50%;" scope="col">&nbsp;&nbsp;&nbsp;067</td>
                        </tr>
                        <tr>
                            <td style="color: #000080; text-align: left; width:15%; border-right: 1px solid; background-color: #ccc;"
                                scope="col">SWIFT CODE </td>
                            <td style="color: #000080; text-align: left; width:50%; background-color: #ccc;;" scope="col">
                                &nbsp;&nbsp;&nbsp;CCEYLKLX</td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
        
                <br><br><br>
                <h3 style="color: #000080;">ADDITIONAL CONTACT INFORMATION</h3>
                <table style="width:100%; border-collapse: collapse; border-spacing: 0; background-color: #0080c0;">
                    <thead>
                        <tr>
                            <td style="color: #fff; text-align: left; width:50%; border-top: 1px solid; border-bottom: 1px solid;  scope="
                                col">OFFICE:</td>
                            <td style="color: #fff; text-align: left; width:50%; border-top: 1px solid; border-bottom: 1px solid;"
                                scope="col">FABRICATION & STORES:</td>
                            <td style="color: #fff; text-align: left; width:50%; border-top: 1px solid; border-bottom: 1px solid;"
                                scope="col">OFFICE:</td>
                        </tr>
                        <tr>
                            <td style="color: #fff; text-align: left; width:15%; border-bottom: 1px solid;" scope="col">#10,
                                Nawala Rd, Rajagiriya, Colombo, <br> Sri Lanka</td>
                            <td style="color: #fff; text-align: left; width:50%; border-bottom: 1px solid;" scope="col">148/A/1,
                                Batahena Road, <br> Sooriyapaluwa, Kadawatha, <br> Sri Lanka </td>
                            <td style="color: #fff; text-align: left; width:50%; border-bottom: 1px solid;" scope="col">593/A3,
                                Kandy Road, Eldeniya, Kadawata, <br> Sri Lanka </td>
                        </tr>
                        <tr>
                            <td style="color: #fff; text-align: left; width:15%; border-bottom: 1px solid;" scope="col">LAND
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                                +94 113 486 570</td>
                            <td style="color: #fff; text-align: left; width:50%; border-bottom: 1px solid;" scope="col">WEB :
                                www.axelsl.com</td>
                            <td style="color: #fff; text-align: left; width:50%; border-bottom: 1px solid;" scope="col"></td>
                        </tr>
                        <tr>
                            <td style="color: #fff; text-align: left; width:15%;border-bottom: 1px solid;" scope="col">MOBILE
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                                +94 70 686 8888</td>
                            <td style="color: #fff; text-align: left; width:50%;border-bottom: 1px solid;" scope="col">EMAIL:
                                sales@axelsl.com</td>
                            <td style="color: #fff; text-align: left; width:50%; border-bottom: 1px solid;" scope="col"></td>
        
                        </tr>
                        <tr>
                            <td style="color: #fff; text-align: left; width:15%;border-bottom: 1px solid;" scope="col">SALES
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                                +94 71 586 8898</td>
                            <td style="color: #fff; text-align: left; width:50%; border-bottom: 1px solid;" scope="col"></td>
                            <td style="color: #fff; text-align: left; width:50%; border-bottom: 1px solid;" scope="col"></td>
                        </tr>
                        <tr>
                            <td style="color: #fff; text-align: left; width:15%;border-bottom: 1px solid;" scope="col">
                                ENGINEERING &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: + 94 761 880 838</td>
                            <td style="color: #fff; text-align: left; width:50%; border-bottom: 1px solid;" scope="col"></td>
                            <td style="color: #fff; text-align: left; width:50%; border-bottom: 1px solid;" scope="col"></td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                </div>
        </body>
        </html>';

        // $dompdf->loadHtml($html);
        // $dompdf->setPaper('A4', 'Portrait');
        // $dompdf->render();
        // $dompdf->stream("AXEL PROJECTS INVOICE.pdf", ["Attachment" => 0]);
    }
}

