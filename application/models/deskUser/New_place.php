<?php

class New_place extends CI_Model
{

    function _construct()
    {
        parent::_construct();
    }

    function registMain($input)
    {
        $user = unserialize(get_cookie('MakanBaMa'))['USERID'];
        $folder = $this->session->userdata('rnd_place');
        $this->db->set('create_date', 'NOW()', FALSE);
        $input['user_id'] = $user;
        $input['folder'] = $folder;
        $this->db->insert('places', $input);
        return $this->db->insert_id();
    }
}
