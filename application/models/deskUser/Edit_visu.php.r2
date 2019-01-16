<?php

class Edit_visu extends CI_Model
{

    function _construct()
    {
        parent::_construct();
    }

    function edit($buillding_id)
    {
        $user = unserialize(get_cookie('MakanBaMa'))['USERID'];
        $this->db->select('building_info.*,building_detail.*,building_info.user_id AS HOST,province.name AS _province,city.name AS _city');
        $this->db->join('building_detail', 'building_detail.building_id=building_info.id', 'left');
        $this->db->join('province', 'province.id=building_info.province_id', 'left');
        $this->db->join('city', 'city.id=building_info.city_id', 'left');
        $this->db->where(array('building_info.id' => $buillding_id, 'building_info.user_id' => $user));
        $this->db->from('building_info');
        return $this->db->get()->result_array();
    }

    function getProvince()
    {
        $this->db->select('id,name');
        $this->db->from('province');
        $this->db->order_by('name');
        return $this->db->get()->result_array();
    }

    function getCity($province)
    {
        $this->db->select('id,name');
        $this->db->from('city');
        $this->db->where('ostan_id', $province);
                $this->db->like('id', '0000', 'before');

        $this->db->order_by('name');
        return $this->db->get()->result_array();
    }

    function editMain($input)
    {
        $building_id = $this->session->userdata('BUILDING');
        $this->db->where('id', $building_id);
        return $this->db->update('building_info', $input);
    }

    function editDetail($input)
    {
        $building_id = $this->session->userdata('BUILDING');
        $this->db->where('building_id', $building_id);
        return $this->db->update('building_detail', $input);
    }

}
