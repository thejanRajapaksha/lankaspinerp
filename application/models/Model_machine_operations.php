<?php

class Model_machine_operations extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getMachineOperationsData($id = null)
    {
        if($id) {
            $sql = "SELECT machine_operations.*,  
                    mt.name as machine_type_name,
                    COUNT(machine_operations.id) as operation_count
                    FROM machine_operations 
                    LEFT JOIN machine_types mt on machine_operations.machine_type_id = mt.id
                    WHERE machine_operations.id = ? 
                    ";
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }

            $sql = "SELECT machine_operations.*,  
                mt.name as machine_type_name,
                COUNT(machine_operations.id) as operation_count
                FROM machine_operations 
                LEFT JOIN machine_types mt on machine_operations.machine_type_id = mt.id    
                WHERE is_deleted = 0
                GROUP BY machine_operations.machine_type_id
                ORDER BY machine_operations.machine_type_id DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function create($data = array())
    {
        if($data) {
            $create = $this->db->insert('machine_operations', $data);
            return ($create == true) ? true : false;
        }
    }

    public function update($id = null, $data = array())
    {
        if($id && $data) {
            $this->db->where('id', $id);
            $update = $this->db->update('machine_operations', $data);
            return ($update == true) ? true : false;
        }
    }

    public function remove($id = null)
    {
        if($id) {
            $this->db->where('id', $id);
            $delete = $this->db->delete('machine_operations');
            return ($delete == true) ? true : false;
        }

        return false;
    }

    public function getActiveMachineOperation()
    {
        $sql = "SELECT * FROM machine_operations WHERE active = ?";
        $query = $this->db->query($sql, array(1));
        return $query->result_array();
    }

    public function countTotalMachineOperations()
    {
        $sql = "SELECT * FROM machine_operations WHERE active = ?";
        $query = $this->db->query($sql, array(1));
        return $query->num_rows();
    }

    public function checkMachineOperation($operation_id = null ,$machine_type_id = null)
    {
        if($operation_id && $machine_type_id) {
            $sql = "SELECT machine_operations.*, op.name as operation_name
            FROM machine_operations
            LEFT JOIN operations_for_machines op on machine_operations.operation_id = op.id 
            WHERE operation_id = ? AND machine_type_id = ? AND is_deleted = 0 
            ";
            $query = $this->db->query($sql, array($operation_id, $machine_type_id));
            return $query->result_array();
        }
    }

    public function getMachineOperationsDataByMachineInId($machine_type_id = null)
    {
        if($machine_type_id) {
            $sql = "SELECT machine_operations.*, op.name as operation_name, ot.name as operation_type_name, ot.class_type as operation_type_class_type
            FROM machine_operations
            LEFT JOIN operations_for_machines op on machine_operations.operation_id = op.id 
            LEFT JOIN operation_types ot on op.operation_type_id = ot.id
            WHERE machine_type_id = ?
            AND is_deleted = 0
            ";
            $query = $this->db->query($sql, array($machine_type_id));
            $data = $query->result_array();
            foreach ($data as $key => $value) {
                $data[$key]['operation_type_name'] = '<span class="badge badge-'.$value['operation_type_class_type'].'"> '.$value['operation_type_name'].' </span>';
                $data[$key]['operation_name'] = $value['operation_name'];
            }

            $mt_sql = "SELECT name FROM machine_types WHERE id = ?";
            $mt_query = $this->db->query($mt_sql, array($machine_type_id));
            $mt_data = $mt_query->row_array();
            $data['machine_type_name'] = $mt_data['name'];

            return $data;
        }
    }

    public function getMachineOperationsDataByMachineTypeId($machine_type_id = null)
    {
        if($machine_type_id) {
            $sql = "SELECT machine_operations.*, op.name as operation_name
            FROM machine_operations
            LEFT JOIN operations_for_machines op on machine_operations.operation_id = op.id 
            WHERE machine_type_id = ?       
            AND is_deleted = 0

            ";
            $query = $this->db->query($sql, array($machine_type_id));
            return $query->result_array();
        }
    }

    public function getMachineOperationsDataByMachineTypeIdFull($machine_type_id = null)
    {
        if($machine_type_id) {
            $sql = "SELECT machine_operations.*, 
            op.name as operation_name,
            ot.name as operation_type_name,
            ot.class_type as operation_type_class_type,
            mt.name as machine_type_name
            FROM machine_operations
            LEFT JOIN machine_types mt on machine_operations.machine_type_id = mt.id
            LEFT JOIN operations_for_machines op on machine_operations.operation_id = op.id  
            LEFT JOIN operation_types ot on op.operation_type_id = ot.id
            WHERE machine_operations.machine_type_id = ?
            ";
            $query = $this->db->query($sql, array($machine_type_id));
            $data = $query->result_array();
            foreach ($data as $key => $value) {
                //id
                $data[$key]['id'] =  $value['id'];
                $data[$key]['operation_type_name'] = '<span class="badge badge-'.$value['operation_type_class_type'].'"> '.$value['operation_type_name'].' </span>';
                $data[$key]['operation_name'] = $value['operation_name'];
            }

            return $data;


        }
    }



}