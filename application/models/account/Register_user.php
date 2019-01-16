<?php

class Register_user extends CI_Model
{

    function _construct()
    {
        parent::_construct();
    }

    function signUP($type,$email, $pas1, $verify_code)
    {
        $data = array(
            'type' => $type,
            'email' => $email,
            'pas' => $pas1,
            'verify_code' => $verify_code,
        );
        $this->db->set('create_date', 'NOW()', FALSE);
        $result = $this->db->insert('users', $data);
        return $result;
    }

    function chkUniqEmail($email)
    {
        $this->db->where(array('email' => $email))->from('users');
        $count = $this->db->count_all_results();
        return $count;
    }

}
