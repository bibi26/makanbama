<?php

class List_item extends CI_Model
{

    function _construct()
    {
        parent::_construct();
    }

   function getCountItems()
    {
        $this->db->select('building_info.id');
        $this->db->from('building_info');
        return $this->db->count_all_results();
    }

    function getItems($start, $length)
    {
        $user = unserialize($_COOKIE['MakanBaMa'])['USERID'];
        $this->db->select('building_info.* ');
        $this->db->from('building_info');
        $this->db->order_by('id', 'desc');
        $this->db->limit($length, $start);
        return $this->db->get()->result_array();
    }
}
