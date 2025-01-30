<?php

class Buyers extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Buyers';
        $this->load->model('model_employees');
        $this->load->model('model_factories');

    }

    public function get_buyers_select()
    {
        $term = $this->input->get('term');
        $page = $this->input->get('page');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $this->db->select('*');
        $this->db->from('buyers');
        $this->db->where('active', 1 );
        $this->db->like('name', $term, 'both');
        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $buyers = $query->result_array();

        $this->db->from('buyers');
        $this->db->where('active', 1 );
        $this->db->like('name', $term, 'both');
        $count = $this->db->count_all_results();

        $data = array();
        foreach ($buyers as $v) {
            $data[] = array(
                'id' => $v['id'],
                'text' => $v['name']
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