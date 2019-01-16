<?php

class New_visu extends CI_Model
{

    function _construct()
    {
        parent::_construct();
    }

    function registMain($type_visu,$input)
    {
        $user       = unserialize(get_cookie('MakanBaMa'))['USERID'];
        $this->db->set('create_date', 'NOW()', FALSE);
        $input['user_id'] = $user;
        $input['folder'] = $this->session->userdata('VISUFOLDERNEW');
        $input['type'] = $type_visu;
        $this->db->insert('building_info', $input);
        return $this->db->insert_id();
    }

    function registDetail($building_id, $input)
    {
        $input['building_id'] = $building_id;
        $res                  = $this->db->insert('building_detail', $input);
        return $res;
    }

}
