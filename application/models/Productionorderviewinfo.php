<?php
class Productionorderviewinfo extends CI_Model{
    public function Getmachinelist(){
        $this->db->select('`idtbl_machine`, `machine`, `machinecode`');
        $this->db->from('tbl_machine');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getproductionorderid(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_production_order_idtbl_production_order` FROM `tbl_production_orderdetail`
         WHERE `idtbl_production_orderdetail`= $recordID AND `status`= 1";
        $respond=$this->db->query($sql, array(1, $recordID));

        echo json_encode($respond->result());

    }
   
    public function Machineinsertupdate(){

        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $tableData = $this->input->post('tableData');
        $productionorderId=$this->input->post('productionorderId');

        $insertdatetime=date('Y-m-d H:i:s');
        $allocatedatetime=date('Y-m-d H:i:s');

foreach($tableData as $rowtabledata){
            $data = array( 
                'tbl_machine_idtbl_machine'=> $rowtabledata['col_2'],
                'allocatedate'=> $allocatedatetime,
                'startdatetime'=> $rowtabledata['col_3'], 
                'enddatetime'=> $rowtabledata['col_4'], 
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
                'tbl_production_order_idtbl_production_order'=> $productionorderId,
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
                redirect('Productionorderview');                
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
                redirect('Productionorderview');
            }        

    }

    public function Productionorderstatus($x, $y){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
        $type=$y;
        $updatedatetime=date('Y-m-d H:i:s');

        if($type==3){
            $data = array(
                'status' => '3',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_production_orderdetail', $recordID);
            $this->db->update('tbl_production_orderdetail', $data);

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
                redirect('Productionorderview');                
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
                redirect('Productionorderview');
            }
        }
    }

    public function Checkmachineavailability(){
        $machineid = $_POST['machineid'];
        $startdate = $_POST['startdate'];
        $enddate = $_POST['enddate'];

        $sql="SELECT `tbl_machine_idtbl_machine`, `startdatetime`, `enddatetime` FROM `tbl_machine_allocation`
        WHERE '$startdate' < DATE(`enddatetime`) AND '$enddate' > DATE(`startdatetime`) AND `tbl_machine_idtbl_machine`= ?  AND `status`= 1";
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

    public function Productiondetailaccoproduction(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_production_orderdetail`.`idtbl_production_orderdetail`, `tbl_material_code`.`materialname`, `tbl_product`.`productcode` FROM `tbl_production_orderdetail` LEFT JOIN `tbl_product` ON `tbl_product`.`idtbl_product`=`tbl_production_orderdetail`.`tbl_product_idtbl_product` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_product`.`materialid` WHERE `tbl_production_orderdetail`.`tbl_production_order_idtbl_production_order`=? AND `tbl_production_orderdetail`.`status`=?";
        $respond=$this->db->query($sql, array($recordID, 1));

        echo json_encode($respond->result());
    }
    public function Getqtyinfoaccoproductiondetail(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_production_orderdetail`.`qty`, SUM(`tbl_production_material`.`qty`) AS `issueqty` FROM `tbl_production_orderdetail` LEFT JOIN `tbl_production_material` ON `tbl_production_material`.`tbl_production_orderdetail_idtbl_production_orderdetail`=`tbl_production_orderdetail`.`idtbl_production_orderdetail` WHERE `tbl_production_orderdetail`.`idtbl_production_orderdetail`=?";
        $respond=$this->db->query($sql, array($recordID));

        echo json_encode($respond->result());
    }
    public function Getrowmateriallist(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_print_material_info`.`idtbl_print_material_info`, `tbl_print_material_info`.`materialinfocode`, `tbl_material_code`.`materialname` FROM `tbl_production_orderdetail` LEFT JOIN `tbl_product_bom` ON `tbl_product_bom`.`tbl_product_idtbl_product`=`tbl_production_orderdetail`.`tbl_product_idtbl_product` LEFT JOIN `tbl_print_material_info` ON `tbl_print_material_info`.`idtbl_print_material_info`=`tbl_product_bom`.`tbl_print_material_info_idtbl_print_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_print_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_print_material_info`.`status`=? AND `tbl_print_material_info`.`tbl_material_category_idtbl_material_category`=? AND `tbl_production_orderdetail`.`idtbl_production_orderdetail`=?";
        $respond=$this->db->query($sql, array(1, 1, $recordID));

        echo json_encode($respond->result());
    }
    public function Getpackmateriallist(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_print_material_info`.`idtbl_print_material_info`, `tbl_print_material_info`.`materialinfocode`, `tbl_material_code`.`materialname` FROM `tbl_production_orderdetail` LEFT JOIN `tbl_product_bom` ON `tbl_product_bom`.`tbl_product_idtbl_product`=`tbl_production_orderdetail`.`tbl_product_idtbl_product` LEFT JOIN `tbl_print_material_info` ON `tbl_print_material_info`.`idtbl_print_material_info`=`tbl_product_bom`.`tbl_print_material_info_idtbl_print_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_print_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_print_material_info`.`status`=? AND `tbl_print_material_info`.`tbl_material_category_idtbl_material_category`=? AND `tbl_production_orderdetail`.`idtbl_production_orderdetail`=?";
        $respond=$this->db->query($sql, array(1, 2, $recordID));

        echo json_encode($respond->result());
    }
    public function Getlablemateriallist(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_print_material_info`.`idtbl_print_material_info`, `tbl_print_material_info`.`materialinfocode`, `tbl_material_code`.`materialname` FROM `tbl_production_orderdetail` LEFT JOIN `tbl_product_bom` ON `tbl_product_bom`.`tbl_product_idtbl_product`=`tbl_production_orderdetail`.`tbl_product_idtbl_product` LEFT JOIN `tbl_print_material_info` ON `tbl_print_material_info`.`idtbl_print_material_info`=`tbl_product_bom`.`tbl_print_material_info_idtbl_print_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_print_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_print_material_info`.`status`=? AND `tbl_print_material_info`.`tbl_material_category_idtbl_material_category`=? AND `tbl_production_orderdetail`.`idtbl_production_orderdetail`=?";
        $respond=$this->db->query($sql, array(1, 3, $recordID));

        echo json_encode($respond->result());
    }
    public function Getmaterialenterlayout(){
        echo '<table class="table table-striped table-bordered table-sm small">
            <tr>
                <th>Row Material</th>
                <td class="p-0 border-0">
                    <table class="table-striped table-bordered table-sm w-100" id="rowmaterialtable">
                        <thead>
                            <tr>
                                <th>Material</th>
                                <th>Batch No</th>
                                <th>Qty</th>
                                <th class="d-none">materialID</th>
                                <th class="d-none">qtylist</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td width="40%">
                                    <select class="form-control form-control-sm rowmaterial">
                                        <option value="">Row Material</option>
                                    </select>
                                </td>
                                <td></td>
                                <td></td>
                                <td class="d-none"></td>
                                <td class="d-none"></td>
                            </tr>
                            <tr>
                                <td width="40%">
                                    <select class="form-control form-control-sm rowmaterial">
                                        <option value="">Row Material</option>
                                    </select>
                                </td>
                                <td></td>
                                <td></td>
                                <td class="d-none"></td>
                                <td class="d-none"></td>
                            </tr>
                            <tr>
                                <td width="40%">
                                    <select class="form-control form-control-sm rowmaterial">
                                        <option value="">Row Material</option>
                                    </select>
                                </td>
                                <td></td>
                                <td></td>
                                <td class="d-none"></td>
                                <td class="d-none"></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <th>Packing Material</th>
                <td class="p-0 border-0">
                    <table class="table-striped table-bordered table-sm w-100" id="packingmaterialtable">
                        <thead>
                            <tr>
                                <th>Material</th>
                                <th>Batch No</th>
                                <th>Qty</th>
                                <th class="d-none">materialID</th>
                                <th class="d-none">qtylist</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td width="40%">
                                    <select class="form-control form-control-sm packingmaterial">
                                        <option value="">Packing Material</option>
                                    </select>
                                </td>
                                <td></td>
                                <td></td>
                                <td class="d-none"></td>
                                <td class="d-none"></td>
                            </tr>
                            <tr>
                                <td width="40%">
                                    <select class="form-control form-control-sm packingmaterial">
                                        <option value="">Packing Material</option>
                                    </select>
                                </td>
                                <td></td>
                                <td></td>
                                <td class="d-none"></td>
                                <td class="d-none"></td>
                            </tr>
                            <tr>
                                <td width="40%">
                                    <select class="form-control form-control-sm packingmaterial">
                                        <option value="">Packing Material</option>
                                    </select>
                                </td>
                                <td></td>
                                <td></td>
                                <td class="d-none"></td>
                                <td class="d-none"></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <th>Lable Material</th>
                <td class="p-0 border-0">
                    <table class="table-striped table-bordered table-sm w-100" id="lablingmaterialtable">
                        <thead>
                            <tr>
                                <th>Material</th>
                                <th>Batch No</th>
                                <th>Qty</th>
                                <th class="d-none">materialID</th>
                                <th class="d-none">qtylist</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td width="40%">
                                    <select class="form-control form-control-sm lablematerial">
                                        <option value="">Labling Material</option>
                                    </select>
                                </td>
                                <td></td>
                                <td></td>
                                <td class="d-none"></td>
                                <td class="d-none"></td>
                            </tr>
                            <tr>
                                <td width="40%">
                                    <select class="form-control form-control-sm lablematerial">
                                        <option value="">Labling Material</option>
                                    </select>
                                </td>
                                <td></td>
                                <td></td>
                                <td class="d-none"></td>
                                <td class="d-none"></td>
                            </tr>
                            <tr>
                                <td width="40%">
                                    <select class="form-control form-control-sm lablematerial">
                                        <option value="">Labling Material</option>
                                    </select>
                                </td>
                                <td></td>
                                <td></td>
                                <td class="d-none"></td>
                                <td class="d-none"></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>';
    }
    public function Getmaterialstockinfoaccomaterial(){
        $materialID=$this->input->post('materialID');

        $sql="SELECT `batchno`, `qty` FROM `tbl_print_stock` WHERE `tbl_print_material_info_idtbl_print_material_info`=? AND `status`=?";
        $respond=$this->db->query($sql, array($materialID, 1));

        $html='';
        foreach($respond->result() as $rowstocklist){
            $html.='
            <tr>
                <td>'.$rowstocklist->batchno.'</td>
                <td>'.$rowstocklist->qty.'</td>
                <td class="enterqty"></td>
                <td class="d-none">'.$rowstocklist->batchno.'</td>
            </tr>
            ';
        }

        echo $html;
    }
    public function Checkissueqty(){
        $recordID=$this->input->post('recordID');
        $productionmaterialinfoID=$this->input->post('productionmaterialinfoID');

        $sql="SELECT SUM(`qty`) AS `issueqty` FROM `tbl_production_material` WHERE `tbl_production_orderdetail_idtbl_production_orderdetail`=? AND `tbl_print_material_info_idtbl_print_material_info`=?";
        $respond=$this->db->query($sql, array($productionmaterialinfoID, $recordID));

        echo $respond->row(0)->issueqty;
    }
    public function Issuematerialforproduction(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $tableDataMaterial=$this->input->post('tableDataMaterial');
        $tableDataPacking=$this->input->post('tableDataPacking');
        $tableDataLabeling=$this->input->post('tableDataLabeling');
        $orderqty=$this->input->post('orderqty');
        $orderfinishgood=$this->input->post('orderfinishgood');
        $productionorder=$this->input->post('productionorder');

        $updatedatetime=date('Y-m-d H:i:s');
        $today=date('Y-m-d');

        $this->db->select('`tbl_product_idtbl_product`, `tbl_production_order_idtbl_production_order`');
        $this->db->from('tbl_production_orderdetail');
        $this->db->where('idtbl_production_orderdetail', $orderfinishgood);

        $respondfg=$this->db->get();

        if(!empty($tableDataMaterial)){
            foreach($tableDataMaterial as $rowmaterial){
                $batchnumlist=$rowmaterial['col_2'];
                $totalqty=$rowmaterial['col_3'];
                $materialID=$rowmaterial['col_4'];
                $qtylist=$rowmaterial['col_5'];

                $dataone = array(
                    'productiontype'=> '1', 
                    'qty'=> $totalqty, 
                    'approvestatus'=> '0', 
                    'tbl_production_order_idtbl_production_order'=> $respondfg->row(0)->tbl_production_order_idtbl_production_order, 
                    'tbl_production_orderdetail_idtbl_production_orderdetail'=> $orderfinishgood, 
                    'tbl_product_idtbl_product'=> $respondfg->row(0)->tbl_product_idtbl_product, 
                    'tbl_print_material_info_idtbl_print_material_info'=> $materialID
                );

                $this->db->insert('tbl_production_material', $dataone);

                $productionmaterialID=$this->db->insert_id();

                $explodebatchno=explode(',', $batchnumlist);
                $explodebatchno=array_filter($explodebatchno);
                $explodeqtylist=explode(',', $qtylist);
                $explodeqtylist=array_filter($explodeqtylist);

                $i=0;
                foreach($explodebatchno as $batchno){
                    $qtycount=$explodeqtylist[$i];

                    $dataissue = array(
                        'issuedate'=> $today, 
                        'batchno'=> $batchno, 
                        'issueqty'=> $qtycount, 
                        'status'=> '1', 
                        'insertdatetime'=> $updatedatetime, 
                        'tbl_user_idtbl_user'=> $userID, 
                        'tbl_production_material_idtbl_production_material'=> $productionmaterialID, 
                        'tbl_product_idtbl_product'=> $respondfg->row(0)->tbl_product_idtbl_product
                    );

                    $this->db->insert('tbl_production_material_issue', $dataissue);

                    $i++;
                }
            }
        }

        if(!empty($tableDataPacking)){
            foreach($tableDataPacking as $rowpacking){
                $batchnumlist=$rowpacking['col_2'];
                $totalqty=$rowpacking['col_3'];
                $materialID=$rowpacking['col_4'];
                $qtylist=$rowpacking['col_5'];

                $dataone = array(
                    'productiontype'=> '2', 
                    'qty'=> $totalqty, 
                    'approvestatus'=> '0', 
                    'tbl_production_order_idtbl_production_order'=> $respondfg->row(0)->tbl_production_order_idtbl_production_order, 
                    'tbl_production_orderdetail_idtbl_production_orderdetail'=> $orderfinishgood, 
                    'tbl_product_idtbl_product'=> $respondfg->row(0)->tbl_product_idtbl_product, 
                    'tbl_print_material_info_idtbl_print_material_info'=> $materialID
                );

                $this->db->insert('tbl_production_material', $dataone);

                $productionmaterialID=$this->db->insert_id();

                $explodebatchno=explode(',', $batchnumlist);
                $explodebatchno=array_filter($explodebatchno);
                $explodeqtylist=explode(',', $qtylist);
                $explodeqtylist=array_filter($explodeqtylist);

                $i=0;
                foreach($explodebatchno as $batchno){
                    $qtycount=$explodeqtylist[$i];

                    $dataissue = array(
                        'issuedate'=> $today, 
                        'batchno'=> $batchno, 
                        'issueqty'=> $qtycount, 
                        'status'=> '1', 
                        'insertdatetime'=> $updatedatetime, 
                        'tbl_user_idtbl_user'=> $userID, 
                        'tbl_production_material_idtbl_production_material'=> $productionmaterialID, 
                        'tbl_product_idtbl_product'=> $respondfg->row(0)->tbl_product_idtbl_product
                    );

                    $this->db->insert('tbl_production_material_issue', $dataissue);

                    $i++;
                }
            }
        }

        if(!empty($tableDataLabeling)){
            foreach($tableDataLabeling as $rowlabeling){
                $batchnumlist=$rowlabeling['col_2'];
                $totalqty=$rowlabeling['col_3'];
                $materialID=$rowlabeling['col_4'];
                $qtylist=$rowlabeling['col_5'];

                $dataone = array(
                    'productiontype'=> '3', 
                    'qty'=> $totalqty, 
                    'approvestatus'=> '0', 
                    'tbl_production_order_idtbl_production_order'=> $respondfg->row(0)->tbl_production_order_idtbl_production_order, 
                    'tbl_production_orderdetail_idtbl_production_orderdetail'=> $orderfinishgood, 
                    'tbl_product_idtbl_product'=> $respondfg->row(0)->tbl_product_idtbl_product, 
                    'tbl_print_material_info_idtbl_print_material_info'=> $materialID
                );

                $this->db->insert('tbl_production_material', $dataone);

                $productionmaterialID=$this->db->insert_id();

                $explodebatchno=explode(',', $batchnumlist);
                $explodebatchno=array_filter($explodebatchno);
                $explodeqtylist=explode(',', $qtylist);
                $explodeqtylist=array_filter($explodeqtylist);

                $i=0;
                foreach($explodebatchno as $batchno){
                    $qtycount=$explodeqtylist[$i];

                    $dataissue = array(
                        'issuedate'=> $today, 
                        'batchno'=> $batchno, 
                        'issueqty'=> $qtycount, 
                        'status'=> '1', 
                        'insertdatetime'=> $updatedatetime, 
                        'tbl_user_idtbl_user'=> $userID, 
                        'tbl_production_material_idtbl_production_material'=> $productionmaterialID, 
                        'tbl_product_idtbl_product'=> $respondfg->row(0)->tbl_product_idtbl_product
                    );

                    $this->db->insert('tbl_production_material_issue', $dataissue);

                    $i++;
                }
            }
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

            $obj=new stdClass();
            $obj->status=1;          
            $obj->action=$actionJSON;  
            
            echo json_encode($obj);
        } else {
            $this->db->trans_rollback();

            $actionObj=new stdClass();
            $actionObj->icon='fas fa-exclamation-triangle';
            $actionObj->title='';
            $actionObj->message='Record Error';
            $actionObj->url='';
            $actionObj->target='_blank';
            $actionObj->type='danger';

            $actionJSON=json_encode($actionObj);

            $obj=new stdClass();
            $obj->status=0;          
            $obj->action=$actionJSON;  
            
            echo json_encode($obj);
        }
    }
}