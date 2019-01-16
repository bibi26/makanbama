<?php

class Edit_place extends CI_Model
{

    function _construct()
    {
        parent::_construct();
    }
    
    function getInfoPlace($place_id)
    {
        $user = unserialize(get_cookie('MakanBaMa'))['USERID'];
        $this->db->select('places.*,province.name AS _province,city.name AS _city');
        $this->db->join('province', 'province.id=places.province_id', 'left');
        $this->db->join('city', 'city.id=places.city_id', 'left');
        $this->db->where(array('places.id' => $place_id, 'places.user_id' => $user));
        $this->db->from('places');
        return $this->db->get()->result_array();
    }
         function edit($input)
    {
        $this->db->where('id',$this->session->userdata('rec_place_id'));
        return $this->db->update('places', $input);
    }
}
