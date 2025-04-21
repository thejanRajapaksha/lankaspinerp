<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

require 'vendor/autoload.php';

use Dompdf\Dompdf;

class Goodreceive extends Admin_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Goodreceiveinfo');

        $this->data['locationlist']=$this->Goodreceiveinfo->Getlocation();
        $this->data['supplierlist']=$this->Goodreceiveinfo->Getsupplier();
        $this->data['porderlist']=$this->Goodreceiveinfo->Getporder();
        $this->data['ordertypelist']=$this->Goodreceiveinfo->Getordertype();
		//$this->load->view('grn/goodreceive', $result);

        $add_check = false;
        if(in_array('createGRN', $this->permission)) {
            $add_check = true;
        }
        $edit_check = false;
        if(in_array('updateGRN', $this->permission)) {
            $edit_check = true;
        }
        $delete_check = false;
        if(in_array('deleteGRN', $this->permission)) {
            $delete_check = true;
        }

        $this->data['addcheck'] = $add_check;
        $this->data['editcheck'] = $edit_check;
        $this->data['deletecheck'] = $delete_check;
        $this->data['statuscheck'] = $edit_check;

        $this->render_template('grn/goodreceive', $this->data );

	}
    public function Goodreceiveinsertupdate(){
		$this->load->model('Goodreceiveinfo');
        $result=$this->Goodreceiveinfo->Goodreceiveinsertupdate();
	}

    public function Goodreceiveupdate(){
        $this->load->model('Goodreceiveinfo');
        $result=$this->Goodreceiveinfo->Goodreceiveupdate();
    }

    public function Goodreceivedelete(){
        $id = $this->input->post('id');

        $this->db->where('tbl_grn_idtbl_grn', $id);
        $this->db->delete('tbl_grndetail');

        $this->db->where('idtbl_grn', $id);
        $this->db->delete('tbl_grn');
        $response['status'] = true;
        $response['msg'] = 'Successfully Deleted';
        echo json_encode($response);
    }

    public function Goodreceivestatus($x, $y){
		$this->load->model('Goodreceiveinfo');
        $result=$this->Goodreceiveinfo->Goodreceivestatus($x, $y);
	}
    public function Goodreceiveedit(){
		$this->load->model('Goodreceiveinfo');
        $result=$this->Goodreceiveinfo->Goodreceiveedit();
	}
    public function Getproductaccosupplier(){
		$this->load->model('Goodreceiveinfo');
        $result=$this->Goodreceiveinfo->Getproductaccosupplier();
	}
    public function Goodreceiveview(){
		$this->load->model('Goodreceiveinfo');
        $result=$this->Goodreceiveinfo->Goodreceiveview();
	}
    public function Getsupplieraccoporder(){
		$this->load->model('Goodreceiveinfo');
        $result=$this->Goodreceiveinfo->Getsupplieraccoporder();
	}
    public function Getproductaccoporder(){
		$this->load->model('Goodreceiveinfo');
        $result=$this->Goodreceiveinfo->Getproductaccoporder();
	}
    public function Getproductinfoaccoproduct(){
		$this->load->model('Goodreceiveinfo');
        $result=$this->Goodreceiveinfo->Getproductinfoaccoproduct();
	}
    public function Getexpdateaccoquater(){
		$this->load->model('Goodreceiveinfo');
        $result=$this->Goodreceiveinfo->Getexpdateaccoquater();
	}
    public function Getbatchnoaccosupplier(){
		$this->load->model('Goodreceiveinfo');
        $result=$this->Goodreceiveinfo->Getbatchnoaccosupplier();
	}
    public function Getpordertpeaccoporder(){
		$this->load->model('Goodreceiveinfo');
        $result=$this->Goodreceiveinfo->Getpordertpeaccoporder();
	}

    public function approve_front()
    {
        if (!in_array('createGRNApprove', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $this->data['js'] = 'application/views/grn/grn_approve-js.php';
        $this->render_template('grn/grn_approve', $this->data);
    }

    public function fetchGoodReceiveDataApprove(){
        if (!in_array('createGRNApprove', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());
        $this->load->model('Goodreceiveinfo');
        $data =  $this->Goodreceiveinfo->getGoodReceiveApprove();

        foreach ($data as $key => $value) {

            $buttons = '';
            $buttons .= '<button class="btn btn-dark btn-sm btnview mr-1" id="' . $value['idtbl_grn'] . '"><i class="fas fa-eye"></i></button>';

            $cb = '<label>';
            $cb .= '<input type="checkbox" ';
            $cb .= 'data-id = "'.$value['idtbl_grn'].'" ';

            $cb .= 'class = "cb"/> ';
            $cb .= '</label>';

            if($value['approvestatus'] == 0){
                $cb1 = $cb;
            }else{
                $cb1 = '';
            }

            $approved_label = '<badge class="badge badge-success bg-success text-white"> Yes </badge> ';
            if($value['approvestatus'] == 0){
                $approved_label = '<badge class="badge badge-danger bg-danger text-white"> No </badge> ';
            }

            $grn_label = '<badge class="badge badge-success bg-success text-white"> Yes </badge> ';
            if($value['qualitycheck'] == 0){
                $grn_label = '<badge class="badge badge-danger bg-danger text-white"> No </badge> ';
            }

            $result['data'][$key] = array(
                $cb1,
                $value['order_type'],
                $value['grndate'],
                $value['batchno'],
                $value['suppliername'],
                $value['location'],
                $value['invoicenum'],
                $value['dispatchnum'],
                number_format($value['total'], 2, '.', ',') ,
                $approved_label,
                $grn_label,
                $value['remarks'],
                $buttons
            );
        } // /foreach

        echo json_encode($result);

    }

    public function approve()
    {

        $selected_cb = $this->input->post('selected_cb');

        if (empty($selected_cb)) {
            $response['status'] = false;
            $response['msg'] = '<p class="text-danger"> Please select at least one record </p>';
            echo json_encode($response);
            die();
        }

        //$data_arr = array();
        foreach ($selected_cb as $cr) {

            $data =  array(
                'approvestatus' => 1,
                'approved_by' => $this->session->userdata('id'),
                'approved_at' => date('Y-m-d H:i:s')
            );

            $this->db->where('idtbl_grn', $cr['id']);
            $this->db->update('tbl_grn', $data);


            $grn_id = $cr['id'];

            $sql = "SELECT gd.*, tg.batchno, tg.idtbl_grn  
            FROM tbl_grn tg 
            LEFT JOIN tbl_grndetail gd ON tg.idtbl_grn = gd.tbl_grn_idtbl_grn 
            WHERE tg.idtbl_grn = '$grn_id' 
            ORDER BY tg.idtbl_grn DESC
            ";
            $query = $this->db->query($sql);
            $grn_details = $query->result_array();

            foreach ($grn_details as $gd){
                $data = array(
                    'grn_id' => $gd['idtbl_grn'],
                    'batchno' => $gd['batchno'],
                    'qty' => $gd['qty'],
                    'spare_part_id' => $gd['spare_part_id'],
                    'created_by' => $this->session->userdata('id'),
                    'created_at' => date('Y-m-d H:i:s')
                );
                $this->db->insert('tbl_stock', $data);
            }

        }

        $response['status'] = true;
        $response['msg'] = 'Successfully Updated';

        echo json_encode($response);

    }

    public function stock_report()
    {
        if (!in_array('viewStock', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $this->data['js'] = 'application/views/grn/view-stock-js.php';
        $this->render_template('grn/view-stock', $this->data);
    }

    public function get_part_no_select_from_stock()
    {
        $term = $this->input->get('term');
        $page = $this->input->get('page');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $this->db->select('spare_parts.id, spare_parts.name, spare_parts.part_no ');
        $this->db->from('tbl_stock');
        $this->db->join('spare_parts', 'spare_parts.id = tbl_stock.spare_part_id', 'left');
        $this->db->where('spare_parts.is_deleted', 0 );
        $this->db->like('spare_parts.name', $term, 'both');
        $this->db->group_by('spare_parts.id');
        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $departments = $query->result_array();

        $this->db->select('spare_parts.id, spare_parts.name, spare_parts.part_no ');
        $this->db->from('tbl_stock');
        $this->db->join('spare_parts', 'spare_parts.id = tbl_stock.spare_part_id', 'left');
        $this->db->where('spare_parts.is_deleted', 0 );
        $this->db->like('spare_parts.name', $term, 'both');
        $this->db->group_by('spare_parts.id');
        $count = $this->db->count_all_results();

        $data = array();
        foreach ($departments as $v) {
            $data[] = array(
                'id' => $v['id'],
                'text' => $v['part_no']. ' - ' .$v['name'],
            );
        }

        $endCount = $offset + $resultCount;
        $morePages = $endCount < $count;

        $results = array(
            "results" => $data,
            "pagination" => array(
                "more" => $morePages
            )
        );

        echo json_encode($results);

    }

    public function get_supplier_select_from_stock()
    {
        $term = $this->input->get('term');
        $page = $this->input->get('page');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $this->db->select('tbl_supplier.idtbl_supplier, tbl_supplier.suppliername');
        $this->db->from('tbl_stock');
        $this->db->join('spare_parts', 'spare_parts.id = tbl_stock.spare_part_id', 'left');
        $this->db->join('spare_part_suppliers', 'spare_part_suppliers.sp_id = spare_parts.id', 'left');
        $this->db->join('tbl_supplier', 'tbl_supplier.idtbl_supplier = spare_part_suppliers.supplier_id', 'left');
        $this->db->like('tbl_supplier.suppliername', $term, 'both');
        $this->db->group_by('tbl_supplier.idtbl_supplier');
        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $departments = $query->result_array();

        $this->db->select('tbl_supplier.idtbl_supplier, tbl_supplier.suppliername');
        $this->db->from('tbl_stock');
        $this->db->join('spare_parts', 'spare_parts.id = tbl_stock.spare_part_id', 'left');
        $this->db->join('spare_part_suppliers', 'spare_part_suppliers.sp_id = spare_parts.id', 'left');
        $this->db->join('tbl_supplier', 'tbl_supplier.idtbl_supplier = spare_part_suppliers.supplier_id', 'left');
        $this->db->like('tbl_supplier.suppliername', $term, 'both');
        $this->db->group_by('tbl_supplier.idtbl_supplier');
        $count = $this->db->count_all_results();

        $data = array();
        foreach ($departments as $v) {
            $data[] = array(
                'id' => $v['idtbl_supplier'],
                'text' => $v['suppliername'],
            );
        }

        $endCount = $offset + $resultCount;
        $morePages = $endCount < $count;

        $results = array(
            "results" => $data,
            "pagination" => array(
                "more" => $morePages
            )
        );

        echo json_encode($results);

    }

    public function get_machine_type_select_from_stock()
    {
        $term = $this->input->get('term');
        $page = $this->input->get('page');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $this->db->select('machine_types.id, machine_types.name');
        $this->db->from('tbl_stock');
        $this->db->join('spare_parts', 'spare_parts.id = tbl_stock.spare_part_id', 'left');
        $this->db->join('machine_types', 'machine_types.id = spare_parts.type', 'left');
        $this->db->group_by('machine_types.id');
        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $departments = $query->result_array();

        $this->db->select('machine_types.id, machine_types.name');
        $this->db->from('tbl_stock');
        $this->db->join('spare_parts', 'spare_parts.id = tbl_stock.spare_part_id', 'left');
        $this->db->join('machine_types', 'machine_types.id = spare_parts.type', 'left');
        $this->db->group_by('machine_types.id');
        $count = $this->db->count_all_results();

        $data = array();
        foreach ($departments as $v) {
            $data[] = array(
                'id' => $v['id'],
                'text' => $v['name'],
            );
        }

        $endCount = $offset + $resultCount;
        $morePages = $endCount < $count;

        $results = array(
            "results" => $data,
            "pagination" => array(
                "more" => $morePages
            )
        );

        echo json_encode($results);

    }

    public function get_spare_part_name_from_stock()
    {
        $term = $this->input->get('term');
        $page = $this->input->get('page');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $this->db->select('spare_parts.id, spare_parts.name');
        $this->db->from('tbl_stock');
        $this->db->join('spare_parts', 'spare_parts.id = tbl_stock.spare_part_id', 'left');
        $this->db->group_by('spare_parts.id');
        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $departments = $query->result_array();

        $this->db->select('spare_parts.id, spare_parts.name');
        $this->db->from('tbl_stock');
        $this->db->join('spare_parts', 'spare_parts.id = tbl_stock.spare_part_id', 'left');
        $this->db->group_by('spare_parts.id');
        $count = $this->db->count_all_results();

        $data = array();
        foreach ($departments as $v) {
            $data[] = array(
                'id' => $v['id'],
                'text' => $v['name'],
            );
        }

        $endCount = $offset + $resultCount;
        $morePages = $endCount < $count;

        $results = array(
            "results" => $data,
            "pagination" => array(
                "more" => $morePages
            )
        );

        echo json_encode($results);

    }

    public function fetchStockReport(){
        if (!in_array('viewGRN', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $spare_part_id = $this->input->post('spare_part_id');
        $supplier_id = $this->input->post('supplier_id');
        $machine_type_id = $this->input->post('machine_type_id');

        $sql = "SELECT SUM(ts.qty) as sum_qty, sp.name, sp.part_no, sp.id as sp_id
                FROM tbl_stock ts
                LEFT JOIN spare_parts sp ON sp.id = ts.spare_part_id
                LEFT JOIN spare_part_suppliers sps ON sps.sp_id = ts.spare_part_id 
                WHERE 1 = 1 
            ";
        if($spare_part_id != ''){
            $sql .= " AND ts.spare_part_id = '$spare_part_id' ";
        }

        if($supplier_id != ''){
            $sql .= " AND sps.supplier_id = '$supplier_id' ";
        }

        if($machine_type_id != ''){
            $sql .= " AND sp.type = '$machine_type_id' ";
        }

        $sql .= " GROUP BY ts.spare_part_id ";

        $query = $this->db->query($sql);
        $data = $query->result_array();

        $result = array();
        foreach ($data as $key => $value) {

            $id = $value['sp_id'];
            $sql2 = "
                SELECT SUM(qty) as sum_qty FROM machine_service_allocated_items
                WHERE spare_part_id = '$id' and is_finished = 0 AND is_deleted = 0
            ";
            $query1 = $this->db->query($sql2);
            $data1 = $query1->row_array();

            $remaining_stock = $value['sum_qty']-$data1['sum_qty'];

            $btn = '';
            if(!empty($data1)){
                if($data1['sum_qty'] > 0){
                    $btn = '<button type="button" class="btn btn-primary btn-sm btn_view" data-toggle="modal" data-target="#viewModal" data-spare_part_id="'.$id.'"> <i class="fa fa-eye text-white"></i> </button>';
                }
            }
  
            $result['data'][$key] = array(
                $value['part_no']. ' - ' .$value['name'],
                $remaining_stock,
                $data1['sum_qty'],
                $btn
            );
        } // /foreach

        echo json_encode($result);

    }

    public function grn_report()
    {
        if (!in_array('viewGRN', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $this->data['js'] = 'application/views/grn/view-grn-js.php';
        $this->render_template('grn/view-grn', $this->data);
    }

    public function fetchGoodReceiveDataReport(){
        if (!in_array('viewGRN', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $spare_part_id = $this->input->post('spare_part_id');
        $supplier_id = $this->input->post('supplier_id');
        $machine_type_id = $this->input->post('machine_type_id');


        $sql = "SELECT tg.*, 
                 tot.type as order_type,
                ts.suppliername as suppliername,
                tl.location as location 
            FROM tbl_grn tg 
            LEFT JOIN tbl_grndetail tgd ON tgd.tbl_grn_idtbl_grn = tg.idtbl_grn
            LEFT JOIN tbl_order_type tot ON tot.idtbl_order_type = tg.tbl_order_type_idtbl_order_type
            LEFT JOIN tbl_supplier ts ON ts.idtbl_supplier = tg.tbl_supplier_idtbl_supplier
            LEFT JOIN tbl_location tl ON tl.idtbl_location = tg.tbl_location_idtbl_location 
            LEFT JOIN tbl_porder po ON po.idtbl_porder = tg.tbl_porder_idtbl_porder 
            LEFT JOIN spare_parts sp on tgd.spare_part_id = sp.id
            WHERE tg.approvestatus = 1   
            ";
        if($spare_part_id != ''){
            $sql .= " AND tgd.spare_part_id = '$spare_part_id' ";
        }

        if($supplier_id != ''){
            $sql .= " AND ts.idtbl_supplier = '$supplier_id' ";
        }

        if($machine_type_id != ''){
            $sql .= " AND sp.type = '$machine_type_id' ";
        }

        $sql .= ' ORDER BY tg.idtbl_grn DESC';

        $query = $this->db->query($sql);
        $data = $query->result_array();

        $result = array();
        foreach ($data as $key => $value) {

            // button
            $buttons = '';
            $buttons .= '<button class="btn btn-dark btn-sm btnview mr-1" id="' . $value['idtbl_grn'] . '"><i class="fas fa-eye"></i></button>';

            $result['data'][$key] = array(
                $value['order_type'],
                $value['grndate'],
                $value['batchno'],
                $value['suppliername'],
                $value['location'],
                $value['invoicenum'],
                $value['dispatchnum'],
                number_format($value['total'], 2, '.', ',') ,
                $value['remarks'],
                $buttons
            );
        } // /foreach

        echo json_encode($result);

    }

    public function GoodreceiveviewPrint($id){

        $sql = "SELECT `u`.*, `ua`.`suppliername`, `ua`.`primarycontactno`, `ua`.`secondarycontactno`, `ua`.`address`, `ua`.`email`, `ub`.`location`, `ub`.`phone`, `ub`.`address`, `ub`.`phone2`, `ub`.`email` AS `locemail` FROM `tbl_grn` AS `u` LEFT JOIN `tbl_supplier` AS `ua` ON (`ua`.`idtbl_supplier` = `u`.`tbl_supplier_idtbl_supplier`) LEFT JOIN `tbl_location` AS `ub` ON (`ub`.`idtbl_location` = `u`.`tbl_location_idtbl_location`) WHERE `u`.`status`=? AND `u`.`idtbl_grn`=?";
        $respond = $this->db->query($sql, array(1, $id));

        $this->db->select('tbl_grndetail.*, spare_parts.id, spare_parts.name, spare_parts.part_no');
        $this->db->from('tbl_grndetail');
        $this->db->join('spare_parts', 'spare_parts.id = tbl_grndetail.spare_part_id', 'left');
        $this->db->where('tbl_grndetail.tbl_grn_idtbl_grn', $id);
        $this->db->where('tbl_grndetail.status', 1);

        $responddetail = $this->db->get();

        $print_date = date("Y-m-d h:i:s");
        $dompdf = new Dompdf();
        $options = $dompdf->getOptions();
        $options->setIsHtml5ParserEnabled(true);
        $options->isPhpEnabled(true);
        $dompdf->setOptions($options);

        $html = '

            <h3 style="text-align: center"> Good Receive Note  </h3>
            
            <table style="width: 100%; margin-bottom: 15px;">
                <tr>
                    <td> ' . date("Y-m-d") . '<br>'  . $respond->row(0)->location . '<br>' . $respond->row(0)->phone . ' / ' . $respond->row(0)->phone2 . '<br>' . $respond->row(0)->address . '<br>' . $respond->row(0)->locemail . ' </td>
                    <td style="text-align: right"> '. $respond->row(0)->suppliername . '<br>' . $respond->row(0)->primarycontactno . ' / ' . $respond->row(0)->secondarycontactno . '<br>' . $respond->row(0)->address . '<br>' . $respond->row(0)->email . ' </td>
                </tr>
            </table>
            
             <hr>
                <p>Invoice No : ' . $respond->row(0)->invoicenum . '</p>
                <p>Dispatch No : ' . $respond->row(0)->dispatchnum . '</p>
                <p>Batch No : ' . $respond->row(0)->batchno . '</p>
                
            <table style="width: 100%">
                <thead>
                        <tr>
                            <th style="text-align: left">Product</th>
                            <th style="text-align: right">Unit Price</th>
                            <th style="text-align: right">Qty</th> 
                            <th style="text-align: right">Total</th>
                        </tr>
                    </thead>
                <tbody>';
        foreach ($responddetail->result() as $roworderinfo) {
            $total = number_format(($roworderinfo->qty * $roworderinfo->unitprice), 2);

                    $html .= '<tr>
                                <td style="text-align: left">' . $roworderinfo->name . ' - ' . $roworderinfo->part_no . '</td>
                                <td style="text-align: right">' . number_format($roworderinfo->unitprice, 2) . '</td>
                                <td style="text-align: right">' . number_format($roworderinfo->qty, 2). '</td> 
                                <td style="text-align: right">' . number_format($total, 2) . '</td>
                            </tr>';
                }
            $html .='</tbody>';

            $html.='
                <tfoot>
                <tr>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td style="text-align: right; font-size: larger; font-weight: bold" >Rs. '.number_format(($respond->row(0)->total), 2).'</td>
                        </tr>
                </tfoot> ';

            $html .='</table>';

        $dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
        $dompdf->render();

        $canvas = $dompdf->get_canvas();

        $font = $dompdf->getFontMetrics()->get_font("Arial, Helvetica, sans-serif", "normal");
        $size = 8;
//$pageText = $PAGE_NUM . "/" . $PAGE_COUNT;
        $pageText = "Page: {PAGE_NUM} of {PAGE_COUNT}";
        $y = $canvas->get_height() - 24;
//$x = $pdf->get_width() - 15 - Font_Metrics::get_text_width($pageText, $font, $size);
        $x = round(($canvas->get_width() - $dompdf->getFontMetrics()->get_text_width("Page: 000 of 000", $font, $size)) / 2, 0);
        $canvas->page_text($x, $y, $pageText, $font, $size);

        $canvas->page_script('
	  if ($PAGE_NUM < $PAGE_COUNT) {
		$font = $dompdf->getFontMetrics()->get_font("helvetica", "bold");
		$current_page = $PAGE_NUM;
		$total_pages = $PAGE_COUNT;
		$pdf->text($pdf->get_width()-100, $pdf->get_height()-60, "Continued", $font, 10, array(0,0,0));
	  }
	');

// Output the generated PDF to Browser

        $file_name = "Good Receive - " . $id . ' ' . $print_date . ".pdf";
        $dompdf->stream($file_name);

    }



}