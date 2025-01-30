<?php

class Model_machine_operation_product extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getMachineOperationProductData($id = null)
    {
        if($id) {
            $sql = "SELECT mop.*, 
                 p.name as product_name,
                pc.name as category_name,
                pp.name as process_name,
                sc.name as component_name,  
                u2.name_with_initial as assigned_by_name,
            GROUP_CONCAT(COALESCE(mod1.operation_name,'') SEPARATOR ', ') as operation_name,
            GROUP_CONCAT(COALESCE(sc.name,'') SEPARATOR ', ') as component_name,
            SUM(mod1.smv) as total_smv
            FROM machine_operation_product mop 
            LEFT JOIN machine_operation_product_components mopc ON mopc.mop_id = mop.id 
            LEFT JOIN style_component sc ON sc.id = mopc.component_id 
            LEFT JOIN machine_operation_desc mod1 ON mod1.id = mopc.component_id   
            LEFT JOIN products p ON mop.product_id = p.id 
            LEFT JOIN product_categories pc ON pc.id = mop.category_id
            LEFT JOIN product_process pp ON pp.id = mop.process_id 
                
            LEFT JOIN employees u2 ON u2.id = mop.assigned_by_id  
            WHERE mop.id = ?
            GROUP BY mop.id
            ";
             
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }

        $sql = "SELECT mop.*, 
                 p.name as product_name,
                pc.name as category_name,
                pp.name as process_name,   
                u2.name_with_initial as assigned_by_name,
            GROUP_CONCAT(COALESCE(mod1.operation_name,'') SEPARATOR ', ') as operation_name,
            GROUP_CONCAT(COALESCE(sc.name,'') SEPARATOR ', ') as component_name,
            SUM(mod1.smv) as total_smv
            FROM machine_operation_product mop 
             LEFT JOIN machine_operation_product_components mopc ON mopc.mop_id = mop.id 
            LEFT JOIN style_component sc ON sc.id = mopc.component_id 
            LEFT JOIN style_component_operations sco ON sco.component_id = sc.id
            LEFT JOIN machine_operation_desc mod1 ON mod1.id = sco.operation_id
            LEFT JOIN products p ON mop.product_id = p.id 
            LEFT JOIN product_categories pc ON pc.id = mop.category_id
            LEFT JOIN product_process pp ON pp.id = mop.process_id 
                
            LEFT JOIN employees u2 ON u2.id = mop.assigned_by_id  
            WHERE mop.is_deleted = 0
            AND mod1.is_deleted = 0
            GROUP BY mop.id 
            ORDER BY mop.id DESC
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getMachineOperationProductDataApprove()
    {
        $sql = "SELECT mop.*, 
                 p.name as product_name,
                pc.name as category_name,
                pp.name as process_name,   
                u2.name_with_initial as assigned_by_name,
            GROUP_CONCAT(COALESCE(mod1.operation_name,'') SEPARATOR ', ') as operation_name,
            GROUP_CONCAT(COALESCE(sc.name,'') SEPARATOR ', ') as component_name,
            SUM(mod1.smv) as total_smv
            FROM machine_operation_product mop 
             LEFT JOIN machine_operation_product_components mopc ON mopc.mop_id = mop.id 
            LEFT JOIN style_component sc ON sc.id = mopc.component_id 
            LEFT JOIN style_component_operations sco ON sco.component_id = sc.id
            LEFT JOIN machine_operation_desc mod1 ON mod1.id = sco.operation_id
            LEFT JOIN products p ON mop.product_id = p.id 
            LEFT JOIN product_categories pc ON pc.id = mop.category_id
            LEFT JOIN product_process pp ON pp.id = mop.process_id 
                
            LEFT JOIN employees u2 ON u2.id = mop.assigned_by_id  
            WHERE mop.is_deleted = 0
            AND mop.is_approved = 0
            AND mod1.is_deleted = 0
            GROUP BY mop.id 
            ORDER BY mop.id DESC
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function create($data = array())
    {
        if($data) {
            $create = $this->db->insert('machine_operation_product', $data);
            return ($create == true) ? true : false;
        }
    }

    public function create_mop_operations($data = array())
    {
        if($data) {
            $create = $this->db->insert('machine_operation_product_components', $data);
            return ($create == true) ? true : false;
        }
    }

    public function update($id = null, $data = array())
    {
        if($id && $data) {
            $this->db->where('id', $id);
            $update = $this->db->update('machine_operation_product', $data);
            return ($update == true) ? true : false;
        }
    }

    //checkIfApproved
    public function checkIfApproved($id)
    {
        $sql = "SELECT * FROM machine_operation_product WHERE id = ? AND is_approved = 1";
        $query = $this->db->query($sql, array($id));
        return $query->row_array();
    }

    public function remove($id = null)
    {
        if($id) {
            $this->db->where('id', $id);
            $delete = $this->db->delete('machine_operation_product');
            return ($delete == true) ? true : false;
        }

        return false;
    }

    //getMachineOperationProductDataByProductId
    public function getMachineOperationProductDataByProductId($id = null)
    {
        $sql = "SELECT mop.*, 
                 p.name as product_name,
                pc.name as category_name,
                pp.name as process_name, 
                u2.name_with_initial as assigned_by_name, 
                GROUP_CONCAT(DISTINCT(sc.name) SEPARATOR ', ') as component_name,
                GROUP_CONCAT(DISTINCT(mod1.operation_name) SEPARATOR ', ') as operation_name,
                SUM(mod1.smv) as smv
            FROM machine_operation_product mop 
            LEFT JOIN machine_operation_product_components mopc ON mopc.mop_id = mop.id 
            LEFT JOIN style_component sc ON sc.id = mopc.component_id 
            LEFT JOIN style_component_operations sco ON sco.component_id = sc.id
            LEFT JOIN machine_operation_desc mod1 ON mod1.id = sco.operation_id  
            LEFT JOIN products p ON mop.product_id = p.id 
            LEFT JOIN product_categories pc ON pc.id = mop.category_id
            LEFT JOIN product_process pp ON pp.id = mop.process_id
            
            LEFT JOIN employees u2 ON u2.id = mop.assigned_by_id  
            WHERE mop.is_deleted = 0
            AND p.id = '$id'
            GROUP BY mop.id
            ORDER BY mop.id DESC
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getMachineOperationProductDataByProductIdRow($id = null)
    {
        if ($id) {
            $sql = "SELECT mod1.*,  
                sco.component_id,
                sc.name as component_name
            FROM machine_operation_product mop 
            LEFT JOIN machine_operation_product_components mopc ON mopc.mop_id = mop.id 
            LEFT JOIN style_component sc ON sc.id = mopc.component_id 
            LEFT JOIN style_component_operations sco ON sco.component_id = sc.id
            LEFT JOIN machine_operation_desc mod1 ON mod1.id = sco.operation_id  
            LEFT JOIN products p ON mop.product_id = p.id 
            LEFT JOIN product_categories pc ON pc.id = mop.category_id
            LEFT JOIN product_process pp ON pp.id = mop.process_id
            WHERE p.id = ?
            ORDER BY mopc.sequence
            ";

            $query = $this->db->query($sql, array($id));
            return $query->result_array();
        }

    }

}