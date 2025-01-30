<?php

class Model_machine_dashboard extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    //getMachineInsMachineTypesCount
    public function getMachineInsMachineTypesCount()
    {
        $this->db->select('machine_types.name as machine_type_name, COUNT(machine_ins.id) AS total_count');
        $this->db->from('machine_ins');
        $this->db->join('machine_types', 'machine_types.id = machine_ins.machine_type_id');
        $this->db->where('machine_ins.is_deleted', 0);
        $this->db->group_by('machine_types.id');
        $query = $this->db->get();
        return $query->result_array();
    }

}