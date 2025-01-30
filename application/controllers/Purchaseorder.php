<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

require 'vendor/autoload.php';

use Dompdf\Dompdf;

class Purchaseorder extends Admin_Controller
{
    public function index()
    {
        $this->load->model('Commeninfo');
        $this->load->model('Purchaseorderinfo');

        $this->data['locationlist'] = $this->Purchaseorderinfo->Getlocation();
        $this->data['supplierlist'] = $this->Purchaseorderinfo->Getsupplier();
        $this->data['ordertypelist'] = $this->Purchaseorderinfo->Getordertype();

        $add_check = false;
        if (in_array('createGRN', $this->permission)) {
            $add_check = true;
        }
        $edit_check = false;
        if (in_array('updateGRN', $this->permission)) {
            $edit_check = true;
        }
        $delete_check = false;
        if (in_array('deleteGRN', $this->permission)) {
            $delete_check = true;
        }

        $this->data['addcheck'] = $add_check;
        $this->data['editcheck'] = $edit_check;
        $this->data['deletecheck'] = $delete_check;
        $this->data['statuscheck'] = $edit_check;

        //$this->load->view('grn/materialdetail', $result);
        $this->render_template('grn/purchaseorder', $this->data);

        //$this->load->view('grn/purchaseorder', $result);
    }

    public function Purchaseorderinsertupdate()
    {
        $this->load->model('Purchaseorderinfo');
        $result = $this->Purchaseorderinfo->Purchaseorderinsertupdate();
    }

    public function Purchaseorderupdate()
    {
        $this->load->model('Purchaseorderinfo');
        $result = $this->Purchaseorderinfo->Purchaseorderupdate();
    }

    public function Purchaseorderstatus($x, $y)
    {
        $this->load->model('Purchaseorderinfo');
        $result = $this->Purchaseorderinfo->Purchaseorderstatus($x, $y);
    }

    public function Purchaseorderedit()
    {
        $this->load->model('Purchaseorderinfo');
        $result = $this->Purchaseorderinfo->Purchaseorderedit();
    }

    public function Getproductaccosupplier()
    {
        $this->load->model('Purchaseorderinfo');
        $result = $this->Purchaseorderinfo->Getproductaccosupplier();
    }

    public function Purchaseorderview()
    {
        $this->load->model('Purchaseorderinfo');
        $result = $this->Purchaseorderinfo->Purchaseorderview();
    }

    public function PurchaseorderviewPrint($id)
    {
        $sql="SELECT `u`.*, `ua`.`suppliername`, `ua`.`primarycontactno`, `ua`.`secondarycontactno`, `ua`.`address`, `ua`.`email`, `ub`.`location`, `ub`.`phone`, `ub`.`address`, `ub`.`phone2`, `ub`.`email` AS `locemail` FROM `tbl_porder` AS `u` LEFT JOIN `tbl_supplier` AS `ua` ON (`ua`.`idtbl_supplier` = `u`.`tbl_supplier_idtbl_supplier`) LEFT JOIN `tbl_location` AS `ub` ON (`ub`.`idtbl_location` = `u`.`tbl_location_idtbl_location`) WHERE `u`.`status`=? AND `u`.`idtbl_porder`=?";
        $respond=$this->db->query($sql, array(1, $id));

        $this->db->select('tbl_porder_detail.*, spare_parts.name, spare_parts.part_no');
        $this->db->from('tbl_porder_detail');
        $this->db->join('tbl_porder', 'tbl_porder.idtbl_porder  = tbl_porder_detail.tbl_porder_idtbl_porder', 'left');
        $this->db->join('spare_parts', 'spare_parts.id = tbl_porder_detail.spare_part_id', 'left');
        $this->db->where('tbl_porder_detail.tbl_porder_idtbl_porder', $id);
        $this->db->where('tbl_porder_detail.status', 1);

        $responddetail=$this->db->get();


        $print_date = date("Y-m-d h:i:s");
        $dompdf = new Dompdf();
        $options = $dompdf->getOptions();
        $options->setIsHtml5ParserEnabled(true);
        $options->isPhpEnabled(true);
        $dompdf->setOptions($options);

        $html='
        <h3 style="text-align: center"> Purchase Order  </h3>

        <table style="width: 100%; margin-bottom: 15px;">
            <tr>
                <td> ' . $respond->row(0)->suppliername.'<br>'.$respond->row(0)->primarycontactno.' / '.$respond->row(0)->secondarycontactno.'<br>'.$respond->row(0)->address.'<br>'.$respond->row(0)->email.' </td>
                <td style="text-align: right" > '. date("Y-m-d"). '<br>' . $respond->row(0)->location.'<br>'.$respond->row(0)->phone.' / '.$respond->row(0)->phone2.'<br>'.$respond->row(0)->address.'<br>'.$respond->row(0)->locemail.' </td>
            </tr> 
        </table>
        
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
        foreach($responddetail->result() as $roworderinfo){
            $html.='<tr>
                            <td style="text-align: left">'.$roworderinfo->name.' - '.$roworderinfo->part_no.'</td>
                            <td style="text-align: right">'.number_format($roworderinfo->unitprice, 2).'</td>
                            <td style="text-align: right">'.$roworderinfo->qty.'</td>
                            <td style="text-align: right">'.number_format(($roworderinfo->qty*$roworderinfo->unitprice), 2).'</td>
                        </tr>';
        }
        $html.='</tbody>';

        $html.='
                <tfoot>
                <tr>
                            <td> </td>
                            <td> </td>
                            <td> </td>
                            <td style="text-align: right; font-size: larger; font-weight: bold" >Rs. '.number_format(($respond->row(0)->nettotal), 2).'</td>
                        </tr>
                </tfoot> ';

        $html.='</table>';

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

        $file_name = "Purchase Order - " . $id . ' ' . $print_date . ".pdf";
        $dompdf->stream($file_name);

    }

