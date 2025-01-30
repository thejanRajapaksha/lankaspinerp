<?php
//require APPPATH . 'libraries/REST_Controller.php';

class V1 extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('model_factories');
        $this->load->model('model_departments');
        $this->load->model('model_auth');

    }

    public function get_factory_list(){
        $data = $this->model_factories->getFactoriesData();

        echo json_encode($data);
    }

    public function get_department_list(){
        $factory_id = $this->input->post('factory_id');

        if($factory_id == ''){
            echo json_encode(
                array(
                    'Success' => False,
                    'Message' => 'factory_id Required'
                )
            );
            die();
        }

        $this->db->select('departments.*');
        $this->db->from('departments');
        $this->db->join('mbranchlist', 'mbranchlist.id = departments.factory_id', 'left');
        $this->db->where('departments.active', 1 );
        if($factory_id) {
            $this->db->where('mbranchlist.id', $factory_id);
        }
        $query = $this->db->get();
        $departments = $query->result_array();

        echo json_encode($departments);
    }

    public function get_section_list(){
        $department_id = $this->input->post('department_id');

        if($department_id == ''){
            echo json_encode(
                array(
                    'Success' => False,
                    'Message' => 'department_id Required'
                )
            );
            die();
        }

        $this->db->select('sections.*');
        $this->db->from('sections');
        $this->db->join('departments', 'departments.id = sections.department', 'left');
        $this->db->join('mbranchlist', 'mbranchlist.id = departments.factory_id', 'left');
        $this->db->where('sections.active', 1 );
        if($department_id) {
            $this->db->where('sections.department', $department_id);
        }

        $query = $this->db->get();
        $departments = $query->result_array();

        echo json_encode($departments);
    }

    public function get_line_list(){
        $factory_id = $this->input->post('factory_id');

        if($factory_id == ''){
            echo json_encode(
                array(
                    'Success' => False,
                    'Message' => 'factory_id Required'
                )
            );
            die();
        }

        $this->db->select('mlinelist.*, sections.name as section_name, departments.name as department_name, mbranchlist.br_name as factory_name, mbranchlist.id as factory_id ');
        $this->db->from('mlinelist');
        $this->db->join('sections', 'sections.id = mlinelist.section', 'left');
        $this->db->join('departments', 'departments.id = sections.department', 'left');
        $this->db->join('mbranchlist', 'mbranchlist.id = departments.factory_id', 'left');
        $this->db->where('mlinelist.active', 1 );
        if($factory_id) {
            $this->db->where('departments.factory_id', $factory_id);
        }
        $query = $this->db->get();
        $sections = $query->result_array();

        echo json_encode($sections);
    }

    public function get_ws_list(){
        $line_id = $this->input->post('line_id');
        $date = $this->input->post('date');

        if($line_id == ''){
            echo json_encode(
                array(
                    'Success' => False,
                    'Message' => 'line_id Required'
                )
            );
            die();
        }

        if($date == ''){
            echo json_encode(
                array(
                    'Success' => False,
                    'Message' => 'Date is required'
                )
            );
            die();
        }

        //get workstations
        $sql1 = "SELECT law.*,
                        e.name_with_initial,
                        la.sabs_styleid
                    FROM line_allocation_workstations law 
                    LEFT JOIN line_allocations la ON la.id = law.line_allocation_id
                    LEFT JOIN employees e ON e.id = law.emp_id
                    WHERE la.line_id = '$line_id'  
                    AND la.date = '$date'
                    AND law.is_deleted = 0
                    ORDER BY ws
                ";
        $query1 = $this->db->query($sql1);
        $result = $query1->result_array();

        $ws_data = array();

        //get operations
        foreach ($result as $res){
            $law_id = $res['id'];
            $sql2 = "SELECT lawo.*,
                                mod1.smv, mod1.operation_name, mod1.value_id, 
                             mt.name as machine_type_name, c.name as criticality_name 
                    FROM line_allocation_workstation_operations lawo 
                    LEFT JOIN machine_operation_desc mod1 ON mod1.id = lawo.operation_id
                    LEFT JOIN machine_types mt ON mod1.machine_type_id = mt.id 
                    LEFT JOIN criticalities c ON c.id = mod1.criticality_id
                    WHERE law_id = '$law_id'  
                    AND lawo.is_deleted = 0
                    ";
            $query2 = $this->db->query($sql2);
            $result2 = $query2->result_array();
            //above is a multi data
            $op_data = array();
            foreach ($result2 as $res2){
                $lawo_id = $res2['id'];
                $operation_id = $res2['operation_id'];
                $operation_name = $res2['operation_name'];
                $criticality_name = $res2['criticality_name'];
                $machine_type_name = $res2['machine_type_name'];
                $smv = $res2['smv'];
                $op_sub_data = array(
                    'lawo_id' => $lawo_id,
                    'operation_id' => $operation_id,
                    'operation_name' => $operation_name,
                    'criticality_name' => $criticality_name,
                    'machine_type_name' => $machine_type_name,
                    'smv' => $smv,
                );

                array_push($op_data, $op_sub_data);

            }

            $ws = $res['ws'];
            $idle_min = $res['idle_min'];
            $remarks = $res['remarks'];
            $emp_id = $res['emp_id'];
            $emp_name = $res['name_with_initial'];
            $total_smv = $res['total_smv'];
            $total_thour = $res['total_thour'];
            $sabs_styleid = $res['sabs_styleid'];

            $s1_data = array(
                'workstation_id' => $law_id,
                'ws' => $ws,
                'idle_min' => $idle_min,
                'remarks' => $remarks,
                'emp_id' => $emp_id,
                'emp_name' => $emp_name,
                'total_smv' => $total_smv,
                'total_thour' => $total_thour,
                'sabs_styleid' => $sabs_styleid,
                'op_data' => $op_data,
            );
            array_push($ws_data, $s1_data);

        }

        $la_full = array(
            'date' => $date,
            'workstations' => $ws_data,
        );

        if(empty($la_full)){
            echo json_encode(
                array(
                    'Success' => False,
                    'Message' => 'No Data Found'
                )
            );
            die();
        }else{
            echo json_encode($la_full);
        }

    }

    public function get_emp_ws_list(){
        $emp_id = $this->input->post('emp_id');
        $date = $this->input->post('date');

        if($emp_id == ''){
            echo json_encode(
                array(
                    'Success' => False,
                    'Message' => 'emp_id Required'
                )
            );
            die();
        }

        if($date == ''){
            echo json_encode(
                array(
                    'Success' => False,
                    'Message' => 'Date is required'
                )
            );
            die();
        }

        //get workstations
        $sql1 = "SELECT law.*,
                        e.name_with_initial,
                        la.sabs_styleid
                    FROM line_allocation_workstations law 
                    LEFT JOIN line_allocations la ON la.id = law.line_allocation_id
                    LEFT JOIN employees e ON e.id = law.emp_id
                    WHERE law.emp_id = '$emp_id'  
                    AND la.date = '$date'
                    AND law.is_deleted = 0
                    ORDER BY ws
                ";
        $query1 = $this->db->query($sql1);
        $result = $query1->result_array();

        $ws_data = array();

        //get operations
        foreach ($result as $res){
            $law_id = $res['id'];
            $sql2 = "SELECT lawo.*,
                                mod1.smv, mod1.operation_name, mod1.value_id, 
                             mt.name as machine_type_name, c.name as criticality_name 
                    FROM line_allocation_workstation_operations lawo 
                    LEFT JOIN machine_operation_desc mod1 ON mod1.id = lawo.operation_id
                    LEFT JOIN machine_types mt ON mod1.machine_type_id = mt.id 
                    LEFT JOIN criticalities c ON c.id = mod1.criticality_id
                    WHERE law_id = '$law_id'  
                    AND lawo.is_deleted = 0
                    ";
            $query2 = $this->db->query($sql2);
            $result2 = $query2->result_array();
            //above is a multi data
            $op_data = array();
            foreach ($result2 as $res2){
                $lawo_id = $res2['id'];
                $operation_id = $res2['operation_id'];
                $operation_name = $res2['operation_name'];
                $criticality_name = $res2['criticality_name'];
                $machine_type_name = $res2['machine_type_name'];
                $smv = $res2['smv'];
                $op_sub_data = array(
                    'lawo_id' => $lawo_id,
                    'operation_id' => $operation_id,
                    'operation_name' => $operation_name,
                    'criticality_name' => $criticality_name,
                    'machine_type_name' => $machine_type_name,
                    'smv' => $smv,
                );

                array_push($op_data, $op_sub_data);

            }

            $ws = $res['ws'];
            $idle_min = $res['idle_min'];
            $remarks = $res['remarks'];
            $emp_id = $res['emp_id'];
            $emp_name = $res['name_with_initial'];
            $total_smv = $res['total_smv'];
            $total_thour = $res['total_thour'];
            $sabs_styleid = $res['sabs_styleid'];

            $s1_data = array(
                'workstation_id' => $law_id,
                'ws' => $ws,
                'idle_min' => $idle_min,
                'remarks' => $remarks,
                'emp_id' => $emp_id,
                'emp_name' => $emp_name,
                'total_smv' => $total_smv,
                'total_thour' => $total_thour,
                'sabs_styleid' => $sabs_styleid,
                'op_data' => $op_data
            );
            array_push($ws_data, $s1_data);

        }

        $la_full = array(
            'date' => $date,
            'workstations' => $ws_data,
        );

        if(empty($la_full)){
            echo json_encode(
                array(
                    'Success' => False,
                    'Message' => 'No Data Found'
                )
            );
            die();
        }else{
            echo json_encode($la_full);
        }

    }

    public function login(){
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        if($email == '' || $password == '' ){
            echo json_encode(
                array(
                    'Success' => False,
                    'Message' => 'email & password Required'
                )
            );
            die();
        }

        $login = $this->model_auth->login($this->input->post('email'), $this->input->post('password'));

        if($login) {
            $logged_in_sess = array(
                'id' => $login['id'],
                'username'  => $login['username'],
                'email'     => $login['email'],
                'factory_id'     => $login['factory_id'],
                'factory_name'     => $login['factory_name'],
                'logged_in' => TRUE,
            );

            $this->session->set_userdata($logged_in_sess);

            echo json_encode($logged_in_sess);

        }else {

            $data = array(
              'status' => false,
              'message' => 'Login Failed'
            );
            echo json_encode($data);
        }

    }

    public function scan_barcode(){
        $barcode = $this->input->post('barcode');
        $date = $this->input->post('date');

        if($barcode == '' || $date == '' ){
            echo json_encode(
                array(
                    'Success' => False,
                    'Message' => 'barcode, date Required'
                )
            );
            die();
        }

        //get workstations
        $sql1 = "SELECT 
                        la.line_id, 
                        l.line_name,
                        l.line_code, 
                        law.ws, 
                        law.idle_min, 
                        law.emp_id, 
                        law.total_smv, 
                        law.total_thour,  
                        mi.bar_code,
                        e.name_with_initial, 
                        law.machine_in_id,
                        law.operation_id,
                        mod1.operation_name,
                        la.sabs_styleid
                    FROM line_allocation_workstations law 
                    LEFT JOIN line_allocations la ON la.id = law.line_allocation_id     
                    LEFT JOIN machine_operation_desc mod1 ON mod1.id = law.operation_id 
                    LEFT JOIN employees e ON e.id = law.emp_id
                    LEFT JOIN machine_ins mi ON mi.id = law.machine_in_id
                    LEFT JOIN mlinelist l ON l.id = la.line_id 
                    WHERE mi.bar_code = '$barcode'  
                    AND la.date = '$date'
                    AND law.is_deleted = 0
                    ORDER BY ws
                ";
        $query1 = $this->db->query($sql1);
        $result = $query1->result_array();

        echo json_encode($result);
    }

    public function get_fail_reasons_list(){

        //get fail reasons
        $sql1 = "SELECT dt.*
                    FROM defect_type dt  
                ";
        $query1 = $this->db->query($sql1);
        $result1 = $query1->result_array();

        $ws_data = array();

        foreach ($result1 as $res){
            $defect_id = $res['id'];
            $defect_type_name = $res['defect_type_name'];

            $sql2 = "SELECT qi.issue_id, issues 
                    FROM quality_issue qi 
                    WHERE defect_type_id
                ";
            $query2 = $this->db->query($sql2);
            $result2 = $query2->result_array();

            $sub = array(
                'defect_id' => $defect_id,
                'defect_type_name' => $defect_type_name,
                'issues' => $result2
            );

            array_push($ws_data, $sub);

        }

        echo json_encode($ws_data);
    }

    public function save_fail_data_arr(){

        $data = $this->input->post('data');
        $batch_no = abs( crc32( uniqid() ) );

        for ($i = 0; $i < count($data); $i++) {

            $sub = array(
                'machine_in_id' => $data[$i]['machine_in_id'],
                'batch_no' => $batch_no,
                'line_id' => $data[$i]['line_id'],
                'emp_id' => $data[$i]['emp_id'],
                'ws' => $data[$i]['ws'],
                'date' => $data[$i]['date'],
                'selected_qty' => $data[$i]['selected_qty'],
                'fail_qty' => $data[$i]['fail_qty'],
                'pass_qty' => $data[$i]['pass_qty']
            );
            $this->db->insert('tls_pass_qty',$sub);
            $sp_id = $this->db->insert_id();

            $issues = $data[$i]['issues'];

            $sub2 = array();
            for ($j = 0; $j < count($issues); $j++) {

                $sub2[] = array(
                    'pass_qty_id' => $sp_id,
                    'issue_id' => $issues[$j]
                );
            }

            $sps_create = $this->db->insert_batch('tls_pass_qty_reasons', $sub2);

        }

        $data = array(
            'success' => true,
            'message' => 'Data Create Success'
        );

        echo json_encode($data);

    }

    public function save_fail_data(){

        $machine_in_id = $this->input->post('machine_in_id');
        $line_id = $this->input->post('line_id');
        $emp_id = $this->input->post('emp_id');
        $ws = $this->input->post('ws');
        $date = $this->input->post('date');
        $selected_qty = $this->input->post('selected_qty');
        $fail_qty = $this->input->post('fail_qty');
        $pass_qty = $this->input->post('pass_qty');
        $time_slot = $this->input->post('time_slot');

        $issues = $this->input->post('issues');

        $stream_clean = $this->security->xss_clean($this->input->raw_input_stream);


        $dec = (Array)json_decode($stream_clean);

        $data = array(
            'machine_in_id' => $dec["machine_in_id"],
            'line_id' => $dec["line_id"],
            'emp_id' => $dec["emp_id"],
            'ws' => $dec["ws"],
            'date' => $dec["date"],
            'selected_qty' => $dec["selected_qty"],
            'fail_qty' => $dec["fail_qty"],
            'pass_qty' => $dec["pass_qty"],
            'time_slot' => $dec["time_slot"],
        );


        $check_data = $this->db->get_where('tls_pass_qty', array('machine_in_id' => $dec["machine_in_id"], 'date' => $dec["date"]));

        if ($check_data->num_rows() == 0) {

            //check if emp_id already exists for date
            $check_emp = $this->db->get_where('tls_pass_qty', array('emp_id' => $dec["emp_id"], 'date' => $dec["date"]));

            if ($check_emp->num_rows() == 0) {

                $this->db->insert('tls_pass_qty',$data);

                //get insert id
                $sp_id = $this->db->insert_id();

                $issues = $dec["issues"];

                $data = array();
                for ($i = 0; $i < count($issues); $i++) {

                    $data[] = array(
                        'pass_qty_id' => $sp_id,
                        'issue_id' => $issues[$i]
                    );
                }

                $sps_create = $this->db->insert_batch('tls_pass_qty_reasons', $data);

                $data = array(
                    'success' => true,
                    'message' => 'Data Create Success'
                );
                echo json_encode($data);

            }else{
                // return success false
                $data = array(
                    'success' => false,
                    'message' => 'emp_id already exists'
                );
                echo json_encode($data);

            }

        }else{
            // return success false
            $data = array(
                'success' => false,
                'message' => 'Data already exists for machine_in_id and date '
            );
            echo json_encode($data);

        }


    }

    public function get_fail_data(){
        $line_id = $this->input->post('line_id');
        $date = $this->input->post('date');

        if($date == '' || $line_id == '' ){
            echo json_encode(
                array(
                    'Success' => False,
                    'Message' => 'line_id, date Required'
                )
            );
            die();
        }

        $sql2 = "
            SELECT pq.*, e.name_with_initial
            FROM tls_pass_qty pq  
            LEFT JOIN employees e ON e.id = pq.emp_id
            WHERE line_id = '$line_id' 
              AND pq.date = '$date' 
        ";

        $query2 = $this->db->query($sql2);
        $result2 = $query2->result_array();

        $main_data = array();

        foreach ($result2 as $res){
            $id = $res['id'];
            $machine_in_id = $res['machine_in_id'];
            $ws = $res['ws'];
            $line_id = $res['line_id'];
            $emp_id = $res['emp_id'];
            $name_with_initial = $res['name_with_initial'];
            $date = $res['date'];
            $selected_qty = $res['selected_qty'];
            $fail_qty = $res['fail_qty'];
            $pass_qty = $res['pass_qty'];

            $sql3 = "
            SELECT pq.*, qi.issues
            FROM tls_pass_qty_reasons pq  
            LEFT JOIN quality_issue qi on pq.issue_id = qi.issue_id 
            WHERE pass_qty_id = '$id'  
            ";

            $query3 = $this->db->query($sql3);
            $result3 = $query3->result_array();

            $sub = array(
                'id' => $id,
                'machine_in_id' => $machine_in_id,
                'ws' => $ws,
                'line_id' => $line_id,
                'emp_id' => $emp_id,
                'emp_name' => $name_with_initial,
                'date' => $date,
                'selected_qty' => $selected_qty,
                'fail_qty' => $fail_qty,
                'pass_qty' => $pass_qty,
                'issues' => $result3
            );

            array_push($main_data, $sub);

        }

        echo json_encode($main_data);
    }


    public function save_actual_cycle_time(){
        $barcode = $this->input->post('barcode');
        $time = $this->input->post('time');
        $date = $this->input->post('date');

        if(
            $barcode == ''
            || $time == ''
            || $date == ''
        ){
            echo json_encode(
                array(
                    'Success' => False,
                    'Message' => 'barcode, time, date  Required'
                )
            );
            die();
        }

        $sql1 = "SELECT mi.* 
                    FROM machine_ins mi  
                    WHERE mi.bar_code = '$barcode'  
                ";
        $query1 = $this->db->query($sql1);
        $result = $query1->row_array();

        $machine_in_id = $result['id'];

        $data = array(
            'machine_in_id' => $machine_in_id,
            'time' => $time,
            'date' => $date
        );

        $this->db->insert('actual_cycle_time',$data);

        $data = array(
            'success' => true,
            'message' => 'Data Create Success'
        );

        echo json_encode($data);

    }

    public function get_actual_cycle_time(){
        $barcode = $this->input->post('barcode');
        $date = $this->input->post('date');

        if($date == '' || $barcode == '' ){
            echo json_encode(
                array(
                    'Success' => False,
                    'Message' => 'barcode, date Required'
                )
            );
            die();
        }

        $sql1 = "SELECT mi.* 
                    FROM machine_ins mi  
                    WHERE mi.bar_code = '$barcode'  
                ";
        $query1 = $this->db->query($sql1);
        $result = $query1->row_array();

        $machine_in_id = $result['id'];

        $sql2 = "
            SELECT act.time, act.date, la.sabs_styleid, law.emp_id, e.name_with_initial, law.operation_id, mod1.operation_name
            FROM actual_cycle_time act 
            LEFT JOIN line_allocation_workstations law ON law.machine_in_id = act.machine_in_id  
            LEFT JOIN line_allocations la ON la.id = law.line_allocation_id
            LEFT JOIN employees e ON e.id = law.emp_id
            LEFT JOIN machine_operation_desc mod1 ON mod1.id = law.operation_id
            WHERE act.date = '$date' 
              AND act.machine_in_id = '$machine_in_id' 
        ";

        $query2 = $this->db->query($sql2);
        $result2 = $query2->result_array();

        echo json_encode($result2);
    }

    public function get_fail_data_count(){
        $line_id = $this->input->post('line_id');
        $date = $this->input->post('date');

        if($date == '' || $line_id == '' ){
            echo json_encode(
                array(
                    'Success' => False,
                    'Message' => 'line_id, date Required'
                )
            );
            die();
        }

        $sql2 = "
            SELECT pq.*, e.name_with_initial 
            FROM tls_pass_qty pq  
            LEFT JOIN employees e ON e.id = pq.emp_id
            WHERE line_id = '$line_id' 
              AND pq.date = '$date'  
            GROUP BY pq.time_slot
        ";

        $query2 = $this->db->query($sql2);
        $result2 = $query2->result_array();

        $main_data = array();

        $i = 1;
        foreach ($result2 as $res){
            $time_slot = $res['time_slot'];
            //get data according to batch_no
            $sql4 = "
            SELECT pq.*, e.name_with_initial 
            FROM tls_pass_qty pq  
            LEFT JOIN employees e ON e.id = pq.emp_id
            WHERE line_id = '$line_id' 
              AND pq.date = '$date'   
              AND pq.time_slot = '$time_slot'  
            ";
            $query4 = $this->db->query($sql4);
            $result4 = $query4->result_array();

            $machine_details = array();
            foreach ($result4 as $res4){
                $id = $res4['id'];
                $sql3 = "
                SELECT pq.*, qi.issues
                FROM tls_pass_qty_reasons pq  
                LEFT JOIN quality_issue qi on pq.issue_id = qi.issue_id 
                WHERE pass_qty_id = '$id'  
                ";

                $query3 = $this->db->query($sql3);
                $result3 = $query3->result_array();

                $sub_4 = array(
                    'machine_in_id' => $res4['machine_in_id'],
                    'fail_qty' => $res4['fail_qty'],
                    'pass_qty' => $res4['pass_qty'],
                    'selected_qty' => $res4['selected_qty'],
                    'issues' => $result3,
                );
                array_push($machine_details, $sub_4);

            }

            $sub = array(
                'attempt_count' => $i,
                'time_slot' => $time_slot,
                'machine_details' => $machine_details,
            );

            array_push($main_data, $sub);

            $i++;

        }

        echo json_encode($main_data);
    }

    public function get_fail_data_view_more(){
        $machine_in_id = $this->input->post('machine_in_id');
        $date = $this->input->post('date');
        $time_slot = $this->input->post('time_slot');

        if(
            $date == '' ||
            $machine_in_id == '' ||
            $time_slot == ''
        ){
            echo json_encode(
                array(
                    'Success' => False,
                    'Message' => 'machine_in_id, date, time_slot Required'
                )
            );
            die();
        }

        $sql2 = "
            SELECT act.time,
                   act.date,
                   la.sabs_styleid,
                   tpq.emp_id,
                   e.name_with_initial,
                   law.operation_id,
                   mod1.operation_name,
                   tpq.machine_in_id,
                   mi.bar_code,
                    la.line_id,
                   l.line_name,
                   mod1.smv 
            FROM tls_pass_qty tpq   
            LEFT JOIN machine_ins mi ON mi.id = tpq.machine_in_id
            LEFT JOIN employees e ON e.id = tpq.emp_id
             LEFT JOIN actual_cycle_time act ON act.machine_in_id = tpq.machine_in_id
            LEFT JOIN line_allocation_workstations law ON law.machine_in_id = tpq.machine_in_id
            LEFT JOIN line_allocations la ON la.id = law.line_allocation_id 
            LEFT JOIN machine_operation_desc mod1 ON mod1.id = law.operation_id
            LEFT JOIN mlinelist l ON la.line_id = l.id 
            WHERE tpq.date = '$date' 
            AND tpq.time_slot = '$time_slot'
            AND tpq.machine_in_id = '$machine_in_id'
            ORDER BY tpq.id DESC
        ";

        $query2 = $this->db->query($sql2);
        $result2 = $query2->row_array();

        echo json_encode($result2);

    }

    public function save_hourly_done_rate(){
        $emp_id = $this->input->post('emp_id');
        $line_id = $this->input->post('line_id');
        $sabs_style_id = $this->input->post('sabs_style_id');
        $operation_id = $this->input->post('operation_id');
        $machine_in_id = $this->input->post('machine_in_id');
        $qty = $this->input->post('qty');
        $hour = $this->input->post('hour');
        $date = $this->input->post('date');

        if(
            $emp_id == ''
            || $line_id == ''
            || $sabs_style_id == ''
            || $operation_id == ''
            || $machine_in_id == ''
            || $qty == ''
            || $hour == ''
            || $date == ''
        ){
            echo json_encode(
                array(
                    'Success' => False,
                    'Message' => ' emp_id, line_id, sabs_style_id, operation_id, machine_in_id, qty, hour, date Required'
                )
            );
            die();
        }

        //check if data exists for date and hour in hourly_done_rate table
        $check_data = $this->db->get_where('hourly_done_rate', array('hour' => $hour, 'date' => $date, 'is_deleted' => 0 ));
        if ($check_data->num_rows() != 0) {
            echo json_encode(
                array(
                    'Success' => False,
                    'Message' => ' Data already exists for date and hour'
                )
            );
            die();
        }


        $data = array(
            'emp_id' => $emp_id,
            'line_id' => $line_id,
            'sabs_style_id' => $sabs_style_id,
            'operation_id' => $operation_id,
            'machine_in_id' => $machine_in_id,
            'qty' => $qty,
            'hour' => $hour,
            'date' => $date
        );

        $this->db->insert('hourly_done_rate',$data);

        $data = array(
            'success' => true,
            'message' => 'Data Create Success'
        );

        echo json_encode($data);

    }

    public function get_hourly_done_rate(){

        $emp_id = $this->input->post('emp_id');
        $date = $this->input->post('date');
        $hour = $this->input->post('hour');

        if(
            $date == '' ||
            $emp_id == '' ||
            $hour == ''
        ){
            echo json_encode(
                array(
                    'Success' => False,
                    'Message' => 'emp_id, date, hour Required'
                )
            );
            die();
        }

        $sql = "SELECT * FROM hourly_done_rate 
            WHERE emp_id = '$emp_id'
            AND date = '$date'
            AND hour = '$hour'
            AND is_deleted = 0
            ORDER BY id DESC 
        ";

        $query2 = $this->db->query($sql);
        $result2 = $query2->row_array();

        echo json_encode($result2);

    }

    public function get_hourly_done_rate_for_date(){

        $date = $this->input->post('date');
        $emp_id = $this->input->post('emp_id');

        if(
            $date == '' || $emp_id == ''
        ){
            echo json_encode(
                array(
                    'Success' => False,
                    'Message' => 'emp_id, date Required'
                )
            );
            die();
        }

        $sql = "SELECT * FROM hourly_done_rate 
            WHERE date = '$date' 
              AND emp_id = '$emp_id'
            AND is_deleted = 0
            ORDER BY id DESC 
        ";

        $query2 = $this->db->query($sql);
        $result2 = $query2->result_array();

        echo json_encode($result2);

    } 

}