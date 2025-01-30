<?php

class Suppliers extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->not_logged_in();
        $this->data['page_title'] = 'Suppliers';
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



}