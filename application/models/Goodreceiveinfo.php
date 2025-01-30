<?php

class Goodreceiveinfo extends CI_Model
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

    public function Getporder()
    {
        $this->db->select('`idtbl_porder`');
        $this->db->from('tbl_porder');
        $this->db->where('status', 1);
        $this->db->where('confirmstatus', 1);
        $this->db->where('grnconfirm', 0);

        return $respond = $this->db->get();
    }

    public function Getproductaccosupplier()
    {
        $recordID = $this->input->post('recordID');

        $sql = "SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname` FROM `tbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_material_info`.`status`=? AND `tbl_material_info`.`tbl_material_category_idtbl_material_category` IN (SELECT `tbl_material_category_idtbl_material_category` FROM `tbl_supplier_has_tbl_material_category` WHERE `tbl_supplier_idtbl_supplier`=?)";
        $respond = $this->db->query($sql, array(1, $recordID));

        echo json_encode($respond->result());
    }

    public function Goodreceiveinsertupdate()
    {
        $this->db->trans_begin();

        $userID = $_SESSION['id'];

        $tableData = $this->input->post('tableData');
        $grndate = $this->input->post('grndate');
        $total = $this->input->post('total');
        $remark = $this->input->post('remark');
        $supplier = $this->input->post('supplier');
        $location = $this->input->post('location');

        $porder = $this->input->post('porder');

        $batchno = $this->input->post('batchno');
        $invoice = $this->input->post('invoice');
        $dispatch = $this->input->post('dispatch');
        $grntype = $this->input->post('grntype');
        $transportcost = $this->input->post('transportcost');
        $unloadcost = $this->input->post('unloadcost');

        $updatedatetime = date('Y-m-d H:i:s');

        $data = array(
            'batchno' => $batchno,
            'grntype' => $grntype,
            'grndate' => $grndate,
            'total' => $total,
            'invoicenum' => $invoice,
            'dispatchnum' => $dispatch,
            'approvestatus' => '0',
            'transportcost' => $transportcost,
            'unloadingcost' => $unloadcost,
            'status' => '1',
            'insertdatetime' => $updatedatetime,
            'tbl_user_idtbl_user' => $userID,
            'tbl_supplier_idtbl_supplier' => $supplier,
            'tbl_location_idtbl_location' => $location,
            'tbl_porder_idtbl_porder' => $porder,
            'tbl_order_type_idtbl_order_type' => $grntype,
            'remarks' => $remark
        );

        $this->db->insert('tbl_grn', $data);

        $grnID = $this->db->insert_id();

        foreach ($tableData as $rowtabledata) {
            $materialname = $rowtabledata['col_1'];
            $comment = $rowtabledata['col_2'];
            $mfdate = $rowtabledata['col_3'];
            $expdate = $rowtabledata['col_4'];
            $quater = $rowtabledata['col_5'];
            $materialID = $rowtabledata['col_6'];
            $unit = $rowtabledata['col_7'];
            $qty = $rowtabledata['col_8'];
            $nettotal = $rowtabledata['col_9'];

            $dataone = array(
                'date' => $grndate,
                'qty' => $qty,
                'unitprice' => $unit,
                'total' => $nettotal,
                'comment' => $comment,
                'mfdate' => $mfdate,
                'expdate' => $expdate,
                'quater' => $quater,
                'status' => '1',
                'insertdatetime' => $updatedatetime,
                'tbl_grn_idtbl_grn' => $grnID,
                'spare_part_id' => $materialID
            );

            $this->db->insert('tbl_grndetail', $dataone);
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

    public function Goodreceiveupdate()
    {
        $this->db->trans_begin();

        $userID = $_SESSION['id'];

        $tableData = $this->input->post('tableData');
        $grndate = $this->input->post('grndate');
        $total = $this->input->post('total');
        $remark = $this->input->post('remark');
        $supplier = $this->input->post('supplier');
        $location = $this->input->post('location');

        $porder = $this->input->post('porder');

        $batchno = $this->input->post('batchno');
        $invoice = $this->input->post('invoice');
        $dispatch = $this->input->post('dispatch');
        $grntype = $this->input->post('grntype');
        $transportcost = $this->input->post('transportcost');
        $unloadcost = $this->input->post('unloadcost');

        $recordID = $this->input->post('recordID');

        $updatedatetime = date('Y-m-d H:i:s');

        $data = array(
            'batchno' => $batchno,
            'grntype' => $grntype,
            'grndate' => $grndate,
            'total' => $total,
            'invoicenum' => $invoice,
            'dispatchnum' => $dispatch,
            'transportcost' => $transportcost,
            'unloadingcost' => $unloadcost,
            'insertdatetime' => $updatedatetime,
            'tbl_user_idtbl_user' => $userID,
            'tbl_supplier_idtbl_supplier' => $supplier,
            'tbl_location_idtbl_location' => $location,
            'tbl_porder_idtbl_porder' => $porder,
            'tbl_order_type_idtbl_order_type' => $grntype,
            'remarks' => $remark
        );

        $this->db->where('idtbl_grn', $recordID);
        $this->db->update('tbl_grn', $data);

        $this->db->where('tbl_grn_idtbl_grn', $recordID);
        $this->db->delete('tbl_grndetail');

        foreach ($tableData as $rowtabledata) {
            $comment = $rowtabledata['col_2'];
            $mfdate = $rowtabledata['col_3'];
            $expdate = $rowtabledata['col_4'];
            $quater = $rowtabledata['col_5'];
            $materialID = $rowtabledata['col_6'];
            $unit = $rowtabledata['col_7'];
            $qty = $rowtabledata['col_8'];
            $nettotal = $rowtabledata['col_9'];

            $dataone = array(
                'date' => $grndate,
                'qty' => $qty,
                'unitprice' => $unit,
                'total' => $nettotal,
                'comment' => $comment,
                'mfdate' => $mfdate,
                'expdate' => $expdate,
                'quater' => $quater,
                'status' => '1',
                'insertdatetime' => $updatedatetime,
                'tbl_grn_idtbl_grn' => $recordID,
                'spare_part_id' => $materialID
            );

            $this->db->insert('tbl_grndetail', $dataone);
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

    public function Goodreceiveview()
    {
        $recordID = $this->input->post('recordID');
        $allowPrint = $this->input->post('allowPrint') ?? 1;

        $sql = "SELECT `u`.*, `ua`.`suppliername`, `ua`.`primarycontactno`, `ua`.`secondarycontactno`, `ua`.`address`, `ua`.`email`, `ub`.`location`, `ub`.`phone`, `ub`.`address`, `ub`.`phone2`, `ub`.`email` AS `locemail` FROM `tbl_grn` AS `u` LEFT JOIN `tbl_supplier` AS `ua` ON (`ua`.`idtbl_supplier` = `u`.`tbl_supplier_idtbl_supplier`) LEFT JOIN `tbl_location` AS `ub` ON (`ub`.`idtbl_location` = `u`.`tbl_location_idtbl_location`) WHERE `u`.`status`=? AND `u`.`idtbl_grn`=?";
        $respond = $this->db->query($sql, array(1, $recordID));

        $this->db->select('tbl_grndetail.*, spare_parts.id, spare_parts.name, spare_parts.part_no');
        $this->db->from('tbl_grndetail');
        $this->db->join('spare_parts', 'spare_parts.id = tbl_grndetail.spare_part_id', 'left');
        $this->db->where('tbl_grndetail.tbl_grn_idtbl_grn', $recordID);
        $this->db->where('tbl_grndetail.status', 1);

        $responddetail = $this->db->get();
//         print_r($this->db->last_query());
//         die();

        $html = '';
        $html .= '
        <div class="row">
            <div class="col-12">' . $respond->row(0)->location . '<br>' . $respond->row(0)->phone . ' / ' . $respond->row(0)->phone2 . '<br>' . $respond->row(0)->address . '<br>' . $respond->row(0)->locemail . '</div>
            <div class="col-12 text-right">' . $respond->row(0)->suppliername . '<br>' . $respond->row(0)->primarycontactno . ' / ' . $respond->row(0)->secondarycontactno . '<br>' . $respond->row(0)->address . '<br>' . $respond->row(0)->email . '</div>
            <div class="col-12">
                <hr>
                <h6>Invoice No : ' . $respond->row(0)->invoicenum . '</h6>
                <h6>Dispatch No : ' . $respond->row(0)->dispatchnum . '</h6>
                <h6>Batch No : ' . $respond->row(0)->batchno . '</h6>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <hr>
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Unit Price</th>
                            <th class="text-center">Qty</th> 
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($responddetail->result() as $roworderinfo) {
            $total = number_format(($roworderinfo->qty * $roworderinfo->unitprice), 2);
//                        if($roworderinfo->amendqty>0){
//                            $total=number_format(($roworderinfo->amendqty*$roworderinfo->unitprice), 2);
//                        }
//                        else{
//                            $total=number_format(($roworderinfo->qty*$roworderinfo->unitprice), 2);
//                        }
            $html .= '<tr>
                            <td>' . $roworderinfo->name . ' - ' . $roworderinfo->part_no . '</td>
                            <td>' . $roworderinfo->unitprice . '</td>
                            <td class="text-center">' . $roworderinfo->qty . '</td> 
                            <td class="text-right">' . $total . '</td>
                        </tr>';
        }
        $html .= '</tbody>
                </table>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 text-right"><h3 class="font-weight-normal">Rs. ' . number_format(($respond->row(0)->total), 2) . '</h3></div>
        </div>
        
        <div class="row mt-2">
            <div class="col-sm-12"> ';

            if($allowPrint == 1){
                $html .='<button type="button" data-id="' . $respond->row(0)->idtbl_grn . '" class="btn btn-secondary btn-sm print-btn float-right">
                            <i class="fa fa-print"></i>&nbsp;Print
                        </button> ';
            }
            
        $html .= '</div>
        </div>
        ';

        echo $html;
    }

    public function Goodreceiveedit()
    {
        $recordID = $this->input->post('recordID');

        $sql = "SELECT `u`.*,
       `ua`.`suppliername`, `ua`.`primarycontactno`,
       `ua`.`secondarycontactno`, `ua`.`address`, 
       `ua`.`email`, `ub`.`location`, `ub`.`phone`,
       `ub`.`address`, `ub`.`phone2`, 
       `ub`.`email` AS `locemail`,
       po.po_no,
       ot.type as order_type
            FROM `tbl_grn` AS `u` 
           LEFT JOIN `tbl_supplier` AS `ua` ON (`ua`.`idtbl_supplier` = `u`.`tbl_supplier_idtbl_supplier`) 
           LEFT JOIN `tbl_location` AS `ub` ON (`ub`.`idtbl_location` = `u`.`tbl_location_idtbl_location`) 
            LEFT JOIN tbl_porder po ON po.idtbl_porder = u.tbl_porder_idtbl_porder
            LEFT JOIN tbl_order_type  ot ON ot.idtbl_order_type = po.tbl_order_type_idtbl_order_type
        WHERE `u`.`status`=? AND `u`.`idtbl_grn`=?";
        $respond = $this->db->query($sql, array(1, $recordID));

        $this->db->select('tbl_grndetail.*, spare_parts.id, spare_parts.name, spare_parts.part_no');
        $this->db->from('tbl_grndetail');
        $this->db->join('spare_parts', 'spare_parts.id = tbl_grndetail.spare_part_id', 'left');
        $this->db->where('tbl_grndetail.tbl_grn_idtbl_grn', $recordID);
        $this->db->where('tbl_grndetail.status', 1);

        $responddetail = $this->db->get();

        $html = '';
        $html .= ' 
          <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <form id="edit_createorderform" autocomplete="off">
                        
                        <input type="hidden" name="recordID" id="recordID" value="'.$recordID.'">
                        
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Order Date*</label>
                                    <input type="date" class="form-control form-control-sm" placeholder=""
                                           name="grndate" id="edit_grndate" value="'.$respond->row(0)->grndate.'" required>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Location*</label>
                                    <select class="form-control form-control-sm" name="location" id="edit_location" required>
                                        <option value="">Select</option>
                                        <option value="'.$respond->row(0)->tbl_location_idtbl_location.'" selected>'.$respond->row(0)->location.'</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Purchase Order</label>
                                    <select class="form-control form-control-sm" name="porder" id="edit_porder">
                                        <option value="">Select</option>
                                        <option value="'.$respond->row(0)->tbl_porder_idtbl_porder.'" selected >'.$respond->row(0)->po_no.'</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Supplier*</label>
                                    <select class="form-control form-control-sm" name="supplier" id="edit_supplier" required>
                                        <option value="">Select</option>
                                        <option value="'.$respond->row(0)->tbl_supplier_idtbl_supplier.'" selected >'.$respond->row(0)->suppliername.'</option>                                        
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold text-dark">GRN Type*</label>
                                <select class="form-control form-control-sm" name="grntype" id="edit_grntype" required>
                                    <option value="">Select</option>
                                    <option selected value="'.$respond->row(0)->tbl_order_type_idtbl_order_type.'">'.$respond->row(0)->order_type.'</option>
                                </select>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Product*</label>
                                    <select class="form-control form-control-sm" name="spare_part_id" id="edit_spare_part_id"
                                            required>
                                        <option value="">Select</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">MF Date*</label>
                                    <input type="date" id="edit_mfdate" name="mfdate" class="form-control form-control-sm"
                                           value="" required>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Shelf Life*</label>
                                    <select class="form-control form-control-sm" name="quater" id="edit_quater" required>
                                        <option value="">Select</option>
                                        <option value="1">3 Month</option>
                                        <option value="2">6 Month</option>
                                        <option value="3">9 Month</option>
                                        <option value="4">12 Month</option>
                                        <option value="5">18 Month</option>
                                        <option value="6">24 Month</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">EXP Date*</label>
                                    <input type="date" id="edit_expdate" name="expdate" class="form-control form-control-sm"
                                           required>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Qty*</label>
                                    <input type="text" id="edit_newqty" name="newqty"
                                           class="form-control form-control-sm" required>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Unit Price</label>
                                    <input type="text" id="edit_unitprice" name="unitprice"
                                           class="form-control form-control-sm" value="0">
                                </div>
                            </div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold text-dark">Comment</label>
                                <textarea name="comment" id="edit_comment"
                                          class="form-control form-control-sm" ></textarea>
                            </div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold text-dark">Batch No</label>
                                <input type="text" id="edit_batchno" name="batchno" class="form-control form-control-sm"
                                       readonly>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Invoice No*</label>
                                    <input type="text" id="edit_invoice" name="invoice" class="form-control form-control-sm"
                                    value="'.$respond->row(0)->invoicenum.'"
                                    >
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Dispatch No</label>
                                    <input type="text" id="edit_dispatch" name="dispatch"
                                           class="form-control form-control-sm"
                                           value="'.$respond->row(0)->dispatchnum.'"
                                           >
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Transport Cost</label>
                                    <input type="number" step="0.01" id="edit_transportcost" name="transportcost"
                                           class="form-control form-control-sm"
                                           value="'.$respond->row(0)->transportcost.'"
                                           >
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Unload Cost</label>
                                    <input type="number" step="0.01" id="edit_unloadcost" name="unloadcost"
                                           class="form-control form-control-sm"
                                           value="'.$respond->row(0)->unloadingcost.'"
                                           >
                                </div>
                            </div>
                            <div class="form-group mt-3 text-right">
                                <button type="button" id="edit_formsubmit"
                                        class="btn btn-primary btn-sm px-4" ><i class="fas fa-plus"></i>&nbsp;Add to list
                                </button>
                                <input name="submitBtn" type="submit" value="Save" id="edit_submitBtn" class="d-none">
                            </div>
                            <input type="hidden" name="refillprice" id="edit_refillprice" value="">
                        </form>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
                        <div class="scrollbar pb-3" id="style-3">
                            <table class="table table-striped table-bordered table-sm small" id="edit_tableorder">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Comment</th>
                                    <th>MF Date</th>
                                    <th>EXP Date</th>
                                    <th class="d-none">Quater</th>
                                    <th class="d-none">ProductID</th>
                                    <th class="d-none">Unitprice</th>
                                    <th class="d-none">Saleprice</th>
                                    <th class="text-center">Qty</th>
                                    <th class="d-none">HideTotal</th>
                                    <th class="text-right">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                            ';

                foreach ($responddetail->result() as $roworderinfo) {

                    $html .= ' <tr class="pointer">
                        <td>' . $roworderinfo->name . ' - ' . $roworderinfo->part_no . '</td>
                        <td>' . $roworderinfo->comment . '</td>
                        <td>' . $roworderinfo->mfdate . '</td>
                        <td>' . $roworderinfo->expdate . '</td>
                        <td class="d-none">' . $roworderinfo->quater . '</td>
                        <td class="d-none">' . $roworderinfo->spare_part_id . '</td>
                        <td class="d-none">' . $roworderinfo->unitprice . '</td>
                        <td class="text-center">' . $roworderinfo->qty . '</td>
                        <td class="edit_total d-none">' . number_format($roworderinfo->total, 2) . '</td>
                        <td class="text-right">' . number_format($roworderinfo->total, 2) . '</td>
                        </tr>';
                }

                $html .= ' </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col text-right">
                                <h1 class="font-weight-600" id="edit_divtotal">Rs. '.number_format(  $respond->row(0)->total, 2).'</h1>
                            </div>
                            <input type="hidden" id="edit_hidetotalorder" value="0">
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="small font-weight-bold text-dark">Remark</label>
                            <textarea name="remark" id="edit_remark" class="form-control form-control-sm">'.$respond->row(0)->remarks.'</textarea>
                        </div>
                        <div class="form-group mt-2">
                            <button type="button" id="edit_btncreateorder"
                                    class="btn btn-outline-primary btn-sm fa-pull-right"><i
                                        class="fas fa-save"></i>&nbsp;Create
                                Good Receive Note
                            </button>
                        </div>
                    </div>
                </div>
        
        ';

        echo $html;
    }

    public function Goodreceivestatus($x, $y)
    {
        $this->db->trans_begin();

        $userID = $_SESSION['userid'];
        $recordID = $x;
        $type = $y;
        $updatedatetime = date('Y-m-d H:i:s');

        if ($type == 1) {
            $data = array(
                'approvestatus' => '1',
                'updateuser' => $userID,
                'updatedatetime' => $updatedatetime
            );

            $this->db->where('idtbl_grn', $recordID);
            $this->db->update('tbl_grn', $data);

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
                redirect('Goodreceive');
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
                redirect('Goodreceive');
            }
        } else if ($type == 3) {
            $data = array(
                'status' => '3',
                'updateuser' => $userID,
                'updatedatetime' => $updatedatetime
            );

            $this->db->where('idtbl_grn', $recordID);
            $this->db->update('tbl_grn', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();

                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-trash-alt';
                $actionObj->title = '';
                $actionObj->message = 'Record Reject Successfully';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'danger';

                $actionJSON = json_encode($actionObj);

                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Goodreceive');
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
                redirect('Goodreceive');
            }
        }
    }

    public function Getsupplieraccoporder()
    {
        $recordID = $this->input->post('recordID');

        $this->db->select('`tbl_supplier_idtbl_supplier`');
        $this->db->from('tbl_porder');
        $this->db->where('status', 1);
        $this->db->where('idtbl_porder', $recordID);

        $respond = $this->db->get();

        echo $respond->row(0)->tbl_supplier_idtbl_supplier;
    }

    public function Getproductaccoporder()
    {
        $recordID = $this->input->post('recordID');

        $sql = "SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname` FROM `tbl_porder_detail` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_porder_detail`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_material_info`.`status`=? AND `tbl_porder_detail`.`tbl_porder_idtbl_porder`=?";
        $respond = $this->db->query($sql, array(1, $recordID));

        echo json_encode($respond->result());
    }

    public function Getproductinfoaccoproduct()
    {
        $recordID = $this->input->post('recordID');

        $this->db->select('`qty`, `unitprice`, `comment`');
        $this->db->from('tbl_porder_detail');
        $this->db->where('status', 1);
        $this->db->where('tbl_material_info_idtbl_material_info', $recordID);

        $respond = $this->db->get();

        $obj = new stdClass();
        $obj->qty = $respond->row(0)->qty;
        $obj->unitprice = $respond->row(0)->unitprice;
        $obj->comment = $respond->row(0)->comment;

        echo json_encode($obj);
    }

    public function Getexpdateaccoquater()
    {
        $recordID = $this->input->post('recordID');
        $mfdate = $this->input->post('mfdate');

        if ($recordID == 1) {
            $addmonth = 3;
        } else if ($recordID == 2) {
            $addmonth = 6;
        } else if ($recordID == 3) {
            $addmonth = 9;
        } else if ($recordID == 4) {
            $addmonth = 12;
        } else if ($recordID == 5) {
            $addmonth = 18;
        } else if ($recordID == 6) {
            $addmonth = 24;
        }

        echo date('Y-m-d', strtotime("+$addmonth months", strtotime($mfdate)));
    }

    public function Getbatchnoaccosupplier()
    {
        $recordID = $this->input->post('recordID');

        if (!empty($recordID)) {
            $this->db->select('tbl_supplier.`suppliercode`, tbl_material_category.categorycode');
            $this->db->from('tbl_supplier');
            $this->db->join('tbl_supplier_has_tbl_material_category', 'tbl_supplier_has_tbl_material_category.tbl_supplier_idtbl_supplier = tbl_supplier.idtbl_supplier', 'left');
            $this->db->join('tbl_material_category', 'tbl_material_category.idtbl_material_category = tbl_supplier_has_tbl_material_category.tbl_material_category_idtbl_material_category', 'left');
            $this->db->where('tbl_supplier.idtbl_supplier', $recordID);
            $this->db->where('tbl_supplier.status', 1);

            $responddetail = $this->db->get();

            // print_r($this->db->last_query());    
            $materialcode = $responddetail->row(0)->categorycode;
            $suppliercode = $responddetail->row(0)->suppliercode;

            $sql = "SELECT COUNT(*) AS `count` FROM `tbl_grn`";
            $respond = $this->db->query($sql);

            if ($respond->row(0)->count == 0) {
                $batchno = date('dmY') . '001';
            } else {
                $count = '000' . ($respond->row(0)->count + 1);
                $count = substr($count, -3);
                $batchno = date('dmY') . $count;
            }

            echo $suppliercode . $materialcode . $batchno;
        } else {
            echo '';
        }
    }

    public function Getordertype()
    {
        $this->db->select('`idtbl_order_type`, `type`');
        $this->db->from('tbl_order_type');
        $this->db->where('status', 1);

        return $respond = $this->db->get();
    }

    public function Getpordertpeaccoporder()
    {
        $recordID = $this->input->post('recordID');

        $this->db->select('`tbl_order_type_idtbl_order_type`');
        $this->db->from('tbl_porder');
        $this->db->where('status', 1);
        $this->db->where('idtbl_porder', $recordID);

        $respond = $this->db->get();

        echo $respond->row(0)->tbl_order_type_idtbl_order_type;
    }

    public function getGoodReceiveApprove($id = null)
    {
        $sql = "SELECT tg.*, 
                 tot.type as order_type,
                ts.suppliername as suppliername,
                tl.location as location 
            FROM tbl_grn tg 
            LEFT JOIN tbl_order_type tot ON tot.idtbl_order_type = tg.tbl_order_type_idtbl_order_type
            LEFT JOIN tbl_supplier ts ON ts.idtbl_supplier = tg.tbl_supplier_idtbl_supplier
            LEFT JOIN tbl_location tl ON tl.idtbl_location = tg.tbl_location_idtbl_location 
            WHERE tg.approvestatus = 0   
            ORDER BY tg.idtbl_grn DESC
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getGoodReceiveReport($id = null)
    {
        $sql = "SELECT tg.*, 
                 tot.type as order_type,
                ts.suppliername as suppliername,
                tl.location as location 
            FROM tbl_grn tg 
            LEFT JOIN tbl_order_type tot ON tot.idtbl_order_type = tg.tbl_order_type_idtbl_order_type
            LEFT JOIN tbl_supplier ts ON ts.idtbl_supplier = tg.tbl_supplier_idtbl_supplier
            LEFT JOIN tbl_location tl ON tl.idtbl_location = tg.tbl_location_idtbl_location 
            WHERE tg.approvestatus = 1  
            ORDER BY tg.idtbl_grn DESC
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

}