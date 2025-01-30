<?php

class ServiceItems extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->not_logged_in();

        $this->data['page_title'] = 'Service Items';

    }

    public function get_items_select()
    {
        $term = $this->input->get('term');
        $page = $this->input->get('page');

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $this->db->select('*');
        $this->db->from('service_items');
        $this->db->where('is_deleted', 0 );
        $this->db->like('name', $term, 'both');
        $query = $this->db->get();
        $this->db->limit($resultCount, $offset);
        $departments = $query->result_array();

        $this->db->from('service_items');
        $this->db->where('is_deleted', 0);
        $this->db->like('name', $term, 'both');
        $count = $this->db->count_all_results();

        $data = array();
        foreach ($departments as $v) {
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


    public function get_service_item_price()
    {
        $id = $this->input->post('service_item_id');
        $this->db->select('*');
        $this->db->from('service_items');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $result = $query->row_array();
        $price = $result['price'];
        echo json_encode($price);
    }

}