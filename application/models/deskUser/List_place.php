<?php

class List_place extends CI_Model
{

    function _construct()
    {
        parent::_construct();
    }

    function getCountPlaces()
    {
        $user = unserialize(get_cookie('MakanBaMa'))['USERID'];
        $this->db->select('places.id');
        $this->db->where('user_id', $user);
        $this->db->from('places');

        return $this->db->count_all_results();
    }
    function getPlaces($start,$length,$sort='id',$dir='desc')
    {
        $user = unserialize(get_cookie('MakanBaMa'))['USERID'];
        $this->db->select('*');
        $this->db->where('user_id', $user);
        $this->db->from('places');
        $this->db->order_by($sort,$dir);
                $this->db->limit($length, $start);

        return $this->db->get()->result_array();
    }
    
     function ostensible($building_id, $is_show)
    {
        $res  = $this->db->where('id',$building_id)->update('places', array('show'=>$is_show));
        return $res;
    }

}
