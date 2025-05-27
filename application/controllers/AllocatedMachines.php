<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class AllocatedMachines extends Admin_Controller {
    public function index(){
        $this->load->model('Machineallocationinfo');
        $this->load->model('AllocatedMachinesinfo');

        $result['machine']=$this->Machineallocationinfo->Getmachinelist();
        $result['reason']=$this->AllocatedMachinesinfo->getRejectReason();
        $this->data['result'] = $result;
		$this->data['js'] = 'application/views/CRMOrder/AllocatedMachines/index-js.php';
		$this->render_template('CRMOrder/AllocatedMachines/index.php', $this->data);
	}
    public function fetch()
{
    $machineId = $this->input->post('machine_id');
    $date = $this->input->post('date');

    $this->load->model('AllocatedMachinesinfo');
    $data = $this->AllocatedMachinesinfo->getAllocationByMachineAndDate($machineId, $date);

    echo json_encode($data);
}
public function getAllocationDataById(){
    $id = $this->input->post('id');

    $this->load->model('AllocatedMachinesinfo');
	$result= $this->AllocatedMachinesinfo->getAllocationDataById($id); 

    echo json_encode($result);

}

public function InsertCompletedAmmount()
{
    $user = $_SESSION['id'];
    $this->load->model('AllocatedMachinesinfo'); 

        $user = $_SESSION['id'];
        $allocationId = $this->input->post('allocation_id');
        $wasteQty = 0;
        $completeQty = $this->input->post('amount');

    if (!$allocationId) {
        echo json_encode(['success' => false, 'message' => 'Required fields are missing']);
        return;
    }

    $data = [
        'tbl_machine_allocation_idtbl_machine_allocation' => $allocationId,
        'wastageqty'=> $wasteQty,
        'completedqty' => $completeQty,
        'insertuser'=> $user,
        'status'=> '1',
    ];

    $exists = $this->AllocatedMachinesinfo->checkAllocationExists($allocationId);

    if ($exists) {

        $updateData = [
            'completedqty' => $completeQty
        ];
        $this->AllocatedMachinesinfo->updateAllocationDetailsData($allocationId, $updateData);
    } else {
        $this->AllocatedMachinesinfo->insertQty($data);
    }

    echo json_encode(['success' => true]);
}

public function InsertRejectedAmmount()
{
    $user = $_SESSION['id'];
    $this->load->model('AllocatedMachinesinfo'); 

    $allocationId = $this->input->post('allocationId');
    $amount = $this->input->post('amount');
    $reason = $this->input->post('reason');
    $comment = $this->input->post('comment');

    if (!$allocationId) {
        echo json_encode(['success' => false, 'message' => 'Required fields are missing']);
        return;
    }

    $data = [
        'tbl_machine_allocation_idtbl_machine_allocation' => $allocationId,
        'wastageqty' => $amount,
        'tbl_reject_item_reason_id_rejected_item_reason' => $reason,
        'comment' => $comment,
        'completedqty' => 0,
        'insertuser' => $user,
        'status' => 1
    ];

    $exists = $this->AllocatedMachinesinfo->checkAllocationExists($allocationId);

    if ($exists) {

        $updateData = [
            'wastageqty' => $amount,
            'tbl_reject_item_reason_id_rejected_item_reason' => $reason,
            'comment' => $comment,
        ];
        $this->AllocatedMachinesinfo->updateAllocationDetailsData($allocationId, $updateData);
    } else {
        $this->AllocatedMachinesinfo->insertQty($data);
    }

    echo json_encode(['success' => true]);
}


}