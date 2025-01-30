<?php

class Purchaseorderinfo extends CI_Model
{
    public function Getlocation()
    {
        $this->db->select('`idtbl_location`, `location`');
        $this->db->from('tbl_location');
        $this->db->where('status', 1);

        return $respond = $this->db->get();
    }

    public function Getsupplier()
    {
        $this->db->select('`idtbl_supplier`, `suppliername`');
        $this->db->from('tbl_supplier');
        $this->db->where('status', 1);

        return $respond = $this->db->get();
    }

    public function Getordertype()
    {
        $this->db->select('`idtbl_order_type`, `type`');
        $this->db->from('tbl_order_type');
        $this->db->where('status', 1);

        return $respond = $this->db->get();
    }

    public function Getproductaccosupplier()
    {
        $recordID = $this->input->post('recordID');

        $sql = "SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname` FROM `tbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_material_info`.`status`=? AND `tbl_material_info`.`tbl_material_category_idtbl_material_category` IN (SELECT `tbl_material_category_idtbl_material_category` FROM `tbl_supplier_has_tbl_material_category` WHERE `tbl_supplier_idtbl_supplier`=?)";
        $respond = $this->db->query($sql, array(1, $recordID));

        echo json_encode($respond->result());
    }

    public function Purchaseorderinsertupdate()
    {
        $this->db->trans_begin();

        $userID = $_SESSION['id'];

        $tableData = $this->input->post('tableData');
        $orderdate = $this->input->post('orderdate');
        $duedate = $this->input->post('duedate');
        $total = $this->input->post('total');
        $remark = $this->input->post('remark');
        $supplier = $this->input->post('supplier');
        $location = $this->input->post('location');
        $ordertype = $this->input->post('ordertype');

        $updatedatetime = date('Y-m-d H:i:s');

        $last_row = $this->db->select('*')->order_by('idtbl_porder', "desc")->limit(1)->get('tbl_porder')->row();
        $no = 'PO0001';
        $last_id = $last_row->po_no ?? $no;
        $id = ((int)substr($last_id, -4)) + 1;

        $number = str_pad($id, 4, "0", STR_PAD_LEFT);

        $new_po = 'PO' . $number;

        $data = array(
            'orderdate' => $orderdate,
            'duedate' => $duedate,
            'subtotal' => $total,
            'discount' => '0',
            'discountamount' => '0',
            'nettotal' => $total,
            'confirmstatus' => '0',
            'grnconfirm' => '0',
            'remark' => $remark,
            'status' => '1',
            'po_no' => $new_po,
            'insertdatetime' => $updatedatetime,
            'tbl_user_idtbl_user' => $userID,
            'tbl_location_idtbl_location' => $location,
            'tbl_supplier_idtbl_supplier' => $supplier,
            'tbl_order_type_idtbl_order_type' => $ordertype
        );

        $this->db->insert('tbl_porder', $data);

        $porderID = $this->db->insert_id();

        foreach ($tableData as $rowtabledata) {
            $materialname = $rowtabledata['col_1'];
            $comment = $rowtabledata['col_2'];
            $spare_part_id = $rowtabledata['col_3'];
            $unit = $rowtabledata['col_4'];
            $qty = $rowtabledata['col_5'];
            $nettotal = $rowtabledata['col_6'];

            $dataone = array(
                'qty' => $qty,
                'unitprice' => $unit,
                'discount' => '0',
                'discountamount' => '0',
                'comment' => $comment,
                'status' => '1',
                'insertdatetime' => $updatedatetime,
                'tbl_porder_idtbl_porder' => $porderID,
                'spare_part_id' => $spare_part_id
            );

            $this->db->insert('tbl_porder_detail', $dataone);
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

            $actionJSON = json_encode($actionObj);

            $obj = new stdClass();
            $obj->status = 1;
            $obj->action = $actionJSON;

            echo json_encode($obj);
        } else {
            $this->db->trans_rollback();

            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-exclamation-triangle';
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

    public function Purchaseorderupdate()
    {
        $this->db->trans_begin();

        $userID = $_SESSION['id'];

        $tableData = $this->input->post('tableData');
        $porder_id = $this->input->post('porder_id');
        $orderdate = $this->input->post('orderdate');
        $duedate = $this->input->post('duedate');
        $total = $this->input->post('total');
        $remark = $this->input->post('remark');
        $supplier = $this->input->post('supplier');
        $location = $this->input->post('location');
        $ordertype = $this->input->post('ordertype');

        $updatedatetime = date('Y-m-d H:i:s');

        $data = array(
            'orderdate' => $orderdate,
            'duedate' => $duedate,
            'subtotal' => $total,
            'nettotal' => $total,
            'remark' => $remark,
            'updatedatetime' => $updatedatetime,
            'tbl_user_idtbl_user' => $userID,
            'tbl_location_idtbl_location' => $location,
            'tbl_supplier_idtbl_supplier' => $supplier,
            'tbl_order_type_idtbl_order_type' => $ordertype
        );


        $this->db->where('idtbl_porder', $porder_id);
        $this->db->update('tbl_porder', $data);


        //delete from table
        $this->db->where('tbl_porder_idtbl_porder', $porder_id);
        $this->db->delete('tbl_porder_detail');

        foreach ($tableData as $rowtabledata) {

            $comment = $rowtabledata['col_2'];
            $spare_part_id = $rowtabledata['col_3'];
            $unit = $rowtabledata['col_4'];
            $qty = $rowtabledata['col_5'];

            $dataone = array(
                'qty' => $qty,
                'unitprice' => $unit,
                'discount' => '0',
                'discountamount' => '0',
                'comment' => $comment,
                'status' => '1',
                'insertdatetime' => $updatedatetime,
                'tbl_porder_idtbl_porder' => $porder_id,
                'spare_part_id' => $spare_part_id
            );

            $this->db->insert('tbl_porder_detail', $dataone);
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

            $actionJSON = json_encode($actionObj);

            $obj = new stdClass();
            $obj->status = 1;
            $obj->action = $actionJSON;

            echo json_encode($obj);
        } else {
            $this->db->trans_rollback();

            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-exclamation-triangle';
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

    public function Purchaseorderview()
    {
        $recordID = $this->input->post('recordID');

        $sql = "SELECT `u`.*, `ua`.`suppliername`, `ua`.`primarycontactno`, `ua`.`secondarycontactno`, `ua`.`address`, `ua`.`email`, `ub`.`location`, `ub`.`phone`, `ub`.`address`, `ub`.`phone2`, `ub`.`email` AS `locemail` FROM `tbl_porder` AS `u` LEFT JOIN `tbl_supplier` AS `ua` ON (`ua`.`idtbl_supplier` = `u`.`tbl_supplier_idtbl_supplier`) LEFT JOIN `tbl_location` AS `ub` ON (`ub`.`idtbl_location` = `u`.`tbl_location_idtbl_location`) WHERE `u`.`status`=? AND `u`.`idtbl_porder`=?";
        $respond = $this->db->query($sql, array(1, $recordID));

        $this->db->select('tbl_porder_detail.*, spare_parts.name, spare_parts.part_no');
        $this->db->from('tbl_porder_detail');
        $this->db->join('tbl_porder', 'tbl_porder.idtbl_porder  = tbl_porder_detail.tbl_porder_idtbl_porder', 'left');
        $this->db->join('spare_parts', 'spare_parts.id = tbl_porder_detail.spare_part_id', 'left');
        $this->db->where('tbl_porder_detail.tbl_porder_idtbl_porder', $recordID);
        $this->db->where('tbl_porder_detail.status', 1);

        $responddetail = $this->db->get();
        // print_r($this->db->last_query());

        $html = '';
        $html .= '
        <div class="row">
            <div class="col-12">' . $respond->row(0)->suppliername . '<br>' . $respond->row(0)->primarycontactno . ' / ' . $respond->row(0)->secondarycontactno . '<br>' . $respond->row(0)->address . '<br>' . $respond->row(0)->email . '</div>
            <div class="col-12 text-right">' . $respond->row(0)->location . '<br>' . $respond->row(0)->phone . ' / ' . $respond->row(0)->phone2 . '<br>' . $respond->row(0)->address . '<br>' . $respond->row(0)->locemail . '</div>
        </div>
        <div class="row">
            <div class="col-12"> 
                <hr> 
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Unit Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($responddetail->result() as $roworderinfo) {
            $html .= '<tr>
                            <td>' . $roworderinfo->name . ' - ' . $roworderinfo->part_no . '</td>
                            <td>' . $roworderinfo->unitprice . '</td>
                            <td>' . $roworderinfo->qty . '</td>
                            <td class="text-right">' . number_format(($roworderinfo->qty * $roworderinfo->unitprice), 2) . '</td>
                        </tr>';
        }
        $html .= '</tbody>
                </table>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 text-right"><h3 class="font-weight-normal">Rs. ' . number_format(($respond->row(0)->nettotal), 2) . '</h3></div>
        </div>
        <div class="row mt-2">
            <div class="col-sm-12">
                <button type="button" data-id="' . $respond->row(0)->idtbl_porder . '" class="btn btn-secondary btn-sm print-btn float-right">
                                <i class="fa fa-print"></i>&nbsp;Print
                            </button>
            </div>
        </div>
        ';

        echo $html;
    }

    public function Purchaseorderstatus($x, $y)
    {
        $this->db->trans_begin();

        $userID = $_SESSION['userid'];
        $recordID = $x;
        $type = $y;
        $updatedatetime = date('Y-m-d H:i:s');

        if ($type == 1) {
            $data = array(
                'confirmstatus' => '1',
                'updateuser' => $userID,
                'updatedatetime' => $updatedatetime
            );

            $this->db->where('idtbl_porder', $recordID);
            $this->db->update('tbl_porder', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();

                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-check';
                $actionObj->title = '';
                $actionObj->message = 'Order Confirm Successfully';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'success';

                $actionJSON = json_encode($actionObj);

                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Purchaseorder');
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
                redirect('Purchaseorder');
            }
        }
    }


    public function getPurchaseOrderDataApprove($id = null)
    {
        $sql = "SELECT tp.*, 
                 tot.type as order_type,
                ts.suppliername as suppliername,
                tl.location as location 
            FROM tbl_porder tp 
            LEFT JOIN tbl_order_type tot ON tot.idtbl_order_type = tp.tbl_order_type_idtbl_order_type
            LEFT JOIN tbl_supplier ts ON ts.idtbl_supplier = tp.tbl_supplier_idtbl_supplier
            LEFT JOIN tbl_location tl ON tl.idtbl_location = tp.tbl_location_idtbl_location 
            WHERE tp.confirmstatus = 0   
            ORDER BY tp.idtbl_porder DESC
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function Purchaseorderedit()
    {
        $recordID = $this->input->post('recordID');

        $sql = "SELECT `u`.*, `ua`.`suppliername`,
       `ua`.`primarycontactno`, `ua`.`secondarycontactno`,
       `ua`.`address`, `ua`.`email`, `ub`.`location`,
       `ub`.`phone`, `ub`.`address`, `ub`.`phone2`,
       `ub`.`email` AS `locemail`,
       u.tbl_order_type_idtbl_order_type as order_type_id,
       tot.type as order_type
        FROM `tbl_porder` AS `u` LEFT JOIN `tbl_supplier` AS `ua` ON (`ua`.`idtbl_supplier` = `u`.`tbl_supplier_idtbl_supplier`) 
            LEFT JOIN `tbl_location` AS `ub` ON (`ub`.`idtbl_location` = `u`.`tbl_location_idtbl_location`) 
            LEFT JOIN tbl_order_type tot ON tot.idtbl_order_type = `u`.`tbl_order_type_idtbl_order_type`
            WHERE `u`.`status`=? 
              AND `u`.`idtbl_porder`=?";
        $respond = $this->db->query($sql, array(1, $recordID));

        $this->db->select('tbl_porder_detail.*, spare_parts.name, spare_parts.part_no');
        $this->db->from('tbl_porder_detail');
        $this->db->join('tbl_porder', 'tbl_porder.idtbl_porder  = tbl_porder_detail.tbl_porder_idtbl_porder', 'left');
        $this->db->join('spare_parts', 'spare_parts.id = tbl_porder_detail.spare_part_id', 'left');
        $this->db->where('tbl_porder_detail.tbl_porder_idtbl_porder', $recordID);
        $this->db->where('tbl_porder_detail.status', 1);

        $responddetail = $this->db->get();
        // print_r($this->db->last_query());

        $html = '';
        $html .= '
            <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <form id="editorderform" autocomplete="off">
                            <input type="hidden" name="porder_id" id="edit_porder_id" value="' . $respond->row(0)->idtbl_porder . '" >
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold text-dark">Purchase Order Type*</label>
                                <select class="form-control form-control-sm" name="ordertype" id="edit_ordertype" required>
                                    <option value="">Select</option> 
                                    <option selected value="' . $respond->row(0)->order_type_id . '"> ' . $respond->row(0)->order_type . ' </option>
                                </select>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Order Date*</label>
                                    <input type="date" class="form-control form-control-sm" placeholder="" name="orderdate" id="edit_orderdate" value="'.$respond->row(0)->orderdate.'" required>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Location*</label>
                                    <select class="form-control form-control-sm" name="location" id="edit_location" required>
                                        <option value="">Select</option>
                                        <option selected value="' . $respond->row(0)->tbl_location_idtbl_location . '"> ' . $respond->row(0)->location . ' </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Due Date*</label>
                                    <input type="date" class="form-control form-control-sm" placeholder="" name="duedate" id="edit_duedate" value="'.$respond->row(0)->duedate.'" required>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Supplier*</label>
                                    <select class="form-control form-control-sm" name="supplier" id="edit_supplier" required>
                                        <option value="">Select</option>
                                        <option selected value="' . $respond->row(0)->tbl_supplier_idtbl_supplier . '"> ' . $respond->row(0)->suppliername . ' </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold text-dark">Product*</label>
                                <select class="form-control form-control-sm" name="spare_part_id" id="edit_spare_part_id" required>
                                    <option value="">Select</option> 
                                </select>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Qty*</label>
                                    <input type="number" id="edit_newqty" name="newqty" class="form-control form-control-sm" required>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Unit Price</label>
                                    <input type="number" id="edit_unitprice"
                                           name="unitprice" class="form-control form-control-sm" value=""
                                           step="0.01"
                                    >
                                </div>
                            </div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold text-dark">Comment</label>
                                <textarea name="comment" id="edit_comment" class="form-control form-control-sm"></textarea>
                            </div>
                            <div class="form-group mt-3 text-right">
                                <button type="button" id="edit_formsubmit" class="btn btn-primary btn-sm px-4" ><i class="fas fa-plus"></i>&nbsp;Add to list</button>
                                <input name="submitBtn" type="submit" value="Save" id="edit_submitBtn" class="d-none">
                            </div>
                            <input type="hidden" name="refillprice" id="edit_refillprice" value="">
                        </form>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
                        <table class="table table-striped table-bordered table-sm small" id="edit_tableorder">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Comment</th>
                                    <th class="d-none">ProductID</th>
                                    <th class="d-none">Unit Price</th>
                                    <th class="text-center">Qty</th> 
                                    <th class="text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>';

                    foreach ($responddetail->result() as $roworderinfo){

                        $total =  $roworderinfo->unitprice * $roworderinfo->qty;

                        $html .= '
                                    <tr class="pointer">
                                    <td>' . $roworderinfo->name . ' - ' . $roworderinfo->part_no . '</td>
                                     <td>' . $roworderinfo->comment . '</td>
                                    <td class="d-none">' . $roworderinfo->spare_part_id . '</td>
                                    <td class="d-none">' . $roworderinfo->unitprice . '</td>
                                    <td >' . $roworderinfo->qty . '</td>
                                    <td class="edit_total d-none">' . $total . '</td>
                                    <td class="text-right">' . $total . '</td>
                                    </tr> 
                            ';
                    }

        $html .= '        </tbody>
                        </table>
                        <div class="row">
                            <div class="col text-right">
                                <h1 class="font-weight-600" id="edit_divtotal">Rs. '.$respond->row(0)->subtotal.' </h1>
                            </div>
                            <input type="hidden" id="edit_hidetotalorder" value="0">
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="small font-weight-bold text-dark">Remark</label>
                            <textarea name="remark" id="edit_remark" class="form-control form-control-sm">'.$respond->row(0)->remark.'</textarea>
                        </div>
                        <div class="form-group mt-2">
                            <button type="button" id="edit_btncreateorder"
                                class="btn btn-outline-primary btn-sm fa-pull-right"><i
                                    class="fas fa-save"></i>&nbsp;Edit
                                Order</button>
                        </div>
                    </div>
                </div>
        ';

        echo $html;
    }

}