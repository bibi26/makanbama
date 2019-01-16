<?php

class Profile extends CI_Model
{

    function _construct()
    {
        parent::_construct();
    }

    function registInfo($input)
    {
        $user = unserialize(get_cookie('MakanBaMa'))['USERID'];

        $data = array(
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'mobile' => $input['mobile'],
            'address' => $input['address'],
        );
        return $this->db->update('users', $data, array('id' => $user));
    }

    function getProfileInfo()
    {
        $user = unserialize(get_cookie('MakanBaMa'))['USERID'];
        $this->db->select('*');
        $this->db->where('id', $user);
        $this->db->from('users');
        return $this->db->get()->result_array();
    }
}
