<?php

class List_rent extends CI_Model
{

    function _construct()
    {
        parent::_construct();
    }

    function getCountRents()
    {
        $user = unserialize($_COOKIE['MakanBaMa'])['USERID'];
        $this->db->select('id ');
        $this->db->where('user_id', $user);
        $this->db->from('rents');
        return $this->db->count_all_results();
    }

    function getRents($start, $length,$sort='id',$dir='desc')
    {
        $user = unserialize($_COOKIE['MakanBaMa'])['USERID'];
        $this->db->select('rents.*,building_info.folder as folder,DATEDIFF(rents.to_date_g,rents.from_date_g) AS RentDays',false);
        $this->db->where('rents.user_id', $user);
        $this->db->join('building_info', 'building_info.id=rents.building_id', 'left');
        $this->db->from('rents');
        $this->db->order_by($sort,$dir);
        $this->db->limit($length, $start);
        return $this->db->get()->result_array();
    }
}
