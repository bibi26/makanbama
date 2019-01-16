<?php

class List_visu extends CI_Model
{

    function _construct()
    {
        parent::_construct();
    }

   function getCountVisu($visu_type)
    {
        $user = unserialize($_COOKIE['MakanBaMa'])['USERID'];
        $this->db->select('building_info.id');
        $this->db->where('user_id', $user);
        $this->db->where('building_info.type', $visu_type);
        $this->db->from('building_info');
        return $this->db->count_all_results();
    }

    function getVisu($visu_type,$start, $length,$sort='id',$dir='desc')
    {
        $user = unserialize($_COOKIE['MakanBaMa'])['USERID'];
        $this->db->select('building_info.* ');
        $this->db->where('user_id', $user);
        $this->db->where('building_info.type', $visu_type);
        $this->db->from('building_info');
        $this->db->order_by($sort,$dir);
        $this->db->limit($length, $start);
        return $this->db->get()->result_array();
    }

    function ostensible($visu_type,$building_id, $is_show)
    {
        $res = $this->db->where('id', $building_id)->update('building_info', array('show' => $is_show));
        return $res;
    }

}
