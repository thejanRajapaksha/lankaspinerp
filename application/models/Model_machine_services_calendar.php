<?php

class Model_machine_services_calendar extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    //getServiceEvents
    public function getServiceEvents()
    {
        $this->db->select('*');
        $this->db->from('machine_services');
        //$this->db->where('machine_services.service_date >=', date('Y-m-d'));
        $this->db->where('machine_services.is_deleted =', 0);
        $this->db->order_by('machine_services.service_date_from', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }

    //getServiceRes
    public function getServiceRes($service_id)
    {
        $this->db->select('machine_services.*, machine_ins.s_no, machine_types.name as machine_type_name ');
        $this->db->from('machine_services');
        $this->db->join('machine_ins', 'machine_ins.id = machine_services.machine_in_id', 'left');
        $this->db->join('machine_types', 'machine_types.id = machine_ins.machine_type_id', 'left');
        $this->db->where('machine_services.id =', $service_id);
        $this->db->where('machine_services.is_deleted =', 0);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function create($data = array())
    {
        if($data) {
            $create = $this->db->insert('machine_service_details', $data);
            return ($create == true) ? true : false;
        }
    }

    public function createServiceDetailItems($data = array())
    {
        if($data) {
            $create = $this->db->insert('machine_service_details_items', $data);
            return ($create == true) ? true : false;
        }
    }

    public function update($id = null, $data = array())
    {
        if($id && $data) {
            $this->db->where('id', $id);
            $update = $this->db->update('machine_services', $data);
            return ($update == true) ? true : false;
        }
    }

    public function remove($id = null)
    {
        if($id) {
            $this->db->where('id', $id);
            $delete = $this->db->delete('machine_services');
            return ($delete == true) ? true : false;
        }

        return false;
    }

    public function getActiveMachineService()
    {
        $sql = "SELECT * FROM machine_services WHERE active = ?";
        $query = $this->db->query($sql, array(1));
        return $query->result_array();
    }

    public function countTotalMachineServices()
    {
        $sql = "SELECT * FROM machine_services WHERE active = ?";
        $query = $this->db->query($sql, array(1));
        return $query->num_rows();
    }
}