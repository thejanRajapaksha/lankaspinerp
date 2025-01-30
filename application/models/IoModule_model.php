<?php 

class IoModule_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getOrderItemStyle($sabsStyleId){
		$this->db->distinct();
		$this->db->select('mpsinfo_id');
		$this->db->from('salesorder_info');
		$this->db->where('sabs_styleid', $sabsStyleId);
		$this->db->where('qrycancel', 0);
		$row_item = $this->db->get()->row();
		return $row_item;
	}
	
	public function getDeviceRegData($id){
		$this->db->select('device_type, mach_instid, track_addr');
		$this->db->from('mmachine_instinfo');
		$this->db->where('id', $id);
		$row_inst = $this->db->get()->row();
		return $row_inst;
	}
	
	public function getDeviceTypes(){
		$this->db->select('id as type_id, device_type');
		$this->db->from('mmachine_typeinfo');
		$row_list = $this->db->get();
		return $row_list->result();
	}
	
	public function getDeviceRegId($str){
		$this->db->select('id as device_id');
		$this->db->from('mmachine_instinfo');
		$this->db->where('mach_instid', $str);
		$this->db->or_where('track_addr', $str);
		$row_inst = $this->db->get();
		return ($row_inst->num_rows()>0)?$row_inst->row()->device_id:NULL;
	}

	public function regAlterDevice($id, $opt_data){
		$importmsg = '';
		$msgclass = "bg-info text-white";
		
		$msgerr = false;
		
		$alterData=array('isoffline'=>$opt_data);
		
		//$this->db->set('qrytime', 'NOW()', FALSE);
		
		$this->db->where('id', $id);
		$update=$this->db->update('mmachine_instinfo', $alterData);
		
		if(!($this->db->affected_rows()==1)){
			$msgErr=true;
			$importmsg="Something wrong";
		}
		
		return array('importMsg'=>$importmsg, 'msgErr'=>$msgerr, 'toastType'=>$msgclass);
	}
	
	public function regUpdateDevice($deviceData, $id){
		$importmsg = '';
		$msgclass = "bg-info text-white";
		
		if($id==''){
			$insert = $this->db->insert('mmachine_instinfo', $deviceData);
		}else{
			$this->db->where('id', $id);
			$update = $this->db->update('mmachine_instinfo', $deviceData);
		}
		
		if(!($this->db->affected_rows()==1)){
			$importmsg = 'Something wrong';
		}
		
		return array('importMsg'=>$importmsg, 'toastType'=>$msgclass);
	}
	
	
	
	
	//allocations
	public function getIoInstallations(){
		//count installed devices per each slots
		$sql = "select slot_id, count(*) as inst_cnt from ("; 
		$sql .= "select mmachine_instslot.machine_allocation_current_id, mmachine_instslot.slot_id from mmachine_instslot ";
		$sql .= "inner join machine_allocation_current ";
		$sql .= "on mmachine_instslot.machine_allocation_current_id=machine_allocation_current.id ";
		$sql .= "where mmachine_instslot.qrycancel=0";
		$sql .= ") as drv group by slot_id";
		
		$query_inst = $this->db->query($sql);
		$inst_rows = $query_inst->result();
		
		$inst_cnt_data = array();
		
		foreach($inst_rows as $r){
			$inst_cnt_data[$r->slot_id] = $r->inst_cnt;
		}
		
		return $inst_cnt_data;
	}
	
	public function getAssignedDevices($slot_id){
		//get installed machine-device for slot-id
		$sql = "select mmachine_instslot.machine_allocation_current_id as row_id, mmachine_instinfo.mach_instid as device_name, ";
		$sql .= "mmachine_instinfo.id as inst_id, ";
		$sql .= "machine_ins.s_no as machine_serialno, '-' as inst_location from mmachine_instslot ";
		$sql .= "inner join machine_allocation_current ";
		$sql .= "on mmachine_instslot.machine_allocation_current_id=machine_allocation_current.id ";
		$sql .= "inner join mmachine_instinfo on mmachine_instslot.mmachine_instinfo_id=mmachine_instinfo.id ";
		$sql .= "inner join machine_ins on machine_allocation_current.machine_in_id=machine_ins.id ";
		$sql .= "where mmachine_instslot.slot_id=? and mmachine_instslot.qrycancel=0";
		
		$query_inst = $this->db->query($sql, array($slot_id));
		$inst_rows = $query_inst->result();
		
		return $inst_rows;
	}
	
	public function getDeviceAllocation($inst_id){
		$sql = "select mmachine_instslot.machine_allocation_current_id as row_id ";
		$sql .= "from mmachine_instslot ";
		$sql .= "inner join machine_allocation_current ";
		$sql .= "on mmachine_instslot.machine_allocation_current_id=machine_allocation_current.id ";
		$sql .= "where mmachine_instslot.mmachine_instinfo_id=? and mmachine_instslot.qrycancel=0";
		
		$query_inst = $this->db->query($sql, array($inst_id));
		$inst_rows = $query_inst->row();
		
		return $inst_rows;
	}
	
	public function regAllocateDevice($deviceData, $id){
		$importmsg = '';
		$msgclass = "bg-info text-white";
		
		//start the transaction
		$this->db->trans_begin();
		$flag = true;
		
		$this->db->select('mmachine_instinfo_id, qrycancel');
		$this->db->from('mmachine_instslot');
		$this->db->where('machine_allocation_current_id', $id);
		$row_device = $this->db->get()->row();
		
		$inst_list = array(array('id'=>$deviceData['mmachine_instinfo_id'], 'mlinelist_id'=>$deviceData['slot_id']));
		
		if(empty($row_device)){
			$allocateData = array_merge($deviceData, array('machine_allocation_current_id'=>$id, 'created_by'=>$this->session->userdata('id')));
			$this->db->set('created_at', 'NOW()', FALSE);
			$insert = $this->db->insert('mmachine_instslot', $allocateData);
		}else{
			$allocateData = array_merge($deviceData, array('qrycancel'=>0, 'updated_by'=>$this->session->userdata('id')));
			$this->db->where('machine_allocation_current_id', $id);
			$this->db->set('updated_at', 'NOW()', FALSE);
			$update = $this->db->update('mmachine_instslot', $allocateData);
			
			if($row_device->qrycancel==0){
				$inst_list[] = array('id'=>$row_device->mmachine_instinfo_id, 'mlinelist_id'=>0);
			}
		}
		
		if(!($this->db->affected_rows()==1)){
			$flag = false;//$importmsg = 'Something wrong';
		}
		
		if(count($inst_list)>0){
			$this->db->update_batch('mmachine_instinfo', $inst_list, 'id');
			
			if(!($this->db->affected_rows()>0)){
				$flag = false;
			}
		}
		
		//check if transaction status TRUE or FALSE
		if(($this->db->trans_status()===FALSE)||($flag==FALSE)){
			//if something went wrong, rollback everything
			$this->db->trans_rollback();
			$importmsg = 'Transaction error';
			$msgclass = 'bg-warning text-white';
		}else{
			//if everything went right, commit the data to the database
			$this->db->trans_commit();
			$msgclass = 'bg-success text-white';
		}
		
		return array('importMsg'=>$importmsg, 'toastType'=>$msgclass);
	}
	
	public function regDropDeviceAllocation($id, $inst_id){
		$importmsg = '';
		$msgclass = "bg-info text-white";
		
		//start the transaction
		$this->db->trans_begin();
		$flag = true;
		
		$msgErr = false;
		
		$alterData=array('updated_by'=>$this->session->userdata('id'), 'qrycancel'=>1);
		
		$this->db->set('updated_at', 'NOW()', FALSE);
		$this->db->where(array('machine_allocation_current_id'=>$id, 'qrycancel'=>0));
		$update=$this->db->update('mmachine_instslot', $alterData);
		
		if(!($this->db->affected_rows()==1)){
			//$msgErr=true;
			//$importmsg="Something wrong";
			$flag = false;
		}
		
		//release device from allocated line
		$instData = array('mlinelist_id'=>0);
		$this->db->where('id', $inst_id);
		$update=$this->db->update('mmachine_instinfo', $instData);
		
		if(!($this->db->affected_rows()==1)){
			//$msgErr=true;
			$flag = false;
		}
		
		//check if transaction status TRUE or FALSE
		if(($this->db->trans_status()===FALSE)||($flag==FALSE)){
			//if something went wrong, rollback everything
			$this->db->trans_rollback();
			$importmsg = 'Transaction error';
			$msgclass = 'bg-warning text-white';
			$msgErr = true;
		}else{
			//if everything went right, commit the data to the database
			$this->db->trans_commit();
			$msgclass = 'bg-success text-white';
		}
		
		return array('importMsg'=>$importmsg, 'msgErr'=>$msgErr, 'toastType'=>$msgclass);
	}
	
	
	
	//dashbozrds
	public function getHourlyLineWipBySlots_v0($lineId, $hourId){
		/*
		$this->db->select('emp_id as name_with_initial, line_id as line_name, sabs_style_id, operation_id as operation_name');
		$this->db->select('machine_in_id as s_no, slot_id as slot_name, qty, hour as time_hour, date');
		$this->db->from('hourly_done_rate');
		$wip_rows = $this->db->get()->result();
		*/
		$sql = "select employees.name_with_initial, mlinelist.line_name, hourly_done_rate.sabs_style_id, ";
		
		//$sql .= "machine_operation_desc.operation_name, ";
		$sql .= "operation_breakdowns.name as operation_name, ";
		
		$sql .= "machine_ins.s_no, slots.name as slot_name, SUM(hourly_done_rate.qty) as qty, hourly_done_rate.date, ";
		$sql .= "concat(DATE_FORMAT(mbranchdayplan.hrs_fr, '%H:%i'), '-', DATE_FORMAT(mbranchdayplan.hrs_to, '%H:%i')) as time_hour ";
		$sql .= "from hourly_done_rate ";
		$sql .= "INNER JOIN employees ON employees.id = hourly_done_rate.emp_id ";
		$sql .= "INNER JOIN mlinelist ON mlinelist.id = hourly_done_rate.line_id ";
		
		//$sql .= "INNER JOIN machine_operation_desc ON machine_operation_desc.id = hourly_done_rate.operation_id ";
		$sql .= "INNER JOIN operation_breakdowns ON operation_breakdowns.id = hourly_done_rate.operation_id ";
		
		$sql .= "INNER JOIN machine_ins ON machine_ins.id = hourly_done_rate.machine_in_id ";
		$sql .= "INNER JOIN mbranchdayplan ON hourly_done_rate.hour=mbranchdayplan.hour_code ";
		$sql .= "INNER JOIN slots ON hourly_done_rate.slot_id=slots.id ";
		$sql .= "WHERE hourly_done_rate.is_deleted = 0 ";
		$sql .= "and hourly_done_rate.line_id=? and hourly_done_rate.hour=? and hourly_done_rate.date=DATE(NOW()) ";
		$sql .= "group by hourly_done_rate.slot_id ";
		$sql .= "order by hourly_done_rate.slot_id";
		
		$wip_query = $this->db->query($sql, array($lineId, $hourId));
		
		return $wip_query->result();
	}
	
	public function getHourlyLineWipBySlots($styleId, $sabsStyleId, $lineId, $hourId){
		//$styleId = 1;
		
		$sql = "select operation_breakdowns.sequence, mlinelist.line_name, hourly_done_rate.sabs_style_id, ";
		
		$sql .= "operation_breakdowns.name as operation_name, operation_breakdowns.tac_time, ";
		$sql .= "TIME_TO_SEC(TIMEDIFF(TIME(NOW()), mbranchdayplan.hrs_fr)) as prod_seconds, ";
		
		$sql .= "IFNULL(SUM(hourly_done_rate.qty), 0) as qty, hourly_done_rate.date, ";
		$sql .= "concat(DATE_FORMAT(mbranchdayplan.hrs_fr, '%H:%i'), '-', DATE_FORMAT(mbranchdayplan.hrs_to, '%H:%i')) as time_hour ";
		$sql .= "from (select id, name, tac_time, sequence from operation_breakdowns where style_id=? AND is_deleted=0) AS operation_breakdowns ";
		
		$sql .= "LEFT OUTER JOIN (select sabs_style_id, operation_id, emp_id, line_id, hour, slot_id, qty, date from hourly_done_rate ";
		$sql .= "WHERE hourly_done_rate.sabs_style_id=? AND hourly_done_rate.is_deleted = 0 ";
		$sql .= "and hourly_done_rate.line_id=? and hourly_done_rate.hour=? and hourly_done_rate.date=DATE(NOW())";
		$sql .= ") AS hourly_done_rate ON operation_breakdowns.id = hourly_done_rate.operation_id ";
		
		$sql .= "LEFT OUTER JOIN mlinelist ON mlinelist.id = hourly_done_rate.line_id ";
		
		$sql .= "LEFT OUTER JOIN mbranchdayplan ON hourly_done_rate.hour=mbranchdayplan.hour_code ";
		
		$sql .= "group by operation_breakdowns.id ";
		$sql .= "order by operation_breakdowns.sequence";
		
		$wip_query = $this->db->query($sql, array($styleId, $sabsStyleId, $lineId, $hourId));
		
		return $wip_query->result();
	}
	
	public function getDeviceSettings($mac_addr){
		$sql = "SELECT drv_inst.machine_inst_id, drv_inst.machine_in_id, operation_breakdown_allocations.operation_breakdown_id as operation_id, ";
		$sql .= "slots.id as slot_id, mlinelist.id as line_id, mlinelist.line_code as workcentre_code, mbranchlist.profile_id as hrsprofile_id, employee_allocation_current.employee_id ";
		$sql .= "FROM (select mmachine_instslot.machine_allocation_current_id as machine_inst_id, mmachine_instslot.mmachine_instinfo_id, machine_allocation_current.machine_in_id, ";
		$sql .= "machine_allocation_current.slot_id from mmachine_instslot inner join machine_allocation_current on ";
		$sql .= "mmachine_instslot.machine_allocation_current_id=machine_allocation_current.id inner join mmachine_instinfo on ";
		$sql .= "mmachine_instslot.mmachine_instinfo_id=mmachine_instinfo.id ";
		$sql .= "where mmachine_instinfo.track_addr=? AND mmachine_instslot.qrycancel=0) as drv_inst ";
		$sql .= "inner join slots on drv_inst.slot_id=slots.id ";
		$sql .= "inner join employee_allocation_current on slots.id=employee_allocation_current.slot_id ";
		$sql .= "inner join operation_breakdown_allocations on slots.id=operation_breakdown_allocations.slot_id ";
		$sql .= "inner join mlinelist on slots.line=mlinelist.id inner join mbranchlist on mlinelist.mbranchlist_id=mbranchlist.id ";
		$sql .= "where slots.active=1 and operation_breakdown_allocations.is_deleted=0";
		
		$settings_query = $this->db->query($sql, array($mac_addr));
		
		return $settings_query->row();
	}
	
	public function getWipLiveData($hrs_profile_id, $work_centre, $inst_id){
		$sql = "select ifnull(drv_wip.id, 0) AS wip_id, ifnull(drv_wip.date, DATE(NOW())) as sch_date, ifnull(drv_hrs.hour_code, drv_wip.hour) as hour, drv_wp.sabs_styleid as sabs_styleid, ifnull(drv_wip.qty, 0) as qty, NOW() as act_time from (select hour_code, hrs_fr, hrs_to, profile_id from mbranchdayplan where profile_id=? AND (TIME(NOW()) BETWEEN hrs_fr AND hrs_to)) as drv_hrs ";
		$sql .= "INNER JOIN (select profile_id, sabs_styleid from dworkplan where workcentre=? AND (NOW() BETWEEN planfrom AND planto)) AS drv_wp ON drv_hrs.profile_id=drv_wp.profile_id ";
		/*
		$sql .= "left outer join (select id, COUNT(*) as wip_cnt, date, hour, qty from hourly_done_rate where machine_allocation_current_id=? and date=DATE(NOW()) and is_deleted=0) as drv_wip on drv_hrs.hour_code=drv_wip.hour ";
		*/
		$sql .= "left outer join (select id, 1 as wip_cnt, date, hour, qty from hourly_done_rate where machine_allocation_current_id=? and date=DATE(NOW()) and is_deleted=0 group by hour) as drv_wip on drv_hrs.hour_code=drv_wip.hour ";
		
		$wip_live_query = $this->db->query($sql, array($hrs_profile_id, $work_centre, $inst_id));
		
		return $wip_live_query->row();
	}
	
}