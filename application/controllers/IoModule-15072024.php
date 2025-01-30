<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class IoModule extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Devices';

		$this->load->model('IoModule_model');
	}
	
	public function create(){
		$viewName = 'ioModule/module_list.php';
		$this->data['opt_device_types'] = $this->IoModule_model->getDeviceTypes();
		$this->data['js'] = 'application/views/ioModule/module_list_js.php';//$viewData['opt'] = NULL;
		$this->render_template($viewName, $this->data);
	}
	
	public function operators_view(){
		$viewName = 'ioModule/operator_dashboard.php';
		$this->data['js'] = 'application/views/ioModule/operator_dashboard_js.php';
		$this->render_template($viewName, $this->data);
	}
	
	public function find(){
		$device_id = $this->input->post('mm_instref');
		$result = $this->IoModule_model->getDeviceRegData($device_id);
		$reg_data = array('inst_name'=>'', 'inst_trackaddr'=>'', 'device_type'=>'-1');
		
		if(!empty($result)){
			$reg_data['inst_name'] = $result->mach_instid;
			$reg_data['inst_trackaddr'] = $result->track_addr;
			$reg_data['device_type'] = $result->device_type;
		}
		
		echo json_encode($reg_data);
	}
	
	public function toggle(){
		$device_id = $this->input->post('mm_actsw');
		$opt_status = $this->input->post('opt_act');
		$res_info=$this->IoModule_model->regAlterDevice($device_id, $opt_status);
		
		$data['resMsg'] = $res_info['importMsg'];
		$data['resTheme'] = $res_info['toastType'];
		
		$data['msgErr'] = $res_info['msgErr'];
	}
	
	public function store(){
		$this->form_validation->set_rules('tinsttrack', 'Tracking code', 'required|callback_macaddr_check');
		$this->form_validation->set_rules('tmachref', 'Machine no.', 'required|callback_docname_check');
		$this->form_validation->set_rules('devicetype', 'Device type', 'required|callback_opt_check');
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		if($this->form_validation->run() == false) {
			$validationErrors = form_error('tinsttrack', '<div class="errormsg">', '</div>');
			
			if($validationErrors == ''){
				$validationErrors = form_error('tmachref', '<div class="errormsg">', '</div>');
			}
			
			if($validationErrors == ''){
				$validationErrors = form_error('devicetype', '<div class="errormsg">', '</div>');
			}
			
			$data = array();
			$data['resMsg'] = $validationErrors;
			$data['resTheme'] = 'bg-info text-white';
			//$this->session->set_userdata($data);
			
		}else {
			$macAddr = $this->input->post('tinsttrack');
			$deviceRegCode = $this->input->post('tmachref');
			$deviceType = $this->input->post('devicetype');
			$refId = $this->input->post('mm_mach');
			
			$deviceData = array('device_type'=>$deviceType, 'mach_instid'=>$deviceRegCode, 'track_addr'=>$macAddr);
			
			$res_info = $this->IoModule_model->regUpdateDevice($deviceData, $refId);
			
			$data = array();
			
			$data['resMsg'] = $res_info['importMsg'];
			$data['resTheme'] = $res_info['toastType'];
		}
		
		echo json_encode($data);
				
	}
	
	public function macaddr_check($field_val){
		$device_id=$this->input->post('mm_mach');//order-regno
		
		$result=$this->IoModule_model->getDeviceRegId($field_val);
		
		$duplicate_code = false;
		
		if(!empty($result)){
			$duplicate_code = ($result!=$device_id);
		}
		
		if($duplicate_code){
			$this->form_validation->set_message('macaddr_check', 'Duplicate value for the {field}');
			return false;
		}
		
		return true;
	}
	
	public function docname_check($field_val){
		$device_id=$this->input->post('mm_mach');//order-regno
		
		$result=$this->IoModule_model->getDeviceRegId($field_val);
		
		$duplicate_code = false;
		
		if(!empty($result)){
			$duplicate_code = ($result!=$device_id);
		}
		
		if($duplicate_code){
			$this->form_validation->set_message('docname_check', 'Duplicate value for the {field}');
			return false;
		}
		
		return true;
	}
	
	public function slot_check($field_val){
		$machine_alloc_id=$this->input->post('machine_alloc_id');//selected machine current allocation
		
		$result=$this->IoModule_model->getDeviceAllocation($field_val);
		
		$module_reserved = false;
		$disp_msg = '';
		
		if(!empty($result)){
			$module_reserved = true;
			if($result->row_id==$machine_alloc_id){
				$disp_msg = 'Device already registered to this machine';
			}else{
				$disp_msg = 'Device reserved for some other machine';
			}
		}
		
		if($module_reserved){
			$this->form_validation->set_message('slot_check', $disp_msg);
			return false;
		}
		
		return true;
	}
	
	public function opt_check($field_val){
		$opt_valid = true;
		
		if(!empty($field_val)){
			$opt_valid = ($field_val!='-1');
		}
		
		if(!$opt_valid){
			$this->form_validation->set_message('opt_check', 'Select the {field}');
			return false;
		}
		
		return true;
	}
	
    public function get_device_type_select(){
		$term = $this->input->get('term');
        $page = $this->input->get('page');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;
		
		$this->db->select('*');
        $this->db->from('mmachine_typeinfo');
        $this->db->like('device_type', $term, 'both');

        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $device_types = $query->result_array();

        $this->db->from('mmachine_typeinfo');
        $this->db->like('device_type', $term, 'both');
        $count = $this->db->count_all_results();

        $data = array();
        foreach ($device_types as $v) {
            $data[] = array(
                'id' => $v['id'],
                'text' => $v['device_type'],
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
	
	public function get_machines_select(){
		$term = $this->input->get('term');
        $page = $this->input->get('page');
		$slot = $this->input->get('slot_id');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;
		
		$this->db->select('machine_allocation_current.id, machine_ins.s_no');
        $this->db->from('machine_allocation_current');
		$this->db->join('machine_ins', 'machine_allocation_current.machine_in_id=machine_ins.id');
        $this->db->like('machine_ins.s_no', $term, 'both');
		$this->db->where('machine_allocation_current.slot_id', $slot);

        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $slot_machines = $query->result_array();

        $this->db->select('machine_ins.s_no');
		$this->db->from('machine_allocation_current');
		$this->db->join('machine_ins', 'machine_allocation_current.machine_in_id=machine_ins.id');
        $this->db->like('machine_ins.s_no', $term, 'both');
		$this->db->where('machine_allocation_current.slot_id', $slot);
        $count = $this->db->count_all_results();

        $data = array();
        foreach ($slot_machines as $v) {
            $data[] = array(
                'id' => $v['id'],
                'text' => $v['s_no'],
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
	
	public function get_modules_select(){
		$term = $this->input->get('term');
        $page = $this->input->get('page');
		$slot = $this->input->get('slot_id');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;
		
		$this->db->select('mmachine_instinfo.id, mmachine_instinfo.mach_instid');
        $this->db->from('mmachine_instinfo');
		$this->db->join('mmachine_instslot', 'mmachine_instinfo.id=mmachine_instslot.mmachine_instinfo_id', 'left');
        $this->db->like('mmachine_instinfo.mach_instid', $term, 'both');
		$this->db->where('(mmachine_instslot.slot_id =', $slot, FALSE);
		$this->db->or_where('ifnull(mmachine_instslot.slot_id, 0) =0)', NULL, FALSE);

        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $slot_machines = $query->result_array();

        $this->db->select('mmachine_instinfo.mach_instid');
		$this->db->from('mmachine_instinfo');
		$this->db->join('mmachine_instslot', 'mmachine_instinfo.id=mmachine_instslot.mmachine_instinfo_id', 'left');
        $this->db->like('mmachine_instinfo.mach_instid', $term, 'both');
		$this->db->where('(mmachine_instslot.slot_id =', $slot, FALSE);
		$this->db->or_where('ifnull(mmachine_instslot.slot_id, 0) =0)', NULL, FALSE);
        $count = $this->db->count_all_results();
		//echo $this->db->last_query();die;

        $data = array();
        foreach ($slot_machines as $v) {
            $data[] = array(
                'id' => $v['id'],
                'text' => $v['mach_instid'],
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
	
	public function monitor(){
		$this->load->model('Model_slots');
		$slot_id = $this->input->post('slot_id');
		$slot_info = $this->Model_slots->getSlotsData($slot_id);
		
		$slotName = $slot_info['name'];
		$devices = $this->IoModule_model->getAssignedDevices($slot_id);
		
		echo json_encode(array('slot_name'=>$slotName, 'device_data'=>$devices));
	}
	
	public function assign(){
		$this->form_validation->set_rules('inst_reg_id', 'Tracking code', 'required|callback_opt_check|callback_slot_check');
		$this->form_validation->set_rules('machine_alloc_id', 'Machine no.', 'required|callback_opt_check');
		$this->form_validation->set_rules('slot_id', 'Slot details', 'required');
		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		if($this->form_validation->run() == false) {
			$validationErrors = form_error('inst_reg_id', '<div class="errormsg">', '</div>');
			
			if($validationErrors == ''){
				$validationErrors = form_error('machine_alloc_id', '<div class="errormsg">', '</div>');
			}
			
			if($validationErrors == ''){
				$validationErrors = form_error('slot_id', '<div class="errormsg">', '</div>');
			}
			
			$data = array();
			$data['resMsg'] = $validationErrors;
			$data['resTheme'] = 'bg-info text-white';
			//$this->session->set_userdata($data);
			
		}else {
			$deviceId = $this->input->post('inst_reg_id');
			$machineAllocationId = $this->input->post('machine_alloc_id');
			$slotId = $this->input->post('slot_id');
			
			$deviceData = array('mmachine_instinfo_id'=>$deviceId, 'slot_id'=>$slotId);
			
			$res_info = $this->IoModule_model->regAllocateDevice($deviceData, $machineAllocationId);
			
			$data = array();
			
			$data['resMsg'] = $res_info['importMsg'];
			$data['resTheme'] = $res_info['toastType'];
		}
		
		echo json_encode($data);
	}
	
	public function detach(){
		$refId=$this->input->post('ref_id');
		$instId=$this->input->post('inst_id');
		
		$res_info=$this->IoModule_model->regDropDeviceAllocation($refId, $instId);
		
		$data['resMsg'] = $res_info['importMsg'];
		$data['resTheme'] = $res_info['toastType'];
		
		$data['msgErr'] = $res_info['msgErr'];
		
		
		echo json_encode($data);
		
	}
	
	
	
	//production update and tracking
	public function get_workhrs_select(){
		$term = $this->input->get('term');
        $page = $this->input->get('page');
		$factoryId = $this->input->get('factory_id');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;
		
		$this->db->select('mbranchdayplan.hour_code as id');
		$this->db->select('concat(DATE_FORMAT(mbranchdayplan.hrs_fr, "%H:%i"), "-", DATE_FORMAT(mbranchdayplan.hrs_to, "%H:%i")) as dura');
        $this->db->from('mbranchdayplan');
		$this->db->join('mbranchlist', 'mbranchdayplan.profile_id=mbranchlist.profile_id');
        //$this->db->like('machine_ins.s_no', $term, 'both');
		$this->db->where('mbranchlist.id', $factoryId);

        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $work_hrs = $query->result_array();

        $this->db->select('mbranchdayplan.hour_code as id');
		$this->db->from('mbranchdayplan');
		$this->db->join('mbranchlist', 'mbranchdayplan.profile_id=mbranchlist.profile_id');
        //$this->db->like('machine_ins.s_no', $term, 'both');
		$this->db->where('mbranchlist.id', $factoryId);
        $count = $this->db->count_all_results();

        $data = array();
        foreach ($work_hrs as $v) {
            $data[] = array(
                'id' => $v['id'],
                'text' => $v['dura'].'('.$v['id'].')',
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
	
	public function get_attached_modules_select(){
		$term = $this->input->get('term');
        $page = $this->input->get('page');
		$slot = $this->input->get('slot_id');
		$optMachine = $this->input->get('machine_in_id');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;
		
		$this->db->select('mmachine_instslot.machine_allocation_current_id as id, mmachine_instinfo.mach_instid');
        $this->db->from('mmachine_instinfo');
		$this->db->join('mmachine_instslot', 'mmachine_instinfo.id=mmachine_instslot.mmachine_instinfo_id');
		$this->db->join('machine_allocation_current', 'mmachine_instslot.machine_allocation_current_id=machine_allocation_current.id');
        $this->db->like('mmachine_instinfo.mach_instid', $term, 'both');
		$this->db->where('mmachine_instslot.slot_id =', $slot);
		$this->db->where('machine_allocation_current.machine_in_id', $optMachine);

        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $slot_machines = $query->result_array();
		//echo $this->db->last_query();die;

        $this->db->select('mmachine_instinfo.mach_instid');
		$this->db->from('mmachine_instinfo');
		$this->db->join('mmachine_instslot', 'mmachine_instinfo.id=mmachine_instslot.mmachine_instinfo_id');
		$this->db->join('machine_allocation_current', 'mmachine_instslot.machine_allocation_current_id=machine_allocation_current.id');
        $this->db->like('mmachine_instinfo.mach_instid', $term, 'both');
		$this->db->where('mmachine_instslot.slot_id =', $slot);
		$this->db->where('machine_allocation_current.machine_in_id', $optMachine);
        $count = $this->db->count_all_results();
		//echo $this->db->last_query();die;

        $data = array();
        foreach ($slot_machines as $v) {
            $data[] = array(
                'id' => $v['id'],
                'text' => $v['mach_instid'],
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
	
	public function line_wip(){
		$lineId = $this->input->post('line_regno');
		$workHourId = $this->input->post('work_hrsno');
		$sabsStyleId = $this->input->post('sabs_styleid');
		$styleItem = $this->IoModule_model->getOrderItemStyle($sabsStyleId);
		$styleId = $styleItem->mpsinfo_id;
		$wip_data = $this->IoModule_model->getHourlyLineWipBySlots($styleId, $sabsStyleId, $lineId, $workHourId);
		
		$tbl_data = array();
		$pcs_input = 0;
		
		foreach($wip_data as $w){
			$pcs_minimum = (int)($w->prod_seconds/$w->tac_time);
			$queue_diff_qty = ($pcs_input>$w->qty)?($pcs_diff_qty-$w->qty):'';
			//$pcs_input_str = ($pcs_input>0)?$pcs_input:'';
			$tbl_data[] = array('op_seqno'=>$w->sequence, 'line_name'=>$w->line_name, 
								'sabs_style_id'=>$w->sabs_style_id, 'operation_name'=>$w->operation_name, 
								'min_qty'=>$pcs_minimum, 'qty'=>$w->qty, 'queue_remain_qty'=>$queue_diff_qty, 
								'date'=>$w->date, 'time_hour'=>$w->time_hour);
			$pcs_input = $w->qty;
		}
		
		echo json_encode(array('line_wip_data'=>$tbl_data));
	}
	
	public function connect_iot(){
		if(!empty($this->input->post('key_addr'))){
			$inst_addr = $this->input->post('key_addr');
			$inst_settings = $this->IoModule_model->getDeviceSettings($inst_addr);
			echo json_encode($inst_settings);
		}else{
			echo json_encode(array('machine_inst_id'=>''));//'Device mac address not specified';
		}
	}
	
	public function save_iot(){
		if(!empty($this->input->post('key_dest'))){
			$pref_opt = $this->input->post('key_dest');
			if($pref_opt=='slot_hour_n_data'){
				$this->load->model('Model_hourly_done_rate');
				$machineInstId = $this->input->post('machine_inst_id');
				$hrsProfileId = $this->input->post('hrsprofile_id');
				$workCentre = !empty($this->input->post('work_centre'))?$this->input->post('work_centre'):'-1';
				$machineInstData = $this->IoModule_model->getWipLiveData($hrsProfileId, $workCentre, $machineInstId);
				
				$resmsg = '';
				$restype = $this->input->post('res_type');
				
				if(!empty($machineInstData)){
					$empId = $this->input->post('emp_id');
					$lineId = $this->input->post('line_id');
					$sabsStyleId = $machineInstData->sabs_styleid;//get day-plan-styleid within hrsprofile //$this->input->post('sabs_styleid');
					$operationId = $this->input->post('operation_id');
					$machineInId = $this->input->post('machine_in_id');
					$slotId = $this->input->post('slot_id');
					$instQty = $machineInstData->qty+1;//exqty+1
					$dayplanHourId = $machineInstData->hour;
					$schDate = $machineInstData->sch_date;
					
					$hourlyDoneRateId = $machineInstData->wip_id;
					$actTime = $machineInstData->act_time;
					
					if($hourlyDoneRateId==0){
						$instData = array('emp_id'=>$empId, 'line_id'=>$lineId, 'sabs_style_id'=>$sabsStyleId, 
										  'operation_id'=>$operationId, 'machine_in_id'=>$machineInId, 'slot_id'=>$slotId, 
										  'machine_allocation_current_id'=>$machineInstId, 'qty'=>$instQty, 'hour'=>$dayplanHourId,
										  'date'=>$schDate, 'created_at'=>$actTime);
						$this->Model_hourly_done_rate->create($instData);
						$resmsg = 'Hourly details added';
					}else{
						$instData = array('qty'=>$instQty, 'updated_at'=>$actTime);
						$this->Model_hourly_done_rate->update($hourlyDoneRateId, $instData);
						$resmsg = "Hourly details updated";
					}
				}else{
					$resmsg = 'Schedule has been expired';
				}
				
				if($restype==''){
					echo $resmsg;
				}else{
					echo json_encode(array('success'=>'yes', 'messages'=>$resmsg));
				}
			}else if($pref_opt=='some_other_key_str'){
				
			}
		}else{
			echo 'Route not specified';
		}
	}
	
	
}