<?php

class Contact_support extends CI_Model
{

    function _construct()
    {
        parent::_construct();
    }

    function registRequest($reauest)
    {
        $user = unserialize(get_cookie('MakanBaMa'))['USERID'];
        $this->db->set('create_date', 'NOW()', FALSE);
        $this->db->insert('support_request', array('request' => $reauest, 'user_id' => $user));
        return $this->db->insert_id();
    }

}
