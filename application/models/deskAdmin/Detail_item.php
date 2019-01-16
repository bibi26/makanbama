<?php

class Detail_item extends CI_Model
{

    function _construct()
    {
        parent::_construct();
    }

    function detail($buillding_id)
    {
        $this->db->select("building_detail.*,building_info.*,building_info.create_date as create_at,building_info.id as ID,cc.name AS city,building_info.user_id AS HOST,aa.name AS _province,cc.name AS _city , CONCAT (first_name,' ',last_name) AS FULL_NAME,mobile,email,bb.name as user_province,dd.name as user_city,users.address,building_info.show as item_show,building_info.status as item_status", FALSE);
        $this->db->join('users', 'users.id=building_info.user_id', 'left');
        $this->db->join('province as aa', 'aa.id=building_info.province_id', 'left');
        $this->db->join('province as bb', 'bb.id=users.province_id', 'left');
        $this->db->join('building_detail', 'building_detail.building_id=building_info.id', 'left');
        $this->db->join('city as cc', 'cc.id=building_info.city_id', 'left');
        $this->db->join('city as dd', 'dd.id=building_info.city_id', 'left');
        $this->db->where(array('building_info.id' => $buillding_id));
        $this->db->from('building_info');
        return $this->db->get()->result_array();
    }

    function getOpinionItem($building_id)
    {
        $this->db->select("visitor_opinion.opinion,visitor_opinion.create_date as opinion_date,visitor_opinion.user_id as user_id_passenger,visitor_opinion_response.user_id as user_id_hosteler, CONCAT (a.first_name,' ',a.last_name) AS full_name_passenger, CONCAT (b.first_name,' ',b.last_name) AS full_name_hosteler,visitor_opinion_response.response, visitor_opinion_response.create_date as response_date", FALSE);
        $this->db->join('users a', 'a.id=visitor_opinion.user_id', 'left');
        $this->db->join('visitor_opinion_response', 'visitor_opinion_response.visitor_opinion_id=visitor_opinion.id', 'left');
        $this->db->join('users b', 'b.id=visitor_opinion_response.user_id', 'left');
        $this->db->where(array('main_id' => $building_id, 'visitor_opinion.type' => 'villa', 'visitor_opinion.show' => 1, 'visitor_opinion_response.show' => 1));
        $this->db->from('visitor_opinion');
        return $this->db->get()->result_array();
    }

}
