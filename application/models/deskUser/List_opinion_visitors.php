<?php

class List_opinion_visitors extends CI_Model
{

    function _construct()
    {
        parent::_construct();
    }
    function getOpinions($start, $length,$sort='id',$dir='desc')
    {
        $user = unserialize($_COOKIE['MakanBaMa'])['USERID'];
        $this->db->select('visitor_opinion.*,building_info.id AS ID,building_info.folder');
        $this->db->join('building_info', 'building_info.id=visitor_opinion.main_id', 'left');
        $this->db->where('visitor_opinion.user_id', $user);
        $this->db->from('visitor_opinion');
        $this->db->order_by($sort,$dir);
       $this->db->limit($length, $start);
        return $this->db->get()->result_array();
    }
    function getCountOpinions()
    {
        $user = unserialize($_COOKIE['MakanBaMa'])['USERID'];
        $this->db->select('visitor_opinion.id');
        $this->db->where('visitor_opinion.user_id', $user);
        $this->db->from('visitor_opinion');
        return $this->db->count_all_results();
    }
}