    public function approve_front()
    {
        if (!in_array('createPurchaseOrderApprove', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        $this->data['js'] = 'application/views/grn/po_approve-js.php';
        $this->render_template('grn/po_approve', $this->data);
    }

    public function fetchPurchaseOrderDataApprove()
    {
        if (!in_array('createPurchaseOrderApprove', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $result = array('data' => array());
        $this->load->model('Purchaseorderinfo');
        $data = $this->Purchaseorderinfo->getPurchaseOrderDataApprove();

        foreach ($data as $key => $value) {

            // button
            $buttons = '';
            $buttons .= '<button class="btn btn-dark btn-sm btnview mr-1" id="' . $value['idtbl_porder'] . '"><i class="fas fa-eye"></i></button>';

            $cb = '<label>';
            $cb .= '<input type="checkbox" ';
            $cb .= 'data-id = "' . $value['idtbl_porder'] . '" ';

            $cb .= 'class = "cb"/> ';
            $cb .= '</label>';

            if ($value['confirmstatus'] == 0) {
                $cb1 = $cb;
            } else {
                $cb1 = '';
            }

            $approved_label = '<badge class="badge badge-success bg-success text-white"> Yes </badge> ';
            if ($value['confirmstatus'] == 0) {
                $approved_label = '<badge class="badge badge-danger bg-danger text-white"> No </badge> ';
            }

            $grn_label = '<badge class="badge badge-success bg-success text-white"> Yes </badge> ';
            if ($value['grnconfirm'] == 0) {
                $grn_label = '<badge class="badge badge-danger bg-danger text-white"> No </badge> ';
            }

            $result['data'][$key] = array(
                $cb1,
                $value['order_type'],
                $value['orderdate'],
                $value['suppliername'],
                $value['location'],
                number_format($value['subtotal'], 2, '.', ','),
                $approved_label,
                $grn_label,
                $value['remark'],
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

            $data = array(
                'confirmstatus' => 1,
                'approved_by' => $this->session->userdata('id'),
                'approved_at' => date('Y-m-d H:i:s')
            );

            $this->db->where('idtbl_porder', $cr['id']);
            $this->db->update('tbl_porder', $data);

        }

        $response['status'] = true;
        $response['msg'] = 'Successfully Updated';

        echo json_encode($response);

    }

    public function Purchaseorderdelete(){
        $id = $this->input->post('id');
        $this->db->where('idtbl_porder', $id);
        $this->db->delete('tbl_porder');
        $response['status'] = true;
        $response['msg'] = 'Successfully Deleted';
        echo json_encode($response);
    }

    public function get_order_type_select()
    {
        $term = $this->input->get('term');
        $page = $this->input->get('page');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $this->db->select('*');
        $this->db->from('tbl_order_type');
        $this->db->like('type', $term, 'both');
        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $machine_ins = $query->result_array();

        $this->db->select('*');
        $this->db->from('tbl_order_type');
        $this->db->like('type', $term, 'both');
        $count = $this->db->count_all_results();

        $data = array();
        foreach ($machine_ins as $v) {
            $data[] = array(
                'id' => $v['idtbl_order_type'],
                'text' => $v['type']
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

    public function get_locations_select()
    {
        $term = $this->input->get('term');
        $page = $this->input->get('page');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $this->db->select('*');
        $this->db->from('tbl_location');
        $this->db->like('location', $term, 'both');
        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $machine_ins = $query->result_array();

        $this->db->select('*');
        $this->db->from('tbl_location');
        $this->db->like('location', $term, 'both');
        $count = $this->db->count_all_results();

        $data = array();
        foreach ($machine_ins as $v) {
            $data[] = array(
                'id' => $v['idtbl_location'],
                'text' => $v['location']
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

    public function get_suppliers_select()
    {
        $term = $this->input->get('term');
        $page = $this->input->get('page');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $this->db->select('*');
        $this->db->from('tbl_supplier');
        $this->db->like('suppliername', $term, 'both');
        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $machine_ins = $query->result_array();

        $this->db->select('*');
        $this->db->from('tbl_supplier');
        $this->db->like('suppliername', $term, 'both');
        $count = $this->db->count_all_results();

        $data = array();
        foreach ($machine_ins as $v) {
            $data[] = array(
                'id' => $v['idtbl_supplier'],
                'text' => $v['suppliername']
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

    public function get_porder_select()
    {
        $term = $this->input->get('term');
        $page = $this->input->get('page');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $this->db->select('*');
        $this->db->from('tbl_porder');
        $this->db->like('po_no', $term, 'both');
        $this->db->where('tbl_porder.confirmstatus', '1');
        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $machine_ins = $query->result_array();

        $this->db->select('*');
        $this->db->from('tbl_porder');
        $this->db->like('po_no', $term, 'both');
        $this->db->where('tbl_porder.confirmstatus', '1');
        $count = $this->db->count_all_results();

        $data = array();
        foreach ($machine_ins as $v) {
            $data[] = array(
                'id' => $v['idtbl_porder'],
                'text' => $v['po_no']
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

    public function get_grn_types_select()
    {
        $term = $this->input->get('term');
        $page = $this->input->get('page');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $this->db->select('*');
        $this->db->from('tbl_order_type');
        $this->db->like('type', $term, 'both');
        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $machine_ins = $query->result_array();

        $this->db->select('*');
        $this->db->from('tbl_order_type');
        $this->db->like('type', $term, 'both');
        $count = $this->db->count_all_results();

        $data = array();
        foreach ($machine_ins as $v) {
            $data[] = array(
                'id' => $v['idtbl_order_type'],
                'text' => $v['type']
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

    public function get_po_spare_part_select()
    {
        $term = $this->input->get('term');
        $page = $this->input->get('page');
        $po_id = $this->input->get('po_id');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $this->db->select('spare_parts.*');
        $this->db->from('spare_parts');
        $this->db->join('tbl_porder_detail', 'tbl_porder_detail.spare_part_id = spare_parts.id', 'left');
        $this->db->like('spare_parts.name', $term, 'both');
        $this->db->where('tbl_porder_detail.tbl_porder_idtbl_porder', $po_id);
        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $machine_ins = $query->result_array();

        $this->db->select('spare_parts.*');
        $this->db->from('spare_parts');
        $this->db->join('tbl_porder_detail', 'tbl_porder_detail.spare_part_id = spare_parts.id', 'left');
        $this->db->like('spare_parts.name', $term, 'both');
        $this->db->where('tbl_porder_detail.tbl_porder_idtbl_porder', $po_id);
        $count = $this->db->count_all_results();

        $data = array();
        foreach ($machine_ins as $v) {
            $data[] = array(
                'id' => $v['id'],
                'text' => $v['name'] . ' - ' . $v['part_no']
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


}
