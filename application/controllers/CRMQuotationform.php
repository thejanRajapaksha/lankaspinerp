<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class CRMQuotationform extends Admin_Controller
{	
	public function Getquotation($z,$y)
	{
		$this->load->model('Commeninfo');
		$this->load->model('CRMQuotationforminfo');

		$result['product'] = $this->CRMQuotationforminfo->Getproduct($z,$y);
		$result['customerlist'] = $this->CRMQuotationforminfo->Getcustomer($z,$y);	
		$result['getid'] = $this->CRMQuotationforminfo->Getquotationid($z,$y);
		$this->data['result'] = $result;
		$this->data['js'] = 'application/views/CRM/CRMQuotationform/index-js.php';
		$this->render_template('CRM/CRMQuotationform/index', $this->data);
	}
	
	public function Quotationforminsertupdate()
	{	
		$this->load->model('CRMQuotationforminfo');
		$result=$this->CRMQuotationforminfo->Quotationforminsertupdate();	
	}

	public function Quotationformgetcustomer()
	{		
		$this->load->model('CRMQuotationforminfo');
		$result=$this->CRMQuotationforminfo->Quotationformgetcustomer();		
	}

	public function Quotationformmeterial()
	{		
		$this->load->model('CRMQuotationforminfo');
		$result=$this->CRMQuotationforminfo->Quotationformmeterial();
		echo $result;		
	}

	public function Quotationformunitprice()
	{		
		$this->load->model('CRMQuotationforminfo');
		$result=$this->CRMQuotationforminfo->Quotationformunitprice();		
	}
	
	public function Quotationformgetinfodata()
	{		
		$this->load->model('CRMQuotationforminfo');
		$result=$this->CRMQuotationforminfo->Quotationformgetinfodata();
		//  $result['Reasontype']=$this->Inquiryinfo->Getreasontype();
		 echo $result;
	}

	public function Getreasontype()
	{		
		$this->load->model('CRMQuotationforminfo');
		$this->CRMQuotationforminfo->Getreasontype();
	}

	public function Quotationformpdf($x)
	{		
		$this->load->model('CRMQuotationforminfo');
		$result=$this->CRMQuotationforminfo->Quotationformpdf($x);
	}

	public function Quotationformstatus()
	{
		$this->load->model('CRMQuotationforminfo');
		$result = $this->CRMQuotationforminfo->Quotationformstatus();
	}

	public function Quotationformapprovestatus()
	{
		$this->load->model('CRMQuotationforminfo');
		$result = $this->CRMQuotationforminfo->Quotationformapprovestatus();
	}

	public function Quotationformedit()
	{
		$this->load->model('CRMQuotationforminfo');
		$result = $this->CRMQuotationforminfo->Quotationformedit();
	}

	public function Getproductlistimages()
	{
		$this->load->model('CRMQuotationforminfo');
		$result = $this->CRMQuotationforminfo->Getproductlistimages();
		echo $result;
	}

	public function Getproductlistimagesdelete()
	{
		$this->load->model('CRMQuotationforminfo');
		$result = $this->CRMQuotationforminfo->Getproductlistimagesdelete();
		//echo $result;
	}
	
	public function Quotationdetailsedit()
	{
		$this->load->model('CRMQuotationforminfo');
		$result = $this->CRMQuotationforminfo->Quotationdetailsedit();
	}
	
	public function QuotationformDetailsstatus($x, $y)
	{
		$this->load->model('CRMQuotationforminfo');
		$result = $this->CRMQuotationforminfo->QuotationformDetailsstatus($x, $y);
	}
}
